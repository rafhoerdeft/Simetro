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
                    <h3 class="text-themecolor">Data Kelompok Pasar</h3>
                </div>

                <div class="col-md-6 align-self-center">
                    <ol class="breadcrumb">
                        <!-- <label>Jenis Perlengkapan</label> -->
                        <li class="breadcrumb-item active">Data Kelompok Pasar</li>
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
                    <div class="card-body" style="margin-bottom: -5px">
                        <div class="row">
                            <div class="col-md-4 m-b-5">
                                <!-- <label>Status pengajuan: </label> -->
                                <select class="form-control" id="select_pasar" onchange="changeStatus()">
                                    <?php foreach ($dataPasar as $psr) { ?>
                                        <option value="<?= encode($psr->id_pasar) ?>" <?= ($selectPasar == $psr->id_pasar?'selected':'') ?>><?= $psr->nama_pasar ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-8"> </div>
                                    <div class="col-md-4"> 
                                        <button class="btn btn-block waves-effect waves-light btn-inverse float-right" onclick="tambahData()"><i class="fa fa-plus"></i> Tambah Data</button>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>


                <div class="card">
                    <div class="card-body p-b-20">
                        <!-- <button class="btn waves-effect waves-light btn-inverse float-right" onclick="tambahData()"><i class="fa fa-plus"></i> Tambah Data</button>
                        <br><br>
                        <hr> -->

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
                                        <th><b>Nama User</b></th>
                                        <th><b>Nama Usaha</b></th>
                                        <th><b>Jenis Usaha</b></th>
                                        <th><b>Nama Pasar</b></th>
                                        <th><b>Aksi</b></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $no = 0;
                                        foreach ($dataKelPasar as $psr) { 
                                            $no++;
                                    ?>
                                            <tr style="font-size: 11pt">
                                                <td align="center" width="20"><?= $no ?></td>
                                                <td><?= $psr->nama_user ?></td>
                                                <td><?= ($psr->nama_usaha!=null?$psr->nama_usaha:'-') ?></td>
                                                <td><?= $psr->nama_jenis_usaha ?></td>
                                                <td><?= $psr->nama_pasar ?></td>

                                                <td align="center">
                                                    <div class="d-none d-sm-none d-md-block d-lg-block" style="width: 75px;">
                                                        <button type="button" 
                                                            data-id="<?= $psr->id_grup ?>" 
                                                            data-id-usr="<?= $psr->id_user ?>" 
                                                            data-nama-usr="<?= $psr->nama_user ?>" 
                                                            data-id-ush="<?= $psr->id_usaha ?>" 
                                                            data-id-psr="<?= $psr->id_pasar ?>" 
                                                            onclick="editData(this)" class="btn btn-sm btn-info waves-effect waves-light m-b-5" style="width: 35px" title="Edit Kelompok Pasar">
                                                            <i class="fa fa-edit"></i>
                                                        </button>

                                                        <button type="button" class="btn btn-sm btn-danger waves-effect waves-light m-b-5" style="width: 35px" onclick="showConfirmMessage(<?= $psr->id_grup ?>)" title="Hapus Kelompok Pasar"><i class="fa fa-trash"></i></button>
                                                    </div>

                                                    <div class="d-block d-sm-block d-md-none d-lg-none">
                                                        <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fa fa-cog"></i>
                                                        </button>

                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="javascript:void(0)" 
                                                                data-id="<?= $psr->id_grup ?>" 
                                                                data-id-usr="<?= $psr->id_user ?>" 
                                                                data-nama-usr="<?= $psr->nama_user ?>" 
                                                                data-id-ush="<?= $psr->id_usaha ?>" 
                                                                data-id-psr="<?= $psr->id_pasar ?>"  onclick="editData(this)"><i class="fa fa-pencil-square-o"></i> Edit Kelompok Pasar
                                                            </a>
                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="showConfirmMessage('<?= $psr->id_grup ?>')"><i class="fa fa-trash-o"></i> Hapus Kelompok Pasar</a>
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

                        <!-- <br>
                        <div class="row">
                            <div style="text-decoration: none; margin: auto;">
                                <?= $pages ?>
                            </div>
                        </div> -->

                    </div>
                </div>

            </div>

            <!-- Modal Tambah -->
            <div id="modal-tambah" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <style type="text/css">
                        ul.ui-autocomplete {
                            z-index: 1100;
                        }
                    </style>
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Tambah Kelompok Pasar</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <form id="inputKelompokPasar" method="POST" action="<?= base_url().'Admin/inputKelompokPasar' ?>">
                            <div class="modal-body">

                                <!-- <input type="hidden" name="id_grup" id="id_grup"> -->

                                <div class="form-group">
                                    <label for="users" class="control-label">Pilih User :</label>
                                    <input type="text" name="users" onchange="changeDataUser(this)" id="users" class="form-control autocomplete" autocomplete="off" placeholder="Pilih user yang terdaftar">
                                    <div id="counter_found" style="font-size: 10pt; color: red"></div>
                                </div>
                                <input type="hidden" name="cek" id="cek">

                                <div class="form-group">
                                    <label for="id_usaha" class="control-label">Pilih Usaha :</label>
                                    <select required id="id_usaha" name="id_usaha" class="form-control">
                                        <option selected value="" disabled style="color: #d6d6d6">Pilih usaha Anda yang tersedia</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="id_pasar" class="control-label">Data Pasar :</label>
                                    <div class="controls">
                                        <select required id="id_pasar" name="id_pasar" class="select2 form-control custom-select" style="width: 100%; height:36px;">
                                            <option selected value="" disabled style="color: #d6d6d6">Pilih Pasar</option>
                                            <?php foreach ($dataPasar as $psr) { ?>
                                                <option value="<?= $psr->id_pasar ?>"><?= $psr->nama_pasar ?></option>
                                            <?php } ?>
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
                            <h4 class="modal-title">Update Kelompok Pasar</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <form id="updateKelompokPasar" method="POST" action="<?= base_url().'Admin/updateKelompokPasar/'.$this->uri->segment(3) ?>">
                            <div class="modal-body">

                                <input type="hidden" name="id_grup" id="id_grup">

                                <div class="form-group">
                                    <label for="users" class="control-label">Pilih User :</label>
                                    <input type="text" name="users" onchange="changeDataUser(this)" id="users" class="form-control autocomplete" autocomplete="off" placeholder="Pilih user yang terdaftar">
                                    <div id="counter_found" style="font-size: 10pt; color: red"></div>
                                </div>
                                <input type="hidden" name="cek" id="cek">

                                <div class="form-group">
                                    <label for="id_usaha" class="control-label">Pilih Usaha :</label>
                                    <select required id="id_usaha" name="id_usaha" class="form-control">
                                        <option selected value="" disabled style="color: #d6d6d6">Pilih usaha Anda yang tersedia</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="id_pasar" class="control-label">Data Pasar :</label>
                                    <div class="controls">
                                        <select required id="id_pasar" name="id_pasar" class="select2 form-control custom-select" style="width: 100%; height:36px;">
                                            <option selected value="" disabled style="color: #d6d6d6">Pilih Pasar</option>
                                            <?php foreach ($dataPasar as $psr) { ?>
                                                <option value="<?= $psr->id_pasar ?>"><?= $psr->nama_pasar ?></option>
                                            <?php } ?>
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
                $('#modal-tambah #inputKelompokPasar').trigger("reset");

                $('#modal-tambah').modal('show');
            }

            function editData(data) {
                var id_grup = $(data).attr('data-id');
                var id_user = $(data).attr('data-id-usr');
                var nama_user = $(data).attr('data-nama-usr');
                var id_usaha = $(data).attr('data-id-ush');
                var id_pasar = $(data).attr('data-id-psr');

                $('#modal-edit #id_grup').val(id_grup);
                $('#modal-edit #users').val(nama_user);
                getDataUsaha(id_user, 'modal-edit');
                $('#modal-edit #id_usaha').val(id_usaha).change();
                $('#modal-edit #id_pasar').val(id_pasar).change();

                $('#modal-edit').modal('show');
                
            }

            function changeStatus() {
                var pasar = $('#select_pasar option:selected').attr('value');

                window.location.href = "<?=base_url().'Admin/kelompokPasar/' ?>"+pasar;
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
            // function getDataDesa(data) {
            //     var id_modal = $(data).parent().parent().parent().parent().parent().parent().parent().attr('id');
            //     var kode = $('#'+id_modal+' #kode_kecamatan option:selected').attr('value');

            //     $("#loading-desa").fadeIn("slow");

            //     $.post("<?//= base_url().'Admin/getDataDesa' ?>", {kode_kecamatan:kode}, function(result){
            //         $("#loading-desa").fadeIn("slow").delay(100).slideUp('slow');

            //         var dt = JSON.parse(result);
            //         console.log(dt.data);

            //         if (dt.response) {
            //             var list = '';
            //             for (var i = 0; i < dt.data.length; i++) {
            //                 list += '<option value="'+dt.data[i].kode_desa+'">'+dt.data[i].nama_desa+'</option>';
            //             }

            //             $('#'+id_modal+' #kode_desa').html(list);
            //         }

            //     });
            // }
        </script>

        <script type="text/javascript">
            function getDataUsaha(id_user, modal='') {
                
                $("#loading-show").fadeIn("slow");
                $.post("<?= base_url().'Admin/getDataUsaha' ?>", {id_user:id_user}, function(result){
                    $("#loading-show").fadeIn("slow").delay(20).slideUp('slow');

                    var dt = JSON.parse(result);
                    // console.log(dt.data);
                    if (dt.response) {
                        var opt = '';
                        opt += '<option selected value="" disabled style="color: #d6d6d6">Pilih usaha Anda yang tersedia</option>';

                        for (var i = 0; i < dt.data.length; i++) {
                            var nama_usaha = '';
                            if (dt.data[i].nama_usaha != null) {
                                nama_usaha = ' - '+dt.data[i].nama_usaha;
                            }
                            opt += '<option value="'+dt.data[i].id_usaha+'">'+dt.data[i].jenis_usaha+nama_usaha+'</option>';
                        }

                        $('#'+modal+' #id_usaha').html(opt);
                    }
                });
            }

            function clearDataUsaha(modal='') {
                // alert(modal);
                var opt = '<option selected value="" disabled style="color: #d6d6d6">Pilih usaha Anda yang tersedia</option>';
                $('#'+modal+' #id_usaha').html(opt);
            }

            function changeDataUser(data) {
                var modal = $(data).parent().parent().parent().parent().parent().parent().attr('id');
                var cek = $('#'+modal+' #cek').val();
                if (cek == '' || cek == null) {
                    $(data).val('');
                    var opt = '<option selected value="" disabled style="color: #d6d6d6">Pilih usaha Anda yang tersedia</option>';
                    $('#'+modal+' #id_usaha').html(opt);
                    // removeAllUttp(0);
                }
                
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
                        url  : "<?php echo base_url('Admin/deleteKelompokPasar')?>",
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
            