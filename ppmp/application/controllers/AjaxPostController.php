<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AjaxPostController extends MY_Controller 
{
	public $layout_view = 'layout/template';
	// Show view Page
	public function index(){
		$this->layout->view('content/gen_ppmpView');
	}

	// This function call from AJAX
	public function user_data_submit() 
	{

		$data = array('deptcode' => $this->input->post('deptcode'), 'offcode' => $this->input->post('offcode'));


		$offices = $this->DatabaseModel->getOfficeByDeptCode($data['deptcode'],$data['offcode']);


		
		

		echo json_encode($offices);
	}

	public function get_user_fund_admin(){

		$fund_admin = $this->DatabaseModel->getFundAdmin();

		echo json_encode($fund_admin);
	}


	public function get_user_dept_head(){

		$data = array('deptcode' => $this->input->post('deptcode'), 'offcode' => $this->input->post('offcode'));


		$rsDeptHead = $this->DatabaseModel->getDeptHead($data['deptcode'],$data['offcode']);

		echo json_encode($rsDeptHead);
	}


}