<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Password reset &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <script src="../assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <?php 
    // 引入外部文件
      include_once './nav/top-nav.php';
      include_once '../tool/tools.php';

    // 声明一个标记值
    $message = null;

    // 判断是否第一次第一次进来
    if(isset($_REQUEST['old'])){
      // 如果进来 说明不是第一次进来 
      // 接收数据
      $old = $_REQUEST['old'];
      $new = $_REQUEST['new'];
      $reNew = $_REQUEST['reNew'];

      // 判断旧密码是否正确
      if($old == $_SESSION['userInfo']['password']){
        // 如果进来 表示正确 
        // 找到id
        $id = $_SESSION['userInfo']['id'];
        // 判断新密码是否一致
        if($new == $reNew){
          // 如果进来了表示一致
          // 执行sql语句
          my_ZSG("update users set password = '$new' where id = '$id'");
          // 修改成功   跳转到登出界面重新登录
          header("location:02.1logout.php");
        }else{
          // 如果进来表示不一致
          $message = "两次新密码不一样,请再次输入!!";
        }

      }else{
        // 如果进来表示不正确 改变标记值
        $message = "密码错误!!";
      }

    }

    
    ?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>修改密码</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <?php if($message != null):?>
        <div class="alert alert-danger">
          <strong>错误！</strong><?php echo $message;?>
        </div>
      <?php endif;?>
      <form class="form-horizontal" action="./password-reset.php" method="post">
        <div class="form-group">
          <label for="old" class="col-sm-3 control-label">旧密码</label>
          <div class="col-sm-7">
            <input id="old" name="old" class="form-control" type="password" placeholder="旧密码">
          </div>
        </div>
        <div class="form-group">
          <label for="password" class="col-sm-3 control-label">新密码</label>
          <div class="col-sm-7">
            <input id="password" name="new" class="form-control" type="password" placeholder="新密码">
          </div>
        </div>
        <div class="form-group">
          <label for="confirm" class="col-sm-3 control-label">确认新密码</label>
          <div class="col-sm-7">
            <input id="confirm" name="reNew" class="form-control" type="password" placeholder="确认新密码">
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-3 col-sm-7">
            <button type="submit" class="btn btn-primary">修改密码</button>
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
