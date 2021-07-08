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
                    <h3 class="text-themecolor">Register Sidang Tera</h3>
                </div>

                <div class="col-md-6 align-self-center">
                    <ol class="breadcrumb">
                        <!-- <label>Jenis Perlengkapan</label> -->
                        <li class="breadcrumb-item active">Register Sidang Tera</li>
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
                            <div class="col-md-3 m-b-5">
                                <select class="form-control" id="select_pasar">
                                    <?php foreach ($dataPasar as $psr) {?>
                                        <option value="<?=encode($psr->id_pasar);?>" <?= ($selectPasar==$psr->id_pasar?'selected':'') ?>><?=$psr->nama_pasar?></option>
                                    <?php } ?>
                                </select>
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

                    /*th {
                      border-collapse: collapse;
                      border: 1px black solid;
                    }
                    tr:nth-of-type(5) th:nth-of-type(1) {
                      visibility: hidden;
                    }*/

                    .rotate {
                         -moz-transform: rotate(-90.0deg);  /* FF3.5+ */
                           -o-transform: rotate(-90.0deg);  /* Opera 10.5 */
                      -webkit-transform: rotate(-90.0deg);  /* Saf3.1+, Chrome */
                                 filter:  progid:DXImageTransform.Microsoft.BasicImage(rotation=0.083);  /* IE6,IE7 */
                             -ms-filter: "progid:DXImageTransform.Microsoft.BasicImage(rotation=0.083)"; /* IE8 */
                    }
                </style>

                <div class="card">
                    <div class="card-body p-b-20">
                        <div class="table-responsive">
                            <table id="myTable" class="table-bordered table-striped table-hover" cellpadding="7px" width="100%">
                                <thead align="center" class="bg-megna text-white" style="font-size: 9pt">
                                    <tr>
                                        <th rowspan="2" width="15">#</th>
                                        <th rowspan="2"><b>Tanggal</b></th>
                                        <th rowspan="2"><b>Nama</b></th>
                                        <!-- <th rowspan="2" width="90"><b>Tanggal Tera</b></th> -->
                                        <th colspan="29"><b>Jumlah UTTP</b></th>
                                        <th rowspan="2" width="70"><b>Jumlah Uang</b></th>
                                    </tr>
                                    <tr>
                                        <th width="40"><b>A</b></th>
                                        <th width="40"><b>B</b></th>
                                        <th width="40"><b>C</b></th>
                                        <th width="40"><b>D</b></th>
                                        <th width="40"><b>E</b></th>
                                        <th width="40"><b>F</b></th>
                                        <th width="40"><b>G</b></th>
                                        <th width="40"><b>H</b></th>
                                        <th width="40"><b>I</b></th>
                                        <th width="40"><b>J</b></th>
                                        <th width="40"><b>K</b></th>
                                        <th width="40"><b>L</b></th>
                                        <th width="40"><b>M</b></th>
                                        <th width="40"><b>N</b></th>
                                        <th width="40"><b>O</b></th>
                                        <th width="40"><b>P</b></th>
                                        <th width="40"><b>Q</b></th>
                                        <th width="40"><b>R</b></th>
                                        <th width="40"><b>S</b></th>
                                        <th width="40"><b>T</b></th>
                                        <th width="40"><b>U</b></th>
                                        <th width="40"><b>V</b></th>
                                        <th width="40"><b>X</b></th>
                                        <th width="40"><b>Y</b></th>
                                        <th width="40"><b>Z</b></th>
                                        <th width="40"><b>AA</b></th>
                                        <th width="40"><b>AB</b></th>
                                        <th width="40"><b>AC</b></th>
                                        <th width="40"><b>AD</b></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php 
                                        $no = 0;
                                        foreach ($dataRegSidang as $lap) { 
                                            $no++;
                                            $uang = ($lap->up1 * $lap->tarif_up1) +
                                                    ($lap->up2 * $lap->tarif_up2) +
                                                    ($lap->tk1 * $lap->tarif_tk1) +
                                                    ($lap->tk2 * $lap->tarif_tk2) +
                                                    ($lap->at1 * $lap->tarif_at1) +
                                                    ($lap->at2 * $lap->tarif_at2) +
                                                    ($lap->at3 * $lap->tarif_at3) +
                                                    ($lap->at4 * $lap->tarif_at4) +
                                                    ($lap->at5 * $lap->tarif_at5) +
                                                    ($lap->nc * $lap->tarif_nc) +
                                                    ($lap->dc1 * $lap->tarif_dc1) +
                                                    ($lap->dc2 * $lap->tarif_dc2) +
                                                    ($lap->ss1 * $lap->tarif_ss1) +
                                                    ($lap->ss2 * $lap->tarif_ss2) +
                                                    ($lap->ss3 * $lap->tarif_ss3) +
                                                    ($lap->bi1 * $lap->tarif_bi1) +
                                                    ($lap->bi2 * $lap->tarif_bi2) +
                                                    ($lap->bi3 * $lap->tarif_bi3) +
                                                    ($lap->mb * $lap->tarif_mb) +
                                                    ($lap->pg1 * $lap->tarif_pg1) +
                                                    ($lap->pg2 * $lap->tarif_pg2) +
                                                    ($lap->cp1 * $lap->tarif_cp1) +
                                                    ($lap->cp2 * $lap->tarif_cp2) +
                                                    ($lap->el1 * $lap->tarif_el1) +
                                                    ($lap->el2 * $lap->tarif_el2) +
                                                    ($lap->el3 * $lap->tarif_el3) +
                                                    ($lap->el4 * $lap->tarif_el4) +
                                                    ($lap->el5 * $lap->tarif_el5) +
                                                    ($lap->el6 * $lap->tarif_el6);
                                    ?>
                                            <tr style="font-size: 10pt; text-align: center;">
                                                <td align="center" width="20"><?= $no ?></td>
                                                <td align="left"><?= date('d-m-Y', strtotime($lap->tgl_daftar)) ?></td>
                                                <td><?= $lap->nama_user ?></td>
                                                <td><?= $lap->up1 ?></td>
                                                <td><?= $lap->up2 ?></td>
                                                <td><?= $lap->tk1 ?></td>
                                                <td><?= $lap->tk2 ?></td>
                                                <td><?= $lap->at1 ?></td>
                                                <td><?= $lap->at2 ?></td>
                                                <td><?= $lap->at3 ?></td>
                                                <td><?= $lap->at4 ?></td>
                                                <td><?= $lap->at5 ?></td>
                                                <td><?= $lap->nc ?></td>
                                                <td><?= $lap->dc1 ?></td>
                                                <td><?= $lap->dc2 ?></td>
                                                <td><?= $lap->ss1 ?></td>
                                                <td><?= $lap->ss2 ?></td>
                                                <td><?= $lap->ss3 ?></td>
                                                <td><?= $lap->bi1 ?></td>
                                                <td><?= $lap->bi2 ?></td>
                                                <td><?= $lap->bi3 ?></td>
                                                <td><?= $lap->mb ?></td>
                                                <td><?= $lap->pg1 ?></td>
                                                <td><?= $lap->pg2 ?></td>
                                                <td><?= $lap->cp1 ?></td>
                                                <td><?= $lap->cp2 ?></td>
                                                <td><?= $lap->el1 ?></td>
                                                <td><?= $lap->el2 ?></td>
                                                <td><?= $lap->el3 ?></td>
                                                <td><?= $lap->el4 ?></td>
                                                <td><?= $lap->el5 ?></td>
                                                <td><?= $lap->el6 ?></td>
                                                <td><?= nominal($uang) ?></td>
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
                var pasar = $('#paramLap #select_pasar').val();
                // var pasar = $('#paramLap #select_pasar').val();

                window.location.href = "<?=base_url().'Admin/lapRegisterSidang/' ?>"+awal+'/'+akhir+'/'+pasar;
            }

            function cetakLaporan(argument) {
                var awal = $('#paramLap #awal').val();
                var akhir = $('#paramLap #akhir').val();
                var pasar = $('#paramLap #select_pasar').val();

                window.location.href = "<?=base_url().'Admin/cetakLapRegSidang/' ?>"+awal+'/'+akhir+'/'+pasar;
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
            