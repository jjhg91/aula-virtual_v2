<?php 
require_once 'navbar.php';
/**
 * 
 */
class Main extends Controller
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function render()
	{
		$sesion = new Sesion();
		$sesion->validateSesion();
		$usuario = $sesion->getSesion();
		
		$navbar = new Navbar($usuario);
		$navbarMaterias = $navbar->navbarMaterias($usuario);
		$this->view->usuario = $usuario;
		$this->view->navbarMaterias = $navbarMaterias;

		$this->view->render('main/index');
	}

	public function saludo()
	{

		echo "<p>ME SALUDASTE</p>";
		$this->model->buscar();
	}
}

?>