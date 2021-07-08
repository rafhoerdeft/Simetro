<?php
  defined('BASEPATH') OR exit('No direct script access allowed');

  class M_home extends CI_Model
  {
    public function __construct()
    {
      parent::__construct();
    }

    public function getProfile()
    {
      $query = $this->db->get('profile');
      return $query->row();
    }

    public function getAgenda()
    {
      $query = $this->db->query("SELECT tgl_inspeksi, layanan, nama_usaha, nama_user 
				FROM tbl_pendaftaran, tbl_usaha, tbl_user 
				WHERE tbl_pendaftaran.id_usaha = tbl_usaha.id_usaha 
					and tbl_usaha.id_user = tbl_user.id_user 
					and tgl_inspeksi >= CURDATE() 
					and month(tgl_inspeksi) = month(curdate()) 
					and year(tgl_inspeksi) = year(curdate()) 
          and status = 'proses'")->result();
      
      return $query;
    }

    public function getCarouselImage()
    {
      $query = $this->db->get('carousel_image');
      return $query;
    }

    public function getBerita()
    {
      $query = $this->db->order_by('tanggal', 'desc')->limit(3)->get('berita');
      return $query;
    }

    public function getPengumuman()
    {
      $query = $this->db->order_by('tanggal', 'desc')->limit(10)->get('pengumuman');
      return $query;
    }

    public function getBeritaPerId($id_berita)
    {
      $query = $this->db->get_where('berita', ['id_berita'=>$id_berita]);
      return $query->row();
    }

    public function getBeritaAll()
    {
      $query = $this->db->order_by('tanggal', 'desc')->get('berita');
      return $query;
    }

    public function getVisitorToday()
    {
      $query = $this->db->query(
        "SELECT count(*)as JML from tbl_pengunjung 
          where year(tanggal)=? and month(tanggal)=? and day(tanggal)=?",
        array(date('Y'), date('m'), date('d'))
      );
      return $query->row()->JML;
    }

    public function getMaklumat()
    {
      $query = $this->db->get('maklumat');
      return $query->row();
    }


  }