<?php  


defined('BASEPATH') OR exit('No direct script access allowed');

error_reporting(E_ALL);
ini_set('display_errors', '1');


Class RepIngresosAjax extends CI_Controller {

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

		$this->load->model('RepIngresos_Model','MAN',true);

		$fini = $this->input->post('fini');
		$ffin = $this->input->post('ffin');
		$cliente=$this->input->post('cliente');

		$datasect=$this->MAN->Reporte($fini,$ffin,$cliente);
		//print_r($datasect);
		$rp='';
		$totalmant=0;
		$totaltarjetas=0;
		$grantotal=0;
		if($datasect['status']==200)
		 {
		 	$contador=1;
			 foreach ($datasect['data'] as $data) {

				$rp.='<tr>
						<td>'.$contador.'</td>
						<td>'.$data['recibo'].'</td>
						<td>'.$data['cliente'].'</td>
						<td>'.$data['ncasa'].'</td>
						<td>'.$data['nsector'].'</td>
						<td>'.$data['nomestado'].'</td>
						<td>'.$data['fpago'].'</td>
						<td>'.$data['moneda'].'</td>
						<td>'.$data['cuota_mat'].'</td>
						<td>'.$data['tarjetas'].'</td>
						<td>'.$data['monto'].'</td>

					  </tr>';
						$contador++;
						$totalmant=$totalmant+$data['cuota_mat'];
						$totaltarjetas=$totaltarjetas+$data['tarjetas'];
						$grantotal=$grantotal+$data['monto'];

			}	
			$rp.='<tr>
			       <td colspan="7" style="text-align:right;"><b>Totales:</b></td>
			       <td><b>'.$data['moneda'].'<b></td>
			       <td><b>'.$totalmant.'<b></td>
			       <td><b>'.$totaltarjetas.'<b></td>
			       <td><b>'.$grantotal.'<b></td>
			     </tr>';
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

	Public function autocompleteclientes() {
		$this->load->model('RepIngresos_Model','MAN',true);
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

	public function generar_excel($fini,$ffin,$cliente){
		$this->load->model('RepIngresos_Model','MAN',true);
	    $datasect=$this->MAN->Reporte($fini,$ffin,$cliente);
	    if($datasect['status']==200){
	    	$contador=3;
	        //Cargamos la librería de excel.
	        $this->load->library('Excel'); $this->excel->setActiveSheetIndex(0);
            $styleBorder = array(
                'borders' => array(
                  'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000')
                  ),
                ),
              );
	        $this->excel->getActiveSheet()->setTitle('Reporte de Ingresos');
	        $this->excel->getActiveSheet()->mergeCells('A1:K1');
            $objStyleB2=$this->excel->getActiveSheet()->getStyle('A1');
            $objFontB2 = $objStyleB2->getFont(); 
            $objFontB2->setName('Arial'); 
            $objFontB2->setSize(15); 
            $objFontB2->setBold(true); 
            $objFontB2 ->getColor()->setARGB('FFFF0000') ;
            $objFontB2 ->getColor()->setARGB( PHPExcel_Style_Color::COLOR_DARKBLUE); 
            $objStyleB2 = $objStyleB2->getAlignment(); 
            $objStyleB2->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
            $objStyleB2->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $this->excel->getActiveSheet()->setCellValue("A1",'Reporte de Ingresos Mensuales');
	        $this->excel->getActiveSheet()->mergeCells('A2:K2');
	        $objStyleA2=$this->excel->getActiveSheet()->getStyle('A2');
            $objFontA2 = $objStyleA2->getFont(); 
            $objFontA2->setName('Arial'); 
            $objFontA2->setSize(15); 
            $objFontA2->setBold(true); 
            $objFontA2 ->getColor()->setARGB('FFFF0000') ;
            $objFontA2 ->getColor()->setARGB( PHPExcel_Style_Color::COLOR_DARKBLUE); 
            $objStyleA2 = $objStyleA2->getAlignment(); 
            $objStyleA2->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
            $objStyleA2->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	        $this->excel->getActiveSheet()->setCellValue("A2", 'del periodo de '.date('d-M-Y', strtotime($fini)).' al '.date('d-M-Y', strtotime($ffin)));
	        //Contador de filas
	        $contador = 3;
	        //Le aplicamos ancho las columnas.
	        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10)->setAutoSize(TRUE);
	        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(10)->setAutoSize(TRUE);
	        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(100)->setAutoSize(TRUE);
	        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(30)->setAutoSize(TRUE);
	        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(30)->setAutoSize(TRUE);
	        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(10)->setAutoSize(TRUE);
	        $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(10)->setAutoSize(TRUE);
	        $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(30)->setAutoSize(TRUE);
	        $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(30)->setAutoSize(TRUE);
	        $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(30)->setAutoSize(TRUE);
	        $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(30)->setAutoSize(TRUE);
	        //Le aplicamos negrita a los títulos de la cabecera.
            $objStyleA3 = $this->excel ->getActiveSheet()->getStyle('A3');
            $objFillA3 = $objStyleA3->getFill(); 
            $objFillA3->setFillType(PHPExcel_Style_Fill::FILL_SOLID); 
            $objFillA3->getStartColor()->setARGB('F0E68C');
            $objStyleA3 = $this->excel ->getActiveSheet()->getStyle('B3');
            $objFillA3 = $objStyleA3->getFill(); 
            $objFillA3->setFillType(PHPExcel_Style_Fill::FILL_SOLID); 
            $objFillA3->getStartColor()->setARGB('F0E68C');
            $objStyleA3 = $this->excel ->getActiveSheet()->getStyle('C3');
            $objFillA3 = $objStyleA3->getFill(); 
            $objFillA3->setFillType(PHPExcel_Style_Fill::FILL_SOLID); 
            $objFillA3->getStartColor()->setARGB('F0E68C');
            $objStyleA3 = $this->excel ->getActiveSheet()->getStyle('D3');
            $objFillA3 = $objStyleA3->getFill(); 
            $objFillA3->setFillType(PHPExcel_Style_Fill::FILL_SOLID); 
            $objFillA3->getStartColor()->setARGB('F0E68C');
            $objStyleA3 = $this->excel ->getActiveSheet()->getStyle('D3');
            $objFillA3 = $objStyleA3->getFill(); 
            $objFillA3->setFillType(PHPExcel_Style_Fill::FILL_SOLID); 
            $objFillA3->getStartColor()->setARGB('F0E68C');
            $objStyleA3 = $this->excel ->getActiveSheet()->getStyle('E3');
            $objFillA3 = $objStyleA3->getFill(); 
            $objFillA3->setFillType(PHPExcel_Style_Fill::FILL_SOLID); 
            $objFillA3->getStartColor()->setARGB('F0E68C');
            $objStyleA3 = $this->excel ->getActiveSheet()->getStyle('F3');
            $objFillA3 = $objStyleA3->getFill(); 
            $objFillA3->setFillType(PHPExcel_Style_Fill::FILL_SOLID); 
            $objFillA3->getStartColor()->setARGB('F0E68C');
            $objStyleA3 = $this->excel ->getActiveSheet()->getStyle('G3');
            $objFillA3 = $objStyleA3->getFill(); 
            $objFillA3->setFillType(PHPExcel_Style_Fill::FILL_SOLID); 
            $objFillA3->getStartColor()->setARGB('F0E68C');
            $objStyleA3 = $this->excel ->getActiveSheet()->getStyle('H3');
            $objFillA3 = $objStyleA3->getFill(); 
            $objFillA3->setFillType(PHPExcel_Style_Fill::FILL_SOLID); 
            $objFillA3->getStartColor()->setARGB('F0E68C');
            $objStyleA3 = $this->excel ->getActiveSheet()->getStyle('I3');
            $objFillA3 = $objStyleA3->getFill(); 
            $objFillA3->setFillType(PHPExcel_Style_Fill::FILL_SOLID); 
            $objFillA3->getStartColor()->setARGB('F0E68C');
            $objStyleA3 = $this->excel ->getActiveSheet()->getStyle('J3');
            $objFillA3 = $objStyleA3->getFill(); 
            $objFillA3->setFillType(PHPExcel_Style_Fill::FILL_SOLID); 
            $objFillA3->getStartColor()->setARGB('F0E68C');
            $objStyleA3 = $this->excel ->getActiveSheet()->getStyle('K3');
            $objFillA3 = $objStyleA3->getFill(); 
            $objFillA3->setFillType(PHPExcel_Style_Fill::FILL_SOLID); 
            $objFillA3->getStartColor()->setARGB('F0E68C');
	        $this->excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("C{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("D{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("E{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("F{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("G{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("H{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("I{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("J{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->getStyle("k{$contador}")->getFont()->setBold(true);
	        //Definimos los títulos de la cabecera.
	        $this->excel->getActiveSheet()->setCellValue("A{$contador}", 'No.');
	        $this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Recibo');
	        $this->excel->getActiveSheet()->setCellValue("C{$contador}", 'Cliente');
	        $this->excel->getActiveSheet()->setCellValue("D{$contador}", 'Casa');
	        $this->excel->getActiveSheet()->setCellValue("E{$contador}", 'Sector');
	        $this->excel->getActiveSheet()->setCellValue("F{$contador}", 'Estado Doc');
	        $this->excel->getActiveSheet()->setCellValue("G{$contador}", 'Fecha Pago');
	        $this->excel->getActiveSheet()->setCellValue("H{$contador}", 'Moneda');
	        $this->excel->getActiveSheet()->setCellValue("I{$contador}", 'Seguridad');
	        $this->excel->getActiveSheet()->setCellValue("J{$contador}", 'Tarjetas');
	        $this->excel->getActiveSheet()->setCellValue("K{$contador}", 'Monto');
	        //Definimos la data del cuerpo.    
	        $contadorln=1;
	        $totalmant=0;
			$totaltarjetas=0;
			$grantotal=0;
	        foreach ($datasect['data'] as $data) {
	           //Incrementamos una fila más, para ir a la siguiente.
	           $contador++;
	           //Informacion de las filas de la consulta.
	        $this->excel->getActiveSheet()->setCellValue("A{$contador}",$contadorln);
	        $this->excel->getActiveSheet()->setCellValue("B{$contador}",$data['recibo']);
	        $this->excel->getActiveSheet()->setCellValue("C{$contador}",$data['cliente']);
	        $this->excel->getActiveSheet()->setCellValue("D{$contador}",$data['ncasa']);
	        $this->excel->getActiveSheet()->setCellValue("E{$contador}",$data['nsector']);
	        $this->excel->getActiveSheet()->setCellValue("F{$contador}",$data['nomestado']);
	        $this->excel->getActiveSheet()->setCellValue("G{$contador}",$data['fpago']);
	        $this->excel->getActiveSheet()->setCellValue("H{$contador}",$data['moneda']);
	        $this->excel->getActiveSheet()->setCellValue("I{$contador}",$data['cuota_mat']);
	        $this->excel->getActiveSheet()->setCellValue("J{$contador}",$data['tarjetas']);
	        $this->excel->getActiveSheet()->setCellValue("K{$contador}",$data['monto']);
	        $contadorln++;
	        	$totalmant=$totalmant+$data['cuota_mat'];
     			$totaltarjetas=$totaltarjetas+$data['tarjetas'];
				$grantotal=$grantotal+$data['monto'];
	        }
	        $contador++;
	        $objStyleA3 = $this->excel ->getActiveSheet()->getStyle("H{$contador}");
            $objFillA3 = $objStyleA3->getFill(); 
            $objFillA3->setFillType(PHPExcel_Style_Fill::FILL_SOLID); 
            $objFillA3->getStartColor()->setARGB('F0E68C');
            $objStyleA3 = $this->excel ->getActiveSheet()->getStyle("I{$contador}");
            $objFillA3 = $objStyleA3->getFill(); 
            $objFillA3->setFillType(PHPExcel_Style_Fill::FILL_SOLID); 
            $objFillA3->getStartColor()->setARGB('F0E68C');
	        $objStyleA3 = $this->excel ->getActiveSheet()->getStyle("J{$contador}");
            $objFillA3 = $objStyleA3->getFill(); 
            $objFillA3->setFillType(PHPExcel_Style_Fill::FILL_SOLID); 
            $objFillA3->getStartColor()->setARGB('F0E68C');
	        $objStyleA3 = $this->excel ->getActiveSheet()->getStyle("K{$contador}");
            $objFillA3 = $objStyleA3->getFill(); 
            $objFillA3->setFillType(PHPExcel_Style_Fill::FILL_SOLID); 
            $objFillA3->getStartColor()->setARGB('F0E68C');
	        $this->excel->getActiveSheet()->getStyle("H{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->setCellValue("H{$contador}",'Total Q');
	        $this->excel->getActiveSheet()->getStyle("I{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->setCellValue("I{$contador}",$totalmant);
	        $this->excel->getActiveSheet()->getStyle("J{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->setCellValue("J{$contador}",$totaltarjetas);
	        $this->excel->getActiveSheet()->getStyle("K{$contador}")->getFont()->setBold(true);
	        $this->excel->getActiveSheet()->setCellValue("K{$contador}",$grantotal);
			$this->excel->getActiveSheet()->getStyle("A3:K{$contador}")->applyFromArray($styleBorder);
	        //Le ponemos un nombre al archivo que se va a generar.
	        $archivo = "Rep_Ingresos.xls";
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
