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
                    <h3 class="text-themecolor">Data Riwayat Perbaikan (<?=ucwords($breadcrumb)?>)</h3>
                </div>

                <div class="col-md-6 align-self-center">
                    <ol class="breadcrumb">
                        <!-- <label>Jenis Perlengkapan</label> -->
                        <li class="breadcrumb-item"><a href="<?=base_url('Petugas/perlengkapanJalan/').encode($id_jenis_pj);?>">Perlengkapan Jalan</a></li>
                        <li class="breadcrumb-item active">Riwayat Perbaikan</li>
                    </ol>
                    </ol>
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


                <div class="card">
                    <div class="card-body p-b-20">
                        <div class="float-right">
                            <button type="button" class="btn btn-success" title="Tambah Data" onclick="showModalAdd()"><i class="fa fa-plus"></i> Riwayat</button>
                        </div>
                        <div class="table-responsive">
                            <table id="myTable" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tanggal Riwayat</th>
                                        <th>Keterangan</th>
                                        <th>Nama PJ</th>
                                        <th>User</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no=1; foreach ($dataRiwayat->result() as $key) {?>
                                        <tr>
                                            <td><?=$no++;?></td>
                                            <td><?= date('d M Y',strtotime($key->tgl_riwayat));?></td>
                                            <td><?=$key->ket_riwayat;?></td>
                                            <td><?=$key->nama_pj;?></td>
                                            <td><?=$key->nama_user;?></td></td>
                                            <td>
                                                <button style="width: 30px" type="button" onclick="showModalEdit('<?= $key->id_riwayat ?>')" class="btn btn-sm waves-effect waves-light btn-info m-b-5" title="Edit Data"><i class="fa fa-pencil-square-o"></i></button>

                                                <button style="width: 30px" type="button" onclick="deleteRiwayat('<?= $id_jenis_pj ?>','<?= $id_pj ?>','<?=$key->id_riwayat?>')" class="btn btn-sm waves-effect waves-light btn-danger m-b-5" title="Hapus Data"><i class="fa fa-trash-o"></i></button>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>

            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->

            <!-- modal tambah -->
            <div id="modal-add" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Tambah Riwayat</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <form id="addRiwayat" method="post" action="<?=base_url();?>Petugas/simpanRiwayat">
                            <input type="hidden" name="id_jenis_pj" id="id_jenis_pj" value="<?=$id_jenis_pj;?>">
                            <input type="hidden" name="id_pj" id="id_pj" value="<?=$id_pj;?>">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="recipient-name" class="control-label">Keterangan:</label>
                                    <textarea required class="form-control" id="ket_riwayat" name="ket_riwayat" rows="3" autocomplete="off"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="date-riwayat" class="control-label">Tanggal:</label>
                                    <input type="text" class="form-control mydatepicker" id="tgl_riwayat" placeholder="tanggal-bulan-tahun" name="tgl_riwayat" required autocomplete="off">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.modal -->

            <!-- modal edit -->
            <div id="modal-edit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Edit Riwayat</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <form id="addRiwayat" method="post" action="<?=base_url();?>Petugas/updateRiwayat">
                            <input type="hidden" name="id_riwayat" id="id_riwayat">
                            <input type="hidden" name="id_jenis_pj" id="id_jenis_pj" value="<?=$id_jenis_pj;?>">
                            <input type="hidden" name="id_pj" id="id_pj" value="<?=$id_pj;?>">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="recipient-name" class="control-label">Keterangan:</label>
                                    <textarea required class="form-control" id="ket_riwayat" name="ket_riwayat" rows="3" autocomplete="off"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="date-riwayat" class="control-label">Tanggal:</label>
                                    <input type="text" class="form-control mydatepicker" placeholder="tanggal-bulan-tahun" id="tgl_riwayat" name="tgl_riwayat" required autocomplete="off">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.modal -->


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


        <!-- Tambah Riwayat =========================================== -->
        <script type="text/javascript">

            function showModalAdd() {
                $('#modal-add #ket_riwayat').val('');
                $('#modal-add #tgl_riwayat').datepicker('setDate', "<?= date('d-m-Y') ?>");
                $('#modal-add').modal('show');
            }

            function deleteRiwayat(id_jenis_pj, id_pj, id_riwayat){
                swal({
                    title: "Anda yakin data akan dihapus?",
                    text: "Data tidak akan dapat di kembalikan lagi!!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Ya, Hapus!",
                    closeOnConfirm: false
                }, function () {
                    // alert(id_riwayat);
                    $.ajax({
                        type : "POST",
                        url  : "<?php echo base_url('Petugas/deleteRiwayat')?>",
                        dataType : "html",
                        data : {
                            id_jenis_pj:id_jenis_pj,
                            id_pj:id_pj,
                            id_riwayat:id_riwayat
                        },
                        success: function(data){
                            location=data;
                        }
                    });
                    return false;
                });
            }

            function showModalEdit(id_riwayat){
                $('#id_riwayat').val(id_riwayat);

                $.post("<?= base_url().'Petugas/getDataRiwayat' ?>", {id_riwayat:id_riwayat}, function(result){
                    $("#loading-show").fadeIn("slow").delay(300).slideUp('slow');
                    var data = JSON.parse(result);
                    $('#modal-edit #ket_riwayat').val(data['ket_riwayat']);    
                    $('#modal-edit #tgl_riwayat').datepicker('setDate', data['tanggal']);    
                });
                $('#modal-edit').modal('show');
            }
            
        </script>
        <!-- ======================================================= -->
