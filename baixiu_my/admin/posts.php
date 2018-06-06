<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Posts &laquo; Admin</title>
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
    <div class="container-fluid">
      <div class="page-title">
        <h1>所有文章</h1>
        <a href="post-add.php" class="btn btn-primary btn-xs">写文章</a>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <a class="btn btn-danger btn-sm" href="javascript:;" style="display: none">批量删除</a>
        <form class="form-inline">
          <select name="" class="form-control input-sm">
            <option value="">所有分类</option>
          </select>
          <select name="" class="form-control input-sm">
            <option value="">所有状态</option>
            <option value="drafted">草稿</option>
            <option value="published">已发布</option>
            <option value="trashed">废弃</option>

          </select>
          <button class="btn btn-default btn-sm">筛选</button>
        </form>
        <ul class="pagination pagination-sm pull-right">
          <li><a href="#">上一页</a></li>
          <li><a href="#">1</a></li>
          <li><a href="#">2</a></li>
          <li><a href="#">3</a></li>
          <li><a href="#">下一页</a></li>
        </ul>
      </div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input type="checkbox"></th>
            <th>标题</th>
            <th>作者</th>
            <th>分类</th>
            <th class="text-center">发表时间</th>
            <th class="text-center">状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="text-center"><input type="checkbox"></td>
            <td>随便一个名称</td>
            <td>小小</td>
            <td>潮科技</td>
            <td class="text-center">2016/10/07</td>
            <td class="text-center">已发布</td>
            <td class="text-center">
              <a href="javascript:;" class="btn btn-default btn-xs">编辑</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>


  <?php include_once './nav/left-nav.php'; ?>


  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>NProgress.done()</script>
  <!-- 引入模板引擎 -->
  <script src="../assets/vendors/art-template/template-web.js"></script>
  <!-- 定义分类信息模板 -->
  <script type="text/html" id="opt">
    {{each}}
      <option value="{{$value.id}}">{{$value.name}}</option>
    {{/each}}
  </script>
  <!-- 定义分类文章模板 -->
  <script type="text/html" id="post">
    {{each items}}  
    <tr 
        dataid='{{$value.id}}'
        {{if $value.status=='published'}}
          class="success"
        {{else if $value.status=='drafted'}}
          草稿
        {{else}}
          class="info"
        {{/if}}
    >
      <td class="text-center"><input type="checkbox"></td>
      <td>{{$value.title}}</td>
      <td>{{$value.nickname}}</td>
      <td>{{$value.name}}</td>
      <td class="text-center">{{$value.created}}</td>
      <td class="text-center">
        {{if $value.status == "drafted"}}
          草稿
        {{else if $value.status == "published"}}
          已发布
        {{else}}
          废弃
        {{/if}}
      </td>
      <td class="text-center">
        <a href="./post-add.php?id={{$value.id}}&num={{myPageNum}}" class="btn btn-default btn-xs">编辑</a>
        <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
      </td>
    </tr>
    {{/each}}
  </script>
