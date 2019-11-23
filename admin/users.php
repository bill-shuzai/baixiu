<?php 

  require_once '../function.php';

  xiu_current_user();

  function add_user(){
    if (empty($_POST['email'])) {
      $GLOBALS['message']='请输入邮箱';
      return;
    }

    if (empty($_POST['slug'])) {
      $GLOBALS['message']='请输入slug';
      return;
    }

    if (empty($_POST['nickname'])) {
      $GLOBALS['message']='请输入昵称';
      return;
    }

    if (empty($_POST['password'])) {
      $GLOBALS['password']='请输入密码';
      return;
    }

    $email=$_POST['email'];
    $slug=$_POST['slug'];
    $nickname=$_POST['nickname'];
    $password=$_POST['password'];

    $rows=xiu_fetch_excute("insert into users (email,slug,nickname,password,status) values('{$email}','{$slug}','{$nickname}','{$password}','actived');");

    $rows>0?$GLOBALS['success']='添加成功':$GLOBALS['message']='添加失败';
  };

  function edit_user(){
    global $current_edit_user;

    $id=$current_edit_user['id'];

    $email=empty($_POST['email'])?$current_edit_user['email']:$_POST['email'];
    $current_edit_user['email']=$email;

    $slug=empty($_POST['slug'])?$current_edit_user['slug']:$_POST['slug'];
    $current_edit_user['slug']=$slug;

    $nickname=empty($_POST['nickname'])?$current_edit_user['nickname']:$_POST['nickname'];
    $current_edit_user['nickname']=$nickname;

    $password=empty($_POST['password'])?$current_edit_user['password']:$_POST['password'];
    $current_edit_user['password']=$password;

    $rows=xiu_fetch_excute("update users set email='{$email}',slug='{$slug}',nickname='{$nickname}',password='{$password}' where id='{$id}';");



    $rows>0?$GLOBALS['success']='更新成功！':$GLOBALS['message']='更新失败！';

  };




  if (empty($_GET['id'])) {
    if ($_SERVER['REQUEST_METHOD']==='POST') {
      add_user();
    }
  }else{
    $current_edit_user=xiu_fetch_one("select * from users where id='{$_GET['id']}';");
    if ($_SERVER['REQUEST_METHOD']==='POST') {
      edit_user();
    }
  }




  $users=xiu_fetch_all('select * from users;');

 ?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Users &laquo; Admin</title>
  <link rel="stylesheet" href="/static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="/static/assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="/static/assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="/static/assets/css/admin.css">
  <script src="/static/assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <?php include 'inc/navbar.php' ?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>用户</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <?php if (isset($success)): ?>
        <div class="alert alert-success">
        <strong>成功！</strong><?php echo $success; ?>
      </div>
      <?php endif ?>
      <?php if (isset($message)): ?>
        <div class="alert alert-danger">
        <strong>错误！</strong><?php echo $message; ?>
      </div>
      <?php endif ?>
      <div class="row">
        <div class="col-md-4">
          <?php if (empty($current_edit_user)): ?>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" novalidate autocomplete="off" >
            <h2>添加新用户</h2>
            <div class="form-group">
              <label for="email">邮箱</label>
              <input id="email" class="form-control" name="email" type="email" placeholder="邮箱">
            </div>
            <div class="form-group">
              <label for="slug">别名</label>
              <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
              <p class="help-block">https://zce.me/author/<strong>slug</strong></p>
            </div>
            <div class="form-group">
              <label for="nickname">昵称</label>
              <input id="nickname" class="form-control" name="nickname" type="text" placeholder="昵称">
            </div>
            <div class="form-group">
              <label for="password">密码</label>
              <input id="password" class="form-control" name="password" type="text" placeholder="密码">
            </div>
            <div class="form-group">
              <button class="btn btn-primary" type="submit">添加</button>
            </div>
          </form>
          <?php else: ?>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $current_edit_user['id']; ?>" method="POST" novalidate autocomplete="off" >
            <h2>编辑用户##<?php echo $current_edit_user['nickname']; ?>##</h2>
            <div class="form-group">
              <label for="email">邮箱</label>
              <input id="email" class="form-control" name="email" type="email" placeholder="<?php echo $current_edit_user['email']; ?>">
            </div>
            <div class="form-group">
              <label for="slug">别名</label>
              <input id="slug" class="form-control" name="slug" type="text" placeholder="<?php echo $current_edit_user['slug']; ?>">
              <p class="help-block">https://zce.me/author/<strong>slug</strong></p>
            </div>
            <div class="form-group">
              <label for="nickname">昵称</label>
              <input id="nickname" class="form-control" name="nickname" type="text" placeholder="<?php echo $current_edit_user['nickname']; ?>">
            </div>
            <div class="form-group">
              <label for="password">密码</label>
              <input id="password" class="form-control" name="password" type="text" placeholder="<?php echo $current_edit_user['password']; ?>">
            </div>
            <div class="form-group">
              <button class="btn btn-primary" type="submit">更新</button>
            </div>
          </form>
          <?php endif ?>
        </div>
        <div class="col-md-8">
          <div class="page-action">
            <!-- show when multiple checked -->
            <a id="deleteAll" class="btn btn-danger btn-sm" href="/admin/users-delete.php" style="display: none">批量删除</a>
          </div>
          <table class="table table-striped table-bordered table-hover">
            <thead>
               <tr>
                <th class="text-center" width="40"><input id="checkAll" type="checkbox"></th>
                <th class="text-center" width="80">头像</th>
                <th>邮箱</th>
                <th>别名</th>
                <th>昵称</th>
                <th>状态</th>
                <th class="text-center" width="100">操作</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($users as $item): ?>
                <tr>
                <td class="text-center"><input data-id="<?php echo $item['id']; ?>" type="checkbox"></td>
                <td class="text-center"><img class="avatar" src="<?php echo $item['avatar']?$item['avatar']:'/static/assets/img/default.png' ?>"></td>
                <td><?php echo $item['email']; ?></td>
                <td><?php echo $item['slug']; ?></td>
                <td><?php echo $item['nickname']; ?></td>
                <td><?php echo $item['status']; ?></td>
                <td class="text-center">
                  <a href="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $item['id']; ?>" class="btn btn-default btn-xs">编辑</a>
                  <a href="/admin/users-delete.php?id=<?php echo $item['id']; ?>" class="btn btn-danger btn-xs">删除</a>
                </td>
              </tr>
              <?php endforeach ?>
              
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <?php include 'inc/sidebar.php' ?>
  <script src="/static/assets/vendors/jquery/jquery.js"></script>
  <script src="/static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>NProgress.done()</script>
  <script type="text/javascript">
    $(function($){
      var allChecked=[];
      var $checkBox=$('tbody input');
      var $deleteAll=$('#deleteAll');
      var $checkAll=$('#checkAll');

      $checkBox.on('change',function(){
        var id=$(this).data('id');

        if ($(this).prop('checked')) {
          allChecked.indexOf(id)!== -1 || allChecked.push(id); 
        }else{
          allChecked.splice(allChecked.indexOf(id),1);
        }

        allChecked.length? $deleteAll.fadeIn():$deleteAll.fadeOut();

        $deleteAll.prop('search','?id='+allChecked);
      });

      $checkAll.on('change',function(){
        var check=$(this).prop('checked');
        $checkBox.prop('checked',check).trigger('change');
      });
    });
  </script>
</body>
</html>
