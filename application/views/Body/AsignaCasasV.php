<?php
		defined('BASEPATH') OR exit('No direct script access allowed');
	  ?>
	<style type="text/css">
	.ui-front {
	    z-index: 1050 !important;
	    }

	.eliminacliente {
 	cursor:pointer; cursor: hand;
	} 
	.agregarcliente{
 	cursor:pointer; cursor: hand;
	}             
	 .verdetalle{
 	cursor:pointer; cursor: hand;
	}   
	#modaltamano{
  		width: 50% !important;

	}   
	
	</style>
	<section class="container">

		<div class="container">
		  <div class="row">
		    <div class="col-sm-3 col-md-9 col-lg-9">
		    	<h2><?php echo $nombreopcion?>&nbsp;<small><a class="fa fa-info-circle" data-toggle="tooltip" title="Manual de Usuario" id="ManualUsuario" href="<?php echo base_url(); ?>assets/Manuales/Manual de Usuario 0008 - Asignacion a Casas.pdf" target="_blank"></a></small></h2>

		    	<hr>
		    </div>
		</div>
	</div>
		  <div class="row">
		    <div class="col-sm-3 col-md-9 col-lg-12">
			  <button type="button" class="btn btn-success  btn-md" id="cargardata">
			    <span class="fa fa-refresh"></span> Cargar
			  </button>
			  <button type="button" class="btn btn-primary btn-md" id="asignacargos">
			    <span class="fa fa-plus-square"></span> Asignar Cargos
			  </button>
			  <button type="button" class="btn btn-danger btn-md" id="inactiva_cargos">
			    <span class="fa fa-angle-double-down"></span> Inactivar Cargos
			  </button>
			  <button type="button" class="btn btn-warning btn-md" id="borradata">
			    <span class="fa fa-save"></span> Borra Datos
			  </button>
		    </div>
		    <br><br><br>
		    <div class="col-sm-3 col-md-9 col-lg-12">
				<form class="form-horizontal" >
				  <div class="form-group">
					    <label class="col-lg-2 control-label">Tipo de Sector:</label>
					    <div class="col-lg-4">
					      <select class="form-control" id='CmbTSector'>
					      	<?php echo $tsectores?>
					      </select>
					    </div>
				   </div>
				  <div class="form-group">
					    <label class="col-lg-2 control-label">Sector:</label>
					    <div class="col-lg-4">
					      <select class="form-control" id='CmbSector'>
					      <option>Seleccione un Sector</option>
					      </select>
					    </div>
				   </div>
					<div class="form-group">
						<label for="disabledTextInput" class="col-lg-2 control-label"> Cliente:</label>
						<div class="col-lg-6">
							<div class="input-group">
				                 <div class="input-group-addon">
				                      <i class="glyphicon glyphicon-user" id="limpiacliente" style="cursor: pointer; color:blue;"></i>
				                 </div>
						      		<input class="form-control" id="txtcliente" type="text" placeholder="Ingrese nombre de cliente">
						    </div>
			            </div>  					
				    </div>
				</form>
 		    </div>
 		     <br><br><br><br><br><br>
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
		  <div class="row">
				<div class="table-responsive">
			    	<table class="table table-hover" id="tablarep">
					 	<thead>
					 		<th><input type="checkbox" name="seleccion" id="selectodos"></th>
					 		<th>No.</th>
					 		<th>Sector </th>
					 		<th>No. Casa</th>
					 		<th>Dir. Catrastro</th>
					 		<th>Cliente</th>
					 		<th>F. Alta</th>
					 		<th>Opciones</th>
					 	</thead>
					 	<tbody id='reporte'>
					 		
					 	</tbody>
					</table>
			    </div>
		  </div>
		</div>
	</div>
   </section>
   <!-- INPUT HIDDEN-->
