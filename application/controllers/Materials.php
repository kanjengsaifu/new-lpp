<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Materials extends CI_Controller {

    function __construct(){
		parent:: __construct();
		$this->load->model('material_m', 'm');
	}

	public function index()
	{
		$data['title'] = "Materials";
		$data['profile_category'] = $this->m->getProfileCategory();
        $this->load->view('templates/header');
        $this->load->view('master/material/index', $data);
        $this->load->view('templates/footer');
	}

	public function fetch()
	{
		echo $this->m->fetch_data();
	}

	public function addMaterial()
	{
		$result = $this->m->addMaterial();
		$msg['success'] = false;
		$msg['type'] = 'add';
		if($result){
			$msg['success'] = true;
		}
		echo json_encode($msg);
	}

	public function editMaterial(){
		$result = $this->m->editMaterial();
		echo json_encode($result);
	}

	public function updateMaterial(){
		$result = $this->m->updateMaterial();
		$msg['success'] = false;
		$msg['type'] = 'update';
		if($result){
			$msg['success'] = true;
		}
		echo json_encode($msg);
	}

	public function deleteMaterial(){
		$result = $this->m->deleteMaterial();
		$msg['success'] = false;
		if($result){
			$msg['success'] = true;
		}
		echo json_encode($msg);
	}

	/* Helper */
	public function getMaterialByID($id){
		$result = $this->m->getMaterialByID($id);
		echo json_encode($result);
	}

}
