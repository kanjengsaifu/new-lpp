<?php

class Spk_m extends My_Model
{
	function __construct(){
        parent::__construct();
        $this->my_table='vw_spkdetail';
        $this->my_column_order=array('id', 'spk_no', 'spk_start', 'spk_end', null, 'customer_name', 'part_name');
        $this->my_column_search=array('spk_no', 'customer_name', 'part_name');
        $this->my_order=array('id'=>'desc');
    }//end

	/*
		SELECT spk.*,
		mc.name AS customer_name,
		mm.name AS material_name,
		mp.part_name AS part_name,
		mp.part_kode AS part_category
		FROM tbl_trx_spk spk
			LEFT JOIN tbl_m_customers mc ON spk.id_customer = mc.id
			LEFT JOIN tbl_m_materials mm On spk.id_material = mm.id
			LEFT JOIN tbl_m_parts mp On spk.id_part = mp.id
	*/

    function fetch_data(){
        $data=array();
        $list=$this->my_result_builder();

        foreach($list as $row){
			if ( $row->spk_closed != NULL ) {
				$spk_closed_date = date( APP_DATE_FORMAT, strtotime($row->spk_closed));
			} else {
				$spk_closed_date = '';
			}

			$btn_show = false;

			if ( $row->spk_status == "0" ) {
				$btn_show = true;
			}

            $subdata=array();
            $subdata[]=$row->id;
            $subdata[]=$row->spk_no;
            $subdata[]=date( APP_DATE_FORMAT, strtotime($row->spk_start));
            $subdata[]=date( APP_DATE_FORMAT, strtotime($row->spk_end));
            $subdata[]=$spk_closed_date;
            $subdata[]=$row->customer_name;
            $subdata[]=$row->part_name;
			$subdata[]=get_status_spk_word($row->spk_status);
			if ( $btn_show == true ) {
				$subdata[]='<a href="#" data="'.$row->id.'" class="btn btn-warning btn-sm item-edit">Edit</a>
							<a href="#" data="'.$row->id.'" class="btn btn-danger btn-sm item-delete">Delete</a>';
			} else {
				$subdata[]='';
			}
            $data[]=$subdata;
        }
        return $this->my_json_builder($data);
	}//end

	/* Helper */
	public function getActiveCustomer()
	{
		$sql = "SELECT * FROM tbl_m_customers WHERE status = ? ORDER BY ?";
		$query = $this->db->query($sql, array('1', 'name'));

		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}

	public function getActiveMaterial()
	{
		$sql = "SELECT * FROM tbl_m_materials WHERE status = ? ORDER BY ?";
		$query = $this->db->query($sql, array('1', 'name'));

		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}

	public function getActiveUOM()
	{
		$sql = "SELECT * FROM tbl_profile_uom WHERE status = ? ORDER BY ?";
		$query = $this->db->query($sql, array('1', 'uom'));

		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}

	public function getActivePart()
	{
		$sql = "SELECT * FROM tbl_m_parts WHERE status = ? ORDER BY part_kode";
		$query = $this->db->query($sql, array('1'));

		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}

	/* End Helper */

