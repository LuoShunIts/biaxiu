<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Comments &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <script src="../assets/vendors/nprogress/nprogress.js"></script>
  <style>
    td {
      max-width: 500px;
    }
    tr td:last-child {
      width: 150px;
    }
    .last {
      margin-left: 10px;
    }
    .btn-success {
      height: 30px;
    }
  </style>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <?php include_once './nav/top-nav.php'; ?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>所有评论</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <div class="btn-batch" style="display: none">
          <button class="btn btn-info btn-sm">批量批准</button>
          <button class="btn btn-warning btn-sm">批量拒绝</button>
          <button class="btn btn-danger btn-sm">批量删除</button>
        </div>
        <span class="btn pull-right btn-success last">尾页</span>
        <ul class="pagination pagination-sm pull-right">
          <li><a href="#">上一页</a></li>
          <li><a href="#">1</a></li>
          <li><a href="#">2</a></li>
          <li><a href="#">3</a></li>
          <li><a href="#">下一页</a></li>
        </ul>
        <span class="btn pull-right btn-success first">首页</span>
      </div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input type="checkbox"></th>
            <th>作者</th>
            <th>评论</th>
            <th>评论在</th>
            <th>提交于</th>
            <th>状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody>
          
        </tbody>
      </table>
    </div>
  </div>

  <?php include_once './nav/left-nav.php'; ?>

  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>NProgress.done()</script>
  <!-- 引入模板引擎 -->
  <script src="../assets/vendors/art-template/template-web.js"></script>
  <!-- 定义模板 -->
  <script type="text/html" id="comments">
    {{each items}}
      <tr 
        {{if $value.status=='held'}}
          class="warning"
        {{ else if $value.status=='approved'}}
          
        {{else if $value.status=='rejected'}}
          class="danger"
        {{/if}}
        dateid = {{$value.id}}
      >
        <td class="text-center"><input type="checkbox"></td>
        <td>{{$value.author}}</td>
        <td>{{$value.content}}</td>
        <td>《{{$value.title}}》</td>
        <td>{{$value.created}}</td>
        <td>
          {{if $value.status=='held'}}
            待审核
          {{ else if $value.status=='approved'}}
            准许
          {{else if $value.status=='rejected'}}
            拒绝
          {{/if}}
        </td>
        <td class="text-center">
          {{if $value.status == 'held'}}
            <a href="javascript:;" class="btn btn-info btn-xs">批准</a>
            <a class="btn btn-warning btn-xs btn-edit" href="javascript:;">拒绝</a>
          {{/if}}
          <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
        </td>
      </tr>
    {{/each}}
  </script>
