<?php
		defined('BASEPATH') OR exit('No direct script access allowed');
	  ?>

	<section class="container">

		<div class="container">
		  <div class="row">
		    <div class="col-sm-3 col-md-9 col-lg-9">
		    	<h2><?php echo $nombreopcion?>&nbsp;<small><a class="fa fa-info-circle" data-toggle="tooltip" title="Manual de Usuario" id="ManualUsuario" href="<?php echo base_url(); ?>assets/Manuales/Manual de Usuario 0006 - Control de Residencias.pdf" target="_blank"></a></small>
		    	</h2>
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
			  <button type="button" class="btn btn-default btn-md" id="reinicio">
			    <span class="fa fa-cogs"></span> Reiniciar Codigos
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
					    <label for="disabledTextInput" class="col-lg-1 control-label">No Casa:</label>
					    <div class="col-lg-3">
					      <input class="form-control" id="nocasa" type="text" placeholder="Ingrese Codigo de Casa">
					    </div>
				   </div>
					<div class="form-group">
						<fieldset class="col-sm-3 col-md-9 col-lg-12">
							<legend>
								Direcci&oacute;n Catastral
							</legend>
						<label for="disabledTextInput" class="col-lg-2 control-label">No. </label>
					    <div class="col-lg-1">
					      <input class="form-control" id="calleavenida" type="text" placeholder="No.">
					    </div>
						<label for="disabledTextInput" class="col-lg-2 control-label">Calle/Ave.</label>
					    <div class="col-lg-3">
								<select class="form-control" id='cmbtdireccion'>
					      			<?php echo $Tdireccion?>
					      		</select>
					    </div>
						<label for="disabledTextInput" class="col-lg-2 control-label">Literal: </label>
					    <div class="col-lg-2">
					      <input class="form-control" id="literal" type="text" placeholder="Literal">
					    </div>
					    <br><br><br>
						<label for="disabledTextInput" class="col-lg-2 control-label">No. Casa # 1:</label>
					    <div class="col-lg-1">
					      <input class="form-control" id="nocasa1" type="text" placeholder="casa # 1.">
					    </div>
						<label for="disabledTextInput" class="col-lg-2 control-label">No. Casa # 2:</label>
					    <div class="col-lg-1">
					      <input class="form-control" id="nocasa2" type="text" placeholder="casa # 2.">
					    </div>
						</fieldset>
				    </div>
				     <div class="col-sm-3 col-md-9 col-lg-12">
				     	<hr></hr>
				     </div>	
					<div class="form-group">
					    <label for="disabledTextInput" class="col-lg-2 control-label">Codigo Seguridad:</label>
					     <div class="col-lg-3">
					      <input class="form-control" id="codigoSec" type="text" placeholder="Ingrese Codigo de Seg" readonly="true">
					     </div>
					      <div class="col-lg-6">
					     		 <button type="button" class="btn btn-primary btn-md" id="gencodigo">
			    					<span class="fa fa-cogs"></span> Generar Codigo
			 			  		 </button>
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
		  <div class="row">
				<div class="table-responsive">
			    	<table class="table table-hover" id="tablarep">
					 	<thead>
					 		<th>No.</th>
					 		<th>Sector </th>
					 		<th>No. Casa</th>
					 		<th>Dir. Catrastro</th>
					 		<th>Estado</th>
					 		<th>Codigo Seg.</th>
					 		<th>F. Alta</th>
					 		<th>Opciones</th>
					 	</thead>
					 	<tbody id='reporte'>
					 		
					 	</tbody>
					</table>
			    </div>
		  </div>
		</div>
   </section>
<!-- MODAL- ACTUALIZACIONES -->
  <div class="modal fade" id="modalactualiza" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header btn-info">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="font-family:'Shadows Into Light'; font-color:black;" >Terra System - Actualizaci&oacute;n de Codigo de Seguridad</h4>
        </div>
        <div class="modal-body">
           <div class="container">
           		<div class="row">
           			<div class="col-lg-8">
           				<form class="form-horizontal">
							<div class="form-group">
							    <label for="disabledTextInput" class="col-lg-2 control-label">Codigo Seguridad:</label>
							     <div class="col-lg-3">
							      <input class="form-control" id="codigoSecModal" type="text" placeholder="Ingrese Codigo de Seg" readonly="true">
							     </div>
							      <div class="col-lg-3">
							     		 <button type="button" class="btn btn-primary btn-md" id="gencodigomodal">
					    					<span class="fa fa-cogs"></span> Generar Codigo
					 			  		 </button>
							      </div>
						  </div>
           					<div class="form-group">
		           				<label for="disabledTextInput" class="col-lg-2 control-label"> Motivo <span class="glyphicon glyphicon-edit"></span> :</label>
							    <div class="col-lg-6">
							    	<textarea class="form-control" id="txtmotivo" rows="2" maxlength="100" placeholder="Ingrese Motivo de Desasignacion"></textarea>
							    </div>
							</div>
					    </form>
           			</div>
           		</div>
           </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-warning"  id="asigna">Actualizar</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
      
    </div>
  </div>
