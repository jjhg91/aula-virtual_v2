<?php

require_once 'models/navbarmodel.php';

/**
 * 
 */
class Navbar extends Controller
{

	function __construct()
	{
		parent::__construct();	
	}



	public function navbarMaterias($usuario)
	{
		$navbarmodel = new NavbarModel();
		if ( $usuario['user'] == 'alumno') {
			$respuesta = $navbarmodel->navbarMateriasAlumno($usuario['id']);
			$_SESSION['nivel'] = $respuesta[0][6];
			
		}elseif ( $usuario['user'] == 'profesor' ) {
			$respuesta = $navbarmodel->navbarMateriasProfesor($usuario['id']);
			$_SESSION['nivel'] = $respuesta[0][5];
		}elseif ($usuario['user'] === 'admin') {
			$respuesta = [];
		}

		return $respuesta;
	}

	public function barMateria($usuario,$materia)
	{
		$navbarmodel = new NavbarModel();
		if ( $usuario['user'] == 'alumno') {
			$respuesta = $navbarmodel->barMateriaAlumno($usuario['id'],$materia);
		}elseif ( $usuario['user'] == 'profesor' ) {
			$respuesta = $navbarmodel->barMateriaProfesor($usuario['id'],$materia);
		}
		return $respuesta;
	}
}
?>