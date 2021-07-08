        <!-- <div style="width: 100%; height: 100%; z-index: 15; background: red"> -->
            <div style="z-index: 20; top: 40%; left: 47%; position: fixed; display:none;" id="loading-show">
                <img src="<?= base_url().'assets/loading/loading3.gif' ?>" width="100">
            </div>   
        <!-- </div>    -->
    
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="row page-titles">
                <div class="col-md-6 align-self-center">
                    <h3 class="text-themecolor">Perlengkapan Jalan</h3>
                </div>

                <div class="col-md-6 align-self-center">
                    <ol class="breadcrumb">
                        <!-- <label>Jenis Perlengkapan</label> -->
                        <li class="breadcrumb-item active">Perlengkapan Jalan</li>
                    </ol>
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

                <?= $this->session->flashdata('alert') ?>

                <div class="row">
                    <div id="loading" class="col-md-12" style="margin-bottom: -25px; margin-top: -50px; text-align: center; display:none;">
                        <img src="<?= base_url().'assets/loading/loading1.gif' ?>" width="100" >
                    </div>
                </div>

                <style type="text/css">
                    a[href^="http://maps.google.com/maps"]{display:none !important}
                    a[href^="https://maps.google.com/maps"]{display:none !important}

                    /*Google Credit*/
                    .gmnoprint a, .gmnoprint span, .gm-style-cc {
                        display:none;
                    }

                    /*Style InfoWindow*/
                    .gm-style-iw {
                      min-width: 150px; 
                      max-width: 300px;
                    }
                    /*.gmnoprint div {
                        background:none !important;
                    }*/
                </style>

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                
                            </div>
                            <div class="col-md-4">
                                <select id="jenisPj" class="form-control" onchange="changeJenisPj();">
                                    <!-- <option disabled=''>Pilih Jenis Perlengkapan</option> -->
                                    <?php foreach ($jenisPj as $pj) { ?>
                                        <option value="<?= encode($pj->id_jenis) ?>" <?= ($pj->id_jenis == $idSelectPj?'selected':'') ?>><?= $pj->nama_jenis ?></option>
                                    <?php } ?> 
                                </select>
                            </div>
                        </div>
                        
                    </div>
                </div>

                <div class="card">
                    <div class="card-body p-b-0">

                        <ul class="nav nav-tabs customtab" role="tablist">
                            <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#map" role="tab"><span class="hidden-sm-up"><i class="ti-map-alt"></i></span> <span class="hidden-xs-down">Peta</span></a> </li>
                            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#table" role="tab"><span class="hidden-sm-up"><i class="mdi mdi-table"></i></span> <span class="hidden-xs-down">Tabel</span></a> </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane active p-b-20 p-t-20" id="map" role="tabpanel">

                                <div style="z-index: 2; position: absolute; margin-top: 420px; margin-left: 12px;">
                                    <img src="<?= base_url().'assets/assets/images/logo/dishub-logo-sm.png' ?>" width='35'>
                                    <!-- <label>DISHUB</label> -->
                                </div>
                                
                                <div id="map-canvas" style="height:470px;"></div>
                                
                            </div>

                            <div class="tab-pane  p-20" id="table" role="tabpanel">

                                <div class="table-responsive">
                                    <table id="myTable" class="table table-bordered table-striped table-hover">

                                        <thead>
                                            <tr style="font-size: 11pt">
                                                <th>#</th>
                                                <th>Nama</th>
                                                <th>Tahun</th>
                                                <th>Kecamatan</th>
                                                <th>Ruas Jalan</th>
                                                <?php if ($idSelectPj == '1') { ?>
                                                    <th>Jenis Lampu</th>
                                                <?php } else if ($idSelectPj == '3') {?>
                                                    <th>Jenis Rambu</th>
                                                <?php } else if ($idSelectPj == '4') {?>
                                                    <th>Panjang (M)</th>
                                                <?php } else if ($idSelectPj == '5') {?>
                                                    <th>Lebar Jalan (M)</th>
                                                <?php } else if ($idSelectPj == '7') {?>
                                                    <th>KWH Meter</th>
                                                    <th>Abonemen</th>
                                                <?php } ?>
                                                <th>Kondisi</th>
                                                <th>Foto</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $no = 0;
                                                foreach ($dataPj as $pj) { 
                                                    $no++;
                                            ?>
                                                    <tr style="font-size: 10pt">
                                                        <td align="center"><?= $no ?></td>
                                                        <td><?= $pj->nama_pj ?></td>
                                                        <td align="center"><?= $pj->thn_pj ?></td>
                                                        <td align="center"><?= $pj->kecamatan ?></td>
                                                        <td><?= $pj->nama_jalan ?></td>

                                                        <?php if ($idSelectPj == '1') { ?>
                                                            <td align="center"><?= $pj->jenis_lampu ?></td>
                                                        <?php } else if ($idSelectPj == '3') {?>
                                                            <td align="center"><?= $pj->jenis_rambu ?></td>
                                                        <?php } else if ($idSelectPj == '4') {?>
                                                            <td align="center"><?= $pj->pjg_guardrail ?></td>
                                                        <?php } else if ($idSelectPj == '5') {?>
                                                            <td align="center"><?= $pj->lebar_jalan ?></td>
                                                        <?php } else if ($idSelectPj == '7') {?>
                                                            <td align="center"><?= $pj->kwh_meter ?></td>
                                                            <td align="center"><?= $pj->abonemen ?></td>
                                                        <?php } ?>
                                                        
                                                        <td align="center"><?= $pj->kondisi_pj ?></td>
                                                        <td align="center">
                                                            <?php  
                                                                $photo = explode(';', $pj->foto_pj);
                                                                $i = 0;
                                                                foreach ($photo as $x) { 
                                                                    $i++;
                                                            ?>
                                                                    <a href="<?= base_url().'assets/path_foto/'.$x ?>" data-lightbox="<?= $pj->id_pj ?>" data-toggle="lightbox" data-gallery="gallery"><button style="width: 60px;" type="button" class="btn btn-sm waves-effect waves-light btn-primary m-b-5"  title="Foto <?= $i; ?>"><i class="fa fa-picture-o"></i> Pic <?= $i; ?></button></a>
                                                                    <br>
                                                            <?php } ?>
                                                        </td>
                                                        <td width="125">
                                                            <a style="width: 30px" href="<?=base_url('Petugas/riwayatPj/').encode($pj->id_pj).'/'.encode($idSelectPj);?>" class="btn btn-sm waves-effect waves-light btn-success m-b-5"  title="Riwayat Perbaikan"><i class="fa fa-history"></i></a>

                                                            <button style="width: 30px" type="button" onclick="showModalEdit('<?= $idSelectPj ?>','<?= $pj->id_pj ?>')" class="btn btn-sm waves-effect waves-light btn-info m-b-5"  title="Edit Data"><i class="fa fa-pencil-square-o"></i></button>

                                                            <button style="width: 30px" type="button" onclick="showConfirmMessage('<?= $idSelectPj ?>','<?= $pj->id_pj ?>')" class="btn btn-sm waves-effect waves-light btn-danger m-b-5"  title="Hapus Data"><i class="fa fa-trash-o"></i></button>
                                                        </td>
                                                    </tr>
                                            <?php } ?>
                                        </tbody>

                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Modal Edit -->
            <div id="modal-edit" class="modal fade" role="dialog" aria-labelledby="myModalLabels" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Update Perlengkapan Jalan</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <form id="updatePj" method="POST" action="<?= base_url().'Petugas/updatePj' ?>" enctype="multipart/form-data">
                            <div class="modal-body">

                                <input type="hidden" name="id_jenis_pj" id="id_jenis_pj">
                                <input type="hidden" name="id_pj" id="id_pj">

                                <div class="form-group">
                                    <label for="nama_pj" class="control-label">Nama Perlengkapan Jalan:</label>
                                    <div class="controls">
                                        <input required data-validation-required-message="Nama perlengkapan jalan harus diisi" type="text" class="form-control" name="nama_pj" id="nama_pj">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="thn_pj" class="control-label">Tahun Pembangunan:</label>
                                    <div class="controls">
                                        <select id="thn_pj" name="thn_pj" class="select2 form-control custom-select" style="width: 100%; height:36px;">
                                            <?php 
                                            $yearNow = date('Y');
                                            for ($i=0; $i <= 50; $i++) { ?>
                                                <option id="<?= $yearNow - $i ?>" value="<?= $yearNow - $i ?>" ><?= $yearNow - $i ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <?php if ($idSelectPj == 1) { ?>

                                    <div class="form-group">
                                        <label for="jenis_lampu" class="control-label">Jenis Lampu:</label>
                                        <div class="controls">
                                            <select id="jenis_lampu" class="form-control" name="id_jenis_lampu">
                                                <?php foreach ($jenis_lampu as $jns) { ?>
                                                    <option id="<?= $jns->id_jenis_lampu ?>" value="<?= $jns->id_jenis_lampu ?>"><?= $jns->jenis_lampu ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                <?php } else if ($idSelectPj == 3) {?>

                                    <div class="form-group">
                                        <label for="jenis_rambu" class="control-label">Jenis Rambu:</label>
                                        <div class="controls">
                                            <select id="jenis_rambu" class="form-control" name="id_jenis_rambu">
                                                <?php foreach ($jenis_rambu as $jns) { ?>
                                                    <option id="<?= $jns->id_jenis_rambu ?>" value="<?= $jns->id_jenis_rambu ?>"><?= $jns->jenis_rambu ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                <?php } else if ($idSelectPj == 4) {?>

                                    <div class="form-group">
                                        <label for="pjg_guardrail" class="control-label">Panjang Guardrail:</label><br>
                                        <div class="controls">
                                            <input required data-validation-required-message="Panjang guardrail harus diisi" type="text"  onkeypress="return inputAngka(event);" class="form-control" name="pjg_guardrail" id="pjg_guardrail" style="width: 85%"> Meter
                                        </div>
                                    </div>

                                <?php } else if ($idSelectPj == 5) {?>

                                    <div class="form-group">
                                        <label for="lebar_jalan" class="control-label">Lebar Jalan:</label><br>
                                        <div class="controls">
                                            <input required data-validation-required-message="Lebar jalan harus diisi" type="text"  onkeypress="return inputAngka(event);" class="form-control" name="lebar_jalan" id="lebar_jalan" style="width: 85%"> Meter
                                        </div>
                                    </div>

                                <?php } else if ($idSelectPj == 7) {?>

                                    <div class="form-group">
                                        <label for="kwh_meter" class="control-label">KWH Meter:</label><br>
                                        <div class="controls">
                                            <input required data-validation-required-message="KWH meter harus diisi" type="text"  onkeypress="return inputAngka(event);" class="form-control" name="kwh_meter" id="kwh_meter">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="abonemen" class="control-label">Abonemen:</label>
                                        <div class="controls">
                                            <input required data-validation-required-message="Abonemen harus diisi" type="text" class="form-control" name="abonemen" id="abonemen">
                                        </div>
                                    </div>

                                <?php } ?>

                                <div class="form-group">
                                    <label for="kecamatan" class="control-label">Kecamatan:</label>
                                    <div class="controls">
                                        <select id="kecamatan" name="kode_kecamatan" class="select2 form-control custom-select" style="width: 100%; height:36px;">
                                            <?php foreach ($dataKec as $kec) { ?>
                                                <option id="<?= $kec->kode_kecamatan ?>" value="<?= $kec->kode_kecamatan ?>"><?= $kec->nama_kecamatan ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="ruas_jalan" class="control-label">Ruas Jalan:</label>
                                    <div class="controls">
                                        <select id="ruas_jalan" name="id_jalan" class="select2 form-control custom-select" style="width: 100%; height:36px;">
                                            <?php foreach ($dataRuasJln as $jln) { ?>
                                                <option id="<?= $jln->id_jalan ?>" value="<?= $jln->id_jalan ?>"><?= $jln->nama_jalan ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="kondisi_pj" class="control-label">Kondisi:</label>
                                    <div class="controls">
                                        <select id="kondisi_pj" name="kondisi_pj" class="form-control">
                                            <option id="Baik" value="Baik">Baik</option>
                                            <option id="Rusak" value="Rusak">Rusak</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div id="photo">
                                        <label>Foto</label><br>
                                    </div>
                                </div>

                                <div id="upload_file"></div>    

                                <div class="form-group">                          
                                    <button type="button" onclick="addfoto()" class="btn btn-sm waves-effect waves-light btn-info"><i class="fa fa-plus"></i> Tambah Foto</button>
                                </div>

                                

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-danger waves-effect waves-light" id="update_jalan">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->

            <script type="text/javascript">
                var piclength ;
                var countPic = 0;
                var markerCluster;
                var map;
                var markers = [];
                var mapClick;
                function initMap(argument) {
                   var mapOptions = {
                      center: {
                        lat: -7.5011538,
                        lng: 110.2676056
                      },
                      zoom: 11,
                      maxZoom: 18,
                      mapTypeId: google.maps.MapTypeId.ROADMAP,
                      mapTypeControl: false,
                      streetViewControl: true,
                      fullscreenControl: true
                    };

                    map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);    

                    showMarker();
                    linesArea();
                }


                function makeMarker(pos, icon, name, pic, kondisi) {
                    // var icon = { // car icon
                    //     // path: 'M29.395,0H17.636c-3.117,0-5.643,3.467-5.643,6.584v34.804c0,3.116,2.526,5.644,5.643,5.644h11.759   c3.116,0,5.644-2.527,5.644-5.644V6.584C35.037,3.467,32.511,0,29.395,0z M34.05,14.188v11.665l-2.729,0.351v-4.806L34.05,14.188z    M32.618,10.773c-1.016,3.9-2.219,8.51-2.219,8.51H16.631l-2.222-8.51C14.41,10.773,23.293,7.755,32.618,10.773z M15.741,21.713   v4.492l-2.73-0.349V14.502L15.741,21.713z M13.011,37.938V27.579l2.73,0.343v8.196L13.011,37.938z M14.568,40.882l2.218-3.336   h13.771l2.219,3.336H14.568z M31.321,35.805v-7.872l2.729-0.355v10.048L31.321,35.805',
                    //     url: "<?//= base_url().'assets/icon/marker/' ?>"+icon+'.svg',
                    //     scale: 0.4,
                    //     fillColor: "#427af4", //<-- Car Color, you can change it 
                    //     fillOpacity: 1,
                    //     strokeWeight: 1,
                    //     anchor: new google.maps.Point(0, 5),
                    //     rotation: data.val().angle //<-- Car angle
                    // };

                    var marker = new google.maps.Marker({
                      // position: pos,
                      position: pos,
                      map: map,
                      animation: google.maps.Animation.DROP,
                      icon: "<?= base_url().'assets/icon/marker/' ?>"+icon+'.png',
                      title: "I'm Here."
                    });                    

                    markers.push(marker);

                    var sts = '';
                    if (kondisi == 'Rusak') {
                        sts = 'red';
                    } else {
                        sts = 'green';
                    }
                    var contentInfo = "<label style='font-size: 12pt; font-weight: bold'>"+name+"</label><br><label>Kondisi: <span style='color:"+sts+"; font-weight: bold'>"+kondisi+"</span></label><div id='picMarker'></div>";
                    
                    var photo = pic.split(';');
                    countPic++;
                    for(i=0; i < photo.length; i++){
                        var no = i + 1;
                        contentInfo += "<a href='<?= base_url().'assets/path_foto/' ?>"+photo[i]+"' data-lightbox='data"+countPic+"' data-toggle='lightbox' data-gallery='gallery'><button style='width: 100%;' type='button' class='btn btn-sm waves-effect waves-light btn-primary m-b-5' data-toggle='tooltip' data-placement='top' title='Foto 1'><i class='fa fa-picture-o'></i> Pic "+no+"</button></a><br>";
                    }

                    var infoWindow = new google.maps.InfoWindow({
                      content: contentInfo
                      // maxWidth: 300
                    });
                    // infoWindow.setPosition(pos);
                    // infoWindow.setContent('Location here.');

                    marker.addListener('click', function(){
                      infoWindow.open(map, marker);
                    });
                }

                function addMarker(lat, lng, name, icon, pic, kondisi) {
                    var pos = new google.maps.LatLng(lat, lng);
                    makeMarker(pos, icon, name, pic, kondisi);
                }

                // SHOW LINE ========================================

                function makeLinesArea(coords, color) {
                    // var coords = [
                    //   {lat: 37.772, lng: -122.214},
                    //   {lat: 21.291, lng: -157.821},
                    //   {lat: -18.142, lng: 178.431},
                    //   {lat: -27.467, lng: 153.027}
                    // ];

                    var lines2 = new google.maps.Polyline({
                      path: coords,
                      geodesic: true,
                      strokeColor: color,
                      strokeOpacity: 1.0,
                      strokeWeight: 3
                    });

                    lines2.setMap(map);

                }

                function linesArea(argument) {
                    $.getJSON("<?= base_url().'assets/line_area/line_kab_mgl.json' ?>", function(data) {
                        // console.log(json); // this will show the info it in firebug console
                        for (var i = 0; i < data.length ; i++) {

                            var koords = data[i];
                            var colors = '#000';

                            makeLinesArea(koords, colors);
                        }   
                    });
                }
                // ===================================================

            </script>


            <script type="text/javascript">
                function changeJenisPj() {
                    var id = $('#jenisPj option:selected').attr('value');
                    window.location = "<?= base_url().'Petugas/perlengkapanJalan/' ?>" + id;
                }

                function showMarker() {

                    var dt = <?= $dataCoord ?>; 
                    // console.log('Data Coord: ',dt);
                    if (dt != null) {

                        for (var i = 0; i < dt.length ; i++) {
                            var icon = dt[i].icon;
                            var name = dt[i].nama_pj;
                            var lat  = dt[i].lat;
                            var lng  = dt[i].lng;
                            var pic  = dt[i].pic;
                            var kondisi  = dt[i].kondisi_pj;

                            addMarker(lat, lng, name, icon, pic, kondisi);
                        }

                        markerCluster = new MarkerClusterer(map, markers, {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
                    }
                }
            </script>


            <script async defer  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDcBM8hFljWAtmwZC82_bMjtiI169z_n7k&callback=initMap" type="text/javascript"></script>
            <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
            <!-- <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?libraries=geometry&sensor=false"></script> -->

            <!-- Fungsi Dialog -->
            <script type="text/javascript">
                //These codes takes from http://t4t5.github.io/sweetalert/
                function showBasicMessage() {
                    swal("Here's a message!");
                }

                function showWithTitleMessage() {
                    swal("Here's a message!", "It's pretty, isn't it?");
                }

                function validasiMessage(text){
                    swal({
                        title: "Dilarang!",
                        text: text,
                        type: "error",
                        timer: 1000,
                        showConfirmButton: false
                    });
                }

                function showSuccessMessage(input) {
                    swal({
                        title: input+"!",
                        text: "Data Berhasil "+input+"!",
                        type: "success",
                        timer: 1000,
                        showConfirmButton: false
                    });
                }

                function showFailedMessage(input) {
                    swal({
                        title: "Gagal!",
                        text: input,
                        type: "error",
                        timer: 1000,
                        showConfirmButton: false
                    });
                }

                function showCancelMessage() {
                    swal({
                        title: "Are you sure?",
                        text: "You will not be able to recover this imaginary file!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Yes, delete it!",
                        cancelButtonText: "No, cancel plx!",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    }, function (isConfirm) {
                        if (isConfirm) {
                            swal("Deleted!", "Your imaginary file has been deleted.", "success");
                        } else {
                            swal("Cancelled", "Your imaginary file is safe :)", "error");
                        }
                    });
                }
            </script>


            <!-- UPDATE PERLENGKAPAN JALAN =========================================== -->
            <script type="text/javascript">

                function showModalEdit(id_jenis_pj='', id_pj='') {
                    // alert(id_jenis_pj+" - "+id_pj);

                    $("#loading-show").fadeIn("slow");

                    $.post("<?= base_url().'Petugas/getDataEditPj' ?>", {id_jenis_pj:id_jenis_pj, id_pj:id_pj}, function(result){
                        $("#loading-show").fadeIn("slow").delay(300).slideUp('slow');

                        var dt = JSON.parse(result);
                        console.log(dt.data);
                        if (dt.response) {
                            for (var i = 0; i < dt.data.length; i++) {
                                $('#modal-edit #id_jenis_pj').val(id_jenis_pj);    
                                $('#modal-edit #id_pj').val(dt.data[i].id_pj);    
                                $('#modal-edit #nama_pj').val(dt.data[i].nama_pj);    
                                $('#modal-edit #thn_pj').val(dt.data[i].thn_pj).trigger('change.select2');

                                if (id_jenis_pj == '1') {
                                    $('#modal-edit #jenis_lampu').val(dt.data[i].id_jenis_lampu).prop('selected', true);
                                } else if (id_jenis_pj == '3') {
                                    $('#modal-edit #jenis_rambu').val(dt.data[i].id_jenis_rambu).prop('selected', true);
                                } else if (id_jenis_pj == '4') {
                                    $('#modal-edit #pjg_guardrail').val(dt.data[i].pjg_guardrail);    
                                } else if (id_jenis_pj == '5') {
                                    $('#modal-edit #lebar_jalan').val(dt.data[i].lebar_jalan);
                                } else if (id_jenis_pj == '7') {
                                    $('#modal-edit #kwh_meter').val(dt.data[i].kwh_meter); 
                                    $('#modal-edit #abonemen').val(dt.data[i].abonemen); 
                                }

                                $('#modal-edit #kecamatan').val(dt.data[i].kode_kecamatan).trigger('change.select2');
                                $('#modal-edit #ruas_jalan').val(dt.data[i].id_jalan).trigger('change.select2');
                                $('#modal-edit #kondisi_pj').val(dt.data[i].kondisi_pj).prop('selected', true);

                                $('#photo').empty();
                                $('#upload_file').empty();
                                var pict = dt.data[i].foto_pj;
                                var pic = pict.split(';');
                                var no = 0;
                                piclength = pic.length;
                                for(var j = 0; j<pic.length; j++){
                                    no++;
                                    $('#photo').append(
                                        '<div class="form-group" id="foto-'+pic[j]+'">'+
                                            '<a href="<?= base_url()?>assets/path_foto/'+pic[j]+'" data-lightbox='+dt.data[i].id_jenis_pj+' data-toggle="lightbox" data-gallery="gallery">'+
                                                    '<img src="<?= base_url().'assets/path_foto/' ?>'+pic[j]+'" width="50" height="50">'+
                                                            // '<i class="fa fa-picture-o"></i> Pic '+no+
                                            '</a>'+
                                            '<label class="m-l-20">'+pic[j]+'</label>'+
                                            '<input type="hidden" name="file_pic_old[]" value="'+pic[j]+'">'+
                                            '<button style="bottom: -10px" type="button" onclick="removefoto(\''+pic[j]+'\')" class="remove btn btn-sm waves-effect waves-light btn-danger float-right"  title="Hapus Foto '+no+'"><i class="fa fa-trash-o"></i>'+
                                            '</button>'+
                                        '</div>'
                                    );
                                }

                            }
                            
                            $('#modal-edit').modal('show');
                        }                   

                    });

                }

                function removefoto(id){
                    document.getElementById("foto-"+id).remove();
                    piclength--;
                    console.log(piclength);
                    if (piclength==0) {
                        addfoto();
                    }

                }

                function addfoto(){

                    var file =  '<div class="form-group">'+
                                    '<a href="javascript:void(0)" onclick="removeUpload(this)" style="float: right;"><span class="badge badge-danger">X</span></a>'+
                                    '<div class="controls">'+
                                        '<input type="file" data-validation-required-message="Foto harus diisi" required name="file_pic_new[]" id="file_pic_new[]" class="dropify" data-height="100" data-max-file-size="500K" accept="image/*" />'+
                                    '</div>'+
                                '</div>';
                    $('#upload_file').append(file);

                    $('.dropify').dropify({
                         messages: {
                            default: '<center>Upload foto/gambar disini.</center>',
                            error: '<center>Maksimal ukuran file 500 KB.</center>',
                        }
                    });
                }

                function removeUpload(data) {
                    $(data).parent().remove();
                }
            </script>
        
            <!-- ======================================================= -->

            <!-- HAPUS PERLENGKAPAN JALAN ================================= -->
            <script type="text/javascript">
                function showConfirmMessage(id_jenis_pj='', id_pj='') {
                    swal({
                        title: "Anda yakin data akan dihapus?",
                        text: "Data tidak akan dapat di kembalikan lagi!!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Ya, Hapus!",
                        closeOnConfirm: false
                    }, function () {
                        $.ajax({
                            type : "POST",
                            url  : "<?= base_url('Petugas/deletePj')?>",
                            dataType : "html",
                            data : {id_jenis_pj:id_jenis_pj, id_pj:id_pj},
                            success: function(data){
                                location=data;          
                            }
                        });
                        return false;
                    });
                }
            </script>

            