<?php
    // 0.设置json
    header('content-type:application/json;charset=utf-8');
    // 1.接收数据
    include_once '../../tool/tools.php';
    // 2.连接数据库
    // 3.准备sql语句 查
    $id = $_REQUEST['id'];
    $sql = "select * from posts where id = $id";
    // 4.执行sql语句
    $backData = my_SELECT($sql);
    // 5.获取结果 解析结果
    echo json_encode($backData);
?>