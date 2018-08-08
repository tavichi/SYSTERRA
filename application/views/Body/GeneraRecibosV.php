<?php
		defined('BASEPATH') OR exit('No direct script access allowed');
	  ?>

	<section class="container">

		<div class="container">
		  <div class="row">
		    <div class="col-sm-3 col-md-9 col-lg-9">
		    	<h2><?php echo $nombreopcion?>&nbsp;<small><a class="fa fa-info-circle" data-toggle="tooltip" title="Manual de Usuario" id="ManualUsuario" href="<?php echo base_url(); ?>assets/Manuales/Manual de Usuario 0007 - Generacion de Recibos de Cobro.pdf" target="_blank"></a></small></h2>
		    </div>
		   <br>
		  <div class="row">
		    <div class="col-sm-3 col-md-9 col-lg-12">
			  <button type="button" class="btn btn-success  btn-md" id="cargardata">
			    <span class="fa fa-refresh"></span> Cargar
			  </button>
			  <button type="button" class="btn btn-primary btn-md" id="generardata">
			    <span class="fa fa-plus-square"></span> Generar Recibos
			  </button>
		    </div>
		    <br><br><br><br><br>
		    <div class="col-sm-3 col-md-9 col-lg-12">
				<form class="form-horizontal" >
				  <div class="form-group">
					    <label class="col-lg-2 control-label">Sector:</label>
					    <div class="col-lg-4">
					      <select class="form-control" id='CmbSector'>
					      	<?php echo $sectores?>
					      </select>
					    </div>
				   </div>
				</form>
 		    </div>
 		     <br><br>
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
					 		<th>Sector </th>
					 		<th>Sector-Casa</th>
					 		<th>Cod.Seg.</th>
					 		<th>Dir. Catastro</th>
					 		<th>Cliente</th>
					 		<th>F. Alta</th>
					 		<th>M</th>
					 		<th>Monto</th>
					 		<th>Periodo</th>
					 		<th>Generar</th>
					 	</thead>
					 	<tbody id='reporte'>
					 		
					 	</tbody>
					</table>
			    </div>
		  </div>
		</div>
   </section>

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

<!-- MODAL- DETALLE DE PAGO -->
	<div class="modal fade" id="dialog_detalle" role="dialog">
	<div class="modal-dialog">
	  <div class="modal-content">
	    <div class="modal-header btn-info">
	      <button type="button" class="close" data-dismiss="modal">&times;</button>
	      <h4 class="modal-title" style="font-family:'Shadows Into Light'; font-color:black;" >Terra System - Detalle del Cobro</h4>
	    </div>
	    <div class="modal-body">
	       <div class="container">
	       		<div class="row">
	       			<div class="col-lg-8">
	       				<form class="form-horizontal">
	       					<div class="form-group">

									<div class="col-lg-8">
									<div class="table-responsive">
								    	<table class="table table-hover" id="tabla_tels">
										 	<thead>
										 		<th>Monto Seguridad</th>
										 		<th>No. Tarjetas Plasticas</th>
										 		<th>Monto Tarjetas Plasticas</th>
										 		<th>No. Tarjetas Adicionales</th>										 		
										 		<th>Monto Tarjetas Adicionales</th>
										 	</thead>
										 	<tbody id='reporte_detalle'>
										 		
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
	      <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
	    </div>
	  </div>
	  
	</div>
	</div>
	<!-- -->

