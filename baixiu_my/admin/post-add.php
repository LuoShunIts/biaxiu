<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Add new post &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <script src="../assets/vendors/nprogress/nprogress.js"></script>
  <style>
    .btn-primary {
      margin-right: 10px;
    }
  </style>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <?php include_once './nav/top-nav.php' ;?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>写文章</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <form class="row">
        <div class="col-md-9">
          <div class="form-group">
            <label for="title">标题</label>
            <input id="title" class="form-control input-lg" name="title" type="text" placeholder="文章标题">
          </div>
          <div class="form-group">
            <label for="content">标题</label>
            <!-- <textarea id="content" class="form-control input-lg" name="content" cols="30" rows="10" placeholder="内容"></textarea> -->
            <div id="content"></div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="slug">别名</label>
            <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
            <p class="help-block">https://zce.me/post/<strong>slug</strong></p>
          </div>
          <div class="form-group">
            <label for="feature">特色图像</label>
            <!-- show when image chose -->
            <img class="help-block thumbnail" style="display: none">
            <input id="feature" class="form-control" name="feature" type="file">
          </div>
          <div class="form-group">
            <label for="category">所属分类</label>
            <select id="category" class="form-control" name="category">
             
            </select>
          </div>
          <div class="form-group">
            <label for="created">发布时间</label>
            <input id="created" class="form-control" name="created" type="datetime-local">
          </div>
          <div class="form-group">
            <label for="status">状态</label>
            <select id="status" class="form-control" name="status">
              <option value="drafted">草稿</option>
              <option value="published">已发布</option>
            </select>
          </div>
          <div class="form-group">
            <button class="btn btn-primary" type="submit">保存</button>
          </div>
        </div>
      </form>
    </div>
  </div>


  <?php include_once './nav/left-nav.php';?>


  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <!-- 文本编辑框插件 -->
  <script src="./wangEditor-3.1.1/release/wangEditor.min.js"></script>
  <script src="./m/m.js"></script>
  <script>NProgress.done()</script>
  <script>
      $(function(){
        // 1. 选择文件后 事件改变事件 显示图片
        $('#feature').change(function(){
          var formData = new FormData();
          // console.log(formData);
          formData.append('preview',this.files[0]);

          $.ajax({
            url: 'http://www.baixiu_my.com/admin/api/06.imgPreview.php',
            type: 'post',
            data:formData,
            processData:false,  // 不自动格式化数据
            contentType:false,  //  不自动设置请求头
            success: function(backData){
              // console.log(backData);
              $('img.thumbnail').attr('src',backData).fadeIn();
            }
          })
        })

        // 2. 查找分类类型  渲染页面
        $.ajax({
          url: 'http://www.baixiu_my.com/admin/api/01.getAllCategories.php',
          // type:'',
          // date: '',
          success: function(backData){
            // console.log(backData.length);
            for($i=0;$i<backData.length;$i++){
              $opt = $('<option value="'+backData[$i].id+'">'+backData[$i].name+'</option>');
              $opt.appendTo('#category');
            }
          }
        })

        

        // 4.文本编辑器
        var E = window.wangEditor
        var editor = new E('#content')
        // 或者 var editor = new E( document.getElementById('editor') )
        editor.create()

        $time = moment().format('YYYY-MM-DDTHH:mm');
        $('#created').val($time)

      // 5.进入编辑状态
      // 获取传过来的id
      var result1 = window.location.search.split('&');// ?id=18 ,num=4
      console.log(result1);
      var searchId = result1[0].split('=')[1];
      // 获取 原始页码
      var num = result1[1].split('=')[1];
      // console.log(id);
      // 判断是否有id
      if(searchId){
        $.ajax({
          url:'http://www.baixiu_my.com/admin/api/14.getPostByid.php',
          type:'get',
          data:{
            id: searchId
          },
          success:function(backData){
            console.log(backData);
            $('#title').val(backData[0].title);
            $('#slug').val(backData[0].slug);
            $('#category').val(backData[0].category_id);
            $('#status').val(backData[0].status);
            // 时间
            editor.txt.html(backData[0].content);
            // 图像
            $('.help-block').show().attr("src",backData[0].feature);

          }
        })
        $('.page-title h1').html('编辑文章');                                                                               
        $('form .btn-primary').html('修改');
        $('<a class="btn btn-success" href="./posts.php?num='+num+'">取消</a>').insertAfter('.btn-primary')
        
      }

      // 3. 新增文章  
      $('form button.btn-primary').click(function(event){
            event.preventDefault();

            $sendData = new FormData(document.querySelector('form'));
            // 获取文本编辑器的内容
            $sendData.append('content',editor.txt.html())

            // 根据内容更换url
            var url = '';
            if($(this).html() == "修改"){
              url = "http://www.baixiu_my.com/admin/api/15.updatePost.php";
              $sendData.append('id',searchId);
            }else{
              url = 'http://www.baixiu_my.com/admin/api/07.insertPost.php';
            }
            $.ajax({
              url: url,
              type: 'post',
              data: $sendData,
              processData: false, // 不格式化数据
              contentType: false, // 不设置请求头
              success: function(backData){
                // console.log(backData);
                alert(backData);
                $('.alert-danger').find('span').end().html(backData).fadeIn().delay(2000).fadeOut();
              }
            })
        })
    })
  </script>
</body>
</html>
