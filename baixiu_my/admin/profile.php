<?php
  if(isset($_REQUEST['slug'])){
    header('content-type:text/html;charset=utf-8');
    // 引入sql语句 工具
    include_once '../tool/tools.php';
    // 接收数据
    $email = $_REQUEST['email'];
    $slug = $_REQUEST['slug'];
    $nickname = $_REQUEST['nickname'];
    $bio = $_REQUEST['bio'];
    // var_dump($_REQUEST);
    // var_dump($_FILES);

    // 装换编码格式 保存数据
    $avatar = "/uploads/".my_move_upload_file("avatar","../uploads/");
    
    // 获取id值
    // 开启session
    session_start();
    $id = $_SESSION['userInfo']['id'];

    
    // 判断是否更改了图片
    if($avatar == "/uploads/"){
      // 如果进来了表示 未更改 将img的图片路径赋值给avatar
      $avatar = $_SESSION['userInfo']['avatar'];
    }
    // 执行sql语句
    my_ZSG("update users set email='$email',slug='$slug',nickname='$nickname',bio='$bio',avatar='$avatar' where id ='$id'");

    // 刷新页面数据   改变session的值
    $_SESSION['userInfo'] = my_SELECT("select * from users where id = '$id'")[0];


    // 重新跳转到当前页面
    header('location: profile.php');

  }else{

  }


?>


<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Dashboard &laquo; Admin</title>
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
        <h1>我的个人资料</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <form class="form-horizontal" action="./profile.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
          <label class="col-sm-3 control-label">头像</label>
          <div class="col-sm-6">
            <label class="form-image">
              <input id="avatar" name="avatar" type="file">
              <img src="<?php echo $_SESSION['userInfo']['avatar'];?>">
              <i class="mask fa fa-upload"></i>
            </label>
          </div>
        </div>
        <div class="form-group">
          <label for="email" class="col-sm-3 control-label">邮箱</label>
          <div class="col-sm-6">
            <input id="email" class="form-control" name="email" type="type" value="<?php echo $_SESSION['userInfo']['email'];?>" placeholder="邮箱" readonly>
            <p class="help-block">登录邮箱不允许修改</p>
          </div>
        </div>
        <div class="form-group">
          <label for="slug" class="col-sm-3 control-label">别名</label>
          <div class="col-sm-6">
            <input id="slug" class="form-control" name="slug" type="type" value="<?php echo $_SESSION['userInfo']['slug'];?>" placeholder="slug">
            <p class="help-block">https://<?php echo $_SESSION['userInfo']['slug'];?>.me/author/<strong><?php echo $_SESSION['userInfo']['slug'];?></strong></p>
          </div>
        </div>
        <div class="form-group">
          <label for="nickname" class="col-sm-3 control-label">昵称</label>
          <div class="col-sm-6">
            <input id="nickname" class="form-control" name="nickname" type="type" value="<?php echo $_SESSION['userInfo']['nickname'];?>" placeholder="昵称">
            <p class="help-block">限制在 2-16 个字符</p>
          </div>
        </div>
        <div class="form-group">
          <label for="bio" class="col-sm-3 control-label">简介</label>
          <div class="col-sm-6">
            <textarea id="bio" class="form-control" name="bio" placeholder="Bio" cols="30" rows="6"><?php echo $_SESSION['userInfo']['bio'];?></textarea>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-3 col-sm-6">
            <button type="submit" class="btn btn-primary">更新</button>
            <a class="btn btn-link" href="password-reset.php">修改密码</a>
          </div>
        </div>
      </form>
    </div>
  </div>


  <?php include_once './nav/left-nav.php';?>


  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>NProgress.done()</script>
</body>
</html>

<script>
  $(function(){
    $('.form-image').on('change','#avatar',function(){
      $url = URL.createObjectURL(this.files[0]);
      console.log($url);
      $(this).next().attr('src',$url);
    })
  })
</script>
