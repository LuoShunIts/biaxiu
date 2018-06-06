<?php
    // 引入函数
    include_once '../../tool/tools.php';
    // 接收数据
    $slug = $_REQUEST['slug'];
    $title = $_REQUEST['title'];
    $created = $_REQUEST['created'];
    $content = $_REQUEST['content'];
    $category = $_REQUEST['category'];
    $status = $_REQUEST['status'];
    // 图片
    $feature = '/uploads/'.my_move_upload_file('feature','../../uploads/');

    // 文章的id
    $postId = $_REQUEST['id'];

    // 准备sql
    $sql = "update posts set
        slug = '$slug',
        title = '$title',
        created = '$created',
        content = '$content',
        category_id = '$category',
        status = '$status',
        feature = '$feature'
        where id =$postId";
    // echo $sql;
    
    // 执行sql
    $rowNum = my_ZSG($sql);
    // echo $rowNum;
    // 判断结果
    if($rowNum==1){
        echo '恭喜你,写好了文章哦';
    }else{
        // 提示用户
        echo '嘤嘤嘤,没有写好 ';
    }
?>