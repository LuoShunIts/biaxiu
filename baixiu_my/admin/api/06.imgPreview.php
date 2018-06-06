<?php
    // 引入外部函数
    include_once '../../tool/tools.php';
    // 接收文件
    $fileName = my_move_upload_file('preview','../../uploads/');
    // 返回数据
    echo '/uploads/'.$fileName;

?>