</body>
</html>
<script>
  $(function(){
    $pageNum = 1;
    $pageSize = 6;

    // 封装函数
    function getData(){
      $.ajax({
        url:'http://www.baixiu_my.com/admin/api/08.getComments.php',
        // type: '',
        data: {
          pageNum: $pageNum,
          pageSize: $pageSize
        },
        success: function(backData){
          console.log(backData);
          $result = template('comments',backData);
          $('tbody').html($result);
          // 保存总页数
          $totalPage = backData.totalPage;
          // console.log($totalPage);
          // 删除除了上一页 下一页 的其他li标签
          $('.pagination').children('li:not(:first,:last)').remove();
          // 让页面上一次只显示7页
          $startIndex = $pageNum - 3;
          $endIndex = $pageNum + 3;
          if($startIndex < 1){
            $startIndex = 1;
            $endIndex = $startIndex + 6;
          }
          if($endIndex > $totalPage){
            $endIndex = $totalPage;
            $startIndex = $endIndex - 6;
          }
          
          for($i = $startIndex; $i <= $endIndex; $i++){
            $lis = $('<li><a href="#">'+$i+'</a></li>');
            // 给当前的li 标签设置高亮
            if($i == $pageNum){
              $lis.addClass('active');
            }
            $lis.insertBefore('.pagination li:last');
          }
        }
      })
    }
    
    getData();
    // 给动态生成的每个li标签设置 点击事件
    $('.pagination').on('click','li:not(:first,:last)',function(){
      // alert('11')
      $pageNum = parseInt($(this).children().html());
      // console.log($pageNum);
      getData();
    })

    // 给上一页  下一页设置点击事件
    $('.pagination li:first').click(function(){
      // 判断是否是第一页
      if($pageNum == 1){
        return;
      }
      // 点击是 当前页数  递减
      $pageNum--;
      getData();
    })
    $('.pagination li:last').click(function(){
      // 判断是否是最后一页
      if($pageNum == $totalPage){
        return;
      }
      // 点击是 当前页数  递减
      $pageNum++;
      getData();
    })
    // 给首页 尾页设置事件
    $('.first').click(function(){
      $pageNum = 1;
      getData();
    })
    $('.last').click(function(){
      $pageNum = $totalPage;
      getData();
    })


    // 给删除按钮设置点击事件
    $("tbody").on('click','a.btn-danger',function(){
      $ids = $(this).parent().parent().attr('dateid');
      $.ajax({
        url: 'http://www.baixiu_my.com/admin/api/09.deleteComments.php',
        type: 'post',
        data: {
          ids: $ids
        },
        success: function(backData){
          console.log(backData);
          getData();
        }
      })
    })
    // 给批准按钮设置点击事件
    $('tbody').on('click','a.btn-info',function(){
      $ids = $(this).parent().parent().attr('dateid');
      $.ajax({
        url: 'http://www.baixiu_my.com/admin/api/10.passComments.php',
        // type: 'post',
        data: {
          ids: $ids
        },
        success: function(backData){
          console.log(backData);
          getData();
        }
      })
    })
    // 给拒绝按钮设置点击事件
    $('tbody').on('click','a.btn-warning',function(){
      $ids = $(this).parent().parent().attr('dateid');
      $.ajax({
        url: 'http://www.baixiu_my.com/admin/api/11.rejectedComments.php',
        type: 'post',
        data: {
          ids: $ids
        },
        success: function(backData){
          console.log(backData);
          getData();
        }
      })
    })

    // 设置全选 全不选
    $('thead input[type=checkbox]').click(function(){
      $('tbody input[type=checkbox]').prop('checked',$(this).prop('checked'));
      if($(this).prop('checked') == true){
        $('.btn-batch').show();
      }else{
        $('.btn-batch').hide();
      }
    })
    $('tbody').on('click','input[type=checkbox]',function(){
      $totalNum = $('tbody input[type=checkbox]').length;
      $checkedNum = $('tbody input[type=checkbox]:checked').length;
      $('thead input[type=checkbox]').prop('checked',$totalNum == $checkedNum);
      if($checkedNum != 0){
        $('.btn-batch').show();
      }else{
        $('.btn-batch').hide();
      }
    })

    // 设置批量操作
    $('.btn-batch .btn').click(function(){
      // 隐藏批量操作按钮
      $('.btn-batch').hide();
      // 取消全选
      $('thead input[type=checkbox]').prop('checked',false);
      $val = $(this).html();
      var url,type;
      switch ($val) {
        case "批量删除":
          url = 'http://www.baixiu_my.com/admin/api/09.deleteComments.php';
          type = 'post';
          break;
        case "批量批准":
          url = 'http://www.baixiu_my.com/admin/api/10.passComments.php';
          type = 'get'; 
          break;
        case "批量拒绝":
          url = 'http://www.baixiu_my.com/admin/api/11.rejectedComments.php';
          type = 'post';    
          break;
      }

      // 获取id 数据
      $ids = '';
      $('tbody input[type=checkbox]:checked').each(function(i,e){
        // 循环获取id值
        $id = $(e).parent().parent().attr('dateid');
        // 拼接id
        $ids += $id + ',';      
      })
      $ids = $ids.slice(0,-1);
      // console.log($ids);
      $.ajax({
        url: url,
        type: type,
        data: {
          ids: $ids
        },
        success: function(backData){
          getData();
        }
      })
    })
  })

</script>