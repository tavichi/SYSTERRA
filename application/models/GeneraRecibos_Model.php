<?php  
Class GeneraRecibos_Model extends CI_Model {

     public function Sectores() {
        $query = "SELECT lpad(trim(nombre),'20','0') as orden,id_sector,nombre from dbs_sector where id_estados=1 
                  UNION 
                  SELECT '',-1,'Todos'
                 ";
        return $this->db->dropdown_array($query, 'id_sector', 'nombre','Seleccione Sector',0);
     }

     public function TiposPago() {
        $query = "SELECT id_tipopago,nombre from dbs_tipopago ORDER BY nombre";
        return $this->db->dropdown_array($query, 'id_tipopago', 'nombre','Seleccione T. Pago',0);
     }

	 Public function TraeSectores($sector){
	 	$response = array(
		    'status' => 400,
		    'message' => '',
		    'data' => '',
		);
		 $this->db->select('id_casa AS codcasa,sector as nombsector,sectorcasa as nocasa,codigo_seg,dir_catastro as dir_completa,
					         CONVERT(DATE_FORMAT(f_alta, "%d %M %Y "),CHARACTER) as falta,id_identidad, 
					         nombrecliente, sectorcasa, simbolo,cuotab,primerper,siguienteper,mes,anno,
					         valorxtadic,valorxtplastica,numtarjetasp,totalcuota,numtarjetasadic ');
		 $this->db->from('dbv_periodoxcasa');
		 if ($sector!=-1) {
		 	$this->db->where('id_sector',$sector);
		 	 $this->db->order_by('sector,lpad(numero,10,"0")','');	 
		 } else{
		 	 $this->db->order_by('sector,lpad(numero,10,"0")','');	 
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
	 Public function insertarecibos($id_casa,$recibo,$id_cliente,$monto,$montoseg,
	 	                            $montotar,$id_mes,$anno,$tpago,$fechap,$obser,
	 	                            $numtarjetasp,$valorxtplastica,$numtarjetasadic){
		$response = array(
		    'status' => 400,
		    'message' => '',
		    'data' => '',
		);
		//PARAMETROS INICIALES
		$usuario=$this->session->userdata('usuario');
	 	$idusuario=$this->session->userdata('id_usuario');
	 	$empresasis=$this->session->userdata('empresa');
	 	$id_tipodoc=1;//tipo de documento recibo
	 	$id_moneda=1;// moneda solamente quetzales
	 	$id_estadodoc=2; //estado del documento: 1-pendiente de cobro -- se cambio a 2-cancelado 03/May/18 sol. x Cliente
	 	$cantidad=1; //solamente es un periodo
	 	$id_medida=1; //unidad sera la unidad de medida default
	 	$descuento=0; //no existe descuento en este tipo de cobro
	 	$id_estadodet=1; //estado 1 del detalle del documento - valido

		$query=$this->db->query("SELECT id_serie, CONVERT(DATE_FORMAT(CURRENT_TIMESTAMP, '%d %M %Y %T'),CHARACTER) as fecha,CURRENT_TIMESTAMP as fechatransac
			from dbs_serie
			where id_empresa=".$empresasis." and id_estadoser=1 and id_tipodoc=".$id_tipodoc);
		$rows=$query->result_array();
		$fechasistema=$rows[0]['fecha'];
		$fechatransac=$rows[0]['fechatransac'];
		$id_serie=$rows[0]['id_serie'];

		if ($recibo==0) {
			$query=$this->db->query("select coalesce(max(recibo),0) +1 as newrecibo  
				from dbs_recibo
				where id_empresa=".$empresasis." and id_serie=".$id_serie." and id_tipodoc=".$id_tipodoc);
			$rows=$query->result_array();
			$newrecibo=$rows[0]['newrecibo'];
		}else{ $newrecibo=$recibo;}
		/*CARGAMOS EL MAESTRO DEL RECIBO*/
	 	$data = array(
					 'id_empresa' =>$empresasis,
					 'id_tipodoc' => $id_tipodoc,
					 'id_serie' => $id_serie,
					 'recibo' =>$newrecibo,
					 'f_emitido' => $fechatransac,
					 'f_vencido' => $fechatransac,
					 'f_anulado' => NULL,
					 'f_cancelado' => $fechatransac,
					 'id_cliente' => $id_cliente,
					 'id_casa' => $id_casa,
					 'id_moneda' => $id_moneda,
					 'monto' => $monto,
					 'id_estadodoc' => $id_estadodoc,
					 'observacion' => '',
					 'id_ingresado' => $idusuario,
					 'id_anulado' => NULL,
					 'id_cancelado' => $idusuario,
					 'bitacora' =>"Ingresado x ".$usuario." via Terra System el ".$fechasistema
					 );
	 	/*CARGAMOS EL DETALLE DE LA SEGURIDAD*/
	 	$linea=1; //primer linea detalle de seguridad
	 	$base=round($montoseg/1.12,2);
	 	$iva=$montoseg-$base;
	 	$id_producto=1;
	 	$datadet = array(
					 'id_empresa' =>$empresasis,
					 'id_tipodoc' => $id_tipodoc,
					 'id_serie' => $id_serie,
					 'recibo' =>$newrecibo,
					 'linea' =>$linea,
					 'id_producto' => $id_producto,
					 'id_medida' => $id_medida,
					 'cantidad' => $cantidad,
					 'base' => $base,
					 'iva' => $iva,
					 'descuento' => $descuento,
					 'id_mes' => $id_mes,
					 'anno' => $anno,
					 'id_estadodet' => $id_estadodet,
					 'observacion' => '',
					 'bitacora' =>"Ingresado x ".$usuario." via Terra System el ".$fechasistema
					 );
	 	if($montotar>0){
	 		$linea=2; //segunda linea detalle de tarjetas adicionales inicialmente Q10 por cada una si tiene el servicio asignado
		 	$base=round($montotar/1.12,2);
		 	$iva=$montotar-$base;	
		 	$id_producto=2; //tarjeta adicional		
		 	$datadetar = array(
						 'id_empresa' =>$empresasis,
						 'id_tipodoc' => $id_tipodoc,
						 'id_serie' => $id_serie,
						 'recibo' =>$newrecibo,
						 'linea' =>$linea,
						 'id_producto' => $id_producto,
						 'id_medida' => $id_medida,
						 'cantidad' => $numtarjetasadic-1,
						 'base' => $base,
						 'iva' => $iva,
						 'descuento' => $descuento,
						 'id_mes' => $id_mes,
						 'anno' => $anno,
						 'id_estadodet' => $id_estadodet,
						 'observacion' => '',
						 'bitacora' =>"Ingresado x ".$usuario." via Terra System el ".$fechasistema
						 );
	 	}  
	 	if($valorxtplastica>0){
	 		$linea=3; //tercera linea detalle de cobro de tarjetas (PLASTICO) inicialmente Q50 por cada una si tiene el servicio asignado
		 	$base=round($valorxtplastica/1.12,2);
		 	$iva=$valorxtplastica-$base;	
		 	$id_producto=3; 	//tarjeta plastica	
		 	$datadeplastica = array(
						 'id_empresa' =>$empresasis,
						 'id_tipodoc' => $id_tipodoc,
						 'id_serie' => $id_serie,
						 'recibo' =>$newrecibo,
						 'linea' =>$linea,
						 'id_producto' => $id_producto,
						 'id_medida' => $id_medida,
						 'cantidad' => $numtarjetasp,
						 'base' => $base,
						 'iva' => $iva,
						 'descuento' => $descuento,
						 'id_mes' => $id_mes,
						 'anno' => $anno,
						 'id_estadodet' => $id_estadodet,
						 'observacion' => '',
						 'bitacora' =>"Ingresado x ".$usuario." via Terra System el ".$fechasistema
						 );
	 	}  

		/*CARGAMOS EL DETALLE DEL PAGO DEL RECIBO*/
		 	$datadetpa = array(
						 'id_pagorecibo' =>NULL,
						 'id_empresa' =>$empresasis,
						 'id_tipodoc' => $id_tipodoc,
						 'id_serie' => $id_serie,
						 'recibo' =>$newrecibo,
						 'id_tipopago' => $tpago,
						 'id_moneda' => $id_moneda,
						 'monto' => $monto,
						 'f_pago' => $fechap,
						 'f_registro' => $fechatransac,
						 'id_estadopago' => 1,
						 'observacion' => $obser,
						 'bitacora' =>"Ingresado x ".$usuario." via Terra System el ".$fechasistema
						 );

			$this->db->trans_begin();
			$this->db->insert('dbs_recibo',$data);
			$this->db->insert('dbs_detallerecibo',$datadet);
			$this->db->insert('dbs_pagorecibo',$datadetpa);
			if($montotar>0){  //valida si hay un cobro de tarjeta adicional
				$this->db->insert('dbs_detallerecibo',$datadetar);	
			}
			if($valorxtplastica>0){ //valida si hay un cobro de tarjeta plastica
				$this->db->insert('dbs_detallerecibo',$datadeplastica);	
				$query=$this->db->query("UPDATE dbs_tarjeta set id_estadot=1,				  	                      
				  	                      bitacora=CONCAT(bitacora,';Activada x ".$usuario." via Terra System el ".$fechasistema."') where id_tarjeta in ( 
				  	                      	select distinct t.id_tarjeta
				  	                      	from dbv_tarjetaspend t
				  	                      	where t.id_casa=".$id_casa.");");

			}
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
		 			$response['message']='Recibos generados con exito !!!';
		 			$response['data']=$newrecibo.'@'.$id_serie.'@'.$empresasis;
		 			return $response;
			}
			
		}


	 Public function DatosEncabezado($recibo,$serie,$tipodoc,$empresa,$recibof){
		$response = array(
		    'status' => 400,
		    'message' => '',
		    'data' => '',
		);

	 	$query=$this->db->query('SELECT a.recibo,b.serie,
	 							concat(c.id_identidad," - ",CONCAT_WS(" ",c.nombres,c.apellidos)) as nombrecliente,
	 							CONCAT(e.nombre," Casa " ,d.numero) as dircorta,CONVERT(DATE_FORMAT(a.f_emitido, "%d-%M-%Y"),CHARACTER) as femitido,
	 							CONVERT(DATE_FORMAT(a.f_cancelado, "%d-%M-%Y %H:%m"),CHARACTER) as fcancelado, f.nombre as canceladox,
	 							a.id_serie,a.id_tipodoc,a.id_empresa,d.dir_catastro,em.logo
								FROM dbs_recibo a 
								Join dbs_serie b ON (b.id_serie=a.id_serie and b.id_empresa=a.id_empresa and b.id_tipodoc=a.id_tipodoc)
								Join dbs_identidad c ON (c.id_identidad=a.id_cliente)
								Join dbs_casa d ON (d.id_casa=a.id_casa)
								Join dbs_sector e ON (e.id_sector=d.id_sector)
								Join dbs_usuario f ON (f.id_usuario=a.id_cancelado)
								left join dbs_empresa em on em.id_empresa=a.id_empresa
								WHERE a.recibo between '.$recibo.' and '.$recibof.' and a.id_empresa='.$empresa.' and a.id_tipodoc='.$tipodoc.' and a.id_serie='.$serie);
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

	 Public function DetalleRecibo($recibo,$serie,$tipodoc,$empresa){
	 	$response = array(
		    'status' => 400,
		    'message' => '',
		    'data' => '',
		);
		 $query=$this->db->query('SELECT a.linea,
		 						  (case when a.id_producto=1 then concat(b.nombre,"   ",m.nombrec," ",a.anno) else b.nombre end) as nombre,
		 	                      c.simbolo as moneda,(a.base+a.iva)as totallinea,a.cantidad
								  FROM dbs_detallerecibo a
								  JOIN dbs_recibo d on (d.recibo=a.recibo and d.id_serie=a.id_serie and d.id_tipodoc=a.id_tipodoc and d.id_empresa=a.id_empresa)
								  JOIN dbs_producto b on (b.id_producto=a.id_producto)
								  JOIN dbs_moneda c on(c.id_moneda=d.id_moneda)			
								  left join dbs_mes m on m.id_mes=a.id_mes					  
								  WHERE a.recibo = '.$recibo.' and a.id_serie='.$serie.' and a.id_tipodoc='.$tipodoc.' and a.id_empresa='.$empresa);
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



}