<script type="text/javascript">
  $(document).ready(function(){

  	var id_casag=0;

	$("#fechainicio").datepicker({
        format: "yyyy-mm-dd",             
        autoclose: true,
        language: 'es',            
    }).on('onSelect', function(selectedDate){            
       
    }); 

    $('#calendario1').click(function(){
   		 $( "#fechainicio" ).datepicker( "show" );
     });

    $("#CmbSector").select().focus();

        $("#cargardata").click(function(){
        	if( $("#CmbSector").val()==0){
				swal("Terra System",'Debe Seleccionar un Sector',"warning");
				return false;
        	}else{
	              $.ajax({
	                url: '<?php echo base_url('GeneraRecibosAjax/cargardatos');?>',
	                type:'POST',
	                data: {sector:$("#CmbSector").val()},
	                success: function(response){
	                  var results = jQuery.parseJSON(response);
	                    if (results.status == 401 ){
	                    	swal("Terra System",results.message,"warning");
	                  }else{
	                    $("#reporte").empty().append(results.data);
	                    contador=0;
	                    generacion_recibos();
	                    mostrardetalle();
	                    }
	                } 
	            });
        	}
 
        });

        // presionando Enter
        $("#CmbSector").on("keydown", function (e) {
            if (e.keyCode === 13) {  
                $("#codigoSec").focus();
            }
        });
              

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

		$('#modalPago').on('hidden.bs.modal', function () {
		    $('#cmbtpago').val(0);
		    $('#fechainicio').val('');
		    $("#txtobservacion").val('');
		});

		$('#modalPago').on('shown.bs.modal', function () {
		    $('#cmbtpago').focus();
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
			guardapago($("#cmbtpago").val(),$("#fechainicio").val(),$("#txtobservacion").val());
		});


  });

function mostrardetalle(){
	$('.detallemonto').click(function(){

		id_casag=this.id;
		/*llena_tipostel();
		$("#CmbTipoTel").select().focus();*/
		llena_detalle();
        $("#dialog_detalle").modal('show');
	});
}

function llena_detalle(){    	
  $.ajax({
    url: '<?php echo base_url('GeneraRecibosAjax/llena_detalle');?>',
    type:'POST',
    data: {id_casa:id_casag},
    success: function(response){
      var results = jQuery.parseJSON(response);
        if (results.status == 401 ){
        	$("#reporte_detalle").empty();
        }else{
            $("#reporte_detalle").empty().append(results.data);
        }
    } 
  });    	
}

function generacion_recibos(){
	$('#generardata').click(function(){
   	if( ($("#CmbSector").val()==0 ) ) // pendiente validar si la tabla esta vacia
    	 {	
    	  swal('Terra System','Debe Completar Los Datos para Guardar','warning');
    	  return false;
    	 }else{
			$("#txtmontopago").numeric(",");
	  		 $("#modalPago").modal('show');
  	    }
	});
}

function Imprimir($recibo,$serie,$tipodoc,$empresa,$recibof){
		location.href='<?php echo base_url('GeneraRecibosAjax/Imprimir');?>'+'/'+$recibo+'/'+$serie+'/'+$tipodoc+'/'+$empresa+'/'+$recibof;
}
 
function guardapago(tpago,fechap,obser){
		swal("Realmente Desea Realizar este Pago?", {
			  icon: "warning",	
			   buttons: true,
			  dangerMode: true,
			})
			.then((value) => {
			  switch (value) {
			    case true:
				    contador=0; // verifica la informacion chequeada
				    chk1 = new Array();
		    	 	$("input[name='chk[]']:checked").each(function() {
		    	 		chk1.push(this.id);
		    	 	});
		    	 	contador=chk1.length;

					$.ajax({
				            url: '<?php echo base_url('GeneraRecibosAjax/insertarecibos');?>',
				            type:'POST',
				            data: {chk1:chk1,total:chk1.length,
				                   tpago:tpago,fechap:fechap,obser:obser},
			                beforeSend: function(){
			                	$("#modalPago").modal('hide');	
			                	BloquearPantalla(2);
			                },
				            success: function(response){
				              var results = jQuery.parseJSON(response);
				                if (results.status == 200){
					                DesbloquearPantalla();	
					                $cadena=results.data.split('@');
					                //alert($cadena);
									$n_inicial=$cadena[0];
									$n_final=$cadena[1];
									$n_total=$cadena[2];
									$newserie=$cadena[3];
									$newempresa=$cadena[4];
									$mensaje=$n_total+" Recibos generados con exito !!! Del ";//+$n_inicial+" Al "+n_final;
									swal('Terra System',$mensaje,'success');
						          	//Parametros de la funcion imprimir: $recibo,$serie,$tipodoc,$empresa,$recibof
						          	Imprimir($n_inicial,$newserie,1,$newempresa,$n_final);
						          	$("#cargardata").click();
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