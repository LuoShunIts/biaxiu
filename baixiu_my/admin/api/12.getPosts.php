<?php
// 设置格式
header('content-type:application/json;charset=utf-8');
// 引入函数
include_once '../../tool/tools.php';

// 接收数据
$pageNum = $_REQUEST['pageNum'];
$pageSize = $_REQUEST['pageSize'];
// 筛选使用到的数据
// 如果为空
$status =  $_REQUEST['status'];
// and status ='$status' and category_id =$category_id
// 定义 字符串 来拼接 查询的 条件
$selectOption ='';
if($status!=''){
    $selectOption.=" and posts.status ='$status'";
}
$category_id = $_REQUEST['category_id'];
if($category_id!=''){
    $selectOption.=" and posts.category_id =$category_id ";
}

// 计算一些数值
// 起始索引
$startIndex = ($pageNum - 1) * $pageSize;
// 总页数 总条数 / 页容量
// where true的目的是为了让我们的查询条件好拼接
$sql_total = "
    select * from posts
    inner join categories
    on posts.category_id = categories.id
    where true $selectOption
";
// echo $sql_total;
$totalPage = ceil(count(my_SELECT($sql_total)) / $pageSize);

// 准备sql 分页查询
$sql = "
select
posts.id,
posts.title,
users.nickname,
categories.name,
posts.created,
posts.status
from
posts
inner join users
on posts.user_id = users.id
inner join categories
on posts.category_id = categories.id
where true $selectOption
limit $startIndex,$pageSize
    ";
// echo $sql;

// 调用函数查询数据
$data = my_SELECT($sql);

// 返回给浏览器(转化为json)
// 准备一个php的关系型数组
$backData = array(
    'items' => $data,
    'totalPage' => $totalPage,
);
// 转化为json string
echo json_encode($backData);
