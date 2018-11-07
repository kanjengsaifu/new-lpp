<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends CI_Controller {

    function __construct(){
		parent:: __construct();
		$this->load->model('customer_m', 'm');
	}

	public function index()
	{
        $data['title'] = "Customers";
        $this->load->view('templates/header');
        $this->load->view('master/customer/index', $data);
        $this->load->view('templates/footer');
	}

	public function fetch()
	{
		echo $this->m->fetch_data();
	}

	public function addCustomer()
	{
		$result = $this->m->addCustomer();
		$msg['success'] = false;
		$msg['type'] = 'add';
		if($result){
			$msg['success'] = true;
		}
		echo json_encode($msg);
	}

	public function editCustomer(){
		$result = $this->m->editCustomer();
		echo json_encode($result);
	}

	public function updateCustomer(){
		$result = $this->m->updateCustomer();
		$msg['success'] = false;
		$msg['type'] = 'update';
		if($result){
			$msg['success'] = true;
		}
		echo json_encode($msg);
	}

	public function deleteCustomer(){
		$result = $this->m->deleteCustomer();
		$msg['success'] = false;
		if($result){
			$msg['success'] = true;
		}
		echo json_encode($msg);
	}

}
