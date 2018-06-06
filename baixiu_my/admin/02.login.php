<?php  
    header('content-type:text/html;charset=utf-8');
    // 引入外部文件
    include_once '../tool/tools.php';

    // 声明一个变量记录是否有值传过来
    $flag = false;
    // 判断是否有数据传过来
    if(isset($_REQUEST['email'])){
      // 如果有数据传过来就代表不是第一次进来 对传过来的的数据进行判断是否存在
      // 接收数据
      $email = $_REQUEST['email'];
      $password = $_REQUEST['password'];

      // 执行sql语句  查
      $data = my_SELECT("select * from users where email = '$email' and password = '$password'");
      // var_dump($data);
      // 判断是否存在
      if(count($data)==1){
        // 如果进来 表示存在  
        // 设置session值
        session_start();
        $_SESSION['userInfo'] = $data[0];
        // 跳转到首页
        header('location:index.php');
      }else{
        // 如果没有不存在  就改变$flag 的值  提示用户登录信息错误
        $flag = true;
      }

    }
?>


<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Sign in &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
  <div class="login">
    <form class="login-wrap" action="02.login.php" method="post">
      <img class="avatar" src="../assets/img/default.png">
      <!-- 有错误信息时展示 -->
      <?php if($flag == true):?>
        <div class="alert alert-danger">
          <strong>错误！</strong> 用户名或密码错误！
        </div>
      <?php endif;?>
      <div class="form-group">
        <label for="email" class="sr-only">邮箱</label>
        <input id="email" type="email" name="email" class="form-control" placeholder="邮箱" autofocus>
      </div>
      <div class="form-group">
        <label for="password" class="sr-only">密码</label>
        <input id="password" name="password" type="password" class="form-control" placeholder="密码">
      </div>
      <button type="submit" class="btn btn-primary btn-block">登 录</button>
    </form>
  </div>
</body>
</html>