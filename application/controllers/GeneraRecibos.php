<?php  


defined('BASEPATH') OR exit('No direct script access allowed');

/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/
 function __construct()
 {
   parent::__construct();
   $this->load->library(array('session'));
 }

Class GeneraRecibos extends CI_Controller {
	Public function Index(){
		$this->load->model('GeneraRecibos_Model','GENR',true);
		$data = array();
		$data['nombreopcion']='Generaci&oacute;n de Recibos';
		$data['usuario']=$this->session->userdata('usuario');
		$data['opciones']=$this->session->userdata('menu');
		$data['sectores']=$this->GENR->Sectores();
		$data['tpago']=$this->GENR->TiposPago();
		$this->load->view('header/header.php',$data);
		$this->load->view('Body/GeneraRecibosV.php',$data);
		$this->load->view('footer/footer.php',$data);

	}
}



?>