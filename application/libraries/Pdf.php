<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';

class Pdf extends TCPDF
{
	private $ci;
    public function __construct()
    {
    	
        parent::__construct();
        $this->ci =& get_instance();
        !$this->ci->load->library('session') ? $this->ci->load->library('session') : false;

    }


public function Footer() {
		//$this->load->library(array('session'));
		$usuario=$this->ci->session->userdata('usuario');
	 	$idusuario=$this->ci->session->userdata('id_usuario');
			$this->SetY(-10);
		// Set font
		$this->SetFont('helvetica', 'I', 6);
		// Position at 15 mm from bottom
		//$this->SetY(-20);
		// Set font
	   //$this->SetFont('helvetica', 'I', 6);
		// Page number
		/*require_once('model/class.seguridad.php');
		$seguridad = new seguridad(); 
		$fechaSistema = $seguridad->fechaSistema();
        $fecha= date("d-M-Y H:i:s",strtotime(date("d-M-Y H:i:s",strtotime($fechaSistema))));  */
	  // $this->Cell(0, 6, 'Generado por ['.$_SESSION['lzentidad'].'-'.$_SESSION['nombreusuario'].' el '.$fecha.'] desde el sistema WebLiztex', 0, false, 'C', 0, '', 0, false, 'T', 'M');
         $this->Cell(0, 2, 'Generado por '.$usuario. ' desde Terra System', 0, false, 'C', 0, '', 0, false, 'T', 'M');
	}
}

?>