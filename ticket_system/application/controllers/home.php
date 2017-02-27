<?php

class Home extends MY_Controller {

    public $layout_view = 'layout/home_template';
    private $user_ticket_bucketlist = array();
    private $user_office_id = 0;
    private $active_users = array();
    private $active_offices = array();
    private $tech_problems = array();
    private $msg_alert_type = 0;
    private $ticket_ctr_no = 0;
    private $error_msg = null;
    private $page_no = 0;
    private $search_mode = 0;
    private $data = array();
    private $logged_user = null;
    private $logged_user_type = null;
    private $logged_user_fname = null;
    private $logged_user_lname = null;
    private $logged_user_division = null;

    // default function redirects user to login page if user is not logged-in.
    function __construct() {

        parent::__construct();
        if (!$this->session->userdata('user_is_logged')) {
            redirect('login');
        }
        $this->logged_user = $this->session->userdata('user_is_logged')['name'];
        $this->logged_user_fname = $this->logged_user;
        $this->logged_user_lname = $this->session->userdata('user_is_logged')['lname'];
        $this->logged_user_type = $this->session->userdata('user_is_logged')['role'];
        $this->logged_user_division = $this->session->userdata('user_is_logged')['division'];
        $this->layout->title('Home Page | MICS-TSG Ticketing System');
        $this->active_offices = $this->DatabaseModel->getActiveOffices();
    }

    public function SaveNewIncident() {
        $this->data['ticket_data'] = $this->input->post('ticket');
        $this->data['ticket_data']['TKT_NO'] = $this->getNextTicketNo();
        $this->data['ticket_data']['CLIENT_FNAME'] = strtoupper($this->data['ticket_data']['CLIENT_FNAME']);
        $this->data['ticket_data']['CLIENT_LNAME'] = strtoupper($this->data['ticket_data']['CLIENT_LNAME']);
        $this->data['ticket_data']['DIVISION'] = strtoupper($this->data['ticket_data']['DIVISION']);
        $this->data['ticket_data']['REQ_DETAILS'] = strtoupper($this->data['ticket_data']['REQ_DETAILS']);
        $this->data['ticket_data']['PROB_DETAILS'] = strtoupper($this->data['ticket_data']['PROB_DETAILS']);
        $this->data['ticket_data']['CREATED'] = date('Y-m-d H:i:s');
        $this->data['ticket_data']['CREATED_BY'] = $this->session->userdata('user_is_logged')['name'];
        $rs = $this->DatabaseModel->saveDataToDb('TB_TICKETS', $this->data['ticket_data']);
        if ($rs) {
            $this->setErrorMsg('<strong>Success!</strong> New ticket added.');
            $this->setMsgAlertType(1);
        } else {
            $this->setErrorMsg('<strong>Error!</strong> Unable to create ticket.');
            $this->setMsgAlertType(0);
        }
        $this->index();
    }

    public function UpdateUserAccount() {
        $this->data['update_user'] = $this->input->post('update_user');
        $user_id = $this->data['update_user']['user_id'];
        unset($this->data['update_user']['user_id']);
        $office_cond = array('OfficeCode' => $this->data['update_user']['user_office']);
        $this->data['update_user']['Abreviation'] = $this->DatabaseModel->getData('OfficeMaster', 'Abreviation', $office_cond)[0]->Abreviation;
        $this->data['update_user']['datetime_modified'] = date('Y-m-d H:i:s');
        $this->data['update_user']['modified_by'] = $this->session->userdata('user_is_logged')['name'];

        if (!empty($this->data['update_user']['user_password'])) {
            $this->data['update_user']['user_password'] = password_hash($this->data['update_user']['user_password'], 1);
            $this->data['update_user']['new_user'] = 0;
        } else {
            unset($this->data['update_user']['user_password']);
        }

        $cond = array('user_id' => $user_id);
        $update_rs = $this->DatabaseModel->updateDataFromTableWhere('TB_USERS', $this->data['update_user'], $cond);
        if ($update_rs) {
            $this->data['alert_type'] = 'alert-success';
            $this->setErrorMsg('<strong>Success!</strong> User successfully updated.');
        } else {
            $this->data['alert_type'] = 'alert-danger';
            $this->setErrorMsg('<strong>Error!</strong> Unable to update user.');
        }
        $this->data['error_msg'] = $this->getErrorMsg();
        $this->accounts();
    }

