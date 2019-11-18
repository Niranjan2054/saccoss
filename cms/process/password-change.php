<?php 
	include $_SERVER['DOCUMENT_ROOT'].'config/init.php';
	include '../inc/checklogin.php';
	// debugger($_POST);
	// debugger($_SESSION);
	if (isset($_POST) && !empty($_POST)) {
		if (!empty($_POST['oldpassword']) && !empty($_POST['password']) && !empty($_POST['newpassword'])) {
			$user = new user();
			$user_info= $user->getUserByEmail($_SESSION['email']);
			// debugger($user_info,true);
			$password = sha1($user_info[0]->email.$_POST['oldpassword']);
			if ($password == $user_info[0]->password) {
				if ($_POST['password'] == $_POST['newpassword']) {
					$en_password = sha1($user_info[0]->email.$_POST['password']);
					$args = array(
								'password'	=>$en_password
							);
					$success = $user->updateUser($args,$user_info[0]->id);
					if ($success) {
						setFlash('../dashboard','success','Password Change Succssfully');
					}else{
						setFlash('../dashboard','error','Sorry! Error while password Change');
					}
				}else{
					setFlash('../password-change','error',"Password Doesn't match.");
				}
			}else{
				setFlash('../password-change','error','Old Password is incorrect');
			}
		}else{
			setFlash('../password-change','error',"Password Fields can't be Empty");
		}
	}else{
		setFlash('../password-change','error',"Unauthorized Access");
	}
	


 ?>