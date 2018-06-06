<pre>
<?php 
  header('content-type:text/html;charset=utf-8');
  // 引入外部文件
  include_once './tool/tools.php';
  // 执行sql语句 查      (  order by rand() 随机生成顺序   limit 5 一页显示 5张 )
  $sql = "select * from posts where status ='published' order by rand() limit 5";
  $data = my_SELECT($sql);
  $data2 = my_SELECT($sql);
  // 渲染页面

  // 接收数据
  $id = $_REQUEST['id'];

  // 分类信息 查
  $categories = my_SELECT("select * from categories");
  // 最新发布数据
  $data5 = my_SELECT("
    select 
    posts.id,
    categories.name,
    posts.title,
    users.nickname,
    posts.created,
    posts.content,
    posts.views,
    posts.likes,
    posts.feature
    from posts 
    inner join users on posts.user_id = users.id
    inner join categories on posts.category_id = categories.id
    where posts.id = $id;
  ");
  // var_dump($data5);

?>
</pre>


<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>阿里百秀-发现生活，发现美!</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.css">
</head>
<body>
  <div class="wrapper">
    <div class="topnav">
      <ul>
        <?php for($i = 0; $i < count($categories);$i++):?>
          <li><a href="list.php?id=<?php echo $categories[$i]['id'];?>"><i class="fa fa-glass"></i><?php echo $categories[$i]['name'];?></a></li>
        <?php endfor;?>
      </ul>
    </div>
    <div class="header">
      <h1 class="logo"><a href="index.php"><img src="assets/img/logo.png" alt=""></a></h1>
      <ul class="nav">
        <?php for($i = 0; $i < count($categories);$i++):?>
          <li><a href="list.php?id=<?php echo $categories[$i]['id'];?>"><i class="fa fa-glass"></i><?php echo $categories[$i]['name'];?></a></li>
        <?php endfor;?>
      </ul>
      <div class="search">
        <form>
          <input type="text" class="keys" placeholder="输入关键字">
          <input type="submit" class="btn" value="搜索">
        </form>
      </div>
      <div class="slink">
        <a href="javascript:;">链接01</a> | <a href="javascript:;">链接02</a>
      </div>
    </div>
    <div class="aside">
      <div class="widgets">
        <h4>搜索</h4>
        <div class="body search">
          <form>
            <input type="text" class="keys" placeholder="输入关键字">
            <input type="submit" class="btn" value="搜索">
          </form>
        </div>
      </div>
      <div class="widgets">
        <h4>随机推荐</h4>
        <ul class="body random">
          <?php for($i = 0; $i < count($data);$i++):?>
            <li>
              <a href="javascript:;">
                <p class="title"><?php echo $data[$i]['title'];?></p>
                <p class="reading">阅读(<?php echo $data[$i]['views'];?>)</p>
                <div class="pic">
                  <img src="<?php echo $data[$i]['feature'];?>" alt="">
                </div>
              </a>
            </li>
          <?php endfor;?>
        </ul>
      </div>
      <div class="widgets">
        <h4>最新评论</h4>
        <ul class="body discuz">
          <li>
            <a href="javascript:;">
              <div class="avatar">
                <img src="uploads/avatar_1.jpg" alt="">
              </div>
              <div class="txt">
                <p>
                  <span>鲜活</span>9个月前(08-14)说:
                </p>
                <p>挺会玩的</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:;">
              <div class="avatar">
                <img src="uploads/avatar_1.jpg" alt="">
              </div>
              <div class="txt">
                <p>
                  <span>鲜活</span>9个月前(08-14)说:
                </p>
                <p>挺会玩的</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:;">
              <div class="avatar">
                <img src="uploads/avatar_2.jpg" alt="">
              </div>
              <div class="txt">
                <p>
                  <span>鲜活</span>9个月前(08-14)说:
                </p>
                <p>挺会玩的</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:;">
              <div class="avatar">
                <img src="uploads/avatar_1.jpg" alt="">
              </div>
              <div class="txt">
                <p>
                  <span>鲜活</span>9个月前(08-14)说:
                </p>
                <p>挺会玩的</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:;">
              <div class="avatar">
                <img src="uploads/avatar_2.jpg" alt="">
              </div>
              <div class="txt">
                <p>
                  <span>鲜活</span>9个月前(08-14)说:
                </p>
                <p>挺会玩的</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:;">
              <div class="avatar">
                <img src="uploads/avatar_1.jpg" alt="">
              </div>
              <div class="txt">
                <p>
                  <span>鲜活</span>9个月前(08-14)说:
                </p>
                <p>挺会玩的</p>
              </div>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div class="content">
      <div class="article">
        <div class="breadcrumb">
          <dl>
            <dt>当前位置：</dt>
            <dd><a href="javascript:;"><?php echo $data5[0]['name'];?></a></dd>
            <dd><?php echo $data5[0]['title'];?></dd>
          </dl>
        </div>
        <h2 class="title">
          <a href="javascript:;"><?php echo $data5[0]['title'];?></a>
        </h2>
        <div class="meta">
          <span><?php echo $data5[0]['nickname'];?> 发布于 <?php echo $data5[0]['created'];?></span>
          <span>分类: <a href="javascript:;"><?php echo $data5[0]['name'];?></a></span>
          <span>阅读: (<?php echo $data5[0]['views'];?>)</span>
          <span>评论: (<?php echo $data5[0]['likes'];?>)</span>
        </div>
        <img src="<?php echo $data5[0]['feature'];?>" alt="">
        <p><?php echo $data5[0]['content'];?></p>
      </div>
      <div class="panel hots">
        <h3>热门推荐</h3>
        <ul>
          <?php for($i=0;$i<count($data2)-1;$i++):?>
            <li>
              <a href="javascript:;">
                <img src="<?php echo $data2[$i]['feature'];?>" alt="">
                <span><?php echo $data2[$i]['title'];?></span>
              </a>
            </li>
          <?php endfor;?>
        </ul>
      </div>
    </div>
    <div class="footer">
      <p>© 2016 XIU主题演示 本站主题由 themebetter 提供</p>
    </div>
  </div>
</body>
</html>
