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
			    <span class="fa fa-refresh"></span> Generar Reporte
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
					      <br>
					      <label>
					      	<input  type="checkbox" style="align: center;" id="casas_sc">
					      	<b for="filtrar">Casas NO Habitadas</b>
					      </label>	
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
			    	<table class="table table-hover" id="reporte">

					</table>
			    </div>
		  </div>
		</div>
   </section>

<script type="text/javascript">
  $(document).ready(function(){


    $("#CmbSector").select().focus();

        $("#cargardata").click(function(){
        	if( $("#CmbSector").val()==0){
				swal("Terra System",'Debe Seleccionar un Sector',"warning");
				return false;
        	}else{
        		  if ( $('#casas_sc').prop("checked") ) {
        		    $casash=0; //muestra casas sin clientes
        		  }else{
        		  	$casash=1; //muestra casas con clientes
        		  }
	              $.ajax({
	                url: '<?php echo base_url('RpCuentasxCobrarAjax/cargardatos');?>',
	                type:'POST',
	                data: {sector:$("#CmbSector").val(),casash:$casash},
	                success: function(response){
	                  var results = jQuery.parseJSON(response);
	                    if (results.status == 401 ){
	                    	swal("Terra System",results.message,"warning");
	                  }else{	                  	
	                    $("#reporte").empty().append(results.data);
	                    swal('Terra System','El proceso ha finalizado exitosamente!!!','success');
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
		  var theTable = $('#reporte')
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


</script>