<?php

class My_Model extends CI_Model
{
    public $my_table;
    public $my_column_order = array();
    public $my_column_search = array();
    public $my_order = array();

    public function __construct()
    {
        parent::__construct();
    }

    // Serverside Processing
    private function _get_datatables_query()
    {

        $this->db->from($this->my_table);
        $this->db->where('status', 1); // custom filter active = 1

        $i = 0;

        foreach ($this->my_column_search as $item)
        {
            if($_POST['search']['value'])
            {
                if($i===0)
                {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if(count($this->my_column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }

        if(isset($_POST['order']))
        {
            $this->db->order_by($this->my_column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else if(isset($this->my_order))
        {
            $order = $this->my_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }//end _get_datatables_query
    function my_result_builder()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    private function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    private function count_all()
    {
        $this->db->from($this->my_table);
        $this->db->where('status', 1); // custom filter active = 1
        return $this->db->count_all_results();
    }//end

    function my_json_builder($data){
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->count_all(),
            "recordsFiltered" => $this->count_filtered(),
            "data" => $data,
        );
        //output to json format
        return json_encode($output);
    }
    //end serverside Processing
}