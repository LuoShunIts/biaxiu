<?php
// 引入外部工具
include_once '../tool/tools.php';
// -- 所有文章
$postsCount = my_SELECT("select * from posts");
// -- 草稿
$draftedCount = my_SELECT("select * from posts where status ='drafted'");
// -- 分类树
$categoriesCount = my_SELECT("select * from  categories");
// -- 评论
$commentsCount = my_SELECT("select * from comments");
// -- 待审核评论
$heldCount = my_SELECT("select * from comments where status ='held'");
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Dashboard &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <script src="../assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <?php include_once './nav/top-nav.php'; ?>
    <div class="container-fluid">
      <div class="jumbotron text-center">
        <h1>One Belt, One Road</h1>
        <p>Thoughts, stories and ideas.</p>
        <p><a class="btn btn-primary btn-lg" href="post-add.php" role="button">写文章</a></p>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">站点内容统计：</h3>
            </div>
            <ul class="list-group">
              <li class="list-group-item"><strong><?php echo count($postsCount);?></strong>篇文章（<strong><?php echo count($draftedCount);?></strong>篇草稿）</li>
              <li class="list-group-item"><strong><?php echo count($categoriesCount);?></strong>个分类</li>
              <li class="list-group-item"><strong><?php echo count($commentsCount);?></strong>条评论（<strong><?php echo count($heldCount);?></strong>条待审核）</li>
            </ul>
          </div>
        </div>
        <div class="col-md-4"></div>
        <div class="col-md-4"></div>
      </div>
    </div>
  </div> 
  <?php include_once './nav/left-nav.php';?>

  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>NProgress.done()</script>
</body>
</html>
