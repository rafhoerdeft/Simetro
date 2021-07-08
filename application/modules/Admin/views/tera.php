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

                    <h3 class="text-themecolor">Daftar Pengajuan Tera</h3>

                </div>



                <div class="col-md-6 align-self-center">

                    <ol class="breadcrumb">

                        <!-- <label>Jenis Perlengkapan</label> -->

                        <li class="breadcrumb-item active">Data Tera</li>

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

                                    <!-- <option value="pending" <?//= ($selectStatus == 'pending'?'selected':'') ?>>Pending</option> -->

                                    <option value="diterima" <?= ($selectStatus == 'diterima'?'selected':'') ?>>Diterima</option>

                                    <option value="proses" <?= ($selectStatus == 'proses'?'selected':'') ?>>Proses</option>

                                    <option value="selesai" <?= ($selectStatus == 'selesai'?'selected':'') ?>>Selesai</option>

                                    <!-- <option value="ditolak" <?= ($selectStatus == 'ditolak'?'selected':'') ?>>Ditolak</option> -->

                                </select>

                            </div>

                        </div>

                    </div>

                </div>





                <div class="card">

                    <div class="card-body p-b-20">

                        <!-- <a href="<?//= base_url().'Admin/pendaftaranTera' ?>" class="btn waves-effect waves-light btn-inverse float-right"><i class="mdi mdi-file-document"></i> Pengajuan Tera</a>

                        <br><br>

                        <hr> -->

                        <div class="table-responsive">

                            <table id="myTable" class="table table-bordered table-striped table-hover">

                                <thead>

                                    <tr style="font-size: 10pt">

                                        <th>#</th>

                                        <th><b>No. Order</b></th>

                                        <th><b>Pemilik</b></th>

                                        <th><b>Usaha</b></th>

                                        <th><b>Layanan</b></th>

                                        <th><b>Tempat Tera</b></th>

                                        <th><b>Tgl Daftar</b></th>

                                        <?php if ($selectStatus != 'diterima') { ?>

                                            <th><b>Tgl Inspeksi</b></th>

                                        <?php } ?>

                                        <th><b>Status</b></th>

                                        <th><b>Formulir</b></th>

                                        <!-- <?php //if ($selectStatus == 'diterima' || $selectStatus == 'proses') { ?> -->

                                            <th><b>Aksi</b></th>

                                        <!-- <?php //} ?> -->

                                    </tr>

                                </thead>

                                <tbody>

                                    <?php 

                                        $no = 0;

                                        foreach ($dataTera as $tera) { 

                                            $no++;

                                    ?>

                                            <tr style="font-size: 10pt">

                                                <td align="center" width="20"><?= $no ?></td>

                                                <td><?= $tera->no_order ?></td>

                                                <td><?= $tera->nama_user ?></td>

                                                <td><?= $tera->jenis_usaha ?></td>

                                                <td width="70"><?= $tera->layanan ?></td>

                                                <td><?= $tera->tempat_tera ?></td>

                                                <td class="text-center" width="95"><?= date('d-m-Y', strtotime($tera->tgl_daftar)) ?></td>

                                                <?php if ($selectStatus != 'diterima') { ?>

                                                    <td class="text-center" width="95"><?= ($tera->tgl_inspeksi == null?'-':date('d-m-Y', strtotime($tera->tgl_inspeksi))) ?></td>

                                                <?php } ?>

                                                <td width="100" align="center">

                                                        <span style="font-size: 7.2pt; width: 75px; text-align: center;" class="label label-<?= ($tera->status=='belum kirim'?'warning':($tera->status=='diterima'?'info':($tera->status=='proses'?'primary':($tera->status=='selesai'?'success':($tera->status=='pending'?'inverse':'danger'))))) ?>"><b><?= $tera->status ?></b></span>

                                                        <button style="width: 75px;" type="button" onclick="showDetail(<?= $tera->id_daftar ?>)" class="btn btn-sm btn-outline-info waves-effect waves-light m-t-5"  title="Lihat Keterangan"><i class="fa fa-eye"></i> Detail</button>

                                                </td>

                                                <td width="50">

                                                    <button onclick="cetakForm(<?= $tera->id_daftar ?>)" type="button" class="btn btn-sm btn-primary waves-effect waves-light">

                                                        <i class="fa fa-print"></i> Cetak

                                                    </button>

                                                </td>

                                                <td nowrap>

                                                    <?php if ($tera->status == 'proses') { ?>

                                                        <!-- <td> -->

                                                            <button type="button" class="btn btn-sm btn-inverse waves-effect waves-light m-b-5"  onclick="cetakSpt(<?= $tera->id_daftar ?>)"  title="Cetak SPT"><i class="fa fa-print"></i> SPT</button>

                                                        <!-- </td> -->

                                                    <?php } ?>

                                                    <?php if ($selectStatus == 'diterima') { ?>

                                                        <!-- <td>

                                                            <div style="width: 115px"> -->

                                                                <button <?= ($tera->status != 'diterima'?'disabled':'') ?> type="button" class="btn btn-sm <?= ($tera->status == 'diterima'?'btn-warning waves-effect waves-light':'btn-default') ?> m-b-5" style="width: 35px" onclick="inputInspeksi(<?= $tera->id_daftar ?>, '<?= $tera->tgl_inspeksi?>')" title="Proses Pengajuan"><i class="fa fa-gears"></i></button>



                                                                <?php if ($tera->status == 'diterima') { ?>

                                                                    <a href="<?= base_url().'Admin/editPendaftaranTera/'.encode($tera->id_daftar) ?>" data-id="<?= $tera->id_daftar ?>" class="btn btn-sm btn-info waves-effect waves-light m-b-5" style="width: 35px" title="Edit Data"><i class="fa fa-pencil-square-o"></i></a>

                                                                <?php } else { ?>

                                                                    <button disabled data-id="<?= $tera->id_daftar ?>" class="btn btn-sm btn-default m-b-5" style="width: 35px" title="Edit Data"><i class="fa fa-pencil-square-o"></i></button>

                                                                <?php } ?>


                                                                <!-- <button <?= ($tera->status != 'proses'?'disabled':'') ?> type="button" data-id="<?= encode($tera->id_daftar) ?>" onclick="selesaiPengajuan(this)" class="btn btn-sm <?= ($tera->status == 'proses'?'btn-success waves-effect waves-light':'btn-default') ?> m-b-5" style="width: 35px" title="Selesai"><i class="fa fa-check"></i></button> -->

                                                            <!-- </div>

                                                        </td> -->

                                                    <?php } ?>

                                                    <button type="button" onclick="showConfirmMessage('<?= $tera->id_daftar ?>')" class="btn btn-sm btn-danger waves-effect waves-light m-b-5" style="width: 35px" title="Hapus Data"><i class="fa fa-trash-o"></i></button>
                                                </td>

                                            </tr>

                                    <?php } ?>

                                </tbody>

                            </table>

                        </div>



                    </div>

                </div>



            </div>



            <!-- Modal Kirim -->

            <div id="modal-kirim" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

                <div class="modal-dialog">

                    <div class="modal-content">

                        <div class="modal-header">

                            <h4 class="modal-title">Kirim Pengajuan Tera</h4>

                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                        </div>

                        <form id="kirimPengajuan" method="POST" action="<?= base_url().'Admin/kirimPengajuan' ?>" enctype="multipart/form-data">

                            <div class="modal-body">



                                <input type="hidden" name="id_daftar" id="id_daftar">



                                <div class="form-group">

                                    <label for="file_surat" class="control-label">File Surat Pengajuan :</label>

                                    <!-- <a href="javascript:void(0)" onclick="removeUpload(this)" style="float: right;"><span class="badge badge-danger">X</span></a> -->

                                    <div class="controls">

                                        <input type="file" data-validation-required-message="Upload file surat pengajuan" required name="file_surat" id="file_surat" class="dropify" data-height="100" data-max-file-size="2000K" accept="*" />

                                    </div>

                                </div>



                                <div class="form-group">

                                    <label for="file_lampiran" class="control-label">File Lampiran :<br><i>(Cetak formulir pengajuan. Beri tanda tangan dan cap perusahaan kemudian <b>scan</b> untuk diupload)</i></label>

                                    <!-- <a href="javascript:void(0)" onclick="removeUpload(this)" style="float: right;"><span class="badge badge-danger">X</span></a> -->

                                    <div class="controls">

                                        <input type="file" data-validation-required-message="Upload file lampiran" required name="file_lampiran" id="file_lampiran" class="dropify" data-height="100" data-max-file-size="2000K" accept="*" />

                                    </div>

                                </div>



                                <!-- <div class="form-group">

                                    <label for="nama_user" class="control-label">Nama User :</label>

                                    <div class="controls">

                                        <input required data-validation-required-message="Nama user harus diisi" type="text" class="form-control" name="nama_user" id="nama_user" placeholder="Isi nama user">

                                    </div>

                                </div>



                                <div class="form-group">

                                    <label for="jk_user" class="control-label">Jenis Kelamin :</label>

                                    <div class="controls">

                                        <select id="jk_user" name="jk_user" class="form-control">

                                            <option id="Laki-Laki" value="Laki-Laki">Laki-Laki</option>

                                            <option id="Perempuan" value="Perempuan">Perempuan</option>

                                        </select>

                                    </div>

                                </div>



                                <div class="form-group">

                                    <label for="no_hp" class="control-label">Nomor HP :</label><br>

                                    <div class="controls">

                                        <input required data-validation-required-message="Nomor HP harus diisi" type="text"  onkeypress="return inputAngka(event);" class="form-control" name="no_hp" id="no_hp">

                                    </div>

                                </div> -->

                                

                            </div>

                            <div class="modal-footer">

                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>

                                <button type="submit" class="btn btn-info waves-effect waves-light" id="simpan_jalan">Kirim</button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>





            <div id="cetak_formulir" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

                <div class="modal-dialog modal-lg">

                    <div class="modal-content" style="margin: 0 -15%; width: 130%;">

                        <div class="modal-header">

                            <h4 class="modal-title">Cetak Formulir Pengajuan Tera</h4>

                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                        </div>

                        <div class="modal-body" id="form-print">

                            <img src="<?= base_url().'assets/assets/images/logo/logo-metro-bw.png' ?>" style="position: absolute;opacity: 0.8; left: 25%; top: 30%;">

                            <table border="1" width="90%" style="font-size: 16pt; color: black; font-family: times new romans; margin: auto; z-index: 2" cellpadding="10">

                                <tr>

                                    <td rowspan="2" width="67%">

                                        <table style="margin-top: -10px;">

                                            <tr>

                                                <td>

                                                    <img src="<?= base_url().'assets/assets/images/logo/logo_kab_mgl_xs.png' ?>" width="100">

                                                </td>

                                                <td class="text-center" style="width: 100%">

                                                    <h4 style="font-family: times new romans; font-weight: bold; color: black">

                                                        <span style="font-family: arial; font-size: 16pt; font-weight: bold">BIDANG METROLOGI</span><br>

                                                        DINAS PERDAGANGAN, KOPERASI, USAHA KECIL <br>

                                                        DAN MENENGAH <br>

                                                        KABUPATEN MAGELANG <br>

                                                        Jalan Soekarno - Hatta No 24 - 26 Telp. (0293) 788227 <br>

                                                        KOTA MUNGKID 56511

                                                    </h4>

                                                </td>

                                            </tr>

                                        </table>

                                    </td> 

                                    <td>

                                        <div class="row">

                                            <div class="col-md-4">Kode</div>

                                            <div class="col-md-2 text-center">:</div>

                                            <div class="col-md-6" id="kode">F.14.A</div>

                                        </div>

                                    </td>

                                </tr>

                                <tr>

                                   <td>

                                        <div class="row">

                                            <div class="col-md-4">Revisi/Edisi</div>

                                            <div class="col-md-2 text-center">:</div>

                                            <div class="col-md-6" id="rev_ed">00/01</div>

                                        </div>

                                   </td>

                                </tr>

                                <tr>

                                   <td rowspan="2">

                                       <label style="font-size: 18pt">FORMULIR</label> <br>

                                       Judul Bagian : 

                                       <label style="font-weight: bold; font-size: 16pt">PERMINTAAN <span id="title">TERA/TERA ULANG</span> UTTP</label>

                                   </td>

                                   <td>

                                        <div class="row">

                                            <div class="col-md-4">Tanggal</div>

                                            <div class="col-md-2 text-center">:</div>

                                            <div class="col-md-6" id="tanggal">30-09-2019</div>

                                        </div>

                                   </td>

                                </tr>

                                <tr>

                                   <td>

                                        <div class="row">

                                            <div class="col-md-4">Bagian</div>

                                            <div class="col-md-2 text-center">:</div>

                                            <div class="col-md-6" id="bagian">14</div>

                                        </div>

                                   </td>

                                </tr>

                                <tr>

                                   <td colspan="2">

                                       <p align="center">PERMINTAAN <span id="judul">TERA/TERA ULANG</span> UTTP</p> <br>

                                       <p align="justify">

                                           Saya yang bertanda tangan di bawah ini mengajukan permohonan tera/tera ulang terhadap UTTP yang saya miliki dengan keterangan sebagai berikut:

                                       </p>



                                       <p>

                                            <table>

                                                <tr>

                                                    <td width="150">Nama/Perusahaan</td>

                                                    <td>:</td>

                                                    <td id="nama_user">Sudiarto</td>

                                                </tr>

                                                <tr>

                                                    <td width="150">Alamat</td>

                                                    <td>:</td>

                                                    <td id="almt_user">Magelang</td>

                                                </tr>

                                                <tr>

                                                    <td width="150">No. Telp/HP</td>

                                                    <td>:</td>

                                                    <td id="telp_user">085743469xxx</td>

                                                </tr>

                                                <tr>

                                                    <td width="150">Jenis Pesanan</td>

                                                    <td>:</td>

                                                    <td id="jenis_pesanan">EMBUHHH</td>

                                                </tr>

                                            </table>

                                       </p>



                                       <table border="1" width="100%" cellpadding="5">

                                           <thead>

                                               <tr align="center" style="height: 50px">

                                                   <td width="7%">No</td>

                                                   <td width="35%">Nama Alat</td>

                                                   <td width="30%">Jenis</td>

                                                   <td width="15%">Kapasitas Max/e</td>

                                                   <td width="8%">Jumlah</td>

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



                                       <br>

                                       Demikian saya ajukan



                                       <div class="row">

                                           <div class="col-md-6"></div>

                                           <div class="col-md-6 text-center">

                                               Kota Mungkid, <span id="tgl_ttd">................</span> <br>

                                               Yang mengajukan <br> <br> <br> <br>

                                               .............................

                                           </div>

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



            <div id="modal-input-tgl" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

                <div class="modal-dialog">

                    <div class="modal-content">

                        <div class="modal-header">

                            <h4 class="modal-title">Input Tanggal Inspeksi</h4>

                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                        </div>

                        <form id="inputTglInspeksi" method="POST" action="<?= base_url().'Admin/inputTglInspeksiTera' ?>" enctype="multipart/form-data">

                            <div class="modal-body">



                                <input type="hidden" name="id_daftar" id="id_daftar">



                                <div class="form-group">

                                    <label for="tgl_inspeksi" class="control-label">Tanggal Inspeksi :</label>

                                    <input type="text" class="form-control mydatepicker" id="tgl_inspeksi" placeholder="tanggal-bulan-tahun" name="tgl_inspeksi" required autocomplete="off">

                                </div>



                                <hr>



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

                                                        <input type="checkbox"  name="id_petugas[]" id="ck_<?= $key->id_petugas ?>" value="<?= $key->id_petugas ?>" class="filled-in chk-col-teal" /><label for="ck_<?= $key->id_petugas ?>"></label>

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



                $.post("<?= base_url().'Admin/getDataForm' ?>", {id_daftar:id}, function(result){

                    $("#loading-show").fadeIn("slow").delay(20).slideUp('slow');



                    var dt = JSON.parse(result);

                    console.log(dt);



                    var tgl_daftar = new Date(dt.dataForm.tgl_daftar);



                    $('#form-print #tanggal').html(addZero(tgl_daftar.getDate())+'-'+addZero(tgl_daftar.getMonth()+1)+'-'+tgl_daftar.getFullYear());

                    $('#form-print #kode').html(dt.dataForm.no_order);

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

                    // window.location.href = "<?//=base_url().'Admin/dataTera' ?>";

            }

        </script>



        <script type="text/javascript">



            function changeStatus() {

                var status = $('#select_status option:selected').attr('value');



                window.location.href = "<?=base_url().'Admin/dataTera/' ?>"+status;

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



                window.location.href = "<?=base_url().'Admin/inputHasilPengujian/dataTera/' ?>"+id;

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

            