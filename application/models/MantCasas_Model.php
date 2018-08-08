<?php  
Class MantCasas_Model extends CI_Model {

     public function Sectores() {
        $query = "SELECT SUBSTR(nombre FROM 8 FOR 10) as orden , id_sector,nombre
				  from dbs_sector
				  where id_estados=1;";
        return $this->db->dropdown_array($query, 'id_sector', 'nombre','Seleccione Sector',0);
     }
     public function Tdireccion() {
        $query = "SELECT  id_tipodireccion,nombre
				  from dbs_tipodireccion";
        return $this->db->dropdown_array($query, 'id_tipodireccion', 'nombre','Seleccione T Direccion',0);
     }
	 Public function TraeSectores($sector){
	 	$response = array(
		    'status' => 400,
		    'message' => '',
		    'data' => '',
		);
		 $this->db->select('a.id_casa AS codcasa,a.codigo_seg,a.numero as nocasa,b.nombre as nombsector,a.dir_catastro as dir_completa,c.id_estadocasa,
							c.nombre AS estadocasa,CONVERT(DATE_FORMAT(a.f_alta, "%d %M %Y "),CHARACTER) as falta');
		 $this->db->from('dbs_casa a');
		 $this->db->join('dbs_sector b','b.id_sector = a.id_sector','inner');
		 $this->db->join('dbs_estadocasa c','c.id_estadocasa = a.id_estadocasa','inner');
		 $this->db->where('a.id_sector',$sector);
		 $this->db->order_by('b.nombre','ASC');
		 $this->db->order_by('lpad(a.numero ,20,0)');
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
	 Public function InsertarDatos($nocasa,$calleavenida,$tdireccion,$literal,$nocasa1,$nocasa2,$sector,$codigosec){
		$response = array(
		    'status' => 400,
		    'message' => '',
		    'data' => '',
		);
		$query=$this->db->query('SELECT CONVERT(DATE_FORMAT(CURRENT_TIMESTAMP, "%d %M %Y %T"),CHARACTER) as fecha,CURRENT_TIMESTAMP as fechatransac');
		$rows=$query->result_array();
		$fechasistema=$rows[0]['fecha'];
	 	$usuario=$this->session->userdata('usuario');
	 	$idusuario=$this->session->userdata('id_usuario');
	 	$empresasis=$this->session->userdata('empresa');
	 	$data = array(
					 'id_casa' =>NULL,
					 'id_sector' => $sector,
					 'numero' => $nocasa,
					 'codigo_seg' =>$codigosec,
					 'numcalleave' => $calleavenida,
					 'id_tipodireccion' => $tdireccion,
					 'literal' => $literal,
					 'numcasa1' => '$nocasa1',
					 'numcasa2' => '$nocasa2',
					 'id_estadocasa' => 1,
					 'f_alta' => $rows[0]['fechatransac'],
					 'id_ingresado' => $idusuario,
					 'bitacora' =>"Ingresado x ".$usuario." via Terra System el ".$fechasistema
					 );
			$this->db->trans_begin();
			$this->db->insert('dbs_casa',$data);
			$query=$this->db->query("SELECT Max(id_casa) as max from dbs_casa" );
			$casa=$query->result_array();
			$data = array(
					 'correlativo' =>NULL,
					 'id_casa' => $casa[0]['max'],
					 'codigo' =>$codigosec,
					 'id_estadocod' => 1,
					 'asignadox' => $idusuario,
					 'f_alta' => $rows[0]['fechatransac'],
					 'bitacora' =>"Ingresado x ".$usuario." via Terra System el ".$fechasistema
					 );
			$this->db->insert('dbs_guardacodigo',$data);
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
		 			$response['message']='Casa Ingresada con Exito';
		 			$response['data']='';
		 			return $response;
			}
			
		}
		Public function InactivarDatos($casa){
		$response = array(
		    'status' => 400,
		    'message' => '',
		    'data' => '',
		);
		$query=$this->db->query('SELECT CONVERT(DATE_FORMAT(CURRENT_TIMESTAMP, "%d %M %Y %T"),CHARACTER) as fecha,CURRENT_TIMESTAMP as fechatransac');
		$rows=$query->result_array();
		$fechasistema=$rows[0]['fecha'];
		$fechatrans=$rows[0]['fechatransac'];
	 	$usuario=$this->session->userdata('usuario');
	 	$idusuario=$this->session->userdata('id_usuario');
			$query=$this->db->query("SELECT count(*) as conteo from dbs_asignacasa where id_casa=$casa and id_estadoas =1;" );
			$casas=$query->result_array();
			if ($casas[0]['conteo']>0){
				$statusinsert=FALSE;
			}else{
				  $this->db->trans_begin();
				  $query=$this->db->query("UPDATE dbs_casa set id_estadocasa=3, id_anulado=".$idusuario.", f_baja='".$fechatrans."' ,bitacora=CONCAT(bitacora,';Dado de Baja x ".$usuario." via Terra System el ".$fechasistema."') where id_casa=".$casa.";");
			      $statusinsert=$this->db->trans_status();
			  }
			  
			if ( $statusinsert === FALSE){

			        $this->db->trans_rollback();
				 	$response['status']=400;
				 	$response['message']='Accion Rechazada La Casa tiene Alguna Asignacion';
				 	$response['data']='';
				 	return $response;
			}else{
			        $this->db->trans_commit();
		 			$response['status']=200;
		 			$response['message']='Casa Inactivada con Exito';
		 			$response['data']='';
		 			return $response;
			}
			
		}
		Public function GeneraCodigo(){
				$response = array(
				    'status' => 400,
				    'message' => '',
				    'data' => '',
				);
				$codigo=str_pad(rand(0,10000), 4, "0", STR_PAD_LEFT);
				$query=$this->db->query('SELECT CONVERT(DATE_FORMAT(CURRENT_TIMESTAMP, "%d %M %Y %T"),CHARACTER) as fecha,CURRENT_TIMESTAMP as fechatransac');
				$rows=$query->result_array();
				$fechasistema=$rows[0]['fecha'];
				$fechatrans=$rows[0]['fechatransac'];
			 	$usuario=$this->session->userdata('usuario');
			 	$idusuario=$this->session->userdata('id_usuario');
					$query=$this->db->query("SELECT count(*) as conteo from dbs_guardacodigo where codigo=".$codigo." and id_estadocod =1;" );
					$codigoas=$query->result_array();
					if ($codigoas[0]['conteo']>0){
						
						 	$response['status']=401;
						 	$response['message']='Codigo Ya Utilizado presione OK para Intentar Genera un Nuevo Codigo, codigo dado:'.$codigo;
						 	$response['data']='';
						 	return $response;
					}else{
					        $this->db->trans_commit();
				 			$response['status']=200;
				 			$response['message']='';
				 			$response['data']=$codigo;
				 			return $response;
					}
					
		 }
			Public function ActualizaCod($casa,$codigo, $motivo){
					$response = array(
					    'status' => 400,
					    'message' => '',
					    'data' => '',
					);
					$query=$this->db->query('SELECT CONVERT(DATE_FORMAT(CURRENT_TIMESTAMP, "%d %M %Y %T"),CHARACTER) as fecha,CURRENT_TIMESTAMP as fechatransac');
					$rows=$query->result_array();
					$fechasistema=$rows[0]['fecha'];
					$fechatrans=$rows[0]['fechatransac'];
				 	$usuario=$this->session->userdata('usuario');
				 	$idusuario=$this->session->userdata('id_usuario');
				 	$empresasis=$this->session->userdata('empresa');
						$this->db->trans_begin();

							$query=$this->db->query("UPDATE dbs_casa set codigo_seg=".$codigo.",bitacora=CONCAT(bitacora,';Actualizado x :".$usuario." , Motivo:".$motivo.", via Terra System el ".$fechasistema."')  WHERE id_casa=".$casa.";");

							$query=$this->db->query("UPDATE dbs_guardacodigo set id_estadocod=2, f_baja='".$fechatrans."',bitacora=CONCAT(bitacora,';Inactivado x :".$usuario." , Motivo:".$motivo.", via Terra System el ".$fechasistema."')  WHERE id_casa=".$casa." And id_estadocod=1;");

							$data = array(
							 'correlativo' =>NULL,
							 'id_casa' => $casa,
							 'codigo' =>$codigo,
							 'id_estadocod' => 1,
							 'asignadox' => $idusuario,
							 'f_alta' => $rows[0]['fechatransac'],
							 'bitacora' =>"Ingresado por Actualizacion x ".$usuario." via Terra System el ".$fechasistema
							 );
							$this->db->insert('dbs_guardacodigo',$data);

						$statusupdate=$this->db->trans_status();

							  
							if ( $statusupdate === FALSE){

							        $this->db->trans_rollback();
								 	$response['status']=401;
						 			$response['message']='No fue posible generar un codigo , codigo dado:'.$codigo;
						 			$response['data']='';
						 			return $response;
							}else{
							        $this->db->trans_commit();
						 			$response['status']=200;
						 			$response['message']='Codigo Actualizado con Exito , codigo Asignado: '.$codigo;
						 			$response['data']='';
						 			return $response;
							}
					
	
				} 
			Public function Actualizadir($idscasa,$calleavenida,$tdireccion, $nocasa1,$nocasa2,$literal,$motivo){
					$response = array(
					    'status' => 400,
					    'message' => '',
					    'data' => '',
					);
					$query=$this->db->query('SELECT CONVERT(DATE_FORMAT(CURRENT_TIMESTAMP, "%d %M %Y %T"),CHARACTER) as fecha,CURRENT_TIMESTAMP as fechatransac');
					$rows=$query->result_array();
					$fechasistema=$rows[0]['fecha'];
					$fechatrans=$rows[0]['fechatransac'];
				 	$usuario=$this->session->userdata('usuario');
				 	$idusuario=$this->session->userdata('id_usuario');
				 	$empresasis=$this->session->userdata('empresa');
						$this->db->trans_begin();

							$query=$this->db->query("UPDATE dbs_casa set numcalleave='".$calleavenida."',id_tipodireccion=".$tdireccion.",literal='".$literal."',numcasa1='".$nocasa1."',numcasa2='".$nocasa2."',bitacora=CONCAT(bitacora,';Actualizado [Dir. Catastro] x :".$usuario." , Motivo:".$motivo.", via Terra System el ".$fechasistema."')  WHERE id_casa=".$idscasa.";");



						$statusupdate=$this->db->trans_status();

							  
							if ( $statusupdate === FALSE){

							        $this->db->trans_rollback();
								 	$response['status']=401;
						 			$response['message']='No fue posible realizar el cambio de direccion Catastral';
						 			$response['data']='';
						 			return $response;
							}else{
							        $this->db->trans_commit();
						 			$response['status']=200;
						 			$response['message']='Direccion Actualizada con Exito';
						 			$response['data']='';
						 			return $response;
							}
					
	
				}

				Public function reinicio(){
						$response = array(
						    'status' => 400,
						    'message' => '',
						    'data' => '',
						);
						$query=$this->db->query('SELECT CONVERT(DATE_FORMAT(CURRENT_TIMESTAMP, "%d %M %Y %T"),CHARACTER) as fecha,CURRENT_TIMESTAMP as fechatransac');
						$rows=$query->result_array();
						$fechasistema=$rows[0]['fecha'];
						$fechatrans=$rows[0]['fechatransac'];
					 	$usuario=$this->session->userdata('usuario');
					 	$idusuario=$this->session->userdata('id_usuario');
					 	$query=$this->db->query("SELECT count(*) as conteo from dbs_guardacodigo where id_estadocod=1" );
						$codigoactivos=$query->result_array();
							$query=$this->db->query("INSERT into dbs_guardacodigo_histo
														SELECT NULL,id_casa,codigo,id_estadocod,asignadox,f_alta,f_baja,bitacora,'".$fechasistema."' 
														from dbs_guardacodigo;");
							$query=$this->db->query("DELETE from dbs_guardacodigo WHERE 1=1;" );
							$query=$this->db->query("SELECT count(*) as conteo from dbs_guardacodigo" );
							$codigoas=$query->result_array();
							if ($codigoas[0]['conteo']>0){
								
								 	$response['status']=401;
								 	$response['message']='Ocurrio un Problema al reiniciar los codigos existen aun :'.$codigoas[0]['conteo'].' codigos ' ;
								 	$response['data']='';
								 	return $response;
							}else{
							        $this->db->trans_commit();
						 			$response['status']=200;
						 			$response['message']='Reinicio de Codigos de Seguridad Realizado con Exito, Codigos Liberados:'.$codigoactivos[0]['conteo'] ;
						 			$response['data']='' ;
						 			return $response;
							}
							
				 }




}

