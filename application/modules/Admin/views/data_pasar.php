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
                    <h3 class="text-themecolor">Data Pasar</h3>
                </div>

                <div class="col-md-6 align-self-center">
                    <ol class="breadcrumb">
                        <!-- <label>Jenis Perlengkapan</label> -->
                        <li class="breadcrumb-item active">Data Pasar</li>
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
                                        <th><b>Nama Pasar</b></th>
                                        <th><b>Desa</b></th>
                                        <th><b>Kecamatan</b></th>
                                        <th><b>Aksi</b></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $no = 0;
                                        foreach ($dataPasar as $psr) { 
                                            $no++;
                                    ?>
                                            <tr style="font-size: 12pt">
                                                <td align="center" width="20"><?= $no ?></td>
                                                <td><?= $psr->nama_pasar ?></td>
                                                <td><?= $psr->nama_desa ?></td>
                                                <td><?= $psr->nama_kecamatan ?></td>

                                                <td width="130" align="center">
                                                    <div class="d-none d-sm-none d-md-block d-lg-block">
                                                        <button type="button" data-id="<?= $psr->id_pasar ?>" data-nama="<?= $psr->nama_pasar ?>" data-desa="<?= $psr->kode_desa ?>" onclick="editData(this)" class="btn btn-sm btn-info waves-effect waves-light m-b-5" style="width: 35px" title="Edit Data Pasar"><i class="fa fa-edit"></i></button>

                                                        <button type="button" class="btn btn-sm btn-danger waves-effect waves-light m-b-5" style="width: 35px" onclick="showConfirmMessage(<?= $psr->id_pasar ?>)" title="Hapus Data Pasar"><i class="fa fa-trash"></i></button>
                                                    </div>

                                                    <div class="d-block d-sm-block d-md-none d-lg-none">
                                                        <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fa fa-cog"></i>
                                                        </button>

                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="javascript:void(0)" data-id="<?= $psr->id_pasar ?>" data-nama="<?= $psr->nama_pasar ?>" data-desa="<?= $psr->kode_desa ?>" onclick="editData(this)"><i class="fa fa-pencil-square-o"></i> Edit Data Pasar</a>
                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="showConfirmMessage('<?= $psr->id_pasar ?>')"><i class="fa fa-trash-o"></i> Hapus Data Pasar</a>
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
            <div id="modal-tambah" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Tambah Data Pasar</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <form id="inputDataPasar" method="POST" action="<?= base_url().'Admin/inputDataPasar' ?>">
                            <div class="modal-body">

                                <!-- <input type="hidden" name="id_pasar" id="id_pasar"> -->

                                <div class="form-group">
                                    <label for="nama_pasar" class="control-label">Nama Data Pasar:</label>
                                    <input type="text" class="form-control" id="nama_pasar" placeholder="Masukkan nama pasar" name="nama_pasar" required autocomplete="off">
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
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-info waves-effect waves-light" id="simpan_kategori"><i class="fa fa-save"></i> Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <div id="modal-edit" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Update Data Pasar</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <form id="updateDataPasar" method="POST" action="<?= base_url().'Admin/updateDataPasar' ?>">
                            <div class="modal-body">

                                <input type="hidden" name="id_pasar" id="id_pasar">

                                <div class="form-group">
                                    <label for="nama_pasar" class="control-label">Nama Data Pasar:</label>
                                    <input type="text" class="form-control" id="nama_pasar" placeholder="Masukkan nama pasar" name="nama_pasar" required autocomplete="off">
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
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-info waves-effect waves-light" id="simpan_jenis"><i class="fa fa-save"></i> Update</button>
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
                $('#modal-tambah #inputDataPasar').trigger("reset");

                $('#modal-tambah').modal('show');
            }

            function editData(data) {
                var id = $(data).attr('data-id');
                var nama = $(data).attr('data-nama');
                var kode_desa = $(data).attr('data-desa');

                $('#modal-edit #id_pasar').val(id);
                $('#modal-edit #nama_pasar').val(nama);

                $("#loading-show").fadeIn("slow");

                $.post("<?= base_url().'Admin/getDataPasar' ?>", {kode_desa:kode_desa}, function(result){
                    $("#loading-show").fadeIn("slow").delay(20).slideUp('slow');

                    var dt = JSON.parse(result);

                    if (dt.response) {
                        $('#modal-edit #kode_kecamatan').val(dt.kode_kecamatan).prop('selected',true);
                        $('#modal-edit #kode_kecamatan').val(dt.kode_kecamatan).select2("destroy");
                        $('#modal-edit #kode_kecamatan').val(dt.kode_kecamatan).select2();

                        var list = '';
                        for (var i = 0; i < dt.dataDesa.length; i++) {
                            list += '<option value="'+dt.dataDesa[i].kode_desa+'">'+dt.dataDesa[i].nama_desa+'</option>';
                        }

                        $('#modal-edit #kode_desa').html(list);
                        $('#modal-edit #kode_desa').val(kode_desa).prop('selected',true);

                        $('#modal-edit').modal('show');
                    }

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

        <script type="text/javascript">
            function getDataDesa(data) {
                var id_modal = $(data).parent().parent().parent().parent().parent().parent().parent().attr('id');
                var kode = $('#'+id_modal+' #kode_kecamatan option:selected').attr('value');

                $("#loading-desa").fadeIn("slow");

                $.post("<?= base_url().'Admin/getDataDesa' ?>", {kode_kecamatan:kode}, function(result){
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
                        url  : "<?php echo base_url('Admin/deleteDataPasar')?>",
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
            