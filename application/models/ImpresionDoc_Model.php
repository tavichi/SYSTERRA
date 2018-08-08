<?php  
Class ImpresionDoc_Model extends CI_Model {

     public function Sectores($tsector) {
        $query = "SELECT id_sector,nombre from dbs_sector where id_tipodecuota=".$tsector." AND id_estados=1 order by nombre asc";
        return $this->db->dropdown_array($query, 'id_sector', 'nombre','Seleccione Sector',0);
     }

     public function TiposPago() {
        $query = "SELECT id_tipopago,nombre from dbs_tipopago ORDER BY nombre";
        return $this->db->dropdown_array($query, 'id_tipopago', 'nombre','Seleccione T. Pago',0);
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


		 	 $sql="SELECT k.nombre as ntipodoc,j.serie,j.id_serie,k.id_tipodoc,a.recibo,
			 								CONCAT_WS(' ',f.nombres,f.			apellidos) as cliente,
			 								DATE_FORMAT(a.f_emitido,'%d %M %Y')as femision,
			 								DATE_FORMAT(a.f_vencido,'%d %M %Y')as fvence,
			 								a.id_empresa,h.simbolo,sum(base+iva) as monto
											from dbs_recibo a
											JOIN dbs_detallerecibo b on (b.id_empresa=a.id_empresa AND b.id_tipodoc=a.id_tipodoc and b.id_serie=a.id_serie AND b.recibo=a.recibo)
											JOIN dbs_producto c on (c.id_producto=b.id_producto)
											JOIN dbs_casa d on (d.id_casa=a.id_casa)
											JOIN dbs_sector e on (e.id_sector=d.id_sector)
											JOIN dbs_identidad f on (f.id_identidad=a.id_cliente)
											JOIN dbs_estadodoc g on (g.id_estadodoc=a.id_estadodoc)
											JOIN dbs_moneda h on (h.id_moneda=a.id_moneda)
											JOIN dbs_usuario i on (i.id_usuario=a.id_ingresado)
											JOIN dbs_serie j on (j.id_serie=a.id_serie and j.id_empresa=a.id_empresa)
											JOIN dbs_tipodoc k on (k.id_tipodoc=a.id_tipodoc)
											where a.id_estadodoc=2 ".$filtros . "
											GROUP BY j.id_serie,k.id_tipodoc,a.id_empresa,a.recibo";
			 //print_r($sql);
			 $query=$this->db->query($sql);
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

		 Public function DetalleRecibo($recibo,$serie,$tipodoc,$empresa){
		 	$response = array(
			    'status' => 400,
			    'message' => '',
			    'data' => '',
			);
			 $query=$this->db->query("SELECT a.linea, (case when a.id_producto=1 then concat(b.nombre,'  ',m.nombrec,'-',a.anno) else b.nombre end) as nombre,
			 								c.simbolo as moneda,(a.base+a.iva)as totallinea,a.cantidad
									  FROM dbs_detallerecibo a
									  JOIN dbs_recibo d on (d.recibo=a.recibo and d.id_serie=a.id_serie and d.id_tipodoc=a.id_tipodoc and d.id_empresa=a.id_empresa)
									  JOIN dbs_producto b on (b.id_producto=a.id_producto)
									  JOIN dbs_moneda c on(c.id_moneda=d.id_moneda)
									  LEFT join dbs_mes m on m.id_mes=a.id_mes	
									  WHERE a.recibo=".$recibo." and a.id_serie=".$serie." and a.id_tipodoc=".$tipodoc." and a.id_empresa=".$empresa . ' and a.id_estadodet=1');
			 $detalle=$query->result_array();
			 if ($query->num_rows()>0){
			    $response['status']=200;
			    $response['data']=$detalle;
			    $response['message']='';
			    return $response;
			 }else{
			 	$response['status']=401;
			 	$response['message']='No fue posible encontrar la Informacion Solicitada';
			 	$response['data']='';
			 	return $response;	
			}	 
		 }	

	 Public function InsertaPago($recibo,$serie,$tipodoc,$empresa,$montop,$tpago,$fpago,$obser){
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

	 	$query=$this->db->query('SELECT a.monto ,SUM(COALESCE(b.monto,0)) as totalpago, CASE WHEN a.monto >= SUM(COALESCE(b.monto,0)) THEN 1 ELSE 0 END as puedepagar,
	 							 CASE WHEN a.monto >= SUM(COALESCE(b.monto,0))+ ' .$montop. ' THEN 1 ELSE 0 END as puedepagarm
								 FROM dbs_recibo a
								 LEFT JOIN dbs_pagorecibo b on (b.id_empresa=a.id_empresa and b.id_tipodoc=a.id_tipodoc and b.id_serie=a.id_serie and b.recibo=a.recibo  and b.id_estadopago=1)
								 WHERE a.recibo='.$recibo.' and a.id_empresa='.$empresa.' and a.id_tipodoc='.$tipodoc.' and a.id_serie='.$serie);
		$pagos=$query->result_array();
		if($pagos[0]['puedepagar']==1 && $pagos[0]['puedepagarm']==1){
			$data = array(
								 'id_pagorecibo' =>NULL,
								 'id_empresa' => $empresa,
								 'id_tipodoc' => $tipodoc,
								 'id_serie' =>$serie,
								 'recibo' => $recibo,
								 'id_tipopago'=>$tpago,
								 'id_moneda'=>1,
								 'monto'=>$montop,
								 'f_pago'=>$fpago,
								 'f_registro'=>$rows[0]['fechatransac'],
								 'id_estadopago'=>1,
								 'observacion' => $obser,
								 'bitacora' =>"Ingresado x :".$usuario." via Caja Terra System el ".$fechasistema
								 );
						$this->db->trans_begin();
						$this->db->insert('dbs_pagorecibo',$data);
						$statusinsert=$this->db->trans_status();
						if ( $statusinsert === FALSE){

						        $this->db->trans_rollback();
							 	$response['status']=400;
							 	$response['message']='Ocurrio un Error al realizar esta Accion';
							 	$response['data']='';
							 	return $response;
						}else{
						        $this->db->trans_commit();
								$query=$this->db->query('SELECT a.monto ,SUM(COALESCE(b.monto,0)) as totalpago, CASE WHEN a.monto = SUM(COALESCE(b.monto,0)) THEN 0 ELSE 1 END as puedepagar
													     FROM dbs_recibo a
								 	                     LEFT JOIN dbs_pagorecibo b on (b.id_empresa=a.id_empresa and b.id_tipodoc=a.id_tipodoc and b.id_serie=a.id_serie and b.recibo=a.recibo and b.id_estadopago=1)
								 					     WHERE a.recibo='.$recibo.' and a.id_empresa='.$empresa.' and a.id_tipodoc='.$tipodoc.' and a.id_serie='.$serie);

								$dpagos=$query->result_array();

								if ($dpagos[0]['puedepagar']==0){

											 $this->db->trans_begin();
											 $query=$this->db->query("UPDATE dbs_recibo set id_estadodoc=2, id_cancelado=".$idusuario.", f_cancelado='".$rows[0]['fechatransac']."' ,bitacora=CONCAT(bitacora,';Actualizado a Cancelado x :".$usuario." via Terra System el ".$fechasistema."')  WHERE recibo=".$recibo." and id_empresa=".$empresa." and id_tipodoc=".$tipodoc." and id_serie=".$serie.";");
											 $statusupdate=$this->db->trans_status();
											  
										if ( $statusupdate === FALSE){
										        $this->db->trans_rollback();
											 	$response['status']=400;
											 	$response['message']='Ocurrio un Error.. no fue posible realizar la Accion';
											 	$response['data']='';
											 	return $response;
										}else{
										        $this->db->trans_commit();
									 			$response['status']=200;
									 			$response['message']='Pago Realizado con Exito 1';
									 			$response['data']='';
									 			return $response;
										}
								}else{
									$response['status']=200;
						 			$response['message']='Pago Realizado con Exito';
						 			$response['data']='';
						 			return $response;	
					 			}	
					    }			 			
		
		}else{
			$response['status']=401;
			$response['message']='Con la Cantidad Ingresada Sobrepasa el monto Pendiente del Recibo';
			$response['data']='';
			return $response;
		}
	 	
			
	}

	 Public function traesaldo($recibo,$serie,$tipodoc,$empresa){
		$response = array(
		    'status' => 400,
		    'message' => '',
		    'data' => '',
		);

	 	$query=$this->db->query('SELECT a.monto-SUM(COALESCE(b.monto,0)) as totalpago
								 FROM dbs_recibo a
								 LEFT JOIN dbs_pagorecibo b on (b.id_empresa=a.id_empresa and b.id_tipodoc=a.id_tipodoc and b.id_serie=a.id_serie and b.recibo=a.recibo and b.id_estadopago=1)
								 WHERE a.recibo='.$recibo.' and a.id_empresa='.$empresa.' and a.id_tipodoc='.$tipodoc.' and a.id_serie='.$serie);
		$pagos=$query->result_array();
		if ($query->num_rows()>0){
			    $response['status']=200;
			    $response['data']=$pagos;
			    $response['message']='';
			    return $response;
		}else{
			 	$response['status']=401;
			 	$response['message']='No fue posible encontrar la Informacion Solicitada';
			 	$response['data']='';
			 	return $response;	
			}	
	} 

	 Public function DatosEncabezado($recibo,$serie,$tipodoc,$empresa){
		$response = array(
		    'status' => 400,
		    'message' => '',
		    'data' => '',
		);

	 	$query=$this->db->query('SELECT a.recibo,b.serie,CONCAT_WS(" ",c.nombres,c.apellidos) as nombrecliente, 
	 							CONCAT(e.nombre," Lote # " ,d.numero) as dircorta,CONVERT(DATE_FORMAT(a.f_emitido, "%d-%M-%Y"),CHARACTER) as femitido,
	 							CONVERT(DATE_FORMAT(a.f_cancelado, "%d-%M-%Y %T"),CHARACTER)as fcancelado, f.nombre as canceladox,d.dir_catastro
								FROM dbs_recibo a 
								Join dbs_serie b ON (b.id_serie=a.id_serie and b.id_empresa=a.id_empresa and b.id_tipodoc=a.id_tipodoc)
								Join dbs_identidad c ON (c.id_identidad=a.id_cliente)
								Join dbs_casa d ON (d.id_casa=a.id_casa)
								Join dbs_sector e ON (e.id_sector=d.id_sector)
								Join dbs_usuario f ON (f.id_usuario=a.id_cancelado)
								WHERE a.recibo='.$recibo.' and a.id_empresa='.$empresa.' and a.id_tipodoc='.$tipodoc.' and a.id_serie='.$serie);
		$encabezado=$query->result_array();
		if ($query->num_rows()>0){
			    $response['status']=200;
			    $response['data']=$encabezado;
			    $response['message']='';
			    return $response;
		}else{
			 	$response['status']=401;
			 	$response['message']='No fue posible encontrar la Informacion Solicitada';
			 	$response['data']='';
			 	return $response;	
			}	
	} 
	 Public function AnularRecibo($recibo,$serie,$tipodoc,$empresa, $motivo){
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

	 	$query=$this->db->query('SELECT count(*) as conteo
								 FROM dbs_pagorecibo
								 WHERE recibo='.$recibo.' and id_empresa='.$empresa.' and id_tipodoc='.$tipodoc.' and id_serie='.$serie . ' and id_estadopago=1');
		$contpagos=$query->result_array();
		if ($contpagos[0]['conteo']>0){
			$this->db->trans_begin();
			$query=$this->db->query("UPDATE dbs_pagorecibo set id_estadopago=2,bitacora=CONCAT(bitacora,';Anulado x :".$usuario." , Motivo:".$motivo.", via Terra System el ".$fechasistema."')  WHERE recibo=".$recibo." and id_empresa=".$empresa." and id_tipodoc=".$tipodoc." and id_serie=".$serie.";");

			$querys=$this->db->query("UPDATE dbs_recibo set id_estadodoc=3, id_anulado=".$idusuario.", f_anulado='".$rows[0]['fechatransac']."' ,bitacora=CONCAT(coalesce(bitacora,''),';Actualizado a Cancelado x :".$usuario." , Motivo:".$motivo.", via Terra System el ".$fechasistema."')  WHERE recibo=".$recibo." and id_empresa=".$empresa." and id_tipodoc=".$tipodoc." and id_serie=".$serie.";");

			$statusupdate=$this->db->trans_status();

				  
				if ( $statusupdate === FALSE){

				        $this->db->trans_rollback();
					 	return -1;
				}else{
				        $this->db->trans_commit();
			 			return 1;
				}
		}else{
				$querys=$this->db->query("UPDATE dbs_recibo set id_estadodoc=3, id_anulado=".$idusuario.", f_anulado='".$rows[0]['fechatransac']."' ,bitacora=CONCAT(bitacora,';Actualizado a Cancelado x :".$usuario." , Motivo:".$motivo." ,via Terra System el ".$fechasistema."')  WHERE recibo=".$recibo." and id_empresa=".$empresa." and id_tipodoc=".$tipodoc." and id_serie=".$serie.";");

							$statusupdate=$this->db->trans_status();

								  
								if ( $statusupdate === FALSE){

								        $this->db->trans_rollback();
									 	return -1;
								}else{
								        $this->db->trans_commit();
							 			return 1;
								}
			}	
	} 
}

