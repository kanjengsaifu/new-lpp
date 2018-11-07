<?php
class Material_m extends My_Model {

	function __construct(){
        parent::__construct();
        $this->my_table='vw_materialdetail'; // view
        $this->my_column_order=array( 'material_kode','name', 'category_alias');
        $this->my_column_search=array('name', 'material_kode', 'category_name');
        $this->my_order=array('material_kode'=>'asc');
    }//end

	/* Helper */
	public function getProfileCategory()
	{
		$sql = "SELECT * FROM tbl_profile_category ORDER BY ?";
		$query = $this->db->query($sql, array('category_alias'));

		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}

	public function getProfileCategoryByID($id)
	{
		if ($id == null) {
			return false;
		}

		$sql = "SELECT * FROM tbl_profile_category WHERE id = ?";
		$query = $this->db->query($sql, array($id));

		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}

	public function getMaterialByID($id)
	{
		if ($id == null) {
			return false;
		}

		$sql = "SELECT * FROM tbl_m_materials WHERE id = ?";
		$query = $this->db->query($sql, array($id));

		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}

	// 	/*
	// 	SELECT m.*, pc.category_alias, pc.category_name
	// 	FROM tbl_m_materials m
	// 	LEFT JOIN tbl_profile_category pc ON m.category_id = pc.id;
	// 	*/

	function fetch_data(){
        $data=array();
        $list=$this->my_result_builder();

        foreach($list as $row){
            $subdata=array();
            $subdata[]=$row->material_kode;
            $subdata[]=$row->name;
            $subdata[]=$row->category_alias . " - " . $row->category_name;
            $subdata[]=$row->conversion;
            $subdata[]=date( APP_DATE_FORMAT, strtotime($row->created_at));
            $subdata[]='<a href="#" data="'.$row->id.'" class="btn btn-warning btn-sm item-edit">Edit</a>
                        <a href="#" data="'.$row->id.'" class="btn btn-danger btn-sm item-delete">Delete</a>';
            $data[]=$subdata;
        }
        return $this->my_json_builder($data);
    }//end

	public function addMaterial(){
		$name = $this->input->post('txtMaterialName');
		$material_kode = $this->input->post('material_kode');
		$category_id = $this->input->post('category_id');
		$conversion = $this->input->post('conversion');
		$created_at = date(DB_DATE_TIME_FORMAT);

		$sql = "INSERT INTO tbl_m_materials (name, material_kode, category_id, conversion, status, created_at) VALUES (?, ?, ?, ?, ?, ?)";
		$query = $this->db->query($sql, array($name, $material_kode, $category_id, $conversion, "1", $created_at));

		if($this->db->affected_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function editMaterial(){
		$id = $this->input->get('id');
		$this->db->where('id', $id);
		$query = $this->db->get('tbl_m_materials');
		if($query->num_rows() > 0){
			return $query->row();
		}else{
			return false;
		}
	}

	public function updateMaterial(){
		$id = $this->input->post('txtId');
		$name = $this->input->post('txtMaterialName');
		$material_kode = $this->input->post('material_kode');
		$category_id = $this->input->post('category_id');
		$conversion = $this->input->post('conversion');
		$modified_at = date(DB_DATE_TIME_FORMAT);

		$sql = "UPDATE tbl_m_materials SET name = ?, material_kode = ?, category_id = ?, conversion = ?, modified_at = ? WHERE id = ?";
		$query = $this->db->query($sql, array($name, $material_kode, $category_id, $conversion, $modified_at, $id));

		if($this->db->affected_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	function deleteMaterial(){
        $id = $this->input->get('id');
        $this->db->where('id', $id);
        $modified_at = date(DB_DATE_TIME_FORMAT);

        $sql = "UPDATE tbl_m_materials SET status = ?, modified_at = ? WHERE id = ?";
        $query = $this->db->query($sql, array(0, $modified_at, $id));

        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

}