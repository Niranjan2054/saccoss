<?php 
$header = "Dashboard";
include_once 'inc/header.php'; 
include_once 'inc/checklogin.php';
?>
    <div class="container body">
      <div class="main_container">
        <?php include 'inc/sidebar.php'; ?>

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <?php flashMessage(); ?>
            <div class="page-title">
              <div class="title_left">
                <h3>Dashboard</h3>
              </div>

              <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <div class="input-group">
                    
                  </div>
                </div>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Password Change</h2>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                      <form action="process/password-change" method="post" class="form form-horizontal">
                        <div class="form-group row">
                          <label for="" class="col-md-2 col-lg-2">Old Password</label>
                          <div class="col-md-6 col-lg-6">
                            <input type="password" placeholder=" Password" name="oldpassword" id="oldpassword" required class="form-control">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="" class="col-md-2 col-lg-2">New Password</label>
                          <div class="col-md-6 col-lg-6">
                            <input type="password" placeholder=" New Password" name="password" id="password" required class="form-control">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="" class="col-md-2 col-lg-2">Old Password</label>
                          <div class="col-md-6 col-lg-6">
                            <input type="password" placeholder=" Re-Enter New Password" name="newpassword" id="newpassword" required class="form-control">
                          </div>
                          <span id="err_pass" class="hidden"></span>
                        </div>
                        <div class="form-group row">
                          <label for="" class="col-md-2 col-lg-2"></label>
                          <div class="col-md-6 col-lg-6">
                            <button type="reset" class="btn btn-primary">Clear</button>
                            <button type="submit" class="btn btn-success" id="submit"><i class="fa fa-send"> Submit</i></button>
                          </div>
                        </div>
                      </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->
<?php include_once 'inc/footer.php'; ?>
<script type="text/javascript">
  $('#newpassword').keyup(function(){
    var password = $('#password').val();
    var newpassword = $('#newpassword').val();
    console.log('check');
    if (password != newpassword) {
      $('#err_pass').html("Password Doesn't match.").removeClass('hidden').addClass('alert').addClass('alert-danger');
      $("#submit").attr('disabled','disabled');
    }else{
      $('#err_pass').html("").addClass('hidden').removeClass('alert').removeClass('alert-danger');
      $("#submit").removeAttr('disabled','disabled');
    }
  });
</script>
