<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class MasterData extends CI_Model {

	public function getData($table){
		return $this->db->GET($table);
	}
	public function getDataDesc($table, $order){
		return $this->db->order_by($order,'DESC')
						->GET($table);
	}
	public function getSelectData($select,$table){
		return $this->db->SELECT($select)
						->GET($table);
	}
	public function getDataWhere($table,$where){
		return $this->db->SELECT('*')
						->WHERE($where)
						->GET($table);
	}
	public function getSelectDataOrder($select,$table,$by,$order){
		return $this->db->SELECT($select)
						->order_by($by, $order)
						->GET($table);
	}
	public function getWhereDataAll($table,$where){
		return $this->db->SELECT('*')
						->WHERE($where)
						->GET($table);
	}
	public function getWhereDataAllDesc($table,$where,$order){
		return $this->db->SELECT('*')
						->WHERE($where)
						->order_by($order,'DESC')
						->GET($table);
	}
	public function getWhereData($select,$table,$where){
		return $this->db->SELECT($select)
						->WHERE($where)
						->GET($table);
	}
	public function getWhereDataLimit($select,$table,$where,$limit){
		return $this->db->SELECT($select)
						->WHERE($where)
						->LIMIT($limit)
						->GET($table);
	}
	public function getWhereDataLimitOrder($select,$table,$where,$limit,$by,$order){
		return $this->db->SELECT($select)
						->WHERE($where)
						->LIMIT($limit)
						->order_by($by, $order)
						->GET($table);
	}
	public function getWhereDataOrder($select,$table,$where,$by,$order){
		return $this->db->SELECT($select)
						->WHERE($where)
						->order_by($by,$order)
						->GET($table);
	}
	public function dataLog(){
		return $this->db->query('SELECT MAX(id_client) FROM client');
	}
	public function getDataOrder($table,$order){
		return $this->db->order_by($order,'ASC')
						->GET($table);
	}
	public function getDataGroup($select,$table,$group){
		return $this->db->SELECT($select)
						->group_by($group)
						->GET($table);
	}
	public function getDataGroupOrder($select,$table,$group,$by,$order){
		return $this->db->SELECT($select)
						->group_by($group)
						->order_by($by,$order)
						->GET($table);
	}
	public function getDataGroupOrderWhere($select,$table,$group,$by,$order,$where){
		return $this->db->SELECT($select)
						->WHERE($where)
						->group_by($group)
						->order_by($by,$order)
						->GET($table);
	}
	public function getDataGroupAll($table,$group){
		return $this->db->SELECT('*')
						->group_by($group)
						->GET($table);
	}
	public function countData($table){
		return $this->db->count_all_results($table);
	}

	public function selectJoin($select,$table,$where){
		return $this->db->SELECT($select)
						->FROM($table)
						->WHERE($where)
						->GET();
	}
	public function selectJoinNot($select,$field,$table,$where){
		return $this->db->SELECT($select)
						->FROM($table)
						->WHERE($where)
						->WHERE_NOT_IN($field, $table)
						->GET();
	}
 	public function inputData($data,$table){
		return $this->db->insert($table,$data);
	}
	public function replaceData($data,$table){
		return $this->db->replace($table,$data);
	}
	public function editData($where,$data,$table){
		$this->db->where($where);
		return $this->db->update($table,$data);
	}
	public function editData2($where,$data,$table){
		return $this->db->query("UPDATE $table SET $data WHERE $where");
	}
	public function deleteData($where,$table){
		$this->db->where($where);
		return $this->db->delete($table);
	}
	public function cekLogin($table,$where){		
		return $this->db->get_where($table,$where);
	}
	public function gambar($id_user){
	    $this->db->where('id_user', $id_user);
	    return $this->db->get('user')->row();
	}

	public function cari($keyword,$select,$table){
		return $this->db->SELECT($select)
						->LIKE('kode_unik', $keyword)
						->GET($table);
	}

	public function sendMsg($data='',$table=''){
		$this->sms = $this->load->database('sms', TRUE);
		return $this->sms->insert($table,$data);
	}
}