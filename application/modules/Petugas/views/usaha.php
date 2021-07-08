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
                    <h3 class="text-themecolor">Data Usaha (<?= $namaUser ?>)</h3>
                </div>

                <div class="col-md-6 align-self-center">
                    <ol class="breadcrumb">
                        <!-- <label>Jenis Perlengkapan</label> -->
                        <li class="breadcrumb-item"><a href="<?= base_url().'Petugas/dataUser/'.$uri ?>" class="text-danger">Data User</a></li>
                        <li class="breadcrumb-item active">Data Usaha</li>
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
                        <button type="button" onclick="showModalAdd()" class="btn waves-effect waves-light btn-primary float-right"><i class="fa fa-plus"></i> Tambah Usaha</button>
                        <br><br>
                        <hr>

                        <style type="text/css">
                            .dataTable > thead > tr > th[class*="sort"]:after{
                                content: "" !important;
                            }
                        </style>

                        <div class="table-responsive">
                            <table id="myTable" class="table-bordered table-striped table-hover" cellpadding="7px" width="100%">
                                <thead align="center" class="bg-megna text-white">
                                    <tr style="font-size: 11pt">
                                        <th><b>#</b></th>
                                        <th><b>Nama Usaha</b></th>
                                        <th><b>Jenis Usaha</b></th>
                                        <th><b>Desa</b></th>
                                        <th><b>Kecamatan</b></th>
                                        <th><b>Alamat</b></th>
                                        <th width="125"><b>Aksi</b></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $no = 0;
                                        foreach ($dataUsaha as $usaha) { 
                                            $no++;
                                    ?>
                                            <tr style="font-size: 11pt">
                                                <td align="center"><?= $no ?></td>
                                                <td><?= $usaha->nama_usaha ?></td>
                                                <td><?= $usaha->jenis_usaha ?></td>
                                                <td><?= $usaha->desa ?></td>
                                                <td><?= $usaha->kecamatan ?></td>
                                                <td><?= $usaha->alamat ?></td>
                                                <td align="center">
                                                    <button type="button" data-id="<?= $usaha->id_usaha ?>" onclick="showModalEdit(<?= $usaha->id_usaha ?>)" class="btn btn-sm waves-effect waves-light btn-info" style="width: 40px; margin-bottom: 5px" title="Edit Data"><i class="fa fa-pencil-square-o"></i></button>
                                                    <button type="button" onclick="showConfirmMessage('<?= $usaha->id_usaha ?>')" class="btn btn-sm waves-effect waves-light btn-danger" style="width: 40px; margin-bottom: 5px" title="Hapus Data"><i class="fa fa-trash-o"></i></button>
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
            <div id="modal-simpan" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Tambah Data Usaha</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <form id="tambahDataUsaha" method="POST" action="<?= base_url().'Petugas/simpanUsaha/'.$uri ?>">
                            <div class="modal-body">

                                <input type="hidden" name="id_user" value="<?= $idUser ?>">

                                <div class="form-group">
                                    <label for="nama_usaha" class="control-label">Nama Usaha :</label>
                                    <div class="controls">
                                        <input required data-validation-required-message="Nama usaha harus diisi" type="text" class="form-control" name="nama_usaha" id="nama_usaha" placeholder="Isi nama usaha">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="jenis_usaha" class="control-label">Jenis Usaha :</label>
                                    <div class="controls">
                                        <select required id="jenis_usaha" name="jenis_usaha" class="select2 form-control custom-select" style="width: 100%; height:36px;">
                                            <option selected value="" disabled style="color: #d6d6d6">Pilih jenis usaha yang tersedia</option>
                                            <?php foreach ($dataJenisUsaha as $key) { ?>
                                                <option value="<?= $key->id_jenis_usaha ?>"><?= $key->nama_jenis_usaha ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="kode_kecamatan" class="control-label">Kecamatan :</label>
                                    <div class="controls">
                                        <select onchange="getDataDesa(this)" required id="kode_kecamatan" name="kode_kecamatan" class="select2 form-control custom-select" style="width: 100%; height:36px;">
                                            <option selected value="" disabled style="color: #d6d6d6">Pilih kecamatan</option>
                                            <?php foreach ($dataKecamatan as $key) { ?>
                                                <option value="<?= $key->kode_kecamatan ?>"><?= $key->nama_kecamatan ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div style="z-index: 20; margin-top: -50px; margin-bottom: -25px; text-align: center; display: none" id="loading-desa">
                                    <img src="<?= base_url().'assets/loading/loading1.gif' ?>" width="100">
                                </div>  

                                <div class="form-group">
                                    <label for="kode_desa" class="control-label">Desa :</label>
                                    <div class="controls">
                                        <select required id="kode_desa" name="kode_desa" class="select2 form-control custom-select" style="width: 100%; height:36px;">
                                            <option selected value="" disabled style="color: #d6d6d6">Pilih desa</option>
                                        </select>
                                    </div>
                                </div>


                               <!--  <div class="form-group">
                                    <label for="no_hp" class="control-label">Nomor HP :</label><br>
                                    <div class="controls">
                                        <input required data-validation-required-message="Nomor HP harus diisi" type="text"  onkeypress="return inputAngka(event);" class="form-control" name="no_hp" id="no_hp">
                                    </div>
                                </div> -->

                                <div class="form-group">
                                    <label for="alamat" class="control-label">Alamat :</label>
                                    <div class="controls">
                                        <textarea required class="form-control" id="alamat" name="alamat"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-info waves-effect waves-light" id="simpan_usaha"><i class="fa fa-save"></i> Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal Edit -->
            <div id="modal-edit" class="modal fade" role="dialog" aria-labelledby="myModalLabels" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Update Data Usaha</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <form id="updateDataUsaha" method="POST" action="<?= base_url().'Petugas/updateUsaha/'.$uri ?>">
                            <div class="modal-body">

                                <input type="hidden" id="id_usaha" name="id_usaha">
                                <input type="hidden" name="id_user" value="<?= $idUser ?>">

                                <div class="form-group">
                                    <label for="nama_usaha" class="control-label">Nama Usaha :</label>
                                    <div class="controls">
                                        <input required type="text" class="form-control" name="nama_usaha" id="nama_usaha" placeholder="Isi nama usaha">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="jenis_usaha" class="control-label">Jenis Usaha :</label>
                                    <!-- <div class="controls"> -->
                                        <select required id="jenis_usaha" name="jenis_usaha" class="select2 form-control custom-select" style="width: 100%; height:36px;">
                                            <option selected value="" disabled style="color: #d6d6d6">Pilih jenis usaha yang tersedia</option>
                                            <?php foreach ($dataJenisUsaha as $jns) { ?>
                                                <option value="<?= $jns->id_jenis_usaha ?>"><?= $jns->nama_jenis_usaha ?></option>
                                            <?php } ?>
                                        </select>
                                    <!-- </div> -->
                                </div>

                                <div class="form-group">
                                    <label for="kode_kecamatan" class="control-label">Kecamatan :</label>
                                    <div class="controls">
                                        <select onchange="getDataDesa(this)" required id="kode_kecamatan" name="kode_kecamatan" class="select2 form-control custom-select" style="width: 100%; height:36px;">
                                            <option selected value="" disabled style="color: #d6d6d6">Pilih kecamatan</option>
                                            <?php foreach ($dataKecamatan as $key) { ?>
                                                <option value="<?= $key->kode_kecamatan ?>"><?= $key->nama_kecamatan ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div style="z-index: 20; margin-top: -50px; margin-bottom: -25px; text-align: center; display: none" id="loading-desa">
                                    <img src="<?= base_url().'assets/loading/loading1.gif' ?>" width="100">
                                </div>  

                                <div class="form-group">
                                    <label for="kode_desa" class="control-label">Desa :</label>
                                    <div class="controls">
                                        <select required id="kode_desa" name="kode_desa" class="select2 form-control custom-select" style="width: 100%; height:36px;">
                                            <option selected value="" disabled style="color: #d6d6d6">Pilih desa</option>
                                        </select>
                                    </div>
                                </div>


                               <!--  <div class="form-group">
                                    <label for="no_hp" class="control-label">Nomor HP :</label><br>
                                    <div class="controls">
                                        <input required data-validation-required-message="Nomor HP harus diisi" type="text"  onkeypress="return inputAngka(event);" class="form-control" name="no_hp" id="no_hp">
                                    </div>
                                </div> -->

                                <div class="form-group">
                                    <label for="alamat" class="control-label">Alamat :</label>
                                    <div class="controls">
                                        <textarea required class="form-control" id="alamat" name="alamat"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-info waves-effect waves-light" id="simpan_jalan"><i class="fa fa-save"></i> Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->


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


        <!-- SIMPAN USAHA =========================================== -->
        <script type="text/javascript">
            function showModalAdd(argument) {
                $('#modal-simpan #tambahDataUsaha').trigger("reset");
                $('#modal-simpan').modal('show');
            }
        </script>

        <script type="text/javascript">
            function getDataDesa(data) {
                var id_modal = $(data).parent().parent().parent().parent().parent().parent().parent().attr('id');
                var kode = $('#'+id_modal+' #kode_kecamatan option:selected').attr('value');

                $("#loading-desa").fadeIn("slow");

                $.post("<?= base_url().'Petugas/getDataDesa' ?>", {kode_kecamatan:kode}, function(result){
                    $("#loading-desa").fadeIn("slow").delay(100).slideUp('slow');

                    var dt = JSON.parse(result);
                    console.log(dt.data);

                    if (dt.response) {
                        var list = '';
                        for (var i = 0; i < dt.data.length; i++) {
                            list += '<option value="'+dt.data[i].kode_desa+'">'+dt.data[i].nama_desa+'</option>';
                        }

                        $('#'+id_modal+' #kode_desa').html(list);
                    }

                });
            }
        </script>
        <!-- ======================================================= -->

        <!-- UPDATE USAHA =========================================== -->
        <script type="text/javascript">

            function showModalEdit(id) {
                $('#modal-edit #updateDataUsaha').trigger('reset');
                
                $("#loading-show").fadeIn("slow");

                $.post("<?= base_url().'Petugas/getDataEditUsaha' ?>", {id:id}, function(result){
                    $("#loading-show").fadeIn("slow").delay(100).slideUp('slow');

                    var dt = JSON.parse(result);
                    // console.log(dt.data);

                    if (dt.response) {
                        $('#modal-edit #updateDataUsaha #id_usaha').val(dt.data.id_usaha);
                        $('#modal-edit #updateDataUsaha #nama_usaha').val(dt.data.nama_usaha);
                        $('#modal-edit #updateDataUsaha #jenis_usaha').val(dt.data.id_jenis_usaha).change();
                        $('#modal-edit #updateDataUsaha #kode_kecamatan').val(dt.kode_kecamatan).prop('selected',true);
                        $('#modal-edit #updateDataUsaha #kode_kecamatan').select2("destroy");
                        $('#modal-edit #updateDataUsaha #kode_kecamatan').select2();

                        var list = '';
                        for (var i = 0; i < dt.dataDesa.length; i++) {
                            list += '<option value="'+dt.dataDesa[i].kode_desa+'">'+dt.dataDesa[i].nama_desa+'</option>';
                        }

                        $('#modal-edit #updateDataUsaha #kode_desa').html(list);

                        $('#modal-edit #updateDataUsaha #kode_desa').val(dt.data.kode_desa).prop('selected',true);
                        $('#modal-edit #updateDataUsaha #alamat').val(dt.data.alamat);

                        $('#modal-edit').modal('show');

                    }

                });
            }

        </script>
        <!-- ======================================================= -->

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
                        url  : "<?php echo base_url('Petugas/deleteUsaha')?>",
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
            