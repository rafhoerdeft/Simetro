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

                    <h3 class="text-themecolor">Sidang Tera</h3>

                </div>



                <div class="col-md-6 align-self-center">

                    <ol class="breadcrumb">

                        <!-- <label>Jenis Perlengkapan</label> -->

                        <li class="breadcrumb-item active">Sidang Tera</li>

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

                        <!-- <form id="tambahDataSidang" method="POST" action="<?//= base_url().'Admin/simpanDataSidang' ?>"> -->
                        <form id="tambahDataSidang" onsubmit="submitInputInspeksi()" action="javascript:void(0)">

                            <div class="modal-body">



                                <!-- <input type="hidden" name="id_sidang" id="id_sidang"> -->

                                <input type="hidden" name="jml_cek" id="jml_cek" value="0">

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



                                <label for="petugas" class="control-label">Menugaskan :</label>

                                <div class="table-responsive" id="petugas">

                                    <table id="tbl_petugas" class="table table-bordered table-striped table-hover" style="font-size: 11pt">

                                        <thead class="bg-megna text-white">

                                            <tr>

                                                <th class="text-center">#</th>

                                                <th>Nama Pegawai</th>

                                                <th>Jabatan</th>

                                            </tr>

                                        </thead>



                                        <tbody>

                                            <?php foreach ($dataPetugas as $key) { 

                                                    if ($key->jabatan != 'Kepala Dinas') { 

                                                ?>

                                                <tr>

                                                    <td align="center">

                                                        <input type="checkbox" onclick="cekPetugas(<?= $key->id_petugas ?>)" name="id_petugas[]" id="ck_<?= $key->id_petugas ?>" value="<?= $key->id_petugas ?>" class="filled-in chk-col-teal" /><label for="ck_<?= $key->id_petugas ?>"></label>

                                                    </td>

                                                    <td><?= $key->nama_user ?></td>

                                                    <td><?= $key->jabatan ?></td>

                                                </tr>

                                            <?php }} ?>

                                        </tbody>

                                    </table>

                                </div>

                                

                            </div>

                            <div class="modal-footer">

                                <button type="submit" class="btn btn-info waves-effect waves-light" id="simpan_kategori"><i class="fa fa-save"></i> Simpan</button>

                                <!-- <button type="submit" class="btn btn-info waves-effect waves-light" id="simpan_kategori"><i class="fa fa-arrow-right"></i> Simpan & Lanjut Register UTTP</button> -->

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
            function cekPetugas(id) {

                var cek = $('#tambahDataSidang #ck_'+id);
                var jml_cek = parseInt($('#tambahDataSidang #jml_cek').val());

                if (cek.is(":checked")) {
                    jml_cek++;
                    $('#tambahDataSidang #jml_cek').val(jml_cek);
                    // cek.attr('checked', false);
                } else {
                    jml_cek--;
                    $('#tambahDataSidang #jml_cek').val(jml_cek);
                    // cek.attr('checked', true);
                }                
            }

            function submitInputInspeksi(argument) {
                var data_form = $('#tambahDataSidang').serializeArray();

                // console.log(data_form[0].value);

                if (data_form[0].value > 0) {

                    $.post("<?= base_url().'Admin/simpanDataSidang' ?>", data_form, function(result){
                        var dt = JSON.parse(result);

                        if (dt.response) {
                            window.location.href = "<?= base_url().'Admin/dataListSidang' ?>";
                        } else {
                            location.reload();
                        }
                    });
                } else {
                    alert('Pilih pegawai yang akan ditugaskan!');
                }
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

            