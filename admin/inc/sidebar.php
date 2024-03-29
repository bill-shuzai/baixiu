<?php require_once '../function.php' ;

$user=xiu_current_user ();


?>

<div class="aside">
    <div class="profile">
      <img class="avatar" src="<?php echo $user['avatar']?$user['avatar']:'/static/uploads/avatar.jpg'; ?>">
      <h3 class="name"><?php echo $user['nickname']; ?></h3>
    </div>
    <ul class="nav">
      <li  <?php echo $_SERVER['PHP_SELF']==='/admin/index.php'? 'class="active"' : '' ?>>
        <a href="index.php"><i class="fa fa-dashboard"></i>仪表盘</a>
      </li>

      <?php $menu_posts=array('/admin/posts.php','/admin/post-add.php','/admin/categories.php'); ?>
      <li <?php echo in_array($_SERVER['PHP_SELF'], $menu_posts)? 'class="active"' : '' ?>>
        <a href="#menu-posts" <?php echo in_array($_SERVER['PHP_SELF'], $menu_posts)? '' : 'class="collapsed"' ?> data-toggle="collapse">
          <i class="fa fa-thumb-tack"></i>文章<i class="fa fa-angle-right"></i>
        </a>
        <ul id="menu-posts" class="collapse <?php echo in_array($_SERVER['PHP_SELF'], $menu_posts)? ' in' : '' ?>">
          <li <?php echo $_SERVER['PHP_SELF']==='/admin/posts.php'? 'class="active"' : '' ?>><a href="posts.php">所有文章</a></li>
          <li <?php echo $_SERVER['PHP_SELF']==='/admin/post-add.php'? 'class="active"' : '' ?>><a href="post-add.php">写文章</a></li>
          <li <?php echo $_SERVER['PHP_SELF']==='/admin/categories.php'? 'class="active"' : '' ?>><a href="categories.php">分类目录</a></li>
        </ul>
      </li>
      <li <?php echo $_SERVER['PHP_SELF']==='/admin/comments.php'? 'class="active"' : '' ?>>
        <a href="comments.php"><i class="fa fa-comments"></i>评论</a>
      </li>
      <li <?php echo $_SERVER['PHP_SELF']==='/admin/users.php'? 'class="active"' : '' ?>>
        <a href="users.php"><i class="fa fa-users"></i>用户</a>
      </li>
      <?php $menu_setting=array('/admin/nav-menus.php','/admin/slides.php','/admin/settings.php'); ?>
      <li <?php echo in_array($_SERVER['PHP_SELF'],$menu_setting)? 'class="active"':'' ?>>
        <a href="#menu-settings" <?php echo in_array($_SERVER['PHP_SELF'],$menu_setting)? '':'class="collapsed"' ?> data-toggle="collapse">
          <i class="fa fa-cogs"></i>设置<i class="fa fa-angle-right"></i>
        </a>
        <ul id="menu-settings" class="collapse<?php echo in_array($_SERVER['PHP_SELF'],$menu_setting)? ' in':'' ?> ">
          <li <?php echo $_SERVER['PHP_SELF']==='/admin/nav-menus.php'? 'class="active"' : '' ?>><a href="nav-menus.php">导航菜单</a></li>
          <li <?php echo $_SERVER['PHP_SELF']==='/admin/slides.php'? 'class="active"' : '' ?>><a href="slides.php">图片轮播</a></li>
          <li <?php echo $_SERVER['PHP_SELF']==='/admin/settings.php'? 'class="active"' : '' ?>><a href="settings.php">网站设置</a></li>
        </ul>
      </li>
    </ul>
  </div>