<?php

class HomeController extends MY_Controller {

    public $layout_view = 'layout/template';
    private $USER_DEFAULT_PASSWORD = '12345';
    private $LOGGED_USER = '';
    private $LOGGED_USER_ROLE = '';
    private $USER_LOGGED_SES_DATA = '';
    private $ERROR_MSG = '';

    function __construct() {

        parent::__construct();

        if (!$this->session->userdata('ses_ticketsys')) {

            redirect('LoginController');
        } else {

            $this->USER_LOGGED_SES_DATA = $this->session->userdata['ses_ticketsys'];

            if ($this->USER_LOGGED_SES_DATA['change_pass'] == 1) {

//                redirect('UpdateUserPassController');
            }
        }

        $this->LOGGED_USER = $this->session->userdata['ses_ticketsys']['name'];
        $this->LOGGED_USER_ROLE = $this->session->userdata['ses_ticketsys']['role'];
        $this->layout->title('HOME | TICKETING SYSTEM');

        if (isset($this->USER_LOGGED_SES_DATA['ERROR_MSG'])) {
            $this->layout->errorMsg($this->USER_LOGGED_SES_DATA['ERROR_MSG']);
        }
    }

    public function index() {
        $data = array();
        $user_logged_data = $this->session->userdata['ses_ticketsys'];
        $data['ticket_details_list'] = $this->DatabaseModel->getAllTicketsDetails();
        $data['rsUserTicketBucketList'] = $this->DatabaseModel->getUserTicketBucketList($user_logged_data['name'], $user_logged_data['role'], $user_logged_data['user_id']);
        //var_dump($data['rsUserTicketBucketList']);
        if ($user_logged_data['role'] == 1) {
            $data['rsOffices'] = $this->DatabaseModel->getUserOffice($user_logged_data['office']);
        } else {
            $data['rsOffices'] = $this->DatabaseModel->getActiveOffices();
        }
        $data['rsTicketStatus'] = $this->DatabaseModel->getTicketStatus();
        $data['available_techs'] = $this->DatabaseModel->getAllTechnician();
//      var_dump($data['available_techs']);
        $data['rsActiveUsers'] = $this->DatabaseModel->getActiveUsers();
        $data['rsUserTypeRoles'] = $this->DatabaseModel->getUserTypeRoles();
        $data['rsProblemCats'] = $this->DatabaseModel->getData('TB_PROBLEMS', '*');
        $data['rsUrgency'] = $this->DatabaseModel->getData('TB_URGENCY', '*');
        $data['userType'] = $user_logged_data['role'];
        $data['loggedUserDetails'] = $user_logged_data;
        $this->layout->view('content/HomeView', $data);
    }

    public function confirmResetPass() {
        $userid_to_reset = $this->input->post('reset_confirm_userid');
//        var_dump($userid_to_reset);
        $data_to_update = array('new_user' => 1, 'user_password' => '12345', 'datetime_modified' => $this->GET_CURRENT_DATETIME(), 'modified_by' => $this->LOGGED_USER, 'last_action' => 'PASSWORD RESET');
        $data_to_update = $this->ARRAY_ALL_UPLOWCAPS($data_to_update);
        $reset_result = $this->DatabaseModel->updateDataFromTableWhere('TB_USERS', $data_to_update, array('user_id' => $userid_to_reset));
        if ($reset_result == true) {
            $this->layout->errorMsg("<div class='alert alert-success alert-dismissable fade in'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <strong>Success!</strong> Password was successfully reset.</div>");
        } else {
//            $this->layout->errorMsg("<div class='alert alert-danger alert-dismissable fade in'>
//                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
//                <strong>Update failed!</strong> Please try again.</div>");
        }
//        $this->index();
        $this->USER_LOGGED_SES_DATA['ERROR_MSG'] = $this->layout->getErrorMsg();
        $this->session->set_userdata('ses_ticketsys', $this->USER_LOGGED_SES_DATA);
        redirect('HomeController');
    }