</body>
</html>

  <script>
    $(function(){
      // 定义变量
      var myPageNum = 1;
      var myPageSize = 6;
      var totalPage;
    

      // 判断是否有页码 有 重新赋值 没有 
      var num = window.location.search.split('=')[1];
      // console.log(num);
      if(num){
        myPageNum =parseInt(num);
      }


      // 获取分类信息
      $.ajax({
        url:'http://www.baixiu_my.com/admin/api/01.getAllCategories.php',
        // type:'',
        // data:'',
        success:function(backData){
          // console.log(backData);
          $result = template('opt',backData);
          $('.form-inline select:first').append($result);

        }
      })

      // 封装 获取分类的文章
      function getData(){
        $.ajax({
          url: 'http://www.baixiu_my.com/admin/api/12.getPosts.php',
          // type: '',
          data: {
            pageNum: myPageNum,
            pageSize: myPageSize,
            status: $('.form-inline select:last').val(),
            category_id: $('.form-inline select:first').val()
          },
          success: function(backData){
            // 加上一个当前的页数
            backData.myPageNum = myPageNum;
            console.log(backData);
            // 保存总页数
            totalPage = backData.totalPage;
            $result = template('post',backData);
            $('tbody').html($result);

            //  如果筛选后的 总页数少于当前的总页数 就让当前的总页数等于 筛选后的总页数 并重新获取一次数据
            if(myPageNum > totalPage){
              myPageNum = 1;
              getData();
            }
           pagination(totalPage,myPageNum);
            
          }
        })
      }
      // 封装 函数
      function pagination(totalPage,myPageNum){
        
            // 如果筛选出来的分类总页数不足5页 就改变循环的条件
            if(totalPage < 5){
              var totalIndex = 1;
              var endIndex = totalPage;
            }else{
              // 控制页面上显示的页数
              var totalIndex = myPageNum - 2;
              var endIndex = myPageNum + 2;
              // 判断是不是第一页
              if(totalIndex < 1){
                totalIndex = 1;
                endIndex = totalIndex + 4;             
              }
              // 判断是不是最后一页
              if(endIndex > totalPage){
                endIndex = totalPage;
                totalIndex = endIndex - 4;
              }
            }
            // 生成页数
            $('.pagination').children('li:not(:first,:last)').remove();
            // 循环生成页码
            for($i = totalIndex; $i <= endIndex;$i++){
              var $li = $('<li><a href="#">'+$i+'</a></li>');
              // 高亮当前的li
              if($i == myPageNum){
                $li.addClass('active');
              }
              $li.insertBefore('.pagination li:last');
            }
      }
      getData();

      // 筛选分类的文章
      $('.form-inline select').change(function(){
        getData();
      })

      // 给上一页 下一页设置  点击事件
      $('.pagination li:first').click(function(){
        // 判断是否为第一页
        if(myPageNum == 1){
          return;
        }
        // 递减
        myPageNum--;
        getData();
      })
      $('.pagination li:last').click(function(){
        // 判断是否为最后一页
        if(myPageNum == totalPage){
          return;
        }
        // 递减
        myPageNum++;
        getData();
      })
      // 给动态生成的每个li标签设置点击事件
      $('.pagination').on('click','li:not(:first,:last)',function(){
        // 因为的出来的是一个字符串 会发生字符串拼接 所以使用数据类型转换 变成 数据类型
        myPageNum = parseInt($(this).children().html());
        // console.log(myPageNum);
        getData();
      })

      // 给删除按钮设置点击事件
      $("tbody").on('click','a.btn-danger',function(){
        $ids = $(this).parent().parent().attr('dataid');
        $.ajax({
          url: 'http://www.baixiu_my.com/admin/api/13.trashPosts.php',
          type: 'post',
          data: {
            ids: $ids
          },
          success: function(backData){
            // console.log(backData);
            getData();
          }
         })
      })
      // 点击顶部 全选
      $('thead input[type=checkbox]').click(function () {
        // 获取自己的选中状态 设置给tbody中的 checkbox
        $('tbody input[type=checkbox]').prop('checked', $(this).prop('checked'));

        // 显示隐藏
        if ($(this).prop('checked') == true) {
          $('.page-action .btn-danger').slideDown();
        } else {
          $('.page-action .btn-danger').slideUp();
        }
      })
      // tbody中的checkbox
      $('tbody').on('click', 'input[type=checkbox]', function () {
      // 总个数
      var totalNum = $('tbody input[type=checkbox]').length;
      // 选中个数
      var checkNum = $('tbody input[type=checkbox]:checked').length;
      // 对比
      $('thead input[type=checkbox]').prop('checked', totalNum == checkNum);

      if (checkNum != 0) {
        $('.page-action .btn-danger').show(500);
      } else {
        $('.page-action .btn-danger').hide(500);
      }
    })
    })
  </script>