<input type="hidden" name="" id="txtclienteoculto"></input>
<input type="hidden" name="" id="txtclientemodaloculto"></input>
<input type="hidden" name="" id="txtidcasaoculto"></input>
<input type="hidden" name="" id="txtidasignacasaoculto"></input>
<!-- MODAL- ASIGNACIONES -->
  <div class="modal fade" id="addcliente" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header btn-info">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="font-family:'Shadows Into Light'; font-color:black;" >Terra System - Asignaci&oacute;n de Clientes</h4>
        </div>
        <div class="modal-body">
           <div class="container">
           		<div class="row">
           			<div class="col-lg-8">
           				<form class="form-horizontal">
           					<div class="form-group">
		           				<label for="disabledTextInput" class="col-lg-2 control-label"> Cliente <span class="glyphicon glyphicon-user"></span> :</label>
							    <div class="col-lg-5">
							    	<input class="form-control" id="txtclientemodal" type="text" placeholder="Ingrese nombre de cliente">
							    </div>
							</div>
					    </form>
           			</div>
           		</div>
           </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary"  id="asigna_cliente">Asignar</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
      
    </div>
  </div>

<!-- MODAL- DESASIGNACIONES -->
  <div class="modal fade" id="desasignacliente" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header btn-info">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="font-family:'Shadows Into Light'; font-color:black;" >Terra System - Desasignaci&oacute;n de Clientes</h4>
        </div>
        <div class="modal-body">
           <div class="container">
           		<div class="row">
           			<div class="col-lg-8">
           				<form class="form-horizontal">
           					<div class="form-group">
		           				<label for="disabledTextInput" class="col-lg-2 control-label"> Motivo <span class="glyphicon glyphicon-edit"></span> :</label>
							    <div class="col-lg-5">
							    	<textarea class="form-control" id="txtmotivo" rows="2" maxlength="100" placeholder="Ingrese Motivo de Desasignacion"></textarea>
							    </div>
							</div>
					    </form>
           			</div>
           		</div>
           </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-warning"  id="desasigna_cliente">Desasignar</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
      
    </div>
  </div>
<!-- -->
<!-- MODAL- PARAMETROS DE COBROS -->
  <div class="modal fade" id="listadecobros" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog" id="modaltamano">
      <div class="modal-content">
        <div class="modal-header btn-info">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="font-family:'Shadows Into Light'; font-color:black;" >Terra System - Parametros de Cobro </h4>
        </div>
        <div class="modal-body">
           <div class="container center-block">
           		<div class="row">
           			<div class="col-lg-8">
           				<center>
           						<div class="table-responsive " >
			    					<table class="table table-hover center-block" id="tablarepmodal" >
					 					<thead>
					 						<th>No.</th>
					 						<th>Descripci&oacute;n </th>
					 						<th>Moneda</th>
					 						<th>Precio</th>
					 						<th>Vigente Hasta</th>
					 						<th>Opci&oacute;n</th>
					 					</thead>	
					 					<tbody id="tablatarifas">
					 						
					 					</tbody>
           							</table>
         						</div>
         				</center>
           			</div>
           		</div>
           </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-warning"  id="usaparametro">Asignar Parametro</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
      
    </div>
  </div>
<!-- -->
<!-- MODAL- PARAMETROS ASIGNADOS -->
  <div class="modal fade" id="parametrosasig" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog" id="modaltamano">
      <div class="modal-content">
        <div class="modal-header btn-info">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="font-family:'Shadows Into Light'; font-color:black;" >Terra System - Parametros de Cobro Asignados </h4>
        </div>
        <div class="modal-body">
           <div class="container center-block">
           		<div class="row">
           			<div class="col-lg-8">
           				<center>
           						<div class="table-responsive " >
			    					<table class="table table-hover center-block" id="tablarepmodal" >
					 					<thead>
					 						<th><center>No.</center></th>
					 						<th><center>Descripci&oacute;n </center></th>
					 						<th><center>Moneda</center></th>
					 						<th><center>Precio</center></th>
					 						<th><center>Opci&oacute;n</center></th>
					 					</thead>	
					 					<tbody id="tablatarifasasig">
					 						
					 					</tbody>
           							</table>
         						</div>
         				</center>
           			</div>
           		</div>
           </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Salir</button>
        </div>
      </div>
      
    </div>
  </div>
<!-- -->

