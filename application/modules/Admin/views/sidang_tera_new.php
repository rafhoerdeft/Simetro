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

                    <h3 class="text-themecolor">Daftar Pengajuan Tera/Tera Ulang (<?= $nama_pasar ?>)</h3>

                </div>



                <div class="col-md-6 align-self-center">

                    <ol class="breadcrumb">

                        <li class="breadcrumb-item"><a href="<?= base_url().'Admin/dataListSidang' ?>" class="text-danger">Daftar Sidang Tera</a></li>

                        <li class="breadcrumb-item active">Daftar Pengajuan Tera</li>

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
                            <div class="col-md-4 m-b-5"> </div>

                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-8"> </div>
                                    <div class="col-md-4"> 
                                        <a href="<?= base_url().'Admin/pendaftaranSidangTera/'.encode($id_sidang) ?>" class="btn btn-block waves-effect waves-light btn-inverse float-right"><i class="mdi mdi-file-document"></i> Pengajuan Tera</a>
                                    </div>
                                </div>                              
                            </div>
                        </div>
                    </div>
                </div>


                <div class="card">
                    <div class="card-body p-b-20">
                        <div class="table-responsive">
                            <table id="myTable" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr style="font-size: 10pt; text-align: center;">
                                        <th width="110"><b>Aksi</b></th>
                                        <th><b>No.</b></th>
                                        <th><b>No. Order</b></th>
                                        <th><b>Pemilik</b></th>
                                        <!-- <th><b>Usaha</b></th> -->
                                        <th><b>Layanan</b></th>
                                        <th nowrap><b>Tgl Daftar</b></th>
                                        <!-- <th><b>Jenis</b></th> -->
                                        <!-- <th><b>Kapasitas</b></th> -->
                                        <th><b>Timbangan</b></th>
                                        <th><b>Anak Timbangan</b></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php 
                                        $no = 0;
                                        foreach ($dataSidangTera as $tera) { 
                                            $no++;
                                    ?>
                                            <tr style="font-size: 10pt">
                                                <td nowrap align="center">
                                                    <!-- <a href="<?= base_url().'Admin/editPendaftaranSidangTera/'.encode($tera->id_list_sidang).'/'.encode($id_sidang) ?>" data-id="<?= $tera->id_list_sidang ?>" class="btn btn-sm btn-info waves-effect waves-light m-b-5" style="width: 35px" title="Edit Data"><i class="fa fa-pencil-square-o"></i></a> -->


                                                    <button type="button" onclick="showConfirmMessage('<?= $tera->id_list_sidang ?>')" class="btn btn-sm btn-danger waves-effect waves-light" style="width: 35px" title="Hapus Data"><i class="fa fa-trash-o"></i></button>

                                                    <a href="<?= base_url().'Admin/printSidangKwitansi/'.encode($tera->id_list_sidang).'/'.encode($id_sidang).'/'.encode($id_pasar).'/1' ?>" class="btn btn-sm btn-primary waves-effect waves-light" style="width: 35px" title="Cetak Kwitansi"><i class="fa fa-print"></i></a>
                                                </td>
                                                <td align="center" width="20"><?= $no ?></td>
                                                <td align="center"><?= $tera->no_order ?></td>
                                                <td><?= $tera->nama_user ?></td>
                                                <!-- <td><?= $tera->jenis_usaha ?></td> -->
                                                <td align="center" width="70"><?= $tera->layanan ?></td>
                                                <td align="center"><?= date('d-m-Y', strtotime($tera->tgl_daftar)) ?></td>

                                                <!-- <td width="100" align="center">
                                                    <span style="font-size: 7.2pt; width: 75px; text-align: center;" class="label label-<?= ($tera->status=='belum kirim'?'warning':($tera->status=='diterima'?'info':($tera->status=='proses'?'primary':($tera->status=='selesai'?'success':($tera->status=='pending'?'inverse':'danger'))))) ?>"><b><?= $tera->status ?></b></span>

                                                    <button style="width: 75px;" type="button" onclick="showDetail(<?= $tera->id_list_sidang ?>)" class="btn btn-sm btn-outline-info waves-effect waves-light m-t-5"  title="Lihat Keterangan"><i class="fa fa-eye"></i> Detail</button>
                                                </td> -->

                                                <!-- <td width="70"><?= $tera->jenis_alat ?></td> -->
                                                <!-- <td width="70"><?= $tera->kapasitas ?></td> -->
                                                <td width="70">
                                                    <button onclick="detailTimbang('<?= $tera->id_list_sidang ?>')" type="button" class="btn btn-sm btn-block btn-inverse"><i class="fa fa-eye"></i> Detail</button>
                                                </td>
                                                <td width="70">
                                                    <button onclick="detailAnakTimbang('<?= $tera->id_list_sidang ?>')" type="button" class="btn btn-sm btn-block btn-primary"><i class="fa fa-eye"></i> Detail</button>
                                                </td>

                                            </tr>

                                    <?php } ?>

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>



            <div id="modal_detail_timbang" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content" style="margin: 0 -15%; width: 130%;">
                        <div class="modal-header">
                            <h4 class="modal-title">Detail Timbangan</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>

                        <div class="modal-body" id="form-print">

                            <table id="tbl_detail_timbang" class="table table-striped table-hover" style="margin: auto; font-size: 10pt">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Jenis Alat</th>
                                        <th>Kapasitas</th>
                                        <th>Jumlah</th>
                                        <th>Tarif</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>

                                <tfoot>
                                    <tr style="font-weight: bold;">
                                        <td colspan="5">Total Bayar (Rp)</td>
                                        <td id="total_bayar" align="right"></td>
                                    </tr>
                                </tfoot>
                            </table>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>

                            <!-- <button type="button" class="btn btn-danger waves-effect waves-light" onclick="printForm()"><i class="fa fa-print"></i> Print</button> -->
                        </div>
                    </div>
                </div>
            </div>

            <div id="modal_detail_anak_timbang" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content" style="margin: 0 -15%; width: 130%;">
                        <div class="modal-header">
                            <h4 class="modal-title">Detail Anak Timbangan</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>

                        <div class="modal-body" id="form-print">

                            <table id="tbl_detail_anak_timbang" class="table table-striped table-hover" style="margin: auto; font-size: 10pt">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Jenis</th>
                                        <th>Kapasitas</th>
                                        <th>Jumlah</th>
                                        <th>Tarif</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        Data Kosong
                                    </tr>
                                </tbody>

                                <tfoot>
                                    <tr style="font-weight: bold;">
                                        <td colspan="5">Total Bayar (Rp)</td>
                                        <td id="total_bayar" align="right"></td>
                                    </tr>
                                </tfoot>
                            </table>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>

                            <!-- <button type="button" class="btn btn-danger waves-effect waves-light" onclick="printForm()"><i class="fa fa-print"></i> Print</button> -->
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

                $('#modal-kirim #kirimPengajuan #id_list_sidang').val(id);

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



                $.post("<?= base_url().'Admin/getDataForm' ?>", {id_list_sidang:id}, function(result){

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

                    if (dt.listUttp.length <= 10) {

                        for (var i = 0; i < 10; i++) {

                            let no = i + 1;

                            list_uttp += '<tr style="border-bottom: 0">'+

                                           '<td align="center">'+no+'</td>';

                            var cek = 0;

                            for (var x = 0; x < dt.listUttp.length; x++) {

                                // console.log('Jenis: ',dt.listUttp[x].jenis_alat);

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

                    } else {

                        for (var x = 0; x < dt.listUttp.length; x++) {

                            // console.log('Jenis: ',dt.listUttp[x].jenis_alat);

                            list_uttp   +=  '<td>'+dt.listUttp[x].jenis_alat+'</td>'+

                                            '<td>'+dt.listUttp[x].kategori_alat+'</td>'+

                                            '<td align="center">'+dt.listUttp[x].kapasitas+'</td>'+

                                            '<td align="center">'+dt.listUttp[x].jumlah_uttp+'</td>';

                        }

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



                    window.location.href = "<?=base_url().'Admin/dataSidangTera' ?>";

            }

            function changeRupe(data){

                var val = formatRupiah($(data).val(), 'Rp. ');
                $(data).val(val);
            }

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

            function detailTimbang(id='') {

                $.post("<?= base_url().'Admin/getDetailTimbangan' ?>", {id_list_sidang:id}, function(result){
                    $("#loading-show").fadeIn("slow").delay(20).slideUp('slow');

                    var dt = JSON.parse(result);

                    // console.log(dt.data);

                    if (dt.response) {
                        var row = '';

                        var tot_bayar = 0;
                        for (var i = 0; i < dt.data.length; i++) {
                            let no = i + 1;
                            let tot = dt.data[i].tarif * dt.data[i].jml_timbang;
                            tot_bayar += tot;
                            row += '<tr>'+
                                        '<td align="center">'+no+'</td>'+
                                        '<td>'+dt.data[i].jenis_alat+'</td>'+
                                        '<td align="center">'+dt.data[i].kapasitas+'</td>'+
                                        '<td align="center">'+dt.data[i].jml_timbang+'</td>'+
                                        '<td align="right">'+formatRupiah(dt.data[i].tarif, 'Rp')+'</td>'+
                                        '<td align="right">'+formatRupiah(tot.toString(), 'Rp')+'</td>'+
                                    '</tr>';
                        }

                        $('#modal_detail_timbang #tbl_detail_timbang tbody').html(row);
                        $('#modal_detail_timbang #tbl_detail_timbang tfoot #total_bayar').html(formatRupiah(tot_bayar.toString(), 'Rp'));
                        
                        $('#modal_detail_timbang').modal('show');

                    } else {
                        alert('Detail timbangan kosong!');
                    }

                });
                
            }

            function detailAnakTimbang(id='') {

                $.post("<?= base_url().'Admin/getDetailAnakTimbangan' ?>", {id_list_sidang:id}, function(result){
                    $("#loading-show").fadeIn("slow").delay(20).slideUp('slow');

                    var dt = JSON.parse(result);

                    if (dt.response) {
                        var row = '';

                        var tot_bayar = 0;
                        for (var i = 0; i < dt.data.length; i++) {
                            let no = i + 1;
                            let tot = dt.data[i].tarif * dt.data[i].jml_anak_timbang;
                            tot_bayar += tot;
                            row += '<tr>'+
                                        '<td align="center">'+no+'</td>'+
                                        '<td>'+dt.data[i].parent+'</td>'+
                                        '<td>'+dt.data[i].child+'</td>'+
                                        '<td align="center">'+dt.data[i].jml_anak_timbang+'</td>'+
                                        '<td align="right">'+formatRupiah(dt.data[i].tarif, 'Rp')+'</td>'+
                                        '<td align="right">'+formatRupiah(tot.toString(), 'Rp')+'</td>'+
                                    '</tr>';
                        }

                        $('#modal_detail_anak_timbang #tbl_detail_anak_timbang tbody').html(row);
                        $('#modal_detail_anak_timbang #tbl_detail_anak_timbang tfoot #total_bayar').html(formatRupiah(tot_bayar.toString(), 'Rp'));
                            
                        $('#modal_detail_anak_timbang').modal('show');
                        
                    } else {
                        alert('Detail anak timbangan kosong!');
                    }

                });
                
            }


            function changeStatus() {

                var status = $('#select_status option:selected').attr('value');

                window.location.href = "<?=base_url().'Admin/dataSidangTera/' ?>"+status+"/<?= encode($id_sidang) ?>";

            }



            function inputInspeksi(id='', tgl='') {

                $('#modal-input-tgl #inputTglInspeksi #id_list_sidang').val(id);



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

                window.location.href = "<?=base_url().'Admin/inputHasilPengujian/dataSidangTera/' ?>"+id;

            }


        </script>

        <!-- ======================================================= -->



        <!-- UPDATE USER =========================================== -->

        <!-- <script type="text/javascript">



            function showModalEdit(data) {

                var id_user = $(data).attr('data-id');

                var nama_user = $(data).attr('data-nama');

                var jk_user = $(data).attr('data-jk');

                var username = $(data).attr('data-username');

                var no_hp = $(data).attr('data-noHp');

                var role = $(data).attr('data-role');



                $('#modal-edit #id_user').val(id_user);

                $('#modal-edit #nama_user').val(nama_user);

                $('#modal-edit #jk_user').val(jk_user).prop('selected',true);

                $('#modal-edit #username').val(username);

                $('#modal-edit #no_hp').val(no_hp);

                $('#modal-edit #role').val(role).prop('selected',true);

                $('#modal-edit').modal('show');

            }



        </script> -->

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

                        url  : "<?php echo base_url('Admin/deletePengajuanSidangTeraNew')?>",

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

                    window.location.href = "<?=base_url().'Admin/prosesPengajuan/' ?>"+id;

                });

            }

        </script>

            