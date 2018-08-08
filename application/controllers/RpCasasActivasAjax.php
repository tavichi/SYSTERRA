<?php  


defined('BASEPATH') OR exit('No direct script access allowed');

/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/


Class RpCasasActivasAjax extends CI_Controller {

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
		$this->load->model('RpCasasActivas_Model','GENR',true);
		$datasect=$this->GENR->TraeSectores($sector);
		$rp='';
		$contador=0;
		if($datasect['status']==200)
		 {
		 	$color='class="success "'; 
			 foreach ($datasect['data'] as $data) {
			 	$contador=$contador+1;
				$rp.='<tr '.$color.'>
						<td align="right">'.$contador.'</td>
						<td>'.$data['nombsector'].'</td>
						<td align="center">'.$data['nocasa'].'</td>
						<td align="center">'.$data['codigo_seg'].'</td>
						<td>'.$data['dir_completa'].'</td>
						<td>'.$data['nombrecliente'].'</td>
						<td>'.$data['falta'].'</td>
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


	public function generar_excel($sector){
		$this->load->model('RpCasasActivas_Model','MANC',true);
	    $datasect=$this->MANC->Reporte($sector);
	    if($datasect['status']==200){
	    	$contador=1;
	        //Cargamos la librería de excel.
	        $this->load->library('Excel'); $this->excel->setActiveSheetIndex(0);
	        $this->excel->getActiveSheet()->setTitle('Reporte Gral.');
	        //Contador de filas
	        $contador = 1;
	        //Le aplicamos ancho las columnas.
	        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(6);
	        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
	        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
	        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
	        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
	        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(70);
	        $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
	        //columnas para los TELEFONOS
	        $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
	        $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
	        $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
	        $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
	        $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
	        //columnas para las TARJETAS
	        $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
	        $this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(10);
	        $this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(10);
	        $this->excel->getActiveSheet()->getColumnDimension('P')->setWidth(10);
	        $this->excel->getActiveSheet()->getColumnDimension('Q')->setWidth(10);
	        //columnas para los VEHICULOS
	        $this->excel->getActiveSheet()->getColumnDimension('R')->setWidth(10);
	        $this->excel->getActiveSheet()->getColumnDimension('S')->setWidth(10);
	        $this->excel->getActiveSheet()->getColumnDimension('T')->setWidth(10);
	        $this->excel->getActiveSheet()->getColumnDimension('U')->setWidth(10);
	        $this->excel->getActiveSheet()->getColumnDimension('V')->setWidth(10);
	        //Le aplicamos negrita a los títulos de la cabecera.
	        $this->excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("C{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("D{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("E{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("F{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("G{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("H{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("M{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("R{$contador}")->getFont()->setBold(true);
	        //Definimos los títulos de la cabecera.
	        $this->excel->getActiveSheet()->setCellValue("A{$contador}", 'No.');
	        $this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Sector');
	        $this->excel->getActiveSheet()->setCellValue("C{$contador}", 'No. Casa');
	        $this->excel->getActiveSheet()->setCellValue("D{$contador}", 'Cod.Seg.');
	        $this->excel->getActiveSheet()->setCellValue("E{$contador}", 'Dir. Catastro');
	        $this->excel->getActiveSheet()->setCellValue("F{$contador}", 'Cliente');
	        $this->excel->getActiveSheet()->setCellValue("G{$contador}", 'F.Alta');
	        $this->excel->getActiveSheet()->setCellValue("H{$contador}", 'Telefonos');
	        $this->excel->getActiveSheet()->setCellValue("M{$contador}", 'Tarjetas');
	        $this->excel->getActiveSheet()->setCellValue("R{$contador}", 'Vehiculos');
	        $this->excel->setActiveSheetIndex(0)->mergecells('H1:L1');
	        $this->excel->setActiveSheetIndex(0)->mergecells('M1:Q1');
	        $this->excel->setActiveSheetIndex(0)->mergecells('R1:V1');
	        //Definimos la data del cuerpo.    
	        $contadorln=1;    
	        foreach ($datasect['data'] as $data) {
	           //Incrementamos una fila más, para ir a la siguiente.
	           $contador++;
	           //Informacion de las filas de la consulta.

		        $this->excel->getActiveSheet()->setCellValue("A{$contador}",$contadorln);
		        $this->excel->getActiveSheet()->setCellValue("B{$contador}",$data['nombsector']);
		        $this->excel->getActiveSheet()->setCellValue("C{$contador}",$data['nocasa']);
		        $this->excel->getActiveSheet()->setCellValue("D{$contador}",$data['codigo_seg']);
		        $this->excel->getActiveSheet()->setCellValue("E{$contador}",$data['dir_completa']);
		        $this->excel->getActiveSheet()->setCellValue("F{$contador}",$data['nombrecliente']);
		        $this->excel->getActiveSheet()->setCellValue("G{$contador}",$data['falta']);

		        //OBTENEMOS LOS TELEFONOS DE CADA CLIENTE
			    $datatele=$this->MANC->Telefonos($data['id_identidad']);
			    if($datatele['status']==200){
			    	$col='H';
			      foreach ($datatele['data'] as $data) {	
			      	$this->excel->getActiveSheet()->setCellValue($col.$contador,$data['numtel']);
			      	$col++;
			      }
			    }	

		        //OBTENEMOS LAS TARJETAS DE CADA CLIENTE
			    $datatarje=$this->MANC->Tarjetas($data['id_identidad']);
			    if($datatarje['status']==200){
			    	$col='M';
			      foreach ($datatarje['data'] as $data) {	
			      	$this->excel->getActiveSheet()->setCellValue($col.$contador,$data['numero']);
			      	$col++;
			      }
			    }	

		        //OBTENEMOS LAS VEHICULOS DE CADA CLIENTE
			    $datavehi=$this->MANC->Vehiculos($data['id_identidad']);
			    if($datavehi['status']==200){
			    	$col='R';
			      foreach ($datavehi['data'] as $data) {	
			      	$this->excel->getActiveSheet()->setCellValue($col.$contador,$data['placa']);
			      	$col++;
			      }
			    }	

		        $contadorln++;
	        }
	        //Le ponemos un nombre al archivo que se va a generar.
	        $archivo = "Rep_CasasActivas.xls";
	        header('Content-Type: application/vnd.ms-excel');
	        header('Content-Disposition: attachment;filename="'.$archivo.'"');
	        header('Cache-Control: max-age=0');
	        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
	        //Hacemos una salida al navegador con el archivo Excel.
	        $objWriter->save('php://output');
	     }else{
	        echo 'No se han encontrado llamadas';
	        exit;        
	     }
	  }	
}