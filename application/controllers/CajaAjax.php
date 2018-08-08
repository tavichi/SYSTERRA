<?php  


defined('BASEPATH') OR exit('No direct script access allowed');

/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/


Class CajaAjax extends CI_Controller {

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
		$filtro.=" AND e.id_sector=".$sector;	
		}else{
			$filtro.="";
		}
		if ($cliente>0 ){
		$filtro.=" AND a.id_cliente=".$cliente;	
		}else{
			$filtro.="";
		}

		$this->load->model('Caja_Model','MAN',true);
		$datasect=$this->MAN->Traedata($filtro);
		$rp='';
		$contador=1;
		$contadorv=0;
		if($datasect['status']==200 )
		 {
			 foreach ($datasect['data'] as $data) {
			 	if ($data['monto']>0 && $data['recibo']>0){
			 	 $saldo=$this->MAN->traesaldo($data['recibo'],$data['id_serie'],$data['id_tipodoc'],$data['id_empresa']);
					$rp.='<tr>
							<td><input type="checkbox" class=\'chkind\' name="chk[]" id="'.$data['recibo'].'<@>'.$data['id_serie'].'<@>'.$data['id_tipodoc'].'<@>'.$data['id_empresa'].'" ></td>
							<td>'.$contador.'</td>
							<td>'.$data['recibo'].'</td>
							<td>'.$data['serie'].'</td>
							<td>'.$data['ntipodoc'].'</td>
							<td>'.$data['cliente'].'</td>
							<td>'.$data['femision'].'</td>
							<td>'.$data['fvence'].'</td>
							<td align="center">'.$data['simbolo'].'</td>
							<td>'.number_format($data['monto'],2).'</td>
							<td style="color:red;"><b>'.number_format($saldo['data'][0]['totalpago'],2).'</b></td>
							<td style="vertical-align:middle;"><i id="'.$data['recibo'].'<@>'.$data['id_serie'].'<@>'.$data['id_tipodoc'].'<@>'.$data['id_empresa'].'" class="fa fa-toggle-down fa-2x verdetalles" title="Ver Detalles" style="color:orange; vertical-align:middle;" ></i>
							</i>&nbsp;&nbsp;<i  id="'.$data['recibo'].'<@>'.$data['id_serie'].'<@>'.$data['id_tipodoc'].'<@>'.$data['id_empresa'].'" class="fa fa-money fa-2x pagar" title="Pagar Recibo" style="color:green; vertical-align:middle;"></i></td>
						  </tr>';
						  $contador++;
						  $contadorv++;
				}

			}
				if ($contadorv>0){
				    $response['status']=200;
				    $response['data']=$rp;
					echo json_encode($response); 
				}else{
					$rp.='<tr>
							<td colspan="13" ><b style="color:red;"><center>No Hay Informacion Para Mostrar</center><b></td>
						  </tr>';
					$response['status']=200;
				    $response['data']=$rp;
					echo json_encode($response);
				}

		 }
		 if($datasect['status']==401){
		 	echo json_encode($datasect);
		 }	
		

	}

	Public function PagarRecibo(){

		if( $this->session->userdata('logueado') ==FALSE ) {
		 	$response['status']=400;
		 	$response['message']='La Sesion a Expirado no es Posible realizar esta Accion';
		 	$response['data']='';
		 echo json_encode($response);
		}else{
			$this->load->model('Caja_Model','MAN',true);
			 $recibo = $this->input->post('recibo');
			 $serie = $this->input->post('serie');
			 $tipodoc = $this->input->post('tipodoc');
			 $empresa = $this->input->post('empresa');
			 $tpago = $this->input->post('tpago');
			 $fechap = $this->input->post('fechap');
			 $cantpago = $this->input->post('cantpago');
			 $obser = $this->input->post('obser');
			 $insertarpago=$this->MAN->InsertaPago($recibo,$serie,$tipodoc,$empresa,$cantpago,$tpago,$fechap,$obser);
		 	echo json_encode($insertarpago); 
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
			
	Public function DetalleRecibo() {
		if( $this->session->userdata('logueado') ==FALSE ) {
		 	$response['status']=400;
		 	$response['message']='La Sesion a Expirado no es Posible realizar esta Accion....Refrescar la pagina';
		 	$response['data']='';
		 echo json_encode($response);
		}else{
			$this->load->model('Caja_Model','MAN',true);
		    $recibo = $this->input->post('recibo');
		    $serie = $this->input->post('serie');
		    $tipodoc = $this->input->post('tipodoc');
		    $empresa = $this->input->post('empresa');
		    $result='';
		    $result=$this->MAN->DetalleRecibo($recibo,$serie,$tipodoc,$empresa);
			$rp='';
			if($result['status']==200)
			 {
			 	$suma=0;
				 foreach ($result['data'] as $data) {
					$rp.='<tr>
							<td>'.$data['linea'].'</td>
							<td>'.$data['nombre'].'</td>
							<td>'.$data['moneda'].'</td>
							<td>'.number_format($data['totallinea'],2).'</td>
						  </tr>';
						  $suma+=$data['totallinea'];
				}	
				$rp.='<tr>
						<td colspan="3" style="text-align:right;"><b>Total:</b></td>
						<td><b>'.number_format($suma,2).'</b></td>

					  </tr>';
				    $response['status']=200;
				    $response['data']=$rp;
				echo json_encode($response); 
			 }
			 if($result['status']==401){
			 	echo json_encode($result);
			 }	
		}
	}

	Public function AnularBloque(){
		if( $this->session->userdata('logueado') ==FALSE ) {
				 	$response['status']=400;
				 	$response['message']='La Sesion a Expirado no es Posible realizar esta Accion';
				 	$response['data']='';
				    echo json_encode($response);
				}else{
					  $this->load->model('Caja_Model','MAN',true);
					  $recibos = $this->input->post('recibos');
					  $motivo = $this->input->post('motivo');
					  $contadorinactivos=0;
					  $contadornoinactivos=0;
					  foreach ($recibos as $rec) {
					  	$datos=explode('<@>', $rec);
					  	$inactivarecibo=$this->MAN->AnularRecibo($datos[0],$datos[1],$datos[2],$datos[3],$motivo);
					  	
					  	if ($inactivarecibo==1){
					  	  $contadorinactivos++;
					  	}else{
					  		$contadornoinactivos++;
					  	}
					  }
					  	if ($contadornoinactivos>0){
							$response['status']=200;
							$response['message'] = 'Se Anularon con Exito : '.$contadorinactivos.' Recibos, no fue posible Anular: ' . $contadornoinactivos . ' Verifique..';
							$response['data'] = '';
							echo json_encode($response);
					  	}else{
					  		$response['status']=200;
							$response['message'] = 'Anulacion Exitosa, se Anularon # : '.$contadorinactivos. ' Recibos';
							$response['data'] = '';
							echo json_encode($response);
					  	}
		 
					}
	}
}

