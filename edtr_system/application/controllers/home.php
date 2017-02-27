<?php

class Home extends MY_Controller {

    public $layout_view = 'layout/template';

    function __construct() {

        parent::__construct();

        if (!$this->session->userdata('logged_in_burial')) {

            redirect('login');
        }

        $this->layout->title('Home Page  | Burial Assistance Information System');
    }

    public function newpassPage() {

//        var_dump($this->session->userdata['logged_in_burial']);

        $data = array();

        $data['userid'] = $userid = $this->session->userdata['logged_in_burial']['id'];

        $data['username'] = $username = $this->session->userdata['logged_in_burial']['username'];

        $select_condition = array('id' => $userid, 'reset' => 1);

        $rs_newpass = $this->DatabaseModel->getDataFromTable('*', 'TB_USERS', $select_condition);

        if ($rs_newpass) {


            $rows_ctr = $this->DatabaseModel->getCountedRows();

            if ($rows_ctr > 0) {

                // $this->session->set_userdata('logged_in_burial',array('resetpass'=>1));

                $this->layout->view('content/newpass', $data);
            } else {
                redirect('home');
            }
        }
    }

    /* INDEX */

    public function index() {
        // $this->DatabaseModel->getOffices();
        $this->layout->view('content/home');
    }

    /* HOME */

    public function register() {

        $data = array();

        $data['errorMsg'] = '';

        $this->layout->view('content/register', $data);
    }
    
    
    
    /* REGISTRATION FORM V2 */
    public function registerFormV2(){
        $data = array();

        $data['errorMsg'] = '';

        $this->layout->view('content/NEW_register', $data);
    }

    public function verifyForm() {

        $this->form_validation->set_rules('appdata[CLAIMANT_FNAME]', 'Claimant Firstname', 'required');
        $this->form_validation->set_rules('appdata[CLAIMANT_MNAME]', 'Claimant Middlename', 'required');
        $this->form_validation->set_rules('appdata[CLAIMANT_LNAME]', 'Claimant Lastname', 'required');
        $this->form_validation->set_rules('appdata[DECEASED_FNAME]', 'Deceased Firstname', 'required');
        $this->form_validation->set_rules('appdata[DECEASED_MNAME]', 'Deceased Middlename', 'required');
        $this->form_validation->set_rules('appdata[DECEASED_LNAME]', 'Deceased Lastname', 'required|callback_dbdeceased_check');

        if ($this->form_validation->run() == FALSE) {

            $this->register();
        } else {

            $this->addQuickForm();
        }
    }

    public function dbdeceased_check($deceased) {

        $data = array();

        $data = $this->input->post('appdata');

        $data = array_map('strtoupper', $data);

        $rs = $this->DatabaseModel->checkDataExistsToTable($data, 'CLAIMANT_DECEASED');

        if ($rs == false) {

            $this->form_validation->set_message('dbdeceased_check', 'Deceased data is already exists and registered.');

            return false;
        }

        return true;
    }

    public function addQuickForm() {

        $data = array();

        $data = $this->input->post('appdata');

        $data = array_map('strtoupper', $data);

        $data['CREATED'] = date('Y-m-d H:i:s');
        $data['CREATED_BY'] = $this->session->userdata['logged_in_burial']['name'];
        $data['CREATED_LAST_IPADDRESS'] = $this->DatabaseModel->get_client_ip();
        $data['LAST_ACTION'] = 'INSERTED A RECORD';

        $duplicate_condition = array('DECEASED_FNAME' => $data['DECEASED_FNAME'], 'DECEASED_LNAME' => $data['DECEASED_LNAME']);


        $rs = $this->DatabaseModel->insertData($data, 'CLAIMANT_DECEASED', $duplicate_condition);

        if ($rs) {

            $data['errorMsg'] = "<div class='alert alert-success'><strong>Application successfully created.</strong></div>";
        } else {

            $data['errorMsg'] = "<div class='alert alert-danger'><strong>Application is invalid maybe deceased data already exists. Please try different deceased information/data.</strong></div>";
        }
        $this->layout->view('content/register', $data);
    }

    public function scsr() {

        $data = array();

        $data['errorMsg'] = '';

        $data['deceaseds'] = $this->DatabaseModel->getDataFromTable(array('DECEASED_LNAME', 'DECEASED_FNAME'), 'CLAIMANT_DECEASED', array('STEP' => 0));

        $data['claimants'] = $this->DatabaseModel->getDataFromTable(array('CLAIMANT_LNAME', 'CLAIMANT_FNAME'), 'CLAIMANT_DECEASED', array('STEP' => 0));

        $this->changeView('content/reports/save_scsr', $data);
    }