    public function ResetUserPassword() {
        $this->data['reset_userpass'] = $this->input->post('reset_userpass');
        $user_id = $this->data['reset_userpass']['user_id'];
        unset($this->data['reset_userpass']['user_id']);
        $this->data['reset_userpass']['datetime_modified'] = date('Y-m-d H:i:s');
        $this->data['reset_userpass']['modified_by'] = $this->session->userdata('user_is_logged')['name'];
        $this->data['reset_userpass']['new_user'] = 1;
        $this->data['reset_userpass']['user_password'] = password_hash('12345', 1); // default password
        $cond = array('user_id' => $user_id);
        $update_rs = $this->DatabaseModel->updateDataFromTableWhere('TB_USERS', $this->data['reset_userpass'], $cond);
        if ($update_rs) {
            $this->data['alert_type'] = 'alert-success';
            $this->setErrorMsg('<strong>Success!</strong> User password succesfully reset.');
        } else {
            $this->data['alert_type'] = 'alert-danger';
            $this->setErrorMsg('<strong>Error!</strong> Unable to user password.');
        }
        $this->data['error_msg'] = $this->getErrorMsg();
        $this->accounts();
    }

    public function DeleteUserAccount() {
        $this->data['delete_user'] = $this->input->post('delete_user');
        $user_id = $this->data['delete_user']['user_id'];
        unset($this->data['delete_user']['user_id']);
        $this->data['delete_user']['datetime_modified'] = date('Y-m-d H:i:s');
        $this->data['delete_user']['modified_by'] = $this->session->userdata('user_is_logged')['name'];
        $this->data['delete_user']['active'] = 0;
        $cond = array('user_id' => $user_id);
        $update_rs = $this->DatabaseModel->updateDataFromTableWhere('TB_USERS', $this->data['delete_user'], $cond);
        if ($update_rs) {
            $this->data['alert_type'] = 'alert-success';
            $this->setErrorMsg('<strong>Success!</strong> User successfully deleted.');
        } else {
            $this->data['alert_type'] = 'alert-danger';
            $this->setErrorMsg('<strong>Error!</strong> Failed to delete user, please try again.');
        }
        $this->data['error_msg'] = $this->getErrorMsg();
        $this->accounts();
    }

    public function searchUser() {
        $this->setSearchMode(1);
        $this->data['search_user'] = $this->input->post('search_user');
        $output = array('user_id', 'user_type', 'user_username', 'user_fname', 'user_lname', 'user_lname', 'user_office', 'user_division', 'user_email', 'user_contact', 'user_location', 'Abreviation');
        $rs = $this->DatabaseModel->searchData('TB_USERS', $output, $this->data['search_user']);
        $this->setActiveUserList($rs);
        $this->accounts();
    }

    public function createUser() {
        $this->data['new_user'] = $this->input->post('new_user');
        $this->data['new_user']['user_password'] = password_hash('12345', 1); // default password
        $this->data['new_user']['user_username'] = substr($this->data['new_user']['user_fname'], 0, 2) . "" . $this->data['new_user']['user_lname']; // generated username
        $office_cond = array('OfficeCode' => $this->data['new_user']['user_office']);
        $this->data['new_user']['Abreviation'] = $this->DatabaseModel->getData('OfficeMaster', 'Abreviation', $office_cond)[0]->Abreviation;
        $this->data['new_user']['datetime_created'] = date('Y-m-d H:i:s');
        $this->data['new_user']['created_by'] = $this->session->userdata('user_is_logged')['name'];
        $cond = array('user_fname' => $this->data['new_user']['user_fname'], 'user_lname' => $this->data['new_user']['user_lname']);
        $duplicate = $this->DatabaseModel->checkDataAlreadyExist('TB_USERS', '*', $cond);
        if (!$duplicate) {
            $rs = $this->DatabaseModel->saveDataToDb('TB_USERS', $this->data['new_user']);
            $this->data['alert_type'] = 'alert-success';
            $this->setErrorMsg('<strong>Success!</strong> User successfully created.');
        } else {
            $this->data['alert_type'] = 'alert-danger';
            $this->setErrorMsg('<strong>Error!</strong>  User already exist.');
        }
        $this->data['error_msg'] = $this->getErrorMsg();
        $this->accounts();
    }
    
    public function saveWorkUp(){
       
        $this->data = $this->input->post('work_update');
        $this->data['CREATED_BY'] = strtoupper($this->getLoggedUser());
        $this->data['CREATED'] = $this->getCurrentDateTime();
//        var_dump($this->data);
        $rs = $this->DatabaseModel->saveDataToDb("TB_TKT_WRK_UP", $this->getData());
        $this->clearData();
        if($rs){
            $this->setErrorMsg("<strong>Success!</strong> Ticket work history updated.");
            $this->setMsgAlertType(1);
        } else {
            $this->setErrorMsg("<strong>Error!</strong> Unable to update work history.");
            $this->setMsgAlertType(0);
        }
        $this->index();
    }

