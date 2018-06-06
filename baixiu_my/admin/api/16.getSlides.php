<?php
    // 设置格式
    header('content-type:application/json;charset=utf-8');
    
    // 引入函数
    include_once '../../tool/tools.php';

    // 查询数据
    $data = my_SELECT("select * from options where id =10")[0]['value'];

    // 返回数据
    echo $data;

?>