    public function save_scsr() {
        $data = array();

        $data['errorMsg'] = '';

        $data['deceaseds'] = $this->DatabaseModel->getDataFromTable(array('*'), 'CLAIMANT_DECEASED', array('STEP' => 0));

        // $data['claimants'] = $this->DatabaseModel->getDataFromTable(array('CLAIMANT_LNAME','CLAIMANT_FNAME'),'CLAIMANT_DECEASED',array('STEP'=>0));

        $data['barangays'] = $this->DatabaseModel->getBarangays();

        $this->changeView('content/reports/save_scsr', $data);
    }

    private function changeView($url, $data) {

        $this->layout->view($url, $data);
    }

    /* LOAD DECEASED & CLAIMANT FOR SCSR PAGE */

    public function loadDeceasedData() {
        $data = array();

        $select_deceased = $this->input->post('select_deceased');

        $data['current_selected'] = $select_deceased;

//        $deceased_name = explode(",", $select_deceased);

        $condition = array('CONTROL_NO' => $data['current_selected']);

        $rs_data = $this->DatabaseModel->getDataFromTable("*", "CLAIMANT_DECEASED", $condition);

        // var_dump($rs_data);

        if ($rs_data) {

            $d_midname = "";
            if (isset($rs_data[0]->DECEASED_MNAME)) {
                $d_midname = substr($rs_data[0]->DECEASED_MNAME, 0, 1) . ".";
            }

            $c_midname = "";
            if (isset($rs_data[0]->CLAIMANT_MNAME)) {
                $c_midname = substr($rs_data[0]->CLAIMANT_MNAME, 0, 1) . ".";
            }

            $data['scsr_selected_claimant_name'] = $rs_data[0]->CLAIMANT_FNAME . " " . $d_midname . " " . $rs_data[0]->CLAIMANT_LNAME;
            $data['scsr_selected_deceased_name'] = $rs_data[0]->DECEASED_FNAME . " " . $c_midname . " " . $rs_data[0]->DECEASED_LNAME;

            $data['scsr_sel_claimant_fname'] = $rs_data[0]->CLAIMANT_FNAME;
            $data['scsr_sel_claimant_mname'] = $c_midname;
            $data['scsr_sel_claimant_lname'] = $rs_data[0]->CLAIMANT_LNAME;

            $data['scsr_sel_deceased_fname'] = $rs_data[0]->DECEASED_FNAME;
            $data['scsr_sel_deceased_mname'] = $d_midname;
            $data['scsr_sel_deceased_lname'] = $rs_data[0]->DECEASED_LNAME;
        }
        $data['barangays'] = $this->DatabaseModel->getBarangays();
        $data['deceaseds'] = $this->DatabaseModel->getDataFromTable(array('*'), 'CLAIMANT_DECEASED', array('STEP' => 0));
        $this->changeView('content/reports/save_scsr', $data);
        // var_dump($data);
    }

    /* SAVING SCSR REPORT */

