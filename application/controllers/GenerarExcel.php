<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class GenerarExcel extends CI_Controller {
 public function __construct(){
    parent::__construct(); 
 }

public function generar_excel($id_cliente=null){
    $llamadas = 1;
    if(count($llamadas) > 0){
        //Cargamos la librería de excel.
        $this->load->library('Excel'); $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Llamadas');
        //Contador de filas
        $contador = 1;
        //Le aplicamos ancho las columnas.
        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(100);
        //Le aplicamos negrita a los títulos de la cabecera.
        $this->excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle("C{$contador}")->getFont()->setBold(true);
        //Definimos los títulos de la cabecera.
        $this->excel->getActiveSheet()->setCellValue("A{$contador}", 'Número de teléfono');
        $this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Fecha');
        $this->excel->getActiveSheet()->setCellValue("C{$contador}", 'Mensaje');
        //Definimos la data del cuerpo.        
        /*foreach($llamadas as $l){
           //Incrementamos una fila más, para ir a la siguiente.
           $contador++;
           //Informacion de las filas de la consulta.
           $this->excel->getActiveSheet()->setCellValue("A{$contador}", $l->telefono);
           $this->excel->getActiveSheet()->setCellValue("B{$contador}", $l->fecha);
           $this->excel->getActiveSheet()->setCellValue("C{$contador}", $l->mensaje);
        }*/
        //Le ponemos un nombre al archivo que se va a generar.
        $archivo = "llamadas_cliente.xls";
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