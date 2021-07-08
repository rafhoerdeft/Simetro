<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Auth extends CI_Controller {



	function __construct(){

		parent:: __construct();

		$this->load->model('MasterData');

		$this->load->library('session');

		$this->load->helper('alert');
		$this->load->helper('email');
		$this->load->helper('wa');

		// $this->sms = $this->load->database('sms', TRUE);



		date_default_timezone_set('Asia/Jakarta');

    }



	public function index(){

		$this->session->sess_destroy();



		$where = "nama_role = 'User'";

		$dataRole = $this->MasterData->getDataWhere('tbl_role',$where)->row();



		$data = array(

			'id_role' => $dataRole->id_role

		);



		$this->load->view('index', $data);

	}



	public function cek_login() {

		$username = htmlspecialchars_decode($this->input->post('username', TRUE));

		$password = htmlspecialchars_decode($this->input->post('password', TRUE));

		$pass = md5($password);

		// $where = array(

		// 			'username' => $username,

		// 			'password' => md5($password)

		// 		);

		$where = "username = '$username' AND password = '$pass'";

		$hasil = $this->MasterData->getWhereDataAll('tbl_user',$where);

		

		if ($hasil->num_rows() == 1) {

			$id_role = $hasil->row()->id_role;



			$where = "id_role = $id_role";

			$dataRole = $this->MasterData->getWhereDataAll('tbl_role',$where)->row();

			$role = $dataRole->nama_role;

			

			$sess_data['id_user'] = $hasil->row()->id_user;

			$sess_data['nama_user'] = $hasil->row()->nama_user;

			$sess_data['username'] = $hasil->row()->username;

			$sess_data['role'] = $role;
			$sess_data['logs'] = 'Sim_'.$role;

			$this->session->set_userdata($sess_data);

			

			$datas = ['success' => true, 'role' => $role, 'link' => base_url($role)];

		}

		else {

			$datas = ['success' => false];

		}



		echo json_encode($datas);

	}



	public function registerUser($value='') {

		$post = $this->input->POST();



		if ($post) {

			$data = array();

			foreach ($post as $key => $val) {

				// if ($key == 'password') {

				// 	$data[$key] = md5($val);

				// } else {

					$data[$key] = $val;

				// }

			}



			$no_hp = $post['no_hp'];



			if ($no_hp != '' || $no_hp != null) {

				$select = 'no_hp';

				$table = 'tbl_user';

				$where = "no_hp = '$no_hp'";

				$cekNoHp = $this->MasterData->getWhereData($select,$table,$where)->num_rows();



				if ($cekNoHp == 0) {

					$pswd = rand(11111,99999);

					$data['password'] = md5($pswd);

					$inputData = $this->MasterData->inputData($data,$table);



					if ($inputData) {

						// $select = 'nama_role';
						// $where = "id_role = '$post[id_role]'";
						// $namaRole = $this->MasterData->getWhereData($select,'tbl_role',$where)->row()->nama_role;

						// $noTelp = $no_hp;

						// $pesan = "Akun SiMetro Anda\nNama User: ".$post['nama_user']."\nUsername: ".$post['username']."\nPassword: ".$pswd."\n\nAnda terdaftar sebagai User Pemilik Usaha";

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

						// ==========================================================

						$pesan_mail = "Akun SiMetro Anda <br> Nama User: ".$post['nama_user']." <br> Username: ".$post['username']." <br> Password: ".$pswd." <br><br> Anda terdaftar sebagai User Pemilik Usaha";

						$pesan_wa = "Akun SiMetro Anda\nNama User: ".$post['nama_user']."\nUsername: ".$post['username']."\nPassword: ".$pswd."\n\nAnda terdaftar sebagai User Pemilik Usaha";

						kirim_email($post['email'], $pesan_mail);
						kirim_wa($no_hp, $pesan_wa);

				        // ==========================================================

						$sess['alert'] = alert_success('Register berhasil.');

						$this->session->set_flashdata($sess);

						redirect(base_url().'Auth');

					} else {

						$sess['alert'] = alert_failed('Register gagal.');

						$this->session->set_flashdata($sess);

						redirect(base_url().'Auth');

					}



				} else {

					$sess['alert'] = alert_failed('Nomor HP sudah terdaftar.');

					$this->session->set_flashdata($sess);

					redirect(base_url().'Auth');

				}

			} else {

				$table = 'tbl_user';

				$inputData = $this->MasterData->inputData($data,$table);



				if ($inputData) {

					$sess['alert'] = alert_success('Register berhasil.');

					$this->session->set_flashdata($sess);

					redirect(base_url().'Auth');

				} else {

					$sess['alert'] = alert_failed('Register gagal.');

					$this->session->set_flashdata($sess);

					redirect(base_url().'Auth');

				}

			}

			



		} else {

			$sess['alert'] = alert_failed('Register gagal.');

			$this->session->set_flashdata($sess);

			redirect(base_url().'Auth');

		}

	}



	public function logout(){

		// Hapus semua data pada session

		$this->session->sess_destroy();



		// redirect ke halaman login	

		redirect('Auth/index');

	}



}

