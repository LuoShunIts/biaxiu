<?php
    // 引入函数
    include_once '../../tool/tools.php';
    // 接收数据
    $slides = $_REQUEST['slides'];
    // 准备sql
    $sql = "update options set value = '$slides' where id = 10";
    // 执行sql
    $rowNum = my_ZSG($sql);
    // 提示用户
    if($rowNum!=-1){
        echo '搞定啦';
    }else{
        echo '翻车啦';
    }
?>