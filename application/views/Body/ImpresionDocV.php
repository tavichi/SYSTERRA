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
	.pagar{
 	cursor:pointer; cursor: hand;
	}             
	 .verdetalles{
 	cursor:pointer; cursor: hand;
	}   
	#modaltamano{
  		width: 50% !important;

	}   
	#totalf {
  		height: 1px;
  		color: red;
	}
	
	</style>
	<section class="container">

		<div class="container">
		  <div class="row">
		    <div class="col-sm-3 col-md-9 col-lg-9">
		    	<h2><?php echo $nombreopcion?></h2>
		    	<hr>
		    </div>
		</div>
	</div>
		  <div class="row">
		    <div class="col-sm-3 col-md-9 col-lg-12">
			  <button type="button" class="btn btn-success  btn-md" id="cargardata">
			    <span class="fa fa-refresh"></span> Cargar
			  </button>
			  <!--<button type="button" class="btn btn-danger btn-md" id="Anularb">
			    <span class="fa fa-remove"></span> Anular Recibo
			  </button>-->
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
				    <div class="form-group">
					    <label class="col-lg-2 control-label">Rango de Fechas:</label>
					    <div class="col-lg-3">
							<div class="input-group">
		                        <div class="input-group-addon">
		                            <i class="fa fa-calendar" id="calendario1" style="cursor: pointer;color: #FF0000"></i>
		                        </div>
		                       <input type="text"  class="form-control" name="fechainicio" id="fechainicio" readonly="true">
						    </div>
						</div>
						<div class="col-lg-1">
						    <span class="input-group-addon">Al</span>
			            </div>
			            <div class="col-lg-3">
			            	<div class="input-group">
		                        <div class="input-group-addon">
		                            <i class="fa fa-calendar" id="calendario2" style="cursor: pointer;color: #000080"></i>
		                        </div>
		                       <input type="text"  class="form-control" name="fechaFinal" id="fechaFinal" readonly="true">
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
					 		<th>No.</th>
					 		<th>No. Recibo </th>
					 		<th>Serie</th>
					 		<th>Tipo Doc.</th>
					 		<th>Cliente</th>
					 		<th>F. Emision</th>
					 		<th>F. Vencimiento</th>
					 		<th>Moneda</th>
					 		<th>Monto</th>
					 		<th>Saldo</th>
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
<input type="hidden" name="" id="txtparametropagooculto"></input>

<!-- MODAL- ANULACIONES -->
  <div class="modal fade" id="modalanulacion" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header btn-info">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="font-family:'Shadows Into Light'; font-color:black;" >Terra System - Anulaci&oacute;n de Recibos</h4>
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
          <button type="button" class="btn btn-warning"  id="Anular">Anular</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
      
    </div>
  </div>
<!-- -->
<!-- MODAL- PAGO -->
  <div class="modal fade" id="modalPago" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header btn-info">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="font-family:'Shadows Into Light'; font-color:black;" >Terra System - Pago de Recibo</h4>
        </div>
        <div class="modal-body">
           <div class="container">
           		<div class="row">
           			<div class="col-lg-8">
           				<form class="form-horizontal" >
						  <div class="form-group">
							    <label class="col-lg-3 control-label">Tipo de pago:</label>
							    <div class="col-lg-4">
							      <select class="form-control" id='cmbtpago'>
							      	<?php echo $tpago?>
							      </select>
							    </div>
						   </div>
						   <div class="form-group">
							    <label class="col-lg-3 control-label">Fecha Pago:</label>
							    <div class="col-lg-4">
									<div class="input-group">
				                        <div class="input-group-addon">
				                            <i class="fa fa-calendar" id="calendario1" style="cursor: pointer;color: #FF0000"></i>
				                        </div>
				                       <input type="text"  class="form-control" name="fechainicio" id="fechainicio" readonly="true">
								    </div>
						   		</div>
						   </div>
						   <div class="form-group">
							    <label class="col-lg-3 control-label">Cantidad de Pago:</label>
							    <div class="col-lg-4">
								<input class="form-control" id="txtmontopago" type="text" placeholder="Ingrese no. Doc Pago">
							    </div>
						   </div>
           					<div class="form-group">
		           				<label for="disabledTextInput" class="col-lg-3 control-label"> Observacion <span class="glyphicon glyphicon-edit"></span> :</label>
							    <div class="col-lg-4">
							    	<textarea class="form-control" id="txtobservacion" rows="2" maxlength="100" placeholder="Ingrese Observacion de Pago"></textarea>
							    </div>
							</div>					   
						</form>
           			</div>
           		</div>
           </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-warning"  id="pagarec">Pagar</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
      
    </div>
  </div>
