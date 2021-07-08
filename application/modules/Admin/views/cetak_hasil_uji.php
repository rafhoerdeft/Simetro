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
                    <h3 class="text-themecolor">Cetak Hasil Pengujian UTTP (No. Order: <?= $dataPendaftaran->no_order ?>)</h3>
                </div>

                <div class="col-md-6 align-self-center">
                    <ol class="breadcrumb">
                        <!-- <label>Jenis Perlengkapan</label> -->
                        <li class="breadcrumb-item"><a href="<?= base_url().'Admin/hasilPengujian' ?>" class="text-danger">Hasil Pengujian</a></li>
                        <li class="breadcrumb-item active">Cetak Hasil Pengujian</li>
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
                        <!-- <button type="button" class="btn btn-danger waves-effect waves-light" onclick="selesaiPengajuan(<?= $id_daftar ?>)"><i class="fa fa-check"></i> Selesaikan</button> -->
                        <div id="tbl_list_tarif">
                            <!-- <hr> -->
                            <table id="list_tarif_pilih" border="1" width="100%" style="border-color: white; font-size: 10pt" cellpadding="5px">
                                <thead align="center" class="bg-megna  text-white" style="border-color: white">
                                    <tr style="height: 40px">
                                        <th width="35%">UTTP</th>
                                        <th width="40%">Spesifikasi UTTP</th>
                                        <th width="10%">Satuan</th>
                                        <!-- <th width="10%">Layanan</th>
                                        <th width="10%">Tempat</th> -->
                                        <th width="5%">Jumlah</th>
                                        <!-- <th width="10%">Tarif (Rp)</th> -->
                                        <!-- <th width="10%">Total (Rp)</th> -->
                                        <th width="10%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $tot_all  = 0;
                                        $ind = 0;
                                        $jml_input = 0;
                                        foreach ($listUttp as $list) { 
                                            $tot_tarif = $list->tarif * $list->jumlah_uttp;
                                            $tot_all += $tot_tarif;
                                            $ind++;
                                    ?>
                                            <tr style="height: 40px; <?= ($list->hasil == 'tidak disahkan'?'background: #ffebe6;':'') ?>">
                                                <!-- <input type="hidden" name="id_uttp[]" id="current_id_uttp_<?//= $ind ?>" value="<?//= $list->id_uttp ?>">
                                                <input type="hidden" name="id_tarif[]" id="current_id_tarif_<?//= $ind ?>" value="<?//= $list->id_tarif ?>">
                                                <input type="hidden" name="jumlah_uttp[]" id="current_jumlah_uttp_<?//= $ind ?>" value="<?//= $list->jumlah_uttp ?>"> -->
                                                <td><?= $list->jenis_alat ?></td>
                                                <td><?= $list->jenis_tarif ?></td>
                                                <td align="center"><?= $list->satuan ?></td>
                                                <td align="center"><?= $list->jumlah_uttp ?></td>
                                                <!-- <td align="right"><?//= number_format($list->tarif,0,".",".") ?></td> -->
                                                <!-- <td align="right"><?//= number_format($tot_tarif,0,".",".") ?></td> -->
                                                <td align="center">
                                                    <?php if ($list->hasil == 'tidak disahkan') { ?>
                                                        <span>Tidak Disahkan</span>
                                                    <?php } else { ?>
                                                        <button data-id-list="<?= $list->id_list ?>" data-id-uttp="<?= $list->id_uttp ?>" onclick="cetakHasil(this)" type="button" class="btn btn-sm btn-info waves-effect waves-light" title="Hapus"><i class="fa fa-print"></i> Cetak</button>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                    <?php } ?>
                                    <input type="hidden" name="jml_current_list" id="jml_current_list" value="<?= $ind ?>">
                                    <input type="hidden" name="jml_input" id="jml_input" value="<?= $jml_input ?>">
                                </tbody>
                                <!-- <tfoot>
                                    <tr class="bg-megna text-white" style="border-color: white; height: 40px">
                                        <td align="center" colspan="5" style="font-weight: bold">Total</td>
                                        <td align="right"  style="font-weight: bold"><?//= number_format($tot_all,0,".",".") ?></td>
                                        <td></td>
                                    </tr>
                                </tfoot> -->
                            </table>
                        </div>

                    </div>
                </div>

            </div>

            <!-- Modal Cetak -->
            <div id="modal-cetak" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg">
                    
                    <div class="modal-content" style="margin: 0 -15%; width: 130%;">
                        <div class="modal-header">
                            <h4 class="modal-title">Cetak Hasil Pengujian</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body" id="form-print">
                            <table border="0" width="90%" style="font-size: 16pt; color: black; font-family: arial; margin: auto; z-index: 2" cellpadding="10">
                                <tr>
                                    <td style="text-align: center; ">
                                        <div style="font-weight: bold; font-size: 18pt"><u>SURAT KETERANGAN HASIL PENGUJIAN</u></div>
                                        <div style="margin-top: -9px; font-size: 12pt"><i>Verification Report</i></div>
                                        <div style="margin-top: -8px;">Nomor: <label id="nomor">510.63/302/IX/2019</label></div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <table border="0" align="right" width="275">
                                            <tr style="border: solid 1px">
                                                <td style="padding-left: 10px">No. Order</td>
                                                <td>:</td>
                                                <td id="no_order" align="right" style="padding-right: 10px">100-1</td>
                                            </tr>
                                            <tr style="border: solid 1px">
                                                <td style="padding-left: 10px">Tanggal</td>
                                                <td>:</td>
                                                <td id="tgl_order" align="right" style="padding-right: 10px">16-08-2019</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <table>
                                            <tr>
                                                <td>
                                                    <table>
                                                        <tr>
                                                            <td style="width: 250px">
                                                                <div style="font-weight: bold;"><u>Nama Alat</u></div>
                                                                <div style="font-size: 13pt; margin-top: -9px"><i>Measuring Instrument</i></div>
                                                            </td>
                                                            <td style="padding-right: 25px" valign="top">:</td>
                                                            <td style="font-weight: bold;" valign="top" id="nama_alat">PU BBM (Pertalite)</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <table id="spek_alat">
                                                        <tr>
                                                            <td style="padding-left: 25px; padding-right: 15px">
                                                                <div>Merk</div>
                                                            </td>
                                                            <td style="padding-right: 15px">:</td>
                                                            <td>TATSUNO</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding-left: 25px; padding-right: 15px">
                                                                <div>Model / Tipe</div>
                                                            </td>
                                                            <td style="padding-right: 15px">:</td>
                                                            <td>SSA 2222</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding-left: 25px; padding-right: 15px">
                                                                <div>Nomor Seri</div>
                                                            </td>
                                                            <td style="padding-right: 15px">:</td>
                                                            <td>AA 241376 2015-1</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding-left: 25px; padding-right: 15px">
                                                                <div>Buatan</div>
                                                            </td>
                                                            <td style="padding-right: 15px">:</td>
                                                            <td>Jepang</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding-left: 25px; padding-right: 15px">
                                                                <div>Laju Aliran Maksimum</div>
                                                            </td>
                                                            <td style="padding-right: 15px">:</td>
                                                            <td>60 L/m</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding-left: 25px; padding-right: 15px">
                                                                <div>Jumlah Nozzle</div>
                                                            </td>
                                                            <td style="padding-right: 15px">:</td>
                                                            <td>2 Nozzle</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <!-- <td colspan="3">
                                                    <table>
                                                        <tr>
                                                            <td style="padding-left: 25px; padding-right: 15px">
                                                                <div>Buatan</div>
                                                            </td>
                                                            <td style="padding-right: 15px">:</td>
                                                            <td>Jepang</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding-left: 25px; padding-right: 15px">
                                                                <div>Laju Aliran Maksimum</div>
                                                            </td>
                                                            <td style="padding-right: 15px">:</td>
                                                            <td>60 L/m</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding-left: 25px; padding-right: 15px">
                                                                <div>Jumlah Nozzle</div>
                                                            </td>
                                                            <td style="padding-right: 15px">:</td>
                                                            <td>2 Nozzle</td>
                                                        </tr>
                                                    </table>
                                                </td> -->
                                            </tr>
                                            <!-- ============================================================== -->
                                            <tr>
                                                <td style="padding-right: 15px" colspan="3">
                                                    <div style="font-weight: bold;"><u>Pemilik / Pengguna</u></div>
                                                    <div style="font-size: 13pt; margin-top: -9px"><i>Owner/User</i></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="6">
                                                    <table>
                                                        <tr>
                                                            <td style="padding-left: 25px; width: 250px">
                                                                <div>Nama</div>
                                                            </td>
                                                            <td style="padding-right: 25px">:</td>
                                                            <td style="font-weight: bold" id="nama_usaha">SPBU 44.564.02 (PT SUDEWO SUDEWI ENERGI SEJAHTERA)</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding-left: 25px; width: 250px">
                                                                <div>Alamat</div>
                                                            </td>
                                                            <td style="padding-right: 25px">:</td>
                                                            <td id="alamat_usaha">Jl. Tentara Pelajar No. 1 Muntilan, Kab. Magelang</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- ============================================================== -->
                                            <tr>
                                                <td style="padding-right: 15px" colspan="3">
                                                    <div style="font-weight: bold;"><u>Metode / Standar</u></div>
                                                    <div style="font-size: 13pt; margin-top: -9px"><i>Method/Standar</i></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="6">
                                                    <table>
                                                        <tr>
                                                            <td style="padding-left: 25px; width: 250px">
                                                                <div>Metode</div>
                                                            </td>
                                                            <td style="padding-right: 25px">:</td>
                                                            <td id="metode">Keputusan DJSPK No. 134/SPK/KEP/10/2015</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding-left: 25px; width: 250px">
                                                                <div>Standar</div>
                                                            </td>
                                                            <td style="padding-right: 25px">:</td>
                                                            <td id="standar">Bejana Ukur Standar 20 Liter</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!-- ============================================================== -->
                                            <tr>
                                                <td colspan="6">
                                                    <table>
                                                        <tr>
                                                            <td style="width: 250px">
                                                                <div style="font-weight: bold;"><u>Tanggal Tera</u></div>
                                                                <div style="font-size: 13pt; margin-top: -9px"><i>Date of Verificated</i></div>
                                                            </td>
                                                            <td style="padding-right: 25px" valign="top">:</td>
                                                            <td valign="top" id="tgl_tera">05 September 2019</td>
                                                        </tr>
                                                        <!-- ============================================================= -->
                                                        <tr>
                                                            <td style="width: 250px">
                                                                <div style="font-weight: bold;"><u>Penera</u></div>
                                                                <div style="font-size: 13pt; margin-top: -9px"><i>Verfication Officer</i></div>
                                                            </td>
                                                            <td style="padding-right: 25px" valign="top">:</td>
                                                            <td style="font-weight: bold;" valign="top" id="petugas">Wendi Sutarman, S.T. / NIP. 19771118 201001 1 007</td>
                                                        </tr>
                                                        <!-- ============================================================== -->
                                                        <tr>
                                                            <td style="width: 250px">
                                                                <div style="font-weight: bold;"><u>Hasil</u></div>
                                                                <div style="font-size: 13pt; margin-top: -9px"><i>Result</i></div>
                                                            </td>
                                                            <td style="padding-right: 25px" valign="top">:</td>
                                                            <td style="font-weight: bold;" valign="top" id="hasil">Disahkan untuk Tera Ulang Tahun 2019</td>
                                                        </tr>
                                                        <!-- ================================================================ -->
                                                        <tr>
                                                            <td style="width: 250px">
                                                                <div style="font-weight: bold;"><u>Berlaku Sampai</u></div>
                                                                <div style="font-size: 13pt; margin-top: -9px"><i>This report due to</i></div>
                                                            </td>
                                                            <td style="padding-right: 25px" valign="top">:</td>
                                                            <td style="font-weight: bold;" valign="top" id="berlaku">September 2020</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="row">
                                           <div class="col-md-4"></div>
                                           <div class="col-md-8 text-center" style="line-height: 20px; padding-left: 130px">
                                               Kota Mungkid, <span id="tgl_ttd">06 September 2019</span> <br>
                                               KEPALA DINAS PERDAGANGAN, KOPERASI, <br> USAHA KECIL DAN MENENGAH <br> KABUPATEN MAGELANG, 
                                               <br> <br> <br> <br> <br>
                                               <div style="font-weight: bold; text-transform: capitalize;" id="ttd_nama"><u><?= $kepalaDinas->nama_user ?></u></div>
                                               <div style="font-weight: bold; text-transform: uppercase;" id="ttd_jabatan">Pembina Utama Muda</div>
                                               <div id="ttd_nip">NIP. <?= $kepalaDinas->nip ?></div>
                                           </div>
                                       </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                       <hr width="100%" style="border: solid 1.5px; margin-top: -7px; margin-bottom: 0px"> 
                                       <div style="font-size: 13pt; line-height: 18px;" class="text-justify">
                                           Dilarang menggandakan sebagian dan atau seluruh isi Surat Keterangan Hasil Pengujian ini tanpa seijin dari Dinas Perdagangan, Koperasi, Usaha Kecil dan Menengah Kabupaten Magelang
                                       </div>
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

        <script type="text/javascript">
            // rupiah2.value = formatRupiah(this.value, 'Rp. ');
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


        <!-- INPUT HASIL =========================================== -->
        <script type="text/javascript">
            function addZero(n){
              if(n <= 9){
                return "0" + n;
              }
              return n
            }

            function cetakHasil(data) {
                $('#modal-cetak #nomor').html('');
                $('#modal-cetak #no_order').html('');
                $('#modal-cetak #tgl_order').html('');
                $('#modal-cetak #nama_alat').html('');
                $('#modal-cetak #spek_alat').html('');
                $('#modal-cetak #nama_usaha').html('');
                $('#modal-cetak #alamat_usaha').html('');
                $('#modal-cetak #metode').html('');
                $('#modal-cetak #standar').html('');
                $('#modal-cetak #tgl_tera').html('');
                $('#modal-cetak #petugas').html('');
                $('#modal-cetak #hasil').html('');
                $('#modal-cetak #berlaku').html('');
                $('#modal-cetak #tgl_ttd').html('');
                // $('#modal-cetak #ttd_nama').html('');
                // $('#modal-cetak #ttd_jabatan').html('');
                // $('#modal-cetak #ttd_nip').html('');

                var id_list = $(data).attr('data-id-list');
                var id_uttp = $(data).attr('data-id-uttp');

                $("#loading-show").fadeIn("slow");

                $.post("<?= base_url().'Admin/getDataHasilUji' ?>", {id_list:id_list, id_uttp:id_uttp}, function(result){
                    $("#loading-show").fadeIn("slow").delay(20).slideUp('slow');

                    var dt = JSON.parse(result);
                    console.log(dt.data);

                    if (dt.response) {
                        var tgl_order = new Date(dt.data.tgl_daftar);
                        var tgl_tera = new Date(dt.data.tgl_tera);
                        var tgl_berlaku = new Date(dt.data.tgl_berlaku);
                        var tgl_cetak = new Date("<?= date('Y-m-d') ?>");

                        $('#modal-cetak #nomor').html(dt.data.nomor_tera);
                        $('#modal-cetak #no_order').html(dt.data.no_order);
                        $('#modal-cetak #tgl_order').html(addZero(tgl_order.getDate())+'-'+addZero(tgl_order.getMonth()+1)+'-'+tgl_order.getFullYear());
                        $('#modal-cetak #nama_alat').html(dt.data.jenis_alat);
                        $('#modal-cetak #nama_usaha').html(dt.data.nama_user+' / '+dt.data.nama_usaha);
                        $('#modal-cetak #alamat_usaha').html(dt.data.alamat_usaha+', '+dt.data.desa+', '+dt.data.kecamatan);
                        $('#modal-cetak #metode').html(dt.data.metode);
                        $('#modal-cetak #standar').html(dt.data.standar);
                        $('#modal-cetak #tgl_tera').html(addZero(tgl_tera.getDate())+' '+nama_bulan(tgl_tera.getMonth())+' '+tgl_tera.getFullYear());
                        $('#modal-cetak #petugas').html(dt.data.nama_petugas+' / NIP. '+dt.data.nip);
                        $('#modal-cetak #hasil').html(dt.data.hasil_tera);
                        $('#modal-cetak #berlaku').html(addZero(tgl_berlaku.getDate())+' '+nama_bulan(tgl_berlaku.getMonth())+' '+tgl_berlaku.getFullYear());
                        $('#modal-cetak #tgl_ttd').html(addZero(tgl_cetak.getDate())+' '+nama_bulan(tgl_cetak.getMonth())+' '+tgl_cetak.getFullYear());
                        // $('#modal-cetak #ttd_nama').html('');
                        // $('#modal-cetak #ttd_jabatan').html('');
                        // $('#modal-cetak #ttd_nip').html('');

                        var spek = '';

                        spek += '<tr>'+
                                    '<td style="padding-left: 25px; min-width: 250px; padding-right: 15px">'+
                                        '<div>Merk</div>'+
                                    '</td>'+
                                    '<td style="padding-right: 15px">:</td>'+
                                    '<td>'+dt.data.merk+'</td>'+
                                '</tr>';

                        spek += '<tr>'+
                                    '<td style="padding-left: 25px; min-width: 250px; padding-right: 15px">'+
                                        '<div>Model / Tipe</div>'+
                                    '</td>'+
                                    '<td style="padding-right: 15px">:</td>'+
                                    '<td>'+dt.data.model_tipe+'</td>'+
                                '</tr>';

                        spek += '<tr>'+
                                    '<td style="padding-left: 25px; min-width: 250px; padding-right: 15px">'+
                                        '<div>Nomor Seri</div>'+
                                    '</td>'+
                                    '<td style="padding-right: 15px">:</td>'+
                                    '<td>'+dt.data.nomor_seri+'</td>'+
                                '</tr>';

                        spek += '<tr>'+
                                    '<td style="padding-left: 25px; min-width: 250px; padding-right: 15px">'+
                                        '<div>Buatan</div>'+
                                    '</td>'+
                                    '<td style="padding-right: 15px">:</td>'+
                                    '<td>'+dt.data.buatan+'</td>'+
                                '</tr>';

                        spek += '<tr>'+
                                    '<td style="padding-left: 25px; min-width: 250px; padding-right: 15px">'+
                                        '<div>Kapasitas</div>'+
                                    '</td>'+
                                    '<td style="padding-right: 15px">:</td>'+
                                    '<td>'+dt.data.kapasitas+'</td>'+
                                '</tr>';

                        

                        if (dt.data.opsi_alat != null) {
                            
                            var ext_spek = JSON.parse(dt.data.opsi_alat);

                            for (var i = 0; i < ext_spek.length; i++) {
                                spek += '<tr>'+
                                            '<td style="padding-left: 25px; min-width: 250px; padding-right: 15px">'+
                                                '<div>'+ext_spek[i].atribut+'</div>'+
                                            '</td>'+
                                            '<td style="padding-right: 15px">:</td>'+
                                            '<td>'+ext_spek[i].value+'</td>'+
                                        '</tr>';
                            }
                        }

                        $('#modal-cetak #spek_alat').html(spek);
 
                        $('#modal-cetak').modal('show');
                    }

                });              
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
                    // document.getElementById('form-print').style.fontSize = "x-large";
                    document.body.innerHTML = printcontent;

                    window.print();

                    location.reload();
                    // window.location.href = "<?//=base_url().'Admin/cetakHasilPengujian/'.encode($id_daftar) ?>";

                    // var display_setting = "toolbar=yes,location=no,directories=yes,menubar=yes,";
                    // display_setting += "scrollbars=yes,width=750, height=600, left=100, top=25";

                    // var printcontent = document.getElementById("form-print").innerHTML;
                    // var document_print = window.open("", "", display_setting);
                    // document_print.document.open();
                    // document_print.document.write('<html><head><title>Cetak SK Hasil Pengujian </title></head>');
                    // document_print.document.write('<body style="font-family:calibri; font-size:14px;" onLoad="self.print();self.close();" >');
                    // document_print.document.write(printcontent);
                    // document_print.document.write('</body></html>');
                    // document_print.print();
                    // document_print.document.close();
                    // return false;
            }
        </script>

        <!-- UPDATE HASIL ============================================ -->

        <script type="text/javascript">
            function addSpekAlat(data) {
                var modal = $(data).parent().parent().parent().parent().parent().parent().attr('id');

                var spek =  '<div class="row m-b-5">'+
                                '<div class="col-md-12">'+
                                    '<input required type="text" name="atribut[]" class="form-control" style="width: 45%" placeholder="Masukkan atribut">'+
                                    ' : '+
                                    '<input required type="text" name="value[]" class="form-control" style="width: 45%" placeholder="Masukkan value">'+
                                    '<button type="button" class="btn btn-sm btn-danger" style="float: right; margin-top: 5px" onclick="hapusSpek(this)" title="Hapus"><i class="fa fa-close"></i></button>'+
                                '</div>'+
                            '</div>';
                $('#'+modal+' #spek_alat').append(spek);
            }

            function hapusSpek(data) {
                $(data).parent().parent().remove();
            }

            function changeDataUser(data) {
                var modal = $(data).parent().parent().parent().parent().parent().parent().attr('id');
                var idUser = $('#'+modal+' #id_petugas').val();

                if (idUser == '' || idUser == null) {
                    $('#'+modal+' #users').val('');
                }
            }
        </script>

        <!-- ======================================================= -->
