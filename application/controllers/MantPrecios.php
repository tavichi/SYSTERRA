<?php  


defined('BASEPATH') OR exit('No direct script access allowed');

/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/
 function __construct()
 {
   parent::__construct();
   $this->load->library(array('session'));
 }

Class MantPrecios extends CI_Controller {


	Public function Index(){
		$this->load->model('MantPrecios_Model','MAN',true);
		$data = array();
		$data['nombreopcion']='Lista de Precios Autorizados';
		$data['usuario']=$this->session->userdata('usuario');
		$data['opciones']=$this->session->userdata('menu');
		$data['Tsectores']=$this->MAN->TiposSectores();
		$data['Tproducto']=$this->MAN->Tproducto();
		$data['Tipopro']=$this->MAN->TipoPro();
		$data['TMonedas']=$this->MAN->Tmoneda();
		$this->load->view('header/header.php',$data);
		$this->load->view('Body/MantPreciosV.php',$data);
		$this->load->view('footer/footer.php',$data);

	}
}



?>