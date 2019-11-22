<?php 

require_once '../../function.php';

if(empty($_GET['email'])){
	return;
}

$email=$_GET['email'];

$sql="select * from users where email='{$email}' limit 1 ;";

$user=xiu_fetch_one($sql);

exit($user['avatar']);