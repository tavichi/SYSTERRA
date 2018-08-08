<?php  


defined('BASEPATH') OR exit('No direct script access allowed');

/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/
 function __construct()
 {
   parent::__construct();
   $this->load->library(array('session'));
   
		
 }

Class MantCasas extends CI_Controller {


	Public function Index(){
		$this->load->model('MantCasas_Model','MANC',true);
		$data = array();
		$data['nombreopcion']='Control de Residencias';
		$data['usuario']=$this->session->userdata('usuario');
		$data['opciones']=$this->session->userdata('menu');
		$data['sectores']=$this->MANC->Sectores();
		$data['Tdireccion']=$this->MANC->Tdireccion();
		$this->load->view('header/header.php',$data);
		$this->load->view('Body/MantCasasV.php',$data);
		$this->load->view('footer/footer.php',$data);

	}
}



?>