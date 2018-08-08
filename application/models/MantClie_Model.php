<?php  
Class MantClie_Model extends CI_Model {

//Combos
    public function listado_tipovehic() {
        $query = "select id_tipov,nombre from dbs_tipov order by nombre";
        return $this->db->dropdown_array($query, 'id_tipov', 'nombre','Seleccione Tipo',0);
    }

    public function listado_tipotel() {
        $query = "select id_tipotel,nombre from dbs_tipotel order by nombre";
        return $this->db->dropdown_array($query, 'id_tipotel', 'nombre','Seleccione Tipo',0);
    }


	Public function Clientes(){
	 	$response = array(
		    'status' => 400,
		    'message' => '',
		    'data' => '',
		);
		$empresasis=$this->session->userdata('empresa');
		 $this->db->select('codigo,apellidos,nombres,nit,dpi,correo,f_alta');
		 $this->db->from('dbv_clientesa');
		 $this->db->where('id_empresa='.$empresasis);
		 $this->db->order_by('apellidos,nombres','ASC');
		 $result=$this->db->get();
		 $clientes=$result->result_array();

		 if ($result->num_rows()>0){

		    $response['status']=200;
		    $response['data']=$clientes;
		    $response['message']='';
		    return $response;
		 }else{
		 	$response['status']=401;
		 	$response['message']='Datos no encontrados para mostrar';
		 	$response['data']='';
		 	return $response;
		 }
	}

	Public function traedat_cliente($id_identidad){
	 	$response = array(
		    'status' => 400,
		    'message' => '',
		    'data' => '',
		);
		//$empresasis=$this->session->userdata('empresa');
		 $this->db->select('codigo,apellidos,nombres,nit,dpi,correo,f_alta');
		 $this->db->from('dbv_clientesa');
		 $this->db->where('codigo='.$id_identidad);
		 //$this->db->order_by('apellidos,nombres','ASC');
		 $result=$this->db->get();
		 $clientes=$result->result_array();

		 if ($result->num_rows()>0){
		    $response['status']=200;
		    $response['data']=$clientes;
		    $response['message']='';
		    return $response;
		 }else{
		 	$response['status']=401;
		 	$response['message']='Datos no encontrados para mostrar';
		 	$response['data']='';
		 	return $response;
		 }
	}

	Public function InsertarDatos($nombre,$apellido,$nit,$dpi,$correo){
		$response = array(
		    'status' => 400,
		    'message' => '',
		    'data' => '',
		);
        //Parametros iniciales
	 	$usuario=$this->session->userdata('usuario');
	 	$empresasis=$this->session->userdata('empresa');
	 	$idusuario=$this->session->userdata('id_usuario');

        //Validacion de existencia
		$query1=$this->db->query("select codigo, nombres,apellidos,nit,dpi
									from dbv_clientesa
									where ( upper(trim(nit))= upper(trim('".$nit."')) and upper(trim(nit))<>upper(trim('c/f')) )
									or    ( upper(trim(dpi))= upper(trim('".$dpi."')) and upper(trim(dpi))<>upper(trim('')) )
									or ( upper(trim(nombres))= upper(trim('".$nombre."')) and 
									     upper(trim(apellidos))= upper(trim('".$apellido."')))
			                        and id_empresa=".$empresasis." order by apellidos,nombres;");
		$rows1=$query1->result_array();
		//$codigoex=$rows1[0]['codigo'];

		if ($query1->num_rows()>0){
		 	$response['status']=400;
		 	$response['message']='Los Nombres y Apellidos, Nit o Dpi ya existen!!! revise el Cliente: '.$rows1[0]['codigo'].' !!!';
		 	$response['data']='';
		 	return $response;			
		}else{
			$query=$this->db->query('SELECT CONVERT(DATE_FORMAT(CURRENT_TIMESTAMP, "%d %M %Y %T"),CHARACTER) as fecha,
			                                now() as fechatransac, max(id_identidad)+1 as newid 
			                         from dbs_identidad 
			                         Where id_empresa='.$empresasis);
			$rows=$query->result_array();
			$fechasistema=$rows[0]['fecha'];
			$newid=$rows[0]['newid'];
		 	$fechatrans=$rows[0]['fechatransac'];
		 	$data = array(
						 'id_identidad' =>$newid,
						 'id_empresa' => $empresasis,
						 'nombres' => $nombre,
						 'apellidos' => $apellido,
						 'nit' => $nit,
						 'dpi' => $dpi,
						 'correo' => $correo,
						 'f_alta' => $fechatrans,
						 'f_baja' => NULL,
						 'id_ingresado' => $idusuario,
						 'id_anulado' =>NULL,
						 'id_estadoide' => 1,
						 'bitacora' =>"Ingresado x ".$usuario." via Terra System el ".$fechasistema.""
						 );
		 	$datar = array(
						 'id_identidad' =>$newid,
						 'id_rol' => 1,
						 'f_alta' => $fechatrans,
						 'bitacora' =>"Ingresado x ".$usuario." via Terra System el ".$fechasistema.""
						 );
			$this->db->trans_begin();
			$this->db->insert('dbs_identidad',$data);
			$this->db->insert('dbs_identidadr',$datar);
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
		 			$response['message']='Cliente Ingresado con Exito';
		 			$response['data']='';
		 			return $response;
			}

		}
			
	}

	Public function modificadatos($nombre,$apellido,$nit,$dpi,$correo,$id_identidad){
		$response = array(
		    'status' => 400,
		    'message' => '',
		    'data' => '',
		);
        //Parametros iniciales
	 	$usuario=$this->session->userdata('usuario');
	 	$empresasis=$this->session->userdata('empresa');
	 	$idusuario=$this->session->userdata('id_usuario');

        //Validacion de existencia validando el codigo en la modificacion
		$query1=$this->db->query("select codigo, nombres,apellidos,nit,dpi
									from dbv_clientesa
									where ( ( upper(trim(nit))= upper(trim('".$nit."')) and upper(trim(nit))<>upper(trim('c/f')) )
									or    ( upper(trim(dpi))= upper(trim('".$dpi."')) and upper(trim(dpi))<>upper(trim('')) )
									or ( upper(trim(nombres))= upper(trim('".$nombre."')) and 
									     upper(trim(apellidos))= upper(trim('".$apellido."'))) )
			                        and id_empresa=".$empresasis." and codigo<> ".$id_identidad.";");
		$rows1=$query1->result_array();
		if ($query1->num_rows()>0){
		 	$response['status']=400;
		 	$response['message']='Los Nombres y Apellidos, Nit o Dpi ya existen!!! revise el Cliente: '.$rows1[0]['codigo'].' !!!';
		 	$response['data']='';
		 	return $response;			
		}else{
			$query=$this->db->query('SELECT CONVERT(DATE_FORMAT(CURRENT_TIMESTAMP, "%d %M %Y %T"),CHARACTER) as fecha
			                         from dbs_identidad 
			                         Where id_identidad='.$id_identidad);
			$rows=$query->result_array();
			$fechasistema=$rows[0]['fecha'];
			$this->db->trans_begin();
			$query=$this->db->query("UPDATE dbs_identidad set nombres='".$nombre."', apellidos='".$apellido."',
			  	                        nit='".$nit."', dpi='".$dpi."', correo='".$correo."',
			  	                      bitacora=CONCAT(bitacora,';Modificado x ".$usuario." via Terra System el ".$fechasistema."') where id_identidad=".$id_identidad.";");
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
		 			$response['message']='Los Datos del Cliente se actualizaron con Exito';
		 			$response['data']='';
		 			return $response;
			}

		}
			
	}

	Public function eliminadatos($id_identidad){
		$response = array(
		    'status' => 400,
		    'message' => '',
		    'data' => '',
		);
        //Parametros iniciales
	 	$usuario=$this->session->userdata('usuario');
	 	$empresasis=$this->session->userdata('empresa');
	 	$idusuario=$this->session->userdata('id_usuario');

        //Validacion de existencia de una casa a un cliente
		$query1=$this->db->query("select sector, numero, sectorcasa
									from dbv_asignacasacliente
									where id_identidad=".$id_identidad.";");
		$rows1=$query1->result_array();
		if ($query1->num_rows()>0){
		 	$response['status']=400;
		 	$response['message']='El Cliente tiene Casas Asignadas!!! revise la casa: '.$rows1[0]['sectorcasa'].' !!!';
		 	$response['data']='';
		 	return $response;			
		}else{
			$query=$this->db->query('SELECT CONVERT(DATE_FORMAT(CURRENT_TIMESTAMP, "%d %M %Y %T"),CHARACTER) as fecha
			                         from dbs_identidad 
			                         Where id_identidad='.$id_identidad);
			$rows=$query->result_array();
			$fechasistema=$rows[0]['fecha'];
			$this->db->trans_begin();
			$query=$this->db->query("UPDATE dbs_identidad set f_baja=NOW(), id_anulado=".$idusuario.",
			  	                        id_estadoide=2,
			  	                      bitacora=CONCAT(bitacora,';Inactivado x ".$usuario." via Terra System el ".$fechasistema."') where id_identidad=".$id_identidad.";");
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
		 			$response['message']='Se Inactivo toda la informacion del Cliente solicitado, con Exito';
		 			$response['data']='';
		 			return $response;
			}

		}
			
	}

	Public function listado_telefonos($id_identidad){
	 	$response = array(
		    'status' => 400,
		    'message' => '',
		    'data' => '',
		);
		 $this->db->select('t.id_telefono,t.id_identidad,t.numero,tt.nombre');
		 $this->db->from('dbs_telefono t');
		 $this->db->join('dbs_tipotel tt','tt.id_tipotel=t.id_tipotel','left');	
		 $this->db->where('t.f_baja is NULL and t.id_identidad='.$id_identidad);
		 $this->db->order_by('t.numero','ASC');
		 $result=$this->db->get();
		 $telefonos=$result->result_array();

		 if ($result->num_rows()>0){

		    $response['status']=200;
		    $response['data']=$telefonos;
		    $response['message']='';
		    return $response;
		 }else{
		 	$response['status']=401;
		 	$response['message']='Aun no existen telefonos asignados';
		 	$response['data']='';
		 	return $response;
		 }
	}

	Public function inserta_telefono($id_identidad,$ntelefono,$tipotel){
		$response = array(
		    'status' => 400,
		    'message' => '',
		    'data' => '',
		);
        //Parametros iniciales
	 	$usuario=$this->session->userdata('usuario');
	 	$empresasis=$this->session->userdata('empresa');
	 	$idusuario=$this->session->userdata('id_usuario');

        //Validacion de existencia el numero si esta habilitado
		$query1=$this->db->query("select * from dbs_telefono 
			                      where id_identidad=".$id_identidad." and f_baja is NULL and numero=".$ntelefono." ");
		$rows1=$query1->result_array();
		if ($query1->num_rows()>0){
		 	$response['status']=400;
		 	$response['message']='El telefono que intenta agregarle al cliente ya existe!!!';
		 	$response['data']='';
		 	return $response;			
		}else{
			$query=$this->db->query('SELECT CONVERT(DATE_FORMAT(CURRENT_TIMESTAMP, "%d %M %Y %T"),CHARACTER) as fecha,
			                                now() as fechatransac, max(id_telefono)+1 as newid 
			                         from dbs_telefono');
			$rows=$query->result_array();
			$fechasistema=$rows[0]['fecha'];
			$newid=$rows[0]['newid'];
		 	$fechatrans=$rows[0]['fechatransac'];
		 	$data = array(
						 'id_telefono' =>$newid,
						 'id_identidad' =>$id_identidad,
						 'numero' => $ntelefono,
						 'f_alta' => $fechatrans,
						 'f_baja' => NULL,
						 'id_tipotel' => $tipotel,
						 'bitacora' =>"Ingresado x ".$usuario." via Terra System el ".$fechasistema.""
						 );
			$this->db->trans_begin();
			$this->db->insert('dbs_telefono',$data);
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
		 			$response['message']='Telefono Ingresado con Exito';
		 			$response['data']='';
		 			return $response;
			}
		}			
	}

	Public function eliminar_tel($id_telefono){
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
			  $query=$this->db->query("UPDATE dbs_telefono set f_baja=NOW(), bitacora=CONCAT(bitacora,';Inactivado x ".$usuario." via Terra System el ".$fechasistema."') where id_telefono=".$id_telefono.";");
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
	 			$response['message']='Telefono Inactivado con Exito';
	 			$response['data']='';
	 			return $response;
		}		
	}


	Public function listado_tarjetas($id_identidad){
	 	$response = array(
		    'status' => 400,
		    'message' => '',
		    'data' => '',
		);
		 $this->db->select('id_tarjeta,id_identidad,numero,f_alta,estado');
		 $this->db->from('dbv_tarjetasxcliente');
		 //muestra las tarjetas pendientes de cancelar y activas
		 $this->db->where('id_identidad='.$id_identidad); 
		 $this->db->order_by('numero','ASC');
		 $result=$this->db->get();
		 $tarjetas=$result->result_array();

		 if ($result->num_rows()>0){

		    $response['status']=200;
		    $response['data']=$tarjetas;
		    $response['message']='';
		    return $response;
		 }else{
		 	$response['status']=401;
		 	$response['message']='Aun no existen tarjetas asignadas';
		 	$response['data']='';
		 	return $response;
		 }
	}

	Public function inserta_tarjeta($id_identidad,$ntarjeta){
		$response = array(
		    'status' => 400,
		    'message' => '',
		    'data' => '',
		);
        //Parametros iniciales
	 	$usuario=$this->session->userdata('usuario');
	 	$empresasis=$this->session->userdata('empresa');
	 	$idusuario=$this->session->userdata('id_usuario');

        //Validacion de existencia el numero si esta habilitado
		$query1=$this->db->query("select id_identidad, id_tarjeta from dbs_tarjeta
			                      where id_estadot in (1,5) and upper(trim(numero))='".$ntarjeta."' ");
		$rows1=$query1->result_array();
		if ($query1->num_rows()>0){
		 	$response['status']=400;
		 	$response['message']='La tarjeta que intenta asignar ya se encuentra asignada al cliente '.$rows1[0]['id_identidad'].' !!!';
		 	$response['data']='';
		 	return $response;			
		}else{
			$query=$this->db->query('SELECT CONVERT(DATE_FORMAT(CURRENT_TIMESTAMP, "%d %M %Y %T"),CHARACTER) as fecha,
			                                now() as fechatransac, max(id_tarjeta)+1 as newid 
			                         from dbs_tarjeta');
			$rows=$query->result_array();
			$fechasistema=$rows[0]['fecha'];
			$newid=$rows[0]['newid'];
		 	$fechatrans=$rows[0]['fechatransac'];
		 	$pendientec=5;
		 	$data = array(
						 'id_tarjeta' =>$newid,
						 'id_identidad' =>$id_identidad,
						 'numero' => $ntarjeta,
						 'f_alta' => $fechatrans,
						 'f_baja' => NULL,
						 'f_vence' => NULL,
						 'id_ingresado' => $idusuario,
						 'id_anulado' =>NULL,
						 'id_estadot' => $pendientec,						 
						 'bitacora' =>"Ingresado x ".$usuario." via Terra System el ".$fechasistema.""
						 );
			$this->db->trans_begin();
			$this->db->insert('dbs_tarjeta',$data);
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
		 			$response['message']='Tarjeta Ingresada con Exito';
		 			$response['data']='';
		 			return $response;
			}
		}			
	}

	Public function eliminar_tar($id_tarjeta){
		$response = array(
		    'status' => 400,
		    'message' => '',
		    'data' => '',
		);
		$query=$this->db->query('SELECT CONVERT(DATE_FORMAT(CURRENT_TIMESTAMP, "%d %M %Y %T"),CHARACTER) as fecha');
		$rows=$query->result_array();
		$fechasistema=$rows[0]['fecha'];
	 	$usuario=$this->session->userdata('usuario');
        $idusuario=$this->session->userdata('id_usuario');
		$this->db->trans_begin();
			  $query=$this->db->query("UPDATE dbs_tarjeta set f_baja=NOW(),id_estadot=4,id_anulado=".$idusuario.", bitacora=CONCAT(bitacora,';Inactivada x ".$usuario." via Terra System el ".$fechasistema."') where id_tarjeta=".$id_tarjeta.";");
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
	 			$response['message']='Tarjeta Inactivada con Exito';
	 			$response['data']='';
	 			return $response;
		}		
	}

	Public function listado_vehiculos($id_identidad){
	 	$response = array(
		    'status' => 400,
		    'message' => '',
		    'data' => '',
		);
		 $this->db->select('id_vehiculo,id_identidad,tipove,placa,f_alta');
		 $this->db->from('dbv_vehiculosa');
		 $this->db->where('id_estadov=1 and id_identidad='.$id_identidad);
		 $this->db->order_by('placa','ASC');
		 $result=$this->db->get();
		 $vehiculos=$result->result_array();

		 if ($result->num_rows()>0){

		    $response['status']=200;
		    $response['data']=$vehiculos;
		    $response['message']='';
		    return $response;
		 }else{
		 	$response['status']=401;
		 	$response['message']='Aun no existen vehiculos asignados';
		 	$response['data']='';
		 	return $response;
		 }
	}

	Public function inserta_vehiculo($id_identidad,$nplaca,$tipove){
		$response = array(
		    'status' => 400,
		    'message' => '',
		    'data' => '',
		);
        //Parametros iniciales
	 	$usuario=$this->session->userdata('usuario');
	 	$empresasis=$this->session->userdata('empresa');
	 	$idusuario=$this->session->userdata('id_usuario');

        //Validacion de existencia el numero de placa en todos los clientes si esta habilitado
		$query1=$this->db->query("select id_identidad, id_vehiculo from dbs_vehiculo
			                      where id_estadov=1 and upper(trim(placa))='".$nplaca."' ");
		$rows1=$query1->result_array();
		if ($query1->num_rows()>0){
		 	$response['status']=400;
		 	$response['message']='La placa que intenta asignar ya se encuentra asignada al cliente '.$rows1[0]['id_identidad'].' !!!';
		 	$response['data']='';
		 	return $response;			
		}else{
			$query=$this->db->query('SELECT CONVERT(DATE_FORMAT(CURRENT_TIMESTAMP, "%d %M %Y %T"),CHARACTER) as fecha,
			                                now() as fechatransac, max(id_vehiculo)+1 as newid 
			                         from dbs_vehiculo');
			$rows=$query->result_array();
			$fechasistema=$rows[0]['fecha'];
			$newid=$rows[0]['newid'];
		 	$fechatrans=$rows[0]['fechatransac'];
		 	$data = array(
						 'id_vehiculo' =>$newid,
						 'id_identidad' =>$id_identidad,
						 'id_tipov' =>$tipove,
						 'placa' => $nplaca,
						 'f_alta' => $fechatrans,
						 'f_baja' => NULL,
						 'id_ingresado' => $idusuario,
						 'id_anulado' =>NULL,
						 'id_estadov' => 1,						 
						 'bitacora' =>"Ingresado x ".$usuario." via Terra System el ".$fechasistema.""
						 );
			$this->db->trans_begin();
			$this->db->insert('dbs_vehiculo',$data);
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
		 			$response['message']='Placa Ingresada con Exito';
		 			$response['data']='';
		 			return $response;
			}
		}			
	}

	Public function eliminar_veh($id_vehiculo){
		$response = array(
		    'status' => 400,
		    'message' => '',
		    'data' => '',
		);
		$query=$this->db->query('SELECT CONVERT(DATE_FORMAT(CURRENT_TIMESTAMP, "%d %M %Y %T"),CHARACTER) as fecha');
		$rows=$query->result_array();
		$fechasistema=$rows[0]['fecha'];
	 	$usuario=$this->session->userdata('usuario');
        $idusuario=$this->session->userdata('id_usuario');
		$this->db->trans_begin();
			  $query=$this->db->query("UPDATE dbs_vehiculo set f_baja=NOW(),id_estadov=2,id_anulado=".$idusuario.", bitacora=CONCAT(bitacora,';Inactivada x ".$usuario." via Terra System el ".$fechasistema."') where id_vehiculo=".$id_vehiculo.";");
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
	 			$response['message']='Placa de Vehiculo Inactivada con Exito';
	 			$response['data']='';
	 			return $response;
		}		
	}


} //CI_Model

