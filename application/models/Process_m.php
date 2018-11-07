<?php

class Process_m extends My_Model
{
	function __construct(){
        parent::__construct();
        $this->my_table='tbl_m_process';
        $this->my_column_order=array('kode_proses', 'name', 'alias');
        $this->my_column_search=array('name');
        $this->my_order=array('name'=>'asc');
    }//end

    function fetch_data(){
        $data=array();
        $list=$this->my_result_builder();

        foreach($list as $row){
            $subdata=array();
            // $subdata[]=$row->id;
            $subdata[]=$row->kode_proses;
            $subdata[]=$row->name;
            $subdata[]=$row->alias;
            $subdata[]=date( APP_DATE_FORMAT, strtotime($row->created_at));
            $subdata[]='<a href="#" data="'.$row->id.'" class="btn btn-warning btn-sm item-edit">Edit</a>
                        <a href="#" data="'.$row->id.'" class="btn btn-danger btn-sm item-delete">Delete</a>';
            $data[]=$subdata;
        }
        return $this->my_json_builder($data);
    }//end

	public function addProcess(){
		$name = $this->input->post('nama_proses');
		$kode_proses = $this->input->post('kode_proses');
		$alias = $this->input->post('alias');
		$created_at = date(DB_DATE_TIME_FORMAT);

		$sql = "INSERT INTO tbl_m_process (kode_proses, name, alias, status, created_at) VALUES (?, ?, ?, ?, ?)";
		$query = $this->db->query($sql, array($kode_proses, $name, $alias, "1", $created_at));

		if($this->db->affected_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function editProcess(){
		$id = $this->input->get('id');
		$this->db->where('id', $id);
		$query = $this->db->get('tbl_m_process');
		if($query->num_rows() > 0){
			return $query->row();
		}else{
			return false;
		}
	}

	public function updateProcess(){
		$id = $this->input->post('txtId');
        $name = $this->input->post('nama_proses');
		$kode_proses = $this->input->post('kode_proses');
		$alias = $this->input->post('alias');
		$modified_at = date(DB_DATE_TIME_FORMAT);

		$sql = "UPDATE tbl_m_process SET name = ?, kode_proses = ?, alias = ?, modified_at = ? WHERE id = ?";
		$query = $this->db->query($sql, array($name, $kode_proses, $alias, $modified_at, $id));

		if($this->db->affected_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	function deleteProcess(){
        $id = $this->input->get('id');
        $this->db->where('id', $id);
        $modified_at = date(DB_DATE_TIME_FORMAT);

        $sql = "UPDATE tbl_m_process SET status = ?, modified_at = ? WHERE id = ?";
        $query = $this->db->query($sql, array(0, $modified_at, $id));

        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

}