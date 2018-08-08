	<?php
		defined('BASEPATH') OR exit('No direct script access allowed');
	  ?>

	<section class="container">

		<div class="container">
		  <div class="row">
		    <div class="col-sm-3 col-md-9 col-lg-9">
		    	<h2>Mantenimiento de Clientes&nbsp;<small><a class="fa fa-info-circle" data-toggle="tooltip" title="Manual de Usuario" id="ManualUsuario" href="<?php echo base_url(); ?>assets/Manuales/Manual de Usuario 0007 - Generacion de Recibos de Cobro.pdf" target="_blank"></a></small></h2>
		    </div>
		   <br>
		  <div class="row">
		    <div class="col-sm-3 col-md-9 col-lg-12">
			  <button type="button" class="btn btn-success  btn-md" id="cargardata">
			    <span class="fa fa-refresh"></span> Cargar
			  </button>
			  <button type="button" class="btn btn-info btn-md" id="guardadata">
			    <span class="fa fa-save"></span> Guardar
			  </button>
			  <button type="button" class="btn btn-danger btn-md" id="modificadata" style="display:none">
			    <span class="fab fa-medium"></span> Modificar Datos
			  </button>
			  <button type="button" class="btn btn-primary btn-md" id="eliminadata" style="display:none">
			    <span class="fa fa-delete"></span> Dar de Baja
			  </button>
		    </div>
		    <br><br><br><br><br>
		    <div class="col-sm-3 col-md-9 col-lg-12">
				<form class="form-horizontal" role="form">
				  <div class="form-group">
				    <label class="col-lg-2 control-label">Nombres:</label>
				    <div class="col-lg-4">
				      <input class="form-control" id="NombreC" type="text" placeholder="Ingrese los Nombres del Cliente">
				    </div>
				    <label class="col-lg-1 control-label">Apellidos:</label>
				    <div class="col-lg-4">
				      <input class="form-control" id="ApellidoC" type="text" placeholder="Ingrese los Apellidos del Cliente">
				    </div>
				  </div>

				  <div class="form-group">
				    <label class="col-lg-2 control-label">NIT:</label>
				    <div class="col-lg-2">
				      <input class="form-control" id="NitC" type="text" placeholder="Ingrese NIT del Cliente o C/F">
				    </div>
				    <label class="col-lg-3 control-label">DPI:</label>
				    <div class="col-lg-2">
				      <input class="form-control" id="DpiC" type="text" placeholder="Ingrese DPI del Cliente - Opcional">
				    </div>
				  </div>

				  <div class="form-group">
				    <label class="col-lg-2 control-label">Correos:</label>
				    <div class="col-lg-6">
				      <input class="form-control" id="CorreoC" type="text" placeholder="Ingrese Correos del Cliente separados por Punto y Coma (;) - Opcional">
				    </div>
				    <label class="col-lg-1 control-label">Codigo:</label>
				    <div class="col-lg-2">
				      <input class="form-control" id="CodigoC" type="text" placeholder="Codigo del Cliente" disabled="">
				    </div>
				  </div>

				</form>
 		    </div>

 		     <br><br><br><br><br><br><br><br><br>
		    <div class="col-sm-3 col-md-9 col-lg-12">
				<form class="form-horizontal" >
				  <div class="form-group">	
					    <label for="disabledTextInput" class="col-lg-9 control-label">Buscar:</label>
					    <div class="col-lg-3">
					      <input class="form-control" id="filter" type="text" placeholder="Ingrese Valor a Buscar en Tabla">
					    </div>
				  </div>
				</form>
 		    </div>
		  </div>
		  <br><br>
		  <div class="row">
		    <div class="col-*-*">
				<div class="table-responsive">
			    	<table class="table table-hover" id="tablarep">
					 	<thead>
					 		<th>ID</th>
					 		<th>Apellidos </th>
					 		<th>Nombres</th>
					 		<th>NIT</th>
					 		<th>DPI</th>
					 		<th>Correos</th>
					 		<th>F. de Alta</th>
					 		<th>Tel.</th>
					 		<th>Tar.</th>
					 		<th>Veh.</th>
					 	</thead>
					 	<tbody id='reporte'>
					 		
					 	</tbody>
					</table>
			    </div>
			</div>
		  </div>
		</div>
  
		  <div class="modal fade" id="dialog_telefono" role="dialog">
		    <div class="modal-dialog">
		      <div class="modal-content">
		        <div class="modal-header btn-info">
		          <button type="button" class="close" data-dismiss="modal">&times;</button>
		          <h4 class="modal-title" style="font-family:'Shadows Into Light'; font-color:black;" >Terra System - Telefonos</h4>
		        </div>
		        <div class="modal-body">
		           <div class="container">
		           		<div class="row">
		           			<div class="col-lg-8">
		           				<form class="form-horizontal">
		           					<div class="form-group">

									    <label class="col-lg-2 control-label">Tipo:</label>
									    <div class="col-lg-4">
									      <select class="form-control" id='CmbTipoTel'>
									      </select>
									    </div>
									    <br><br>
				           				<label for="disabledTextInput" class="col-lg-2 control-label"> Telefono <span class="glyphicon glyphicon-user"></span> :</label>
									    <div class="col-lg-5">
									    	<input class="form-control" id="txttelefono" type="text" placeholder="Ingrese Telefono del cliente">
									    </div>
										<br><br>
											<div class="col-lg-8">
											<div class="table-responsive">
										    	<table class="table table-hover" id="tabla_tels">
												 	<thead>
												 		<th>ID</th>
												 		<th>Numero Telefonico</th>
												 		<th>Tipo</th>
												 		<th>Baja</th>
												 	</thead>
												 	<tbody id='reportetel'>
												 		
												 	</tbody>
												</table>
										    </div>

										</div>
									</div>
							    </form>
		           			</div>
		           		</div>
		           </div>
		        </div>
		        <div class="modal-footer">
		          <button type="button" class="btn btn-primary"  id="asigna_telefono">Asignar</button>
		          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
		        </div>
		      </div>
		      
		    </div>
		  </div>

		  <div class="modal fade" id="dialog_tarjeta" role="dialog">
		    <div class="modal-dialog">
		      <div class="modal-content">
		        <div class="modal-header btn-info">
		          <button type="button" class="close" data-dismiss="modal">&times;</button>
		          <h4 class="modal-title" style="font-family:'Shadows Into Light'; font-color:black;" >Terra System - Tarjetas Electrónicas</h4>
		        </div>
		        <div class="modal-body">
		           <div class="container">
		           		<div class="row">
		           			<div class="col-lg-9">
		           				<form class="form-horizontal">
		           					<div class="form-group">
				           				<label for="disabledTextInput" class="col-lg-2 control-label"> Tarjeta <span class="glyphicon glyphicon-user"></span> :</label>
									    <div class="col-lg-5">
									    	<input class="form-control" id="txttarjeta" type="text" placeholder="Ingrese # de Tarjeta Electrónica">
									    </div>
										<br><br>
											<div class="col-lg-8">
											<div class="table-responsive">
										    	<table class="table table-hover" id="tabla_tarjetas">
												 	<thead>
												 		<th>ID</th>
												 		<th>No. Tarjeta Electrónica</th>
												 		<th>F.Alta</th>
												 		<th>Estado</th>
												 		<th>Baja</th>												 		
												 	</thead>
												 	<tbody id='reportetar'>
												 		
												 	</tbody>
												</table>
										    </div>

										</div>
									</div>
							    </form>
		           			</div>
		           		</div>
		           </div>
		        </div>
		        <div class="modal-footer">
		          <button type="button" class="btn btn-primary"  id="asigna_tarjeta">Asignar</button>
		          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
		        </div>
		      </div>		      
		    </div>
		  </div> 

		  <div class="modal fade" id="dialog_vehiculo" role="dialog">
		    <div class="modal-dialog">
		      <div class="modal-content">
		        <div class="modal-header btn-info">
		          <button type="button" class="close" data-dismiss="modal">&times;</button>
		          <h4 class="modal-title" style="font-family:'Shadows Into Light'; font-color:black;" >Terra System - Placas Vehiculares</h4>
		        </div>
		        <div class="modal-body">
		           <div class="container">
		           		<div class="row">
		           			<div class="col-lg-9">
		           				<form class="form-horizontal">		           					
		           					<div class="form-group">
									    <label class="col-lg-2 control-label">Tipo V.:</label>
									    <div class="col-lg-4">
									      <select class="form-control" id='CmbTipoV'>
									      </select>
									    </div>
									    <br><br>
				           				<label for="disabledTextInput" class="col-lg-2 control-label"> Placa <span class="glyphicon glyphicon-user"></span> :</label>
									    <div class="col-lg-5">
									    	<input class="form-control" id="txtplaca" type="text" placeholder="Ingrese # de Placa del Vehiculo">
									    </div>
										<br><br>
											<div class="col-lg-8">
											<div class="table-responsive">
										    	<table class="table table-hover" id="tabla_vehiculos">
												 	<thead>
												 		<th>ID</th>
												 		<th>Tipo Vehiculo</th>
												 		<th>No. Placa</th>
												 		<th>F.Alta</th>
														<th>Baja</th>
												 	</thead>
												 	<tbody id='reporteveh'>
												 		
												 	</tbody>
												</table>
										    </div>

										</div>
									</div>
							    </form>
		           			</div>
		           		</div>
		           </div>
		        </div>
		        <div class="modal-footer">
		          <button type="button" class="btn btn-primary"  id="asigna_vehiculo">Asignar</button>
		          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
		        </div>
		      </div>		      
		    </div>
		  </div> 

    </section>