<!-- MODAL- CAMBIO FECHA ASIGNACION -->
  <div class="modal fade" id="fechaasigna" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header btn-info">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="font-family:'Shadows Into Light'; font-color:black;" >Terra System - Configuraci&oacute;n de fecha de Asignaci&oacute;n</h4>
        </div>
        <div class="modal-body">
           <div class="container">
           		<div class="row">
           			<div class="col-lg-8">
           		    <form class="form-horizontal">
           				<div class="form-group">
           					<div class="col-lg-2">
							    <label class="col-lg- control-label">Nueva Fecha:</label>
							</div>
							    <div class="col-lg-5">
									<div class="input-group">
				                        <div class="input-group-addon">
				                            <i class="fa fa-calendar" id="calendario1" style="cursor: pointer;color: #FF0000"></i>
				                        </div>
				                       <input type="text"  class="form-control" name="fechaasig" id="fechaasig" readonly="true">
								    </div>
						   		</div>
						</div>
           					<div class="form-group">
		           				<label for="disabledTextInput" class="col-lg-2 control-label"> Motivo <span class="glyphicon glyphicon-edit"></span> :</label>
							    <div class="col-lg-5">
							    	<textarea class="form-control" id="txtmotivofecha" rows="2" maxlength="100" placeholder="Ingrese Motivo de Cambio de Fecha"></textarea>
							    </div>
							</div>
				    </form>
           		</div>
           	</div>
           </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-warning"  id="cambiarfecha">Cambiar Fecha</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
      
    </div>
  </div>
