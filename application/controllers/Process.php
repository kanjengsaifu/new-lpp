<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Process extends CI_Controller {

    function __construct(){
		parent:: __construct();
		$this->load->model('process_m', 'm');
	}

	public function index()
	{
        $data['title'] = "Process";
        $this->load->view('templates/header');
        $this->load->view('master/process/index', $data);
        $this->load->view('templates/footer');
	}

	public function fetch()
	{
		echo $this->m->fetch_data();
	}

	public function addProcess()
	{
		$result = $this->m->addProcess();
		$msg['success'] = false;
		$msg['type'] = 'add';
		if($result){
			$msg['success'] = true;
		}
		echo json_encode($msg);
	}

	public function editProcess(){
		$result = $this->m->editProcess();
		echo json_encode($result);
	}

	public function updateProcess(){
		$result = $this->m->updateProcess();
		$msg['success'] = false;
		$msg['type'] = 'update';
		if($result){
			$msg['success'] = true;
		}
		echo json_encode($msg);
	}

	public function deleteProcess(){
		$result = $this->m->deleteProcess();
		$msg['success'] = false;
		if($result){
			$msg['success'] = true;
		}
		echo json_encode($msg);
	}

}