    public function index() {
        
        if (!empty($this->getErrorMsg())) {
            $this->data['error_msg'] = $this->getErrorMsg();
        }
        
        if (!empty($this->getMsgAlertType())) {
            $this->data['alert_type'] = $this->getMsgAlertType();
        }
        
        $this->data['logged_user_division'] = $this->getLoggedUserDivision();
        $this->data['logged_user_fname'] = strtoupper($this->getLoggedUser());
        $this->data['logged_user_lname'] = strtoupper($this->getLoggedUserLname());
        $this->data['userType'] = $this->getLoggedUserType();
        $this->data['userOfficeId'] = $this->getUserOfficeId($this->getLoggedUser());
        $this->data['rsUserTicketBucketList'] = $this->getUserTicketBucketList($this->getLoggedUser(), $this->getLoggedUserType());
        $this->data['page_no'] = $this->page_no;
        $this->data['rsActiveOffices'] = $this->getActiveOffices();
        $this->data['rsTechProblems'] = $this->getTechProblems();
        $this->data['available_techs'] = $this->getAvailableTechs();
        $this->layout->title('Home Page | MICS-TSG Ticketing System');
        $this->layout->view('content/home', $this->getData());
        $this->clearData();
    }

    private function setMsgAlertType($type = 0) {
        if ($type == 0) {
            $this->msg_alert_type = 'alert-danger';
        } else {
            
            $this->msg_alert_type = 'alert-success';
        }
    }

    private function clearData() {
        $this->data = array();
    }

    private function getPageNo() {
        return $this->page_no;
    }

    private function getData() {
        return $this->data;
    }

    private function setPageNo($num) {
        $this->page_no = $num;
    }

    private function setErrorMsg($message) {
        $this->error_msg = $message;
    }

    private function setActiveUserList($data) {
        $this->data['active_user_list'] = $data;
    }

    private function setSearchMode($mode) {
        $this->search_mode = $mode;
    }

    private function getSearchMode() {
        return $this->search_mode;
    }

    private function getActiveUserList() {
        return $this->data['active_user_list'];
    }

    private function getErrorMsg() {
        return $this->error_msg;
    }

    private function getUserTicketBucketList($user, $user_type) {
        $this->user_ticket_bucketlist = $this->DatabaseModel->getUserTicketBucketList($user, $user_type);
        return $this->user_ticket_bucketlist;
    }

    private function getUserOfficeId($user) {
        $this->user_office_id = $this->DatabaseModel->getData('TB_USERS', 'user_office', array('user_fname' => $user))[0]->user_office;
//        var_dump($this->user_office_id);
        return $this->user_office_id;
    }

    private function getActiveOffices() {
        return $this->active_offices;
    }
    
    private function getCurrentDateTime(){
        return date('Y-m-d H:i:s');
    }
    
    private function getAvailableTechs(){
        $techs = $this->DatabaseModel->getAvailableTechs();
        return $techs;
    }

    private function getLoggedUserDivision() {
        return $this->logged_user_division;
    }

    private function getLoggedUserLname() {
        return $this->logged_user_lname;
    }

    private function getLoggedUser() {
//        var_dump($this->logged_user);
        return $this->logged_user;
    }

    private function getLoggedUserType() {
        return $this->logged_user_type;
    }

    private function getTechProblems() {
        $this->tech_problems = $this->DatabaseModel->getData('TB_PROBLEMS', '*');
        return $this->tech_problems;
    }

    private function getMsgAlertType() {
        return $this->msg_alert_type;
    }

    private function getNextTicketNo() {
        $this->ticket_ctr_no = $this->DatabaseModel->getTicketControlNo('TB_TICKETS', 'RECORD_NO');
        return $this->ticket_ctr_no;
    }

    private function getActiveUsers() {
        $this->active_users = $this->DatabaseModel->getActiveUsers();
        return $this->active_users;
    }

    public function accounts() {
//        $data = array();
        $this->setPageNo(4);
        $this->data['logged_user_fname'] = strtoupper($this->getLoggedUser());
        $this->data['logged_user_lname'] = strtoupper($this->getLoggedUserLname());
        $this->data['page_no'] = $this->getPageNo();
        $this->data['offices'] = $this->getActiveOffices();
        $this->data['rsActiveOffices'] = $this->getActiveOffices();
        $this->data['rsTechProblems'] = $this->getTechProblems();
        if ($this->getSearchMode() == 1) {
            $this->data['active_user_list'] = $this->getActiveUserList();
        } else {
            $this->data['active_user_list'] = $this->getActiveUsers();
        }


        $this->layout->title('User Account Page | MICS-TSG Ticketing System');
        $this->layout->view('content/accounts', $this->getData());
        $this->clearData();
        $this->setSearchMode(0);
    }

    public function logout() {
        if (isset($this->session->userdata['user_is_logged'])) {
            $session_user_fname = $this->session->userdata['user_is_logged']['name'];
            $data_to_update = array('datetime_lastlogout' => date('Y-m-d H:i:s'));
            $update_condition = array('user_fname' => $session_user_fname);
            $this->DatabaseModel->updateDataFromTableWhere("tb_users", $data_to_update, $update_condition);
            $this->session->unset_userdata('user_is_logged');
            redirect('login');
        }
    }

}

?>