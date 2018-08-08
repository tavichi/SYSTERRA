<?php  


defined('BASEPATH') OR exit('No direct script access allowed');

/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/
 function __construct()
 {
   parent::__construct();
   $this->load->library(array('session'));
 }

Class MenuCont extends CI_Controller {


	Public function Index(){
		$data = array();
		$data['nombreopcion']='Menu Principal';
		$data['usuario']=$this->session->userdata('usuario');
		$data['opciones']=$this->session->userdata('menu');
		$this->load->view('header/header.php',$data);
	}
}



?>