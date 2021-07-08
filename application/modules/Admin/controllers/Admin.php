<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin extends CI_Controller {
	function __construct(){
		parent:: __construct();
		$this->load->model('MasterData');
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->helper('alert');
		$this->load->helper('encrypt');
		$this->load->helper('uang');
		$this->load->helper('terbilang');
		$this->load->helper('tanggal');
		$this->load->helper('striptag');

		$this->load->helper('email');
		$this->load->helper('wa');

		// phpinfo();exit();
		// $this->sms = $this->load->database('sms', TRUE);

		if ($this->session->userdata('logs') != 'Sim_Admin') {
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
		$this->load->view('Admin/head',$data, TRUE);	
		// ======================================================================
		$select = "COUNT(id_daftar) jml_masuk";
		$table = 'tbl_pendaftaran dft';
		$where = "status = 'pending' AND user_daftar = 'user'";
		$count['masuk'] = $this->MasterData->getWhereData($select,$table,$where)->row()->jml_masuk;
		// ========================================================
		$select = "COUNT(id_daftar) jml_masuk";
		$table = 'tbl_pendaftaran dft';
		$where = "id_tempat_tera = '1' AND status = 'proses' AND input_hasil = 'belum'";
		$count['uji_kantor'] = $this->MasterData->getWhereData($select,$table,$where)->row()->jml_masuk;
		$where = "id_tempat_tera = '2' AND status = 'proses' AND input_hasil = 'belum'";
		$count['uji_pasar'] = $this->MasterData->getWhereData($select,$table,$where)->row()->jml_masuk;
		$where = "id_tempat_tera = '3' AND status = 'proses' AND input_hasil = 'belum'";
		$count['uji_pemilik'] = $this->MasterData->getWhereData($select,$table,$where)->row()->jml_masuk;
		// =========================================================
		$select = "COUNT(id_uttp) jml_uttp";
		$table = "tbl_uttp uttp";
		$where = "uttp.tgl_tera_ulang BETWEEN CURDATE() AND DATE_SUB(CURDATE(), INTERVAL -30 DAY)";
		$count['jml_uttp'] = $this->MasterData->getWhereData($select,$table,$where)->row()->jml_uttp;
		$this->load->view('Admin/navigation',$count, TRUE);
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
		$where = "date(tgl_daftar) = date(now()) AND status != 'belum kirim'";
		$lap_harian = $this->MasterData->getWhereData($select,$table,$where)->num_rows();
		$where = "YEARWEEK(tgl_daftar) = YEARWEEK(NOW()) AND status != 'belum kirim'";
		$lap_mingguan = $this->MasterData->getWhereData($select,$table,$where)->num_rows();
		$where = "MONTH(tgl_daftar) = MONTH(now()) AND YEAR(tgl_daftar) = YEAR(now()) AND status != 'belum kirim'";
		$lap_bulanan = $this->MasterData->getWhereData($select,$table,$where)->num_rows();
		$where = "YEAR(tgl_daftar) = YEAR(now()) AND status != 'belum kirim'";
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
		$where = "YEAR(tgl_daftar) = '$thn' AND status != 'belum kirim'";
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
		$this->load->view('Admin/head',$head);
		$this->load->view('Admin/navigation',$nav);
		$this->load->view('Admin/dashboard',$data);
		$this->load->view('foot',$foot);
	}
	// =====================================================
	public function lapSetoran($bln='', $thn='', $psr='') {
		if ($thn != '' && $thn != 'null') {
			$tahun = decode($thn);
		} else {
			$tahun = date('Y');			
		}

		// var_dump($tahun);exit();

		$where = "year(tgl_bayar) = $tahun";
		if ($bln != '') {
			$bulan = decode($bln);
		} else {
			$bulan = date('m');
		}

		$where .= " AND month(tgl_bayar) = $bulan";
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
		// ==============================================================================================
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
		$this->load->view('Admin/head',$head);
		$this->load->view('Admin/navigation',$nav);
		$this->load->view('Admin/data_setoran',$data);
		$this->load->view('foot',$foot);
	}

	public function cetakLapSetoran($bln='', $thn='', $psr='') {
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
		$select = array(
			'pt.*',
			"(SELECT usr.nama_user FROM tbl_user usr WHERE usr.id_user = pt.id_user) nama_user"
		);
		$where = "id_jabatan = (SELECT jb.id_jabatan FROM tbl_jabatan jb WHERE  jb.nama_jabatan = 'Kepala Dinas')";
		$table = 'tbl_petugas pt';
		$kepalaDinas = $this->MasterData->getWhereData($select,$table,$where)->row();
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
			'dataBulan' => $dataBulan,
			'kepalaDinas' => $kepalaDinas,
		);
		$this->load->library('PhpExcelNew/PHPExcel');
		$this->load->view('Admin/laporan/printLaporan',$data);
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
	public function lapPad($bln='', $thn='') {
		if ($thn != '') {
			$tahun = decode($thn);
		} else {
			// $tahun = date('Y');	
			$select = array(
				'tahun_pad'
			);
			$limit = 1;
			$by = 'tahun_pad';
			$order = 'DESC';
			$table = 'tbl_target_pad';
			$tahunPad = $this->MasterData->getDataLimitOrder($select,$table,$limit,$by,$order)->row();	
			if ($tahunPad != null || $tahunPad != '') {
				$tahun = $tahunPad->tahun_pad;
			} else {
				$tahun = null;
			}
		}
		if ($bln != '') {
			$bulan = decode($bln);
		} else {
			$bulan = date('m');
		}
		if ($tahun != '' || $tahun != null) { 
			$select = '*';
			$where = "year(tgl_daftar) = $tahun";
			$where .= " AND month(tgl_daftar) BETWEEN 1 AND $bulan";
			$where .= " AND kondisi = 'baik'";
			$table = 'tbl_list_sidang_new';
			$dataSidang = $this->MasterData->getWhereData($select,$table,$where)->result();

			$where = "year(tgl_daftar) = $tahun";
			$where .= " AND month(tgl_daftar) BETWEEN 1 AND $bulan";
			$where .= " AND id_daftar IN (SELECT byr.id_daftar FROM tbl_pembayaran byr)";
			$table = 'tbl_pendaftaran';
			$dataPendaftaran = $this->MasterData->getWhereData($select,$table,$where)->result();


		} else {
			$dataSidang = null;
			$dataPendaftaran = null;
		}
		// ===============================================================
		$bulanIni = 0;
		$sdBulanLalu = 0;
		$sdBulanIni = 0;

		if ($dataSidang != null) { 
			$listTera = array();
			foreach ($dataSidang as $dft) {
				$id_list_sidang = $dft->id_list_sidang;
				$bulan = date('m', strtotime($dft->tgl_daftar));
				$where = "id_list_sidang = $id_list_sidang";
				$dataListTimbang = $this->MasterData->getWhereData('*','tbl_list_sidang_timbang',$where)->result();
				foreach ($dataListTimbang as $list) {
					$listTera[] = array(
						'bulan' => (int)$bulan,
						'id_tarif' => $list->id_tarif_timbang,
						'jml_uttp' => $list->jml_timbang
					);
				}

				$dataListAnakTimbang = $this->MasterData->getWhereData('*','tbl_list_sidang_anak_timbang',$where)->result();
				foreach ($dataListAnakTimbang as $list) {
					$listTera[] = array(
						'bulan' => (int)$bulan,
						'id_tarif' => $list->id_tarif_anak_timbang,
						'jml_uttp' => $list->jml_anak_timbang
					);
				}
			}
			$pendapatan = array();
			for ($i=1; $i <= $bulan; $i++) { 
				$sum_tarif = 0;
				foreach ($listTera as $val) {
					$where = "id_tarif = $val[id_tarif]";
					$dataTarif = $this->MasterData->getWhereData('*','tbl_tarif',$where)->row();
					$bln = $val['bulan'];
					if ($i == $bln) {
						$sum_tarif += (int)$dataTarif->tera_ulang_kantor * (int)$val['jml_uttp'];
					}
				}
				$pendapatan[] = array(
					'bulan' => $i,
					'nominal' => $sum_tarif
				);
			}
			foreach ($pendapatan as $val) {
				$sdBulanIni += $val['nominal'];
				if ($val['bulan'] != $bulan) {
					$sdBulanLalu += $val['nominal'];
				} else {
					$bulanIni = $val['nominal'];
				}
			}
		}

		if ($dataPendaftaran != null) { 
			$listTera = array();
			foreach ($dataPendaftaran as $dft) {
				$id_daftar = $dft->id_daftar;
				$bulan = date('m', strtotime($dft->tgl_daftar));
				$tera = $dft->layanan.'_'.$dft->tempat;
				$jns_tarif = str_replace(' ', '_', $tera);
				$where = "id_daftar = $id_daftar AND id_list IN (SELECT tera.id_list FROM tbl_tera tera WHERE tera.hasil_tera = 'disahkan')";
				$dataList = $this->MasterData->getWhereData('*','tbl_list_tera',$where)->result();
				foreach ($dataList as $list) {
					$listTera[] = array(
						'bulan' => (int)$bulan,
						'jns_tarif' => $jns_tarif,
						'id_tarif' => $list->id_tarif,
						'jml_uttp' => $list->jumlah_uttp
					);
				}
			}
			$pendapatan = array();
			for ($i=1; $i <= $bulan; $i++) { 
				$sum_tarif = 0;
				foreach ($listTera as $val) {
					$where = "id_tarif = $val[id_tarif]";
					$dataTarif = $this->MasterData->getWhereData('*','tbl_tarif',$where)->row();
					$jns_tarif = $val['jns_tarif'];
					$bln = $val['bulan'];
					if ($i == $bln) {
						$sum_tarif += (int)$dataTarif->$jns_tarif * (int)$val['jml_uttp'];
					}
				}
				$pendapatan[] = array(
					'bulan' => $i,
					'nominal' => $sum_tarif
				);
			}
			foreach ($pendapatan as $val) {
				$sdBulanIni += $val['nominal'];
				if ($val['bulan'] != $bulan) {
					$sdBulanLalu += $val['nominal'];
				} else {
					$bulanIni = $val['nominal'];
				}
			}
		}
		// ===============================================================
		$select = array(
			// 'year(tgl_daftar) tahun'
			'tahun_pad tahun'
		);
		// $group = 'year(tgl_daftar)';
		// $by = 'year(tgl_daftar)';
		// $order = 'DESC';
		// $tahunPembayaran = $this->MasterData->getSelectDataGroupOrder($select,$table,$group,$by,$order)->result();
		$tahunPembayaran = $this->MasterData->getSelectData($select,'tbl_target_pad')->result();
		// ================================================================
		if ($tahun != null) { 
			$where = "tahun_pad = $tahun";
			$targetPad = $this->MasterData->getWhereData('*','tbl_target_pad',$where)->row()->target_pad;
		} else {
			$targetPad = 0;
		}
		// ================================================================
		$select = array(
			'pt.*',
			"(SELECT usr.nama_user FROM tbl_user usr WHERE usr.id_user = pt.id_user) nama_user"
		);
		$where = "id_jabatan = (SELECT jb.id_jabatan FROM tbl_jabatan jb WHERE  jb.nama_jabatan = 'Kepala Dinas')";
		$table = 'tbl_petugas pt';
		$kepalaDinas = $this->MasterData->getWhereData($select,$table,$where)->row();
		$where = "id_jabatan = (SELECT jb.id_jabatan FROM tbl_jabatan jb WHERE  jb.nama_jabatan = 'Bendahara')";
		$bendahara = $this->MasterData->getWhereData($select,$table,$where)->row();
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
		$nav['menu'] = 'pad';
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
			'sdBulanLalu' => $sdBulanLalu,
			'bulanIni' => $bulanIni,
			'sdBulanIni' => $sdBulanIni,
			'targetPad' => $targetPad,
			'tahun' => $tahunPembayaran,
			'selectTahun' => $tahun,
			'selectBulan' => $bulan,
			'dataBulan' => $dataBulan,
			'bendahara' => $bendahara,
			'kepalaDinas' => $kepalaDinas,
		);
		$this->load->view('Admin/head',$head);
		$this->load->view('Admin/navigation',$nav);
		$this->load->view('Admin/data_lap_pad',$data);
		$this->load->view('foot',$foot);
	}
	// =====================================================
	public function lapTeraUlangKantor($tgl_awal='', $tgl_akhir='') {
		if ($tgl_awal != '') {
			$awal = date('Y-m-d', strtotime($tgl_awal));
		} else {
			$awal = date('Y-m-1');			
		}
		if ($tgl_akhir != '') {
			$akhir = date('Y-m-d', strtotime($tgl_akhir));
		} else {
			$akhir = date('Y-m-d');
		}
		// ================================================================
		$select = '*';
		$table = 'tbl_tarif';
		$idKwh = array(); //Listrik KWH
		$where = "parent_id = '20'";
		$dataKwh = $this->MasterData->getWhereData($select,$table,$where)->result();
		foreach ($dataKwh as $kwh) {
			if ($kwh->child_id == '0') {
				$idKwh[] = $kwh->id_tarif;
			} else {
				$xx = $this->loopIdTarif($kwh->id_tarif);
				foreach ($xx as $key) {
					$idKwh[] = $key;
				}
			}
		}
		// ============================================================
		$idMT = array(); //Meter Taksi
		$where = "jenis_tarif = 'Meter Taksi'";
		$dataMeter = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataMeter->child_id == '0') {
			$idMT[] = $dataMeter->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataMeter->id_tarif);
			foreach ($xx as $key) {
				$idMT[] = $key;
			}
		}
		// ============================================================
		$idBj = array(); //Bejana Ukur
		$where = "jenis_tarif = 'Bejana Ukur'";
		$dataBj = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataBj->child_id == '0') {
			$idBj[] = $dataBj->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataBj->id_tarif);
			foreach ($xx as $key) {
				$idBj[] = $key;
			}
		}
		// ============================================================
		$idTC = array(); //Timbangan Cepat
		$where = "jenis_tarif = 'Cepat'";
		$dataTC = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataTC->child_id == '0') {
			$idTC[] = $dataTC->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataTC->id_tarif);
			foreach ($xx as $key) {
				$idTC[] = $key;
			}
		}
		// ============================================================
		$idGU = array(); //Gelas Ukur
		$where = "jenis_tarif = 'Alat Ukur dari Gelas'";
		$dataGU = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataGU->child_id == '0') {
			$idGU[] = $dataGU->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataGU->id_tarif);
			foreach ($xx as $key) {
				$idGU[] = $key;
			}
		}
		// ============================================================
		$idMKA = array(); //Meter Kadar Air
		$where = "jenis_tarif = 'Meter Kadar Air'";
		$dataMKA = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataMKA->child_id == '0') {
			$idMKA[] = $dataMKA->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataMKA->id_tarif);
			foreach ($xx as $key) {
				$idMKA[] = $key;
			}
		}
		// ============================================================
		$idTensi = array(); //Tensi Meter
		$where = "jenis_tarif = 'Alat Ukur Tekanan Darah'";
		$dataTensi = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataTensi->child_id == '0') {
			$idTensi[] = $dataTensi->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataTensi->id_tarif);
			foreach ($xx as $key) {
				$idTensi[] = $key;
			}
		}
		// ============================================================
		$idTM = array(); //Timbangan Meja
		$where = "jenis_tarif = 'Meja Beranger'";
		$dataTM = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataTM->child_id == '0') {
			$idTM[] = $dataTM->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataTM->id_tarif);
			foreach ($xx as $key) {
				$idTM[] = $key;
			}
		}
		// ============================================================
		$idTS = array(); //Timbangan Sentisimal
		$where = "jenis_tarif = 'Sentisimal'";
		$dataTS = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataTS->child_id == '0') {
			$idTS[] = $dataTS->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataTS->id_tarif);
			foreach ($xx as $key) {
				$idTS[] = $key;
			}
		}
		// ============================================================
		$idTP = array(); //Timbangan Pegas
		$where = "jenis_tarif = 'Pegas'";
		$dataTP = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataTP->child_id == '0') {
			$idTP[] = $dataTP->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataTP->id_tarif);
			foreach ($xx as $key) {
				$idTP[] = $key;
			}
		}
		// ============================================================
		$idTBI = array(); //Timbangan Bobot Ingsut
		$where = "jenis_tarif = 'Bobot Ingsut'";
		$dataTBI = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataTBI->child_id == '0') {
			$idTBI[] = $dataTBI->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataTBI->id_tarif);
			foreach ($xx as $key) {
				$idTBI[] = $key;
			}
		}
		// ============================================================
		$idTE = array(); //Timbangan Elektronik
		$where = "jenis_tarif = 'Elektronik (Kelas I)'";
		$dataTE1 = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataTE1->child_id == '0') {
			$idTE[] = $dataTE1->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataTE1->id_tarif);
			foreach ($xx as $key) {
				$idTE[] = $key;
			}
		}
		$where = "jenis_tarif = 'Elektronik (Kelas II)'";
		$dataTE2 = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataTE2->child_id == '0') {
			$idTE[] = $dataTE2->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataTE2->id_tarif);
			foreach ($xx as $key) {
				$idTE[] = $key;
			}
		}
		$where = "jenis_tarif = 'Elektronik (Kelas III dan IV)'";
		$dataTE3 = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataTE3->child_id == '0') {
			$idTE[] = $dataTE3->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataTE3->id_tarif);
			foreach ($xx as $key) {
				$idTE[] = $key;
			}
		}
		// ============================================================
		$idDL = array(); //Timbangan Dacin Logam
		$where = "jenis_tarif = 'Dacin'";
		$dataDL = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataDL->child_id == '0') {
			$idDL[] = $dataDL->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataDL->id_tarif);
			foreach ($xx as $key) {
				$idDL[] = $key;
			}
		}
		// ============================================================
		$idNc = array(); //Timbangan Neraca
		$where = "jenis_tarif = 'Neraca'";
		$dataNc = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataNc->child_id == '0') {
			$idNc[] = $dataNc->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataNc->id_tarif);
			foreach ($xx as $key) {
				$idNc[] = $key;
			}
		}
		// ============================================================
		$idUP = array(); //Timbangan Ukuran Panjang
		$where = "id_tarif = '223'";
		$dataUP = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataUP->child_id == '0') {
			$idUP[] = $dataUP->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataUP->id_tarif);
			foreach ($xx as $key) {
				$idUP[] = $key;
			}
		}
		// ============================================================
		$idATH = array(); //Timbangan Anak Timbangan Halus
		$where = "jenis_tarif = 'Sampai dengan 1 kg' OR jenis_tarif = 'Lebih dari 1 kg sampai dengan 5 kg'";
		$dataATH = $this->MasterData->getWhereData($select,$table,$where)->result();
		foreach ($dataATH as $ATH) {
			if ($ATH->child_id == '0') {
				$idATH[] = $ATH->id_tarif;
			} else {
				$xx = $this->loopIdTarif($ATH->id_tarif);
				foreach ($xx as $key) {
					$idATH[] = $key;
				}
			}
		}
		// ============================================================
		$idATB = array(); //Timbangan Anak Timbangan Besar
		$where = "jenis_tarif = 'Lebih dari 5 kg sampai dengan 50 kg'";
		$dataATB = $this->MasterData->getWhereData($select,$table,$where)->result();
		foreach ($dataATB as $ATB) {
			if ($ATB->child_id == '0') {
				$idATB[] = $ATB->id_tarif;
			} else {
				$xx = $this->loopIdTarif($ATB->id_tarif);
				foreach ($xx as $key) {
					$idATB[] = $key;
				}
			}
		}
		// ============================================================
		$idTAK = array(); //Takaran
		$where = "jenis_tarif = 'Takaran (Basah/Kering)'";
		$dataTAK = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataTAK->child_id == '0') {
			$idTAK[] = $dataTAK->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataTAK->id_tarif);
			foreach ($xx as $key) {
				$idTAK[] = $key;
			}
		}
		// ================================================================
		$select = array(
			'dft.*',
			"(SELECT usr.nama_user FROM tbl_user usr WHERE usr.id_user = (SELECT ush.id_user FROM tbl_usaha ush WHERE ush.id_usaha = dft.id_usaha)) nama_user",
			"(SELECT ush.nama_usaha FROM tbl_usaha ush WHERE ush.id_usaha = dft.id_usaha) nama_usaha",
		);
		$table = 'tbl_pendaftaran dft';
		$where = "id_daftar IN (SELECT byr.id_daftar FROM tbl_pembayaran byr) AND tempat = 'kantor' AND layanan = 'tera ulang'";
		$where .= " AND tgl_daftar BETWEEN '$awal' AND '$akhir'";
		$order = 'ASC';
		$by = 'tgl_daftar';
		$dataPendaftaran = $this->MasterData->getWhereDataOrder($select,$table,$where,$by,$order)->result();
		// var_dump($dataPendaftaran);
		$dataLapKantor = array();
		foreach ($dataPendaftaran as $dft) {
			$nama_user = $dft->nama_user;
			$nama_usaha = $dft->nama_usaha;
			$tgl_daftar = date('d-m-Y', strtotime($dft->tgl_daftar));
			$countWTU = 0;
			$countTM = 0;	
			$countTS = 0;	
			$countTP = 0;	
			$countTBI = 0;	
			$countTE = 0;	
			$countDL = 0;	
			$countNc = 0;	
			$countUP = 0;	
			$countATH = 0;	
			$countATB = 0;	
			$countTAK = 0;
			$countKwh = 0;
			$countMT = 0;
			$countBj = 0;
			$countTC = 0;
			$countGU = 0;
			$countMKA = 0;
			$countTensi = 0;
			$totUttp = 0;
			$id_daftar = $dft->id_daftar;
			$where = "id_daftar = $id_daftar AND id_list IN (SELECT tera.id_list FROM tbl_tera tera WHERE tera.hasil_tera = 'disahkan')";
			$dataList = $this->MasterData->getWhereData('*','tbl_list_tera',$where)->result();
			foreach ($dataList as $list) {
				$countWTU++;
				foreach ($idKwh as $Kwh) {
					if ($list->id_tarif == $Kwh) {
						$countKwh++;
					}
				}
				foreach ($idMT as $MT) {
					if ($list->id_tarif == $MT) {
						$countMT++;
					}
				}
				foreach ($idBj as $Bj) {
					if ($list->id_tarif == $Bj) {
						$countBj++;
					}
				}
				foreach ($idTC as $TC) {
					if ($list->id_tarif == $TC) {
						$countTC++;
					}
				}
				foreach ($idGU as $GU) {
					if ($list->id_tarif == $GU) {
						$countGU++;
					}
				}
				foreach ($idMKA as $MKA) {
					if ($list->id_tarif == $MKA) {
						$countMKA++;
					}
				}
				foreach ($idTensi as $Tensi) {
					if ($list->id_tarif == $Tensi) {
						$countTensi++;
					}
				}
				// =================================
				foreach ($idTM as $TM) {
					if ($list->id_tarif == $TM) {
						$countTM++;
					}
				}
				foreach ($idTS as $TS) {
					if ($list->id_tarif == $TS) {
						$countTS++;
					}
				}
				foreach ($idTP as $TP) {
					if ($list->id_tarif == $TP) {
						$countTP++;
					}
				}
				foreach ($idTBI as $TBI) {
					if ($list->id_tarif == $TBI) {
						$countTBI++;
					}
				}
				foreach ($idTE as $TE) {
					if ($list->id_tarif == $TE) {
						$countTE++;
					}
				}
				foreach ($idDL as $DL) {
					if ($list->id_tarif == $DL) {
						$countDL++;
					}
				}
				foreach ($idNc as $Nc) {
					if ($list->id_tarif == $Nc) {
						$countNc++;
					}
				}
				foreach ($idUP as $UP) {
					if ($list->id_tarif == $UP) {
						$countUP++;
					}
				}
				foreach ($idATH as $ATH) {
					if ($list->id_tarif == $ATH) {
						$countATH++;
					}
				}
				foreach ($idATB as $ATB) {
					if ($list->id_tarif == $ATB) {
						$countATB++;
					}
				}
				foreach ($idTAK as $TAK) {
					if ($list->id_tarif == $TAK) {
						$countTAK++;
					}
				}
			}
			$totUttp = $countTM	+ $countTS + $countTP + $countTBI + $countTE + $countDL + $countNc + $countUP + $countATH + $countATB + $countTAK + $countKwh + $countMT + $countBj + $countTC + $countGU + $countMKA + $countTensi;
			$dataLapKantor[] = array(
				'nama_user' => $nama_user,
				'nama_usaha' => $nama_usaha,
				'tgl_daftar' => $tgl_daftar,
				'TM' => $countTM,	
				'TS' => $countTS,	
				'TP' => $countTP,	
				'TBI' => $countTBI,	
				'TE' => $countTE,	
				'DL' => $countDL,	
				'Nc' => $countNc,	
				'UP' => $countUP,	
				'ATH' => $countATH,	
				'ATB' => $countATB,	
				'TAK' => $countTAK,
				'Kwh' => $countKwh,
				'MT' => $countMT,
				'Bj' => $countBj,
				'TC' => $countTC,
				'GU' => $countGU,
				'MKA' => $countMKA,
				'Tensi' => $countTensi,
				'tot_uttp' => $totUttp
			);
		}
		// var_dump($dataLapKantor);
		// =================================================================
		$select = array(
			'pt.*',
			"(SELECT usr.nama_user FROM tbl_user usr WHERE usr.id_user = pt.id_user) nama_user"
		);
		$where = "id_jabatan = (SELECT jb.id_jabatan FROM tbl_jabatan jb WHERE  jb.nama_jabatan = 'Kepala Dinas')";
		$table = 'tbl_petugas pt';
		$kepalaDinas = $this->MasterData->getWhereData($select,$table,$where)->row();
		$where = "id_jabatan = (SELECT jb.id_jabatan FROM tbl_jabatan jb WHERE  jb.nama_jabatan = 'Bendahara')";
		$bendahara = $this->MasterData->getWhereData($select,$table,$where)->row();
		// ================================================================
		// $this->head[] = "assets/assets/plugins/select2/dist/css/select2.css";
		$this->head[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.css";
		$this->head[] = "assets/assets/plugins/sweetalert/sweetalert.css";
		// $this->head[] = "assets/assets/plugins/dropify/dist/css/dropify.min.css";
		$this->head[] = "assets/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css";
		$this->head[] = "assets/assets/plugins/bootstrap-daterangepicker/daterangepicker.css";
		// $this->foot[] = "assets/assets/plugins/select2/dist/js/select2.full.min.js";
		$this->foot[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/sweetalert.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/jquery.sweet-alert.custom.js";
		$this->foot[] = "assets/assets/plugins/datatables/jquery.dataTables.min.js";
		// $this->foot[] = "assets/assets/plugins/dropify/dist/js/dropify.min.js";
		$this->foot[] = "assets/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js";
		$this->foot[] = "assets/assets/plugins/bootstrap-daterangepicker/daterangepicker.js";
		$script = array(
			"$('#myTable').DataTable();",
			// "$('.select2').select2();",
			// "$('.dropify').dropify({
			// 	 messages: {
	  		//      default: '<center>Upload foto/gambar disini.</center>',
	  		//      error: '<center>Maksimal ukuran file 2 MB.</center>',
	  		//   }
			// });",
			"$('.mydatepicker').datepicker({ format: 'dd-mm-yyyy', autoclose:true });",
			"jQuery('#date-range').datepicker({
		        toggleActive: true,
		        format: 'dd-mm-yyyy', 
		        autoclose:true
		    });",
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
		$nav['menu'] = 'tera_ulang_kantor';
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
			'selectTglAwal' => $awal,
			'selectTglAkhir' => $akhir,
			'dataBulan' => $dataBulan,
			'dataLapKantor' => $dataLapKantor,
			'bendahara' => $bendahara,
			'kepalaDinas' => $kepalaDinas,
		);
		$this->load->view('Admin/head',$head);
		$this->load->view('Admin/navigation',$nav);
		$this->load->view('Admin/data_lap_kantor',$data);
		$this->load->view('foot',$foot);
	}
	public function cetakLapKantor($tgl_awal='', $tgl_akhir='') {
		if ($tgl_awal != '') {
			$awal = date('Y-m-d', strtotime($tgl_awal));
		} else {
			$awal = date('Y-m-d');			
		}
		if ($tgl_akhir != '') {
			$akhir = date('Y-m-d', strtotime($tgl_akhir));
		} else {
			$akhir = date('Y-m-d');
		}
		// ================================================================
		$select = '*';
		$table = 'tbl_tarif';
		$idKwh = array(); //Listrik KWH
		$where = "parent_id = '20'";
		$dataKwh = $this->MasterData->getWhereData($select,$table,$where)->result();
		foreach ($dataKwh as $kwh) {
			if ($kwh->child_id == '0') {
				$idKwh[] = $kwh->id_tarif;
			} else {
				$xx = $this->loopIdTarif($kwh->id_tarif);
				foreach ($xx as $key) {
					$idKwh[] = $key;
				}
			}
		}
		// ============================================================
		$idMT = array(); //Meter Taksi
		$where = "jenis_tarif = 'Meter Taksi'";
		$dataMeter = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataMeter->child_id == '0') {
			$idMT[] = $dataMeter->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataMeter->id_tarif);
			foreach ($xx as $key) {
				$idMT[] = $key;
			}
		}
		// ============================================================
		$idBj = array(); //Bejana Ukur
		$where = "jenis_tarif = 'Bejana Ukur'";
		$dataBj = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataBj->child_id == '0') {
			$idBj[] = $dataBj->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataBj->id_tarif);
			foreach ($xx as $key) {
				$idBj[] = $key;
			}
		}
		// ============================================================
		$idTC = array(); //Timbangan Cepat
		$where = "jenis_tarif = 'Cepat'";
		$dataTC = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataTC->child_id == '0') {
			$idTC[] = $dataTC->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataTC->id_tarif);
			foreach ($xx as $key) {
				$idTC[] = $key;
			}
		}
		// ============================================================
		$idGU = array(); //Gelas Ukur
		$where = "jenis_tarif = 'Alat Ukur dari Gelas'";
		$dataGU = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataGU->child_id == '0') {
			$idGU[] = $dataGU->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataGU->id_tarif);
			foreach ($xx as $key) {
				$idGU[] = $key;
			}
		}
		// ============================================================
		$idMKA = array(); //Meter Kadar Air
		$where = "jenis_tarif = 'Meter Kadar Air'";
		$dataMKA = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataMKA->child_id == '0') {
			$idMKA[] = $dataMKA->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataMKA->id_tarif);
			foreach ($xx as $key) {
				$idMKA[] = $key;
			}
		}
		// ============================================================
		$idTensi = array(); //Tensi Meter
		$where = "jenis_tarif = 'Alat Ukur Tekanan Darah'";
		$dataTensi = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataTensi->child_id == '0') {
			$idTensi[] = $dataTensi->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataTensi->id_tarif);
			foreach ($xx as $key) {
				$idTensi[] = $key;
			}
		}
		// ============================================================
		$idTM = array(); //Timbangan Meja
		$where = "jenis_tarif = 'Meja Beranger'";
		$dataTM = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataTM->child_id == '0') {
			$idTM[] = $dataTM->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataTM->id_tarif);
			foreach ($xx as $key) {
				$idTM[] = $key;
			}
		}
		// ============================================================
		$idTS = array(); //Timbangan Sentisimal
		$where = "jenis_tarif = 'Sentisimal'";
		$dataTS = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataTS->child_id == '0') {
			$idTS[] = $dataTS->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataTS->id_tarif);
			foreach ($xx as $key) {
				$idTS[] = $key;
			}
		}
		// ============================================================
		$idTP = array(); //Timbangan Pegas
		$where = "jenis_tarif = 'Pegas'";
		$dataTP = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataTP->child_id == '0') {
			$idTP[] = $dataTP->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataTP->id_tarif);
			foreach ($xx as $key) {
				$idTP[] = $key;
			}
		}
		// ============================================================
		$idTBI = array(); //Timbangan Bobot Ingsut
		$where = "jenis_tarif = 'Bobot Ingsut'";
		$dataTBI = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataTBI->child_id == '0') {
			$idTBI[] = $dataTBI->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataTBI->id_tarif);
			foreach ($xx as $key) {
				$idTBI[] = $key;
			}
		}
		// ============================================================
		$idTE = array(); //Timbangan Elektronik
		$where = "jenis_tarif = 'Elektronik (Kelas I)'";
		$dataTE1 = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataTE1->child_id == '0') {
			$idTE[] = $dataTE1->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataTE1->id_tarif);
			foreach ($xx as $key) {
				$idTE[] = $key;
			}
		}
		$where = "jenis_tarif = 'Elektronik (Kelas II)'";
		$dataTE2 = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataTE2->child_id == '0') {
			$idTE[] = $dataTE2->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataTE2->id_tarif);
			foreach ($xx as $key) {
				$idTE[] = $key;
			}
		}
		$where = "jenis_tarif = 'Elektronik (Kelas III dan IV)'";
		$dataTE3 = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataTE3->child_id == '0') {
			$idTE[] = $dataTE3->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataTE3->id_tarif);
			foreach ($xx as $key) {
				$idTE[] = $key;
			}
		}
		// ============================================================
		$idDL = array(); //Timbangan Dacin Logam
		$where = "jenis_tarif = 'Dacin'";
		$dataDL = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataDL->child_id == '0') {
			$idDL[] = $dataDL->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataDL->id_tarif);
			foreach ($xx as $key) {
				$idDL[] = $key;
			}
		}
		// ============================================================
		$idNc = array(); //Timbangan Neraca
		$where = "jenis_tarif = 'Neraca'";
		$dataNc = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataNc->child_id == '0') {
			$idNc[] = $dataNc->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataNc->id_tarif);
			foreach ($xx as $key) {
				$idNc[] = $key;
			}
		}
		// ============================================================
		$idUP = array(); //Timbangan Ukuran Panjang
		$where = "id_tarif = '223'";
		$dataUP = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataUP->child_id == '0') {
			$idUP[] = $dataUP->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataUP->id_tarif);
			foreach ($xx as $key) {
				$idUP[] = $key;
			}
		}
		// ============================================================
		$idATH = array(); //Timbangan Anak Timbangan Halus
		$where = "jenis_tarif = 'Sampai dengan 1 kg' OR jenis_tarif = 'Lebih dari 1 kg sampai dengan 5 kg'";
		$dataATH = $this->MasterData->getWhereData($select,$table,$where)->result();
		foreach ($dataATH as $ATH) {
			if ($ATH->child_id == '0') {
				$idATH[] = $ATH->id_tarif;
			} else {
				$xx = $this->loopIdTarif($ATH->id_tarif);
				foreach ($xx as $key) {
					$idATH[] = $key;
				}
			}
		}
		// ============================================================
		$idATB = array(); //Timbangan Anak Timbangan Besar
		$where = "jenis_tarif = 'Lebih dari 5 kg sampai dengan 50 kg'";
		$dataATB = $this->MasterData->getWhereData($select,$table,$where)->result();
		foreach ($dataATB as $ATB) {
			if ($ATB->child_id == '0') {
				$idATB[] = $ATB->id_tarif;
			} else {
				$xx = $this->loopIdTarif($ATB->id_tarif);
				foreach ($xx as $key) {
					$idATB[] = $key;
				}
			}
		}
		// ============================================================
		$idTAK = array(); //Takaran
		$where = "jenis_tarif = 'Takaran (Basah/Kering)'";
		$dataTAK = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataTAK->child_id == '0') {
			$idTAK[] = $dataTAK->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataTAK->id_tarif);
			foreach ($xx as $key) {
				$idTAK[] = $key;
			}
		}
		// ================================================================
		$select = array(
			'dft.*',
			"(SELECT usr.nama_user FROM tbl_user usr WHERE usr.id_user = (SELECT ush.id_user FROM tbl_usaha ush WHERE ush.id_usaha = dft.id_usaha)) nama_user",
			"(SELECT ush.nama_usaha FROM tbl_usaha ush WHERE ush.id_usaha = dft.id_usaha) nama_usaha",
		);
		$table = 'tbl_pendaftaran dft';
		$where = "id_daftar IN (SELECT byr.id_daftar FROM tbl_pembayaran byr) AND tempat = 'kantor'";
		$where .= " AND tgl_daftar BETWEEN '$awal' AND '$akhir'";
		$order = 'ASC';
		$by = 'tgl_daftar';
		$dataPendaftaran = $this->MasterData->getWhereDataOrder($select,$table,$where,$by,$order)->result();
		// var_dump($dataPendaftaran);
		$dataLapKantor = array();
		foreach ($dataPendaftaran as $dft) {
			$nama_user = $dft->nama_user;
			$nama_usaha = $dft->nama_usaha;
			$tgl_daftar = date('d-m-Y', strtotime($dft->tgl_daftar));
			$countWTU = 0;
			$countTM = 0;	
			$countTS = 0;	
			$countTP = 0;	
			$countTBI = 0;	
			$countTE = 0;	
			$countDL = 0;	
			$countNc = 0;	
			$countUP = 0;	
			$countATH = 0;	
			$countATB = 0;	
			$countTAK = 0;
			$countKwh = 0;
			$countMT = 0;
			$countBj = 0;
			$countTC = 0;
			$countGU = 0;
			$countMKA = 0;
			$countTensi = 0;
			$totUttp = 0;
			$id_daftar = $dft->id_daftar;
			$where = "id_daftar = $id_daftar AND id_list IN (SELECT tera.id_list FROM tbl_tera tera WHERE tera.hasil_tera = 'disahkan')";
			$dataList = $this->MasterData->getWhereData('*','tbl_list_tera',$where)->result();
			foreach ($dataList as $list) {
				$countWTU++;
				foreach ($idKwh as $Kwh) {
					if ($list->id_tarif == $Kwh) {
						$countKwh++;
					}
				}
				foreach ($idMT as $MT) {
					if ($list->id_tarif == $MT) {
						$countMT++;
					}
				}
				foreach ($idBj as $Bj) {
					if ($list->id_tarif == $Bj) {
						$countBj++;
					}
				}
				foreach ($idTC as $TC) {
					if ($list->id_tarif == $TC) {
						$countTC++;
					}
				}
				foreach ($idGU as $GU) {
					if ($list->id_tarif == $GU) {
						$countGU++;
					}
				}
				foreach ($idMKA as $MKA) {
					if ($list->id_tarif == $MKA) {
						$countMKA++;
					}
				}
				foreach ($idTensi as $Tensi) {
					if ($list->id_tarif == $Tensi) {
						$countTensi++;
					}
				}
				// =================================
				foreach ($idTM as $TM) {
					if ($list->id_tarif == $TM) {
						$countTM++;
					}
				}
				foreach ($idTS as $TS) {
					if ($list->id_tarif == $TS) {
						$countTS++;
					}
				}
				foreach ($idTP as $TP) {
					if ($list->id_tarif == $TP) {
						$countTP++;
					}
				}
				foreach ($idTBI as $TBI) {
					if ($list->id_tarif == $TBI) {
						$countTBI++;
					}
				}
				foreach ($idTE as $TE) {
					if ($list->id_tarif == $TE) {
						$countTE++;
					}
				}
				foreach ($idDL as $DL) {
					if ($list->id_tarif == $DL) {
						$countDL++;
					}
				}
				foreach ($idNc as $Nc) {
					if ($list->id_tarif == $Nc) {
						$countNc++;
					}
				}
				foreach ($idUP as $UP) {
					if ($list->id_tarif == $UP) {
						$countUP++;
					}
				}
				foreach ($idATH as $ATH) {
					if ($list->id_tarif == $ATH) {
						$countATH++;
					}
				}
				foreach ($idATB as $ATB) {
					if ($list->id_tarif == $ATB) {
						$countATB++;
					}
				}
				foreach ($idTAK as $TAK) {
					if ($list->id_tarif == $TAK) {
						$countTAK++;
					}
				}
			}
			$totUttp = $countTM	+ $countTS + $countTP + $countTBI + $countTE + $countDL + $countNc + $countUP + $countATH + $countATB + $countTAK + $countKwh + $countMT + $countBj + $countTC + $countGU + $countMKA + $countTensi;
			$dataLapKantor[] = array(
				'nama_user' => $nama_user,
				'nama_usaha' => $nama_usaha,
				'tgl_daftar' => $tgl_daftar,
				'TM' => $countTM,	
				'TS' => $countTS,	
				'TP' => $countTP,	
				'TBI' => $countTBI,	
				'TE' => $countTE,	
				'DL' => $countDL,	
				'Nc' => $countNc,	
				'UP' => $countUP,	
				'ATH' => $countATH,	
				'ATB' => $countATB,	
				'TAK' => $countTAK,
				'Kwh' => $countKwh,
				'MT' => $countMT,
				'Bj' => $countBj,
				'TC' => $countTC,
				'GU' => $countGU,
				'MKA' => $countMKA,
				'Tensi' => $countTensi,
				'tot_uttp' => $totUttp
			);
		}
		// var_dump($dataLapKantor);
		// =================================================================
		$select = array(
			'pt.*',
			"(SELECT usr.nama_user FROM tbl_user usr WHERE usr.id_user = pt.id_user) nama_user"
		);
		$where = "id_jabatan = (SELECT jb.id_jabatan FROM tbl_jabatan jb WHERE  jb.nama_jabatan = 'Kepala Dinas')";
		$table = 'tbl_petugas pt';
		$kepalaDinas = $this->MasterData->getWhereData($select,$table,$where)->row();
		$where = "id_jabatan = (SELECT jb.id_jabatan FROM tbl_jabatan jb WHERE  jb.nama_jabatan = 'Bendahara')";
		$bendahara = $this->MasterData->getWhereData($select,$table,$where)->row();
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
			'selectTglAwal' => $awal,
			'selectTglAkhir' => $akhir,
			'dataBulan' => $dataBulan,
			'dataLapKantor' => $dataLapKantor,
			'bendahara' => $bendahara,
			'kepalaDinas' => $kepalaDinas,
		);
		$this->load->library('PhpExcelNew/PHPExcel');
		$this->load->view('Admin/laporan/printLapKantor',$data);
	}
	// =====================================================
	public function lapTeraUlangSidang($tgl_awal='', $tgl_akhir='') {
		if ($tgl_awal != '') {
			$awal = date('Y-m-d', strtotime($tgl_awal));
		} else {
			$awal = date('Y-m-1');			
		}
		if ($tgl_akhir != '') {
			$akhir = date('Y-m-d', strtotime($tgl_akhir));
		} else {
			$akhir = date('Y-m-d');
		}
		// ================================================================
		$select = '*';
		$table = 'tbl_tarif';
		$idTM = array(); //Timbangan Meja
		$where = "jenis_tarif = 'Meja Beranger'";
		$dataTM = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataTM->child_id == '0') {
			$idTM[] = $dataTM->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataTM->id_tarif);
			foreach ($xx as $key) {
				$idTM[] = $key;
			}
		}
		// ============================================================
		$idTS = array(); //Timbangan Sentisimal
		$where = "jenis_tarif = 'Sentisimal'";
		$dataTS = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataTS->child_id == '0') {
			$idTS[] = $dataTS->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataTS->id_tarif);
			foreach ($xx as $key) {
				$idTS[] = $key;
			}
		}
		// ============================================================
		$idTP = array(); //Timbangan Pegas
		$where = "jenis_tarif = 'Pegas'";
		$dataTP = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataTP->child_id == '0') {
			$idTP[] = $dataTP->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataTP->id_tarif);
			foreach ($xx as $key) {
				$idTP[] = $key;
			}
		}
		// ============================================================
		$idTBI = array(); //Timbangan Bobot Ingsut
		$where = "jenis_tarif = 'Bobot Ingsut'";
		$dataTBI = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataTBI->child_id == '0') {
			$idTBI[] = $dataTBI->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataTBI->id_tarif);
			foreach ($xx as $key) {
				$idTBI[] = $key;
			}
		}
		// ============================================================
		$idTE = array(); //Timbangan Elektronik
		$where = "jenis_tarif = 'Elektronik (Kelas I)'";
		$dataTE1 = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataTE1->child_id == '0') {
			$idTE[] = $dataTE1->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataTE1->id_tarif);
			foreach ($xx as $key) {
				$idTE[] = $key;
			}
		}
		$where = "jenis_tarif = 'Elektronik (Kelas II)'";
		$dataTE2 = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataTE2->child_id == '0') {
			$idTE[] = $dataTE2->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataTE2->id_tarif);
			foreach ($xx as $key) {
				$idTE[] = $key;
			}
		}
		$where = "jenis_tarif = 'Elektronik (Kelas III dan IV)'";
		$dataTE3 = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataTE3->child_id == '0') {
			$idTE[] = $dataTE3->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataTE3->id_tarif);
			foreach ($xx as $key) {
				$idTE[] = $key;
			}
		}
		// ============================================================
		$idDL = array(); //Timbangan Dacin Logam
		$where = "jenis_tarif = 'Dacin'";
		$dataDL = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataDL->child_id == '0') {
			$idDL[] = $dataDL->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataDL->id_tarif);
			foreach ($xx as $key) {
				$idDL[] = $key;
			}
		}
		// ============================================================
		$idNc = array(); //Timbangan Neraca
		$where = "jenis_tarif = 'Neraca'";
		$dataNc = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataNc->child_id == '0') {
			$idNc[] = $dataNc->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataNc->id_tarif);
			foreach ($xx as $key) {
				$idNc[] = $key;
			}
		}
		// ============================================================
		$idUP = array(); //Timbangan Ukuran Panjang
		$where = "id_tarif = '223'";
		$dataUP = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataUP->child_id == '0') {
			$idUP[] = $dataUP->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataUP->id_tarif);
			foreach ($xx as $key) {
				$idUP[] = $key;
			}
		}
		// ============================================================
		$idATH = array(); //Timbangan Anak Timbangan Halus
		$where = "jenis_tarif = 'Sampai dengan 1 kg' OR jenis_tarif = 'Lebih dari 1 kg sampai dengan 5 kg'";
		$dataATH = $this->MasterData->getWhereData($select,$table,$where)->result();
		foreach ($dataATH as $ATH) {
			if ($ATH->child_id == '0') {
				$idATH[] = $ATH->id_tarif;
			} else {
				$xx = $this->loopIdTarif($ATH->id_tarif);
				foreach ($xx as $key) {
					$idATH[] = $key;
				}
			}
		}
		// ============================================================
		$idATB = array(); //Timbangan Anak Timbangan Besar
		// $where = "jenis_tarif = 'Ketelitian khusus (kelas F2 dan M1)'";
		// $dataATB1 = $this->MasterData->getWhereData($select,$table,$where)->row();
		// if ($dataATB1->child_id == '0') {
		// 	$idATB[] = $dataATB1->id_tarif;
		// } else {
		// 	$xx = $this->loopIdTarif($dataATB1->id_tarif);
		// 	foreach ($xx as $key) {
		// 		$idATB[] = $key;
		// 	}
		// }
		// $where = "jenis_tarif = 'Ketelitian khusus (kelas E2 dan F1)'";
		// $dataATB2 = $this->MasterData->getWhereData($select,$table,$where)->row();
		// if ($dataATB2->child_id == '0') {
		// 	$idATB[] = $dataATB2->id_tarif;
		// } else {
		// 	$xx = $this->loopIdTarif($dataATB2->id_tarif);
		// 	foreach ($xx as $key) {
		// 		$idATB[] = $key;
		// 	}
		// }
		$where = "jenis_tarif = 'Lebih dari 5 kg sampai dengan 50 kg'";
		$dataATB = $this->MasterData->getWhereData($select,$table,$where)->result();
		foreach ($dataATB as $ATB) {
			if ($ATB->child_id == '0') {
				$idATB[] = $ATB->id_tarif;
			} else {
				$xx = $this->loopIdTarif($ATB->id_tarif);
				foreach ($xx as $key) {
					$idATB[] = $key;
				}
			}
		}
		// ============================================================
		$idTAK = array(); //Takaran
		$where = "jenis_tarif = 'Takaran (Basah/Kering)'";
		$dataTAK = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataTAK->child_id == '0') {
			$idTAK[] = $dataTAK->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataTAK->id_tarif);
			foreach ($xx as $key) {
				$idTAK[] = $key;
			}
		}
		// ================================================================
		$select = array(
			'list.*',
			"(SELECT psr.nama_pasar FROM tbl_pasar psr WHERE psr.id_pasar = (SELECT st.id_pasar FROM tbl_sidang_tera st WHERE st.id_sidang = list.id_sidang)) nama_pasar",
			"(SELECT st.id_pasar FROM tbl_sidang_tera st WHERE st.id_sidang = list.id_sidang) id_pasar",
		);
		$table = 'tbl_list_sidang_new list';
		// $where = "list.id_sidang IN (SELECT st.id_sidang FROM tbl_sidang_tera st WHERE st.tgl_sidang BETWEEN '$awal' AND '$akhir')";
		$where = "list.tgl_daftar BETWEEN '$awal' AND '$akhir'";
		$dataListSidang = $this->MasterData->getWhereData($select,$table,$where)->result();
		// ====================================================================
		
		// =====================================================================
		$dataPasar = $this->MasterData->getData('tbl_pasar')->result();
		$dataLapSidang = array();
		foreach ($dataPasar as $psr) {
			$nama_pasar = $psr->nama_pasar;
			$countWTU = 0;
			$countTM = 0;	
			$countTS = 0;	
			$countTP = 0;	
			$countTBI = 0;	
			$countTE = 0;	
			$countDL = 0;	
			$countNc = 0;	
			$countUP = 0;	
			$countATH = 0;	
			$countATB = 0;	
			$countTAK = 0;
			$totUttp = 0;
			foreach ($dataListSidang as $ld) {
				if ($psr->id_pasar == $ld->id_pasar) {
					// foreach ($dataListTimbang as $dft) {
						// if ($ld->id_list_sidang == $dft->id_list_sidang) {
							$countWTU++;
							$id_list_sidang = $ld->id_list_sidang;
							$where = "id_list_sidang = $id_list_sidang";
							$dataListTimbang = $this->MasterData->getWhereData('*','tbl_list_sidang_timbang',$where)->result();
							foreach ($dataListTimbang as $list) {
								foreach ($idTM as $TM) {
									if ($list->id_tarif_timbang == $TM) {
										$countTM++;
									}
								}
								foreach ($idTS as $TS) {
									if ($list->id_tarif_timbang == $TS) {
										$countTS++;
									}
								}
								foreach ($idTP as $TP) {
									if ($list->id_tarif_timbang == $TP) {
										$countTP++;
									}
								}
								foreach ($idTBI as $TBI) {
									if ($list->id_tarif_timbang == $TBI) {
										$countTBI++;
									}
								}
								foreach ($idTE as $TE) {
									if ($list->id_tarif_timbang == $TE) {
										$countTE++;
									}
								}
								foreach ($idDL as $DL) {
									if ($list->id_tarif_timbang == $DL) {
										$countDL++;
									}
								}
								foreach ($idNc as $Nc) {
									if ($list->id_tarif_timbang == $Nc) {
										$countNc++;
									}
								}
								foreach ($idUP as $UP) {
									if ($list->id_tarif_timbang == $UP) {
										$countUP++;
									}
								}
								foreach ($idTAK as $TAK) {
									if ($list->id_tarif_timbang == $TAK) {
										$countTAK++;
									}
								}
							}

							$dataListAnakTimbang = $this->MasterData->getWhereData('*','tbl_list_sidang_anak_timbang',$where)->result();
							foreach ($dataListAnakTimbang as $list) {
								foreach ($idATH as $ATH) {
									if ($list->id_tarif_anak_timbang == $ATH) {
										$countATH++;
									}
								}
								foreach ($idATB as $ATB) {
									if ($list->id_tarif_anak_timbang == $ATB) {
										$countATB++;
									}
								}
							}
						// }
					// }
				}
			}
			$totUttp = $countTM + $countTS + $countTP + $countTBI + $countTE + $countDL + $countNc + $countUP + $countATH + $countATB + $countTAK;
			$dataLapSidang[] = array(
				'tempat' => $nama_pasar,
				'jml_wtu' => $countWTU,
				'TM' => $countTM,
				'TS' => $countTS,
				'TP' => $countTP,
				'TBI' => $countTBI,
				'TE' => $countTE,
				'DL' => $countDL,
				'Nc' => $countNc,
				'UP' => $countUP,
				'ATH' => $countATH,
				'ATB' => $countATB,
				'TAK' => $countTAK,
				'tot_uttp' => $totUttp
			);
		}
		// var_dump($dataLapSidang);
		// =================================================================
		$select = array(
			'pt.*',
			"(SELECT usr.nama_user FROM tbl_user usr WHERE usr.id_user = pt.id_user) nama_user"
		);
		$where = "id_jabatan = (SELECT jb.id_jabatan FROM tbl_jabatan jb WHERE  jb.nama_jabatan = 'Kepala Dinas')";
		$table = 'tbl_petugas pt';
		$kepalaDinas = $this->MasterData->getWhereData($select,$table,$where)->row();
		$where = "id_jabatan = (SELECT jb.id_jabatan FROM tbl_jabatan jb WHERE  jb.nama_jabatan = 'Bendahara')";
		$bendahara = $this->MasterData->getWhereData($select,$table,$where)->row();
		// ================================================================
		// $this->head[] = "assets/assets/plugins/select2/dist/css/select2.css";
		$this->head[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.css";
		$this->head[] = "assets/assets/plugins/sweetalert/sweetalert.css";
		// $this->head[] = "assets/assets/plugins/dropify/dist/css/dropify.min.css";
		$this->head[] = "assets/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css";
		$this->head[] = "assets/assets/plugins/bootstrap-daterangepicker/daterangepicker.css";
		// $this->foot[] = "assets/assets/plugins/select2/dist/js/select2.full.min.js";
		$this->foot[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/sweetalert.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/jquery.sweet-alert.custom.js";
		$this->foot[] = "assets/assets/plugins/datatables/jquery.dataTables.min.js";
		// $this->foot[] = "assets/assets/plugins/dropify/dist/js/dropify.min.js";
		$this->foot[] = "assets/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js";
		$this->foot[] = "assets/assets/plugins/bootstrap-daterangepicker/daterangepicker.js";
		$script = array(
			"$('#myTable').DataTable();",
			// "$('.select2').select2();",
			// "$('.dropify').dropify({
			// 	 messages: {
	  		//      default: '<center>Upload foto/gambar disini.</center>',
	  		//      error: '<center>Maksimal ukuran file 2 MB.</center>',
	  		//   }
			// });",
			"$('.mydatepicker').datepicker({ format: 'dd-mm-yyyy', autoclose:true });",
			"jQuery('#date-range').datepicker({
		        toggleActive: true,
		        format: 'dd-mm-yyyy', 
		        autoclose:true
		    });",
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
		$nav['menu'] = 'tera_ulang_sidang';
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
			'selectTglAwal' => $awal,
			'selectTglAkhir' => $akhir,
			'dataBulan' => $dataBulan,
			'dataLapSidang' => $dataLapSidang,
			'bendahara' => $bendahara,
			'kepalaDinas' => $kepalaDinas,
		);
		$this->load->view('Admin/head',$head);
		$this->load->view('Admin/navigation',$nav);
		$this->load->view('Admin/data_lap_sidang',$data);
		$this->load->view('foot',$foot);
	}

	public function cetakLapSidang($tgl_awal='', $tgl_akhir='') {
		if ($tgl_awal != '') {
			$awal = date('Y-m-d', strtotime($tgl_awal));
		} else {
			$awal = date('Y-m-d');			
		}
		if ($tgl_akhir != '') {
			$akhir = date('Y-m-d', strtotime($tgl_akhir));
		} else {
			$akhir = date('Y-m-d');
		}
		// ================================================================
		$select = '*';
		$table = 'tbl_tarif';
		$idTM = array(); //Timbangan Meja
		$where = "jenis_tarif = 'Meja Beranger'";
		$dataTM = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataTM->child_id == '0') {
			$idTM[] = $dataTM->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataTM->id_tarif);
			foreach ($xx as $key) {
				$idTM[] = $key;
			}
		}
		// ============================================================
		$idTS = array(); //Timbangan Sentisimal
		$where = "jenis_tarif = 'Sentisimal'";
		$dataTS = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataTS->child_id == '0') {
			$idTS[] = $dataTS->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataTS->id_tarif);
			foreach ($xx as $key) {
				$idTS[] = $key;
			}
		}
		// ============================================================
		$idTP = array(); //Timbangan Pegas
		$where = "jenis_tarif = 'Pegas'";
		$dataTP = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataTP->child_id == '0') {
			$idTP[] = $dataTP->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataTP->id_tarif);
			foreach ($xx as $key) {
				$idTP[] = $key;
			}
		}
		// ============================================================
		$idTBI = array(); //Timbangan Bobot Ingsut
		$where = "jenis_tarif = 'Bobot Ingsut'";
		$dataTBI = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataTBI->child_id == '0') {
			$idTBI[] = $dataTBI->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataTBI->id_tarif);
			foreach ($xx as $key) {
				$idTBI[] = $key;
			}
		}
		// ============================================================
		$idTE = array(); //Timbangan Elektronik
		$where = "jenis_tarif = 'Elektronik (Kelas I)'";
		$dataTE1 = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataTE1->child_id == '0') {
			$idTE[] = $dataTE1->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataTE1->id_tarif);
			foreach ($xx as $key) {
				$idTE[] = $key;
			}
		}
		$where = "jenis_tarif = 'Elektronik (Kelas II)'";
		$dataTE2 = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataTE2->child_id == '0') {
			$idTE[] = $dataTE2->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataTE2->id_tarif);
			foreach ($xx as $key) {
				$idTE[] = $key;
			}
		}
		$where = "jenis_tarif = 'Elektronik (Kelas III dan IV)'";
		$dataTE3 = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataTE3->child_id == '0') {
			$idTE[] = $dataTE3->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataTE3->id_tarif);
			foreach ($xx as $key) {
				$idTE[] = $key;
			}
		}
		// ============================================================
		$idDL = array(); //Timbangan Dacin Logam
		$where = "jenis_tarif = 'Dacin'";
		$dataDL = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataDL->child_id == '0') {
			$idDL[] = $dataDL->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataDL->id_tarif);
			foreach ($xx as $key) {
				$idDL[] = $key;
			}
		}
		// ============================================================
		$idNc = array(); //Timbangan Neraca
		$where = "jenis_tarif = 'Neraca'";
		$dataNc = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataNc->child_id == '0') {
			$idNc[] = $dataNc->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataNc->id_tarif);
			foreach ($xx as $key) {
				$idNc[] = $key;
			}
		}
		// ============================================================
		$idUP = array(); //Timbangan Ukuran Panjang
		$where = "id_tarif = '223'";
		$dataUP = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataUP->child_id == '0') {
			$idUP[] = $dataUP->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataUP->id_tarif);
			foreach ($xx as $key) {
				$idUP[] = $key;
			}
		}
		// ============================================================
		$idATH = array(); //Timbangan Anak Timbangan Halus
		$where = "jenis_tarif = 'Sampai dengan 1 kg' OR jenis_tarif = 'Lebih dari 1 kg sampai dengan 5 kg'";
		$dataATH = $this->MasterData->getWhereData($select,$table,$where)->result();
		foreach ($dataATH as $ATH) {
			if ($ATH->child_id == '0') {
				$idATH[] = $ATH->id_tarif;
			} else {
				$xx = $this->loopIdTarif($ATH->id_tarif);
				foreach ($xx as $key) {
					$idATH[] = $key;
				}
			}
		}
		// ============================================================
		$idATB = array(); //Timbangan Anak Timbangan Besar
		$where = "jenis_tarif = 'Lebih dari 5 kg sampai dengan 50 kg'";
		$dataATB = $this->MasterData->getWhereData($select,$table,$where)->result();
		foreach ($dataATB as $ATB) {
			if ($ATB->child_id == '0') {
				$idATB[] = $ATB->id_tarif;
			} else {
				$xx = $this->loopIdTarif($ATB->id_tarif);
				foreach ($xx as $key) {
					$idATB[] = $key;
				}
			}
		}
		// ============================================================
		$idTAK = array(); //Takaran
		$where = "jenis_tarif = 'Takaran (Basah/Kering)'";
		$dataTAK = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataTAK->child_id == '0') {
			$idTAK[] = $dataTAK->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataTAK->id_tarif);
			foreach ($xx as $key) {
				$idTAK[] = $key;
			}
		}
		// ================================================================
		$select = array(
			'list.*',
			"(SELECT psr.nama_pasar FROM tbl_pasar psr WHERE psr.id_pasar = (SELECT st.id_pasar FROM tbl_sidang_tera st WHERE st.id_sidang = list.id_sidang)) nama_pasar",
			"(SELECT st.id_pasar FROM tbl_sidang_tera st WHERE st.id_sidang = list.id_sidang) id_pasar",
		);
		$table = 'tbl_list_sidang_new list';
		// $where = "list.id_sidang IN (SELECT st.id_sidang FROM tbl_sidang_tera st WHERE st.tgl_sidang BETWEEN '$awal' AND '$akhir')";
		$where = "list.tgl_daftar BETWEEN '$awal' AND '$akhir'";
		$dataListSidang = $this->MasterData->getWhereData($select,$table,$where)->result();
		// ====================================================================
		
		// =====================================================================
		$dataPasar = $this->MasterData->getData('tbl_pasar')->result();
		$dataLapSidang = array();
		foreach ($dataPasar as $psr) {
			$nama_pasar = $psr->nama_pasar;
			$countWTU = 0;
			$countTM = 0;	
			$countTS = 0;	
			$countTP = 0;	
			$countTBI = 0;	
			$countTE = 0;	
			$countDL = 0;	
			$countNc = 0;	
			$countUP = 0;	
			$countATH = 0;	
			$countATB = 0;	
			$countTAK = 0;
			$totUttp = 0;
			foreach ($dataListSidang as $ld) {
				if ($psr->id_pasar == $ld->id_pasar) {
					// foreach ($dataListTimbang as $dft) {
						// if ($ld->id_list_sidang == $dft->id_list_sidang) {
							$countWTU++;
							$id_list_sidang = $ld->id_list_sidang;
							$where = "id_list_sidang = $id_list_sidang";
							$dataListTimbang = $this->MasterData->getWhereData('*','tbl_list_sidang_timbang',$where)->result();
							foreach ($dataListTimbang as $list) {
								foreach ($idTM as $TM) {
									if ($list->id_tarif_timbang == $TM) {
										$countTM++;
									}
								}
								foreach ($idTS as $TS) {
									if ($list->id_tarif_timbang == $TS) {
										$countTS++;
									}
								}
								foreach ($idTP as $TP) {
									if ($list->id_tarif_timbang == $TP) {
										$countTP++;
									}
								}
								foreach ($idTBI as $TBI) {
									if ($list->id_tarif_timbang == $TBI) {
										$countTBI++;
									}
								}
								foreach ($idTE as $TE) {
									if ($list->id_tarif_timbang == $TE) {
										$countTE++;
									}
								}
								foreach ($idDL as $DL) {
									if ($list->id_tarif_timbang == $DL) {
										$countDL++;
									}
								}
								foreach ($idNc as $Nc) {
									if ($list->id_tarif_timbang == $Nc) {
										$countNc++;
									}
								}
								foreach ($idUP as $UP) {
									if ($list->id_tarif_timbang == $UP) {
										$countUP++;
									}
								}
								foreach ($idTAK as $TAK) {
									if ($list->id_tarif_timbang == $TAK) {
										$countTAK++;
									}
								}
							}

							$dataListAnakTimbang = $this->MasterData->getWhereData('*','tbl_list_sidang_anak_timbang',$where)->result();
							foreach ($dataListAnakTimbang as $list) {
								foreach ($idATH as $ATH) {
									if ($list->id_tarif_anak_timbang == $ATH) {
										$countATH++;
									}
								}
								foreach ($idATB as $ATB) {
									if ($list->id_tarif_anak_timbang == $ATB) {
										$countATB++;
									}
								}
							}
						// }
					// }
				}
			}
			$totUttp = $countTM + $countTS + $countTP + $countTBI + $countTE + $countDL + $countNc + $countUP + $countATH + $countATB + $countTAK;
			$dataLapSidang[] = array(
				'tempat' => $nama_pasar,
				'jml_wtu' => $countWTU,
				'TM' => $countTM,
				'TS' => $countTS,
				'TP' => $countTP,
				'TBI' => $countTBI,
				'TE' => $countTE,
				'DL' => $countDL,
				'Nc' => $countNc,
				'UP' => $countUP,
				'ATH' => $countATH,
				'ATB' => $countATB,
				'TAK' => $countTAK,
				'tot_uttp' => $totUttp
			);
		}
		// var_dump($dataLapSidang);
		// =================================================================
		$select = array(
			'pt.*',
			"(SELECT usr.nama_user FROM tbl_user usr WHERE usr.id_user = pt.id_user) nama_user"
		);
		$where = "id_jabatan = (SELECT jb.id_jabatan FROM tbl_jabatan jb WHERE  jb.nama_jabatan = 'Kepala Dinas')";
		$table = 'tbl_petugas pt';
		$kepalaDinas = $this->MasterData->getWhereData($select,$table,$where)->row();
		$where = "id_jabatan = (SELECT jb.id_jabatan FROM tbl_jabatan jb WHERE  jb.nama_jabatan = 'Bendahara')";
		$bendahara = $this->MasterData->getWhereData($select,$table,$where)->row();
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
			'selectTglAwal' => $awal,
			'selectTglAkhir' => $akhir,
			'dataBulan' => $dataBulan,
			'dataLapSidang' => $dataLapSidang,
			'bendahara' => $bendahara,
			'kepalaDinas' => $kepalaDinas,
		);
		
		$this->load->library('PhpExcelNew/PHPExcel');
		$this->load->view('Admin/laporan/printLapSidang',$data);
	}
	// ==========================================================

	public function lapSidangTera($id='', $tgl='') {
		// $id_user = $this->id_user;
		if ($id != '') {
			$id_pasar = decode($id);
		} else {
			$id_pasar = 1;
		}

		if ($tgl != '') {
			$tgl_sidang = date('Y-m-d', strtotime($tgl));
		} else {
			$tgl_sidang = date('Y-m-d');
		}

		// SELECT 
		// 	tb.*,
		//     (SELECT usr.nama_user FROM tbl_user_pasar usr WHERE usr.id_user_pasar = (SELECT list.id_user_pasar FROM tbl_list_sidang_new list WHERE list.id_list_sidang = tb.id_list_sidang)) nama_user,
		//     (SELECT usr.alamat_user FROM tbl_user_pasar usr WHERE usr.id_user_pasar = (SELECT list.id_user_pasar FROM tbl_list_sidang_new list WHERE list.id_list_sidang = tb.id_list_sidang)) alamat_user,
		//     (SELECT jns.nama_jenis_alat FROM tbl_jenis_alat_ukur jns WHERE jns.id_jenis_alat = tb.id_jenis_alat) jenis_alat,
		//     SUM(tb.jml_timbang) jml_timbang,
		    
		//     CASE 
		//         WHEN 
		//             (SELECT jns.nama_jenis_alat FROM tbl_jenis_alat_ukur jns WHERE jns.id_jenis_alat = tb.id_jenis_alat) = 'Timbangan Meja' THEN (SELECT SUM(at.jml_anak_timbang) FROM tbl_list_sidang_anak_timbang at WHERE at.id_list_sidang = tb.id_list_sidang)  
		//         ELSE 0
		//         END AS jml_anak_timbang,
		//     (SELECT list.berlaku FROM tbl_list_sidang_new list WHERE list.id_list_sidang = tb.id_list_sidang) berlaku,
		//     (SELECT list.tidak_berlaku FROM tbl_list_sidang_new list WHERE list.id_list_sidang = tb.id_list_sidang) tidak_berlaku
		// FROM tbl_list_sidang_timbang tb WHERE tb.id_list_sidang = '31' GROUP BY id_jenis_alat, id_list_sidang

		$select = array(
			'tb.*',
			'(SELECT list.id_user_pasar FROM tbl_list_sidang_new list WHERE list.id_list_sidang = tb.id_list_sidang) id_user_pasar',
		    '(SELECT usr.nama_user FROM tbl_user_pasar usr WHERE usr.id_user_pasar = (SELECT list.id_user_pasar FROM tbl_list_sidang_new list WHERE list.id_list_sidang = tb.id_list_sidang)) nama_user',
		    '(SELECT usr.alamat_user FROM tbl_user_pasar usr WHERE usr.id_user_pasar = (SELECT list.id_user_pasar FROM tbl_list_sidang_new list WHERE list.id_list_sidang = tb.id_list_sidang)) alamat_user',
		    '(SELECT jns.nama_jenis_alat FROM tbl_jenis_alat_ukur jns WHERE jns.id_jenis_alat = tb.id_jenis_alat) jenis_alat',
		    'SUM(tb.jml_timbang) jumlah_timbang',
		    "(SELECT SUM(at.jml_anak_timbang) FROM tbl_list_sidang_anak_timbang at WHERE at.id_list_sidang = tb.id_list_sidang) jumlah_anak_timbang",
		  //   "CASE 
				// WHEN 
				//     (SELECT jns.nama_jenis_alat FROM tbl_jenis_alat_ukur jns WHERE jns.id_jenis_alat = tb.id_jenis_alat) != 'Timbangan Digital' AND (SELECT jns.nama_jenis_alat FROM tbl_jenis_alat_ukur jns WHERE jns.id_jenis_alat = tb.id_jenis_alat) != 'Timbangan Pegas' THEN (SELECT SUM(at.jml_anak_timbang) FROM tbl_list_sidang_anak_timbang at WHERE at.id_list_sidang = tb.id_list_sidang)  
				// ELSE 0
				// END AS jumlah_anak_timbang",
		    '(SELECT list.berlaku FROM tbl_list_sidang_new list WHERE list.id_list_sidang = tb.id_list_sidang) berlaku',
		    '(SELECT list.tidak_berlaku FROM tbl_list_sidang_new list WHERE list.id_list_sidang = tb.id_list_sidang) tidak_berlaku',
		    '(SELECT list.kondisi FROM tbl_list_sidang_new list WHERE list.id_list_sidang = tb.id_list_sidang) kondisi',
		    '(SELECT list.tindakan FROM tbl_list_sidang_new list WHERE list.id_list_sidang = tb.id_list_sidang) tindakan',
		    "CASE 
		        WHEN 
		            (SELECT jns.nama_jenis_alat FROM tbl_jenis_alat_ukur jns WHERE jns.id_jenis_alat = tb.id_jenis_alat) = 'Timbangan Meja' THEN 'TM'
		        WHEN
		        	(SELECT jns.nama_jenis_alat FROM tbl_jenis_alat_ukur jns WHERE jns.id_jenis_alat = tb.id_jenis_alat) = 'Timbangan Sentisimal' THEN 'T.Sent'
		       	WHEN
		       		(SELECT jns.nama_jenis_alat FROM tbl_jenis_alat_ukur jns WHERE jns.id_jenis_alat = tb.id_jenis_alat) = 'Dacin Logam' THEN 'DL'
		       	WHEN
		       		(SELECT jns.nama_jenis_alat FROM tbl_jenis_alat_ukur jns WHERE jns.id_jenis_alat = tb.id_jenis_alat) = 'Timbangan Pegas' THEN 'TP'
		       	WHEN
		       		(SELECT jns.nama_jenis_alat FROM tbl_jenis_alat_ukur jns WHERE jns.id_jenis_alat = tb.id_jenis_alat) = 'Timbangan Digital' THEN 'TE'
		       	WHEN
		       		(SELECT jns.nama_jenis_alat FROM tbl_jenis_alat_ukur jns WHERE jns.id_jenis_alat = tb.id_jenis_alat) = 'Neraca' THEN 'NR'
		        ELSE 0
		        END AS jenis_timbangan",
		        "CASE 
			        WHEN 
			        	(SELECT list.layanan FROM tbl_list_sidang_new list WHERE list.id_list_sidang = tb.id_list_sidang) = 'tera ulang' THEN (SELECT tr.tera_ulang_kantor FROM tbl_tarif tr WHERE tr.id_tarif = tb.id_tarif_timbang) 
			        WHEN 
			        	(SELECT list.layanan FROM tbl_list_sidang_new list WHERE list.id_list_sidang = tb.id_list_sidang) = 'tera' THEN (SELECT tr.tera_kantor FROM tbl_tarif tr WHERE tr.id_tarif = tb.id_tarif_timbang)
			        ELSE NULL
		     	END AS tarif_timbang",
		);
		$table = "tbl_list_sidang_timbang tb";
		$where = "tb.id_list_sidang IN (SELECT list.id_list_sidang FROM tbl_list_sidang_new list WHERE list.id_sidang = (SELECT sd.id_sidang FROM tbl_sidang_tera sd WHERE sd.id_pasar = '$id_pasar' AND sd.tgl_sidang = '$tgl_sidang'))";
		$group = "tb.id_jenis_alat, tb.id_list_sidang";
		$by = 'tb.id_list_sidang';
		$order = 'DESC';
		$dataSidangTera = $this->MasterData->getWhereDataGroupOrder($select,$table,$where,$group,$by,$order)->result();

		// ===========================================================================================

		$select = array(
			'tb.*',
			"(SELECT tr.jenis_tarif FROM tbl_tarif tr WHERE tr.id_tarif = (SELECT trf.parent_id FROM tbl_tarif trf WHERE  trf.id_tarif = tb.id_tarif_anak_timbang)) AS parent",
			"(SELECT tr.jenis_tarif FROM tbl_tarif tr WHERE tr.id_tarif = tb.id_tarif_anak_timbang) AS child",
			"CASE 
		        WHEN 
		        	(SELECT list.layanan FROM tbl_list_sidang_new list WHERE list.id_list_sidang = tb.id_list_sidang) = 'tera ulang' THEN (SELECT tr.tera_ulang_kantor FROM tbl_tarif tr WHERE tr.id_tarif = tb.id_tarif_anak_timbang) 
		        WHEN 
		        	(SELECT list.layanan FROM tbl_list_sidang_new list WHERE list.id_list_sidang = tb.id_list_sidang) = 'tera' THEN (SELECT tr.tera_kantor FROM tbl_tarif tr WHERE tr.id_tarif = tb.id_tarif_anak_timbang)
		        ELSE NULL
		     	END AS tarif_anak_timbang"
		);
		$table = 'tbl_list_sidang_anak_timbang tb';
		$where = "tb.id_list_sidang IN (SELECT list.id_list_sidang FROM tbl_list_sidang_new list WHERE list.id_sidang = (SELECT sd.id_sidang FROM tbl_sidang_tera sd WHERE sd.id_pasar = '$id_pasar' AND sd.tgl_sidang = '$tgl_sidang'))";
		$dataTarifAnakTimbang = $this->MasterData->getWhereData($select,$table,$where)->result();

		// ==========================================================================================

		$select = 'nama_pasar';
		$table = 'tbl_pasar';
		$where = "id_pasar = $id_pasar";
		$nama_pasar = $this->MasterData->getWhereData($select,$table,$where)->row()->nama_pasar;

		$data_pasar = $this->MasterData->getData('tbl_pasar')->result();

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
		$nav['menu'] = 'lap_sidang_tera';
		$data = array(
			'dataSidangTera' => $dataSidangTera,
			'dataTarifAnakTimbang' => $dataTarifAnakTimbang,
			'selectPasar' => $id_pasar,
			'tgl_sidang' =>  $tgl_sidang,
			'id_pasar' =>  $id_pasar,
			'nama_pasar' =>  $nama_pasar,
			'data_pasar' =>  $data_pasar,
		);
		$this->load->view('Admin/head',$head);
		$this->load->view('Admin/navigation',$nav);
		$this->load->view('Admin/data_lap_tera_pasar',$data);
		$this->load->view('foot',$foot);
	}

	public function cetakLapSidangTera($id='', $tgl='') {
		// $id_user = $this->id_user;
		if ($id != '') {
			$id_pasar = decode($id);
		} else {
			$id_pasar = 1;
		}

		if ($tgl != '') {
			$tgl_sidang = date('Y-m-d', strtotime($tgl));
		} else {
			$tgl_sidang = date('Y-m-d');
		}

		$select = array(
			'tb.*',
			'(SELECT list.id_user_pasar FROM tbl_list_sidang_new list WHERE list.id_list_sidang = tb.id_list_sidang) id_user_pasar',
		    '(SELECT usr.nama_user FROM tbl_user_pasar usr WHERE usr.id_user_pasar = (SELECT list.id_user_pasar FROM tbl_list_sidang_new list WHERE list.id_list_sidang = tb.id_list_sidang)) nama_user',
		    '(SELECT usr.alamat_user FROM tbl_user_pasar usr WHERE usr.id_user_pasar = (SELECT list.id_user_pasar FROM tbl_list_sidang_new list WHERE list.id_list_sidang = tb.id_list_sidang)) alamat_user',
		    '(SELECT jns.nama_jenis_alat FROM tbl_jenis_alat_ukur jns WHERE jns.id_jenis_alat = tb.id_jenis_alat) jenis_alat',
		    'SUM(tb.jml_timbang) jumlah_timbang',
		    "(SELECT SUM(at.jml_anak_timbang) FROM tbl_list_sidang_anak_timbang at WHERE at.id_list_sidang = tb.id_list_sidang) jumlah_anak_timbang",
		  //   "CASE 
				// WHEN 
				//     (SELECT jns.nama_jenis_alat FROM tbl_jenis_alat_ukur jns WHERE jns.id_jenis_alat = tb.id_jenis_alat) != 'Timbangan Digital' AND (SELECT jns.nama_jenis_alat FROM tbl_jenis_alat_ukur jns WHERE jns.id_jenis_alat = tb.id_jenis_alat) != 'Timbangan Pegas' THEN (SELECT SUM(at.jml_anak_timbang) FROM tbl_list_sidang_anak_timbang at WHERE at.id_list_sidang = tb.id_list_sidang)  
				// ELSE 0
				// END AS jumlah_anak_timbang",
		    '(SELECT list.berlaku FROM tbl_list_sidang_new list WHERE list.id_list_sidang = tb.id_list_sidang) berlaku',
		    '(SELECT list.tidak_berlaku FROM tbl_list_sidang_new list WHERE list.id_list_sidang = tb.id_list_sidang) tidak_berlaku',
		    '(SELECT list.kondisi FROM tbl_list_sidang_new list WHERE list.id_list_sidang = tb.id_list_sidang) kondisi',
		    '(SELECT list.tindakan FROM tbl_list_sidang_new list WHERE list.id_list_sidang = tb.id_list_sidang) tindakan',
		    "CASE 
		        WHEN 
		            (SELECT jns.nama_jenis_alat FROM tbl_jenis_alat_ukur jns WHERE jns.id_jenis_alat = tb.id_jenis_alat) = 'Timbangan Meja' THEN 'TM'
		        WHEN
		        	(SELECT jns.nama_jenis_alat FROM tbl_jenis_alat_ukur jns WHERE jns.id_jenis_alat = tb.id_jenis_alat) = 'Timbangan Sentisimal' THEN 'T.Sent'
		       	WHEN
		       		(SELECT jns.nama_jenis_alat FROM tbl_jenis_alat_ukur jns WHERE jns.id_jenis_alat = tb.id_jenis_alat) = 'Dacin Logam' THEN 'DL'
		       	WHEN
		       		(SELECT jns.nama_jenis_alat FROM tbl_jenis_alat_ukur jns WHERE jns.id_jenis_alat = tb.id_jenis_alat) = 'Timbangan Pegas' THEN 'TP'
		       	WHEN
		       		(SELECT jns.nama_jenis_alat FROM tbl_jenis_alat_ukur jns WHERE jns.id_jenis_alat = tb.id_jenis_alat) = 'Timbangan Digital' THEN 'TE'
		       	WHEN
		       		(SELECT jns.nama_jenis_alat FROM tbl_jenis_alat_ukur jns WHERE jns.id_jenis_alat = tb.id_jenis_alat) = 'Neraca' THEN 'NR'
		        ELSE 0
		        END AS jenis_timbangan",
		        "CASE 
			        WHEN 
			        	(SELECT list.layanan FROM tbl_list_sidang_new list WHERE list.id_list_sidang = tb.id_list_sidang) = 'tera ulang' THEN (SELECT tr.tera_ulang_kantor FROM tbl_tarif tr WHERE tr.id_tarif = tb.id_tarif_timbang) 
			        WHEN 
			        	(SELECT list.layanan FROM tbl_list_sidang_new list WHERE list.id_list_sidang = tb.id_list_sidang) = 'tera' THEN (SELECT tr.tera_kantor FROM tbl_tarif tr WHERE tr.id_tarif = tb.id_tarif_timbang)
			        ELSE NULL
		     	END AS tarif_timbang",
		);
		$table = "tbl_list_sidang_timbang tb";
		$where = "tb.id_list_sidang IN (SELECT list.id_list_sidang FROM tbl_list_sidang_new list WHERE list.id_sidang = (SELECT sd.id_sidang FROM tbl_sidang_tera sd WHERE sd.id_pasar = '$id_pasar' AND sd.tgl_sidang = '$tgl_sidang'))";
		$group = "tb.id_jenis_alat, tb.id_list_sidang";
		$by = 'tb.id_list_sidang';
		$order = 'DESC';
		$dataSidangTera = $this->MasterData->getWhereDataGroupOrder($select,$table,$where,$group,$by,$order)->result_array();

		// ===========================================================================================

		$select = array(
			'tb.*',
			"(SELECT tr.jenis_tarif FROM tbl_tarif tr WHERE tr.id_tarif = (SELECT trf.parent_id FROM tbl_tarif trf WHERE  trf.id_tarif = tb.id_tarif_anak_timbang)) AS parent",
			"(SELECT tr.jenis_tarif FROM tbl_tarif tr WHERE tr.id_tarif = tb.id_tarif_anak_timbang) AS child",
			"CASE 
		        WHEN 
		        	(SELECT list.layanan FROM tbl_list_sidang_new list WHERE list.id_list_sidang = tb.id_list_sidang) = 'tera ulang' THEN (SELECT tr.tera_ulang_kantor FROM tbl_tarif tr WHERE tr.id_tarif = tb.id_tarif_anak_timbang) 
		        WHEN 
		        	(SELECT list.layanan FROM tbl_list_sidang_new list WHERE list.id_list_sidang = tb.id_list_sidang) = 'tera' THEN (SELECT tr.tera_kantor FROM tbl_tarif tr WHERE tr.id_tarif = tb.id_tarif_anak_timbang)
		        ELSE NULL
		     	END AS tarif_anak_timbang"
		);
		$table = 'tbl_list_sidang_anak_timbang tb';
		$where = "tb.id_list_sidang IN (SELECT list.id_list_sidang FROM tbl_list_sidang_new list WHERE list.id_sidang = (SELECT sd.id_sidang FROM tbl_sidang_tera sd WHERE sd.id_pasar = '$id_pasar' AND sd.tgl_sidang = '$tgl_sidang'))";
		$dataTarifAnakTimbang = $this->MasterData->getWhereData($select,$table,$where)->result_array();

		// ==========================================================================================

		$select = 'nama_pasar';
		$table = 'tbl_pasar';
		$where = "id_pasar = $id_pasar";
		$nama_pasar = $this->MasterData->getWhereData($select,$table,$where)->row()->nama_pasar;

		$data_pasar = $this->MasterData->getData('tbl_pasar')->result();

		// =================================================================
		$select = array(
			'pt.*',
			"(SELECT usr.nama_user FROM tbl_user usr WHERE usr.id_user = pt.id_user) nama_user"
		);
		$where = "id_jabatan = (SELECT jb.id_jabatan FROM tbl_jabatan jb WHERE  jb.nama_jabatan = 'Kepala Dinas')";
		$table = 'tbl_petugas pt';
		$kepalaDinas = $this->MasterData->getWhereData($select,$table,$where)->row();
		$where = "id_jabatan = (SELECT jb.id_jabatan FROM tbl_jabatan jb WHERE  jb.nama_jabatan = 'Bendahara')";
		$bendahara = $this->MasterData->getWhereData($select,$table,$where)->row();
		$where = "id_jabatan = (SELECT jb.id_jabatan FROM tbl_jabatan jb WHERE  jb.nama_jabatan = 'Kabid Metrologi')";
		$kabid = $this->MasterData->getWhereData($select,$table,$where)->row();
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
			'dataSidangTera' => $dataSidangTera,
			'dataTarifAnakTimbang' => $dataTarifAnakTimbang,
			'selectPasar' => $id_pasar,
			'tgl_sidang' =>  $tgl_sidang,
			'id_pasar' =>  $id_pasar,
			'nama_pasar' =>  $nama_pasar,
			'data_pasar' =>  $data_pasar,
			'dataBulan' => $dataBulan,
			'bendahara' => $bendahara,
			'kabid' => $kabid,
			'kepalaDinas' => $kepalaDinas,
		);
		
		$this->load->library('PhpExcelNew/PHPExcel');
		$this->load->view('Admin/laporan/printLapSidangTera',$data);
	}

	// ==========================================================
	public function lapTeraUlangLoco($tgl_awal='', $tgl_akhir='') {
		if ($tgl_awal != '') {
			$awal = date('Y-m-d', strtotime($tgl_awal));
		} else {
			$awal = date('Y-m-1');			
		}
		if ($tgl_akhir != '') {
			$akhir = date('Y-m-d', strtotime($tgl_akhir));
		} else {
			$akhir = date('Y-m-d');
		}
		// ================================================================
		$select = '*';
		$table = 'tbl_tarif';
		$idBBM = array(); //PU BBM
		$where = "jenis_tarif = 'Meter Bahan Bakar Minyak (Pompa Ukur BBM)'";
		$dataBBM = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataBBM->child_id == '0') {
			$idBBM[] = $dataBBM->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataBBM->id_tarif);
			foreach ($xx as $key) {
				$idBBM[] = $key;
			}
		}
		// ============================================================
		$idBU = array(); //Bejana Ukur
		$where = "jenis_tarif = 'Bejana Ukur'";
		$dataBU = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataBU->child_id == '0') {
			$idBU[] = $dataBU->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataBU->id_tarif);
			foreach ($xx as $key) {
				$idBU[] = $key;
			}
		}
		// ============================================================
		$idTutsida = array(); //Tangki Ukur Tetap Silinder Datar 
		$where = "jenis_tarif = 'Bentuk Silinder Datar'";
		$dataTutsida = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataTutsida->child_id == '0') {
			$idTutsida[] = $dataTutsida->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataTutsida->id_tarif);
			foreach ($xx as $key) {
				$idTutsida[] = $key;
			}
		}
		// ============================================================
		$idATB = array(); //Anak Timbangan Berat
		$where = "jenis_tarif = 'Lebih dari 5 kg sampai dengan 50 kg'";
		$dataATB = $this->MasterData->getWhereData($select,$table,$where)->result();
		foreach ($dataATB as $ATB) {
			if ($ATB->child_id == '0') {
				$idATB[] = $ATB->id_tarif;
			} else {
				$xx = $this->loopIdTarif($ATB->id_tarif);
				foreach ($xx as $key) {
					$idATB[] = $key;
				}
			}
		}
		// ============================================================
		$idTM = array(); //Timbangan Meja
		$where = "jenis_tarif = 'Meja Beranger'";
		$dataTM = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataTM->child_id == '0') {
			$idTM[] = $dataTM->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataTM->id_tarif);
			foreach ($xx as $key) {
				$idTM[] = $key;
			}
		}
		// ============================================================
		$idTS = array(); //Timbangan Sentisimal
		$where = "jenis_tarif = 'Sentisimal'";
		$dataTS = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataTS->child_id == '0') {
			$idTS[] = $dataTS->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataTS->id_tarif);
			foreach ($xx as $key) {
				$idTS[] = $key;
			}
		}
		// ============================================================
		$idTE1 = array(); //Timbangan Elektronik
		$where = "jenis_tarif = 'Elektronik (Kelas III dan IV)'";
		$dataTE1 = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataTE1->child_id == '0') {
			$idTE1[] = $dataTE1->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataTE1->id_tarif);
			foreach ($xx as $key) {
				if ($key != '192' AND $key != '193') {
					$idTE1[] = $key;
				}
			}
		}
		// ============================================================
		$idTE2 = array(); //Timbangan Elektronik > 500kg
		$where = "jenis_tarif = 'Elektronik (Kelas III dan IV)'";
		$dataTE2 = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataTE2->child_id == '0') {
			$idTE2[] = $dataTE2->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataTE2->id_tarif);
			foreach ($xx as $key) {
				if ($key == '192' AND $key == '193') {
					$idTE2[] = $key;
				}
			}
		}
		// ============================================================
		$idTE3 = array(); //Timbangan Elektronik Kelas I
		$where = "jenis_tarif = 'Elektronik (Kelas I)'";
		$dataTE3 = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataTE3->child_id == '0') {
			$idTE3[] = $dataTE3->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataTE3->id_tarif);
			foreach ($xx as $key) {
				$idTE3[] = $key;
			}
		}
		// ===========================================================
		$idJb = array(); //Timbangan Jembatan
		$where = "jenis_tarif = 'Timbangan Jembatan'";
		$dataJb = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataJb->child_id == '0') {
			$idJb[] = $dataJb->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataJb->id_tarif);
			foreach ($xx as $key) {
				$idJb[] = $key;
			}
		}
		// ============================================================
		$idTD = array(); //Tongkat Duga
		$where = "jenis_tarif = 'Meter dengan pegangan, Meter Kayu, Meter Meja dari Logam, Tongkat Duga, Meter Saku Baja, Ban Ukur, Depth Tape'";
		$dataTD = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataTD->child_id == '0') {
			$idTD[] = $dataTD->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataTD->id_tarif);
			foreach ($xx as $key) {
				$idTD[] = $key;
			}
		}
		// ============================================================
		$idFM = array(); //Filling Machine
		$where = "jenis_tarif = 'Alat Ukur Pengisi (Filling Machine)'";
		$dataFM = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataFM->child_id == '0') {
			$idFM[] = $dataFM->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataFM->id_tarif);
			foreach ($xx as $key) {
				$idFM[] = $key;
			}
		}
		// ================================================================
		$select = array(
			'dft.*',
			"(SELECT usr.nama_user FROM tbl_user usr WHERE usr.id_user = (SELECT ush.id_user FROM tbl_usaha ush WHERE ush.id_usaha = dft.id_usaha)) nama_user",
			"(SELECT ush.nama_usaha FROM tbl_usaha ush WHERE ush.id_usaha = dft.id_usaha) nama_usaha",
		);
		$table = 'tbl_pendaftaran dft';
		$where = "id_daftar IN (SELECT byr.id_daftar FROM tbl_pembayaran byr) AND id_tempat_tera = '3' AND layanan = 'tera ulang'";
		$where .= " AND tgl_daftar BETWEEN '$awal' AND '$akhir'";
		$order = 'ASC';
		$by = 'tgl_daftar';
		$dataPendaftaran = $this->MasterData->getWhereDataOrder($select,$table,$where,$by,$order)->result();
		// var_dump($dataPendaftaran);
		$dataLapLoco = array();
		foreach ($dataPendaftaran as $dft) {
			$nama_user = $dft->nama_user;
			$nama_usaha = $dft->nama_usaha;
			$tgl_daftar = date('d-m-Y', strtotime($dft->tgl_daftar));
			$countWTU = 0;
			$countBBM = 0;
			$countBU = 0;
			$countTutsida = 0;
			$countATB = 0;
			$countTM = 0;
			$countTS = 0;
			$countTE1 = 0;
			$countTE2 = 0;
			$countTE3 = 0;
			$countJb = 0;
			$countTD = 0;
			$countFM = 0;
			$totUttp = 0;
			$id_daftar = $dft->id_daftar;
			$where = "id_daftar = $id_daftar AND id_list IN (SELECT tera.id_list FROM tbl_tera tera WHERE tera.hasil_tera = 'disahkan')";
			$dataList = $this->MasterData->getWhereData('*','tbl_list_tera',$where)->result();
			foreach ($dataList as $list) {
				$countWTU++;
				foreach ($idBBM as $BBM) {
					if ($list->id_tarif == $BBM) {
						$countBBM++;
					}
				}
				foreach ($idBU as $BU) {
					if ($list->id_tarif == $BU) {
						$countBU++;
					}
				}
				foreach ($idTutsida as $Tutsida) {
					if ($list->id_tarif == $Tutsida) {
						$countTutsida++;
					}
				}
				foreach ($idATB as $ATB) {
					if ($list->id_tarif == $ATB) {
						$countATB++;
					}
				}
				foreach ($idTM as $TM) {
					if ($list->id_tarif == $TM) {
						$countTM++;
					}
				}
				foreach ($idTS as $TS) {
					if ($list->id_tarif == $TS) {
						$countTS++;
					}
				}
				foreach ($idTE1 as $TE1) {
					if ($list->id_tarif == $TE1) {
						$countTE1++;
					}
				}
				foreach ($idTE2 as $TE2) {
					if ($list->id_tarif == $TE2) {
						$countTE2++;
					}
				}
				foreach ($idTE3 as $TE3) {
					if ($list->id_tarif == $TE3) {
						$countTE3++;
					}
				}
				foreach ($idJb as $Jb) {
					if ($list->id_tarif == $Jb) {
						$countJb++;
					}
				}
				foreach ($idTD as $TD) {
					if ($list->id_tarif == $TD) {
						$countTD++;
					}
				}
				foreach ($idFM as $FM) {
					if ($list->id_tarif == $FM) {
						$countFM++;
					}
				}
			}
			$totUttp = $countBBM + $countBU + $countTutsida + $countATB + $countTM + $countTS + $countTE1 + $countTE2 + $countTE3 + $countJb + $countTD + $countFM;
			$dataLapLoco[] = array(
				'nama_user' => $nama_user,
				'nama_usaha' => $nama_usaha,
				'tgl_daftar' => $tgl_daftar,
				'BBM' => $countBBM,
				'BU' => $countBU,
				'Tutsida' => $countTutsida,
				'ATB' => $countATB,
				'TM' => $countTM,
				'TS' => $countTS,
				'TE1' => $countTE1,
				'TE2' => $countTE2,
				'TE3' => $countTE3,
				'Jb' => $countJb,
				'TD' => $countTD,
				'FM' => $countFM,
				'tot_uttp' => $totUttp
			);
		}
		// var_dump($dataLapLoco);
		// =================================================================
		$select = array(
			'pt.*',
			"(SELECT usr.nama_user FROM tbl_user usr WHERE usr.id_user = pt.id_user) nama_user"
		);
		$where = "id_jabatan = (SELECT jb.id_jabatan FROM tbl_jabatan jb WHERE  jb.nama_jabatan = 'Kepala Dinas')";
		$table = 'tbl_petugas pt';
		$kepalaDinas = $this->MasterData->getWhereData($select,$table,$where)->row();
		$where = "id_jabatan = (SELECT jb.id_jabatan FROM tbl_jabatan jb WHERE  jb.nama_jabatan = 'Bendahara')";
		$bendahara = $this->MasterData->getWhereData($select,$table,$where)->row();
		// ================================================================
		// $this->head[] = "assets/assets/plugins/select2/dist/css/select2.css";
		$this->head[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.css";
		$this->head[] = "assets/assets/plugins/sweetalert/sweetalert.css";
		// $this->head[] = "assets/assets/plugins/dropify/dist/css/dropify.min.css";
		$this->head[] = "assets/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css";
		$this->head[] = "assets/assets/plugins/bootstrap-daterangepicker/daterangepicker.css";
		// $this->foot[] = "assets/assets/plugins/select2/dist/js/select2.full.min.js";
		$this->foot[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/sweetalert.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/jquery.sweet-alert.custom.js";
		$this->foot[] = "assets/assets/plugins/datatables/jquery.dataTables.min.js";
		// $this->foot[] = "assets/assets/plugins/dropify/dist/js/dropify.min.js";
		$this->foot[] = "assets/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js";
		$this->foot[] = "assets/assets/plugins/bootstrap-daterangepicker/daterangepicker.js";
		$script = array(
			"$('#myTable').DataTable();",
			// "$('.select2').select2();",
			// "$('.dropify').dropify({
			// 	 messages: {
	  		//      default: '<center>Upload foto/gambar disini.</center>',
	  		//      error: '<center>Maksimal ukuran file 2 MB.</center>',
	  		//   }
			// });",
			"$('.mydatepicker').datepicker({ format: 'dd-mm-yyyy', autoclose:true });",
			"jQuery('#date-range').datepicker({
		        toggleActive: true,
		        format: 'dd-mm-yyyy', 
		        autoclose:true
		    });",
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
		$nav['menu'] = 'tera_ulang_loco';
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
			'selectTglAwal' => $awal,
			'selectTglAkhir' => $akhir,
			'dataBulan' => $dataBulan,
			'dataLapLoco' => $dataLapLoco,
			'bendahara' => $bendahara,
			'kepalaDinas' => $kepalaDinas,
		);
		$this->load->view('Admin/head',$head);
		$this->load->view('Admin/navigation',$nav);
		$this->load->view('Admin/data_lap_loco',$data);
		$this->load->view('foot',$foot);
	}
	public function cetakLapLoco($tgl_awal='', $tgl_akhir='') {
		if ($tgl_awal != '') {
			$awal = date('Y-m-d', strtotime($tgl_awal));
		} else {
			$awal = date('Y-m-d');			
		}
		if ($tgl_akhir != '') {
			$akhir = date('Y-m-d', strtotime($tgl_akhir));
		} else {
			$akhir = date('Y-m-d');
		}
		// ================================================================
		$select = '*';
		$table = 'tbl_tarif';
		$idBBM = array(); //PU BBM
		$where = "jenis_tarif = 'Meter Bahan Bakar Minyak (Pompa Ukur BBM)'";
		$dataBBM = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataBBM->child_id == '0') {
			$idBBM[] = $dataBBM->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataBBM->id_tarif);
			foreach ($xx as $key) {
				$idBBM[] = $key;
			}
		}
		// ============================================================
		$idBU = array(); //Bejana Ukur
		$where = "jenis_tarif = 'Bejana Ukur'";
		$dataBU = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataBU->child_id == '0') {
			$idBU[] = $dataBU->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataBU->id_tarif);
			foreach ($xx as $key) {
				$idBU[] = $key;
			}
		}
		// ============================================================
		$idTutsida = array(); //Tangki Ukur Tetap Silinder Datar 
		$where = "jenis_tarif = 'Bentuk Silinder Datar'";
		$dataTutsida = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataTutsida->child_id == '0') {
			$idTutsida[] = $dataTutsida->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataTutsida->id_tarif);
			foreach ($xx as $key) {
				$idTutsida[] = $key;
			}
		}
		// ============================================================
		$idATB = array(); //Anak Timbangan Berat
		$where = "jenis_tarif = 'Lebih dari 5 kg sampai dengan 50 kg'";
		$dataATB = $this->MasterData->getWhereData($select,$table,$where)->result();
		foreach ($dataATB as $ATB) {
			if ($ATB->child_id == '0') {
				$idATB[] = $ATB->id_tarif;
			} else {
				$xx = $this->loopIdTarif($ATB->id_tarif);
				foreach ($xx as $key) {
					$idATB[] = $key;
				}
			}
		}
		// ============================================================
		$idTM = array(); //Timbangan Meja
		$where = "jenis_tarif = 'Meja Beranger'";
		$dataTM = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataTM->child_id == '0') {
			$idTM[] = $dataTM->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataTM->id_tarif);
			foreach ($xx as $key) {
				$idTM[] = $key;
			}
		}
		// ============================================================
		$idTS = array(); //Timbangan Sentisimal
		$where = "jenis_tarif = 'Sentisimal'";
		$dataTS = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataTS->child_id == '0') {
			$idTS[] = $dataTS->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataTS->id_tarif);
			foreach ($xx as $key) {
				$idTS[] = $key;
			}
		}
		// ============================================================
		$idTE1 = array(); //Timbangan Elektronik
		$where = "jenis_tarif = 'Elektronik (Kelas III dan IV)'";
		$dataTE1 = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataTE1->child_id == '0') {
			$idTE1[] = $dataTE1->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataTE1->id_tarif);
			foreach ($xx as $key) {
				if ($key != '192' AND $key != '193') {
					$idTE1[] = $key;
				}
			}
		}
		// ============================================================
		$idTE2 = array(); //Timbangan Elektronik > 500kg
		$where = "jenis_tarif = 'Elektronik (Kelas III dan IV)'";
		$dataTE2 = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataTE2->child_id == '0') {
			$idTE2[] = $dataTE2->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataTE2->id_tarif);
			foreach ($xx as $key) {
				if ($key == '192' AND $key == '193') {
					$idTE2[] = $key;
				}
			}
		}
		// ============================================================
		$idTE3 = array(); //Timbangan Elektronik Kelas I
		$where = "jenis_tarif = 'Elektronik (Kelas I)'";
		$dataTE3 = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataTE3->child_id == '0') {
			$idTE3[] = $dataTE3->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataTE3->id_tarif);
			foreach ($xx as $key) {
				$idTE3[] = $key;
			}
		}
		// ===========================================================
		$idJb = array(); //Timbangan Jembatan
		$where = "jenis_tarif = 'Timbangan Jembatan'";
		$dataJb = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataJb->child_id == '0') {
			$idJb[] = $dataJb->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataJb->id_tarif);
			foreach ($xx as $key) {
				$idJb[] = $key;
			}
		}
		// ============================================================
		$idTD = array(); //Tongkat Duga
		$where = "jenis_tarif = 'Meter dengan pegangan, Meter Kayu, Meter Meja dari Logam, Tongkat Duga, Meter Saku Baja, Ban Ukur, Depth Tape'";
		$dataTD = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataTD->child_id == '0') {
			$idTD[] = $dataTD->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataTD->id_tarif);
			foreach ($xx as $key) {
				$idTD[] = $key;
			}
		}
		// ============================================================
		$idFM = array(); //Filling Machine
		$where = "jenis_tarif = 'Alat Ukur Pengisi (Filling Machine)'";
		$dataFM = $this->MasterData->getWhereData($select,$table,$where)->row();
		if ($dataFM->child_id == '0') {
			$idFM[] = $dataFM->id_tarif;
		} else {
			$xx = $this->loopIdTarif($dataFM->id_tarif);
			foreach ($xx as $key) {
				$idFM[] = $key;
			}
		}
		// ================================================================
		$select = array(
			'dft.*',
			"(SELECT usr.nama_user FROM tbl_user usr WHERE usr.id_user = (SELECT ush.id_user FROM tbl_usaha ush WHERE ush.id_usaha = dft.id_usaha)) nama_user",
			"(SELECT ush.nama_usaha FROM tbl_usaha ush WHERE ush.id_usaha = dft.id_usaha) nama_usaha",
		);
		$table = 'tbl_pendaftaran dft';
		$where = "id_daftar IN (SELECT byr.id_daftar FROM tbl_pembayaran byr) AND id_tempat_tera = '3'";
		$where .= " AND tgl_daftar BETWEEN '$awal' AND '$akhir'";
		$order = 'ASC';
		$by = 'tgl_daftar';
		$dataPendaftaran = $this->MasterData->getWhereDataOrder($select,$table,$where,$by,$order)->result();
		// var_dump($dataPendaftaran);
		$dataLapLoco = array();
		foreach ($dataPendaftaran as $dft) {
			$nama_user = $dft->nama_user;
			$nama_usaha = $dft->nama_usaha;
			$tgl_daftar = date('d-m-Y', strtotime($dft->tgl_daftar));
			$countWTU = 0;
			$countBBM = 0;
			$countBU = 0;
			$countTutsida = 0;
			$countATB = 0;
			$countTM = 0;
			$countTS = 0;
			$countTE1 = 0;
			$countTE2 = 0;
			$countTE3 = 0;
			$countJb = 0;
			$countTD = 0;
			$countFM = 0;
			$totUttp = 0;
			$id_daftar = $dft->id_daftar;
			$where = "id_daftar = $id_daftar AND id_list IN (SELECT tera.id_list FROM tbl_tera tera WHERE tera.hasil_tera = 'disahkan')";
			$dataList = $this->MasterData->getWhereData('*','tbl_list_tera',$where)->result();
			foreach ($dataList as $list) {
				$countWTU++;
				foreach ($idBBM as $BBM) {
					if ($list->id_tarif == $BBM) {
						$countBBM++;
					}
				}
				foreach ($idBU as $BU) {
					if ($list->id_tarif == $BU) {
						$countBU++;
					}
				}
				foreach ($idTutsida as $Tutsida) {
					if ($list->id_tarif == $Tutsida) {
						$countTutsida++;
					}
				}
				foreach ($idATB as $ATB) {
					if ($list->id_tarif == $ATB) {
						$countATB++;
					}
				}
				foreach ($idTM as $TM) {
					if ($list->id_tarif == $TM) {
						$countTM++;
					}
				}
				foreach ($idTS as $TS) {
					if ($list->id_tarif == $TS) {
						$countTS++;
					}
				}
				foreach ($idTE1 as $TE1) {
					if ($list->id_tarif == $TE1) {
						$countTE1++;
					}
				}
				foreach ($idTE2 as $TE2) {
					if ($list->id_tarif == $TE2) {
						$countTE2++;
					}
				}
				foreach ($idTE3 as $TE3) {
					if ($list->id_tarif == $TE3) {
						$countTE3++;
					}
				}
				foreach ($idJb as $Jb) {
					if ($list->id_tarif == $Jb) {
						$countJb++;
					}
				}
				foreach ($idTD as $TD) {
					if ($list->id_tarif == $TD) {
						$countTD++;
					}
				}
				foreach ($idFM as $FM) {
					if ($list->id_tarif == $FM) {
						$countFM++;
					}
				}
			}
			$totUttp = $countBBM + $countBU + $countTutsida + $countATB + $countTM + $countTS + $countTE1 + $countTE2 + $countTE3 + $countJb + $countTD + $countFM;
			$dataLapLoco[] = array(
				'nama_user' => $nama_user,
				'nama_usaha' => $nama_usaha,
				'tgl_daftar' => $tgl_daftar,
				'BBM' => $countBBM,
				'BU' => $countBU,
				'Tutsida' => $countTutsida,
				'ATB' => $countATB,
				'TM' => $countTM,
				'TS' => $countTS,
				'TE1' => $countTE1,
				'TE2' => $countTE2,
				'TE3' => $countTE3,
				'Jb' => $countJb,
				'TD' => $countTD,
				'FM' => $countFM,
				'tot_uttp' => $totUttp
			);
		}
		// =================================================================
		$select = array(
			'pt.*',
			"(SELECT usr.nama_user FROM tbl_user usr WHERE usr.id_user = pt.id_user) nama_user"
		);
		$where = "id_jabatan = (SELECT jb.id_jabatan FROM tbl_jabatan jb WHERE  jb.nama_jabatan = 'Kepala Dinas')";
		$table = 'tbl_petugas pt';
		$kepalaDinas = $this->MasterData->getWhereData($select,$table,$where)->row();
		$where = "id_jabatan = (SELECT jb.id_jabatan FROM tbl_jabatan jb WHERE  jb.nama_jabatan = 'Bendahara')";
		$bendahara = $this->MasterData->getWhereData($select,$table,$where)->row();
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
			'selectTglAwal' => $awal,
			'selectTglAkhir' => $akhir,
			'dataBulan' => $dataBulan,
			'dataLapLoco' => $dataLapLoco,
			'bendahara' => $bendahara,
			'kepalaDinas' => $kepalaDinas,
		);
		$this->load->library('PhpExcelNew/PHPExcel');
		$this->load->view('Admin/laporan/printLapLoco',$data);
	}
	// =====================================================
	public function lapRegisterSidang($tgl_awal='', $tgl_akhir='', $psr='') {
		if ($tgl_awal != '') {
			$awal = date('Y-m-d', strtotime($tgl_awal));
		} else {
			$awal = date('Y-m-1');			
		}
		if ($tgl_akhir != '') {
			$akhir = date('Y-m-d', strtotime($tgl_akhir));
		} else {
			$akhir = date('Y-m-d');
		}
		if ($psr != '') {
			$pasar = decode($psr);
		} else {
			$pasar = 1;
		}
		// ================================================================
		$select = array(
			'dft.id_daftar',
			'dft.tgl_daftar',
			'dft.no_order',
			"(SELECT usr.nama_user FROM tbl_user usr WHERE usr.id_user = (SELECT ush.id_user FROM tbl_usaha ush WHERE ush.id_usaha = dft.id_usaha)) nama_user",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '26' AND list.id_daftar = dft.id_daftar) up1",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '27' AND list.id_daftar = dft.id_daftar) up2",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '38' AND list.id_daftar = dft.id_daftar) tk1",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '39' AND list.id_daftar = dft.id_daftar) tk2",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '155' AND list.id_daftar = dft.id_daftar) at1",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '156' AND list.id_daftar = dft.id_daftar) at2",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '157' AND list.id_daftar = dft.id_daftar) at3",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '158' AND list.id_daftar = dft.id_daftar) at4",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '159' AND list.id_daftar = dft.id_daftar) at5",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '164' AND list.id_daftar = dft.id_daftar) nc",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '177' AND list.id_daftar = dft.id_daftar) dc1",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '178' AND list.id_daftar = dft.id_daftar) dc2",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '179' AND list.id_daftar = dft.id_daftar) ss1",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '180' AND list.id_daftar = dft.id_daftar) ss2",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '181' AND list.id_daftar = dft.id_daftar) ss3",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '182' AND list.id_daftar = dft.id_daftar) bi1",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '183' AND list.id_daftar = dft.id_daftar) bi2",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '184' AND list.id_daftar = dft.id_daftar) bi3",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '169' AND list.id_daftar = dft.id_daftar) mb",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '185' AND list.id_daftar = dft.id_daftar) pg1",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '186' AND list.id_daftar = dft.id_daftar) pg2",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '187' AND list.id_daftar = dft.id_daftar) cp1",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '188' AND list.id_daftar = dft.id_daftar) cp2",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '189' AND list.id_daftar = dft.id_daftar) el1",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '190' AND list.id_daftar = dft.id_daftar) el2",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '191' AND list.id_daftar = dft.id_daftar) el3",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '192' AND list.id_daftar = dft.id_daftar) el4",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '194' AND list.id_daftar = dft.id_daftar) el5",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '195' AND list.id_daftar = dft.id_daftar) el6",
			//tarif
			"(SELECT trf.tera_ulang_kantor FROM tbl_tarif trf WHERE trf.id_tarif = '26') tarif_up1",
			"(SELECT trf.tera_ulang_kantor FROM tbl_tarif trf WHERE trf.id_tarif = '27') tarif_up2",
			"(SELECT trf.tera_ulang_kantor FROM tbl_tarif trf WHERE trf.id_tarif = '38') tarif_tk1",
			"(SELECT trf.tera_ulang_kantor FROM tbl_tarif trf WHERE trf.id_tarif = '39') tarif_tk2",
			"(SELECT trf.tera_ulang_kantor FROM tbl_tarif trf WHERE trf.id_tarif = '155') tarif_at1",
			"(SELECT trf.tera_ulang_kantor FROM tbl_tarif trf WHERE trf.id_tarif = '156') tarif_at2",
			"(SELECT trf.tera_ulang_kantor FROM tbl_tarif trf WHERE trf.id_tarif = '157') tarif_at3",
			"(SELECT trf.tera_ulang_kantor FROM tbl_tarif trf WHERE trf.id_tarif = '158') tarif_at4",
			"(SELECT trf.tera_ulang_kantor FROM tbl_tarif trf WHERE trf.id_tarif = '159') tarif_at5",
			"(SELECT trf.tera_ulang_kantor FROM tbl_tarif trf WHERE trf.id_tarif = '164') tarif_nc",
			"(SELECT trf.tera_ulang_kantor FROM tbl_tarif trf WHERE trf.id_tarif = '177') tarif_dc1",
			"(SELECT trf.tera_ulang_kantor FROM tbl_tarif trf WHERE trf.id_tarif = '178') tarif_dc2",
			"(SELECT trf.tera_ulang_kantor FROM tbl_tarif trf WHERE trf.id_tarif = '179') tarif_ss1",
			"(SELECT trf.tera_ulang_kantor FROM tbl_tarif trf WHERE trf.id_tarif = '180') tarif_ss2",
			"(SELECT trf.tera_ulang_kantor FROM tbl_tarif trf WHERE trf.id_tarif = '181') tarif_ss3",
			"(SELECT trf.tera_ulang_kantor FROM tbl_tarif trf WHERE trf.id_tarif = '182') tarif_bi1",
			"(SELECT trf.tera_ulang_kantor FROM tbl_tarif trf WHERE trf.id_tarif = '183') tarif_bi2",
			"(SELECT trf.tera_ulang_kantor FROM tbl_tarif trf WHERE trf.id_tarif = '184') tarif_bi3",
			"(SELECT trf.tera_ulang_kantor FROM tbl_tarif trf WHERE trf.id_tarif = '169') tarif_mb",
			"(SELECT trf.tera_ulang_kantor FROM tbl_tarif trf WHERE trf.id_tarif = '185') tarif_pg1",
			"(SELECT trf.tera_ulang_kantor FROM tbl_tarif trf WHERE trf.id_tarif = '186') tarif_pg2",
			"(SELECT trf.tera_ulang_kantor FROM tbl_tarif trf WHERE trf.id_tarif = '187') tarif_cp1",
			"(SELECT trf.tera_ulang_kantor FROM tbl_tarif trf WHERE trf.id_tarif = '188') tarif_cp2",
			"(SELECT trf.tera_ulang_kantor FROM tbl_tarif trf WHERE trf.id_tarif = '189') tarif_el1",
			"(SELECT trf.tera_ulang_kantor FROM tbl_tarif trf WHERE trf.id_tarif = '190') tarif_el2",
			"(SELECT trf.tera_ulang_kantor FROM tbl_tarif trf WHERE trf.id_tarif = '191') tarif_el3",
			"(SELECT trf.tera_ulang_kantor FROM tbl_tarif trf WHERE trf.id_tarif = '192') tarif_el4",
			"(SELECT trf.tera_ulang_kantor FROM tbl_tarif trf WHERE trf.id_tarif = '194') tarif_el5",
			"(SELECT trf.tera_ulang_kantor FROM tbl_tarif trf WHERE trf.id_tarif = '195') tarif_el6",
		);
		$table = 'tbl_pendaftaran dft';
		$where = "id_daftar IN (SELECT byr.id_daftar FROM tbl_pembayaran byr) AND id_daftar IN (SELECT list.id_daftar FROM tbl_list_sidang list WHERE list.id_sidang IN (SELECT st.id_sidang FROM tbl_sidang_tera st WHERE st.id_pasar = '$pasar' AND st.tgl_sidang BETWEEN '$awal' AND '$akhir'))";
		$by = 'tgl_daftar';
		$order = 'ASC';
		$dataRegSidang = $this->MasterData->getWhereDataOrder($select,$table,$where,$by,$order)->result();
		// var_dump($dataRegSidang);
		// ================================================================
		$select = '*';
		$dataPasar = $this->MasterData->getSelectData($select,'tbl_pasar')->result();
		// ================================================================
		// $this->head[] = "assets/assets/plugins/select2/dist/css/select2.css";
		$this->head[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.css";
		$this->head[] = "assets/assets/plugins/sweetalert/sweetalert.css";
		// $this->head[] = "assets/assets/plugins/dropify/dist/css/dropify.min.css";
		$this->head[] = "assets/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css";
		$this->head[] = "assets/assets/plugins/bootstrap-daterangepicker/daterangepicker.css";
		// $this->foot[] = "assets/assets/plugins/select2/dist/js/select2.full.min.js";
		$this->foot[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/sweetalert.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/jquery.sweet-alert.custom.js";
		// $this->foot[] = "assets/assets/plugins/dropify/dist/js/dropify.min.js";
		$this->foot[] = "assets/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js";
		$this->foot[] = "assets/assets/plugins/bootstrap-daterangepicker/daterangepicker.js";
		$this->foot[] = "assets/assets/plugins/datatables/jquery.dataTables.min.js";
	    $this->foot[] = "assets/assets/plugins/datatables-plugins/export/dataTables.buttons.min.js";
	    $this->foot[] = "assets/assets/plugins/datatables-plugins/export/buttons.flash.min.js";
	    $this->foot[] = "assets/assets/plugins/datatables-plugins/export/jszip.min.js";
	    $this->foot[] = "assets/assets/plugins/datatables-plugins/export/pdfmake.min.js";
	    $this->foot[] = "assets/assets/plugins/datatables-plugins/export/vfs_fonts.js";
	    $this->foot[] = "assets/assets/plugins/datatables-plugins/export/buttons.html5.min.js";
	    $this->foot[] = "assets/assets/plugins/datatables-plugins/export/buttons.print.min.js";
		$script = array(
			"$('#myTable').DataTable();",
			// "$('#myTable').DataTable({
		 //        dom: 'Bfrtip',
		 //        buttons: [
		 //            {
		 //                extend: 'excelHtml5',
		 //                title: 'Register Sidang'
		 //            },
		 //            {
		 //                extend: 'pdfHtml5',
		 //                title: 'Register Sidang'
		 //            }
		 //        ]
		 //    });",
			// "$('.select2').select2();",
			// "$('.dropify').dropify({
			// 	 messages: {
	  		//      default: '<center>Upload foto/gambar disini.</center>',
	  		//      error: '<center>Maksimal ukuran file 2 MB.</center>',
	  		//   }
			// });",
			"$('.mydatepicker').datepicker({ format: 'dd-mm-yyyy', autoclose:true });",
			"jQuery('#date-range').datepicker({
		        toggleActive: true,
		        format: 'dd-mm-yyyy', 
		        autoclose:true
		    });",
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
		$nav['menu'] = 'reg_sidang';
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
			'selectTglAwal' => $awal,
			'selectTglAkhir' => $akhir,
			'dataBulan' => $dataBulan,
			'dataRegSidang' => $dataRegSidang,
			'dataPasar' => $dataPasar,
			'selectPasar' => $pasar,
			// 'bendahara' => $bendahara,
			// 'kepalaDinas' => $kepalaDinas,
		);
		$this->load->view('Admin/head',$head);
		$this->load->view('Admin/navigation',$nav);
		$this->load->view('Admin/data_lap_reg_sidang',$data);
		$this->load->view('foot',$foot);
	}
	public function cetakLapRegSidang($tgl_awal='', $tgl_akhir='', $psr='') {
		if ($tgl_awal != '') {
			$awal = date('Y-m-d', strtotime($tgl_awal));
		} else {
			$awal = date('Y-m-1');			
		}
		if ($tgl_akhir != '') {
			$akhir = date('Y-m-d', strtotime($tgl_akhir));
		} else {
			$akhir = date('Y-m-d');
		}
		if ($psr != '') {
			$pasar = decode($psr);
		} else {
			$pasar = 1;
		}
		// ================================================================
		$select = array(
			'dft.id_daftar',
			'dft.tgl_daftar',
			'dft.no_order',
			"(SELECT usr.nama_user FROM tbl_user usr WHERE usr.id_user = (SELECT ush.id_user FROM tbl_usaha ush WHERE ush.id_usaha = dft.id_usaha)) nama_user",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '26' AND list.id_daftar = dft.id_daftar) up1",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '27' AND list.id_daftar = dft.id_daftar) up2",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '38' AND list.id_daftar = dft.id_daftar) tk1",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '39' AND list.id_daftar = dft.id_daftar) tk2",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '155' AND list.id_daftar = dft.id_daftar) at1",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '156' AND list.id_daftar = dft.id_daftar) at2",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '157' AND list.id_daftar = dft.id_daftar) at3",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '158' AND list.id_daftar = dft.id_daftar) at4",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '159' AND list.id_daftar = dft.id_daftar) at5",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '164' AND list.id_daftar = dft.id_daftar) nc",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '177' AND list.id_daftar = dft.id_daftar) dc1",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '178' AND list.id_daftar = dft.id_daftar) dc2",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '179' AND list.id_daftar = dft.id_daftar) ss1",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '180' AND list.id_daftar = dft.id_daftar) ss2",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '181' AND list.id_daftar = dft.id_daftar) ss3",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '182' AND list.id_daftar = dft.id_daftar) bi1",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '183' AND list.id_daftar = dft.id_daftar) bi2",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '184' AND list.id_daftar = dft.id_daftar) bi3",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '169' AND list.id_daftar = dft.id_daftar) mb",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '185' AND list.id_daftar = dft.id_daftar) pg1",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '186' AND list.id_daftar = dft.id_daftar) pg2",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '187' AND list.id_daftar = dft.id_daftar) cp1",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '188' AND list.id_daftar = dft.id_daftar) cp2",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '189' AND list.id_daftar = dft.id_daftar) el1",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '190' AND list.id_daftar = dft.id_daftar) el2",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '191' AND list.id_daftar = dft.id_daftar) el3",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '192' AND list.id_daftar = dft.id_daftar) el4",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '194' AND list.id_daftar = dft.id_daftar) el5",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '195' AND list.id_daftar = dft.id_daftar) el6",
			//tarif
			"(SELECT trf.tera_ulang_tempat_pakai FROM tbl_tarif trf WHERE trf.id_tarif = '26') tarif_up1",
			"(SELECT trf.tera_ulang_tempat_pakai FROM tbl_tarif trf WHERE trf.id_tarif = '27') tarif_up2",
			"(SELECT trf.tera_ulang_tempat_pakai FROM tbl_tarif trf WHERE trf.id_tarif = '38') tarif_tk1",
			"(SELECT trf.tera_ulang_tempat_pakai FROM tbl_tarif trf WHERE trf.id_tarif = '39') tarif_tk2",
			"(SELECT trf.tera_ulang_tempat_pakai FROM tbl_tarif trf WHERE trf.id_tarif = '155') tarif_at1",
			"(SELECT trf.tera_ulang_tempat_pakai FROM tbl_tarif trf WHERE trf.id_tarif = '156') tarif_at2",
			"(SELECT trf.tera_ulang_tempat_pakai FROM tbl_tarif trf WHERE trf.id_tarif = '157') tarif_at3",
			"(SELECT trf.tera_ulang_tempat_pakai FROM tbl_tarif trf WHERE trf.id_tarif = '158') tarif_at4",
			"(SELECT trf.tera_ulang_tempat_pakai FROM tbl_tarif trf WHERE trf.id_tarif = '159') tarif_at5",
			"(SELECT trf.tera_ulang_tempat_pakai FROM tbl_tarif trf WHERE trf.id_tarif = '164') tarif_nc",
			"(SELECT trf.tera_ulang_tempat_pakai FROM tbl_tarif trf WHERE trf.id_tarif = '177') tarif_dc1",
			"(SELECT trf.tera_ulang_tempat_pakai FROM tbl_tarif trf WHERE trf.id_tarif = '178') tarif_dc2",
			"(SELECT trf.tera_ulang_tempat_pakai FROM tbl_tarif trf WHERE trf.id_tarif = '179') tarif_ss1",
			"(SELECT trf.tera_ulang_tempat_pakai FROM tbl_tarif trf WHERE trf.id_tarif = '180') tarif_ss2",
			"(SELECT trf.tera_ulang_tempat_pakai FROM tbl_tarif trf WHERE trf.id_tarif = '181') tarif_ss3",
			"(SELECT trf.tera_ulang_tempat_pakai FROM tbl_tarif trf WHERE trf.id_tarif = '182') tarif_bi1",
			"(SELECT trf.tera_ulang_tempat_pakai FROM tbl_tarif trf WHERE trf.id_tarif = '183') tarif_bi2",
			"(SELECT trf.tera_ulang_tempat_pakai FROM tbl_tarif trf WHERE trf.id_tarif = '184') tarif_bi3",
			"(SELECT trf.tera_ulang_tempat_pakai FROM tbl_tarif trf WHERE trf.id_tarif = '169') tarif_mb",
			"(SELECT trf.tera_ulang_tempat_pakai FROM tbl_tarif trf WHERE trf.id_tarif = '185') tarif_pg1",
			"(SELECT trf.tera_ulang_tempat_pakai FROM tbl_tarif trf WHERE trf.id_tarif = '186') tarif_pg2",
			"(SELECT trf.tera_ulang_tempat_pakai FROM tbl_tarif trf WHERE trf.id_tarif = '187') tarif_cp1",
			"(SELECT trf.tera_ulang_tempat_pakai FROM tbl_tarif trf WHERE trf.id_tarif = '188') tarif_cp2",
			"(SELECT trf.tera_ulang_tempat_pakai FROM tbl_tarif trf WHERE trf.id_tarif = '189') tarif_el1",
			"(SELECT trf.tera_ulang_tempat_pakai FROM tbl_tarif trf WHERE trf.id_tarif = '190') tarif_el2",
			"(SELECT trf.tera_ulang_tempat_pakai FROM tbl_tarif trf WHERE trf.id_tarif = '191') tarif_el3",
			"(SELECT trf.tera_ulang_tempat_pakai FROM tbl_tarif trf WHERE trf.id_tarif = '192') tarif_el4",
			"(SELECT trf.tera_ulang_tempat_pakai FROM tbl_tarif trf WHERE trf.id_tarif = '194') tarif_el5",
			"(SELECT trf.tera_ulang_tempat_pakai FROM tbl_tarif trf WHERE trf.id_tarif = '195') tarif_el6",
		);
		$table = 'tbl_pendaftaran dft';
		$where = "id_daftar IN (SELECT byr.id_daftar FROM tbl_pembayaran byr) AND id_daftar IN (SELECT list.id_daftar FROM tbl_list_sidang list WHERE list.id_sidang IN (SELECT st.id_sidang FROM tbl_sidang_tera st WHERE st.id_pasar = '$pasar' AND st.tgl_sidang BETWEEN '$awal' AND '$akhir'))";
		$by = 'tgl_daftar';
		$order = 'ASC';
		$dataRegSidang = $this->MasterData->getWhereDataOrder($select,$table,$where,$by,$order)->result();
		// var_dump($dataRegSidang);
		// ================================================================
		$select = '*';
		$where = "id_pasar = '$pasar'";
		$dataPasar = $this->MasterData->getWhereData($select,'tbl_pasar',$where)->row()->nama_pasar;
		// ================================================================
		// =================================================================
		$select = array(
			'pt.*',
			"(SELECT usr.nama_user FROM tbl_user usr WHERE usr.id_user = pt.id_user) nama_user"
		);
		$where = "id_jabatan = (SELECT jb.id_jabatan FROM tbl_jabatan jb WHERE  jb.nama_jabatan = 'Kepala Dinas')";
		$table = 'tbl_petugas pt';
		$kepalaDinas = $this->MasterData->getWhereData($select,$table,$where)->row();
		$where = "id_jabatan = (SELECT jb.id_jabatan FROM tbl_jabatan jb WHERE  jb.nama_jabatan = 'Bendahara')";
		$bendahara = $this->MasterData->getWhereData($select,$table,$where)->row();
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
			'selectTglAwal' => $awal,
			'selectTglAkhir' => $akhir,
			'dataBulan' => $dataBulan,
			'dataRegSidang' => $dataRegSidang,
			'dataPasar' => $dataPasar,
			// 'selectPasar' => $pasar,
			'bendahara' => $bendahara,
			'kepalaDinas' => $kepalaDinas,
		);
		$this->load->library('PhpExcelNew/PHPExcel');
		$this->load->view('Admin/laporan/printLapRegSidang',$data);
	}
	// =====================================================
	public function lapRegisterBukanPasar($tgl_awal='', $tgl_akhir='') {
		if ($tgl_awal != '') {
			$awal = date('Y-m-d', strtotime($tgl_awal));
		} else {
			$awal = date('Y-m-1');			
		}
		if ($tgl_akhir != '') {
			$akhir = date('Y-m-d', strtotime($tgl_akhir));
		} else {
			$akhir = date('Y-m-d');
		}
		// ================================================================
		$select = array(
			'dft.id_daftar',
			'dft.tgl_daftar',
			'dft.no_order',
			"(SELECT usr.nama_user FROM tbl_user usr WHERE usr.id_user = (SELECT ush.id_user FROM tbl_usaha ush WHERE ush.id_usaha = dft.id_usaha)) nama_user",
			"(SELECT jns.nama_jenis_usaha FROM tbl_jenis_usaha jns WHERE jns.id_jenis_usaha = (SELECT ush.id_jenis_usaha FROM tbl_usaha ush WHERE ush.id_usaha = dft.id_usaha)) jenis_usaha",
			"(SELECT ush.nama_usaha FROM tbl_usaha ush WHERE ush.id_usaha = dft.id_usaha) nama_usaha",
			"(SELECT tp.tempat_tera FROM tbl_tempat_tera tp WHERE tp.id_tempat_tera = dft.id_tempat_tera) tempat_tera",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '26' AND list.id_daftar = dft.id_daftar) up1",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '27' AND list.id_daftar = dft.id_daftar) up2",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '38' AND list.id_daftar = dft.id_daftar) tk1",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '39' AND list.id_daftar = dft.id_daftar) tk2",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '155' AND list.id_daftar = dft.id_daftar) at1",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '156' AND list.id_daftar = dft.id_daftar) at2",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '157' AND list.id_daftar = dft.id_daftar) at3",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '158' AND list.id_daftar = dft.id_daftar) at4",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '159' AND list.id_daftar = dft.id_daftar) at5",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '164' AND list.id_daftar = dft.id_daftar) nc",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '177' AND list.id_daftar = dft.id_daftar) dc1",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '178' AND list.id_daftar = dft.id_daftar) dc2",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '179' AND list.id_daftar = dft.id_daftar) ss1",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '180' AND list.id_daftar = dft.id_daftar) ss2",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '181' AND list.id_daftar = dft.id_daftar) ss3",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '182' AND list.id_daftar = dft.id_daftar) bi1",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '183' AND list.id_daftar = dft.id_daftar) bi2",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '184' AND list.id_daftar = dft.id_daftar) bi3",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '169' AND list.id_daftar = dft.id_daftar) mb",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '185' AND list.id_daftar = dft.id_daftar) pg1",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '186' AND list.id_daftar = dft.id_daftar) pg2",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '187' AND list.id_daftar = dft.id_daftar) cp1",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '188' AND list.id_daftar = dft.id_daftar) cp2",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '189' AND list.id_daftar = dft.id_daftar) el1",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '190' AND list.id_daftar = dft.id_daftar) el2",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '191' AND list.id_daftar = dft.id_daftar) el3",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '192' AND list.id_daftar = dft.id_daftar) el4",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '194' AND list.id_daftar = dft.id_daftar) el5",
			"(SELECT COUNT(list.id_list) jml FROM tbl_list_tera list WHERE list.id_tarif = '195' AND list.id_daftar = dft.id_daftar) el6",
			//tarif
			"(SELECT trf.tera_ulang_tempat_pakai FROM tbl_tarif trf WHERE trf.id_tarif = '26') tarif_up1",
			"(SELECT trf.tera_ulang_tempat_pakai FROM tbl_tarif trf WHERE trf.id_tarif = '27') tarif_up2",
			"(SELECT trf.tera_ulang_tempat_pakai FROM tbl_tarif trf WHERE trf.id_tarif = '38') tarif_tk1",
			"(SELECT trf.tera_ulang_tempat_pakai FROM tbl_tarif trf WHERE trf.id_tarif = '39') tarif_tk2",
			"(SELECT trf.tera_ulang_tempat_pakai FROM tbl_tarif trf WHERE trf.id_tarif = '155') tarif_at1",
			"(SELECT trf.tera_ulang_tempat_pakai FROM tbl_tarif trf WHERE trf.id_tarif = '156') tarif_at2",
			"(SELECT trf.tera_ulang_tempat_pakai FROM tbl_tarif trf WHERE trf.id_tarif = '157') tarif_at3",
			"(SELECT trf.tera_ulang_tempat_pakai FROM tbl_tarif trf WHERE trf.id_tarif = '158') tarif_at4",
			"(SELECT trf.tera_ulang_tempat_pakai FROM tbl_tarif trf WHERE trf.id_tarif = '159') tarif_at5",
			"(SELECT trf.tera_ulang_tempat_pakai FROM tbl_tarif trf WHERE trf.id_tarif = '164') tarif_nc",
			"(SELECT trf.tera_ulang_tempat_pakai FROM tbl_tarif trf WHERE trf.id_tarif = '177') tarif_dc1",
			"(SELECT trf.tera_ulang_tempat_pakai FROM tbl_tarif trf WHERE trf.id_tarif = '178') tarif_dc2",
			"(SELECT trf.tera_ulang_tempat_pakai FROM tbl_tarif trf WHERE trf.id_tarif = '179') tarif_ss1",
			"(SELECT trf.tera_ulang_tempat_pakai FROM tbl_tarif trf WHERE trf.id_tarif = '180') tarif_ss2",
			"(SELECT trf.tera_ulang_tempat_pakai FROM tbl_tarif trf WHERE trf.id_tarif = '181') tarif_ss3",
			"(SELECT trf.tera_ulang_tempat_pakai FROM tbl_tarif trf WHERE trf.id_tarif = '182') tarif_bi1",
			"(SELECT trf.tera_ulang_tempat_pakai FROM tbl_tarif trf WHERE trf.id_tarif = '183') tarif_bi2",
			"(SELECT trf.tera_ulang_tempat_pakai FROM tbl_tarif trf WHERE trf.id_tarif = '184') tarif_bi3",
			"(SELECT trf.tera_ulang_tempat_pakai FROM tbl_tarif trf WHERE trf.id_tarif = '169') tarif_mb",
			"(SELECT trf.tera_ulang_tempat_pakai FROM tbl_tarif trf WHERE trf.id_tarif = '185') tarif_pg1",
			"(SELECT trf.tera_ulang_tempat_pakai FROM tbl_tarif trf WHERE trf.id_tarif = '186') tarif_pg2",
			"(SELECT trf.tera_ulang_tempat_pakai FROM tbl_tarif trf WHERE trf.id_tarif = '187') tarif_cp1",
			"(SELECT trf.tera_ulang_tempat_pakai FROM tbl_tarif trf WHERE trf.id_tarif = '188') tarif_cp2",
			"(SELECT trf.tera_ulang_tempat_pakai FROM tbl_tarif trf WHERE trf.id_tarif = '189') tarif_el1",
			"(SELECT trf.tera_ulang_tempat_pakai FROM tbl_tarif trf WHERE trf.id_tarif = '190') tarif_el2",
			"(SELECT trf.tera_ulang_tempat_pakai FROM tbl_tarif trf WHERE trf.id_tarif = '191') tarif_el3",
			"(SELECT trf.tera_ulang_tempat_pakai FROM tbl_tarif trf WHERE trf.id_tarif = '192') tarif_el4",
			"(SELECT trf.tera_ulang_tempat_pakai FROM tbl_tarif trf WHERE trf.id_tarif = '194') tarif_el5",
			"(SELECT trf.tera_ulang_tempat_pakai FROM tbl_tarif trf WHERE trf.id_tarif = '195') tarif_el6",
		);
		$table = 'tbl_pendaftaran dft';
		$where = "id_daftar IN (SELECT byr.id_daftar FROM tbl_pembayaran byr) AND id_daftar NOT IN (SELECT list.id_daftar FROM tbl_list_sidang list) AND tgl_daftar BETWEEN '$awal' AND '$akhir'";
		$by = 'tgl_daftar';
		$order = 'ASC';
		$dataRegSidang = $this->MasterData->getWhereDataOrder($select,$table,$where,$by,$order)->result();
		var_dump($dataRegSidang);
		// ================================================================
		$select = '*';
		$dataPasar = $this->MasterData->getSelectData($select,'tbl_pasar')->result();
		// ================================================================
		// $this->head[] = "assets/assets/plugins/select2/dist/css/select2.css";
		$this->head[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.css";
		$this->head[] = "assets/assets/plugins/sweetalert/sweetalert.css";
		// $this->head[] = "assets/assets/plugins/dropify/dist/css/dropify.min.css";
		$this->head[] = "assets/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css";
		$this->head[] = "assets/assets/plugins/bootstrap-daterangepicker/daterangepicker.css";
		// $this->foot[] = "assets/assets/plugins/select2/dist/js/select2.full.min.js";
		$this->foot[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/sweetalert.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/jquery.sweet-alert.custom.js";
		// $this->foot[] = "assets/assets/plugins/dropify/dist/js/dropify.min.js";
		$this->foot[] = "assets/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js";
		$this->foot[] = "assets/assets/plugins/bootstrap-daterangepicker/daterangepicker.js";
		$this->foot[] = "assets/assets/plugins/datatables/jquery.dataTables.min.js";
	    $this->foot[] = "assets/assets/plugins/datatables-plugins/export/dataTables.buttons.min.js";
	    $this->foot[] = "assets/assets/plugins/datatables-plugins/export/buttons.flash.min.js";
	    $this->foot[] = "assets/assets/plugins/datatables-plugins/export/jszip.min.js";
	    $this->foot[] = "assets/assets/plugins/datatables-plugins/export/pdfmake.min.js";
	    $this->foot[] = "assets/assets/plugins/datatables-plugins/export/vfs_fonts.js";
	    $this->foot[] = "assets/assets/plugins/datatables-plugins/export/buttons.html5.min.js";
	    $this->foot[] = "assets/assets/plugins/datatables-plugins/export/buttons.print.min.js";
		$script = array(
			// "$('#myTable').DataTable();",
			"$('#myTable').DataTable({
		        dom: 'Bfrtip',
		        buttons: [
		            {
		                extend: 'excelHtml5',
		                title: 'Register Sidang'
		            },
		            {
		                extend: 'pdfHtml5',
		                title: 'Register Sidang'
		            }
		        ]
		    });",
			// "$('.select2').select2();",
			// "$('.dropify').dropify({
			// 	 messages: {
	  		//      default: '<center>Upload foto/gambar disini.</center>',
	  		//      error: '<center>Maksimal ukuran file 2 MB.</center>',
	  		//   }
			// });",
			"$('.mydatepicker').datepicker({ format: 'dd-mm-yyyy', autoclose:true });",
			"jQuery('#date-range').datepicker({
		        toggleActive: true,
		        format: 'dd-mm-yyyy', 
		        autoclose:true
		    });",
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
		$nav['menu'] = 'reg_sidang';
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
			'selectTglAwal' => $awal,
			'selectTglAkhir' => $akhir,
			'dataBulan' => $dataBulan,
			'dataRegSidang' => $dataRegSidang,
			// 'dataPasar' => $dataPasar
			// 'bendahara' => $bendahara,
			// 'kepalaDinas' => $kepalaDinas,
		);
		// $this->load->view('Admin/head',$head);
		// $this->load->view('Admin/navigation',$nav);
		// $this->load->view('Admin/data_lap_reg_sidang',$data);
		// $this->load->view('foot',$foot);
	}
	// =====================================================
	public function loopIdTarif($id='') {
		$select = '*';
		$table = 'tbl_tarif';
		$where = "parent_id = $id";
		$tarif = $this->MasterData->getWhereData($select,$table,$where)->result();
		$zz = array();
		foreach ($tarif as $trf) {
			if ($trf->child_id == 0) {
				$zz[] = $trf->id_tarif;
			}
		}
		return $zz;
	}
	// =====================================================
	public function dataTera($status='x'){
		// $id_user = $this->id_user;
		$select = array(
			'dft.*',
			"(SELECT jns.nama_jenis_usaha FROM tbl_jenis_usaha jns WHERE jns.id_jenis_usaha IN (SELECT ush.id_jenis_usaha FROM tbl_usaha ush WHERE ush.id_usaha = dft.id_usaha)) jenis_usaha",
			"(SELECT usr.nama_user FROM tbl_user usr WHERE usr.id_user = (SELECT ush.id_user FROM tbl_usaha ush WHERE ush.id_usaha = dft.id_usaha)) nama_user",
			"(SELECT tmp.tempat_tera FROM tbl_tempat_tera tmp WHERE tmp.id_tempat_tera = dft.id_tempat_tera) tempat_tera"
		);
		$table = "tbl_pendaftaran dft";
		$where = "user_daftar = 'petugas' AND id_tempat_tera != (SELECT tmp.id_tempat_tera FROM tbl_tempat_tera tmp WHERE tmp.tempat_tera = 'Pasar')";
		if ($status != 'x') {
			// if ($status == 'belumkirim') {
			// 	$where .= " AND status = 'belum kirim'";
			// }
			if ($status == 'pending') {
				$where .= " AND status = 'pending'";
			}
			if ($status == 'diterima') {
				$where .= " AND status = 'diterima'";
			}
			if ($status == 'proses') {
				$where .= " AND status = 'proses'";
			}
			if ($status == 'selesai') {
				$where .= " AND status = 'selesai'";
			}
			if ($status == 'ditolak') {
				$where .= " AND status = 'ditolak'";
			}
		} else {
			$status = 'diterima';
			$where .= " AND status = 'diterima'";
		}
		$by = 'dft.id_daftar';
		$order = 'DESC';
		$dataTera = $this->MasterData->getWhereDataOrder($select,$table,$where,$by,$order)->result();
		// =========================================================================
		$select = array(
			'pt.*',
			"(SELECT usr.nama_user FROM tbl_user usr WHERE usr.id_user = pt.id_user) nama_user",
			"(SELECT jbt.nama_jabatan FROM tbl_jabatan jbt WHERE jbt.id_jabatan = pt.id_jabatan) jabatan",
		);
		$table = 'tbl_petugas pt';
		$where = "id_petugas > 0";
		$by = 'id_jabatan';
		$order = 'ASC';
		$dataPetugas = $this->MasterData->getWhereDataOrder($select,$table,$where,$by,$order)->result();
		// ============================================================================
		$select = array(
			'pt.*',
			"(SELECT usr.nama_user FROM tbl_user usr WHERE usr.id_user = pt.id_user) nama_user"
		);
		$where = "id_jabatan = (SELECT jb.id_jabatan FROM tbl_jabatan jb WHERE  jb.nama_jabatan = 'Kepala Dinas')";
		$table = 'tbl_petugas pt';
		$kepalaDinas = $this->MasterData->getWhereData($select,$table,$where)->row();
		// ==========================================================

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
			'dataTera' => $dataTera,
			'dataPetugas' => $dataPetugas,
			'kepalaDinas' => $kepalaDinas,
			'selectStatus' => $status
		);
		$this->load->view('Admin/head',$head);
		$this->load->view('Admin/navigation',$nav);
		$this->load->view('Admin/tera',$data);
		$this->load->view('foot',$foot);
	}
	public function pendaftaranTera($id='1'){
		$id_user = $this->id_user;
		// $select = 'nomor';
		// $table = 'tbl_nomor';
		// $where = "keterangan = 'Agenda'";
		// $no_order = $this->MasterData->getWhereData($select,$table,$where)->row()->nomor;
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
		$this->head[] = "assets/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css";
		$this->head[] = "assets/assets/plugins/bootstrap-daterangepicker/daterangepicker.css";

		$this->foot[] = "assets/assets/plugins/select2/dist/js/select2.full.min.js";
		$this->foot[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/sweetalert.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/jquery.sweet-alert.custom.js";
		$this->foot[] = "assets/assets/plugins/datatables/jquery.dataTables.min.js";
		$this->foot[] = "assets/assets/plugins/dropify/dist/js/dropify.min.js";
		// $this->foot[] = "assets/main/vendor/typeahead/typeahead.jquery.min.js";
		$this->foot[] = "assets/main/vendor/jquery-ui/jquery-ui.min.js";
		$this->foot[] = "assets/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js";
		$this->foot[] = "assets/assets/plugins/bootstrap-daterangepicker/daterangepicker.js";

		$script = array(
			"$('#myTable').DataTable();",
			"$('.select2').select2();",
			"$('.datepicker').datepicker({
		        autoclose: true,
		        format: 'dd-mm-yyyy'
		    });",
			// "$('.dropify').dropify({
			// 	 messages: {
	  //               default: '<center>Upload foto/gambar disini.</center>',
	  //               error: '<center>Maksimal ukuran file 500 KB.</center>',
	  //           }
			// });"
			"$('.autocomplete').autocomplete({
                source: '".base_url().'Admin/getDataUser'."',
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
			// 'no_order' => $no_order,
			'id_user' => $id_user
		);
		$this->load->view('Admin/head',$head);
		$this->load->view('Admin/navigation',$nav);
		$this->load->view('Admin/pendaftaran_tera',$data);
		$this->load->view('foot',$foot);
	}
	public function pengajuanTera($value='') {
		$post = $this->input->POST();
		if ($post) {
			// $post = striptag($data_post);
			$select = 'grup';
			$where = "id_tempat_tera = $post[tempat]";
			$tempat_tera = $this->MasterData->getWhereData($select,'tbl_tempat_tera',$where)->row()->grup;
			$data = array(
				'id_usaha' => $post['id_usaha'],
				'no_order' => $post['no_order'],
				'layanan' => $post['layanan'],
				'tempat' => $tempat_tera,
				'id_tempat_tera' => $post['tempat'],
				'tgl_daftar' => date('Y-m-d', strtotime($post['tgl_daftar'])),
				'tgl_kirim' => date('Y-m-d H:i:s'),
				'status' => 'diterima',
				'user_daftar' => 'petugas',
				'tgl_update_status' => date('Y-m-d H:i:s')
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
					// $where = "keterangan = 'Agenda'";
					// $data = array(
					// 	'nomor' => $post['no_order'] + 1
					// );
					// $update_nomor = $this->MasterData->editData($where,$data,'tbl_nomor');
					$sess['alert'] = alert_success('Data pengajuan tera berhasil disimpan.');
					$this->session->set_flashdata($sess);
					redirect(base_url().'Admin/dataTera');
				} else {
					$sess['alert'] = alert_failed('Data pengajuan tera gagal disimpan.');
					$this->session->set_flashdata($sess);
					redirect(base_url().'Admin/pendaftaranTera');
				}
			} else {
				$sess['alert'] = alert_failed('Data pengajuan tera gagal disimpan.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Admin/pendaftaranTera');
			}
		} else {
			$sess['alert'] = alert_failed('Data pengajuan tera gagal disimpan.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Admin/pendaftaranTera');
		}
		// echo "<pre>".print_r($post)."</pre>";
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
			"(SELECT uttp.kapasitas FROM tbl_uttp uttp WHERE uttp.id_uttp = list.id_uttp) kapasitas",
			"(SELECT uttp.merk FROM tbl_uttp uttp WHERE uttp.id_uttp = list.id_uttp) merk",
			"(SELECT uttp.nomor_seri FROM tbl_uttp uttp WHERE uttp.id_uttp = list.id_uttp) nomor_seri",
			"(SELECT uttp.model_tipe FROM tbl_uttp uttp WHERE uttp.id_uttp = list.id_uttp) model_tipe",
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
		$this->head[] = "assets/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css";
		$this->head[] = "assets/assets/plugins/bootstrap-daterangepicker/daterangepicker.css";


		$this->foot[] = "assets/assets/plugins/select2/dist/js/select2.full.min.js";
		$this->foot[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/sweetalert.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/jquery.sweet-alert.custom.js";
		$this->foot[] = "assets/assets/plugins/datatables/jquery.dataTables.min.js";
		$this->foot[] = "assets/assets/plugins/dropify/dist/js/dropify.min.js";
		$this->foot[] = "assets/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js";
		$this->foot[] = "assets/assets/plugins/bootstrap-daterangepicker/daterangepicker.js";

		$script = array(
			"$('#myTable').DataTable();",
			"$('.select2').select2();",
			"$('.datepicker').datepicker({
		        autoclose: true,
		        format: 'dd-mm-yyyy'
		    });",
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
		$this->load->view('Admin/head',$head);
		$this->load->view('Admin/navigation',$nav);
		$this->load->view('Admin/edit_pendaftaran_tera',$data);
		$this->load->view('foot',$foot);
	}
	public function updatePengajuanTera($value='') {
		$post = $this->input->POST();
		if ($post) {
			// $post = striptag($data_post);
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
				'tgl_daftar' => date('Y-m-d', strtotime($post['tgl_daftar'])),
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
						redirect(base_url().'Admin/dataTera');
					} else {
						$sess['alert'] = alert_failed('Data pengajuan tera gagal diupdate.');
						$this->session->set_flashdata($sess);
						redirect(base_url().'Admin/dataTera');
					}
				} else {
					$sess['alert'] = alert_failed('Data pengajuan tera gagal diupdate.');
					$this->session->set_flashdata($sess);
					redirect(base_url().'Admin/dataTera');
				}
			} else {
				$sess['alert'] = alert_failed('Data pengajuan tera gagal diupdate.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Admin/dataTera');
			}
		} else {
			$sess['alert'] = alert_failed('Data pengajuan tera gagal diupdate.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Admin/dataTera');
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
			// redirect(base_url().'Admin/dataTera');
		} else {
			echo 'Gagal';
			$sess['alert'] = alert_failed('Data pengajuan tera gagal dihapus.');
			$this->session->set_flashdata($sess);
		}
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

		        // $cekID = $this->sms->query("SHOW TABLE STATUS LIKE 'outbox'")->row();
		        // $newID = $cekID->Auto_increment;
		        // $data = array(
		        //     'DestinationNumber' => $noTelp,
		        //     'TextDecoded' => $pesan,
		        //     'ID' => $newID,
		        //     'MultiPart' => 'false',
		        //     'CreatorID' => 'SiMetro'
		        // );
		        // $table = 'outbox';
				// $input_msg = $this->MasterData->sendMsg($data,$table);

				kirim_wa($noTelp, $pesan);
				
				redirect(base_url().'Admin/dataTera');
			}
		}
	}
	public function inputTglInspeksiTera($value='') {
		$input = $this->input->POST();
		// $input = striptag($data_input);
		$data = array(
			'tgl_inspeksi' => date('Y-m-d', strtotime($input['tgl_inspeksi'])),
			'status' => 'proses',
			'notif' => 0,
			'tgl_update_status' => date('Y-m-d H:i:s')
		);
		$where = "id_daftar = $input[id_daftar]";
		$update = $this->MasterData->editData($where,$data,'tbl_pendaftaran');
		if ($update) {
			$dataSpt = array();
			foreach ($input['id_petugas'] as $key) {
				$arr = array(
					'id_petugas' => $key,
					'id_daftar' => $input['id_daftar']
				);
				$dataSpt[] = $arr;
			}
			$insert_spt = $this->db->insert_batch('tbl_spt', $dataSpt);
			$where = "id_user = (SELECT ush.id_user FROM tbl_usaha ush WHERE ush.id_usaha = (SELECT dft.id_usaha FROM tbl_pendaftaran dft WHERE dft.id_daftar = $input[id_daftar]))";
			$noTelp = $this->MasterData->getWhereData('*','tbl_user',$where)->row()->no_hp;
			if ($noTelp == null) {
				$noTelp = '0';
			}
			$where = "id_daftar = $input[id_daftar]";
			$no_order = $this->MasterData->getWhereData('*','tbl_pendaftaran',$where)->row()->no_order;
			$pesan = "Status pengajuan tera/tera ulang Anda dengan nomor order ".$no_order." saat ini sudah diPROSES oleh Admin";
	        // $cekID = $this->sms->query("SHOW TABLE STATUS LIKE 'outbox'")->row();
	        // $newID = $cekID->Auto_increment;
	        // $data = array(
	        //     'DestinationNumber' => $noTelp,
	        //     'TextDecoded' => $pesan,
	        //     'ID' => $newID,
	        //     'MultiPart' => 'false',
	        //     'CreatorID' => 'SiMetro'
	        // );
	        // $table = 'outbox';
			// $input_msg = $this->MasterData->sendMsg($data,$table);
			
			kirim_wa($noTelp, $pesan);

			$sess['alert'] = alert_success('Tanggal inspeksi berhasil disimpan. Mohon pengajuan segera diproses!');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Admin/dataTera');
		} else {
			$sess['alert'] = alert_failed('Tanggal inspeksi gagal disimpan.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Admin/dataTera');
		}
	}
	// =====================================================
	public function dataListSidang($value='') {
		$select = array(
			'st.*',
			"(SELECT psr.nama_pasar FROM tbl_pasar psr WHERE psr.id_pasar = st.id_pasar) nama_pasar"
		);
		$table = 'tbl_sidang_tera st';
		$by = 'id_sidang';
		$order = 'DESC';
		$dataListSidang = $this->MasterData->getSelectDataOrder($select,$table,$by,$order)->result();
		// =========================================================
		// $select = array(
		// 	'pt.*',
		// 	"(SELECT usr.nama_user FROM tbl_user usr WHERE usr.id_user = pt.id_user) nama_user",
		// 	"(SELECT jbt.nama_jabatan FROM tbl_jabatan jbt WHERE jbt.id_jabatan = pt.id_jabatan) jabatan",
		// );
		// $table = 'tbl_petugas pt';
		// $where = "id_petugas > 0";
		// $by = 'id_jabatan';
		// $order = 'ASC';
		// $dataPetugas = $this->MasterData->getWhereDataOrder($select,$table,$where,$by,$order)->result();
		// =========================================================
		$dataPasar = $this->MasterData->getData('tbl_pasar')->result();
		// =========================================================
		$select = array(
			'pt.*',
			"(SELECT usr.nama_user FROM tbl_user usr WHERE usr.id_user = pt.id_user) nama_user"
		);
		$where = "id_jabatan = (SELECT jb.id_jabatan FROM tbl_jabatan jb WHERE  jb.nama_jabatan = 'Kepala Dinas')";
		$table = 'tbl_petugas pt';
		$kepalaDinas = $this->MasterData->getWhereData($select,$table,$where)->row();
		// ==========================================================
		$this->head[] = "assets/assets/plugins/select2/dist/css/select2.css";
		$this->head[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.css";
		$this->head[] = "assets/assets/plugins/sweetalert/sweetalert.css";
		$this->head[] = "assets/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css";
		// $this->head[] = "assets/assets/plugins/dropify/dist/css/dropify.min.css";
		$this->foot[] = "assets/assets/plugins/select2/dist/js/select2.full.min.js";
		$this->foot[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/sweetalert.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/jquery.sweet-alert.custom.js";
		$this->foot[] = "assets/assets/plugins/datatables/jquery.dataTables.min.js";
		$this->foot[] = "assets/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js";
		// $this->foot[] = "assets/assets/plugins/dropify/dist/js/dropify.min.js";
		$script = array(
			"$('#myTable').DataTable();",
			"$('.select2').select2();",
			"$('.mydatepicker').datepicker({ format: 'dd-mm-yyyy', autoclose:true });",
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
		$nav['menu'] = 'daftar_sidang';
		$data = array(
			'list_sidang' => $dataListSidang,
			'dataPasar' => $dataPasar,
			// 'dataPetugas' => $dataPetugas,
			'kepalaDinas' => $kepalaDinas,
		);
		$this->load->view('Admin/head',$head);
		$this->load->view('Admin/navigation',$nav);
		$this->load->view('Admin/list_sidang',$data);
		$this->load->view('foot',$foot);
	}
	public function editListSidang($value='') {
		$id_sidang = $this->input->POST('id_sidang');
		if ($id_sidang) {
			$select = array(
				'pt.*',
				"(SELECT usr.nama_user FROM tbl_user usr WHERE usr.id_user = pt.id_user) nama_user",
				"(SELECT jbt.nama_jabatan FROM tbl_jabatan jbt WHERE jbt.id_jabatan = pt.id_jabatan) jabatan",
			);
			$table = 'tbl_petugas pt';
			$where = "id_petugas > 0";
			$by = 'id_jabatan';
			$order = 'ASC';
			$dataPetugas = $this->MasterData->getWhereDataOrder($select,$table,$where,$by,$order)->result();
			// ============================================================================================
			$select = array(
				'spt.*',
				"(SELECT usr.nama_user FROM tbl_user usr WHERE usr.id_user = (SELECT pt.id_user FROM tbl_petugas pt WHERE pt.id_petugas = spt.id_petugas)) nama_user",
				"(SELECT jb.nama_jabatan FROM tbl_jabatan jb WHERE jb.id_jabatan = (SELECT pt.id_jabatan FROM tbl_petugas pt WHERE pt.id_petugas = spt.id_petugas)) jabatan",
				"(SELECT pt.nip FROM tbl_petugas pt WHERE pt.id_petugas = spt.id_petugas) nip",
			);
			$table = 'tbl_spt_sidang spt';
			$where = "spt.id_sidang = $id_sidang";
			$petugas = $this->MasterData->getWhereData($select,$table,$where)->result();
			if ($petugas) {
				$result = array(
					'response' 		=> true,
					'petugas' 		=> $petugas,
					'dataPetugas' 	=> $dataPetugas
				);
			} else {
				$result = array(
					'response' => false
				);
			}
		}  else {
			$result = array(
				'response' => false
			);
		}
		echo json_encode($result);
	}
	public function tambahListSidang($value='') {
		$select = array(
			'st.*',
			"(SELECT psr.nama_pasar FROM tbl_pasar psr WHERE psr.id_pasar = st.id_pasar) nama_pasar"
		);
		$table = 'tbl_sidang_tera st';
		$by = 'id_sidang';
		$order = 'DESC';
		$dataListSidang = $this->MasterData->getSelectDataOrder($select,$table,$by,$order)->result();
		// ===========================================================
		$select = array(
			'pt.*',
			"(SELECT usr.nama_user FROM tbl_user usr WHERE usr.id_user = pt.id_user) nama_user",
			"(SELECT jbt.nama_jabatan FROM tbl_jabatan jbt WHERE jbt.id_jabatan = pt.id_jabatan) jabatan",
		);
		$table = 'tbl_petugas pt';
		$where = "id_petugas > 0";
		$by = 'id_jabatan';
		$order = 'ASC';
		$dataPetugas = $this->MasterData->getWhereDataOrder($select,$table,$where,$by,$order)->result();
		// =========================================================
		$dataPasar = $this->MasterData->getData('tbl_pasar')->result();
		// =========================================================
		$this->head[] = "assets/assets/plugins/select2/dist/css/select2.css";
		$this->head[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.css";
		$this->head[] = "assets/assets/plugins/sweetalert/sweetalert.css";
		$this->head[] = "assets/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css";
		// $this->head[] = "assets/assets/plugins/dropify/dist/css/dropify.min.css";
		$this->foot[] = "assets/assets/plugins/select2/dist/js/select2.full.min.js";
		$this->foot[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/sweetalert.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/jquery.sweet-alert.custom.js";
		$this->foot[] = "assets/assets/plugins/datatables/jquery.dataTables.min.js";
		$this->foot[] = "assets/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js";
		// $this->foot[] = "assets/assets/plugins/dropify/dist/js/dropify.min.js";
		$script = array(
			"$('#myTable').DataTable();",
			"$('.select2').select2();",
			"$('.mydatepicker').datepicker({ format: 'dd-mm-yyyy', autoclose:true });",
			"$(document).ready( function () {
                $('#tambahDataSidang #tgl_sidang').datepicker('setDate', '".date('d-m-Y')."'); 
            });"
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
		$nav['menu'] = 'sidang_tera';
		$data = array(
			'list_sidang' => $dataListSidang,
			'dataPasar' => $dataPasar,
			'dataPetugas' => $dataPetugas,
		);
		$this->load->view('Admin/head',$head);
		$this->load->view('Admin/navigation',$nav);
		$this->load->view('Admin/tambah_list_sidang',$data);
		$this->load->view('foot',$foot);
	}

	public function simpanDataSidang($value='') {
		$post = $this->input->POST();
		if ($post) {
			// $post = striptag($data_post);
			$data = array(
				'id_pasar' => $post['id_pasar'],
				'tgl_sidang' => date('Y-m-d', strtotime($post['tgl_sidang']))
			);
			$insert = $this->MasterData->inputData($data,'tbl_sidang_tera');
			if ($insert) {
				$id_sidang = $this->db->insert_id();
				$dataSpt = array();
				foreach ($post['id_petugas'] as $key) {
					$arr = array(
						'id_petugas' => $key,
						'id_sidang' => $id_sidang
					);
					$dataSpt[] = $arr;
				}
				$insert_spt = $this->db->insert_batch('tbl_spt_sidang', $dataSpt);
				$sess['alert'] = alert_success('Data sidang tera berhasil disimpan.');
				$this->session->set_flashdata($sess);
				$result = array(
					'response' => true
				);
				// redirect(base_url().'Admin/dataListSidang');
				// redirect(base_url().'Admin/pendaftaranSidangTera/'.encode($id_sidang));
			} else {
				$sess['alert'] = alert_failed('Data sidang tera gagal disimpan.');
				$this->session->set_flashdata($sess);
				$result = array(
					'response' => false
				);
				// redirect(base_url().'Admin/dataListSidang');
				// redirect(base_url().'Admin/pendaftaranSidangTera/'.encode($id_sidang));
			}
		} else {
			$result = array(
				'response' => false
			);
		}
		echo json_encode($result);
	}
	public function updateDataSidang($value='') {
		$input = $this->input->POST();
		if ($input) {
			// $input = striptag($data_input);
			$id_sidang = $input['id_sidang'];
			$where = "id_sidang = $id_sidang";
			$deleteSpt = $this->MasterData->deleteData($where,'tbl_spt_sidang');
			if ($deleteSpt) {
				$dataSpt = array();
				foreach ($input['id_petugas'] as $key) {
					$arr = array(
						'id_petugas' => $key,
						'id_sidang' => $id_sidang
					);
					$dataSpt[] = $arr;
				}
				$insert_spt = $this->db->insert_batch('tbl_spt_sidang', $dataSpt);
				// if ($insert_spt) {
					$data = array(
						'id_pasar' => $input['id_pasar'],
						'tgl_sidang' => date('Y-m-d', strtotime($input['tgl_sidang']))
					);
					$where = "id_sidang = $id_sidang";
					$update = $this->MasterData->editData($where,$data,'tbl_sidang_tera');
					if ($update) {
						$sess['alert'] = alert_success('Data sidang tera berhasil diupdate.');
						$this->session->set_flashdata($sess);
						// redirect(base_url().'Admin/dataListSidang');
						$result = array(
							'response' => true
						);
					} else {
						$sess['alert'] = alert_failed('Data sidang tera gagal diupdate.');
						$this->session->set_flashdata($sess);
						$result = array(
							'response' => false
						);
					}
				// } else {
				// 	$sess['alert'] = alert_failed('Data sidang tera gagal diupdate.');
				// 	$this->session->set_flashdata($sess);
				// 	$result = array(
				// 		'response' => false
				// 	);
				// }
			} else {
				$sess['alert'] = alert_failed('Data sidang tera gagal diupdate.');
				$this->session->set_flashdata($sess);
				$result = array(
					'response' => false
				);
			}
		} else {
			$sess['alert'] = alert_failed('Data sidang tera gagal diupdate.');
			$this->session->set_flashdata($sess);
			$result = array(
				'response' => false
			);
		}
		echo json_encode($result);
	}

	public function deleteDataSidang($id='') {
		$id = $this->input->POST('id');
		if ($id) {
			$where = "id_sidang = $id";
			$delete = $this->MasterData->deleteData($where,'tbl_sidang_tera');
			if ($delete) {
				echo "Success";
				$sess['alert'] = alert_success('Data sidang tera berhasil dihapus.');
				$this->session->set_flashdata($sess);
				// redirect(base_url().'Admin/jenisAlat');
			} else {
				echo 'Failed';
				$sess['alert'] = alert_failed('Data sidang tera gagal dihapus.');
				$this->session->set_flashdata($sess);
				// redirect(base_url().'Admin/jenisAlat');
			}
		} else {
			echo 'Failed';
			$sess['alert'] = alert_failed('Data sidang tera gagal dihapus.');
			$this->session->set_flashdata($sess);
			// redirect(base_url().'Admin/jenisAlat');
		}
	}

	public function dataSidangTera($status='x', $id=''){
		// $id_user = $this->id_user;
		if ($id != '') {
			$id_sidang = decode($id);
		} else {
			$id_sidang = 1;
		}
		$select = array(
			'list.*',
			// "(SELECT jns.nama_jenis_usaha FROM tbl_jenis_usaha jns WHERE jns.id_jenis_usaha IN (SELECT ush.id_jenis_usaha FROM tbl_usaha ush WHERE ush.id_usaha = list.id_usaha)) jenis_usaha",
			"(SELECT usr.nama_user FROM tbl_user_pasar usr WHERE usr.id_user_pasar = list.id_user_pasar) nama_user",
			"(SELECT usr.alamat_user FROM tbl_user_pasar usr WHERE usr.id_user_pasar = list.id_user_pasar) alamat_user",
			"(SELECT jns.nama_jenis_alat FROM tbl_jenis_alat_ukur jns WHERE jns.id_jenis_alat = list.id_jenis_alat) jenis_alat",
			// "(SELECT psr.nama_pasar FROM tbl_pasar psr WHERE psr.id_pasar = (SELECT grup.id_pasar FROM tbl_grup_pasar grup WHERE grup.id_usaha = list.id_usaha)) tempat_tera"
		);
		$table = "tbl_list_sidang_new list";
		$where = "list.id_sidang = $id_sidang";

		$by = 'list.id_list_sidang';
		$order = 'DESC';
		$dataSidangTera = $this->MasterData->getWhereDataOrder($select,$table,$where,$by,$order)->result();

		$select = 'id_pasar';
		$table = 'tbl_sidang_tera';
		$where = "id_sidang = $id_sidang";
		$id_pasar = $this->MasterData->getWhereData($select,$table,$where)->row()->id_pasar;

		$select = 'nama_pasar';
		$table = 'tbl_pasar';
		$where = "id_pasar = $id_pasar";
		$nama_pasar = $this->MasterData->getWhereData($select,$table,$where)->row()->nama_pasar;

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
		$nav['menu'] = 'daftar_sidang';
		$data = array(
			'dataSidangTera' => $dataSidangTera,
			// 'selectStatus' => $status,
			'id_sidang' =>  $id_sidang,
			'id_pasar' =>  $id_pasar,
			'nama_pasar' =>  $nama_pasar,
		);
		$this->load->view('Admin/head',$head);
		$this->load->view('Admin/navigation',$nav);
		$this->load->view('Admin/sidang_tera_new',$data);
		$this->load->view('foot',$foot);
	}

	public function pendaftaranSidangTera($id=''){
		// $id_user = $this->id_user;
		if ($id != '') {
			$id_sidang = decode($id);
		} else {
			$id_sidang = 1;
		}

		// $select = 'nomor';
		// $table = 'tbl_nomor';
		// $where = "keterangan = 'pasar'";
		// $no_order = $this->MasterData->getWhereData($select,$table,$where)->row()->nomor;

		$tempat_tera = $this->MasterData->getData('tbl_tempat_tera')->result();

		$select = 'tgl_sidang';
		$table = 'tbl_sidang_tera';
		$where = "id_sidang = $id_sidang";
		$tgl_sidang = $this->MasterData->getWhereData($select,$table,$where)->row()->tgl_sidang;

		$select = 'id_pasar';
		$table = 'tbl_sidang_tera';
		$where = "id_sidang = $id_sidang";
		$id_pasar = $this->MasterData->getWhereData($select,$table,$where)->row()->id_pasar;

		$select = 'nama_pasar';
		$table = 'tbl_pasar';
		$where = "id_pasar = $id_pasar";
		$nama_pasar = $this->MasterData->getWhereData($select,$table,$where)->row()->nama_pasar;

		$select = 'kode_pasar';
		$table = 'tbl_pasar';
		$where = "id_pasar = $id_pasar";
		$kode_pasar = $this->MasterData->getWhereData($select,$table,$where)->row()->kode_pasar;

		$select1 = array('no_order'); // Select kode permintaan terakhir
		$by 	= "no_order";
		$order 	= "DESC";
		$limit 	= "1";
		$table1 = 'tbl_list_sidang_new list';
		// $where1 = "substr(no_order,1,2) = (SELECT psr.kode_pasar FROM tbl_pasar psr WHERE psr.id_pasar = (SELECT sd.id_pasar FROM tbl_sidang_tera sd WHERE sd.id_sidang = list.id_sidang))";
		$where1 = "substr(no_order,1,3) = $kode_pasar";
		$detail = $this->MasterData->getWhereDataLimitOrder($select1,$table1,$where1,$limit,$by,$order);
		$no_order = $detail->row();
		if ($detail->num_rows() > 0) { // Check data
			// $kode_pasar = substr($no_order->no_order, 0, 2);
			$kode = substr($no_order->no_order, 3); // Mengambil string beberapa digit
			$code = (int) $kode; // Mengubah String jadi Integer
			$code++;
			$kodeOtomatis = $kode_pasar.str_pad($code, 6, "0", STR_PAD_LEFT); // Kerangka Kode Otomatis = kode_pasar + 6 digit
		} else {
			$kodeOtomatis = $kode_pasar.'000001';
		}


		$where = "nama_jenis_alat like '%timbangan meja%' OR nama_jenis_alat like '%timbangan sentisimal%' OR nama_jenis_alat like '%dacin logam%' OR nama_jenis_alat like '%timbangan pegas%' OR nama_jenis_alat like '%timbangan digital%' OR nama_jenis_alat like '%neraca%' ";
		$dataJenisAlat = $this->MasterData->getDataWhere('tbl_jenis_alat_ukur',$where)->result();

		// ========================================================

		$select = array(
			'trf.*'
		);
		$table = 'tbl_tarif trf';
		$where = "parent_id = 22";
		$by = 'trf.id_tarif';
		$order = 'ASC';
		$dataAnakTimbang = $this->MasterData->getDataWhere($table,$where)->result();

		$dataHead = array();
		$dataArr = array();
		foreach ($dataAnakTimbang as $anakTimbang) {
			$id = $anakTimbang->id_tarif;
			$where = "id_tarif = $id";
			$dataTrf = $this->MasterData->getDataWhere($table,$where)->row();
			$child_id = $dataTrf->child_id;
			$jenis_tarif = $dataTrf->jenis_tarif;
			$dataHead[] = $jenis_tarif;

			if ($child_id == 0) {
				$where = "id_tarif = $id";
			} else {
				$where = "parent_id = $id";
			}
			$kelompokTarif = $this->MasterData->getWhereDataOrder($select,$table,$where,$by,$order)->result();

			foreach ($kelompokTarif as $trf) {

				$dataArr[] = array(
					'head' => $jenis_tarif,
					'id_tarif' => $trf->id_tarif,
					'jenis_tarif' => $trf->jenis_tarif,
					'parent_id' => $trf->parent_id,
					'child_id' => $trf->child_id,
					'satuan' => $trf->satuan,
					'tera_kantor' => $trf->tera_kantor,
					'tera_tempat_pakai' => $trf->tera_tempat_pakai,
					'tera_ulang_kantor' => $trf->tera_ulang_kantor,
					'tera_ulang_tempat_pakai' => $trf->tera_ulang_tempat_pakai
				);
			}
		}

		$ank_tbg = array(
			'data' => $dataArr,
			'head' => $dataHead
		);

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
		$this->head[] = "assets/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css";
		$this->head[] = "assets/assets/plugins/bootstrap-daterangepicker/daterangepicker.css";
		// $this->head[] = "assets/assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css";

		$this->foot[] = "assets/assets/plugins/select2/dist/js/select2.full.min.js";
		$this->foot[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/sweetalert.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/jquery.sweet-alert.custom.js";
		$this->foot[] = "assets/assets/plugins/datatables/jquery.dataTables.min.js";
		$this->foot[] = "assets/assets/plugins/dropify/dist/js/dropify.min.js";
		
		// $this->foot[] = "assets/assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js";

		// $this->foot[] = "assets/main/vendor/typeahead/typeahead.jquery.min.js";
		$this->foot[] = "assets/main/vendor/jquery-ui/jquery-ui.min.js";
		$this->foot[] = "assets/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js";
		$this->foot[] = "assets/assets/plugins/bootstrap-daterangepicker/daterangepicker.js";

		$script = array(
			"$('#myTable').DataTable();",
			"$('.select2').select2();",
			"$('.datepicker').datepicker({
		        autoclose: true,
		        format: 'dd-mm-yyyy'
		    });",
		    // "$('.datepicker').bootstrapMaterialDatePicker({ 
		    // 	weekStart: 0, 
		    // 	time: false 
		    // });",
			// "$('.dropify').dropify({
			// 	 messages: {
	  //               default: '<center>Upload foto/gambar disini.</center>',
	  //               error: '<center>Maksimal ukuran file 500 KB.</center>',
	  //           }
			// });"
			"$('.autocomplete').autocomplete({
                source: '".base_url().'Admin/getDataUserGrupPasar/'.$id_pasar."',
      			response: function (event, ui) {
		            var len = ui.content.length;
		            if (len == 0) {
		            	$('#modal-cari #counter_found').html('Data user tidak ditemukan');
		            	clearDataUsaha();
		            	$('#pengajuanSidangTera #id_user_pasar').val('');
		            } else {
		            	$('#modal-cari #counter_found').html('');
		            	clearDataUsaha();
		            }
		        },
                select: function (event, ui) {
                    getDataUsaha(ui.item.id);
                    $('#pengajuanSidangTera #id_user_pasar').val(ui.item.id);
                    $('#modal-cari').modal('hide');
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
		$nav['menu'] = 'sidang_tera';
		$data = array(
			'dataJenisAlat' => $dataJenisAlat,
			'tempat_tera' => $tempat_tera,
			'no_order' => $kodeOtomatis,
			// 'id_user' => $id_user,
			'tgl_sidang' => $tgl_sidang,
			'id_sidang' => $id_sidang,
			'id_pasar' => $id_pasar,
			'nama_pasar' => $nama_pasar,
			'ank_tbg' => $ank_tbg
		);
		$this->load->view('Admin/head',$head);
		$this->load->view('Admin/navigation',$nav);
		$this->load->view('Admin/pendaftaran_sidang_tera_new',$data);
		$this->load->view('foot',$foot);
	}

	public function pengajuanSidangTera($value='') {
		$data_post = $this->input->POST();
		if ($data_post) {
			$post = striptag($data_post);

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
				'tgl_inspeksi' => date('Y-m-d'),
				'status' => 'proses',
				'user_daftar' => 'petugas',
				// 'notif' => 0
			);
			$input_pendaftaran = $this->MasterData->inputData($data,'tbl_pendaftaran');
			if ($input_pendaftaran) {
				$id_daftar = $this->db->insert_id();
				$data_sidang = array(
					'id_daftar' => $id_daftar,
					'id_sidang' => $post['id_sidang']
				);
				$input_sidang = $this->MasterData->inputData($data_sidang,'tbl_list_sidang');
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

					// $where = "keterangan = 'Agenda'";
					// $data = array(
					// 	'nomor' => $post['no_order'] + 1
					// );
					// $update_nomor = $this->MasterData->editData($where,$data,'tbl_nomor');

					$sess['alert'] = alert_success('Data pengajuan tera berhasil disimpan.');
					$this->session->set_flashdata($sess);
					redirect(base_url().'Admin/pendaftaranSidangTera/'.encode($post['id_sidang']));
				} else {
					$sess['alert'] = alert_failed('Data pengajuan tera gagal disimpan.');
					$this->session->set_flashdata($sess);
					redirect(base_url().'Admin/pendaftaranSidangTera/'.encode($post['id_sidang']));
				}
			} else {
				$sess['alert'] = alert_failed('Data pengajuan tera gagal disimpan.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Admin/pendaftaranSidangTera/'.encode($post['id_sidang']));
			}
		} else {
			$sess['alert'] = alert_failed('Data pengajuan tera gagal disimpan.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Admin/pendaftaranSidangTera/'.encode($post['id_sidang']));
		}
		// echo "<pre>".print_r($post)."</pre>";
	}

	public function pengajuanSidangTeraNew($value='') {
		$post = $this->input->POST();
		if ($post) {
			// $post = striptag($data_post);	

			// $data = array();
			// foreach ($post as $key => $val) {
			// 	if ($key != 'nama_user' && $key != 'alamat_user' && $key != 'id_pasar') {
			// 		if (is_array($val)) {
			// 			$data[$key] = implode(';', $val);
			// 		} else {
			// 			$data[$key] = $val;
			// 		}
			// 	}
			// }

			$data = array(
				'id_sidang' 			=> $post['id_sidang'],
				// 'id_jenis_alat' 		=> $post['id_jenis_alat'],
				'no_order'				=> $post['no_order'],
				'layanan'				=> $post['layanan'],
				// 'kapasitas'				=> $post['kapasitas'],
				// 'jml_timbang'			=> $post['jml_timbang'],
				// 'jml_anak_timbang'		=> $post['jml_anak_timbang'],
				'berlaku'				=> date('Y-m-d', strtotime($post['tgl_daftar'])),
				'tidak_berlaku'			=> date('Y-m-d', strtotime($post['tgl_daftar'].'+1 year')),
				'tgl_daftar'		 	=> date('Y-m-d', strtotime($post['tgl_daftar'])),
				'kondisi'				=> $post['kondisi'],
				'tindakan'				=> $post['tindakan']
			);

			// $data['tgl_daftar'] = date('Y-m-d');
			// $data['berlaku'] = date('Y-m-d');
			// $data['tidak_berlaku'] = date('Y-m-d', strtotime('+1 year'));

			if ($post['id_user_pasar'] == null || $post['id_user_pasar'] == '') {
				$dataUserPasar = array(
					'id_pasar' 		=> $post['id_pasar'],
					'nama_user' 	=> $post['nama_user'],
					'alamat_user'	=> $post['alamat_user']
				);
				$inputUser = $this->MasterData->inputData($dataUserPasar,'tbl_user_pasar');
				$data['id_user_pasar'] = $this->db->insert_id();
			} else {
				$data['id_user_pasar'] = $post['id_user_pasar'];
			}

			$input_pendaftaran = $this->MasterData->inputData($data,'tbl_list_sidang_new');

			$id_list_sidang = $this->db->insert_id();

			// ======================================================================

			$dataArrTimbang = array();
			for ($i=0; $i < count($post['id_jenis_alat']) ; $i++) { 
				$id_jenis_alat = $post['id_jenis_alat'][$i];
				$kapasitas = $post['kapasitas'][$i];
				$id_tarif_timbang = $post['id_tarif_timbang'][$i];
				$jml_timbang = $post['jml_timbang'][$i];
				// =====================================================
				$arr = array(
					'id_list_sidang' 	=> $id_list_sidang,
					'id_jenis_alat' 	=> $id_jenis_alat,
					'kapasitas'			=> $kapasitas,
					'id_tarif_timbang'	=> $id_tarif_timbang,
					'jml_timbang'		=> $jml_timbang
				);
				$dataArrTimbang[] = $arr;
			}
			$insert_list_timbang = $this->db->insert_batch('tbl_list_sidang_timbang', $dataArrTimbang); 

			// =============================================================

			if ($post['id_tarif_anak_timbang']) {
				if ($post['id_tarif_anak_timbang'][0] != '') {
					$dataArrAnakTimbang = array();
					for ($y=0; $y < count($post['id_tarif_anak_timbang']) ; $y++) { 
						$id_tarif_anak_timbang = $post['id_tarif_anak_timbang'][$y];
						$jml_anak_timbang = $post['jml_anak_timbang'][$y];
						// =====================================================
						$arr = array(
							'id_list_sidang' 		=> $id_list_sidang,
							'id_tarif_anak_timbang'	=> $id_tarif_anak_timbang,
							'jml_anak_timbang'		=> $jml_anak_timbang
						);
						$dataArrAnakTimbang[] = $arr;
					}
					$insert_list_anak_timbang = $this->db->insert_batch('tbl_list_sidang_anak_timbang', $dataArrAnakTimbang); 
				}
			}

			// =======================================================================

			if ($input_pendaftaran) {
					// $sess['alert'] = alert_success('Data pengajuan tera berhasil disimpan.');
					// $this->session->set_flashdata($sess);
					// redirect(base_url().'Admin/pendaftaranSidangTera/'.encode($post['id_sidang']));
					redirect(base_url().'Admin/printSidangKwitansi/'.encode($id_list_sidang).'/'.encode($post['id_sidang']).'/'.encode($post['id_pasar']));
			} else {
				$sess['alert'] = alert_failed('Data pengajuan tera gagal disimpan.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Admin/pendaftaranSidangTera/'.encode($post['id_sidang']));
			}
		} else {
			$sess['alert'] = alert_failed('Data pengajuan tera gagal disimpan.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Admin/pendaftaranSidangTera/'.encode($post['id_sidang']));
		}

		// echo "<pre>"; print_r($post); echo "</pre>";
	}

	public function bayarSidangTera($id='', $ids='') {
		if ($id) {
			$id_sidang = decode($ids);
			$id_list_sidang = decode($id);

			$table = "tbl_list_sidang_new";
			$where = "id_list_sidang = $id_list_sidang";
			$dataList = $this->MasterData->getDataWhere($table,$where)->row_array();
			// ================================================================
			$select = array(
				'tb.*',
				"(SELECT nama_jenis_alat FROM tbl_jenis_alat_ukur jns WHERE jns.id_jenis_alat = tb.id_jenis_alat) jenis_alat",
				"CASE 
			        WHEN 
			        	(SELECT list.layanan FROM tbl_list_sidang_new list WHERE list.id_list_sidang = tb.id_list_sidang) = 'tera ulang' THEN (SELECT tr.tera_ulang_tempat_pakai FROM tbl_tarif tr WHERE tr.id_tarif = tb.id_tarif_timbang) 
			        WHEN 
			        	(SELECT list.layanan FROM tbl_list_sidang_new list WHERE list.id_list_sidang = tb.id_list_sidang) = 'tera' THEN (SELECT tr.tera_tempat_pakai FROM tbl_tarif tr WHERE tr.id_tarif = tb.id_tarif_timbang)
			        ELSE NULL
		     	END AS tarif"
			);
			$table = 'tbl_list_sidang_timbang tb';
			$dataTimbang = $this->MasterData->getWhereData($select,$table,$where)->result_array();
			// ======================================================================
			$select = array(
				'tb.*',
				"(SELECT tr.jenis_tarif FROM tbl_tarif tr WHERE tr.id_tarif = (SELECT trf.parent_id FROM tbl_tarif trf WHERE  trf.id_tarif = tb.id_tarif_anak_timbang)) AS parent",
				"(SELECT tr.jenis_tarif FROM tbl_tarif tr WHERE tr.id_tarif = tb.id_tarif_anak_timbang) AS child",
				"CASE 
			        WHEN 
			        	(SELECT list.layanan FROM tbl_list_sidang_new list WHERE list.id_list_sidang = tb.id_list_sidang) = 'tera ulang' THEN (SELECT tr.tera_ulang_tempat_pakai FROM tbl_tarif tr WHERE tr.id_tarif = tb.id_tarif_anak_timbang) 
			        WHEN 
			        	(SELECT list.layanan FROM tbl_list_sidang_new list WHERE list.id_list_sidang = tb.id_list_sidang) = 'tera' THEN (SELECT tr.tera_tempat_pakai FROM tbl_tarif tr WHERE tr.id_tarif = tb.id_tarif_anak_timbang)
			        ELSE NULL
			     	END AS tarif"
			);
			$table = 'tbl_list_sidang_anak_timbang tb';
			$dataAnakTimbang = $this->MasterData->getWhereData($select,$table,$where)->result_array();
			// ============================================================

			// $this->head[] = "assets/assets/plugins/select2/dist/css/select2.css";
			// $this->head[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.css";
			// $this->head[] = "assets/assets/plugins/sweetalert/sweetalert.css";
			// $this->head[] = "assets/assets/plugins/dropify/dist/css/dropify.min.css";
			$this->head[] = "assets/main/vendor/jquery-ui/jquery-ui.min.css";

			// $this->foot[] = "assets/assets/plugins/select2/dist/js/select2.full.min.js";
			// $this->foot[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.js";
			// $this->foot[] = "assets/assets/plugins/sweetalert/sweetalert.min.js";
			// $this->foot[] = "assets/assets/plugins/sweetalert/jquery.sweet-alert.custom.js";
			// $this->foot[] = "assets/assets/plugins/datatables/jquery.dataTables.min.js";
			// $this->foot[] = "assets/assets/plugins/dropify/dist/js/dropify.min.js";
			$this->foot[] = "assets/main/vendor/jquery-ui/jquery-ui.min.js";

			// $head = array (
			// 	'head' => $this->head,
			// );

			$foot = array(
				'foot' =>  $this->foot,
			);

			$data = array(
				'list' 			=> $dataList,
				'timbang' 		=> $dataTimbang,
				'anak_timbang' 	=> $dataAnakTimbang,
				'id_sidang'		=> $id_sidang,
				'head'			=> $this->head,
				'foot'			=> $this->foot
			);

			// $this->load->view('Admin/head',$head);
			// $this->load->view('Admin/navigation',$nav);
			$this->load->view('Admin/bayar_sidang_tera', $data);
			// $this->load->view('foot',$foot);
		}
	}

	public function printSidangKwitansi($id='', $ids='', $idp='', $link='0') {
		if ($id) {
			$id_sidang = decode($ids);
			$id_list_sidang = decode($id);
			$id_pasar = decode($idp);

			$select = array(
				'lst.*',
				"(SELECT usr.nama_user FROM tbl_user_pasar usr WHERE usr.id_user_pasar = lst.id_user_pasar) nama_pedagang"
			);
			$table = "tbl_list_sidang_new lst";
			$where = "id_list_sidang = $id_list_sidang";
			$dataList = $this->MasterData->getWhereData($select,$table,$where)->row_array();
			// ================================================================
			$select = array(
				'tb.*',
				"(SELECT nama_jenis_alat FROM tbl_jenis_alat_ukur jns WHERE jns.id_jenis_alat = tb.id_jenis_alat) jenis_alat",
				"CASE 
			        WHEN 
			        	(SELECT list.layanan FROM tbl_list_sidang_new list WHERE list.id_list_sidang = tb.id_list_sidang) = 'tera ulang' THEN (SELECT tr.tera_ulang_kantor FROM tbl_tarif tr WHERE tr.id_tarif = tb.id_tarif_timbang) 
			        WHEN 
			        	(SELECT list.layanan FROM tbl_list_sidang_new list WHERE list.id_list_sidang = tb.id_list_sidang) = 'tera' THEN (SELECT tr.tera_kantor FROM tbl_tarif tr WHERE tr.id_tarif = tb.id_tarif_timbang)
			        ELSE NULL
		     	END AS tarif"
			);
			$table = 'tbl_list_sidang_timbang tb';
			$dataTimbang = $this->MasterData->getWhereData($select,$table,$where)->result_array();
			// ======================================================================
			$select = array(
				'tb.*',
				"(SELECT tr.jenis_tarif FROM tbl_tarif tr WHERE tr.id_tarif = (SELECT trf.parent_id FROM tbl_tarif trf WHERE  trf.id_tarif = tb.id_tarif_anak_timbang)) AS parent",
				"(SELECT tr.jenis_tarif FROM tbl_tarif tr WHERE tr.id_tarif = tb.id_tarif_anak_timbang) AS child",
				"CASE 
			        WHEN 
			        	(SELECT list.layanan FROM tbl_list_sidang_new list WHERE list.id_list_sidang = tb.id_list_sidang) = 'tera ulang' THEN (SELECT tr.tera_ulang_kantor FROM tbl_tarif tr WHERE tr.id_tarif = tb.id_tarif_anak_timbang) 
			        WHEN 
			        	(SELECT list.layanan FROM tbl_list_sidang_new list WHERE list.id_list_sidang = tb.id_list_sidang) = 'tera' THEN (SELECT tr.tera_kantor FROM tbl_tarif tr WHERE tr.id_tarif = tb.id_tarif_anak_timbang)
			        ELSE NULL
			     	END AS tarif"
			);
			$table = 'tbl_list_sidang_anak_timbang tb';
			$dataAnakTimbang = $this->MasterData->getWhereData($select,$table,$where)->result_array();
			// ============================================================
			$select = array('nama_pasar');
			$where = "id_pasar = $id_pasar";
			$table = 'tbl_pasar';
			$nama_pasar = $this->MasterData->getWhereData($select,$table,$where)->row()->nama_pasar;
			// ===========================================================
			$data = array(
				'list' 			=> $dataList,
				'timbang' 		=> $dataTimbang,
				'anak_timbang' 	=> $dataAnakTimbang,
				'id_sidang'		=> $id_sidang,
				'nama_pasar'	=> $nama_pasar,
				'link'			=> $link
			);
			$this->load->view('Admin/cetak_kwitansi', $data);
		}
	}

	public function editPendaftaranSidangTera($id='', $ids='') {
		// $id_user = $this->id_user;
		if ($id != '') {
			$id_daftar = decode($id);
		} else {
			$id_daftar = 1;
		}
		if ($ids != '') {
			$id_sidang = decode($ids);
		} else {
			$id_sidang = 1;
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
		$nav['menu'] = 'daftar_sidang';
		$data = array(
			'tempat_tera' => $tempat_tera,
			'dataUsaha' => $dataUsaha,
			'listUttp' => $listUttp,
			'dataPendaftaran' => $dataPendaftaran,
			'dataUser' => $dataUser,
			'id_sidang' => $id_sidang,
		);
		$this->load->view('Admin/head',$head);
		$this->load->view('Admin/navigation',$nav);
		$this->load->view('Admin/edit_pendaftaran_sidang_tera',$data);
		$this->load->view('foot',$foot);
	}

	public function updatePengajuanSidangTera($id='') {
		if ($id != '') {
			$id_sidang = decode($id);
		} else {
			$id_sidang = 1;
		}
		$post = $this->input->POST();
		if ($post) {
			// $post = striptag($data_post);

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
						redirect(base_url().'Admin/dataSidangTera/x/'.encode($id_sidang));
					} else {
						$sess['alert'] = alert_failed('Data pengajuan tera gagal diupdate.');
						$this->session->set_flashdata($sess);
						redirect(base_url().'Admin/dataSidangTera/x/'.encode($id_sidang));
					}
				} else {
					$sess['alert'] = alert_failed('Data pengajuan tera gagal diupdate.');
					$this->session->set_flashdata($sess);
					redirect(base_url().'Admin/dataSidangTera/x/'.encode($id_sidang));
				}
			} else {
				$sess['alert'] = alert_failed('Data pengajuan tera gagal diupdate.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Admin/dataSidangTera/x/'.encode($id_sidang));
			}
		} else {
			$sess['alert'] = alert_failed('Data pengajuan tera gagal diupdate.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Admin/dataSidangTera/x/'.encode($id_sidang));
		}
	}

	public function deletePengajuanSidangTera($value='') {
		$id = $this->input->POST('id');
		$where = "id_daftar = $id";
		$delete = $this->MasterData->deleteData($where,'tbl_pendaftaran');
		if ($delete) {
			echo 'Success';
			$sess['alert'] = alert_success('Data pengajuan tera berhasil dihapus.');
			$this->session->set_flashdata($sess);
			// redirect(base_url().'Admin/dataTera');
		} else {
			echo 'Gagal';
			$sess['alert'] = alert_failed('Data pengajuan tera gagal dihapus.');
			$this->session->set_flashdata($sess);
		}
	}

	public function deletePengajuanSidangTeraNew($value='') {
		$id = $this->input->POST('id');
		$where = "id_list_sidang = $id";
		$delete = $this->MasterData->deleteData($where,'tbl_list_sidang_new');
		if ($delete) {
			echo 'Success';
			$sess['alert'] = alert_success('Data pengajuan tera berhasil dihapus.');
			$this->session->set_flashdata($sess);
			// redirect(base_url().'Admin/dataTera');
		} else {
			echo 'Gagal';
			$sess['alert'] = alert_failed('Data pengajuan tera gagal dihapus.');
			$this->session->set_flashdata($sess);
		}
	}

	public function getDataSptSidang($id='') {
		$id_sidang = $this->input->POST('id_sidang');
		if ($id_sidang) {
			$select = array(
				'st.*',
				"(SELECT psr.nama_pasar FROM tbl_pasar psr WHERE psr.id_pasar = st.id_pasar) nama_pasar",
				"(SELECT des.nama_desa FROM tbl_desa des WHERE des.kode_desa = (SELECT psr.kode_desa FROM tbl_pasar psr WHERE psr.id_pasar = st.id_pasar)) desa",
				"(SELECT kec.nama_kecamatan FROM tbl_kecamatan kec WHERE kec.kode_kecamatan = (SELECT des.kode_kecamatan FROM tbl_desa des WHERE des.kode_desa = (SELECT psr.kode_desa FROM tbl_pasar psr WHERE psr.id_pasar = st.id_pasar))) kecamatan"
			);
			$table = 'tbl_sidang_tera st';
			$where = "id_sidang = $id_sidang";
			$tera = $this->MasterData->getWhereData($select,$table,$where)->row();
			$select = array(
				'spt.*',
				"(SELECT usr.nama_user FROM tbl_user usr WHERE usr.id_user = (SELECT pt.id_user FROM tbl_petugas pt WHERE pt.id_petugas = spt.id_petugas)) nama_user",
				"(SELECT jb.nama_jabatan FROM tbl_jabatan jb WHERE jb.id_jabatan = (SELECT pt.id_jabatan FROM tbl_petugas pt WHERE pt.id_petugas = spt.id_petugas)) jabatan",
				"(SELECT pt.nip FROM tbl_petugas pt WHERE pt.id_petugas = spt.id_petugas) nip",
			);
			$table = 'tbl_spt_sidang spt';
			$where = "spt.id_sidang = $id_sidang";
			$petugas = $this->MasterData->getWhereData($select,$table,$where)->result();
			if ($tera) {
				$result = array(
					'response' => true,
					'tera' =>  $tera,
					'petugas' => $petugas
				);
			} else {
				$result = array(
					'response' => false
				);
			}
		}  else {
			$result = array(
				'response' => false
			);
		}
		echo json_encode($result);
	}

	public function getDetailTimbangan($value='') {
		$id = $this->input->POST('id_list_sidang');

		if ($id) {
			$select = array(
				'tb.*',
				"(SELECT nama_jenis_alat FROM tbl_jenis_alat_ukur jns WHERE jns.id_jenis_alat = tb.id_jenis_alat) jenis_alat",
				"CASE 
			        WHEN 
			        	(SELECT list.layanan FROM tbl_list_sidang_new list WHERE list.id_list_sidang = tb.id_list_sidang) = 'tera ulang' THEN (SELECT tr.tera_ulang_kantor FROM tbl_tarif tr WHERE tr.id_tarif = tb.id_tarif_timbang) 
			        WHEN 
			        	(SELECT list.layanan FROM tbl_list_sidang_new list WHERE list.id_list_sidang = tb.id_list_sidang) = 'tera' THEN (SELECT tr.tera_kantor FROM tbl_tarif tr WHERE tr.id_tarif = tb.id_tarif_timbang)
			        ELSE NULL
		     	END AS tarif"
			);
			$table = 'tbl_list_sidang_timbang tb';
			$where = "id_list_sidang = $id";
			$dataList = $this->MasterData->getWhereData($select,$table,$where)->result();

			if ($dataList) {
				$result = array(
					'response' 	=> true,
					'data'		=> $dataList 
				);
			} else {
				$result = array(
					'response' 	=> false
				);
			}
		} else {
			$result = array(
				'response' 	=> false
			);
		}

		echo json_encode($result);
	}

	public function getDetailAnakTimbangan($value='') {
		$id = $this->input->POST('id_list_sidang');

		if ($id) {
			$select = array(
				'tb.*',
				"(SELECT tr.jenis_tarif FROM tbl_tarif tr WHERE tr.id_tarif = (SELECT trf.parent_id FROM tbl_tarif trf WHERE  trf.id_tarif = tb.id_tarif_anak_timbang)) AS parent",
				"(SELECT tr.jenis_tarif FROM tbl_tarif tr WHERE tr.id_tarif = tb.id_tarif_anak_timbang) AS child",
				"CASE 
			        WHEN 
			        	(SELECT list.layanan FROM tbl_list_sidang_new list WHERE list.id_list_sidang = tb.id_list_sidang) = 'tera ulang' THEN (SELECT tr.tera_ulang_kantor FROM tbl_tarif tr WHERE tr.id_tarif = tb.id_tarif_anak_timbang) 
			        WHEN 
			        	(SELECT list.layanan FROM tbl_list_sidang_new list WHERE list.id_list_sidang = tb.id_list_sidang) = 'tera' THEN (SELECT tr.tera_kantor FROM tbl_tarif tr WHERE tr.id_tarif = tb.id_tarif_anak_timbang)
			        ELSE NULL
			     	END AS tarif"
			);
			$table = 'tbl_list_sidang_anak_timbang tb';
			$where = "id_list_sidang = $id";
			$dataList = $this->MasterData->getWhereData($select,$table,$where)->result();

			if ($dataList) {
				$result = array(
					'response' 	=> true,
					'data'		=> $dataList 
				);
			} else {
				$result = array(
					'response' 	=> false
				);
			}
		} else {
			$result = array(
				'response' 	=> false
			);
		}

		echo json_encode($result);
	}
	// ======================================================

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
			'status' => 'diterima',
			'tgl_update_status' => date('Y-m-d H:i:s')
		);
		// var_dump($data);
		$where = "id_daftar = '$id_daftar'";
		$update = $this->MasterData->editData($where,$data,'tbl_pendaftaran');
		if ($update) {
			// echo 'Success';
			$sess['alert'] = alert_success('Data pengajuan tera berhasil dikirim.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Admin/dataTera');
		} else {
			// echo 'Gagal';
			$sess['alert'] = alert_failed('Data pengajuan tera gagal dikirim.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Admin/dataTera');
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
	// ======================================================
	public function pengajuanMasuk($status='x', $id=''){
		// $id_user = $this->id_user;
		$select = array(
			'dft.*',
			"(SELECT jns.nama_jenis_usaha FROM tbl_jenis_usaha jns WHERE jns.id_jenis_usaha IN (SELECT ush.id_jenis_usaha FROM tbl_usaha ush WHERE ush.id_usaha = dft.id_usaha)) jenis_usaha",
			"(SELECT usr.nama_user FROM tbl_user usr WHERE usr.id_user = (SELECT ush.id_user FROM tbl_usaha ush WHERE ush.id_usaha = dft.id_usaha)) nama_user",
			"(SELECT tmp.tempat_tera FROM tbl_tempat_tera tmp WHERE tmp.id_tempat_tera = dft.id_tempat_tera) tempat_tera"
		);
		$table = "tbl_pendaftaran dft";
		$where = "user_daftar = 'user'";
		if ($id == '') {
			$id_daftar = 0;
			if ($status != 'x') {
				// if ($status == 'belumkirim') {
				// 	$where .= " AND status = 'belum kirim'";
				// }
				if ($status == 'pending') {
					$where .= " AND status = 'pending'";
				}
				if ($status == 'diterima') {
					$where .= " AND status = 'diterima'";
				}
				if ($status == 'proses') {
					$where .= " AND status = 'proses'";
				}
				if ($status == 'selesai') {
					$where .= " AND status = 'selesai'";
				}
				if ($status == 'ditolak') {
					$where .= " AND status = 'ditolak'";
				}
			} else {
				$status = 'pending';
				$where .= " AND status = 'pending'";
			}
		} else {
			$id_daftar = decode($id);
			$where .= " AND id_daftar = $id_daftar";
		}
		$by = 'dft.tgl_kirim';
		$order = 'DESC';
		$dataTera = $this->MasterData->getWhereDataOrder($select,$table,$where,$by,$order)->result();
		// =====================================================
		$select = array(
			'pt.*',
			"(SELECT usr.nama_user FROM tbl_user usr WHERE usr.id_user = pt.id_user) nama_user",
			"(SELECT jbt.nama_jabatan FROM tbl_jabatan jbt WHERE jbt.id_jabatan = pt.id_jabatan) jabatan",
		);
		$table = 'tbl_petugas pt';
		$where = "id_petugas > 0";
		$by = 'id_jabatan';
		$order = 'ASC';
		$dataPetugas = $this->MasterData->getWhereDataOrder($select,$table,$where,$by,$order)->result();
		// =========================================================
		$select = array(
			'pt.*',
			"(SELECT usr.nama_user FROM tbl_user usr WHERE usr.id_user = pt.id_user) nama_user"
		);
		$where = "id_jabatan = (SELECT jb.id_jabatan FROM tbl_jabatan jb WHERE  jb.nama_jabatan = 'Kepala Dinas')";
		$table = 'tbl_petugas pt';
		$kepalaDinas = $this->MasterData->getWhereData($select,$table,$where)->row();
		// ==========================================================
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
			// "$(document).ready( function () {
			// 	var table = $('#myTable').DataTable();
		 //        var row = table.row(function ( idx, data, node ) {
			//         return data[11] === '".$id."';
			//     });
		 //      	if (row.length > 0) {
			//         row.select()
			//         .show()
			//         .draw(false);
		 //      	}
	  //     	});",
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
			// "https://cdn.datatables.net/v/dt/dt-1.10.16/sl-1.2.4/datatables.min.js",
			// "https://cdn.datatables.net/plug-ins/1.10.13/api/row().show().js"
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
		$nav['menu'] = 'pengajuan_tera';
		$data = array(
			'dataTera' => $dataTera,
			'kepalaDinas' => $kepalaDinas,
			'dataPetugas' => $dataPetugas,
			'idDaftar' => $id_daftar,
			// 'idRow' => $id,
			'selectStatus' => $status
		);
		$this->load->view('Admin/head',$head);
		$this->load->view('Admin/navigation',$nav);
		$this->load->view('Admin/pengajuan_masuk',$data);
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
		$this->load->view('Admin/head',$head);
		$this->load->view('Admin/navigation',$nav);
		$this->load->view('Admin/terima_pengajuan',$data);
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
		        // $cekID = $this->sms->query("SHOW TABLE STATUS LIKE 'outbox'")->row();
		        // $newID = $cekID->Auto_increment;
		        // $data = array(
		        //     'DestinationNumber' => $noTelp,
		        //     'TextDecoded' => $pesan,
		        //     'ID' => $newID,
		        //     'MultiPart' => 'false',
		        //     'CreatorID' => 'SiMetro'
		        // );
		        // $table = 'outbox';
				// $input_msg = $this->MasterData->sendMsg($data,$table);
				kirim_wa($noTelp, $pesan);
			}
			redirect(base_url().'Admin/pengajuanMasuk');
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
		        // $cekID = $this->sms->query("SHOW TABLE STATUS LIKE 'outbox'")->row();
		        // $newID = $cekID->Auto_increment;
		        // $data = array(
		        //     'DestinationNumber' => $noTelp,
		        //     'TextDecoded' => $pesan,
		        //     'ID' => $newID,
		        //     'MultiPart' => 'false',
		        //     'CreatorID' => 'SiMetro'
		        // );
		        // $table = 'outbox';
				// $input_msg = $this->MasterData->sendMsg($data,$table);
				kirim_wa($noTelp, $pesan);
			}
			redirect(base_url().'Admin/pengajuanMasuk');
		}
	}
	public function inputTglInspeksi($value='') {
		$data_input = $this->input->POST();
		$input = striptag($data_input);
		// var_dump($input); exit();
		$data = array(
			'tgl_inspeksi' => date('Y-m-d', strtotime($input['tgl_inspeksi'])),
			'status' => 'proses',
			'notif' => 0,
			'tgl_update_status' => date('Y-m-d H:i:s')
		);
		$where = "id_daftar = $input[id_daftar]";
		$update = $this->MasterData->editData($where,$data,'tbl_pendaftaran');
		if ($update) {
			$dataSpt = array();
			foreach ($input['id_petugas'] as $key) {
				$arr = array(
					'id_petugas' => $key,
					'id_daftar' => $input['id_daftar']
				);
				$dataSpt[] = $arr;
			}
			$insert_spt = $this->db->insert_batch('tbl_spt', $dataSpt);
			$where = "id_user = (SELECT ush.id_user FROM tbl_usaha ush WHERE ush.id_usaha = (SELECT dft.id_usaha FROM tbl_pendaftaran dft WHERE dft.id_daftar = $input[id_daftar]))";
			$noTelp = $this->MasterData->getWhereData('*','tbl_user',$where)->row()->no_hp;
			if ($noTelp == null) {
				$noTelp = '0';
			}
			$where = "id_daftar = $input[id_daftar]";
			$no_order = $this->MasterData->getWhereData('*','tbl_pendaftaran',$where)->row()->no_order;
			$pesan = "Status pengajuan tera/tera ulang Anda dengan nomor order ".$no_order." saat ini sudah diPROSES oleh Admin";
	        // $cekID = $this->sms->query("SHOW TABLE STATUS LIKE 'outbox'")->row();
	        // $newID = $cekID->Auto_increment;
	        // $data = array(
	        //     'DestinationNumber' => $noTelp,
	        //     'TextDecoded' => $pesan,
	        //     'ID' => $newID,
	        //     'MultiPart' => 'false',
	        //     'CreatorID' => 'SiMetro'
	        // );
	        // $table = 'outbox';
			// $input_msg = $this->MasterData->sendMsg($data,$table);
			
			kirim_wa($noTelp, $pesan);

			$sess['alert'] = alert_success('Tanggal inspeksi berhasil disimpan. Mohon pengajuan segera diproses!');
			$this->session->set_flashdata($sess);
			$result = array(
				'response' => true
			);
			// redirect(base_url().'Admin/pengajuanMasuk/diterima');
		} else {
			$sess['alert'] = alert_failed('Tanggal inspeksi gagal disimpan.');
			$this->session->set_flashdata($sess);
			$result = array(
				'response' => false
			);
			// redirect(base_url().'Admin/pengajuanMasuk/diterima');
		}
		echo json_encode($result);
	}
	public function tolakPengajuan($value='') {
		$data_input = $this->input->POST();
		if ($data_input) {
			$input = striptag($data_input);
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
			        // $cekID = $this->sms->query("SHOW TABLE STATUS LIKE 'outbox'")->row();
			        // $newID = $cekID->Auto_increment;
			        // $data = array(
			        //     'DestinationNumber' => $noTelp,
			        //     'TextDecoded' => $pesan,
			        //     'ID' => $newID,
			        //     'MultiPart' => 'false',
			        //     'CreatorID' => 'SiMetro'
			        // );
			        // $table = 'outbox';
					// $input_msg = $this->MasterData->sendMsg($data,$table);
					
					kirim_wa($noTelp, $pesan);

					redirect(base_url().'Admin/pengajuanMasuk');
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
		$data_post = $this->input->POST();
		if ($data_post) {
			$post = striptag($data_post);
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
					redirect(base_url().'Admin/showTerimaPengajuan/'.encode($id_daftar));
				// } else {
				// 	$sess['alert'] = alert_failed('Data tarif gagal diupdate.');
				// 	$this->session->set_flashdata($sess);
				// 	redirect(base_url().'Admin/showTerimaPengajuan/'.encode($id_daftar));
				// }
			} else {
				$sess['alert'] = alert_failed('Data tarif gagal diupdate.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Admin/showTerimaPengajuan/'.encode($id_daftar));
			}
		} else {
			$sess['alert'] = alert_failed('Data tarif gagal diupdate.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Admin/showTerimaPengajuan/'.encode($id_daftar));
		}
	}
	public function cetakFileSurat($id=''){
		$data['photo']  = $this->db->query("SELECT file_surat, no_order FROM tbl_pendaftaran WHERE id_daftar = '$id'")->result();
		// var_dump($data);exit();
		$this->load->library('pdf');
		$this->load->view('Admin/cetak_surat',$data);
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
	public function getDataSpt($id='') {
		$id_daftar = $this->input->POST('id_daftar');
		if ($id_daftar) {
			$select = array(
				'dft.*',
				"(SELECT usr.nama_user FROM tbl_user usr WHERE usr.id_user = (SELECT ush.id_user FROM tbl_usaha ush WHERE dft.id_usaha = ush.id_usaha)) nama_pemilik",
				"(SELECT ush.nama_usaha FROM tbl_usaha ush WHERE dft.id_usaha = ush.id_usaha) nama_usaha",
				"(SELECT ush.alamat FROM tbl_usaha ush WHERE dft.id_usaha = ush.id_usaha) alamat_usaha",
				"(SELECT des.nama_desa FROM tbl_desa des WHERE des.kode_desa = (SELECT ush.kode_desa FROM tbl_usaha ush WHERE ush.id_usaha = dft.id_usaha)) desa",
				"(SELECT kec.nama_kecamatan FROM tbl_kecamatan kec WHERE kec.kode_kecamatan = (SELECT des.kode_kecamatan FROM tbl_desa des WHERE des.kode_desa = (SELECT ush.kode_desa FROM tbl_usaha ush WHERE ush.id_usaha = dft.id_usaha))) kecamatan"
			);
			$table = 'tbl_pendaftaran dft';
			$where = "id_daftar = $id_daftar";
			$tera = $this->MasterData->getWhereData($select,$table,$where)->row();
			$select = array(
				'spt.*',
				"(SELECT usr.nama_user FROM tbl_user usr WHERE usr.id_user = (SELECT pt.id_user FROM tbl_petugas pt WHERE pt.id_petugas = spt.id_petugas)) nama_user",
				"(SELECT jb.nama_jabatan FROM tbl_jabatan jb WHERE jb.id_jabatan = (SELECT pt.id_jabatan FROM tbl_petugas pt WHERE pt.id_petugas = spt.id_petugas)) jabatan",
				"(SELECT pt.nip FROM tbl_petugas pt WHERE pt.id_petugas = spt.id_petugas) nip",
			);
			$table = 'tbl_spt spt';
			$where = "spt.id_daftar = $id_daftar";
			$petugas = $this->MasterData->getWhereData($select,$table,$where)->result();
			if ($tera) {
				$result = array(
					'response' => true,
					'tera' =>  $tera,
					'petugas' => $petugas
				);
			} else {
				$result = array(
					'response' => false
				);
			}
		}  else {
			$result = array(
				'response' => false
			);
		}
		echo json_encode($result);
	}
	// ====================================================
	public function pengujianTera($id=1){
		$where = "id_tempat_tera = $id";
		$tempatTera = $this->MasterData->getDataWhere('tbl_tempat_tera',$where);
		if ($tempatTera->num_rows() == 0) {
			$id = 1;
		}
		$select = array(
			'dft.*',
			"(SELECT jns.nama_jenis_usaha FROM tbl_jenis_usaha jns WHERE jns.id_jenis_usaha IN (SELECT ush.id_jenis_usaha FROM tbl_usaha ush WHERE ush.id_usaha = dft.id_usaha)) jenis_usaha",
			"(SELECT usr.nama_user FROM tbl_user usr WHERE usr.id_user = (SELECT ush.id_user FROM tbl_usaha ush WHERE ush.id_usaha = dft.id_usaha)) nama_user",
			"(SELECT tmp.tempat_tera FROM tbl_tempat_tera tmp WHERE tmp.id_tempat_tera = dft.id_tempat_tera) tempat_tera"
		);
		if ($id == 2) {
			$select[] = "(SELECT psr.nama_pasar FROM tbl_pasar psr WHERE psr.id_pasar = (SELECT st.id_pasar FROM tbl_sidang_tera st WHERE st.id_sidang = (SELECT list.id_sidang FROM tbl_list_sidang list WHERE list.id_daftar = dft.id_daftar))) pasar";
		}
		if ($id == 3) {
			$select[] = "(SELECT usr.alamat_user FROM tbl_user usr WHERE usr.id_user = (SELECT ush.id_user FROM tbl_usaha ush WHERE ush.id_usaha = dft.id_usaha)) alamat";
		}
		$table = "tbl_pendaftaran dft";
		$where = "id_tempat_tera = '$id' AND status = 'proses' AND input_hasil = 'belum'";
		$by = 'dft.id_daftar';
		$order = 'DESC';
		$dataTera = $this->MasterData->getWhereDataOrder($select,$table,$where,$by,$order)->result();
		// $statusJl = $this->MasterData->getData('tbl_status_jalan')->result();
		$this->head[] = "assets/assets/plugins/select2/dist/css/select2.css";
		$this->head[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.css";
		$this->head[] = "assets/assets/plugins/sweetalert/sweetalert.css";
		// $this->head[] = "assets/assets/plugins/dropify/dist/css/dropify.min.css";
		$this->head[] = "assets/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css";
		$this->foot[] = "assets/assets/plugins/select2/dist/js/select2.full.min.js";
		$this->foot[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/sweetalert.min.js";
		$this->foot[] = "assets/assets/plugins/sweetalert/jquery.sweet-alert.custom.js";
		$this->foot[] = "assets/assets/plugins/datatables/jquery.dataTables.min.js";
		// $this->foot[] = "assets/assets/plugins/dropify/dist/js/dropify.min.js";
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
		$where = "id_tempat_tera = $id";
		$menus = $this->MasterData->getDataWhere('tbl_tempat_tera',$where)->row();
		$select_menu = str_replace(' ', '_', $menus->tempat_tera);
		$nav['menu'] = $select_menu;
		$data = array(
			'dataTera' => $dataTera,
			'tempatTera' => $menus->tempat_tera,
			'param' => $id
		);
		$this->load->view('Admin/head',$head);
		$this->load->view('Admin/navigation',$nav);
		$this->load->view('Admin/pengujian_tera',$data);
		$this->load->view('foot',$foot);
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
		// =========================================================================================
		$select = array(
			'pt.*',
			"(SELECT usr.nama_user FROM tbl_user usr WHERE usr.id_user = pt.id_user) nama_user",
		);
		$table = 'tbl_petugas pt';
		$where = "pt.id_jabatan IN (SELECT jb.id_jabatan FROM tbl_jabatan jb WHERE nama_jabatan like '%Penera%')";
		$dataPetugasTera = $this->MasterData->getWhereData($select,$table,$where)->result();
		// =========================================================================================
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
                source: '".base_url().'Admin/getDataPetugas'."',
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
		$where = "id_tempat_tera = $source";
		$menus = $this->MasterData->getDataWhere('tbl_tempat_tera',$where)->row();
		$select_menu = str_replace(' ', '_', $menus->tempat_tera);
		$nav['menu'] = $select_menu;
		$data = array(
			// 'dataUsaha' => $dataUsaha,
			'listUttp' => $listUttp,
			'dataPendaftaran' => $dataPendaftaran,
			'dataPetugasTera' => $dataPetugasTera,
			'id_daftar' => $id_daftar,
			'source' => $source
			// 'dataUser' => $dataUser
		);
		$this->load->view('Admin/head',$head);
		$this->load->view('Admin/navigation',$nav);
		$this->load->view('Admin/input_hasil_pengujian',$data);
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
		// $input = striptag($data_input);
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
					redirect(base_url().'Admin/inputHasilPengujian/'.$source.'/'.encode($id_daftar));
				} else {
					$sess['alert'] = alert_failed('Data  hasil pengujian gagal disimpan.');
					$this->session->set_flashdata($sess);
					redirect(base_url().'Admin/inputHasilPengujian/'.$source.'/'.encode($id_daftar));
				}
			} else {
				$sess['alert'] = alert_failed('Data  hasil pengujian gagal disimpan.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Admin/inputHasilPengujian/'.$source.'/'.encode($id_daftar));
			}
		} else {
			$sess['alert'] = alert_failed('Data  hasil pengujian gagal disimpan.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Admin/inputHasilPengujian/'.$source.'/'.encode($id_daftar));
		}
	}
	public function updateHasilUji($source='', $value='') {
		$input = $this->input->POST();
		// $input = striptag($data_input);
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
					redirect(base_url().'Admin/inputHasilPengujian/'.$source.'/'.encode($id_daftar));
				} else {
					$sess['alert'] = alert_failed('Data  hasil pengujian gagal diupdate.');
					$this->session->set_flashdata($sess);
					redirect(base_url().'Admin/inputHasilPengujian/'.$source.'/'.encode($id_daftar));
				}
			} else {
				$sess['alert'] = alert_failed('Data  hasil pengujian gagal diupdate.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Admin/inputHasilPengujian/'.$source.'/'.encode($id_daftar));
			}
		} else {
			$sess['alert'] = alert_failed('Data  hasil pengujian gagal diupdate.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Admin/inputHasilPengujian/'.$source.'/'.encode($id_daftar));
		}
	}
	public function selesaiInputHasilUji($source='', $id='') {
		if ($id != '') {
			$data = array(
				'input_hasil' => 'sudah',
				'tgl_update_status' => date('Y-m-d H:i:s')
			);
			$where = "id_daftar = $id";
			$update = $this->MasterData->editData($where,$data,'tbl_pendaftaran');
			if ($update) {
				redirect(base_url().'Admin/pengujianTera/'.$source);
			}
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
				redirect(base_url().'Admin/pengajuanMasuk/x/'.encode($id));
			}
		}
	}
	public function clickNotifAll() {
		$data = array(
			'notif_petugas' => 1
		);
		$where = "user_daftar = 'user' AND status = 'pending' AND notif_petugas = 0";
		$update = $this->MasterData->editData($where,$data,'tbl_pendaftaran');
		if ($update) {
			redirect(base_url().'Admin/pengajuanMasuk/');
		}
	}
	// =====================================================
	public function hasilPengujian($param='') {
		// $id_user = $this->id_user;
		$select = array(
			'dft.*',
			"(SELECT jns.nama_jenis_usaha FROM tbl_jenis_usaha jns WHERE jns.id_jenis_usaha IN (SELECT ush.id_jenis_usaha FROM tbl_usaha ush WHERE ush.id_usaha = dft.id_usaha)) jenis_usaha",
			"(SELECT usr.nama_user FROM tbl_user usr WHERE usr.id_user = (SELECT ush.id_user FROM tbl_usaha ush WHERE ush.id_usaha = dft.id_usaha)) nama_user",
			"(SELECT COUNT(byr.id_bayar) FROM tbl_pembayaran byr WHERE byr.id_daftar = dft.id_daftar) bayar",
			"(SELECT byr.nominal_bayar FROM tbl_pembayaran byr WHERE byr.id_daftar = dft.id_daftar) nominal_bayar",
		);
		$table = "tbl_pendaftaran dft";
		$where = "input_hasil = 'sudah'";
		if ($param != '') {
			if ($param == 'sudah') {
				$select[] = "(SELECT byr.tgl_bayar FROM tbl_pembayaran byr WHERE byr.id_daftar = dft.id_daftar) tgl_bayar";
				$where .= " AND id_daftar IN (SELECT byr.id_daftar FROM tbl_pembayaran byr)";
				// $by = 'tgl_bayar';
				// $order = 'DESC';
				$order = 'dft.no_order DESC, tgl_bayar DESC';

				$dataTera = $this->MasterData->getWhereDataOrderMultiple($select,$table,$where,$order)->result();
			} else {
				$by = 'tgl_update_status';
				$order = 'DESC';
				$where .= " AND id_daftar NOT IN (SELECT byr.id_daftar FROM tbl_pembayaran byr)";

				$dataTera = $this->MasterData->getWhereDataOrder($select,$table,$where,$by,$order)->result();
			}
		} else {
			$param = 'belum';
			$by = 'tgl_update_status';
			$order = 'DESC';
			$where .= " AND id_daftar NOT IN (SELECT byr.id_daftar FROM tbl_pembayaran byr)";

			$dataTera = $this->MasterData->getWhereDataOrder($select,$table,$where,$by,$order)->result();
		}
		
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
			// "$('#myTable').DataTable({ 'order': [[ 8, 'asc' ], [ 1, 'asc' ]] });",
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
			'bayar' => $bayar,
			'selectStatus' => $param
		);
		$this->load->view('Admin/head',$head);
		$this->load->view('Admin/navigation',$nav);
		$this->load->view('Admin/hasil_uji',$data);
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
		// =============================================================
		$select = array(
			'pt.*',
			"(SELECT usr.nama_user FROM tbl_user usr WHERE usr.id_user = pt.id_user) nama_user"
		);
		$where = "id_jabatan = (SELECT jb.id_jabatan FROM tbl_jabatan jb WHERE  jb.nama_jabatan = 'Kepala Dinas')";
		$table = 'tbl_petugas pt';
		$kepalaDinas = $this->MasterData->getWhereData($select,$table,$where)->row();
		// ==============================================================
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
                source: '".base_url().'Admin/getDataPetugas'."',
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
			'kepalaDinas' => $kepalaDinas,
			// 'dataUser' => $dataUser
		);
		$this->load->view('Admin/head',$head);
		$this->load->view('Admin/navigation',$nav);
		$this->load->view('Admin/cetak_hasil_uji',$data);
		$this->load->view('foot',$foot);
	}
	public function getDataHasilUji($id='') {
		$data_input = $this->input->POST();
		if ($data_input) {
			$input = striptag($data_input);
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
		$data_input = $this->input->POST();
		if ($data_input) {
			$input = striptag($data_input);
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
					$selesaiPengajuan = $this->selesaiPengajuan($input['id_daftar']);
					if ($selesaiPengajuan) {
						$sess['alert'] = alert_success('Pembayaran berhasil disimpan.');
						$this->session->set_flashdata($sess);
						redirect(base_url().'Admin/hasilPengujian');
					} else {
						$sess['alert'] = alert_failed('Pembayaran gagal disimpan.');
						$this->session->set_flashdata($sess);
						redirect(base_url().'Admin/hasilPengujian');
					}
				} else {
					$sess['alert'] = alert_failed('Pembayaran gagal disimpan.');
					$this->session->set_flashdata($sess);
					redirect(base_url().'Admin/hasilPengujian');
				}
			} else {
				$where = "id_daftar = $input[id_daftar]";
				$updatePembayaran = $this->MasterData->editData($where,$data,'tbl_pembayaran');
				if ($updatePembayaran) {
					$selesaiPengajuan = $this->selesaiPengajuan($input['id_daftar']);
					if ($selesaiPengajuan) {
						$sess['alert'] = alert_success('Pembayaran berhasil disimpan.');
						$this->session->set_flashdata($sess);
						redirect(base_url().'Admin/hasilPengujian');
					} else {
						$sess['alert'] = alert_failed('Pembayaran gagal disimpan.');
						$this->session->set_flashdata($sess);
						redirect(base_url().'Admin/hasilPengujian');
					}
				} else {
					$sess['alert'] = alert_failed('Pembayaran gagal disimpan.');
					$this->session->set_flashdata($sess);
					redirect(base_url().'Admin/hasilPengujian');
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
	public function selesaiPengajuan($id='') {
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
		        // $cekID = $this->sms->query("SHOW TABLE STATUS LIKE 'outbox'")->row();
		        // $newID = $cekID->Auto_increment;
		        // $data = array(
		        //     'DestinationNumber' => $noTelp,
		        //     'TextDecoded' => $pesan,
		        //     'ID' => $newID,
		        //     'MultiPart' => 'false',
		        //     'CreatorID' => 'SiMetro'
		        // );
		        // $table = 'outbox';
				// $input_msg = $this->MasterData->sendMsg($data,$table);
					
				kirim_wa($noTelp, $pesan);

				// redirect(base_url().'Admin/hasilPengujian');
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	// =====================================================
	public function uttpTeraUlang($id=''){
		$select = array(
			'uttp.*',
			"(SELECT alat.nama_jenis_alat FROM tbl_jenis_alat_ukur alat WHERE alat.id_jenis_alat = uttp.id_jenis_alat) jenis_alat",
			"(SELECT usr.id_user FROM tbl_user usr WHERE usr.id_user = (SELECT ush.id_user FROM tbl_usaha ush WHERE ush.id_usaha = uttp.id_usaha)) id_user",
			"(SELECT usr.nama_user FROM tbl_user usr WHERE usr.id_user = (SELECT ush.id_user FROM tbl_usaha ush WHERE ush.id_usaha = uttp.id_usaha)) nama_pemilik",
			"(SELECT jns.nama_jenis_usaha FROM tbl_jenis_usaha jns WHERE jns.id_jenis_usaha = (SELECT ush.id_jenis_usaha FROM tbl_usaha ush WHERE ush.id_usaha = uttp.id_usaha)) jenis_usaha",
			"(SELECT ush.nama_usaha FROM tbl_usaha ush WHERE ush.id_usaha = uttp.id_usaha) nama_usaha",
		);
		$table = "tbl_uttp uttp";
		$where = "uttp.tgl_tera_ulang BETWEEN CURDATE() AND DATE_SUB(CURDATE(), INTERVAL -30 DAY)";
		$by = 'uttp.tgl_tera_ulang';
		$order = 'DESC';
		$dataUttp = $this->MasterData->getWhereDataOrder($select,$table,$where,$by,$order)->result();
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
		$nav['menu'] = 'uttp_ulang';
		$data = array(
			'dataUttp' => $dataUttp,
		);
		$this->load->view('Admin/head',$head);
		$this->load->view('Admin/navigation',$nav);
		$this->load->view('Admin/uttp_tera_ulang',$data);
		$this->load->view('foot',$foot);
	}
	public function kirimNotif($value='') {
		$data_post = $this->input->POST();
		if ($data_post) {
			$post = striptag($data_post);
			$id_user = $post['id_user'];
			$id_uttp = $post['id_uttp'];
			$where = "id_user = $id_user";
			$noTelp = $this->MasterData->getWhereData('*','tbl_user',$where)->row()->no_hp;
			if ($noTelp == null) {
				$noTelp = '0';
			}
			$select = array(
				'uttp.*',
				"(SELECT jns.nama_jenis_alat FROM tbl_jenis_alat_ukur jns WHERE jns.id_jenis_alat = uttp.id_jenis_alat) jenis_alat"
			);
			$where = "id_uttp = $id_uttp";
			$uttp = $this->MasterData->getWhereData($select,'tbl_uttp uttp',$where)->row();
			$kapasitas = '';
			if ($uttp->kapasitas != '-' || $uttp->kapasitas != '') {
				$kapasitas = ' kapasitas '.$uttp->kapasitas;
			}
			$pesan = "Masa berlaku tera ".$uttp->jenis_alat.$kapasitas." Anda akan berakhir pada tanggal ".formatTanggalTtd($uttp->tgl_tera_ulang).". Mohon untuk segera mengajukan permohonan tera ulang.\n\nDikirim dari aplikasi simetro.magelangkab.go.id";
	        // $cekID = $this->sms->query("SHOW TABLE STATUS LIKE 'outbox'")->row();
	        // $newID = $cekID->Auto_increment;
	        // // menghitung jumlah pecahan
	        // $jmlSMS = ceil(strlen($pesan)/153);
	        // // memecah pesan asli
	        // $pecah  = str_split($pesan, 153);
	        // // proses penyimpanan ke tabel mysql untuk setiap pecahan
	        // $counts = 0;
	        // for ($i=1; $i<=$jmlSMS; $i++){
	        //    // membuat UDH untuk setiap pecahan, sesuai urutannya
	        //    $udh = "050003A7".sprintf("%02s", $jmlSMS).sprintf("%02s", $i);
	        //    // membaca text setiap pecahan
	        //    $msg = $pecah[$i-1];
	        //    if ($i == 1){
		    //          // jika merupakan pecahan pertama, maka masukkan ke tabel OUTBOX
	        //    		$data = array(
			//             'DestinationNumber' => $noTelp,
			//             'UDH' => $udh,
			//             'TextDecoded' => $msg,
			//             'ID' => $newID,
			//             'MultiPart' => 'true',
			//             'CreatorID' => 'SiMetro'
			//         );
			//         $table = 'outbox';
			//         $input_msg = $this->MasterData->sendMsg($data,$table);
	        //    }else{
	        //       	// jika bukan merupakan pecahan pertama, simpan ke tabel OUTBOX_MULTIPART
	        //     	$data = array(
			//             'UDH' => $udh,
			//             'TextDecoded' => $msg,
			//             'ID' => $newID,
			//             'SequencePosition' => $i
			//         );
			//         $table = 'outbox_multipart';
			//         $input_msg = $this->MasterData->sendMsg($data,$table);
	        //    }
	        //    	if ($input_msg) {
		    //      	$counts++;
		    //     }          
	        // }
	        // if ($counts > 0) {
	        // 	echo "Success";
	        // } else {
	        // 	echo "Gagal";
			// }
			
			$cek_wa = kirim_wa($noTelp, $pesan);

			if($cek_wa){
				echo "Success";
			} else {
				echo "Gagal";
			}

		} else {
			echo "Gagal";
		}
	}
	public function getDetailUser($value='') {
		$id_user = $this->input->POST('id_user');
		if ($id_user) {
			$select = array(
				'usr.*',
				"(SELECT ush.alamat FROM tbl_usaha ush WHERE ush.id_user = usr.id_user) alamat_usaha",
				"(SELECT des.nama_desa FROM tbl_desa des WHERE des.kode_desa = (SELECT ush.kode_desa FROM tbl_usaha ush WHERE ush.id_user = usr.id_user)) desa",
				"(SELECT kec.nama_kecamatan FROM tbl_kecamatan kec WHERE kec.kode_kecamatan = (SELECT des.kode_kecamatan FROM tbl_desa des WHERE des.kode_desa = (SELECT ush.kode_desa FROM tbl_usaha ush WHERE ush.id_user = usr.id_user))) kecamatan"
			);
			$where = "id_user = $id_user";
			$dataUser = $this->MasterData->getWhereData($select,'tbl_user usr',$where)->row();
			if ($dataUser) {
				$result = array(
					'response' => true,
					'dataUser' =>  $dataUser
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
	public function targetPad($value='') {
		$select = array(
			'pad.*'
		);
		$table = 'tbl_target_pad pad';
		$by = 'id_target_pad';
		$order = 'DESC';
		$dataPad = $this->MasterData->getSelectDataOrder($select,$table,$by,$order)->result();
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
		$nav['menu'] = 'target';
		$data = array(
			'data_pad' => $dataPad,
		);
		$this->load->view('Admin/head',$head);
		$this->load->view('Admin/navigation',$nav);
		$this->load->view('Admin/target_pad',$data);
		$this->load->view('foot',$foot);
	}
	public function tambahTargetPad($value='') {
		$data_input = $this->input->POST();
		if ($data_input) {
			$input = striptag($data_input);
			$data = array(
				'tahun_pad' => $input['tahun_pad'],
				'target_pad' => str_replace(".", "", $input['target_pad']),
			);
			$insert = $this->MasterData->inputData($data,'tbl_target_pad');
			if ($insert) {
				$sess['alert'] = alert_success('Data target PAD berhasil disimpan.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Admin/targetPad');
			} else {
				$sess['alert'] = alert_failed('Data target PAD gagal disimpan.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Admin/targetPad');
			}
		}
	}
	public function updateTargetPad($value='') {
		$data_input = $this->input->POST();
		if ($data_input) {
			$input = striptag($data_input);
			$data = array(
				'tahun_pad' => $input['tahun_pad'],
				'target_pad' => str_replace(".", "", $input['target_pad']),
			);
			$where = "id_target_pad = $input[id_target_pad]";
			$update = $this->MasterData->editData($where, $data, 'tbl_target_pad');
			if ($update) {
				$sess['alert'] = alert_success('Data target PAD berhasil diupdate.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Admin/targetPad');
			} else {
				$sess['alert'] = alert_failed('Data target PAD gagal diupdate.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Admin/targetPad');
			}
		} else {
			$sess['alert'] = alert_failed('Data target PAD gagal diupdate.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Admin/targetPad');
		}
	}
	public function deleteTargetPad($id='') {
		$id = $this->input->POST('id');
		if ($id) {
			$where = "id_target_pad = $id";
			$delete = $this->MasterData->deleteData($where,'tbl_target_pad');
			if ($delete) {
				echo "Success";
				$sess['alert'] = alert_success('Data target PAD berhasil dihapus.');
				$this->session->set_flashdata($sess);
				// redirect(base_url().'Admin/jenisAlat');
			} else {
				echo 'Failed';
				$sess['alert'] = alert_failed('Data target PAD gagal dihapus.');
				$this->session->set_flashdata($sess);
				// redirect(base_url().'Admin/jenisAlat');
			}
		} else {
			echo 'Failed';
			$sess['alert'] = alert_failed('Data target PAD gagal dihapus.');
			$this->session->set_flashdata($sess);
			// redirect(base_url().'Admin/jenisAlat');
		}
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
		$this->load->view('Admin/head',$head);
		$this->load->view('Admin/navigation',$nav);
		$this->load->view('Admin/kelompok_tarif',$data);
		$this->load->view('foot',$foot);
	}
	public function addKelompokTarif($value='') {
		$input = $this->input->POST();
		if ($input) {
			// $input = striptag($data_input);
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
			// if ($simpanData) {
				$sess['alert'] = alert_success('Data kelompok tarif berhasil disimpan.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Admin/kelompokTarif');
			// } else {
			// 	$sess['alert'] = alert_failed('Data kelompok tarif gagal disimpan.');
			// 	$this->session->set_flashdata($sess);
			// 	redirect(base_url().'Admin/kelompokTarif');
			// }
		} else {
			$sess['alert'] = alert_failed('Data kelompok tarif gagal disimpan.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Admin/kelompokTarif');
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
				// redirect(base_url().'Admin/kategoriAlat');
			} else {
				echo 'Failed';
				$sess['alert'] = alert_failed('Data kelompok tarif gagal dihapus.');
				$this->session->set_flashdata($sess);
				// redirect(base_url().'Admin/kategoriAlat');
			}
		} else {
			echo 'Failed';
			$sess['alert'] = alert_failed('Data kelompok tarif gagal dihapus.');
			$this->session->set_flashdata($sess);
			// redirect(base_url().'Admin/kategoriAlat');
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
		$this->load->view('Admin/head',$head);
		$this->load->view('Admin/navigation',$nav);
		$this->load->view('Admin/kategori_alat',$data);
		$this->load->view('foot',$foot);
	}
	public function inputKategoriAlat($value='') {
		$data_input = $this->input->POST();
		if ($data_input) {
			$data = striptag($data_input);
			$insert = $this->MasterData->inputData($data,'tbl_kategori_alat_ukur');
			if ($insert) {
				$sess['alert'] = alert_success('Data kategori alat berhasil disimpan.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Admin/kategoriAlat');
			} else {
				$sess['alert'] = alert_failed('Data kategori alat gagal disimpan.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Admin/kategoriAlat');
			}
		}
	}
	public function updateKategoriAlat($value='') {
		$data_input = $this->input->POST();
		if ($data_input) {
			$input = striptag($data_input);
			$data = array(
				'nama_kategori_alat' => $input['nama_kategori_alat']
			);
			$where = "id_kategori_alat = $input[id_kategori_alat]";
			$update = $this->MasterData->editData($where,$data,'tbl_kategori_alat_ukur');
			if ($update) {
				$sess['alert'] = alert_success('Data kategori alat berhasil diupdate.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Admin/kategoriAlat');
			} else {
				$sess['alert'] = alert_failed('Data kategori alat gagal diupdate.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Admin/kategoriAlat');
			}
		} else {
			$sess['alert'] = alert_failed('Data kategori alat gagal diupdate.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Admin/kategoriAlat');
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
				// redirect(base_url().'Admin/kategoriAlat');
			} else {
				echo 'Failed';
				$sess['alert'] = alert_failed('Data kategori alat gagal dihapus.');
				$this->session->set_flashdata($sess);
				// redirect(base_url().'Admin/kategoriAlat');
			}
		} else {
			echo 'Failed';
			$sess['alert'] = alert_failed('Data kategori alat gagal dihapus.');
			$this->session->set_flashdata($sess);
			// redirect(base_url().'Admin/kategoriAlat');
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
		$this->load->view('Admin/head',$head);
		$this->load->view('Admin/navigation',$nav);
		$this->load->view('Admin/jenis_alat',$data);
		$this->load->view('foot',$foot);
	}
	public function inputJenisAlat($value='') {
		$data_input = $this->input->POST();
		if ($data_input) {
			$data = striptag($data_input);
			$input = $this->MasterData->inputData($data,'tbl_jenis_alat_ukur');
			if ($input) {
				$sess['alert'] = alert_success('Data jenis alat ukur berhasil disimpan.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Admin/jenisAlat');
			} else {
				$sess['alert'] = alert_failed('Data jenis alat ukur gagal disimpan.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Admin/jenisAlat');
			}
		}
	}
	public function updateJenisAlat($value='') {
		$data_input = $this->input->POST();
		if ($data_input) {
			$input = striptag($data_input);
			$where = "id_jenis_alat = $input[id_jenis_alat]";
			$update = $this->MasterData->editData($where,$input,'tbl_jenis_alat_ukur');
			if ($update) {
				$sess['alert'] = alert_success('Data jenis alat ukur berhasil diupdate.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Admin/jenisAlat');
			} else {
				$sess['alert'] = alert_failed('Data jenis alat ukur gagal diupdate.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Admin/jenisAlat');
			}
		} else {
			$sess['alert'] = alert_failed('Data jenis alat ukur gagal diupdate.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Admin/jenisAlat');
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
				// redirect(base_url().'Admin/jenisAlat');
			} else {
				echo 'Failed';
				$sess['alert'] = alert_failed('Data jenis alat ukur gagal dihapus.');
				$this->session->set_flashdata($sess);
				// redirect(base_url().'Admin/jenisAlat');
			}
		} else {
			echo 'Failed';
			$sess['alert'] = alert_failed('Data jenis alat ukur gagal dihapus.');
			$this->session->set_flashdata($sess);
			// redirect(base_url().'Admin/jenisAlat');
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
		$this->load->view('Admin/head',$head);
		$this->load->view('Admin/navigation',$nav);
		$this->load->view('Admin/jenis_usaha',$data);
		$this->load->view('foot',$foot);
	}
	public function inputJenisUsaha($value='') {
		$data_input = $this->input->POST();
		if ($data_input) {
			$data = striptag($data_input);
			$input = $this->MasterData->inputData($data,'tbl_jenis_usaha');
			if ($input) {
				$sess['alert'] = alert_success('Data jenis usaha berhasil disimpan.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Admin/jenisUsaha');
			} else {
				$sess['alert'] = alert_failed('Data jenis usaha gagal disimpan.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Admin/jenisUsaha');
			}
		}
	}
	public function updateJenisUsaha($value='') {
		$data_input = $this->input->POST();
		if ($data_input) {
			$input = striptag($data_input);
			$where = "id_jenis_usaha = $input[id_jenis_usaha]";
			$update = $this->MasterData->editData($where,$input,'tbl_jenis_usaha');
			if ($update) {
				$sess['alert'] = alert_success('Data jenis usaha berhasil diupdate.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Admin/jenisUsaha');
			} else {
				$sess['alert'] = alert_failed('Data jenis usaha gagal diupdate.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Admin/jenisUsaha');
			}
		} else {
			$sess['alert'] = alert_failed('Data jenis usaha gagal diupdate.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Admin/jenisUsaha');
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
				// redirect(base_url().'Admin/jenisAlat');
			} else {
				echo 'Failed';
				$sess['alert'] = alert_failed('Data jenis usaha gagal dihapus.');
				$this->session->set_flashdata($sess);
				// redirect(base_url().'Admin/jenisAlat');
			}
		} else {
			echo 'Failed';
			$sess['alert'] = alert_failed('Data jenis usaha gagal dihapus.');
			$this->session->set_flashdata($sess);
			// redirect(base_url().'Admin/jenisAlat');
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
		$this->load->view('Admin/head',$head);
		$this->load->view('Admin/navigation',$nav);
		$this->load->view('Admin/data_pasar',$data);
		$this->load->view('foot',$foot);
	}

	public function inputDataPasar($value='') {
		$data_input = $this->input->POST();
		if ($data_input) {
			$input = striptag($data_input);

			$select = 'kode_pasar';
			$table = 'tbl_pasar';
			$limit = 1;
			$by = 'kode_pasar';
			$order = 'DESC';
			$data_pasar = $this->MasterData->getDataLimitOrder($select,$table,$limit,$by,$order);
			$kode_pasar = $data_pasar->row()->kode_pasar;

			if ($data_pasar->num_rows() > 0) { // Check data
				// $kode_pasar = substr($no_order->no_order, 0, 2);
				$kode = substr($kode_pasar, 0); // Mengambil string beberapa digit
				$code = (int) $kode; // Mengubah String jadi Integer
				$code++;
				$kodeOtomatis = str_pad($code, 3, "0", STR_PAD_LEFT); // Kerangka Kode Otomatis = kode_pasar + 6 digit
			} else {
				$kodeOtomatis = '001';
			}

			$data = array(
				'kode_desa' => $input['kode_desa'],
				'kode_pasar' => $kodeOtomatis,
				'nama_pasar' => $input['nama_pasar']
			);
			$insert = $this->MasterData->inputData($data,'tbl_pasar');
			if ($insert) {
				$sess['alert'] = alert_success('Data pasar berhasil disimpan.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Admin/dataPasar');
			} else {
				$sess['alert'] = alert_failed('Data pasar gagal disimpan.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Admin/dataPasar');
			}
		}
	}

	public function updateDataPasar($value='') {
		$data_input = $this->input->POST();
		if ($data_input) {
			$input = striptag($data_input);
			$data = array(
				'kode_desa' => $input['kode_desa'],
				'nama_pasar' => $input['nama_pasar']
			);
			$where = "id_pasar = $input[id_pasar]";
			$update = $this->MasterData->editData($where,$data,'tbl_pasar');
			if ($update) {
				$sess['alert'] = alert_success('Data pasar berhasil diupdate.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Admin/dataPasar');
			} else {
				$sess['alert'] = alert_failed('Data pasar gagal diupdate.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Admin/dataPasar');
			}
		} else {
			$sess['alert'] = alert_failed('Data pasar gagal diupdate.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Admin/dataPasar');
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
				// redirect(base_url().'Admin/jenisAlat');
			} else {
				echo 'Failed';
				$sess['alert'] = alert_failed('Data pasar gagal dihapus.');
				$this->session->set_flashdata($sess);
				// redirect(base_url().'Admin/jenisAlat');
			}
		} else {
			echo 'Failed';
			$sess['alert'] = alert_failed('Data pasar gagal dihapus.');
			$this->session->set_flashdata($sess);
			// redirect(base_url().'Admin/jenisAlat');
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
	public function kelompokPasar($id='') {
		if ($id!='') {
			$id_pasar = decode($id);
		} else {
			$id_pasar = 1;
		}
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
		$where = "id_pasar = $id_pasar";
		$kelPasar = $this->MasterData->getWhereDataOrder($select,$table,$where,$by,$order);
		// ============================================================================
		// $config['base_url'] = base_url().'/Admin/kelompokPasar';
		// $config['total_rows'] = $kelPasar->num_rows();
		// $config['per_page'] = 10;
		// $config['num_links'] = 1;
		// $config['display_pages'] = TRUE;
		// $config['use_page_numbers'] = TRUE;
		// $config['uri_segment'] = 3; //supaya tidak error karena base url dinamis
		// $config['reuse_query_string'] = true; //supaya link pagination sesuai parameter get yang ada
		  //       // Membuat Style pagination untuk BootStrap v4
		  //       $config['first_link']       = '<span class="d-block d-sm-block d-md-none d-lg-none"> << </span> <span class="d-none d-sm-none d-md-block d-lg-block">First</span>';
		  //       $config['last_link']        = '<span class="d-block d-sm-block d-md-none d-lg-none"> >> </span> <span class="d-none d-sm-none d-md-block d-lg-block">Last</span>';
		  //       $config['next_link']        = '<span class="d-block d-sm-block d-md-none d-lg-none"> > </span> <span class="d-none d-sm-none d-md-block d-lg-block">Next</span>';
		  //       $config['prev_link']        = '<span class="d-block d-sm-block d-md-none d-lg-none"> < </span> <span class="d-none d-sm-none d-md-block d-lg-block">Prev</span>';
		  //       $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
		  //       $config['full_tag_close']   = '</ul></nav></div>';
		  //       $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
		  //       $config['num_tag_close']    = '</span></li>';
		  //       $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
		  //       $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
		  //       $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
		  //       $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
		  //       $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
		  //       $config['prev_tagl_close']  = '</span></li>';
		  //       $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
		  //       $config['first_tagl_close'] = '</span></li>';
		  //       $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
		  //       $config['last_tagl_close']  = '</span></li>';
		// $this->pagination->initialize($config);
		// if($this->uri->segment(3) == null){
		// 	$start_index = 0;
		// }else{
		// 	$start_index = ($this->uri->segment(3)-1)*$config['per_page'];
		// }
		// if ($start_index > 0) {
		// 	$numbers = ($this->uri->segment(3)*$config['per_page'])-$config['per_page'];
		// } else {
		// 	$numbers = 0;
		// }
		// $pages =  $this->pagination->create_links();
		// ==============================================================================
		// $where = "grp.id_grup > 0";
		// $dataKelPasar = $this->MasterData->getWhereDataLimitIndexOrder($select,$table,$where,$start_index,$config['per_page'],$by,$order)->result();
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
                source: '".base_url().'Admin/getDataUserKelPasar'."',
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
			'dataKelPasar' => $kelPasar->result(),
			'dataPasar' => $dataPasar,
			'selectPasar' => $id_pasar,
			// 'pages' => $pages,
			// 'numbers' => $numbers
		);
		$this->load->view('Admin/head',$head);
		$this->load->view('Admin/navigation',$nav);
		$this->load->view('Admin/kelompok_pasar',$data);
		$this->load->view('foot',$foot);
	}
	public function inputKelompokPasar($value='') {
		$data_input = $this->input->POST();
		if ($data_input) {
			$input = striptag($data_input);
			$data = array(
				'id_pasar' => $input['id_pasar'],
				'id_usaha' => $input['id_usaha']
			);
			$insert = $this->MasterData->inputData($data,'tbl_grup_pasar');
			if ($insert) {
				$sess['alert'] = alert_success('Kelompok pasar berhasil disimpan.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Admin/kelompokPasar');
			} else {
				$sess['alert'] = alert_failed('Kelompok pasar gagal disimpan.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Admin/kelompokPasar');
			}
		}
	}
	public function updateKelompokPasar($uri='') {
		$data_input = $this->input->POST();
		if ($data_input) {
			$input = striptag($data_input);
			$data = array(
				'id_pasar' => $input['id_pasar'],
				'id_usaha' => $input['id_usaha']
			);
			$where = "id_grup = $input[id_grup]";
			$update = $this->MasterData->editData($where,$data,'tbl_grup_pasar');
			if ($update) {
				$sess['alert'] = alert_success('Kelompok pasar berhasil diupdate.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Admin/kelompokPasar/'.$uri);
			} else {
				$sess['alert'] = alert_failed('Kelompok pasar gagal diupdate.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Admin/kelompokPasar/'.$uri);
			}
		} else {
			$sess['alert'] = alert_failed('Kelompok pasar gagal diupdate.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Admin/kelompokPasar/'.$uri);
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
				// redirect(base_url().'Admin/jenisAlat');
			} else {
				echo 'Failed';
				$sess['alert'] = alert_failed('Kelompok pasar gagal dihapus.');
				$this->session->set_flashdata($sess);
				// redirect(base_url().'Admin/jenisAlat');
			}
		} else {
			echo 'Failed';
			$sess['alert'] = alert_failed('Kelompok pasar gagal dihapus.');
			$this->session->set_flashdata($sess);
			// redirect(base_url().'Admin/jenisAlat');
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
		$this->load->view('Admin/head',$head);
		$this->load->view('Admin/navigation',$nav);
		$this->load->view('Admin/profil',$data);
		$this->load->view('foot',$foot);
	}
	public function simpanProfil($value='') {
		$id_user = $this->id_user;
		$data_post = $this->input->POST();
		if ($data_post) {
			$data = striptag($data_post);
			$table = 'tbl_user';
			$where = "id_user = $id_user";
			$updateData = $this->MasterData->editData($where,$data,$table);
			if ($updateData) {
				$sess['alert'] = alert_success('Data profil berhasil disimpan.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Admin/profil');
			} else {
				$sess['alert'] = alert_failed('Data profil gagal disimpan.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Admin/profil');
			}
		} else {
			$sess['alert'] = alert_failed('Data profil gagal disimpan.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Admin/profil');
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
		$this->load->view('Admin/head',$head);
		$this->load->view('Admin/navigation',$nav);
		$this->load->view('Admin/tarif',$data);
		$this->load->view('foot',$foot);
	}
	public function simpanTarif($value='') {
		$data_input = $this->input->POST();
		if ($data_input) {
			$input = striptag($data_input);
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
				redirect(base_url().'Admin/dataTarif');
			} else {
				$sess['alert'] = alert_failed('Data tarif gagal disimpan.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Admin/dataTarif');
			}
		} else {
			$sess['alert'] = alert_failed('Data tarif gagal disimpan.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Admin/dataTarif');
		}
		// var_dump($input);
	}
	public function updateTarif($value='') {
		$data_input = $this->input->POST();
		if ($data_input) {
			$input = striptag($data_input);
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
				redirect(base_url().'Admin/dataTarif');
			} else {
				$sess['alert'] = alert_failed('Data tarif gagal diupdate.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Admin/dataTarif');
			}
		} else {
			$sess['alert'] = alert_failed('Data tarif gagal diupdate.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Admin/dataTarif');
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
			redirect(base_url().'Admin/dataTarif');
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
			$this->load->view('Admin/head',$head);
			$this->load->view('Admin/navigation',$nav);
			$this->load->view('Admin/sub_tarif',$data);
			$this->load->view('foot',$foot);
		}
	}
	public function simpanSubTarif($id='') {
		if ($id != '') {
			$id_tarif = decode($id);
		} else {
			redirect(base_url().'Admin/dataTarif');
		}	
		$data_input = $this->input->POST();
		if ($data_input) {
			$input = striptag($data_input);
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
				redirect(base_url().'Admin/subTarif/'.encode($id_tarif));
			} else {
				$sess['alert'] = alert_failed('Data tarif gagal disimpan.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Admin/subTarif/'.encode($id_tarif));
			}
		} else {
			$sess['alert'] = alert_failed('Data tarif gagal disimpan.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Admin/subTarif/'.encode($id_tarif));
		}
		// var_dump($input);
	}
	public function updateSubTarif($id='') {
		if ($id != '') {
			$id_tarif = decode($id);
		} else {
			redirect(base_url().'Admin/dataTarif');
		}	
		$data_input = $this->input->POST();
		if ($data_input) {
			$input = striptag($data_input);
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
				redirect(base_url().'Admin/subTarif/'.encode($id_tarif));
			} else {
				$sess['alert'] = alert_failed('Data tarif gagal diupdate.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Admin/subTarif/'.encode($id_tarif));
			}
		} else {
			$sess['alert'] = alert_failed('Data tarif gagal diupdate.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Admin/subTarif/'.encode($id_tarif));
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
						redirect(base_url().'Admin/dataTarif');
					}
				}
			} else {
				echo "Failed";
				$sess['alert'] = alert_failed('Data tarif gagal dihapus.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Admin/dataTarif');
			}
		// } else {
		// 	echo "Failed";
		// 	$sess['alert'] = alert_failed('Data tarif gagal dihapus.');
		// 	$this->session->set_flashdata($sess);
		// 	redirect(base_url().'Admin/dataTarif';
		// }
	}
	public function deleteSubTarif($ids='', $id='', $no='') {
		if ($ids != '') {
			$id_tarif = decode($ids);
		} 
		// else {
		// 	redirect(base_url().'Admin/dataTarif');
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
						redirect(base_url().'Admin/subTarif/'.encode($id_tarif));
					}
				}
				// echo "Success";
				// $sess['alert'] = alert_success('Data tarif berhasil dihapus.');
				// $this->session->set_flashdata($sess);
			} else {
				echo "Failed";
				$sess['alert'] = alert_failed('Data tarif gagal dihapus.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Admin/subTarif/'.encode($id_tarif));
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
		$this->load->view('Admin/head',$head);
		$this->load->view('Admin/navigation',$nav);
		$this->load->view('Admin/akun_login',$data);
		$this->load->view('foot',$foot);
	}
	public function simpanAkun($value='') {
		$id_user = $this->id_user;
		$data_post = $this->input->POST();
		if ($data_post) {
			$post = striptag($data_post);
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
					redirect(base_url().'Admin/akunLogin');
				} else {
					$sess['alert'] = alert_failed('Data akun login gagal disimpan.');
					$this->session->set_flashdata($sess);
					redirect(base_url().'Admin/akunLogin');
				}
			} else {
				$sess['alert'] = alert_failed('Password lama tidak sesuai.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Admin/akunLogin');
			}
		} else {
			$sess['alert'] = alert_failed('Data akun login gagal disimpan.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Admin/akunLogin');
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
		$config['base_url'] = base_url().'/Admin/dataUser';
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
		$this->load->view('Admin/head',$head);
		$this->load->view('Admin/navigation',$nav);
		$this->load->view('Admin/user',$data);
		$this->load->view('foot',$foot);
	}
	public function tambahDataUser($value='') {
		$data_post = $this->input->POST();
		if ($data_post) {
			$post = striptag($data_post);
			$data = array();
			foreach ($post as $key => $val) {
				if ($key == 'password') {
					$data[$key] = md5($val);
				} else {
					$data[$key] = $val;
				}
			}
			$no_hp = $post['no_hp'];
			if ($no_hp != '' || $no_hp != null) {
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
				        // $cekID = $this->sms->query("SHOW TABLE STATUS LIKE 'outbox'")->row();
				        // $newID = $cekID->Auto_increment;
				        // $data = array(
				        //     'DestinationNumber' => $noTelp,
				        //     'TextDecoded' => $pesan,
				        //     'ID' => $newID,
				        //     'MultiPart' => 'false',
				        //     'CreatorID' => 'SiMetro'
				        // );
				        // $table = 'outbox';
						// $input_msg = $this->MasterData->sendMsg($data,$table);

						kirim_wa($noTelp, $pesan);

				        // ==========================================================
						$sess['alert'] = alert_success('Data user berhasil disimpan.');
						$this->session->set_flashdata($sess);
						redirect(base_url().'Admin/dataUser');
					} else {
						$sess['alert'] = alert_failed('Data user gagal disimpan.');
						$this->session->set_flashdata($sess);
						redirect(base_url().'Admin/dataUser');
					}
				} else {
					$sess['alert'] = alert_failed('Nomor HP sudah terdaftar.');
					$this->session->set_flashdata($sess);
					redirect(base_url().'Admin/dataUser');
				}
			} else {
				$table = 'tbl_user';
				$inputData = $this->MasterData->inputData($data,$table);
				if ($inputData) {
					$sess['alert'] = alert_success('Data user berhasil disimpan.');
					$this->session->set_flashdata($sess);
					redirect(base_url().'Admin/dataUser');
				} else {
					$sess['alert'] = alert_failed('Data user gagal disimpan.');
					$this->session->set_flashdata($sess);
					redirect(base_url().'Admin/dataUser');
				}
			}
		} else {
			$sess['alert'] = alert_failed('Data user gagal disimpan.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Admin/dataUser');
		}
	}
	public function updateDataUser($urii='') {
		$data_post = $this->input->POST();
		if ($data_post) {
			$post = striptag($data_post);
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
			        // $cekID = $this->sms->query("SHOW TABLE STATUS LIKE 'outbox'")->row();
			        // $newID = $cekID->Auto_increment;
			        // $data = array(
			        //     'DestinationNumber' => $noTelp,
			        //     'TextDecoded' => $pesan,
			        //     'ID' => $newID,
			        //     'MultiPart' => 'false',
			        //     'CreatorID' => 'SiMetro'
			        // );
			        // $table = 'outbox';
					// $input_msg = $this->MasterData->sendMsg($data,$table);
					kirim_wa($noTelp, $pesan);
			        // ===============================================================
					$sess['alert'] = alert_success('Data user berhasil diupdate.');
					$this->session->set_flashdata($sess);
					redirect(base_url().'Admin/dataUser/'.$urii);
				} else {
					$sess['alert'] = alert_failed('Data user gagal diupdate.');
					$this->session->set_flashdata($sess);
					redirect(base_url().'Admin/dataUser/'.$urii);
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
				        // $cekID = $this->sms->query("SHOW TABLE STATUS LIKE 'outbox'")->row();
				        // $newID = $cekID->Auto_increment;
				        // $data = array(
				        //     'DestinationNumber' => $noTelp,
				        //     'TextDecoded' => $pesan,
				        //     'ID' => $newID,
				        //     'MultiPart' => 'false',
				        //     'CreatorID' => 'SiMetro'
				        // );
				        // $table = 'outbox';
						// $input_msg = $this->MasterData->sendMsg($data,$table);

						kirim_wa($noTelp, $pesan);

						$sess['alert'] = alert_success('Data user berhasil diupdate.');
						$this->session->set_flashdata($sess);
						redirect(base_url().'Admin/dataUser/'.$urii);
					} else {
						$sess['alert'] = alert_failed('Data user gagal diupdate.');
						$this->session->set_flashdata($sess);
						redirect(base_url().'Admin/dataUser/'.$urii);
					}
				} else {
					$sess['alert'] = alert_failed('Nomor HP sudah terdaftar.');
					$this->session->set_flashdata($sess);
					redirect(base_url().'Admin/dataUser/'.$urii);
				}
			}
		} else {
			$sess['alert'] = alert_failed('Data user gagal diupdate.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Admin/dataUser/'.$urii);
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
			redirect(base_url().'Admin/dataUser');
		} else {
			// echo "Failed";
			$sess['alert'] = alert_failed('Data user gagal dihapus.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Admin/dataUser');
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
		$this->load->view('Admin/head',$head);
		$this->load->view('Admin/navigation',$nav);
		$this->load->view('Admin/usaha',$data);
		$this->load->view('foot',$foot);
	}
	public function simpanUsaha($uri='') {
		// $id_user = $this->id_user;
		$data_input = $this->input->POST();
		if ($data_input) {
			$input = striptag($data_input);
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
				redirect(base_url().'Admin/dataUsaha/'.encode($input['id_user']).'/'.encode($uri));
			} else {
				$sess['alert'] = alert_failed('Data usaha gagal disimpan.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Admin/dataUsaha/'.encode($input['id_user']).'/'.encode($uri));
			}
		} else {
			$sess['alert'] = alert_failed('Data usaha gagal disimpan.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Admin/dataUsaha/'.encode($input['id_user']).'/'.encode($uri));
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
		$data_input = $this->input->POST();
		if ($data_input) {
			$input = striptag($data_input);
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
				redirect(base_url().'Admin/dataUsaha/'.encode($input['id_user']).'/'.encode($uri));
			} else {
				$sess['alert'] = alert_failed('Data usaha gagal diupdate.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Admin/dataUsaha/'.encode($input['id_user']).'/'.encode($uri));
			}
		} else {
			$sess['alert'] = alert_failed('Data usaha gagal diupdate.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Admin/dataUsaha/'.encode($input['id_user']).'/'.encode($uri));
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
	public function dataUttp($id='', $id_usr='', $uri=''){
		if ($id_usr != '') {
			$id_user = decode($id_usr);
		}
		// $select = array(
		// 	'ush.*',
		// 	"(SELECT jns.nama_jenis_usaha FROM tbl_jenis_usaha jns WHERE jns.id_jenis_usaha = ush.id_jenis_usaha) jenis_usaha"
		// );
		// $table = "tbl_usaha ush";
		// $where = "ush.id_user = '$id_user'";
		// $by = 'ush.id_usaha';
		// $order = 'DESC';
		// $dataUsaha = $this->MasterData->getWhereDataOrder($select,$table,$where,$by,$order)->result();
		if ($id != '') {
			$id_usaha = decode($id);
		}
		if ($uri != '') {
			$urii = decode($uri);
		} else {
			$urii = $uri;
		}
		$select = array(
			'uttp.*',
			"(SELECT alat.nama_jenis_alat FROM tbl_jenis_alat_ukur alat WHERE alat.id_jenis_alat = uttp.id_jenis_alat) jenis_alat"
		);
		$table = "tbl_uttp uttp";
		$where = "uttp.id_usaha = '$id_usaha'";
		$by = 'uttp.id_uttp';
		$order = 'DESC';
		$dataUttp = $this->MasterData->getWhereDataOrder($select,$table,$where,$by,$order)->result();
		$dataJenisAlat = $this->MasterData->getData('tbl_jenis_alat_ukur')->result();
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
			'dataUttp' => $dataUttp,
			// 'dataUsaha' => $dataUsaha,
			'selectUsaha' => $id_usaha,
			'dataJenisAlat' => $dataJenisAlat,
			'uri' => $urii,
			'idUser' => $id_user
		);
		$this->load->view('Admin/head',$head);
		$this->load->view('Admin/navigation',$nav);
		$this->load->view('Admin/uttp',$data);
		$this->load->view('foot',$foot);
	}
	public function updateUttp($id='', $id_usr='', $uri=''){
		$data_post = $this->input->POST();
		if ($data_post) {
			$data = striptag($data_post);
			$table = 'tbl_uttp';
			$where = "id_uttp = $data[id_uttp]";
			$updateData = $this->MasterData->editData($where,$data,$table);
			if ($updateData) {
				$sess['alert'] = alert_success('Data UTTP berhasil diupdate.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Admin/dataUttp/'.$id.'/'.$id_usr.'/'.$uri);
			} else {
				$sess['alert'] = alert_failed('Data UTTP gagal diupdate.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Admin/dataUttp/'.$id.'/'.$id_usr.'/'.$uri);
			}
		} else {
			$sess['alert'] = alert_failed('Data UTTP gagal diupdate.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Admin/dataUttp/'.$id.'/'.$id_usr.'/'.$uri);
		}
	}
	public function deleteUttp(){
		if ($this->input->POST()) {
			$id = $this->input->POST('id');
			$where = "id_uttp = '$id'";
			$table = 'tbl_uttp';
			$delete = $this->MasterData->deleteData($where,$table);
			if ($delete) {
				echo "Success";
				$sess['alert'] = alert_success('Data UTTP berhasil dihapus.');
				$this->session->set_flashdata($sess);
			} else {
				echo "Failed";
				$sess['alert'] = alert_failed('Data UTTP gagal dihapus.');
				$this->session->set_flashdata($sess);
			}
		} else {
			echo "Failed";
			$sess['alert'] = alert_failed('Data UTTP gagal dihapus.');
			$this->session->set_flashdata($sess);
		}
	}
	public function simpanUttp($id='', $id_usr='', $uri=''){
		$data_post = $this->input->POST();
		if ($data_post) {
			$data = striptag($data_post);
			$table = 'tbl_uttp';
			$inputData = $this->MasterData->inputData($data,$table);
			if ($inputData) {
				$sess['alert'] = alert_success('Data UTTP berhasil disimpan.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Admin/dataUttp/'.$id.'/'.$id_usr.'/'.$uri);
			} else {
				$sess['alert'] = alert_failed('Data UTTP gagal disimpan.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Admin/dataUttp/'.$id.'/'.$id_usr.'/'.$uri);
			}
		} else {
			$sess['alert'] = alert_failed('Data UTTP gagal disimpan.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Admin/dataUttp/'.$id.'/'.$id_usr.'/'.$uri);
		}
	}
	// =====================================================
	public function dataPetugas($value='') {
		$select = array(
			'usr.*',
			"(SELECT jbt.nama_jabatan FROM tbl_jabatan jbt WHERE jbt.id_jabatan = (SELECT pt.id_jabatan FROM tbl_petugas pt WHERE pt.id_user = usr.id_user)) jabatan",
			"(SELECT pt.id_jabatan FROM tbl_petugas pt WHERE pt.id_user = usr.id_user) id_jabatan",
			"(SELECT pt.nip FROM tbl_petugas pt WHERE pt.id_user = usr.id_user) nip",
			"(SELECT pt.golongan FROM tbl_petugas pt WHERE pt.id_user = usr.id_user) golongan"
		);
		$table = 'tbl_user usr';
		$where = "id_user IN (SELECT pt.id_user FROM tbl_petugas pt)";
		$by = 'id_user';
		$order = 'DESC';
		$dataUser = $this->MasterData->getWhereDataOrder($select,$table,$where,$by,$order)->result();
		$where = "nama_role = 'Admin'";
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
		$this->load->view('Admin/head',$head);
		$this->load->view('Admin/navigation',$nav);
		$this->load->view('Admin/petugas',$data);
		$this->load->view('foot',$foot);
	}
	public function tambahDataPetugas($value='') {
		$data_post = $this->input->POST();
		if ($data_post) {
			$post = striptag($data_post);
			$data = array();
			foreach ($post as $key => $val) {
				if ($key != 'jabatan') {
					if ($key != 'golongan') {
						if ($key != 'nip') {
							if ($key == 'password') {
								$data[$key] = md5($val);
							} else {
								$data[$key] = $val;
							}
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
						'golongan' => $post['golongan'],
						'nip' => $post['nip']
					);
					$inputPetugas = $this->MasterData->inputData($data,'tbl_petugas');
					$select = 'nama_role';
					$where = "id_role = '$post[id_role]'";
					$namaRole = $this->MasterData->getWhereData($select,'tbl_role',$where)->row()->nama_role;
					$noTelp = $no_hp;
					$pesan = "Akun SiMetro Anda\nNama User: ".$post['nama_user']."\nUsername: ".$post['username']."\nPassword: ".$post['password']."\n\nAnda terdaftar sebagai ".strtoupper($namaRole);
			        // $cekID = $this->sms->query("SHOW TABLE STATUS LIKE 'outbox'")->row();
			        // $newID = $cekID->Auto_increment;
			        // $data = array(
			        //     'DestinationNumber' => $noTelp,
			        //     'TextDecoded' => $pesan,
			        //     'ID' => $newID,
			        //     'MultiPart' => 'false',
			        //     'CreatorID' => 'SiMetro'
			        // );
			        // $table = 'outbox';
					// $input_msg = $this->MasterData->sendMsg($data,$table);
					kirim_wa($noTelp, $pesan);

					if ($inputPetugas) {
						$sess['alert'] = alert_success('Data petugas berhasil disimpan.');
						$this->session->set_flashdata($sess);
						redirect(base_url().'Admin/dataPetugas');
					} else {
						$sess['alert'] = alert_failed('Data petugas gagal disimpan.');
						$this->session->set_flashdata($sess);
						redirect(base_url().'Admin/dataPetugas');
					}
				} else {
					$sess['alert'] = alert_failed('Data petugas gagal disimpan.');
					$this->session->set_flashdata($sess);
					redirect(base_url().'Admin/dataPetugas');
				}
			} else {
				$sess['alert'] = alert_failed('Nomor HP sudah terdaftar.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Admin/dataPetugas');
			}
		} else {
			$sess['alert'] = alert_failed('Data petugas gagal disimpan.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Admin/dataPetugas');
		}
	}
	public function updateDataPetugas($value='') {
		$data_post = $this->input->POST();
		if ($data_post) {
			$post = striptag($data_post);
			$data = array();
			$newPass = '';
			foreach ($post as $key => $val) {
				if ($key != 'jabatan') {
					if ($key != 'golongan') {
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
						'golongan' => $post['golongan'],
						'nip' => $post['nip']
					);
					$updatePetugas = $this->MasterData->MasterData->editData($where,$datas,'tbl_petugas');
					$select = 'nama_role';
					$where = "id_role = '$post[id_role]'";
					$namaRole = $this->MasterData->getWhereData($select,'tbl_role',$where)->row()->nama_role;
					$noTelp = $no_hp;
					$pesan = "Akun SiMetro Anda\nNama User: ".$post['nama_user']."\nUsername: ".$post['username']."\nPassword: ".$newPass."\n\nAnda terdaftar sebagai ".strtoupper($namaRole);
			        // $cekID = $this->sms->query("SHOW TABLE STATUS LIKE 'outbox'")->row();
			        // $newID = $cekID->Auto_increment;
			        // $data = array(
			        //     'DestinationNumber' => $noTelp,
			        //     'TextDecoded' => $pesan,
			        //     'ID' => $newID,
			        //     'MultiPart' => 'false',
			        //     'CreatorID' => 'SiMetro'
			        // );
			        // $table = 'outbox';
					// $input_msg = $this->MasterData->sendMsg($data,$table);
					
					kirim_wa($noTelp, $pesan);

					if ($updatePetugas) {
						$sess['alert'] = alert_success('Data petugas berhasil diupdate.');
						$this->session->set_flashdata($sess);
						redirect(base_url().'Admin/dataPetugas');
					} else {
						$sess['alert'] = alert_failed('Data petugas gagal diupdate.');
						$this->session->set_flashdata($sess);
						redirect(base_url().'Admin/dataPetugas');
					}
				} else {
					$sess['alert'] = alert_failed('Data petugas gagal diupdate.');
					$this->session->set_flashdata($sess);
					redirect(base_url().'Admin/dataPetugas');
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
				        // $cekID = $this->sms->query("SHOW TABLE STATUS LIKE 'outbox'")->row();
				        // $newID = $cekID->Auto_increment;
				        // $data = array(
				        //     'DestinationNumber' => $noTelp,
				        //     'TextDecoded' => $pesan,
				        //     'ID' => $newID,
				        //     'MultiPart' => 'false',
				        //     'CreatorID' => 'SiMetro'
				        // );
				        // $table = 'outbox';
						// $input_msg = $this->MasterData->sendMsg($data,$table);
						
						kirim_wa($noTelp, $pesan);

						if ($updatePetugas) {
							$sess['alert'] = alert_success('Data petugas berhasil diupdate.');
							$this->session->set_flashdata($sess);
							redirect(base_url().'Admin/dataPetugas');
						} else {
							$sess['alert'] = alert_failed('Data petugas gagal diupdate.');
							$this->session->set_flashdata($sess);
							redirect(base_url().'Admin/dataPetugas');
						}
					} else {
						$sess['alert'] = alert_failed('Data petugas gagal diupdate.');
						$this->session->set_flashdata($sess);
						redirect(base_url().'Admin/dataPetugas');
					}
				} else {
					$sess['alert'] = alert_failed('Nomor HP sudah terdaftar.');
					$this->session->set_flashdata($sess);
					redirect(base_url().'Admin/dataPetugas');
				}
			}
		} else {
			$sess['alert'] = alert_failed('Data petugas gagal diupdate.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Admin/dataPetugas');
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
			redirect(base_url().'Admin/dataPetugas');
		} else {
			// echo "Failed";
			$sess['alert'] = alert_failed('Data petugas gagal dihapus.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Admin/dataPetugas');
		}
	}
	// =====================================================
	public function dataJabatan($value='') {
		$select = array(
			'jb.*'
		);
		$table = 'tbl_jabatan jb';
		$by = 'id_jabatan';
		$order = 'DESC';
		$dataJabatan = $this->MasterData->getSelectDataOrder($select,$table,$by,$order)->result();
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
		$nav['menu'] = 'jabatan';
		$data = array(
			'data_jabatan' => $dataJabatan,
		);
		$this->load->view('Admin/head',$head);
		$this->load->view('Admin/navigation',$nav);
		$this->load->view('Admin/jabatan',$data);
		$this->load->view('foot',$foot);
	}
	public function tambahDataJabatan($value='') {
		$data_input = $this->input->POST();
		if ($data_input) {
			$data = striptag($data_input);
			$insert = $this->MasterData->inputData($data,'tbl_jabatan');
			if ($insert) {
				$sess['alert'] = alert_success('Data jabatan berhasil disimpan.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Admin/dataJabatan');
			} else {
				$sess['alert'] = alert_failed('Data jabatan gagal disimpan.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Admin/dataJabatan');
			}
		}
	}
	public function updateDataJabatan($value='') {
		$data_input = $this->input->POST();
		if ($data_input) {
			$input = striptag($data_input);
			$where = "id_jabatan = $input[id_jabatan]";
			$update = $this->MasterData->editData($where,$input,'tbl_jabatan');
			if ($update) {
				$sess['alert'] = alert_success('Data jabatan berhasil diupdate.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Admin/dataJabatan');
			} else {
				$sess['alert'] = alert_failed('Data jabatan gagal diupdate.');
				$this->session->set_flashdata($sess);
				redirect(base_url().'Admin/dataJabatan');
			}
		} else {
			$sess['alert'] = alert_failed('Data jabatan gagal diupdate.');
			$this->session->set_flashdata($sess);
			redirect(base_url().'Admin/dataJabatan');
		}
	}
	public function deleteDataJabatan($id='') {
		$id = $this->input->POST('id');
		if ($id) {
			$where = "id_jabatan = $id";
			$delete = $this->MasterData->deleteData($where,'tbl_jabatan');
			if ($delete) {
				echo "Success";
				$sess['alert'] = alert_success('Data jabatan berhasil dihapus.');
				$this->session->set_flashdata($sess);
				// redirect(base_url().'Admin/jenisAlat');
			} else {
				echo 'Failed';
				$sess['alert'] = alert_failed('Data jabatan gagal dihapus.');
				$this->session->set_flashdata($sess);
				// redirect(base_url().'Admin/jenisAlat');
			}
		} else {
			echo 'Failed';
			$sess['alert'] = alert_failed('Data jabatan gagal dihapus.');
			$this->session->set_flashdata($sess);
			// redirect(base_url().'Admin/jenisAlat');
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

	public function getDataUserGrupPasar($id_pasar='') {
		$input = $_GET['term'];
		$select = array(
			'usr.*'
		);
		$table = 'tbl_user_pasar usr';
		$field = 'usr.nama_user';
		$keyword = $input;
		$limit = 10;
		$where = "id_pasar = $id_pasar";
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
                    'id' => $usr->id_user_pasar,
                    'label' => $label
                );
                // $result[] =  $usr->nama_user.' '.$usr->alamat_user.'-'.$usr->id_user;
			}
			echo json_encode($result);
		} 
	}

	public function getDataUserPasar($value='') {
		$id_user_pasar = $this->input->POST('id_user_pasar');

		if ($id_user_pasar) {
			$where = "id_user_pasar = $id_user_pasar";
			$data = $this->MasterData->getDataWhere('tbl_user_pasar',$where)->row();

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

	public function getDataTarifPasar($value='') {
		$id_jenis_alat = $this->input->POST('id_jenis_alat');

		if ($id_jenis_alat) {
			$where = "id_jenis_alat = $id_jenis_alat";
			$dataJenisAlat = $this->MasterData->getDataWhere('tbl_jenis_alat_ukur',$where)->row();

			$jns_alat = $dataJenisAlat->nama_jenis_alat;
			$id_tarif = array();
			if ($jns_alat == 'Timbangan Meja') {
				$id_tarif[] = 169;
			} else if ($jns_alat == 'Timbangan Sentisimal') {
				$id_tarif[] = 166;
			} else if ($jns_alat == 'Dacin Logam') {
				$id_tarif[] = 165;
			} else if ($jns_alat == 'Timbangan Pegas') {
				$id_tarif[] = 170;
			} else if ($jns_alat == 'Timbangan Digital') {
				$id_tarif[] = 172;
				$id_tarif[] = 173;
				$id_tarif[] = 174;
			} else if ($jns_alat == 'Neraca') {
				$id_tarif[] = 164; 
			} else if ($jns_alat == 'Anak Timbangan') {
				$id_tarif[] = 22; 
			}

			$select = array(
				'trf.*'
			);
			$table = 'tbl_tarif trf';
			$by = 'trf.id_tarif';
			$order = 'ASC';

			$dataHead = array();
			$dataArr = array();
			$jmlArr = count($id_tarif);
			foreach ($id_tarif as $id) {
				$where = "id_tarif = $id";
				$dataTrf = $this->MasterData->getWhereData($select,$table,$where)->row();
				$child_id = $dataTrf->child_id;
				$jenis_tarif = $dataTrf->jenis_tarif;
				$dataHead[] = $jenis_tarif;

				if ($child_id == 0) {
					$where = "id_tarif = $id";
				} else {
					$where = "parent_id = $id";
				}
				$kelompokTarif = $this->MasterData->getWhereDataOrder($select,$table,$where,$by,$order)->result();

				foreach ($kelompokTarif as $trf) {

					$dataArr[] = array(
						'head' => $jenis_tarif,
						'id_tarif' => $trf->id_tarif,
						'jenis_tarif' => $trf->jenis_tarif,
						'parent_id' => $trf->parent_id,
						'child_id' => $trf->child_id,
						'satuan' => $trf->satuan,
						'tera_kantor' => $trf->tera_kantor,
						'tera_tempat_pakai' => $trf->tera_tempat_pakai,
						'tera_ulang_kantor' => $trf->tera_ulang_kantor,
						'tera_ulang_tempat_pakai' => $trf->tera_ulang_tempat_pakai
					);
				}
			}
			
			if ($dataArr != null) {
				$result = array(
					'response' => true,
					'data' => $dataArr,
					'head' => $dataHead,
					'jmlArr' => $jmlArr
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
	// ========================================================
	// BACKEND HOME
	// ========================================================
	public function carousel() {
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
	    $script = [
	      "$('#myTablees').DataTable();",
	      "$(document).ready(function() {
	        $('.dropify').dropify({
	          messages: {
	            'default': '<center>Seret gambar di sini.</center>',
	            'error': 'Ooops, something wrong happended.'
	          }
	        });
	      });",
	    ];
	    $head['head'] = $this->head;
	    $foot = [
				'foot'    => $this->foot,
				'script'  => $script,
	    ];
	    $nav['menu'] = 'carousel';
	    $data = [
	      'carousels' => $this->MasterData->getData('carousel_image'),
	    ];
	    $this->load->view('Admin/head',$head);
	    $this->load->view('Admin/navigation', $nav);
	    $this->load->view('Admin/back_home/v_image_carousel', $data);
	    $this->load->view('foot', $foot);
  	}
	public function save_add_carousel() {
		$data_post = $this->input->POST();
		$post = striptag($data_post);
	    $title  = $post['title'];
	    if (!empty($_FILES['image']['name'])) {
	      $upload = $this->_do_upload(null, 'carousel_image');
	      $image = $upload;
	    }
	    $query = $this->MasterData->inputData([
	      'title' => $title,
	      'image' => $image,
	    ], 'carousel_image');
	    if ($query) {
	      $sess['alert'] = alert_success('Data berhasil ditambahkan.');
	      $this->session->set_flashdata($sess);
	      ?>
	        <script>
	          window.location = "<?= base_url('Admin/carousel'); ?>";
	        </script>
	      <?php
	          } else {
	            $sess['alert'] = alert_failed('Tambah data gagal.');
	            $this->session->set_flashdata($sess);
	            ?>
	        <script>
	          window.location = "<?= base_url('Admin/carousel'); ?>";
	        </script>
	      <?php
	    }
	}
	public function save_edit_carousel() {
	    $data_post = $this->input->POST();
		$post = striptag($data_post);
	    $id_image_carousel = $post['id_image_carousel'];
	    $title = $post['title'];
	    if (!empty($_FILES['image']['name'])) {
	      $upload = $this->_do_upload(null, 'carousel_image');
	      $filename = $post['old_image'];
	      unlink(FCPATH . "assets/frontend/carousel_image/$filename");
	      $image = $upload;
	    }
	    else
	    {
	      $image = $post['old_image'];
	    }
	    $query = $this->MasterData->editData(
	      [
	        'id_image_carousel'=>$id_image_carousel
	      ], 
	      [
	        'title' => $title,
	        'image' => $image
	      ], 
	      'carousel_image'
	    );
	    if ($query) {
	      $sess['alert'] = alert_success('Data berhasil diupdate.');
	      $this->session->set_flashdata($sess);
	      ?>
	        <script>
	          window.location = "<?= base_url('Admin/carousel'); ?>";
	        </script>
	      <?php
	          } else {
	            $sess['alert'] = alert_failed('Update data gagal.');
	            $this->session->set_flashdata($sess);
	            ?>
	        <script>
	          window.location = "<?= base_url('Admin/carousel'); ?>";
	        </script>
	      <?php
	    }
	}
	public function delete_carousel($id_image_carousel, $image) {
	    $query = $this->MasterData->deleteData(['id_image_carousel'=>$id_image_carousel], 'carousel_image');
	    if ($query) {
	      unlink(FCPATH . "assets/frontend/carousel_image/$image");
	      $sess['alert'] = alert_success('Data berhasil dihapus.');
	      $this->session->set_flashdata($sess);
	      ?>
	        <script>
	          window.location = "<?= base_url('Admin/carousel'); ?>";
	        </script>
	      <?php
	          } else {
	            $sess['alert'] = alert_failed('Hapus data gagal.');
	            $this->session->set_flashdata($sess);
	            ?>
	        <script>
	          window.location = "<?= base_url('Admin/carousel'); ?>";
	        </script>
	      <?php
	    }
	}
	// ============================================
	private function _do_upload($url=null, $path=null) {
	    $config['upload_path']     = './assets/frontend/'.$path;
	    $config['allowed_types']   = 'jpeg|jpg|png';
	    // $config['max_size']        = 2048;
	    $config['file_name']       = round(microtime(true) * 1000);
	    $this->load->library('upload', $config);
	    if (!$this->upload->do_upload('image')) {
	      $sess['alert'] = alert_failed('Update data gagal.');
	      $this->session->set_flashdata($sess);
	      ?>
	        <script>
	          window.location = "<?= base_url('Admin/'.$url); ?>";
	        </script>
	      <?php
	    }
	    return $this->upload->data('file_name');
	}
	public function profile() {
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
	    $css_link = [
	      "http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css",
	    ];
	    $js_link = [
	      "http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.js",
	    ];
	    $script = [
	      "$('#myTablees').DataTable();",
	    ];
	    $head = [
	      'head'  => $this->head,
	      'css_link' => $css_link,
	    ];
	    $foot = [
				'foot'    => $this->foot,
	      'script'  => $script,
	      'js_link' => $js_link,
	    ];
	    $nav['menu'] = 'profile';
	    $data = [
	      'profiles' => $this->MasterData->getData('profile')->row(),
	    ];
	    $this->load->view('Admin/head',$head);
	    $this->load->view('Admin/navigation', $nav);
	    $this->load->view('Admin/back_home/v_profile', $data);
	    $this->load->view('foot', $foot);
	}
	public function edit_profile($id_profile) {
	    $css_link = [
	      "http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css",
	    ];
	    $js_link = [
	      "http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.js",
	    ];
	    $script = [
	      "$(document).ready(function() {
	          $('.summernote').summernote();
	      });"
	    ];
	    $head = [
	      'head'  => $this->head,
	      'css_link' => $css_link,
	    ];
	    $foot = [
				'foot'    => $this->foot,
	      'js_link' => $js_link,
	      'script'  => $script,
	    ];
	    $nav['menu'] = 'profile';
	    $data = [
	      'profile' => $this->MasterData->getDataWhere('profile', ['id_profile'=>$id_profile])->row(),
	    ];
	    $this->load->view('Admin/head',$head);
	    $this->load->view('Admin/navigation', $nav);
	    $this->load->view('Admin/back_home/v_edit_profile', $data);
	    $this->load->view('foot', $foot);
	}
	public function save_edit_profile() {
	    $data_post = $this->input->POST();
		$post = striptag($data_post);
	    $id_profile = $post['id_profile'];
	    $profile  = $post['profile'];
	    $visi     = $post['visi'];
	    $misi     = $post['misi'];
	    $query = $this->MasterData->editData(
	      ['id_profile'=>$id_profile],
	      [
	        'profile' => $profile,
	        'visi'    => $visi,
	        'misi'    => $misi,
	      ], 'profile'
	    );
	    if ($query) {
	      $sess['alert'] = alert_success('Data berhasil diedit.');
	      $this->session->set_flashdata($sess);
	      ?>
	        <script>
	          window.location = "<?= base_url('Admin/profile'); ?>";
	        </script>
	      <?php
	          } else {
	            $sess['alert'] = alert_failed('Update data gagal.');
	            $this->session->set_flashdata($sess);
	            ?>
	        <script>
	          window.location = "<?= base_url('Admin/profile'); ?>";
	        </script>
	      <?php
	    }
	}
	// =================================================
	public function berita() {
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
	    $script = [
	      "$('#myTablees').DataTable();",
	      "$(document).ready(function() {
	        $('.dropify').dropify({
	          messages: {
	            'default': '<center>Seret gambar di sini.</center>',
	            'error': 'Ooops, something wrong happended.'
	          }
	        });
	      });",
	    ];
	    $head['head'] = $this->head;
	    $foot = [
				'foot'    => $this->foot,
				'script'  => $script,
	    ];
	    $nav['menu'] = 'berita';
	    $data = [
	      'beritas' => $this->MasterData->getSelectDataOrder('*','berita','id_berita','DESC'),
	    ];
	    $this->load->view('Admin/head',$head);
	    $this->load->view('Admin/navigation', $nav);
	    $this->load->view('Admin/back_home/v_berita', $data);
	    $this->load->view('foot', $foot);
	}
	public function add_berita() {
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
	    $css_link = [
	      "http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css",
	    ];
	    $js_link = [
	      "http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.js",
	    ];
	    $script = [
	      "$(document).ready(function() {
	          $('.summernote').summernote({
	            height: 150,
	          });
	      });",
	      // "$('#mdate').bootstrapMaterialDatePicker({ weekStart: 0, time: false });",
	      "$('#mdate').datepicker({ format: 'dd-mm-yyyy', autoclose:true });",
	      "$(document).ready(function() {
	        $('.dropify').dropify({
	          messages: {
	            'default': '<center>Seret gambar di sini.</center>',
	            'error': 'Ooops, something wrong happended.'
	          }
	        });
	      });",
	    ];
	    $head = [
	      'head'  => $this->head,
	      'css_link' => $css_link,
	    ];
	    $foot = [
				'foot'    => $this->foot,
	      'js_link' => $js_link,
	      'script'  => $script,
	    ];
	    $nav['menu'] = 'berita';
	    $data = [
	      'berita' => 'berita',
	    ];
	    $this->load->view('Admin/head',$head);
	    $this->load->view('Admin/navigation', $nav);
	    $this->load->view('Admin/back_home/v_add_berita', $data);
	    $this->load->view('foot', $foot);
	}
	public function edit_berita($id_berita) {
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
	    $css_link = [
	      "http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css",
	    ];
	    $js_link = [
	      "http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.js",
	    ];
	    $script = [
	      "$(document).ready(function() {
	          $('.summernote').summernote({
	            height: 200,
	          });
	      });",
	      // "$('#mdate').bootstrapMaterialDatePicker({ weekStart: 0, time: false });",
	      "$('#mdate').datepicker({ format: 'dd-mm-yyyy', autoclose:true });",
	      "$(document).ready(function() {
	        $('.dropify').dropify({
	          messages: {
	            'default': '<center>Seret gambar di sini.</center>',
	            'error': 'Ooops, something wrong happended.'
	          }
	        });
	      });",
	      // "$(document).ready( function () {
       //          $('#mdate').datepicker('setDate', '".date('d-m-Y')."'); 
       //      });"
	    ];
	    $head = [
	      'head'  => $this->head,
	      'css_link' => $css_link,
	    ];
	    $foot = [
				'foot'    => $this->foot,
	      'js_link' => $js_link,
	      'script'  => $script,
	    ];
	    $nav['menu'] = 'berita';
	    $data = [
	      'berita' => $this->MasterData->getDataWhere('berita', ['id_berita'=>$id_berita])->row(),
	    ];
	    $this->load->view('Admin/head',$head);
	    $this->load->view('Admin/navigation', $nav);
	    $this->load->view('Admin/back_home/v_edit_berita', $data);
	    $this->load->view('foot', $foot);
	}
	public function save_add_berita() {
	    $data_post = $this->input->POST();
		$post = striptag($data_post);
	    $judul    = $post['judul'];
	    $tanggal  = date('Y-m-d', strtotime($post['tanggal']));
	    $berita   = $post['berita'];
	    if (!empty($_FILES['image']['name'])) {
	      $upload = $this->_do_upload('add_berita', 'berita_image');
	      $image = $upload;
	    }
	    $query = $this->MasterData->inputData([
	      'judul'   => $judul,
	      'tanggal' => $tanggal,
	      'berita'  => $berita,
	      'image'   => $image,
	    ], 'berita');
	    if ($query) {
	      $sess['alert'] = alert_success('Data berhasil ditambahkan.');
	      $this->session->set_flashdata($sess);
	      ?>
	        <script>
	          window.location = "<?= base_url('Admin/berita'); ?>";
	        </script>
	      <?php
	          } else {
	            $sess['alert'] = alert_failed('Tambah data gagal.');
	            $this->session->set_flashdata($sess);
	            ?>
	        <script>
	          window.location = "<?= base_url('Admin/berita'); ?>";
	        </script>
	      <?php
	    }
	}
	public function save_edit_berita() {
	    $data_post = $this->input->POST();
		$post = striptag($data_post);
	    $id_berita= $post['id_berita'];
	    $judul    = $post['judul'];
	    $tanggal  = date('Y-m-d', strtotime($post['tanggal']));
	    $berita   = $post['berita'];
	    if (!empty($_FILES['image']['name'])) {
	      $upload = $this->_do_upload('berita', 'berita_image');
	      $filename = $post['old_image'];
	      unlink(FCPATH . "assets/frontend/berita_image/$filename");
	      $image = $upload;
	    }
	    else
	    {
	      $image = $post['old_image'];
	    }
	    $query = $this->MasterData->editData(
	      [
	        'id_berita'=>$id_berita
	      ], 
	      [
	        'judul'   => $judul,
	        'tanggal' => $tanggal,
	        'berita'  => $berita,
	        'image'   => $image,
	      ], 
	      'berita'
	    );
	    if ($query) {
	      $sess['alert'] = alert_success('Data berhasil diupdate.');
	      $this->session->set_flashdata($sess);
	      ?>
	        <script>
	          window.location = "<?= base_url('Admin/berita'); ?>";
	        </script>
	      <?php
	          } else {
	            $sess['alert'] = alert_failed('Update data gagal.');
	            $this->session->set_flashdata($sess);
	            ?>
	        <script>
	          window.location = "<?= base_url('Admin/berita'); ?>";
	        </script>
	      <?php
	    }
	}
	public function delete_berita($id_berita, $image) {
	    $query = $this->MasterData->deleteData(['id_berita'=>$id_berita], 'berita');
	    if ($query) {
	      unlink(FCPATH . "assets/frontend/berita_image/$image");
	      $sess['alert'] = alert_success('Data berhasil dihapus.');
	      $this->session->set_flashdata($sess);
	      ?>
	        <script>
	          window.location = "<?= base_url('Admin/berita'); ?>";
	        </script>
	      <?php
	          } else {
	            $sess['alert'] = alert_failed('Hapus data gagal.');
	            $this->session->set_flashdata($sess);
	            ?>
	        <script>
	          window.location = "<?= base_url('Admin/berita'); ?>";
	        </script>
	      <?php
	    }
	}
	// ====================================================
	public function pengumuman() {  
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
		$css_link = [
	      "http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css",
	    ];
	    $js_link = [
	      "http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.js",
	    ];
	    $script = [
	      "$(document).ready(function() {
	          $('.summernote').summernote({
	            height: 200,
	            placeholder: 'Isi pengumuman...',
	          });
	      });",
	      // "$('.mdate').bootstrapMaterialDatePicker({ format: 'DD-mm-YYYY', weekStart: 0, time: false });",
	      "$('.mdate').datepicker({ format: 'dd-mm-yyyy', autoclose:true });",
	      "$(document).ready(function() {
	        $('.dropify').dropify({
	          messages: {
	            'default': '<center>Seret gambar di sini.</center>',
	            'error': 'Ooops, something wrong happended.'
	          }
	        });
	      });",
	    ];		
	    $head = [
	      'head'  => $this->head,
	      'css_link' => $css_link,
	    ];
	    $foot = [
			'foot'    => $this->foot,
	      	'js_link' => $js_link,
	      	'script'  => $script,
	    ];
	    $nav['menu'] = 'pengumuman';
	    $data = [
	      'pengumumans' => $this->MasterData->getSelectDataOrder('*', 'pengumuman', 'tanggal', 'desc'),
	    ];
	    $this->load->view('Admin/head',$head);
	    $this->load->view('Admin/navigation', $nav);
	    $this->load->view('Admin/back_home/v_pengumuman', $data);
	    $this->load->view('foot', $foot);
	}
	public function save_add_pengumuman() {
	    $data_post = $this->input->POST();
		$post = striptag($data_post);
	    $tanggal  = date('Y-m-d', strtotime($post['tanggal']));
	    $pengumuman = $post['pengumuman'];
	    $query = $this->MasterData->inputData([
	      'tanggal'   => $tanggal,
	      'pengumuman' => $pengumuman,
	    ], 'pengumuman');
	    if ($query) {
	      $sess['alert'] = alert_success('Data berhasil ditambahkan.');
	      $this->session->set_flashdata($sess);
	      ?>
	        <script>
	          window.location = "<?= base_url('Admin/pengumuman'); ?>";
	        </script>
	      <?php
	          } else {
	            $sess['alert'] = alert_failed('Tambah data gagal.');
	            $this->session->set_flashdata($sess);
	            ?>
	        <script>
	          window.location = "<?= base_url('Admin/pengumuman'); ?>";
	        </script>
	      <?php
	    }
	}
	public function save_edit_pengumuman() {
	    $data_post = $this->input->POST();
		$post = striptag($data_post);
	    $id_pengumuman  = $post['id_pengumuman'];
	    $tanggal        = date('Y-m-d', strtotime($post['tanggal']));
	    $pengumuman     = $post['pengumuman'];
	    $query = $this->MasterData->editData(
	      [
	        'id_pengumuman'=>$id_pengumuman
	      ], 
	      [
	        'tanggal'     => $tanggal,
	        'pengumuman'  => $pengumuman,
	      ], 'pengumuman'
	    );
	    if ($query) {
	      $sess['alert'] = alert_success('Data berhasil diedit.');
	      $this->session->set_flashdata($sess);
	      ?>
	        <script>
	          window.location = "<?= base_url('Admin/pengumuman'); ?>";
	        </script>
	      <?php
	          } else {
	            $sess['alert'] = alert_failed('Edit data gagal.');
	            $this->session->set_flashdata($sess);
	            ?>
	        <script>
	          window.location = "<?= base_url('Admin/pengumuman'); ?>";
	        </script>
	      <?php
	    }
	}
	public function delete_pengumuman($id_pengumuman) {
	    $query = $this->MasterData->deleteData(['id_pengumuman'=>$id_pengumuman], 'pengumuman');
	    if ($query) {
	      $sess['alert'] = alert_success('Data berhasil dihapus.');
	      $this->session->set_flashdata($sess);
	      ?>
	        <script>
	          window.location = "<?= base_url('Admin/pengumuman'); ?>";
	        </script>
	      <?php
	          } else {
	            $sess['alert'] = alert_failed('Hapus data gagal.');
	            $this->session->set_flashdata($sess);
	            ?>
	        <script>
	          window.location = "<?= base_url('Admin/pengumuman'); ?>";
	        </script>
	      <?php
	    }
	}
	// ==================================================
	public function maklumat() {
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
	    $css_link = [
	      "http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css",
	    ];
	    $js_link = [
	      "http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.js",
	    ];
	    $script = [
	      "$('#myTablees').DataTable();",
	    ];
	    $head = [
	      'head'  => $this->head,
	      'css_link' => $css_link,
	    ];
	    $foot = [
		'foot'    => $this->foot,
	      'script'  => $script,
	      'js_link' => $js_link,
	    ];
	    $nav['menu'] = 'maklumat';
	    $data = [
	      'maklumats' => $this->MasterData->getData('maklumat')->row(),
	    ];
	    $this->load->view('Admin/head',$head);
	    $this->load->view('Admin/navigation', $nav);
	    $this->load->view('Admin/back_home/v_maklumat', $data);
	    $this->load->view('foot', $foot);
	}
	public function edit_maklumat($id_maklumat) {
	    $css_link = [
	      "http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css",
	    ];
	    $js_link = [
	      "http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.js",
	    ];
	    $script = [
	      "$(document).ready(function() {
	          $('.summernote').summernote();
	      });"
	    ];
	    $head = [
	      'head'  => $this->head,
	      'css_link' => $css_link,
	    ];
	    $foot = [
				'foot'    => $this->foot,
	      'js_link' => $js_link,
	      'script'  => $script,
	    ];
	    $nav['menu'] = 'maklumat';
	    $data = [
	      'maklumat' => $this->MasterData->getDataWhere('maklumat', ['id_maklumat'=>$id_maklumat])->row(),
	    ];
	    $this->load->view('Admin/head',$head);
	    $this->load->view('Admin/navigation', $nav);
	    $this->load->view('Admin/back_home/v_edit_maklumat', $data);
	    $this->load->view('foot', $foot);
	}
	public function save_edit_maklumat() {
	    $data_post = $this->input->POST();
		$post = striptag($data_post);
	    $id_maklumat = $post['id_maklumat'];
	    $maklumat  = $post['maklumat'];
	    $query = $this->MasterData->editData(
	      ['id_maklumat'=>$id_maklumat],
	      [
	        'maklumat' => $maklumat,
	      ], 'maklumat'
	    );
	    if ($query) {
	      $sess['alert'] = alert_success('Data berhasil diedit.');
	      $this->session->set_flashdata($sess);
	      ?>
	        <script>
	          window.location = "<?= base_url('Admin/maklumat'); ?>";
	        </script>
	      <?php
	          } else {
	            $sess['alert'] = alert_failed('Update data gagal.');
	            $this->session->set_flashdata($sess);
	            ?>
	        <script>
	          window.location = "<?= base_url('Admin/maklumat'); ?>";
	        </script>
	      <?php
	    }
	}
}