    public function savescsr() {
        $data = array();
        $data['errorMsg'] = '';
        $scsr_data = $this->input->post('scsr_data');
        $scsr_deceased_children = $this->input->post('scsr_deceased_children');
        // $scsr_deceased_children = array_map('strtoupper', $scsr_deceased_children);
        $scsr_data = array_map('strtoupper', $scsr_data);
        $control_no = $this->DatabaseModel->getNextIdRecord("SCSR_REPORT", "control_no");
        $scsr_data['created'] = date('Y-m-d H:i:s');
        $scsr_data['created_by'] = $this->session->userdata['logged_in_burial']['name'];
        $scsr_data['last_action'] = 'NEW RECORD ADDED';
        $control_no = $control_no[0]->ctr + 1;
        $scsr_data['scsr_rec_id'] = "SCR" . sprintf("%'.03d", $control_no);
        $scsr_data['scsr_rec_id'] = trim($scsr_data['scsr_rec_id']);
        if (isset($scsr_data['deceased_spouse_fname']) && isset($scsr_data['deceased_spouse_lname'])) {
            $scsr_data['deceased_spouse'] = $scsr_data['deceased_spouse_fname'] . " " . $scsr_data['deceased_spouse_lname'];
        } else {
            $scsr_data['deceased_spouse'] = '';
        }
        $scsr_data['deceased_address'] = "BRGY. " . $scsr_data['deceased_brgy'] . " " . $scsr_data['deceased_street_add'];
        $scsr_data['claimant_address'] = "BRGY. " . $scsr_data['claimant_brgy'] . " " . $scsr_data['claimant_street_add'];

        $d_midname = "";
        if (isset($d_midname)) {
            $d_midname = substr($scsr_data['deceased_mname'], 0) . ".";
        }

        $scsr_data['deceased_name'] = $scsr_data['deceased_fname'] . " " . $d_midname . " " . $scsr_data['deceased_lname'];

        $c_midname = "";
        if (isset($c_midname)) {
            $c_midname = substr($scsr_data['claimant_mname'], 0) . ".";
        }

        $scsr_data['claimant_name'] = $scsr_data['claimant_fname'] . " " . $c_midname . " " . $scsr_data['claimant_lname'];

        $insert_condition = array(
            'DECEASED_FNAME' => $scsr_data['deceased_fname'],
            'DECEASED_LNAME' => $scsr_data['deceased_lname'],
            'CLAIMANT_FNAME' => $scsr_data['claimant_fname'],
            'CLAIMANT_LNAME' => $scsr_data['claimant_lname']);

        $rs = $this->DatabaseModel->insertData($scsr_data, 'SCSR_REPORT', $insert_condition);
        if ($rs) {
            $child_ctr = 0;
            foreach ($scsr_deceased_children as $child) {
                if ($child['name'] != '' && $child['age'] != '' && $child['rel'] != '') {
                    $child['ctrid'] = $scsr_data['scsr_rec_id'];
                    $child = array_map('strtoupper', $child);
                    $rs = $this->DatabaseModel->insertData($child, 'TB_CHILDREN', array('name' => $child['name']));
                    // var_dump($rs);
                    $child_ctr++;
                }
            }
            $data_to_update = array(
                'SCR_ID' => $scsr_data['scsr_rec_id'],
                'CLAIMANT_CIVILSTATUS' => $scsr_data['claimant_cs'],
                'CLAIMANT_AGE' => $scsr_data['claimant_age'],
                'CLAIMANT_CONTACT' => $scsr_data['claimant_contact_no'],
                'CLAIMANT_ADDRESS' => $scsr_data['claimant_address'],
                'CLAIMANT_BRGY' => "BRGY. " . $scsr_data['claimant_brgy'],
                'CLAIMANT_STRT_ADD' => $scsr_data['claimant_street_add'],
                'CLAIMANT_RELATION' => $scsr_data['claimant_rel'],
                'DECEASED_DOD' => $scsr_data['deceased_dod'],
                'DECEASED_DOB' => $scsr_data['deceased_dob'],
                'DECEASED_COD' => $scsr_data['deceased_cod'],
                'DECEASED_POD' => $scsr_data['deceased_pod'],
                'DECEASED_POB' => $scsr_data['deceased_pob'],
                'DECEASED_LASTADD' => $scsr_data['deceased_address'],
                'DECEASED_BRGY' => "BRGY. " . $scsr_data['deceased_brgy'],
                'DECEASED_STRT_ADD' => $scsr_data['deceased_street_add'],
                'DECEASED_CIVILSTATUS' => $scsr_data['deceased_cs'],
                'DECEASED_SPOUSE_LNAME' => $scsr_data['deceased_spouse_fname'],
                'DECEASED_SPOUSE_FNAME' => $scsr_data['deceased_spouse_lname'],
                'DECEASED_NUMCHILD' => $child_ctr,
                'MODIFIED' => date('Y-m-d H:i:s'),
                'MODIFIED_BY' => $this->session->userdata['logged_in_burial']['name'],
                'MODIFIED_LAST_IPADDRESS' => $this->DatabaseModel->get_client_ip(),
                'LAST_ACTION' => 'SCSR REPORT SAVED',
                'STEP' => 1
            );
            $update_condition = array(
                'DECEASED_FNAME' => $scsr_data['deceased_fname'],
                'DECEASED_LNAME' => $scsr_data['deceased_lname'],
                'CLAIMANT_FNAME' => $scsr_data['claimant_fname'],
                'CLAIMANT_LNAME' => $scsr_data['claimant_lname']);
            $rs_update = $this->DatabaseModel->updateDataFromTableWhere('CLAIMANT_DECEASED', $data_to_update, $update_condition);
            $data['errorMsg'] = "<div class='alert alert-success'>";
            $data['errorMsg'] .= "<strong>SCSR Report successfully saved.</strong>.";
            $data['errorMsg'] .= "This is your SCSR Control no.";
            $data['errorMsg'] .= "<strong><a class='btn-link' href='print_scr/" . $scsr_data['scsr_rec_id'] . "'>" . $scsr_data['scsr_rec_id'] . "</a></strong></div>";
        } else {
            $data['errorMsg'] = "<div class='alert alert-danger'><strong>SCSR Report already exists.</strong></div>";
        }
        $data['deceaseds'] = $this->DatabaseModel->getDataFromTable(array('DECEASED_LNAME', 'DECEASED_FNAME'), 'CLAIMANT_DECEASED', array('STEP' => 0));
        $data['claimants'] = $this->DatabaseModel->getDataFromTable(array('CLAIMANT_LNAME', 'CLAIMANT_FNAME'), 'CLAIMANT_DECEASED', array('STEP' => 0));
        $this->changeView('content/reports/save_scsr', $data);
    }

