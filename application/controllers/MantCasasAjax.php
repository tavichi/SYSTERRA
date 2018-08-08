<?php  


defined('BASEPATH') OR exit('No direct script access allowed');

/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/


Class MantCasasAjax extends CI_Controller {

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
		$sector = $this->input->post('sector');
		$this->load->model('MantCasas_Model','MAN',true);
		$datasect=$this->MAN->TraeSectores($sector);
		$rp='';
		$contador=1;
		if($datasect['status']==200)
		 {
			 foreach ($datasect['data'] as $data) {
			 	if ($data['id_estadocasa']== 1){
			 		$color='class="success "';
			 		$clase='class="fa fa-remove fa-2x eliminacasa"';
			 		$clase2='class="fa fa-cogs fa-2x actcod"';
			 		$aviso='';
			 	}
			 	if ($data['id_estadocasa']==2){
			 		$clase='class="fa fa-remove fa-2x eliminacasa"';
			 		$clase2='class="fa fa-cogs fa-2x actcod"';
			 		$color='';
			 		$aviso='';
			 	}
			 	if ($data['id_estadocasa']== 3){
			 		$color='class="danger "';
			 		$clase2='';
			 		$clase='';
			 		$aviso='';
			 	}
				$rp.='<tr '.$color.'>
						<td>'.$contador.'</td>
						<td>'.$data['nombsector'].'</td>
						<td>'.$data['nocasa'].'</td>
						<td>'.$data['dir_completa'].'</td>
						<td>'.$data['estadocasa'].'</td>
						<td>'.$data['codigo_seg'].'</td>
						<td>'.$data['falta'].'</td>
						<td><i '.$clase.' style="color:red; text-align: right;" id="'.$data['codcasa'].'"></i>&nbsp;&nbsp;<i '.$clase2.' style="color:gray; text-align: right;" id="'.$data['codcasa'].'"></i>&nbsp;&nbsp;<i class="fa fa-address-card-o fa-2x cambiadircatastro" style="color:darkblue; text-align: right;" id="'.$data['codcasa'].'"></i>'.$aviso.'</td></tr>';
						$contador++;
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
			$this->load->model('MantCasas_Model','MAN',true);
			 $nocasa = $this->input->post('nocasa');
			 $calleavenida = $this->input->post('calleave');
			 $tdireccion = $this->input->post('tdireccion');
			 $literal = $this->input->post('literal');
			 $nocasa1=$this->input->post('nocasa1');
			 $nocasa2=$this->input->post('nocasa2');
			 $nocasa = $this->input->post('nocasa');
			 $sector = $this->input->post('sector');
	    	 $codigosec = $this->input->post('codigosec');
			 $insertar=$this->MAN->InsertarDatos($nocasa,$calleavenida,$tdireccion,$literal,$nocasa1,$nocasa2,$sector,$codigosec);
		 	echo json_encode($insertar); 
		 }	
			
		 }

	Public function inactivacasas(){

		if( $this->session->userdata('logueado') ==FALSE ) {
		 	$response['status']=400;
		 	$response['message']='La Sesion a Expirado no es Posible realizar esta Accion....Refrescar la pagina';
		 	$response['data']='';
		 echo json_encode($response);
		}else{
			$this->load->model('MantCasas_Model','MAN',true);
			 $idscasa = $this->input->post('idcasa');
			 $inactiva=$this->MAN->InactivarDatos($idscasa);
		 	 echo json_encode($inactiva); 
		 }	
			
	}
	Public function generacodigo(){

		if( $this->session->userdata('logueado') ==FALSE ) {
		 	$response['status']=400;
		 	$response['message']='La Sesion a Expirado no es Posible realizar esta Accion....Refrescar la pagina';
		 	$response['data']='';
		 echo json_encode($response);
		}else{
			$this->load->model('MantCasas_Model','MAN',true);
			 $genera=$this->MAN->GeneraCodigo();
		 	 echo json_encode($genera); 
		 }	
			
	}
	Public function actualizarcod(){

		if( $this->session->userdata('logueado') ==FALSE ) {
		 	$response['status']=400;
		 	$response['message']='La Sesion a Expirado no es Posible realizar esta Accion....Refrescar la pagina';
		 	$response['data']='';
		 echo json_encode($response);
		}else{
			$this->load->model('MantCasas_Model','MAN',true);
			$idscasa = $this->input->post('nocasa');
			$codigo = $this->input->post('codigosec');
			$motivo = $this->input->post('motivo');
			$genera=$this->MAN->ActualizaCod($idscasa,$codigo, $motivo);
		 	 echo json_encode($genera); 
		 }	
			
	}	


	Public function actualizardir(){

		if( $this->session->userdata('logueado') ==FALSE ) {
		 	$response['status']=400;
		 	$response['message']='La Sesion a Expirado no es Posible realizar esta Accion....Refrescar la pagina';
		 	$response['data']='';
		 echo json_encode($response);
		}else{
			$this->load->model('MantCasas_Model','MAN',true);
			$idcasa=$this->input->post('nocasa');
			$calleavenida = $this->input->post('calleavenida');
			$tdireccion = $this->input->post('tdireccion');
			$nocasa1 = $this->input->post('nocasa1');
			$nocasa2 = $this->input->post('nocasa2');
			$literal = $this->input->post('literal');
			$motivo = $this->input->post('motivo');
			$genera=$this->MAN->Actualizadir($idcasa,$calleavenida,$tdireccion, $nocasa1,$nocasa2,$literal,$motivo);
		 	 echo json_encode($genera); 
		 }	
			
	}
	Public function Reinicio(){

		if( $this->session->userdata('logueado') ==FALSE ) {
		 	$response['status']=400;
		 	$response['message']='La Sesion a Expirado no es Posible realizar esta Accion....Refrescar la pagina';
		 	$response['data']='';
		 echo json_encode($response);
		}else{
			$this->load->model('MantCasas_Model','MAN',true);
			$reinicio=$this->MAN->reinicio();
		 	 echo json_encode($reinicio); 
		 }	
			
	}
}