<?php

class LoginController extends MY_Controller {

    public $layout_view = 'layout/template';
    private $USER_LOGGED_SES_DATA = '';

    function __construct() {

        parent::__construct();

        if ($this->session->userdata('ses_ticketsys')) {

            $this->USER_LOGGED_SES_DATA = $this->session->userdata['ses_ticketsys'];

            if ($this->USER_LOGGED_SES_DATA['change_pass'] != 1) {
                redirect('HomeController');
            } else {
               redirect('UpdateUserPassController');
            }
        }

        $this->layout->title('LOGIN | TICKETING SYSTEM');
    }

    public function index() {
        $this->layout->view('content/loginView');
    }


    public function loginUser() {
        $data = $this->input->post('login');
 
        $this->storeUserSession($data['username'], $data['password']);
    }

    private function storeUserSession($user_name, $user_password) {
        $logged_user_data = $this->DatabaseModel->login($user_name, 'user_username', $user_password, 'tb_users', 'ses_ticketsys', '');
        if (isset($logged_user_data) || $logged_user_data) {
            if ($logged_user_data == 1) {
                redirect('HomeController');
            }
            if ($logged_user_data == 2) {
                redirect('UpdateUserPassController');
            }
            if ($logged_user_data == 0) {
                $data = array();
                $data['message'] = "User account is not found and invalid. Please login with the correct user account. <a href='LoginController'>[Back to Login Page]</a>";
                $data['heading'] = "Login Failed";
                $this->layout->view('errors/html/error_404', $data);
            }
        }
    }

}

?>