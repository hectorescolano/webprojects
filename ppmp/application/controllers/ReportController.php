<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of newPHPClass
 *
 * @author Hector
 */
class ReportController extends MY_Controller {

    //put your code here
    public $layout_view = 'layout/template';

    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('ses_ppmp')) {
           redirect('LoginController');
        }
        $this->layout->title('PPMP GENERATE REPORT');
    }

    public function index() {

        $data = array();

        $session_data = $this->session->userdata('ses_ppmp');

        $data['userlogged_data'] = $this->session->userdata['ses_ppmp'][0];



        // var_dump($data['userlogged_data']);
        // $rsDeptHead = $this->DatabaseModel->getDeptHead($data['userlogged_data']->address,$data['userlogged_data']->sys_suboffice_code);




        if(!isset($data['userlogged_data']->sys_suboffice_code) || empty($data['userlogged_data']->sys_suboffice_code)){
            $data['userlogged_data']->sys_suboffice_code = '0';
        } 

        $data['userlogged_acctcd'] = $this->DatabaseModel->getUserAccountCode($data['userlogged_data']->user_name,$data['userlogged_data']->sys_suboffice_code);

        if(empty($data['userlogged_acctcd'])){
            $data['userlogged_acctcd'] = $this->DatabaseModel->getUserAccountCodeByDeptCode($data['userlogged_data']->address);

        }


        // $data['userlogged_dept'] = $this->DatabaseModel->getUserDeptAndOffice($data['userlogged_data']->user_name);

        // var_dump($data['userlogged_dept']);

        // if(empty($data['userlogged_dept'])){
            $data['userlogged_dept'] = $this->DatabaseModel->getUserDeptAndOffice($data['userlogged_data']->address);
            $data['userlogged_dept2'] = $this->DatabaseModel->getUserDeptAndOffice2($data['userlogged_data']->address,$data['userlogged_data']->sys_suboffice_code);
        // }

            $session_data['department'] = $data['userlogged_dept2'][0]->description;

            $this->session->set_userdata('ses_ppmp',$session_data);

        // var_dump($this->session->userdata('ses_ppmp'));

        $this->layout->view('content/gen_ppmpView',$data);
    }

    public function GeneratePPMP() {
        $data = array();
        $data['ppmp'] = $this->input->post('ppmp');

         $data['userlogged_data'] = $this->session->userdata['ses_ppmp'][0];
         // var_dump($this->session->userdata['ses_ppmp']['department']);


        if(empty($data['ppmp']['off'])){
            $data['ppmp']['off'] = '0';
        }

        $year = $data['ppmp']['year'];
        $dept = $data['ppmp']['dept'];
        $off = $data['ppmp']['off'];
        $acct = $data['ppmp']['acctcode'];
        $contract_type = $data['ppmp']['contracttype'];

        // $contract_type = $this->DatabaseModel->getContractType($acct,$dept);

        // var_dump($contract_type);

        // if($contract_type[0]->contract_type == 1){

        //     $data['setup'] = 1;
        //     $res = $this->DatabaseModel->getPPMPreport($year, $dept, $off, $acct);
        // } else {
        //     $data['setup'] = 2;
        //     $res = $this->DatabaseModel->getPPMPreport2($year, $dept, $off, $acct);

        // }

        if($contract_type == 1) {
            $data['setup'] = 1;
            $res = $this->DatabaseModel->getPPMPreport($year, $dept, $off, $acct);
        } else {
            $data['setup'] = 2;
            $res = $this->DatabaseModel->getPPMPreport2($year, $dept, $off, $acct);
        }




        // if($contract_type[0]->contract_type >= 1 && $contract_type[0]->contract_type < 3){
        //         $data['setup'] = 2;
        //         $res = $this->DatabaseModel->getPPMPreport2($year, $dept, $off, $acct);

        // }

        // if($contract_type[0]->contract_type >=3) {
        //         $data['setup'] = 1;
        //         $res = $this->DatabaseModel->getPPMPreport($year, $dept, $off, $acct);
        // }


        
       if(!empty($res)){
            $data['ppmp_reports'] = $res;
       } else {
            $data['ppmp_reports'] = array();
       }

       // var_dump($data['userlogged_data']);
        
        $data['department'] = $this->session->userdata['ses_ppmp']['department'];

        
        $this->layout->view('content/reports/rep_ppmpView', $data);
        $this->layout->title('PRINT PPMP REPORT');
    }


    public function logoutUser(){
        if (isset($this->session->userdata['ses_ppmp'])) {

            // $session_appdata = $this->session->userdata['logged_in_burial']['name'];

            // $update_data = array
            //     (
            //     'logout' => date('Y-m-d H:i:s'),
            //     'lastout_ipaddress' => $this->DatabaseModel->get_client_ip(),
            //     'last_action' => 'LOGGED OUT'
            // );

            // $this->DatabaseModel->updateTransacDateTime('user_fname', $session_appdata, $update_data, 'TB_USERS');

            $this->session->unset_userdata('ses_ppmp');

            redirect('LoginController');
        }
    }

}
