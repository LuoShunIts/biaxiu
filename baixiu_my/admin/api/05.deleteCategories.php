<?php
    // 引入外部函数
    include_once '../../tool/tools.php';
    // 接收数据
    $ids = $_REQUEST['ids'];
    // 准备sql
    $sql = "delete from categories where id in($ids)";
    // echo $sql;
    // 执行sql
    $rowNum = my_ZSG($sql);
    // 判断是否成功
    if($rowNum!=-1){
        echo '嘤嘤嘤,你删掉了好多呀!!!!';
    }else{
        echo '哈哈,没有删除成功哦';
    }
    // 返回结果


?>