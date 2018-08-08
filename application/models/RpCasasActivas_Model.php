<?php  
Class RpCasasActivas_Model extends CI_Model {

     public function Sectores() {
        $query = "SELECT lpad(trim(nombre),'20','0') as orden,id_sector,nombre from dbs_sector where id_estados=1 
                  UNION 
                  SELECT '',-1,'Todos'
                 ";
        return $this->db->dropdown_array($query, 'id_sector', 'nombre','Seleccione Sector',0);
     }


	 Public function TraeSectores($sector){
	 	$response = array(
		    'status' => 400,
		    'message' => '',
		    'data' => '',
		);
		 $this->db->select('id_casa AS codcasa,sector as nombsector,numero as nocasa,codigo_seg,dir_catastro as dir_completa,
					         CONVERT(DATE_FORMAT(f_alta, "%d %M %Y "),CHARACTER) as falta,id_identidad, 
					         nombrecliente, sectorcasa ');
		 $this->db->from('dbv_periodoxcasa');
		 if ($sector!=-1) {
		 	$this->db->where('id_sector',$sector);
		 	$this->db->order_by('numero','ASC');
		 } else{
		 	$this->db->order_by('nombsector,numero','ASC');
		 }
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

	 Public function llena_detalle($id_casa){
	 	$response = array(
		    'status' => 400,
		    'message' => '',
		    'data' => '',
		);
		 $this->db->select('id_casa,cuotab,numtarjetasp,valorxtplastica,valorxtadic,numtarjetasadic ');
		 $this->db->from('dbv_periodoxcasa');
		 $this->db->where('id_casa',$id_casa);	
		 $this->db->order_by('sector,lpad(numero,10,"0")','');	 	
		 $result=$this->db->get();
		 $detalle=$result->result_array();

		 if ($result->num_rows()>0){

		    $response['status']=200;
		    $response['data']=$detalle;
		    $response['message']='';
		    return $response;
		 }else{
		 	$response['status']=401;
		 	$response['message']='Datos no encontrados para mostrar';
		 	$response['data']='';
		 	return $response;
		 }
	 }	


	Public function Reporte($sector){
	 	$response = array(
		    'status' => 400,
		    'message' => '',
		    'data' => '',
		);
		 if ($sector!=-1) {
		 	$filtro='and id_sector='.$sector;
		 } else{
		 	$filtro='';
		 }

	 	$query='select id_casa AS codcasa,sector as nombsector,numero as nocasa,codigo_seg,dir_catastro as dir_completa,
					         CONVERT(DATE_FORMAT(f_alta, "%d %M %Y "),CHARACTER) as falta,id_identidad, 
					         nombrecliente, sectorcasa
				from dbv_periodoxcasa a
				where 1=1 '.$filtro.' 
				order BY sector,lpad(numero,10,"0");';

		//print_r("<pre>".$query."</pre>");die();
		 $result=$this->db->query($query);
		 $rep=$result->result_array();

		 if ($result->num_rows()>0){

		    $response['status']=200;
		    $response['data']=$rep;
		    $response['message']='';
		    return $response;
		 }else{
		 	$response['status']=401;
		 	$response['message']='Datos no encontrados para mostrar';
		 	$response['data']='';
		 	return $response;
		 }
	}

	Public function Telefonos($id_identidad){
	 	$response = array(
		    'status' => 400,
		    'message' => '',
		    'data' => '',
		);
	 	$query='select *
				from dbv_telefonosxcli a
				where id_identidad= '.$id_identidad.' 
				order BY numtel  limit 5;';

		 $result=$this->db->query($query);
		 $rep=$result->result_array();

		 if ($result->num_rows()>0){
		    $response['status']=200;
		    $response['data']=$rep;
		    $response['message']='';
		    return $response;
		 }else{
		 	$response['status']=401;
		 	$response['message']='Datos no encontrados para mostrar';
		 	$response['data']='';
		 	return $response;
		 }
	}

	Public function Tarjetas($id_identidad){
	 	$response = array(
		    'status' => 400,
		    'message' => '',
		    'data' => '',
		);
	 	$query='select *
				from dbv_tarjetasxcliente a
				where id_identidad= '.$id_identidad.' 
				order BY numero  limit 5;';

		 $result=$this->db->query($query);
		 $rep=$result->result_array();

		 if ($result->num_rows()>0){
		    $response['status']=200;
		    $response['data']=$rep;
		    $response['message']='';
		    return $response;
		 }else{
		 	$response['status']=401;
		 	$response['message']='Datos no encontrados para mostrar';
		 	$response['data']='';
		 	return $response;
		 }
	}

	Public function Vehiculos($id_identidad){
	 	$response = array(
		    'status' => 400,
		    'message' => '',
		    'data' => '',
		);
	 	$query='select *
				from dbv_vehiculosa a
				where id_identidad= '.$id_identidad.' 
				order BY placa  limit 5;';

		 $result=$this->db->query($query);
		 $rep=$result->result_array();

		 if ($result->num_rows()>0){
		    $response['status']=200;
		    $response['data']=$rep;
		    $response['message']='';
		    return $response;
		 }else{
		 	$response['status']=401;
		 	$response['message']='Datos no encontrados para mostrar';
		 	$response['data']='';
		 	return $response;
		 }
	}

}

