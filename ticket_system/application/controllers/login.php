<?php

class Login extends MY_Controller {

    public $layout_view = 'layout/login_template';
    private $error_msg = null;

    // default function/constructor that redirects user to the home page user is already logged-in
    function __construct() {
        parent::__construct();
        if ($this->session->userdata('user_is_logged')) {
            redirect('home');
        }
        $this->layout->title('Login Page | MICS-TSG Ticketing System');
    }
    // check user authentication login
    public function UserAuth() {
        $data = array();
        // set validation rules
        $this->form_validation->set_rules('user_data[username]', 'Username', 'trim|required');
        $this->form_validation->set_rules('user_data[password]', 'Password', 'trim|required|callback_dbpassword_check');
        // run validation
        $validation_result = $this->form_validation->run();
        if ($validation_result == true) {
            redirect('home');
        } else {
            // validation equals to false / failed. username or password is incorrect. 
            $this->setErrorMsg('Invalid username or password.');
            $data['login_error_msg'] = $this->getErrorMsg();
            $this->layout->view('content/login', $data);
        }
    }
    // check password enter exist from the database
    public function dbpassword_check() {
        $user_data = $this->input->post('user_data');
        $user_account_check_rs = $this->DatabaseModel->checkUserAuth($user_data, 'tb_users');
        return $user_account_check_rs;
    }
    public function index() {
        $this->layout->view('content/login');
    }
    private function setErrorMsg($message) {
        $this->error_msg = $message;
    }
    private function getErrorMsg() {
        return $this->error_msg;
    }

}

?>