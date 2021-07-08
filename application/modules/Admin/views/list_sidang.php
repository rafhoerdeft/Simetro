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

                    <h3 class="text-themecolor">Daftar Sidang Tera</h3>

                </div>



                <div class="col-md-6 align-self-center">

                    <ol class="breadcrumb">

                        <!-- <label>Jenis Perlengkapan</label> -->

                        <li class="breadcrumb-item active">Daftar Sidang Tera</li>

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

                        <!-- <button class="btn waves-effect waves-light btn-inverse float-right" onclick="tambahData()"><i class="fa fa-plus"></i> Sidang Tera</button>

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

                                    <tr style="font-size: 11pt">

                                        <th width="70"><b>#</b></th>

                                        <th><b>Tempat Sidang</b></th>

                                        <th><b>Tgl Sidang</b></th>

                                        <th><b>Aksi</b></th>

                                    </tr>

                                </thead>

                                <tbody>

                                    <?php 

                                        $no = 0;

                                        foreach ($list_sidang as $st) { 

                                            $no++;

                                    ?>

                                            <tr style="font-size: 12pt">

                                                <td align="center" width="20"><?= $no ?></td>

                                                <td><?= $st->nama_pasar ?></td>

                                                <td align="center"><?= date('d-m-Y', strtotime($st->tgl_sidang)) ?></td>



                                                <td width="200" align="center">

                                                    <div class="d-none d-sm-none d-md-block d-lg-block">

                                                        <a class="btn btn-sm btn-inverse waves-effect waves-light m-b-5" style="width: 35px" href="<?= base_url().'Admin/dataSidangTera/x/'.encode($st->id_sidang) ?>" title="Pengajuan Tera"><i class="fa fa-plus"></i> </a>



                                                        <button type="button" style="width: 35px" class="btn btn-sm btn-primary waves-effect waves-light m-b-5"  onclick="cetakSpt(<?= $st->id_sidang ?>)"  title="Cetak SPT"><i class="fa fa-print"></i></button>



                                                        <button type="button" data-id="<?= $st->id_sidang ?>" data-pasar="<?= $st->id_pasar ?>" data-tgl="<?= date('d-m-Y', strtotime($st->tgl_sidang)) ?>" onclick="editData(this)" class="btn btn-sm btn-info waves-effect waves-light m-b-5" style="width: 35px" title="Edit Sidang"><i class="fa fa-edit"></i></button>



                                                        <button type="button" class="btn btn-sm btn-danger waves-effect waves-light m-b-5" style="width: 35px" onclick="showConfirmMessage(<?= $st->id_sidang ?>)" title="Hapus Sidang"><i class="fa fa-trash"></i></button>

                                                    </div>



                                                    <div class="d-block d-sm-block d-md-none d-lg-none">

                                                        <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                                            <i class="fa fa-cog"></i>

                                                        </button>



                                                        <div class="dropdown-menu">

                                                            <a class="dropdown-item" href="<?= base_url().'Admin/dataSidangTera/x/'.encode($st->id_sidang) ?>"><i class="fa fa-plus"></i> Pengajuan Tera</a>



                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="cetakSpt(<?= $st->id_sidang ?>)"><i class="fa fa-print"></i> Cetak SPT</a>



                                                            <a class="dropdown-item" href="javascript:void(0)" data-id="<?= $st->id_sidang ?>" data-pasar="<?= $st->id_pasar ?>" onclick="editData(this)" data-tgl="<?= date('d-m-Y', strtotime($st->tgl_sidang)) ?>"><i class="fa fa-pencil-square-o"></i> Edit Sidang</a>

                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="showConfirmMessage('<?= $st->id_sidang ?>')"><i class="fa fa-trash-o"></i> Hapus Sidang</a>

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

                            <h4 class="modal-title">Tambah Sidang</h4>

                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                        </div>

                        <form id="tambahDataSidang" method="POST" action="<?= base_url().'Admin/tambahDataSidang' ?>">

                            <div class="modal-body">



                                <!-- <input type="hidden" name="id_sidang" id="id_sidang"> -->



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



                                <div class="form-group">

                                    <label for="tgl_sidang" class="control-label">Tanggal Sidang :</label>

                                    <input type="text" class="form-control mydatepicker" id="tgl_sidang" placeholder="tanggal-bulan-tahun" name="tgl_sidang" required autocomplete="off">

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

                            <h4 class="modal-title">Update Sidang Tera</h4>

                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                        </div>

                        <!-- <form id="updateDataSidang" method="POST" action="<?//= base_url().'Admin/updateDataSidang' ?>"> -->
                        <form id="updateDataSidang" onsubmit="submitInputInspeksi()" action="javascript:void(0)">

                            <div class="modal-body">



                                <input type="hidden" name="id_sidang" id="id_sidang">



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



                                <div class="form-group">

                                    <label for="tgl_sidang" class="control-label">Tanggal Sidang :</label>

                                    <input type="text" class="form-control mydatepicker" id="tgl_sidang" placeholder="tanggal-bulan-tahun" name="tgl_sidang" required autocomplete="off">

                                </div>

                                <hr>

                                <input type="hidden" name="jml_cek" id="jml_cek" value="0">

                                <label for="petugas" class="control-label">Menugaskan :</label>

                                <div class="table-responsive" id="petugas">

                                    <table id="tbl_petugas" class="table table-bordered table-striped table-hover" style="font-size: 10pt">

                                        <thead>

                                            <tr>

                                                <th>#</th>

                                                <th>Nama Pegawai</th>

                                                <th>Jabatan</th>

                                            </tr>

                                        </thead>



                                        <tbody> </tbody>

                                    </table>

                                </div>

                            </div>

                            <div class="modal-footer">

                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>

                                <button type="submit" class="btn btn-info waves-effect waves-light" id="simpan_sidang"><i class="fa fa-save"></i> Update</button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>



            <div id="cetak_spt" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

                <div class="modal-dialog modal-lg">

                    <div class="modal-content" style="margin: 0 -15%; width: 130%;">

                        <div class="modal-header">

                            <h4 class="modal-title">Cetak SPT</h4>

                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                        </div>

                        <div class="modal-body" id="form-print">



                            <table id="tbl_spt" border="0" width="90%" style="font-size: 18pt; color: black; font-family: times new romans; margin: auto; z-index: 2; margin-top: 20px" cellpadding="10">

                                 <tr style="border-bottom: 7px double;">

                                    <td>

                                        <img src="<?= base_url().'assets/assets/images/logo/logo_kab_mgl_xs.png' ?>" width="100">

                                    </td>

                                    <td class="text-center" style="width: 100%">

                                        <h2 style="font-family: arial; color: black; line-height: 30px;">

                                            <span style="font-family: arial;">PEMERINTAH KABUPATEN MAGELANG</span><br>

                                            <span style="font-weight: bolder; font-size: 22pt">DINAS PERDAGANGAN, KOPERASI DAN <br> USAHA KECIL MENENGAH </span> <br>

                                            <!-- KABUPATEN MAGELANG <br> -->

                                            <span style="font-size: 14pt">Jalan Soekarno - Hatta No 24 - 26 Telp. (0293) 788227 

                                            Kota Mungkid 56511</span>

                                        </h2>

                                    </td>

                                </tr>



                                <tr>

                                    <td colspan="2" class="text-center">

                                        <div style="font-weight: bold; text-decoration: underline;">

                                            SURAT PERINTAH TUGAS

                                        </div>

                                        <div style="margin-top: -5px">NOMOR: <span id="no_spt">094/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/21/<?= date('Y') ?></span></div>

                                    </td>

                                </tr>



                                <tr>

                                    <td colspan="2">

                                        <table border="0" width="100%">

                                            <tr>

                                                <td width="150" valign="top">Dasar</td>

                                                <td width="30" valign="top">:</td>

                                                <td>Program Perlindungan Konsumen dan Pengamanan Perdagangan Tahun Anggaran <?= date('Y') ?></td>

                                            </tr>



                                            <tr>

                                                <td colspan="3">

                                                    <div style="font-weight: bold; text-align: center; margin-top: 10px; margin-bottom: 10px">MEMERINTAHKAN : </div>

                                                </td>

                                            </tr>



                                            <tr>

                                                <td width="150" valign="top">Kepada</td>

                                                <td width="30" valign="top">:</td>

                                                <td id="kepada">



                                                    <table border="0" style="line-height: 25px; margin-bottom: 10px">

                                                        <tr>

                                                            <td width="30" align="left">1.</td>

                                                            <td width="100">Nama</td>

                                                            <td width="20">:</td>

                                                            <td>USWATUN WULANDARI,S.Psi,M.Pd</td>

                                                        </tr>

                                                        <tr>

                                                            <td width="30"> </td>

                                                            <td width="100">NIP</td>

                                                            <td width="20">:</td>

                                                            <td>19750430 1999903 2 005</td>

                                                        </tr>

                                                        <tr>

                                                            <td width="30"> </td>

                                                            <td width="100">Jabatan</td>

                                                            <td width="20">:</td>

                                                            <td>Kabid. Metrologi</td>

                                                        </tr>

                                                    </table>



                                                </td>

                                            </tr>



                                            <tr>

                                                <td width="150" valign="top">Untuk</td>

                                                <td width="30" valign="top">:</td>

                                                <td>

                                                    Melakukan sidang tera

                                                    <table style="line-height: 25px">

                                                        <tr>

                                                            <td width="130">Hari</td>

                                                            <td width="20">:</td>

                                                            <td id="hari">Rabu</td>

                                                        </tr>

                                                        <tr>

                                                            <td width="130">Tanggal</td>

                                                            <td width="20">:</td>

                                                            <td id="tgl">20 November 2019</td>

                                                        </tr>

                                                        <tr>

                                                            <td width="130" valign="top">Tempat</td>

                                                            <td width="20" valign="top">:</td>

                                                            <td id="tempat">

                                                                Trans Luxury Hotel Bandung <br>

                                                                Jln. Gatot Subroto No. 289, Cibangkong, Kec.Batununggal

                                                                Kota Bandung, Jawa Barat 

                                                            </td>

                                                        </tr>

                                                    </table>

                                                </td>

                                            </tr>



                                            <tr>

                                                <td width="150"></td>

                                                <td width="30"></td>

                                                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Demikian untuk diperhatikan dan dilaksanakan dengan penuh tanggung jawab.</td>

                                            </tr>



                                            <tr>

                                                <td colspan="2"></td>

                                                <td style="text-align: center; padding-left: 200px">

                                                    <table align="center" width="90%" style="line-height: 25px; margin-bottom: 10px">

                                                        <tr>

                                                            <td>

                                                                Ditetapkan di Kota Mungkid

                                                            </td>

                                                        </tr>

                                                        <tr>

                                                            <td>

                                                                pada tanggal <span id="tgl_spt"><?= formatTanggalTtd(date('d-m-Y')) ?></span>

                                                            </td>

                                                        </tr>

                                                    </table>

                                                    <div style="line-height: 25px">

                                                        KEPALA DINAS PERDAGANGAN, KOPERASI <br>DAN USAHA KECIL MENENGAH <br>

                                                        KABUPATEN MAGELANG <br> <br> <br> <br>

                                                        <div style="text-decoration: underline; font-weight: bold;"><?= $kepalaDinas->nama_user ?></div>

                                                        <div><?= $kepalaDinas->golongan ?></div>

                                                        <div>NIP. <?= $kepalaDinas->nip ?></div>

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





        <!-- OPERASI DATA =========================================== -->

        <script type="text/javascript">

            function tambahData() {

                $('#modal-tambah #tambahDataSidang').trigger("reset");

                $('#modal-tambah #tgl_sidang').datepicker('setDate', "<?= date('d-m-Y') ?>"); 

                $('#modal-tambah').modal('show');

            }



            function editData(data) {

                $('#modal-edit #updateDataSidang').trigger("reset");

                var id = $(data).attr('data-id');
                var pasar = $(data).attr('data-pasar');
                var tgl = $(data).attr('data-tgl');

                $("#loading-show").fadeIn("slow");

                $.post("<?= base_url().'Admin/editListSidang' ?>", {id_sidang:id}, function(result){

                    $("#loading-show").fadeIn("slow").delay(20).slideUp('slow');

                    var dt = JSON.parse(result);

                    if (dt.response) {

                        var inputCek = '';
                        for (var x = 0; x < dt.dataPetugas.length; x++) {
                            if (dt.dataPetugas[x].jabatan != 'Kepala Dinas') {
                                inputCek += '<tr>'+
                                                '<td>'+
                                                    '<input type="checkbox" onclick="cekPetugas('+dt.dataPetugas[x].id_petugas+')"  name="id_petugas[]" id="ck_'+dt.dataPetugas[x].id_petugas+'" value="'+dt.dataPetugas[x].id_petugas+'" class="filled-in chk-col-teal" />'+
                                                    '<label for="ck_'+dt.dataPetugas[x].id_petugas+'"></label>'+
                                                '</td>'+
                                                '<td>'+dt.dataPetugas[x].nama_user+'</td>'+
                                                '<td>'+dt.dataPetugas[x].jabatan+'</td>'+
                                            '</tr>';
                            }
                        }

                        $('#modal-edit #tbl_petugas tbody').html(inputCek);

                        var jml_cek = 0;
                        for (var i = 0; i < dt.petugas.length; i++) {
                            jml_cek++;
                            $('#tbl_petugas #ck_'+dt.petugas[i].id_petugas).attr('checked',true);
                        }
                        $('#modal-edit #jml_cek').val(jml_cek);
                    }

                });

                $('#modal-edit #id_sidang').val(id);

                $('#modal-edit #id_pasar').val(pasar).change();

                $('#modal-edit #tgl_sidang').datepicker('setDate', tgl); 



                $('#modal-edit').modal('show');

            }

            function cekPetugas(id) {

                var cek = $('#modal-edit #tbl_petugas #ck_'+id);
                var jml_cek = parseInt($('#modal-edit #jml_cek').val());

                if (cek.is(":checked")) {
                    jml_cek++;
                    $('#modal-edit #jml_cek').val(jml_cek);
                    // cek.attr('checked', false);

                } else {
                    jml_cek--;
                    $('#modal-edit #jml_cek').val(jml_cek);
                    // cek.attr('checked', true);

                }                

            }

            function submitInputInspeksi(argument) {
                var data_form = $('#modal-edit #updateDataSidang').serializeArray();

                // console.log(data_form);

                if (data_form[3].value > 0) {

                    $.post("<?= base_url().'Admin/updateDataSidang' ?>", data_form, function(result){
                        var dt = JSON.parse(result);

                        // console.log(dt);

                        location.reload();
                    });
                } else {
                    alert('Pilih pegawai yang akan ditugaskan!');
                }
            }



            function cetakSpt(id) {



                $("#loading-show").fadeIn("slow");



                $.post("<?= base_url().'Admin/getDataSptSidang' ?>", {id_sidang:id}, function(result){

                    $("#loading-show").fadeIn("slow").delay(20).slideUp('slow');



                    var dt = JSON.parse(result);

                    // console.log(dt);



                    if (dt.response) {

                        var kepada = '';

                        for (var i = 0; i < dt.petugas.length; i++) {

                            var no = i+1;

                            kepada +=   '<table border="0" style="line-height: 25px; margin-bottom: 10px">'+

                                                '<tr>'+

                                                    '<td width="30" align="left">'+ no +'. </td>'+

                                                    '<td width="100">Nama</td>'+

                                                    '<td width="20">:</td>'+

                                                    '<td>'+dt.petugas[i].nama_user+'</td>'+

                                                '</tr>'+

                                                '<tr>'+

                                                    '<td width="30"> </td>'+

                                                    '<td width="100">NIP</td>'+

                                                    '<td width="20">:</td>'+

                                                    '<td>'+dt.petugas[i].nip+'</td>'+

                                                '</tr>'+

                                                '<tr>'+

                                                    '<td width="30"> </td>'+

                                                    '<td width="100">Jabatan</td>'+

                                                    '<td width="20">:</td>'+

                                                    '<td>'+dt.petugas[i].jabatan+'</td>'+

                                                '</tr>'+

                                            '</table>';

                        }



                        $('#cetak_spt #tbl_spt #kepada').html(kepada);

                        $('#cetak_spt #tbl_spt #hari').html(nameDays(dt.tera.tgl_sidang));

                        $('#cetak_spt #tbl_spt #tgl').html(formatTglSurat(dt.tera.tgl_sidang));

                        var alamat = dt.tera.nama_pasar+', '+dt.tera.desa+' '+dt.tera.kecamatan;

                        $('#cetak_spt #tbl_spt #tempat').html(alamat);

                        $('#cetak_spt #tbl_spt #tgl_spt').html(formatTglSurat(dt.tera.tgl_sidang));



                        $('#cetak_spt').modal('show');

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



            function nameDays(tanggal='') {

                var date = new Date(tanggal);

                var hari = [

                    'Minggu',

                    'Senin',

                    'Selasa',

                    'Rabu',

                    'Kamis',

                    'Jumat',

                    'Sabtu'

                ];



                return hari[date.getDay()];

            }



            function formatTglSurat(tanggal='') {

                var date = new Date(tanggal);

                var tgl = addZero(date.getDate())+' '+nama_bulan(date.getMonth())+' '+date.getFullYear();

                return tgl;

            }



            function printForm(argument) {

                    var printcontent = document.getElementById('form-print').innerHTML;

                    document.body.innerHTML = printcontent;

                    window.print();



                    location.reload();

                    // window.location.href = "<?//=base_url().'Admin/pengajuanMasuk/proses' ?>";

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

                        url  : "<?php echo base_url('Admin/deleteDataSidang')?>",

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

            