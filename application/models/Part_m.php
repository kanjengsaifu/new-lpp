<?php

class Part_m extends My_Model
{
	function __construct(){
        parent::__construct();
        $this->my_table='vw_partdetail';
        $this->my_column_order=array('part_name', 'part_kode', null, 'partcategory_alias'); // sesuai index kolom
        // $this->my_column_order=array( 'name', 'status', 'created_at');
        $this->my_column_search=array('part_name', 'part_kode', 'partcategory_name');
        $this->my_order=array('part_name'=>'asc');
    }//end

	/*
	SELECT p.*, ppc.partcategory_alias, ppc.partcategory_name
	FROM tbl_m_parts p
	LEFT JOIN tbl_profile_partcategory ppc ON p.id_partcategory = ppc.id;
	*/

    function fetch_data(){
        $data=array();
        $list=$this->my_result_builder();

        foreach($list as $row){
            $subdata=array();
            // $subdata[]=$row->id;
            $subdata[]=$row->part_kode;
            $subdata[]=$row->part_name;
            $subdata[]=$row->spk_kode;
            $subdata[]=$row->partcategory_alias . " - " . $row->partcategory_name;
            $subdata[]=$row->conversion;
            $subdata[]=date( APP_DATE_FORMAT, strtotime($row->created_at));
            $subdata[]='<a href="#" data="'.$row->id.'" class="btn btn-warning btn-sm item-edit">Edit</a>
                        <a href="#" data="'.$row->id.'" class="btn btn-danger btn-sm item-delete">Delete</a>';
            $data[]=$subdata;
        }
        return $this->my_json_builder($data);
    }//end

	/* Helper */
	public function getProfilePartCategory()
	{
		$sql = "SELECT * FROM tbl_profile_partcategory ORDER BY ?";
		$query = $this->db->query($sql, array('category_alias'));

		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}

	public function addPart(){
		$part_name = $this->input->post('part_name');
		$part_kode = $this->input->post('part_kode');
		$spk_kode = $this->input->post('spk_kode');
		$id_partcategory = $this->input->post('partcategory_id');
		$conversion = $this->input->post('conversion');
		$created_at = date(DB_DATE_TIME_FORMAT);

		$sql = "INSERT INTO tbl_m_parts (part_name, part_kode, spk_kode, id_partcategory, conversion, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?)";
		$query = $this->db->query($sql, array($part_name, $part_kode, $spk_kode, $id_partcategory, $conversion, "1", $created_at));

		if($this->db->affected_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function editPart(){
		$id = $this->input->get('id');
		$this->db->where('id', $id);
		$query = $this->db->get('tbl_m_parts');
		if($query->num_rows() > 0){
			return $query->row();
		}else{
			return false;
		}
	}

	public function updatePart(){
		$id = $this->input->post('txtId');
        $part_name = $this->input->post('part_name');
		$part_kode = $this->input->post('part_kode');
		$spk_kode = $this->input->post('spk_kode');
		$id_partcategory = $this->input->post('partcategory_id');
        $conversion = $this->input->post('conversion');

		$modified_at = date(DB_DATE_TIME_FORMAT);

		$sql = "UPDATE tbl_m_parts SET part_name = ?, part_kode = ?, spk_kode = ?, id_partcategory = ?, conversion = ?, modified_at = ? WHERE id = ?";
		$query = $this->db->query($sql, array($part_name, $part_kode, $spk_kode, $id_partcategory, $conversion, $modified_at, $id));

		if($this->db->affected_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	function deletePart(){
        $id = $this->input->get('id');
        $this->db->where('id', $id);
        $modified_at = date(DB_DATE_TIME_FORMAT);

        $sql = "UPDATE tbl_m_parts SET status = ?, modified_at = ? WHERE id = ?";
        $query = $this->db->query($sql, array(0, $modified_at, $id));

        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

}