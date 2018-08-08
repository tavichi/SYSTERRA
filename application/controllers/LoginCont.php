<?php  


defined('BASEPATH') OR exit('No direct script access allowed');

error_reporting(E_ALL);
ini_set('display_errors', '1');

 function __construct()
 {
   parent::__construct();
   $this->load->library(array('session','form_validation'));
   $this->load->helper(array('url','form'));
   $this->load->database('dbsystem');
 }

Class LoginCont extends CI_Controller {

	Public function index(){

		$this->load->view('LoginVi.php');
	}

}



?>