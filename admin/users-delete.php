<?php 

require_once '../function.php';

if ($_SERVER['REQUEST_METHOD']!=='GET') {
	return;
}

$id=$_GET['id'];

$rows=xiu_fetch_excute('delete from users where id in ('.$id.');');

if (!$rows) {
	return false;
}

header('Location:/admin/users.php');