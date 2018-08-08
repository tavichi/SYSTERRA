<?php  


defined('BASEPATH') OR exit('No direct script access allowed');

/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/


Class AsignaCasasAjax extends CI_Controller {

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
		$cliente = $this->input->post('cliente');
		$filtro='';
		if ($sector>0 ){
		$filtro.=" AND a.id_sector=".$sector;	
		}else{
			$filtro.="";
		}
		if ($cliente>0 ){
		$filtro.=" AND d.id_identidad=".$cliente;	
		}else{
			$filtro.="";
		}

		$this->load->model('AsignaCasas_Model','MAN',true);
		$datasect=$this->MAN->Traedata($filtro);
		$rp='';
		$contador=1;
		if($datasect['status']==200)
		 {
			 foreach ($datasect['data'] as $data) {
			 	$color='';
			 	$clase='';	
			 	$style='';		
			 	$style2='';
			 	$clase2='';
			 	$id='';
			 	$id2='';
			 	$idcheck='';

			 	if ($data['codcliente']== '' || $data['codcliente']== Null){
			 		$color='class="warning"';
			 		$clase='fa fa-address-book fa-2x agregarcliente';
			 		$clase2=' fa fa-search fa-2x verdetalle'; 
			 		$style='color:green;';
			 		$style2='color:blue;';
			 		$id2=$data['codcasa'];
			 		$id=$data['codcasa'];
			 		$idcheck=$data['codcasa'];

			 	}

			 	if ($data['codcliente']>0 ){
			 		$clase=' fa fa-remove fa-2x eliminacliente';
			 		$style='color:red;';
			 		$clase2=' fa fa-search fa-2x verdetalle'; 
			 		$style2='color:blue;';
			 		$id2=$data['codcasa'];
			 		$color='';
			 		$id=$data['codasig'];
			 		$idcheck=$data['codcasa'];
			 	}

				$rp.='<tr '.$color.'>
						<td><input type="checkbox" class=\'chkind\' name="chk[]" id="'.$idcheck.'" ></td>
						<td>'.$contador.'</td>
						<td>'.$data['nsector'].'</td>
						<td>'.$data['ncasa'].'</td>
						<td>'.$data['dircompleta'].'</td>
						<td>'.$data['ncliente'].'</td>
						<td>'.$data['fasignacion'].'</td>
						<td><i id="'.$id .'"  class="'.$clase.'"  style="'.$style.'" ></i>
						</i>&nbsp;&nbsp;<i  id="'.$id2.'" class="'.$clase2.'"  style="'.$style2.'"></i>&nbsp;&nbsp;
						<i id="'.$data['codasig'].'"class="fa fa-calendar-times-o fa-2x cambiof"  style="color:brown;"></i></td>
					  </tr>';
					  $contador++;
			}	
			    $response['status']=200;
			    $response['data']=$rp;
			echo json_encode($response); 
		 }
		 if($datasect['status']==401){
		 	echo json_encode($datasect);
		 }	
		

	}

	Public function insertacliente(){

		if( $this->session->userdata('logueado') ==FALSE ) {
		 	$response['status']=400;
		 	$response['message']='La Sesion a Expirado no es Posible realizar esta Accion';
		 	$response['data']='';
		 echo json_encode($response);
		}else{
			$this->load->model('AsignaCasas_Model','MAN',true);
			 $idcliente = $this->input->post('cliente');
			 $idcasa = $this->input->post('casa');
			 $insertar=$this->MAN->InsertarDatosCliente($idcliente,$idcasa);
		 	echo json_encode($insertar); 
		 }	
			
		 }

	Public function inactivaasignacion(){

		if( $this->session->userdata('logueado') ==FALSE ) {
		 	$response['status']=400;
		 	$response['message']='La Sesion a Expirado no es Posible realizar esta Accion....Refrescar la pagina';
		 	$response['data']='';
		 echo json_encode($response);
		}else{
			$this->load->model('AsignaCasas_Model','MAN',true);
			 $idscasa = $this->input->post('casa');
			 $motivo = $this->input->post('motivo');
			 $inactiva=$this->MAN->InactivarDatos($idscasa,$motivo);
		 	 echo json_encode($inactiva); 
		 }	
			
	}
	
	Public function autocompleteclientes() {
		$this->load->model('AsignaCasas_Model','MAN',true);
	    $frase = $this->input->post('cliente');
	    $frases = str_replace(' ', '%', $frase);
	    $listado = $this->MAN->TraeClientes($frases);
	    $response['status'] = 200;

	        foreach ($listado['data'] as $ln) {
	            $items[utf8_encode($ln['id_identidad'])]= utf8_encode(trim("[".$ln['id_identidad']. "] - ".$ln['ncliente']));
	        }
	        $result = array();

	        foreach ($items as $key=>$value) {
	            array_push($result, array("id"=>$key,  "value"=>strip_tags($value) ) );
	        }

	    echo json_encode($result);
	}
	Public function TraeSectores() {
		$this->load->model('AsignaCasas_Model','MAN',true);
	    $tsector = $this->input->post('tsectores');
	    $result='';
	    $result=$this->MAN->Sectores($tsector);
	    echo($result);
	}
			
	Public function TraeTarifas() {
			$this->load->model('AsignaCasas_Model','MAN',true);
		    $tsector = $this->input->post('tsectores');
		    $result='';
		    $result=$this->MAN->Tarifas($tsector);
			$rp='';
			$contador=1;
			if($result['status']==200)
			 {
				 foreach ($result['data'] as $data) {
					$rp.='<tr>
							<td>'.$contador.'</td>
							<td>'.$data['observacion'].'</td>
							<td>'.$data['moneda'].'</td>
							<td>'.$data['precio'].'</td>
							<td>'.$data['fechavigencia'].'</td>
							<td><input type="radio" class=\'chkind\' name="precios" value="'.$data['id_listadopa'].'" ></td>

						  </tr>';
						  $contador++;
				}	
				    $response['status']=200;
				    $response['data']=$rp;
				echo json_encode($response); 
			 }
			 if($result['status']==401){
			 	echo json_encode($result);
			 }	
	}
	Public function Asignaparametro(){

		if( $this->session->userdata('logueado') ==FALSE ) {
		 	$response['status']=400;
		 	$response['message']='La Sesion a Expirado no es Posible realizar esta Accion';
		 	$response['data']='';
		    echo json_encode($response);
		}else{
			  $this->load->model('AsignaCasas_Model','MAN',true);
			  $parametro = $this->input->post('parametro');
			  $casas = $this->input->post('casas');
			  $contadorinsertados=0;
			  $contadornoinsertados=0;
			  foreach ($casas as $casa) {
			  	$tieneparametro=$this->MAN->VerificaParametro($parametro,$casa);
			  	if ($tieneparametro==1){
			  	  $Inactiva=$this->MAN->InactivaParametro($parametro,$casa);
			  	  if($Inactiva==1){
			  	  	$Inactiva=$this->MAN->InsertarParametro($parametro,$casa);
			  	  	$contadorinsertados++;
			  	  }else{
			  	  	$contadornoinsertados++;
			  	  }
			  	}else{
			  		$Inactiva=$this->MAN->InsertarParametro($parametro,$casa);
			  		$contadorinsertados++;
			  	}
			  }
			  	if ($contadornoinsertados>0){
					$response['status']=200;
					$response['message'] = 'Se Asignaron con Exito : '.$contadorinsertados.' , no fue posible asignar: ' . $contadornoinsertados . ' Verifique..';
					$response['data'] = '';
					echo json_encode($response);
			  	}else{
			  		$response['status']=200;
					$response['message'] = 'Asignacion Relizada con Exito,  Casas con Parametros Asignados # : '.$contadorinsertados;
					$response['data'] = '';
					echo json_encode($response);
			  	}
 
			}
	}
	Public function TraeTarifasAsig() {
			$this->load->model('AsignaCasas_Model','MAN',true);
		    $casa = $this->input->post('casa');
		    $result='';
		    $result=$this->MAN->TraedataParam($casa);
			$rp='';
			$contador=1;
			if($result['status']==200)
			 {
				 foreach ($result['data'] as $data) {
					$rp.='<tr>
							<td>'.$contador.'</td>
							<td>'.$data['concepto'].'</td>
							<td>'.$data['simbolo'].'</td>
							<td>'.$data['precio'].'</td>
							<td><i id="'. $data['nasignacion'].'"  class="fa fa-trash-o fa-2x inactivapar"  style="color:red;" ></i></i></td>
						  </tr>';
						  $contador++;
				}	
				    $response['status']=200;
				    $response['data']=$rp;
				echo json_encode($response); 
			 }
			 if($result['status']==401){
			 	echo json_encode($result);
			 }	
	}
	Public function InactivaParam(){

		if( $this->session->userdata('logueado') ==FALSE ) {
		 	$response['status']=400;
		 	$response['message']='La Sesion a Expirado no es Posible realizar esta Accion....Refrescar la pagina';
		 	$response['data']='';
		 echo json_encode($response);
		}else{
			$this->load->model('AsignaCasas_Model','MAN',true);
			 $parametro = $this->input->post('parametro');
			 $inactiva=$this->MAN->InactivaParam($parametro);
		 	 echo json_encode($inactiva); 
		 }	
			
	}
	Public function InactivaBloque(){
		if( $this->session->userdata('logueado') ==FALSE ) {
				 	$response['status']=400;
				 	$response['message']='La Sesion a Expirado no es Posible realizar esta Accion';
				 	$response['data']='';
				    echo json_encode($response);
				}else{
					  $this->load->model('AsignaCasas_Model','MAN',true);
					  $casas = $this->input->post('casas');
					  $contadorinactivos=0;
					  $contadornoinactivos=0;
					  foreach ($casas as $casa) {
					  	$inactivaparamB=$this->MAN->InactivaParamBloque($casa);
					  	if ($inactivaparamB==1){
					  	  $contadorinactivos++;
					  	}else{
					  		$contadornoinactivos++;
					  	}
					  }
					  	if ($contadornoinactivos>0){
							$response['status']=200;
							$response['message'] = 'Se Desasignaron con Exito : '.$contadorinactivos.' , no fue posible Desasignar: ' . $contadornoinsertados . ' Verifique..';
							$response['data'] = '';
							echo json_encode($response);
					  	}else{
					  		$response['status']=200;
							$response['message'] = 'Desasignacion Relizada con Exito,  Casas con Parametros Desasignados # : '.$contadorinactivos;
							$response['data'] = '';
							echo json_encode($response);
					  	}
		 
					}
	}

	Public function CambiaFechaAs(){

		if( $this->session->userdata('logueado') ==FALSE ) {
		 	$response['status']=400;
		 	$response['message']='La Sesion a Expirado no es Posible realizar esta Accion....Refrescar la pagina';
		 	$response['data']='';
		 echo json_encode($response);
		}else{
			$this->load->model('AsignaCasas_Model','MAN',true);
			 $idscasa = $this->input->post('idasignacion');
			 $motivo = $this->input->post('motivo');
			 $fecha = $this->input->post('fecha');
			 $inactivafecha=$this->MAN->CambiaFecha($fecha,$motivo,$idscasa);
		 	 echo json_encode($inactivafecha); 
		 }	
			
	}
}

