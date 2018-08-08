<?php  
Class RpCuentasxCobrar_Model extends CI_Model {

     public function Sectores() {
        $query = "SELECT lpad(trim(nombre),'20','0') as orden,id_sector,nombre 
                  from dbs_sector where id_estados=1 UNION 
                  SELECT '',-1,'Todos'
                 ";
        return $this->db->dropdown_array($query, 'id_sector', 'nombre','Seleccione Sector',0);
     }

	 Public function TraeCasasxSector($sector,$casash){
	 	$response = array(
		    'status' => 400,
		    'message' => '',
		    'data' => '',
		);
		 $idusuario=$this->session->userdata('id_usuario');
		 if ($casash==1) { //muestra las casas que tienen cliente asignado
		 	//$sincliente=' and cxc.codcliente is not NULL';	
		 	$sincliente='';		 	
		 } else{
		 	$sincliente=' and cxc.codcliente is NULL';
		 }

		 $this->db->select('cxc.*,xmes.mes1,xmes.mes2,xmes.mes3,xmes.mes4,xmes.mes5,xmes.mes6,
       						xmes.mes7,xmes.mes8,xmes.mes9,xmes.mes10,xmes.mes11,xmes.mes12  ');
		 $this->db->from('dbv_reportecxc_mensual cxc');
		 $this->db->join('dbs_tmpreportecxc xmes','xmes.id_casa=cxc.id_casa and xmes.id_usuario='.$idusuario,'left');	
		 if ($sector!=-1) {
		 	$this->db->where('cxc.id_sector='.$sector.$sincliente);
		 	$this->db->order_by('lpad(codsector,10,"0"),lpad(numero,10,"0")','');	 
		 } else{
		 	$this->db->where(' 1=1 '.$sincliente);
		 	$this->db->order_by('lpad(codsector,10,"0"),lpad(numero,10,"0")','');	 
		 }


		 
		 //$this->db->order_by('cxc.sectorcasa','ASC');
		 $result=$this->db->get();
		 $sectores=$result->result_array();

		 if ($result->num_rows()>0){

		    $response['status']=200;
		    $response['data']=$sectores;
		    $response['message']='';
		    return $response;
		 }else{
		 	$response['status']=401;
		 	$response['message']='Datos no encontrados para mostrar';
		 	$response['data']='';
		 	return $response;
		 }
	 }	 

	 Public function PreparaTabla($sector,$casash){
	 	$response = array(
		    'status' => 400,
		    'message' => '',
		    'data' => '',
		);

	 	$idusuario=$this->session->userdata('id_usuario');

		if ($casash==1) { //muestra las casas que tienen cliente asignado
			$query=$this->db->query("SELECT cast(CONCAT_WS('-',year(CURRENT_TIMESTAMP),month(CURRENT_TIMESTAMP),'1') as date) as m1,
				date_add(cast(CONCAT_WS('-',year(CURRENT_TIMESTAMP),month(CURRENT_TIMESTAMP),'1') as date), INTERVAL -1 MONTH) as m2,
				date_add(cast(CONCAT_WS('-',year(CURRENT_TIMESTAMP),month(CURRENT_TIMESTAMP),'1') as date), INTERVAL -2 MONTH) as m3,
				date_add(cast(CONCAT_WS('-',year(CURRENT_TIMESTAMP),month(CURRENT_TIMESTAMP),'1') as date), INTERVAL -3 MONTH) as m4,
				date_add(cast(CONCAT_WS('-',year(CURRENT_TIMESTAMP),month(CURRENT_TIMESTAMP),'1') as date), INTERVAL -4 MONTH) as m5,
				date_add(cast(CONCAT_WS('-',year(CURRENT_TIMESTAMP),month(CURRENT_TIMESTAMP),'1') as date), INTERVAL -5 MONTH) as m6,
				date_add(cast(CONCAT_WS('-',year(CURRENT_TIMESTAMP),month(CURRENT_TIMESTAMP),'1') as date), INTERVAL -6 MONTH) as m7,
				date_add(cast(CONCAT_WS('-',year(CURRENT_TIMESTAMP),month(CURRENT_TIMESTAMP),'1') as date), INTERVAL -7 MONTH) as m8,
				date_add(cast(CONCAT_WS('-',year(CURRENT_TIMESTAMP),month(CURRENT_TIMESTAMP),'1') as date), INTERVAL -8 MONTH) as m9,
				date_add(cast(CONCAT_WS('-',year(CURRENT_TIMESTAMP),month(CURRENT_TIMESTAMP),'1') as date), INTERVAL -9 MONTH) as m10,
				date_add(cast(CONCAT_WS('-',year(CURRENT_TIMESTAMP),month(CURRENT_TIMESTAMP),'1') as date), INTERVAL -10 MONTH) as m11,
				date_add(cast(CONCAT_WS('-',year(CURRENT_TIMESTAMP),month(CURRENT_TIMESTAMP),'1') as date), INTERVAL -11 MONTH) as m12");
			$rows=$query->result_array();
			$mes1=$rows[0]['m1'];
			$mes2=$rows[0]['m2'];
			$mes3=$rows[0]['m3'];
			$mes4=$rows[0]['m4'];
			$mes5=$rows[0]['m5'];
			$mes6=$rows[0]['m6'];
			$mes7=$rows[0]['m7'];
			$mes8=$rows[0]['m8'];
			$mes9=$rows[0]['m9'];
			$mes10=$rows[0]['m10'];
			$mes11=$rows[0]['m11'];
			$mes12=$rows[0]['m12'];
			$meses=$mes1.'@'.$mes2.'@'.$mes3.'@'.$mes4.'@'.$mes5.'@'.$mes6.'@'.$mes7.'@'.$mes8.'@'.$mes9.'@'.$mes10.'@'.$mes11.'@'.$mes12; 
			 if ($sector!=-1) { //entra aca cuando eligen un sector especifico
				$query=$this->db->query("delete from dbs_tmpreportecxc where id_usuario=".$idusuario.";");
				$query=$this->db->query("call dbpa_pagosxmes(".$idusuario.",".$sector.",'".$mes1."',12);");
				$query=$this->db->query("call dbpa_pagosxmes(".$idusuario.",".$sector.",'".$mes2."',11);");
				$query=$this->db->query("call dbpa_pagosxmes(".$idusuario.",".$sector.",'".$mes3."',10);");
				$query=$this->db->query("call dbpa_pagosxmes(".$idusuario.",".$sector.",'".$mes4."',9);");
				$query=$this->db->query("call dbpa_pagosxmes(".$idusuario.",".$sector.",'".$mes5."',8);");
				$query=$this->db->query("call dbpa_pagosxmes(".$idusuario.",".$sector.",'".$mes6."',7);");
				$query=$this->db->query("call dbpa_pagosxmes(".$idusuario.",".$sector.",'".$mes7."',6);");
				$query=$this->db->query("call dbpa_pagosxmes(".$idusuario.",".$sector.",'".$mes8."',5);");
				$query=$this->db->query("call dbpa_pagosxmes(".$idusuario.",".$sector.",'".$mes9."',4);");
				$query=$this->db->query("call dbpa_pagosxmes(".$idusuario.",".$sector.",'".$mes10."',3);");
				$query=$this->db->query("call dbpa_pagosxmes(".$idusuario.",".$sector.",'".$mes11."',2);");
				$query=$this->db->query("call dbpa_pagosxmes(".$idusuario.",".$sector.",'".$mes12."',1);");
			 } else{
				$query=$this->db->query("delete from dbs_tmpreportecxc where id_usuario=".$idusuario.";");
				$query=$this->db->query("call dbpa_pagosxmestodos(".$idusuario.",'".$mes1."',12);");
				$query=$this->db->query("call dbpa_pagosxmestodos(".$idusuario.",'".$mes2."',11);");
				$query=$this->db->query("call dbpa_pagosxmestodos(".$idusuario.",'".$mes3."',10);");
				$query=$this->db->query("call dbpa_pagosxmestodos(".$idusuario.",'".$mes4."',9);");
				$query=$this->db->query("call dbpa_pagosxmestodos(".$idusuario.",'".$mes5."',8);");
				$query=$this->db->query("call dbpa_pagosxmestodos(".$idusuario.",'".$mes6."',7);");
				$query=$this->db->query("call dbpa_pagosxmestodos(".$idusuario.",'".$mes7."',6);");
				$query=$this->db->query("call dbpa_pagosxmestodos(".$idusuario.",'".$mes8."',5);");
				$query=$this->db->query("call dbpa_pagosxmestodos(".$idusuario.",'".$mes9."',4);");
				$query=$this->db->query("call dbpa_pagosxmestodos(".$idusuario.",'".$mes10."',3);");
				$query=$this->db->query("call dbpa_pagosxmestodos(".$idusuario.",'".$mes11."',2);");
				$query=$this->db->query("call dbpa_pagosxmestodos(".$idusuario.",'".$mes12."',1);");
			 }
		} else{ //como son casas sin cliente, solamente se limpia la tabla temporal
		 	$query=$this->db->query("delete from dbs_tmpreportecxc where id_usuario=".$idusuario.";");
		 	$meses=''; 
		 }



		$response['status']=200;
		$response['message']='Tablas limpias !!!';
		$response['data']=$meses;
		return $response;

	 }	 



}

