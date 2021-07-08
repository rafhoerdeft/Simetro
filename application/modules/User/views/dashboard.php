
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor">Dashboard</h3>
                </div>
                <div class="col-md-7 align-self-center">
                   <!--  <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol> -->
                </div>
                <div>
                    <!-- <button class="right-side-toggle waves-effect waves-light btn-inverse btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button> -->
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->

                <div class="card-group">

                    <div class="card card-inverse card-info m-1">
                        <a href="<?= base_url().'User/dataUsaha' ?>">
                            <div class="card-body">
                                <div class="d-flex" style="margin-top: -10px; margin-bottom: -20px">
                                    <div class="m-r-20 align-self-center">
                                        <label style="font-size: 45pt;"><i class="mdi mdi-briefcase-check text-white"></i></label>
                                    </div>
                                    <div style="margin-top: 14px">
                                        <h3 class="card-title">
                                            <?= $jmlUsaha ?>
                                        </h3>
                                        <h5 class="card-subtitle text-white">Jumlah usaha yang dimiliki</h5></div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="card card-inverse card-warning m-1">
                        <a href="<?= base_url().'User/dataUttp' ?>">
                            <div class="card-body">
                                <div class="d-flex" style="margin-top: -10px; margin-bottom: -20px">
                                    <div class="m-r-20 align-self-center">
                                        <label style="font-size: 45pt;"><i class="mdi mdi-scale text-white"></i></label>
                                    </div>
                                    <div style="margin-top: 14px">
                                        <h3 class="card-title">
                                            <?= $jmlUttp ?>
                                        </h3>
                                        <h5 class="card-subtitle text-white">Jumlah UTTP yang dimiliki</h5></div>
                                </div>
                            </div>
                        </a>
                    </div>

                </div>

                <!-- ==================================================================== -->

                <span style="font-weight: bold;">Jumlah Pengajuan</span>
                <hr style="margin-top: 10px;">
                <div class="card-group">

                    <div class="card">
                        <a href="<?= base_url().'User/dataTera/pending' ?>">
                            <div class="card-body">
                                <div class="d-flex" style="margin-top: -10px; margin-bottom: -20px">
                                    <div class="m-r-10 align-self-center">
                                        <label style="font-size: 27pt;"><i class="mdi mdi-alert-circle text-inverse"></i></label>
                                    </div>
                                    <div style="margin-top: 5px">
                                        <h3 class="card-title">
                                            <?= $jmlPending ?>
                                        </h3>
                                        <h5 class="card-subtitle" style="font-size: 12pt; margin-top: -15px">Pending</h5></div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="card">
                        <a href="<?= base_url().'User/dataTera/diterima' ?>">
                            <div class="card-body">
                                <div class="d-flex" style="margin-top: -10px; margin-bottom: -20px">
                                    <div class="m-r-10 align-self-center">
                                        <label style="font-size: 27pt;"><i class="mdi mdi-send text-success"></i></label>
                                    </div>
                                    <div style="margin-top: 5px">
                                        <h3 class="card-title">
                                            <?= $jmlDiterima ?>
                                        </h3>
                                        <h5 class="card-subtitle" style="font-size: 12pt; margin-top: -15px">Diterima</h5></div>
                                </div>
                                <!-- <div class="row">
                                    <div class="col-12">
                                        <h2 class="m-b-0"><i class="mdi mdi-send text-success"></i></h2>
                                        <h3 class=""><?= $jmlDiterima ?></h3>
                                        <h6 class="card-subtitle">Pengajuan Diterima</h6>
                                    </div>
                                    <div class="col-12">
                                        <div class="progress">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 100%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                        </a>
                    </div>
                    
                    <div class="card">
                        <a href="<?= base_url().'User/dataTera/proses' ?>">
                            <div class="card-body">
                                <div class="d-flex" style="margin-top: -10px; margin-bottom: -20px">
                                    <div class="m-r-10 align-self-center">
                                        <label style="font-size: 27pt;"><i class="fa fa-gears text-info"></i></label>
                                    </div>
                                    <div style="margin-top: 5px">
                                        <h3 class="card-title">
                                            <?= $jmlDiproses ?>
                                        </h3>
                                        <h5 class="card-subtitle" style="font-size: 12pt; margin-top: -15px">Diproses</h5></div>
                                </div>
                                <!-- <div class="row">
                                    <div class="col-12">
                                        <h2 class="m-b-0"><i class="fa fa-gears text-info"></i></h2>
                                        <h3 class=""><?= $jmlDiproses ?></h3>
                                        <h6 class="card-subtitle">Pengajuan Diproses</h6>
                                    </div>
                                    <div class="col-12">
                                        <div class="progress">
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: 100%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                        </a>
                    </div>

                    <div class="card">
                        <a href="<?= base_url().'User/dataTera/ditolak' ?>">
                            <div class="card-body">
                                <div class="d-flex" style="margin-top: -10px; margin-bottom: -20px">
                                    <div class="m-r-10 align-self-center">
                                        <label style="font-size: 27pt;"><i class="mdi mdi-close-octagon text-danger"></i></label>
                                    </div>
                                    <div style="margin-top: 5px">
                                        <h3 class="card-title">
                                            <?= $jmlTolak ?>
                                        </h3>
                                        <h5 class="card-subtitle" style="font-size: 12pt; margin-top: -15px">Ditolak</h5></div>
                                </div>
                                <!-- <div class="row">
                                    <div class="col-12">
                                        <h2 class="m-b-0"><i class="mdi mdi-close-octagon text-danger"></i></h2>
                                        <h3 class=""><?= $jmlTolak ?></h3>
                                        <h6 class="card-subtitle">Pengajuan Ditolak</h6>
                                    </div>
                                    <div class="col-12">
                                        <div class="progress">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: 100%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                        </a>
                    </div>
                    
                    <div class="card">
                        <a href="<?= base_url().'User/dataTera/selesai' ?>">
                            <div class="card-body">
                                <div class="d-flex" style="margin-top: -10px; margin-bottom: -20px">
                                    <div class="m-r-10 align-self-center">
                                        <label style="font-size: 27pt;"><i class="mdi mdi-checkbox-multiple-marked-circle text-warning"></i></label>
                                    </div>
                                    <div style="margin-top: 5px">
                                        <h3 class="card-title">
                                            <?= $jmlSelesai ?>
                                        </h3>
                                        <h5 class="card-subtitle" style="font-size: 12pt; margin-top: -15px">Selesai</h5></div>
                                </div>
                                <!-- <div class="row">
                                    <div class="col-12">
                                        <h2 class="m-b-0"><i class="mdi mdi-checkbox-multiple-marked-circle text-warning"></i></h2>
                                        <h3 class=""><?= $jmlSelesai ?></h3>
                                        <h6 class="card-subtitle">Pengajuan Selesai</h6>
                                    </div>
                                    <div class="col-12">
                                        <div class="progress">
                                            <div class="progress-bar bg-warning" role="progressbar" style="width: 100%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                        </a>
                    </div>
                    <!-- Column -->
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
               <!--  <div class="right-sidebar">
                    <div class="slimscrollright">
                        <div class="rpanel-title"> Service Panel <span><i class="ti-close right-side-toggle"></i></span> </div>
                        <div class="r-panel-body">
                            <ul id="themecolors" class="m-t-20">
                                <li><b>With Light sidebar</b></li>
                                <li><a href="javascript:void(0)" data-theme="default" class="default-theme">1</a></li>
                                <li><a href="javascript:void(0)" data-theme="green" class="green-theme">2</a></li>
                                <li><a href="javascript:void(0)" data-theme="red" class="red-theme">3</a></li>
                                <li><a href="javascript:void(0)" data-theme="blue" class="blue-theme working">4</a></li>
                                <li><a href="javascript:void(0)" data-theme="purple" class="purple-theme">5</a></li>
                                <li><a href="javascript:void(0)" data-theme="megna" class="megna-theme">6</a></li>
                                <li class="d-block m-t-30"><b>With Dark sidebar</b></li>
                                <li><a href="javascript:void(0)" data-theme="default-dark" class="default-dark-theme">7</a></li>
                                <li><a href="javascript:void(0)" data-theme="green-dark" class="green-dark-theme">8</a></li>
                                <li><a href="javascript:void(0)" data-theme="red-dark" class="red-dark-theme">9</a></li>
                                <li><a href="javascript:void(0)" data-theme="blue-dark" class="blue-dark-theme">10</a></li>
                                <li><a href="javascript:void(0)" data-theme="purple-dark" class="purple-dark-theme">11</a></li>
                                <li><a href="javascript:void(0)" data-theme="megna-dark" class="megna-dark-theme ">12</a></li>
                            </ul>
                            <ul class="m-t-20 chatonline">
                                <li><b>Chat option</b></li>
                                <li>
                                    <a href="javascript:void(0)"><img src="<?//= base_url() ?>assets/assets/images/users/1.jpg" alt="user-img" class="img-circle"> <span>Varun Dhavan <small class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="<?//= base_url() ?>assets/assets/images/users/2.jpg" alt="user-img" class="img-circle"> <span>Genelia Deshmukh <small class="text-warning">Away</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="<?//= base_url() ?>assets/assets/images/users/3.jpg" alt="user-img" class="img-circle"> <span>Ritesh Deshmukh <small class="text-danger">Busy</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="<?//= base_url() ?>assets/assets/images/users/4.jpg" alt="user-img" class="img-circle"> <span>Arijit Sinh <small class="text-muted">Offline</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="<?//= base_url() ?>assets/assets/images/users/5.jpg" alt="user-img" class="img-circle"> <span>Govinda Star <small class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="<?//= base_url() ?>assets/assets/images/users/6.jpg" alt="user-img" class="img-circle"> <span>John Abraham<small class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="<?//= base_url() ?>assets/assets/images/users/7.jpg" alt="user-img" class="img-circle"> <span>Hritik Roshan<small class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="<?//= base_url() ?>assets/assets/images/users/8.jpg" alt="user-img" class="img-circle"> <span>Pwandeep rajan <small class="text-success">online</small></span></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div> -->
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            