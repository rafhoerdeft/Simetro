        <div style="z-index: 20; top: 40%; left: 47%; position: fixed; display:none;" id="loading-show">
            <img src="<?= base_url().'assets/loading/loading3.gif' ?>" width="100">
        </div>  

        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="row page-titles">
                <div class="col-md-6 align-self-center">
                    <h3 class="text-themecolor">UTTP Tera Ulang</h3>
                </div>   

                <div class="col-md-6 align-self-center">
                    <ol class="breadcrumb">
                        <!-- <label>Jenis Perlengkapan</label> -->
                        <li class="breadcrumb-item active">UTTP Tera Ulang</li>
                    </ol>
                </div>             

                <!-- <div>
                    <button class="right-side-toggle waves-effect waves-light btn-inverse btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>
                </div> -->
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


                <div class="card">
                    <div class="card-body p-b-20">
                        <!-- <button type="button" onclick="showModalAdd()" class="btn waves-effect waves-light btn-primary float-right"  title="Edit Data"><i class="fa fa-plus"></i> Tambah UTTP</button>
                        <br><br>
                        <hr> -->
                        <div class="table-responsive">
                            <table id="myTable" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr style="font-size: 9pt">
                                        <th><b>#</b></th>
                                        <th><b>Pemilik</b></th>
                                        <th><b>Jenis Usaha</b></th>
                                        <th><b>Nama Usaha</b></th>
                                        <th><b>Jenis Alat</b></th>
                                        <!-- <th><b>No. Seri</b></th> -->
                                        <th><b>Merk</b></th>
                                        <!-- <th><b>Model/Tipe</b></th> -->
                                        <!-- <th><b>Buatan</b></th> -->
                                        <!-- <th><b>Jml</b></th> -->
                                        <th><b>Kapasitas</b></th>
                                        <th><b>Thn Beli</b></th>
                                        <th width="110"><b>Tera Terakhir</b></th>
                                        <th width="110"><b>Tera Ulang</b></th>
                                        <th width="115"><b>Aksi</b></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $no = 0;
                                        foreach ($dataUttp as $uttp) { 
                                            $no++;
                                    ?>
                                            <tr style="font-size: 10pt">
                                                <td align="center"><?= $no ?></td>
                                                <td><?= $uttp->nama_pemilik ?></td>
                                                <td><?= $uttp->jenis_usaha ?></td>
                                                <td><?= $uttp->nama_usaha ?></td>
                                                <td><?= $uttp->jenis_alat ?></td>
                                                <!-- <td align="center"><?= $uttp->nomor_seri ?></td> -->
                                                <td align="center"><?= $uttp->merk ?></td>
                                                <!-- <td align="center"><?= $uttp->model_tipe ?></td> -->
                                                <!-- <td align="center"><?= $uttp->buatan ?></td> -->
                                                <!-- <td align="center"><?= $uttp->jml_uttp ?></td> -->
                                                <td align="center"><?= $uttp->kapasitas ?></td>
                                                <td align="center"><?= $uttp->tahun_pembelian ?></td>
                                                <td align="center"><?= ($uttp->tgl_tera_terakhir!=null&&$uttp->tgl_tera_terakhir!='0000-00-00'?date('d-m-Y', strtotime($uttp->tgl_tera_terakhir)):'-') ?></td>
                                                <td align="center"><?= ($uttp->tgl_tera_ulang!=null&&$uttp->tgl_tera_ulang!='0000-00-00'?date('d-m-Y', strtotime($uttp->tgl_tera_ulang)):'-') ?></td>
                                                <td>
                                                    <div style="width: 75px">
                                                        <button type="button" onclick="kirimNotif('<?= $uttp->id_user ?>','<?= $uttp->id_uttp ?>')" class="btn btn-sm waves-effect waves-light btn-danger m-b-5" style="width: 35px"  title="Kirim Pemberitahuan"><i class="fa fa-send"></i></button>

                                                        <button type="button" onclick="detailUser('<?= $uttp->id_user ?>')" class="btn btn-sm waves-effect waves-light btn-info m-b-5" style="width: 35px"  title="Detail Pemilik"><i class="fa fa-user-circle-o"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>

            <!-- Modal Simpan -->
            <div id="modal-detail" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Detail Pemilik UTTP</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                            <div class="modal-body">
                                <table border="0" class="table table-bordered table-striped table-hover" style="font-size: 10pt">
                                    <tr>
                                        <td style="font-weight: bold;">Nama</td>
                                        <td>:</td>
                                        <td id="nama_user">Sudiarto</td>
                                    </tr>

                                    <tr>
                                        <td  style="font-weight: bold;">Nomor HP</td>
                                        <td>:</td>
                                        <td id="no_hp_user">085743469254</td>
                                    </tr>

                                    <tr>
                                        <td  style="font-weight: bold;">Alamat</td>
                                        <td>:</td>
                                        <td id="alamat_user">
                                            Menowosari 10 RT 1 RW 1 Kedungsari, Magelang Utara, Kota Magelang.
                                        </td>
                                    </tr>

                                    <tr>
                                        <td  style="font-weight: bold;">Alamat Tempat Usaha</td>
                                        <td>:</td>
                                        <td id="alamat_usaha">
                                            Menowosari 10 RT 1 RW 1 Kedungsari, Magelang Utara, Kota Magelang.
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                <!-- <button type="submit" class="btn btn-info waves-effect waves-light" id="simpan_jalan"><i class="fa fa-save"></i> Simpan</button> -->
                            </div>
                    </div>
                </div>
            </div>

            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->


        <script type="text/javascript">
            function changeUsaha(argument) {
               var id_usaha = $('#usaha').val();
               window.location = "<?= base_url().'Admin/dataUttp/' ?>" + id_usaha;
            }
        </script>

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


        <!-- SIMPAN USER =========================================== -->
        <script type="text/javascript">
            function detailUser(id) {

                $("#loading-show").fadeIn("slow");

                $.post("<?= base_url().'Admin/getDetailUser' ?>", {id_user:id}, function(result){
                    $("#loading-show").fadeIn("slow").delay(20).slideUp('slow');

                    var dt = JSON.parse(result);
                    // console.log(dt);

                    if (dt.response) {

                        $('#modal-detail #nama_user').html(dt.dataUser.nama_user);

                        var no_hp = ''
                        if (dt.dataUser.no_hp != '' || dt.dataUser.no_hp != null) {
                            no_hp = dt.dataUser.no_hp;
                        }
                        $('#modal-detail #no_hp_user').html(no_hp);

                        var almt_user = ''
                        if (dt.dataUser.alamat_user != '' || dt.dataUser.alamat_user != null) {
                            almt_user = dt.dataUser.alamat_user;
                        }
                        $('#modal-detail #alamat_user').html(almt_user);

                        var almt_usaha = ''
                        if (dt.dataUser.alamat_usaha != '' || dt.dataUser.alamat_usaha != null) {
                            almt_usaha = dt.dataUser.alamat_usaha+' '+dt.dataUser.desa+', '+dt.dataUser.kecamatan;
                        }
                        $('#modal-detail #alamat_usaha').html(almt_usaha);

                        $('#modal-detail').modal('show');

                    }

                });
            }
        </script>
        <!-- ======================================================= -->

        <!-- ======================================================= -->

        <script type="text/javascript">
            function kirimNotif(id_user='', id_uttp='') {
                swal({
                    title: "Pemberitahuan Tera Ulang?",
                    text: "Apakah Anda ingin mengirim pemberitahuan tera ulang kepada pemilik UTTP?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#0264db",
                    confirmButtonText: "Ya, Kirim!",
                    closeOnConfirm: false
                }, function () {
                    $.ajax({
                        type : "POST",
                        url  : "<?php echo base_url('Admin/kirimNotif')?>",
                        dataType : "html",
                        data : {id_user: id_user, id_uttp: id_uttp},
                        success: function(data){

                            if(data=='Success'){
                                swal({
                                    title: "Berhasil!",
                                    text: "Pemberitahuan tera ulang berhasil terkirim!",
                                    type: "success",
                                    timer: 1000,
                                    showConfirmButton: false
                                });
                            }else{
                                swal({
                                    title: "Gagal!",
                                    text: "Pemberitahuan tera ulang gagal terkirim.!",
                                    type: "error",
                                    timer: 1000,
                                    showConfirmButton: false
                                });
                            } 
                        }
                    });
                    return false;
                    // swal("Hapus!", "Data telah berhasil dihapus.", "success");
                });
            }
        </script>

        <!-- HAPUS USER ================================= -->
        <script type="text/javascript">
            function showConfirmMessage(id) {
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
                        url  : "<?php echo base_url('Admin/deleteUttp')?>",
                        dataType : "html",
                        data : {id:id},
                        success: function(data){
                            // alert(data);
                            // $('#myTable').DataTable().destroy();
                            // $('#myTable').DataTable().draw();

                            if(data=='Success'){
                                location.reload();
                            }else{
                                location.reload();
                            } 
                        }
                    });
                    return false;
                    // swal("Hapus!", "Data telah berhasil dihapus.", "success");
                });
            }
        </script>
            