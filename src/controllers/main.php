<?php 
require_once 'navbar.php';
require_once 'mensajeInicio.php';
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
		$periodo = $navbar->periodoActivo();

		$this->view->usuario = $usuario;
		$this->view->navbarMaterias = $navbarMaterias;
		$this->view->periodo = $periodo;


		if ($usuario['user'] === 'profesor' ){
			$datos = [
				'periodo' => $navbarMaterias[0][4],
				'educacion' => $navbarMaterias[0][5],
				'grado' => $navbarMaterias[0][3],
				'seccion' =>$navbarMaterias[0][6]
			];
		}elseif ($usuario['user'] === 'alumno') {
			$datos = [
				'periodo' => $navbarMaterias[0][4],
				'educacion' => $navbarMaterias[0][6],
				'grado' => $navbarMaterias[0][3],
				'seccion' =>$navbarMaterias[0][7]
			];
		}

		$mensajes = $this->model->getMensajes($datos);
		$this->view->mensajes = $mensajes;

		$this->view->render('main/index');
	}

	public function saludo()
	{

		echo "<p>ME SALUDASTE</p>";
		$this->model->buscar();
	}
}

?>