<!-- -->
<!-- MODAL- ACTUALIZACIONES -->
  <div class="modal fade" id="modalactualizadireccion" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header btn-info">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="font-family:'Shadows Into Light'; font-color:black;" >Terra System - Actualizaci&oacute;n de Direcci&oacute;n Catastral</h4>
        </div>
        <div class="modal-body">
           <div class="container">
           		<div class="row">
           			<div class="col-lg-8">
           				<form class="form-horizontal">
					<div class="form-group">
						<fieldset class="col-sm-3 col-md-12 col-lg-12">
							<legend>
								Direcci&oacute;n Catastral
							</legend>
						<label for="disabledTextInput" class="col-lg-1 control-label">No. </label>
					    <div class="col-lg-2">
					      <input class="form-control" id="calleavenidamodal" type="text" placeholder="No.">
					    </div>
						<label for="disabledTextInput" class="col-lg-2 control-label">Calle/Ave.</label>
					    <div class="col-lg-4">
								<select class="form-control" id='cmbtdireccionmodal'>
					      			<?php echo $Tdireccion?>
					      		</select>
					    </div>
						<label for="disabledTextInput" class="col-lg-1 control-label">Literal: </label>
					    <div class="col-lg-2">
					      <input class="form-control" id="literalmodal" type="text" placeholder="Literal">
					    </div>
					    <br><br><br>
						<label for="disabledTextInput" class="col-lg-2 control-label">No. Casa # 1:</label>
					    <div class="col-lg-2">
					      <input class="form-control" id="nocasa1modal" type="text" placeholder="casa # 1.">
					    </div>
						<label for="disabledTextInput" class="col-lg-2 control-label">No. Casa # 2:</label>
					    <div class="col-lg-2">
					      <input class="form-control" id="nocasa2modal" type="text" placeholder="casa # 2.">
					    </div>
						</fieldset>
				    </div>
				     <div class="col-sm-3 col-md-9 col-lg-12">
				     	<hr></hr>
				     </div>	
           					<div class="form-group">
		           				<label for="disabledTextInput" class="col-lg-2 control-label"> Motivo <span class="glyphicon glyphicon-edit"></span> :</label>
							    <div class="col-lg-6">
							    	<textarea class="form-control" id="txtmotivocambiodir" rows="2" maxlength="100" placeholder="Ingrese Motivo de cambio de Direccion"></textarea>
							    </div>
							</div>
					    </form>
           			</div>
           		</div>
           </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-warning"  id="asignanuevadir">Actualizar</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
      
    </div>
  </div>
