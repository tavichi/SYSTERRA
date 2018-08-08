<?php  


defined('BASEPATH') OR exit('No direct script access allowed');

/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/
 function __construct()
 {
   parent::__construct();
   $this->load->library(array('session'));
   
		
 }

Class ImpresionDOc extends CI_Controller {


	Public function Index(){
		$this->load->model('ImpresionDoc_Model','MANC',true);
		$data = array();
		$data['nombreopcion']='Impresi&oacute;n de Recibos';
		$data['usuario']=$this->session->userdata('usuario');
		$data['opciones']=$this->session->userdata('menu');
		$data['tsectores']=$this->MANC->TiposSectores();
		$data['tpago']=$this->MANC->TiposPago();
		$this->load->view('header/header.php',$data);
		$this->load->view('Body/ImpresionDocV.php',$data);
		$this->load->view('footer/footer.php',$data);

	}
}



?>