<?php  
Class MantPrecios_Model extends CI_Model {



	 Public function ListaPrecios(){
	 	$response = array(
		    'status' => 400,
		    'message' => '',
		    'data' => '',
		);

		 $query = "SELECT a.id_listadopa,a.id_producto,a.id_moneda,a.id_estadolis,a.observacion,DATE_FORMAT(a.f_inicio,'%d %M %Y') as f_inicio,a.precio,
		 				  e.nombre AS descestado,d.nombre AS tipocuota,c.simbolo as moneda
						FROM
							dbs_listadopa a
						INNER JOIN dbs_producto b ON (b.id_producto = a.id_producto)
						INNER JOIN dbs_moneda c ON (c.id_moneda = a.id_moneda)
						INNER JOIN dbs_tipodecuota d ON (d.id_tipodecuota = a.id_tipodecuota)
						INNER JOIN dbs_estadolis e ON (e.id_estadolis = a.id_estadolis)
						ORDER BY a.id_producto";
		 $result=$this->db->query($query);
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
     public function Tproducto() {
        $query = "SELECT id_producto,nombre from dbs_producto where id_estadopro=1 order by nombre asc";
        return $this->db->dropdown_array($query, 'id_producto', 'nombre','Seleccione Producto',0);
     }
     public function Tmoneda() {
        $query = "SELECT id_moneda,simbolo from dbs_moneda";
        return $this->db->dropdown_array($query, 'id_moneda', 'simbolo','Seleccione Moneda',0);
     }
     public function TipoPro() {
        $query = "SELECT id_tipopro,nombre from dbs_tipopro";
        return $this->db->dropdown_array($query, 'id_tipopro', 'nombre','Seleccione T. Producto',0);
     }
    
	 Public function InsertarDatos($tsector,$tproducto,$observacion,$precio,$fecha){
		$response = array(
		    'status' => 400,
		    'message' => '',
		    'data' => '',
		);
		$query=$this->db->query('SELECT CONVERT(DATE_FORMAT(CURRENT_TIMESTAMP, "%d %M %Y %T"),CHARACTER) as fecha,CURRENT_TIMESTAMP as fechatransac');
		$rows=$query->result_array();
		$fechasistema=$rows[0]['fecha'];
		$ftransac=$rows[0]['fechatransac'];
	 	$usuario=$this->session->userdata('usuario');
	 	$empresasis=$this->session->userdata('empresa');
	 	$id_usuario=$this->session->userdata('id_usuario');
	 	$data = array(
					 'id_listadopa' =>NULL,
					 'id_producto' => $tproducto,
					 'id_moneda' => 1,
					 'precio' => $precio,
					 'observacion' => $observacion,
					 'f_inicio' => $ftransac,
					 'f_final' =>$fecha,
					 'id_estadolis'=>1,
					 'id_ingresado'=>$id_usuario,
					 'id_tipodecuota'=>$tsector,
					 'bitacora' =>";Ingresado x ".$usuario." via Terra System el '".$fechasistema."'"
					 );
			$this->db->trans_begin();
			$this->db->insert('dbs_listadopa',$data);
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
		 			$response['message']='Precio Autorizado e Ingresado con Exito';
		 			$response['data']='';
		 			return $response;
			}
			
		}
	 Public function InsertarDatosProd($tproducto,$moneda,$nombreproducto,$abr,$precio){
		$response = array(
		    'status' => 400,
		    'message' => '',
		    'data' => '',
		);
		$query=$this->db->query('SELECT CONVERT(DATE_FORMAT(CURRENT_TIMESTAMP, "%d %M %Y %T"),CHARACTER) as fecha,CURRENT_TIMESTAMP as fechatransac');
		$rows=$query->result_array();
		$fechasistema=$rows[0]['fecha'];
		$ftransac=$rows[0]['fechatransac'];
	 	$usuario=$this->session->userdata('usuario');
	 	$empresasis=$this->session->userdata('empresa');
	 	$id_usuario=$this->session->userdata('id_usuario');
	 	$data = array(
					 'id_producto' =>NULL,
					 'id_tipopro' => $tproducto,
					 'id_empresa' => 1,
					 'nombre' => $nombreproducto,
					 'codigo' => $abr,
					 'id_estadopro'=>1,
					 'id_medida'=>1,
					 'id_moneda'=>$moneda,
					 'costo'=>$precio,
					 'bitacora' =>";Ingresado x ".$usuario." via Terra System el '".$fechasistema."'"
					 );
			$this->db->trans_begin();
			$this->db->insert('dbs_producto',$data);
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
		 			$response['message']='Producto Ingresado con Exito';
		 			$response['data']='';
		 			return $response;
			}
			
		}

		Public function InactivarDatos($idlista){
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
			$query=$this->db->query("SELECT count(*) as conteo from dbs_serviciocasa where id_listadopa=".$idlista. " and id_estadoservcasa=1" );
			$casas=$query->result_array();
			if ($casas[0]['conteo']>0){
				$statusinsert=FALSE;
			}else{
				  $query=$this->db->query("UPDATE dbs_listadopa set id_estadolis=2, bitacora=CONCAT(bitacora,';Inactivado x ".$usuario." via Terra System el ".$fechasistema."') where id_listadopa=".$idlista.";");
			      $statusinsert=$this->db->trans_status();
			  }
			if ( $statusinsert === FALSE){

			        $this->db->trans_rollback();
				 	$response['status']=400;
				 	$response['message']='La Lista esta aun asignadas en casas, Accion Rechazada';
				 	$response['data']='';
				 	return $response;
			}else{
			        $this->db->trans_commit();
		 			$response['status']=200;
		 			$response['message']='Lista de Precios Inactivada con Exito';
		 			$response['data']='';
		 			return $response;
			}
			
		}
    public function TiposSectores() {
        $query = "SELECT id_tipodecuota,nombre from dbs_tipodecuota  order by nombre asc";
        return $this->db->dropdown_array($query, 'id_tipodecuota', 'nombre','Seleccione Tipo de Sector',0);
     }


}

