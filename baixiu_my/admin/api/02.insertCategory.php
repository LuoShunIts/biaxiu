<?php 
    // 引入函数
    include_once '../../tool/tools.php';
    // 接收数据
    $slug = $_REQUEST['slug'];
    $name = $_REQUEST['name'];
    // 准备sql语句
    $sql = "insert into categories(slug,name) values ('$slug','$name')";
    // 执行sql语句
    $rowNum = my_ZSG($sql);
    // 判断返回的信息
    if($rowNum == 1){
    // 如果进来表示增加成功 给出提示信息
        echo  "增加成功!";
    }else{
    // 如果进来表示增加失败  给出提示信息
        echo  "失败了!";
    }


?>