
<?php 

  require_once '../config.php';

  session_start();

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
    $password=$_POST['password'];

    $conn=mysqli_connect(XIU_DB_HOST,XIU_DB_USER,XIU_DB_PASS,XIU_DB_NAME);
    if(!$conn){
      exit('<h1>数据库连接失败<h1>');
    }

    $query=mysqli_query($conn,"SELECT * from users where email ='{$email}' limit 1;");
    
    if (!$query) {
      $GLOBALS['message']='查询失败请重试！';
      return;
    }

    $user=mysqli_fetch_assoc($query);

    //var_dump($users['password']);

    if(!$user){
      $GLOBALS['message']='邮箱不匹配';
      return;
    }

    if($user['password']!==$password){
      $GLOBALS['message']='密码不匹配';
      return;
    }

    $_SESSION['current_login_user']=$user;


    header('Location:/admin/');

  };



  if($_SERVER['REQUEST_METHOD']==='POST'){
    login();
  }


  if ($_SERVER['REQUEST_METHOD']==='GET'&& isset($_GET['action']) && $_GET['action']==='logout') {
    unset($_SESSION['current_login_user']);
  }

 ?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Sign in &laquo; Admin</title>
  <link rel="stylesheet" href="/static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="/static/assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" type="text/css" href="/static/assets/vendors/animate/animate.css">
  <link rel="stylesheet" href="/static/assets/css/admin.css">
</head>
<body>
  <div class="login ">
    <form  action="<?php echo $_SERVER['PHP_SELF']; ?>" method='POST'; class="login-wrap <?php echo isset($message)? 'animated shake':'' ?>" novalidate autocomplete="off">
      <img class="avatar" src="/static/assets/img/default.png">
      <!-- 有错误信息时展示 -->
      <?php if (isset($message)): ?>
        <div class="alert alert-danger">
        <strong>错误！</strong> <?php echo $message; ?>
      </div>
      <?php endif ?>
      <div class="form-group">
        <label for="email" class="sr-only">邮箱</label>
        <input id="email" name="email" type="email" class="form-control" placeholder="邮箱" value="<?php echo $_POST['email'] ?>" autofocus>
      </div>
      <div class="form-group">
        <label for="password" class="sr-only">密码</label>
        <input id="password" name="password" type="password" class="form-control" placeholder="密码">
      </div>
      <button class="btn btn-primary btn-block" href="index.php">登 录</button>
    </form>
  </div>
  <script src="/static/assets/vendors/jquery/jquery.js"></script>
  <script type="text/javascript" src="/static/assets/vendors/nprogress/nprogress.js"></script>
  <script>
    $(function($){
      $('#email').on('blur',function(){
          //获取邮箱，验证邮箱
  
          var value=$(this).val();
          var reg=/[0-9a-zA-Z_.-]+[@][0-9a-zA-Z_.-]+([.][a-zA-z]+){1,2}/;
          
          //
          if (!value||!reg.test(value)) {
            if ($('.avatar').attr('src')==='/static/assets/img/default.png') {
             return;
            }
             $('.avatar').fadeOut(function(){
              $(this).attr('src','/static/assets/img/default.png').on('load',function(){
                $(this).fadeIn();
              })
            });
            return;
          }

          $.get('/admin/api/avatar.php',{ email: value },function(res){
            if(!res){
              return;
            }
            $('.avatar').fadeOut(function(){
                $(this).attr('src',res).on('load',function(){
                  $(this).fadeIn();
                });
            });
          });
      })
    });








    

  </script>
</body>
</html>
