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
                    <h3 class="text-themecolor">Data UTTP</h3>
                </div>   

                <div class="col-md-6 align-self-center">
                    <ol class="breadcrumb">
                        <!-- <label>Jenis Perlengkapan</label> -->
                        <li class="breadcrumb-item"><a href="<?= base_url().'Admin/dataUser/'.$uri ?>" class="text-danger">Data User</a></li>
                        <li class="breadcrumb-item active"><a href="<?= base_url().'Admin/dataUsaha/'.encode($idUser).'/'.encode($uri) ?>" class="text-danger">Data Usaha</a></li>
                        <li class="breadcrumb-item active">Data UTTP</li>
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
                        <button type="button" onclick="showModalAdd()" class="btn waves-effect waves-light btn-primary float-right"  title="Edit Data"><i class="fa fa-plus"></i> Tambah UTTP</button>
                        <br><br>
                        <hr>
                        <div class="table-responsive">
                            <table id="myTable" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr style="font-size: 9pt">
                                        <th><b>#</b></th>
                                        <th><b>Jenis Alat</b></th>
                                        <th><b>No. Seri</b></th>
                                        <th><b>Merk</b></th>
                                        <th><b>Model/Tipe</b></th>
                                        <th><b>Buatan</b></th>
                                        <th><b>Jml</b></th>
                                        <th><b>Kapasitas</b></th>
                                        <th><b>Thn Beli</b></th>
                                        <th><b>Tera Terakhir</b></th>
                                        <th><b>Tera Ulang</b></th>
                                        <th><b>Aksi</b></th>
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
                                                <td><?= $uttp->jenis_alat ?></td>
                                                <td align="center"><?= $uttp->nomor_seri ?></td>
                                                <td align="center"><?= $uttp->merk ?></td>
                                                <td align="center"><?= $uttp->model_tipe ?></td>
                                                <td align="center"><?= $uttp->buatan ?></td>
                                                <td align="center"><?= $uttp->jml_uttp ?></td>
                                                <td align="center"><?= $uttp->kapasitas ?></td>
                                                <td align="center"><?= $uttp->tahun_pembelian ?></td>
                                                <td align="center"><?= ($uttp->tgl_tera_terakhir!=null&&$uttp->tgl_tera_terakhir!='0000-00-00'?date('d-m-Y', strtotime($uttp->tgl_tera_terakhir)):'-') ?></td>
                                                <td align="center"><?= ($uttp->tgl_tera_ulang!=null&&$uttp->tgl_tera_ulang!='0000-00-00'?date('d-m-Y', strtotime($uttp->tgl_tera_ulang)):'-') ?></td>
                                                <td>
                                                    <div style="width: 75px;">
                                                        <button type="button" data-id="<?= $uttp->id_uttp ?>" data-buatan="<?= $uttp->buatan ?>" data-jenis-alat="<?= $uttp->id_jenis_alat ?>" data-no-seri="<?= $uttp->nomor_seri ?>" data-merk="<?= $uttp->merk ?>" data-model="<?= $uttp->model_tipe ?>" data-jml-uttp="<?= $uttp->jml_uttp ?>" data-kapasitas="<?= $uttp->kapasitas ?>" data-thn="<?= $uttp->tahun_pembelian ?>" onclick="showModalEdit(this)" class="btn btn-sm waves-effect waves-light btn-info m-b-5" style="width: 35px"  title="Edit Data"><i class="fa fa-pencil-square-o"></i></button>
                                                        
                                                        <button type="button" onclick="showConfirmMessage('<?= $uttp->id_uttp ?>')" class="btn btn-sm waves-effect waves-light btn-danger m-b-5" style="width: 35px"  title="Hapus Data"><i class="fa fa-trash-o"></i></button>
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
            <div id="modal-simpan" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Tambah Data UTTP</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <form id="tambahDataUttp" method="POST" action="<?= base_url().'Admin/simpanUttp/'.encode($selectUsaha).'/'.encode($idUser).'/'.encode($uri) ?>">
                            <div class="modal-body">

                                <input type="hidden" name="id_usaha" id="id_usaha" value="<?= $selectUsaha ?>">

                                <div class="form-group">
                                    <label for="id_jenis_alat" class="control-label">Jenis Alat :</label>
                                    <div class="controls">
                                        <select required id="id_jenis_alat" name="id_jenis_alat" class="select2 form-control custom-select" style="width: 100%; height:36px;">
                                            <option selected value="" disabled style="color: #d6d6d6">Pilih jenis alat yang tersedia</option>
                                            <?php foreach ($dataJenisAlat as $key) { ?>
                                                <option value="<?= $key->id_jenis_alat ?>"><?= $key->nama_jenis_alat ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="nomor_seri" class="control-label">Nomor Seri :</label>
                                    <div class="controls">
                                        <input required type="text" class="form-control" name="nomor_seri" id="nomor_seri" placeholder="Isi nomor seri alat">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="merk" class="control-label">Merk :</label>
                                    <div class="controls">
                                        <input required type="text" class="form-control" name="merk" id="merk" placeholder="Isi merk alat">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="model_tipe" class="control-label">Model/Tipe :</label>
                                    <div class="controls">
                                        <input required type="text" class="form-control" name="model_tipe" id="model_tipe" placeholder="Isi model/tipe alat">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="buatan" class="control-label">Buatan :</label>
                                    <div class="controls">
                                        <input required type="text" class="form-control" name="buatan" id="buatan" placeholder="Ex: Jepang, China, Indonesia, dll.">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="kapasitas" class="control-label">Kapasitas :</label>
                                    <div class="controls">
                                        <input required type="text" class="form-control" name="kapasitas" id="kapasitas" placeholder="Isi kapasitas alat">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="jml_uttp" class="control-label">Jumlah Alat :</label><br>
                                    <div class="controls">
                                        <input required type="text"  onkeypress="return inputAngka(event);" class="form-control" name="jml_uttp" id="jml_uttp" placeholder="Isi jumlah UTTP yang dimiliki">
                                    </div>
                                </div>
                                

                                <div class="form-group">
                                    <label for="tahun_pembelian" class="control-label">Tahun Pembelian :</label>
                                    <div class="controls">
                                        <select id="tahun_pembelian" name="tahun_pembelian" class="select2 form-control custom-select" style="width: 100%; height:36px;">
                                            <?php 
                                                $thn = date('Y');
                                                for ($i=0; $i < 20; $i++) {  
                                                    $tahun = $thn - $i;
                                            ?>
                                                <option value="<?= $tahun ?>"><?= $tahun ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- <div class="form-group">
                                    <label for="message-text" class="control-label">Message:</label>
                                    <textarea class="form-control" id="message-text"></textarea>
                                </div> -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-info waves-effect waves-light" id="simpan_jalan"><i class="fa fa-save"></i> Simpan</button>
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
                            <h4 class="modal-title">Update Data User</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <form id="updateDataUttp" method="POST" action="<?= base_url().'Admin/updateUttp/'.encode($selectUsaha).'/'.encode($idUser).'/'.encode($uri) ?>">
                            <div class="modal-body">

                                <!-- <input type="hidden" name="id_usaha" id="id_usaha" value="<?//= $selectUsaha ?>"> -->
                                <input type="hidden" name="id_uttp" id="id_uttp">

                                <div class="form-group">
                                    <label for="id_jenis_alat" class="control-label">Jenis Alat :</label>
                                    <div class="controls">
                                        <select required id="id_jenis_alat" name="id_jenis_alat" class="select2 form-control custom-select" style="width: 100%; height:36px;">
                                            <option selected value="" disabled style="color: #d6d6d6">Pilih jenis alat yang tersedia</option>
                                            <?php foreach ($dataJenisAlat as $key) { ?>
                                                <option value="<?= $key->id_jenis_alat ?>"><?= $key->nama_jenis_alat ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="nomor_seri" class="control-label">Nomor Seri :</label>
                                    <div class="controls">
                                        <input required type="text" class="form-control" name="nomor_seri" id="nomor_seri" placeholder="Isi nomor seri alat">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="merk" class="control-label">Merk :</label>
                                    <div class="controls">
                                        <input required type="text" class="form-control" name="merk" id="merk" placeholder="Isi merk alat">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="model_tipe" class="control-label">Model/Tipe :</label>
                                    <div class="controls">
                                        <input required type="text" class="form-control" name="model_tipe" id="model_tipe" placeholder="Isi model/tipe alat">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="buatan" class="control-label">Buatan :</label>
                                    <div class="controls">
                                        <input required type="text" class="form-control" name="buatan" id="buatan" placeholder="Ex: Jepang, China, Indonesia, dll.">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="kapasitas" class="control-label">Kapasitas :</label>
                                    <div class="controls">
                                        <input required type="text" class="form-control" name="kapasitas" id="kapasitas" placeholder="Isi kapasitas alat">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="jml_uttp" class="control-label">Jumlah Alat :</label><br>
                                    <div class="controls">
                                        <input required type="text"  onkeypress="return inputAngka(event);" class="form-control" name="jml_uttp" id="jml_uttp" placeholder="Isi jumlah UTTP yang dimiliki">
                                    </div>
                                </div>
                                

                                <div class="form-group">
                                    <label for="tahun_pembelian" class="control-label">Tahun Pembelian :</label>
                                    <div class="controls">
                                        <select id="tahun_pembelian" name="tahun_pembelian" class="select2 form-control custom-select" style="width: 100%; height:36px;">
                                            <?php 
                                                $thn = date('Y');
                                                for ($i=0; $i < 20; $i++) {  
                                                    $tahun = $thn - $i;
                                            ?>
                                                <option value="<?= $tahun ?>"><?= $tahun ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- <div class="form-group">
                                    <label for="message-text" class="control-label">Message:</label>
                                    <textarea class="form-control" id="message-text"></textarea>
                                </div> -->
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
            function showModalAdd(argument) {
                $('#modal-simpan #tambahDataUttp').trigger("reset");
                $('#modal-simpan').modal('show');
            }
        </script>
        <!-- ======================================================= -->

        <!-- UPDATE USER =========================================== -->
        <script type="text/javascript">

            function showModalEdit(data) {
                var id_uttp = $(data).attr('data-id');
                var id_jenis_alat = $(data).attr('data-jenis-alat');
                var nomor_seri = $(data).attr('data-no-seri');
                var merk = $(data).attr('data-merk');
                var buatan = $(data).attr('data-buatan');
                var model = $(data).attr('data-model');
                var jml_uttp = $(data).attr('data-jml-uttp');
                var kapasitas = $(data).attr('data-kapasitas');
                var tahun_pembelian = $(data).attr('data-thn');

                $('#modal-edit #updateDataUttp #id_uttp').val(id_uttp);
                $('#modal-edit #updateDataUttp #id_jenis_alat').val(id_jenis_alat).change();
                $('#modal-edit #updateDataUttp #nomor_seri').val(nomor_seri);
                $('#modal-edit #updateDataUttp #merk').val(merk);
                $('#modal-edit #updateDataUttp #buatan').val(buatan);
                $('#modal-edit #updateDataUttp #model_tipe').val(model);
                $('#modal-edit #updateDataUttp #jml_uttp').val(jml_uttp);
                $('#modal-edit #updateDataUttp #kapasitas').val(kapasitas);
                $('#modal-edit #updateDataUttp #tahun_pembelian').val(tahun_pembelian).change();

                $('#modal-edit').modal('show');
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
            