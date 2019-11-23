<?php 

require_once '../function.php';

if($_SERVER['REQUEST_METHOD']!=='GET'){
	return;
}

$delete_categories_id=$_GET['id'];

$rows=xiu_fetch_excute("delete from categories where id='{$delete_categories_id}';");


if(!$rows){
	return false;
}

header('Location:/admin/categories.php');