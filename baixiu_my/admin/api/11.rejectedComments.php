<?php
    // 引入外部函数
    include_once '../../tool/tools.php';
    // 接收数据
    $ids = $_REQUEST['ids'];
    // 执行sql语句
    $rowNum = my_ZSG("update comments set status = 'rejected' where id in($ids)");
    // 返回结果
    if($rowNUm != -1){
        echo "操作成功!";
    }else{
        echo "失败@!!";
    }

?>