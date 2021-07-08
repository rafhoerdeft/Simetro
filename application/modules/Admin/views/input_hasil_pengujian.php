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
                    <h3 class="text-themecolor">Input Hasil Pengujian UTTP (No. Order: <?= $dataPendaftaran->no_order ?>)</h3>
                </div>

                <div class="col-md-6 align-self-center">
                    <ol class="breadcrumb">
                        <!-- <label>Jenis Perlengkapan</label> -->
                        <li class="breadcrumb-item"><a href="<?= base_url().'Admin/pengujianTera/'.$source ?>" class="text-danger">Pengujian Tera</a></li>
                        <li class="breadcrumb-item active">Input Hasil Pengujian</li>
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

                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4 m-b-5">
                                        <a href="<?= base_url().'Admin/pengujianTera/'.$source ?>" class="btn btn-block btn-inverse waves-effect waves-light" ><i class="fa fa-arrow-left"></i> Kembali</a>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="button" class="btn btn-block btn-danger waves-effect waves-light" onclick="selesaiInputHasilUji(<?= $id_daftar ?>)"><i class="fa fa-check"></i> Selesai</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6"> </div>
                        </div>
                        
                        
                        <div id="tbl_list_tarif" class="table-responsive">
                            <hr>
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
                                            <tr style="height: 40px">
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
                                                    <?php if ($list->hasil_tera == 0) { ?>
                                                        <button style="width: 65px" data-id-list="<?= $list->id_list ?>" data-id-uttp="<?= $list->id_uttp ?>" onclick="inputHasil(this)" type="button" class="btn btn-sm btn-info waves-effect waves-light" title="Hapus"><i class="fa fa-pencil"></i> Input</button>
                                                    <?php } else { $jml_input++;?>
                                                        <button style="width: 65px" data-id-list="<?= $list->id_list ?>" data-id-uttp="<?= $list->id_uttp ?>" onclick="updateHasil(this)" type="button" class="btn btn-sm btn-primary waves-effect waves-light" title="Edit"><i class="fa fa-edit"></i> Edit</button>
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

            <!-- Modal Selesai -->
            <div id="modal-selesai" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <style type="text/css">
                        ul.ui-autocomplete {
                            z-index: 1100;
                        }
                    </style>

                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Input Hasil Pengujian</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <form id="simpanHasilUji" method="POST" action="<?= base_url().'Admin/simpanHasilUji/'.$source ?>">
                            <div class="modal-body">

                                <input type="hidden" name="id_list" id="id_list">
                                <input type="hidden" name="id_daftar" value="<?= $id_daftar ?>">

                                <div class="form-group">
                                    <label for="spek_alat" class="control-label">Spesifikasi Alat :</label>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-4">Nama Alat</div>
                                                <div class="col-md-1">:</div>
                                                <div class="col-md-6" id="alat"></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">Merk</div>
                                                <div class="col-md-1">:</div>
                                                <div class="col-md-6" id="merk"></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">Model/Tipe</div>
                                                <div class="col-md-1">:</div>
                                                <div class="col-md-6" id="model"></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">Nomor Seri</div>
                                                <div class="col-md-1">:</div>
                                                <div class="col-md-6" id="no_seri"></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">Buatan</div>
                                                <div class="col-md-1">:</div>
                                                <div class="col-md-6" id="buatan"></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">Kapasitas</div>
                                                <div class="col-md-1">:</div>
                                                <div class="col-md-6" id="kapasitas"></div>
                                            </div>
                                            <!-- <div class="row">
                                                <div class="col-md-4">Jumlah Tera Alat</div>
                                                <div class="col-md-2">:</div>
                                                <div class="col-md-6" id="jml_uttp"></div>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>

                                <div id="spek_alat" class="form-group">
                                    
                                </div>

                                <div class="form-group">
                                    <button onclick="addSpekAlat(this)" type="button" class="btn btn-block btn-primary waves-effect waves-light">Tambah Spesifikasi Alat</button>
                                </div>

                                <div class="form-group">
                                    <label for="nomor_tera" class="control-label">Nomor Tera :</label>
                                    <div class="controls">
                                        <input required type="text" class="form-control" name="nomor_tera" id="nomor_tera" placeholder="Ex: 510.63/302/IX/2019">
                                    </div>
                                </div>

                                <!-- <div class="form-group">
                                    <label for="users" class="control-label">Petugas Penera :</label>
                                    <input required type="text" name="users" id="users" onchange="changeDataUser(this)" class="form-control autocomplete" autocomplete="off" placeholder="Pilih petugas yang terdaftar">
                                    <div id="counter_found" style="font-size: 10pt; color: red"></div>
                                </div>
                                <input type="hidden" name="id_petugas" id="id_petugas"> -->

                                <div class="form-group">
                                    <label for="id_petugas" class="control-label">Petugas Penera :</label>
                                    <div class="controls">
                                        <select id="id_petugas" name="id_petugas" class="form-control" required>
                                            <option value="" disabled selected>Pilih Petugas Penera</option>
                                            <?php foreach ($dataPetugasTera as $pt) { ?>
                                                <option value="<?= $pt->id_petugas ?>"><?= $pt->nama_user ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="tgl_tera" class="control-label">Tanggal Tera:</label>
                                    <input type="text" class="form-control mydatepicker" id="tgl_tera" placeholder="tanggal-bulan-tahun" name="tgl_tera" required autocomplete="off">
                                </div>

                                <div class="form-group">
                                    <label for="metode" class="control-label">Metode :</label>
                                    <div class="controls">
                                        <input required type="text" class="form-control" name="metode" id="metode" placeholder="Isi metode pengujian" autocomplete="off" >
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="standar" class="control-label">Standar :</label>
                                    <div class="controls">
                                        <input required type="text" class="form-control" name="standar" id="standar" placeholder="Isi standar pengujian" autocomplete="off" >
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="hasil" class="control-label">Hasil :</label>
                                    <!-- <div class="controls">
                                        <input required type="text" class="form-control" name="hasil" id="hasil" placeholder="Isi hasil pengujian">
                                    </div> -->
                                    <div class="controls">
                                        <select id="hasil" name="hasil" class="form-control" required>
                                            <!-- <option value="" disabled selected>Pilih jenis kelamin</option> -->
                                            <option id="disahkan" value="disahkan">Disahkan</option>
                                            <option id="tidak_disahkan" value="tidak disahkan">Tidak Disahkan</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="tgl_tera_ulang" class="control-label">Berlaku Sampai:</label>
                                    <input type="text" class="form-control mydatepicker" id="tgl_tera_ulang" placeholder="tanggal-bulan-tahun" name="tgl_tera_ulang" required autocomplete="off">
                                </div>

                                <!-- <div class="form-group">
                                    <label for="alamat" class="control-label">Alamat :</label>
                                    <div class="controls">
                                        <textarea required class="form-control" id="alamat" name="alamat"></textarea>
                                    </div>
                                </div> -->

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Keluar</button>
                                <button type="submit" class="btn btn-info waves-effect waves-light" id="simpan_usaha"><i class="fa fa-save"></i> Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal Edit -->
            <div id="modal-edit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <style type="text/css">
                        ul.ui-autocomplete {
                            z-index: 1100;
                        }
                    </style>

                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Update Hasil Pengujian</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <form id="updateHasilUji" method="POST" action="<?= base_url().'Admin/updateHasilUji/'.$source ?>">
                            <div class="modal-body">

                                <input type="hidden" name="id_tera" id="id_tera">
                                <input type="hidden" name="id_list" id="id_list">
                                <input type="hidden" name="id_daftar" value="<?= $id_daftar ?>">

                                <div class="form-group">
                                    <label for="spek_alat" class="control-label">Spesifikasi Alat :</label>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-4">Nama Alat</div>
                                                <div class="col-md-1">:</div>
                                                <div class="col-md-6" id="alat"></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">Merk</div>
                                                <div class="col-md-1">:</div>
                                                <div class="col-md-6" id="merk"></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">Model/Tipe</div>
                                                <div class="col-md-1">:</div>
                                                <div class="col-md-6" id="model"></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">Nomor Seri</div>
                                                <div class="col-md-1">:</div>
                                                <div class="col-md-6" id="no_seri"></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">Buatan</div>
                                                <div class="col-md-1">:</div>
                                                <div class="col-md-6" id="buatan"></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">Kapasitas</div>
                                                <div class="col-md-1">:</div>
                                                <div class="col-md-6" id="kapasitas"></div>
                                            </div>
                                            <!-- <div class="row">
                                                <div class="col-md-4">Jumlah Tera Alat</div>
                                                <div class="col-md-2">:</div>
                                                <div class="col-md-6" id="jml_uttp"></div>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>

                                <div id="spek_alat" class="form-group">
                                    
                                </div>

                                <div class="form-group">
                                    <button onclick="addSpekAlat(this)" type="button" class="btn btn-block btn-primary waves-effect waves-light">Tambah Spesifikasi Alat</button>
                                </div>

                                <div class="form-group">
                                    <label for="nomor_tera" class="control-label">Nomor Tera :</label>
                                    <div class="controls">
                                        <input required type="text" class="form-control" name="nomor_tera" id="nomor_tera" placeholder="Ex: 510.63/302/IX/2019">
                                    </div>
                                </div>

                                <!-- <div class="form-group">
                                    <label for="users" class="control-label">Petugas Penera :</label>
                                    <input required type="text" name="users" id="users" onchange="changeDataUser(this)" class="form-control autocomplete" autocomplete="off" placeholder="Pilih petugas yang terdaftar">
                                    <div id="counter_found" style="font-size: 10pt; color: red"></div>
                                </div>
                                <input type="hidden" name="id_petugas" id="id_petugas"> -->

                                <div class="form-group">
                                    <label for="id_petugas" class="control-label">Petugas Penera :</label>
                                    <div class="controls">
                                        <select id="id_petugas" name="id_petugas" class="form-control" required>
                                            <option value="" disabled selected>Pilih Petugas Penera</option>
                                            <?php foreach ($dataPetugasTera as $pt) { ?>
                                                <option value="<?= $pt->id_petugas ?>"><?= $pt->nama_user ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="tgl_tera" class="control-label">Tanggal Tera:</label>
                                    <input type="text" class="form-control mydatepicker" id="tgl_tera" placeholder="tanggal-bulan-tahun" name="tgl_tera" required autocomplete="off">
                                </div>

                                <div class="form-group">
                                    <label for="metode" class="control-label">Metode :</label>
                                    <div class="controls">
                                        <input required type="text" class="form-control" name="metode" id="metode" placeholder="Isi metode pengujian" autocomplete="off" >
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="standar" class="control-label">Standar :</label>
                                    <div class="controls">
                                        <input required type="text" class="form-control" name="standar" id="standar" placeholder="Isi standar pengujian" autocomplete="off" >
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="hasil" class="control-label">Hasil :</label>
                                    <!-- <div class="controls">
                                        <input required type="text" class="form-control" name="hasil" id="hasil" placeholder="Isi hasil pengujian">
                                    </div> -->
                                    <div class="controls">
                                        <select id="hasil" name="hasil" class="form-control" required>
                                            <option id="disahkan" value="disahkan">Disahkan</option>
                                            <option id="tidak_disahkan" value="tidak disahkan">Tidak Disahkan</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="tgl_tera_ulang" class="control-label">Berlaku Sampai:</label>
                                    <input type="text" class="form-control mydatepicker" id="tgl_tera_ulang" placeholder="tanggal-bulan-tahun" name="tgl_tera_ulang" required autocomplete="off">
                                </div>

                                <!-- <div class="form-group">
                                    <label for="alamat" class="control-label">Alamat :</label>
                                    <div class="controls">
                                        <textarea required class="form-control" id="alamat" name="alamat"></textarea>
                                    </div>
                                </div> -->

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Keluar</button>
                                <button type="submit" class="btn btn-info waves-effect waves-light" id="simpan_usaha"><i class="fa fa-save"></i> Simpan</button>
                            </div>
                        </form>
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
            function inputHasil(data) {
                $('#modal-selesai #simpanHasilUji').trigger("reset");
                $('#modal-selesai #spek_alat').html('');
                $('#modal-selesai #counter_found').html('');

                var id_list = $(data).attr('data-id-list');
                var id_uttp = $(data).attr('data-id-uttp');

                $("#loading-show").fadeIn("slow");

                $.post("<?= base_url().'Admin/getDataAlat' ?>", {id_uttp:id_uttp}, function(result){
                    $("#loading-show").fadeIn("slow").delay(20).slideUp('slow');

                    var dt = JSON.parse(result);

                    if (dt.response) {
                        $('#modal-selesai #simpanHasilUji #id_list').val(id_list);
                        $('#modal-selesai #simpanHasilUji #alat').html(dt.data.jenis_alat);
                        $('#modal-selesai #simpanHasilUji #merk').html(dt.data.merk);
                        $('#modal-selesai #simpanHasilUji #model').html(dt.data.model_tipe);
                        $('#modal-selesai #simpanHasilUji #no_seri').html(dt.data.nomor_seri);
                        $('#modal-selesai #simpanHasilUji #buatan').html(dt.data.buatan);
                        $('#modal-selesai #simpanHasilUji #kapasitas').html(dt.data.kapasitas);

                        $('#modal-selesai #simpanHasilUji #tgl_tera').datepicker('setDate', "<?= date('d-m-Y') ?>"); 
                        $('#modal-selesai #simpanHasilUji #tgl_tera_ulang').datepicker('setDate', "<?= date('d-m-Y', strtotime('+1 years')) ?>"); 
                        $('#modal-selesai').modal('show');
                    }

                });

                
            }
        </script>

        <!-- UPDATE HASIL ============================================ -->
        <script type="text/javascript">
            function addZero(n){
              if(n <= 9){
                return "0" + n;
              }
              return n
            }

            function updateHasil(data) {
                $('#modal-edit #updateHasilUji').trigger("reset");
                $('#modal-edit #spek_alat').html('');
                $('#modal-edit #counter_found').html('');

                var id_list = $(data).attr('data-id-list');
                var id_uttp = $(data).attr('data-id-uttp');

                $("#loading-show").fadeIn("slow");

                $.post("<?= base_url().'Admin/getDataTeraAlat' ?>", {id_uttp:id_uttp, id_list: id_list}, function(result){
                    $("#loading-show").fadeIn("slow").delay(20).slideUp('slow');

                    var dt = JSON.parse(result);
                    // console.log('Jml Opsi',dt.dataTera.opsi_alat);
                    // console.log('Opsi Alat ',JSON.parse(dt.dataTera.opsi_alat));

                    if (dt.response) {
                        

                        var tgl_tera = new Date(dt.dataTera.tgl_tera);
                        var tgl_tera_ulang = new Date(dt.dataTera.tgl_berlaku);

                        $('#modal-edit #updateHasilUji #id_tera').val(dt.dataTera.id_tera);
                        $('#modal-edit #updateHasilUji #id_list').val(id_list);
                        $('#modal-edit #updateHasilUji #alat').html(dt.data.jenis_alat);
                        $('#modal-edit #updateHasilUji #merk').html(dt.data.merk);
                        $('#modal-edit #updateHasilUji #model').html(dt.data.model_tipe);
                        $('#modal-edit #updateHasilUji #no_seri').html(dt.data.nomor_seri);
                        $('#modal-edit #updateHasilUji #buatan').html(dt.data.buatan);
                        $('#modal-edit #updateHasilUji #kapasitas').html(dt.data.kapasitas);

                        if (dt.dataTera.opsi_alat != null) {
                            var opsi_alat = JSON.parse(dt.dataTera.opsi_alat);
                            var opsi = '';
                            for (var i = 0; i < opsi_alat.length; i++) {
                                opsi += '<div class="row m-b-5">'+
                                            '<div class="col-md-12">'+
                                                '<input required type="text" name="atribut[]" value="'+opsi_alat[i].atribut+'" class="form-control" style="width: 45%" placeholder="Masukkan atribut">'+
                                                ' : '+
                                                '<input required type="text" name="value[]" value="'+opsi_alat[i].value+'" class="form-control" style="width: 45%" placeholder="Masukkan value">'+
                                                '<button type="button" class="btn btn-sm btn-danger" style="float: right; margin-top: 5px" onclick="hapusSpek(this)" title="Hapus"><i class="fa fa-close"></i></button>'+
                                            '</div>'+
                                        '</div>';
                            }
                            $('#modal-edit #updateHasilUji #spek_alat').html(opsi);
                        }
                        $('#modal-edit #updateHasilUji #nomor_tera').val(dt.dataTera.nomor_tera);
                        // $('#modal-edit #updateHasilUji #users').val(dt.dataTera.nama_user+' - '+dt.dataTera.nip);
                        $('#modal-edit #updateHasilUji #id_petugas').val(dt.dataTera.id_petugas).change();
                        $('#modal-edit #updateHasilUji #metode').val(dt.dataTera.metode);
                        $('#modal-edit #updateHasilUji #standar').val(dt.dataTera.standar);
                        $('#modal-edit #updateHasilUji #hasil').val(dt.dataTera.hasil_tera).change();



                        $('#modal-edit #updateHasilUji #tgl_tera').datepicker('setDate', addZero(tgl_tera.getDate())+'-'+addZero(tgl_tera.getMonth()+1)+'-'+tgl_tera.getFullYear()); 
                        $('#modal-edit #updateHasilUji #tgl_tera_ulang').datepicker('setDate', addZero(tgl_tera_ulang.getDate())+'-'+addZero(tgl_tera_ulang.getMonth()+1)+'-'+tgl_tera_ulang.getFullYear()); 
                        $('#modal-edit').modal('show');
                    }

                });

                
            }
        </script>

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

        <script type="text/javascript">
            function selesaiInputHasilUji(id_daftar) {
                var jml_list = $('#jml_current_list').val();
                var jml_input = $('#jml_input').val();

                if (jml_list != jml_input) {
                    alert('Data hasil pengujian belum diinput semua!');
                } else {
                    swal({
                        title: "Selesai Input Hasil Pengujian?",
                        text: "Anda yakin data yang diinputkan sudah benar?",
                        type: "info",
                        showCancelButton: true,
                        confirmButtonColor: "#38a80c",
                        confirmButtonText: "Ya, Selesai!",
                        closeOnConfirm: false
                    }, function () {
                        window.location.href = "<?=base_url().'Admin/selesaiInputHasilUji/'.$source.'/' ?>"+id_daftar;
                    });
                }
            }
        </script>
        <!-- ======================================================= -->