	public function addSpk(){
		$id_customer = $this->input->post('id_customer');
		$spk_status = get_status_spk_int($this->input->post('spk_status'));
		$id_material = $this->input->post('id_material');
		$qty_m_base = $this->input->post('qty_m_base');
		$id_uom_base = $this->input->post('id_uom_base');
		$qty_m_convert = $this->input->post('qty_m_convert');
		$id_uom_convert = $this->input->post('id_uom_convert');
		$id_part = $this->input->post('id_part');
		$qty_part = $this->input->post('qty_part');
		$id_uom_part = $this->input->post('id_uom_part');
		$spk_rework = $this->input->post('spk_rework');
		$spk_co_number = $this->input->post('spk_co_number');
		$spk_notes = $this->input->post('spk_notes');
		$spk_start = $this->input->post('spk_start');
		$spk_end = $this->input->post('spk_end');

		// Generate SPK Number, ambil SPK Code nya based on Part ID as parameter
		$spk_no = $this->generateSPKNumber($id_part);

		$created_at = date(DB_DATE_TIME_FORMAT);

		$sql = "INSERT INTO tbl_trx_spk (
				status,
				spk_no,
				id_customer,
				spk_status,
				id_material,
				qty_m_base,
				id_uom_base,
				qty_m_convert,
				id_uom_convert,
				id_part,
				qty_part,
				id_uom_part,
				spk_rework,
				spk_co_number,
				spk_notes,
				spk_start,
				spk_end,
				created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

		$arr_val = [
			"1",
			$spk_no,
			$id_customer,
			$spk_status,
			$id_material,
			$qty_m_base,
			$id_uom_base,
			$qty_m_convert,
			$id_uom_convert,
			$id_part,
			$qty_part,
			$id_uom_part,
			$spk_rework,
			$spk_co_number,
			$spk_notes,
			$spk_start,
			$spk_end,
			$created_at
		];

		// return $arr_val;

		$query = $this->db->query($sql, $arr_val);

		if($this->db->affected_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function editSpk(){
		$id = $this->input->get('id');
		$this->db->where('id', $id);
		$query = $this->db->get('tbl_trx_spk');
		if($query->num_rows() > 0){
			return $query->row();
		}else{
			return false;
		}
	}

	public function updateSpk(){
		$id = $this->input->post('txtId');
		$spk_no = $this->input->post('spk_no');
		$id_customer = $this->input->post('id_customer');
		$id_material = $this->input->post('id_material');
		$qty_m_base = $this->input->post('qty_m_base');
		$id_uom_base = $this->input->post('id_uom_base');
		$qty_m_convert = $this->input->post('qty_m_convert');
		$id_uom_convert = $this->input->post('id_uom_convert');
		$id_part = $this->input->post('id_part');
		$qty_part = $this->input->post('qty_part');
		$id_uom_part = $this->input->post('id_uom_part');
		$spk_rework = $this->input->post('spk_rework');
		$spk_co_number = $this->input->post('spk_co_number');
		$spk_notes = $this->input->post('spk_notes');
		$spk_start = $this->input->post('spk_start');
		$spk_end = $this->input->post('spk_end');

		$modified_at = date(DB_DATE_TIME_FORMAT);

		// $sql = "UPDATE tbl_m_materials SET name = ?, material_kode = ?, category_id = ?, conversion = ?, status = ?, modified_at = ? WHERE id = ?";

		$sql = "UPDATE tbl_trx_spk SET
			spk_no = ?,
			id_customer = ?,
			id_material = ?,
			qty_m_base = ?,
			id_uom_base = ?,
			qty_m_convert = ?,
			id_uom_convert = ?,
			id_part = ?,
			qty_part = ?,
			id_uom_part = ?,
			spk_rework = ?,
			spk_co_number = ?,
			spk_notes = ?,
			spk_start = ?,
			spk_end = ?,
			modified_at = ?
			WHERE id = ?";

		$arr_val = [
			$spk_no,
			$id_customer,
			$id_material,
			$qty_m_base,
			$id_uom_base,
			$qty_m_convert,
			$id_uom_convert,
			$id_part,
			$qty_part,
			$id_uom_part,
			$spk_rework,
			$spk_co_number,
			$spk_notes,
			$spk_start,
			$spk_end,
			$modified_at,
			$id
		];

		// return $arr_val;

		$query = $this->db->query($sql, $arr_val);

		if($this->db->affected_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	function deleteSPK(){
        $id = $this->input->get('id');
        $this->db->where('id', $id);
        $modified_at = date(DB_DATE_TIME_FORMAT);
        // $this->db->delete('tbl_m_customers');

        $sql = "UPDATE tbl_trx_spk SET status = ?, modified_at = ? WHERE id = ?";
        $query = $this->db->query($sql, array(0, $modified_at, $id));

        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

	function generateSPKNumber($id_part)
	{
		/* QUERY UNTUK DAPETIN SPK_KODE
		SELECT p.spk_kode FROM tbl_m_parts as p WHERE p.id = 3;
		*/
		$sql_spk_kode = "SELECT p.spk_kode FROM tbl_m_parts as p WHERE p.id = ?";
		$query_spk_kode = $this->db->query($sql_spk_kode, array($id_part));

		// Jika tidak ada return false aja
		if ( $query_spk_kode->num_rows() < 1 ) {
			return false;
		}

		$result_spk_kode = $query_spk_kode->result();
		$spk_kode = $result_spk_kode[0]->spk_kode;

		/* QUERY UNTUK DAPETIN NOMOR TERAKHIR AJA
		SELECT spk.spk_no
		FROM tbl_trx_spk as spk
		WHERE spk.id_part = 3 and Year(spk.created_at) = '2018' and Month(spk.created_at) = '10'
		ORDER BY spk.id DESC Limit 1;
		*/

		$cur_year = date('Y');
		$cur_year_simple = date('y');
		$cur_month = date('m');

		$sql = "SELECT spk.spk_no";
		$sql .= " FROM tbl_trx_spk as spk";
		$sql .= " WHERE spk.id_part = ? and Year(spk.created_at) = ? and Month(spk.created_at) = ?";
		$sql .= " ORDER BY spk.id DESC Limit 1";

		$query = $this->db->query($sql, array($id_part, $cur_year, $cur_month));

		if($query->num_rows() > 0){
			$result = $query->result();
			/* Expected Result
				[{"spk_no":"SPK-12-1217-003"}]
			*/
			$spk_no = $result[0]->spk_no;
			$last_spk_no = explode("-", $spk_no)[3];
		}else{
			// tidak ada record, so mulai dari awal
			$last_spk_no = 0;
		}

		// Add leading 0 with total 3 character.
		// Reset to 0 when month, year changes
		$new_spk_no = (int) $last_spk_no + 1;
		$next_spk_no = "SPK-" . $spk_kode . "-" . $cur_month . $cur_year_simple . "-" . str_pad($new_spk_no,3,"0",STR_PAD_LEFT);

		return $next_spk_no;
	}

}