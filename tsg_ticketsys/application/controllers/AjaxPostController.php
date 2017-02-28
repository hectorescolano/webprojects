<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class AjaxPostController extends MY_Controller {

    public $layout_view = 'layout/template';
    private $LOGGED_USER = '';

    function __construct() {

        parent::__construct();

        $this->LOGGED_USER = $this->session->userdata['ses_ticketsys']['name'];
    }

    // Show view Page
    public function index() {
        $this->layout->view('content/gen_ppmpView');
    }

    // This function call from AJAX
    public function user_data_submit() {

        $data = array('deptcode' => $this->input->post('deptcode'), 'offcode' => $this->input->post('offcode'));


        $offices = $this->DatabaseModel->getOfficeByDeptCode($data['deptcode'], $data['offcode']);





        echo json_encode($offices);
    }
    
  
    
    public function get_ticket_reports(){
        
        $data = array();
        
        $datefrom = $this->input->post('datefrom');
        $dateto = $this->input->post('dateto');
        $tktStatus = $this->input->post('tktStatus');
        $tktProbCat = $this->input->post('tktProbCat');
        
       
        $data['total_tickets_created'] = $this->DatabaseModel->getNumberOfTickets(null);
        $data['total_tickets_resolved'] = $this->DatabaseModel->getNumberOfTickets('RESOLVED');
        $data['total_tickets_open'] = $this->DatabaseModel->getNumberOfTickets('NEW');
        $data['total_tickets_closed'] = $this->DatabaseModel->getNumberOfTickets('CLOSED');
        $data['total_tickets_assigned'] = $this->DatabaseModel->getNumberOfTickets('ASSIGNED');
        $data['total_tickets_canceled'] = $this->DatabaseModel->getNumberOfTickets('CANCELED');
        
//        if(!isset($tktStatus) && !isset($tktProbCat)){
            $sum_ticket_problems = $this->DatabaseModel->getNumTktProblems($datefrom,$dateto,$tktStatus,$tktProbCat);
//        }
        
        
        
        
        $data['sum_ticket_problems'] = $sum_ticket_problems;
        
        
        
        echo json_encode($data);
    }

    public function get_user_fund_admin() {

        $fund_admin = $this->DatabaseModel->getFundAdmin();

        echo json_encode($fund_admin);
    }

    public function get_user_dept_head() {

        $data = array('deptcode' => $this->input->post('deptcode'), 'offcode' => $this->input->post('offcode'));


        $rsDeptHead = $this->DatabaseModel->getDeptHead($data['deptcode'], $data['offcode']);

        echo json_encode($rsDeptHead);
    }

    public function get_ticket_workhistory() {
        $data = array();

        $data['tkt_id'] = $this->input->post('tkt_id');

        $rsTicketWorkUpdate = $this->DatabaseModel->getWorkUpdateHistory($data['tkt_id']);
        
        echo json_encode($rsTicketWorkUpdate);
    }
    
    public function get_ticket_details(){
        $ticket_id = $this->input->post('ticket_id');
        $rsTicketDetails = $this->DatabaseModel->getTicketDetails($ticket_id);
        
        if(!empty($rsTicketDetails)){
            echo json_encode($rsTicketDetails);
        } else {
            echo json_encode('');
        }
        
    }
    
    public function get_ac_report(){
        $datefrom = $this->input->post('datefrom');
        $dateto = $this->input->post('dateto');
        $tech = $this->input->post('tech');
        
        $ac_report_rs = $this->DatabaseModel->getACreport($datefrom,$dateto,$tech);
        if(!empty($ac_report_rs)){
             echo json_encode($ac_report_rs);
        } else {
            echo json_encode('');
        }
        
    }

    public function update_ticket_workhist() {
        $data = array();
        
        $data['work_update']['TKT_NO'] = $this->input->post('tkt_id');
        $data['work_update']['TECH_ID'] = $this->input->post('tkt_techid');
        $data['work_update']['UPDATE_DESCRIPTION'] = $this->input->post('tkt_update');
        $data['work_update']['CREATED'] = $this->GET_CURRENT_DATETIME();
        $data['work_update']['CREATED_BY'] = $this->LOGGED_USER;
        $data['work_update'] = $this->ARRAY_ALL_UPLOWCAPS($data['work_update']);

        $insert_result = $this->DatabaseModel->insertUniqueDataFromTable('TB_TKT_WRK_UP', $data['work_update']);
        if ($insert_result == true) {
            echo "1";
        }
    }

    private function ARRAY_ALL_UPLOWCAPS($data, $mode = 'strtoupper') {
        return array_map($mode, $data);
    }

    private function GET_CURRENT_DATETIME() {
        return date('Y-m-d H:i:s');
    }

}