    public function voucherOBR() {

        $data = array();

        $data['errorMsg'] = '';

        $control_no_ctr = $this->DatabaseModel->getNextIdRecord("DV_OBR_CERT", "rec_no");


        $dv_no = $control_no_ctr[0]->ctr + 1;

        $obr_no = $control_no_ctr[0]->ctr + 100 + 1;

        $dv_no = "DV" . sprintf("%'.04d\n", $dv_no);
        $obr_no = "OBR" . sprintf("%'.04d\n", $obr_no);

        $data['dv_no'] = $dv_no;
        $data['obr_no'] = $obr_no;

        $data['client_ctr_no'] = $this->DatabaseModel->getDataFromTable(
                array('CONTROL_NO',
            'CLAIMANT_LNAME',
            'CLAIMANT_FNAME',
            'CLAIMANT_ADDRESS',
            'DECEASED_LNAME',
            'DECEASED_FNAME'), 'CLAIMANT_DECEASED', array('STEP' => 1, 'ACTIVE' => 1));

        // var_dump($data);


        $this->changeView('content/reports/dv_obr_cert', $data);
    }

    /* VOUCHER - OBR - CERTIFICATION */

    public function loadClaimantData() {

        $data = array();

        $claimant_control_no = $this->input->post('selected_claimant');

        $data['current_selected'] = $claimant_control_no;

        $condition = array('CONTROL_NO' => $claimant_control_no);

        $rs_data = $this->DatabaseModel->getDataFromTable("*", "CLAIMANT_DECEASED", $condition);

//        var_dump($rs_data);

        if ($rs_data) {

            $d_midname = "";
            if (isset($rs_data[0]->DECEASED_MNAME)) {
                $d_midname = substr($rs_data[0]->DECEASED_MNAME, 0, 1) . ".";
            }
            $data['selected_deceased_name'] = $rs_data[0]->DECEASED_FNAME . " " . $d_midname . " " . $rs_data[0]->DECEASED_LNAME;

            $c_midname = "";
            if (isset($rs_data[0]->CLAIMANT_MNAME)) {
                $c_midname = substr($rs_data[0]->CLAIMANT_MNAME, 0, 1) . ".";
            }

            $data['selected_claimant_name'] = $rs_data[0]->CLAIMANT_FNAME . " " . $c_midname . " " . $rs_data[0]->CLAIMANT_LNAME;




            $data['deceased_dod'] = $rs_data[0]->DECEASED_DOD;
            $data['claimant_brgy'] = $rs_data[0]->CLAIMANT_BRGY;
            $data['deceased_address'] = $rs_data[0]->DECEASED_BRGY;

            $data['deceased_fname'] = $rs_data[0]->DECEASED_FNAME;
            $data['deceased_mname'] = $d_midname;
            $data['deceased_lname'] = $rs_data[0]->DECEASED_LNAME;

            $data['claimant_fname'] = $rs_data[0]->CLAIMANT_FNAME;
            $data['claimant_mname'] = $c_midname;
            $data['claimant_lname'] = $rs_data[0]->CLAIMANT_LNAME;


            $control_no_ctr = $this->DatabaseModel->getNextIdRecord("DV_OBR_CERT", "rec_no");
            $dv_no = $control_no_ctr[0]->ctr + 1;
            $obr_no = $control_no_ctr[0]->ctr + 100 + 1;
            $dv_no = "DV" . sprintf("%'.04d\n", $dv_no);
            $obr_no = "OBR" . sprintf("%'.04d\n", $obr_no);

            $data['dv_no'] = $dv_no;
            $data['obr_no'] = $obr_no;
        }
        $data['client_ctr_no'] = $this->DatabaseModel->getDataFromTable(
                array('CONTROL_NO',
            'CLAIMANT_LNAME',
            'CLAIMANT_FNAME',
            'CLAIMANT_ADDRESS',
            'DECEASED_LNAME',
            'DECEASED_FNAME'), 'CLAIMANT_DECEASED', array('STEP' => 1, 'ACTIVE' => 1));

        // var_dump($data);

        $this->changeView('content/reports/dv_obr_cert', $data);
    }

