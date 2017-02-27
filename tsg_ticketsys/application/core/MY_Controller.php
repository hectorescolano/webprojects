<?php 

class MY_Controller extends CI_Controller  {
   function __construct() {
      parent::__construct();
      // Layout library loaded site wide
      $this->load->library('layout'); 
   }

}
?>