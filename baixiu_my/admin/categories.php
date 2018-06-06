<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Categories &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <script src="../assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <?php include_once './nav/top-nav.php'; ?>
    </nav>
    <div class="container-fluid">
      <div class="page-title">
        <h1>分类目录</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="row">
        <div class="col-md-4">
          <form>
            <h2>添加新分类目录</h2>
            <div class="form-group">
              <label for="name">名称</label>
              <input id="name" class="form-control" name="name" type="text" placeholder="分类名称">
            </div>
            <div class="form-group">
              <label for="slug">别名</label>
              <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
              <p class="help-block">https://zce.me/category/<strong>slug</strong></p>
            </div>
            <div class="form-group">
              <button class="btn btn-primary" type="submit">添加</button>
              <button class="btn btn-success" style='display:none;'>取消</button>
            </div>
          </form>
        </div>
        <div class="col-md-8">
          <div class="page-action" style="height: 30px;">
            <!-- show when multiple checked -->
            <a class="btn btn-danger btn-sm" href="javascript:;" style="display: none;">批量删除</a>
          </div>
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th class="text-center" width="40"><input type="checkbox"></th>
                <th>名称</th>
                <th>Slug</th>
                <th class="text-center" width="100">操作</th>
              </tr>
            </thead>
            <tbody>
              
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <?php include_once './nav/left-nav.php'; ?>

  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>NProgress.done()</script>
  <!-- 引入模板引擎 -->
  <script src="../assets/vendors/art-template/template-web.js"></script>
  <!-- 设置模板块 -->
  <script type="text/html" id="cateTem">
    {{each}}
      <tr>
        <td class="text-center">
          <input type="checkbox">
        </td>
        <td>{{$value.name}}</td>
        <td>{{$value.slug}}</td>
        <td class="text-center">
          <a href="javascript:;" class="btn btn-info btn-xs">编辑</a>
          <a href="javascript:;" deleteId="{{$value.id}}" class="btn btn-danger btn-xs">删除</a>
        </td>
      </tr>
    {{/each}}
  </script>

  <script>
    $(function(){
      // 封装查询的ajax 方便多次调用
      function getData(){
        $.ajax({
          url: 'http://www.baixiu_my.com/admin/api/01.getAllCategories.php',
          type: 'get',
          // data: 无
          success: function(backData){
            // console.log(backData);
            $result = template('cateTem',backData);
            // console.log($result);
            $('tbody').html($result);
          }
        })
      } 
      // 1. 查到所有的数据 并渲染到页面上
      // 调用查询的ajax的 封装函数
      getData();

      // 2. 增加数据 并渲染到页面上
      $('button.btn-primary').click(function(event){
        // 阻止默认跳转
        event.preventDefault();
        // 保存this
        $this = $(this);
        if($this.html() == '添加'){
          $.ajax({
            url: 'http://www.baixiu_my.com/admin/api/02.insertCategory.php',
            type: 'post',
            data: {
              slug: $('#slug').val(),
              name: $('#name').val()
            },
            success: function(backData){
              // window.location.reload();
              // 调用查询的ajax的 封装函数
              getData();
            }
          })
        }else{
          $.ajax({
            url: 'http://www.baixiu_my.com/admin/api/04.updateCategory.php',
            type: 'get',
            data: {
              slug: $('#slug').val(),
              name: $('#name').val(),
              id: $this.attr('editId')
            },
            success: function(backData){
              // window.location.reload();
              // 调用查询的ajax的 封装函数
              getData();
              $('form button.btn-success').click();
            }
          })
        }
      })
      
      // 3. 删除数据 并渲染到页面上
      $('tbody').on('click','.btn-danger',function(){
        // console.log($(this).prevAll('.id').val());
        $deleteId = $(this).attr('deleteId');
        $.ajax({
          url: 'http://www.baixiu_my.com/admin/api/03.deleteCategory.php',
          data: {
            id: $deleteId
          },
          success: function(backData){
            getData();
          }
        })
      })
      // 4.1 点击编辑按钮将对应的内容放到 左边文本框
      $('tbody').on('click','.btn-info',function(){
        // 获取数据
        $name = $(this).parent().siblings().eq(1).html();
        $slug = $(this).parent().siblings().eq(2).html();
        $id = $(this).next().attr('deleteId');
        // 赋值给左边文本框
        $('form h2').html('编辑分类');
        $('#name').val($name);
        $('#slug').val($slug);
        $('form button.btn-primary').html("保存");
        $('form button.btn-primary').attr('editId',$id);
        $('form button.btn-success').show();
      })
      // 4.2 点击取消按钮将左边文本框内容还原
      $('form button.btn-success').click(function(){
        // 还原左边文本框内容
        $('form h2').html('添加新分类目录');
        $('#name').val('');
        $('#slug').val('');
        $('form button.btn-primary').html("添加");
        $('form button.btn-primary').attr('editId','');
        $('form button.btn-success').hide();
      }) 

      // 5.1 全选 全不选
      $('thead input[type=checkbox]').click(function(){
        //  console.log(11);
        $('tbody input[type=checkbox]').prop('checked',$(this).prop('checked'));
        // 判断显示或隐藏批量删除按钮
        if($(this).prop('checked') == true){
          $('.page-action a').fadeIn();
        }else{
          $('.page-action a').fadeOut();
        }
      })
      // 5.2 判断是否全选 
      $('tbody').on('click','input[type=checkbox]',function(){
        $checkedNum = $('tbody input[type=checkbox]:checked').length;
        $totalNum = $('tbody input[type=checkbox]').length;
        $('thead input[type=checkbox]').prop('checked',$checkedNum == $totalNum);
        if($checkedNum != 0){
          $('.page-action a').fadeIn();
        }else{
          $('.page-action a').fadeOut();
        }
      });
      // 6 批量删除  并渲染到页面上
      $('.page-action a').click(function(){
        // 获取数据 (选中的id)
        // 声明一个变量来保存id
        $ids = '';
        // 先找到被选中的input
        $checkeds = $('tbody input[type=checkbox]:checked');
        // 循环遍历出每个对应id值 
        $checkeds.each(function(i,e){
          $id = $(e).parent().siblings().last().children().eq(1).attr('deleteId');
          // console.log($id);
          // 拼接给$ids
          $ids += $id + ',';
        });
        // console.log($ids);
        // 字符串拼接 取从下标为0开始到倒数第一个  不包含倒数第一个
        $ids = $ids.slice(0,-1);
        // console.log($ids);
        $.ajax({
          url:'http://www.baixiu_my.com/admin/api/05.deleteCategories.php',
          // type:'get',
          data:{
            ids: $ids
          },
          success: function(backData){
            // console.log(backData);
            getData();
            $('.page-action a').fadeOut();
          }
        });
      });
    })
  </script>
</body>
</html>
