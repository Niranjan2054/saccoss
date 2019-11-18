<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'config/init.php';
$user = new User();
$args = array(
    'session_token' => ""
);

$user->updateUser($args, $_SESSION['user_id']);

if(isset($_COOKIE['_auth_user'])){
	setcookie('_auth_user', null, time()-60, "/");
}
session_destroy();
setFlash('index');