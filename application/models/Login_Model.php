<?php  
Class Login_Model extends CI_Model {

	 public function __construct() {
	 parent::__construct();
	 }

	Public function GetUser($usuario,$password){
		$response = array(
		    'status' => 400,
		    'message' => '',
		    'data' => '',
		);
		// realiza consulta de usuario
		$this->db->where('codigo',$usuario);
		$this->db->where('clave',$password);
		$result= $this->db->get('dbs_usuario');
		$users=$result->result_array();
		//-------------------
		if ($result->num_rows()>0){
		  $response['status']=200;
		  $response['data']=$users;
		// busca las opciones asociadas a este usuario
		 $this->db->select('id_submenu, trim(nombre) as descriparea');
		 $this->db->from('dbs_submenu');
		 $this->db->order_by('id_submenu','ASC');
		 $opciones=$this->db->get()->result_array();
		 //---------------Iniciando armar el menu dinamico --------------------------
		  $identificador=0;
		  $rp='';
		  $sigvalor=0;
		  $iterracion=1;
		  //print_r($opciones);
		  foreach ($opciones as $op) {
			  	if($identificador==0 ){ // encabezado de Menu
			  		$rp.= '<li class="dropdown">
			  			   		<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">'.$op['descriparea'].' 
			  			     		<span class="caret"></span></a>
			  			     		<ul class="dropdown-menu">';
			  			     		$identificador=1;
			  	}else{
			  		$rp.= '</ul>
			  				</li>
			  			</li>
			  			<li class="dropdown">
			  			   		<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">'.$op['descriparea'].' 
			  			     		<span class="caret"></span></a>
			  			     		<ul class="dropdown-menu">';
			  	}
			  			// busca las opciones asociadas a este usuario
				 $this->db->select('	a.codigo,d.id_opcion AS codigoopcion,d.nombre AS descripopcion,d.fuente AS ejecutable,f.id_submenu as area, f.nombre as descriparea');
				 $this->db->from('dbs_usuario a');
				 $this->db->join('dbs_usuarioper b','b.id_usuario = a.id_usuario and b.id_estadop = 1','inner');
				 $this->db->join('dbs_perfilopc c','c.id_perfil = b.id_perfil and c.id_estadoop = 1','inner');
				 $this->db->join('dbs_opcion d','d.id_opcion = c.id_opcion and d.id_estadoop = 1','inner');
				 $this->db->join('dbs_sistema e','e.id_sistema = d.id_sistema','inner');
				 $this->db->join('dbs_submenu f','f.id_submenu=d.id_submenu','inner');
				 $this->db->where('a.codigo',$usuario);
				 $this->db->where('f.id_submenu',$op['id_submenu']);
				 $this->db->order_by('d.nombre','ASC');
				 $submenus=$this->db->get()->result_array();
				 foreach ($submenus as $lis) {
				 	$rp.= '<li>
		  			     		    <a href='.base_url().$lis["ejecutable"].'>'.$lis['descripopcion'].'</a>
		  			   			 </li>';
				 }
			  }


//--------------------------------------------------------------------
		  //print_r($rp); exit;
		 // agregando los datos de usuario para session 
		  $usuario_data = array(
			   'id_usuario' => $users[0]['id_usuario'],
			   'nombre' => $users[0]['nombre'],
			   'empresa' => $users[0]['id_empresa'],
			   'usuario' =>'['.$users[0]['codigo'].'] - '. $users[0]['nombre'],
			   'menu' => $rp,
			   'logueado' => TRUE
		  );
		  $this->session->set_userdata($usuario_data);
		  return $response;
		}else{
		 	$response['status']=401;
		 	$response['message']='Usuario no Encontrado o Datos mal Ingresados';
		 	$response['data']='';
		 	return $response;
		}
	}

	
	
}

?>