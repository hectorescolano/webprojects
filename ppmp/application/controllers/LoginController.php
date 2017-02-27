<?php

class LoginController extends MY_Controller {

    public $layout_view = 'layout/template';

    function __construct() {

        parent::__construct();

        if ($this->session->userdata('ses_ppmp')) {
            redirect('ReportController');  
        }

        $this->layout->title('LOGIN PPMP SYSTEM');
    }
    

    public function index() {
        $this->layout->view('content/loginView');        
    }
    
    
    public function loginUser(){
        $data = $this->input->post('login');
        // var_dump($data);
        $this->storeUserSession($data['username']);
    }

    private function storeUserSession($user_name){
        $logged_user_data = $this->DatabaseModel->getLoginDetails($user_name);
        // var_dump($logged_user_data);
        if(!empty($logged_user_data))
        {
            $this->session->set_userdata('ses_ppmp',$logged_user_data);
            $session_login_log_data = array
            (
                'login' => date('Y-m-d H:i:s'),
                'lastin_ipaddress' => $this->DatabaseModel->get_client_ip(),
                'last_action' => 'LOGGED IN'
            );
            // var_dump($this->session->userdata['ses_ppmp'][0]);
            redirect('ReportController');       
        } else{
            echo "User account is not found and invalid. Please try differrent account. <a href='LoginController'>BACK</a>";

        }
    }


        
        


}

?>