<!-- -->
<script type="text/javascript">
  $(document).ready(function(){

	$("#fechaasig").datepicker({
        format: "yyyy-mm-dd",             
        autoclose: true,
        language: 'es',            
    }).on('onSelect', function(selectedDate){            
       
    }); 

    $('#calendario1').click(function(){
   		 $( "#fechaasig" ).datepicker( "show" );
     });
  	
    $("#CmbTSector").select().focus();

        $("#cargardata").click(function(){
        	if( $("#CmbTSector").val()==0){
				swal("Terra System",'Debe Seleccionar un Tipo de Sector',"warning");
				return false;
        	}else{
        		if( $("#CmbSector").val()==0){
					swal("Terra System",'Debe Seleccionar un Sector',"warning");
					return false;
        	    }else{
		              $.ajax({
		                url: '<?php echo base_url('AsignaCasasAjax/cargardatos');?>',
		                type:'POST',
		                data: {sector:$("#CmbSector").val(),cliente:$("#txtclienteoculto").val()},
		                success: function(response){
		                  var results = jQuery.parseJSON(response);
		                    if (results.status == 401 ){
		                    	swal("Terra System",results.message,"warning");
		                    	$("#reporte").empty();
		                  }else{
		                    $("#reporte").empty().append(results.data);
		                    asignarcliente();
		                    Desasignarcliente();
		                    VerDetalleParam();
		                    cambiafecha();
		                    }
		                } 
		            });
        		}
        	}
 
        });

        $("#CmbTSector").change(function(){
					$.ajax({
				                url: '<?php echo base_url('AsignaCasasAjax/TraeSectores');?>',
				                type:'POST',
				                data: {tsectores:$("#CmbTSector").val()},
				                success: function(response){
				                    $("#CmbSector").empty().append(response);
				                } 
				            }); 

        });

        $("#limpiacliente").click(function(){
        	$("#txtclienteoculto").val('');
        	$("#txtcliente").val('');
        	$("#cargardata").click();
        });
        $("#asignacargos").click(function(){
        	var chk1 = new Array();
        		$("input[name='chk[]']:checked").each(function() {
					chk1.push(this.id);
			    });
				contador=chk1.length;
	         		if (contador==0){
	           			swal('Terra System','Debe Seleccionar al menos una Casa','warning');
			   			return false;	
	         		}else{
							$.ajax({
						                url: '<?php echo base_url('AsignaCasasAjax/TraeTarifas');?>',
						                type:'POST',
						                data: {tsectores:$("#CmbTSector").val()},
						                success: function(response){
						                 var results = jQuery.parseJSON(response);
						                 
										 if (results.status == 200){
										 	$("#tablatarifas").empty().append(results.data);
										 	$("#listadecobros").modal('show');
										 	asignarcliente();
		                    				Desasignarcliente();
		                   				    VerDetalleParam();
		                   				    cambiafecha();
						                  }else{
						                  	swal("Terra System",results.message,"warning");
						                  }
						                } 
						            });
							        	
	      			}				
        	
        });

		$("#inactiva_cargos").click(function(){
        	var chk3 = new Array();
        		$("input[name='chk[]']:checked").each(function() {
					chk3.push(this.id);
			    });
				contador=chk3.length;
	         		if (contador==0){
	           			swal('Terra System','Debe Seleccionar al menos una Casa','warning');
			   			return false;	
	         		}else{

	         			swal("Realmente Desea Desasignar los cargos de las casas seleccionadas?", {
						  icon: "warning",	
						   buttons: true,
						  dangerMode: true,
						})
						.then((value) => {
						  switch (value) {
						    case true:
									$.ajax({
								                url: '<?php echo base_url('AsignaCasasAjax/InactivaBloque');?>',
								                type:'POST',
								                data: {casas:chk3},
								                beforeSend: function(){
								                	BloquearPantalla(2);
								                },
								                success: function(response){
								                 var results = jQuery.parseJSON(response);
								                 
												 if (results.status == 200){
												 	swal("Terra System",results.message,"success");
												 	asignarcliente();
				                    				Desasignarcliente();
				                   				    VerDetalleParam();
				                   				    cambiafecha();
				                   				    $("#cargardata").click();
				                   				    $("#selectodos").prop('checked',false);
				                   				    DesbloquearPantalla();
								                  }else{
								                  	swal("Terra System",results.message,"warning");
								                  	DesbloquearPantalla();
								                  }
								                } 
								            });
								break;
	  						}
						});
							        	
	      			}	
		});

        $("#asigna_cliente").click(function(){
        	guardaclienteasignado($("#txtclientemodaloculto").val(),$("#txtidcasaoculto").val());
        });

        $("#desasigna_cliente").click(function(){
        	guardaclientedesasignado($("#txtidasignacasaoculto").val(),$("#txtmotivo").val());
        });
        $("#borradata").click(function(){
        	location.reload();
        })
        // presionando Enter
        $("#CmbTSector").on("keydown", function (e) {
            if (e.keyCode === 13) {  
                $("#CmbSector").focus();
            }
        });

        $("#CmbSector").on("keydown", function (e) {
            if (e.keyCode === 13) {  
                $("#cargardata").focus();
            }
        });

		$('#addcliente').on('shown.bs.modal', function () {
		    $('#txtclientemodal').focus();
		});  

		$('#desasignacliente').on('shown.bs.modal', function () {
		    $('#txtmotivo').focus();
		});

		$('#addcliente').on('hidden.bs.modal', function () {
		    $('#txtclientemodal').val('');
		    $('#txtclientemodaloculto').val('');
		    $("#cargardata").click();
		}); 
		$('#desasignacliente').on('hidden.bs.modal', function () {
		    $('#txtmotivo').val('');
		    $("#cargardata").click();
		});
		$('#fechaasigna').on('hidden.bs.modal', function () {
		    $('#txtmotivofecha').val('');
		    $('#fechaasig').val('');
		    $("#cargardata").click();
		});

		$('#usaparametro').click(function(){
			$("#listadecobros").modal('hide');
			parametro=$('input:radio[name=precios]:checked').val();
        	var chk2 = new Array();
        		$("input[name='chk[]']:checked").each(function() {
					chk2.push(this.id);
			    });

			swal("Se Asignara el cargo seleccionado Inactivando el anterior si existiera. Desea Continuar?", {

		    icon: "warning",
		    buttons: true,
		    dangerMode: true,
			}).then((value) => {
			  switch (value) {
			 
			    case true:
		          	$.ajax({
				                url: '<?php echo base_url('AsignaCasasAjax/Asignaparametro');?>',
				                type:'POST',
				                data: {parametro:parametro, casas:chk2},
				                beforeSend: function(){
				                	BloquearPantalla(2);
				                },
				                success: function(response){
				                  var results = jQuery.parseJSON(response);
				                    if (results.status == 200){
									swal("Terra System",results.message,"success");
				                    $("#cargardata").click();
				                    $("#selectodos").prop('checked',false);
				                    DesbloquearPantalla();
				                  }else{
									swal("Terra System",results.message,"warning");
									DesbloquearPantalla();
				                    }
				                } 
				            }); 

	   			break;
	  		   }
	  		});
		});

	    $("#selectodos").change(function(){
			var marcado = $("input[name='chk[]']").is(":checked");
			if(!marcado)
				$("input[name='chk[]']").prop('checked',true);
			else
				$("input[name='chk[]']").prop('checked', false);
	    });

		//----------------------buscar en tabla--------------
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
        //-------------------------------------------------------

		autocomplete_clientes();
		autocomplete_clientes_modal();

  }); //document ready

