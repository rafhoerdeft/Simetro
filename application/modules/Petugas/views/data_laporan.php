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
                    <h3 class="text-themecolor">Laporan Tera/Tera Ulang UTTP</h3>
                </div>

                <div class="col-md-6 align-self-center">
                    <ol class="breadcrumb">
                        <!-- <label>Jenis Perlengkapan</label> -->
                        <li class="breadcrumb-item active">Laporan</li>
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
                    <div class="card-body" style="margin-bottom: -15px" id="paramLap">
                        <div class="row">
                            <div class="col-md-3 m-b-5">
                                <select class="form-control" id="select_thn">
                                    <option value="" disabled>Pilih Tahun</option>
                                    <?php foreach ($tahun as $key) {?>
                                        <option value="<?=encode($key->tahun);?>" <?= ($selectTahun==$key->tahun?'selected':'') ?>><?=$key->tahun?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-3 m-b-5">
                                <select class="form-control" id="select_bln">
                                    <option value="" disabled>Pilih Bulan</option>
                                    <?php foreach ($dataBulan as $key => $bln) {?>
                                        <option value="<?=encode($key);?>" <?= ($selectBulan==$key?'selected':'') ?>><?=$bln?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-3 m-b-5">
                                <select class="form-control" id="select_pasar">
                                    <option value="" selected>Semua</option>
                                    <option value="<?=encode(0);?>" <?= ($selectPasar=='0'?'selected':'') ?>>Bukan Pasar</option>
                                    <?php foreach ($dataPasar as $psr) {?>
                                        <option value="<?=encode($psr->id_pasar);?>" <?= ($selectPasar==$psr->id_pasar?'selected':'') ?>><?=$psr->nama_pasar?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-6 m-b-5">
                                        <button class="btn btn-block waves-effect waves-light btn-info float-right" onclick="tampilData()" title="Tampilkan Data"><i class="fa fa-eye"></i> Tampil</button>
                                    </div>
                                    <div class="col-md-6 m-b-5">
                                        <button class="btn btn-block waves-effect waves-light btn-inverse float-right" onclick="cetakLaporan()" title="Export Excel"><i class="fa fa-file-excel-o"></i> Export</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="card-body p-b-20">
                        <div class="table-responsive">
                            <table id="myTable" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr style="font-size: 10pt">
                                        <th>#</th>
                                        <th width="130"><b>Tgl Bayar</b></th>
                                        <th><b>Rincian Setoran</b></th>
                                        <!-- <th><b>Jumlah (Rp)</b></th> -->
                                        <th width="160"><b>Sub Total (Rp)</b></th>
                                        <th><b>Aksi</b></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php 
                                        $no = 0;
                                        foreach ($dataSetor as $setor) { 
                                            $no++;
                                    ?>
                                            <tr style="font-size: 10pt">
                                                <td align="center" width="20"><?= $no ?></td>
                                                <td style="font-weight: bold"><?= date('d-m-Y', strtotime($setor->tgl_bayar)) ?></td>
                                                <td>
                                                    <style type="text/css">
                                                        .list_rincian ul {
                                                          list-style: none;
                                                          margin-left: 0;
                                                          padding-left: 0;
                                                        }

                                                        .list_rincian ul li {
                                                          padding-left: 1em;
                                                          text-indent: -1em;
                                                        }

                                                        .list_rincian ul li:before {
                                                          content: "-";
                                                          padding-right: 5px;
                                                        }
                                                    </style>
                                                    <?php 
                                                    $tot_tarif = 0;
                                                    foreach ($dataOrder as $order) {
                                                        if ($order->tgl_bayar == $setor->tgl_bayar) {
                                                            echo '<div>'.$order->nama_user.' / '.$order->nama_usaha.'</div>';
                                                            echo '<div class="list_rincian"><ul>';
                                                            foreach ($dataBayar as $byr) {
                                                                if ($byr['id_daftar'] == $order->id_daftar) {
                                                                    echo '<li>'.$byr['uttp'].' - '.$byr['jenis_tarif'].' ('.nominal($byr['tarif']).' x '.$byr['jml_uttp'].') </li>';

                                                                    $tot_tarif += $byr['tarif'] * $byr['jml_uttp'];
                                                                }
                                                            }
                                                            echo '</ul></div>';
                                                        }
                                                    } ?>
                                                </td>

                                                <td align="right" style="font-weight: bold"> <?= nominal($tot_tarif); ?> </td>

                                                <td width="100" align="center">
                                                    <div class="d-none d-sm-none d-md-block d-lg-block">
                                                        <button style="font-size: 10pt" type="button" class="btn btn-sm btn-primary waves-effect waves-light m-b-5" onclick="cetakSetoran('<?= $setor->tgl_bayar ?>')" title="Cetak Setoran"><span class="btn-label"><i class="fa fa-print"></i></span>Setor</button>
                                                    </div>

                                                    <div class="d-block d-sm-block d-md-none d-lg-none">
                                                        <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fa fa-cog"></i>
                                                        </button>

                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="cetakSetoran('<?= $setor->tgl_bayar ?>')"><i class="fa fa-trash-o"></i> Hapus Kelompok Tarif</a>
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
                                    <label for="nominal_bayar" class="control-label">Nominal Bayar (Rp):</label>
                                    <input type="text" class="form-control" id="nominal_bayar" onkeyup="changeRupe(this)" onkeypress="return inputAngka(event);" placeholder="Ex: 150.000" name="nominal_bayar" required autocomplete="off">
                                </div>

                                <div class="form-group">
                                    <label for="tgl_bayar" class="control-label">Tanggal Bayar :</label>
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


            <div id="modal-setor" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg">
                    
                    <div class="modal-content" style="margin: 0 -10%; width: 120%;">
                        <div class="modal-header">
                            <h4 class="modal-title">Cetak Setoran Harian</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body" id="form-print">
                            <table border="0" width="85%" style="font-size: 13pt; color: black; font-family: arial; margin: auto; z-index: 2; border: solid 2px;" cellpadding="10">
                                <tr>
                                    <td width="50%" style="text-align: center; border: solid 2px; line-height: 18px">
                                        <div style="font-size: 11pt">PEMERINTAH KABUPATEN MAGELANG</div>
                                        <div style="font-weight: bold">DINAS PERDAGANGAN, KOPERASI, <br> USAHA KECIL DAN MENENGAH</div>
                                        <div style="font-size: 11pt">Jl. Soekarno-Hatta Kota Mungkid <br> Telp. (0293) 788227</div>
                                    </td>
                                    <td style="border: solid 2px;" valign="top">
                                        <div style="font-size: 19pt; font-weight: bold;">SURAT SETORAN</div>
                                        <div class="row">
                                            <div class="col-md-4">Tanggal :</div>
                                            <div class="col-md-8" id="tgl_setor">20 Januari 2019</div>
                                        </div>
                                        
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2">
                                        <table>
                                            <tr>
                                                <td width="90">N a m a</td>
                                                <td width="25">:</td>
                                                <td style="font-weight: bold"> Bidang Metrologi</td>
                                            </tr>
                                            <tr>
                                                <td>A l a m a t</td>
                                                <td>:</td>
                                                <td style="font-weight: bold">Jl. Soekarno Hatta</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">
                                                    Menyetor berdasarkan: Surat Keputusan Setoran Bulanan No. 
                                                    <span id="no_sk1">.......................................</span>
                                                    <div style="margin-left: 90px">
                                                        atau 
                                                        <span id="no_sk2">............................................................</span>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="padding: 0px; text-align: center;" colspan="2">
                                        <table cellpadding="3" width="100%" id="rincian_setor">
                                            <tr>
                                                <td width="5%" style="border-style: solid; border-color: black; border-width: 2px 0px">No.</td>
                                                <td width="15%" style="border: solid 2px;">A y a t</td>
                                                <td width="65%" style="border: solid 2px;">R i n c i a n</td>
                                                <td width="15%" style="border-style: solid; border-color: black; border-width: 2px 0px">J u m l a h</td>
                                            </tr>

                                            <tr>
                                                <td valign="top">1</td>
                                                <td style="border-style: solid; border-color: black; border-width: 0px 2px" valign="top">4120145</td>
                                                <td align="left" style="border-style: solid; border-color: black; border-width: 0px 2px">
                                                    Setor Tera Ulang dari SPPBE PT MNI Indonesia
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td style="border-style: solid; border-color: black; border-width: 0px 2px"></td>
                                                <td style="border-style: solid; border-color: black; border-width: 0px 2px" align="left">- ATB Kapasitas 10kg (20.000 x 2)</td>
                                                <td align="right">5.000</td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td style="border-style: solid; border-color: black; border-width: 0px 2px"></td>
                                                <td style="border-style: solid; border-color: black; border-width: 0px 2px" align="left">- Filling Machine (15.000 x 14)</td>
                                                <td align="right">1.260.000</td>
                                            </tr>

                                            <tr>
                                                <td colspan="3" align="right" style="border-style: solid; border-color: black; border-width: 2px 0px">
                                                    <i>Jumlah Rp.</i>
                                                </td>
                                                <td style="border-style: solid; border-color: black; border-width: 2px 0px 2px 2px; font-weight: bold;" align="right" id="tot_setor">1.365.000</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 3px 3px 3px 15px" colspan="2" align="left" valign="top">
                                        <!-- <div class="row"> -->
                                            <div style="width: 100px; float: left; line-height: 20px; font-style: italic;">
                                                Dengan huruf  :
                                            </div> 
                                            <div style="border: solid 1px; border-radius: 10px; height: 40px; padding-top: 6px; padding-left: 10px; ; font-weight: bold; width: 86%; float: right;" id="terbilang">
                                                Satu Juta Tiga Ratus Enam Puluh Lima Ribu
                                            </div>
                                        <!-- </div> -->
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border: solid 2px; padding: 3px" colspan="2">
                                        <div class="row">
                                            <div class="col-md-6"></div>
                                            <div class="col-md-6" style="text-align: center;">
                                                <div id="tgl_cetak">Magelang,  14 Oktober 2019 </div>
                                                Penyetor <br> <br> <br>
                                                ..........................................
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr style="font-size: 12pt">
                                    <td style="border: solid 2px; text-align: justify; line-height: 20px">
                                        Kepada Yth. <br>
                                        Direktur Utama BPD/Kepala Kantor Giro Pos, agar menerima penyetoran untuk keuntungan rekening Pemegang Kas Daerah Kabupaten Magelang
                                    </td>
                                    <td valign="top" style="border: solid 2px; text-align: justify; line-height: 20px">
                                        Ruangan untuk tercap Kas Register / Tanda tangan / Cap BKP / Pejabat Bank / Pejabat Kantor Giro Pos.
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
                var pasar = $('#paramLap #select_pasar').val();

                window.location.href = "<?=base_url().'Petugas/laporan/' ?>"+bln+'/'+thn+'/'+pasar;
            }

            function cetakLaporan(argument) {
                var thn = $('#paramLap #select_thn').val();
                var bln = $('#paramLap #select_bln').val();
                var pasar = $('#paramLap #select_pasar').val();

                window.location.href = "<?=base_url().'Petugas/cetakLaporan/' ?>"+bln+'/'+thn+'/'+pasar;
            }

            function cetakSetoran(tgl_bayar='') {
                $('#modal-setor #tgl_setor').html('');
                $('#modal-setor #no_sk1').html('...........................................');
                $('#modal-setor #no_sk2').html('............................................................');
                $('#modal-setor #rincian_setor').html('');
                $('#modal-setor #terbilang').html('');
                $('#modal-setor #tgl_cetak').html('');

                $("#loading-show").fadeIn("slow");
                $.post("<?= base_url().'Petugas/getDataSetor' ?>", {tgl_bayar:tgl_bayar}, function(result){
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
                        for (var i = 0; i < dt.dataOrder.length; i++) {
                            var rinci_usaha =   '<tr>'+
                                                    '<td valign="top">1</td>'+
                                                    '<td style="border-style: solid; border-color: black; border-width: 0px 2px" valign="top">'+dt.dataOrder[i].no_order+'</td>'+
                                                    '<td align="left" style="border-style: solid; border-color: black; border-width: 0px 2px">'+
                                                        dt.dataOrder[i].nama_user+' / '+dt.dataOrder[i].nama_usaha+
                                                    '</td>'+
                                                    '<td></td>'+
                                                '</tr>';
                            for (var x = 0; x < dt.dataBayar.length; x++) {
                                if (dt.dataOrder[i].id_daftar == dt.dataBayar[x].id_daftar) {
                                    var tot_rinci = dt.dataBayar[x].jml_uttp * dt.dataBayar[x].tarif;
                                    var rinci_list = '<tr>'+
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

                // window.location.href = "<?//=base_url().'Petugas/cetakLaporan/' ?>"+bln+'/'+thn+'/'+pasar;
                

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
                var tgl = addZero(tanggal.getDate())+' '+nama_bulan(tanggal.getMonth()+1)+' '+tanggal.getFullYear();
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
                    var printcontent = document.getElementById('form-print').innerHTML;
                    document.body.innerHTML = printcontent;
                    window.print();

                    window.location.href = "<?=base_url().'Petugas/laporan' ?>";
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
            