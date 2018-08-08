	<?php
		defined('BASEPATH') OR exit('No direct script access allowed');
	  ?>
<style type="">
	.eliminadet {
 	cursor:pointer; cursor: hand;
	}
</style>
	<section class="container">

		<div class="container">
		  <div class="row">
		    <div class="col-sm-3 col-md-9 col-lg-9">
		    	<h2><?php echo $nombreopcion?>&nbsp;<small><a class="fa fa-info-circle" data-toggle="tooltip" title="Manual de Usuario" id="ManualUsuario" href="<?php echo base_url(); ?>assets/Manuales/Manual de Usuario 0007 -Lista de Precios.pdf" target="_blank"></a></small></h2>
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
			  <button type="button" class="btn btn-warning btn-md" id="borradata">
			    <span class="fa fa-save"></span> Borra Datos
			  </button>
		    </div>
		    <br><br><br><br><br>
		    <div class="col-sm-3 col-md-9 col-lg-12">
				<form class="form-horizontal" role="form">
				  <div class="form-group">
				    <label class="col-lg-2 control-label">Tipo de Sector:</label>
				    <div class="col-lg-4">
				      	<select class="form-control" id='CmbTSector'>
					      	<?php echo $Tsectores?>
					     </select>
				    </div>
				  </div>
				  <div class="form-group">
				    <label class="col-lg-2 control-label">Tipo de Producto:</label>
				    <div class="col-lg-4">
				      	<select class="form-control" id='CmbTproducto'>
					      	<?php echo $Tproducto?>
					     </select>
				    </div>
				    <div class="col-lg-2">
						<button type="button" class="btn btn-primary  btn-md" id="agregaproducto">
			    			<span class="fa fa-plus"></span> Agregar Producto
			  			</button>
				    </div>
				  </div>
				  <div class="form-group">
				    <label class="col-lg-2 control-label">Observaci&oacute;n:</label>
				    <div class="col-lg-6">
				      <input class="form-control" id="obser" type="text" placeholder="Ingrese Observacion">
				    </div>
				  </div>
				   <div class="form-group">
					    <label class="col-lg-2 control-label">Valido Hasta:</label>
					    <div class="col-lg-6">
							<div class="input-group">
		                        <div class="input-group-addon">
		                            <i class="fa fa-calendar" id="calendario1" style="cursor: pointer;color: #FF0000"></i>
		                        </div>
		                       <input type="text"  class="form-control" name="fechainicio" id="fechainicio" readonly="true">
						    </div>
				   		</div>
				   </div>
				  <div class="form-group">
				    <label for="disabledTextInput" class="col-lg-2 control-label">Monto Q:</label>
				    <div class="col-lg-2">
				      <input class="form-control" id="precio" type="text" placeholder="Ingrese Monto">
				    </div>
				  </div>
				</form>
 		    </div>
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
					 		<th>Tipo Cuota </th>
					 		<th>Descripci&oacute;n</th>
					 		<th>F. Inicio </th>
					 		<th>Moneda </th>
					 		<th>Monto</th>
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
<!-- MODAL- PRODUCTO -->
  <div class="modal fade" id="modalProducto" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header btn-info">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="font-family:'Shadows Into Light'; font-color:black;" >Terra System - Nuevos Productos</h4>
        </div>
        <div class="modal-body">
           <div class="container">
           		<div class="row">
           			<div class="col-lg-8">
           				<form class="form-horizontal" >
						  <div class="form-group">
							    <label class="col-lg-2 control-label">Tipo de producto:</label>
							    <div class="col-lg-6">
							      <select class="form-control" id='CmbTproductoModal'>
							      	<?php echo $Tipopro?>
							      </select>
							    </div>
						   </div>
						   <div class="form-group">
							    <label class="col-lg-2 control-label">Nombre:</label>
							    <div class="col-lg-6">
									<div class="input-group">
				                        <div class="input-group-addon">
				                            <i class="fa fa-cart-plus"></i>
				                        </div>
				                       <input type="text"  class="form-control" id="nombreProducto">
								    </div>
						   		</div>
						   </div>
						   <div class="form-group">
							    <label class="col-lg-2 control-label">abreviatura:</label>
							    <div class="col-lg-6">
									<div class="input-group">
				                        <div class="input-group-addon">
				                            <i class=""></i>
				                        </div>
				                       <input type="text"  class="form-control" id="abr">
								    </div>
						   		</div>
						   </div>
						  <div class="form-group">
							    <label class="col-lg-2 control-label">Moneda:</label>
							    <div class="col-lg-6">
							      <select class="form-control" id='CmbMoneda'>
							      	<?php echo $TMonedas?>
							      </select>
							    </div>
						   </div>
						   <div class="form-group">
							    <label class="col-lg-2 control-label">Precio:</label>
							    <div class="col-lg-6">
									<div class="input-group">
				                        <div class="input-group-addon">
				                            <i class="fa fa-money"></i>
				                        </div>
				                       <input type="text"  class="form-control" id="PrecioProducto">
								    </div>
						   		</div>
						   </div>					   
						</form>
           			</div>
           		</div>
           </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-warning"  id="AgregarProductomodal">Agregar</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
      
    </div>
  </div>
