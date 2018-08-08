<?php  


defined('BASEPATH') OR exit('No direct script access allowed');

/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/


Class loginAjax extends CI_Controller {


 

	Public function login(){

		$this->load->model('Login_Model','UM',true);
        $usuario = $this->input->post('usuario');
	    $password = $this->input->post('password');
		$datos=$this->UM->GetUser($usuario,$password);
		echo json_encode($datos); 
	}
	public function logout() {
	    $this->session->sess_destroy();
	    redirect('LoginCont/index');
        }
	
	
}