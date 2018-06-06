<?php
    // 设置格式
    header('content-type:application/json;charset=utf-8');
    // 引入函数
    include_once '../../tool/tools.php';
    // 接收数据
    $pageNum = $_REQUEST['pageNum'];
    $pageSize = $_REQUEST['pageSize'];

    // 计算一些数值
    // 起始索引
    $startIndex = ($pageNum-1)*$pageSize;
    // 总页数 总条数 / 页容量
    $totalPage = ceil(count(my_SELECT("
        select * from comments
        inner join posts
        on comments.post_id = posts.id
        where comments.status in('held','approved','rejected')
    "))/$pageSize);

    // 准备sql 分页查询
    // limit x,x
    $sql ="
    select
    comments.id,
    comments.author,
    comments.content,
    posts.title,
    comments.created,
    comments.status
    from comments
    inner join posts
    on comments.post_id =posts.id
    where comments.status in('held','approved','rejected')
    limit $startIndex,$pageSize
    ";

    // 调用函数查询数据
    $data = my_SELECT($sql);

    // 返回给浏览器(转化为json)
    // 准备一个php的关系型数组
    $backData = array(
        'items'=>  $data,
        'totalPage'=>$totalPage
    );
    // 转化为json string
    echo json_encode($backData);

?>