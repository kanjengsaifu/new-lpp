<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Spks extends CI_Controller {

    function __construct(){
		parent:: __construct();
		$this->load->model('spk_m', 'm');
	}

	public function index()
	{
		$data['title'] = "Spks";
		$js_data['js_to_load'] = array("moment.min.js");
		$data['active_customer'] = $this->m->getActiveCustomer();
		$data['active_material'] = $this->m->getActiveMaterial();
		$data['active_uom'] = $this->m->getActiveUOM();
		$data['active_part'] = $this->m->getActivePart();
        // nanti tambah profile unit
        $this->load->view('templates/header', $js_data);
        $this->load->view('transaction/spk/index', $data);
        $this->load->view('transaction/spk/script');
        $this->load->view('templates/footer');
	}

	public function fetch()
	{
		echo $this->m->fetch_data();
	}

	// public function showAllSpk($limit){
	// 	$result = $this->m->showAllSpk($limit);
	// 	echo json_encode($result);
	// }

	public function addSpk()
	{
		$result = $this->m->addSpk();
		$msg['success'] = false;
		$msg['type'] = 'add';
		if($result){
			$msg['success'] = true;
		}
		echo json_encode($msg);
	}

	public function editSpk()
	{
		$result = $this->m->editSpk();
		echo json_encode($result);
	}

	public function updateSpk()
	{
		$result = $this->m->updateSpk();
		$msg['success'] = false;
		$msg['type'] = 'update';

		if($result){
			$msg['success'] = true;
		}
		echo json_encode($msg);
	}

	public function deleteSpk(){
		$result = $this->m->deleteSpk();
		$msg['success'] = false;
		if($result){
			$msg['success'] = true;
		}
		echo json_encode($msg);
	}

	public function updateSpkStatusOnly()
	{
		$result = $this->m->updateSpkStatusOnly();
		$msg['success'] = false;
		$msg['type'] = 'update';

		if($result){
			$msg['success'] = true;
		}
		echo json_encode($msg);
	}

}
