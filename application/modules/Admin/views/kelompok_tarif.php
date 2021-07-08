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
                    <h3 class="text-themecolor">Kelompok Tarif UTTP</h3>
                </div>

                <div class="col-md-6 align-self-center">
                    <ol class="breadcrumb">
                        <!-- <label>Jenis Perlengkapan</label> -->
                        <li class="breadcrumb-item active">Kelompok Tarif UTTP</li>
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
                        <!-- <a href="<?//= base_url().'Admin/pendaftaranTera' ?>" class="btn waves-effect waves-light btn-primary float-right"><i class="mdi mdi-file-document"></i> Pengajuan Tera</a> -->

                        <style type="text/css">
                            .dataTable > thead > tr > th[class*="sort"]:after{
                                content: "" !important;
                            }
                        </style>

                        <div class="table-responsive">
                            <table id="myTable" class="table-bordered table-striped table-hover" cellpadding="7px" width="100%">
                                <thead align="center" class="bg-megna text-white">
                                    <tr style="font-size: 10pt">
                                        <th width="70"><b>#</b></th>
                                        <th width="25%"><b>Kategori Alat Ukur</b></th>
                                        <th><b>Kelompok Tarif</b></th>
                                        <th><b>Aksi</b></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $no = 0;
                                        foreach ($dataKategori as $ktg) { 
                                            $no++;
                                    ?>
                                            <tr style="font-size: 10pt">
                                                <td align="center" width="20"><?= $no ?></td>
                                                <td><?= $ktg->nama_kategori_alat ?></td>
                                                <td>

                                                    <?php 
                                                    foreach ($dataKelompok as $kel) {
                                                        if ($kel->id_kategori_alat == $ktg->id_kategori_alat) {
                                                            echo '<div class="m-b-5"><span style="font-size: 8pt; font-weight: bold;" class="label label-inverse">'.$kel->tarif.'</span></div>';
                                                        }
                                                    } ?>
                                                </td>

                                                <td width="130" align="center">
                                                    <div class="d-none d-sm-none d-md-block d-lg-block">
                                                        <button onclick="addGroup(<?= $ktg->id_kategori_alat ?>)" class="btn btn-sm btn-inverse waves-effect waves-light m-b-5" style="width: 35px" title="Tambah Kelompok"><i class="fa fa-plus"></i></button>

                                                        <!-- <button onclick="editGroup(<?= $ktg->id_kategori_alat ?>)"  class="btn btn-sm btn-info waves-effect waves-light m-b-5" style="width: 35px" title="Edit Kelompok"><i class="fa fa-edit"></i></button> -->

                                                        <button type="button" class="btn btn-sm btn-danger waves-effect waves-light m-b-5" style="width: 35px" onclick="showConfirmMessage(<?= $ktg->id_kategori_alat ?>)" title="Hapus Kelompok"><i class="fa fa-trash"></i></button>
                                                    </div>

                                                    <div class="d-block d-sm-block d-md-none d-lg-none">
                                                        <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fa fa-cog"></i>
                                                        </button>

                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="addGroup(<?= $ktg->id_kategori_alat ?>)"><i class="fa fa-plus"></i> Tambah Kelompok Tarif</a>
                                                            <!-- <a class="dropdown-item" href="javascript:void(0)" onclick="editGroup(<?= $ktg->id_kategori_alat ?>)"><i class="fa fa-pencil-square-o"></i> Edit Kelompok Tarif</a> -->
                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="showConfirmMessage('<?= $ktg->id_kategori_alat ?>')"><i class="fa fa-trash-o"></i> Hapus Kelompok Tarif</a>
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

            <!-- Modal Add -->
            <div id="modal-add" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Tambah Kelompok Tarif</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <form id="addKelompokTarif" method="POST" action="<?= base_url().'Admin/addKelompokTarif' ?>">
                            <div class="modal-body">

                                <input type="hidden" name="id_kategori_alat" id="id_kategori_alat">

                                <div class="form-group">
                                    <select id="id_tarif" name="id_tarif[]" class="select2 m-b-10 select2-multiple" style="width: 100%" multiple="multiple" data-placeholder="Pilih Tarif" required>
                                        <?php foreach ($dataTarif as $trf) { ?>
                                            <option id="<?= $trf->id_tarif ?>" value="<?= $trf->id_tarif ?>"><?= $trf->jenis_tarif ?></option>
                                        <?php } ?>
                                    </select>
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


            <div id="modal-edit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Update Kelompok Tarif</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <form id="updateKelompokTarif" method="POST" action="<?= base_url().'Admin/updateKelompokTarif' ?>">
                            <div class="modal-body">

                                <input type="hidden" name="id_kategori_alat" id="id_kategori_alat">

                                <div class="form-group">
                                    <select name="id_tarif[]" class="select2 m-b-10 select2-multiple" style="width: 100%" multiple="multiple" data-placeholder="Pilih Tarif" required>
                                        <?php foreach ($dataTarif as $trf) { ?>
                                            <option id="<?= $trf->id_tarif ?>" value="<?= $trf->id_tarif ?>"><?= $trf->jenis_tarif ?></option>
                                        <?php } ?>
                                    </select>
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


        <!-- KIRIM PENGAJUAN =========================================== -->
        <script type="text/javascript">
            function addGroup(id) {
                $('#modal-add #addKelompokTarif').trigger("reset");
                $('#modal-add #addKelompokTarif #id_tarif').val(null).trigger('change');
                $('#modal-add #addKelompokTarif #id_kategori_alat').val(id);

                $("#loading-show").fadeIn("slow");

                $.post("<?= base_url().'Admin/getDataKelompok' ?>", {id_kategori_alat:id}, function(result){
                    $("#loading-show").fadeIn("slow").delay(20).slideUp('slow');

                    var dt = JSON.parse(result);

                    if (dt.response) {
                        var id_tarif = [];
                        for (var i = 0; i < dt.data.length; i++) {
                           id_tarif.push(dt.data[i].id_tarif);
                        }
                        // console.log(id_tarif);
                        $('#modal-add #addKelompokTarif #id_tarif').val(id_tarif).change();
                    }

                    $('#modal-add').modal('show');

                });

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
                        url  : "<?php echo base_url('Admin/deleteKelompokTarif')?>",
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

            function prosesPengajuan(id) {
                swal({
                    title: "Proses Pengajuan?",
                    text: "Proses pengajuan tera ini?",
                    type: "info",
                    showCancelButton: true,
                    confirmButtonColor: "#38a80c",
                    confirmButtonText: "Ya, Proses!",
                    closeOnConfirm: false
                }, function () {
                    window.location.href = "<?=base_url().'Admin/prosesPengajuanMasuk/' ?>"+id;
                });
            }
        </script>
            