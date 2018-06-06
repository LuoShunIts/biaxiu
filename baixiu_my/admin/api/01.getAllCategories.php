<?php 
    // 设置数据的格式
    header('content-type:application/json;charset=utf-8');
    // 引入函数
    include_once '../../tool/tools.php';
    // 准备sql语句
    $sql = "select * from categories"; 
    // 执行sql语句  结果返回php数组
    $data = my_SELECT($sql);
    // 转换php数组 为json格式
    $jsonString = json_encode($data);
    // 返回数据
    echo $jsonString;


?>