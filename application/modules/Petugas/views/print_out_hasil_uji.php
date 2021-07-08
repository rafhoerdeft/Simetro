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
                        <div id="form-print">
                            <!-- <img src="<?//= base_url().'assets/assets/images/logo/logo-metro-bw.png' ?>" style="position: absolute;opacity: 0.6; left: 25%; top: 30%;"> -->
                            <table border="0" width="90%" style="font-size: 14pt; color: black; font-family: arial; margin: auto; z-index: 2" cellpadding="10">
                                <tr>
                                    <td style="text-align: center; ">
                                        <div style="font-weight: bold; font-size: 18pt"><u>SURAT KETERANGAN HASIL PENGUJIAN</u></div>
                                        <div style="margin-top: -9px; font-size: 12pt"><i>Verification Report</i></div>
                                        <div style="margin-top: -8px;">Nomor: <label id="nomor">510.63/302/IX/2019</label></div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <table border="0" align="right" width="250">
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
                                                            <td style="padding-right: 65px">
                                                                <div style="font-weight: bold;"><u>Nama Alat</u></div>
                                                                <div style="font-size: 11pt; margin-top: -9px"><i>Measuring Instrument</i></div>
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
                                                    <div style="font-size: 11pt; margin-top: -9px"><i>Owner/User</i></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="6">
                                                    <table>
                                                        <tr>
                                                            <td style="padding-left: 25px; padding-right: 115px">
                                                                <div>Nama</div>
                                                            </td>
                                                            <td style="padding-right: 25px">:</td>
                                                            <td style="font-weight: bold" id="nama_usaha">SPBU 44.564.02 (PT SUDEWO SUDEWI ENERGI SEJAHTERA)</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding-left: 25px; padding-right: 115px">
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
                                                    <div style="font-size: 11pt; margin-top: -9px"><i>Method/Standar</i></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="6">
                                                    <table>
                                                        <tr>
                                                            <td style="padding-left: 25px; padding-right: 110px">
                                                                <div>Metode</div>
                                                            </td>
                                                            <td style="padding-right: 25px">:</td>
                                                            <td id="metode">Keputusan DJSPK No. 134/SPK/KEP/10/2015</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding-left: 25px; padding-right: 110px">
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
                                                            <td style="padding-right: 73px">
                                                                <div style="font-weight: bold;"><u>Tanggal Tera</u></div>
                                                                <div style="font-size: 11pt; margin-top: -9px"><i>Date of Verificated</i></div>
                                                            </td>
                                                            <td style="padding-right: 25px" valign="top">:</td>
                                                            <td valign="top" id="tgl_tera">05 September 2019</td>
                                                        </tr>
                                                        <!-- ============================================================= -->
                                                        <tr>
                                                            <td style="padding-right: 73px">
                                                                <div style="font-weight: bold;"><u>Penera</u></div>
                                                                <div style="font-size: 11pt; margin-top: -9px"><i>Verfication Officer</i></div>
                                                            </td>
                                                            <td style="padding-right: 25px" valign="top">:</td>
                                                            <td style="font-weight: bold;" valign="top" id="petugas">Wendi Sutarman, S.T. / NIP. 19771118 201001 1 007</td>
                                                        </tr>
                                                        <!-- ============================================================== -->
                                                        <tr>
                                                            <td style="padding-right: 73px">
                                                                <div style="font-weight: bold;"><u>Hasil</u></div>
                                                                <div style="font-size: 11pt; margin-top: -9px"><i>Result</i></div>
                                                            </td>
                                                            <td style="padding-right: 25px" valign="top">:</td>
                                                            <td style="font-weight: bold;" valign="top" id="hasil">Disahkan untuk Tera Ulang Tahun 2019</td>
                                                        </tr>
                                                        <!-- ================================================================ -->
                                                        <tr>
                                                            <td style="padding-right: 73px">
                                                                <div style="font-weight: bold;"><u>Berlaku Sampai</u></div>
                                                                <div style="font-size: 11pt; margin-top: -9px"><i>This report due to</i></div>
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
                                           <div class="col-md-7"></div>
                                           <div class="col-md-5 text-center" style="line-height: 20px">
                                               Kota Mungkid, <span id="tgl_ttd">06 September 2019</span> <br>
                                               Kepala Dinas Perdagangan, Koperasi, <br> Usaha Kecil dan Menengah <br> Kabupaten Magelang, 
                                               <br> <br> <br> <br> <br>
                                               <div style="font-weight: bold" id="ttd_nama"><u>Drs. ASFURI, M.Si</u></div>
                                               <div style="font-weight: bold" id="ttd_jabatan">Pembina Utama Muda</div>
                                               <div id="ttd_nip">NIP. 19670305 199303 1 007</div>
                                           </div>
                                       </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                       <hr width="100%" style="border: solid 1.5px; margin-top: -7px; margin-bottom: 0px"> 
                                       <div style="font-size: 12pt; line-height: 18px;" class="text-justify">
                                           Dilarang menggandakan sebagian dan atau seluruh isi Surat Keterangan Hasil Pengujian ini tanpa seijin dari Dinas Perdagangan, Koperasi, Usaha Kecil dan Menengah Kabupaten Magelang
                                       </div>
                                    </td>
                                </tr>
                            </table>
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
            function addZero(n){
              if(n <= 9){
                return "0" + n;
              }
              return n
            }

            function cetakForm(id) {
                // alert(id);
                $("#loading-show").fadeIn("slow");

                $.post("<?= base_url().'Petugas/getDataForm' ?>", {id_daftar:id}, function(result){
                    $("#loading-show").fadeIn("slow").delay(20).slideUp('slow');

                    var dt = JSON.parse(result);
                    console.log(dt);

                    var tgl_daftar = new Date(dt.dataForm.tgl_daftar);

                    $('#form-print #tanggal').html(addZero(tgl_daftar.getDate())+'-'+addZero(tgl_daftar.getMonth()+1)+'-'+tgl_daftar.getFullYear());
                    $('#form-print #title').html(dt.dataForm.layanan.toUpperCase());
                    $('#form-print #judul').html(dt.dataForm.layanan.toUpperCase());
                    $('#form-print #nama_user').html(dt.dataForm.nama_user+'/'+dt.dataForm.jenis_usaha);
                    $('#form-print #almt_user').html(dt.dataForm.alamat+', '+dt.dataForm.desa+', '+dt.dataForm.kecamatan);
                    $('#form-print #telp_user').html(dt.dataForm.no_telp);
                    $('#form-print #jenis_pesanan').html(dt.dataForm.layanan);
                    $('#form-print #tgl_ttd').html(addZero(tgl_daftar.getDate())+' '+nama_bulan(tgl_daftar.getMonth())+' '+tgl_daftar.getFullYear());

                    var list_uttp = '';
                    for (var i = 0; i < 15; i++) {
                        let no = i + 1;
                        list_uttp += '<tr style="border-bottom: 0">'+
                                       '<td align="center">'+no+'</td>';
                        var cek = 0;
                        for (var x = 0; x < dt.listUttp.length; x++) {
                            console.log('Jenis: ',dt.listUttp[x].jenis_alat);
                            if (i==x) {
                                cek++;                                                
                            }
                        }

                        if (cek > 0) {
                            list_uttp   +=  '<td>'+dt.listUttp[i].jenis_alat+'</td>'+
                                            '<td>'+dt.listUttp[i].kategori_alat+'</td>'+
                                            '<td align="center">'+dt.listUttp[i].kapasitas+'</td>'+
                                            '<td align="center">'+dt.listUttp[i].jumlah_uttp+'</td>';
                        } else {
                            list_uttp   +=  '<td></td>'+
                                            '<td></td>'+
                                            '<td></td>'+
                                            '<td align="center"></td>';
                        }

                        list_uttp += '</tr>';
                    }

                    $('#form-print #list_uttp').html(list_uttp);

                    $('#cetak_formulir').modal('show');
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
                    document.body.innerHTML = printcontent;
                    window.print();

                    window.location.href = "<?=base_url().'Petugas/pengajuanMasuk' ?>";
            }
        </script>

        <script type="text/javascript">
            function addZero(n){
              if(n <= 9){
                return "0" + n;
              }
              return n
            }

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

        </script>
            