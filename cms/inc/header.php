<?php 
  include $_SERVER['DOCUMENT_ROOT'].'config/init.php'; 
  
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $_SERVER['SERVER_ADMIN']; ?> | <?php echo isset($header)?$header:"Admin"; ?> </title>

    <!-- Bootstrap -->
    <link href="<?php echo CSS_PATH; ?>bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo CSS_PATH; ?>font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo CSS_PATH; ?>nprogress.css" rel="stylesheet">

  <?php 
    if (getFileName()=='index' || getFileName()=='reset-password' || getFileName()=='reset') {
  ?>
      <!-- Animate.css -->
      <link href="<?php echo CSS_PATH; ?>animate.min.css" rel="stylesheet">
  <?php  
        $class = 'login';    
    }else{
      $class = 'nav-md';
    }
  ?>
    <!-- Custom Theme Style -->
    <link href="<?php echo CSS_PATH; ?>custom.min.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="<?php echo JS_PATH; ?>jquery.min.js"></script>
  </head>
  <body class="<?php echo $class; ?>">