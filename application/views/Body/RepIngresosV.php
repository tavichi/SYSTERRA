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
		    	<h2><?php echo $nombreopcion?> <small><a class="fa fa-info-circle" data-toggle="tooltip" title="Manual de Usuario" id="ManualUsuario" href="<?php echo base_url(); ?>assets/Manuales/Manual de Usuario 0010 - Reporte de Ingresos.pdf" target="_blank"></a></small></h2>
		    	
		    </div>
		   <br>
		  <div class="row">
		    <div class="col-sm-3 col-md-9 col-lg-12">
			  <button type="button" class="btn btn-info  btn-md" id="cargardata">
			    <span class="fa fa-refresh"></span> Cargar
			  </button>
			  <button type="button" class="btn btn-success btn-md" id="excel">
			    <span class="fa fa-file-excel-o"></span> Generar Excel
			  </button>
			  <button type="button" class="btn btn-warning btn-md" id="borradata">
			    <span class="fa fa-save"></span> Borra Datos
			  </button>
		    </div>
		    <br><br><br><br><br>
		    <div class="col-sm-3 col-md-9 col-lg-12">
				<form class="form-horizontal" role="form">
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
		    <div class="col-lg-12">
				<div class="table-responsive">
			    	<table class="table table-hover" id="tablarep">
					 	<thead>
					 		<th>ID</th>
					 		<th>Recibo</th>
					 		<th>A nombre De</th>
					 		<th>Casa </th>
					 		<th>Sector </th>
					 		<th>Estado </th>
					 		<th>F.pago</th>
					 		<th>Moneda</th>
					 		<th>Seguridad</th>
					 		<th>Tarjetas</th>
					 		<th>Monto</th>
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

	$("#fechaFinal").datepicker({
        format: "yyyy-mm-dd",             
        autoclose: true,
        language: 'es',            
    }).on('onSelect', function(selectedDate){            
       
    });
    $('#calendario2').click(function(){
   		 $( "#fechaFinal" ).datepicker( "show" );
     });

        $("#cargardata").click(function(){
              $.ajax({
                url: '<?php echo base_url('RepIngresosAjax/cargardatos');?>',
                type:'POST',
                data: {fini:$("#fechainicio").val(),ffin:$("#fechaFinal").val(),cliente:$("#txtclienteoculto").val()},
                success: function(response){
                  var results = jQuery.parseJSON(response);
                    if (results.status == 401 ){
                   swal("Terra System",results.message,"warning");
                  }else{
                    $("#reporte").empty().append(results.data);
                    }
                } 
            }); 
        });
		$("#excel").click(function(){
			if($("#txtclienteoculto").val()==null || $("#txtclienteoculto").val()=='' ){
				cliente=0;
			}else{
				cliente=$("#txtclienteoculto").val();
			}
		location.href='<?php echo base_url('RepIngresosAjax/generar_excel');?>'+'/'+$("#fechainicio").val()+'/'+$("#fechaFinal").val()+'/'+cliente;
		});
        $("#borradata").click(function(){
        	location.reload();
        })
autocomplete_clientes();
 });

function autocomplete_clientes(){  //autocomplete de clientes
    $('#txtcliente').autocomplete({
        source: function( request, response ) {               
            $.ajax({
                type: "POST",
                      url: '<?php echo base_url('RepIngresosAjax/autocompleteclientes');?>',
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
</script>