<?php  


defined('BASEPATH') OR exit('No direct script access allowed');

error_reporting(E_ALL);
ini_set('display_errors', '1');


Class MantPreciosAjax extends CI_Controller {

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

		$this->load->model('MantPrecios_Model','MAN',true);
		$datasect=$this->MAN->ListaPrecios();
		$rp='';
		if($datasect['status']==200)
		 {
		 	$contador=1;
			 foreach ($datasect['data'] as $data) {
			 	if ($data['id_estadolis']== 2){
			 		$color='class="danger"';
			 		$clase='';
			 		$aviso='<b>Inactivo..</b>';
			 	}else{
			 		$clase='class="fa fa-remove fa-2x eliminadet"';
			 		$color='';
			 		$aviso='';
			 	}
				$rp.='<tr '.$color.'>
						<td>'.$contador.'</td>
						<td>'.$data['tipocuota'].'</td>
						<td>'.$data['observacion'].'</td>
						<td>'.$data['f_inicio'].'</td>
						<td style="text-align: center;">'.$data['moneda'].'</td>
						<td >'.$data['precio'].'</td>
						<td><i '.$clase.' style="color:red; text-align: right;" id="'.$data['id_listadopa'].'" title="Inactivar Lista"></i>'.$aviso.'</td></tr>';
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
			$this->load->model('MantPrecios_Model','MAN',true);
			 $tproducto = $this->input->post('Tproducto');
	    	 $observacion = $this->input->post('obser');
	    	 $precio = $this->input->post('precio');
	    	 $tsector = $this->input->post('Tsector');
	    	 $fecha = $this->input->post('fecha');
			 $insertar=$this->MAN->InsertarDatos($tsector,$tproducto,$observacion,$precio,$fecha);
		 	echo json_encode($insertar); 
		 }	
			
		 }

	Public function inactivarListas(){

		if( $this->session->userdata('logueado') ==FALSE ) {
		 	$response['status']=400;
		 	$response['message']='La Sesion a Expirado no es Posible realizar esta Accion....Refrescar la pagina';
		 	$response['data']='';
		 echo json_encode($response);
		}else{
			$this->load->model('MantPrecios_Model','MAN',true);
			 $idlista = $this->input->post('idlista');
			 $inactiva=$this->MAN->InactivarDatos($idlista);
		 	echo json_encode($inactiva); 
		 }	
			
	}
	
	Public function InsertaProducto(){

		if( $this->session->userdata('logueado') ==FALSE ) {
		 	$response['status']=400;
		 	$response['message']='La Sesion a Expirado no es Posible realizar esta Accion';
		 	$response['data']='';
		 echo json_encode($response);
		}else{
			$this->load->model('MantPrecios_Model','MAN',true);
			 $tproducto = $this->input->post('tproducto');
			 $moneda=$this->input->post('moneda');
	    	 $nombreproducto = $this->input->post('nombreProducto');
	    	 $precio = $this->input->post('precio');
	    	 $abr = $this->input->post('abr');
			 $insertar=$this->MAN->InsertarDatosProd($tproducto,$moneda,$nombreproducto,$abr,$precio);
		 	echo json_encode($insertar); 
		 }	
			
		 }	
	
}
