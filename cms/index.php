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
            <form method="post" action="process/login">
              <h1>Login Form</h1>
              <div>
                <input type="text" class="form-control" placeholder="Username" name="username" required="" />
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Password" name="password" required="" />
              </div>
              <div>
                <input type="checkbox" name="remember" /> Remember Me
              </div>
              <div>
                <button class="">Log in</button>
                <a class="reset_pass" href="reset-password">Lost your password?</a>
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
