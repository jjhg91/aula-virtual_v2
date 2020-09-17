<?php
require_once 'navbar.php';
/**
 *
 */
class Alumno extends Controller
{
	function __construct()
	{
		parent::__construct();
	}

	public function render()
	{
		echo 'alumno';
	}

	public function all($materia)
	{
		$sesion = new Sesion();
		$sesion->validateSesion();
		$usuario = $sesion->getSesion();

		$navbar = new Navbar($usuario);
		$navbarMaterias = $navbar->navbarMaterias($usuario);

		$this->view->usuario = $usuario;
		$this->view->navbarMaterias = $navbarMaterias;


		if (  ctype_digit($materia[0]) ) {

			$barMateria = $navbar->barMateria($usuario,$materia[0]);
			if ($barMateria) {
				$this->view->barMateria = $barMateria;
				$alumnos = $this->model->getAlumnos($materia[0]);

				$this->view->alumnos = $alumnos;
				$this->view->render('alumno/index');

			}else{
				echo "MATERIA NO VALIDA O NO INSCRITA";
			}


		}else{
			echo "DIRECCION URL INVALIDA";
			exit;
		}

	}

}

?>