<?php
    // 开启session 
    session_start();
    // 删除session
    unset($_SESSION['userInfo']);

    // 跳转到登录页
    header('location:02.login.php');

    
?>