    /* SAVING OBR DV CERT */

    public function saveVrObrCert() {

        $data = array();

        $data['errorMsg'] = '';

        $dv_obr_cert_data = $this->input->post('dv_obr_cert');

        $dv_obr_cert_data['created'] = date('Y-m-d H:i:s');

        $dv_obr_cert_data['created_by'] = $this->session->userdata['logged_in_burial']['name'];

        $dv_obr_cert_data['last_action'] = 'NEW RECORD ADDED';

        $dv_obr_cert_data['created_last_ipaddress'] = $this->DatabaseModel->get_client_ip();

        $control_no_ctr = $this->DatabaseModel->getNextIdRecord("DV_OBR_CERT", "rec_no");

        $control_no = $control_no_ctr[0]->ctr + 1;

        $dv_obr_cert_data['dv_obr_cert_id'] = "VOC" . sprintf("%'.03d", $control_no);

        $dv_obr_cert_data['dv_obr_cert_id'] = trim($dv_obr_cert_data['dv_obr_cert_id']);

        $dv_obr_cert_data = array_map('strtoupper', $dv_obr_cert_data);

//        var_dump($dv_obr_cert_data);

        $insert_condition = array(
            'deceased_fname' => $dv_obr_cert_data['deceased_fname'],
            'deceased_lname' => $dv_obr_cert_data['deceased_lname'],
            'claimant_fname' => $dv_obr_cert_data['claimant_fname'],
            'claimant_lname' => $dv_obr_cert_data['claimant_lname']);

//        var_dump($insert_condition);

        $rs = $this->DatabaseModel->insertData($dv_obr_cert_data, 'DV_OBR_CERT', $insert_condition);

        if ($rs) {
            $data_to_update = array(
                'VOC_ID' => $dv_obr_cert_data['dv_obr_cert_id'],
                'MODIFIED' => date('Y-m-d H:i:s'),
                'MODIFIED_BY' => $this->session->userdata['logged_in_burial']['name'],
                'MODIFIED_LAST_IPADDRESS' => $this->DatabaseModel->get_client_ip(),
                'LAST_ACTION' => 'VOUCHER,OBR,CERTIFICATION SAVED',
                'STEP' => 2
            );
            $update_condition = array(
                'DECEASED_FNAME' => $dv_obr_cert_data['deceased_fname'],
                'DECEASED_LNAME' => $dv_obr_cert_data['deceased_lname'],
                'CLAIMANT_FNAME' => $dv_obr_cert_data['claimant_fname'],
                'CLAIMANT_LNAME' => $dv_obr_cert_data['claimant_lname']);
            // var_dump($data_to_update);
            $rs_update = $this->DatabaseModel->updateDataFromTableWhere('CLAIMANT_DECEASED', $data_to_update, $update_condition);

            $data['errorMsg'] = "<div class='alert alert-success'>";
            $data['errorMsg'] .= "<strong>Voucher, OBR, and Certification successfully saved.</strong>.";
            $data['errorMsg'] .= "This is your DV_OBR_CERT Control no. ";
            $data['errorMsg'] .= "<strong><a class='btn-link' href='print_vor/" . $dv_obr_cert_data['dv_obr_cert_id'] . "'>" . $dv_obr_cert_data['dv_obr_cert_id'] . "</a></strong></div>";
        } else {
            $data['errorMsg'] = "<div class='alert alert-danger'><strong>Voucher, OBR, and Certification already exists.</strong></div>";
        }


        $dv_no = $control_no;

        $obr_no = $control_no + 100;

        $dv_no = "DV" . sprintf("%'.04d\n", $dv_no);
        $obr_no = "OBR" . sprintf("%'.04d\n", $obr_no);

        $data['dv_no'] = $dv_no;
        $data['obr_no'] = $obr_no;

        $data['client_ctr_no'] = $this->DatabaseModel->getDataFromTable(
                array('CONTROL_NO',
            'CLAIMANT_LNAME',
            'CLAIMANT_FNAME',
            'CLAIMANT_ADDRESS',
            'DECEASED_LNAME',
            'DECEASED_FNAME'), 'CLAIMANT_DECEASED', array('STEP' => 1, 'ACTIVE' => 1));


        $this->changeView('content/reports/dv_obr_cert', $data);
    }

