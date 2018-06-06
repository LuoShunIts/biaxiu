<?php
    // 引入函数
    include_once '../../tool/tools.php';
    // 接收数据
    $ids = $_REQUEST['ids'];

    // 准备sql
    $sql = "update posts set status ='trashed' where id in($ids)";
    // 执行sql
    // 获取函数
    $rowNum = my_ZSG($sql);
    // echo $rowNum;
    if($rowNum!=-1){
        echo '恭喜你,搞定了哟';
    }else{
        echo '哎呀,没有通过哦';
    }
    // 返回提示消息
?>