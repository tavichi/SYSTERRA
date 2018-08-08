<?php  


defined('BASEPATH') OR exit('No direct script access allowed');

/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/
 function __construct()
 {
   parent::__construct();
   $this->load->library(array('session'));
 }

Class RepIngresos extends CI_Controller {


	Public function Index(){
		$this->load->model('RepIngresos_Model','MAN',true);
		$data = array();
		$data['nombreopcion']='Reporte de Ingresos';
		$data['usuario']=$this->session->userdata('usuario');
		$data['opciones']=$this->session->userdata('menu');
		$this->load->view('header/header.php',$data);
		$this->load->view('Body/RepIngresosV.php',$data);
		$this->load->view('footer/footer.php',$data);

	}
}



?>