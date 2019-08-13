<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url().'assets/image/scm/small_logo.png' ?>">

    <title>SCM Dominos | Internal</title>

    <link href="<?= base_url() ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/internal/css/style.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/internal/css/colors/blue.css" id="theme" rel="stylesheet">
    <link href="<?= base_url() ?>assets/internal/css/animate.css" id="theme" rel="stylesheet">

    <link href="<?= base_url() ?>assets/plugins/toast-master/css/jquery.toast.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.2/css/responsive.bootstrap4.min.css"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    <script src="<?= base_url() ?>assets/plugins/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>source/int/additional.js"></script>
    <script src="<?= base_url() ?>source/int/finance/at_main.js"></script>
</head>
<body>
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.html">
                        <!-- Logo icon -->
                        <b>
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            <!-- Light Logo icon -->
                            <img src="<?= base_url() ?>assets/image/scm/small_logo.png" alt="homepage" class="light-logo" style="width:40px;" />
                        </b>
                        <!--End Logo icon -->
                        <!-- Logo text -->
                        <span class="text-white">
                            <b>SCM</b> Dominos
                         <!-- dark Logo text -->
                         <!-- <img src="<?= base_url() ?>assets/image/logo-text.png" alt="homepage" class="dark-logo" /> -->
                         <!-- Light Logo text -->
                         <!-- <img src="<?= base_url() ?>assets/image/logo-light-text.png" class="light-logo" alt="homepage" />  -->
                        </span>
                    </a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav mr-auto mt-md-0">
                        <!-- This is  -->
                        <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                        <li class="nav-item"> <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                        <!-- ============================================================== -->

                    </ul>
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav my-lg-0">
                        <!-- ============================================================== -->
                        <!-- Profile -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?= base_url() ?>doc/default_user.png" alt="user" class="profile-pic" /></a>
                            <div class="dropdown-menu dropdown-menu-right scale-up">
                                <ul class="dropdown-user">
                                    <li>
                                        <div class="dw-user-box">
                                            <div class=""><img src="<?= base_url() ?>doc/default_user.png" class="img-fluid" alt="user"></div>
                                            <div class="mt-2 text-center">
                                                <h6 class="session_name"></h6>
                                                <p class="text-muted" id="session_email"></p>
                                                <button class="btn btn-rounded btn-info btn-sm btn-block mb-1 setting">Account Settings</button>
                                                <button  class="btn btn-rounded btn-danger btn-sm btn-block logout">Logout</button>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- User profile -->
                <div class="user-profile" style="background: url(<?= base_url() ?>assets/image/background/socialbg.jpg) no-repeat;">
                    <!-- User profile image -->
                    <div class="profile-img"> <img src="<?= base_url() ?>doc/default_user.png"  alt="user" /> </div>
                    <!-- User profile text-->
                    <div class="profile-text"> <a class="session_name" role="button" aria-haspopup="true" aria-expanded="true"></a>

                    </div>
                </div>
                <!-- End User profile text-->
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="nav-small-cap">MASTER</li>
                        <li>
                            <a class="waves-effect waves-dark" href="#/dashboard"><i class="mdi mdi-gauge"></i> <span class="hide-menu">Dashboard</span></a>
                        </li>
                        <li>
                            <a class="waves-effect waves-dark" href="#/warehouse"><i class="fa fa-bank"></i> <span class="hide-menu">Warehouse</span></a>
                        </li>
                        <li>
                            <a class="waves-effect waves-dark" href="#/supplier"><i class="fa fa-inbox"></i> <span class="hide-menu">Supplier</span></a>
                        </li>
                        <li>
                            <a class="waves-effect waves-dark" href="#/product"><i class="fa fa-bank"></i> <span class="hide-menu">Product</span></a>
                        </li>
                        <li>
                            <a class="waves-effect waves-dark" href="#/order"><i class="fa fa-inbox"></i> <span class="hide-menu">Order</span></a>
                        </li>
                        <li>
                            <a class="waves-effect waves-dark" href="#/invoice"><i class="fa fa-file"></i> <span class="hide-menu">Invoice</span></a>
                        </li>
                        <li>
                            <a class="waves-effect waves-dark" href="#/payment"><i class="fa fa-money"></i> <span class="hide-menu">Payment</span></a>
                        </li>
                        <li>
                            <a class="waves-effect waves-dark" href="#/lap_hutang"><i class="fa fa-copy"></i> <span class="hide-menu">Laporan Hutang</span></a>
                        </li>
                        <li>
                            <a class="waves-effect waves-dark" href="#/lap_payment"><i class="fa fa-copy"></i> <span class="hide-menu">Laporan Payment</span></a>
                        </li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
            <!-- Bottom points-->
            <div class="sidebar-footer">
                <!-- item-->
                <a class="link setting" data-toggle="tooltip" title="Settings" style="cursor:pointer;"><i class="ti-settings"></i></a>
                <!-- item-->
                <a href="https://mail.google.com/mail" target="_blank" class="link" data-toggle="tooltip" title="Email"><i class="mdi mdi-gmail"></i></a>
                <!-- item-->
                <a  class="link logout" data-toggle="tooltip" title="Logout" style="cursor:pointer;"><i class="mdi mdi-power"></i></a>
            </div>
            <!-- End Bottom points-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid" id="page">

                <!-- ============================================================== -->
                <!-- LOAD PAGE CONTENT -->
                <!-- ============================================================== -->

            </div>

            <div id="modal_setting" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Account Setting</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <ul class="nav nav-pills m-b-30">
                                <li class=" nav-item"> <a href="#navpills-1" class="nav-link active" data-toggle="tab" aria-expanded="false">Account Info</a> </li>
                                <li class="nav-item"> <a href="#navpills-2" class="nav-link" data-toggle="tab" aria-expanded="false">Change Password</a> </li>
                            </ul>
                            <div class="tab-content br-n pn">
                                <div id="navpills-1" class="tab-pane active">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h4>Data User</h4>
                                            <table class="table" style="font-size: 12px">
                                                <tr>
                                                    <td>ID User</td>
                                                    <td id="info_id_user"></td>
                                                </tr>
                                                <tr>
                                                    <td>Nama</td>
                                                    <td id="info_nama_lengkap"></td>
                                                </tr>
                                                <tr>
                                                    <td>Jenis Kelamin</td>
                                                    <td id="info_jenis_kelamin"></td>
                                                </tr>
                                                <tr>
                                                    <td>Telepon</td>
                                                    <td id="info_telepon"></td>
                                                </tr>
                                                <tr>
                                                    <td>Email</td>
                                                    <td id="info_email"></td>
                                                </tr>
                                                <tr>
                                                    <td>Alamat</td>
                                                    <td id="info_alamat"></td>
                                                </tr>
                                                <tr>
                                                    <td>Level</td>
                                                    <td id="info_level"></td>
                                                </tr>
                                                <tr>
                                                    <td>Status</td>
                                                    <td id="info_status"></td>
                                                </tr>
                                                <tr>
                                                    <td>Tgl Registrasi</td>
                                                    <td id="info_tgl_reg_user"></td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <h4>Data Warehouse</h4>
                                            <table class="table" style="font-size: 12px">
                                                <tr>
                                                    <td>ID Warehouse</td>
                                                    <td id="info_id_warehouse">-</td>
                                                </tr>
                                                <tr>
                                                    <td>Nama Warehouse</td>
                                                    <td id="info_nama_warehouse">-</td>
                                                </tr>
                                                <tr>
                                                    <td>Group</td>
                                                    <td id="info_nama_group">-</td>
                                                </tr>
                                                <tr>
                                                    <td>Lokasi Group</td>
                                                    <td id="info_lokasi_group">-</td>
                                                </tr>
                                                <tr>
                                                    <td>Alamat</td>
                                                    <td id="info_alm_warehouse">-</td>
                                                </tr>
                                                <tr>
                                                    <td>Telepon</td>
                                                    <td id="info_telp_supplier">-</td>
                                                </tr>
                                                <tr>
                                                    <td>Fax</td>
                                                    <td id="info_fax">-</td>
                                                </tr>
                                                <tr>
                                                    <td>Tgl Registrasi</td>
                                                    <td id="info_tgl_reg_warehouse">-</td>
                                                </tr>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div id="navpills-2" class="tab-pane">
                                    <form id="form_pass">
                                        <div class="form-group">
                                            <label for="">Old Password</label>
                                            <input type="password" class="form-control" name="old_password" id="old_password">
                                        </div>
                                        <div class="form-group">
                                            <label for="">New Password</label>
                                            <input type="password" class="form-control" name="new_password" id="new_password">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Confirm Password</label>
                                            <input type="password" class="form-control" name="conf_password" id="conf_password">
                                        </div>
                                        <button id="submit_pass" class="btn btn-info btn-block" type="submit">Submit</button>
                                        <button type="button" class="btn btn-danger btn-block waves-effect" data-dismiss="modal">Close</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer">
                © 2019 SCM Dominos by Ulfia
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>


    <script src="<?= base_url() ?>assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>assets/internal/js/jquery.slimscroll.js"></script>
    <script src="<?= base_url() ?>assets/internal/js/waves.js"></script>
    <script src="<?= base_url() ?>assets/internal/js/sidebarmenu.js"></script>
    <script src="<?= base_url() ?>assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/sparkline/jquery.sparkline.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>

    <script src="<?= base_url() ?>assets/plugins/toast-master/js/jquery.toast.js"></script>
    <script src="<?= base_url() ?>assets/plugins/wizard/jquery.validate.min.js"></script>

    <script src="<?= base_url() ?>assets/internal/js/custom.min.js"></script>

    <script type="text/javascript" src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.2/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.2/js/responsive.bootstrap4.min.js"></script>

    <script src="<?= base_url() ?>source/int/finance/main.js"></script>


</body>
</html>
