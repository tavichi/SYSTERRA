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
		    	<h2>Mantenimiento de Sectores &nbsp;<small><a class="fa fa-info-circle" data-toggle="tooltip" title="Manual de Usuario" id="ManualUsuario" href="<?php echo base_url(); ?>assets/Manuales/Manual de Usuario 0005 - Control de Sectores.pdf" target="_blank"></a></small></h2>
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
				    <div class="col-lg-6">
				      	<select class="form-control" id='CmbTSector'>
					      	<?php echo $Tsectores?>
					     </select>
				    </div>
				  </div>
				  <div class="form-group">
				    <label class="col-lg-2 control-label">Nombre:</label>
				    <div class="col-lg-6">
				      <input class="form-control" id="NombreSec" type="text" placeholder="Ingrese Nombre">
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="disabledTextInput" class="col-lg-2 control-label">Codigo:</label>
				    <div class="col-lg-6">
				      <input class="form-control" id="codigoSec" type="text" placeholder="Ingrese Codigo">
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
					 		<th>Nombre </th>
					 		<th>Codigo</th>
					 		<th>Tipo Sector </th>
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

<script type="text/javascript">
  $(document).ready(function(){
    $("#NombreSec").focus();
        $("#cargardata").click(function(){
              $.ajax({
                url: '<?php echo base_url('MantSecAjax/cargardatos');?>',
                type:'POST',
                data: {},
                success: function(response){
                  var results = jQuery.parseJSON(response);
                    if (results.status == 401 ){
                   swal("Terra System",results.message,"warning");
                  }else{
                    $("#reporte").empty().append(results.data);
                    inactivarsector();
                    }
                } 
            }); 
        });

        $("#guardadata").click(function(){
        	
        	if( ($("#NombreSec").val()=='') || ($("#codigoSec").val()=='') || ($("#CmbTSector").val()==0))
        	 {	
        	  swal('Terra System','Debe Completar Los Datos para Guardar','warning');
        	  return false;
        	 }else{
					$.ajax({
				                url: '<?php echo base_url('MantSecAjax/insertadatos');?>',
				                type:'POST',
				                data: {nombresec:$("#NombreSec").val(),codigosec:$("#codigoSec").val(),Tsector:$("#CmbTSector").val()},
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
        $("#NombreSec").on("keydown", function (e) {
            if (e.keyCode === 13) {  
                $("#codigoSec").focus();
            }
        });
              
        $("#codigoSec").on("keydown", function (e) {
            if (e.keyCode === 13) {  
                $("#guardadata").focus();
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
  });

function inactivarsector(){
	$(".eliminadet").click(function(){
		idsector=this.id;

		swal("Realmente Desea Dar de Baja Este Sector?", {

	    icon: "warning",
	    buttons: true,
	    dangerMode: true,
		}).then((value) => {
		  switch (value) {
		 
		    case true:
	          	$.ajax({
			                url: '<?php echo base_url('MantSecAjax/inactivasector');?>',
			                type:'POST',
			                data: {idsector:idsector},
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