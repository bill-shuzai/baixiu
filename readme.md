## 百秀项目

#### mac批量修改后缀

​	

```
for i in *.html; do mv "$i" "${i%.html}.php" ;done 
```



### 静态页面公共部分

#### 使用inlude_once

include与require不同之处

include引导文件丢失可以正常显示，require报错

include_once和require_once重复引用只引用一次不冲突



### 文件目录结构

>   baixiu--
>
>   -   admin
>       -   api   //功能，存放功能页面 如 ajax调用的获取头像的avatar.php
>       -   inc   //存放公共部分文件夹
>       -   各个页面.php
>   -   static
>       -   assets (存放插件)
>           -   css
>           -   img
>           -   vender //存放各类框架api？
>       -   upload （存放上传文件）
>   -   ----config.php  //存放配置文件
>   -   ----function.php  //存放公共方法
>   -   ----index.php





### config.php

存放配置项，配置常量，如数据库配置

```
<?php 

 //数据库主机
 define('XIU_DB_HOST','localhost');

 //数据库用户
 define('XIU_DB_USER', 'root');

 //数据库密码
 define('XIU_DB_PASS','linbihui');

 //数据库表
 define('XIU_DB_NAME','baixiu');
```



使用require_once引入





##### require页面使用相对路径





### 判断页面的请求

###### 判断方法 isset() empty()

###### 判断请求方法

```
$_SERVER['REQUEST_METHOD']==='POST' or 'GET'
```



###### 判断请求是否存在

```
empty($_POST['name'])  or isset($_GET['name']);
```



###### 判断变量

```
$bian=$_GET['name'];
if(!bian)
```





### 连接数据库并校验的方法

```

$conn=mysqli_connect('host','user','password','tablename');
if(!$conn){
	exit(<h1>数据库连接失败<h1>);
}

$query=mysqli_query($conn,'query sentence');
if(!$query){
	//查询失败
}

$result=mysqli_fetch_assoc($query);
使用关联数组承接一条数据，使用枚举数组承接多条关联数组数据
if(!$result['name']){
	//查询数据不匹配
}




```



### 插入css、js等配置文件

使用绝对路径，从根目录开始

```
/  根目录
./  当前目录和写是一样的
../ 返回上一层
```



### header方法

跳转页面

header('Location:/admin/（绝对路径）')；





### 函数内设置全局变量



```
$GLOBALS['message'];


//使用方法$message
```





### PHP主要输出方式

1.  echo

    可以输出字符串串和变量，也可以同时输出多个，用逗号隔开

2.  print

    和echo一样，但是不支持多个输出

3.  print_r打印关于变量易于理解的信息，也是一个函数，一定要加（），一般不用，数组用

4.  die(退出)

    等同于exit()：输出一个字符串或一个值并且退出当前脚本，也可以不输出

5.  exit

    输出一个字符串，可以输出字符串，也可以不输出

6.  printf

    可以输出一个整数，也可以什么也不输出

    ```
    printf函数输出格式化的字符串
    printf(format,arg1,arg2++)
    printd(format:格式化的字符串，arg为若干个函数)
    
    
    //例子
    $num=5;
    $location='树上';
    $format='有%d只猴子在%s上';
    printf($format,$num,$loction);
    
    %.2f  //小数点后取两位
    ```

7.  sprintf和printf一样，但是有返回结果没有输出。





### session机制

使用之前一定要开始

session_start();



设置session

```
$_SESSION['name']=key;
```



会话控制跳转，封装成方法

这里session存了变量信息

可以传递到其他页面使用

```
function xiu_current_user(){
 	if(empty($_SESSION['current_login_user'])){
 		header('Location:/admin/login.php');
 		exit();
 	}

 	return $_SESSION['current_login_user'];
 }
```









### 表单属性设置

novalidate 取消验证

aoto-complete='off';

关闭浏览器的操作



### 跳转回当前页面

```
action="<?php echo $_SERVER['PHP_SELF']; ?>"
```



### 通过设置全局变量展示错误信息

```
<?php if (isset($message)): ?>
        <div class="alert alert-danger">
        <strong>错误！</strong> <?php echo $message; ?>
      </div>
      <?php endif ?>
```





### 使用ajax发送请求获取用户头像

```javascript
<script>
	$(function($){
		//做什么时候做什么事情
		//在email栏失去焦点的时候，验证邮箱，失败先不操作，成功去发送ajax请求并获取数据渲染html页面
		$('.email').on('blur',function(){
			//获取当前输入的邮箱
      var value=$(this).val();
      var reg=/[0-9a-zA-Z_.-]+[@][0-9a-zA-Z_.-]+([.][a-zA-z]+){1,2}/;
      //如果邮箱无效就不发送ajax请求
      //空或者不满足邮箱格式
      if(!value||！reg.test(value)){
        
        //返回之前需要判断是否原来有用户的头像的话就要切换会默认的，变化方法是一样的		
        $('.avatar').fadeOut(function(){
              $(this).attr('src','/static/assets/img/default.png').on('load',function(){
                $(this).fadeIn();
              })
            });
        
        return;
      }
      
      //是正确的邮箱，发送ajax
      $.get('api操作url'，{键值对}，function(res){
      	//是否拿到返回数据
      	if(!res){
          return;
        }
      
      	//先隐藏，隐藏结束后开始回调函数，先加载图片使用load方法，结束以后在回调方法中让当前元素显示出来
      	$('.avatar').fadeOut(
        function(){
          $(this).attr('src',res).on('load',function(){
            $(this).fadeIn();
          });
        }
        );
    	});
		});
	});
</script>
```





### 使用animate动画库

1.  引入animate.css文件
2.  在需要产生动画的元素上添加属性如 抖动属性添加 animate shack





### 使用Nprogress进度条插件

1.  引入nprogress的js和css问价

2.  页面加载设置进度条

    ```
    <script>NProgress.start()</script>
    
    内容
    <script>NProgress.end()</script>
    ```

3.  ajax请求发起加载进度条，可以放在公共方法处

    ```
    $(document)
    	.ajaxStart(function () {
    		NProgress.start()
    	})
    	.ajaxStop(function () {
    		NProgress.done()
    	})
    ```

    



### 退出功能删除session

点击退出功能返回到登录页面，并删除session

>   退出按钮的href上设置get的url？action=logout请求
>
>   跳转回登录页面通过判断信息是否删除
>
>   unset($_SESSION['name']);





