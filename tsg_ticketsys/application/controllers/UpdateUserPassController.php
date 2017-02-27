<?php

/**
 * Description of UpdateUserPassword
 *
 * @author Hector
 */
class UpdateUserPassController extends MY_Controller{

    public $layout_view = 'layout/template';
    private $USER_LOGGED_SES_DATA = '';
    

    function __construct() {

        parent::__construct();

        if ($this->session->userdata('ses_ticketsys')) {

            $this->USER_LOGGED_SES_DATA = $this->session->userdata['ses_ticketsys'];

            if ($this->USER_LOGGED_SES_DATA['change_pass'] != 1) {
                redirect('HomeController');
            }
        }

        if (isset($this->USER_LOGGED_SES_DATA['ERROR_MSG'])) {
            $this->layout->errorMsg($this->USER_LOGGED_SES_DATA['ERROR_MSG']);
        }

        $this->layout->title('UPDATE USER PASSWORD | TICKETING SYSTEM');
    }

    public function index() {
        $data = array();
        //        var_dump($this->USER_LOGGED_SES_DATA);
        $data['id'] = $this->USER_LOGGED_SES_DATA['user_id'];
        $data['user_username'] = $this->USER_LOGGED_SES_DATA['username'];
        $this->layout->view('content/newpass', $data);
    }

    public function updateUserPass() {
        $data = array();
        $data['user_newpassword'] = $this->input->post('user_newpassword');
        $userid = $this->input->post('userid');
        if ($data['user_newpassword']['user_password'] != $data['user_newpassword']['confirm_user_password']) {
            $this->layout->errorMsg("<div class='alert alert-danger alert-dismissable fade in'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <strong>Password not matched!</strong> Please confirm and match your password.</div>");
            $this->USER_LOGGED_SES_DATA['ERROR_MSG'] = $this->layout->getErrorMsg();
            $this->session->set_userdata('ses_ticketsys', $this->USER_LOGGED_SES_DATA);
            redirect('LoginController');
        } else {
            unset($data['user_newpassword']['confirm_user_password']);
            $data['user_newpassword']['user_password'] = $this->getHashPassword($data['user_newpassword']['user_password']);
            $data['user_newpassword']['datetime_modified'] = $this->GET_CURRENT_DATETIME();
            $data['user_newpassword']['modified_by'] = $this->USER_LOGGED_SES_DATA['name'];
            $data['user_newpassword']['last_action'] = "PASSWORD UPDATED @ " . $this->GET_CURRENT_DATETIME() . " BY: " . $this->USER_LOGGED_SES_DATA['name'];
            $data['user_newpassword']['new_user'] = 0;
                        
            $update_result = $this->DatabaseModel->updateDataFromTableWhere('TB_USERS', $data['user_newpassword'], array('user_id' => $userid));
            if ($update_result == true) {
                $this->layout->errorMsg("<div class='alert alert-success alert-dismissable fade in'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <strong>Success!</strong> Your password was successfully updated.</div>");
                $this->logoutUser();
            } else {
                $this->layout->errorMsg("<div class='alert alert-danger alert-dismissable fade in'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <strong>Update failed!</strong> Error on updating password please try again.</div>");
                $this->USER_LOGGED_SES_DATA['ERROR_MSG'] = $this->layout->getErrorMsg();
                $this->session->set_userdata('ses_ticketsys', $this->USER_LOGGED_SES_DATA);
                redirect('LoginController');
            }
        }
    }

    private function GET_CURRENT_DATETIME() {
        return date('Y-m-d H:i:s');
    }

    private function logoutUser() {
        if (isset($this->USER_LOGGED_SES_DATA)) {
            $update_data = array
                (
                'datetime_lastlogout' => $this->GET_CURRENT_DATETIME(),
                'lastlogout_ipaddress' => $this->DatabaseModel->get_client_ip(),
                'last_action' => 'LOGGED OUT'
            );
            $this->DatabaseModel->updateTransacDateTime('user_fname', $this->USER_LOGGED_SES_DATA['name'], $update_data, 'TB_USERS');
            $this->session->unset_userdata('ses_ticketsys');
            redirect('LoginController');
        }
    }

    private function getHashPassword($pass) {
        return password_hash($pass, 1);
    }
    
    private function ARRAY_ALL_UPLOWCAPS($data, $mode = 'strtoupper') {
        return array_map($mode, $data);
    }

}
