<?php 
$header = "Login Admin";
include_once 'inc/header.php'; 
if (isset($_SESSION['token']) && !empty($_SESSION['token']) || isset($_COOKIE['_auth_user'])) {
    setFlash('dashboard','success','You are already logged in.');
}  
?>
    <div>
      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <?php flashMessage(); ?>
            <form method="post" action="process/reset-password">
              <h1>Reset Form</h1>
              <div>
                <label for="">Please provide your valid email address to send reset link.</label>
                <input type="text" class="form-control" placeholder="Username" name="username" required="" />
              </div>
              <div>
                <button class="">Send Verification</button>
                <a class="reset_pass" href="index">Login</a>
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
 <?php include_once 'inc/footer.php'; ?>
