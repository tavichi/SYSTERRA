<?php
		defined('BASEPATH') OR exit('No direct script access allowed');
	  ?>

	<section class="container">

		<div class="container">
		  <div class="row">
		    <div class="col-sm-3 col-md-9 col-lg-9">
		    	<h2><?php echo $nombreopcion?></h2>
		    </div>
		   <br>
		  <div class="row">
		    <div class="col-sm-3 col-md-9 col-lg-12">
			  <button type="button" class="btn btn-success  btn-md" id="cargardata">
			    <span class="fa fa-refresh"></span> Cargar
			  </button>
			  <button type="button" class="btn btn-success btn-md" id="excel">
			    <span class="fa fa-file-excel-o"></span> Generar Excel
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
					 		<th>No. Casa</th>
					 		<th>Cod.Seg.</th>
					 		<th>Dir. Catastro</th>
					 		<th>Cliente</th>
					 		<th>F. Alta</th>
					 	</thead>
					 	<tbody id='reporte'>
					 		
					 	</tbody>
					</table>
			    </div>
		  </div>
		</div>
   </section>


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
										 		<th>Monto Tarjeta Adicionales</th>
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
	                url: '<?php echo base_url('RpCasasActivasAjax/cargardatos');?>',
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


		$("#excel").click(function(){
        	if( $("#CmbSector").val()==0){
				swal("Terra System",'Debe Seleccionar un Sector',"warning");
				return false;
        	}else{
				alert('Por favor no utilizar EXCEL, hasta que la generacion del Reporte FINALICE....');
				location.href='<?php echo base_url('RpCasasActivasAjax/generar_excel');?>'+'/'+$("#CmbSector").val();
			}
		});


  });

function mostrardetalle(){
	$('.detallemonto').click(function(){

		id_casag=this.id;
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