<pre>
<?php 
  header('content-type:text/html;charset=utf-8');
  // 引入外部文件
  include_once './tool/tools.php';
  // 执行sql语句 查      (  order by rand() 随机生成顺序   limit 5 一页显示 5张 )
  $sql = "select * from posts where status ='published' order by rand() limit 5";

  $data = my_SELECT($sql);

  // 接收数据
  $id = $_REQUEST['id'];
  // echo $id;

  // 分类信息 查
  $categories = my_SELECT("select * from categories");
  // var_dump($categories);
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
    where categories.id = $id
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
        <li><a href="javascript:;"><i class="fa fa-glass"></i>奇趣事</a></li>
        <li><a href="javascript:;"><i class="fa fa-phone"></i>潮科技</a></li>
        <li><a href="javascript:;"><i class="fa fa-fire"></i>会生活</a></li>
        <li><a href="javascript:;"><i class="fa fa-gift"></i>美奇迹</a></li>
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
          <?php for($i=0;$i<count($data);$i++):?>
            <li>
                <a href="detail.php?id=<?php echo $data[$i]['id'];?>">
                  <p class="title"><?php echo $data[$i]['title'];?></p>
                  <p class="reading">阅读(<?php echo $data[$i]['views'];?>)</p>
                  <div class="pic">
                    <img src="<?php echo $data[$i]['feature']?>" alt="">
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
      <div class="panel new">
        <h3></h3>
          <?php for($i = 0; $i < count($data5);$i++):?>
            <div class="entry">
              <div class="head">
                <span class="sort"><?php echo $data5[$i]['name'];?></span>
                <a href="javascript:;"><?php echo $data5[$i]['title'];?></a>
              </div>
              <div class="main">
                <p class="info"><?php echo $data5[$i]['nickname'];?> 发表于 <?php echo $data5[$i]['created'];?></p>
                <p class="brief"><?php echo $data5[$i]['content'];?></p>
                <p class="extra">
                  <span class="reading">阅读(<?php echo $data5[$i]['views'];?>)</span>
                  <span class="comment">评论(<?php echo $data5[$i]['likes'];?>)</span>
                  <a href="javascript:;" class="like">
                    <i class="fa fa-thumbs-up"></i>
                    <span>赞(<?php echo $data5[$i]['likes'];?>)</span>
                  </a>
                  <a href="javascript:;" class="tags">
                    分类：<span><?php echo $data5[$i]['name'];?></span>
                  </a>
                </p>
                <a href="javascript:;" class="thumb">
                  <img src="<?php echo $data5[$i]['feature'];?>" alt="">
                </a>
              </div>
            </div>
          <?php endfor;?>
      </div>
    </div>
    <div class="footer">
      <p>© 2016 XIU主题演示 本站主题由 themebetter 提供</p>
    </div>
  </div>
</body>
</html>
