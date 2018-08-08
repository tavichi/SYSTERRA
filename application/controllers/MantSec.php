<?php  


defined('BASEPATH') OR exit('No direct script access allowed');

/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/
 function __construct()
 {
   parent::__construct();
   $this->load->library(array('session'));
 }

Class MantSec extends CI_Controller {


	Public function Index(){
		$this->load->model('MantSec_Model','MAN',true);
		$data = array();
		$data['nombreopcion']='Mantenimiento de Sectores';
		$data['usuario']=$this->session->userdata('usuario');
		$data['opciones']=$this->session->userdata('menu');
		$data['Tsectores']=$this->MAN->TiposSectores();
		$this->load->view('header/header.php',$data);
		$this->load->view('Body/MantSecV.php',$data);
		$this->load->view('footer/footer.php',$data);

	}
}



?>