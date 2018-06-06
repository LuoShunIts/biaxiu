<?php
// 声明变量 会被改变哦!!!
// 不会被改变的量 
// 不变量->常量
// $host = '127.0.0.1';
// $userName = 'root';
// $userPass = 'root';
// $dbName = 'test';

define('HOST','127.0.0.1');
define('USERNAME','root');
define('USERPASS','root');
define('DBNAME','baixiu');
// echo host;
// echo userName;
// echo userPass;
// echo dbName;


// 增删改
function my_ZSG($sql)
{
    // 连接数据库
    $link = mysqli_connect(HOST, USERNAME, USERPASS,DBNAME);
    // 执行传入的sql语句
    mysqli_query($link, $sql);
    // 获取行数
    $rowNum = mysqli_affected_rows($link);
    // 关闭连接
    mysqli_close($link);
    // 返回
    return $rowNum;
}

//    $rowNum = my_ZSG("update hero_recycle set isDelete='yes'");
//    echo $rowNum;

// 查询
function my_SELECT($sql)
{
    // 连接数据库
    $link = mysqli_connect(HOST, USERNAME, USERPASS,DBNAME);
    // 执行传入的sql语句
    $result = mysqli_query($link, $sql);
    // 解析结果
    // 0=>xxx,1=>xxx,2=>xx
    $data = mysqli_fetch_all($result,MYSQLI_ASSOC);
    // 关闭连接
    mysqli_close($link);
    // 返回
    return $data;
}
// var_dump(my_SELECT("select * from hero_recycle where isDelete ='yes'"));

// 保存文件的函数
/*
    $targetPath 应该是一个文件夹 /xxx/xx/x/xx.jpg
                                xx.jpg
*/
function my_move_upload_file($key,$targetPath)
{
    // 编码格式转换 保存文件的名字
    $fileName_GBK = iconv('utf-8', 'gbk', $_FILES[$key]['name']);
    // 移动文件
    move_uploaded_file($_FILES[$key]['tmp_name'], $targetPath. $fileName_GBK);

    // 获取文件的路径 utf-8;
    // $heroIcon = 'imgs/icon/' . $_FILES[$key]['name'];

    // 返回文件的原本的名字即可
    return $_FILES[$key]['name'];
}
