<?php  


defined('BASEPATH') OR exit('No direct script access allowed');

/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/
 function __construct()
 {
   parent::__construct();
   $this->load->library(array('session'));
 }

Class RpCasasActivas extends CI_Controller {
	Public function Index(){
		$this->load->model('RpCasasActivas_Model','GENR',true);
		$data = array();
		$data['nombreopcion']='Reporte General de Casas Activas';
		$data['usuario']=$this->session->userdata('usuario');
		$data['opciones']=$this->session->userdata('menu');
		$data['sectores']=$this->GENR->Sectores();
		$this->load->view('header/header.php',$data);
		$this->load->view('Body/RpCasasActivasV.php',$data);
		$this->load->view('footer/footer.php',$data);

	}
}



?>