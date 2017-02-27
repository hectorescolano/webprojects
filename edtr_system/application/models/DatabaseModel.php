<?php

class DatabaseModel extends CI_Model {

    public function getCertificationList(){
        $sql = "SELECT * FROM Certification ORDER BY EMPLOYEENAME ASC";
        $res = $this->db->query($sql);
        return $res->result();       
    }
    
    public function getCertificationListByDeptCode($code){
        $sql = "SELECT * FROM Certification WHERE DEPTCODE = ? ORDER BY EMPLOYEENAME ASC";
        $res = $this->db->query($sql,$code);
        return $res->result();       
    }
    
    public function deleteFromCertListById($id){
//        $sql = "DELETE FROM Certification WHERE EMPLOYEEID = ?";
//        $res = $this->db->query($sql,$id);
//        return $res->result();
        $this->db->where('EMPLOYEEID', $id);
        $this->db->delete('Certification');
        return $this->db->affected_rows();
    }

    public function getLoginDetails($username, $password,$tablename){
        $sql = "SELECT TOP 1 * FROM ".$tablename." WHERE USERID = ? AND PASSWORD = ?";
        $data = array($username, $password);
        $res = $this->db->query($sql,$data);
        return $res->result();
    }


    public function getFundAdmin(){
        $sql = "SELECT * FROM dbo.RPT_SIGNATORIES_DETAIL WHERE sequence_no = 2";
        $res = $this->db->query($sql);
        return $res->result();
    }


    public function getDeptHead($deptcode,$offcode){

        if(isset($offcode) && $offcode != 0){
            $sql = "SELECT [OIC] AS head, [position] AS post FROM MST_OFFICE WHERE department_code = ? AND sys_suboffice_code = ?";
            $data = array($deptcode,$offcode);
        } else {
            if($offcode == 0){
                $sql = "SELECT [dept_head] AS head,[position_title] AS post FROM MST_DEPARTMENT WHERE department_code = ?"; 
                $data = array($deptcode);
            }  
        }
        $res = $this->db->query($sql,$data);
        return $res->result();

    }

    public function getContractType($account_code,$dept_code){

        $sql = "SELECT DISTINCT department_code, contract_type,account_code FROM trx_ppmp_detail WHERE department_code = ? AND account_code = ?";
        $data = array($dept_code,$account_code);
        $res = $this->db->query($sql,$data);
        return $res->result();

    }


    
    public function getPPMPreport($year,$dept,$off, $acct){

        $sql = "EXEC dbo.spppmp ?,?,?,?";
        $data = array($year,$dept,$off,$acct);
        $res = $this->db->query($sql,$data);
        return $res->result();
        
        
    }

    public function getPPMPreport2($year,$dept,$off, $acct){

        $sql = "EXEC dbo.spnewppmp ?,?,?,?";
        $data = array($year,$dept,$off,$acct);
        $res = $this->db->query($sql,$data);
        return $res->result();
        
        
    }

    

    public function getUserDeptByAddress($address){
        $sql = "SELECT dbo.MST_DEPARTMENT.description AS Dept,dbo.MST_DEPARTMENT.department_code FROM dbo.MST_DEPARTMENT WHERE (department_code = ?)";
        $data = array($address);
        $res = $this->db->query($sql,$data);
        // sqlsrv_free_stmt($res);
        return $res->result();         
    }

    public function getUserDeptAndOffice($deptcode){
        // $sql = "SELECT dbo.MST_DEPARTMENT.description AS Dept, dbo.MST_OFFICE.description AS Office, dbo.USER_MASTER.user_name,dbo.MST_DEPARTMENT.department_code
        //         FROM   dbo.USER_MASTER INNER JOIN dbo.MST_OFFICE ON dbo.USER_MASTER.sys_suboffice_code = dbo.MST_OFFICE.sys_suboffice_code INNER JOIN
        //         dbo.MST_DEPARTMENT ON dbo.MST_OFFICE.department_code = dbo.MST_DEPARTMENT.department_code WHERE (dbo.USER_MASTER.user_name = ?)";


        $sql = "SELECT * FROM dbo.MST_DEPARTMENT WHERE department_code = ? ";


        $data = array($deptcode);
        $res = $this->db->query($sql,$data);




        return $res->result();         

    }

    public function getUserDeptAndOffice2($deptcode,$offcode){
       

        if(!empty($offcode)){
            $sql = "SELECT * from dbo.MST_OFFICE where sys_suboffice_code = ? and department_code = ?";
            $data = array($offcode,$deptcode);
        } else {
            $sql = "SELECT * FROM dbo.MST_DEPARTMENT WHERE department_code = ? ";
            $data = array($deptcode);
        }

        $res = $this->db->query($sql,$data);
        return $res->result();         
    }



    



    public function getOfficeByDeptCode($deptcode,$offcode){

        $sql = "SELECT * FROM dbo.MST_OFFICE WHERE (department_code = ?) AND (sys_suboffice_code = ?)";
        $data = array($deptcode,$offcode);
        $res = $this->db->query($sql,$data);
        return $res->result();

    }
    
