<?php 
	include '../config/init.php';
	$user = new user();
	debugger($_POST);
	debugger($_SESSION);
	if (isset($_POST) && !empty($_POST)) {
		if (empty($_POST['password']) || empty($_POST['new-password'])) {
			setFlash('../reset?token='.$_SESSION['password_reset_token'],'error','Password or Re password cannot be empty.');
		}
		if ($_POST['password'] != $_POST['new-password']) {
			setFlash('../reset?token='.$_SESSION['password_reset_token'],'error',"Password and Re password doesn't match");
		}
		$token = $_SESSION['password_reset_token'];
		$user_info = $user->getUserByPasswordResetToken($token);
	    if (!isset($user_info) || empty($user_info)) {
			setFlash('../login','error',"Invalid reset token. Please send again");
	    }
	    $en_password = sha1($user_info[0]->email.$_POST['password']);

	    $args=array(
	    	'password' => $en_password,
	    	'password_reset_token' => ''
	    );
	    $success=$user->updateUser($args,$user_info[0]->id);
	    debugger($success);
	    if ($success) {
	    	if ($user_info[0]->role=="Admin") {
	    		setFlash('../cms/index','success','Password changed successfully');
	    	}else{
	    		echo "check";
	    		exit;
	    		setFlash('../reset','success','Password Changed successfully');
	    	}
	    }else{
	    	echo "check";
			debugger($user_info,true);
	    	setFlash('../reset','error','Sorry! Error while password Change');
	    }
	}else{
		setFlash('../login','error','Unauthorized Access');
	}
?>