    public function regTicket() {
        $data = array();
        $data['new_ticket'] = $this->input->post("new_ticket");
        $data['new_ticket']['TKT_NO'] = $this->DatabaseModel->getNextId();
        $record_no = $this->DatabaseModel->generateId();
        $data['new_ticket']['CREATED'] = date('Y-m-d H:i:s');
        $data['new_ticket']['CREATED_BY'] = $this->session->userdata['ses_ticketsys']['name'];
        $data_unique = array('RECORD_NO' => $record_no[0]->CTR + 1);
        $data['new_ticket'] = $this->ARRAY_ALL_UPLOWCAPS($data['new_ticket']);
        $rs = $this->DatabaseModel->insertUniqueDataFromTable('TB_TICKETS', $data['new_ticket'], $data_unique);
        if ($rs == true) {
            $this->layout->errorMsg("<div class='alert alert-success alert-dismissable fade in'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <strong>Success!</strong> Ticket was successfully added.</div>");
        } else {
            $this->layout->errorMsg("<div class='alert alert-danger alert-dismissable fade in'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <strong>Duplicate found!</strong> Ticket was already added.</div>");
        }
        $this->USER_LOGGED_SES_DATA['ERROR_MSG'] = $this->layout->getErrorMsg();
        $this->session->set_userdata('ses_ticketsys', $this->USER_LOGGED_SES_DATA);
        redirect('HomeController');
    }

    public function updateTicket() {

        $data = array();
        $data['update_ticket'] = $this->input->post("update_ticket");
        $data['update_ticket']['DATERESOLVED'] = '';
        $data['update_ticket']['DATECLOSED'] = '';
        $data['update_ticket']['DATECANCELED'] = '';
        $data['update_ticket']['DATEASSIGNED'] = '';
        $data['update_ticket']['RESOLVED_BY'] = '';
        $data['update_ticket']['CLOSED_BY'] = '';
        $data['update_ticket']['CANCELLED_BY'] = '';
        
        
        


        switch ($data['update_ticket']['TKT_STATUS']) {
            case 'RESOLVED': $data['update_ticket']['DATERESOLVED'] = $this->GET_CURRENT_DATETIME();
                $data['update_ticket']['RESOLVED_BY'] = $this->LOGGED_USER;
                break;
            case 'CLOSED': $data['update_ticket']['DATECLOSED'] = $this->GET_CURRENT_DATETIME();
                $data['update_ticket']['CLOSED_BY'] = $this->LOGGED_USER;
                break;
            case 'CANCELED': $data['update_ticket']['DATECANCELED'] = $this->GET_CURRENT_DATETIME();
                $data['update_ticket']['CANCELLED_BY'] = $this->LOGGED_USER;
                break;
            case 'ASSIGNED': $data['update_ticket']['DATEASSIGNED'] = $this->GET_CURRENT_DATETIME();
                break;
            default:break;
        }


        $data_to_update = array(
            'STATUS' => $data['update_ticket']['TKT_STATUS'],
            'URGENCY' => $data['update_ticket']['URGENCY'],
            'SERVICE_DONE' => $data['update_ticket']['SERVICE_DONE'],
            'ASSIGNED_TECH_ID' => $data['update_ticket']['TECH_ID'],
            'RESOLVED_BY' => $data['update_ticket']['RESOLVED_BY'],
            'DATERESOLVED' => $data['update_ticket']['DATERESOLVED'],
            'CLOSED_BY' => $data['update_ticket']['CLOSED_BY'],
            'DATECLOSED' => $data['update_ticket']['DATECLOSED'],
            'CANCELLED_BY' => $data['update_ticket']['CANCELLED_BY'],
            'DATECANCELED' => $data['update_ticket']['DATECANCELED'],
            'DATEASSIGNED' => $data['update_ticket']['DATEASSIGNED'],
            'MODIFIED' => $this->GET_CURRENT_DATETIME(),
            'MODIFIED_BY' => $this->LOGGED_USER,
            'REMARKS' => 'TICKET was ' . $data['update_ticket']['TKT_STATUS'] . ' at ' . $this->GET_CURRENT_DATETIME() . ' by ' . $this->LOGGED_USER);

        $data_to_update = $this->ARRAY_ALL_UPLOWCAPS($data_to_update);


        $update_result = $this->DatabaseModel->updateDataFromTableWhere('TB_TICKETS', $data_to_update, array('TKT_NO' => $data['update_ticket']['TKT_ID']));
        if ($update_result == true) {
            $this->layout->errorMsg("<div class='alert alert-success alert-dismissable fade in'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <strong>Success!</strong> Ticket was successfully updated.</div>");
        }

        $this->USER_LOGGED_SES_DATA['ERROR_MSG'] = $this->layout->getErrorMsg();
        $this->session->set_userdata('ses_ticketsys', $this->USER_LOGGED_SES_DATA);
        redirect('HomeController');
    }