    public function getUserAccountCode($username,$offcode){
        $sql = "SELECT DISTINCT dbo.TRX_PPMP_DETAIL.account_code FROM dbo.TRX_PPMP_DETAIL INNER JOIN
                dbo.USER_MASTER ON dbo.TRX_PPMP_DETAIL.sys_suboffice_code = dbo.USER_MASTER.sys_suboffice_code
                WHERE (dbo.USER_MASTER.sys_suboffice_code = ?) AND (dbo.USER_MASTER.user_name = ?) 
                AND (YEAR(dbo.TRX_PPMP_DETAIL.trx_year) > YEAR(DATEADD(YEAR, - 2, GETDATE())))";
        $data = array($offcode,$username);
        $res = $this->db->query($sql,$data);
        return $res->result();
    }

    public function getUserAccountCodeByDeptCode($address){
        $sql = "SELECT DISTINCT account_code FROM dbo.TRX_PPMP_DETAIL WHERE  (YEAR(dbo.TRX_PPMP_DETAIL.trx_year) > YEAR(DATEADD(YEAR, - 2, GETDATE()))) AND (department_code = ?)";
        $data = array($address);
        $res = $this->db->query($sql,$data);
        return $res->result();
    }
    

    public function getSP_GetSumReport($datefrm, $dateto, $brgy, $dist, $stat) {

        $sql = "EXEC dbo.SP_GetSumReport ?,?,?,?,?";
        $data = array($datefrm, $dateto, $brgy, $dist, $stat);
//            var_dump($data);
        $res = $this->db->query($sql, $data);
        return $res->result();
    }

    public function getBarangays() {
        $sql = "EXEC dbo.SP_GetBarangays";
        $res = $this->db->query($sql);
        return $res->result();
        // var_dump($res->result());
    }

    public function getDataFromTable($outputs, $table, $condition) {

        $this->db->select($outputs);

        if ($condition != null || $condition != "") {

            $this->db->where($condition);
        }


        return $this->db->get($table)->result();
    }

    public function getClaimantDeceasedTransactions() {
        $sql_query = "SELECT * FROM CLAIMANT_DECEASED ORDER BY MODIFIED DESC";
        $res = $this->db->query($sql_query);
        return $res->result();
    }

    public function getCountedRows() {
        return $this->db->count_all_results();
    }

    public function getDataFromTableLike($outputs, $table, $title_1, $title_2, $match) {
        $this->db->select($outputs);
        $this->db->like($title_1, $match);
        $this->db->or_like($title_2, $match);
        return $this->db->get($table)->result();
    }

    public function getNextIdRecord($table, $fieldname) {

        $sql = "SELECT COUNT($fieldname) AS ctr FROM $table";

        $res = $this->db->query($sql);

        return $res->result();
    }

    public function insertData($data_to_insert, $table, $duplicate_condition) {

        if (isset($duplicate_condition)) {
            if ($this->checkDataExistsToTable($duplicate_condition, $table)) {
                return $this->db->insert($table, $data_to_insert);
            }
        } else {
            return $this->db->insert($table, $data_to_insert);
        }




        return false;
    }

    public function insertDataToTable($data_to_insert, $tablename, $data_to_update, $update_condition) {


        if ($this->checkDataExistsToTable($update_condition, $tablename)) {

            if ($this->db->insert($tablename, $data_to_insert)) {

                return $this->updateDataFromTableWhere($tablename, $data_to_update, $update_condition);
            }
        }

        return false;
    }

    /* checks the data from table and returns true or false */

    public function checkDataExistsToTable($data_condition, $table) {

        $this->db->where($data_condition);

        $rs = $this->db->get($table)->result();

        if (!$rs) {

            return true;
        }

        return false;
    }

    public function updateDataFromTableWhere($table, $data_to_update, $update_condition) {
        return $this->db->update($table, $data_to_update, $update_condition);
    }

    public function insertUniqueDataFromTable($tablename, $data, $data_unique) {
        $this->db->where($data_unique);

        $rs = $this->db->get($tablename)->result();

        if (!$rs) {

            return $this->db->insert($tablename, $data);
        } else {

            return false;
        }
    }

    // Generates a update SQL string and runs the query
    // Returns:	TRUE on success, FALSE on failure
    // Compiles and executes a DELETE query.
    // Returns: CI_DB_query_builder instance (method chaining) or FALSE on failure
    public function deleteFromTableWhere($tablename, $condition_array) {
        return $this->db->delete($tablename, $condition_array);
    }

    // Generates a truncate SQL string and runs the query
    // Returns:	TRUE on success, FALSE on failure
    public function truncateTable($tablename) {
        return $this->db->truncate($tablename);
    }

    // Function to get the client IP address
    public function get_client_ip() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
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




                $sesData = array('id' => $row->id, 'name' => $row->user_fname, 'role' => $row->user_type, 'username' => $row->user_username, 'reset' => $row->reset);

                $this->session->set_userdata($sesName, $sesData);
                $update_data = array
                    (
                    'login' => date('Y-m-d H:i:s'),
                    'lastin_ipaddress' => $this->get_client_ip(),
                    'last_action' => 'LOGGED IN'
                );
                $this->updateTransacDateTime('user_username', $username, $update_data, 'TB_USERS');

                return true;
            } else {

                return false;
            }
        } else {

            return false;
        }
    }

    public function updateTransacDateTime($param, $param_val, $data, $table) {
        $this->db->where($param, $param_val);
        $this->db->update($table, $data);
    }

}

?>