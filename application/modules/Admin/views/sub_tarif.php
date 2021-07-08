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
                    <h3 class="text-themecolor"><?= $subTarif[0]->sub ?></h3>
                </div>

                <div class="col-md-6 align-self-center">
                    <ol class="breadcrumb">
                        <!-- <label>Jenis Perlengkapan</label> -->
                        <li class="breadcrumb-item"><a href="<?= base_url().'Admin/dataTarif' ?>" class="text-danger">Tarif Retribusi</a></li>
                        <?php 
                            for ($i=count($subTarif)-1; $i >= 0 ; $i--) {  
                                if ($i == 0) { 
                        ?>
                            <li class="breadcrumb-item active"><?= $subTarif[$i]->sub ?></li>
                        <?php } else { ?>
                            <li class="breadcrumb-item"><a href="<?= base_url().'Admin/subTarif/'.encode($subTarif[$i]->id_sub) ?>" class="text-danger"><?= $subTarif[$i]->sub ?></a></li>
                        <?php }} ?>
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

                <style type="text/css">
                    .dataTable > thead > tr > th[class*="sort"]:after{
                        content: "" !important;
                    }
                </style>

                <div class="card">
                    <div class="card-body p-b-20">
                        <button type="button" onclick="showModalAdd()" class="btn waves-effect waves-light btn-primary float-right"><i class="fa fa-plus"></i> Tambah Tarif</button>
                        <br><br>
                        <hr>
                        <div class="table-responsive">
                            <table id="myTable" class="table-bordered table-striped table-hover" cellpadding="7px" width="100%">
                                <thead align="center" class="bg-megna text-white" style="font-size: 10pt">
                                    <tr>
                                        <th rowspan="3">#</th>
                                        <th rowspan="3" width="40%">Jenis Tarif</th>
                                        <th rowspan="3">Satuan</th>
                                        <th colspan="4">Tarif</th>
                                        <th rowspan="3">Aksi</th>
                                    </tr>
                                    <tr>
                                        <th colspan="2">Tera</th>
                                        <th colspan="2">Tera Ulang</th>
                                    </tr>
                                    <tr>
                                        <th>Kantor (Rp)</th>
                                        <th>Tempat Pakai (Rp)</th>
                                        <th>Kantor/Luar Kantor (Rp)</th>
                                        <th>Tempat Pakai (Rp)</th>
                                    </tr>
                                </thead>
                                <tbody style="font-size: 10pt">
                                    <?php 
                                        $no = 0;
                                        foreach ($dataTarif as $tarif) { 
                                            $no++;
                                    ?>
                                            <tr>
                                                <td align="center" width="30"><?= $no ?></td>
                                                <td><?= $tarif->jenis_tarif ?></td>
                                                <td align="center"><?= $tarif->satuan ?></td>
                                                <td align="center"><?= number_format($tarif->tera_kantor,0,".",".") ?></td>
                                                <td align="center"><?= number_format($tarif->tera_tempat_pakai,0,".",".") ?></td>
                                                <td align="center"><?= number_format($tarif->tera_ulang_kantor,0,".",".") ?></td>
                                                <td align="center"><?= number_format($tarif->tera_ulang_tempat_pakai,0,".",".") ?></td>
                                                <td nowrap>

                                                    <div class="d-none d-sm-none d-md-block d-lg-block">
                                                        <a href="<?= base_url().'Admin/subTarif/'.encode($tarif->id_tarif) ?>" class="btn btn-sm btn-warning m-b-5" style="width: 40px;" title="Sub Tarif"><i class="fa fa-eye"></i></a>
                                                        <button type="button" data-id="<?= $tarif->id_tarif ?>" data-jenis="<?= $tarif->jenis_tarif ?>" data-satuan="<?= $tarif->satuan ?>" data-tera-a="<?= number_format($tarif->tera_kantor,0,'.','.') ?>" data-tera-b="<?= number_format($tarif->tera_tempat_pakai,0,'.','.') ?>" data-tera-ulang-a="<?= number_format($tarif->tera_ulang_kantor,0,'.','.') ?>" data-tera-ulang-b="<?= number_format($tarif->tera_ulang_tempat_pakai,0,'.','.') ?>" onclick="showModalEdit(this)" class="btn btn-sm waves-effect waves-light btn-info m-b-5" style="width: 40px" title="Edit Data"><i class="fa fa-pencil-square-o"></i></button>
                                                        <button type="button" onclick="showConfirmMessage('<?= $tarif->id_tarif ?>', <?= $no ?>)" class="btn btn-sm waves-effect waves-light btn-danger m-b-5" style="width: 40px" title="Hapus Data"><i class="fa fa-trash-o"></i></button>
                                                    </div>

                                                    <div class="d-block d-sm-block d-md-none d-lg-none">
                                                        <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fa fa-cog"></i>
                                                        </button>

                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="<?= base_url().'Admin/subTarif/'.encode($tarif->id_tarif) ?>"><i class="fa fa-eye"></i> Sub Tarif</a>
                                                            <a class="dropdown-item" href="javascript:void(0)" data-id="<?= $tarif->id_tarif ?>" data-jenis="<?= $tarif->jenis_tarif ?>" data-satuan="<?= $tarif->satuan ?>" data-tera-a="<?= number_format($tarif->tera_kantor,0,'.','.') ?>" data-tera-b="<?= number_format($tarif->tera_tempat_pakai,0,'.','.') ?>" data-tera-ulang-a="<?= number_format($tarif->tera_ulang_kantor,0,'.','.') ?>" data-tera-ulang-b="<?= number_format($tarif->tera_ulang_tempat_pakai,0,'.','.') ?>" onclick="showModalEdit(this)"><i class="fa fa-pencil-square-o"></i> Edit Data</a>
                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="showConfirmMessage('<?= $tarif->id_tarif ?>', <?= $no ?>)"><i class="fa fa-trash-o"></i> Hapus Data</a>
                                                            <!-- <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item" href="#">Separated link</a> -->
                                                        </div>
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
                            <h4 class="modal-title">Tambah Tarif Retribusi</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <form id="simpanTarif" method="POST" action="<?= base_url().'Admin/simpanSubTarif/'.encode($subTarif[0]->id_sub) ?>">
                            <div class="modal-body">

                                <input type="hidden" id="parent_id" name="parent_id" value="<?= $subTarif[0]->id_sub ?>">

                                <div class="form-group">
                                    <label for="jenis_tarif" class="control-label">Nama Tarif :</label>
                                    <div class="controls">
                                        <input required type="text" class="form-control" name="jenis_tarif" id="jenis_tarif" placeholder="Isi nama tarif retribusi">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="satuan" class="control-label">Satuan :</label>
                                    <div class="controls">
                                        <input type="text" class="form-control" name="satuan" id="satuan" placeholder="Isi satuan tarif">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="tera_kantor" class="control-label">Tera Kantor :</label><br>
                                    <div class="controls">
                                        <input required type="text" onkeyup="changeRupe(this)" onkeypress="return inputAngka(event);" class="form-control" name="tera_kantor" id="tera_kantor" autocomplete="off" placeholder="Isi nilai tarif retribusi">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="tera_tempat_pakai" class="control-label">Tera Tempat Pakai :</label><br>
                                    <div class="controls">
                                        <input required type="text" onkeyup="changeRupe(this)" autocomplete="off" onkeypress="return inputAngka(event);" class="form-control" name="tera_tempat_pakai" id="tera_tempat_pakai" placeholder="Isi nilai tarif retribusi">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="tera_ulang_kantor" class="control-label">Tera Ulang Kantor :</label><br>
                                    <div class="controls">
                                        <input required type="text" onkeyup="changeRupe(this)" autocomplete="off" onkeypress="return inputAngka(event);" class="form-control" name="tera_ulang_kantor" id="tera_ulang_kantor" placeholder="Isi nilai tarif retribusi">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="tera_ulang_tempat_pakai" class="control-label">Tera Ulang Tempat Pakai :</label><br>
                                    <div class="controls">
                                        <input required type="text" onkeyup="changeRupe(this)" autocomplete="off" onkeypress="return inputAngka(event);" class="form-control" name="tera_ulang_tempat_pakai" id="tera_ulang_tempat_pakai" placeholder="Isi nilai tarif retribusi">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-info waves-effect waves-light" id="simpan_tarif">Save</button>
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
                            <h4 class="modal-title">Update Tarif Retribusi</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <form id="updateTarif" method="POST" action="<?= base_url().'Admin/updateSubTarif/'.encode($subTarif[0]->id_sub) ?>">
                            <div class="modal-body">

                                <input type="hidden" id="parent_id" name="parent_id" value="<?= $subTarif[0]->id_sub ?>">
                                <input type="hidden" id="id_tarif" name="id_tarif">

                                <div class="form-group">
                                    <label for="jenis_tarif" class="control-label">Nama Tarif :</label>
                                    <div class="controls">
                                        <input required type="text" class="form-control" name="jenis_tarif" id="jenis_tarif" placeholder="Isi nama tarif retribusi">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="satuan" class="control-label">Satuan :</label>
                                    <div class="controls">
                                        <input type="text" class="form-control" name="satuan" id="satuan" placeholder="Isi satuan tarif">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="tera_kantor" class="control-label">Tera Kantor :</label><br>
                                    <div class="controls">
                                        <input required type="text" onkeyup="changeRupe(this)" autocomplete="off" onkeypress="return inputAngka(event);" class="form-control" name="tera_kantor" id="tera_kantor" placeholder="Isi nilai tarif retribusi">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="tera_tempat_pakai" class="control-label">Tera Tempat Pakai :</label><br>
                                    <div class="controls">
                                        <input required type="text" onkeyup="changeRupe(this)" autocomplete="off" onkeypress="return inputAngka(event);" class="form-control" name="tera_tempat_pakai" id="tera_tempat_pakai" placeholder="Isi nilai tarif retribusi">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="tera_ulang_kantor" class="control-label">Tera Ulang Kantor :</label><br>
                                    <div class="controls">
                                        <input required type="text" onkeyup="changeRupe(this)" autocomplete="off" onkeypress="return inputAngka(event);" class="form-control" name="tera_ulang_kantor" id="tera_ulang_kantor" placeholder="Isi nilai tarif retribusi">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="tera_ulang_tempat_pakai" class="control-label">Tera Ulang Tempat Pakai :</label><br>
                                    <div class="controls">
                                        <input required type="text" onkeyup="changeRupe(this)" autocomplete="off" onkeypress="return inputAngka(event);" class="form-control" name="tera_ulang_tempat_pakai" id="tera_ulang_tempat_pakai" placeholder="Isi nilai tarif retribusi">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-info waves-effect waves-light" id="simpan_tarif">Save</button>
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

        <!-- <script type="text/javascript">
            function getDataDesa(data) {
                var id_modal = $(data).parent().parent().parent().parent().parent().parent().parent().attr('id');
                var kode = $('#'+id_modal+' #kode_kecamatan option:selected').attr('value');

                $("#loading-desa").fadeIn("slow");

                $.post("<?//= base_url().'Admin/getDataDesa' ?>", {kode_kecamatan:kode}, function(result){
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
        </script> -->
        <!-- ======================================================= -->

        <!-- UPDATE TARIF =========================================== -->
        <script type="text/javascript">

            function showModalEdit(data) {
                $('#modal-edit #updateTarif').trigger('reset');

                var id_tarif = $(data).attr('data-id');
                var jenis_tarif = $(data).attr('data-jenis');
                var satuan = $(data).attr('data-satuan');
                var tera_a = $(data).attr('data-tera-a');
                var tera_b = $(data).attr('data-tera-b');
                var tera_ulang_a = $(data).attr('data-tera-ulang-a');
                var tera_ulang_b = $(data).attr('data-tera-ulang-b');
                
                $('#modal-edit #updateTarif #id_tarif').val(id_tarif);
                $('#modal-edit #updateTarif #jenis_tarif').val(jenis_tarif);
                $('#modal-edit #updateTarif #satuan').val(satuan);
                $('#modal-edit #updateTarif #tera_kantor').val(tera_a);
                $('#modal-edit #updateTarif #tera_tempat_pakai').val(tera_b);
                $('#modal-edit #updateTarif #tera_ulang_kantor').val(tera_ulang_a);
                $('#modal-edit #updateTarif #tera_ulang_tempat_pakai').val(tera_ulang_b);

                $('#modal-edit').modal('show');
            }

        </script>

        <script type="text/javascript">

            function changeRupe(data){
                var val = formatRupiah($(data).val(), 'Rp. ');
                $(data).val(val);
            }

            /* Fungsi formatRupiah */
            function formatRupiah(angka, prefix){
                var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split           = number_string.split(','),
                sisa            = split[0].length % 3,
                rupiah          = split[0].substr(0, sisa),
                ribuan          = split[0].substr(sisa).match(/\d{3}/gi);
     
                // tambahkan titik jika yang di input sudah menjadi angka ribuan
                if(ribuan){
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }
     
                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                return prefix == undefined ? rupiah : (rupiah ? rupiah : '');
            }
        </script>
        <!-- ======================================================= -->

        <!-- HAPUS USER ================================= -->
        <script type="text/javascript">
            function showConfirmMessage(id, no) {
                swal({
                    title: "Anda yakin data akan dihapus?",
                    text: "Data tidak akan dapat di kembalikan lagi!!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Ya, Hapus!",
                    closeOnConfirm: false
                }, function () {
                    window.location.href = "<?= base_url('Admin/deleteSubTarif/').encode($subTarif[0]->id_sub).'/'?>"+id+'/'+no;
                    // $.ajax({
                    //     type : "GET",
                    //     url  : "<?php //echo base_url('Admin/deleteSubTarif/').encode($subTarif[0]->id_sub).'/'?>"+id+'/'+no,
                    //     dataType : "html",
                    //     // data : {id:id, no:no},
                    //     success: function(data){
                    //         // alert(data);
                    //         // $('#myTable').DataTable().destroy();
                    //         // $('#myTable').DataTable().draw();

                    //         if(data=='Success'){
                    //             location.reload();
                    //         }else{
                    //             location.reload();
                    //         } 
                    //     }
                    // });
                    // return false;
                    // swal("Hapus!", "Data telah berhasil dihapus.", "success");
                });
            }
        </script>
            