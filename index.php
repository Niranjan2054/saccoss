<?php 
	include 'config/config.php';
	include 'config/autoload.php';
	$user = new user();
	$data = $user->getUserByUserName('Admin User');
	echo "<pre>";
	print_r($data);