<!-- -->
<!-- MODAL- DETALLES  DE RECIBO -->
  <div class="modal fade" id="listadecobros" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog" id="modaltamano">
      <div class="modal-content">
        <div class="modal-header btn-info">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="font-family:'Shadows Into Light'; font-color:black;" >Terra System - Detalles Recibo </h4>
        </div>
        <div class="modal-body">
           <div class="container center-block">
           		<div class="row">
           			<div class="col-lg-8">
           				<center>
           						<div class="table-responsive " >
			    					<table class="table table-hover center-block" id="tablarepmodal" >
					 					<thead>
					 						<th>Linea Det.</th>
					 						<th>Descripci&oacute;n </th>
					 						<th>Moneda</th>
					 						<th>Total</th>
					 					</thead>	
					 					<tbody id="tablacobros">
					 						
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

<script type="text/javascript">
  $(document).ready(function(){

	$("#fechainicio").datepicker({
        format: "yyyy-mm-dd",             
        autoclose: true,
        language: 'es',            
    }).on('onSelect', function(selectedDate){            
       $("#fechaFinal").val($("#fechainicio").val());
    }); 

    $('#calendario1').click(function(){
   		 $( "#fechainicio" ).datepicker( "show" );
     });

	$("#fechaFinal").datepicker({
        format: "yyyy-mm-dd",             
        autoclose: true,
        language: 'es',            
    }).on('onSelect', function(selectedDate){            
       
    });
    $('#calendario2').click(function(){
   		 $( "#fechaFinal" ).datepicker( "show" );
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
		                url: '<?php echo base_url('ImpresionDOcAjax/cargardatos');?>',
		                type:'POST',
		                data: {sector:$("#CmbSector").val(),cliente:$("#txtclienteoculto").val(),fini: $( "#fechainicio" ).val(),ffin: $( "#fechaFinal" ).val()},
		                success: function(response){
		                  var results = jQuery.parseJSON(response);
		                    if (results.status == 401 ){
		                    	swal("Terra System",results.message,"warning");
		                    	$("#reporte").empty();
		                  }else{
		                    $("#reporte").empty().append(results.data);
		                    VerDetalleRecibo();
		                    Imprimir();
		                    }
		                } 
		            });
        		}
        	}
 
        });

        $("#CmbTSector").change(function(){
					$.ajax({
				                url: '<?php echo base_url('ImpresionDOcAjax/TraeSectores');?>',
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
		$("#Anularb").click(function(){
        	var chk3 = new Array();
        		$("input[name='chk[]']:checked").each(function() {
					chk3.push(this.id);
			    });
				contador=chk3.length;
	         		if (contador==0){
	           			swal('Terra System','Debe Seleccionar al menos un Recibo','warning');
			   			return false;	
	         		}else{
	         			$("#modalanulacion").modal('show');
	         		}
	    });

		$("#Anular").click(function(){
        	var chk3 = new Array();
        		$("input[name='chk[]']:checked").each(function() {
					chk3.push(this.id);
			    });
				contador=chk3.length;
	         		if (contador==0){
	           			swal('Terra System','Debe Seleccionar al menos un Recibo','warning');
			   			return false;	
	         		}else{

	         			swal("Realmente Desea Anular los Recibos Seleccionados?", {
						  icon: "warning",	
						   buttons: true,
						  dangerMode: true,
						})
						.then((value) => {
						  switch (value) {
						    case true:
									$.ajax({
								                url: '<?php echo base_url('ImpresionDOcAjax/AnularBloque');?>',
								                type:'POST',
								                data: {recibos:chk3,motivo:$("#txtmotivo").val().trim()},
								                beforeSend: function(){
								                	BloquearPantalla(2);
								                },
								                success: function(response){
								                 var results = jQuery.parseJSON(response);
								                 
												 if (results.status == 200){
												 	swal("Terra System",results.message,"success");
								                    VerDetalleRecibo();
								                    Imprimir();
				                   				    $("#cargardata").click();
				                   				    $("#selectodos").prop('checked',false);
				                   				    $("#modalanulacion").modal('hide');
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

        $("#borradata").click(function(){
        	location.reload();
        })
        // presionando Enter
        $("#CmbTSector").on("keydown", function (e) {
            if (e.keyCode === 13) {  
                $("#CmbSector").focus();
            }
        });

        $("#cmbtpago").on("keydown", function (e) {
            if (e.keyCode === 13) {  
 				$('#fechainicio').focus();

            }
        });
        $("#fechainicio").on("keydown", function (e) {
            if (e.keyCode === 13) {  
 				$('#txtmontopago').focus();

            }
        });
        $("#txtmontopago").on("keydown", function (e) {
            if (e.keyCode === 13) {  
 				$('#txtobservacion').focus();

            }
        });
        $("#txtobservacion").on("keydown", function (e) {
            if (e.keyCode === 13) {  
 				$('#pagarec').focus();

            }
        });
        $("#CmbTSector").on("keydown", function (e) {
            if (e.keyCode === 13) {  
                $("#CmbSector").focus();
            }
        });

		$('#modalPago').on('hidden.bs.modal', function () {
		    $('#cmbtpago').val(0);
		    $('#fechainicio').val('');
		    $("#txtmontopago").val('');
		    $("#txtobservacion").val('');
		}); 
		$('#modalPago').on('shown.bs.modal', function () {
		    $('#cmbtpago').focus();
		}); 
		$('#modalanulacion').on('shown.bs.modal', function () {
		    $('#txtmotivo').focus();
		});
		$('#modalanulacion').on('hidden.bs.modal', function () {
		    $('#txtmotivo').val('');
		});

		$('#pagarec').click(function(){

			if ($("#cmbtpago").val()==0){
				swal("Terra System",'Debe Seleccionar un Tipo de Pago',"warning");	
				return false;
			}
			if($("#fechainicio").val()=='' || $("#fechainicio").val()== null ){
				swal("Terra System",'Debe Seleccionar una Fecha de Pago',"warning");	
				return false;
			}
			if($("#txtmontopago").val()== '' || $("#txtmontopago").val()=='0'){
				swal("Terra System",'Debe Seleccionar Ingresar un Monto Valido',"warning");	
				return false;
			}

			guardapago($("#txtparametropagooculto").val(),$("#cmbtpago").val(),$("#fechainicio").val(),$("#txtmontopago").val(),$("#txtobservacion").val());
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

  }); //document ready



function guardapago(parametro,tpago,fechap,cantpago,obser){

	datos=parametro.split('<@>');
	recibop=datos[0];
	seriep=datos[1];
	tipodocp=datos[2];
	empresap=datos[3];

		swal("Realmente Desea Realizar este Pago?", {
			  icon: "warning",	
			   buttons: true,
			  dangerMode: true,
			})
			.then((value) => {
			  switch (value) {
			    case true:
					$.ajax({
				            url: '<?php echo base_url('ImpresionDOcAjax/Imprimir');?>',
				            type:'POST',
				            data: {recibo:recibop,serie:seriep,tipodoc:tipodocp,empresa:empresap,tpago:tpago,fechap:fechap,cantpago:cantpago,obser:obser},
			                beforeSend: function(){
			                	BloquearPantalla(2);
			                },
				            success: function(response){
				              var results = jQuery.parseJSON(response);
				                if (results.status == 200){
								swal('Terra System',results.message,'success');
								$("#modalPago").modal('hide');
								DesbloquearPantalla();
								$("#cargardata").click();
		                    	VerDetalleRecibo();
		                    	Imprimir();
				              }else{
								swal('Terra System',results.message,'warning');
								DesbloquearPantalla();
				                }
				            } 
				        }); 

			      break;
			  }
			});
}



function VerDetalleRecibo(){

	$(".verdetalles").click(function(){
	 parametros=this.id.split('<@>');
	 recibo=parametros[0];
	 serie=parametros[1];
	 tipodoc=parametros[2];
	 empresa=parametros[3];
		$.ajax({
	                url: '<?php echo base_url('ImpresionDOcAjax/DetalleRecibo');?>',
	                type:'POST',
	                data: {recibo:recibo,serie:serie,tipodoc:tipodoc,empresa:empresa},
	                success: function(response){
	                 var results = jQuery.parseJSON(response);
					 if (results.status == 200){
					 	$("#tablacobros").empty().append(results.data);
					 	$("#listadecobros").modal('show');
	                  }else{
	                  	swal("Terra System",results.message,"warning");
	                  }
	                } 
	    });
	});
}
function Imprimir(){

	$(".print").click(function(){
		$datos=this.id.split('<@>');
		location.href='<?php echo base_url('ImpresionDOcAjax/Imprimir');?>'+'/'+$datos[0]+'/'+$datos[1]+'/'+$datos[2]+'/'+$datos[3];
	});
	
}
 
function autocomplete_clientes(){  //autocomplete de clientes
    $('#txtcliente').autocomplete({
        source: function( request, response ) {               
            $.ajax({
                type: "POST",
                      url: '<?php echo base_url('ImpresionDOcAjax/autocompleteclientes');?>',
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

</script>
