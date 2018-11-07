<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Parts extends CI_Controller {

    function __construct(){
		parent:: __construct();
		$this->load->model('part_m', 'm');
	}

	public function index()
	{
        $data['title'] = "Parts";
        $data['profile_partcategory'] = $this->m->getProfilePartCategory();
        $this->load->view('templates/header');
        $this->load->view('master/part/index', $data);
        $this->load->view('templates/footer');
	}

	public function fetch()
	{
		echo $this->m->fetch_data();
	}

	public function addPart()
	{
		$result = $this->m->addPart();
		$msg['success'] = false;
		$msg['type'] = 'add';
		if($result){
			$msg['success'] = true;
		}
		echo json_encode($msg);
	}

	public function editPart(){
		$result = $this->m->editPart();
		echo json_encode($result);
	}

	public function updatePart(){
		$result = $this->m->updatePart();
		$msg['success'] = false;
		$msg['type'] = 'update';
		if($result){
			$msg['success'] = true;
		}
		echo json_encode($msg);
	}

	public function deletePart(){
		$result = $this->m->deletePart();
		$msg['success'] = false;
		if($result){
			$msg['success'] = true;
		}
		echo json_encode($msg);
	}

}
