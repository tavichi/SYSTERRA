<?php  


defined('BASEPATH') OR exit('No direct script access allowed');

/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/


Class GeneraRecibosAjax extends CI_Controller {

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
		$this->load->model('GeneraRecibos_Model','GENR',true);
		$datasect=$this->GENR->TraeSectores($sector);
		$rp='';
		$contador=0;
		if($datasect['status']==200)
		 {
			 foreach ($datasect['data'] as $data) {
			 	if ($data['siguienteper']== ''){
			 		$periodo='<td>'.$data['primerper'].'</td>';
			 		$color='class="danger "';
			 	}else{
			 		$periodo='<td>'.$data['siguienteper'].'</td>';
			 		$color='class="success "';
			 	}

			 	$contador=$contador+1;
				$rp.='<tr '.$color.'>
						<td align="right">'.$contador.'</td>
						<td>'.$data['nombsector'].'</td>
						<td align="center">'.$data['nocasa'].'</td>
						<td align="center">'.$data['codigo_seg'].'</td>
						<td>'.$data['dir_completa'].'</td>
						<td>'.$data['nombrecliente'].'</td>
						<td>'.$data['falta'].'</td>
						<td>'.$data['simbolo'].'</td>
						<td align="right"><a href="#" class="detallemonto" id="'.$data['codcasa'].'">'.$data['totalcuota'].'</a></td>
						'.$periodo.'
						<td><input type="checkbox" style="align: center;" name="chk[]" id="'.$data['codcasa'].'@'.$data['id_identidad'].'@'.$data['totalcuota'].'@'.$data['cuotab'].'@'.$data['valorxtadic'].'@'.$data['mes'].'@'.$data['anno'].'@'.$data['numtarjetasp'].'@'.$data['valorxtplastica'].'@'.$data['numtarjetasadic'].'"></td>
					  </tr>';
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

	Public function llena_detalle(){
		$id_casa = $this->input->post('id_casa');
		$this->load->model('GeneraRecibos_Model','GENR',true);
		$datasect=$this->GENR->llena_detalle($id_casa);
		$rp='';
		if($datasect['status']==200)
		 {
			 foreach ($datasect['data'] as $data) {
				$rp.='<tr>
						<td align="right">'.$data['cuotab'].'</td>
						<td align="right">'.$data['numtarjetasp'].'</td>
						<td align="right">'.$data['valorxtplastica'].'</td>
						<td align="right">'.$data['numtarjetasadic'].'</td>
						<td align="right">'.$data['valorxtadic'].'</td>
					  </tr>';
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

	Public function insertarecibos(){
		if( $this->session->userdata('logueado') ==FALSE ) {
		 	$response['status']=400;
		 	$response['message']='La Sesion a Expirado no es Posible realizar esta Accion';
		 	$response['data']='';
		 echo json_encode($response);
		}else{

				$this->load->model('GeneraRecibos_Model','GENR',true);
			 	$chk1 = $this->input->post('chk1');
			 	$total = $this->input->post('total');
			 	$tpago = $this->input->post('tpago');
			 	$fechap= $this->input->post('fechap');
			 	$obser= $this->input->post('obser');
			 	$contador=0;
				foreach ($chk1 as $data) {			 	
				 	$cadena=explode('@',$data);	
					$id_casa=$cadena[0];
					$id_cliente=$cadena[1];
					$monto=$cadena[2];
					$montoseg=$cadena[3];
					$montotar=$cadena[4];
					$id_mes=$cadena[5];
					$anno=$cadena[6];
					$numtarjetasp=$cadena[7];
					$valorxtplastica=$cadena[8];
					$numtarjetasadic=$cadena[9];
					$insertar=$this->GENR->insertarecibos($id_casa,$contador,$id_cliente,$monto,$montoseg,$montotar,$id_mes,$anno,
					                                      $tpago,$fechap,$obser,$numtarjetasp,$valorxtplastica,$numtarjetasadic);
					if ($contador==0) { //verifica los valores recibo y serie devueltos
						$documentos=explode('@',$insertar['data']);	
						//$primero=$insertar['data'];
						//$contador=$insertar['data'];
						$primero=$documentos[0];
						$contador=$documentos[0];
						$newserie=$documentos[1];
						$newempresa=$documentos[2];
					}
				 	$contador=$contador+1;		 	
				}		
			    $response['status']=200;
			    //$response['data']=$total.' Recibos generados con exito !!! Del '.$primero.' Al '.(($primero+$total)-1);
			    $response['data']=$primero.'@'.(($primero+$total)-1).'@'.$total.'@'.$newserie.'@'.$newempresa;
			echo json_encode($response); 
		 }	
			
		 }

	Public function Imprimir($recibo,$serie,$tipodoc,$empresa,$recibof){
		$this->load->model('GeneraRecibos_Model','GENR',true);
		$this->load->library('Pdf');
		if( $this->session->userdata('logueado') ==FALSE ) {
		 	$response['status']=400;
		 	$response['message']='<script>swal("Terra System","La Sesion a Expirado no es Posible realizar esta Accion","warning");</script>';
		 	$response['data']='';
		 echo json_encode($response);
		$this->load->view('header/header.php',$data);
		$this->load->view('Body/GeneraRecibosV.php',$data);
		$this->load->view('footer/footer.php',$data);		 
		}else{
			if($recibo>0 && $serie>0 && $tipodoc>0 && $empresa>0){
				$enc=$this->GENR->DatosEncabezado($recibo,$serie,$tipodoc,$empresa,$recibof);
				
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
foreach ($enc['data'] as $dataenc) {
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
		                $pdf->SetFont('Courier', 'B',7);
		                $pdf->MultiCell(195, 3, 'Contacto: '. $dataenc['logo'],                      $border, 'C', 1, 1, '', '', true);	
		                $pdf->SetFont('Courier', 'B',12);	                
		                $pdf->SetTextColor(255, 0, 0);
		                $pdf->MultiCell(195, 3, 'No. # '. $dataenc['recibo'],       						 $border, 'C', 1, 1, '', '', true);
		                $pdf->SetTextColor(0, 0, 0, 100);
		                $pdf->MultiCell(195, 3, "Serie \"". $dataenc['serie']. "\"",               $border, 'C', 1, 1, '', '', true);
		                $pdf->MultiCell(195, 3, ''.date('d-M-Y', strtotime($dataenc['femitido'])),       $border, 'C', 1, 1, '', '', true);
		                $pdf->MultiCell(195, 3, "",            									 $border, 'C', 1, 1, '', '', true);
		                $pdf->Ln(4);
						$pdf->MultiCell(195, 3, "Nombre: " .$dataenc['nombrecliente'],    $border, 'L', 1, 1, '', '', true);
						$pdf->Ln(1);
						$pdf->MultiCell(195, 3, "Dirección: " .$dataenc['dircorta'],      $border, 'L', 1, 1, '', '', true);
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
		             	$detalles=$this->GENR->DetalleRecibo($dataenc['recibo'],$dataenc['id_serie'],$dataenc['id_tipodoc'],$dataenc['id_empresa']);
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
								 	$pdf->Ln(30);
								 	$pdf->SetFont('Courier', 'B',7);
								 	$pdf->MultiCell( 195, 5, " Cancelación Realizada por: ".$dataenc['canceladox']." El Dia ".date('d-M-Y H:m', strtotime($dataenc['fcancelado'])), $border, 'C', 1, 0, '', '', true);
								 

						}
}
				// Imprimimos el texto con writeHTMLCell()
				 		$pdf->lastPage();
				// ---------------------------------------------------------
				// Cerrar el documento PDF y preparamos la salida
				// Este método tiene varias opciones, consulte la documentación para más información.
				        $nombre_archivo='';
				        $nombre_archivo = utf8_decode("Recibo_".$recibo.".pdf");
				        $pdf->Output($nombre_archivo, 'D');
				    
				}

			
	}		 		
	
}