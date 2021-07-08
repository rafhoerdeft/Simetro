<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('MasterData');
		$this->load->library('session');
		$this->load->helper('tanggal');
		$this->load->model('m_home');
		$this->load->model('counter_model', 'counter');
		$this->counter->simpanPengunjung();
	}

	public function index()
	{
		$data = [
			'agenda'	=> $this->m_home->getAgenda(),
			'profile'	=> $this->m_home->getProfile(),
			'beritas'	=> $this->m_home->getBerita(),
			'pengumumans'	=> $this->m_home->getPengumuman(),
			'carousels'	=> $this->m_home->getCarouselImage(),
			'maklumat'	=> $this->m_home->getMaklumat(),
		];

		$this->load->view('v_home', $data);
	}

	public function detail_berita($id_berita)
	{
		$data = [
			'active'	=> 'berita',
			'content'	=> 'v_detail_berita',
			'berita'	=> $this->m_home->getBeritaPerId($id_berita),
		];

		$this->load->view('v_main_partial', $data);
	}

	public function semua_berita()
	{
		$data = [
			'active'	=> 'berita',
			'content'	=> 'v_semua_berita',
			'beritas'	=> $this->m_home->getBeritaAll(),
		];

		$this->load->view('v_main_partial', $data);
	}
}
