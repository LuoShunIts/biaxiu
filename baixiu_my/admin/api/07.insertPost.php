<?php
    // 引入外部函数
    include_once '../../tool/tools.php';
    // 接收数据
    $slug = $_REQUEST['slug'];
    $title = $_REQUEST['title'];
    $created = $_REQUEST['created'];
    $content = $_REQUEST['content'];
    $category = $_REQUEST['category'];
    $status = $_REQUEST['status'];
    // 文件
    $feature = '/uploads/'.my_move_upload_file('feature','../../uploads/');
    // 当前登录的id
    session_start();
    $id = $_SESSION['userInfo']['id'];
    // 执行sql语句
    $rowNum = my_ZSG("insert into posts(slug,title,created,content,category_id,status,feature,user_id) values('$slug','$title','$created','$content','$category','$status','$feature','$id')");
    // 提示结果
    if($rowNum == 1){
        echo "增加成功";
    }else{
        echo "失败了哦";
    }
?>