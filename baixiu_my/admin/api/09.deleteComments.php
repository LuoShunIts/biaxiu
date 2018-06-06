<?php
    // 引入外部函数
    include_once '../../tool/tools.php';
    // 接收数据
    $ids = $_REQUEST['ids'];
    // 执行sql语句
    $rowNum = my_ZSG("delete from comments where id in($ids)");
    // 返回结果
    if($rowNum != -1){
        echo "删除成功";
    }else{
        echo "失败@!!";
    }

?>