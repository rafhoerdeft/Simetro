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
                    <h3 class="text-themecolor">Hasil Pengujian</h3>
                </div>

                <div class="col-md-6 align-self-center">
                    <ol class="breadcrumb">
                        <!-- <label>Jenis Perlengkapan</label> -->
                        <li class="breadcrumb-item active">Hasil Pengujian</li>
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
            <?php 
                $namaUser = $this->session->userdata('nama_user');
            ?>
            
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
                            <table id="myTable" class="table table-bordered table-striped table-hover">
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
                                        <!-- <th><b>File</b></th> -->
                                        <th><b>Aksi</b></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $no = 0;
                                        foreach ($dataTera as $tera) { 
                                            $no++;
                                    ?>
                                            <tr style="font-size: 10pt">
                                                <td align="center" width="20"><?= $no ?></td>
                                                <td><?= $tera->no_order ?></td>
                                                <td><?= $tera->nama_user ?></td>
                                                <td><?= $tera->jenis_usaha ?></td>
                                                <td width="70"><?= $tera->layanan ?></td>
                                                <td><?= $tera->tempat ?></td>
                                                <td class="text-center" width="95"><?= date('d-m-Y', strtotime($tera->tgl_daftar)) ?></td>
                                                <td class="text-center" width="95"><?= ($tera->tgl_inspeksi == null?'-':date('d-m-Y', strtotime($tera->tgl_inspeksi))) ?></td>
                                                <?php 
                                                    foreach ($bayar as $byr) { 
                                                        if ($byr['id_daftar'] == $tera->id_daftar) {
                                                ?>
                                                <td width="100"><span style="font-size: 7.2pt; width: 85px; text-align: center; font-weight: bold;" class="label label-<?= ($tera->bayar > 0?($tera->nominal_bayar >= $byr['tot_tarif']?'success':'warning'):'danger') ?>"><?= ($tera->bayar > 0?($tera->nominal_bayar >= $byr['tot_tarif']?'Lunas':'Belum Lunas'):'Belum Bayar') ?></span></td>
                                                <?php }} ?>

                                                <td width="100">
                                                    <a href="<?= base_url('Petugas/cetakHasilPengujian/'.encode($tera->id_daftar)) ?>" class="btn btn-sm btn-danger waves-effect waves-light m-b-5" style="width: 35px"  title="Cetak Hasil"><i class="fa fa-file-text-o"></i></a>

                                                    <?php 
                                                        foreach ($bayar as $byr) { 
                                                            if ($byr['id_daftar'] == $tera->id_daftar) {
                                                    ?>
                                                            <button type="button" data-id="<?= $tera->id_daftar ?>" data-bayar="<?= $byr['tot_tarif'] ?>" class="btn btn-sm btn-info waves-effect waves-light m-b-5" style="width: 35px" onclick="inputBayar(this)"  title="Bayar"><i class="fa fa-money"></i></button>
                                                    <?php }} ?>

                                                    <button type="button" <?= ($tera->bayar==0?'disabled':'') ?> class="btn btn-sm <?= ($tera->bayar==0?'btn-default':'btn-inverse waves-effect waves-light') ?> m-b-5" style="width: 35px" onclick="cetakKwitansi(<?= $tera->id_daftar ?>)"  title="Cetak Kwitansi"><i class="fa fa-credit-card-alt"></i></button>

                                                </td>
                                            </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>

            <!-- Modal Bayar -->
            <div id="modal-bayar" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Input Pembayaran</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <form id="inputPembayaran" method="POST" action="<?= base_url().'Petugas/inputPembayaran' ?>" enctype="multipart/form-data">
                            <div class="modal-body">

                                <input type="hidden" name="id_daftar" id="id_daftar">

                                <div class="form-group">
                                    <label for="nominal_bayar" class="control-label">Total Bayar: <b id="tot_tarif">Rp. 150.000,-</b></label>
                                </div>

                                <div class="form-group">
                                    <label for="nominal_bayar" class="control-label">Nominal Bayar (Rp):</label>
                                    <input type="text" class="form-control" id="nominal_bayar" onkeyup="changeRupe(this)" onkeypress="return inputAngka(event);" placeholder="Ex: 150.000" name="nominal_bayar" required autocomplete="off">
                                </div>

                                <div class="form-group">
                                    <label for="tgl_bayar" class="control-label">Tanggal Bayar:</label>
                                    <input type="text" class="form-control mydatepicker" id="tgl_bayar" placeholder="tanggal-bulan-tahun" name="tgl_bayar" required autocomplete="off">
                                </div>
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-info waves-effect waves-light" id="simpan_jalan">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <div id="modal-kwitansi" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg">
                    
                    <div class="modal-content" style="margin: 0 -20%; width: 140%;">
                        <div class="modal-header">
                            <h4 class="modal-title">Cetak Kwitansi</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body" id="form-print">
                            <table border="0" width="100%" style="font-size: 14pt; color: black; font-family: arial; margin: auto; z-index: 2; border: solid 2px;" cellpadding="10">
                                <tr>
                                    <td width="150" valign="top">
                                        <table>
                                            <tr>
                                                <td style="text-align: center;" valign="top">
                                                    <img src="<?= base_url().'assets/assets/images/logo/logo_kab_mgl_xs.png' ?>" width="100">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div style="border: solid 2px; width: 150px; text-align: center; font-weight: bold; font-size: 12pt; line-height: 20px; padding: 5px 0; margin-top: 5px">
                                                        <span>KWITANSI TERA INI JIKA DIMINTA HARUS DIPERLIHATKAN</span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td height="35">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div style="width: 150px; text-align: center; font-weight: bold; font-size: 12pt; padding: 5px 0;">
                                                        <table style="border: solid 2px;">
                                                            <tr>
                                                                <td width="50" style="border: solid 2px;">Reg.</td>
                                                                <td width="50" style="border: solid 2px;">Hal.</td>
                                                                <td width="50" style="border: solid 2px;">No.</td>
                                                            </tr>
                                                            <tr>
                                                                <td id="reg" height="40" style="border: solid 2px;"></td>
                                                                <td id="hal" height="40" style="border: solid 2px;"></td>
                                                                <td id="no" height="40" style="border: solid 2px;"></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>

                                    <td valign="top">
                                        <table width="100%">
                                            <tr>
                                                <td width="25%" colspan="2" height="40"></td>
                                                <td width="400" style="font-weight: bold; text-decoration: underline;" valign="top">KWITANSI RETRIBUSI TERA/TERA ULANG</td>
                                                <td width="10%"></td>
                                                <td width="200" style="font-weight: bold" valign="top" align="right">No. <span id="nomor"></span></td>
                                            </tr>
                                            <tr>
                                                <td align="left" style="font-size: 12pt">Sudah terima dari</td>
                                                <td>:</td>
                                                <td colspan="3" style="border: solid 1px; padding: 0 5px; font-size: 12pt">
                                                    <div id="pembayar"></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left" valign="top" style="font-size: 12pt">Untuk pembayaran</td>
                                                <td valign="top">:</td>
                                                <td colspan="3" style="border: solid 1px; height: 150px; vertical-align: top; padding: 0 5px; font-size: 12pt">
                                                    <div style="text-align: justify;">
                                                        Biaya tera/tera ulang alat ukur, takar, timbang dan perlengkapannya (UTTP), dengan rincian sbb :
                                                    </div>
                                                    <style type="text/css">
                                                        #list_rincian ul {
                                                          list-style: none;
                                                          margin-left: 0;
                                                          padding-left: 0;
                                                        }

                                                        #list_rincian ul li {
                                                          padding-left: 1em;
                                                          text-indent: -1em;
                                                        }

                                                        #list_rincian ul li:before {
                                                          content: "-";
                                                          padding-right: 5px;
                                                        }
                                                    </style>
                                                    <div id="list_rincian">
                                                        <ul id="rincian"></ul>
                                                    </div>
                                                    
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left" style="font-size: 12pt">Uang sebanyak</td>
                                                <td>:</td>
                                                <td colspan="3" style="border: solid 1px; padding: 0 5px; font-size: 12pt">
                                                    <div id="terbilang" style="font-weight: bold"></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="right">Rp.</td>
                                                <td></td>
                                                <td style="border: solid 1px; padding: 0 5px; width: 150px; background: lightgrey">
                                                    <div id="nominal" style="font-weight: bold"></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">
                                                    <div style="border: solid 2px; font-size: 10pt; font-weight: bold; width: 450px; text-align: justify; padding: 5px 10px; background: lightgrey;">
                                                        Berdasarkan Peraturan Daerah No 1 Tahun 2018 tentang Perubahan Ketiga atas Peraturan Daerah Kabupaten Magelang Nomor 3 Tahun 2012 Tentang Retribusi Jasa Umum.
                                                    </div>
                                                </td>
                                                <td colspan="2">
                                                    <div style="text-align: center; font-size: 12pt">
                                                        Kota Mungkid, <span id="tanggal_cetak">......................</span>
                                                        <br>Kasir/Pemegang Surat Kuasa,<br><br><br>
                                                        <div id="ttd_nama"><?= ucfirst($namaUser) ?></div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-danger waves-effect waves-light" onclick="printForm()"><i class="fa fa-print"></i> Print</button>
                        </div>
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
            function kirimPengajuan(id) {
                $('#modal-kirim #kirimPengajuan').trigger("reset");
                $('#modal-kirim #kirimPengajuan #id_daftar').val(id);
                $('#modal-kirim').modal('show');
            }
        </script>

        <script type="text/javascript">
            function inputBayar(data) {
                var id = $(data).attr('data-id');
                var tot_tarif = $(data).attr('data-bayar');
                $('#modal-bayar #inputPembayaran #id_daftar').val(id);
                $('#modal-bayar #inputPembayaran #tot_tarif').html('Rp. '+formatRupiah(tot_tarif, 'Rp.')+',-');
                $('#modal-bayar #inputPembayaran #nominal_bayar').val('');
                $('#modal-bayar #inputPembayaran #tgl_bayar').datepicker('setDate', "<?= date('d-m-Y') ?>"); 

                $("#loading-show").fadeIn("slow");

                $.post("<?= base_url().'Petugas/getDataPembayaran' ?>", {id_daftar:id}, function(result){
                    $("#loading-show").fadeIn("slow").delay(20).slideUp('slow');

                    var dt = JSON.parse(result);

                    if (dt.response) {
                        var tgl_bayar = new Date(dt.data.tgl_bayar);
                        $('#modal-bayar #inputPembayaran #nominal_bayar').val(formatRupiah(dt.data.nominal_bayar, 'Rp.'));
                        $('#modal-bayar #inputPembayaran #tgl_bayar').datepicker('setDate', addZero(tgl_bayar.getDate())+'-'+addZero(tgl_bayar.getMonth()+1)+'-'+tgl_bayar.getFullYear()); 
                    }

                    $('#modal-bayar').modal('show');

                });
            }

            function cetakKwitansi(id='') {
                $('#modal-kwitansi #reg').html('');
                $('#modal-kwitansi #hal').html('');
                $('#modal-kwitansi #no').html('');
                $('#modal-kwitansi #nomor').html('');
                $('#modal-kwitansi #pembayar').html('');
                $('#modal-kwitansi #rincian').html('');
                $('#modal-kwitansi #terbilang').html('');
                $('#modal-kwitansi #nominal').html('');
                $('#modal-kwitansi #tanggal_cetak').html('');
                // $('#modal-kwitansi #ttd_nama').html('');

                $("#loading-show").fadeIn("slow");

                $.post("<?= base_url().'Petugas/getDataKwitansi' ?>", {id_daftar:id}, function(result){
                    $("#loading-show").fadeIn("slow").delay(20).slideUp('slow');

                    var dt = JSON.parse(result);
                    // console.log('data', dt);

                    if (dt.response) {
                        var pembayar = dt.nama_user;
                        if (dt.nama_usaha != null) {
                            pembayar = dt.nama_user+' / '+dt.nama_usaha;
                        }

                        $('#modal-kwitansi #nomor').html(dt.no_order);
                        $('#modal-kwitansi #pembayar').html(pembayar);

                        if (dt.rincian != null) {
                            var rincian = '';
                            for (var i = 0; i < dt.rincian.length; i++) {
                                rincian += '<li>'+dt.rincian[i].uttp+' - '+dt.rincian[i].jenis_tarif+' ('+formatRupiah(dt.rincian[i].tarif, 'Rp.')+') x '+dt.rincian[i].jml_uttp+'</li>';
                            }
                            $('#modal-kwitansi #rincian').html(rincian);
                        }

                        var tgl_cetak = new Date("<?= date('Y-m-d') ?>");
                        var nominal = dt.total.toString();
                        $('#modal-kwitansi #terbilang').html(dt.terbilang);
                        $('#modal-kwitansi #nominal').html(formatRupiah(nominal, 'Rp.'));
                        $('#modal-kwitansi #tanggal_cetak').html(addZero(tgl_cetak.getDate())+' '+nama_bulan(tgl_cetak.getMonth()+1)+' '+tgl_cetak.getFullYear());
                        // $('#modal-kwitansi #ttd_nama').html('');

                        $('#modal-kwitansi').modal('show');
                    }

                });
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

                    window.location.href = "<?=base_url().'Petugas/hasilPengujian' ?>";
            }
        </script>

        <script type="text/javascript">
            // function addZero(n){
            //   if(n <= 9){
            //     return "0" + n;
            //   }
            //   return n
            // }

            // function inputInspeksi(id='', tgl='') {
            //     $('#modal-input-tgl #inputTglInspeksi #id_daftar').val(id);
                
            //     if (tgl == '' || tgl == null) {
            //         $('#modal-input-tgl #inputTglInspeksi #tgl_inspeksi').datepicker('setDate', "<?//= date('d-m-Y') ?>"); 
            //     } else {
            //         var tgl_inspeksi = new Date(tgl);

            //         $('#modal-input-tgl #inputTglInspeksi #tgl_inspeksi').datepicker('setDate', addZero(tgl_inspeksi.getDate())+'-'+addZero(tgl_inspeksi.getMonth()+1)+'-'+tgl_inspeksi.getFullYear()); 
            //     }

            //     $('#modal-input-tgl').modal('show');
            // }

            // function selesaiPengajuan(data) {
            //     var id = $(data).attr('data-id');
                
            //     window.location.href = "<?//=base_url().'Petugas/inputHasilPengujian/hasilPengujian/' ?>"+id;
            // }
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

            // function prosesPengajuan(id) {
            //     swal({
            //         title: "Proses Pengajuan?",
            //         text: "Proses pengajuan tera ini?",
            //         type: "info",
            //         showCancelButton: true,
            //         confirmButtonColor: "#38a80c",
            //         confirmButtonText: "Ya, Proses!",
            //         closeOnConfirm: false
            //     }, function () {
            //         window.location.href = "<?=base_url().'Petugas/proseshasilPengujian/' ?>"+id;
            //     });
            // }
        </script>
            