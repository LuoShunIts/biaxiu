<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Slides &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <script src="../assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <?php include_once './nav/top-nav.php' ;?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>图片轮播</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="row">
        <div class="col-md-4">
          <form>
            <h2>添加新轮播内容</h2>
            <div class="form-group">
              <label for="image">图片</label>
              <!-- show when image chose -->
              <img class="help-block thumbnail" style="display: none">
              <input id="image" class="form-control" name="image" type="file">
            </div>
            <div class="form-group">
              <label for="text">文本</label>
              <input id="text" class="form-control" name="text" type="text" placeholder="文本">
            </div>
            <div class="form-group">
              <label for="link">链接</label>
              <input id="link" class="form-control" name="link" type="text" placeholder="链接">
            </div>
            <div class="form-group">
              <button class="btn btn-primary" type="submit">添加</button>
            </div>
          </form>
        </div>
        <div class="col-md-8">
          <div class="page-action">
            <!-- show when multiple checked -->
            <a class="btn btn-danger btn-sm" href="javascript:;" style="display: none">批量删除</a>
          </div>
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th class="text-center" width="40"><input type="checkbox"></th>
                <th class="text-center">图片</th>
                <th>文本</th>
                <th>链接</th>
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

  <?php include_once './nav/left-nav.php';?>


  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>NProgress.done()</script>
  <!-- 引入模板引擎 -->
  <script src="../assets/vendors/art-template/template-web.js"></script>
  <!-- 定义模板块 -->
  <script type="text/html" id="slide">
    {{each}}
      <tr>
        <td class="text-center"><input type="checkbox" value="{{$index}}"></td>
        <td class="text-center"><img class="slide" src="{{$value.image}}"></td>
        <td>{{$value.text}}</td>
        <td>{{$value.link}}</td>
        <td class="text-center">
          <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
        </td>
      </tr>
    {{/each}}
  </script>
</body>
</html>

<script>
    $(function(){
      // 定义一个变量来保存轮播图的数据
      var slideData ; 
      // 封装一个渲染页面的函数
      function getData(){
        $.ajax({
          url: 'http://www.baixiu_my.com/admin/api/16.getSlides.php',
          // type: '',
          // data: '',
          success: function(backData){
            console.log(backData);
            // 记录轮播图的数据
            slideData = backData;
            $('tbody').html(template('slide',backData));
          }
        })
      }
      // 刚进来时调用一次
      getData();
      // 给动态添加的tr中的删除按钮设置事件
      $('tbody').on('click','a.btn-danger',function(){
        var index = $(this).parent().siblings().first().children().val();
        // console.log(index);
        // 删除一个数组中的从 第一个索引开始 到后面的第二个参数的个数
        slideData.splice(index,1);
        // 将一个js对象 转换成一个json数据
        var jsonArr = JSON.stringify(slideData);

        $.ajax({
          url: 'http://www.baixiu_my.com/admin/api/17.modifySlides.php',
          type: 'post',
          data: {
            slides: jsonArr
          },
          success: function(backData){
            console.log(backData);
            // 重新渲染页面
            getData();
          }
        })
      })

      // 上传图片时 显示图片
      $('#image').change(function(){
        var sendData = new FormData();
        sendData.append('preview',this.files[0]);
        $.ajax({
          url: 'http://www.baixiu_my.com/admin/api/06.imgPreview.php',
          type: 'post',
          data: sendData,
          processData: false, // ajax2.0 中  不格式化化数据
          contentType: false, //    不设置请求头
          success: function(backData){
            console.log(backData)
            $('.help-block').attr('src',backData).show();
          }
        })
      })
      // 点击添加  新增到数据库 显示在页面上
      $('form .btn-primary').click(function(event){
        event.preventDefault();
        /* 添加页面上的数据到数组中 */
        var ArrData = {
          image: $('.help-block').attr('src'),
          text: $('#text').val(),
          link: $('#link').val()
        };
        // 将新增的数据添加到之前的轮播图数组中
        slideData.push(ArrData);
        // 将一个js对象 转换成一个json数据
        var jsonArr = JSON.stringify(slideData);

        $.ajax({
          url: 'http://www.baixiu_my.com/admin/api/17.modifySlides.php',
          type: 'post',
          data: {
            slides: jsonArr
          },
          success: function(backData){
            console.log(backData);
            // 重新渲染页面
            getData();
          }
        })
      })
      
    })

</script>
