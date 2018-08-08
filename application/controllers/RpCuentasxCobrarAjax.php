<?php  


defined('BASEPATH') OR exit('No direct script access allowed');

/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/


Class RpCuentasxCobrarAjax extends CI_Controller {

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
		$casash = $this->input->post('casash'); //1 CASAS CON CLIENTE 0 CASAS SIN CLIENTE
		$this->load->model('RpCuentasxCobrar_Model','GENR',true);
		$dataclean=$this->GENR->PreparaTabla($sector,$casash);
		$datasect=$this->GENR->TraeCasasxSector($sector,$casash);
		$rp='';
		$contador=0;
		$tituloss=$dataclean['data'];
		if($datasect['status']==200){
			if ($casash==1) {
				$cadena=explode('@',$tituloss);	
				$mes1=$cadena[0];
				$mes2=$cadena[1];
				$mes3=$cadena[2];
				$mes4=$cadena[3];
				$mes5=$cadena[4];
				$mes6=$cadena[5];
				$mes7=$cadena[6];
				$mes8=$cadena[7];
				$mes9=$cadena[8];
				$mes10=$cadena[9];
				$mes11=$cadena[10];
				$mes12=$cadena[11];
				$rp.='  <thead>
					 		<th>No.</th>
					 		<th>Sector</th>
					 		<th>Casa</th>
					 		<th>Cliente</th>
					 		<th>Inicio</th>
					 		<th>N.T.</th>
					 		<th>N.V.</th>
					 		<th>'.date('M-y',strtotime($mes12)).'</th>
					 		<th>'.date('M-y',strtotime($mes11)).'</th>
					 		<th>'.date('M-y',strtotime($mes10)).'</th>
					 		<th>'.date('M-y',strtotime($mes9)).'</th>
					 		<th>'.date('M-y',strtotime($mes8)).'</th>
					 		<th>'.date('M-y',strtotime($mes7)).'</th>
					 		<th>'.date('M-y',strtotime($mes6)).'</th>
					 		<th>'.date('M-y',strtotime($mes5)).'</th>
					 		<th>'.date('M-y',strtotime($mes4)).'</th>
					 		<th>'.date('M-y',strtotime($mes3)).'</th>
					 		<th>'.date('M-y',strtotime($mes2)).'</th>
					 		<th>'.date('M-y',strtotime($mes1)).'</th>
					 	</thead>
					 	<tbody >';
			} else{
				$rp.='  <thead>
					 		<th>No.</th>
					 		<th>Sector</th>
					 		<th>Casa</th>
					 		<th>Cliente</th>
					 		<th>Inicio</th>
					 		<th>N.T.</th>
					 		<th>N.V.</th>
					 		<th>M1</th>
					 		<th>M2</th>
					 		<th>M3</th>
					 		<th>M4</th>
					 		<th>M5</th>
					 		<th>M6</th>
					 		<th>M7</th>
					 		<th>M8</th>
					 		<th>M9</th>
					 		<th>M10</th>
					 		<th>M11</th>
					 		<th>M12</th>
					 	</thead>
					 	<tbody >';				
			}

			 foreach ($datasect['data'] as $data) {
			 	if ($data['codcliente']== ''){
			 		//$periodo='<td>'.$data['primerper'].'</td>';
			 		$color='class="danger "';
			 		$color2='red';
			 	}else{
			 		//$periodo='<td>'.$data['siguienteper'].'</td>';
			 		$color='class="success "';
			 		$color2='black';
			 	}
			 	$contador=$contador+1;
				$rp.='<tr '.$color.'>
						<td>'.$contador.'</td>
						<td style="color:'.$color2.'; text-align: center;"> '.$data['codsector'].'</td>
						<td style="color:'.$color2.'; text-align: center;"> '.$data['numero'].'</td>
						<td>'.$data['nombrecliente'].'</td>
						<td>'.$data['primerper'].'</td>
						<td>'.$data['numtarjetas'].'</td>
						<td>'.$data['numveh'].'</td>
						<td>'.$data['mes1'].'</td>
						<td>'.$data['mes2'].'</td>
						<td>'.$data['mes3'].'</td>
						<td>'.$data['mes4'].'</td>
						<td>'.$data['mes5'].'</td>
						<td>'.$data['mes6'].'</td>
						<td>'.$data['mes7'].'</td>
						<td>'.$data['mes8'].'</td>
						<td>'.$data['mes9'].'</td>
						<td>'.$data['mes10'].'</td>
						<td>'.$data['mes11'].'</td>
						<td>'.$data['mes12'].'</td>
					  </tr>';

			}	
			$rp.='  </tbody>';
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

}