<!-- -->
<input type="hidden" id="casaactualizacod" ></input>
<input type="hidden" id="casaactualizadircat" ></input>
<script type="text/javascript">
  $(document).ready(function(){
    $("#CmbSector").select().focus();
        $("#cargardata").click(function(){
        	if( $("#CmbSector").val()==0){
				swal("Terra System",'Debe Seleccionar un Sector',"warning");
				return false;
        	}else{
	              $.ajax({
	                url: '<?php echo base_url('MantCasasAjax/cargardatos');?>',
	                type:'POST',
	                data: {sector:$("#CmbSector").val()},
	                success: function(response){
	                  var results = jQuery.parseJSON(response);
	                    if (results.status == 401 ){
	                    	swal("Terra System",results.message,"warning");
	                  }else{
	                    $("#reporte").empty().append(results.data);
	                    inactivarcasa();
	                    actualizacod();
	                    actualizadicatastro();
	                    }
	                } 
	            });
        	}
 
        });

        $("#guardadata").click(function(){
        	
        	if( ($("#nocasa").val()=='') || ($("#dircatastro").val()=='') || ($("#codigosec").val()=='' )|| ($("#CmbSector").val()==0 ) )
        	 {	
        	  swal('Terra System','Debe Completar Los Datos para Guardar','warning');
        	  return false;
        	 }else{
					$.ajax({
				                url: '<?php echo base_url('MantCasasAjax/insertadatos');?>',
				                type:'POST',
				                data: {nocasa:$("#nocasa").val(),calleave:$("#calleavenida").val(),tdireccion:$("#cmbtdireccion").val(),literal:$("#literal").val(),nocasa1:$("#nocasa1").val(),nocasa2:$("#nocasa2").val(),sector:$("#CmbSector").val(),codigosec:$("#codigoSec").val()},
				                success: function(response){
				                  var results = jQuery.parseJSON(response);
				                    if (results.status == 200){
				                    swal('Terra System',results.message,'success');
				                    $("#cargardata").click();
				                  }else{
				                  	swal('Terra System',results.message,'warning');
				                    }
				                } 
				            }); 
        	 }


        });
        $("#gencodigo").click(function(){
        	
					$.ajax({
				                url: '<?php echo base_url('MantCasasAjax/generacodigo');?>',
				                type:'POST',
				                data: {},
				                success: function(response){
				                  var results = jQuery.parseJSON(response);
				                  if (results.status == 200){
				                    $("#codigoSec").val(results.data);
				                  }else{
				                  	$("#gencodigo").click();
				                    }
				                } 
				            }); 
        	 


        });

        $("#gencodigomodal").click(function(){
        	
					$.ajax({
				                url: '<?php echo base_url('MantCasasAjax/generacodigo');?>',
				                type:'POST',
				                data: {},
				                success: function(response){
				                  var results = jQuery.parseJSON(response);
				                  if (results.status == 200){
				                    $("#codigoSecModal").val(results.data);
				                  }else{
				                  	if (results.status == 401){
				                  	swal('Terra System',results.message,'warning');
				                  	setTimeout(Reintentar, 3000);
				                  	   
				                  	}else{
				                  		swal('Terra System',results.message,'warning');
				                  	}
				                  	
				                    }
				                } 
				            }); 
        	 


        });
        $("#asigna").click(function(){
        	
        	if( ($("#txtmotivo").val()=='') || ($("#codigoSecModal").val()=='')  )
        	 {	
        	  swal('Terra System','Debe Completar Los Datos para Actualizar','warning');
        	  return false;
        	 }else{
					$.ajax({
					                url: '<?php echo base_url('MantCasasAjax/actualizarcod');?>',
					                type:'POST',
					                data: {nocasa:$("#casaactualizacod").val(),codigosec:$("#codigoSecModal").val(),motivo:$("#txtmotivo").val()},
					                success: function(response){
					                  var results = jQuery.parseJSON(response);
					                    if (results.status == 200){
					                    swal('Terra System',results.message,'success');
					                    $("#cargardata").click();
					                    $("#modalactualiza").modal('hide');
					                  }else{
					                  	swal('Terra System',results.message,'warning');
					                    }
					                } 
							 }); 
        	 }


        });

        $("#asignanuevadir").click(function(){
        	
        	if( ($("#txtmotivocambiodir").val()=='') || ($("#nocasa2modal").val()=='')  || ($("#nocasa1modal").val()=='') || ($("#literalmodal").val()=='') || ($("#cmbtdireccionmodal").val()==0) || ($("#calleavenidamodal").val()=='') )
        	 {	
        	  swal('Terra System','Debe Completar Los Datos para Actualizar','warning');
        	  return false;
        	 }else{
					$.ajax({
					                url: '<?php echo base_url('MantCasasAjax/actualizardir');?>',
					                type:'POST',
					                data: {motivo:$("#casaactualizacod").val(),calleavenida:$("#calleavenidamodal").val(),tdireccion:$("#cmbtdireccionmodal").val(),nocasa1:$("#nocasa1modal").val(),nocasa2:$("#nocasa2modal").val(),literal:$("#literalmodal").val(),nocasa:$("#casaactualizadircat").val()},
					                success: function(response){
					                  var results = jQuery.parseJSON(response);
					                    if (results.status == 200){
					                    swal('Terra System',results.message,'success');
					                    $("#cargardata").click();
					                    $("#modalactualizadireccion").modal('hide');
					                  }else{
					                  	swal('Terra System',results.message,'warning');
					                    }
					                } 
							 }); 
        	 }


        });
		$("#reinicio").click(function(){
				idcasa=this.id;

		swal("Realmente Desea Reiniciar los Codigos de Seguridad?", {
		  icon: "warning",	
		   buttons: true,
		  dangerMode: true,
		})
		.then((value) => {
		  switch (value) {
		    case true:
				$.ajax({
			            url: '<?php echo base_url('MantCasasAjax/Reinicio');?>',
			            type:'POST',
			            data: {idcasa:idcasa},
			            success: function(response){
			              var results = jQuery.parseJSON(response);
			                if (results.status == 200){
							swal('Terra System',results.message,'success');
			              }else{
							swal('Terra System',results.message,'warning');
			                }
			            } 
			        }); 

		      break;
		  }
		});
		});
        $("#borradata").click(function(){
        	location.reload();
        })
        // presionando Enter
        $("#CmbSector").on("keydown", function (e) {
            if (e.keyCode === 13) {  
                $("#nocasa").focus();
            }
        });
        $("#nocasa").on("keydown", function (e) {
            if (e.keyCode === 13) {  
                $("#calleavenida").focus();
            }
        });
        $("#gencodigo").on("keydown", function (e) {
            if (e.keyCode === 13) {  
                $("#guardadata").focus();
            }
        });

        $("#codigoSecModal").on("keydown", function (e) {
            if (e.keyCode === 13) {  
                $("#txtmotivo").focus();
            }
        });
        $("#txtmotivo").on("keydown", function (e) {
            if (e.keyCode === 13) {  
                $("#asigna").focus();
            }
        });
        $("#calleavenida").on("keydown", function (e) {
            if (e.keyCode === 13) {  
                $("#cmbtdireccion").focus();
            }
        });
        $("#cmbtdireccion").on("keydown", function (e) {
            if (e.keyCode === 13) {  
                $("#literal").focus();
            }
        });
        $("#literal").on("keydown", function (e) {
            if (e.keyCode === 13) {  
                $("#nocasa1").focus();
            }
        });
        $("#nocasa1").on("keydown", function (e) {
            if (e.keyCode === 13) {  
                $("#nocasa2").focus();
            }
        });
        $("#nocasa2").on("keydown", function (e) {
            if (e.keyCode === 13) {  
                $("#gencodigo").focus();
            }
        });
        $("#calleavenidamodal").on("keydown", function (e) {
            if (e.keyCode === 13) {  
                $("#cmbtdireccionmodal").focus();
            }
        });
        $("#cmbtdireccionmodal").on("keydown", function (e) {
            if (e.keyCode === 13) {  
                $("#literalmodal").focus();
            }
        });
        $("#literalmodal").on("keydown", function (e) {
            if (e.keyCode === 13) {  
                $("#nocasa1modal").focus();
            }
        });
        $("#nocasa1modal").on("keydown", function (e) {
            if (e.keyCode === 13) {  
                $("#nocasa2modal").focus();
            }
        });
        $("#nocasa2modal").on("keydown", function (e) {
            if (e.keyCode === 13) {  
                $("#asignanuevadir").focus();
            }
        });

		$('#modalactualiza').on('shown.bs.modal', function () {
		    $('#codigoSecModal').focus();
		});
		$('#modalactualiza').on('hidden.bs.modal', function () {
		    $('#codigoSecModal').val('');
		     $('#txtmotivo').val('');
		    
		});
        $("#nocasa2modal").on("keydown", function (e) {
            if (e.keyCode === 13) {  
                $("#txtmotivocambiodir").focus();
            }
        });
        $("#txtmotivocambiodir").on("keydown", function (e) {
            if (e.keyCode === 13) {  
                $("#asignanuevadir").focus();
            }
        });
		$('#modalactualizadireccion').on('shown.bs.modal', function () {
		    $('#calleavenidamodal').focus();
		});
		$('#modalactualizadireccion').on('hidden.bs.modal', function () {
            $('#calleavenidamodal').val('');
            $('#tdireccion').val(0);
            $('#literalmodal').val('');
            $('#nocasa1modal').val('');
            $('#nocasa2modal').val('');
             $('#txtmotivocambiodir').val('');
		    
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

  });



function inactivarcasa(){
	$(".eliminacasa").click(function(){
		idcasa=this.id;

swal("Realmente Desea Dar de Baja Esta Casa?", {
  icon: "warning",	
   buttons: true,
  dangerMode: true,
})
.then((value) => {
  switch (value) {
    case true:
		$.ajax({
	            url: '<?php echo base_url('MantCasasAjax/inactivacasas');?>',
	            type:'POST',
	            data: {idcasa:idcasa},
	            success: function(response){
	              var results = jQuery.parseJSON(response);
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
}
function actualizacod(){
	$(".actcod").click(function(){
		idcasa=this.id;
		$("#casaactualizacod").val(idcasa);
		$("#modalactualizadireccion").modal('show');
	});
}
function Reintentar(){
$("#gencodigomodal").click();
}
function actualizadicatastro(){
	$(".cambiadircatastro").click(function(){
		idcasa=this.id;
		$("#casaactualizadircat").val(idcasa);
		$("#modalactualizadireccion").modal('show');
	});
}
</script>