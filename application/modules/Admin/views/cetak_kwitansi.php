<?php 

    $dataxx = array(

        'id_sidang' => $id_sidang,

        'link'      => $link

    );

    $this->load->view('headjs.php', $dataxx);

?>

<!-- <?php //require(base_url('assets/print/headjs.php')); ?> -->

	<style type="text/css">

		#body

		{

			page-break-after: always;

		}

	</style>

	<body>

		<div id="container" style="width: 5.3cm; margin-left: auto; margin-right: auto;">

			<!-- <img width="50px" src="<?= base_url('assets/assets/images/logo/logo_kab_mgl_sm.png') ?>"> -->

			<table style="margin-top: -10px; margin-bottom: 0px">

                <tr>

                    <td>

                        <img style="margin-top: 5px;" src="<?= base_url().'assets/assets/images/logo/logo_kab_mgl_xs.png' ?>" width="35">

                    </td>



                    <td style="width: 100%; text-align: center; color: black">

                        <div style="font-family: arial; font-size: 5pt;">PEMERINTAH KABUPATEN MAGELANG</div>

                        <h4 style="font-family: arial; color: black; font-size: 6pt; font-weight: bold; margin: 0px">

                            <!-- <span style=""> -->

	                            DINAS PERDAGANGAN, KOPERASI, <br>

	                            USAHA KECIL DAN MENENGAH <br>

	                            <!-- KABUPATEN MAGELANG <br> -->

	                        <!-- </span> -->

                        </h4>

                        <div style="font-size: 5pt; font-family: arial; line-height: 7px">

                            Jl. Soekarno - Hatta No 24 - 26 Telp. (0293) 788227 <br>

                            Kota Mungkid 56511

                        </div>

                    </td>

                </tr>

                <tr>

                	<td colspan="2" style="background-color: black; height: 1px"> </td>

                </tr>

                <tr>

                	<td colspan="2" align="center" style="padding-left: 10px; padding-right: 10px; font-family: aral; font-weight: bold; font-size: 6pt">

                		TANDA BUKTI PEMBAYARAN TERA/TERA ULANG UTTP

                	</td>

                </tr>

                <tr style="font-size: 5pt; font-family: arial">

                	<td valign="top">DASAR : </td>

                	<TD>

                		PERDA KABUPATEN MAGELANG NO 1 TAHUN 2018 TENTANG RETRIBUSI TERA/TERA ULANG

                	</TD>

                </tr>

                <tr>

                    <table style="font-family: arial; margin: 0px; margin-bottom: 5px;">

                        <tr style="font-weight: bold; font-size: 10pt">

                            <td width="50">No</td>

                            <td>:</td>

                            <td><?= $list['no_order'] ?></td>

                        </tr>

                        <tr style="font-size: 7pt">

                            <td width="50">Nama</td>

                            <td>:</td>

                            <td><?= ucwords($list['nama_pedagang']) ?></td>

                        </tr>

                        <tr style="font-size: 7pt">

                            <td>Tanggal</td>

                            <td>:</td>

                            <td><?= date('d/m/Y H:i:s') ?></td>

                        </tr>

                        <tr style="font-size: 7pt">

                            <td>Tempat</td>

                            <td>:</td>

                            <td><?= $nama_pasar ?></td>

                        </tr>

                    </table>

                </tr>

                <tr>

                    <table id="tbl_bayar" style="font-size: 7pt; font-family: arial">

                        <thead>

                            <tr>

                                <!-- <th>No</th> -->

                                <th align="left">Jenis Alat</th>

                                <!-- <th>Kapasitas</th> -->

                                <th>Qty</th>

                                <!-- <th>Tarif</th> -->

                                <th>Total</th>

                            </tr>

                        </thead>



                        <tbody>

                            <!-- <tr>

                                <td colspan="4" style="background-color: black; height: 0.5px; padding: 0px;"></td>

                            </tr>

                            <tr>

                                <td colspan="4" style="background-color: black; height: 1px; padding: 0px;"></td>

                            </tr> -->

                            <?php 

                                $no=0; $tot_bayar=0; 

                                foreach ($timbang as $tb) { 

                                    $no++;

                                    $tot_tb = $tb['tarif'] * $tb['jml_timbang'];

                                    $tot_bayar += $tot_tb;

                            ?>

                                <tr>

                                    <!-- <td align="center" valign="top"><?= $no ?></td> -->

                                    <td><?= $tb['jenis_alat'].' '.$tb['kapasitas'].' @'.nominal($tb['tarif']) ?></td>

                                    <!-- <td align="left"><?= $tb['kapasitas'] ?></td> -->

                                    <td align="right" valign="bottom"><?= $tb['jml_timbang'] ?></td>

                                    <!-- <td align="right"><?= nominal($tb['tarif']) ?></td> -->

                                    <td align="right" valign="bottom"><?= nominal($tot_tb) ?></td>

                                </tr>

                            <?php } ?>



                            <?php 

                                foreach ($anak_timbang as $at) { 

                                    $no++;

                                    $tot_at = $at['tarif'] * $at['jml_anak_timbang'];

                                    $tot_bayar += $tot_at;

                            ?>

                                <tr>

                                    <!-- <td align="center" valign="top"><?= $no ?></td> -->

                                    <td>Anak Timbangan - <?= $at['parent'].' '.$at['child'].' @'.nominal($at['tarif']) ?></td>

                                    <!-- <td><?= $at['child'] ?></td> -->

                                    <td align="right" valign="bottom"><?= $at['jml_anak_timbang'] ?></td>

                                    <!-- <td align="right"><?= nominal($at['tarif']) ?></td> -->

                                    <td align="right" valign="bottom"><?= nominal($tot_at) ?></td>

                                </tr>

                            <?php } ?>

                        </tbody>



                        <tfoot>

                            <tr style="font-weight: bold;">

                                <td colspan="2">Total Bayar (Rp)</td>

                                <td id="total_bayar" align="right"><?= nominal($tot_bayar) ?></td>

                            </tr>



                            <tr>

                                <td colspan="3" style="background-color: black; height: 0.5px; padding: 0px;"></td>

                            </tr>

                        </tfoot>



                    </table>

                </tr>

                <tr>

                    <?php 

                        $namaUser = $this->session->userdata('nama_user');

                    ?>

                    <table style="font-family: arial;">

                        <tr style="font-weight: bold; font-size: 7pt">

                            <td width="50">Petugas</td>

                            <td>:</td>

                            <td><?= $namaUser ?></td>

                        </tr>

                    </table>

                </tr>

            </table>



			<div id="aside"></div>

		</div>

	</body>

</html>

