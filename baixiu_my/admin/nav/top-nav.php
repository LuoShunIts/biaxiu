<?php
  // 判断是否有session值  是否登录
  // 开启session
  session_start();
  if(isset($_SESSION['userInfo'])){
    // 如果有进来
  }else{
    // 如果没有就跳到登录界面
    header('location:02.login.php');
  }
?>
  <nav class="navbar">
        <button class="btn btn-default navbar-btn fa fa-bars"></button>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="profile.php"><i class="fa fa-user"></i>个人中心</a></li>
          <li><a href="02.1logout.php"><i class="fa fa-sign-out"></i>退出</a></li>
        </ul>
      </nav>