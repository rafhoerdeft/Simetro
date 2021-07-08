
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

                <?php 
                    $nama_bulan = array(
                        1 =>'Januari', 
                        2 =>'Februari', 
                        3 =>'Maret', 
                        4 =>'April', 
                        5 =>'Mei', 
                        6 =>'Juni', 
                        7 =>'Juli', 
                        8 =>'Agustus', 
                        9 =>'September', 
                        10 =>'Oktober', 
                        11 =>'November', 
                        12 =>'Desember'
                    );

                    // if ($showGrafik == 'true') {
                    if ($data_lap != 'Kosong'){
                        $lapPerBulan = array();
                        
                        foreach ($nama_bulan as $row => $value) {
                            $tot = 0;
                            foreach ($data_lap as $key) {
                                if ($key->bulan == $row) {
                                    $tot = (int)$key->jml_lap;
                                }
                            }
                            $lapPerBulan[] = array(
                              "name" => $value,
                              "y" => $tot,
                              "drilldown" => $row
                            );
                        }

                        $lapPerMinggu = array();
                        foreach ($lapPerBulan as $row) {
                            $dataLaporan = array();
                            $minggu = 1;
                            $bln = 0;
                            foreach ($lap_per_minggu as $key) {
                                if ($row['drilldown'] == $key->bulan) {
                                    $dataLaporan[] = array(
                                        'Minggu '.$key->minggu,
                                        (int)$key->jml_lap
                                    );
                                    $bln++;
                                }
                            }

                            if ($bln == 0) {
                                $lapPerMinggu[] = array(
                                    "name" => $row['name'],
                                    "id" => $row['drilldown'],
                                    "data" => array(array('Data Kosong', 0))
                                );
                            }else{
                                $lapPerMinggu[] = array(
                                    "name" => $row['name'],
                                    "id" => $row['drilldown'],
                                    "data" => $dataLaporan
                                );
                            }
                        }
                    }else{
                        $lapPerBulan = '';
                    }
                    // var_dump(json_encode($lapPerBulan));
                    // echo "<br>";
                    // var_dump(json_encode($lapPerMinggu)); exit();
                    // }
                ?>

                <div class="card-group">

                    <div class="card card-inverse card-info m-1">
                        <a href="<?= base_url().'Petugas/dataUser' ?>">
                            <div class="card-body">
                                <div class="d-flex" style="margin-top: -10px; margin-bottom: -20px">
                                    <div class="m-r-20 align-self-center">
                                        <label style="font-size: 45pt;"><i class="mdi mdi-account-circle text-white"></i></label>
                                    </div>
                                    <div style="margin-top: 14px">
                                        <h3 class="card-title">
                                            <?= $jmlUser ?>
                                        </h3>
                                        <h5 class="card-subtitle text-white">Jumlah Pemilik Usaha Terdaftar</h5></div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="card card-inverse card-warning m-1">
                        <a href="<?= base_url().'Petugas/dataPetugas' ?>">
                            <div class="card-body">
                                <div class="d-flex" style="margin-top: -10px; margin-bottom: -20px">
                                    <div class="m-r-20 align-self-center">
                                        <label style="font-size: 45pt;"><i class="mdi mdi-account-card-details text-white"></i></label>
                                    </div>
                                    <div style="margin-top: 14px">
                                        <h3 class="card-title">
                                            <?= $jmlPetugas ?>
                                        </h3>
                                        <h5 class="card-subtitle text-white">Jumlah Petugas Terdaftar</h5></div>
                                </div>
                            </div>
                        </a>
                    </div>

                </div>

                <!-- ==================================================================== -->

                <div class="card-group">

                    <div class="card">
                        <!-- <a href="<?= base_url().'Petugas/dataTera/belumkirim' ?>"> -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <h2 class="m-b-0"><i class="mdi mdi-login-variant text-info"></i></h2>
                                        <h3 class=""><?= $lap_harian ?></h3>
                                        <h6 class="card-subtitle">Pengajuan Masuk Hari Ini</h6>
                                    </div>
                                    <div class="col-12">
                                        <div class="progress">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: 100%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <!-- </a> -->
                    </div>

                    <!-- Column -->
                    <!-- Column -->
                    <div class="card">
                        <!-- <a href="<?= base_url().'Petugas/dataTera/diterima' ?>"> -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <h2 class="m-b-0"><i class="mdi mdi-login-variant text-success"></i></h2>
                                        <h3 class=""><?= $lap_mingguan ?></h3>
                                        <h6 class="card-subtitle">Pengajuan Masuk Minggu Ini</h6></div>
                                    <div class="col-12">
                                        <div class="progress">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 100%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <!-- </a> -->
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="card">
                        <!-- <a href="<?= base_url().'Petugas/dataTera/proses' ?>"> -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <h2 class="m-b-0"><i class="mdi mdi-login-variant text-danger"></i></h2>
                                        <h3 class=""><?= $lap_bulanan ?></h3>
                                        <h6 class="card-subtitle">Pengajuan Masuk Bulan Ini</h6></div>
                                    <div class="col-12">
                                        <div class="progress">
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: 100%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <!-- </a> -->
                    </div>
                    <!-- Column -->
                    <div class="card">
                        <!-- <a href="<?= base_url().'Petugas/dataTera/selesai' ?>"> -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <h2 class="m-b-0"><i class="mdi mdi-login-variant text-warning"></i></h2>
                                        <h3 class=""><?= $lap_tahunan ?></h3>
                                        <h6 class="card-subtitle">Pengajuan Masuk Tahun Ini</h6></div>
                                    <div class="col-12">
                                        <div class="progress">
                                            <div class="progress-bar bg-warning" role="progressbar" style="width: 100%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <!-- </a> -->
                    </div>
                    <!-- Column -->
                </div>

                <div class="card">
                    <!-- <div class="card-body"> -->
                        <!-- <div class="card product-report"> -->
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-lg-8 col-md-12 col-sm-12">
                                        <h3>Jumlah Pengajuan Tera/Tera Ulang Tahun <?=$tahun ?></h3>
                                    </div>
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <form method="GET" action="<?= base_url().'Petugas/index' ?>">
                                            <div class="row">
                                                <div class="col-lg-8 col-md-8 col-sm-8" >
                                                     <select name="tahun" class="form-control show-tick m-b-5">
                                                        <option value="" disabled selected>Pilih Tahun</option>
                                                        <?php foreach ($data_thn as $key) { ?>
                                                            <option <?= ($key->thn==$tahun?'selected':'') ?> value="<?= $key->thn ?>"><?= $key->thn ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4">
                                                    <button type="submit" class="btn btn-block btn-primary waves-effect" style="height: 38px;">Tampil</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- <ul class="header-dropdown m-r--5">
                                    <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more-vert"></i> </a>
                                        <ul class="dropdown-menu pull-right">
                                            <li><a href="javascript:void(0);">Action</a></li>
                                            <li><a href="javascript:void(0);">Another action</a></li>
                                            <li><a href="javascript:void(0);">Something else here</a></li>
                                        </ul>
                                    </li>
                                </ul> -->
                            </div>
                            <div class="card-body">
                                <div class="row clearfix m-b-15">
                                    <div class="col-lg-8 col-md-12 col-sm-12">
                                        <?php if ($lapPerBulan != '') { ?>
                                            <div id="chart-bar-laporan" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                                        <?php }else{ ?>
                                            <h3 align="center">Data Grafik Kosong</h3>
                                        <?php } ?>
                                    </div>
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <div class="table-responsive" style="height: 400px">
                                            <!-- <p>Contrary to popular belief, Lorem Ipsum is not simply random text</p> -->
                                            <!-- <table class="table table-hover js-exportable"> -->
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Bulan</th>
                                                        <th>Jumlah</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                        if ($lapPerBulan != '') {
                                                           foreach ($lapPerBulan as $key) {
                                                     ?>
                                                            <tr>
                                                                <td><?= $key['name'] ?></td>
                                                                <td><?= $key['y'] ?></td>
                                                            </tr>
                                                    <?php }}else{ ?> 
                                                            <tr align="center">
                                                                <td colspan="2"><b>Data Kosong</b></td>
                                                            </tr> 
                                                    <?php } ?>                                                                    
                                                </tbody>
                                            </table>                                    
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <!-- </div> -->
                    <!-- </div> -->
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
            
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>

<script type="text/javascript">
    // var show = "<?//= $showGrafik ?>";
    // if (show == 'true') {
    showGrafik();
    // }
    function showGrafik() {
      Highcharts.chart('chart-bar-laporan', {
        chart: {
          type: 'column'
        },
        title: {
          text: "Grafik Jumlah Pengajuan Masuk"
          // text: ""
        },
        subtitle: {
          text: ''
        },
        xAxis: {
          type: 'category'
        },
        yAxis: {
          title: {
            text: 'Total Laporan'
          }

        },
        credits: 'false',
        legend: {
          enabled: false
        },
        plotOptions: {
          series: {
            borderWidth: 0,
            dataLabels: {
              enabled: true,
              format: '{point.y}'
            }
          }
        },

        tooltip: {
          headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
          pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>'
        },

        series: [
          {
            "name": "Laporan Masuk Per Bulan",
            "colorByPoint": true,
            "data": <?= json_encode($lapPerBulan) ?>
          }
        ],
        drilldown: {
          "series": <?= json_encode($lapPerMinggu) ?>
        }
      });
    }
</script>