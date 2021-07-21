

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

    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url() ?>assets/assets/images/logo/logo-metro-sm.png">

    <title>SiMETRO</title>

    <!-- Bootstrap Core CSS -->

    <link href="<?= base_url() ?>assets/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!--alerts CSS -->

    <link href="<?= base_url() ?>assets/assets/plugins/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">

    <!-- Custom CSS -->

    <link href="<?= base_url() ?>assets/main/css/style.css" rel="stylesheet">

    <!-- You can change the theme colors from here -->

    <link href="<?= base_url() ?>assets/main/css/colors/yellow.css" id="theme" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

    <!--[if lt IE 9]>

    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>

    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>

<![endif]-->

    <style>
        #img_captcha img{
            /* border-radius: 100px; */
            border: 1px solid #a6445d !important;
            width: 100%;
            height: 50px;
        }
    </style>

</head>



<body oncontextmenu="return false;">

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

    <section id="wrapper" class="login-register login-sidebar" style="background-image:url(<?= base_url() ?>assets/assets/images/background/simetro.jpg);">

        <div class="login-box card">

            <div class="card-body">

                <br>

                <form class="form-horizontal form-material" id="loginform">

                    <a href="javascript:void(0)" class="text-center db">
                        <img width="100" src="<?= base_url() ?>assets/assets/images/logo/logo-metro.png" alt="Home" /><br/>
                        <label style="font-size: 25pt; color: grey"><b>SiMETRO</b></label><br>
                        <label style="font-size: 15pt; color: grey">KABUPATEN MAGELANG</label>
                    </a>

                    <?= $this->session->flashdata('alert') ?>

                    <div class="form-group m-t-40">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" name="username" id="username" required="" placeholder="Username" style="text-align: center;">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control" type="password" name="password" id="password" required="" placeholder="Password" style="text-align: center;">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 m-b-10" id="img_captcha"><?= $img_captcha; ?></div>
                        <div class="validate-input m-b-10 col-md-6" data-validate="Captcha is required">
                            <input class="form-control text-center" type="text" id="captcha" name="captcha" placeholder="Captcha" maxlength="4" style="padding: 10px; font-size: 16pt !important;" required="">
                        </div>
                    </div>

                    <!-- <div class="form-group">

                        <div class="col-md-12">

                            <div class="checkbox checkbox-primary pull-left p-t-0">

                                <input id="checkbox-signup" type="checkbox">

                                <label for="checkbox-signup"> Remember me </label>

                            </div>

                            <a href="javascript:void(0)" id="to-recover" class="text-dark pull-right"><i class="fa fa-lock m-r-5"></i> Forgot pwd?</a> </div>

                    </div> -->

                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-warning btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button>
                        </div>
                    </div>



                    <!-- <div class="form-group text-center m-t-20">

                        <div class="col-xs-12">

                            <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="button" onclick="showModalAdd()">Register</button>

                        </div>

                    </div> -->

                    <!-- <div class="row">

                        <div class="col-xs-12 col-sm-12 col-md-12 m-t-10 text-center">

                            <div class="social"><a href="javascript:void(0)" class="btn  btn-facebook" data-toggle="tooltip" title="Login with Facebook"> <i aria-hidden="true" class="fa fa-facebook"></i> </a> <a href="javascript:void(0)" class="btn btn-googleplus" data-toggle="tooltip" title="Login with Google"> <i aria-hidden="true" class="fa fa-google-plus"></i> </a> </div>

                        </div>

                    </div>

                    <div class="form-group m-b-0">

                        <div class="col-sm-12 text-center">

                            <p>Don't have an account? <a href="pages-register2.html" class="text-primary m-l-5"><b>Sign Up</b></a></p>

                        </div>

                    </div> -->

                </form>

                <!-- <form class="form-horizontal" id="recoverform" action="index.html">

                    <div class="form-group ">

                        <div class="col-xs-12">

                            <h3>Recover Password</h3>

                            <p class="text-muted">Enter your Email and instructions will be sent to you! </p>

                        </div>

                    </div>

                    <div class="form-group ">

                        <div class="col-xs-12">

                            <input class="form-control" type="text" required="" placeholder="Email">

                        </div>

                    </div>

                    <div class="form-group text-center m-t-20">

                        <div class="col-xs-12">

                            <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Reset</button>

                        </div>

                    </div>

                </form> -->

            </div>

        </div>

    </section>





    <!-- Modal Simpan -->

    <div id="modal-simpan" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <h4 class="modal-title">Register User Baru</h4>

                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                </div>

                <form id="tambahDataUser" method="POST" action="<?= base_url().'Auth/registerUser' ?>">

                    <div class="modal-body">



                        <input type="hidden" name="id_role" id="id_role" value="<?//= $id_role ?>">



                        <div class="form-group">

                            <label for="nama_user" class="control-label">Nama :</label>

                            <div class="controls">

                                <input required type="text" class="form-control" name="nama_user" id="nama_user" placeholder="Isi nama user" autocomplete="off">

                            </div>

                        </div>



                        <div class="form-group">

                            <label for="jk_user" class="control-label">Jenis Kelamin :</label>

                            <div class="controls">

                                <select id="jk_user" name="jk_user" class="form-control" required>

                                    <option value="" disabled selected>Pilih jenis kelamin</option>

                                    <option id="Laki-Laki" value="Laki-Laki">Laki-Laki</option>

                                    <option id="Perempuan" value="Perempuan">Perempuan</option>

                                </select>

                            </div>

                        </div>



                        <div class="form-group">

                            <label for="username" class="control-label">Username :</label>

                            <div class="controls">

                                <input required type="text" class="form-control" name="username" id="username" placeholder="Isi username untuk login" autocomplete="off">

                            </div>

                        </div>



                        <!-- <div class="form-group">

                            <label for="password" class="control-label">Password :</label>

                            <div class="controls">

                                <input required type="text" class="form-control" name="password" id="password" placeholder="Isi password untuk login" autocomplete="off">

                            </div>

                        </div> -->

                        <div class="form-group">
                            <label for="no_hp" class="control-label">Nomor HP :</label><br>
                            <div class="controls">
                                <input required type="text"  onkeypress="return inputAngka(event);" class="form-control" name="no_hp" id="no_hp" autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="control-label">Email :</label><br>
                            <div class="controls">
                                <input required type="text" class="form-control" name="email" id="email" autocomplete="off">
                            </div>
                        </div>



                        <!-- <div class="form-group">

                            <label for="role" class="control-label">Role :</label>

                            <div class="controls">

                                <select id="role" name="id_role" class="form-control">

                                    <?php //foreach ($data_role as $role) { ?>

                                        <option id="<?//= $role->id_role ?>" value="<?//=$role->id_role ?>"><?//=$role->role ?></option>

                                    <?php //} ?>

                                </select>

                            </div>

                        </div> -->



                        <div class="form-group">

                            <label for="alamat_user" class="control-label">Alamat :</label>

                            <textarea required class="form-control" name="alamat_user" id="alamat_user" autocomplete="off"></textarea>

                        </div>



                        <div class="alert alert-success alert-rounded" style="font-size: 11pt"> 

                            <i class="mdi mdi-key"></i> 

                            <span style="font-weight: bolder;">Password</span> akan dikirimkan melalui WA & email Anda. Pastikan nomor HP & email Anda aktif.

                            <!-- <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> -->

                        </div>

                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>

                        <button type="submit" class="btn btn-info waves-effect waves-light" id="simpan_user"><i class="mdi mdi-account-plus"></i> Daftar</button>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <!-- ============================================================== -->

    <!-- End Wrapper -->

    <!-- ============================================================== -->

    <!-- ============================================================== -->

    <!-- All Jquery -->

    <!-- ============================================================== -->

    <script src="<?= base_url() ?>assets/assets/plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap tether Core JavaScript -->

    <script src="<?= base_url() ?>assets/assets/plugins/bootstrap/js/popper.min.js"></script>

    <script src="<?= base_url() ?>assets/assets/plugins/bootstrap/js/bootstrap.min.js"></script>

    <!-- slimscrollbar scrollbar JavaScript -->

    <script src="<?= base_url() ?>assets/main/js/jquery.slimscroll.js"></script>

    <!--Wave Effects -->

    <script src="<?= base_url() ?>assets/main/js/waves.js"></script>

    <!--Menu sidebar -->

    <script src="<?= base_url() ?>assets/main/js/sidebarmenu.js"></script>

    <!--stickey kit -->

    <script src="<?= base_url() ?>assets/assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>

    <script src="<?= base_url() ?>assets/assets/plugins/sparkline/jquery.sparkline.min.js"></script>

    <!--Custom JavaScript -->

    <script src="<?= base_url() ?>assets/main/js/custom.min.js"></script>

    <!-- Sweet-Alert  -->

    <script src="<?= base_url() ?>assets/assets/plugins/sweetalert/sweetalert.min.js"></script>

    <script src="<?= base_url() ?>assets/assets/plugins/sweetalert/jquery.sweet-alert.custom.js"></script>



    <!-- ============================================================== -->

    <!-- Style switcher -->

    <!-- ============================================================== -->

    <script src="<?= base_url() ?>assets/assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>



    <!-- SIMPAN USER =========================================== -->

    <script type="text/javascript">

        function showModalAdd(argument) {

            $('#modal-simpan #tambahDataUser').trigger("reset");

            $('#modal-simpan').modal('show');

        }

    </script>

    <!-- ======================================================= -->

    <script src="<?= base_url() ?>assets/assets/js/auth_log.js"></script>
    <script src="<?= base_url() ?>assets/assets/js/block.js"></script>

</body>



</html>