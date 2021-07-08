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

                    <h3 class="text-themecolor">Pengajuan Masuk</h3>

                </div>



                <div class="col-md-6 align-self-center">

                    <ol class="breadcrumb">

                        <!-- <label>Jenis Perlengkapan</label> -->

                        <li class="breadcrumb-item active">Pengajuan Masuk</li>

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

                            <div class="col-md-4 m-b-5">

                                <!-- <label>Status pengajuan: </label> -->

                                <select class="form-control" id="select_status" onchange="changeStatus()">

                                    <option value="" disabled>Pilih status pengajuan masuk</option>

                                    <option value="pending" <?= ($selectStatus == 'pending'?'selected':'') ?>>Pending</option>

                                    <option value="diterima" <?= ($selectStatus == 'diterima'?'selected':'') ?>>Diterima</option>

                                    <option value="proses" <?= ($selectStatus == 'proses'?'selected':'') ?>>Proses</option>

                                    <option value="selesai" <?= ($selectStatus == 'selesai'?'selected':'') ?>>Selesai</option>

                                    <option value="ditolak" <?= ($selectStatus == 'ditolak'?'selected':'') ?>>Ditolak</option>

                                </select>

                            </div>

                            <div class="col-md-8">

                                <div class="row">

                                    <div class="col-md-8"></div>

                                    <div class="col-md-4">

                                        <?php if ($idDaftar != 0) { ?>

                                            <a href="<?= base_url().'Admin/pengajuanMasuk' ?>" class="btn btn-block waves-effect waves-light btn-inverse float-right"><i class="fa fa-eye"></i> Tampilkan Semua</a>

                                        <?php } ?>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>





                <div class="card">

                    <div class="card-body p-b-20">

                        <!-- <a href="<?//= base_url().'Admin/pendaftaranTera' ?>" class="btn waves-effect waves-light btn-primary float-right"><i class="mdi mdi-file-document"></i> Pengajuan Tera</a> -->



                        <div class="table-responsive">

                            <table id="myTable" class="table table-bordered table-striped table-hover" style="width: 100%">

                                <thead>

                                    <tr style="font-size: 9pt">

                                        <th>#</th>

                                        <th><b>No. Order</b></th>

                                        <th><b>Pemilik</b></th>

                                        <th><b>Usaha</b></th>

                                        <th><b>Layanan</b></th>

                                        <th><b>Tempat Tera</b></th>

                                        <th><b>Tgl Daftar</b></th>

                                        <th><b>Tgl Inspeksi</b></th>

                                        <th><b>Status</b></th>

                                        <th style="width: 50px"><b>Surat</b></th>

                                        <?php if ($selectStatus == 'pending' || $selectStatus == 'diterima' || $selectStatus == 'proses') { ?>

                                            <th><b>Aksi</b></th>

                                        <?php } ?>

                                        <!-- <th style="display: none">id</th> -->

                                    </tr>

                                </thead>

                                <tbody>

                                    <?php 

                                        $no = 0;

                                        foreach ($dataTera as $tera) { 

                                            $no++;

                                    ?>

                                            <tr style="font-size: 10pt;">

                                                <td align="center" width="20"><?= $no ?></td>

                                                <td><?= $tera->no_order ?></td>

                                                <td><?= $tera->nama_user ?></td>

                                                <td><?= $tera->jenis_usaha ?></td>

                                                <td width="70"><?= $tera->layanan ?></td>

                                                <td><?= $tera->tempat_tera ?></td>

                                                <td class="text-center" width="95"><?= date('d-m-Y', strtotime($tera->tgl_daftar)) ?></td>

                                                <td class="text-center" width="95"><?= ($tera->tgl_inspeksi == null?'-':date('d-m-Y', strtotime($tera->tgl_inspeksi))) ?></td>

                                                <td width="100" align="center">

                                                        <span style="font-size: 7.2pt; width: 75px; text-align: center;" class="label label-<?= ($tera->status=='belum kirim'?'warning':($tera->status=='diterima'?'info':($tera->status=='proses'?'primary':($tera->status=='selesai'?'success':($tera->status=='pending'?'inverse':'danger'))))) ?>"><b><?= $tera->status ?></b></span>



                                                        <?php if ($tera->status == 'ditolak') { ?>



                                                            <button style="width: 75px;" type="button" onclick="showKeterangan(<?= $tera->id_daftar ?>)" class="btn btn-sm btn-outline-danger waves-effect waves-light m-t-5"  title="Lihat Keterangan"><i class="fa fa-eye"></i> Detail</button>



                                                        <?php } else { ?>



                                                            <button style="width: 75px;" type="button" onclick="showDetail(<?= $tera->id_daftar ?>)" class="btn btn-sm btn-outline-info waves-effect waves-light m-t-5"  title="Lihat Keterangan"><i class="fa fa-eye"></i> Detail</button>



                                                        <?php } ?>

                                                </td>

                                                <td>

                                                    <?php $formatFile = explode('.', $tera->file_surat); ?>

                                                    <?php if ($formatFile[1] == 'jpg' || $formatFile[1] == 'jpeg' || $formatFile[1] == 'png') { ?>

                                                        <a href="<?= base_url().'Admin/cetakFileSurat/'.$tera->id_daftar ?>" class="btn btn-sm btn-primary waves-effect waves-light m-b-5"  title="Surat Permohonan">

                                                            <span class="btn-label"><i class="fa fa-envelope"></i></span>File 

                                                        </a>

                                                        

                                                    <?php } else { ?>

                                                        <a href="<?= base_url().'assets/path_file/'.$tera->file_surat ?>" class="btn btn-sm btn-primary waves-effect waves-light m-b-5"  title="Surat Permohonan">

                                                            <span class="btn-label"><i class="fa fa-envelope"></i></span>File 

                                                        </a>

                                                    <?php } ?>

                                                    <!-- <a target="_blank" href="<?//= base_url().'assets/path_file/'.$tera->file_lampiran ?>" class="btn btn-sm btn-danger waves-effect waves-light m-b-5"  title="Lampiran">

                                                        <span class="btn-label"><i class="fa fa-file"></i></span>File 2

                                                    </a> -->

                                                </td>

                                                <?php if ($selectStatus == 'pending' || $selectStatus == 'diterima' || $selectStatus == 'proses') { ?>

                                                    <td>

                                                        <div class="d-none d-sm-none d-md-block d-lg-block" style="width: 70px">

                                                            <?php if ($tera->status == 'pending') { ?>

                                                                <button <?= ($tera->status != 'pending'?'disabled':'') ?> type="button" class="btn btn-sm <?= ($tera->status == 'pending'?'btn-info waves-effect waves-light':'btn-default') ?> m-b-5" style="width: 32px" data-id="<?= encode($tera->id_daftar) ?>" onclick="terimaPengajuan(this)"  title="Terima Pengajuan"><i class="fa fa-check-square-o"></i></button>





                                                                <button <?= ($tera->status != 'pending'?'disabled':'') ?> type="button" class="btn btn-sm <?= ($tera->status == 'pending'?'btn-danger waves-effect waves-light':'btn-default') ?> m-b-5" style="width: 32px" onclick="tolakPengajuan(<?= $tera->id_daftar ?>)"  title="Tolak Pengajuan"><i class="fa fa-close"></i></button>



                                                            <?php } ?>



                                                            <?php if ($tera->status == 'proses') { ?>

                                                                <button type="button" class="btn btn-sm btn-inverse waves-effect waves-light m-b-5"  onclick="cetakSpt(<?= $tera->id_daftar ?>)"  title="Cetak SPT"><i class="fa fa-print"></i> SPT</button>

                                                            <?php } ?>



                                                            <?php if ($tera->status == 'diterima') { ?>

                                                                <button <?= ($tera->status != 'diterima'?'disabled':'') ?> type="button" class="btn btn-sm <?= ($tera->status == 'diterima'?'btn-warning waves-effect waves-light':'btn-default') ?> m-b-5" onclick="inputInspeksi(<?= $tera->id_daftar ?>, '<?= $tera->tgl_inspeksi?>')"  title="Proses Pengajuan"><i class="fa fa-gears"></i> Proses</button>

                                                            <?php } ?>



                                                            <!-- <button <?= ($tera->status != 'proses'?'disabled':'') ?> type="button" data-id="<?= encode($tera->id_daftar) ?>" onclick="selesaiPengajuan(this)" class="btn btn-sm <?= ($tera->status == 'proses'?'btn-success waves-effect waves-light':'btn-default') ?> m-b-5" style="width: 35px"  title="Selesai"><i class="fa fa-check"></i></button> -->

                                                        </div>



                                                        <div class="d-block d-sm-block d-md-none d-lg-none">

                                                            <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                                                <i class="fa fa-cog"></i>

                                                            </button>



                                                            <div class="dropdown-menu">

                                                                <?php if ($tera->status != 'pending') { ?>

                                                                    <a class="dropdown-item" href="javascript:void(0)" style="color: #e8e8e8"><i class="fa fa-check-square-o"></i> Terima Pengajuan</a>



                                                                    <a class="dropdown-item" <?= ($tera->status != 'pending'?'disabled':'') ?> href="javascript:void(0)" style="color: #e8e8e8"><i class="fa fa-close"></i> Tolak Pengajuan</a>

                                                                <?php } else { ?>

                                                                    <a class="dropdown-item" href="javascript:void(0)" data-id="<?= encode($tera->id_daftar) ?>" onclick="terimaPengajuan(this)"><i class="fa fa-check-square-o"></i> Terima Pengajuan</a>



                                                                    <a class="dropdown-item" <?= ($tera->status != 'pending'?'disabled':'') ?> href="javascript:void(0)" onclick="tolakPengajuan(<?= $tera->id_daftar ?>)" ><i class="fa fa-close"></i> Tolak Pengajuan</a>

                                                                <?php } ?>



                                                                <?php if ($tera->status == 'proses') { ?>

                                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="cetakSpt(<?= $tera->id_daftar ?>)"><i class="fa fa-print"></i> Cetak SPT</a>

                                                                <?php } ?>



                                                                <?php if ($tera->status != 'diterima') { ?>

                                                                    <a class="dropdown-item" href="javascript:void(0)" style="color: #e8e8e8" ><i class="fa fa-gears"></i> Proses Pengajuan</a>

                                                                <?php } else { ?>

                                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="inputInspeksi(<?= $tera->id_daftar ?>, '<?= $tera->tgl_inspeksi?>')" ><i class="fa fa-gears"></i> Proses Pengajuan</a>

                                                                <?php } ?>

                                                                <!-- <div class="dropdown-divider"></div>

                                                                <a class="dropdown-item" href="#">Separated link</a> -->

                                                            </div>

                                                        </div>

                                                    </td>

                                                <?php } ?>

                                                <!-- <td style="display: none"><?= $tera->id_daftar ?></td> -->

                                            </tr>

                                    <?php } ?>

                                </tbody>

                            </table>

                        </div>



                    </div>

                </div>



            </div>



            <!-- Modal Kirim -->

            <div id="modal-input-tgl" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

                <div class="modal-dialog">

                    <div class="modal-content">

                        <div class="modal-header">

                            <h4 class="modal-title">Input Tanggal Inspeksi</h4>

                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                        </div>

                        <!-- <form id="inputTglInspeksi" method="POST" action="<?//= base_url().'Admin/inputTglInspeksi' ?>"> -->
                        <form id="inputTglInspeksi" onsubmit="submitInputInspeksi()" action="javascript:void(0)">

                            <div class="modal-body">



                                <input type="hidden" name="id_daftar" id="id_daftar">



                                <div class="form-group">

                                    <label for="tgl_inspeksi" class="control-label">Tanggal Inspeksi :</label>

                                    <input type="text" class="form-control mydatepicker" id="tgl_inspeksi" placeholder="tanggal-bulan-tahun" name="tgl_inspeksi" required autocomplete="off">

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



                                        <tbody>

                                            <?php foreach ($dataPetugas as $key) { 

                                                    if ($key->jabatan != 'Kepala Dinas') { 

                                                ?>

                                                <tr>

                                                    <td>

                                                        <input type="checkbox" onclick="cekPetugas(<?= $key->id_petugas ?>)"  name="id_petugas[]" id="ck_<?= $key->id_petugas ?>" value="<?= $key->id_petugas ?>" class="filled-in chk-col-teal" /><label for="ck_<?= $key->id_petugas ?>"></label>

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

                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>

                                <button type="submit" class="btn btn-info waves-effect waves-light" id="simpan_jalan">Proses</button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>



            <!-- Modal Tolak -->

            <div id="modal-tolak" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

                <div class="modal-dialog">

                    <div class="modal-content">

                        <div class="modal-header">

                            <h4 class="modal-title">Tolak Pengajuan</h4>

                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                        </div>

                        <form id="tolakPengajuan" method="POST" action="<?= base_url().'Admin/tolakPengajuan' ?>" enctype="multipart/form-data">

                            <div class="modal-body">



                                <input type="hidden" name="id_daftar" id="id_daftar">



                                <div class="form-group">

                                    <label for="keterangan" class="control-label">Keterangan :</label>

                                    <textarea required class="form-control" name="keterangan" id="keterangan" autocomplete="off"></textarea>

                                </div>

                                

                            </div>

                            <div class="modal-footer">

                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>

                                <button type="submit" class="btn btn-danger waves-effect waves-light" id="simpan_jalan"><i class="fa fa-close"></i> Tolak</button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>



            <!-- Modal Tolak -->

            <div id="modal-tolak-show" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

                <div class="modal-dialog">

                    <div class="modal-content">

                        <div class="modal-header">

                            <h4 class="modal-title">Keterangan Pengajuan Ditolak</h4>

                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                        </div>

                        <!-- <form id="tolakPengajuan" method="POST" action="<?//= base_url().'Admin/tolakPengajuan' ?>" enctype="multipart/form-data"> -->

                            <div class="modal-body">



                                <!-- <input type="hidden" name="id_daftar" id="id_daftar"> -->



                                <div class="form-group">

                                    <label for="keterangan" class="control-label">Keterangan :</label>

                                    <textarea readonly class="form-control" name="keterangan" id="keterangan" autocomplete="off" rows="5"></textarea>

                                </div>

                                

                            </div>

                            <div class="modal-footer">

                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>

                                <!-- <button type="submit" class="btn btn-danger waves-effect waves-light" id="simpan_jalan"><i class="fa fa-close"></i> Tolak</button> -->

                            </div>

                        <!-- </form> -->

                    </div>

                </div>

            </div>



            <!-- Modal Detail -->

            <div id="modal-detail" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

                <div class="modal-dialog modal-lg">

                    <div class="modal-content">

                        <div class="modal-header">

                            <h4 class="modal-title">Detail Pengajuan Tera UTTP</h4>

                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                        </div>

                        <!-- <form id="tolakPengajuan" method="POST" action="<?//= base_url().'Admin/tolakPengajuan' ?>" enctype="multipart/form-data"> -->

                            <div class="modal-body">



                                <!-- <input type="hidden" name="id_daftar" id="id_daftar"> -->



                                <div class="form-group">

                                    <table id="tbl_detail" border="0" width="100%" cellpadding="5" style="font-size: 10pt">

                                        <thead>

                                            <tr style="height: 50px; font-weight: bold;">

                                                <td width="7%" align="center">No</td>

                                                <td width="35%">Nama Alat</td>

                                                <td width="30%">Jenis</td>

                                                <td width="15%" align="center">Kapasitas</td>

                                                <td width="8%" align="center">Jumlah</td>

                                            </tr>

                                        </thead>

                                        <tbody border="0" style="height: 500px" id="list_uttp">

                                            <?php for ($i=0; $i < 15; $i++) {  ?>

                                                <tr style="border-bottom: 0">

                                                   <td align="center"><?= $i+1 ?></td>

                                                   <td>asdfasf</td>

                                                   <td>asdf</td>

                                                   <td>asdf</td>

                                                   <td align="center">2</td>

                                                </tr>

                                            <?php } ?>

                                       </tbody>

                                    </table>

                                </div>

                                

                            </div>

                            <div class="modal-footer">

                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>

                            </div>

                        <!-- </form> -->

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

                            <!-- <img src="<?//= base_url().'assets/assets/images/logo/logo-metro-bw.png' ?>" style="position: absolute;opacity: 0.8; left: 25%; top: 30%;"> -->

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

                                                    Melakukan tera/tera ulang UTTP

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



        <script type="text/javascript">

            function cekPetugas(id) {

                var cek = $('#modal-input-tgl #tbl_petugas #ck_'+id);
                var jml_cek = parseInt($('#modal-input-tgl #jml_cek').val());

                if (cek.is(":checked")) {
                    jml_cek++;
                    $('#modal-input-tgl #jml_cek').val(jml_cek);
                    // cek.attr('checked', false);

                } else {
                    jml_cek--;
                    $('#modal-input-tgl #jml_cek').val(jml_cek);
                    // cek.attr('checked', true);

                }                

            }



            function cetakSpt(id) {



                $("#loading-show").fadeIn("slow");



                $.post("<?= base_url().'Admin/getDataSpt' ?>", {id_daftar:id}, function(result){

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

                        $('#cetak_spt #tbl_spt #hari').html(nameDays(dt.tera.tgl_inspeksi));

                        $('#cetak_spt #tbl_spt #tgl').html(formatTglSurat(dt.tera.tgl_inspeksi));

                        if (dt.tera.nama_usaha != null) {

                            var alamat = dt.tera.nama_usaha+' ('+dt.tera.nama_pemilik+'), '+dt.tera.alamat_usaha+', '+dt.tera.desa+' '+dt.tera.kecamatan;

                        } else {

                            var alamat = '('+dt.tera.nama_pemilik+') '+dt.tera.alamat_usaha+', '+dt.tera.desa+' '+dt.tera.kecamatan;

                        }

                        

                        $('#cetak_spt #tbl_spt #tempat').html(alamat);

                        $('#cetak_spt #tbl_spt #tgl_spt').html(formatTglSurat(dt.tera.tgl_update_status));



                        $('#cetak_spt').modal('show');

                    }



                });



            }

        </script>



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

            function tolakPengajuan(id) {

                $('#modal-tolak #tolakPengajuan').trigger("reset");

                $('#modal-tolak #tolakPengajuan #id_daftar').val(id);

                $('#modal-tolak').modal('show');

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



            function changeStatus() {

                var status = $('#select_status option:selected').attr('value');



                window.location.href = "<?=base_url().'Admin/pengajuanMasuk/' ?>"+status;

            }



            function inputInspeksi(id='', tgl='') {

                $('#modal-input-tgl #inputTglInspeksi').trigger('reset');

                $('#modal-input-tgl #jml_cek').val('0');

                $('#modal-input-tgl #inputTglInspeksi #id_daftar').val(id);



                if (tgl == '' || tgl == null) {

                    $('#modal-input-tgl #inputTglInspeksi #tgl_inspeksi').datepicker('setDate', "<?= date('d-m-Y') ?>"); 

                } else {

                    var tgl_inspeksi = new Date(tgl);



                    $('#modal-input-tgl #inputTglInspeksi #tgl_inspeksi').datepicker('setDate', addZero(tgl_inspeksi.getDate())+'-'+addZero(tgl_inspeksi.getMonth()+1)+'-'+tgl_inspeksi.getFullYear()); 

                }



                $('#modal-input-tgl').modal('show');

            }


            function submitInputInspeksi(argument) {
                var data_form = $('#modal-input-tgl #inputTglInspeksi').serializeArray();

                // console.log(data_form[2].value);

                if (data_form[2].value > 0) {

                    $.post("<?= base_url().'Admin/inputTglInspeksi' ?>", data_form, function(result){
                        var dt = JSON.parse(result);

                        location.reload();
                    });
                } else {
                    alert('Pilih pegawai yang akan ditugaskan!');
                }
            }


            function selesaiPengajuan(data) {

                var id = $(data).attr('data-id');

                

                window.location.href = "<?=base_url().'Admin/inputHasilPengujian/pengajuanMasuk/' ?>"+id;

            }



            function showKeterangan(id) {

                $("#loading-show").fadeIn("slow");



                $.post("<?= base_url().'Admin/showKetTolak' ?>", {id_daftar:id}, function(result){

                    $("#loading-show").fadeIn("slow").delay(20).slideUp('slow');



                    var dt = JSON.parse(result);

                    // console.log(dt.data);



                    if (dt.response) {

                        $('#modal-tolak-show #keterangan').val(dt.data.keterangan);



                        $('#modal-tolak-show').modal('show');

                    }



                });

            }



            function showDetail(id) {

                $("#loading-show").fadeIn("slow");



                $.post("<?= base_url().'Admin/getDetailPengajuan' ?>", {id_daftar:id}, function(result){

                    $("#loading-show").fadeIn("slow").delay(20).slideUp('slow');



                    var dt = JSON.parse(result);

                    // console.log(dt.listUttp);



                    if (dt.response) {

                        var list_uttp = '';

                        

                        for (var x = 0; x < dt.listUttp.length; x++) {

                            let no = x + 1;

                            list_uttp += '<tr style="border-bottom: 0">'+

                                           '<td align="center">'+no+'</td>';



                            list_uttp   +=  '<td>'+dt.listUttp[x].jenis_alat+'</td>'+

                                            '<td>'+dt.listUttp[x].kategori_alat+'</td>'+

                                            '<td align="center">'+dt.listUttp[x].kapasitas+'</td>'+

                                            '<td align="center">'+dt.listUttp[x].jumlah_uttp+'</td>';

                            list_uttp += '</tr>';

                        }



                        $('#modal-detail #list_uttp').html(list_uttp);



                        $('#modal-detail').modal('show');

                    }



                });

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



            function terimaPengajuan(data) {

                var id = $(data).attr('data-id');

                // swal({

                //     title: "Terima Pengajuan",

                //     text: "Terima pengajuan tera ini?",

                //     type: "info",

                //     showCancelButton: true,

                //     confirmButtonColor: "#38a80c",

                //     confirmButtonText: "Ya, Terima!",

                //     closeOnConfirm: false

                // }, function () {

                //     window.location.href = "<?//=base_url().'Admin/terimaPengajuanMasuk/' ?>"+id;

                // });

                window.location.href = "<?=base_url().'Admin/showTerimaPengajuan/' ?>"+id;

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

                    window.location.href = "<?=base_url().'Admin/prosesPengajuanMasuk/' ?>"+id;

                });

            }

        </script>

            