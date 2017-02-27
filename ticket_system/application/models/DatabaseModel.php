<?php

class DatabaseModel extends CI_Model {
    
    
    public function getWorkUpdateHistory($tkt_no){
        $tkt_no = trim($tkt_no);
        $sql = "SELECT * FROM TB_TKT_WRK_UP WHERE TKT_NO = ?";
        $res = $this->db->query($sql,array($tkt_no));
        return $res->result();
    }
    
    
    public function getAvailableTechs(){
        $sql = "SELECT * FROM TB_USERS WHERE user_type = 2 ORDER BY user_lname ASC";
        $res = $this->db->query($sql);
        return $res->result();
    }

    public function getData($table, $output = array(), $cond = array()) {
        $this->db->select($output);
        if (!empty($cond))
            $res = $this->db->get_where($table, $cond);
        else
            $res = $this->db->get($table);
        return $res->result();
    }

    public function getDataNumRows($table, $output = array(), $cond = array()) {
        $this->db->select($output);
        $res = $this->db->get_where($table, $cond);
        return $res->num_rows();
    }

    public function login($username, $unColumnName, $password, $table, $sesName, $dtLoginColumnName) {
        $sql = "SELECT * FROM " . $table . " WHERE " . $unColumnName . " = ?";
        $res = $this->db->query($sql, array($username));
        $row = $res->row();

        if ($row != NULL) {
            $db_hash_password = $row->user_password;
            $entered_password = $password;

            // verify password
            if (password_verify($entered_password, $db_hash_password)) {
                $sesData = array('id' => $row->user_id, 'name' => $row->user_fname, 'role' => $row->user_type);
                $this->session->set_userdata($sesName, $sesData);
                $this->updateTransacDateTime($unColumnName, $row->user_fname, array($dtLoginColumnName => date('Y-m-d H:i:s')), $table);
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getTicketControlNo($table, $fieldname) {
        $control_no = $this->getNextIdRecord($table, $fieldname);
        $control_no = sprintf("%'.08d\n", $control_no[0]->ID + 1);
        $control_no = "TKT" . $control_no;
        return $control_no;
    }

    public function getNextIdRecord($table, $fieldname) {

        $sql = "SELECT COUNT($fieldname) AS ID FROM $table";

        $res = $this->db->query($sql);

        if ($res)
            return $res->result();
        else
            return 0;
    }

    public function searchData($table, $output, $data = array()) {
        $this->db->select($output);
        $this->db->like($data, 'after');
        $rs = $this->db->get_where($table, array('active' => 1));
        return $rs->result();
    }

    public function checkDataAlreadyExist($table, $output = array(), $cond = array()) {
        $num_rows = $this->getDataNumRows($table, $output, $cond);
        if ($num_rows > 0) {
            return true; // data already exist.
        }
        return false;
    }

    // returns boolean if user is exist  true & not false
    public function checkUserAuth($user_data, $table) {
        $sql = "SELECT * FROM " . $table . " WHERE user_username = ?";

        $rs = $this->db->query($sql, array($user_data['username']));

        $row = $rs->row();

        if ($row != NULL) {
            $db_userpass = $row->user_password;
            $user_enteredpass = $user_data['password'];
            // check if password matched
            $session_data = array();
            if (password_verify($user_enteredpass, $db_userpass)) {
                $session_data = array('id' => $row->user_id, 'name' => $row->user_fname, 'role' => $row->user_type, 'lname' => $row->user_lname, 'division' => $row->user_division);
                $this->session->set_userdata('user_is_logged', $session_data);
                return true;
            }
        }
        return false;
    }

    public function updateDataFromTableWhere($table, $data_to_update, $update_condition) {
        return $this->db->update($table, $data_to_update, $update_condition);
    }

    // return active offices
    public function getActiveOffices() {
        $sql_query = "EXEC SP_GETOFFICES";
        $rs = $this->db->query($sql_query);
        return $rs->result();
    }

    public function saveDataToDb($table, $data) {
        $rs_insert = $this->db->insert($table, $data);
        return $rs_insert;
    }

    public function getActiveUsers() {
        $sql_query = "EXEC SP_GetActiveUsers";
        $rs = $this->db->query($sql_query);
        return $rs->result();
    }

    public function getUserTicketBucketList($user, $user_type = null) {
        $sql_query = "EXEC SP_GetUserTicketBucketList " . $user;
        if ($user_type != null) {
            if ($user_type == 4 || $user_type == 3) {
                $sql_query = "EXEC SP_GetAllUserTicketBucketList";
            }
        }


        $rs = $this->db->query($sql_query);
        return $rs->result();
    }

}

?>