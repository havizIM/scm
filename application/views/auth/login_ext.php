
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url().'assets/image/scm/small_logo.png' ?>">
    <title>SCM Dominos | Public</title>
    <!-- Bootstrap Core CSS -->
    <link href="<?= base_url() ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= base_url() ?>assets/internal/css/style.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="<?= base_url() ?>assets/eksternal/css/colors/blue.css" id="theme" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.css">
    <link href="<?= base_url() ?>assets/plugins/toast-master/css/jquery.toast.css" rel="stylesheet">

    <script src="<?= base_url() ?>assets/plugins/jquery/jquery.min.js"></script>
    <script src="<?= base_url().'source/ext/additional.js'?>"></script>
    <script src="<?= base_url().'source/ext/at_login.js'?>"></script>

    <style media="screen">
      .card-body{
        margin-top:40%;
      }
    </style>

</head>

<body>

  <div class="preloader">
      <svg class="circular" viewBox="25 25 50 50">
      <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
  </div>

  <section id="wrapper" class="login-register login-sidebar"  style="background-image:url('<?= base_url() ?>assets/image/scm/login.jpg'); width:100%; background-size:cover; height:126%;">
  <div class="login-box card" style="right:auto !important;">
    <div class="card-body animated bounceInDown">
      <form class="form-horizontal form-material" id="login_form">
        <a class="text-center db"><img src="<?= base_url() ?>assets/image/scm/logo_full.png" alt="Home" style="width:90%;" /></a>

        <div class="form-group m-t-40">
          <div class="col-xs-12">
            <input class="form-control" type="text" id="username" name="username" placeholder="Username">
            <small class="form-text text-danger" id="invalid_username"></small>
          </div>
        </div>
        <div class="form-group">
          <div class="col-xs-12">
            <input class="form-control" type="password" id="password" name="password" placeholder="Password">
            <small class="form-text text-danger" id="invalid_password"></small>
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-12">
            <div class="checkbox checkbox-primary pull-left p-t-0">
              <input id="checkbox-signup" class="show_pass" type="checkbox">
              <label for="checkbox-signup"> Show Password </label>
            </div>
          </div>
        </div>
        <div class="form-group text-center m-t-20">
          <div class="col-xs-12">
            <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" id="submit_login" type="submit">Log In</button>
          </div>
        </div>

      </form>
      
    </div>
  </div>
</section>

    
    <!-- Bootstrap tether Core JavaScript -->
    <script src="<?= base_url() ?>assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="<?= base_url() ?>assets/internal/js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="<?= base_url() ?>assets/internal/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="<?= base_url() ?>assets/internal/js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="<?= base_url() ?>assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!--Custom JavaScript -->
    <script src="<?= base_url() ?>assets/internal/js/custom.min.js"></script>
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="<?= base_url() ?>assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>

    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/toast-master/js/jquery.toast.js"></script>

    <script src="<?= base_url().'source/ext/auth.js'?>"></script>

</body>

</html>>
