<?php 
$user = new user();
if (!isset($_SESSION['token']) || empty($_SESSION['token'])) {
  if (isset($_COOKIE['_auth_user'])) {
    $token = $_COOKIE['_auth_user'];
    $user_info = $user->getUserByToken($token);
    if (!isset($user_info) || empty($user_info)) {
     setFlash('logout');
    }
    $_SESSION['user_id'] = $user_info[0]->id;
    $_SESSION['admin_name'] = $user_info[0]->username;
    $_SESSION['email'] = $user_info[0]->email;
    $_SESSION['role'] = $user_info[0]->role;
    $_SESSION['status'] = $user_info[0]->status;
    $token = setToken(100);
    $_SESSION['token'] = $token;
    setcookie('_auth_user',$token,(time()+864000),'/');
    $args = array(
        'session_token'=>$_SESSION['token'],
        'last_login' =>date('Y-m-d h:i:s'),
        'last_ip'=>$_SERVER['REMOTE_ADDR']
    );  
    $user->updateUser($args,$user_info[0]->id);
    setFlash('../dashboard','success','You are successfully logged in. Welcome to the dashboard.');
  }else{
    setFlash('index','error','You are not logged in. Please login');
  }
}  

if ($_SESSION['token']) {
   $token = $_SESSION['token'];
   $user_info = $user->getUserByToken($token);
   if (!isset($user_info) || empty($user_info)) {
     setFlash('logout');
   }
 } 
?>