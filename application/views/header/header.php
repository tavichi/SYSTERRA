<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->library(array('session'));

if($this->session->userdata('logueado')==FALSE) header("Location:".base_url());
?>
<!DOCTYPE html>
<html>
	<head>
        <title><?php echo $nombreopcion;?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		  <link rel="icon" href="<?php echo base_url();?>assets/imagenes/terra.ico" type="image/icon">
		  <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
		  <link href="<?php echo base_url(); ?>assets/css/bootstrap.css" rel="stylesheet">
		  <!--<link href="<?php //echo base_url(); ?>assets/css/alert/sweet-alert.css" rel="stylesheet">-->
		  <link href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		  <link href="<?php echo base_url(); ?>assets/js/jquery-ui-1.12.1/jquery-ui.css" rel="stylesheet"> 
		  <link href="<?php echo base_url(); ?>assets/js/jquery-ui-1.12.1/jquery-ui.structure.css" rel="stylesheet"> 
		  <link href="<?php echo base_url(); ?>assets/js/jquery-ui-1.12.1/jquery-ui.theme.css" rel="stylesheet"> 
		  <link href="<?php echo base_url(); ?>assets/js/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet">
		  
		  <!--<link rel="stylesheet" href="<?php //echo base_url(); ?>assets/materialize/css/materialize.min.css">-->
		  <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.js"> </script>
		  <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap.js"> </script>
		  <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"> </script>
		  <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"> </script>
		  <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/blockUI.js"> </script>
		  <!--<script type="text/javascript" src="<?php //echo base_url(); ?>assets/js/alert/sweet-alert.js"> </script>-->
		  <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/alert/sweetalert2.min.js"> </script>
		  <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.uitablefilter.js"> </script>
		  <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-ui-1.12.1/jquery-ui.js"> </script>
		  <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.numeric.js"> </script>
		  <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
		  <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js"></script>
		  <!--<script src="<?php //echo base_url(); ?>assets/materialize/js/materialize.min.js"></script>-->
          
	</head>
	<style type="text/css">
		@font-face {
		font-family:'Shadows Into Light';
		src: url("<?php echo base_url();?>assets/fonts/ShadowsIntoLight.ttf")  format('truetype');
		}
	</style>
	<body>
  <!-- Menu principal start-->
	<section class="container">
	    <div class="row">
				    <header>

							<nav class="navbar navbar-inverse">
							  <div class="container-fluid">
							    <div class="navbar-header">
							      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
							        <span class="icon-bar"></span>
							        <span class="icon-bar"></span>
							        <span class="icon-bar"></span>                        
							      </button>
							      <a style="font-family:'Shadows Into Light';" class="navbar-brand" href="<?php echo base_url(); ?>MenuCont/index"><b>Terra System</b></a>
							    </div>
							    <div class="collapse navbar-collapse" id="myNavbar">
							      <ul class="nav navbar-nav">
							        	<?php
							        		echo $opciones;
							        	 
							        	?>
							      </ul>
							     	<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
							     	<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
							     	<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
							        <li><a href="#"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;<span  style=" text-align: right; color:white;"><?php echo " Usuario: ". $usuario; ?></span></a></li>
							        <li><a href="<?php echo base_url(); ?>loginAjax/logout"><span class="glyphicon glyphicon-log-in"></span> Salir</a></li>
							   
							    </div>
							  </div>
							</nav>

 					</header>
			</div>

   </section>

