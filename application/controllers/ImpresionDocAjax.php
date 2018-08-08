<?php  


defined('BASEPATH') OR exit('No direct script access allowed');

/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/


Class ImpresionDocAjax extends CI_Controller {

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
		$ffin = $this->input->post('ffin');
		$fini = $this->input->post('fini');
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
		if($fini!='' &&  $ffin !=''){
			$filtro.=" AND date(a.f_emitido) between date('". $fini ."') AND date('" . $ffin ."')" ;
		}else{
			$filtro.="";
		}

		$this->load->model('ImpresionDoc_Model','MAN',true);
		$datasect=$this->MAN->Traedata($filtro);
		$rp='';
		$contador=1;
		$contadorv=0;
		if($datasect['status']==200 )
		 {
			 foreach ($datasect['data'] as $data) {
			 	if ($data['monto']>=0 && $data['recibo']>0){
			 	 $saldo=$this->MAN->traesaldo($data['recibo'],$data['id_serie'],$data['id_tipodoc'],$data['id_empresa']);
					$rp.='<tr>
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
							</i>&nbsp;&nbsp;<i  id="'.$data['recibo'].'<@>'.$data['id_serie'].'<@>'.$data['id_tipodoc'].'<@>'.$data['id_empresa'].'" class="fa fa-print fa-2x print " title="Imprimir Recibo" style="color:gray; vertical-align:middle;"></i></td>
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

	Public function Imprimir($recibo,$serie,$tipodoc,$empresa){
		$this->load->model('ImpresionDoc_Model','MAN',true);
		$this->load->library('Pdf');
		if( $this->session->userdata('logueado') ==FALSE ) {
		 	$response['status']=400;
		 	$response['message']='<script>swal("Terra System","La Sesion a Expirado no es Posible realizar esta Accion","warning");</script>';
		 	$response['data']='';
		 echo json_encode($response);
		$this->load->view('header/header.php',$data);
		$this->load->view('Body/ImpresionDocV.php',$data);
		$this->load->view('footer/footer.php',$data);		 
		}else{
			if($recibo>0 && $serie>0 && $tipodoc>0 && $empresa>0){
				$enc=$this->MAN->DatosEncabezado($recibo,$serie,$tipodoc,$empresa);
				$detalles=$this->MAN->DetalleRecibo($recibo,$serie,$tipodoc,$empresa);
			}else{
					$response['status']=400;
				    $response['message']='Ocurrio un Problema no es posible Generar este PDF';
					echo json_encode($response);
			}

			$param='';
			$param=$recibo;
			//if (isset())	
			$lenguage = 'es_GT';
			        putenv("LANG=$lenguage");
			        setlocale(LC_ALL,$lenguage);
			        //****************************************************************************************************************
			            //Esta función llama a la página que generará el archivo PDF
			        while (ob_get_level())
			       
			        ob_end_clean();
			        header("Content-Encoding: None", true); 

						$pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
						$border=0;

				//Pdf('L', 'mm', 'A5', true, 'UTF-8', false);
				        $pdf->SetCreator(PDF_CREATOR);
				        $pdf->SetAuthor('Terra System');
				        $pdf->SetTitle('Recibo de Cobro Residencial');
				        $pdf->SetHeaderData("",8, "Recibo de Cobro Residencial  ", "Terra System");
				        $pdf->SetSubject('Documento generado desde el sistema Terra System');
				        $pdf->setPrintHeader(false);
				        $pdf->setPrintFooter(true);
				        $pdf->SetFillColor(255, 255, 255);
				        // set cell padding
				        $pdf->setCellPaddings(0, 0, 0, 0);
				        // set cell margins
				        $pdf->setCellMargins(0, 0, 0, 0);
				        //$pdf->SetFont('Courier', 'B',7);   
				        //$pdf->SetFont('times', 'U', 11, '', 'false');
				        $pdf->SetFont('dejavusans', '', 7);
				        //defino los margenes del documento
				        $pdf->SetMargins(12, 9, 9, false);   
				        $pdf->AddPage('L','A5');
						$pdf->SetFont('Courier', 'B',12);
						$pdf->MultiCell(195, 10, "",                                             $border, 'C', 1, 1, '', '', true);
						$pdf->Image('./assets/imagenes/Logo_Terranova.png', 10, 14, 50, 15,'', '', '', '', false, 300);
		                $pdf->MultiCell(195, 3, "Residenciales Terra Nova",                      $border, 'C', 1, 1, '', '', true);
		                $pdf->SetTextColor(255, 0, 0);
		                $pdf->MultiCell(195, 3, 'No. # '. $recibo,       						 $border, 'C', 1, 1, '', '', true);
		                $pdf->SetTextColor(0, 0, 0, 100);
		                $pdf->MultiCell(195, 3, "Serie \"". $enc['data'][0]['serie']. "\"",               $border, 'C', 1, 1, '', '', true);
		                $pdf->MultiCell(195, 3, ''.date('d-M-Y', strtotime($enc['data'][0]['femitido'])),       $border, 'C', 1, 1, '', '', true);
		                $pdf->MultiCell(195, 3, "",            									 $border, 'C', 1, 1, '', '', true);
		                $pdf->Ln(5);
						$pdf->MultiCell(195, 3, "Nombre: " .$enc['data'][0]['nombrecliente'],    $border, 'L', 1, 1, '', '', true);
						$pdf->Ln(1);
						$pdf->MultiCell(195, 3, "Dirección: " .$enc['data'][0]['dircorta'],      $border, 'L', 1, 1, '', '', true);
						if(!empty($dataenc['dir_catastro'])){
						$pdf->MultiCell(195, 3, "Dirección Catastro: " .$dataenc['dir_catastro'],      $border, 'L', 1, 1, '', '', true);

						}
						$pdf->Ln(5);

		                $pdf->MultiCell( 15, 3, "",              								 $border, 'C', 1, 0, '', '', true);
		                $pdf->SetFillColor(173,216,230);
		                $pdf->MultiCell( 30, 3, "CANTIDAD",              						 1, 'C', 1, 0, '', '', true);
			            $pdf->MultiCell( 90, 3, "DESCRIPCIÓN ",              					 1, 'C', 1, 0, '', '', true);
		             	$pdf->MultiCell( 40, 3, "TOTAL",             							 1, 'C', 1, 1, '', '', true);
		             	$pdf->SetFillColor(255,255,255);
						if($detalles['status']==200){
							 	$suma=0;
							 	$moneda='';
								 foreach ($detalles['data'] as $data) {
								 	$pdf->MultiCell( 15, 5, "",              								 $border, 'C', 1, 0, '', '', true);
								 	$pdf->MultiCell( 30, 5, number_format($data['cantidad'],0),              						 1, 'C', 1, 0, '', '', true);
								 	$pdf->MultiCell( 90, 5, $data['nombre'],              						 1, 'C', 1, 0, '', '', true);
								 	$pdf->MultiCell( 40, 5, $data['moneda']." " . number_format($data['totallinea'],2), 1, 'C', 1, 0, '', '', true);
								 	$pdf->Ln(5);
									$suma+=$data['totallinea'];
									$moneda=$data['moneda'];
								}	
								 	$pdf->MultiCell( 15, 5, "",              								 $border, 'C', 1, 0, '', '', true);
								 	$pdf->MultiCell( 30, 5, "",              						 1, 'C', 1, 0, '', '', true);
								 	$pdf->MultiCell( 90, 5, "Gran Total",              						 1, 'C', 1, 0, '', '', true);
								 	$pdf->MultiCell( 40, 5, $moneda." " . number_format($suma,2), 1, 'C', 1, 0, '', '', true);
								 	$pdf->Image('./assets/imagenes/cancelado.png', 85, 95, 50, 15,'', '', '', '', false, 300);
								 	$pdf->Image('./assets/imagenes/Copy.png', 20, 95, 20, 15,'', '', '', '', true, 100);
								 	$pdf->Ln(30);
								 	$pdf->SetFont('Courier', 'B',7);
								 	$pdf->MultiCell( 195, 5, " Cancelación Realizada por: ".$enc['data'][0]['canceladox']." El Dia " .$enc['data'][0]['fcancelado'], $border, 'C', 1, 0, '', '', true);
								 	/*$pdf->MultiCell( 200, 1, "--------------------------------------------------------------------------------------------------------------------------------------", $border, 'J', 1, 0, '1', '135', true);*/

						}

						
/*
				// Imprimimos el texto con writeHTMLCell()

						$border=0;

				//Pdf('L', 'mm', 'A5', true, 'UTF-8', false);
				        $pdf->SetCreator(PDF_CREATOR);
				        $pdf->SetAuthor('Terra System');
				        $pdf->SetTitle('Recibo de Cobro Residencial');
				        $pdf->SetHeaderData("",8, "Recibo de Cobro Residencial  ", "Terra System");
				        $pdf->SetSubject('Documento generado desde el sistema Terra System');
				        $pdf->setPrintHeader(false);
				        $pdf->setPrintFooter(true);
				        $pdf->SetFillColor(255, 255, 255);
				        // set cell padding
				        $pdf->setCellPaddings(0, 0, 0, 0);
				        // set cell margins
				        $pdf->setCellMargins(0, 0, 0, 0);
				        //$pdf->SetFont('Courier', 'B',7);   
				        //$pdf->SetFont('times', 'U', 11, '', 'false');
				        $pdf->SetFont('dejavusans', '', 7);
				        //defino los margenes del documento
				        $pdf->SetMargins(12, 9, 9, false);  
						$pdf->SetFont('Courier', 'B',12);
						$pdf->MultiCell(195, 10, "",                                             $border, 'C', 1, 1, '', '', true);
						$pdf->Image('./assets/imagenes/Logo_Terranova.png', 10, 140, 50, 15,'', '', '', '', false, 300);
		                $pdf->MultiCell(195, 3, "Residenciales Terra Nova",                      $border, 'C', 1, 1, '', '', true);
		                $pdf->SetTextColor(255, 0, 0);
		                $pdf->MultiCell(195, 3, 'No. # '. $recibo,       						 $border, 'C', 1, 1, '', '', true);
		                $pdf->SetTextColor(0, 0, 0, 100);
		                $pdf->MultiCell(195, 3, "Serie \"". $enc['data'][0]['serie']. "\"",               $border, 'C', 1, 1, '', '', true);
		                $pdf->MultiCell(195, 3, ''.date('d-M-Y', strtotime($enc['data'][0]['femitido'])),       $border, 'C', 1, 1, '', '', true);
		                $pdf->MultiCell(195, 3, "",            									 $border, 'C', 1, 1, '', '', true);
		                $pdf->Ln(5);
						$pdf->MultiCell(195, 3, "Nombre: " .$enc['data'][0]['nombrecliente'],    $border, 'L', 1, 1, '', '', true);
						$pdf->Ln(1);
						$pdf->MultiCell(195, 3, "Dirección: " .$enc['data'][0]['dircorta'],      $border, 'L', 1, 1, '', '', true);
						$pdf->Ln(5);

		                $pdf->MultiCell( 15, 3, "",              								 $border, 'C', 1, 0, '', '', true);
		                $pdf->SetFillColor(173,216,230);
		                $pdf->MultiCell( 30, 3, "CANTIDAD",              						 1, 'C', 1, 0, '', '', true);
			            $pdf->MultiCell( 90, 3, "DESCRIPCIÓN ",              					 1, 'C', 1, 0, '', '', true);
		             	$pdf->MultiCell( 40, 3, "TOTAL",             							 1, 'C', 1, 1, '', '', true);
		             	$pdf->SetFillColor(255,255,255);
						if($detalles['status']==200){
							 	$suma=0;
							 	$moneda='';
								 foreach ($detalles['data'] as $data) {
								 	$pdf->MultiCell( 15, 5, "",              								 $border, 'C', 1, 0, '', '', true);
								 	$pdf->MultiCell( 30, 5, number_format($data['cantidad'],0),              						 1, 'C', 1, 0, '', '', true);
								 	$pdf->MultiCell( 90, 5, $data['nombre'],              						 1, 'C', 1, 0, '', '', true);
								 	$pdf->MultiCell( 40, 5, $data['moneda']." " . number_format($data['totallinea'],2), 1, 'C', 1, 0, '', '', true);
								 	$pdf->Ln(5);
									$suma+=$data['totallinea'];
									$moneda=$data['moneda'];
								}	
								 	$pdf->MultiCell( 15, 5, "",              								 $border, 'C', 1, 0, '', '', true);
								 	$pdf->MultiCell( 30, 5, "",              						 1, 'C', 1, 0, '', '', true);
								 	$pdf->MultiCell( 90, 5, "Gran Total",              						 1, 'C', 1, 0, '', '', true);
								 	$pdf->MultiCell( 40, 5, $moneda." " . number_format($suma,2), 1, 'C', 1, 0, '', '', true);
								 	$pdf->Image('./assets/imagenes/cancelado.png', 85, 217, 50, 15,'', '', '', '', false, 300);
								 	$pdf->Image('./assets/imagenes/Copy.png', 20, 217, 20, 15,'', '', '', '', true, 100);
								 	$pdf->Ln(38);
								 	$pdf->SetFont('Courier', 'B',7);
								 	$pdf->MultiCell( 195, 5, " Cancelación Realizada por: ".$enc['data'][0]['canceladox']." El Dia ".$enc['data'][0]['fcancelado'], $border, 'C', 1, 0, '', '', true);
								 

						}*/
						$pdf->lastPage();
				// ---------------------------------------------------------
				// Cerrar el documento PDF y preparamos la salida
				// Este método tiene varias opciones, consulte la documentación para más información.
				        $nombre_archivo='';
				        $nombre_archivo = utf8_decode("Recibo_".$recibo.".pdf");
				        $pdf->Output($nombre_archivo, 'D');
				    
				}

			
	}

	
	Public function autocompleteclientes() {
		$this->load->model('ImpresionDoc_Model','MAN',true);
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
		$this->load->model('ImpresionDoc_Model','MAN',true);
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
					  $this->load->model('ImpresionDoc_Model','MAN',true);
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

