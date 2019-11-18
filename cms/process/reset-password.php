<?php 
include_once $_SERVER['DOCUMENT_ROOT'].'config/init.php';
require $_SERVER['DOCUMENT_ROOT'].'assets/plugins/SMTP.php';
require $_SERVER['DOCUMENT_ROOT'].'assets/plugins/PHPMailer.php';

$user =	 new user();
$mail = new PHPMailer(true);
$data = array();
if (isset($_POST) && !empty($_POST)) {
	if (isset($_POST['username']) && !empty($_POST['username'])) {
		$data['username'] = filter_var($_POST['username'],FILTER_VALIDATE_EMAIL);
		if ($data['username']) {
			$user_info= $user->getUserByEmail($data['username']);
			if ($user_info) {
				$password_token = setToken(100);
				$args=array(
					'password_reset_token' => $password_token
				);
				$user->updateUser($args,$user_info[0]->id);
				$message = " Dear ".$user_info[0]->username."! <br>";
				$message .= " You have requested for the password change. If you want to change the password, please click on the link below: <br>";
				$message .= "<a href='".SITE_URL.'reset?token='.$password_token."'>".SITE_URL.'reset?token='.$password_token."</a>";
				$message .= "<br> If you did not request for the password change, please ignore this message.<br>";
				$message .= "Regards,<br>";
				$message .= "MeroPasal Administration";
				$mail = sendMessage($user_info[0]->email,'Change Password Token',$message,$mail);
				// debugger($mail,true);
				if ($mail) {
					setFlash('../reset-password','success','Password link is sent to your mail. Please check mail');
				}
				
			}else{
				setFlash('../reset-password','error','Invalid Username. Username must be Email Type.');
			}
		}else{
			setFlash('../reset-password','error','Invalid Username. Username must be Email Type.');
		}
	}else{
		setFlash('../reset-password','error','Username Required');
	}
}else{
	setFlash('../reset-password','error','Unauthorized Access');
}