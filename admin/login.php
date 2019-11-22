<?php 

  require_once '../config.php';

  function login(){
    if(empty($_POST['email'])){
      $GLOBALS['message']='请输入邮箱';
      return;
    }

    if(empty($_POST['password'])){
      $GLOBALS['message']='请输入密码';
      return;
    }

    $email=$_POST['email'];
    $password=$_POST['email'];

    $conn=mysqli_connect(XIU_DB_HOST,XIU_DB_USER,XIU_DB_PASS,XIU_DB_TABLE);
    if(!$conn){
      exit('<h1>数据库连接失败<h1>');
    }

    $query=mysqli_query($conn,'');

  };



  if($_SERVER['REQUEST_METHOD']==='POST'){
    login();
  }


 ?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Sign in &laquo; Admin</title>
  <link rel="stylesheet" href="/static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="/static/assets/css/admin.css">
</head>
<body>
  <div class="login">
    <form  action="<?php echo $_SERVER['PHP_SELF']; ?>" method='POST'; class="login-wrap" novalidate autocomplete="off">
      <img class="avatar" src="/static/assets/img/default.png">
      <!-- 有错误信息时展示 -->
      <?php if (isset($message)): ?>
        <div class="alert alert-danger">
        <strong>错误！</strong> <?php echo $message; ?>
      </div>
      <?php endif ?>
      <div class="form-group">
        <label for="email" class="sr-only">邮箱</label>
        <input id="email" name="email" type="email" class="form-control" placeholder="邮箱" autofocus>
      </div>
      <div class="form-group">
        <label for="password" class="sr-only">密码</label>
        <input id="password" name="password" type="password" class="form-control" placeholder="密码">
      </div>
      <button class="btn btn-primary btn-block" href="index.php">登 录</button>
    </form>
  </div>
</body>
</html>