    public function searchApplication() {

        $data = array();

        $data['errorMsg'] = '';

        $data['results'] = $this->DatabaseModel->getClaimantDeceasedTransactions();
        //var_dump($data['results']);
        $this->changeView('content/search', $data);
    }

    public function findapp() {

        $data = array();

        $searchname = $this->input->post('searchname');

        $data['errorMsg'] = '';

        $data['results'] = $this->DatabaseModel->getDataFromTableLike('*', 'CLAIMANT_DECEASED', 'DECEASED_LNAME', 'CLAIMANT_LNAME', $searchname);

        $this->layout->view('content/search', $data);
    }

    public function updateapp() {

        $data = array();

        $update = $this->input->post('update');

        $data['errorMsg'] = '';

        $update = array_map('strtoupper', $update);

        $update['RELEASED_DATE'] = NULL;

        if ($update['STATUS'] == 'RELEASED') {

            $update['RELEASED_DATE'] = date('Y-m-d');
        }
//        var_dump($update);
        $rs = $this->DatabaseModel->updateDataFromTableWhere('CLAIMANT_DECEASED', array(
            'DECEASED_FNAME' => $update['DECEASED_FNAME'],
            'DECEASED_MNAME' => $update['DECEASED_MNAME'],
            'DECEASED_LNAME' => $update['DECEASED_LNAME'],
            'CLAIMANT_FNAME' => $update['CLAIMANT_FNAME'],
            'CLAIMANT_MNAME' => $update['CLAIMANT_MNAME'],
            'CLAIMANT_LNAME' => $update['CLAIMANT_LNAME'],
            'REMARKS' => $update['REMARKS'],
            'STATUS' => $update['STATUS'],
            'RELEASED_DATE' => $update['RELEASED_DATE'],
            'MODIFIED' => date('Y-m-d H:i:s'),
            'MODIFIED_BY' => $this->session->userdata['logged_in_burial']['name'],
            'MODIFIED_LAST_IPADDRESS' => $this->DatabaseModel->get_client_ip(),
            'LAST_ACTION' => 'RECORD MODIFIED'), array('CONTROL_NO' => $update['ID']));

        if ($rs) {

//          $data['errorMsg'] = "<div class='alert alert-success'><strong>Record successfully updated.</strong></div>";
            
            $rs = $this->DatabaseModel->updateDataFromTableWhere('SCSR_REPORT', array(
            'DECEASED_FNAME' => $update['DECEASED_FNAME'],
            'DECEASED_MNAME' => $update['DECEASED_MNAME'],
            'DECEASED_LNAME' => $update['DECEASED_LNAME'],
            'CLAIMANT_FNAME' => $update['CLAIMANT_FNAME'],
            'CLAIMANT_MNAME' => $update['CLAIMANT_MNAME'],
            'CLAIMANT_LNAME' => $update['CLAIMANT_LNAME'],
            'MODIFIED' => date('Y-m-d H:i:s'),
            'MODIFIED_BY' => $this->session->userdata['logged_in_burial']['name'],
            'MODIFIED_LAST_IPADDRESS' => $this->DatabaseModel->get_client_ip(),
            'LAST_ACTION' => 'RECORD MODIFIED'), array('SCSR_REC_ID' => $update['SCR_ID']));
            
            if($rs){
                $data['errorMsg'] = "<div class='alert alert-success'><strong>Record successfully updated.</strong></div>";
            } else {
                $data['errorMsg'] = "<div class='alert alert-danger'><strong>Failed to record.</strong></div>";
            }
            
        } else {

            $data['errorMsg'] = "<div class='alert alert-danger'><strong>Failed to record.</strong></div>";
        }

        $data['results'] = $this->DatabaseModel->getClaimantDeceasedTransactions();

        $this->layout->view('content/search', $data);
    }

    public function users() {

        $data = array();

        $data['errorMsg'] = '';

        $data['users'] = $this->DatabaseModel->getDataFromTable('*', 'TB_USERS', '');

        $this->layout->view('content/newuser', $data);
    }