<!-- -->
<script type="text/javascript">
  $(document).ready(function(){
  	 $("#CmbTSector").focus();
  	$("#PrecioProducto").numeric(",");
  	$("#precio").numeric(",");
   	$("#fechainicio").datepicker({
        format: "yyyy-mm-dd",             
        autoclose: true,
        language: 'es',            
    }).on('onSelect', function(selectedDate){            
       
    }); 

    $('#calendario1').click(function(){
   		 $( "#fechainicio" ).datepicker( "show" );
     });


        $("#cargardata").click(function(){
              $.ajax({
                url: '<?php echo base_url('MantPreciosAjax/cargardatos');?>',
                type:'POST',
                data: {},
                success: function(response){
                  var results = jQuery.parseJSON(response);
                    if (results.status == 401 ){
                   swal("Terra System",results.message,"warning");
                  }else{
                    $("#reporte").empty().append(results.data);
                    inactivarLista();
                    }
                } 
            }); 
        });

        $("#guardadata").click(function(){
        	
        	if( ($("#obser").val()=='') || ($("#precio").val()=='') || ($("#CmbTSector").val()==0)|| ($("#CmbTproducto").val()==0) || ($("#fechainicio").val()=='') || ($("#fechainicio").val()==null ))
        	 {	
        	  swal('Terra System','Debe Completar Los Datos para Guardar','warning');
        	  return false;
        	 }else{
					$.ajax({
				                url: '<?php echo base_url('MantPreciosAjax/insertadatos');?>',
				                type:'POST',
				                data: {obser:$("#obser").val(),precio:$("#precio").val(),Tsector:$("#CmbTSector").val(),Tproducto:$("#CmbTproducto").val(),fecha:$("#fechainicio").val()},
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
        $("#borradata").click(function(){
        	location.reload();
        })
        // presionando Enter
        $("#CmbTSector").on("keydown", function (e) {
            if (e.keyCode === 13) {  
                $("#CmbTproducto").focus();
            }
        });
              
        $("#CmbTproducto").on("keydown", function (e) {
            if (e.keyCode === 13) {  
                $("#obser").focus();
            }
        });
        $("#obser").on("keydown", function (e) {
            if (e.keyCode === 13) {  
                $("#Monto").focus();
            }
        });
        $("#precio").on("keydown", function (e) {
            if (e.keyCode === 13) {  
                $("#guardadata").focus();
            }
        });
        $("#nombreProducto").on("keydown", function (e) {
            if (e.keyCode === 13) {  
                $("#CmbMoneda").focus();
            }
        });
        $("#CmbMoneda").on("keydown", function (e) {
            if (e.keyCode === 13) {  
                $("#PrecioProducto").focus();
            }
        });
        $("#PrecioProducto").on("keydown", function (e) {
            if (e.keyCode === 13) {  
                $("#AgregarProductomodal").focus();
            }
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
		$('#modalProducto').on('hidden.bs.modal', function () {
		    $('#CmbTproductoModal').val(0);
		    $('#CmbMoneda').val(0);
		    $('#nombreProducto').val('');
		    $("#PrecioProducto").val('');
		}); 

		$('#modalProducto').on('shown.bs.modal', function () {
		    $('#CmbTproductoModal').focus();
		});
		$("#agregaproducto").click(function(){
		 $("#modalProducto").modal("show");
		});

		$("#AgregarProductomodal").click(function(){
		 if ( ($("#CmbTproductoModal").val()== 0 ) || ($("#CmbMoneda").val()==0) || ($("#nombreProducto").val()=='') || ($("#nombreProducto").val()==null ) || ($("#PrecioProducto").val()=='') || ($("#PrecioProducto").val()==null) || ($("#abr").val()=='') || ($("#abr").val()==null )  ){
		 	swal('Terra System','Debe Completar Los Datos para Guardar el Producto','warning');
		 }else{
					$.ajax({
				                url: '<?php echo base_url('MantPreciosAjax/InsertaProducto');?>',
				                type:'POST',
				                data: {tproducto:$("#CmbTproductoModal").val(),moneda:$("#CmbMoneda").val(),nombreProducto:$("#nombreProducto").val(),precio:$("#PrecioProducto").val()},
				                success: function(response){
				                  var results = jQuery.parseJSON(response);
				                    if (results.status == 200){
				                    swal("Terra System",results.message,"success");
				                    setTimeout(recargar, 3000);
				                  }else{
				                  	swal("Terra System",results.message,"warning");
				                    }
				                } 
				            });

		 } 

		});	

 });


function recargar(){
	location.reload();
}
function inactivarLista(){
	$(".eliminadet").click(function(){
		idlista=this.id;

		swal("Realmente Desea Dar de Baja Esta Lista?", {

	    icon: "warning",
	    buttons: true,
	    dangerMode: true,
		}).then((value) => {
		  switch (value) {
		 
		    case true:
	          	$.ajax({
			                url: '<?php echo base_url('MantPreciosAjax/inactivarListas');?>',
			                type:'POST',
			                data: {idlista:idlista},
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

   			break;
  		   }
		});
	});
}
</script>