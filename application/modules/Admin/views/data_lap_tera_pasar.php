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

                    <h3 class="text-themecolor">Tera Ulang Pasar</h3>

                </div>



                <div class="col-md-6 align-self-center">

                    <ol class="breadcrumb">

                        <!-- <label>Jenis Perlengkapan</label> -->

                        <li class="breadcrumb-item active">Tera Ulang Pasar</li>

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

                            <!-- <div class="col-md-6 m-b-5">

                                <div class="input-daterange input-group" id="date-range">

                                    <input type="text" class="form-control" id="awal" name="awal" placeholder="Dari Tanggal" value="<?= date('d-m-Y', strtotime($selectTglAwal)) ?>"/>

                                    <div class="input-group-append">

                                        <span class="input-group-text bg-info b-0 text-white">sampai</span>

                                    </div>

                                    <input type="text" class="form-control" id="akhir" name="akhir" placeholder="Sampai Tanggal" value="<?= date('d-m-Y', strtotime($selectTglAkhir)) ?>"/>

                                </div>

                            </div> -->

                            <div class="col-md-3 m-b-5">

                                <div class="form-group">

                                    <!-- <label for="tgl_akhir" class="control-label">Sampai Tanggal :</label> -->

                                    <input type="text" name="tgl_daftar" autocomplete="off" required id="tgl_daftar" class="mydatepicker form-control" value="<?= date('d-m-Y', strtotime($tgl_sidang)) ?>">

                                </div>

                            </div>



                            <div class="col-md-3">

                                <select name="id_pasar" id="id_pasar" class="select2 form-control custom-select" >

                                    <?php foreach ($data_pasar as $psr) { ?>

                                        <option value="<?= encode($psr->id_pasar) ?>" <?= ($psr->id_pasar == $selectPasar?'selected':'') ?>><?= $psr->nama_pasar ?></option>

                                    <?php } ?>

                                </select>

                            </div>



                            <div class="col-md-3">

                                <div class="row">

                                    <div class="col-md-6 m-b-5">

                                        <button class="btn btn-block waves-effect waves-light btn-info float-right" onclick="tampilData()" title="Tampilkan Data"><i class="fa fa-eye"></i> Tampil</button>

                                    </div>

                                    <div class="col-md-6 m-b-5">

                                        <button class="btn btn-block waves-effect waves-light btn-inverse float-right" onclick="cetakLaporan()" title="Export Excel"><i class="mdi mdi-file-excel"></i> Export</button>

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

                             <table id="myTable" class="table-bordered table-striped table-hover" cellpadding="7px" width="100%">

                                <thead align="center" class="bg-megna text-white" style="font-size: 7pt">

                                    <tr style="text-align: center;">

                                        <th rowspan="2"><b>No.</b></th>

                                        <th rowspan="2"><b>Pemilik</b></th>

                                        <th rowspan="2"><b>Alamat</b></th>

                                        <th colspan="5"><b>Data Teknis UTTP</b></th>

                                        <th colspan="2"><b>Tanda Tera</b></th>

                                        <th colspan="2"><b>Kondisi</b></th>

                                        <th colspan="2"><b>Tindakan</b></th>

                                        <th rowspan="2"><b>Tarif (Rp)</b></th>

                                    </tr>



                                    <tr style="text-align: center;">

                                        <th><b>Jenis</b></th>

                                        <th><b>Kapasitas</b></th>

                                        <th><b>Jml Timbangan</b></th>

                                        <th><b>Jml Anak Timbangan</b></th>

                                        <th><b>Jml Timbangan + Anak Timbangan</b></th>

                                        <th><b>Berlaku</b></th>

                                        <th><b>Tidak Berlaku</b></th>

                                        <th><b>Baik</b></th>

                                        <th><b>Rusak</b></th>

                                        <th><b>Ditera</b></th>

                                        <th><b>Diganti</b></th>

                                        <!-- <th><b>Timbangan</b></th>

                                        <th><b>Anak Timbangan</b></th>

                                        <th><b>Total</b></th> -->

                                    </tr>

                                </thead>



                                <tbody>

                                    <?php 

                                        $no = 0;

                                        foreach ($dataSidangTera as $tera) { 

                                            $no++;

                                            $trfTimbang = $tera->tarif_timbang * $tera->jumlah_timbang;

                                            $trfAnakTimbang = 0;

                                            foreach ($dataTarifAnakTimbang as $trf) {

                                                if ($trf->id_list_sidang == $tera->id_list_sidang) {

                                                    $trfAnakTimbang += $trf->tarif_anak_timbang * $trf->jml_anak_timbang;

                                                }

                                            }



                                            $tarif = $trfTimbang + $trfAnakTimbang;

                                    ?>

                                            <tr style="font-size: 9pt;">

                                                <td align="center"><?= $no ?></td>

                                                <td><?= $tera->nama_user ?></td>

                                                <td><?= $tera->alamat_user ?></td>

                                                <td align="center"><?= $tera->jenis_timbangan ?></td>

                                                <td align="center"><?= $tera->kapasitas ?></td>

                                                <td align="center"><?= $tera->jumlah_timbang ?></td>

                                                <td align="center"><?= ($tera->jumlah_anak_timbang != 0?($tera->jumlah_anak_timbang == null?0:$tera->jumlah_anak_timbang):0) ?></td>

                                                <td align="center"><?= $tera->jumlah_timbang + $tera->jumlah_anak_timbang ?></td>

                                                <td align="center"><?= ($tera->kondisi=='rusak'?'-':date('M Y', strtotime($tera->berlaku))) ?></td>

                                                <td align="center"><?= ($tera->kondisi=='rusak'?date('M Y', strtotime($tgl_sidang)):date('M Y', strtotime($tera->tidak_berlaku))) ?></td>

                                                <td align="center"><?= ($tera->kondisi=='baik'?'✓':'-') ?></td>

                                                <td align="center"><?= ($tera->kondisi=='rusak'?'✓':'-') ?></td>

                                                <td align="center"><?= ($tera->tindakan=='ditera'?'✓':'-') ?></td>

                                                <td align="center"><?= ($tera->tindakan=='diganti'?'✓':'-') ?></td>

                                                <td align="right"><?= nominal($tarif) ?></td>

                                            </tr>



                                    <?php } ?>



                                </tbody>

                            </table>

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

                var tgl = $('#paramLap #tgl_daftar').val();

                var id_pasar = $('#paramLap #id_pasar').val();

                // var pasar = $('#paramLap #select_pasar').val();



                window.location.href = "<?=base_url().'Admin/lapSidangTera/' ?>"+id_pasar+'/'+tgl;

            }



            function cetakLaporan(argument) {

                var tgl = $('#paramLap #tgl_daftar').val();

                var id_pasar = $('#paramLap #id_pasar').val();



                window.location.href = "<?=base_url().'Admin/cetakLapSidangTera/' ?>"+id_pasar+'/'+tgl;

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



        </script>

            