<?php 

	require_once 'config.php';
 /*
 
 判断用户是否登录
  */
 session_start();

 function xiu_current_user(){
 	if(empty($_SESSION['current_login_user'])){
 		header('Location:/admin/login.php');
 		exit();
 	}

 	return $_SESSION['current_login_user'];
 }


 /*
 从数据库查询一条数据
  */
 
 function xiu_fetch_one($sql){
 	$conn=mysqli_connect(XIU_DB_HOST,XIU_DB_USER,XIU_DB_PASS,XIU_DB_NAME);
 	if(!$conn){
 		exit('数据库连接失败！');
 	}
 	$query=mysqli_query($conn,$sql);
 	if(!$query){
 		return false;
 	}

 	$result=mysqli_fetch_assoc($query);
 	if(!$result){
 		return false;
 	}

 	return $result;
 }