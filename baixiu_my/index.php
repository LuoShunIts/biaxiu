<!-- <pre> -->
<?php 
  header('content-type:text/html;charset=utf-8');
  // 引入外部文件
  include_once './tool/tools.php';
  // 执行sql语句 查      (  order by rand() 随机生成顺序   limit 5 一页显示 5张 )
  $sql = "select * from posts where status ='published' order by rand() limit 5";

  $data = my_SELECT($sql);
  $data2 = my_SELECT($sql);
  $data3 = my_SELECT($sql);
  $data4 = my_SELECT($sql);
  // 渲染页面

  $slideData = my_SELECT("select * from options where `key` = 'home_slides'")[0]['value'];
  // var_dump($slideData);
  // 将数据转换成一个关系数组
  // $phpData = JSON_decode($slideData);
  // 默认转换出来的是一个对象 对象取值方法
  // var_dump($phpData[0]->image);
  // 第二个参数传true的话 转换出来的就是 关系型数组
  $phpData = JSON_decode($slideData,true);
  // var_dump($phpData);

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
    order by rand() limit 5
  ");
  // var_dump($data4);

?>
<!-- </pre> -->
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>阿里百秀-发现生活，发现美!</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.css">
  <style>
    .content .swipe-wrapper img {
      width: 819px;
      height: 460px;
    }

    /* fa fa-phone
fa fa-fire
fa fa-gift */
  </style>
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
          <?php for($i=0;$i<count($data4);$i++):?>
            <li>
                <a href="javascript:;">
                  <p class="title"><?php echo $data4[$i]['title'];?></p>
                  <p class="reading">阅读(<?php echo $data4[$i]['views'];?>)</p>
                  <div class="pic">
                    <img src="<?php echo $data4[$i]['feature']?>" alt="">
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
      <div class="swipe">
        <ul class="swipe-wrapper">
          <?php for($i = 0; $i < count($phpData);$i++):?>
            <li>
              <a href="<?php echo $phpData[$i]['link'];?>">
                <img src="<?php echo $phpData[$i]['image'];?>">
                <span><?php echo $phpData[$i]['text'];?></span>
              </a>
            </li>
          <?php endfor;?>
        </ul>
        <p class="cursor">
          <span class="active"></span>
          <?php for($i = 1;$i < count($phpData);$i++):?>
            <span></span>
          <?php endfor;?>

        </p>
        <a href="javascript:;" class="arrow prev"><i class="fa fa-chevron-left"></i></a>
        <a href="javascript:;" class="arrow next"><i class="fa fa-chevron-right"></i></a>
      </div>
      <div class="panel focus">
        <h3>焦点关注</h3>
        <ul>
          <li class="large">
            <a href="detail.php?id=<?php echo $data[0]['id'];?>">
              <img src="<?php echo $data[0]['feature'];?>" alt="">
              <span><?php echo $data[0]['title'];?></span>
            </a>
          </li>
          <?php for($i = 1; $i < count($data);$i++):?>
            <li>
              <a href="detail.php?id=<?php echo $data[$i]['id'];?>">
                <img src="<?php echo $data[$i]['feature'];?>" alt="">
                <span><?php echo $data[$i]['title'];?></span>
              </a>
            </li>
          <?php endfor;?>
        </ul>
      </div>
      <div class="panel top">
        <h3>一周热门排行</h3>
        <ol>
          <?php for($i = 0 ; $i < count($data2);$i++):?>
            <li>
              <i><?php echo $i+1;?></i>
              <a href="detail.php?id=<?php echo $data2[$i]['id'];?>"><?php echo $data2[$i]['title'];?></a>
              <a href="javascript:;" class="like">赞(<?php echo $data2[$i]['likes'];?>)</a>
              <span>阅读 (<?php echo $data2[$i]['views'];?>)</span>
            </li>
          <?php endfor;?>
        </ol>
      </div>
      <div class="panel hots">
        <h3>热门推荐</h3>
        <ul>
          <?php for($i = 0; $i < count($data3)-1; $i++):?>
            <li>
              <a href="javascript:;">
                <img src="<?php echo $data3[$i]['feature'];?>" alt="">
                <span><?php echo $data3[$i]['title'];?></span>
              </a>
            </li>
          <?php endfor;?>
        </ul>
      </div>
      <div class="panel new">
        <h3>最新发布</h3>
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
    </div>
    <div class="footer">
      <p>© 2016 XIU主题演示 本站主题由 themebetter 提供</p>
    </div>
  </div>
  <script src="assets/vendors/jquery/jquery.js"></script>
  <script src="assets/vendors/swipe/swipe.js"></script>
  <script>
    //
    var swiper = Swipe(document.querySelector('.swipe'), {
      auto: 3000,
      transitionEnd: function (index) {
        // index++;

        $('.cursor span').eq(index).addClass('active').siblings('.active').removeClass('active');
      }
    });

    // 上/下一张
    $('.swipe .arrow').on('click', function () {
      var _this = $(this);

      if(_this.is('.prev')) {
        swiper.prev();
      } else if(_this.is('.next')) {
        swiper.next();
      }
    })
  </script>
</body>
</html>
