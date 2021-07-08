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
                    <h3 class="text-themecolor">Pengajuan Masuk</h3>
                </div>

                <div class="col-md-6 align-self-center">
                    <ol class="breadcrumb">
                        <!-- <label>Jenis Perlengkapan</label> -->
                        <li class="breadcrumb-item active">Pengajuan Masuk</li>
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
                        <!-- <a href="<?//= base_url().'Petugas/pendaftaranTera' ?>" class="btn waves-effect waves-light btn-primary float-right"><i class="mdi mdi-file-document"></i> Pengajuan Tera</a> -->

                        <div class="table-responsive">
                            <table id="myTable" class="table table-bordered table-striped table-hover" style="width: 100%">
                                <thead>
                                    <tr style="font-size: 10pt">
                                        <th>#</th>
                                        <th><b>No. Order</b></th>
                                        <th><b>Pemilik</b></th>
                                        <th><b>Usaha</b></th>
                                        <th><b>Layanan</b></th>
                                        <th><b>Tempat Tera</b></th>
                                        <th><b>Tgl Daftar</b></th>
                                        <th><b>Tgl Inspeksi</b></th>
                                        <th><b>Status</b></th>
                                        <th><b>Surat</b></th>
                                        <th><b>Aksi</b></th>
                                        <th style="display: none">id</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $no = 0;
                                        foreach ($dataTera as $tera) { 
                                            $no++;
                                    ?>
                                            <tr style="font-size: 10pt; <?= ($idRow == $tera->id_daftar?'background: #ffebe6; font-weight: bold':'') ?>" id="row_<?= $tera->id_daftar ?>">
                                                <td align="center" width="20"><?= $no ?></td>
                                                <td><?= $tera->no_order ?></td>
                                                <td><?= $tera->nama_user ?></td>
                                                <td><?= $tera->jenis_usaha ?></td>
                                                <td width="70"><?= $tera->layanan ?></td>
                                                <td><?= $tera->tempat_tera ?></td>
                                                <td class="text-center" width="95"><?= date('d-m-Y', strtotime($tera->tgl_daftar)) ?></td>
                                                <td class="text-center" width="95"><?= ($tera->tgl_inspeksi == null?'-':date('d-m-Y', strtotime($tera->tgl_inspeksi))) ?></td>
                                                <td width="100" align="center">
                                                        <span style="font-size: 7.2pt; width: 75px; text-align: center;" class="label label-<?= ($tera->status=='belum kirim'?'warning':($tera->status=='diterima'?'info':($tera->status=='proses'?'primary':($tera->status=='selesai'?'success':($tera->status=='pending'?'inverse':'danger'))))) ?>"><b><?= $tera->status ?></b></span>

                                                        <?php if ($tera->status == 'ditolak') { ?>

                                                            <button style="width: 75px;" type="button" onclick="showKeterangan(<?= $tera->id_daftar ?>)" class="btn btn-sm btn-outline-danger waves-effect waves-light m-t-5"  title="Lihat Keterangan"><i class="fa fa-eye"></i> Detail</button>

                                                        <?php } else { ?>

                                                            <button style="width: 75px;" type="button" onclick="showDetail(<?= $tera->id_daftar ?>)" class="btn btn-sm btn-outline-info waves-effect waves-light m-t-5"  title="Lihat Keterangan"><i class="fa fa-eye"></i> Detail</button>

                                                        <?php } ?>
                                                </td>
                                                <td width="50">
                                                    <a target="_blank" href="<?= base_url().'assets/path_file/'.$tera->file_surat ?>" class="btn btn-sm btn-primary waves-effect waves-light m-b-5"  title="Surat Permohonan">
                                                        <span class="btn-label"><i class="fa fa-envelope"></i></span>File
                                                    </a> <br>
                                                    <!-- <a target="_blank" href="<?//= base_url().'assets/path_file/'.$tera->file_lampiran ?>" class="btn btn-sm btn-danger waves-effect waves-light m-b-5"  title="Lampiran">
                                                        <span class="btn-label"><i class="fa fa-file"></i></span>File 2
                                                    </a> -->
                                                </td>
                                                <td width="135">
                                                    <button <?= ($tera->status != 'pending'?'disabled':'') ?> type="button" class="btn btn-sm <?= ($tera->status == 'pending'?'btn-info waves-effect waves-light':'btn-default') ?> m-b-5" style="width: 35px" data-id="<?= encode($tera->id_daftar) ?>" onclick="terimaPengajuan(this)"  title="Terima Pengajuan"><i class="fa fa-check-square-o"></i></button>

                                                    <button <?= ($tera->status != 'pending'?'disabled':'') ?> type="button" class="btn btn-sm <?= ($tera->status == 'pending'?'btn-danger waves-effect waves-light':'btn-default') ?> m-b-5" style="width: 35px" onclick="tolakPengajuan(<?= $tera->id_daftar ?>)"  title="Tolak Pengajuan"><i class="fa fa-close"></i></button>

                                                    <button <?= ($tera->status != 'diterima'?'disabled':'') ?> type="button" class="btn btn-sm <?= ($tera->status == 'diterima'?'btn-warning waves-effect waves-light':'btn-default') ?> m-b-5" style="width: 35px" onclick="inputInspeksi(<?= $tera->id_daftar ?>, '<?= $tera->tgl_inspeksi?>')"  title="Proses Pengajuan"><i class="fa fa-gears"></i></button>

                                                    <button <?= ($tera->status != 'proses'?'disabled':'') ?> type="button" data-id="<?= encode($tera->id_daftar) ?>" onclick="selesaiPengajuan(this)" class="btn btn-sm <?= ($tera->status == 'proses'?'btn-success waves-effect waves-light':'btn-default') ?> m-b-5" style="width: 35px"  title="Selesai"><i class="fa fa-check"></i></button>
                                                </td>
                                                <td style="display: none"><?= $tera->id_daftar ?></td>
                                            </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>

            <!-- Modal Kirim -->
            <div id="modal-input-tgl" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Input Tanggal Inspeksi</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <form id="inputTglInspeksi" method="POST" action="<?= base_url().'Petugas/inputTglInspeksi' ?>" enctype="multipart/form-data">
                            <div class="modal-body">

                                <input type="hidden" name="id_daftar" id="id_daftar">

                                <div class="form-group">
                                    <label for="tgl_inspeksi" class="control-label">Tanggal Inspeksi :</label>
                                    <input type="text" class="form-control mydatepicker" id="tgl_inspeksi" placeholder="tanggal-bulan-tahun" name="tgl_inspeksi" required autocomplete="off">
                                </div>
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-info waves-effect waves-light" id="simpan_jalan">Proses</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal Tolak -->
            <div id="modal-tolak" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Tolak Pengajuan</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <form id="tolakPengajuan" method="POST" action="<?= base_url().'Petugas/tolakPengajuan' ?>" enctype="multipart/form-data">
                            <div class="modal-body">

                                <input type="hidden" name="id_daftar" id="id_daftar">

                                <div class="form-group">
                                    <label for="keterangan" class="control-label">Keterangan :</label>
                                    <textarea required class="form-control" name="keterangan" id="keterangan" autocomplete="off"></textarea>
                                </div>
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-danger waves-effect waves-light" id="simpan_jalan"><i class="fa fa-close"></i> Tolak</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal Tolak -->
            <div id="modal-tolak-show" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Keterangan Pengajuan Ditolak</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <!-- <form id="tolakPengajuan" method="POST" action="<?//= base_url().'Petugas/tolakPengajuan' ?>" enctype="multipart/form-data"> -->
                            <div class="modal-body">

                                <!-- <input type="hidden" name="id_daftar" id="id_daftar"> -->

                                <div class="form-group">
                                    <label for="keterangan" class="control-label">Keterangan :</label>
                                    <textarea readonly class="form-control" name="keterangan" id="keterangan" autocomplete="off" rows="5"></textarea>
                                </div>
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                <!-- <button type="submit" class="btn btn-danger waves-effect waves-light" id="simpan_jalan"><i class="fa fa-close"></i> Tolak</button> -->
                            </div>
                        <!-- </form> -->
                    </div>
                </div>
            </div>

            <!-- Modal Detail -->
            <div id="modal-detail" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Detail Pengajuan Tera UTTP</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <!-- <form id="tolakPengajuan" method="POST" action="<?//= base_url().'Petugas/tolakPengajuan' ?>" enctype="multipart/form-data"> -->
                            <div class="modal-body">

                                <!-- <input type="hidden" name="id_daftar" id="id_daftar"> -->

                                <div class="form-group">
                                    <table id="tbl_detail" border="0" width="100%" cellpadding="5" style="font-size: 10pt">
                                        <thead>
                                            <tr style="height: 50px; font-weight: bold;">
                                                <td width="7%" align="center">No</td>
                                                <td width="35%">Nama Alat</td>
                                                <td width="30%">Jenis</td>
                                                <td width="15%" align="center">Kapasitas</td>
                                                <td width="8%" align="center">Jumlah</td>
                                            </tr>
                                        </thead>
                                        <tbody border="0" style="height: 500px" id="list_uttp">
                                            <?php for ($i=0; $i < 15; $i++) {  ?>
                                                <tr style="border-bottom: 0">
                                                   <td align="center"><?= $i+1 ?></td>
                                                   <td>asdfasf</td>
                                                   <td>asdf</td>
                                                   <td>asdf</td>
                                                   <td align="center">2</td>
                                                </tr>
                                            <?php } ?>
                                       </tbody>
                                    </table>
                                </div>
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                            </div>
                        <!-- </form> -->
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


        <!-- KIRIM PENGAJUAN =========================================== -->
        <script type="text/javascript">
            function tolakPengajuan(id) {
                $('#modal-tolak #tolakPengajuan').trigger("reset");
                $('#modal-tolak #tolakPengajuan #id_daftar').val(id);
                $('#modal-tolak').modal('show');
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

            function printForm(argument) {
                    var printcontent = document.getElementById('form-print').innerHTML;
                    document.body.innerHTML = printcontent;
                    window.print();

                    window.location.href = "<?=base_url().'Petugas/pengajuanMasuk' ?>";
            }
        </script>

        <script type="text/javascript">
            // function addZero(n){
            //   if(n <= 9){
            //     return "0" + n;
            //   }
            //   return n
            // }

            function inputInspeksi(id='', tgl='') {
                $('#modal-input-tgl #inputTglInspeksi #id_daftar').val(id);

                if (tgl == '' || tgl == null) {
                    $('#modal-input-tgl #inputTglInspeksi #tgl_inspeksi').datepicker('setDate', "<?= date('d-m-Y') ?>"); 
                } else {
                    var tgl_inspeksi = new Date(tgl);

                    $('#modal-input-tgl #inputTglInspeksi #tgl_inspeksi').datepicker('setDate', addZero(tgl_inspeksi.getDate())+'-'+addZero(tgl_inspeksi.getMonth()+1)+'-'+tgl_inspeksi.getFullYear()); 
                }

                $('#modal-input-tgl').modal('show');
            }

            function selesaiPengajuan(data) {
                var id = $(data).attr('data-id');
                
                window.location.href = "<?=base_url().'Petugas/inputHasilPengujian/pengajuanMasuk/' ?>"+id;
            }

            function showKeterangan(id) {
                $("#loading-show").fadeIn("slow");

                $.post("<?= base_url().'Petugas/showKetTolak' ?>", {id_daftar:id}, function(result){
                    $("#loading-show").fadeIn("slow").delay(20).slideUp('slow');

                    var dt = JSON.parse(result);
                    // console.log(dt.data);

                    if (dt.response) {
                        $('#modal-tolak-show #keterangan').val(dt.data.keterangan);

                        $('#modal-tolak-show').modal('show');
                    }

                });
            }

            function showDetail(id) {
                $("#loading-show").fadeIn("slow");

                $.post("<?= base_url().'Petugas/getDetailPengajuan' ?>", {id_daftar:id}, function(result){
                    $("#loading-show").fadeIn("slow").delay(20).slideUp('slow');

                    var dt = JSON.parse(result);
                    // console.log(dt.listUttp);

                    if (dt.response) {
                        var list_uttp = '';
                        
                        for (var x = 0; x < dt.listUttp.length; x++) {
                            let no = x + 1;
                            list_uttp += '<tr style="border-bottom: 0">'+
                                           '<td align="center">'+no+'</td>';

                            list_uttp   +=  '<td>'+dt.listUttp[x].jenis_alat+'</td>'+
                                            '<td>'+dt.listUttp[x].kategori_alat+'</td>'+
                                            '<td align="center">'+dt.listUttp[x].kapasitas+'</td>'+
                                            '<td align="center">'+dt.listUttp[x].jumlah_uttp+'</td>';
                            list_uttp += '</tr>';
                        }

                        $('#modal-detail #list_uttp').html(list_uttp);

                        $('#modal-detail').modal('show');
                    }

                });
            }
        </script>
        <!-- ======================================================= -->

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
                        url  : "<?php echo base_url('Petugas/deletePengajuanTera')?>",
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

            function terimaPengajuan(data) {
                var id = $(data).attr('data-id');
                // swal({
                //     title: "Terima Pengajuan",
                //     text: "Terima pengajuan tera ini?",
                //     type: "info",
                //     showCancelButton: true,
                //     confirmButtonColor: "#38a80c",
                //     confirmButtonText: "Ya, Terima!",
                //     closeOnConfirm: false
                // }, function () {
                //     window.location.href = "<?//=base_url().'Petugas/terimaPengajuanMasuk/' ?>"+id;
                // });
                window.location.href = "<?=base_url().'Petugas/showTerimaPengajuan/' ?>"+id;
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
                    window.location.href = "<?=base_url().'Petugas/prosesPengajuanMasuk/' ?>"+id;
                });
            }
        </script>
            