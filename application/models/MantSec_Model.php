<?php  
Class MantSec_Model extends CI_Model {



	 Public function Sectores(){
	 	$response = array(
		    'status' => 400,
		    'message' => '',
		    'data' => '',
		);
		 $this->db->select('a.id_sector, a.codigo,trim(a.nombre) as nombresector,a.id_estados,b.nombre as tsector');
		 $this->db->from('dbs_sector a');
		 $this->db->join('dbs_tipodecuota b','b.id_tipodecuota=a.id_tipodecuota','INNER');
		 $this->db->order_by('id_sector','ASC');
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
	 Public function InsertarDatos($nombre,$codigo,$tsector){
		$response = array(
		    'status' => 400,
		    'message' => '',
		    'data' => '',
		);
		$query=$this->db->query('SELECT CONVERT(DATE_FORMAT(CURRENT_TIMESTAMP, "%d %M %Y %T"),CHARACTER) as fecha');
		$rows=$query->result_array();
		$fechasistema=$rows[0]['fecha'];
	 	$usuario=$this->session->userdata('usuario');
	 	$empresasis=$this->session->userdata('empresa');
	 	$data = array(
					 'id_sector' =>NULL,
					 'id_empresa' => $empresasis,
					 'codigo' => $codigo,
					 'nombre' => $nombre,
					 'id_estados' => 1,
					 'id_tipodecuota'=>$tsector,
					 'bitacora' =>";Ingresado x ".$usuario." via Terra System el '".$fechasistema."'"
					 );
			$this->db->trans_begin();
			$this->db->insert('dbs_sector',$data);
			$statusinsert=$this->db->trans_status();
			if ( $statusinsert === FALSE){

			        $this->db->trans_rollback();
				 	$response['status']=400;
				 	$response['message']='Ocurrio un Error al realizar esta Accion';
				 	$response['data']='';
				 	return $response;
			}else{
			        $this->db->trans_commit();
		 			$response['status']=200;
		 			$response['message']='Sector Ingresado con Exito';
		 			$response['data']='';
		 			return $response;
			}
			
		}
		Public function InactivarDatos($idsector){
		$response = array(
		    'status' => 400,
		    'message' => '',
		    'data' => '',
		);
		$query=$this->db->query('SELECT CONVERT(DATE_FORMAT(CURRENT_TIMESTAMP, "%d %M %Y %T"),CHARACTER) as fecha');
		$rows=$query->result_array();
		$fechasistema=$rows[0]['fecha'];
	 	$usuario=$this->session->userdata('usuario');

			$this->db->trans_begin();
			$query=$this->db->query("SELECT count(*) as conteo from dbs_asignacasa where id_casa in (SElECT id_casa from dbs_casa where id_sector=".$idsector." and id_estadocasa=2)" );
			$casas=$query->result_array();
			if ($casas[0]['conteo']>0){
				$statusinsert=FALSE;
			}else{
				  $query=$this->db->query("UPDATE dbs_sector set id_estados=2, bitacora=CONCAT(bitacora,';Inactivado x ".$usuario." via Terra System el ".$fechasistema."') where id_sector=".$idsector.";");
			      $statusinsert=$this->db->trans_status();
			  }
			if ( $statusinsert === FALSE){

			        $this->db->trans_rollback();
				 	$response['status']=400;
				 	$response['message']='El Sector tiene casas Asignadas Accion Rechazada';
				 	$response['data']='';
				 	return $response;
			}else{
			        $this->db->trans_commit();
		 			$response['status']=200;
		 			$response['message']='Sector Inactivado con Exito';
		 			$response['data']='';
		 			return $response;
			}
			
		}
    public function TiposSectores() {
        $query = "SELECT id_tipodecuota,nombre from dbs_tipodecuota  order by nombre asc";
        return $this->db->dropdown_array($query, 'id_tipodecuota', 'nombre','Seleccione Tipo de Sector',0);
     }


}

