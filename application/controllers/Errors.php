<?php 
	defined('BASEPATH') OR exit('No direct script access allowed');

	/**
	 * 
	 */
	class Errors extends CI_Controller
	{
		
		function __construct()
		{
			parent::__construct();
		// 	$this->load->helper('url');
		}

		public function index($sess=''){
			$this->load->view('error404.php');
		}

		public function forbidden($sess=''){
			$this->load->view('forbidden.php');
		}
	}
?>