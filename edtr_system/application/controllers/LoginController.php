<?php

class LoginController extends MY_Controller {

    public $layout_view = 'layout/template';

    function __construct() {

        parent::__construct();

        if ($this->session->userdata('ses_edtrsys')) {
            redirect('EdtrHomeController');  
        }

        $this->layout->title('LOGIN | EDTR SYSTEM');
    }
    

    public function index() {
        $this->layout->view('content/loginView');        
    }
    
    
    public function loginUser(){
        $data = $this->input->post('login');
        // var_dump($data);
        $this->storeUserSession($data['username'],$data['password']);
    }

    private function storeUserSession($user_name,$user_password){
        $logged_user_data = $this->DatabaseModel->getLoginDetails($user_name,$user_password,'Authfile');
        // var_dump($logged_user_data);
        if(!empty($logged_user_data))
        {
            $this->session->set_userdata('ses_edtrsys',$logged_user_data);
            $session_login_log_data = array
            (
                'login' => date('Y-m-d H:i:s'),
                'lastin_ipaddress' => $this->DatabaseModel->get_client_ip(),
                'last_action' => 'LOGGED IN'
            );
            // var_dump($this->session->userdata['ses_edtrsys'][0]);
            redirect('EdtrHomeController');       
        } else{
            $data = array();
            $data['message']= "User account is not found and invalid. Please login with the correct user account. <a href='LoginController'>[Back to Login Page]</a>";
            $data['heading']= "Login Failed";
            $this->layout->view('errors/html/error_404',$data);      
        }
    }


        
        


}

?>