    public function closeTicket() {
        $data = array();
        $data['ticket_close_id'] = $this->input->post('close_tktid');
        $data['ticket_close'] = $this->input->post('ticket_close');
        $data['ticket_close']['CLOSED_BY'] = $this->LOGGED_USER;
        $data['ticket_close']['DATECLOSED'] = $this->GET_CURRENT_DATETIME();
        $data['ticket_close']['MODIFIED'] = $this->GET_CURRENT_DATETIME();
        $data['ticket_close']['MODIFIED_BY'] = $this->LOGGED_USER;
        $data['ticket_close']['STATUS'] = 'CLOSED';
        $data['ticket_close']['REMARKS'] = 'TICKET was ' . $data['ticket_close']['STATUS'] . ' at ' . $this->GET_CURRENT_DATETIME() . ' by ' . $this->LOGGED_USER;
        $data['ticket_close'] = $this->ARRAY_ALL_UPLOWCAPS($data['ticket_close']);
        $update_condition = array('TKT_NO' => $data['ticket_close_id']);

        $update_result = $this->DatabaseModel->updateDataFromTableWhere('tb_tickets', $data['ticket_close'], $update_condition);

        if ($update_result == true) {
            $this->layout->errorMsg("<div class='alert alert-success alert-dismissable fade in'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <strong>Success!</strong> Ticket was successfully closed.</div>");
        } else {
            
        }

        $this->USER_LOGGED_SES_DATA['ERROR_MSG'] = $this->layout->getErrorMsg();
        $this->session->set_userdata('ses_ticketsys', $this->USER_LOGGED_SES_DATA);
        redirect('HomeController');
    }

    public function newReport() {
        $data = array();
        $data['new_ticket_report'] = $this->input->post('new_report');
//        var_dump($this->DatabaseModel->getNumberOfTickets('CLOSED'));
    }

    public function submitWorkUp() {

//        $data = array();
//        $data['work_update'] = $this->input->post('work_update');
//        $data['work_update']['CREATED'] = $this->GET_CURRENT_DATETIME();
//        $data['work_update']['CREATED_BY'] = $this->LOGGED_USER;
//        $data['work_update'] = $this->ARRAY_ALL_UPLOWCAPS($data['work_update']);
//
//        $insert_result = $this->DatabaseModel->insertUniqueDataFromTable('TB_TKT_WRK_UP', $data['work_update']);
//
//        if ($insert_result == true) {
//            $this->layout->errorMsg("<div class='alert alert-success alert-dismissable fade in'>
//                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
//                <strong>Success!</strong> Ticket work update was added.</div>");
//        } else {
//            
//        }
//
//        $this->USER_LOGGED_SES_DATA['ERROR_MSG'] = $this->layout->getErrorMsg();
//        $this->session->set_userdata('ses_ticketsys', $this->USER_LOGGED_SES_DATA);
//        redirect('HomeController');
    }

    public function updateUserAccountDtl() {
        $data = array();
        $data['update_user'] = $this->input->post('update_user');
        $userid_to_update = $this->input->post('user_id');
        $data['update_user'] += array('datetime_modified' => $this->GET_CURRENT_DATETIME(), 'modified_by' => $this->LOGGED_USER, 'last_action' => 'USER UPDATED');
        $data['update_user'] = $this->ARRAY_ALL_UPLOWCAPS($data['update_user']);
        $update_result = $this->DatabaseModel->updateDataFromTableWhere('TB_USERS', $data['update_user'], array('user_id' => $userid_to_update));
//        var_dump($data);

        if ($update_result == true) {
            $this->layout->errorMsg("<div class='alert alert-success alert-dismissable fade in'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <strong>Success!</strong> User was successfully updated.</div>");
        } else {
            
        }
        $this->USER_LOGGED_SES_DATA['ERROR_MSG'] = $this->layout->getErrorMsg();
        $this->session->set_userdata('ses_ticketsys', $this->USER_LOGGED_SES_DATA);
        redirect('HomeController');
    }

