<?php  


defined('BASEPATH') OR exit('No direct script access allowed');

/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/


Class MantClieAjax extends CI_Controller {

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

		$this->load->model('MantClie_Model','MANC',true);
		$datacliente=$this->MANC->Clientes();
		$rp='';
		if($datacliente['status']==200)
		 {
		 	$color='';
			 foreach ($datacliente['data'] as $data) {
			 	$claseTe='class="fa fa-phone fa-2x agregatelefono"';
			 	$claseTa='class="fa fa-file fa-2x agregatarjeta"';
			 	$claseVe='class="fa fa-car fa-2x agregavehiculo"';
				$rp.='<tr '.$color.'>
						<td><a href="#" class="modificacli" id="'.$data['codigo'].'">'.$data['codigo'].'</a></td>
						<td>'.$data['nombres'].'</td>
						<td>'.$data['apellidos'].'</td>
						<td>'.$data['nit'].'</td>
						<td>'.$data['dpi'].'</td>
						<td>'.$data['correo'].'</td>
						<td>'.$data['f_alta'].'</td>
						<td><a href="#" '.$claseTe.' style="color:gray; text-align: right;" id="'.$data['codigo'].'"></a></td>
						<td><a href="#" '.$claseTa.' style="color:blue; text-align: right;" id="'.$data['codigo'].'"></a></td>
						<td><a href="#" '.$claseVe.' style="color:green; text-align: right;" id="'.$data['codigo'].'"></a></td>	
						</tr>';
			}	
			    $response['status']=200;
			    $response['data']=$rp;
			echo json_encode($response); 
		 }
		 if($datacliente['status']==401){
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
			$this->load->model('MantClie_Model','MANC',true);
			 $nombre = $this->input->post('nombrec');
	    	 $apellido = $this->input->post('apellidoc');
	    	 $nit = $this->input->post('nitc');
	    	 $dpi = $this->input->post('dpic');
	    	 $correo = $this->input->post('correoc');
			 $insertar=$this->MANC->InsertarDatos($nombre,$apellido,$nit,$dpi,$correo);
		 	echo json_encode($insertar); 
		 }				
	}

	Public function modificadatos(){

		if( $this->session->userdata('logueado') ==FALSE ) {
		 	$response['status']=400;
		 	$response['message']='La Sesion a Expirado no es Posible realizar esta Accion';
		 	$response['data']='';
		 echo json_encode($response);
		}else{
			$this->load->model('MantClie_Model','MANC',true);
			 $nombre = $this->input->post('nombrec');
	    	 $apellido = $this->input->post('apellidoc');
	    	 $nit = $this->input->post('nitc');
	    	 $dpi = $this->input->post('dpic');
	    	 $correo = $this->input->post('correoc');
	    	 $id_identidad = $this->input->post('id_identidad');
			 $modificar=$this->MANC->modificadatos($nombre,$apellido,$nit,$dpi,$correo,$id_identidad);
		 	echo json_encode($modificar); 
		 }				
	}

	Public function eliminadatos(){
		if( $this->session->userdata('logueado') ==FALSE ) {
		 	$response['status']=400;
		 	$response['message']='La Sesion a Expirado no es Posible realizar esta Accion';
		 	$response['data']='';
		 echo json_encode($response);
		}else{
			$this->load->model('MantClie_Model','MANC',true);
	    	 $id_identidad = $this->input->post('id_identidad');
			 $eliminar=$this->MANC->eliminadatos($id_identidad);
		 	echo json_encode($eliminar); 
		 }				
	}

	Public function listado_telefonos(){
		$this->load->model('MantClie_Model','MANC',true);
		$id_identidad = $this->input->post('id_identidad');
		$datacliente=$this->MANC->listado_telefonos($id_identidad);
		$rp='';
		if($datacliente['status']==200)
		 {
		 	$color='';
		 	$claseTe='class="fa fa-remove fa-2x eliminatel"';
			 foreach ($datacliente['data'] as $data) {
				$rp.='<tr '.$color.'>
						<td>'.$data['id_telefono'].'</td>
						<td>'.$data['numero'].'</td>
						<td>'.$data['nombre'].'</td>
						<td><a href="#" '.$claseTe.' style="color:red; text-align: right;" id="'.$data['id_telefono'].'"></a></td>
					  </tr>';
			}	
			    $response['status']=200;
			    $response['data']=$rp;
			echo json_encode($response); 
		 }
		 if($datacliente['status']==401){
		 	$response['status']=401;
		 	$response['message']='Datos no encontrados para mostrar';
		 	$response['data']='';
		 	echo json_encode($response);
		 }	
	}

	Public function listado_tipotel(){
		if( $this->session->userdata('logueado') ==FALSE ) {
		 	$response['status']=400;
		 	$response['message']='La Sesion a Expirado no es Posible realizar esta Accion....Refrescar la pagina';
		 	$response['data']='';
		 echo json_encode($response);
		}else{
			$this->load->model('MantClie_Model','MANC',true);
			$listado=$this->MANC->listado_tipotel();
			$response['status']=200;
			$response['data']=$listado;		
		 	echo json_encode($response); 
		 }				
	}	

	Public function inserta_telefono(){

		if( $this->session->userdata('logueado') ==FALSE ) {
		 	$response['status']=400;
		 	$response['message']='La Sesion a Expirado no es Posible realizar esta Accion....Refrescar la pagina';
		 	$response['data']='';
		 echo json_encode($response);
		}else{
			$this->load->model('MantClie_Model','MANC',true);
			 $id_identidad = $this->input->post('id_identidad');
			 $ntelefono = $this->input->post('telefono');
			 $tipotel = $this->input->post('tipotel');
			 $inactiva=$this->MANC->inserta_telefono($id_identidad,$ntelefono,$tipotel);
		 	echo json_encode($inactiva); 
		 }				
	}

	Public function eliminar_tel(){
		if( $this->session->userdata('logueado') ==FALSE ) {
		 	$response['status']=400;
		 	$response['message']='La Sesion a Expirado no es Posible realizar esta Accion....Refrescar la pagina';
		 	$response['data']='';
		 echo json_encode($response);
		}else{
			$this->load->model('MantClie_Model','MANC',true);
			 $id_telefono = $this->input->post('id_telefono');
			 $inactiva=$this->MANC->eliminar_tel($id_telefono);
		 	 echo json_encode($inactiva); 
		 }	
			
	}
	
	Public function listado_tarjetas(){

		$this->load->model('MantClie_Model','MANC',true);
		$id_identidad = $this->input->post('id_identidad');
		$datacliente=$this->MANC->listado_tarjetas($id_identidad);
		$rp='';
		if($datacliente['status']==200)
		 {
		 	$color='';
		 	$claseTe='class="fa fa-remove fa-2x eliminatar"';
			 foreach ($datacliente['data'] as $data) {
				$rp.='<tr '.$color.'>
						<td>'.$data['id_tarjeta'].'</td>
						<td>'.$data['numero'].'</td>
						<td>'.$data['f_alta'].'</td>
						<td>'.$data['estado'].'</td>
						<td><a href="#" '.$claseTe.' style="color:red; text-align: right;" id="'.$data['id_tarjeta'].'"></a></td>				
					  </tr>';
			}	
			    $response['status']=200;
			    $response['data']=$rp;
			echo json_encode($response); 
		 }
		 if($datacliente['status']==401){
		 	$response['status']=401;
		 	$response['message']='Datos no encontrados para mostrar';
		 	$response['data']='';
		 	echo json_encode($response);
		 }	
	}

	Public function inserta_tarjeta(){

		if( $this->session->userdata('logueado') ==FALSE ) {
		 	$response['status']=400;
		 	$response['message']='La Sesion a Expirado no es Posible realizar esta Accion....Refrescar la pagina';
		 	$response['data']='';
		 echo json_encode($response);
		}else{
			$this->load->model('MantClie_Model','MANC',true);
			 $id_identidad = $this->input->post('id_identidad');
			 $ntarjeta = $this->input->post('tarjeta');
			 $inactiva=$this->MANC->inserta_tarjeta($id_identidad,$ntarjeta);
		 	echo json_encode($inactiva); 
		 }				
	}	

	Public function eliminar_tar(){
		if( $this->session->userdata('logueado') ==FALSE ) {
		 	$response['status']=400;
		 	$response['message']='La Sesion a Expirado no es Posible realizar esta Accion....Refrescar la pagina';
		 	$response['data']='';
		 echo json_encode($response);
		}else{
			$this->load->model('MantClie_Model','MANC',true);
			 $id_tarjeta = $this->input->post('id_tarjeta');
			 $inactiva=$this->MANC->eliminar_tar($id_tarjeta);
		 	 echo json_encode($inactiva); 
		 }	
			
	}

	Public function listado_vehiculos(){

		$this->load->model('MantClie_Model','MANC',true);
		$id_identidad = $this->input->post('id_identidad');
		$datacliente=$this->MANC->listado_vehiculos($id_identidad);
		$rp='';
		if($datacliente['status']==200)
		 {
		 	$color='';
		 	$claseTe='class="fa fa-remove fa-2x eliminaveh"';
			 foreach ($datacliente['data'] as $data) {
				$rp.='<tr '.$color.'>
						<td>'.$data['id_vehiculo'].'</td>
						<td>'.$data['tipove'].'</td>
						<td>'.$data['placa'].'</td>
						<td>'.$data['f_alta'].'</td>
						<td><a href="#" '.$claseTe.' style="color:red; text-align: right;" id="'.$data['id_vehiculo'].'"></a></td>
					  </tr>';
			}	
			    $response['status']=200;
			    $response['data']=$rp;
			echo json_encode($response); 
		 }
		 if($datacliente['status']==401){
		 	$response['status']=401;
		 	$response['message']='Datos no encontrados para mostrar';
		 	$response['data']='';
		 	echo json_encode($response);
		 }	
	}

	Public function inserta_vehiculo(){

		if( $this->session->userdata('logueado') ==FALSE ) {
		 	$response['status']=400;
		 	$response['message']='La Sesion a Expirado no es Posible realizar esta Accion....Refrescar la pagina';
		 	$response['data']='';
		 echo json_encode($response);
		}else{
			$this->load->model('MantClie_Model','MANC',true);
			 $id_identidad = $this->input->post('id_identidad');
			 $nplaca = $this->input->post('placa');
			 $tipove = $this->input->post('tipove');
			 $inactiva=$this->MANC->inserta_vehiculo($id_identidad,$nplaca,$tipove);
		 	echo json_encode($inactiva); 
		 }				
	}	

	Public function eliminar_veh(){
		if( $this->session->userdata('logueado') ==FALSE ) {
		 	$response['status']=400;
		 	$response['message']='La Sesion a Expirado no es Posible realizar esta Accion....Refrescar la pagina';
		 	$response['data']='';
		 echo json_encode($response);
		}else{
			$this->load->model('MantClie_Model','MANC',true);
			 $id_vehiculo = $this->input->post('id_vehiculo');
			 $inactiva=$this->MANC->eliminar_veh($id_vehiculo);
		 	 echo json_encode($inactiva); 
		 }	
			
	}

	Public function listado_tipovehic(){
		if( $this->session->userdata('logueado') ==FALSE ) {
		 	$response['status']=400;
		 	$response['message']='La Sesion a Expirado no es Posible realizar esta Accion....Refrescar la pagina';
		 	$response['data']='';
		 echo json_encode($response);
		}else{
			$this->load->model('MantClie_Model','MANC',true);
			$listado=$this->MANC->listado_tipovehic();
			$response['status']=200;
			$response['data']=$listado;		
		 	echo json_encode($response); 
		 }				
	}	

	Public function traedat_cliente(){
		$this->load->model('MantClie_Model','MANC',true);
		$id_identidad = $this->input->post('id_identidad');
		$datacliente=$this->MANC->traedat_cliente($id_identidad);
		$rp='';
		if($datacliente['status']==200)
		 {
		    $response['data']=$datacliente['data'][0]['codigo'].'@'.
		                      $datacliente['data'][0]['nombres'].'@'.
		                      $datacliente['data'][0]['apellidos'].'@'.
		                      $datacliente['data'][0]['nit'].'@'.
		                      $datacliente['data'][0]['dpi'].'@'.
		                      $datacliente['data'][0]['correo'];
			echo json_encode($response); 
		 }
		 if($datacliente['status']==401){
		 	$response['status']=401;
		 	$response['message']='Datos no encontrados para mostrar';
		 	$response['data']='';
		 	echo json_encode($response);
		 }	
	}


	
}