<script type="text/javascript">
  $(document).ready(function(){
    $("#NombreC").focus();
    var id_identidadg=0;
    var id_eliminar=0; //dato a eliminar o cambiar de estado en la DB

        $("#cargardata").click(function(){
				//Limpia campos principales
	          	$("#CodigoC").val('');
	          	$("#NombreC").val('');
	          	$("#ApellidoC").val('');
	          	$("#NitC").val('');
	          	$("#DpiC").val('');
	          	$("#CorreoC").val('');
	          	$("#modificadata").hide();
	          	$("#eliminadata").hide();
	          	$("#guardadata").show();
              $.ajax({
                url: '<?php echo base_url('MantClieAjax/cargardatos');?>',
                type:'POST',
                data: {},
                success: function(response){
                  var results = jQuery.parseJSON(response);
                    if (results.status == 401 ){
                    /*$("#mensajelogin").empty().append(results.message);
                    $("#mensajelogin").show();
                    desaparecerdiv('mensajelogin');*/
                  }else{
                    $("#reporte").empty().append(results.data);
                      modificarcliente();
                      creartelefonos();
                      crear_telefono();
                      creartarjetas();
                      crear_tarjeta();
                      crearvehiculos();
                      crear_vehiculo();
                    }
                } 
            }); 
        });

        $("#guardadata").click(function(){       	
        	if( ($("#NombreC").val()=='') || ($("#ApellidoC").val()=='') 
        		|| ($("#NitC").val()=='') )
        	 {	
        	  swal('Terra System','Debe Completar Los Datos para Guardar','warning');
        	  return false;
        	 }else{
					$.ajax({
			                url: '<?php echo base_url('MantClieAjax/insertadatos');?>',
			                type:'POST',
			                data: {nombrec:$("#NombreC").val(),apellidoc:$("#ApellidoC").val(),
			                       nitc:$("#NitC").val(),dpic:$("#DpiC").val(),
			                       correoc:$("#CorreoC").val()},
			                success: function(response){
			                  var results = jQuery.parseJSON(response);
			                    if (results.status == 200){
			                    swal("Terra System",results.message,"success");
			                    $("#cargardata").click();
			                  }else{
			                  	swal("Terra System",results.message,"warning");
			                    }
			                } 
			            }); 
        	 }

        });

        $("#modificadata").click(function(){       	
        	if( ($("#NombreC").val()=='') || ($("#ApellidoC").val()=='') 
        		|| ($("#NitC").val()=='') )
        	 {	
        	  swal('Terra System','Debe Completar Los Datos para Guardar','warning');
        	  return false;
        	 }else{
					$.ajax({
			                url: '<?php echo base_url('MantClieAjax/modificadatos');?>',
			                type:'POST',
			                data: {nombrec:$("#NombreC").val(),apellidoc:$("#ApellidoC").val(),
			                       nitc:$("#NitC").val(),dpic:$("#DpiC").val(),
			                       correoc:$("#CorreoC").val(),id_identidad:$("#CodigoC").val()},
			                success: function(response){
			                  var results = jQuery.parseJSON(response);
			                    if (results.status == 200){
			                    swal("Terra System",results.message,"success");
			                    $("#cargardata").click();
			                  }else{
			                  	swal("Terra System",results.message,"warning");
			                    }
			                } 
			            }); 
        	 }

        });

		$('#eliminadata').click(function(){
			//id_eliminar=this.id;
			swal("Esta seguro de ELIMINAR al cliente con el CODIGO: ?", {
			  icon: "warning",	
			   buttons: true,
			  dangerMode: true,
			})
			.then((value) => {
			  switch (value) {
			    case true:
					$.ajax({
				            url: '<?php echo base_url('MantClieAjax/eliminadatos');?>',
				            type:'POST',
				            data: {id_identidad:$("#CodigoC").val()},
				            success: function(response){
				              var results = jQuery.parseJSON(response);
				                //alert(results.status);
				                if (results.status == 200){
								swal('Terra System',results.message,'success');
			                    $("#cargardata").click();		                    
				              }else{
								swal('Terra System',results.message,'warning');
				                }
				            } 
				        }); 

			      break;
			  }
			});
		});

        // presionando Enter
        $("#NombreC").on("keydown", function (e) {
            if (e.keyCode === 13) {  
                $("#ApellidoC").focus();
            }
        });

        $("#ApellidoC").on("keydown", function (e) {
            if (e.keyCode === 13) {  
                $("#NitC").focus();
            }
        });
        $("#NitC").on("keydown", function (e) {
            if (e.keyCode === 13) {  
                $("#DpiC").focus();
            }
        });
        $("#DpiC").on("keydown", function (e) {
            if (e.keyCode === 13) {  
                $("#CorreoC").focus();
            }
        });
              
        $("#CorreoC").on("keydown", function (e) {
            if (e.keyCode === 13) {  
                $("#guardadata").focus();
            }
        });
        //FUNCION que permite buscar en una tabla cualquier valor ingresado en el texto #filter
		$(function() {
		  var theTable = $('#tablarep')
		  theTable.find("tbody > tr").find("td:eq(1)").mousedown(function(){
		    $(this).prev().find(":checkbox").click()
		  });
		  $("#filter").keyup(function() {
		    $.uiTableFilter( theTable, this.value );
		  })
		  $('#filter-form').submit(function(){
		    theTable.find("tbody > tr:visible > td:eq(1)").mousedown();
		    return false;
		  }).focus(); //Give focus to input field
		});  
    



  });

  	function modificarcliente(){
		$('.modificacli').click(function(){
			id_identidadg=this.id;
		      $.ajax({
		        url: '<?php echo base_url('MantClieAjax/traedat_cliente');?>',
		        type:'POST',
		        data: {id_identidad:id_identidadg},
		        success: function(response){
		          var results = jQuery.parseJSON(response);
		            if (results.status == 401 ){
		            	alert('No es posible realizar esta operacion en estos momentos!!!');
		          }else{
		          	$cadena=results.data.split('@');
		          	$("#CodigoC").val($cadena[0]);
		          	$("#NombreC").val($cadena[1]);
		          	$("#ApellidoC").val($cadena[2]);
		          	$("#NitC").val($cadena[3]);
		          	$("#DpiC").val($cadena[4]);
		          	$("#CorreoC").val($cadena[5]);
		          	$("#modificadata").show();
		          	$("#eliminadata").show();		          	
		          	$("#guardadata").hide();
		            }
		        } 
		      });    	

		});
	}


    function llena_tipostel(){  
      $.ajax({
        url: '<?php echo base_url('MantClieAjax/listado_tipotel');?>',
        type:'POST',
        data: {},
        success: function(response){
          var results = jQuery.parseJSON(response);
            if (results.status == 401 ){
            	$("#CmbTipoTel").empty();
          }else{
          	$("#CmbTipoTel").empty().append(results.data);
            }
        } 
      });    	
    }

    function llena_tels(){    	
      $.ajax({
        url: '<?php echo base_url('MantClieAjax/listado_telefonos');?>',
        type:'POST',
        data: {id_identidad:id_identidadg},
        success: function(response){
          var results = jQuery.parseJSON(response);
            if (results.status == 401 ){
            	$("#reportetel").empty();
          }else{
            $("#reportetel").empty().append(results.data);
            creartelefonos();
            eliminartelefonos();
            }
        } 
      });    	
    }

	function eliminartelefonos(){
		$('.eliminatel').click(function(){
			id_eliminar=this.id;
			swal("Esta seguro de eliminar este numero telefonico?", {
			  icon: "warning",	
			   buttons: true,
			  dangerMode: true,
			})
			.then((value) => {
			  switch (value) {
			    case true:
					$.ajax({
				            url: '<?php echo base_url('MantClieAjax/eliminar_tel');?>',
				            type:'POST',
				            data: {id_telefono:id_eliminar},
				            success: function(response){
				              var results = jQuery.parseJSON(response);
				                if (results.status == 200){
								swal('Terra System',results.message,'success');
			                    llena_tels();
			                    $("#txttelefono").val('');			                    
				              }else{
								swal('Terra System',results.message,'warning');
								$("#txttelefono").val('');
				                }
				            } 
				        }); 

			      break;
			  }
			});
		});
	}

	function creartelefonos(){
		$('.agregatelefono').click(function(){
			id_identidadg=this.id;
			llena_tipostel();
			$("#CmbTipoTel").select().focus();
			llena_tels();
            $("#dialog_telefono").modal('show');
		});
	}


	function crear_telefono(){
		$('#asigna_telefono').click(function(){				
        	if( ($("#txttelefono").val()=='') || ($("#CmbTipoTel").val()==0) )
    	 {	
    	  swal('Terra System','Debe Completar Los Datos para Guardar','warning');
    	  return false;
    	 }else{		
				$.ajax({
			                url: '<?php echo base_url('MantClieAjax/inserta_telefono');?>',
			                type:'POST',
			                data: {telefono:$("#txttelefono").val(),id_identidad:id_identidadg,tipotel:$("#CmbTipoTel").val()},
			                success: function(response){
			                  var results = jQuery.parseJSON(response);
			                    if (results.status == 200){
			                    swal("Terra System",results.message,"success");
			                    llena_tels();
			                    $("#txttelefono").val('');			                    
			                  }else{
			                  	swal("Terra System",results.message,"warning");
			                  	$("#txttelefono").val('');	
			                    }
			                } 
			            }); 
			   }
			
		});
	}

    function llena_tarjetas(){
      $.ajax({
        url: '<?php echo base_url('MantClieAjax/listado_tarjetas');?>',
        type:'POST',
        data: {id_identidad:id_identidadg},
        success: function(response){
          var results = jQuery.parseJSON(response);
            if (results.status == 401 ){
            	$("#reportetar").empty();
          }else{
            $("#reportetar").empty().append(results.data); 
            eliminartarjetas();
            }
        } 
      });    	
    }

	function eliminartarjetas(){
		$('.eliminatar').click(function(){
			id_eliminar=this.id;
			swal("Esta seguro de eliminar esta Tarjeta Electronica?", {
			  icon: "warning",	
			   buttons: true,
			  dangerMode: true,
			})
			.then((value) => {
			  switch (value) {
			    case true:
					$.ajax({
				            url: '<?php echo base_url('MantClieAjax/eliminar_tar');?>',
				            type:'POST',
				            data: {id_tarjeta:id_eliminar},
				            success: function(response){
				              var results = jQuery.parseJSON(response);
				                if (results.status == 200){
								swal('Terra System',results.message,'success');
			                    llena_tarjetas();
			                    $("#txttarjeta").val('');			                    
				              }else{
								swal('Terra System',results.message,'warning');
								$("#txttarjeta").val('');
				                }
				            } 
				        }); 

			      break;
			  }
			});
		});
	}

	function creartarjetas(){
		$('.agregatarjeta').click(function(){
			id_identidadg=this.id;
			llena_tarjetas();
            $("#dialog_tarjeta").modal('show');
			return false;
		});
	}

	function crear_tarjeta(){
		$('#asigna_tarjeta').click(function(){				
        	if( $("#txttarjeta").val()=='' )
    	 {	
    	  swal('Terra System','Debe Completar Los Datos para Guardar','warning');
    	  return false;
    	 }else{		
				$.ajax({
			                url: '<?php echo base_url('MantClieAjax/inserta_tarjeta');?>',
			                type:'POST',
			                data: {tarjeta:$("#txttarjeta").val(),id_identidad:id_identidadg},
			                success: function(response){
			                  var results = jQuery.parseJSON(response);
			                    if (results.status == 200){
			                    swal("Terra System",results.message,"success");
			                    llena_tarjetas();
			                    $("#txttarjeta").val('');			                    
			                  }else{
			                  	swal("Terra System",results.message,"warning");
			                  	$("#txttarjeta").val('');
			                    }
			                } 
			            }); 
			   }
			
		});
	}

    function llena_tiposv(){    	
      $.ajax({
        url: '<?php echo base_url('MantClieAjax/listado_tipovehic');?>',
        type:'POST',
        data: {},
        success: function(response){
          var results = jQuery.parseJSON(response);
            if (results.status == 401 ){
            	$("#CmbTipoV").empty();
          }else{
          	$("#CmbTipoV").empty().append(results.data);
            }
        } 
      });    	
    }

    function llena_vehiculos(){
      $.ajax({
        url: '<?php echo base_url('MantClieAjax/listado_vehiculos');?>',
        type:'POST',
        data: {id_identidad:id_identidadg},
        success: function(response){
          var results = jQuery.parseJSON(response);
            if (results.status == 401 ){
            	$("#reporteveh").empty();
          }else{
            $("#reporteveh").empty().append(results.data); 
            eliminarvehiculos();
            }
        } 
      });    	
    }

	function eliminarvehiculos(){
		$('.eliminaveh').click(function(){
			id_eliminar=this.id;
			swal("Esta seguro de eliminar esta Placa Vehicular?", {
			  icon: "warning",	
			   buttons: true,
			  dangerMode: true,
			})
			.then((value) => {
			  switch (value) {
			    case true:
					$.ajax({
				            url: '<?php echo base_url('MantClieAjax/eliminar_veh');?>',
				            type:'POST',
				            data: {id_vehiculo:id_eliminar},
				            success: function(response){
				              var results = jQuery.parseJSON(response);
				                if (results.status == 200){
								swal('Terra System',results.message,'success');
			                    llena_vehiculos();
			                    $("#txtplaca").val('');			                    
				              }else{
								swal('Terra System',results.message,'warning');
								$("#txtplaca").val('');
				                }
				            } 
				        }); 

			      break;
			  }
			});
		});
	}

	function crearvehiculos(){
		$('.agregavehiculo').click(function(){
			id_identidadg=this.id;
			llena_tiposv();
			$("#CmbTipoV").select().focus();
			llena_vehiculos();
            $("#dialog_vehiculo").modal('show');
			return false;
		});
	}

	function crear_vehiculo(){
		$('#asigna_vehiculo').click(function(){		
        if( ($("#txtplaca").val()=='') || ($("#CmbTipoV").val()==0) ) 
    	 {	
    	  swal('Terra System','Debe Completar Los Datos para Guardar','warning');
    	  return false;
    	 }else{		
				$.ajax({
			                url: '<?php echo base_url('MantClieAjax/inserta_vehiculo');?>',
			                type:'POST',
			                data: {placa:$("#txtplaca").val(),id_identidad:id_identidadg,tipove:$("#CmbTipoV").val()},
			                success: function(response){
			                  var results = jQuery.parseJSON(response);
			                    if (results.status == 200){
			                    swal("Terra System",results.message,"success");
			                    llena_vehiculos();
			                    $("#txtplaca").val('');			                    
			                  }else{
			                  	swal("Terra System",results.message,"warning");
			                  	$("#txtplaca").val('');
			                    }
			                } 
			            }); 
			   }
			
		});
	}

</script>