    public function regNewUser() {
        $data = array();
        $data['new_user'] = $this->input->post("new_user");
        $data['new_user']['Abreviation'] = $this->DatabaseModel->getAbreviation($data['new_user']['user_office']);
        $data['new_user']['user_username'] = $data['new_user']['user_fname'][0] . "" . $data['new_user']['user_lname'];
        $data['new_user']['user_password'] = $this->USER_DEFAULT_PASSWORD;
        $data['new_user']['created_by'] = $this->LOGGED_USER;
        $data['new_user']['datetime_created'] = $this->GET_CURRENT_DATETIME();
        $data['new_user']['last_action'] = 'USER ACCOUNT CREATED AT ' . $this->GET_CURRENT_DATETIME() . ' BY:' . $this->LOGGED_USER;
        $data['new_user'] = $this->ARRAY_ALL_UPLOWCAPS($data['new_user']);

        $unique_data = array(
            'user_fname' => $data['new_user']['user_fname'],
            'user_lname' => $data['new_user']['user_lname'],
            'user_office' => $data['new_user']['user_office']);
        $save_result = $this->DatabaseModel->insertUniqueDataFromTable('TB_USERS', $data['new_user'], $unique_data);
        if ($save_result == true) {
            $this->layout->errorMsg("<div class='alert alert-success alert-dismissable fade in'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <strong>Success!</strong> User was successfully registered.</div>");
        } else {
            $this->layout->errorMsg("<div class='alert alert-danger alert-dismissable fade in'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <strong>Duplicate found!</strong> User already exist.</div>");
        }

        $this->USER_LOGGED_SES_DATA['ERROR_MSG'] = $this->layout->getErrorMsg();
        $this->session->set_userdata('ses_ticketsys', $this->USER_LOGGED_SES_DATA);
        redirect('HomeController');
    }

    private function ARRAY_ALL_UPLOWCAPS($data, $mode = 'strtoupper') {
        return array_map($mode, $data);
    }

    private function GET_CURRENT_DATETIME() {
        return date('Y-m-d H:i:s');
    }

    public function logoutUser() {
        if (isset($this->session->userdata['ses_ticketsys'])) {
            $session_appdata = $this->session->userdata['ses_ticketsys']['name'];
            $update_data = array
                (
                'datetime_lastlogout' => date('Y-m-d H:i:s'),
                'lastlogout_ipaddress' => $this->DatabaseModel->get_client_ip(),
                'last_action' => 'LOGGED OUT'
            );
            $this->DatabaseModel->updateTransacDateTime('user_fname', $session_appdata, $update_data, 'TB_USERS');
            $this->session->unset_userdata('ses_ticketsys');
            redirect('LoginController');
        }
    }

    public function confirmDel() {
        $data = array();
        $ticket_id = $this->input->post('ticketid');
        $user_logged_name = $this->session->userdata['ses_ticketsys']['name'];
        $data_update = array('ACTIVE' => 0, 'MODIFIED' => date('Y-m-d H:i:s'), 'MODIFIED_BY' => $user_logged_name);
        $data_update = $this->ARRAY_ALL_UPLOWCAPS($data_update);
        $rs = $this->DatabaseModel->updateFrmTable($data_update, 'TKT_NO', trim($ticket_id), 'TB_TICKETS');
        if ($rs == true) {
            $this->layout->errorMsg("<div class='alert alert-success alert-dismissable fade in'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <strong>Success!</strong> Ticket was successfully deleted.</div>");
        }
        $this->USER_LOGGED_SES_DATA['ERROR_MSG'] = $this->layout->getErrorMsg();
        $this->session->set_userdata('ses_ticketsys', $this->USER_LOGGED_SES_DATA);
        redirect('HomeController');
    }

}

?>