function guardaclienteasignado(cliente,casa){
	swal("Realmente Desea Asignar este Cliente a la Casa?", {
	  icon: "warning",	
	   buttons: true,
	  dangerMode: true,
	})
	.then((value) => {
	  switch (value) {
	    case true:
			$.ajax({
		            url: '<?php echo base_url('AsignaCasasAjax/insertacliente');?>',
		            type:'POST',
		            data: {cliente:cliente, casa:casa},
		            success: function(response){
		              var results = jQuery.parseJSON(response);
		                if (results.status == 200){
						swal('Terra System',results.message,'success');
		                $("#addcliente").modal('hide');
		                	asignarcliente();
		                    Desasignarcliente();
		                    VerDetalleParam();
		                    cambiafecha();
		              }else{
						swal('Terra System',results.message,'warning');
		                }
		            } 
		        }); 

	      break;
	  }
	});
	
}

function guardaclientedesasignado(casa,motivo){
		swal("Realmente Desea Desasignar a este Cliente de la Casa?", {
			  icon: "warning",	
			   buttons: true,
			  dangerMode: true,
			})
			.then((value) => {
			  switch (value) {
			    case true:
					$.ajax({
				            url: '<?php echo base_url('AsignaCasasAjax/inactivaasignacion');?>',
				            type:'POST',
				            data: {casa:casa,motivo:motivo},
				            success: function(response){
				              var results = jQuery.parseJSON(response);
				                if (results.status == 200){
								swal('Terra System',results.message,'success');
								$("#desasignacliente").modal('hide');
								asignarcliente();
			                    Desasignarcliente();
			                    VerDetalleParam();
			                    cambiafecha();
				              }else{
								swal('Terra System',results.message,'warning');
				                }
				            } 
				        }); 

			      break;
			  }
			});
}

function asignarcliente(){
	$(".agregarcliente").click(function(){
		$("#txtidcasaoculto").val('');
		idcasa=this.id;
		$("#txtidcasaoculto").val(idcasa);
		$("#addcliente").modal('show');

	});
}

function Desasignarcliente(){
	$(".eliminacliente").click(function(){
		$("#txtidasignacasaoculto").val('');
		idcasa=this.id;
		$("#txtidasignacasaoculto").val(idcasa);
		BloquearPantalla();
		$("#desasignacliente").modal('show');
		DesbloquearPantalla();

	});
}
function VerDetalleParam(){

	$(".verdetalle").click(function(){
	 casaparam=this.id;
		$.ajax({
	                url: '<?php echo base_url('AsignaCasasAjax/TraeTarifasAsig');?>',
	                type:'POST',
	                data: {casa:casaparam},
	                success: function(response){
	                 var results = jQuery.parseJSON(response);
					 if (results.status == 200){
					 	$("#tablatarifasasig").empty().append(results.data);
					 	$("#parametrosasig").modal('show');
					 	InactivaParametroAsignado();
		                    asignarcliente();
		                    Desasignarcliente();
		                    cambiafecha();
	                  }else{
	                  	swal("Terra System",results.message,"warning");
	                  }
	                } 
	    });
	});
}
function InactivaParametroAsignado(){

	$(".inactivapar").click(function(){
  		 parametro = this.id;
			swal("Realmente Desea Inactivar el Parametro Asignado?", {
			  icon: "warning",	
			   buttons: true,
			  dangerMode: true,
			})
			.then((value) => {
			  switch (value) {
			    case true:

							$.ajax({
					            url: '<?php echo base_url('AsignaCasasAjax/InactivaParam');?>',
					            type:'POST',
					            data: {parametro:parametro},
					            success: function(response){
					              var results = jQuery.parseJSON(response);
					                if (results.status == 200){
									swal('Terra System',results.message,'success');
									$("#parametrosasig").modal('hide');
				                    asignarcliente();
				                    Desasignarcliente();
				                    VerDetalleParam();
				                    cambiafecha();
					              }else{
									swal('Terra System',results.message,'warning');
					                }
					            } 
					        });
					

			      break;
			  }
			});
	});
	
}

