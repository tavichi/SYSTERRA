<?php  
Class AsignaCasas_Model extends CI_Model {

     public function Sectores($tsector) {
        $query = "SELECT id_sector,nombre from dbs_sector where id_tipodecuota=".$tsector." AND id_estados=1 ";
        return $this->db->dropdown_array($query, 'id_sector', 'nombre','Seleccione Sector',0);
     }
    public function TiposSectores() {
        $query = "SELECT id_tipodecuota,nombre from dbs_tipodecuota  order by nombre asc";
        return $this->db->dropdown_array($query, 'id_tipodecuota', 'nombre','Seleccione Tipo de Sector',0);
     }
	 Public function TraeClientes($complemento){
	 	$response = array(
		    'status' => 400,
		    'message' => '',
		    'data' => '',
		);
		 $query=$this->db->query("SELECT ncliente,id_identidad 
									from (
									SELECT CONCAT_WS(' - ',CONCAT_WS(' ',a.nombres,a.apellidos),a.nit ) as ncliente, a.id_identidad 
									from dbs_identidad a 
									join dbs_identidadr b on (b.id_identidad=a.id_identidad and b.id_rol=1)
									where a.id_estadoide=1
									ORDER BY ncliente) a 
									where ncliente like UPPER('%".$complemento."%') LIMIT 5");
		 $clientes=$query->result_array();

		    $response['status']=200;
		    $response['data']=$clientes;
		    $response['message']='';
		    return $response;		 
	 }	 
		 Public function Traedata($filtros){
		 	$response = array(
			    'status' => 400,
			    'message' => '',
			    'data' => '',
			);
			 $query=$this->db->query("SELECT 
											a.id_casa AS codcasa,
											b.nombre AS nsector,
											a.numero AS ncasa,
											a.dir_catastro as dircompleta,
											CONCAT_WS(' ', d.nombres, d.apellidos) AS ncliente,
											d.id_identidad AS codcliente, DATE_FORMAT(c.f_alta,'%d %M %Y') AS fasignacion,
											c.id_estadoas as estadoasig,c.id_asignacasa as codasig
										FROM
											dbs_casa a
										JOIN dbs_sector b ON (b.id_sector = a.id_sector)
										LEFT JOIN dbs_asignacasa c ON (c.id_casa = a.id_casa and c.id_estadoas=1)
										LEFT JOIN dbs_identidad d ON (d.id_identidad = c.id_identidad)
										where 1=1 ".$filtros);
			 $datacasas=$query->result_array();
			 if ($query->num_rows()>0){
			    $response['status']=200;
			    $response['data']=$datacasas;
			    $response['message']='';
			    return $response;
			 }else{
			 	$response['status']=401;
			 	$response['message']='No existe informacion con los filtros solicitados';
			 	$response['data']='';
			 	return $response;	
			}	 
		 }	

	 Public function InsertarDatosCliente($cliente,$casa){
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
					 'id_asignacasa' =>NULL,
					 'id_identidad' => $cliente,
					 'id_rol' => 1,
					 'id_casa' =>$casa,
					 'f_alta' => $rows[0]['fechatransac'],
					 'id_ingresado' => $idusuario,
					 'id_estadoas' => 1,
					 'bitacora' =>"Ingresado x ".$usuario." via Terra System el ".$fechasistema
					 );
			$this->db->trans_begin();
			$this->db->insert('dbs_asignacasa',$data);
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
		 			$response['message']='Cliente Asignado con Exito';
		 			$response['data']='';
		 			return $response;
			}
			
		}
		Public function InactivarDatos($casa,$motivo){
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
			/*$query=$this->db->query("SELECT count(*) as conteo from dbs_asignacasa where id_casa=$casa and id_estadoas =1;" );
			$casas=$query->result_array();
			if ($casas[0]['conteo']>0){*/
			if(1==0){
				$statusinsert=FALSE;
			}else{
				  $this->db->trans_begin();
				  $query=$this->db->query("UPDATE dbs_asignacasa set id_estadoas=2, id_anulado=".$idusuario.", f_baja='".$fechatrans."' ,bitacora=CONCAT(bitacora,';Dado de Baja x ".$usuario." , Motivo:".$motivo.", via Terra System el ".$fechasistema."') where id_asignacasa=".$casa.";");
			      $statusinsert=$this->db->trans_status();
			  }
			  
			if ( $statusinsert === FALSE){

			        $this->db->trans_rollback();
				 	$response['status']=400;
				 	$response['message']='Ocurrio un Error.. La Casa tiene Alguna Asignacion,Accion Rechazada';
				 	$response['data']='';
				 	return $response;
			}else{
			        $this->db->trans_commit();
		 			$response['status']=200;
		 			$response['message']='Cliente Desasignado con Exito';
		 			$response['data']='';
		 			return $response;
			}
			
		}

		 Public function Tarifas($tsector){
		 	$response = array(
			    'status' => 400,
			    'message' => '',
			    'data' => '',
			);
			 $query=$this->db->query("SELECT a.id_listadopa, a.observacion,b.simbolo as moneda, a.precio,CONVERT(DATE_FORMAT(a.f_final, '%d %M %Y'),CHARACTER) as fechavigencia
										FROM dbs_listadopa a
										JOIN dbs_moneda b on (b.id_moneda=a.id_moneda)
										WHERE a.id_estadolis=1 AND date(f_final)>CURRENT_DATE AND a.id_tipodecuota=".$tsector);
			 $tarifas=$query->result_array();
			 if ($query->num_rows()>0){

			    $response['status']=200;
			    $response['data']=$tarifas;
			    $response['message']='';
			    return $response;
			 }else{
			 	$response['status']=401;
			 	$response['message']='No existe informacion con los el tipo de sector seleccionado';
			 	$response['data']='';
			 	return $response;	
			}	 
		 }
		 Public function VerificaParametro($parametro,$casa){
			 $query=$this->db->query("SELECT id_serviciocasa
										FROM dbs_serviciocasa 
										WHERE id_casa=".$casa." AND f_baja IS NULL AND id_estadoservcasa=1  AND id_listadopa=".$parametro);
			 $tarifas=$query->result_array();
			 if ($query->num_rows()>0){
			 	return 1;
			 }else{
			 	return -1;
			}	 
		 }

		Public function InactivaParametro($parametro,$casa){
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

			  $this->db->trans_begin();
			  $query=$this->db->query("UPDATE dbs_serviciocasa set id_estadoservcasa=2, id_anulado=".$idusuario.", f_baja='".$fechatrans."' ,bitacora=CONCAT(bitacora,';Dado de Baja x ".$usuario." via Terra System el ".$fechasistema."') where id_casa=".$casa.";");
		     
		      $statusupdate=$this->db->trans_status();

				  
				if ( $statusupdate === FALSE){

				        $this->db->trans_rollback();
					 	return -1;
				}else{
				        $this->db->trans_commit();
			 			return 1;
				}
			
		}

	 Public function InsertarParametro($parametro,$casa){
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
					 'id_serviciocasa' =>NULL,
					 'id_casa' => $casa,
					 'id_listadopa' => $parametro,
					 'id_estadoservcasa' =>1,
					 'f_alta' => $rows[0]['fechatransac'],
					 'id_ingresado' => $idusuario,
					 'bitacora' =>"Ingresado x :".$usuario." via Terra System el ".$fechasistema
					 );
			$this->db->trans_begin();
			$this->db->insert('dbs_serviciocasa',$data);
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
		 			$response['message']='Parametros Ingresados con Exito';
		 			$response['data']='';
		 			return $response;
			}
			
		}


		 Public function TraedataParam($casa){
		 	$response = array(
			    'status' => 400,
			    'message' => '',
			    'data' => '',
			);
			 $query=$this->db->query("SELECT a.id_serviciocasa as nasignacion,a.id_casa,b.observacion as concepto ,c.simbolo, b.precio 
										FROM dbs_serviciocasa a
										JOIN dbs_listadopa b ON  (b.id_listadopa=a.id_listadopa )
										JOIN dbs_moneda c ON (c.id_moneda=b.id_moneda)
										WHERE a.id_estadoservcasa=1 AND a.id_casa=".$casa);
			 $dataparamcasas=$query->result_array();
			 if ($query->num_rows()>0){
			    $response['status']=200;
			    $response['data']=$dataparamcasas;
			    $response['message']='';
			    return $response;
			 }else{
			 	$response['status']=401;
			 	$response['message']='No existe informacion con los filtros solicitados';
			 	$response['data']='';
			 	return $response;	
			}	 
		 }	
		Public function InactivaParam($parametro){
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

			  $this->db->trans_begin();
			  $query=$this->db->query("UPDATE dbs_serviciocasa set id_estadoservcasa=2, id_anulado=".$idusuario.", f_baja='".$fechatrans."' ,bitacora=CONCAT(bitacora,';Dado de Baja x ".$usuario." via Terra System el ".$fechasistema."') where id_serviciocasa=".$parametro.";");
		     
		      $statusupdate=$this->db->trans_status();

					  
				if ( $statusupdate === FALSE){

				        $this->db->trans_rollback();
					 	$response['status']=400;
					 	$response['message']='Ocurrio un Error.. La Casa tiene Alguna Asignacion,Accion Rechazada';
					 	$response['data']='';
					 	return $response;
				}else{
				        $this->db->trans_commit();
			 			$response['status']=200;
			 			$response['message']='Parametro Desasignado con Exito';
			 			$response['data']='';
			 			return $response;
				}
			
		}

		Public function InactivaParamBloque($idcasa){
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

			  $this->db->trans_begin();
			  $query=$this->db->query("UPDATE dbs_serviciocasa set id_estadoservcasa=2, id_anulado=".$idusuario.", f_baja='".$fechatrans."' ,bitacora=CONCAT(bitacora,';Dado de Baja x ".$usuario." via Terra System el ".$fechasistema."') where id_casa=".$idcasa.";");
		     
		      $statusupdate=$this->db->trans_status();

					  
				if ( $statusupdate === FALSE){

				        $this->db->trans_rollback();
					 	return -1;
				}else{
				        $this->db->trans_commit();
			 			return 1;
				}
			
		}

	 Public function CambiaFecha($fecha, $motivo,$asignacion){
		$response = array(
		    'status' => 400,
		    'message' => '',
		    'data' => '',
		);
		$query=$this->db->query('SELECT CONVERT(DATE_FORMAT(CURRENT_TIMESTAMP, "%d %M %Y %T"),CHARACTER) as fecha,CURRENT_TIMESTAMP as fechatransac');
		$rows=$query->result_array();
		$fechasistema=$rows[0]['fecha'];
		$queryf=$this->db->query('SELECT CONVERT(DATE_FORMAT(f_alta, "%d %M %Y"),CHARACTER) as f_alta from dbs_asignacasa where id_asignacasa='.$asignacion);
		$dat=$queryf->result_array();
		//print_r($dat);
	 	$usuario=$this->session->userdata('usuario');
	 	$idusuario=$this->session->userdata('id_usuario');
	 	$empresasis=$this->session->userdata('empresa');

			$this->db->trans_begin();
			$querys=$this->db->query("UPDATE dbs_asignacasa set  f_alta='".$fecha."' ,bitacora=CONCAT(coalesce(bitacora,''),';Fecha Actualizada x :".$usuario." , Motivo:".$motivo.",fecha anterior :".$dat[0]['f_alta']." via Terra System el ".$fechasistema."') WHERE id_asignacasa=".$asignacion.";");

			$statusupdate=$this->db->trans_status();

				if ( $statusupdate === FALSE){

				        $this->db->trans_rollback();
					 	$response['status']=400;
						$response['message'] = 'Ocurrio un Error al Cambiar la Fecha Asignada, Verifique' ;
						$response['data'] = '';
						return $response;
				}else{
				        $this->db->trans_commit();
					 	$response['status']=200;
						$response['message'] = 'Fecha de Asignacion configurada con Exito' ;
						$response['data'] = '';
						return $response;
				}
	
	} 

}