    public function check_adduser() {

        $this->form_validation->set_rules('user[name]', 'User Full Name', 'trim|required');

        $this->form_validation->set_rules('user[user_username]', 'Username', 'alpha_numeric|trim|required');

        $this->form_validation->set_rules('user[user_password]', 'Password', 'alpha_numeric|trim');

        if ($this->form_validation->run() == FALSE) {

            $this->users();
        } else {

            $this->adduser();
        }
    }

    public function adduser() {

        $data = array();

        $data['errorMsg'] = '';

        $user = $this->input->post('user');

        if (isset($user['user_password']) || $user['user_password'] == "" || $user['user_password'] == null) {
            $user['user_password'] = "12345"; // default password
        }
        $user['user_password'] = password_hash($user['user_password'], 1);

        $user['name'] = strtoupper($user['name']);

        $user['name'] = explode(' ', $user['name']);

        $user['user_username'] = $user['user_username'];

        $user['user_fname'] = $user['name'][0];

        $user['user_lname'] = $user['name'][1];

        if (isset($user['name'][2])) {
            $user['user_lname'] = $user['lname'] . " " . $user['name'][2];
        }

        $duplicate_condition = array(
            'user_fname' => $user['user_fname'],
            'user_lname' => $user['user_lname'],
            'user_username' => $user['user_username']);

        $data_to_insert = array(
            'user_fname' => $user['user_fname'],
            'user_lname' => $user['user_lname'],
            'user_type' => $user['user_type'],
            'user_username' => $user['user_username'],
            'user_password' => $user['user_password'],
            'datetime_created' => date('Y-m-d H:i:s'),
            'last_action' => 'USER ACCOUNT CREATED',
            'created_by' => $this->session->userdata['logged_in_burial']['name']
        );

        $rs_insert = $this->DatabaseModel->insertData($data_to_insert, 'TB_USERS', $duplicate_condition);

        if ($rs_insert) {
            $data['errorMsg'] = "<div class='alert alert-success'><strong>User account successfully added.</strong></div>";
        } else {
            $data['errorMsg'] = "<div class='alert alert-danger'><strong>Failed to add user.</strong> User already exists.</div>";
        }
        $data['users'] = $this->DatabaseModel->getDataFromTable('*', 'TB_USERS', '');

        $this->layout->view('content/newuser', $data);
    }

    public function updateuser() {

        $data = array();

        $data['errorMsg'] = '';

        $update_user = $this->input->post('update');

        $update_user['user_password'] = password_hash($update_user['user_password'], 1);

        $data_to_update = array(
            'user_password' => $update_user['user_password'],
            'user_fname' => $update_user['user_fname'],
            'user_lname' => $update_user['user_lname'],
            'datetime_modified' => date('Y-m-d H:i:s'),
            'modified_by' => $this->session->userdata['logged_in_burial']['name'],
            'last_action' => 'USER ACCOUNT UPDATED'
        );

        $update_condition = array(
            'id' => $update_user['id']
        );

        $rs_updateuser = $this->DatabaseModel->updateDataFromTableWhere('TB_USERS', $data_to_update, $update_condition);

        if ($rs_updateuser) {

            $data['errorMsg'] = "<div class='alert alert-success'><strong>User account successfully updated.</strong></div>";
        } else {

            $data['errorMsg'] = "<div class='alert alert-danger'><strong>Failed to update account.</strong></div>";
        }


        $data['users'] = $this->DatabaseModel->getDataFromTable('*', 'TB_USERS', '');

        $this->layout->view('content/newuser', $data);
    }

    public function resetpass() {

        $data = array();

        $data['errorMsg'] = '';

        $user_reset = $this->input->post('reset');

        $user_reset['default_user_password'] = "12345"; // default password

        $user_reset['default_user_password'] = password_hash($user_reset['default_user_password'], 1);

        $data_to_update = array(
            'user_password' => $user_reset['default_user_password'],
            'datetime_modified' => date('Y-m-d H:i:s'),
            'modified_by' => $this->session->userdata['logged_in_burial']['name'],
            'last_action' => 'PASSWORD RESET',
            'reset' => 1
        );

        $update_condition = array('id' => $user_reset['id']);

        $rs_resetpass = $this->DatabaseModel->updateDataFromTableWhere('TB_USERS', $data_to_update, $update_condition);

        if ($rs_resetpass) {
            $data['errorMsg'] = "<div class='alert alert-success'><strong>User password successfully reset.</strong></div>";
        } else {
            $data['errorMsg'] = "<div class='alert alert-danger'><strong>Failed to reset password.</strong></div>";
        }

        $data['users'] = $this->DatabaseModel->getDataFromTable('*', 'TB_USERS', '');
        $this->layout->view('content/newuser', $data);
    }

