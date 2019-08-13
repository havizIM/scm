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
    <title>SCM Dominos | Private</title>


    <link href="<?= base_url() ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/internal/css/style.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/internal/css/colors/blue.css" id="theme" rel="stylesheet">
    <link href="<?= base_url() ?>assets/plugins/toast-master/css/jquery.toast.css" rel="stylesheet">

    <script src="<?= base_url() ?>assets/plugins/jquery/jquery.min.js"></script>
    <script src="<?= base_url().'source/int/additional.js'?>"></script>
    <script src="<?= base_url().'source/int/at_login.js'?>"></script>
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <section id="wrapper">
        <div class="login-register" style="background-image:url('<?= base_url() ?>assets/image/scm/login.jpg'); width:100%; background-size:cover; height:126%;">
            <div class="login-box card">
            <div class="card-body">
                <form class="form-horizontal form-material" id="login_form">
                    <h3 class="box-title m-b-20 text-center">Welcome</h3>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" name="username" id="username" placeholder="Username"> </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control" type="password" name="password" id="password" placeholder="Password"> </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <div class="checkbox checkbox-primary pull-left p-t-0">
                                <input id="checkbox-signup" type="checkbox" class="show_pass">
                                <label for="checkbox-signup"> Show Password </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit" id="submit_login">Log In</button>
                        </div>
                    </div>
                </form>
                <!-- <form class="form-horizontal" id="recover_form">
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <h3>Recover Password</h3>
                            <p class="text-muted">Enter your Email and instructions will be sent to you! </p>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" required="" placeholder="Email"> </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit" id="submit_forgot_password">Reset</button>
                        </div>
                    </div>
                </form> -->
            </div>
          </div>
        </div>

    </section>

    <script src="<?= base_url() ?>assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>assets/internal/js/jquery.slimscroll.js"></script>
    <script src="<?= base_url() ?>assets/internal/js/waves.js"></script>
    <script src="<?= base_url() ?>assets/internal/js/sidebarmenu.js"></script>
    <script src="<?= base_url() ?>assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/sparkline/jquery.sparkline.min.js"></script>
    <script src="<?= base_url() ?>assets/internal/js/custom.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>

    <script src="<?= base_url() ?>assets/plugins/wizard/jquery.validate.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/toast-master/js/jquery.toast.js"></script>

    <script src="<?= base_url().'source/int/auth.js'?>"></script>

</body>

</html>
