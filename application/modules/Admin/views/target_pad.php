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
                    <h3 class="text-themecolor">Target PAD</h3>
                </div>

                <div class="col-md-6 align-self-center">
                    <ol class="breadcrumb">
                        <!-- <label>Target Perlengkapan</label> -->
                        <li class="breadcrumb-item active">Target PAD</li>
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
                        <button class="btn waves-effect waves-light btn-inverse float-right" onclick="tambahData()"><i class="fa fa-plus"></i> Tambah Data</button>
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
                                    <tr style="font-size: 12pt">
                                        <th width="70"><b>#</b></th>
                                        <th width="200"><b>Tahun</b></th>
                                        <th><b>Target (Rp)</b></th>
                                        <th width="125"><b>Aksi</b></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $no = 0;
                                        foreach ($data_pad as $pad) { 
                                            $no++;
                                    ?>
                                            <tr style="font-size: 12pt; font-weight: bold">
                                                <td align="center" width="20"><?= $no ?></td>
                                                <td align="center"><?= $pad->tahun_pad ?></td>
                                                <td align="center"><?= nominal($pad->target_pad) ?></td>

                                                <td width="130" align="center">
                                                    <div class="d-none d-sm-none d-md-block d-lg-block">
                                                        <button type="button" data-id="<?= $pad->id_target_pad ?>" data-thn="<?= $pad->tahun_pad ?>" data-target="<?= nominal($pad->target_pad) ?>" onclick="editData(this)" class="btn btn-sm btn-info waves-effect waves-light m-b-5" style="width: 35px" title="Edit Target PAD"><i class="fa fa-edit"></i></button>

                                                        <button type="button" class="btn btn-sm btn-danger waves-effect waves-light m-b-5" style="width: 35px" onclick="showConfirmMessage(<?= $pad->id_target_pad ?>)" title="Hapus Target PAD"><i class="fa fa-trash"></i></button>
                                                    </div>

                                                    <div class="d-block d-sm-block d-md-none d-lg-none">
                                                        <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fa fa-cog"></i>
                                                        </button>

                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="javascript:void(0)" data-id="<?= $pad->id_target_pad ?>" data-thn="<?= $pad->tahun_pad ?>" data-target="<?= nominal($pad->target_pad) ?>" onclick="editData(this)"><i class="fa fa-pencil-square-o"></i> Edit Target PAD</a>
                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="showConfirmMessage('<?= $pad->id_target_pad ?>')"><i class="fa fa-trash-o"></i> Hapus Target PAD</a>
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

            <!-- Modal Tambah -->
            <div id="modal-tambah" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Tambah Target PAD</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <form id="tambahTargetPad" method="POST" action="<?= base_url().'Admin/tambahTargetPad' ?>">
                            <div class="modal-body">

                                <!-- <input type="hidden" name="id_target_pad" id="id_target_pad"> -->

                                <div class="form-group">
                                    <label for="tahun_pad" class="control-label">Tahun:</label>
                                    <input type="text" class="form-control" id="tahun_pad" onkeypress="return inputAngka(event);" placeholder="Ex: 2019" name="tahun_pad" maxlength="4" required autocomplete="off">
                                </div>

                                <div class="form-group">
                                    <label for="target_pad" class="control-label">Nominal Target (Rp):</label>
                                    <input type="text" class="form-control" id="target_pad" onkeyup="changeRupe(this)" onkeypress="return inputAngka(event);" placeholder="Ex: 150.000" name="target_pad" required autocomplete="off">
                                </div>
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-info waves-effect waves-light" id="simpan_kategori"><i class="fa fa-save"></i> Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <div id="modal-edit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Update Target PAD</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <form id="updateTargetPad" method="POST" action="<?= base_url().'Admin/updateTargetPad' ?>">
                            <div class="modal-body">

                                <input type="hidden" name="id_target_pad" id="id_target_pad">

                                <div class="form-group">
                                    <label for="tahun_pad" class="control-label">Tahun:</label>
                                    <input type="text" class="form-control" id="tahun_pad" onkeypress="return inputAngka(event);" placeholder="Ex: 2019" name="tahun_pad" maxlength="4" required autocomplete="off">
                                </div>

                                <div class="form-group">
                                    <label for="target_pad" class="control-label">Nominal Target (Rp):</label>
                                    <input type="text" class="form-control" id="target_pad" onkeyup="changeRupe(this)" onkeypress="return inputAngka(event);" placeholder="Ex: 150.000" name="target_pad" required autocomplete="off">
                                </div>
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-info waves-effect waves-light" id="simpan_Target"><i class="fa fa-save"></i> Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->


        <!-- OPERASI DATA =========================================== -->
        <script type="text/javascript">
            function tambahData() {
                $('#modal-tambah #tambahTargetPad').trigger("reset");

                $('#modal-tambah').modal('show');
            }

            function editData(data) {
                var id = $(data).attr('data-id');
                var tahun = $(data).attr('data-thn');
                var target = $(data).attr('data-target');

                $('#modal-edit #id_target_pad').val(id);
                $('#modal-edit #tahun_pad').val(tahun);
                $('#modal-edit #target_pad').val(target);

                $('#modal-edit').modal('show');
            }
        </script>

        <script type="text/javascript">
            function addZero(n){
              if(n <= 9){
                return "0" + n;
              }
              return n
            }


            function nama_bulan(bln) {
                var bulan = [
                    'Januari',
                    'Februari',
                    'Maret',
                    'April',
                    'Mei',
                    'Juni',
                    'Juli',
                    'Agustus',
                    'September',
                    'Oktober',
                    'November',
                    'Desember'
                ];

                return bulan[bln];
            }

            // function printForm(argument) {
            //         var printcontent = document.getElementById('form-print').innerHTML;
            //         document.body.innerHTML = printcontent;
            //         window.print();

            //         window.location.href = "<?//=base_url().'Admin/pengajuanMasuk' ?>";
            // }
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

        <!-- ======================================================= -->

        <!-- HAPUS DATA ================================= -->
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
                        url  : "<?php echo base_url('Admin/deleteTargetPad')?>",
                        dataType : "html",
                        data : {id:id},
                        success: function(data){

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
            