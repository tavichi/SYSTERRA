<?php  


defined('BASEPATH') OR exit('No direct script access allowed');

/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/


Class MantSecAjax extends CI_Controller {

 function __construct()
 {
   parent::__construct();
   			$response = array(
			    'status' => 200,
			    'message' => '',
			    'data' => '',
			);
 }
 

	Public function cargardatos(){

		$this->load->model('MantSec_Model','MAN',true);
		$datasect=$this->MAN->Sectores();
		$rp='';
		if($datasect['status']==200)
		 {
			 foreach ($datasect['data'] as $data) {
			 	if ($data['id_estados']== 2){
			 		$color='class="danger"';
			 		$clase='';
			 		$aviso='<b>Inactivo..</b>';
			 	}else{
			 		$clase='class="fa fa-remove fa-2x eliminadet"';
			 		$color='';
			 		$aviso='';
			 	}
				$rp.='<tr '.$color.'>
						<td>'.$data['id_sector'].'</td>
						<td>'.$data['nombresector'].'</td>
						<td>'.$data['codigo'].'</td>
						<td>'.$data['tsector'].'</td>
						<td><i '.$clase.' style="color:red; text-align: right;" id="'.$data['id_sector'].'" title="Inactivar Sector"></i>'.$aviso.'</td></tr>';
			}	
			    $response['status']=200;
			    $response['data']=$rp;
			echo json_encode($response); 
		 }
		 if($datasect['status']==401){
		 	$response['status']=401;
		 	$response['message']='Datos no encontrados para mostrar';
		 	$response['data']='';
		 	echo json_encode($response);
		 }	
		

	}

	Public function insertadatos(){

		if( $this->session->userdata('logueado') ==FALSE ) {
		 	$response['status']=400;
		 	$response['message']='La Sesion a Expirado no es Posible realizar esta Accion';
		 	$response['data']='';
		 echo json_encode($response);
		}else{
			$this->load->model('MantSec_Model','MAN',true);
			 $nombre = $this->input->post('nombresec');
	    	 $codigo = $this->input->post('codigosec');
	    	 $tsector = $this->input->post('Tsector');
			 $insertar=$this->MAN->InsertarDatos($nombre,$codigo,$tsector);
		 	echo json_encode($insertar); 
		 }	
			
		 }

	Public function inactivasector(){

		if( $this->session->userdata('logueado') ==FALSE ) {
		 	$response['status']=400;
		 	$response['message']='La Sesion a Expirado no es Posible realizar esta Accion....Refrescar la pagina';
		 	$response['data']='';
		 echo json_encode($response);
		}else{
			$this->load->model('MantSec_Model','MAN',true);
			 $idsector = $this->input->post('idsector');
			 $inactiva=$this->MAN->InactivarDatos($idsector);
		 	echo json_encode($inactiva); 
		 }	
			
	}
	
	
	
}