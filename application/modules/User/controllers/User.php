<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class User extends CI_Controller {



	function __construct(){

		parent:: __construct();

		$this->load->model('MasterData');

		$this->load->library('session');

		$this->load->helper('alert');

		$this->load->helper('encrypt');

		$this->load->helper('uang');

		$this->load->helper('terbilang');

		$this->load->helper('tanggal');
		$this->load->helper('striptag');
		// $this->sms = $this->load->database('sms', TRUE);



		if ($this->session->userdata('logs') != '') {

			redirect('Auth');

		}



		date_default_timezone_set('Asia/Jakarta');



		$this->id_user = $this->session->userdata('id_user');



		$this->head = array(

			"assets/assets/plugins/bootstrap/css/bootstrap.min.css",

		    // "assets/assets/plugins/morrisjs/morris.css",

		    "assets/main/css/style.css",

		    "assets/main/css/colors/yellow.css",

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



		$id_usr = $this->id_user;

		$select = array(

			'dft.*',

			"(SELECT usr.nama_user FROM tbl_user usr WHERE usr.id_user = (SELECT ush.id_user FROM tbl_usaha ush WHERE ush.id_usaha = dft.id_usaha)) nama_user",

			"(SELECT jns.nama_jenis_usaha FROM tbl_jenis_usaha jns WHERE jns.id_jenis_usaha = (SELECT ush.id_jenis_usaha FROM tbl_usaha ush WHERE ush.id_usaha = dft.id_usaha)) nama_jenis_usaha"

		);

		$table = 'tbl_pendaftaran dft';

		$where = "status != 'belum kirim' AND status != 'pending' AND notif = 0 AND id_usaha IN (SELECT ush.id_usaha FROM tbl_usaha ush WHERE ush.id_user = $id_usr)";

		$limit = 5;

		$by = 'tgl_update_status';

		$order = 'DESC';

		$data['notif'] = $this->MasterData->getWhereDataLimitOrder($select,$table,$where,$limit,$by,$order)->result();



		$this->load->view('User/head',$data, TRUE);

    }



	public function index($sess=''){		

		$id_user = $this->id_user;



		$where = "id_user = $id_user";

		$usr = $this->MasterData->getDataWhere('tbl_user',$where)->row();



		if ($usr->nama_user == null || $usr->jk_user == null || $usr->alamat_user == null || $usr->username == null || $usr->password == null) {

			$sess['alert'] = alert_warning('Lengkapi data profil Anda terlebih dahulu!');

			$this->session->set_flashdata($sess);

			redirect('User/profil');

		}

		



		$where = "id_usaha IN (SELECT id_usaha FROM tbl_usaha WHERE id_user = $id_user)";

		$jmlUttp = $this->MasterData->getDataWhere('tbl_uttp',$where)->num_rows();



		$jmlUsaha = $this->MasterData->getDataWhere('tbl_usaha',$where)->num_rows();



		$where .= " AND status='diterima'";

		$pengajuanDiterima = $this->MasterData->getDataWhere('tbl_pendaftaran',$where)->num_rows();



		$where = "id_usaha IN (SELECT id_usaha FROM tbl_usaha WHERE id_user = $id_user) AND status='proses'";

		$pengajuanDiproses = $this->MasterData->getDataWhere('tbl_pendaftaran',$where)->num_rows();



		$where = "id_usaha IN (SELECT id_usaha FROM tbl_usaha WHERE id_user = $id_user) AND status='belum kirim'";

		$pengajuanBelum = $this->MasterData->getDataWhere('tbl_pendaftaran',$where)->num_rows();



		$where = "id_usaha IN (SELECT id_usaha FROM tbl_usaha WHERE id_user = $id_user) AND status='pending'";

		$pengajuanPending = $this->MasterData->getDataWhere('tbl_pendaftaran',$where)->num_rows();



		$where = "id_usaha IN (SELECT id_usaha FROM tbl_usaha WHERE id_user = $id_user) AND status='selesai'";

		$pengajuanSelesai = $this->MasterData->getDataWhere('tbl_pendaftaran',$where)->num_rows();



		$where = "id_usaha IN (SELECT id_usaha FROM tbl_usaha WHERE id_user = $id_user) AND status='ditolak'";

		$pengajuanTolak = $this->MasterData->getDataWhere('tbl_pendaftaran',$where)->num_rows();





		// $this->foot[] = "assets/main/js/dashboard1.js";



		$head['head'] = $this->head;

		$foot['foot'] = $this->foot;

		$nav['menu'] = 'dashboard';



		$data = array(

			'jmlUttp' => $jmlUttp,

			'jmlUsaha' => $jmlUsaha,

			'jmlDiterima' => $pengajuanDiterima,

			'jmlDiproses' => $pengajuanDiproses,

			'jmlBelumKirim' => $pengajuanBelum,

			'jmlPending' => $pengajuanPending,

			'jmlTolak' => $pengajuanTolak,

			'jmlSelesai' => $pengajuanSelesai

		);



		$this->load->view('User/head',$head);

		$this->load->view('User/navigation',$nav);

		$this->load->view('User/dashboard',$data);

		$this->load->view('foot',$foot);

	}



	// =====================================================



	public function clickNotif($id='') {

		if ($id != '') {

			$data = array(

				'notif' => 1

			);

			$where = "id_daftar = $id";

			$update = $this->MasterData->editData($where,$data,'tbl_pendaftaran');



			if ($update) {

				redirect(base_url().'User/dataTera/x/'.encode($id));

			}

		}

	}



	// =====================================================



	public function dataTera($status='x', $id=''){

		$id_user = $this->id_user;



		$select = array(

			'dft.*',

			"(SELECT jns.nama_jenis_usaha FROM tbl_jenis_usaha jns WHERE jns.id_jenis_usaha IN (SELECT ush.id_jenis_usaha FROM tbl_usaha ush WHERE ush.id_usaha = dft.id_usaha)) jenis_usaha",

			"(SELECT tmp.tempat_tera FROM tbl_tempat_tera tmp WHERE tmp.id_tempat_tera = dft.id_tempat_tera) tempat_tera"

		);

		$table = "tbl_pendaftaran dft";

		$where = "id_usaha IN (SELECT usaha.id_usaha FROM tbl_usaha usaha WHERE usaha.id_user = '$id_user') AND status != 'belum kirim'";



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

			$status = '';

			$id_daftar = decode($id);

			$where .= " AND id_daftar = $id_daftar";

		}



		$by = 'dft.id_daftar';

		$order = 'DESC';

		$dataTera = $this->MasterData->getWhereDataOrder($select,$table,$where,$by,$order)->result();

		// $statusJl = $this->MasterData->getData('tbl_status_jalan')->result();



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

			"$('.select2').select2();",

			"$('.dropify').dropify({

				 messages: {

	                default: '<center>Upload dokumen disini (<b>.pdf</b> atau <b>.doc, .docx</b>).</center>',

	                error: '<center>Maksimal ukuran file 2 MB.</center>',

	            }

			});",

			// "$(document).ready( function () {

			// 	var table = $('#myTable').DataTable();

				    	

		 //        var row = table.row(function ( idx, data, node ) {

			//         return data[10] === '".$idRow."';

			//     });

		 //      	if (row.length > 0) {

			//         row.select()

			//         .show()

			//         .draw(false);

		 //      	}

	  //     	});"

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



		$nav['menu'] = 'tera';



		$data = array(

			'status' => $status,

			'dataTera' => $dataTera,

			// 'idRow' => $idRow

			'idDaftar' => $id_daftar,

			'selectStatus' => $status

		);



		$this->load->view('User/head',$head);

		$this->load->view('User/navigation',$nav);

		$this->load->view('User/tera',$data);

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



		$this->foot[] = "assets/assets/plugins/select2/dist/js/select2.full.min.js";

		$this->foot[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.js";

		$this->foot[] = "assets/assets/plugins/sweetalert/sweetalert.min.js";

		$this->foot[] = "assets/assets/plugins/sweetalert/jquery.sweet-alert.custom.js";

		$this->foot[] = "assets/assets/plugins/datatables/jquery.dataTables.min.js";

		$this->foot[] = "assets/assets/plugins/dropify/dist/js/dropify.min.js";



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



		$nav['menu'] = 'tera';



		$data = array(

			'dataUsaha' => $dataUsaha,

			'tempat_tera' => $tempat_tera,

			'no_order' => $no_order,

			'id_user' => $id_user

		);



		$this->load->view('User/head',$head);

		$this->load->view('User/navigation',$nav);

		$this->load->view('User/pendaftaran_tera',$data);

		$this->load->view('foot',$foot);

	}



	public function teraBaru($id='1'){

		$id_user = $this->id_user;



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



		$tempat_tera = $this->MasterData->getData('tbl_tempat_tera')->result();



		$data = array(

			'dataUsaha' => $dataUsaha,

			'tempat_tera' => $tempat_tera,

			// 'no_order' => $no_order,

			// 'listUttp' => $listUttp,

			// 'dataPendaftaran' => $dataPendaftaran,

			'id_user' => $id_user

		);



		$select = 'dft.*';

		$where = "id_usaha IN (SELECT ush.id_usaha FROM tbl_usaha ush WHERE ush.id_user = $id_user) AND status = 'belum kirim'";

		$dataPengajuan = $this->MasterData->getWhereData($select,'tbl_pendaftaran dft',$where)->row();



		if ($dataPengajuan != null) {

		 	$id_daftar = $dataPengajuan->id_daftar;

		 	$no_order = $dataPengajuan->no_order;



		 	$select = '*';

			$table = 'tbl_pendaftaran dft';

			$where = "dft.id_daftar = $id_daftar";

			$dataPendaftaran = $this->MasterData->getWhereData($select,$table,$where)->row();



			$xxx =  $dataPendaftaran->layanan.'_'.$dataPendaftaran->tempat;

			$col_tarif = str_replace(' ', '_', $xxx);

			$select = array(

				'list.*',
				"(SELECT jns.nama_jenis_alat FROM tbl_jenis_alat_ukur jns WHERE jns.id_jenis_alat = (SELECT uttp.id_jenis_alat FROM tbl_uttp uttp WHERE uttp.id_uttp = list.id_uttp)) jenis_alat",
				// "(SELECT trf.jenis_tarif FROM tbl_tarif trf WHERE trf.id_tarif = list.id_tarif) jenis_tarif",

				// "(SELECT trf.satuan FROM tbl_tarif trf WHERE trf.id_tarif = list.id_tarif) satuan",
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



			$data['listUttp'] = $listUttp;

			$data['dataPendaftaran'] = $dataPendaftaran;



			// =================================================================================



			$select = array(

				'dft.*',

				"(SELECT usr.nama_user FROM tbl_user usr WHERE usr.id_user = (SELECT ush.id_user FROM tbl_usaha ush WHERE ush.id_usaha = dft.id_usaha)) nama_user",

				"(SELECT jns.nama_jenis_usaha FROM tbl_jenis_usaha jns WHERE jns.id_jenis_usaha = (SELECT ush.id_jenis_usaha FROM tbl_usaha ush WHERE ush.id_usaha = dft.id_usaha)) jenis_usaha",

				"(SELECT des.nama_desa FROM tbl_desa des WHERE des.kode_desa = (SELECT ush.kode_desa FROM tbl_usaha ush WHERE ush.id_usaha = dft.id_usaha)) desa",

				"(SELECT kec.nama_kecamatan FROM tbl_kecamatan kec WHERE kec.kode_kecamatan = (SELECT des.kode_kecamatan FROM tbl_desa des WHERE des.kode_desa = (SELECT ush.kode_desa FROM tbl_usaha ush WHERE ush.id_usaha = dft.id_usaha))) kecamatan",

				"(SELECT ush.alamat FROM tbl_usaha ush WHERE ush.id_usaha = dft.id_usaha) alamat",

				"(SELECT usr.no_hp FROM tbl_user usr WHERE usr.id_user = (SELECT ush.id_user FROM tbl_usaha ush WHERE ush.id_usaha = dft.id_usaha)) no_telp"

			);

			$where = "id_daftar = $id_daftar";

			$table = 'tbl_pendaftaran dft';

			$dataForm = $this->MasterData->getWhereData($select,$table,$where)->row();



			$select = array(

				'list.*',

				"(SELECT jns.nama_jenis_alat FROM tbl_jenis_alat_ukur jns WHERE jns.id_jenis_alat = (SELECT uttp.id_jenis_alat FROM tbl_uttp uttp WHERE uttp.id_uttp = list.id_uttp)) jenis_alat",

				"(SELECT ktg.nama_kategori_alat FROM tbl_kategori_alat_ukur ktg WHERE ktg.id_kategori_alat = (SELECT jns.id_kategori_alat FROM tbl_jenis_alat_ukur jns WHERE jns.id_jenis_alat = (SELECT uttp.id_jenis_alat FROM tbl_uttp uttp WHERE uttp.id_uttp = list.id_uttp))) kategori_alat",

				"(SELECT uttp.kapasitas FROM tbl_uttp uttp WHERE uttp.id_uttp = list.id_uttp) kapasitas"

			);

			$table = 'tbl_list_tera list';

			$listUttpxx = $this->MasterData->getWhereData($select,$table,$where)->result();



			$data['listUttpxx'] = $listUttpxx;

			$data['dataForm'] = $dataForm;



			$new = false;

		} else {

		 	$select = 'nomor';

			$table = 'tbl_nomor';

			$where = "keterangan = 'Agenda'";

			$no_order = $this->MasterData->getWhereData($select,$table,$where)->row()->nomor;



			$new = true;

		}



		$data['no_order'] = $no_order;

		$data['new'] = $new;

		



		$this->head[] = "assets/assets/plugins/select2/dist/css/select2.css";

		$this->head[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.css";

		$this->head[] = "assets/assets/plugins/wizard/steps.css";

		$this->head[] = "assets/assets/plugins/sweetalert/sweetalert.css";

		$this->head[] = "assets/assets/plugins/dropify/dist/css/dropify.min.css";





		$this->foot[] = "assets/assets/plugins/select2/dist/js/select2.full.min.js";

		$this->foot[] = "assets/assets/plugins/bootstrap-select/bootstrap-select.min.js";

		$this->foot[] = "assets/assets/plugins/wizard/jquery.steps.min.js";

		$this->foot[] = "assets/assets/plugins/sweetalert/sweetalert.min.js";

		$this->foot[] = "assets/assets/plugins/sweetalert/jquery.sweet-alert.custom.js";

		// $this->foot[] = "assets/assets/plugins/wizard/steps.js";

		$this->foot[] = "assets/assets/plugins/datatables/jquery.dataTables.min.js";

		$this->foot[] = "assets/assets/plugins/dropify/dist/js/dropify.min.js";







		$script = array(

			"$('#myTable').DataTable();",

			"$('.select2').select2();",

			"var stepsWizard  = $('.tab-wizard').steps({

			    headerTag: 'h6',

			    bodyTag: 'section',

			    transitionEffect: 'fade',

			    titleTemplate: '<span class=step>#index#</span> #title#',

			    labels: {

			        finish: 'Kirim',

			        next: 'Lanjut',

			        previous: 'Sebelumnya'

			    }, 

			    // onStepChanging: function (event, currentIndex, newIndex) {

			    //     console.log('Evt: ',event);

			    //     console.log('curIndex: ',currentIndex);

			    //     console.log('newIndex: ',newIndex);

			    // },

			    onFinished: function (event, currentIndex) {

			        var form = $(this);

			        form.submit();        

			    }

			});",

			"function nextCus(step=1) {

                for (var i = 0; i < step; i++) {

                    stepsWizard.steps('next');

                }

            }",

            "function next() {

                    stepsWizard.steps('next');

            }",

            "function prev() {

                stepsWizard.steps('previous');

            }",

            "$('.tab-wizard .actions').hide();",

			"$('.dropify').dropify({

				 messages: {

	                default: '<center>Upload dokumen disini (<b>.pdf, .jpg, .jpeg</b>).</center>',

	                error: '<center>Maksimal ukuran file 2 MB.</center>',

	            }

			});",

		);



		if (!$new) {

			$script[] = "$(document).ready(function() {

				          nextCus(1);

				        });";

		}



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



		$nav['menu'] = 'tera_baru';



		$this->load->view('User/head',$head);

		$this->load->view('User/navigation',$nav);

		$this->load->view('User/tera_baru',$data);

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



	public function cekTotalBayar($value='') {



		if ($this->input->POST()) {



			$id_daftar = $this->input->POST('id_daftar');



			$select = array('*');

			$where = "id_daftar = $id_daftar";

			$dataOrder = $this->MasterData->getWhereData($select,'tbl_pendaftaran',$where)->row();		



			$layanan = $dataOrder->layanan;

			$tempat = $dataOrder->tempat;



			// =============================================================



			$dataList = $this->MasterData->getWhereData($select,'tbl_list_tera',$where)->result();			



			$dataArr = array();

			foreach ($dataList as $list) { 



				$id_list = $list->id_list;



				$select = array('hasil_tera');

				$where = "id_list = $id_list";

				$hasil = $this->MasterData->getWhereData($select,'tbl_tera',$where)->row()->hasil_tera;



				if ($hasil=='disahkan') {



					$id_tarif = $list->id_tarif;

					$id_uttp = $list->id_uttp;

					$jml_uttp = $list->jumlah_uttp;



					$select = array(

						'uttp.*',

						"(SELECT alat.nama_jenis_alat FROM tbl_jenis_alat_ukur alat WHERE alat.id_jenis_alat = uttp.id_jenis_alat) jenis_alat"

					);

					$where = "uttp.id_uttp = '$id_uttp'";

					$data_uttp = $this->MasterData->getWhereData($select,'tbl_uttp uttp',$where)->row();



					if ($id_tarif != null || $id_tarif != '') {

						$select = '*';

						$where = "id_tarif = '$id_tarif'";

						$data_tarif = $this->MasterData->getWhereData($select,'tbl_tarif',$where)->row();



						$xxx =  $layanan.'_'.$tempat;

						$col_tarif = str_replace(' ', '_', $xxx);

						$tarif = $data_tarif->$col_tarif;	

						$tot_tarif = $tarif * $jml_uttp;		



						$arr = array(

							'jenis_alat' => $data_uttp->jenis_alat,

							'kapasitas' => $data_uttp->kapasitas,

							'jenis_tarif' => $data_tarif->jenis_tarif,

							'satuan' => $data_tarif->satuan,

							'layanan' => $layanan,

							'tempat' => $tempat,

							'jumlah' => $jml_uttp,

							'tarif' => $tarif,

							'tot_tarif' => $tot_tarif

						);

					} else {

						$arr = array(

							'jenis_alat' => $data_uttp->jenis_alat,

							'kapasitas' => $data_uttp->kapasitas,

							'jenis_tarif' => '-',

							'satuan' => '-',

							'layanan' => $layanan,

							'tempat' => $tempat,

							'jumlah' => $jml_uttp,

							'tarif' => 0,

							'tot_tarif' => 0

						);

					}



					$dataArr[] = $arr;

				}



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
			// $post = striptag($data_post);
			
			// var_dump($post);exit();

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

				// 'tgl_kirim' => date('Y-m-d H:i:s'),

				'user_daftar' => 'user'

				// 'status' => 'masuk',

				// 'notif' => 0

			);

			$input_pendaftaran = $this->MasterData->inputData($data,'tbl_pendaftaran');



			if ($input_pendaftaran) {

				$id_daftar = $this->db->insert_id();



				$id_uttp = $post['id_uttp'];

				// $id_tarif = $post['id_tarif'];

				$jumlah_uttp = $post['jumlah_uttp'];

				$data = array();

				for ($i=0; $i < count($id_uttp) ; $i++) { 

					$arr = array(

						'id_daftar' => $id_daftar,

						'id_uttp' => $id_uttp[$i],

						// 'id_tarif' => $id_tarif[$i],

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

					redirect(base_url().'User/teraBaru');

				} else {

					$sess['alert'] = alert_failed('Data pengajuan tera gagal disimpan.');

					$this->session->set_flashdata($sess);

					redirect(base_url().'User/teraBaru');

				}

			} else {

				$sess['alert'] = alert_failed('Data pengajuan tera gagal disimpan.');

				$this->session->set_flashdata($sess);

				redirect(base_url().'User/teraBaru');

			}

		} else {

			$sess['alert'] = alert_failed('Data pengajuan tera gagal disimpan.');

			$this->session->set_flashdata($sess);

			redirect(base_url().'User/teraBaru');

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

		$id_user = $this->id_user;



		if ($id != '') {

			$id_daftar = decode($id);

		} else {

			$id_daftar = 1;

		}

		

		$select = '*';

		$table = 'tbl_pendaftaran dft';

		$where = "dft.id_daftar = $id_daftar";

		$dataPendaftaran = $this->MasterData->getWhereData($select,$table,$where)->row();





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



		$xxx =  $dataPendaftaran->layanan.'_'.$dataPendaftaran->tempat;

		$col_tarif = str_replace(' ', '_', $xxx);

		$select = array(

			'list.*',

			"(SELECT jns.nama_jenis_alat FROM tbl_jenis_alat_ukur jns WHERE jns.id_jenis_alat = (SELECT uttp.id_jenis_alat FROM tbl_uttp uttp WHERE uttp.id_uttp = list.id_uttp)) jenis_alat",

			"(SELECT trf.jenis_tarif FROM tbl_tarif trf WHERE trf.id_tarif = list.id_tarif) jenis_tarif",

			"(SELECT trf.satuan FROM tbl_tarif trf WHERE trf.id_tarif = list.id_tarif) satuan",

			"(SELECT trf.$col_tarif FROM tbl_tarif trf WHERE trf.id_tarif = list.id_tarif) tarif"

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

			'id_user' => $id_user

		);



		$this->load->view('User/head',$head);

		$this->load->view('User/navigation',$nav);

		$this->load->view('User/edit_pendaftaran_tera',$data);

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

					// $id_tarif = $post['id_tarif'];

					$jumlah_uttp = $post['jumlah_uttp'];

					$data = array();

					for ($i=0; $i < count($id_uttp) ; $i++) { 

						$arr = array(

							'id_daftar' => $id_daftar,

							'id_uttp' => $id_uttp[$i],

							// 'id_tarif' => $id_tarif[$i],

							'jumlah_uttp' => $jumlah_uttp[$i]

						);

						$data[] = $arr;

					}



					$insert_list = $this->db->insert_batch('tbl_list_tera', $data); 



					if ($insert_list) {

						$sess['alert'] = alert_success('Data pengajuan tera berhasil diupdate.');

						$this->session->set_flashdata($sess);

						redirect(base_url().'User/teraBaru');

					} else {

						$sess['alert'] = alert_failed('Data pengajuan tera gagal diupdate.');

						$this->session->set_flashdata($sess);

						redirect(base_url().'User/teraBaru');

					}

				} else {

					$sess['alert'] = alert_failed('Data pengajuan tera gagal diupdate.');

					$this->session->set_flashdata($sess);

					redirect(base_url().'User/teraBaru');

				}

								

			} else {

				$sess['alert'] = alert_failed('Data pengajuan tera gagal diupdate.');

				$this->session->set_flashdata($sess);

				redirect(base_url().'User/teraBaru');

			}

		} else {

			$sess['alert'] = alert_failed('Data pengajuan tera gagal diupdate.');

			$this->session->set_flashdata($sess);

			redirect(base_url().'User/teraBaru');

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

			// redirect(base_url().'User/dataTera');

		} else {

			echo 'Gagal';

			$sess['alert'] = alert_failed('Data pengajuan tera gagal dihapus.');

			$this->session->set_flashdata($sess);

		}

	}



	public function kirimPengajuan($value='') {

		$id_daftar = $this->input->POST('id_daftar');



		$where = "id_daftar = $id_daftar";

		$no_order = $this->MasterData->getDataWhere('tbl_pendaftaran',$where)->row()->no_order;



		$file_surat = '';

		$file_lampiran = '';

		$fp = date('YmdHis');

	    

		if (isset($_FILES['file_surat'])){

			$config['upload_path']          = './assets/path_file';

		    $config['allowed_types']        = 'jpg|jpeg|png|pdf';

		    $config['overwrite']			= false;

			$config['file_name'] = 'Surat_Permohonan_No_Order_'.$no_order;

		    $this->load->library('upload', $config, 'file_surat');

		    $this->file_surat->initialize($config);



			if ($this->file_surat->do_upload('file_surat')) {

                $data_file1 = $this->file_surat->data();

				$file_surat = $data_file1['file_name'];



				// if (isset($_FILES['file_lampiran'])){

				// 	$config2['upload_path']          = './assets/path_file';

				//     $config2['allowed_types']        = 'pdf|doc|docx';

				//     $config2['overwrite']			= false;

				// 	$config2['file_name'] = 'Lampiran-'.$id_daftar.'-'.$fp;

				//     $this->load->library('upload', $config2, 'file_lampiran');

				//     $this->file_lampiran->initialize($config2);



				// 	if ($this->file_lampiran->do_upload('file_lampiran')) {

		  //               $data_file2 = $this->file_lampiran->data();

				// 		$file_lampiran = $data_file2['file_name'];



						$data = array(

							'tgl_kirim' => date('Y-m-d H:i:s'),

							'file_surat' => $file_surat,

							// 'file_lampiran' => $file_lampiran,

							'status' => 'pending',

							'notif_petugas' => 0

						);

						// var_dump($data);

						$where = "id_daftar = '$id_daftar'";

						$update = $this->MasterData->editData($where,$data,'tbl_pendaftaran');



						if ($update) {

							// echo 'Success';

							$sess['alert'] = alert_success('Data pengajuan tera berhasil dikirim.');

							$this->session->set_flashdata($sess);

							redirect(base_url().'User/dataTera');

						} else {

							// echo 'Gagal';

							$sess['alert'] = alert_failed('Data pengajuan tera gagal dikirim.');

							$this->session->set_flashdata($sess);

							redirect(base_url().'User/teraBaru');

						}

		  //           } else {

				// 		$sess['alert'] = alert_failed('Data pengajuan tera gagal dikirim.');

				// 		$this->session->set_flashdata($sess);

				// 		redirect(base_url().'User/teraBaru');

				// 	}

				// } else {

				// 	$sess['alert'] = alert_failed('Data pengajuan tera gagal dikirim.');

				// 	$this->session->set_flashdata($sess);

				// 	redirect(base_url().'User/teraBaru');

				// }

            } else {

				$sess['alert'] = alert_failed('Data pengajuan tera gagal dikirim.');

				$this->session->set_flashdata($sess);

				redirect(base_url().'User/teraBaru');

			}

		} else {

			$sess['alert'] = alert_failed('Data pengajuan tera gagal dikirim.');

			$this->session->set_flashdata($sess);

			redirect(base_url().'User/teraBaru');

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



	public function dataUsaha($value=''){

		$id_user = $this->id_user;

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



		$nav['menu'] = 'usaha';



		$data = array(

			'dataUsaha' => $dataUsaha,

			'dataJenisUsaha' => $dataJenisUsaha,

			'dataKecamatan' => $dataKecamatan

		);



		$this->load->view('User/head',$head);

		$this->load->view('User/navigation',$nav);

		$this->load->view('User/usaha',$data);

		$this->load->view('foot',$foot);

	}



	public function simpanUsaha($value='') {

		$id_user = $this->id_user;

		$data_post = $this->input->POST();
        if ($data_post) {
            $input = striptag($data_post);

			$data = array(

				'id_user' => $id_user,

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

				redirect(base_url().'User/dataUsaha');

			} else {

				$sess['alert'] = alert_failed('Data usaha gagal disimpan.');

				$this->session->set_flashdata($sess);

				redirect(base_url().'User/dataUsaha');

			}

		} else {

			$sess['alert'] = alert_failed('Data usaha gagal disimpan.');

			$this->session->set_flashdata($sess);

			redirect(base_url().'User/dataUsaha');

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



	public function updateUsaha($value='') {

		$data_post = $this->input->POST();
        if ($data_post) {
            $input = striptag($data_post);

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

				redirect(base_url().'User/dataUsaha');

			} else {

				$sess['alert'] = alert_failed('Data usaha gagal diupdate.');

				$this->session->set_flashdata($sess);

				redirect(base_url().'User/dataUsaha');

			}

		} else {

			$sess['alert'] = alert_failed('Data usaha gagal diupdate.');

			$this->session->set_flashdata($sess);

			redirect(base_url().'User/dataUsaha');

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



	// =====================================================



	public function dataUttp($id=''){

		$id_user = $this->id_user;



		$select = array(

			'ush.*',

			"(SELECT jns.nama_jenis_usaha FROM tbl_jenis_usaha jns WHERE jns.id_jenis_usaha = ush.id_jenis_usaha) jenis_usaha"

		);

		$table = "tbl_usaha ush";

		$where = "ush.id_user = '$id_user'";

		$by = 'ush.id_usaha';

		$order = 'DESC';

		$dataUsaha = $this->MasterData->getWhereDataOrder($select,$table,$where,$by,$order)->result();



		if ($id == '') {

			$limit = 1;

			$usaha = $this->MasterData->getWhereDataLimitOrder($select,$table,$where,$limit,$by,$order)->row();

			if ($usaha) {

				$id_usaha = $usaha->id_usaha;

			} else {

				$id_usaha = null;

			}

		} else {

			$id_usaha = decode($id);

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



		$nav['menu'] = 'uttp';



		$data = array(

			'dataUttp' => $dataUttp,

			'dataUsaha' => $dataUsaha,

			'selectUsaha' => $id_usaha,

			'dataJenisAlat' => $dataJenisAlat

		);



		$this->load->view('User/head',$head);

		$this->load->view('User/navigation',$nav);

		$this->load->view('User/uttp',$data);

		$this->load->view('foot',$foot);

	}



	public function updateUttp(){

		$data_post = $this->input->POST();
        if ($data_post) {
            $data = striptag($data_post);

			$table = 'tbl_uttp';

			$where = "id_uttp = $data[id_uttp]";

			$updateData = $this->MasterData->editData($where,$data,$table);



			if ($updateData) {

				$sess['alert'] = alert_success('Data UTTP berhasil diupdate.');

				$this->session->set_flashdata($sess);

				redirect(base_url().'User/dataUttp/'.encode($data['id_usaha']));

			} else {

				$sess['alert'] = alert_failed('Data UTTP gagal diupdate.');

				$this->session->set_flashdata($sess);

				redirect(base_url().'User/dataUttp/'.encode($data['id_usaha']));

			}

		} else {

			$sess['alert'] = alert_failed('Data UTTP gagal diupdate.');

			$this->session->set_flashdata($sess);

			redirect(base_url().'User/dataUttp/'.encode($data['id_usaha']));

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



	public function simpanUttp(){

		$id_user = $this->id_user;

		$data_post = $this->input->POST();
        if ($data_post) {
            $data = striptag($data_post);

			$table = 'tbl_uttp';

			$inputData = $this->MasterData->inputData($data,$table);



			if ($inputData) {

				$sess['alert'] = alert_success('Data UTTP berhasil disimpan.');

				$this->session->set_flashdata($sess);

				redirect(base_url().'User/dataUttp/'.encode($data['id_usaha']));

			} else {

				$sess['alert'] = alert_failed('Data UTTP gagal disimpan.');

				$this->session->set_flashdata($sess);

				redirect(base_url().'User/dataUttp/'.encode($data['id_usaha']));

			}

		} else {

			$sess['alert'] = alert_failed('Data UTTP gagal disimpan.');

			$this->session->set_flashdata($sess);

			redirect(base_url().'User/dataUttp/'.encode($data['id_usaha']));

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



		$this->load->view('User/head',$head);

		$this->load->view('User/navigation',$nav);

		$this->load->view('User/profil',$data);

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

				redirect(base_url().'User/profil');

			} else {

				$sess['alert'] = alert_failed('Data profil gagal disimpan.');

				$this->session->set_flashdata($sess);

				redirect(base_url().'User/profil');

			}

		} else {

			$sess['alert'] = alert_failed('Data profil gagal disimpan.');

			$this->session->set_flashdata($sess);

			redirect(base_url().'User/profil');

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



		$this->load->view('User/head',$head);

		$this->load->view('User/navigation',$nav);

		$this->load->view('User/akun_login',$data);

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

					redirect(base_url().'User/akunLogin');

				} else {

					$sess['alert'] = alert_failed('Data akun login gagal disimpan.');

					$this->session->set_flashdata($sess);

					redirect(base_url().'User/akunLogin');

				}

			} else {

				$sess['alert'] = alert_failed('Password lama tidak sesuai.');

				$this->session->set_flashdata($sess);

				redirect(base_url().'User/akunLogin');

			}

			

		} else {

			$sess['alert'] = alert_failed('Data akun login gagal disimpan.');

			$this->session->set_flashdata($sess);

			redirect(base_url().'User/akunLogin');

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



	// =========================================================



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



}



