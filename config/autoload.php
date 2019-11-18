<?php 
spl_autoload_register(function($class){
	require_once CLASS_PATH.$class.'.php';
});