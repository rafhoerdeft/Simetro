<?php
// include_once(APPPATH.'libraries/REST_Controller.php');

defined('BASEPATH') OR exit('No direct script access allowed');

class Operator extends CI_Controller {

	function __construct() {

		parent::__construct();

    $this->load->model('MasterData');

	}

    //auth

    public function index(){
      // $data['active'] = 'input';
      // $data['tipeSurat'] = $this->MasterData->getData('typesurat');

      // $select = "max(no_agenda) max_no";
      // $table = "nomor_agenda";
      // $where = "jenis_agenda = 'Bupati'";
      // $data['no_agenda'] = $this->MasterData->getWhereData($select,$table,$where)->row()->max_no;
      // var_dump($data['no_agenda'] );exit();

      // $this->load->view('Operator/header');
      // $this->load->view('Operator/navigation',$data);
      $this->load->view('Operator/index');
      // $this->load->view('Operator/footer');
    }
}

