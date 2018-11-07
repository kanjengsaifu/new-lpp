<?php

class Customer_m extends My_Model
{
    function __construct(){
        parent::__construct();
        $this->my_table='tbl_m_customers';
        $this->my_column_order=array('name');
        // $this->my_column_order=array( 'name', 'status', 'created_at');
        $this->my_column_search=array('name');
        $this->my_order=array('name'=>'asc');
    }//end

    function fetch_data(){
        $data=array();
        $list=$this->my_result_builder();

        foreach($list as $row){
            $subdata=array();
            // $subdata[]=$row->id;
            $subdata[]=$row->name;
            $subdata[]=date( APP_DATE_FORMAT, strtotime($row->created_at));
            $subdata[]='<a href="#" data="'.$row->id.'" class="btn btn-warning btn-sm item-edit">Edit</a>
                        <a href="#" data="'.$row->id.'" class="btn btn-danger btn-sm item-delete">Delete</a>';
            $data[]=$subdata;
        }
        return $this->my_json_builder($data);
    }//end

    public function addCustomer(){
		$name = $this->input->post('txtCustomerName');
		$created_at = date(DB_DATE_TIME_FORMAT);

		$sql = "INSERT INTO tbl_m_customers (name, status, created_at) VALUES (?, ?, ?)";
		$query = $this->db->query($sql, array($name, "1", $created_at));

		if($this->db->affected_rows() > 0){
			return true;
		}else{
			return false;
		}
    }

    public function editCustomer(){
		$id = $this->input->get('id');
		$this->db->where('id', $id);
		$query = $this->db->get('tbl_m_customers');
		if($query->num_rows() > 0){
			return $query->row();
		}else{
			return false;
		}
    }

    public function updateCustomer(){
        $id = $this->input->post('txtId');
        $name = $this->input->post('txtCustomerName');
        $modified_at = date(DB_DATE_TIME_FORMAT);

        $sql = "UPDATE tbl_m_customers SET name = ?, modified_at = ? WHERE id = ?";
        $query = $this->db->query($sql, array($name, $modified_at, $id));

        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    function deleteCustomer(){
        $id = $this->input->get('id');
        $this->db->where('id', $id);
        $modified_at = date(DB_DATE_TIME_FORMAT);
        // $this->db->delete('tbl_m_customers');

        $sql = "UPDATE tbl_m_customers SET status = ?, modified_at = ? WHERE id = ?";
        $query = $this->db->query($sql, array(0, $modified_at, $id));

        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
}
