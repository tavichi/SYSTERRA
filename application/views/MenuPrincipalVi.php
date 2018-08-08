<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Menu Principal</title>
<!-- Listado de archivos necesarios -->	
	<link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/css/bootstrap.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/css/sweetalert2.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/css/sweetalert2.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.js"> </script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap.js"> </script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"> </script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/sweetalert2.min.js"> </script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/sweetalert2.js"> </script>
</head>
<style type="text/css">
.texto_grande {
    font-size: 1.5rem;
    color: white;
} 
#icone_grande {
    font-size: 4rem;
    color:#fff;
} 
</style>
<body>
<!-- cuerpo de la Pagina -->
<div class="container">
	<div class="row">
     <div class="col-md-3">
        <a class="btn btn-block btn-lg btn-primary" data-toggle="modal" data-target="#mymodal">
            <i class="fa fa-users" id="icone_grande"></i> <br><br>
            <span class="texto_grande"><i class="fa fa-plus-circle"></i> Mi Perfil</span></a>
      </div>
      <div class="col-md-3">
        <a class="btn btn-block btn-lg btn-danger" data-toggle="modal" data-target="#mymodal">
            <i class="fa fa-home" id="icone_grande"></i> <br><br>
            <span class="texto_grande"><i class="fa fa-times-circle-o"></i> Mi Vivienda</span></a>
      </div>
      <div class="col-md-3">
        <a class="btn btn-block btn-lg btn-success" data-toggle="modal" data-target="#mymodal">
            <i class="fa fa-cog fa-spin" id="icone_grande"></i> <br><br>
            <span class="texto_grande"><i class="fa fa-edit"></i> Informes / Gastos</span></a>
      </div>

    </div>
    <br>
 	<div class="row">
     <div class="col-md-3">
        <a class="btn btn-block btn-lg btn-success" data-toggle="modal" data-target="#mymodal">
            <i class="fa fa-users" id="icone_grande"></i> <br><br>
            <span class="texto_grande"><i class="fa fa-plus-circle"></i> Usuários</span></a>
      </div>
      <div class="col-md-3">
        <a class="btn btn-block btn-lg btn-danger" data-toggle="modal" data-target="#mymodal">
            <i class="fa fa-home" id="icone_grande"></i> <br><br>
            <span class="texto_grande"><i class="fa fa-times-circle-o"></i> Viviendas</span></a>
      </div>
      <div class="col-md-3">
        <a class="btn btn-block btn-lg btn-primary" data-toggle="modal" data-target="#mymodal">
            <i class="fa fa-cog fa-spin" id="icone_grande"></i> <br><br>
            <span class="texto_grande"><i class="fa fa-edit"></i> Gastos</span></a>
      </div>
      <div class="col-md-3">
        <a class="btn btn-block btn-lg btn-warning" data-toggle="modal" data-target="#mymodal">
            <i class="fa fa-male" id="icone_grande"></i> <br><br>
            <span class="texto_grande"><i class="fa fa-list-ul"></i> Empleados</span></a>
      </div>
    </div>  
</div>

<div class="btn-group">
  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" 
          data-toggle="dropdown" >
    Dropdown
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" role="menu" >
    <li role="presentation"><a role="menuitem"  href="#">Action</a></li>
    <li role="presentation"><a role="menuitem" href="#">Another action</a></li>
    <li role="presentation"><a role="menuitem" href="#">Something else here</a></li>
    <li role="presentation"><a role="menuitem" href="#">Separated link</a></li>
  </ul>
</div>
</body>

<!-- Iniciando Javascript-->
<script type="text/javascript">
	$(document).ready(function(){
	
	});


</script>


