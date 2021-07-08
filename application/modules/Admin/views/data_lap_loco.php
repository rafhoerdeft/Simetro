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
                    <h3 class="text-themecolor">Data Tera Ulang Loco</h3>
                </div>

                <div class="col-md-6 align-self-center">
                    <ol class="breadcrumb">
                        <!-- <label>Jenis Perlengkapan</label> -->
                        <li class="breadcrumb-item active">Data Tera Ulang Loco</li>
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
                            <div class="col-md-6 m-b-5">
                                <div class="input-daterange input-group" id="date-range">
                                    <input type="text" class="form-control" id="awal" name="awal" placeholder="Dari Tanggal" value="<?= date('d-m-Y', strtotime($selectTglAwal)) ?>"/>
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-info b-0 text-white">sampai</span>
                                    </div>
                                    <input type="text" class="form-control" id="akhir" name="akhir" placeholder="Sampai Tanggal" value="<?= date('d-m-Y', strtotime($selectTglAkhir)) ?>"/>
                                </div>
                            </div>
                            <!-- <div class="col-md-3 m-b-5">
                                <div class="form-group">
                                    <label for="tgl_akhir" class="control-label">Sampai Tanggal :</label>
                                    <input type="text" class="form-control mydatepicker" id="tgl_akhir" value="<?//= date('d-m-Y', strtotime($selectTglAkhir)) ?>" placeholder="tanggal-bulan-tahun" name="tgl_akhir" required autocomplete="off">
                                </div>
                            </div> -->

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
                                <thead align="center" class="bg-megna text-white" style="font-size: 8pt">
                                    <tr>
                                        <th rowspan="2" width="15">#</th>
                                        <th rowspan="2"><b>Nama WTU</b></th>
                                        <th rowspan="2" width="100"><b>Tanggal Tera</b></th>
                                        <th colspan="19"><b>Jumlah UTTP</b></th>
                                    </tr>
                                    <tr>
                                        <th width="40"><b>PU BBM</b></th>
                                        <th width="40"><b>BEJANA UKUR</b></th>
                                        <th width="40"><b>TUTSIDA</b></th>
                                        <th width="40"><b>ATB</b></th>
                                        <th width="40"><b>TM</b></th>
                                        <th width="40"><b>TS</b></th>
                                        <th width="40"><b>TE</b></th>
                                        <th width="40"><b>TE > 500kg</b></th>
                                        <th width="40"><b>TE KELAS I</b></th>
                                        <th width="40"><b>JEMBATAN S.D 50 TON</b></th>
                                        <th width="40"><b>TONGKAT DUGA</b></th>
                                        <th width="40"><b>FILLING MACHINE</b></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php 
                                        $no = 0;
                                        foreach ($dataLapLoco as $lap) { 
                                            $no++;
                                            if ($lap['nama_usaha'] != null || $lap['nama_usaha'] != '') {
                                                $usr = $lap['nama_user'].'/'.$lap['nama_usaha'];
                                            } else {
                                                $usr = $lap['nama_user'];
                                            }
                                             
                                    ?>
                                            <tr style="font-size: 10pt; text-align: center;">
                                                <td align="center" width="20"><?= $no ?></td>
                                                <td align="left"><?= $usr ?></td>
                                                <td><?= $lap['tgl_daftar'] ?></td>
                                                <td><?= $lap['BBM'] ?></td>
                                                <td><?= $lap['BU'] ?></td>
                                                <td><?= $lap['Tutsida'] ?></td>
                                                <td><?= $lap['ATB'] ?></td>
                                                <td><?= $lap['TM'] ?></td>
                                                <td><?= $lap['TS'] ?></td>
                                                <td><?= $lap['TE1'] ?></td>
                                                <td><?= $lap['TE2'] ?></td>
                                                <td><?= $lap['TE3'] ?></td>
                                                <td><?= $lap['Jb'] ?></td>
                                                <td><?= $lap['TD'] ?></td>
                                                <td><?= $lap['FM'] ?></td>
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
                var awal = $('#paramLap #awal').val();
                var akhir = $('#paramLap #akhir').val();
                // var pasar = $('#paramLap #select_pasar').val();

                window.location.href = "<?=base_url().'Admin/lapTeraUlangLoco/' ?>"+awal+'/'+akhir;
            }

            function cetakLaporan(argument) {
                var awal = $('#paramLap #awal').val();
                var akhir = $('#paramLap #akhir').val();

                window.location.href = "<?=base_url().'Admin/cetakLapLoco/' ?>"+awal+'/'+akhir;
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
            