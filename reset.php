<?php 
require $_SERVER['DOCUMENT_ROOT'].'config/init.php';
include_once 'cms/inc/header.php'; 
$user = new user();
if (isset($_GET) && isset($_GET['token']) && !empty($_GET['token'])) {
	$token = sanitize($_GET['token']);
	$user_info = $user->getUserByPasswordResetToken($token);
	// debugger($_GET,true);
    if (!isset($user_info) || empty($user_info)) {
     	setFlash('cms/reset-password','error','Invalid Reset Token. Please send mail again.');
    }else{
		// debugger($_GET,true);
    	$_SESSION['password_reset_token'] = $token;
    	$_SESSION['password_reset_id'] = $user_info[0]->id;
    }
    ?>
     <div>
      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <?php flashMessage(); ?>
            <form method="post" action="process/reset">
              <h1>Password Change</h1>
              <div>
                <input type="password" class="form-control" placeholder="Password" name="password" id="password" required="" />
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Re-Enter Password" name="new-password" id="newpassword" required="" />
				      <span class="hidden" id="err_pass"></span>
              </div>
              <div>
                <button class="btn btn-success" id="button">Change Password</button>
              </div>
              <div class="clearfix"></div>
              <div class="separator">
                <div class="clearfix"></div>
                <br />
                <div>
                  <p>&copy; <?php echo date('Y'); ?> All Rights Reserved.</p>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
    <?php

}else{
	setFlash('cms/reset-password','error','Reset Token Required for Password Change.');
}
?>
<script type="text/javascript">
	$('#newpassword').keyup(function(){
		var password = $('#password').val();
		var newpassword = $('#newpassword').val();
		console.log('check');
		if (password != newpassword) {
			$('#err_pass').html("Password Doesn't match.").removeClass('hidden').addClass('alert').addClass('alert-danger');
			$("#button").attr('disabled','disabled').addClass('hidden');
		}else{
			$('#err_pass').html("").addClass('hidden').removeClass('alert').removeClass('alert-danger');
			$("#button").removeAttr('disabled','disabled').removeClass('hidden');
		}
	});
</script>