    public function printReportPage() {
        $data['barangays'] = $this->DatabaseModel->getBarangays();
        $this->changeView('content/print', $data);
    }

    public function print_scr($id) {
        $data = array();
        $data['errorMsg'] = '';
        $condition = array('scsr_rec_id' => $id);
        $rs_data = $this->DatabaseModel->getDataFromTable("*", "SCSR_REPORT", $condition);
        $data['scsr_data'] = $rs_data;

        $data['scsr_data'][0]->claimant_name = $data['scsr_data'][0]->claimant_fname . " " . substr($data['scsr_data'][0]->claimant_mname, 0, 1) . ". " . $data['scsr_data'][0]->claimant_lname;
        $data['scsr_data'][0]->deceased_name = $data['scsr_data'][0]->deceased_fname . " " . substr($data['scsr_data'][0]->deceased_mname, 0, 1) . ". " . $data['scsr_data'][0]->deceased_lname;
//                var_dump($data['scsr_data']);
        $data['children'] = $this->DatabaseModel->getDataFromTable("*", "TB_CHILDREN", array('ctrid' => $id));
        $this->changeView('content/reports/print_scsr', $data);
    }

    public function print_vor($id) {
        $data = array();
        $data['errorMsg'] = '';
        $condition = array('dv_obr_cert_id' => $id);
        $rs_data = $this->DatabaseModel->getDataFromTable("*", "DV_OBR_CERT", $condition);

        $data['dv_obr_cert_data'] = $rs_data;
        $data['dv_obr_cert_data'][0]->claimant_mname = substr($data['dv_obr_cert_data'][0]->claimant_mname, 0, 1) . ".";
        $data['dv_obr_cert_data'][0]->deceased_mname = substr($data['dv_obr_cert_data'][0]->deceased_mname, 0, 1) . ".";
        $data['dv_obr_cert_data'][0]->dv_payee = $data['dv_obr_cert_data'][0]->claimant_fname . " " . $data['dv_obr_cert_data'][0]->claimant_mname . " " . $data['dv_obr_cert_data'][0]->claimant_lname;
        $data['dv_obr_cert_data'][0]->obr_payee = $data['dv_obr_cert_data'][0]->claimant_fname . " " . $data['dv_obr_cert_data'][0]->claimant_mname . " " . $data['dv_obr_cert_data'][0]->claimant_lname;
        $data['dv_obr_cert_data'][0]->cert_deceased_name = $data['dv_obr_cert_data'][0]->deceased_fname . " " . $data['dv_obr_cert_data'][0]->deceased_mname . " " . $data['dv_obr_cert_data'][0]->deceased_lname;
        $data['dv_obr_cert_data'][0]->cert_claimant_name = $data['dv_obr_cert_data'][0]->obr_payee;
//        var_dump($data['dv_obr_cert_data']);
        $this->changeView('content/reports/print_dv_obr_cert', $data);
    }

    public function loadPrintReport() {
        $data = array();
        $report_data = $this->input->post('report');
        $rs_data = $this->DatabaseModel->getSP_GetSumReport($report_data['datefrm'], $report_data['dateto'], $report_data['brgy'], $report_data['brgy_dist'], $report_data['status']);

        $data['barangays'] = $this->DatabaseModel->getBarangays();
        $data['report_res'] = $rs_data;
        $data['report_frm'] = $report_data['datefrm'];
        $data['report_to'] = $report_data['dateto'];
        $this->changeView('content/print', $data);
    }

    /* LOGOUT */

    public function logout() {

        if (isset($this->session->userdata['logged_in_burial'])) {

            $session_appdata = $this->session->userdata['logged_in_burial']['name'];

            $update_data = array
                (
                'logout' => date('Y-m-d H:i:s'),
                'lastout_ipaddress' => $this->DatabaseModel->get_client_ip(),
                'last_action' => 'LOGGED OUT'
            );

            $this->DatabaseModel->updateTransacDateTime('user_fname', $session_appdata, $update_data, 'TB_USERS');

            $this->session->unset_userdata('logged_in_burial');

            redirect('login');
        }
    }

}

?>