function CambiaF(par){

	$("#cambiarfecha").click(function(){
  		 parametrof = par;
			swal("Realmente Desea Cambiar la Fecha de Asignacion?", {
			  icon: "warning",	
			   buttons: true,
			  dangerMode: true,
			})
			.then((value) => {
			  switch (value) {
			    case true:

							$.ajax({
					            url: '<?php echo base_url('AsignaCasasAjax/CambiaFechaAs');?>',
					            type:'POST',
					            data: {fecha:$("#fechaasig").val(),motivo:$("#txtmotivofecha").val(),idasignacion:parametrof},
					            success: function(response){
					              var results = jQuery.parseJSON(response);
					                if (results.status == 200){
									swal('Terra System',results.message,'success');
									$("#fechaasigna").modal('hide');
				                    asignarcliente();
				                    Desasignarcliente();
				                    VerDetalleParam();
				                    cambiafecha();
					              }else{
									swal('Terra System',results.message,'warning');
					                }
					            } 
					        });
					

			      break;
			  }
			});
	});
	
} 
function autocomplete_clientes(){  //autocomplete de clientes
    $('#txtcliente').autocomplete({
        source: function( request, response ) {               
            $.ajax({
                type: "POST",
                      url: '<?php echo base_url('AsignaCasasAjax/autocompleteclientes');?>',
                      data: {f :1,cliente: $('#txtcliente').val().trim()} ,
                      success: function(data){
                          var arr = jQuery.parseJSON(data);
                          response( $.map( arr, function( item ) {
                        return {
                            value: item.value,
                            id: item.id
                        }
                    }));      
                      }
            }); 
        },
        select: function( event, ui ) {
            $('#txtclienteoculto').val(ui.item.id);
            return false; 
        }
     });
  }
function autocomplete_clientes_modal(){  //autocomplete de clientes
    $('#txtclientemodal').autocomplete({
        source: function( request, response ) {               
            $.ajax({
                type: "POST",
                      url: '<?php echo base_url('AsignaCasasAjax/autocompleteclientes');?>',
                      data: {f :1,cliente: $('#txtclientemodal').val().trim()} ,
                      success: function(data){
                          var arr = jQuery.parseJSON(data);
                          response( $.map( arr, function( item ) {
                        return {
                            value: item.value,
                            id: item.id
                        }
                    }));      
                      }
            }); 
        },
        select: function( event, ui ) {
            $('#txtclientemodaloculto').val(ui.item.id);
            return false; 
        }
     });
  }

function BloquearPantalla(parametros){
	if (parametros==1 ){ //cargando
		$.blockUI({ message: '<h1><img src="<?php echo base_url(); ?>assets/imagenes/waiting.gif" /> </h1>' });
	}
	if(parametros==2){ // procesando
		$.blockUI({ message: '<h1><img src="<?php echo base_url(); ?>assets/imagenes/cortinilla2.gif" /> </h1>' });	
	}

}

function DesbloquearPantalla(){
	$.unblockUI();
}
function cambiafecha(){
	$(".cambiof").click(function(){
		Params=this.id;
		$("#fechaasigna").modal('show');
		CambiaF(Params);

	});
}
</script>