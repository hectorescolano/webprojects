<?php

class EdtrHomeController extends MY_Controller {

    public $layout_view = 'layout/template';

    function __construct() {

        parent::__construct();

        if (!$this->session->userdata('ses_ticketsys')) {
            redirect('LoginController');
        }

        $this->layout->title('HOME | TICKETING SYSTEM');
    }

    public function index() {
        $data = array();
        $user_logged_data = $this->session->userdata['ses_ticketsys'];
//        $data['userid'] = trim($user_logged_data[0]->USERID); // logged userid
//        $data['userdeptcode'] = trim($user_logged_data[0]->USERSTATUS);
//        $data['certification_list'] = $this->DatabaseModel->getCertificationListByDeptCode($data['userdeptcode']);
//        var_dump($data['certification_list']);
        $this->layout->view('content/homeEdtrSystemView', $data);
    }

    public function confirmDeleteEmp() {
        $employeeid_to_delete = $this->input->post('employeeid');

        $rs = $this->DatabaseModel->deleteFromCertListById($employeeid_to_delete);
//       var_dump($rs);
        $this->index();
    }

    public function logoutUser() {
        if (isset($this->session->userdata['ses_ticketsys'])) {

            // $session_appdata = $this->session->userdata['logged_in_burial']['name'];
            // $update_data = array
            //     (
            //     'logout' => date('Y-m-d H:i:s'),
            //     'lastout_ipaddress' => $this->DatabaseModel->get_client_ip(),
            //     'last_action' => 'LOGGED OUT'
            // );
            // $this->DatabaseModel->updateTransacDateTime('user_fname', $session_appdata, $update_data, 'TB_USERS');

            $this->session->unset_userdata('ses_ticketsys');

            redirect('LoginController');
        }
    }

}

?>