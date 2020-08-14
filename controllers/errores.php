<?php 
/**
 * 
 */
class Errores extends Controller
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function render()
	{
		$this->view->mensaje = "Hubo un error en la solicitud o no existe la página";
		$this->view->render('errores/index');
	}
}
?>