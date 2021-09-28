<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Petugas extends CI_Controller {

	function __construct(){
		parent:: __construct();
		$this->load->model('MasterData');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->helper('alert');
		$this->load->helper('encrypt');
		$this->load->helper('uang');
		$this->load->helper('terbilang');
		$this->sms = $this->load->database('sms', TRUE);

		if ($this->session->userdata('role') != '') {
			redirect('Auth');
		}

		date_default_timezone_set('Asia/Jakarta');

		$this->id_user = $this->session->userdata('id_user');

		$this->head = array(
			"assets/assets/plugins/bootstrap/css/bootstrap.min.css",
		    // "assets/assets/plugins/morrisjs/morris.css",
		    "assets/main/css/style.css",
		    "assets/main/css/colors/red.css",
		);


		$this->foot = array(
			"assets/assets/plugins/jquery/jquery.min.js",
		    "assets/assets/plugins/bootstrap/js/popper.min.js",
		    "assets/assets/plugins/bootstrap/js/bootstrap.min.js",
		    "assets/main/js/jquery.slimscroll.js",
		    "assets/main/js/waves.js",
		    "assets/main/js/sidebarmenu.js",
		    "assets/assets/plugins/sticky-kit-master/dist/sticky-kit.min.js",
		    "assets/main/js/custom.min.js",
		    "assets/main/js/validation.js",
		    // "assets/assets/plugins/sparkline/jquery.sparkline.min.js",
		    // "assets/assets/plugins/raphael/raphael-min.js",
		    // "assets/assets/plugins/morrisjs/morris.min.js",
		    "assets/assets/plugins/styleswitcher/jQuery.style.switcher.js"
		);

		$select = array(
			'dft.*',
			"(SELECT usr.nama_user FROM tbl_user usr WHERE usr.id_user = (SELECT ush.id_user FROM tbl_usaha ush WHERE ush.id_usaha = dft.id_usaha)) nama_user",
			"(SELECT jns.nama_jenis_usaha FROM tbl_jenis_usaha jns WHERE jns.id_jenis_usaha = (SELECT ush.id_jenis_usaha FROM tbl_usaha ush WHERE ush.id_usaha = dft.id_usaha)) nama_jenis_usaha"
		);
		$table = 'tbl_pendaftaran dft';
		$where = "user_daftar = 'user' AND status = 'pending' AND notif_petugas = 0";
		$limit = 5;
		$by = 'tgl_kirim';
		$order = 'DESC';
		$data['notif'] = $this->MasterData->getWhereDataLimitOrder($select,$table,$where,$limit,$by,$order)->result();

		$this->load->view('Petugas/head',$data, TRUE);
    }

	public function index($sess=''){

		$thn = $this->input->GET('tahun');
		if ($thn == '') {
			$thn = date('Y');
		}

		$where = "id_role = (SELECT role.id_role FROM tbl_role role WHERE role.nama_role = 'User')";
		$jmlUser = $this->MasterData->getDataWhere('tbl_user',$where)->num_rows();

		$where = "id_user IN (SELECT pt.id_user FROM tbl_petugas pt)";
		$jmlPetugas = $this->MasterData->getDataWhere('tbl_user',$where)->num_rows();

		// JUMLAH LAPORAN MASUK
		$select = 'id_daftar';
		$table = 'tbl_pendaftaran';

		$where = "date(tgl_daftar) = date(now()) AND status != 'belum kirim' AND user_daftar = 'user'";
		$lap_harian = $this->MasterData->getWhereData($select,$table,$where)->num_rows();

		$where = "YEARWEEK(tgl_daftar) = YEARWEEK(NOW()) AND status != 'belum kirim' AND user_daftar = 'user'";
		$lap_mingguan = $this->MasterData->getWhereData($select,$table,$where)->num_rows();

		$where = "MONTH(tgl_daftar) = MONTH(now()) AND YEAR(tgl_daftar) = YEAR(now()) AND status != 'belum kirim' AND user_daftar = 'user'";
		$lap_bulanan = $this->MasterData->getWhereData($select,$table,$where)->num_rows();

		$where = "YEAR(tgl_daftar) = YEAR(now()) AND status != 'belum kirim' AND user_daftar = 'user'";
		$lap_tahunan = $this->MasterData->getWhereData($select,$table,$where)->num_rows();

		$data = array(
			'jmlUser' => $jmlUser,
			'jmlPetugas' => $jmlPetugas,
			'lap_harian' => $lap_harian,
			'lap_mingguan' => $lap_mingguan,
			'lap_bulanan' => $lap_bulanan,
			'lap_tahunan' => $lap_tahunan,
			'tahun' => $thn
		);


		//DATA GRAFIK
		$select = array(
			'MONTH(tgl_daftar) AS bulan',
			'WEEK(tgl_daftar) AS minggu',
		    'COUNT(id_daftar) AS jml_lap'
		);
		$where = "YEAR(tgl_daftar) = '$thn' AND status != 'belum kirim' AND user_daftar = 'user'";
		$group = "MONTH(tgl_daftar), WEEK(tgl_daftar)";
		$by = "MONTH(tgl_daftar), WEEK(tgl_daftar)";
		$order = 'ASC';
		$data['lap_per_minggu'] = $this->MasterData->getWhereDataGroupOrder($select,$table,$where,$group,$by,$order)->result();

		$select = array(
			'MONTH(tgl_daftar) AS bulan',
		    'COUNT(id_daftar) AS jml_lap'
		);
		$group = "MONTH(tgl_daftar)";
		$by = "MONTH(tgl_daftar)";
		$order = 'ASC';
		$data_lap = $this->MasterData->getWhereDataGroupOrder($select,$table,$where,$group,$by,$order)->result();

		if ($data_lap == null || $data_lap == '') {
			$data['data_lap'] = "Kosong";
		}else{
			$data['data_lap'] = $data_lap;
		}

		// $data['tahun'] = $thn;

		$select = "YEAR(tgl_daftar) thn";
		$group = "YEAR(tgl_daftar)";
		$by = "YEAR(tgl_daftar)";
		$order = 'ASC';
		$data['data_thn'] = $this->MasterData->getDataGroupOrder($select,$table,$group,$by,$order)->result();

		// $this->foot[] = "assets/main/js/dashboard1.js";

		$head['head'] = $this->head;
		$foot['foot'] = $this->foot;
		$nav['menu'] = 'dashboard';

		$this->load->view('Petugas/head',$head);
		$this->load->view('Petugas/navigation',$nav);
		$this->load->view('Petugas/dashboard',$data);
		$this->load->view('foot',$foot);
	}

	// =====================================================

	public function laporan($bln='', $thn='', $psr='') {

		if ($thn != '') {
			$tahun = decode($thn);

			$where = "year(tgl_bayar) = $tahun";
		} else {
			$tahun = date('Y');

			$where = "year(tgl_bayar) = $tahun";
		}

		$bulan = date('m');
		if ($bln != '') {
			$bulan = decode($bln);

			$where .= " AND month(tgl_bayar) = $bulan";
		}

		$pasar = '';
		if ($psr != '') {
			$pasar = decode($psr);

			if ($pasar > 0) {
				$where .= " AND id_daftar IN (SELECT dft.id_daftar FROM tbl_pendaftaran dft WHERE dft.id_usaha IN (SELECT psr.id_usaha FROM tbl_grup_pasar psr WHERE psr.id_pasar = $pasar))";
			} else {
				$where .= " AND id_daftar IN (SELECT dft.id_daftar FROM tbl_pendaftaran dft WHERE dft.id_usaha NOT IN (SELECT psr.id_usaha FROM tbl_grup_pasar psr))";
			}
		} 
		// else {
		// 	$where .= " AND id_daftar IN (SELECT dft.id_daftar FROM tbl_pendaftaran dft)";
		// }

		$group = 'tgl_bayar';
		$by = 'tgl_bayar';
		$order = 'DESC';
		$dataSetor = $this->MasterData->getWhereDataGroupOrder('*','tbl_pembayaran',$where,$group,$by,$order)->result();

		$select = array(
			'dft.*',
			"(SELECT ush.nama_usaha FROM tbl_usaha ush WHERE ush.id_usaha = dft.id_usaha) nama_usaha",
			"(SELECT usr.nama_user FROM tbl_user usr WHERE usr.id_user = (SELECT ush.id_user FROM tbl_usaha ush WHERE ush.id_usaha = dft.id_usaha)) nama_user",
			"(SELECT byr.tgl_bayar FROM tbl_pembayaran byr WHERE byr.id_daftar = dft.id_daftar) tgl_bayar"
		);
		$where = "dft.id_daftar IN (SELECT byr.id_daftar FROM tbl_pembayaran byr)";
		$dataOrder = $this->MasterData->getWhereData($select,'tbl_pendaftaran dft',$where)->result();

		$dataBayar = array();
		foreach ($dataOrder as $order) {
			$layanan = $order->layanan;
			$tempat = $order->tempat;
			$id_daftar = $order->id_daftar;

			$select = '*';
			$where = "id_daftar = $id_daftar";
			$dataList = $this->MasterData->getWhereData($select,'tbl_list_tera',$where)->result();

			$xxx =  $layanan.'_'.$tempat;
			$col_tarif = str_replace(' ', '_', $xxx);
			
			$tot_tarif = 0;
			foreach ($dataList as $list) {
				$id_uttp = $list->id_uttp;
				$id_tarif = $list->id_tarif;
				$jml_uttp = $list->jumlah_uttp;

				$select = '*';
				$where = "id_tarif = $id_tarif";
				$dataTarif = $this->MasterData->getWhereData($select,'tbl_tarif',$where)->row();

				$tarif = $dataTarif->$col_tarif;	
				$tot_tarif += $tarif * $jml_uttp;

				$select = array(
					"(SELECT jns.nama_jenis_alat FROM tbl_jenis_alat_ukur jns WHERE jns.id_jenis_alat = uttp.id_jenis_alat) jenis_alat"
				);
				$where = "id_uttp = $id_uttp";
				$dataUttp = $this->MasterData->getWhereData($select,'tbl_uttp uttp',$where)->row();

				$dataBayar[] = array(
					'id_daftar' => $id_daftar,
					'uttp' => $dataUttp->jenis_alat,
					'jml_uttp' => $jml_uttp,
					'jenis_tarif' => $dataTarif->jenis_tarif,
					'tarif' => $tarif
				);
			}
		}

		// ===============================================================

		$select = array(
			'year(tgl_bayar) tahun'
		);
		$group = 'year(tgl_bayar)';
		$by = 'year(tgl_bayar)';
		$order = 'DESC';
		$tahunPembayaran = $this->MasterData->getSelectDataGroupOrder($select,'tbl_pembayaran',$group,$by,$order)->result();

		// ================================================================

		$select = '*';
		$dataPasar = $this->MasterData->getSelectData($select,'tbl_pasar')->result();

		// ================================================================

		// $this->head[] = "assets/assets/plugins/select2/dist/css/select2.css";
		$this->head[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.css";
		$this->head[] = "assets/assets/plugins/sweetalert/sweetalert.css";
		// $this->head[] = "assets/assets/plugins/dropify/dist/css/dropify.min.css";
		// $this->head[] = "assets/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css";

		// $this->foot[] = "assets/assets/plugins/select2/dist/js/select2.full.min.js";
		$this->foot[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/sweetalert.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/jquery.sweet-alert.custom.js";
		$this->foot[] = "assets/assets/plugins/datatables/jquery.dataTables.min.js";
		// $this->foot[] = "assets/assets/plugins/dropify/dist/js/dropify.min.js";
		// $this->foot[] = "assets/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js";

		$script = array(
			"$('#myTable').DataTable();",
			// "$('.select2').select2();",
			// "$('.dropify').dropify({
			// 	 messages: {
	  //               default: '<center>Upload foto/gambar disini.</center>',
	  //               error: '<center>Maksimal ukuran file 2 MB.</center>',
	  //           }
			// });",
			// "$('.mydatepicker').datepicker({ format: 'dd-mm-yyyy', autoclose:true });",
		);


		// $css_link = array(
		// 	"https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/css/lightbox.min.css"
		// );

		// $js_link = array(
		// 	"https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/js/lightbox.min.js"
		// );

		$head = array (
			'head' => $this->head,
			// 'css_link' => $css_link
		);
		$foot = array(
			'foot' =>  $this->foot,
			'script' => $script,
			// 'js_link' => $js_link
		);

		$nav['menu'] = 'laporan';

		$dataBulan = array(
			1 => 'Januari',
			2 => 'Februari',
			3 => 'Maret',
			4 => 'April',
			5 => 'Mei',
			6 => 'Juni',
			7 => 'Juli',
			8 => 'Agustus',
			9 => 'September',
			10 => 'Oktober',
			11 => 'November',
			12 => 'Desember'
		);

		$data = array(
			'dataSetor' => $dataSetor,
			'dataOrder' => $dataOrder,
			'dataBayar' => $dataBayar,
			'tahun' => $tahunPembayaran,
			'selectTahun' => $tahun,
			'selectBulan' => $bulan,
			'selectPasar' => $pasar,
			'dataPasar' => $dataPasar,
			'dataBulan' => $dataBulan
		);

		$this->load->view('Petugas/head',$head);
		$this->load->view('Petugas/navigation',$nav);
		$this->load->view('Petugas/data_laporan',$data);
		$this->load->view('foot',$foot);
	}

	public function cetakLaporan($bln='', $thn='', $psr='') {

		if ($thn != '') {
			$tahun = decode($thn);

			$where = "year(tgl_bayar) = $tahun";
		} else {
			$tahun = date('Y');

			$where = "year(tgl_bayar) = $tahun";
		}

		$bulan = 1;
		if ($bln != '') {
			$bulan = decode($bln);

			$where .= " AND month(tgl_bayar) = $bulan";
		}

		$pasar = '';
		if ($psr != '') {
			$pasar = decode($psr);

			if ($pasar > 0) {
				$where .= " AND id_daftar IN (SELECT dft.id_daftar FROM tbl_pendaftaran dft WHERE dft.id_usaha IN (SELECT psr.id_usaha FROM tbl_grup_pasar psr WHERE psr.id_pasar = $pasar))";
			} else {
				$where .= " AND id_daftar IN (SELECT dft.id_daftar FROM tbl_pendaftaran dft WHERE dft.id_usaha NOT IN (SELECT psr.id_usaha FROM tbl_grup_pasar psr))";
			}
		} 

		$group = 'tgl_bayar';
		$by = 'tgl_bayar';
		$order = 'ASC';
		$dataSetor = $this->MasterData->getWhereDataGroupOrder('*','tbl_pembayaran',$where,$group,$by,$order)->result();

		$select = array(
			'dft.*',
			"(SELECT ush.nama_usaha FROM tbl_usaha ush WHERE ush.id_usaha = dft.id_usaha) nama_usaha",
			"(SELECT usr.nama_user FROM tbl_user usr WHERE usr.id_user = (SELECT ush.id_user FROM tbl_usaha ush WHERE ush.id_usaha = dft.id_usaha)) nama_user",
			"(SELECT byr.tgl_bayar FROM tbl_pembayaran byr WHERE byr.id_daftar = dft.id_daftar) tgl_bayar"
		);
		$where = "dft.id_daftar IN (SELECT byr.id_daftar FROM tbl_pembayaran byr)";
		$dataOrder = $this->MasterData->getWhereData($select,'tbl_pendaftaran dft',$where)->result();

		$dataBayar = array();
		foreach ($dataOrder as $order) {
			$layanan = $order->layanan;
			$tempat = $order->tempat;
			$id_daftar = $order->id_daftar;

			$select = '*';
			$where = "id_daftar = $id_daftar";
			$dataList = $this->MasterData->getWhereData($select,'tbl_list_tera',$where)->result();

			$xxx =  $layanan.'_'.$tempat;
			$col_tarif = str_replace(' ', '_', $xxx);
			
			$tot_tarif = 0;
			foreach ($dataList as $list) {
				$id_uttp = $list->id_uttp;
				$id_tarif = $list->id_tarif;
				$jml_uttp = $list->jumlah_uttp;

				$select = '*';
				$where = "id_tarif = $id_tarif";
				$dataTarif = $this->MasterData->getWhereData($select,'tbl_tarif',$where)->row();

				$tarif = $dataTarif->$col_tarif;	
				$tot_tarif += $tarif * $jml_uttp;

				$select = array(
					"(SELECT jns.nama_jenis_alat FROM tbl_jenis_alat_ukur jns WHERE jns.id_jenis_alat = uttp.id_jenis_alat) jenis_alat"
				);
				$where = "id_uttp = $id_uttp";
				$dataUttp = $this->MasterData->getWhereData($select,'tbl_uttp uttp',$where)->row();

				$dataBayar[] = array(
					'id_daftar' => $id_daftar,
					'uttp' => $dataUttp->jenis_alat,
					'jml_uttp' => $jml_uttp,
					'jenis_tarif' => $dataTarif->jenis_tarif,
					'tarif' => $tarif
				);
			}
		}

		// ===============================================================

		// $select = array(
		// 	'year(tgl_bayar) tahun'
		// );
		// $group = 'year(tgl_bayar)';
		// $by = 'year(tgl_bayar)';
		// $order = 'DESC';
		// $tahunPembayaran = $this->MasterData->getSelectDataGroupOrder($select,'tbl_pembayaran',$group,$by,$order)->result();

		// ================================================================

		$select = '*';
		$dataPasar = $this->MasterData->getSelectData($select,'tbl_pasar')->result();

		// ================================================================


		$dataBulan = array(
			1 => 'Januari',
			2 => 'Februari',
			3 => 'Maret',
			4 => 'April',
			5 => 'Mei',
			6 => 'Juni',
			7 => 'Juli',
			8 => 'Agustus',
			9 => 'September',
			10 => 'Oktober',
			11 => 'November',
			12 => 'Desember'
		);

		$data = array(
			'dataSetor' => $dataSetor,
			'dataOrder' => $dataOrder,
			'dataBayar' => $dataBayar,
			// 'tahun' => $tahunPembayaran,
			'selectTahun' => $tahun,
			'selectBulan' => $bulan,
			'selectPasar' => $pasar,
			'dataPasar' => $dataPasar,
			'dataBulan' => $dataBulan
		);

		$this->load->library('PhpExcelNew/PHPExcel');
		$this->load->view('Petugas/laporan/printLaporan',$data);
	}

	public function getDataSetor($value='') {
		$tgl_bayar = $this->input->POST('tgl_bayar');

		if ($tgl_bayar) {
			$select = array(
				'dft.*',
				"(SELECT ush.nama_usaha FROM tbl_usaha ush WHERE ush.id_usaha = dft.id_usaha) nama_usaha",
				"(SELECT usr.nama_user FROM tbl_user usr WHERE usr.id_user = (SELECT ush.id_user FROM tbl_usaha ush WHERE ush.id_usaha = dft.id_usaha)) nama_user",
				"(SELECT byr.tgl_bayar FROM tbl_pembayaran byr WHERE byr.id_daftar = dft.id_daftar) tgl_bayar"
			);
			$where = "dft.id_daftar IN (SELECT byr.id_daftar FROM tbl_pembayaran byr WHERE byr.tgl_bayar = '$tgl_bayar')";
			$dataOrder = $this->MasterData->getWhereData($select,'tbl_pendaftaran dft',$where)->result();

			$dataBayar = array();
			foreach ($dataOrder as $order) {
				$layanan = $order->layanan;
				$tempat = $order->tempat;
				$id_daftar = $order->id_daftar;

				$select = '*';
				$where = "id_daftar = $id_daftar";
				$dataList = $this->MasterData->getWhereData($select,'tbl_list_tera',$where)->result();

				$xxx =  $layanan.'_'.$tempat;
				$col_tarif = str_replace(' ', '_', $xxx);
				
				$tot_tarif = 0;
				foreach ($dataList as $list) {
					$id_uttp = $list->id_uttp;
					$id_tarif = $list->id_tarif;
					$jml_uttp = $list->jumlah_uttp;

					$select = '*';
					$where = "id_tarif = $id_tarif";
					$dataTarif = $this->MasterData->getWhereData($select,'tbl_tarif',$where)->row();

					$tarif = $dataTarif->$col_tarif;	
					$tot_tarif += $tarif * $jml_uttp;

					$select = array(
						"(SELECT jns.nama_jenis_alat FROM tbl_jenis_alat_ukur jns WHERE jns.id_jenis_alat = uttp.id_jenis_alat) jenis_alat"
					);
					$where = "id_uttp = $id_uttp";
					$dataUttp = $this->MasterData->getWhereData($select,'tbl_uttp uttp',$where)->row();

					$dataBayar[] = array(
						'id_daftar' => $id_daftar,
						'uttp' => $dataUttp->jenis_alat,
						'jml_uttp' => $jml_uttp,
						'jenis_tarif' => $dataTarif->jenis_tarif,
						'tarif' => $tarif
					);
				}
			}

			if ($dataOrder) {
				$result = array(
					'response' => true,
					'dataOrder' => $dataOrder,
					'dataBayar' => $dataBayar,
					'terbilang' => number_to_words($tot_tarif)
				);
			} else {
				$result = array(
					'response' => false
				);
			}
		} else {
			$result = array(
				'response' => false
			);
		}

		echo json_encode($result);
	}

	// =====================================================

	public function dataTera($id='1'){
		$id_user = $this->id_user;
		$select = array(
			'dft.*',
			"(SELECT jns.nama_jenis_usaha FROM tbl_jenis_usaha jns WHERE jns.id_jenis_usaha IN (SELECT ush.id_jenis_usaha FROM tbl_usaha ush WHERE ush.id_usaha = dft.id_usaha)) jenis_usaha",
			"(SELECT usr.nama_user FROM tbl_user usr WHERE usr.id_user = (SELECT ush.id_user FROM tbl_usaha ush WHERE ush.id_usaha = dft.id_usaha)) nama_user",
			"(SELECT tmp.tempat_tera FROM tbl_tempat_tera tmp WHERE tmp.id_tempat_tera = dft.id_tempat_tera) tempat_tera"
		);
		$table = "tbl_pendaftaran dft";
		$where = "user_daftar = 'petugas'";
		$by = 'dft.id_daftar';
		$order = 'DESC';
		$dataTera = $this->MasterData->getWhereDataOrder($select,$table,$where,$by,$order)->result();
		// $statusJl = $this->MasterData->getData('tbl_status_jalan')->result();

		$this->head[] = "assets/assets/plugins/select2/dist/css/select2.css";
		$this->head[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.css";
		$this->head[] = "assets/assets/plugins/sweetalert/sweetalert.css";
		$this->head[] = "assets/assets/plugins/dropify/dist/css/dropify.min.css";
		$this->head[] = "assets/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css";

		$this->foot[] = "assets/assets/plugins/select2/dist/js/select2.full.min.js";
		$this->foot[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/sweetalert.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/jquery.sweet-alert.custom.js";
		$this->foot[] = "assets/assets/plugins/datatables/jquery.dataTables.min.js";
		$this->foot[] = "assets/assets/plugins/dropify/dist/js/dropify.min.js";
		$this->foot[] = "assets/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js";

		$script = array(
			"$('#myTable').DataTable();",
			"$('.select2').select2();",
			"$('.dropify').dropify({
				 messages: {
	                default: '<center>Upload foto/gambar disini.</center>',
	                error: '<center>Maksimal ukuran file 2 MB.</center>',
	            }
			});",
			"$('.mydatepicker').datepicker({ format: 'dd-mm-yyyy', autoclose:true });",
			// "lightbox.option({
	  //           'albumLabel':   'picture %1 of %2',
	  //           'fadeDuration': 300,
	  //           'resizeDuration': 150,
	  //           'wrapAround': true
	  //       })"
		);


		$css_link = array(
			"https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/css/lightbox.min.css"
		);

		$js_link = array(
			"https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/js/lightbox.min.js"
		);

		$head = array (
			'head' => $this->head,
			// 'css_link' => $css_link
		);
		$foot = array(
			'foot' =>  $this->foot,
			'script' => $script,
			// 'js_link' => $js_link
		);

		$nav['menu'] = 'tera';

		$data = array(
			'dataTera' => $dataTera
		);

		$this->load->view('Petugas/head',$head);
		$this->load->view('Petugas/navigation',$nav);
		$this->load->view('Petugas/tera',$data);
		$this->load->view('foot',$foot);
	}

	public function pendaftaranTera($id='1'){
		$id_user = $this->id_user;

		$select = 'nomor';
		$table = 'tbl_nomor';
		$where = "keterangan = 'Agenda'";
		$no_order = $this->MasterData->getWhereData($select,$table,$where)->row()->nomor;

		$tempat_tera = $this->MasterData->getData('tbl_tempat_tera')->result();

		// $select = '*';
		// $table = "tbl_tarif";
		// $where = "parent_id = (SELECT id_tarif FROM tbl_tarif WHERE jenis_tarif = 'UTTP')";
		// $by = 'id_tarif';
		// $order = 'ASC';
		// $dataTarif = $this->MasterData->getWhereDataOrder($select,$table,$where,$by,$order)->result();

		// $select = array(
		// 	'ush.id_usaha',
		// 	"(SELECT jns.nama_jenis_usaha FROM tbl_jenis_usaha jns WHERE jns.id_jenis_usaha = ush.id_jenis_usaha) jenis_usaha"
		// );
		// $table = "tbl_usaha ush";
		// $where = "ush.id_user = '$id_user'";
		// $by = 'ush.id_usaha';
		// $order = 'ASC';
		// $dataUsaha = $this->MasterData->getWhereDataOrder($select,$table,$where,$by,$order)->result();
		
		// $select = array(
		// 	'uttp.*',
		// 	"(SELECT alat.nama_jenis_alat FROM tbl_jenis_alat_ukur alat WHERE alat.id_jenis_alat = uttp.id_jenis_alat) jenis_alat"
		// );
		// $table = "tbl_uttp uttp";
		// $where = "uttp.id_usaha IN (SELECT ush.id_usaha FROM tbl_usaha ush WHERE ush.id_user = '$id_user')";
		// $by = 'uttp.id_uttp';
		// $order = 'DESC';
		// $dataUttp = $this->MasterData->getWhereDataOrder($select,$table,$where,$by,$order)->result();

		$this->head[] = "assets/assets/plugins/select2/dist/css/select2.css";
		$this->head[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.css";
		$this->head[] = "assets/assets/plugins/sweetalert/sweetalert.css";
		$this->head[] = "assets/assets/plugins/dropify/dist/css/dropify.min.css";
		$this->head[] = "assets/main/vendor/jquery-ui/jquery-ui.min.css";

		$this->foot[] = "assets/assets/plugins/select2/dist/js/select2.full.min.js";
		$this->foot[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/sweetalert.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/jquery.sweet-alert.custom.js";
		$this->foot[] = "assets/assets/plugins/datatables/jquery.dataTables.min.js";
		$this->foot[] = "assets/assets/plugins/dropify/dist/js/dropify.min.js";
		// $this->foot[] = "assets/main/vendor/typeahead/typeahead.jquery.min.js";
		$this->foot[] = "assets/main/vendor/jquery-ui/jquery-ui.min.js";

		$script = array(
			"$('#myTable').DataTable();",
			"$('.select2').select2();",
			// "$('.dropify').dropify({
			// 	 messages: {
	  //               default: '<center>Upload foto/gambar disini.</center>',
	  //               error: '<center>Maksimal ukuran file 500 KB.</center>',
	  //           }
			// });"
			"$('.autocomplete').autocomplete({
                source: '".base_url().'Petugas/getDataUser'."',
      			response: function (event, ui) {
		            var len = ui.content.length;
		            if (len == 0) {
		            	$('#pengajuanTera #counter_found').html('Data user tidak ditemukan');
		            	clearDataUsaha();
		            	$('#pengajuanTera #cek').val('');
		            } else {
		            	$('#pengajuanTera #counter_found').html('');
		            	clearDataUsaha();
		            }
		            
		        },
                select: function (event, ui) {
                    getDataUsaha(ui.item.id);
                    $('#pengajuanTera #cek').val(ui.item.id);
                }
            });"
		);


		$css_link = array(
			"https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/css/lightbox.min.css"
		);

		$js_link = array(
			"https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/js/lightbox.min.js",
			// "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"
		);

		$head = array (
			'head' => $this->head,
			// 'css_link' => $css_link
		);
		$foot = array(
			'foot' =>  $this->foot,
			'script' => $script,
			// 'js_link' => $js_link
		);

		$nav['menu'] = 'tera_baru';

		$data = array(
			// 'dataUsaha' => $dataUsaha,
			'tempat_tera' => $tempat_tera,
			'no_order' => $no_order,
			'id_user' => $id_user
		);

		$this->load->view('Petugas/head',$head);
		$this->load->view('Petugas/navigation',$nav);
		$this->load->view('Petugas/pendaftaran_tera',$data);
		$this->load->view('foot',$foot);
	}

	public function getDataTarif($value='') {
		$id_jenis_alat = $this->input->POST('id_jenis_alat');

		$select = 'id_kategori_alat';
		$table = 'tbl_jenis_alat_ukur';
		$where = "id_jenis_alat = $id_jenis_alat";
		$id_kategori_alat = $this->MasterData->getWhereData($select,$table,$where)->row()->id_kategori_alat;

		$select = array(
			'trf.*'
		);
		$table = 'tbl_tarif trf';
		$where = "id_tarif IN (SELECT kel.id_tarif FROM tbl_kelompok_tarif kel WHERE kel.id_kategori_alat = $id_kategori_alat)";
		$by = 'trf.id_tarif';
		$order = 'ASC';
		$kelompokTarif = $this->MasterData->getWhereDataOrder($select,$table,$where,$by,$order)->result();

		if ($kelompokTarif) {
			$result = array(
				'response' => true,
				'data' => $kelompokTarif
			);
		} else {
			$result = array(
				'response' => false
			);
		}

		echo json_encode($result);
	}

	public function getListTarif($value='') {
		$id_tarif = $this->input->POST('id_tarif');
		$parent_id = $this->input->POST('parent_id');
		$child_id = $this->input->POST('child_id');

		if ($this->input->POST()) {
			$select = array(
			'trf.*'
			);
			$table = 'tbl_tarif trf';
			$by = 'trf.id_tarif';
			$order = 'ASC';
			if ($child_id == 0) {
				$where = "id_tarif = $id_tarif";
			} else {
				$where = "parent_id = $id_tarif";
			}
			
			$kelompokTarif = $this->MasterData->getWhereDataOrder($select,$table,$where,$by,$order)->result();

			if ($kelompokTarif) {
				$result = array(
					'response' => true,
					'data' => $kelompokTarif
				);
			} else {
				$result = array(
					'response' => false
				);
			}
		} else {
			$result = array(
				'response' => false
			);
		}

		echo json_encode($result);
	}

	public function getDataUttp($value='') {
		$id_user = $this->id_user;
		$id_uttp = $this->input->POST('select_id_uttp');
		$id_usaha = $this->input->POST('id_usaha');

		if ($this->input->POST()) { 

			// $id_uttp = explode(";",$uttp_select);
			// $id_uttp = implode(",",$id_uttp);

			$select = array(
				'uttp.*',
				"(SELECT alat.nama_jenis_alat FROM tbl_jenis_alat_ukur alat WHERE alat.id_jenis_alat = uttp.id_jenis_alat) jenis_alat"
			);
			$table = "tbl_uttp uttp";
			// $where = "uttp.id_usaha IN (SELECT ush.id_usaha FROM tbl_usaha ush WHERE ush.id_user = '$id_user') AND uttp.id_uttp NOT IN ($id_uttp)";
			$where = "uttp.id_usaha = '$id_usaha' AND uttp.id_uttp NOT IN ($id_uttp)";
			$by = 'uttp.id_uttp';
			$order = 'DESC';
			$dataUttp = $this->MasterData->getWhereDataOrder($select,$table,$where,$by,$order)->result();

			if ($dataUttp) {
				$result = array(
					'response' => true,
					'data' => $dataUttp
				);
			} else {
				$result = array(
					'response' => false
				);
			}
		} else {
			$result = array(
				'response' => false
			);
		}

		echo json_encode($result);
	}

	public function cekTarif($value='') {

		if ($this->input->POST()) {
			$tarif_id = $this->input->POST('id_tarif');
			$uttp_id = $this->input->POST('uttp_id');
			$uttp_jml = $this->input->POST('jml_uttp');
			$layanan = $this->input->POST('layanan');
			$tempat = $this->input->POST('tempat');

			$id_tarif = explode(',', $tarif_id);
			$id_uttp = explode(',', $uttp_id);
			$jml_uttp = explode(',', $uttp_jml);

			$dataArr = array();
			for ($i=0; $i < count($id_tarif) ; $i++) { 
				$select = array(
					'uttp.*',
					"(SELECT alat.nama_jenis_alat FROM tbl_jenis_alat_ukur alat WHERE alat.id_jenis_alat = uttp.id_jenis_alat) jenis_alat"
				);
				$where = "uttp.id_uttp = '$id_uttp[$i]'";
				$data_uttp = $this->MasterData->getWhereData($select,'tbl_uttp uttp',$where)->row();

				$select = '*';
				$where = "id_tarif = '$id_tarif[$i]'";
				$data_tarif = $this->MasterData->getWhereData($select,'tbl_tarif',$where)->row();

				$xxx =  $layanan.'_'.$tempat;
				$col_tarif = str_replace(' ', '_', $xxx);
				$tarif = $data_tarif->$col_tarif;	
				$tot_tarif = $tarif * $jml_uttp[$i];		

				$arr = array(
					'jenis_alat' => $data_uttp->jenis_alat,
					'kapasitas' => $data_uttp->kapasitas,
					'jenis_tarif' => $data_tarif->jenis_tarif,
					'satuan' => $data_tarif->satuan,
					'layanan' => $layanan,
					'tempat' => $tempat,
					'jumlah' => $jml_uttp[$i],
					'tarif' => $tarif,
					'tot_tarif' => $tot_tarif
				);

				$dataArr[] = $arr;
			}

			$result = array(
				'response' => true,
				'data' => $dataArr
			);
		} else {
			$result = array(
				'response' => false
			);
		}

		echo json_encode($result);
	}

	public function pengajuanTera($value='') {
		$post = $this->input->POST();


		if ($post) {

			$select = 'grup';
			$where = "id_tempat_tera = $post[tempat]";
			$tempat_tera = $this->MasterData->getWhereData($select,'tbl_tempat_tera',$where)->row()->grup;

			$data = array(
				'id_usaha' => $post['id_usaha'],
				'no_order' => $post['no_order'],
				'layanan' => $post['layanan'],
				'tempat' => $tempat_tera,
				'id_tempat_tera' => $post['tempat'],
				'tgl_daftar' => date('Y-m-d'),
				'tgl_kirim' => date('Y-m-d H:i:s'),
				'status' => 'diterima',
				'user_daftar' => 'petugas',
				// 'notif' => 0
			);
			$input_pendaftaran = $this->MasterData->inputData($data,'tbl_pendaftaran');

			if ($input_pendaftaran) {

				$id_daftar = $this->db->insert_id();

				$id_uttp = $post['id_uttp'];
				$id_tarif = $post['id_tarif'];
				$jumlah_uttp = $post['jumlah_uttp'];
				$data = array();
				for ($i=0; $i < count($id_uttp) ; $i++) { 

					$datax = array(
						'id_tarif' => $id_tarif[$i]
					);
					$wherex = "id_uttp = $id_uttp[$i]";
					$update_uttp = $this->MasterData->editData($wherex,$datax,'tbl_uttp'); //Update id_tarif tbl_uttp
					// =====================================================
					$arr = array(
						'id_daftar' => $id_daftar,
						'id_uttp' => $id_uttp[$i],
						'id_tarif' => $id_tarif[$i],
						'jumlah_uttp' => $jumlah_uttp[$i]
					);
					$data[] = $arr;
				}

				$insert_list = $this->db->insert_batch('tbl_list_tera', $data); 

				if ($insert_list) {
					$where = "keterangan = 'Agenda'";
					$data = array(
						'nomor' => $post['no_order'] + 1
					);
					$update_nomor = $this->MasterData->editData($where,$data,'tbl_nomor');

					$sess['alert'] = alert_success('Data pengajuan tera berhasil disimpan.');
					$this->session->set_flashdata($sess);
					redirect(base_url().'Petugas/dataTera');
				} else {
					$sess['alert'] = alert_failed('Data pengajuan tera gagal disimpan.');
					$this->session->set_flashdata($sess);
					redirect(base_url().'Petugas/pendaftaranTera');
				}
			} else {
				$sess['alert'] = alert_failed('Data pengajuan tera gagal disimpan.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Petugas/pendaftaranTera');
			}
		} else {
			$sess['alert'] = alert_failed('Data pengajuan tera gagal disimpan.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Petugas/pendaftaranTera');
		}
		// echo "<pre>".print_r($post)."</pre>";
	}

	public function getDataForm($value='') {
		$id = $this->input->POST('id_daftar');

		if ($id) {
			$select = array(
				'dft.*',
				"(SELECT usr.nama_user FROM tbl_user usr WHERE usr.id_user = (SELECT ush.id_user FROM tbl_usaha ush WHERE ush.id_usaha = dft.id_usaha)) nama_user",
				"(SELECT jns.nama_jenis_usaha FROM tbl_jenis_usaha jns WHERE jns.id_jenis_usaha = (SELECT ush.id_jenis_usaha FROM tbl_usaha ush WHERE ush.id_usaha = dft.id_usaha)) jenis_usaha",
				"(SELECT des.nama_desa FROM tbl_desa des WHERE des.kode_desa = (SELECT ush.kode_desa FROM tbl_usaha ush WHERE ush.id_usaha = dft.id_usaha)) desa",
				"(SELECT kec.nama_kecamatan FROM tbl_kecamatan kec WHERE kec.kode_kecamatan = (SELECT des.kode_kecamatan FROM tbl_desa des WHERE des.kode_desa = (SELECT ush.kode_desa FROM tbl_usaha ush WHERE ush.id_usaha = dft.id_usaha))) kecamatan",
				"(SELECT ush.alamat FROM tbl_usaha ush WHERE ush.id_usaha = dft.id_usaha) alamat",
				"(SELECT usr.no_hp FROM tbl_user usr WHERE usr.id_user = (SELECT ush.id_user FROM tbl_usaha ush WHERE ush.id_usaha = dft.id_usaha)) no_telp"
			);
			$where = "id_daftar = $id";
			$table = 'tbl_pendaftaran dft';
			$dataForm = $this->MasterData->getWhereData($select,$table,$where)->row();

			$select = array(
				'list.*',
				"(SELECT jns.nama_jenis_alat FROM tbl_jenis_alat_ukur jns WHERE jns.id_jenis_alat = (SELECT uttp.id_jenis_alat FROM tbl_uttp uttp WHERE uttp.id_uttp = list.id_uttp)) jenis_alat",
				"(SELECT ktg.nama_kategori_alat FROM tbl_kategori_alat_ukur ktg WHERE ktg.id_kategori_alat = (SELECT jns.id_kategori_alat FROM tbl_jenis_alat_ukur jns WHERE jns.id_jenis_alat = (SELECT uttp.id_jenis_alat FROM tbl_uttp uttp WHERE uttp.id_uttp = list.id_uttp))) kategori_alat",
				"(SELECT uttp.kapasitas FROM tbl_uttp uttp WHERE uttp.id_uttp = list.id_uttp) kapasitas"
			);
			$table = 'tbl_list_tera list';
			$listUttp = $this->MasterData->getWhereData($select,$table,$where)->result();

			if ($listUttp) {
				$result = array(
					'response' => true,
					'dataForm' => $dataForm,
					'listUttp' =>  $listUttp
				);
			} else {
				$result = array(
					'response' => false
				);
			}
		} else {
			$result = array(
				'response' => false
			);
		}

		echo json_encode($result);
	}

	public function editPendaftaranTera($id='') {
		// $id_user = $this->id_user;

		if ($id != '') {
			$id_daftar = decode($id);
		} else {
			$id_daftar = 1;
		}
		
		$select = '*';
		$table = 'tbl_pendaftaran dft';
		$where = "dft.id_daftar = $id_daftar";
		$dataPendaftaran = $this->MasterData->getWhereData($select,$table,$where)->row();

		$id_usaha = $dataPendaftaran->id_usaha;
		$select = array(
			'ush.id_usaha',
			'ush.nama_usaha',
			"(SELECT jns.nama_jenis_usaha FROM tbl_jenis_usaha jns WHERE jns.id_jenis_usaha = ush.id_jenis_usaha) jenis_usaha"
		);
		$table = "tbl_usaha ush";
		$where = "ush.id_user = (SELECT usaha.id_user FROM tbl_usaha usaha WHERE usaha.id_usaha = $id_usaha)";
		$by = 'ush.id_usaha';
		$order = 'ASC';
		$dataUsaha = $this->MasterData->getWhereDataOrder($select,$table,$where,$by,$order)->result();

		$select = '*';
		$table = 'tbl_user usr';
		$where = "usr.id_user = (SELECT usaha.id_user FROM tbl_usaha usaha WHERE usaha.id_usaha = $id_usaha)";
		$dataUser = $this->MasterData->getWhereData($select,$table,$where)->row();

		$xxx =  $dataPendaftaran->layanan.'_'.$dataPendaftaran->tempat;
		$col_tarif = str_replace(' ', '_', $xxx);
		$select = array(
			'list.*',
			"(SELECT jns.nama_jenis_alat FROM tbl_jenis_alat_ukur jns WHERE jns.id_jenis_alat = (SELECT uttp.id_jenis_alat FROM tbl_uttp uttp WHERE uttp.id_uttp = list.id_uttp)) jenis_alat",
			"(SELECT trf.jenis_tarif FROM tbl_tarif trf WHERE trf.id_tarif = list.id_tarif) jenis_tarif",
			"(SELECT trf.satuan FROM tbl_tarif trf WHERE trf.id_tarif = list.id_tarif) satuan",
			"(SELECT trf.$col_tarif FROM tbl_tarif trf WHERE trf.id_tarif = list.id_tarif) tarif",
			"(SELECT uttp.kapasitas FROM tbl_uttp uttp WHERE uttp.id_uttp = list.id_uttp) kapasitas"
		);	
		$table = 'tbl_list_tera list';
		$where = "list.id_daftar = $id_daftar";
		$by = 'list.id_list';
		$order = 'ASC';
		$listUttp = $this->MasterData->getWhereDataOrder($select,$table,$where,$by,$order)->result();

		$tempat_tera = $this->MasterData->getData('tbl_tempat_tera')->result();

		// $arr = array(
		// 	'jenis_alat' => $data_uttp->jenis_alat,
		// 	'jenis_tarif' => $data_tarif->jenis_tarif,
		// 	'satuan' => $data_tarif->satuan,
		// 	'layanan' => $layanan,
		// 	'tempat' => $tempat,
		// 	'jumlah' => $jml_uttp[$i],
		// 	'tarif' => $tarif,
		// 	'tot_tarif' => $tot_tarif
		// );


		$this->head[] = "assets/assets/plugins/select2/dist/css/select2.css";
		$this->head[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.css";
		$this->head[] = "assets/assets/plugins/sweetalert/sweetalert.css";
		$this->head[] = "assets/assets/plugins/dropify/dist/css/dropify.min.css";

		$this->foot[] = "assets/assets/plugins/select2/dist/js/select2.full.min.js";
		$this->foot[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/sweetalert.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/jquery.sweet-alert.custom.js";
		$this->foot[] = "assets/assets/plugins/datatables/jquery.dataTables.min.js";
		$this->foot[] = "assets/assets/plugins/dropify/dist/js/dropify.min.js";

		$script = array(
			"$('#myTable').DataTable();",
			"$('.select2').select2();"
		);


		$css_link = array(
			"https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/css/lightbox.min.css"
		);

		$js_link = array(
			"https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/js/lightbox.min.js"
		);

		$head = array (
			'head' => $this->head,
			'css_link' => $css_link
		);
		$foot = array(
			'foot' =>  $this->foot,
			'script' => $script,
			'js_link' => $js_link
		);

		$nav['menu'] = 'tera';

		$data = array(
			'tempat_tera' => $tempat_tera,
			'dataUsaha' => $dataUsaha,
			'listUttp' => $listUttp,
			'dataPendaftaran' => $dataPendaftaran,
			'dataUser' => $dataUser
		);

		$this->load->view('Petugas/head',$head);
		$this->load->view('Petugas/navigation',$nav);
		$this->load->view('Petugas/edit_pendaftaran_tera',$data);
		$this->load->view('foot',$foot);
	}

	public function updatePengajuanTera($value='') {
		$post = $this->input->POST();


		if ($post) {

			$select = 'grup';
			$where = "id_tempat_tera = $post[tempat]";
			$tempat_tera = $this->MasterData->getWhereData($select,'tbl_tempat_tera',$where)->row()->grup;

			$id_daftar = $post['id_daftar'];

			$data = array(
				'id_usaha' => $post['id_usaha'],
				// 'no_order' => $post['no_order'],
				'layanan' => $post['layanan'],
				'tempat' => $tempat_tera,
				'id_tempat_tera' => $post['tempat'],
				// 'tgl_daftar' => date('Y-m-d'),
				// 'status' => 'masuk',
				// 'notif' => 0
			);
			$where = "id_daftar = '$id_daftar'";
			$update_pendaftaran = $this->MasterData->editData($where,$data,'tbl_pendaftaran');

			if ($update_pendaftaran) {

				$deleteList = $this->MasterData->deleteData($where,'tbl_list_tera');

				if ($deleteList) {
					$id_uttp = $post['id_uttp'];
					$id_tarif = $post['id_tarif'];
					$jumlah_uttp = $post['jumlah_uttp'];
					$data = array();
					for ($i=0; $i < count($id_uttp) ; $i++) { 

						$datax = array(
							'id_tarif' => $id_tarif[$i]
						);
						$wherex = "id_uttp = $id_uttp[$i]";
						$update_uttp = $this->MasterData->editData($wherex,$datax,'tbl_uttp'); //Update id_tarif tbl_uttp
						// =====================================================
						$arr = array(
							'id_daftar' => $id_daftar,
							'id_uttp' => $id_uttp[$i],
							'id_tarif' => $id_tarif[$i],
							'jumlah_uttp' => $jumlah_uttp[$i]
						);
						$data[] = $arr;
					}

					$insert_list = $this->db->insert_batch('tbl_list_tera', $data); 

					if ($insert_list) {
						$sess['alert'] = alert_success('Data pengajuan tera berhasil diupdate.');
						$this->session->set_flashdata($sess);
						redirect(base_url().'Petugas/dataTera');
					} else {
						$sess['alert'] = alert_failed('Data pengajuan tera gagal diupdate.');
						$this->session->set_flashdata($sess);
						redirect(base_url().'Petugas/dataTera');
					}
				} else {
					$sess['alert'] = alert_failed('Data pengajuan tera gagal diupdate.');
					$this->session->set_flashdata($sess);
					redirect(base_url().'Petugas/dataTera');
				}
								
			} else {
				$sess['alert'] = alert_failed('Data pengajuan tera gagal diupdate.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Petugas/dataTera');
			}
		} else {
			$sess['alert'] = alert_failed('Data pengajuan tera gagal diupdate.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Petugas/dataTera');
		}
	}

	public function deletePengajuanTera($value='') {
		$id = $this->input->POST('id');

		$where = "id_daftar = $id";
		$delete = $this->MasterData->deleteData($where,'tbl_pendaftaran');

		if ($delete) {
			echo 'Success';
			$sess['alert'] = alert_success('Data pengajuan tera berhasil dihapus.');
			$this->session->set_flashdata($sess);
			// redirect(base_url().'Petugas/dataTera');
		} else {
			echo 'Gagal';
			$sess['alert'] = alert_failed('Data pengajuan tera gagal dihapus.');
			$this->session->set_flashdata($sess);
		}
	}

	public function kirimPengajuan($value='') {
		$id_daftar = $this->input->POST('id_daftar');
		$file_surat = '';
		$file_lampiran = '';
		$fp = date('YmdHis');
	    
		if (isset($_FILES['file_surat'])){
			$config['upload_path']          = './assets/path_file';
		    $config['allowed_types']        = '*';
		    $config['overwrite']			= false;
			$config['file_name'] = 'Surat-'.$id_daftar.'-'.$fp;
		    $this->load->library('upload', $config, 'file_surat');
		    $this->file_surat->initialize($config);

			if ($this->file_surat->do_upload('file_surat')) {
                $data_file1 = $this->file_surat->data();
				$file_surat = $data_file1['file_name'];
            }
		}

		if (isset($_FILES['file_lampiran'])){
			$config2['upload_path']          = './assets/path_file';
		    $config2['allowed_types']        = '*';
		    $config2['overwrite']			= false;
			$config2['file_name'] = 'Lampiran-'.$id_daftar.'-'.$fp;
		    $this->load->library('upload', $config2, 'file_lampiran');
		    $this->file_lampiran->initialize($config2);

			if ($this->file_lampiran->do_upload('file_lampiran')) {
                $data_file2 = $this->file_lampiran->data();
				$file_lampiran = $data_file2['file_name'];
            }
		}

		$data = array(
			'file_surat' => $file_surat,
			'file_lampiran' => $file_lampiran,
			'status' => 'diterima'
		);
		// var_dump($data);
		$where = "id_daftar = '$id_daftar'";
		$update = $this->MasterData->editData($where,$data,'tbl_pendaftaran');

		if ($update) {
			// echo 'Success';
			$sess['alert'] = alert_success('Data pengajuan tera berhasil dikirim.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Petugas/dataTera');
		} else {
			// echo 'Gagal';
			$sess['alert'] = alert_failed('Data pengajuan tera gagal dikirim.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Petugas/dataTera');
		}
	}

	public function getDataUsaha($value='') {
		$id_user = $this->input->POST('id_user');

		$select = array(
			'ush.id_usaha',
			'ush.nama_usaha',
			"(SELECT jns.nama_jenis_usaha FROM tbl_jenis_usaha jns WHERE jns.id_jenis_usaha = ush.id_jenis_usaha) jenis_usaha"
		);
		$table = "tbl_usaha ush";
		$where = "ush.id_user = '$id_user'";
		$by = 'ush.id_usaha';
		$order = 'ASC';
		$dataUsaha = $this->MasterData->getWhereDataOrder($select,$table,$where,$by,$order)->result();

		if ($dataUsaha) {
			$result = array(
				'response' => true,
				'data' => $dataUsaha
			);
		} else {
			$result = array(
				'response' => false
			);
		}

		echo json_encode($result);
	}

	public function prosesPengajuan($id='') {
		if ($id != '') {
			$data = array(
				'status' => 'proses',
				'notif' => 0,
				'tgl_update_status' => date('Y-m-d H:i:s')
			);
			$where = "id_daftar = $id";
			$update = $this->MasterData->editData($where,$data,'tbl_pendaftaran');

			if ($update) {
				$where = "id_user = (SELECT ush.id_user FROM tbl_usaha ush WHERE ush.id_usaha = (SELECT dft.id_usaha FROM tbl_pendaftaran dft WHERE dft.id_daftar = $id))";
				$noTelp = $this->MasterData->getWhereData('*','tbl_user',$where)->row()->no_hp;
				if ($noTelp == null) {
					$noTelp = '0';
				}

				$where = "id_daftar = $id";
				$no_order = $this->MasterData->getWhereData('*','tbl_pendaftaran',$where)->row()->no_order;

				$pesan = "Status pengajuan tera/tera ulang Anda dengan nomor order ".$no_order." saat ini sudah diPROSES oleh Admin";

		        $cekID = $this->sms->query("SHOW TABLE STATUS LIKE 'outbox'")->row();
		        $newID = $cekID->Auto_increment;

		        $data = array(
		            'DestinationNumber' => $noTelp,
		            'TextDecoded' => $pesan,
		            'ID' => $newID,
		            'MultiPart' => 'false',
		            'CreatorID' => 'SiMetro'
		        );

		        $table = 'outbox';
		        $input_msg = $this->MasterData->sendMsg($data,$table);

				redirect(base_url().'Petugas/dataTera');
			}
		}
	}

	public function inputHasilPengujian($source='', $id='') {
		if ($id != '') {
			$id_daftar = decode($id);
		} else {
			$id_daftar = 1;
		}
		
		$select = '*';
		$table = 'tbl_pendaftaran dft';
		$where = "dft.id_daftar = $id_daftar";
		$dataPendaftaran = $this->MasterData->getWhereData($select,$table,$where)->row();
		

		$xxx =  $dataPendaftaran->layanan.'_'.$dataPendaftaran->tempat;
		$col_tarif = str_replace(' ', '_', $xxx);
		$select = array(
			'list.*',
			"(SELECT jns.nama_jenis_alat FROM tbl_jenis_alat_ukur jns WHERE jns.id_jenis_alat = (SELECT uttp.id_jenis_alat FROM tbl_uttp uttp WHERE uttp.id_uttp = list.id_uttp)) jenis_alat",
			"(SELECT trf.jenis_tarif FROM tbl_tarif trf WHERE trf.id_tarif = list.id_tarif) jenis_tarif",
			"(SELECT trf.satuan FROM tbl_tarif trf WHERE trf.id_tarif = list.id_tarif) satuan",
			"(SELECT trf.$col_tarif FROM tbl_tarif trf WHERE trf.id_tarif = list.id_tarif) tarif",
			"(SELECT COUNT(tera.id_tera) FROM tbl_tera tera WHERE tera.id_list = list.id_list) hasil_tera"
		);	
		$table = 'tbl_list_tera list';
		$where = "list.id_daftar = $id_daftar";
		$by = 'list.id_list';
		$order = 'ASC';
		$listUttp = $this->MasterData->getWhereDataOrder($select,$table,$where,$by,$order)->result();


		$this->head[] = "assets/assets/plugins/select2/dist/css/select2.css";
		$this->head[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.css";
		$this->head[] = "assets/assets/plugins/sweetalert/sweetalert.css";
		$this->head[] = "assets/assets/plugins/dropify/dist/css/dropify.min.css";
		// $this->head[] = "assets/assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css";
		$this->head[] = "assets/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css";
		$this->head[] = "assets/main/vendor/jquery-ui/jquery-ui.min.css";

		$this->foot[] = "assets/assets/plugins/select2/dist/js/select2.full.min.js";
		$this->foot[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/sweetalert.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/jquery.sweet-alert.custom.js";
		$this->foot[] = "assets/assets/plugins/datatables/jquery.dataTables.min.js";
		$this->foot[] = "assets/assets/plugins/dropify/dist/js/dropify.min.js";
		$this->foot[] = "assets/main/vendor/jquery-ui/jquery-ui.min.js";
		// $this->foot[] = "assets/assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js";
		$this->foot[] = "assets/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js";

		$script = array(
			"$('#myTable').DataTable();",
			"$('.select2').select2();",
			"$('.mydatepicker').datepicker({ format: 'dd-mm-yyyy', autoclose:true });",
			"$('.autocomplete').autocomplete({
                source: '".base_url().'Petugas/getDataPetugas'."',
      			response: function (event, ui) {
		            var len = ui.content.length;
		            if (len == 0) {
		            	$('#modal-selesai #counter_found').html('Data petugas tidak ditemukan');
		            	$('#modal-selesai #simpanHasilUji #id_petugas').val('');

		            	$('#modal-edit #counter_found').html('Data petugas tidak ditemukan');
		            	$('#modal-edit #updateHasilUji #id_petugas').val('');
		            } else {
		            	$('#modal-selesai #counter_found').html('');
		            	$('#modal-edit #counter_found').html('');
		            }
		            
		        },
                select: function (event, ui) {
                	$('#modal-selesai #simpanHasilUji #id_petugas').val(ui.item.id);
                	$('#modal-edit #updateHasilUji #id_petugas').val(ui.item.id);
                }
            });"
		);


		$css_link = array(
			"https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/css/lightbox.min.css"
		);

		$js_link = array(
			"https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/js/lightbox.min.js"
		);

		$head = array (
			'head' => $this->head,
			'css_link' => $css_link
		);
		$foot = array(
			'foot' =>  $this->foot,
			'script' => $script,
			'js_link' => $js_link
		);

		if ($source == 'pengajuanMasuk') {
			$nav['menu'] = 'pengajuan_tera';
		} else {
			$nav['menu'] = 'tera';
		}

		$data = array(
			// 'dataUsaha' => $dataUsaha,
			'listUttp' => $listUttp,
			'dataPendaftaran' => $dataPendaftaran,
			'id_daftar' => $id_daftar,
			'source' => $source
			// 'dataUser' => $dataUser
		);

		$this->load->view('Petugas/head',$head);
		$this->load->view('Petugas/navigation',$nav);
		$this->load->view('Petugas/input_hasil_pengujian',$data);
		$this->load->view('foot',$foot);
	}

	public function getDataAlat($value='') {
		$id_uttp = $this->input->POST('id_uttp');

		$select = array(
			'uttp.*',
			"(SELECT alat.nama_jenis_alat FROM tbl_jenis_alat_ukur alat WHERE alat.id_jenis_alat = uttp.id_jenis_alat) jenis_alat"
		);
		$table = 'tbl_uttp uttp';
		$where = "id_uttp = $id_uttp";
		$dataUttp = $this->MasterData->getWhereData($select,$table,$where)->row();

		if ($dataUttp) {
			$result = array(
				'response' => true,
				'data' => $dataUttp
			);
		} else {
			$result = array(
				'response' => false
			);
		}

		echo json_encode($result);
	}

	public function getDataTeraAlat($value='') {
		$id_uttp = $this->input->POST('id_uttp');
		$id_list = $this->input->POST('id_list');

		$select = array(
			'uttp.*',
			"(SELECT alat.nama_jenis_alat FROM tbl_jenis_alat_ukur alat WHERE alat.id_jenis_alat = uttp.id_jenis_alat) jenis_alat"
		);
		$table = 'tbl_uttp uttp';
		$where = "id_uttp = $id_uttp";
		$dataUttp = $this->MasterData->getWhereData($select,$table,$where)->row();

		$select = array(
			'tera.*',
			"(SELECT usr.nama_user FROM tbl_user usr WHERE usr.id_user = (SELECT pt.id_user FROM tbl_petugas pt WHERE pt.id_petugas = tera.id_petugas)) nama_user",
			"(SELECT pt.nip FROM tbl_petugas pt WHERE pt.id_petugas = tera.id_petugas) nip"
		);
		$table = 'tbl_tera tera';
		$where = "tera.id_list = $id_list";
		$dataTera = $this->MasterData->getWhereData($select,$table,$where)->row();

		if ($dataUttp && $dataTera) {
			$result = array(
				'response' => true,
				'data' => $dataUttp,
				'dataTera' => $dataTera
			);
		} else {
			$result = array(
				'response' => false
			);
		}

		echo json_encode($result);
	}

	public function simpanHasilUji($source='', $id='') {
		$input = $this->input->POST();
		$id_daftar = $input['id_daftar'];

		if ($input) {

			$data = array(
				'nomor_tera' => $input['nomor_tera'],
				'id_list' => $input['id_list'],
				'id_petugas' => $input['id_petugas'],
				'tgl_tera' => date('Y-m-d', strtotime($input['tgl_tera'])),
				'tgl_berlaku' => date('Y-m-d', strtotime($input['tgl_tera_ulang'])),
				'metode' => $input['metode'],
				'standar' => $input['standar'],
				'hasil_tera' => $input['hasil'],

			);

			if ($this->input->POST('atribut')) {
				$opsi = array();
				for ($i=0; $i < count($input['atribut']) ; $i++) { 
					$opsi[] = array(
						'atribut' => $input['atribut'][$i],
						'value' => $input['value'][$i]
					);
				}
				$data['opsi_alat'] = json_encode($opsi);
			}

			$inputTera = $this->MasterData->inputData($data,'tbl_tera');

			if ($inputTera) {
				$data = array(
					'tgl_tera_ulang' => date('Y-m-d', strtotime($input['tgl_tera_ulang'])),
					'tgl_tera_terakhir' => date('Y-m-d', strtotime($input['tgl_tera']))
				);
				$where = "id_uttp = (SELECT list.id_uttp FROM tbl_list_tera list WHERE list.id_list = $input[id_list])";
				$updateUttp = $this->MasterData->editData($where,$data,'tbl_uttp');

				if ($updateUttp) {
					$sess['alert'] = alert_success('Data hasil pengujian berhasil disimpan.');
					$this->session->set_flashdata($sess);
					redirect(base_url().'Petugas/inputHasilPengujian/'.$source.'/'.encode($id_daftar));
				} else {
					$sess['alert'] = alert_failed('Data  hasil pengujian gagal disimpan.');
					$this->session->set_flashdata($sess);
					redirect(base_url().'Petugas/inputHasilPengujian/'.$source.'/'.encode($id_daftar));
				}
			} else {
				$sess['alert'] = alert_failed('Data  hasil pengujian gagal disimpan.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Petugas/inputHasilPengujian/'.$source.'/'.encode($id_daftar));
			}
		} else {
			$sess['alert'] = alert_failed('Data  hasil pengujian gagal disimpan.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Petugas/inputHasilPengujian/'.$source.'/'.encode($id_daftar));
		}
	}

	public function updateHasilUji($source='', $value='') {
		$input = $this->input->POST();
		$id_daftar = $input['id_daftar'];

		if ($input) {

			$data = array(
				'nomor_tera' => $input['nomor_tera'],
				'id_list' => $input['id_list'],
				'id_petugas' => $input['id_petugas'],
				'tgl_tera' => date('Y-m-d', strtotime($input['tgl_tera'])),
				'tgl_berlaku' => date('Y-m-d', strtotime($input['tgl_tera_ulang'])),
				'metode' => $input['metode'],
				'standar' => $input['standar'],
				'hasil_tera' => $input['hasil'],

			);

			if ($this->input->POST('atribut')) {
				$opsi = array();
				for ($i=0; $i < count($input['atribut']) ; $i++) { 
					$opsi[] = array(
						'atribut' => $input['atribut'][$i],
						'value' => $input['value'][$i]
					);
				}
				$data['opsi_alat'] = json_encode($opsi);
			} else {
				$data['opsi_alat'] = null;
			}

			$where = "id_tera = $input[id_tera]";
			$updateTera = $this->MasterData->editData($where,$data,'tbl_tera');

			if ($updateTera) {
				$data = array(
					'tgl_tera_ulang' => date('Y-m-d', strtotime($input['tgl_tera_ulang'])),
					'tgl_tera_terakhir' => date('Y-m-d', strtotime($input['tgl_tera']))
				);
				$where = "id_uttp = (SELECT list.id_uttp FROM tbl_list_tera list WHERE list.id_list = $input[id_list])";
				$updateUttp = $this->MasterData->editData($where,$data,'tbl_uttp');

				if ($updateUttp) {
					$sess['alert'] = alert_success('Data hasil pengujian berhasil diupdate.');
					$this->session->set_flashdata($sess);
					redirect(base_url().'Petugas/inputHasilPengujian/'.$source.'/'.encode($id_daftar));
				} else {
					$sess['alert'] = alert_failed('Data  hasil pengujian gagal diupdate.');
					$this->session->set_flashdata($sess);
					redirect(base_url().'Petugas/inputHasilPengujian/'.$source.'/'.encode($id_daftar));
				}
			} else {
				$sess['alert'] = alert_failed('Data  hasil pengujian gagal diupdate.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Petugas/inputHasilPengujian/'.$source.'/'.encode($id_daftar));
			}
		} else {
			$sess['alert'] = alert_failed('Data  hasil pengujian gagal diupdate.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Petugas/inputHasilPengujian/'.$source.'/'.encode($id_daftar));
		}
	}

	public function selesaiPengajuan($source='', $id='') {
		if ($id != '') {
			$data = array(
				'status' => 'selesai',
				'notif' => 0,
				'tgl_update_status' => date('Y-m-d H:i:s')
			);
			$where = "id_daftar = $id";
			$update = $this->MasterData->editData($where,$data,'tbl_pendaftaran');

			if ($update) {
				$where = "id_user = (SELECT ush.id_user FROM tbl_usaha ush WHERE ush.id_usaha = (SELECT dft.id_usaha FROM tbl_pendaftaran dft WHERE dft.id_daftar = $id))";
				$noTelp = $this->MasterData->getWhereData('*','tbl_user',$where)->row()->no_hp;
				if ($noTelp == null) {
					$noTelp = '0';
				}

				$where = "id_daftar = $id";
				$no_order = $this->MasterData->getWhereData('*','tbl_pendaftaran',$where)->row()->no_order;

				$pesan = "Status pengajuan tera/tera ulang Anda dengan nomor order ".$no_order." saat ini sudah SELESAI";

		        $cekID = $this->sms->query("SHOW TABLE STATUS LIKE 'outbox'")->row();
		        $newID = $cekID->Auto_increment;

		        $data = array(
		            'DestinationNumber' => $noTelp,
		            'TextDecoded' => $pesan,
		            'ID' => $newID,
		            'MultiPart' => 'false',
		            'CreatorID' => 'SiMetro'
		        );

		        $table = 'outbox';
		        $input_msg = $this->MasterData->sendMsg($data,$table);

				redirect(base_url().'Petugas/'.$source);
			}
		}
	}

	public function inputTglInspeksiTera($value='') {
		$input = $this->input->POST();

		$data = array(
			'tgl_inspeksi' => date('Y-m-d', strtotime($input['tgl_inspeksi'])),
			'status' => 'proses',
			'notif' => 0,
			'tgl_update_status' => date('Y-m-d H:i:s')
		);
		$where = "id_daftar = $input[id_daftar]";
		$update = $this->MasterData->editData($where,$data,'tbl_pendaftaran');

		if ($update) {
			$where = "id_user = (SELECT ush.id_user FROM tbl_usaha ush WHERE ush.id_usaha = (SELECT dft.id_usaha FROM tbl_pendaftaran dft WHERE dft.id_daftar = $input[id_daftar]))";
			$noTelp = $this->MasterData->getWhereData('*','tbl_user',$where)->row()->no_hp;
			if ($noTelp == null) {
				$noTelp = '0';
			}

			$where = "id_daftar = $input[id_daftar]";
			$no_order = $this->MasterData->getWhereData('*','tbl_pendaftaran',$where)->row()->no_order;

			$pesan = "Status pengajuan tera/tera ulang Anda dengan nomor order ".$no_order." saat ini sudah diPROSES oleh Admin";

	        $cekID = $this->sms->query("SHOW TABLE STATUS LIKE 'outbox'")->row();
	        $newID = $cekID->Auto_increment;

	        $data = array(
	            'DestinationNumber' => $noTelp,
	            'TextDecoded' => $pesan,
	            'ID' => $newID,
	            'MultiPart' => 'false',
	            'CreatorID' => 'SiMetro'
	        );

	        $table = 'outbox';
	        $input_msg = $this->MasterData->sendMsg($data,$table);
		
			$sess['alert'] = alert_success('Tanggal inspeksi berhasil disimpan. Mohon pengajuan segera diproses!');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Petugas/dataTera');
		} else {
			$sess['alert'] = alert_failed('Tanggal inspeksi gagal disimpan.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Petugas/dataTera');
		}
	}

	public function showKetTolak($value='') {
		$id_daftar = $this->input->POST('id_daftar');

		if ($id_daftar) {
			$where = "id_daftar = $id_daftar";
			$data = $this->MasterData->getDataWhere('tbl_tolak_pendaftaran',$where)->row();

			if ($data) {
				$result = array(
					'response' => true,
					'data' => $data
				);
			} else {
				$result = array(
					'response' => false
				);
			}

		} else {
			$result = array(
				'response' => false
			);
		}

		echo json_encode($result);
	}

	// =====================================================

	public function pengajuanMasuk($id=0){
		// $id_user = $this->id_user;
		$select = array(
			'dft.*',
			"(SELECT jns.nama_jenis_usaha FROM tbl_jenis_usaha jns WHERE jns.id_jenis_usaha IN (SELECT ush.id_jenis_usaha FROM tbl_usaha ush WHERE ush.id_usaha = dft.id_usaha)) jenis_usaha",
			"(SELECT usr.nama_user FROM tbl_user usr WHERE usr.id_user = (SELECT ush.id_user FROM tbl_usaha ush WHERE ush.id_usaha = dft.id_usaha)) nama_user",
			"(SELECT tmp.tempat_tera FROM tbl_tempat_tera tmp WHERE tmp.id_tempat_tera = dft.id_tempat_tera) tempat_tera"
		);
		$table = "tbl_pendaftaran dft";
		$where = "user_daftar = 'user' AND status != 'belum kirim'";
		$by = 'dft.tgl_kirim';
		$order = 'DESC';
		$dataTera = $this->MasterData->getWhereDataOrder($select,$table,$where,$by,$order)->result();
		// $statusJl = $this->MasterData->getData('tbl_status_jalan')->result();

		$this->head[] = "assets/assets/plugins/select2/dist/css/select2.css";
		$this->head[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.css";
		$this->head[] = "assets/assets/plugins/sweetalert/sweetalert.css";
		$this->head[] = "assets/assets/plugins/dropify/dist/css/dropify.min.css";
		$this->head[] = "assets/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css";

		$this->foot[] = "assets/assets/plugins/select2/dist/js/select2.full.min.js";
		$this->foot[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/sweetalert.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/jquery.sweet-alert.custom.js";
		$this->foot[] = "assets/assets/plugins/datatables/jquery.dataTables.min.js";
		$this->foot[] = "assets/assets/plugins/dropify/dist/js/dropify.min.js";
		$this->foot[] = "assets/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js";

		$script = array(
			// "$('#myTable').DataTable();",
			"$('.select2').select2();",
			"$(document).ready( function () {
				var table = $('#myTable').DataTable();
				    	
		        var row = table.row(function ( idx, data, node ) {
			        return data[11] === '".$id."';
			    });
		      	if (row.length > 0) {
			        row.select()
			        .show()
			        .draw(false);
		      	}
	      	});",
			// "$('.dropify').dropify({
			// 	 messages: {
	  //               default: '<center>Upload foto/gambar disini.</center>',
	  //               error: '<center>Maksimal ukuran file 2 MB.</center>',
	  //           }
			// });",
			"$('.mydatepicker').datepicker({ format: 'dd-mm-yyyy', autoclose:true });",
			// "lightbox.option({
	  //           'albumLabel':   'picture %1 of %2',
	  //           'fadeDuration': 300,
	  //           'resizeDuration': 150,
	  //           'wrapAround': true
	  //       })"
		);


		$css_link = array(
			"https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/css/lightbox.min.css"
		);

		$js_link = array(
			// "https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/js/lightbox.min.js",
			"https://cdn.datatables.net/v/dt/dt-1.10.16/sl-1.2.4/datatables.min.js",
			"https://cdn.datatables.net/plug-ins/1.10.13/api/row().show().js"
		);

		$head = array (
			'head' => $this->head,
			// 'css_link' => $css_link
		);
		$foot = array(
			'foot' =>  $this->foot,
			'script' => $script,
			'js_link' => $js_link
		);

		$nav['menu'] = 'pengajuan_tera';

		$data = array(
			'dataTera' => $dataTera,
			'idRow' => $id
		);

		$this->load->view('Petugas/head',$head);
		$this->load->view('Petugas/navigation',$nav);
		$this->load->view('Petugas/pengajuan_masuk',$data);
		$this->load->view('foot',$foot);
	}

	public function showTerimaPengajuan($id='') {
		// $id_user = $this->id_user;

		if ($id != '') {
			$id_daftar = decode($id);
		} else {
			$id_daftar = 1;
		}
		
		$select = '*';
		$table = 'tbl_pendaftaran dft';
		$where = "dft.id_daftar = $id_daftar";
		$dataPendaftaran = $this->MasterData->getWhereData($select,$table,$where)->row();

		$id_usaha = $dataPendaftaran->id_usaha;
		$select = array(
			'ush.id_usaha',
			'ush.nama_usaha',
			"(SELECT jns.nama_jenis_usaha FROM tbl_jenis_usaha jns WHERE jns.id_jenis_usaha = ush.id_jenis_usaha) jenis_usaha"
		);
		$table = "tbl_usaha ush";
		$where = "ush.id_user = (SELECT usaha.id_user FROM tbl_usaha usaha WHERE usaha.id_usaha = $id_usaha)";
		$by = 'ush.id_usaha';
		$order = 'ASC';
		$dataUsaha = $this->MasterData->getWhereDataOrder($select,$table,$where,$by,$order)->result();

		$select = '*';
		$table = 'tbl_user usr';
		$where = "usr.id_user = (SELECT usaha.id_user FROM tbl_usaha usaha WHERE usaha.id_usaha = $id_usaha)";
		$dataUser = $this->MasterData->getWhereData($select,$table,$where)->row();

		$xxx =  $dataPendaftaran->layanan.'_'.$dataPendaftaran->tempat;
		$col_tarif = str_replace(' ', '_', $xxx);
		$select = array(
			'list.*',
			"(SELECT jns.nama_jenis_alat FROM tbl_jenis_alat_ukur jns WHERE jns.id_jenis_alat = (SELECT uttp.id_jenis_alat FROM tbl_uttp uttp WHERE uttp.id_uttp = list.id_uttp)) jenis_alat",
			"(SELECT trf.jenis_tarif FROM tbl_tarif trf WHERE trf.id_tarif = (SELECT uttp.id_tarif FROM tbl_uttp uttp WHERE uttp.id_uttp = list.id_uttp)) jenis_tarif",
			"(SELECT trf.satuan FROM tbl_tarif trf WHERE trf.id_tarif = (SELECT uttp.id_tarif FROM tbl_uttp uttp WHERE uttp.id_uttp = list.id_uttp)) satuan",
			"(SELECT trf.$col_tarif FROM tbl_tarif trf WHERE trf.id_tarif = (SELECT uttp.id_tarif FROM tbl_uttp uttp WHERE uttp.id_uttp = list.id_uttp)) tarif",
			"(SELECT uttp.id_jenis_alat FROM tbl_uttp uttp WHERE uttp.id_uttp = list.id_uttp) id_jenis_alat",
			"(SELECT uttp.kapasitas FROM tbl_uttp uttp WHERE uttp.id_uttp = list.id_uttp) kapasitas",
			"(SELECT uttp.id_tarif FROM tbl_uttp uttp WHERE uttp.id_uttp = list.id_uttp) id_tarifx"
		);	
		$table = 'tbl_list_tera list';
		$where = "list.id_daftar = $id_daftar";
		$by = 'list.id_list';
		$order = 'ASC';
		$listUttp = $this->MasterData->getWhereDataOrder($select,$table,$where,$by,$order)->result();

		$tempat_tera = $this->MasterData->getData('tbl_tempat_tera')->result();

		// $arr = array(
		// 	'jenis_alat' => $data_uttp->jenis_alat,
		// 	'jenis_tarif' => $data_tarif->jenis_tarif,
		// 	'satuan' => $data_tarif->satuan,
		// 	'layanan' => $layanan,
		// 	'tempat' => $tempat,
		// 	'jumlah' => $jml_uttp[$i],
		// 	'tarif' => $tarif,
		// 	'tot_tarif' => $tot_tarif
		// );


		$this->head[] = "assets/assets/plugins/select2/dist/css/select2.css";
		$this->head[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.css";
		$this->head[] = "assets/assets/plugins/sweetalert/sweetalert.css";
		$this->head[] = "assets/assets/plugins/dropify/dist/css/dropify.min.css";

		$this->foot[] = "assets/assets/plugins/select2/dist/js/select2.full.min.js";
		$this->foot[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/sweetalert.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/jquery.sweet-alert.custom.js";
		$this->foot[] = "assets/assets/plugins/datatables/jquery.dataTables.min.js";
		$this->foot[] = "assets/assets/plugins/dropify/dist/js/dropify.min.js";

		$script = array(
			"$('#myTable').DataTable();",
			"$('.select2').select2();"
		);


		$css_link = array(
			"https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/css/lightbox.min.css"
		);

		$js_link = array(
			"https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/js/lightbox.min.js"
		);

		$head = array (
			'head' => $this->head,
			'css_link' => $css_link
		);
		$foot = array(
			'foot' =>  $this->foot,
			'script' => $script,
			'js_link' => $js_link
		);

		$nav['menu'] = 'pengajuan_tera';

		$data = array(
			'tempat_tera' => $tempat_tera,
			'dataUsaha' => $dataUsaha,
			'listUttp' => $listUttp,
			'dataPendaftaran' => $dataPendaftaran,
			'dataUser' => $dataUser
		);

		$this->load->view('Petugas/head',$head);
		$this->load->view('Petugas/navigation',$nav);
		$this->load->view('Petugas/terima_pengajuan',$data);
		$this->load->view('foot',$foot);
	}

	public function terimaPengajuanMasuk($id='', $id_tarif='', $id_list='') {
		if ($id != '') {

			$id_trf = explode('-', $id_tarif);
			$id_lst = explode('-', $id_list);
			for ($i=0; $i < count($id_trf); $i++) { 
				$data = array(
					'id_tarif' => $id_trf[$i]
				);
				$where = "id_list = $id_lst[$i]";
				$update_list = $this->MasterData->editData($where,$data,'tbl_list_tera');
			}

			$data = array(
				'status' => 'diterima',
				'notif' => 0,
				'tgl_update_status' => date('Y-m-d H:i:s')
			);
			$where = "id_daftar = $id";
			$update = $this->MasterData->editData($where,$data,'tbl_pendaftaran');

			if ($update) {
				$where = "id_user = (SELECT ush.id_user FROM tbl_usaha ush WHERE ush.id_usaha = (SELECT dft.id_usaha FROM tbl_pendaftaran dft WHERE dft.id_daftar = $id))";
				$noTelp = $this->MasterData->getWhereData('*','tbl_user',$where)->row()->no_hp;
				if ($noTelp == null) {
					$noTelp = '0';
				}

				$where = "id_daftar = $id";
				$no_order = $this->MasterData->getWhereData('*','tbl_pendaftaran',$where)->row()->no_order;

				$pesan = "Status pengajuan tera/tera ulang Anda dengan nomor order ".$no_order." saat ini sudah diTERIMA oleh Admin";

		        $cekID = $this->sms->query("SHOW TABLE STATUS LIKE 'outbox'")->row();
		        $newID = $cekID->Auto_increment;

		        $data = array(
		            'DestinationNumber' => $noTelp,
		            'TextDecoded' => $pesan,
		            'ID' => $newID,
		            'MultiPart' => 'false',
		            'CreatorID' => 'SiMetro'
		        );

		        $table = 'outbox';
		        $input_msg = $this->MasterData->sendMsg($data,$table);
			}
			redirect(base_url().'Petugas/pengajuanMasuk');
		}
	}

	public function prosesPengajuanMasuk($id='') {
		if ($id != '') {
			$data = array(
				'status' => 'proses',
				'notif' => 0,
				'tgl_update_status' => date('Y-m-d H:i:s')
			);
			$where = "id_daftar = $id";
			$update = $this->MasterData->editData($where,$data,'tbl_pendaftaran');

			if ($update) {
				$where = "id_user = (SELECT ush.id_user FROM tbl_usaha ush WHERE ush.id_usaha = (SELECT dft.id_usaha FROM tbl_pendaftaran dft WHERE dft.id_daftar = $id))";
				$noTelp = $this->MasterData->getWhereData('*','tbl_user',$where)->row()->no_hp;
				if ($noTelp == null) {
					$noTelp = '0';
				}

				$where = "id_daftar = $id";
				$no_order = $this->MasterData->getWhereData('*','tbl_pendaftaran',$where)->row()->no_order;

				$pesan = "Status pengajuan tera/tera ulang Anda dengan nomor order ".$no_order." saat ini sudah diPROSES oleh Admin";

		        $cekID = $this->sms->query("SHOW TABLE STATUS LIKE 'outbox'")->row();
		        $newID = $cekID->Auto_increment;

		        $data = array(
		            'DestinationNumber' => $noTelp,
		            'TextDecoded' => $pesan,
		            'ID' => $newID,
		            'MultiPart' => 'false',
		            'CreatorID' => 'SiMetro'
		        );

		        $table = 'outbox';
		        $input_msg = $this->MasterData->sendMsg($data,$table);
			}
			redirect(base_url().'Petugas/pengajuanMasuk');
		}
	}

	public function inputTglInspeksi($value='') {
		$input = $this->input->POST();

		$data = array(
			'tgl_inspeksi' => date('Y-m-d', strtotime($input['tgl_inspeksi'])),
			'status' => 'proses',
			'notif' => 0,
			'tgl_update_status' => date('Y-m-d H:i:s')
		);
		$where = "id_daftar = $input[id_daftar]";
		$update = $this->MasterData->editData($where,$data,'tbl_pendaftaran');

		if ($update) {
			$where = "id_user = (SELECT ush.id_user FROM tbl_usaha ush WHERE ush.id_usaha = (SELECT dft.id_usaha FROM tbl_pendaftaran dft WHERE dft.id_daftar = $input[id_daftar]))";
			$noTelp = $this->MasterData->getWhereData('*','tbl_user',$where)->row()->no_hp;
			if ($noTelp == null) {
				$noTelp = '0';
			}

			$where = "id_daftar = $input[id_daftar]";
			$no_order = $this->MasterData->getWhereData('*','tbl_pendaftaran',$where)->row()->no_order;

			$pesan = "Status pengajuan tera/tera ulang Anda dengan nomor order ".$no_order." saat ini sudah diPROSES oleh Admin";

	        $cekID = $this->sms->query("SHOW TABLE STATUS LIKE 'outbox'")->row();
	        $newID = $cekID->Auto_increment;

	        $data = array(
	            'DestinationNumber' => $noTelp,
	            'TextDecoded' => $pesan,
	            'ID' => $newID,
	            'MultiPart' => 'false',
	            'CreatorID' => 'SiMetro'
	        );

	        $table = 'outbox';
	        $input_msg = $this->MasterData->sendMsg($data,$table);
		
			$sess['alert'] = alert_success('Tanggal inspeksi berhasil disimpan. Mohon pengajuan segera diproses!');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Petugas/pengajuanMasuk');
		} else {
			$sess['alert'] = alert_failed('Tanggal inspeksi gagal disimpan.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Petugas/pengajuanMasuk');
		}
	}

	public function tolakPengajuan($value='') {
		$input = $this->input->POST();

		if ($input) {
			$simpan = $this->MasterData->inputData($input,'tbl_tolak_pendaftaran');

			if ($simpan) {
				$data = array(
					'status' => 'ditolak',
					'notif' => 0,
					'tgl_update_status' => date('Y-m-d H:i:s')
				);
				$where = "id_daftar = $input[id_daftar]";
				$update = $this->MasterData->editData($where,$data,'tbl_pendaftaran');

				if ($update) {
					$where = "id_user = (SELECT ush.id_user FROM tbl_usaha ush WHERE ush.id_usaha = (SELECT dft.id_usaha FROM tbl_pendaftaran dft WHERE dft.id_daftar = $input[id_daftar]))";
					$noTelp = $this->MasterData->getWhereData('*','tbl_user',$where)->row()->no_hp;
					if ($noTelp == null) {
						$noTelp = '0';
					}

					$where = "id_daftar = $input[id_daftar]";
					$no_order = $this->MasterData->getWhereData('*','tbl_pendaftaran',$where)->row()->no_order;

					$pesan = "Status pengajuan tera/tera ulang Anda dengan nomor order ".$no_order." diTOLAK oleh Admin";

			        $cekID = $this->sms->query("SHOW TABLE STATUS LIKE 'outbox'")->row();
			        $newID = $cekID->Auto_increment;

			        $data = array(
			            'DestinationNumber' => $noTelp,
			            'TextDecoded' => $pesan,
			            'ID' => $newID,
			            'MultiPart' => 'false',
			            'CreatorID' => 'SiMetro'
			        );

			        $table = 'outbox';
			        $input_msg = $this->MasterData->sendMsg($data,$table);

					redirect(base_url().'Petugas/pengajuanMasuk');
				}
			}
		}
	}

	public function getDetailPengajuan($value='') {
		$id = $this->input->POST('id_daftar');

		if ($id) {

			$select = array(
				'list.*',
				"(SELECT jns.nama_jenis_alat FROM tbl_jenis_alat_ukur jns WHERE jns.id_jenis_alat = (SELECT uttp.id_jenis_alat FROM tbl_uttp uttp WHERE uttp.id_uttp = list.id_uttp)) jenis_alat",
				"(SELECT ktg.nama_kategori_alat FROM tbl_kategori_alat_ukur ktg WHERE ktg.id_kategori_alat = (SELECT jns.id_kategori_alat FROM tbl_jenis_alat_ukur jns WHERE jns.id_jenis_alat = (SELECT uttp.id_jenis_alat FROM tbl_uttp uttp WHERE uttp.id_uttp = list.id_uttp))) kategori_alat",
				"(SELECT uttp.kapasitas FROM tbl_uttp uttp WHERE uttp.id_uttp = list.id_uttp) kapasitas"
			);
			$table = 'tbl_list_tera list';
			$where = "id_daftar = $id";
			$listUttp = $this->MasterData->getWhereData($select,$table,$where)->result();

			if ($listUttp) {
				$result = array(
					'response' => true,
					'listUttp' =>  $listUttp
				);
			} else {
				$result = array(
					'response' => false
				);
			}
		} else {
			$result = array(
				'response' => false
			);
		}

		echo json_encode($result);
	}

	public function setTarifUttp($value='') {
		$post = $this->input->POST();

		if ($post) {
			$id_daftar = $post['id_daftar'];

			$data = array(
				'id_tarif' => $post['id_tarif'][0]
			);
			$where = "id_uttp = $post[id_uttp]";
			$update_uttp = $this->MasterData->editData($where,$data,'tbl_uttp');

			if ($update_uttp) {
				// $where = "id_list = $post[id_list]";
				// $update_list = $this->MasterData->editData($where,$data,'tbl_list_tera');

				// if ($update_list) {
					$sess['alert'] = alert_success('Data tarif berhasil disimpan.');
					$this->session->set_flashdata($sess);
					redirect(base_url().'Petugas/showTerimaPengajuan/'.encode($id_daftar));
				// } else {
				// 	$sess['alert'] = alert_failed('Data tarif gagal diupdate.');
				// 	$this->session->set_flashdata($sess);
				// 	redirect(base_url().'Petugas/showTerimaPengajuan/'.encode($id_daftar));
				// }
			} else {
				$sess['alert'] = alert_failed('Data tarif gagal diupdate.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Petugas/showTerimaPengajuan/'.encode($id_daftar));
			}
		} else {
			$sess['alert'] = alert_failed('Data tarif gagal diupdate.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Petugas/showTerimaPengajuan/'.encode($id_daftar));
		}
	}

	// ====================================================

	public function clickNotif($id='') {
		if ($id != '') {
			$data = array(
				'notif_petugas' => 1
			);
			$where = "id_daftar = $id";
			$update = $this->MasterData->editData($where,$data,'tbl_pendaftaran');

			if ($update) {
				redirect(base_url().'Petugas/pengajuanMasuk/'.$id.'/#row_'.$id);
			}
		}
	}

	// =====================================================

	public function hasilPengujian($value='') {
		// $id_user = $this->id_user;
		$select = array(
			'dft.*',
			"(SELECT jns.nama_jenis_usaha FROM tbl_jenis_usaha jns WHERE jns.id_jenis_usaha IN (SELECT ush.id_jenis_usaha FROM tbl_usaha ush WHERE ush.id_usaha = dft.id_usaha)) jenis_usaha",
			"(SELECT usr.nama_user FROM tbl_user usr WHERE usr.id_user = (SELECT ush.id_user FROM tbl_usaha ush WHERE ush.id_usaha = dft.id_usaha)) nama_user",
			"(SELECT COUNT(byr.id_bayar) FROM tbl_pembayaran byr WHERE byr.id_daftar = dft.id_daftar) bayar",
			"(SELECT byr.nominal_bayar FROM tbl_pembayaran byr WHERE byr.id_daftar = dft.id_daftar) nominal_bayar",
		);
		$table = "tbl_pendaftaran dft";
		$where = "status = 'selesai'";
		$by = 'dft.id_daftar';
		$order = 'DESC';
		$dataTera = $this->MasterData->getWhereDataOrder($select,$table,$where,$by,$order)->result();
		// $statusJl = $this->MasterData->getData('tbl_status_jalan')->result();

		$bayar = array();
		foreach ($dataTera as $tera) {	
			$id_daftar = $tera->id_daftar;
			$layanan = $tera->layanan;
			$tempat = $tera->tempat;

			$select = '*';
			$where = "id_daftar = $id_daftar";
			$dataList = $this->MasterData->getWhereData($select,'tbl_list_tera',$where)->result();

			$xxx =  $layanan.'_'.$tempat;
			$col_tarif = str_replace(' ', '_', $xxx);

			$tot_tarif = 0;
			foreach ($dataList as $list) {
				$id_list = $list->id_list;

				$select = array('hasil_tera');
				$where = "id_list = $id_list";
				$hasil = $this->MasterData->getWhereData($select,'tbl_tera',$where)->row()->hasil_tera;

				if ($hasil=='disahkan') {
					$id_tarif = $list->id_tarif;
					$jml_uttp = $list->jumlah_uttp;

					$select = '*';
					$where = "id_tarif = $id_tarif";
					$dataTarif = $this->MasterData->getWhereData($select,'tbl_tarif',$where)->row();

					$tarif = $dataTarif->$col_tarif;	
					$tot_tarif += $tarif * $jml_uttp;
				}
			}

			$bayar[] = array(
				'id_daftar' => $id_daftar,
				'tot_tarif' => $tot_tarif
			);
		}

		$this->head[] = "assets/assets/plugins/select2/dist/css/select2.css";
		$this->head[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.css";
		$this->head[] = "assets/assets/plugins/sweetalert/sweetalert.css";
		$this->head[] = "assets/assets/plugins/dropify/dist/css/dropify.min.css";
		$this->head[] = "assets/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css";

		$this->foot[] = "assets/assets/plugins/select2/dist/js/select2.full.min.js";
		$this->foot[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/sweetalert.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/jquery.sweet-alert.custom.js";
		$this->foot[] = "assets/assets/plugins/datatables/jquery.dataTables.min.js";
		$this->foot[] = "assets/assets/plugins/dropify/dist/js/dropify.min.js";
		$this->foot[] = "assets/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js";

		$script = array(
			"$('#myTable').DataTable();",
			"$('.select2').select2();",
			// "$('.dropify').dropify({
			// 	 messages: {
	  //               default: '<center>Upload foto/gambar disini.</center>',
	  //               error: '<center>Maksimal ukuran file 2 MB.</center>',
	  //           }
			// });",
			"$('.mydatepicker').datepicker({ format: 'dd-mm-yyyy', autoclose:true });",
			// "lightbox.option({
	  //           'albumLabel':   'picture %1 of %2',
	  //           'fadeDuration': 300,
	  //           'resizeDuration': 150,
	  //           'wrapAround': true
	  //       })"
		);


		// $css_link = array(
		// 	"https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/css/lightbox.min.css"
		// );

		// $js_link = array(
		// 	"https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/js/lightbox.min.js"
		// );

		$head = array (
			'head' => $this->head,
			// 'css_link' => $css_link
		);
		$foot = array(
			'foot' =>  $this->foot,
			'script' => $script,
			// 'js_link' => $js_link
		);

		$nav['menu'] = 'hasil_uji';

		$data = array(
			'dataTera' => $dataTera,
			'bayar' => $bayar
		);

		$this->load->view('Petugas/head',$head);
		$this->load->view('Petugas/navigation',$nav);
		$this->load->view('Petugas/hasil_uji',$data);
		$this->load->view('foot',$foot);
	}

	public function cetakHasilPengujian($id='') {
		if ($id != '') {
			$id_daftar = decode($id);
		} else {
			$id_daftar = 1;
		}
		
		$select = '*';
		$table = 'tbl_pendaftaran dft';
		$where = "dft.id_daftar = $id_daftar";
		$dataPendaftaran = $this->MasterData->getWhereData($select,$table,$where)->row();
		

		$xxx =  $dataPendaftaran->layanan.'_'.$dataPendaftaran->tempat;
		$col_tarif = str_replace(' ', '_', $xxx);
		$select = array(
			'list.*',
			"(SELECT jns.nama_jenis_alat FROM tbl_jenis_alat_ukur jns WHERE jns.id_jenis_alat = (SELECT uttp.id_jenis_alat FROM tbl_uttp uttp WHERE uttp.id_uttp = list.id_uttp)) jenis_alat",
			"(SELECT trf.jenis_tarif FROM tbl_tarif trf WHERE trf.id_tarif = list.id_tarif) jenis_tarif",
			"(SELECT trf.satuan FROM tbl_tarif trf WHERE trf.id_tarif = list.id_tarif) satuan",
			"(SELECT trf.$col_tarif FROM tbl_tarif trf WHERE trf.id_tarif = list.id_tarif) tarif",
			"(SELECT tera.hasil_tera FROM tbl_tera tera WHERE tera.id_list = list.id_list) hasil"
			// "(SELECT COUNT(tera.id_tera) FROM tbl_tera tera WHERE tera.id_list = list.id_list) hasil_tera"
		);	
		$table = 'tbl_list_tera list';
		$where = "list.id_daftar = $id_daftar";
		$by = 'list.id_list';
		$order = 'ASC';
		$listUttp = $this->MasterData->getWhereDataOrder($select,$table,$where,$by,$order)->result();


		$this->head[] = "assets/assets/plugins/select2/dist/css/select2.css";
		$this->head[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.css";
		$this->head[] = "assets/assets/plugins/sweetalert/sweetalert.css";
		$this->head[] = "assets/assets/plugins/dropify/dist/css/dropify.min.css";
		// $this->head[] = "assets/assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css";
		$this->head[] = "assets/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css";
		$this->head[] = "assets/main/vendor/jquery-ui/jquery-ui.min.css";

		$this->foot[] = "assets/assets/plugins/select2/dist/js/select2.full.min.js";
		$this->foot[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/sweetalert.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/jquery.sweet-alert.custom.js";
		$this->foot[] = "assets/assets/plugins/datatables/jquery.dataTables.min.js";
		$this->foot[] = "assets/assets/plugins/dropify/dist/js/dropify.min.js";
		$this->foot[] = "assets/main/vendor/jquery-ui/jquery-ui.min.js";
		// $this->foot[] = "assets/assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js";
		$this->foot[] = "assets/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js";

		$script = array(
			"$('#myTable').DataTable();",
			"$('.select2').select2();",
			"$('.mydatepicker').datepicker({ format: 'dd-mm-yyyy', autoclose:true });",
			"$('.autocomplete').autocomplete({
                source: '".base_url().'Petugas/getDataPetugas'."',
      			response: function (event, ui) {
		            var len = ui.content.length;
		            if (len == 0) {
		            	$('#modal-selesai #counter_found').html('Data petugas tidak ditemukan');
		            	$('#modal-selesai #simpanHasilUji #id_petugas').val('');

		            	$('#modal-edit #counter_found').html('Data petugas tidak ditemukan');
		            	$('#modal-edit #updateHasilUji #id_petugas').val('');
		            } else {
		            	$('#modal-selesai #counter_found').html('');
		            	$('#modal-edit #counter_found').html('');
		            }
		            
		        },
                select: function (event, ui) {
                	$('#modal-selesai #simpanHasilUji #id_petugas').val(ui.item.id);
                	$('#modal-edit #updateHasilUji #id_petugas').val(ui.item.id);
                }
            });"
		);


		$css_link = array(
			"https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/css/lightbox.min.css"
		);

		$js_link = array(
			"https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/js/lightbox.min.js"
		);

		$head = array (
			'head' => $this->head,
			'css_link' => $css_link
		);
		$foot = array(
			'foot' =>  $this->foot,
			'script' => $script,
			'js_link' => $js_link
		);

		$nav['menu'] = 'hasil_uji';
		
		$data = array(
			'listUttp' => $listUttp,
			'dataPendaftaran' => $dataPendaftaran,
			'id_daftar' => $id_daftar,
			// 'dataUser' => $dataUser
		);

		$this->load->view('Petugas/head',$head);
		$this->load->view('Petugas/navigation',$nav);
		$this->load->view('Petugas/cetak_hasil_uji',$data);
		$this->load->view('foot',$foot);
	}

	public function getDataHasilUji($id='') {
		$input = $this->input->POST();

		if ($input) {
			$select = array(
				'tera.*',
				'uttp.*',
				"(SELECT dft.no_order FROM tbl_pendaftaran dft WHERE dft.id_daftar = (SELECT list.id_daftar FROM tbl_list_tera list WHERE list.id_list = tera.id_list)) no_order",
				"(SELECT dft.tgl_daftar FROM tbl_pendaftaran dft WHERE dft.id_daftar = (SELECT list.id_daftar FROM tbl_list_tera list WHERE list.id_list = tera.id_list)) tgl_daftar",
				"(SELECT jns.nama_jenis_alat FROM tbl_jenis_alat_ukur jns WHERE jns.id_jenis_alat = uttp.id_jenis_alat) jenis_alat",
				"(SELECT ush.nama_usaha FROM tbl_usaha ush WHERE ush.id_usaha = (SELECT dft.id_usaha FROM tbl_pendaftaran dft WHERE dft.id_daftar = (SELECT list.id_daftar FROM tbl_list_tera list WHERE list.id_list = tera.id_list))) nama_usaha",
				"(SELECT ush.alamat FROM tbl_usaha ush WHERE ush.id_usaha = (SELECT dft.id_usaha FROM tbl_pendaftaran dft WHERE dft.id_daftar = (SELECT list.id_daftar FROM tbl_list_tera list WHERE list.id_list = tera.id_list))) alamat_usaha",
				"(SELECT des.nama_desa FROM tbl_desa des WHERE des.kode_desa = (SELECT ush.kode_desa FROM tbl_usaha ush WHERE ush.id_usaha = (SELECT dft.id_usaha FROM tbl_pendaftaran dft WHERE dft.id_daftar = (SELECT list.id_daftar FROM tbl_list_tera list WHERE list.id_list = tera.id_list)))) desa",
				"(SELECT kec.nama_kecamatan FROM tbl_kecamatan kec WHERE kec.kode_kecamatan = (SELECT des.kode_kecamatan FROM tbl_desa des WHERE des.kode_desa = (SELECT ush.kode_desa FROM tbl_usaha ush WHERE ush.id_usaha = (SELECT dft.id_usaha FROM tbl_pendaftaran dft WHERE dft.id_daftar = (SELECT list.id_daftar FROM tbl_list_tera list WHERE list.id_list = tera.id_list))))) kecamatan",
				"(SELECT usr.nama_user FROM tbl_user usr WHERE usr.id_user = (SELECT ush.id_user FROM tbl_usaha ush WHERE ush.id_usaha = (SELECT dft.id_usaha FROM tbl_pendaftaran dft WHERE dft.id_daftar = (SELECT list.id_daftar FROM tbl_list_tera list WHERE list.id_list = tera.id_list)))) nama_user",
				"(SELECT usr.nama_user FROM tbl_user usr WHERE usr.id_user = (SELECT pt.id_user FROM tbl_petugas pt WHERE pt.id_petugas = tera.id_petugas)) nama_petugas",
				"(SELECT pt.nip FROM tbl_petugas pt WHERE pt.id_petugas = tera.id_petugas) nip"

			);
			$table = array(
				'tbl_tera tera',
				'tbl_uttp uttp'
			);
			$where = "tera.id_list = $input[id_list] AND uttp.id_uttp = (SELECT list.id_uttp FROM tbl_list_tera list WHERE list.id_list = tera.id_list)";
			$dataList = $this->MasterData->getWhereData($select,$table,$where)->row();

			if ($dataList) {
				$result = array(
					'response' => true,
					'data' => $dataList
				);
			} else {
				$result = array(
					'response' => false
				);
			}

			echo json_encode($result);
		}
	}

	public function inputPembayaran($value='') {
		$input = $this->input->POST();

		if ($input) {

			$where = "id_daftar = $input[id_daftar]";
			$cek = $this->MasterData->getDataWhere('tbl_pembayaran',$where)->num_rows();

			$data = array(
				'id_daftar' => $input['id_daftar'],
				'nominal_bayar' => str_replace(".", "", $input['nominal_bayar']),
				'tgl_bayar' => date('Y-m-d', strtotime($input['tgl_bayar']))
			);

			if ($cek == 0) {
				$inputPembayaran = $this->MasterData->inputData($data,'tbl_pembayaran');

				if ($inputPembayaran) {
					$sess['alert'] = alert_success('Pembayaran berhasil disimpan.');
					$this->session->set_flashdata($sess);
					redirect(base_url().'Petugas/hasilPengujian');
				} else {
					$sess['alert'] = alert_failed('Pembayaran gagal disimpan.');
					$this->session->set_flashdata($sess);
					redirect(base_url().'Petugas/hasilPengujian');
				}
			} else {
				$where = "id_daftar = $input[id_daftar]";
				$updatePembayaran = $this->MasterData->editData($where,$data,'tbl_pembayaran');

				if ($updatePembayaran) {
					$sess['alert'] = alert_success('Pembayaran berhasil disimpan.');
					$this->session->set_flashdata($sess);
					redirect(base_url().'Petugas/hasilPengujian');
				} else {
					$sess['alert'] = alert_failed('Pembayaran gagal disimpan.');
					$this->session->set_flashdata($sess);
					redirect(base_url().'Petugas/hasilPengujian');
				}
			}
			
		}
	}

	public function getDataPembayaran($value='') {
		$id = $this->input->POST('id_daftar');

		if ($id) {
			$where = "id_daftar = $id";
			$dataBayar = $this->MasterData->getDataWhere('tbl_pembayaran',$where)->row();

			if ($dataBayar) {
				$result = array(
					'response' => true,
					'data' => $dataBayar
				);
			} else {
				$result = array(
					'response' => false
				);
			}

			echo json_encode($result);
		}
	}

	public function getDataKwitansi($id_daftar='') {
		$id_daftar = $this->input->POST('id_daftar');

		if ($id_daftar) {

			$select = array(
				'dft.*',
				"(SELECT ush.nama_usaha FROM tbl_usaha ush WHERE ush.id_usaha = dft.id_usaha) nama_usaha",
				"(SELECT usr.nama_user FROM tbl_user usr WHERE usr.id_user = (SELECT ush.id_user FROM tbl_usaha ush WHERE ush.id_usaha = dft.id_usaha)) nama_user"
			);
			$where = "id_daftar = $id_daftar";
			$dataOrder = $this->MasterData->getWhereData($select,'tbl_pendaftaran dft',$where)->row();

			$layanan = $dataOrder->layanan;
			$tempat = $dataOrder->tempat;

			$select = '*';
			$dataList = $this->MasterData->getWhereData($select,'tbl_list_tera',$where)->result();

			$xxx =  $layanan.'_'.$tempat;
			$col_tarif = str_replace(' ', '_', $xxx);

			$dataBayar = array();
			$tot_tarif = 0;
			foreach ($dataList as $list) {

				$id_list = $list->id_list;

				$select = array('hasil_tera');
				$where = "id_list = $id_list";
				$hasil = $this->MasterData->getWhereData($select,'tbl_tera',$where)->row()->hasil_tera;

				if ($hasil=='disahkan') {

					$id_uttp = $list->id_uttp;
					$id_tarif = $list->id_tarif;
					$jml_uttp = $list->jumlah_uttp;

					$select = '*';
					$where = "id_tarif = $id_tarif";
					$dataTarif = $this->MasterData->getWhereData($select,'tbl_tarif',$where)->row();

					$tarif = $dataTarif->$col_tarif;	
					$tot_tarif += $tarif * $jml_uttp;

					$select = array(
						"(SELECT jns.nama_jenis_alat FROM tbl_jenis_alat_ukur jns WHERE jns.id_jenis_alat = uttp.id_jenis_alat) jenis_alat"
					);
					$where = "id_uttp = $id_uttp";
					$dataUttp = $this->MasterData->getWhereData($select,'tbl_uttp uttp',$where)->row();

					$dataBayar[] = array(
						'uttp' => $dataUttp->jenis_alat,
						'jml_uttp' => $jml_uttp,
						'jenis_tarif' => $dataTarif->jenis_tarif,
						'tarif' => $tarif
					);
				}
			}

			$result = array(
				'response' => true,
				'rincian' => $dataBayar,
				'total' => $tot_tarif,
				'terbilang' => number_to_words($tot_tarif),
				'no_order' => $dataOrder->no_order,
				'nama_user' => $dataOrder->nama_user,
				'nama_usaha' => $dataOrder->nama_usaha
			);
		} else {
			$result = array(
				'response' => false
			);
		}

		echo json_encode($result);
	}

	// =====================================================

	public function kelompokTarif($value='') {
		// $id_user = $this->id_user;
		$select = array(
			'ktr.*',
			// "(SELECT ktg.nama_kategori_alat FROM tbl_kategori_alat_ukur ktg WHERE ktg.id_kategori_alat = ktr.id_kategori_alat) nama_kategori_alat",
			"(SELECT trf.jenis_tarif FROM tbl_tarif trf WHERE trf.id_tarif = ktr.id_tarif) tarif"
		);
		$table = "tbl_kelompok_tarif ktr";
		$by = 'ktr.id_kelompok';
		$order = 'DESC';
		$dataKelompok = $this->MasterData->getSelectDataOrder($select,$table,$by,$order)->result();
		$dataKategori = $this->MasterData->getData('tbl_kategori_alat_ukur')->result();

		$select = '*';
		$table = 'tbl_tarif';
		$where = "parent_id = 1";
		$dataTarif = $this->MasterData->getWhereData($select,$table,$where)->result();

		$this->head[] = "assets/assets/plugins/select2/dist/css/select2.css";
		$this->head[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.css";
		$this->head[] = "assets/assets/plugins/sweetalert/sweetalert.css";
		$this->head[] = "assets/assets/plugins/multiselect/css/multi-select.css";
		// $this->head[] = "assets/assets/plugins/dropify/dist/css/dropify.min.css";
		// $this->head[] = "assets/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css";

		$this->foot[] = "assets/assets/plugins/select2/dist/js/select2.full.min.js";
		$this->foot[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/sweetalert.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/jquery.sweet-alert.custom.js";
		$this->foot[] = "assets/assets/plugins/datatables/jquery.dataTables.min.js";
		$this->foot[] = "assets/assets/plugins/multiselect/js/jquery.multi-select.js";
		// $this->foot[] = "assets/assets/plugins/dropify/dist/js/dropify.min.js";
		// $this->foot[] = "assets/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js";

		$script = array(
			"$('#myTable').DataTable();",
			"$('.select2').select2();",
			// "$('.dropify').dropify({
			// 	 messages: {
	  //               default: '<center>Upload foto/gambar disini.</center>',
	  //               error: '<center>Maksimal ukuran file 2 MB.</center>',
	  //           }
			// });",
			// "$('.mydatepicker').datepicker({ format: 'dd-mm-yyyy', autoclose:true });",
		);


		// $css_link = array(
		// 	"https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/css/lightbox.min.css"
		// );

		// $js_link = array(
		// 	"https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/js/lightbox.min.js"
		// );

		$head = array (
			'head' => $this->head,
			// 'css_link' => $css_link
		);
		$foot = array(
			'foot' =>  $this->foot,
			'script' => $script,
			// 'js_link' => $js_link
		);

		$nav['menu'] = 'kelompok_tarif';

		$data = array(
			'dataKelompok' => $dataKelompok,
			'dataKategori' => $dataKategori,
			'dataTarif' => $dataTarif
		);

		$this->load->view('Petugas/head',$head);
		$this->load->view('Petugas/navigation',$nav);
		$this->load->view('Petugas/kelompok_tarif',$data);
		$this->load->view('foot',$foot);
	}

	public function addKelompokTarif($value='') {
		$input = $this->input->POST();

		if ($input) {
			$data_tarif = implode(',', $input['id_tarif']);
			$id_kategori_alat = $input['id_kategori_alat'];
			for ($i=0; $i < count($input['id_tarif']) ; $i++) { 

				$id_tarif = $input['id_tarif'][$i];

				$select = 'id_kelompok';
				$table = 'tbl_kelompok_tarif';
				$where = "id_kategori_alat = '$id_kategori_alat' AND id_tarif = '$id_tarif'";
				$cek = $this->MasterData->getWhereData($select,$table,$where)->num_rows();

				$data = array(
					'id_kategori_alat' => $id_kategori_alat,
					'id_tarif' => $id_tarif
				);

				if ($cek == 0) {
					$simpanData = $this->MasterData->inputData($data,$table);
				} 				
			}

			$where = "id_kategori_alat = $id_kategori_alat AND id_tarif NOT IN ($data_tarif)";
			$delete = $this->MasterData->deleteData($where,$table);

			if ($simpanData) {
				$sess['alert'] = alert_success('Data kelompok tarif berhasil disimpan.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Petugas/kelompokTarif');
			} else {
				$sess['alert'] = alert_failed('Data kelompok tarif gagal disimpan.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Petugas/kelompokTarif');
			}
		} else {
			$sess['alert'] = alert_failed('Data kelompok tarif gagal disimpan.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Petugas/kelompokTarif');
		}
	}

	public function getDataKelompok($value='') {
		$id = $this->input->POST('id_kategori_alat');

		if ($id) {
			$select = '*';
			$table = 'tbl_kelompok_tarif';
			$where = "id_kategori_alat = $id";
			$data = $this->MasterData->getWhereData($select,$table,$where)->result();

			if ($data) {
				$result = array(
					'response' => true,
					'data' => $data
				);
			} else {
				$result = array(
					'response' => false
				);
			}
		} else {
			$result = array(
				'response' => false
			);
		}

		echo json_encode($result);
	}

	public function deleteKelompokTarif($value='') {
		$id = $this->input->POST('id');

		if ($id) {
			$where = "id_kategori_alat = $id";
			$delete = $this->MasterData->deleteData($where,'tbl_kelompok_tarif');

			if ($delete) {
				echo "Success";
				$sess['alert'] = alert_success('Data kelompok tarif berhasil dihapus.');
				$this->session->set_flashdata($sess);
				// redirect(base_url().'Petugas/kategoriAlat');
			} else {
				echo 'Failed';
				$sess['alert'] = alert_failed('Data kelompok tarif gagal dihapus.');
				$this->session->set_flashdata($sess);
				// redirect(base_url().'Petugas/kategoriAlat');
			}
		} else {
			echo 'Failed';
			$sess['alert'] = alert_failed('Data kelompok tarif gagal dihapus.');
			$this->session->set_flashdata($sess);
			// redirect(base_url().'Petugas/kategoriAlat');
		}
	}

	// =====================================================

	public function kategoriAlat($value='') {
		$by = 'id_kategori_alat';
		$order = 'DESC';
		$dataKategori = $this->MasterData->getSelectDataOrder('*','tbl_kategori_alat_ukur',$by,$order)->result();

		// $this->head[] = "assets/assets/plugins/select2/dist/css/select2.css";
		$this->head[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.css";
		$this->head[] = "assets/assets/plugins/sweetalert/sweetalert.css";
		// $this->head[] = "assets/assets/plugins/dropify/dist/css/dropify.min.css";
		// $this->head[] = "assets/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css";

		// $this->foot[] = "assets/assets/plugins/select2/dist/js/select2.full.min.js";
		$this->foot[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/sweetalert.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/jquery.sweet-alert.custom.js";
		$this->foot[] = "assets/assets/plugins/datatables/jquery.dataTables.min.js";
		// $this->foot[] = "assets/assets/plugins/dropify/dist/js/dropify.min.js";
		// $this->foot[] = "assets/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js";

		$script = array(
			"$('#myTable').DataTable();",
			// "$('.select2').select2();",
			// "$('.dropify').dropify({
			// 	 messages: {
	  //               default: '<center>Upload foto/gambar disini.</center>',
	  //               error: '<center>Maksimal ukuran file 2 MB.</center>',
	  //           }
			// });",
			// "$('.mydatepicker').datepicker({ format: 'dd-mm-yyyy', autoclose:true });",
		);


		// $css_link = array(
		// 	"https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/css/lightbox.min.css"
		// );

		// $js_link = array(
		// 	"https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/js/lightbox.min.js"
		// );

		$head = array (
			'head' => $this->head,
			// 'css_link' => $css_link
		);
		$foot = array(
			'foot' =>  $this->foot,
			'script' => $script,
			// 'js_link' => $js_link
		);

		$nav['menu'] = 'kategori_alat';

		$data = array(
			'dataKategori' => $dataKategori
		);

		$this->load->view('Petugas/head',$head);
		$this->load->view('Petugas/navigation',$nav);
		$this->load->view('Petugas/kategori_alat',$data);
		$this->load->view('foot',$foot);
	}

	public function inputKategoriAlat($value='') {
		$data = $this->input->POST();

		if ($data) {
			$input = $this->MasterData->inputData($data,'tbl_kategori_alat_ukur');

			if ($input) {
				$sess['alert'] = alert_success('Data kategori alat berhasil disimpan.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Petugas/kategoriAlat');
			} else {
				$sess['alert'] = alert_failed('Data kategori alat gagal disimpan.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Petugas/kategoriAlat');
			}
		}
	}

	public function updateKategoriAlat($value='') {
		$input = $this->input->POST();

		if ($input) {
			$data = array(
				'nama_kategori_alat' => $input['nama_kategori_alat']
			);
			$where = "id_kategori_alat = $input[id_kategori_alat]";
			$update = $this->MasterData->editData($where,$data,'tbl_kategori_alat_ukur');

			if ($update) {
				$sess['alert'] = alert_success('Data kategori alat berhasil diupdate.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Petugas/kategoriAlat');
			} else {
				$sess['alert'] = alert_failed('Data kategori alat gagal diupdate.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Petugas/kategoriAlat');
			}
		} else {
			$sess['alert'] = alert_failed('Data kategori alat gagal diupdate.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Petugas/kategoriAlat');
		}
	}

	public function deleteKategoriAlat($value='') {
		$id = $this->input->POST('id');

		if ($id) {
			$where = "id_kategori_alat = $id";
			$delete = $this->MasterData->deleteData($where,'tbl_kategori_alat_ukur');

			if ($delete) {
				echo "Success";
				$sess['alert'] = alert_success('Data kategori alat berhasil dihapus.');
				$this->session->set_flashdata($sess);
				// redirect(base_url().'Petugas/kategoriAlat');
			} else {
				echo 'Failed';
				$sess['alert'] = alert_failed('Data kategori alat gagal dihapus.');
				$this->session->set_flashdata($sess);
				// redirect(base_url().'Petugas/kategoriAlat');
			}
		} else {
			echo 'Failed';
			$sess['alert'] = alert_failed('Data kategori alat gagal dihapus.');
			$this->session->set_flashdata($sess);
			// redirect(base_url().'Petugas/kategoriAlat');
		}
	}
	// =====================================================

	public function jenisAlat($value='') {
		$select = array(
			'jns.*',
			"(SELECT ktg.nama_kategori_alat FROM tbl_kategori_alat_ukur ktg WHERE ktg.id_kategori_alat = jns.id_kategori_alat) nama_kategori_alat",
		);
		$table = "tbl_jenis_alat_ukur jns";
		$by = 'jns.id_jenis_alat';
		$order = 'DESC';
		$jenisAlat = $this->MasterData->getSelectDataOrder($select,$table,$by,$order)->result();

		$dataKategori = $this->MasterData->getData('tbl_kategori_alat_ukur')->result();

		// $this->head[] = "assets/assets/plugins/select2/dist/css/select2.css";
		$this->head[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.css";
		$this->head[] = "assets/assets/plugins/sweetalert/sweetalert.css";
		// $this->head[] = "assets/assets/plugins/dropify/dist/css/dropify.min.css";
		// $this->head[] = "assets/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css";

		// $this->foot[] = "assets/assets/plugins/select2/dist/js/select2.full.min.js";
		$this->foot[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/sweetalert.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/jquery.sweet-alert.custom.js";
		$this->foot[] = "assets/assets/plugins/datatables/jquery.dataTables.min.js";
		// $this->foot[] = "assets/assets/plugins/dropify/dist/js/dropify.min.js";
		// $this->foot[] = "assets/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js";

		$script = array(
			"$('#myTable').DataTable();",
			// "$('.select2').select2();",
			// "$('.dropify').dropify({
			// 	 messages: {
	  //               default: '<center>Upload foto/gambar disini.</center>',
	  //               error: '<center>Maksimal ukuran file 2 MB.</center>',
	  //           }
			// });",
			// "$('.mydatepicker').datepicker({ format: 'dd-mm-yyyy', autoclose:true });",
		);


		// $css_link = array(
		// 	"https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/css/lightbox.min.css"
		// );

		// $js_link = array(
		// 	"https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/js/lightbox.min.js"
		// );

		$head = array (
			'head' => $this->head,
			// 'css_link' => $css_link
		);
		$foot = array(
			'foot' =>  $this->foot,
			'script' => $script,
			// 'js_link' => $js_link
		);

		$nav['menu'] = 'jenis_alat';

		$data = array(
			'jenisAlat' => $jenisAlat,
			'dataKategori' => $dataKategori
		);

		$this->load->view('Petugas/head',$head);
		$this->load->view('Petugas/navigation',$nav);
		$this->load->view('Petugas/jenis_alat',$data);
		$this->load->view('foot',$foot);
	}

	public function inputJenisAlat($value='') {
		$data = $this->input->POST();

		if ($data) {
			$input = $this->MasterData->inputData($data,'tbl_jenis_alat_ukur');

			if ($input) {
				$sess['alert'] = alert_success('Data jenis alat ukur berhasil disimpan.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Petugas/jenisAlat');
			} else {
				$sess['alert'] = alert_failed('Data jenis alat ukur gagal disimpan.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Petugas/jenisAlat');
			}
		}
	}

	public function updateJenisAlat($value='') {
		$input = $this->input->POST();

		if ($input) {
			$where = "id_jenis_alat = $input[id_jenis_alat]";
			$update = $this->MasterData->editData($where,$input,'tbl_jenis_alat_ukur');

			if ($update) {
				$sess['alert'] = alert_success('Data jenis alat ukur berhasil diupdate.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Petugas/jenisAlat');
			} else {
				$sess['alert'] = alert_failed('Data jenis alat ukur gagal diupdate.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Petugas/jenisAlat');
			}
		} else {
			$sess['alert'] = alert_failed('Data jenis alat ukur gagal diupdate.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Petugas/jenisAlat');
		}
	}

	public function deleteJenisAlat($value='') {
		$id = $this->input->POST('id');

		if ($id) {
			$where = "id_jenis_alat = $id";
			$delete = $this->MasterData->deleteData($where,'tbl_jenis_alat_ukur');

			if ($delete) {
				echo "Success";
				$sess['alert'] = alert_success('Data jenis alat ukur berhasil dihapus.');
				$this->session->set_flashdata($sess);
				// redirect(base_url().'Petugas/jenisAlat');
			} else {
				echo 'Failed';
				$sess['alert'] = alert_failed('Data jenis alat ukur gagal dihapus.');
				$this->session->set_flashdata($sess);
				// redirect(base_url().'Petugas/jenisAlat');
			}
		} else {
			echo 'Failed';
			$sess['alert'] = alert_failed('Data jenis alat ukur gagal dihapus.');
			$this->session->set_flashdata($sess);
			// redirect(base_url().'Petugas/jenisAlat');
		}
	}

	// =====================================================

	public function jenisUsaha($value='') {
		$select = array(
			'jns.*',
			// "(SELECT ktg.nama_kategori_alat FROM tbl_kategori_alat_ukur ktg WHERE ktg.id_kategori_alat = jns.id_kategori_alat) nama_kategori_alat",
		);
		$table = "tbl_jenis_usaha jns";
		$by = 'jns.id_jenis_usaha';
		$order = 'DESC';
		$jenisUsaha = $this->MasterData->getSelectDataOrder($select,$table,$by,$order)->result();

		// $dataKategori = $this->MasterData->getData('tbl_kategori_alat_ukur')->result();

		// $this->head[] = "assets/assets/plugins/select2/dist/css/select2.css";
		$this->head[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.css";
		$this->head[] = "assets/assets/plugins/sweetalert/sweetalert.css";
		// $this->head[] = "assets/assets/plugins/dropify/dist/css/dropify.min.css";
		// $this->head[] = "assets/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css";

		// $this->foot[] = "assets/assets/plugins/select2/dist/js/select2.full.min.js";
		$this->foot[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/sweetalert.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/jquery.sweet-alert.custom.js";
		$this->foot[] = "assets/assets/plugins/datatables/jquery.dataTables.min.js";
		// $this->foot[] = "assets/assets/plugins/dropify/dist/js/dropify.min.js";
		// $this->foot[] = "assets/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js";

		$script = array(
			"$('#myTable').DataTable();",
			// "$('.select2').select2();",
			// "$('.dropify').dropify({
			// 	 messages: {
	  //               default: '<center>Upload foto/gambar disini.</center>',
	  //               error: '<center>Maksimal ukuran file 2 MB.</center>',
	  //           }
			// });",
			// "$('.mydatepicker').datepicker({ format: 'dd-mm-yyyy', autoclose:true });",
		);


		// $css_link = array(
		// 	"https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/css/lightbox.min.css"
		// );

		// $js_link = array(
		// 	"https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/js/lightbox.min.js"
		// );

		$head = array (
			'head' => $this->head,
			// 'css_link' => $css_link
		);
		$foot = array(
			'foot' =>  $this->foot,
			'script' => $script,
			// 'js_link' => $js_link
		);

		$nav['menu'] = 'usaha';

		$data = array(
			'jenisUsaha' => $jenisUsaha,
			// 'dataKategori' => $dataKategori
		);

		$this->load->view('Petugas/head',$head);
		$this->load->view('Petugas/navigation',$nav);
		$this->load->view('Petugas/jenis_usaha',$data);
		$this->load->view('foot',$foot);
	}

	public function inputJenisUsaha($value='') {
		$data = $this->input->POST();

		if ($data) {
			$input = $this->MasterData->inputData($data,'tbl_jenis_usaha');

			if ($input) {
				$sess['alert'] = alert_success('Data jenis usaha berhasil disimpan.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Petugas/jenisUsaha');
			} else {
				$sess['alert'] = alert_failed('Data jenis usaha gagal disimpan.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Petugas/jenisUsaha');
			}
		}
	}

	public function updateJenisUsaha($value='') {
		$input = $this->input->POST();

		if ($input) {
			$where = "id_jenis_usaha = $input[id_jenis_usaha]";
			$update = $this->MasterData->editData($where,$input,'tbl_jenis_usaha');

			if ($update) {
				$sess['alert'] = alert_success('Data jenis usaha berhasil diupdate.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Petugas/jenisUsaha');
			} else {
				$sess['alert'] = alert_failed('Data jenis usaha gagal diupdate.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Petugas/jenisUsaha');
			}
		} else {
			$sess['alert'] = alert_failed('Data jenis usaha gagal diupdate.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Petugas/jenisUsaha');
		}
	}

	public function deleteJenisUsaha($value='') {
		$id = $this->input->POST('id');

		if ($id) {
			$where = "id_jenis_usaha = $id";
			$delete = $this->MasterData->deleteData($where,'tbl_jenis_usaha');

			if ($delete) {
				echo "Success";
				$sess['alert'] = alert_success('Data jenis usaha berhasil dihapus.');
				$this->session->set_flashdata($sess);
				// redirect(base_url().'Petugas/jenisAlat');
			} else {
				echo 'Failed';
				$sess['alert'] = alert_failed('Data jenis usaha gagal dihapus.');
				$this->session->set_flashdata($sess);
				// redirect(base_url().'Petugas/jenisAlat');
			}
		} else {
			echo 'Failed';
			$sess['alert'] = alert_failed('Data jenis usaha gagal dihapus.');
			$this->session->set_flashdata($sess);
			// redirect(base_url().'Petugas/jenisAlat');
		}
	}

	// =====================================================

	public function dataPasar($value='') {
		$select = array(
			'psr.*',
			"(SELECT des.nama_desa FROM tbl_desa des WHERE des.kode_desa = psr.kode_desa) nama_desa",
			"(SELECT kec.nama_kecamatan FROM tbl_kecamatan kec WHERE kec.kode_kecamatan = (SELECT des.kode_kecamatan FROM tbl_desa des WHERE des.kode_desa = psr.kode_desa)) nama_kecamatan",
		);
		$table = "tbl_pasar psr";
		$by = 'psr.id_pasar';
		$order = 'DESC';
		$dataPasar = $this->MasterData->getSelectDataOrder($select,$table,$by,$order)->result();

		$dataKecamatan = $this->MasterData->getData('tbl_kecamatan')->result();

		$this->head[] = "assets/assets/plugins/select2/dist/css/select2.css";
		$this->head[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.css";
		$this->head[] = "assets/assets/plugins/sweetalert/sweetalert.css";
		// $this->head[] = "assets/assets/plugins/dropify/dist/css/dropify.min.css";
		// $this->head[] = "assets/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css";

		$this->foot[] = "assets/assets/plugins/select2/dist/js/select2.full.min.js";
		$this->foot[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/sweetalert.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/jquery.sweet-alert.custom.js";
		$this->foot[] = "assets/assets/plugins/datatables/jquery.dataTables.min.js";
		// $this->foot[] = "assets/assets/plugins/dropify/dist/js/dropify.min.js";
		// $this->foot[] = "assets/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js";

		$script = array(
			"$('#myTable').DataTable();",
			"$('.select2').select2();",
			// "$('.dropify').dropify({
			// 	 messages: {
	  //               default: '<center>Upload foto/gambar disini.</center>',
	  //               error: '<center>Maksimal ukuran file 2 MB.</center>',
	  //           }
			// });",
			// "$('.mydatepicker').datepicker({ format: 'dd-mm-yyyy', autoclose:true });",
		);


		// $css_link = array(
		// 	"https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/css/lightbox.min.css"
		// );

		// $js_link = array(
		// 	"https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/js/lightbox.min.js"
		// );

		$head = array (
			'head' => $this->head,
			// 'css_link' => $css_link
		);
		$foot = array(
			'foot' =>  $this->foot,
			'script' => $script,
			// 'js_link' => $js_link
		);

		$nav['menu'] = 'pasar';

		$data = array(
			'dataPasar' => $dataPasar,
			'dataKecamatan' => $dataKecamatan
		);

		$this->load->view('Petugas/head',$head);
		$this->load->view('Petugas/navigation',$nav);
		$this->load->view('Petugas/data_pasar',$data);
		$this->load->view('foot',$foot);
	}

	public function inputDataPasar($value='') {
		$input = $this->input->POST();

		if ($input) {
			$data = array(
				'kode_desa' => $input['kode_desa'],
				'nama_pasar' => $input['nama_pasar']
			);
			$input = $this->MasterData->inputData($data,'tbl_pasar');

			if ($input) {
				$sess['alert'] = alert_success('Data pasar berhasil disimpan.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Petugas/dataPasar');
			} else {
				$sess['alert'] = alert_failed('Data pasar gagal disimpan.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Petugas/dataPasar');
			}
		}
	}

	public function updateDataPasar($value='') {
		$input = $this->input->POST();

		if ($input) {
			$data = array(
				'kode_desa' => $input['kode_desa'],
				'nama_pasar' => $input['nama_pasar']
			);
			$where = "id_pasar = $input[id_pasar]";
			$update = $this->MasterData->editData($where,$data,'tbl_pasar');

			if ($update) {
				$sess['alert'] = alert_success('Data pasar berhasil diupdate.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Petugas/dataPasar');
			} else {
				$sess['alert'] = alert_failed('Data pasar gagal diupdate.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Petugas/dataPasar');
			}
		} else {
			$sess['alert'] = alert_failed('Data pasar gagal diupdate.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Petugas/dataPasar');
		}
	}

	public function deleteDataPasar($value='') {
		$id = $this->input->POST('id');

		if ($id) {
			$where = "id_pasar = $id";
			$delete = $this->MasterData->deleteData($where,'tbl_pasar');

			if ($delete) {
				echo "Success";
				$sess['alert'] = alert_success('Data pasar berhasil dihapus.');
				$this->session->set_flashdata($sess);
				// redirect(base_url().'Petugas/jenisAlat');
			} else {
				echo 'Failed';
				$sess['alert'] = alert_failed('Data pasar gagal dihapus.');
				$this->session->set_flashdata($sess);
				// redirect(base_url().'Petugas/jenisAlat');
			}
		} else {
			echo 'Failed';
			$sess['alert'] = alert_failed('Data pasar gagal dihapus.');
			$this->session->set_flashdata($sess);
			// redirect(base_url().'Petugas/jenisAlat');
		}
	}

	public function getDataPasar($value='') {
		$kode_desa = $this->input->POST('kode_desa');

		if ($kode_desa) {
			$where = "kode_desa = $kode_desa";
			$kode_kec = $this->MasterData->getDataWhere('tbl_desa',$where)->row()->kode_kecamatan;

			$where = "kode_kecamatan = $kode_kec";
			$dataDesa = $this->MasterData->getDataWhere('tbl_desa',$where)->result();

			if ($dataDesa) {
				$result = array(
					'response' => true,
					'kode_kecamatan' => $kode_kec,
					'dataDesa' => $dataDesa
				);
			} else {
				$result = array(
					'response' => false
				);
			}
		} else {
			$result = array(
				'response' => false
			);
		}

		echo json_encode($result);
	}

	// =====================================================

	public function kelompokPasar($value='') {
		$select = array(
			'grp.*',
			"(SELECT usr.nama_user FROM tbl_user usr WHERE usr.id_user = (SELECT ush.id_user FROM tbl_usaha ush WHERE ush.id_usaha = grp.id_usaha)) nama_user",
			"(SELECT usr.id_user FROM tbl_user usr WHERE usr.id_user = (SELECT ush.id_user FROM tbl_usaha ush WHERE ush.id_usaha = grp.id_usaha)) id_user",
			"(SELECT ush.nama_usaha FROM tbl_usaha ush WHERE ush.id_usaha = grp.id_usaha) nama_usaha",
			"(SELECT jns.nama_jenis_usaha FROM tbl_jenis_usaha jns WHERE jns.id_jenis_usaha = (SELECT ush.id_jenis_usaha FROM tbl_usaha ush WHERE ush.id_usaha = grp.id_usaha)) nama_jenis_usaha",
			"(SELECT psr.nama_pasar FROM tbl_pasar psr WHERE psr.id_pasar = grp.id_pasar) nama_pasar",
		);
		$table = "tbl_grup_pasar grp";
		$by = 'grp.id_grup';
		$order = 'DESC';

		$kelPasar = $this->MasterData->getSelectDataOrder($select,$table,$by,$order);

		// ============================================================================

		$config['base_url'] = base_url().'/Petugas/kelompokPasar';
		$config['total_rows'] = $kelPasar->num_rows();
		$config['per_page'] = 10;
		
		$config['num_links'] = 1;
		$config['display_pages'] = TRUE;
		$config['use_page_numbers'] = TRUE;
		$config['uri_segment'] = 3; //supaya tidak error karena base url dinamis
		$config['reuse_query_string'] = true; //supaya link pagination sesuai parameter get yang ada
 
        // Membuat Style pagination untuk BootStrap v4
        $config['first_link']       = '<span class="d-block d-sm-block d-md-none d-lg-none"> << </span> <span class="d-none d-sm-none d-md-block d-lg-block">First</span>';
        $config['last_link']        = '<span class="d-block d-sm-block d-md-none d-lg-none"> >> </span> <span class="d-none d-sm-none d-md-block d-lg-block">Last</span>';
        $config['next_link']        = '<span class="d-block d-sm-block d-md-none d-lg-none"> > </span> <span class="d-none d-sm-none d-md-block d-lg-block">Next</span>';
        $config['prev_link']        = '<span class="d-block d-sm-block d-md-none d-lg-none"> < </span> <span class="d-none d-sm-none d-md-block d-lg-block">Prev</span>';
        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tagl_close']  = '</span></li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tagl_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tagl_close']  = '</span></li>';
		
		$this->pagination->initialize($config);

		if($this->uri->segment(3) == null){
			$start_index = 0;
		}else{
			$start_index = ($this->uri->segment(3)-1)*$config['per_page'];
		}

		if ($start_index > 0) {
			$numbers = ($this->uri->segment(3)*$config['per_page'])-$config['per_page'];
		} else {
			$numbers = 0;
		}
		
		$pages =  $this->pagination->create_links();

		// ==============================================================================

		$where = "grp.id_grup > 0";
		$dataKelPasar = $this->MasterData->getWhereDataLimitIndexOrder($select,$table,$where,$start_index,$config['per_page'],$by,$order)->result();

		// ==============================================================================

		$dataPasar = $this->MasterData->getData('tbl_pasar')->result();

		$this->head[] = "assets/assets/plugins/select2/dist/css/select2.css";
		$this->head[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.css";
		$this->head[] = "assets/assets/plugins/sweetalert/sweetalert.css";
		// $this->head[] = "assets/assets/plugins/dropify/dist/css/dropify.min.css";
		// $this->head[] = "assets/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css";
		$this->head[] = "assets/main/vendor/jquery-ui/jquery-ui.min.css";

		$this->foot[] = "assets/assets/plugins/select2/dist/js/select2.full.min.js";
		$this->foot[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/sweetalert.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/jquery.sweet-alert.custom.js";
		$this->foot[] = "assets/assets/plugins/datatables/jquery.dataTables.min.js";
		// $this->foot[] = "assets/assets/plugins/dropify/dist/js/dropify.min.js";
		// $this->foot[] = "assets/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js";
		$this->foot[] = "assets/main/vendor/jquery-ui/jquery-ui.min.js";

		$script = array(
			"$('#myTable').DataTable();",
			"$('.select2').select2();",
			// "$('.dropify').dropify({
			// 	 messages: {
	  //               default: '<center>Upload foto/gambar disini.</center>',
	  //               error: '<center>Maksimal ukuran file 2 MB.</center>',
	  //           }
			// });",
			// "$('.mydatepicker').datepicker({ format: 'dd-mm-yyyy', autoclose:true });",

			"$('.autocomplete').autocomplete({
                source: '".base_url().'Petugas/getDataUserKelPasar'."',
      			response: function (event, ui) {
      				var modal = $(this).parent().parent().parent().parent().parent().parent().attr('id');
		            var len = ui.content.length;
		            if (len == 0) {
		            	$('#'+modal+' #counter_found').html('Data user tidak ditemukan');
		            	clearDataUsaha(modal);
		            	$('#'+modal+' #cek').val('');
		            } else {
		            	$('#'+modal+' #counter_found').html('');
		            	clearDataUsaha(modal);
		            }
		            
		        },
                select: function (event, ui) {
                	var modal = $(this).parent().parent().parent().parent().parent().parent().attr('id');
                    getDataUsaha(ui.item.id, modal);
                    $('#'+modal+' #cek').val(ui.item.id);
                }
            });"
		);


		// $css_link = array(
		// 	"https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/css/lightbox.min.css"
		// );

		// $js_link = array(
		// 	"https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/js/lightbox.min.js"
		// );

		$head = array (
			'head' => $this->head,
			// 'css_link' => $css_link
		);
		$foot = array(
			'foot' =>  $this->foot,
			'script' => $script,
			// 'js_link' => $js_link
		);

		$nav['menu'] = 'kelompok_pasar';

		$data = array(
			'dataKelPasar' => $dataKelPasar,
			'dataPasar' => $dataPasar,
			'pages' => $pages,
			'numbers' => $numbers
		);

		$this->load->view('Petugas/head',$head);
		$this->load->view('Petugas/navigation',$nav);
		$this->load->view('Petugas/kelompok_pasar',$data);
		$this->load->view('foot',$foot);
	}

	public function inputKelompokPasar($value='') {
		$input = $this->input->POST();

		if ($input) {
			$data = array(
				'id_pasar' => $input['id_pasar'],
				'id_usaha' => $input['id_usaha']
			);
			$input = $this->MasterData->inputData($data,'tbl_grup_pasar');

			if ($input) {
				$sess['alert'] = alert_success('Kelompok pasar berhasil disimpan.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Petugas/kelompokPasar');
			} else {
				$sess['alert'] = alert_failed('Kelompok pasar gagal disimpan.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Petugas/kelompokPasar');
			}
		}
	}

	public function updateKelompokPasar($uri='') {
		$input = $this->input->POST();

		if ($input) {
			$data = array(
				'id_pasar' => $input['id_pasar'],
				'id_usaha' => $input['id_usaha']
			);
			$where = "id_grup = $input[id_grup]";
			$update = $this->MasterData->editData($where,$data,'tbl_grup_pasar');

			if ($update) {
				$sess['alert'] = alert_success('Kelompok pasar berhasil diupdate.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Petugas/kelompokPasar/'.$uri);
			} else {
				$sess['alert'] = alert_failed('Kelompok pasar gagal diupdate.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Petugas/kelompokPasar/'.$uri);
			}
		} else {
			$sess['alert'] = alert_failed('Kelompok pasar gagal diupdate.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Petugas/kelompokPasar/'.$uri);
		}
	}

	public function deleteKelompokPasar($value='') {
		$id = $this->input->POST('id');

		if ($id) {
			$where = "id_grup = $id";
			$delete = $this->MasterData->deleteData($where,'tbl_grup_pasar');

			if ($delete) {
				echo "Success";
				$sess['alert'] = alert_success('Kelompok pasar berhasil dihapus.');
				$this->session->set_flashdata($sess);
				// redirect(base_url().'Petugas/jenisAlat');
			} else {
				echo 'Failed';
				$sess['alert'] = alert_failed('Kelompok pasar gagal dihapus.');
				$this->session->set_flashdata($sess);
				// redirect(base_url().'Petugas/jenisAlat');
			}
		} else {
			echo 'Failed';
			$sess['alert'] = alert_failed('Kelompok pasar gagal dihapus.');
			$this->session->set_flashdata($sess);
			// redirect(base_url().'Petugas/jenisAlat');
		}
	}

	// =====================================================

	public function profil($value='') {
		$id_user = $this->id_user;

		$select = array(
			'usr.*'
		);
		$table = "tbl_user usr";
		$where = "usr.id_user = $id_user";
		$dataUser = $this->MasterData->getWhereData($select,$table,$where)->row();
		// $statusJl = $this->MasterData->getData('tbl_status_jalan')->result();

		$this->head[] = "assets/assets/plugins/select2/dist/css/select2.css";
		$this->head[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.css";
		$this->head[] = "assets/assets/plugins/sweetalert/sweetalert.css";
		// $this->head[] = "assets/assets/plugins/dropify/dist/css/dropify.min.css";

		$this->foot[] = "assets/assets/plugins/select2/dist/js/select2.full.min.js";
		$this->foot[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/sweetalert.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/jquery.sweet-alert.custom.js";
		$this->foot[] = "assets/assets/plugins/datatables/jquery.dataTables.min.js";
		// $this->foot[] = "assets/assets/plugins/dropify/dist/js/dropify.min.js";

		$script = array(
			"$('#myTable').DataTable();",
			"$('.select2').select2();",
			// "$('.dropify').dropify({
			// 	 messages: {
	  //               default: '<center>Upload foto/gambar disini.</center>',
	  //               error: '<center>Maksimal ukuran file 2 MB.</center>',
	  //           }
			// });"
		);


		$css_link = array(
			"https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/css/lightbox.min.css"
		);

		$js_link = array(
			"https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/js/lightbox.min.js"
		);

		$head = array (
			'head' => $this->head,
			// 'css_link' => $css_link
		);
		$foot = array(
			'foot' =>  $this->foot,
			'script' => $script,
			// 'js_link' => $js_link
		);

		$nav['menu'] = 'profil';

		$data = array(
			'dataUser' => $dataUser
		);

		$this->load->view('Petugas/head',$head);
		$this->load->view('Petugas/navigation',$nav);
		$this->load->view('Petugas/profil',$data);
		$this->load->view('foot',$foot);
	}

	public function simpanProfil($value='') {
		$id_user = $this->id_user;
		$data = $this->input->POST();

		if ($data) {
			$table = 'tbl_user';
			$where = "id_user = $id_user";
			$updateData = $this->MasterData->editData($where,$data,$table);

			if ($updateData) {
				$sess['alert'] = alert_success('Data profil berhasil disimpan.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Petugas/profil');
			} else {
				$sess['alert'] = alert_failed('Data profil gagal disimpan.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Petugas/profil');
			}
		} else {
			$sess['alert'] = alert_failed('Data profil gagal disimpan.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Petugas/profil');
		}
	}

	// =====================================================

	public function dataTarif($value=''){
		// $id_user = $this->id_user;
		$select = array(
			'trf.*',
		);
		$table = "tbl_tarif trf";
		$where = "parent_id = 0";
		$by = 'id_tarif';
		$order = 'DESC';
		$dataTarif = $this->MasterData->getWhereDataOrder($select,$table,$where,$by,$order)->result();

		// $this->head[] = "assets/assets/plugins/select2/dist/css/select2.css";
		// $this->head[] = "assets/assets/plugins/footable/css/footable.core.css";
		$this->head[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.css";
		$this->head[] = "assets/assets/plugins/sweetalert/sweetalert.css";
		// $this->head[] = "assets/assets/plugins/dropify/dist/css/dropify.min.css";

		// $this->foot[] = "assets/assets/plugins/select2/dist/js/select2.full.min.js";
		// $this->foot[] = "assets/assets/plugins/footable/js/footable.all.min.js";
		$this->foot[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/sweetalert.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/jquery.sweet-alert.custom.js";
		$this->foot[] = "assets/assets/plugins/datatables/jquery.dataTables.min.js";
		// $this->foot[] = "assets/main/js/footable-init.js";
		// $this->foot[] = "assets/assets/plugins/dropify/dist/js/dropify.min.js";

		$script = array(
			"$('#myTable').DataTable();",
			// "$('.select2').select2();",
			// "$('.dropify').dropify({
			// 	 messages: {
	  //               default: '<center>Upload foto/gambar disini.</center>',
	  //               error: '<center>Maksimal ukuran file 500 KB.</center>',
	  //           }
			// });"
		);


		$css_link = array(
			"https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/css/lightbox.min.css"
		);

		$js_link = array(
			"https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/js/lightbox.min.js"
		);

		$head = array (
			'head' => $this->head,
			// 'css_link' => $css_link
		);
		$foot = array(
			'foot' =>  $this->foot,
			'script' => $script,
			// 'js_link' => $js_link
		);

		$nav['menu'] = 'tarif';

		$data = array(
			'dataTarif' => $dataTarif,
			// 'dataJenisUsaha' => $dataJenisUsaha,
			// 'dataKecamatan' => $dataKecamatan
		);

		$this->load->view('Petugas/head',$head);
		$this->load->view('Petugas/navigation',$nav);
		$this->load->view('Petugas/tarif',$data);
		$this->load->view('foot',$foot);
	}

	public function simpanTarif($value='') {

		$input = $this->input->POST();
		// $sess['show_alert'] = 1;

		if ($input) {
			$data = array(
				'jenis_tarif' => $input['jenis_tarif'],
				'parent_id' => 0,
				'child_id' => 0,
				'satuan' => ($input['satuan']=='' || $input['satuan'] == null?'-':$input['satuan']),
				'tera_kantor' => str_replace(".", "", $input['tera_kantor']),
				'tera_tempat_pakai' => str_replace(".", "", $input['tera_tempat_pakai']),
				'tera_ulang_kantor' => str_replace(".", "", $input['tera_ulang_kantor']),
				'tera_ulang_tempat_pakai' => str_replace(".", "", $input['tera_ulang_tempat_pakai'])
			);
			$table = 'tbl_tarif';
			$inputData = $this->MasterData->inputData($data,$table);

			if ($inputData) {
				$sess['alert'] = alert_success('Data tarif berhasil disimpan.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Petugas/dataTarif');
			} else {
				$sess['alert'] = alert_failed('Data tarif gagal disimpan.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Petugas/dataTarif');
			}
		} else {
			$sess['alert'] = alert_failed('Data tarif gagal disimpan.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Petugas/dataTarif');
		}

		// var_dump($input);
	}

	public function updateTarif($value='') {

		$input = $this->input->POST();
		// $sess['show_alert'] = 1;

		if ($input) {
			$data = array(
				'jenis_tarif' => $input['jenis_tarif'],
				// 'parent_id' => 0,
				// 'child_id' => 0,
				'satuan' => ($input['satuan']=='' || $input['satuan'] == null?'-':$input['satuan']),
				'tera_kantor' => str_replace(".", "", $input['tera_kantor']),
				'tera_tempat_pakai' => str_replace(".", "", $input['tera_tempat_pakai']),
				'tera_ulang_kantor' => str_replace(".", "", $input['tera_ulang_kantor']),
				'tera_ulang_tempat_pakai' => str_replace(".", "", $input['tera_ulang_tempat_pakai'])
			);
			$table = 'tbl_tarif';
			$where = "id_tarif = $input[id_tarif]";
			$updateData = $this->MasterData->editData($where,$data,$table);

			if ($updateData) {
				$sess['alert'] = alert_success('Data tarif berhasil diupdate.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Petugas/dataTarif');
			} else {
				$sess['alert'] = alert_failed('Data tarif gagal diupdate.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Petugas/dataTarif');
			}
		} else {
			$sess['alert'] = alert_failed('Data tarif gagal diupdate.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Petugas/dataTarif');
		}

		// var_dump($input);
	}

	public function subTarif($id='', $sub=''){
		
		if ($id != '') {
			$id_tarif = decode($id);

			$table = "tbl_tarif trf";
			$where = "id_tarif = $id_tarif";
			$subTarif = $this->MasterData->getWhereData('*',$table,$where)->row();
		} else {
			redirect(base_url().'Petugas/dataTarif');
		}	

		$subs = array();
		if ($sub != '') {
			$xx = json_decode($sub);
			foreach ($xx as $key) {
				$subs[] = $key;
			}
		}
		if ($subTarif->parent_id > 0) {

			$subs[] = array(
				'id_sub' => $subTarif->id_tarif,
				'sub' => $subTarif->jenis_tarif
			);
			$ss = json_encode($subs);
			$this->subTarif(encode($subTarif->parent_id), $ss);

		} else {

			$subs[] = array(
				'id_sub' => $subTarif->id_tarif,
				'sub' => $subTarif->jenis_tarif
			);
			$subx = json_encode($subs);
			$ssxx = json_decode($subx);

			$id_trf = $ssxx[0]->id_sub;

			$select = array(
				'trf.*',
			);
			$table = "tbl_tarif trf";
			$where = "parent_id = $id_trf";
			$by = 'id_tarif';
			$order = 'DESC';
			$dataTarif = $this->MasterData->getWhereDataOrder($select,$table,$where,$by,$order)->result();


			// $this->head[] = "assets/assets/plugins/select2/dist/css/select2.css";
			// $this->head[] = "assets/assets/plugins/footable/css/footable.core.css";
			$this->head[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.css";
			$this->head[] = "assets/assets/plugins/sweetalert/sweetalert.css";
			// $this->head[] = "assets/assets/plugins/dropify/dist/css/dropify.min.css";

			// $this->foot[] = "assets/assets/plugins/select2/dist/js/select2.full.min.js";
			// $this->foot[] = "assets/assets/plugins/footable/js/footable.all.min.js";
			$this->foot[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.js";
			$this->foot[] = "assets/assets/plugins/sweetalert/sweetalert.min.js";
			$this->foot[] = "assets/assets/plugins/sweetalert/jquery.sweet-alert.custom.js";
			$this->foot[] = "assets/assets/plugins/datatables/jquery.dataTables.min.js";
			// $this->foot[] = "assets/main/js/footable-init.js";
			// $this->foot[] = "assets/assets/plugins/dropify/dist/js/dropify.min.js";

			$script = array(
				"$('#myTable').DataTable();",
				// "$('.select2').select2();",
				// "$('.dropify').dropify({
				// 	 messages: {
		  		//         default: '<center>Upload foto/gambar disini.</center>',
		  		//         error: '<center>Maksimal ukuran file 500 KB.</center>',
		  		//     }
				// });"
			);


			$css_link = array(
				"https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/css/lightbox.min.css"
			);

			$js_link = array(
				"https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/js/lightbox.min.js"
			);

			$head = array (
				'head' => $this->head,
				// 'css_link' => $css_link
			);
			$foot = array(
				'foot' =>  $this->foot,
				'script' => $script,
				// 'js_link' => $js_link
			);

			$nav['menu'] = 'tarif';

			$data = array(
				'dataTarif' => $dataTarif,
				'subTarif' => $ssxx
				// 'dataJenisUsaha' => $dataJenisUsaha,
				// 'dataKecamatan' => $dataKecamatan
			);

			$this->load->view('Petugas/head',$head);
			$this->load->view('Petugas/navigation',$nav);
			$this->load->view('Petugas/sub_tarif',$data);
			$this->load->view('foot',$foot);

		}
	}

	public function simpanSubTarif($id='') {

		if ($id != '') {
			$id_tarif = decode($id);
		} else {
			redirect(base_url().'Petugas/dataTarif');
		}	

		$input = $this->input->POST();
		// $sess['show_alert'] = 1;

		if ($input) {
			$data = array(
				'jenis_tarif' => $input['jenis_tarif'],
				'parent_id' => $input['parent_id'],
				'child_id' => 0,
				'satuan' => ($input['satuan']=='' || $input['satuan'] == null?'-':$input['satuan']),
				'tera_kantor' => str_replace(".", "", $input['tera_kantor']),
				'tera_tempat_pakai' => str_replace(".", "", $input['tera_tempat_pakai']),
				'tera_ulang_kantor' => str_replace(".", "", $input['tera_ulang_kantor']),
				'tera_ulang_tempat_pakai' => str_replace(".", "", $input['tera_ulang_tempat_pakai'])
			);
			$table = 'tbl_tarif';
			$inputData = $this->MasterData->inputData($data,$table);

			$data = array(
				'child_id' => 1
			);
			$where = "id_tarif = $input[parent_id]";
			$updateData = $this->MasterData->editData($where,$data,$table);

			if ($inputData && $updateData) {
				$sess['alert'] = alert_success('Data tarif berhasil disimpan.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Petugas/subTarif/'.encode($id_tarif));
			} else {
				$sess['alert'] = alert_failed('Data tarif gagal disimpan.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Petugas/subTarif/'.encode($id_tarif));
			}
		} else {
			$sess['alert'] = alert_failed('Data tarif gagal disimpan.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Petugas/subTarif/'.encode($id_tarif));
		}

		// var_dump($input);
	}

	public function updateSubTarif($id='') {

		if ($id != '') {
			$id_tarif = decode($id);
		} else {
			redirect(base_url().'Petugas/dataTarif');
		}	

		$input = $this->input->POST();
		// $sess['show_alert'] = 1;

		if ($input) {
			$data = array(
				'jenis_tarif' => $input['jenis_tarif'],
				'parent_id' => $input['parent_id'],
				// 'child_id' => 0,
				'satuan' => ($input['satuan']=='' || $input['satuan'] == null?'-':$input['satuan']),
				'tera_kantor' => str_replace(".", "", $input['tera_kantor']),
				'tera_tempat_pakai' => str_replace(".", "", $input['tera_tempat_pakai']),
				'tera_ulang_kantor' => str_replace(".", "", $input['tera_ulang_kantor']),
				'tera_ulang_tempat_pakai' => str_replace(".", "", $input['tera_ulang_tempat_pakai'])
			);
			$table = 'tbl_tarif';
			$where = "id_tarif = $input[id_tarif]";
			$updateData = $this->MasterData->editData($where,$data,$table);

			if ($updateData) {
				$sess['alert'] = alert_success('Data tarif berhasil diupdate.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Petugas/subTarif/'.encode($id_tarif));
			} else {
				$sess['alert'] = alert_failed('Data tarif gagal diupdate.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Petugas/subTarif/'.encode($id_tarif));
			}
		} else {
			$sess['alert'] = alert_failed('Data tarif gagal diupdate.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Petugas/subTarif/'.encode($id_tarif));
		}

		// var_dump($input);
	}

	public function deleteTarif($id='') {

		// if ($this->input->POST()) {
			// $id = $this->input->POST('id');

			$where = "id_tarif = '$id'";
			$table = 'tbl_tarif';
			$delete = $this->MasterData->deleteData($where,$table);

			if ($delete) {
				$select = '*';
				$where = "parent_id = $id";
				$dataTrf = $this->MasterData->getWhereData($select,$table,$where)->result();

				$xx = 0;
				foreach ($dataTrf as $trf) {
					$xx++;
					$id_trf = $trf->id_tarif;
					if ($trf->child_id > 0) {
						$this->deleteChildTarif($id_trf);
					} else {
						
						$where = "id_tarif = '$id_trf'";
						$table = 'tbl_tarif';
						$delete = $this->MasterData->deleteData($where,$table);
					}

					if ($xx == count($dataTrf)) {
						// echo "Success";
						$sess['alert'] = alert_success('Data tarif berhasil dihapus.');
						$this->session->set_flashdata($sess);
						redirect(base_url().'Petugas/dataTarif');
					}
				}
			} else {
				echo "Failed";
				$sess['alert'] = alert_failed('Data tarif gagal dihapus.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Petugas/dataTarif');
			}
		// } else {
		// 	echo "Failed";
		// 	$sess['alert'] = alert_failed('Data tarif gagal dihapus.');
		// 	$this->session->set_flashdata($sess);
		// 	redirect(base_url().'Petugas/dataTarif';
		// }
	}

	public function deleteSubTarif($ids='', $id='', $no='') {
		if ($ids != '') {
			$id_tarif = decode($ids);
		} 
		// else {
		// 	redirect(base_url().'Petugas/dataTarif');
		// }	

		// if ($this->input->POST()) {
			// $id = $this->input->POST('id');
			// $no = $this->input->POST('no');

			$where = "id_tarif = '$id'";
			$table = 'tbl_tarif';
			$delete = $this->MasterData->deleteData($where,$table);

			if ($delete) {
				if ($no == 1) {
					$data = array(
						'child_id' => 0
					);
					$where = "id_tarif = $id_tarif";
					$table = 'tbl_tarif';
					$updateData = $this->MasterData->editData($where,$data,$table);
				}

				$select = '*';
				$where = "parent_id = $id";
				$dataTrf = $this->MasterData->getWhereData($select,$table,$where)->result();

				$xx = 0;
				foreach ($dataTrf as $trf) {
					$xx++;
					$id_trf = $trf->id_tarif;
					if ($trf->child_id > 0) {
						$this->deleteChildTarif($id_trf);
					} else {
						
						$where = "id_tarif = '$id_trf'";
						$table = 'tbl_tarif';
						$delete = $this->MasterData->deleteData($where,$table);
					}

					if ($xx == count($dataTrf)) {
						// echo "Success";
						$sess['alert'] = alert_success('Data tarif berhasil dihapus.');
						$this->session->set_flashdata($sess);
						redirect(base_url().'Petugas/subTarif/'.encode($id_tarif));
					}
				}
				
				// echo "Success";
				// $sess['alert'] = alert_success('Data tarif berhasil dihapus.');
				// $this->session->set_flashdata($sess);
			} else {
				echo "Failed";
				$sess['alert'] = alert_failed('Data tarif gagal dihapus.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Petugas/subTarif/'.encode($id_tarif));
			}
		// } else {
		// 	echo "Failed";
		// 	$sess['alert'] = alert_failed('Data tarif gagal dihapus.');
		// 	$this->session->set_flashdata($sess);
		// }
	}

	public function deleteChildTarif($id='') {
		$where = "id_tarif = '$id'";
		$table = 'tbl_tarif';
		$delete = $this->MasterData->deleteData($where,$table);

		$select = '*';
		$where = "parent_id = $id";
		$table = 'tbl_tarif';
		$dataTrf = $this->MasterData->getWhereData($select,$table,$where)->result();

		$xx = 0;
		foreach ($dataTrf as $trf) {
			$xx++;
			$id_trf = $trf->id_tarif;
			if ($trf->child_id > 0) {
				$this->deleteChildTarif($id_trf);
			} else {
				
				$where = "id_tarif = '$id_trf'";
				$table = 'tbl_tarif';
				$delete = $this->MasterData->deleteData($where,$table);
			}

			// if ($xx == count($dataTrf)) {
			// 	break;
			// }
		}
	}

	// =====================================================

	public function akunLogin($value='') {
		$id_user = $this->id_user;

		$select = array(
			'usr.*'
		);
		$table = "tbl_user usr";
		$where = "usr.id_user = $id_user";
		$dataUser = $this->MasterData->getWhereData($select,$table,$where)->row();
		// $statusJl = $this->MasterData->getData('tbl_status_jalan')->result();

		$this->head[] = "assets/assets/plugins/select2/dist/css/select2.css";
		$this->head[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.css";
		$this->head[] = "assets/assets/plugins/sweetalert/sweetalert.css";
		// $this->head[] = "assets/assets/plugins/dropify/dist/css/dropify.min.css";

		$this->foot[] = "assets/assets/plugins/select2/dist/js/select2.full.min.js";
		$this->foot[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/sweetalert.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/jquery.sweet-alert.custom.js";
		$this->foot[] = "assets/assets/plugins/datatables/jquery.dataTables.min.js";
		// $this->foot[] = "assets/assets/plugins/dropify/dist/js/dropify.min.js";

		$script = array(
			"$('#myTable').DataTable();",
			"$('.select2').select2();",
			// "$('.dropify').dropify({
			// 	 messages: {
	  //               default: '<center>Upload foto/gambar disini.</center>',
	  //               error: '<center>Maksimal ukuran file 2 MB.</center>',
	  //           }
			// });"
		);


		$css_link = array(
			"https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/css/lightbox.min.css"
		);

		$js_link = array(
			"https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/js/lightbox.min.js"
		);

		$head = array (
			'head' => $this->head,
			// 'css_link' => $css_link
		);
		$foot = array(
			'foot' =>  $this->foot,
			'script' => $script,
			// 'js_link' => $js_link
		);

		$nav['menu'] = 'pass';

		$data = array(
			'dataUser' => $dataUser
		);

		$this->load->view('Petugas/head',$head);
		$this->load->view('Petugas/navigation',$nav);
		$this->load->view('Petugas/akun_login',$data);
		$this->load->view('foot',$foot);
	}

	public function simpanAkun($value='') {
		$id_user = $this->id_user;
		$post = $this->input->POST();

		if ($post) {
			$table = 'tbl_user';
			$where = "id_user = $id_user";
			$oldPass1 = $this->MasterData->getDataWhere($table,$where)->row()->password;
			$oldPass2 = md5($post['oldPass']);


			if ($oldPass1 == $oldPass2) {
				$data = array(
					'username' => $post['username'],
					'password' => md5($post['password'])
				);
				$updateData = $this->MasterData->editData($where,$data,$table);

				if ($updateData) {
					$sess['alert'] = alert_success('Data akun login berhasil disimpan.');
					$this->session->set_flashdata($sess);
					redirect(base_url().'Petugas/akunLogin');
				} else {
					$sess['alert'] = alert_failed('Data akun login gagal disimpan.');
					$this->session->set_flashdata($sess);
					redirect(base_url().'Petugas/akunLogin');
				}
			} else {
				$sess['alert'] = alert_failed('Password lama tidak sesuai.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Petugas/akunLogin');
			}
			
		} else {
			$sess['alert'] = alert_failed('Data akun login gagal disimpan.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Petugas/akunLogin');
		}
	}

	// =====================================================

	public function dataUser($value='') {

		$select = array(
			'usr.*'
		);
		$table = 'tbl_user usr';
		$where = "id_role = (SELECT role.id_role FROM tbl_role role WHERE role.nama_role = 'User')";
		$by = 'id_user';
		$order = 'DESC';
		$user = $this->MasterData->getWhereDataOrder($select,$table,$where,$by,$order);

		// ============================================================================

		$config['base_url'] = base_url().'/Petugas/dataUser';
		$config['total_rows'] = $user->num_rows();
		$config['per_page'] = 10;
		
		$config['num_links'] = 1;
		$config['display_pages'] = TRUE;
		$config['use_page_numbers'] = TRUE;
		$config['uri_segment'] = 3; //supaya tidak error karena base url dinamis
		$config['reuse_query_string'] = true; //supaya link pagination sesuai parameter get yang ada
 
        // Membuat Style pagination untuk BootStrap v4
        $config['first_link']       = '<span class="d-block d-sm-block d-md-none d-lg-none"> << </span> <span class="d-none d-sm-none d-md-block d-lg-block">First</span>';
        $config['last_link']        = '<span class="d-block d-sm-block d-md-none d-lg-none"> >> </span> <span class="d-none d-sm-none d-md-block d-lg-block">Last</span>';
        $config['next_link']        = '<span class="d-block d-sm-block d-md-none d-lg-none"> > </span> <span class="d-none d-sm-none d-md-block d-lg-block">Next</span>';
        $config['prev_link']        = '<span class="d-block d-sm-block d-md-none d-lg-none"> < </span> <span class="d-none d-sm-none d-md-block d-lg-block">Prev</span>';
        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tagl_close']  = '</span></li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tagl_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tagl_close']  = '</span></li>';
		
		$this->pagination->initialize($config);

		if($this->uri->segment(3) == null){
			$start_index = 0;
		}else{
			$start_index = ($this->uri->segment(3)-1)*$config['per_page'];
		}

		if ($start_index > 0) {
			$numbers = ($this->uri->segment(3)*$config['per_page'])-$config['per_page'];
		} else {
			$numbers = 0;
		}
		 
		
		$pages =  $this->pagination->create_links();

		// ==============================================================================

		$dataUser = $this->MasterData->getWhereDataLimitIndexOrder($select,$table,$where,$start_index,$config['per_page'],$by,$order)->result();

		// ===========================================================================

		$where = "nama_role = 'User'";
		$dataRole = $this->MasterData->getDataWhere('tbl_role',$where)->row();

		// ==========================================================================

		$this->head[] = "assets/assets/plugins/select2/dist/css/select2.css";
		$this->head[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.css";
		$this->head[] = "assets/assets/plugins/sweetalert/sweetalert.css";
		// $this->head[] = "assets/assets/plugins/dropify/dist/css/dropify.min.css";

		$this->foot[] = "assets/assets/plugins/select2/dist/js/select2.full.min.js";
		$this->foot[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/sweetalert.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/jquery.sweet-alert.custom.js";
		$this->foot[] = "assets/assets/plugins/datatables/jquery.dataTables.min.js";
		// $this->foot[] = "assets/assets/plugins/dropify/dist/js/dropify.min.js";

		$script = array(
			"$('#myTable').DataTable();",
			"$('.select2').select2();",
			// "$('.dropify').dropify({
			// 	 messages: {
	  //               default: '<center>Upload foto/gambar disini.</center>',
	  //               error: '<center>Maksimal ukuran file 500 KB.</center>',
	  //           }
			// });"
	        // "$('.selectpicker').selectpicker();"
		);

		$head = array (
			'head' => $this->head,
			// 'css_link' => $css_link
		);
		$foot = array(
			'foot' =>  $this->foot,
			'script' => $script,
			// 'js_link' => $js_link
		);

		$nav['menu'] = 'user';

		$data = array(
			'data_user' => $dataUser,
			'id_role' => $dataRole->id_role,
			'pages' => $pages,
			'numbers' => $numbers
		);

		$this->load->view('head',$head);
		$this->load->view('Petugas/navigation',$nav);
		$this->load->view('Petugas/user',$data);
		$this->load->view('foot',$foot);
	}

	public function tambahDataUser($value='') {
		$post = $this->input->POST();

		if ($post) {
			$data = array();
			foreach ($post as $key => $val) {
				if ($key == 'password') {
					$data[$key] = md5($val);
				} else {
					$data[$key] = $val;
				}
			}

			$no_hp = $post['no_hp'];

			$select = 'no_hp';
			$table = 'tbl_user';
			$where = "no_hp = '$no_hp'";
			$cekNoHp = $this->MasterData->getWhereData($select,$table,$where)->num_rows();

			if ($cekNoHp == 0) {

				$inputData = $this->MasterData->inputData($data,$table);

				if ($inputData) {

					$select = 'nama_role';
					$where = "id_role = '$post[id_role]'";
					$namaRole = $this->MasterData->getWhereData($select,'tbl_role',$where)->row()->nama_role;

					$noTelp = $no_hp;
					$pesan = "Akun SiMetro Anda\nNama User: ".$post['nama_user']."\nUsername: ".$post['username']."\nPassword: ".$post['password']."\n\nAnda terdaftar sebagai ".strtoupper($namaRole);

			        $cekID = $this->sms->query("SHOW TABLE STATUS LIKE 'outbox'")->row();
			        $newID = $cekID->Auto_increment;

			        $data = array(
			            'DestinationNumber' => $noTelp,
			            'TextDecoded' => $pesan,
			            'ID' => $newID,
			            'MultiPart' => 'false',
			            'CreatorID' => 'SiMetro'
			        );

			        $table = 'outbox';
			        $input_msg = $this->MasterData->sendMsg($data,$table);

			        // ==========================================================

					$sess['alert'] = alert_success('Data user berhasil disimpan.');
					$this->session->set_flashdata($sess);
					redirect(base_url().'Petugas/dataUser');
				} else {
					$sess['alert'] = alert_failed('Data user gagal disimpan.');
					$this->session->set_flashdata($sess);
					redirect(base_url().'Petugas/dataUser');
				}

			} else {
				$sess['alert'] = alert_failed('Nomor HP sudah terdaftar.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Petugas/dataUser');
			}

		} else {
			$sess['alert'] = alert_failed('Data user gagal disimpan.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Petugas/dataUser');
		}
	}

	public function updateDataUser($urii='') {
		$post = $this->input->POST();

		if ($post) {
			$data = array();
			$newPass = '';
			foreach ($post as $key => $val) {
				if ($key == 'password') {
					if ($val != '' || $val != null) {
						$data[$key] = md5($val);
						$newPass = $val;
					} else {
						$newPass = 'Tidak berubah';
					}
				} else {
					if ($key != 'id_user') {
						$data[$key] = $val;
					}
				}
			}

			$no_hp = $post['no_hp'];

			$select = 'no_hp';
			$table = 'tbl_user';
			$where = "id_user = '$post[id_user]'";
			$cekNoHpOld = $this->MasterData->getWhereData($select,$table,$where)->row()->no_hp;

			if ($no_hp == $cekNoHpOld) {

				$where = "id_user = '$post[id_user]'";
				$updateData = $this->MasterData->editData($where,$data,$table);

				if ($updateData) {

					$select = 'nama_role';
					$where = "id_role = '$post[id_role]'";
					$namaRole = $this->MasterData->getWhereData($select,'tbl_role',$where)->row()->nama_role;

					$noTelp = $no_hp;
					$pesan = "Akun SiMetro Anda\nNama User: ".$post['nama_user']."\nUsername: ".$post['username']."\nPassword: ".$newPass."\n\nAnda terdaftar sebagai ".strtoupper($namaRole);

			        $cekID = $this->sms->query("SHOW TABLE STATUS LIKE 'outbox'")->row();
			        $newID = $cekID->Auto_increment;

			        $data = array(
			            'DestinationNumber' => $noTelp,
			            'TextDecoded' => $pesan,
			            'ID' => $newID,
			            'MultiPart' => 'false',
			            'CreatorID' => 'SiMetro'
			        );

			        $table = 'outbox';
			        $input_msg = $this->MasterData->sendMsg($data,$table);

			        // ===============================================================

					$sess['alert'] = alert_success('Data user berhasil diupdate.');
					$this->session->set_flashdata($sess);
					redirect(base_url().'Petugas/dataUser/'.$urii);
				} else {
					$sess['alert'] = alert_failed('Data user gagal diupdate.');
					$this->session->set_flashdata($sess);
					redirect(base_url().'Petugas/dataUser/'.$urii);
				}
			} else {
				$where = "no_hp = '$no_hp'";
				$cekNoHp = $this->MasterData->getWhereData($select,$table,$where)->num_rows();

				if ($cekNoHp == 0) {

					$where = "id_user = '$post[id_user]'";
					$updateData = $this->MasterData->editData($where,$data,$table);

					if ($updateData) {

						$select = 'nama_role';
						$where = "id_role = '$post[id_role]'";
						$namaRole = $this->MasterData->getWhereData($select,'tbl_role',$where)->row()->nama_role;

						$noTelp = $no_hp;
						$pesan = "Akun SiMetro Anda\nNama User: ".$post['nama_user']."\nUsername: ".$post['username']."\nPassword: ".$newPass."\n\nAnda terdaftar sebagai ".strtoupper($namaRole);

				        $cekID = $this->sms->query("SHOW TABLE STATUS LIKE 'outbox'")->row();
				        $newID = $cekID->Auto_increment;

				        $data = array(
				            'DestinationNumber' => $noTelp,
				            'TextDecoded' => $pesan,
				            'ID' => $newID,
				            'MultiPart' => 'false',
				            'CreatorID' => 'SiMetro'
				        );

				        $table = 'outbox';
				        $input_msg = $this->MasterData->sendMsg($data,$table);

						$sess['alert'] = alert_success('Data user berhasil diupdate.');
						$this->session->set_flashdata($sess);
						redirect(base_url().'Petugas/dataUser/'.$urii);
					} else {
						$sess['alert'] = alert_failed('Data user gagal diupdate.');
						$this->session->set_flashdata($sess);
						redirect(base_url().'Petugas/dataUser/'.$urii);
					}

				} else {
					$sess['alert'] = alert_failed('Nomor HP sudah terdaftar.');
					$this->session->set_flashdata($sess);
					redirect(base_url().'Petugas/dataUser/'.$urii);
				}

			}

		} else {
			$sess['alert'] = alert_failed('Data user gagal diupdate.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Petugas/dataUser/'.$urii);
		}
	}

	public function deleteDataUser($id='') {
		// $id = $this->input->POST('id');

		$where = "id_user = '$id'";
		$table = 'tbl_user';
		$delete = $this->MasterData->deleteData($where,$table);

		if ($delete) {
			// echo "Success";
			$sess['alert'] = alert_success('Data user berhasil dihapus.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Petugas/dataUser');
		} else {
			// echo "Failed";
			$sess['alert'] = alert_failed('Data user gagal dihapus.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Petugas/dataUser');
		}
	}

	// =====================================================

	public function dataUsaha($id='', $uri=''){
		if ($id != '') {
			$id_user = decode($id);
		}

		if ($uri != '') {
			$urii = decode($uri);
		} else {
			$urii = $uri;
		}
		

		$select = 'nama_user';
		$where = "id_user = $id_user";
		$dataUser = $this->MasterData->getWhereData($select,'tbl_user',$where)->row();

		// $id_user = $this->id_user;
		$select = array(
			'ush.*',
			"(SELECT jns.nama_jenis_usaha FROM tbl_jenis_usaha jns WHERE jns.id_jenis_usaha = ush.id_jenis_usaha) jenis_usaha",
			"(SELECT desa.nama_desa FROM tbl_desa desa WHERE desa.kode_desa = ush.kode_desa) desa",
			"(SELECT kec.nama_kecamatan FROM tbl_kecamatan kec, tbl_desa desa WHERE desa.kode_desa = ush.kode_desa AND desa.kode_kecamatan = kec.kode_kecamatan) kecamatan"
		);
		$table = "tbl_usaha ush";
		$where = "id_user = '$id_user'";
		$by = 'id_usaha';
		$order = 'DESC';
		$dataUsaha = $this->MasterData->getWhereDataOrder($select,$table,$where,$by,$order)->result();

		$dataJenisUsaha = $this->MasterData->getData('tbl_jenis_usaha')->result();
		$dataKecamatan = $this->MasterData->getData('tbl_kecamatan')->result();
		// $statusJl = $this->MasterData->getData('tbl_status_jalan')->result();

		$this->head[] = "assets/assets/plugins/select2/dist/css/select2.css";
		$this->head[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.css";
		$this->head[] = "assets/assets/plugins/sweetalert/sweetalert.css";
		// $this->head[] = "assets/assets/plugins/dropify/dist/css/dropify.min.css";

		$this->foot[] = "assets/assets/plugins/select2/dist/js/select2.full.min.js";
		$this->foot[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/sweetalert.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/jquery.sweet-alert.custom.js";
		$this->foot[] = "assets/assets/plugins/datatables/jquery.dataTables.min.js";
		// $this->foot[] = "assets/assets/plugins/dropify/dist/js/dropify.min.js";

		$script = array(
			"$('#myTable').DataTable();",
			"$('.select2').select2();",
			// "$('.dropify').dropify({
			// 	 messages: {
	  //               default: '<center>Upload foto/gambar disini.</center>',
	  //               error: '<center>Maksimal ukuran file 500 KB.</center>',
	  //           }
			// });"
		);


		$css_link = array(
			"https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/css/lightbox.min.css"
		);

		$js_link = array(
			"https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/js/lightbox.min.js"
		);

		$head = array (
			'head' => $this->head,
			// 'css_link' => $css_link
		);
		$foot = array(
			'foot' =>  $this->foot,
			'script' => $script,
			// 'js_link' => $js_link
		);

		$nav['menu'] = 'user';

		$data = array(
			'dataUsaha' => $dataUsaha,
			'dataJenisUsaha' => $dataJenisUsaha,
			'dataKecamatan' => $dataKecamatan,
			'idUser' => $id_user,
			'namaUser' => $dataUser->nama_user,
			'uri' => $urii
		);

		$this->load->view('Petugas/head',$head);
		$this->load->view('Petugas/navigation',$nav);
		$this->load->view('Petugas/usaha',$data);
		$this->load->view('foot',$foot);
	}

	public function simpanUsaha($uri='') {
		// $id_user = $this->id_user;
		$input = $this->input->POST();

		if ($input) {
			$data = array(
				'id_user' => $input['id_user'],
				'id_jenis_usaha' => $input['jenis_usaha'],
				'nama_usaha' => $input['nama_usaha'],
				'kode_desa' => $input['kode_desa'],
				'alamat' => $input['alamat']
			);
			$table = 'tbl_usaha';
			$inputData = $this->MasterData->inputData($data,$table);

			if ($inputData) {
				$sess['alert'] = alert_success('Data usaha berhasil disimpan.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Petugas/dataUsaha/'.encode($input['id_user']).'/'.encode($uri));
			} else {
				$sess['alert'] = alert_failed('Data usaha gagal disimpan.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Petugas/dataUsaha/'.encode($input['id_user']).'/'.encode($uri));
			}
		} else {
			$sess['alert'] = alert_failed('Data usaha gagal disimpan.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Petugas/dataUsaha/'.encode($input['id_user']).'/'.encode($uri));
		}

		// var_dump($input);
	}

	public function getDataEditUsaha($value='') {
		$id_usaha = $this->input->POST('id');

		$where = "id_usaha = $id_usaha";
		$data = $this->MasterData->getDataWhere('tbl_usaha',$where)->row();

		$kode_desa = $data->kode_desa;
		$where = "kode_desa = $kode_desa";
		$kodeKec = $this->MasterData->getDataWhere('tbl_desa',$where)->row()->kode_kecamatan;

		$where = "kode_kecamatan = $kodeKec";
		$dataDesa = $this->MasterData->getDataWhere('tbl_desa',$where)->result();

		if ($dataDesa) {
			$result = array(
				'response' => true,
				'data' => $data,
				'kode_kecamatan' => $kodeKec,
				'dataDesa' => $dataDesa
			);
		} else {
			$result = array(
				'response' => false
			);
		}

		echo json_encode($result);
	}

	public function updateUsaha($uri='') {
		$input = $this->input->POST();

		if ($input) {
			$data = array(
				// 'id_user' => $id_user,
				'id_jenis_usaha' => $input['jenis_usaha'],
				'nama_usaha' => $input['nama_usaha'],
				'kode_desa' => $input['kode_desa'],
				'alamat' => $input['alamat']
			);
			$table = 'tbl_usaha';
			$where = "id_usaha = $input[id_usaha]";
			$updateData = $this->MasterData->editData($where,$data,$table);

			if ($updateData) {
				$sess['alert'] = alert_success('Data usaha berhasil diupdate.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Petugas/dataUsaha/'.encode($input['id_user']).'/'.encode($uri));
			} else {
				$sess['alert'] = alert_failed('Data usaha gagal diupdate.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Petugas/dataUsaha/'.encode($input['id_user']).'/'.encode($uri));
			}
		} else {
			$sess['alert'] = alert_failed('Data usaha gagal diupdate.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Petugas/dataUsaha/'.encode($input['id_user']).'/'.encode($uri));
		}
	}

	public function deleteUsaha($value='') {

		if ($this->input->POST()) {
			$id = $this->input->POST('id');

			$where = "id_usaha = '$id'";
			$table = 'tbl_usaha';
			$delete = $this->MasterData->deleteData($where,$table);

			if ($delete) {
				echo "Success";
				$sess['alert'] = alert_success('Data usaha berhasil dihapus.');
				$this->session->set_flashdata($sess);
			} else {
				echo "Failed";
				$sess['alert'] = alert_failed('Data usaha gagal dihapus.');
				$this->session->set_flashdata($sess);
			}
		} else {
			echo "Failed";
			$sess['alert'] = alert_failed('Data usaha gagal dihapus.');
			$this->session->set_flashdata($sess);
		}
	}

	// =========================================================

	public function dataPetugas($value='') {

		$select = array(
			'usr.*',
			"(SELECT jbt.nama_jabatan FROM tbl_jabatan jbt WHERE jbt.id_jabatan = (SELECT pt.id_jabatan FROM tbl_petugas pt WHERE pt.id_user = usr.id_user)) jabatan",
			"(SELECT pt.id_jabatan FROM tbl_petugas pt WHERE pt.id_user = usr.id_user) id_jabatan",
			"(SELECT pt.nip FROM tbl_petugas pt WHERE pt.id_user = usr.id_user) nip"
		);
		$table = 'tbl_user usr';
		$where = "id_user IN (SELECT pt.id_user FROM tbl_petugas pt)";
		$by = 'id_user';
		$order = 'DESC';
		$dataUser = $this->MasterData->getWhereDataOrder($select,$table,$where,$by,$order)->result();

		$where = "nama_role = 'Petugas'";
		$dataRole = $this->MasterData->getDataWhere('tbl_role',$where)->row();

		$dataJabatan = $this->MasterData->getData('tbl_jabatan')->result();

		$this->head[] = "assets/assets/plugins/select2/dist/css/select2.css";
		$this->head[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.css";
		$this->head[] = "assets/assets/plugins/sweetalert/sweetalert.css";
		// $this->head[] = "assets/assets/plugins/dropify/dist/css/dropify.min.css";

		$this->foot[] = "assets/assets/plugins/select2/dist/js/select2.full.min.js";
		$this->foot[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/sweetalert.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/jquery.sweet-alert.custom.js";
		$this->foot[] = "assets/assets/plugins/datatables/jquery.dataTables.min.js";
		// $this->foot[] = "assets/assets/plugins/dropify/dist/js/dropify.min.js";

		$script = array(
			"$('#myTable').DataTable();",
			"$('.select2').select2();",
			// "$('.dropify').dropify({
			// 	 messages: {
	  //               default: '<center>Upload foto/gambar disini.</center>',
	  //               error: '<center>Maksimal ukuran file 500 KB.</center>',
	  //           }
			// });"
	        // "$('.selectpicker').selectpicker();"
		);

		$head = array (
			'head' => $this->head,
			// 'css_link' => $css_link
		);
		$foot = array(
			'foot' =>  $this->foot,
			'script' => $script,
			// 'js_link' => $js_link
		);

		$nav['menu'] = 'petugas';

		$data = array(
			'data_user' => $dataUser,
			'id_role' => $dataRole->id_role,
			'jabatan' => $dataJabatan
		);

		$this->load->view('head',$head);
		$this->load->view('Petugas/navigation',$nav);
		$this->load->view('Petugas/petugas',$data);
		$this->load->view('foot',$foot);
	}

	public function tambahDataPetugas($value='') {
		$post = $this->input->POST();

		if ($post) {
			$data = array();
			foreach ($post as $key => $val) {
				if ($key != 'jabatan') {
					if ($key != 'nip') {
						if ($key == 'password') {
							$data[$key] = md5($val);
						} else {
							$data[$key] = $val;
						}
					}
				}
			}

			$no_hp = $post['no_hp'];

			$select = 'no_hp';
			$table = 'tbl_user';
			$where = "no_hp = '$no_hp'";
			$cekNoHp = $this->MasterData->getWhereData($select,$table,$where)->num_rows();

			if ($cekNoHp == 0) {

				$inputData = $this->MasterData->inputData($data,$table);

				if ($inputData) {
					$id_user = $this->db->insert_id();
					$data = array(
						'id_user' => $id_user,
						'id_jabatan' => $post['jabatan'],
						'nip' => $post['nip']
					);
					$inputPetugas = $this->MasterData->inputData($data,'tbl_petugas');

					$select = 'nama_role';
					$where = "id_role = '$post[id_role]'";
					$namaRole = $this->MasterData->getWhereData($select,'tbl_role',$where)->row()->nama_role;

					$noTelp = $no_hp;
					$pesan = "Akun SiMetro Anda\nNama User: ".$post['nama_user']."\nUsername: ".$post['username']."\nPassword: ".$post['password']."\n\nAnda terdaftar sebagai ".strtoupper($namaRole);

			        $cekID = $this->sms->query("SHOW TABLE STATUS LIKE 'outbox'")->row();
			        $newID = $cekID->Auto_increment;

			        $data = array(
			            'DestinationNumber' => $noTelp,
			            'TextDecoded' => $pesan,
			            'ID' => $newID,
			            'MultiPart' => 'false',
			            'CreatorID' => 'SiMetro'
			        );

			        $table = 'outbox';
			        $input_msg = $this->MasterData->sendMsg($data,$table);

					if ($inputPetugas) {
						$sess['alert'] = alert_success('Data petugas berhasil disimpan.');
						$this->session->set_flashdata($sess);
						redirect(base_url().'Petugas/dataPetugas');
					} else {
						$sess['alert'] = alert_failed('Data petugas gagal disimpan.');
						$this->session->set_flashdata($sess);
						redirect(base_url().'Petugas/dataPetugas');
					}

				} else {
					$sess['alert'] = alert_failed('Data petugas gagal disimpan.');
					$this->session->set_flashdata($sess);
					redirect(base_url().'Petugas/dataPetugas');
				}

			} else {
				$sess['alert'] = alert_failed('Nomor HP sudah terdaftar.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Petugas/dataPetugas');
			}

		} else {
			$sess['alert'] = alert_failed('Data petugas gagal disimpan.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Petugas/dataPetugas');
		}
	}

	public function updateDataPetugas($value='') {
		$post = $this->input->POST();

		if ($post) {
			$data = array();
			$newPass = '';
			foreach ($post as $key => $val) {
				if ($key != 'jabatan') {
					if ($key != 'nip') {
						if ($key == 'password') {
							if ($val != '' || $val != null) {
								$data[$key] = md5($val);
								$newPass = $val;
							} else {
								$newPass = 'Tidak berubah';
							}
						} else {
							if ($key != 'id_user') {
								$data[$key] = $val;
							}
						}
					}
				}
			}

			$no_hp = $post['no_hp'];

			$select = 'no_hp';
			$table = 'tbl_user';
			$where = "id_user = '$post[id_user]'";
			$cekNoHpOld = $this->MasterData->getWhereData($select,$table,$where)->row()->no_hp;

			if ($no_hp == $cekNoHpOld) {

				$where = "id_user = '$post[id_user]'";
				$updateData = $this->MasterData->editData($where,$data,$table);

				if ($updateData) {

					$datas = array(
						// 'id_user' => $id_user,
						'id_jabatan' => $post['jabatan'],
						'nip' => $post['nip']
					);
					$updatePetugas = $this->MasterData->MasterData->editData($where,$datas,'tbl_petugas');

					$select = 'nama_role';
					$where = "id_role = '$post[id_role]'";
					$namaRole = $this->MasterData->getWhereData($select,'tbl_role',$where)->row()->nama_role;

					$noTelp = $no_hp;
					$pesan = "Akun SiMetro Anda\nNama User: ".$post['nama_user']."\nUsername: ".$post['username']."\nPassword: ".$newPass."\n\nAnda terdaftar sebagai ".strtoupper($namaRole);

			        $cekID = $this->sms->query("SHOW TABLE STATUS LIKE 'outbox'")->row();
			        $newID = $cekID->Auto_increment;

			        $data = array(
			            'DestinationNumber' => $noTelp,
			            'TextDecoded' => $pesan,
			            'ID' => $newID,
			            'MultiPart' => 'false',
			            'CreatorID' => 'SiMetro'
			        );

			        $table = 'outbox';
			        $input_msg = $this->MasterData->sendMsg($data,$table);

					if ($updatePetugas) {
						$sess['alert'] = alert_success('Data petugas berhasil diupdate.');
						$this->session->set_flashdata($sess);
						redirect(base_url().'Petugas/dataPetugas');
					} else {
						$sess['alert'] = alert_failed('Data petugas gagal diupdate.');
						$this->session->set_flashdata($sess);
						redirect(base_url().'Petugas/dataPetugas');
					}
					
				} else {
					$sess['alert'] = alert_failed('Data petugas gagal diupdate.');
					$this->session->set_flashdata($sess);
					redirect(base_url().'Petugas/dataPetugas');
				}
			} else {
				$where = "no_hp = '$no_hp'";
				$cekNoHp = $this->MasterData->getWhereData($select,$table,$where)->num_rows();

				if ($cekNoHp == 0) {

					$where = "id_user = '$post[id_user]'";
					$updateData = $this->MasterData->editData($where,$data,$table);

					if ($updateData) {

						$datas = array(
							// 'id_user' => $id_user,
							'id_jabatan' => $post['jabatan'],
							'nip' => $post['nip']
						);
						$updatePetugas = $this->MasterData->MasterData->editData($where,$datas,'tbl_petugas');

						$select = 'nama_role';
						$where = "id_role = '$post[id_role]'";
						$namaRole = $this->MasterData->getWhereData($select,'tbl_role',$where)->row()->nama_role;

						$noTelp = $no_hp;
						$pesan = "Akun SiMetro Anda\nNama User: ".$post['nama_user']."\nUsername: ".$post['username']."\nPassword: ".$newPass."\n\nAnda terdaftar sebagai ".strtoupper($namaRole);

				        $cekID = $this->sms->query("SHOW TABLE STATUS LIKE 'outbox'")->row();
				        $newID = $cekID->Auto_increment;

				        $data = array(
				            'DestinationNumber' => $noTelp,
				            'TextDecoded' => $pesan,
				            'ID' => $newID,
				            'MultiPart' => 'false',
				            'CreatorID' => 'SiMetro'
				        );

				        $table = 'outbox';
				        $input_msg = $this->MasterData->sendMsg($data,$table);

						if ($updatePetugas) {
							$sess['alert'] = alert_success('Data petugas berhasil diupdate.');
							$this->session->set_flashdata($sess);
							redirect(base_url().'Petugas/dataPetugas');
						} else {
							$sess['alert'] = alert_failed('Data petugas gagal diupdate.');
							$this->session->set_flashdata($sess);
							redirect(base_url().'Petugas/dataPetugas');
						}

					} else {
						$sess['alert'] = alert_failed('Data petugas gagal diupdate.');
						$this->session->set_flashdata($sess);
						redirect(base_url().'Petugas/dataPetugas');
					}

				} else {
					$sess['alert'] = alert_failed('Nomor HP sudah terdaftar.');
					$this->session->set_flashdata($sess);
					redirect(base_url().'Petugas/dataPetugas');
				}

			}

		} else {
			$sess['alert'] = alert_failed('Data petugas gagal diupdate.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Petugas/dataPetugas');
		}
	}

	public function deleteDataPetugas($id='') {
		// $id = $this->input->POST('id');

		$where = "id_user = '$id'";
		$table = 'tbl_user';
		$delete = $this->MasterData->deleteData($where,$table);

		if ($delete) {
			// echo "Success";
			$sess['alert'] = alert_success('Data petugas berhasil dihapus.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Petugas/dataPetugas');
		} else {
			// echo "Failed";
			$sess['alert'] = alert_failed('Data petugas gagal dihapus.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Petugas/dataPetugas');
		}
	}

	// =====================================================

	public function getDataUser($value='') {
		$input = $_GET['term'];

		$select = array(
			'usr.*'
		);
		$table = 'tbl_user usr';
		$field = 'usr.nama_user';
		$keyword = $input;
		$limit = 10;
		$where = "id_role = (SELECT role.id_role FROM tbl_role role WHERE role.nama_role = 'User')";
		$dataUser = $this->MasterData->getWhereDataLikeLimit($select,$table,$where,$field,$keyword,$limit)->result();

		if ($dataUser) {
			// $result = array(
			// 	'response' => true,
			// 	'data' => $dataUser
			// );
			foreach ($dataUser as $usr) {
				if ($usr->alamat_user != null || $usr->alamat_user != '') {
					$label = $usr->nama_user.' - '.$usr->alamat_user;
				} else {
					$label = $usr->nama_user;
				}
				$result[] = array(
                    'id' => $usr->id_user,
                    'label' => $label
                );

                // $result[] =  $usr->nama_user.' '.$usr->alamat_user.'-'.$usr->id_user;
			}
			echo json_encode($result);
		} 
	}

	public function getDataPetugas($value='') {
		$input = $_GET['term'];

		$select = array(
			'usr.*',
			"(SELECT pt.nip FROM tbl_petugas pt WHERE pt.id_user = usr.id_user) nip",
			"(SELECT pt.id_petugas FROM tbl_petugas pt WHERE pt.id_user = usr.id_user) id_petugas"
		);
		$table = 'tbl_user usr';
		$field = 'usr.nama_user';
		$keyword = $input;
		$limit = 10;
		$where = "usr.id_user IN (SELECT id_user FROM tbl_petugas)";
		$dataUser = $this->MasterData->getWhereDataLikeLimit($select,$table,$where,$field,$keyword,$limit)->result();

		if ($dataUser) {
			foreach ($dataUser as $usr) {
				if ($usr->nip != null || $usr->nip != '') {
					$label = $usr->nama_user.' - '.$usr->nip;
				} else {
					$label = $usr->nama_user;
				}
				$result[] = array(
                    'id' => $usr->id_petugas,
                    'label' => $label
                );

                // $result[] =  $usr->nama_user.' '.$usr->alamat_user.'-'.$usr->id_user;
			}
			echo json_encode($result);
		} 
	}

	public function getDataUserKelPasar($value='') {
		$input = $_GET['term'];

		$select = array(
			'usr.*'
		);
		$table = 'tbl_user usr';
		$field = 'usr.nama_user';
		$keyword = $input;
		$limit = 10;
		$where = "id_role = (SELECT role.id_role FROM tbl_role role WHERE role.nama_role = 'User') AND usr.id_user NOT IN (SELECT ush.id_user FROM tbl_usaha ush WHERE ush.id_usaha IN (SELECT grp.id_usaha FROM tbl_grup_pasar grp))";
		$dataUser = $this->MasterData->getWhereDataLikeLimit($select,$table,$where,$field,$keyword,$limit)->result();

		if ($dataUser) {
			// $result = array(
			// 	'response' => true,
			// 	'data' => $dataUser
			// );
			foreach ($dataUser as $usr) {
				if ($usr->alamat_user != null || $usr->alamat_user != '') {
					$label = $usr->nama_user.' - '.$usr->alamat_user;
				} else {
					$label = $usr->nama_user;
				}
				$result[] = array(
                    'id' => $usr->id_user,
                    'label' => $label
                );

                // $result[] =  $usr->nama_user.' '.$usr->alamat_user.'-'.$usr->id_user;
			}
			echo json_encode($result);
		} 
	}

	// =========================================================

	public function getDataDesa($value='') {

		if ($this->input->POST()) {
			$kode_kec = $this->input->POST('kode_kecamatan');

			$where = "kode_kecamatan = '$kode_kec'";
			$data = $this->MasterData->getDataWhere('tbl_desa',$where)->result();

			if ($data) {
				$result = array(
					'response' => true,
					'data' => $data
				);
			} else {
				$result = array(
					'response' => false
				);
			}
		} else {
			$result = array(
				'response' => false
			);
		}

		echo json_encode($result);
	}
}

