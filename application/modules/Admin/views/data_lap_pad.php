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

                    <h3 class="text-themecolor">Laporan PAD</h3>

                </div>



                <div class="col-md-6 align-self-center">

                    <ol class="breadcrumb">

                        <!-- <label>Jenis Perlengkapan</label> -->

                        <li class="breadcrumb-item active">Laporan PAD</li>

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

                    <div class="card-body" style="margin-bottom: -5px" id="paramLap">

                        <div class="row">

                            <div class="col-md-3 m-b-5">

                                <select class="form-control" id="select_thn">

                                    <option value="" disabled>Pilih Tahun</option>

                                    <?php foreach ($tahun as $key) {?>

                                        <option data-thn="<?=$key->tahun?>" value="<?=encode($key->tahun);?>" <?= ($selectTahun==$key->tahun?'selected':'') ?>><?=$key->tahun?></option>

                                    <?php } ?>

                                </select>

                            </div>

                            <div class="col-md-3 m-b-5">

                                <select class="form-control" id="select_bln">

                                    <option value="" disabled>Pilih Bulan</option>

                                    <?php foreach ($dataBulan as $key => $bln) {?>

                                        <option data-bln="<?=$bln?>" value="<?=encode($key);?>" <?= ($selectBulan==$key?'selected':'') ?>><?=$bln?></option>

                                    <?php } ?>

                                </select>

                            </div>



                            <div class="col-md-3">

                                <div class="row">

                                    <div class="col-md-6 m-b-5">

                                        <button class="btn btn-block waves-effect waves-light btn-info float-right" onclick="tampilData()" title="Tampilkan Data"><i class="fa fa-eye"></i> Tampil</button>

                                    </div>

                                    <div class="col-md-6 m-b-5">

                                        <button class="btn btn-block waves-effect waves-light btn-inverse float-right" onclick="cetakLaporan()" title="Cetak"><i class="fa fa-print"></i> Cetak</button>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>



                <style type="text/css">

                    .dataTable > thead > tr > th[class*="sort"]:after{

                        content: "" !important;

                    }

                </style>



                <div class="card">

                    <div class="card-body p-b-20">

                        <div class="table-responsive">

                            <table class="table-bordered table-striped table-hover" cellpadding="7px" width="100%">

                                <thead align="center" class="bg-megna text-white" style="font-size: 10pt">

                                    <tr>

                                        <!-- <th rowspan="2">#</th> -->

                                        <th rowspan="2"><b>Target</b></th>

                                        <th colspan="3"><b>Realisasi Pendapatan</b></th>

                                        <th colspan="2"><b>Capaian</b></th>

                                        <!-- <th><b>Aksi</b></th> -->

                                    </tr>

                                    <tr>

                                        <th><b>s/d Bulan Lalu (Rp)</b></th>

                                        <th><b>Bulan Ini (Rp)</b></th>

                                        <th><b>s/d Bulan Ini (Rp)</b></th>

                                        <th><b>Lebih / Kurang (Rp)</b></th>

                                        <th><b>Prosentase (%)</b></th>

                                    </tr>

                                </thead>

                                <tbody>



                                    <?php 

                                        // $no = 0;

                                        // foreach ($pendapatan as $pad) { 

                                        //     $no++;

                                    ?>

                                            <tr style="font-size: 10pt; font-weight: bold; text-align: center;">

                                                <!-- <td align="center" width="20"><?= $no ?></td> -->

                                                <td><?= nominal($targetPad) ?></td>

                                                <td><?= nominal($sdBulanLalu) ?></td>

                                                <td><?= nominal($bulanIni) ?></td>

                                                <td><?= nominal($sdBulanIni) ?></td>

                                                <td><?= nominal($targetPad - $sdBulanIni) ?></td>

                                                <?php 
                                                    if ($targetPad != 0) {
                                                        $target_PAD = round(($sdBulanIni/$targetPad)*100, 2);
                                                    } else {
                                                        $target_PAD = 0;
                                                    } 
                                                ?>
                                                <td><?= $target_PAD ?> %</td>



                                                <!-- <td width="100" align="center">

                                                    <div class="d-none d-sm-none d-md-block d-lg-block">

                                                        <button style="font-size: 10pt" type="button" class="btn btn-sm btn-primary waves-effect waves-light m-b-5" onclick="cetakSetoran('<?= $setor->tgl_bayar ?>')" title="Cetak Setoran"><span class="btn-label"><i class="fa fa-print"></i></span>Setor</button>

                                                    </div>



                                                </td> -->

                                            </tr>

                                    <?php //} ?>

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>



            </div>





            <div id="cetak_lap_pad" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

                <div class="modal-dialog modal-lg">

                    <div class="modal-content" style="margin: 0 -15%; width: 130%;">

                        <div class="modal-header">

                            <h4 class="modal-title">Cetak Laporan PAD</h4>

                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                        </div>

                        <div class="modal-body" id="form-print">

                            <div style="font-size: 11pt; text-align: center; font-family: arial; color: black;">

                                <div>LAPORAN REALISASI PENERIMAAN PENDAPATAN ASLI DAERAH KABUPATEN MAGELANG</div>

                                <div>RETRIBUSI PELAYANAN TERA / TERA ULANG</div>

                                <div id="bulan">Periode: November 2019</div>

                            </div>

                            <br>

                            <!-- <table class="table-bordered table-striped table-hover" cellpadding="7px" width="100%"> -->

                            <table border="1" width="90%" style="font-size: 11pt; color: black; font-family: arial; margin: auto; z-index: 2" cellpadding="10">

                                <thead align="center">

                                    <tr>

                                        <th rowspan="2">Uraian</th>

                                        <th rowspan="2">Target</th>

                                        <th colspan="3">Realisasi Pendapatan</th>

                                        <th colspan="2">Capaian</th>

                                        <!-- <th>Aksi</th> -->

                                    </tr>

                                    <tr>

                                        <th>s/d Bulan Lalu (Rp)</th>

                                        <th>Bulan Ini (Rp)</th>

                                        <th>s/d Bulan Ini (Rp)</th>

                                        <th>Lebih / Kurang (Rp)</th>

                                        <th>Prosentase (%)</th>

                                    </tr>

                                </thead>

                                <tbody>



                                    <?php 

                                        // $no = 0;

                                        // foreach ($pendapatan as $pad) { 

                                        //     $no++;

                                    ?>

                                            <tr style="font-size: 11pt; text-align: center;">

                                                <!-- <td align="center" width="20"><?= $no ?></td> -->

                                                <td>Retribusi Pelayanan Tera/Tera Ulang</td>

                                                <td><?= nominal($targetPad) ?></td>

                                                <td><?= nominal($sdBulanLalu) ?></td>

                                                <td><?= nominal($bulanIni) ?></td>

                                                <td><?= nominal($sdBulanIni) ?></td>

                                                <td><?= nominal($targetPad - $sdBulanIni) ?></td>

                                                <td><?= $target_PAD ?> %</td>



                                                <!-- <td width="100" align="center">

                                                    <div class="d-none d-sm-none d-md-block d-lg-block">

                                                        <button style="font-size: 10pt" type="button" class="btn btn-sm btn-primary waves-effect waves-light m-b-5" onclick="cetakSetoran('<?= $setor->tgl_bayar ?>')" title="Cetak Setoran"><span class="btn-label"><i class="fa fa-print"></i></span>Setor</button>

                                                    </div>



                                                </td> -->

                                            </tr>

                                    <?php //} ?>

                                </tbody>

                            </table>

                            <br>

                            <div class="row">

                                <div class="col-md-6" style="text-align: center; color: black; font-family: arial; font-size: 11pt">

                                    Bendahara Penerima / Pembantu <br><br><br><br>

                                    <div id="bendahar" style="text-decoration: underline;"><?= $bendahara->nama_user ?></div>

                                    <?= $bendahara->golongan ?> <br>

                                    NIP. <?= $bendahara->nip ?>

                                </div>

                                <div class="col-md-6" style="text-align: center; color: black; font-family: arial; font-size: 11pt">

                                    Kota Mungkid, <?= formatTanggalTtd(date('d-m-Y')) ?> <br>

                                    KEPALA DINAS <br><br><br>

                                    <div id="bendahar" style="text-decoration: underline;"><?= $kepalaDinas->nama_user ?></div>

                                    <?= $kepalaDinas->golongan ?> <br>

                                    NIP. <?= $kepalaDinas->nip ?>

                                </div>

                            </div>

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





        <!-- KIRIM PENGAJUAN =========================================== -->

        <script type="text/javascript">

            function kirimPengajuan(id) {

                $('#modal-kirim #kirimPengajuan').trigger("reset");

                $('#modal-kirim #kirimPengajuan #id_daftar').val(id);

                $('#modal-kirim').modal('show');

            }

        </script>



        <script type="text/javascript">

            function tampilData(argument) {

                var thn = $('#paramLap #select_thn').val();

                var bln = $('#paramLap #select_bln').val();

                // var pasar = $('#paramLap #select_pasar').val();



                window.location.href = "<?=base_url().'Admin/lapPad/' ?>"+bln+'/'+thn;

            }



            function cetakLaporan(argument) {

                var thn = $('#paramLap #select_thn option:selected').attr('data-thn');

                var bln = $('#paramLap #select_bln option:selected').attr('data-bln');



                $('#cetak_lap_pad #bulan').html('Periode: '+bln+' '+thn);



                $('#cetak_lap_pad').modal('show');

            }



            function cetakSetoran(tgl_bayar='') {

                $('#modal-setor #tgl_setor').html('');

                $('#modal-setor #no_sk1').html('...........................................');

                $('#modal-setor #no_sk2').html('............................................................');

                $('#modal-setor #rincian_setor').html('');

                $('#modal-setor #terbilang').html('');

                $('#modal-setor #tgl_cetak').html('');



                $("#loading-show").fadeIn("slow");

                $.post("<?= base_url().'Admin/getDataSetor' ?>", {tgl_bayar:tgl_bayar}, function(result){

                    $("#loading-show").fadeIn("slow").delay(20).slideUp('slow');



                    var dt = JSON.parse(result);

                    console.log(dt);



                    if (dt.response) {

                        $('#modal-setor #tgl_setor').html(showDate(tgl_bayar));

                        // $('#modal-setor #no_sk1').html('...........................................');

                        // $('#modal-setor #no_sk2').html('............................................................');



                        var rinci_head = '<tr>'+

                                            '<td width="5%" style="border-style: solid; border-color: black; border-width: 2px 0px">No.</td>'+

                                            '<td width="15%" style="border: solid 2px;">A y a t</td>'+

                                            '<td width="65%" style="border: solid 2px;">R i n c i a n</td>'+

                                            '<td width="15%" style="border-style: solid; border-color: black; border-width: 2px 0px">J u m l a h</td>'+

                                        '</tr>';



                        var tot_setor = 0;

                        var rinci_list = '';

                        var rinci_usaha = '';

                        for (var i = 0; i < dt.dataOrder.length; i++) {

                            var num = i+1;

                            var nama_usaha = '';

                            if (dt.dataOrder[i].nama_usaha != 'null' && dt.dataOrder[i].nama_usaha != null && dt.dataOrder[i].nama_usaha != '') {

                                nama_usaha = ' / '+dt.dataOrder[i].nama_usaha;

                            } else {

                                nama_usaha = '';

                            }

                            rinci_usaha +=  '<tr>'+

                                                '<td valign="top">'+num+'</td>'+

                                                '<td style="border-style: solid; border-color: black; border-width: 0px 2px" valign="top">'+dt.dataOrder[i].no_order+'</td>'+

                                                '<td align="left" style="border-style: solid; border-color: black; border-width: 0px 2px">'+

                                                    dt.dataOrder[i].nama_user+nama_usaha+

                                                '</td>'+

                                                '<td></td>'+

                                            '</tr>';

                            for (var x = 0; x < dt.dataBayar.length; x++) {

                                if (dt.dataOrder[i].id_daftar == dt.dataBayar[x].id_daftar) {

                                    var tot_rinci = dt.dataBayar[x].jml_uttp * dt.dataBayar[x].tarif;

                                    rinci_list += '<tr>'+

                                                        '<td></td>'+

                                                        '<td style="border-style: solid; border-color: black; border-width: 0px 2px"></td>'+

                                                        '<td style="border-style: solid; border-color: black; border-width: 0px 2px" align="left">- '+dt.dataBayar[x].uttp+' ('+dt.dataBayar[x].jenis_tarif+') x '+dt.dataBayar[x].jml_uttp+'</td>'+

                                                        '<td align="right">'+formatRupiah(tot_rinci.toString(), 'Rp.')+'</td>'+

                                                    '</tr>';

                                    tot_setor += tot_rinci;

                                }

                            }

                        }



                        var rinci_foot = '<tr>'+

                                            '<td colspan="3" align="right" style="border-style: solid; border-color: black; border-width: 2px 0px">'+

                                                '<i>Jumlah Rp.</i>'+

                                            '</td>'+

                                            '<td style="border-style: solid; border-color: black; border-width: 2px 0px 2px 2px; font-weight: bold;" align="right">'+formatRupiah(tot_setor.toString(), 'Rp.')+'</td>'+

                                        '</tr>';



                        var rincian = '';

                        rincian += rinci_head;

                        rincian += rinci_usaha;

                        rincian += rinci_list;

                        rincian += rinci_foot;



                        $('#modal-setor #rincian_setor').html(rincian);

                        $('#modal-setor #terbilang').html(dt.terbilang);

                        $('#modal-setor #tgl_cetak').html('Magelang, '+showDate('<?= date('Y-m-d') ?>'));



                        $('#modal-setor').modal('show');

                    }



                });



                // window.location.href = "<?//=base_url().'Admin/cetaklapPad/' ?>"+bln+'/'+thn+'/'+pasar;

                



            }

        </script>



        <script type="text/javascript">

            function addZero(n){

              if(n <= 9){

                return "0" + n;

              }

              return n

            }



            function showDate(date='') {

                var tanggal = new Date(date);

                var tgl = addZero(tanggal.getDate())+' '+nama_bulan(tanggal.getMonth())+' '+tanggal.getFullYear();

                return tgl;

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

                    var css = '@page { size: landscape; }',

                        head = document.head || document.getElementsByTagName('head')[0],

                        style = document.createElement('style');



                    style.type = 'text/css';

                    style.media = 'print';



                    if (style.styleSheet){

                      style.styleSheet.cssText = css;

                    } else {

                      style.appendChild(document.createTextNode(css));

                    }



                    head.appendChild(style);

                    var printcontent = document.getElementById('form-print').innerHTML;

                    document.body.innerHTML = printcontent;

                    window.print();



                    location.reload();

                    // window.location.href = "<?//=base_url().'Admin/lapPad' ?>";

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

                        url  : "<?php echo base_url('Admin/deletePengajuanTera')?>",

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

            