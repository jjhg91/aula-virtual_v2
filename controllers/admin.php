<?php 
require_once 'navbar.php';
/**
 * 
 */
class Admin extends Controller
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function render()
	{
		$this->view->render('admin/index');
	}

	public function login()
	{
		$sesion = new Sesion();
		
		$user = $_POST['user'];
		$pass = $_POST['pass'];
		$level = 'admin';
		$datosModel = [
			'user'  => $user,
			'pass'  => $pass,
			'level' => $level
		];
		if ( $user === 'admin-uepjmc' && $pass === '21151272' ) {
			$datosSesion = [
				'admin',
				88888888,
				88888888,
				'ADMINISTRADOR',
				1
			];
		$sesion->setSesion($datosSesion);
		
		header("location: " . constant('URL') . 'admin/inicio');

		}else{
		echo "ERROR AL HACER LOGIN";
		}

	}

	public function inicio()
	{
		$sesion = new Sesion();
		$sesion->validateSesion();
		$usuario = $sesion->getSesion();
		
		$navbar = new Navbar($usuario);
		$navbarMaterias = $navbar->navbarMaterias($usuario);
		$this->view->usuario = $usuario;
		$this->view->navbarMaterias = $navbarMaterias;

		$this->view->render('admin/inicio');

		
	}

	public function periodo($url = null)
	{
		
		$sesion = new Sesion();
		$sesion->validateSesion();
		$usuario = $sesion->getSesion();
		
		$navbar = new Navbar($usuario);
		$navbarMaterias = $navbar->navbarMaterias($usuario);
		$this->view->usuario = $usuario;
		$this->view->navbarMaterias = $navbarMaterias;
		$respuesta = ['status' => false, 'respuesta' => "", 'json' => ""];

		switch ( $_SERVER['REQUEST_METHOD'] ) {
			case 'GET':
				$paginaActual = 1;
				$totalPaginas;
				$nResultados;
				$resultadosPorPagina  = 10;
				$indice = 0;

				$nResultados = $this->model->totalPeriodos()['total'];

				$totalPaginas = ceil($nResultados / $resultadosPorPagina);
				
				if ( !isset($url[0]) || $url[0] === '0' ) {
					$url[0] = 1;
				}
					if ( is_numeric($url[0]) ) {
						if ( $url[0] >= 1 && $url[0] <= $totalPaginas || empty($nResultados)) {
							$paginaActual = $url[0];
							$indice =(($paginaActual - 1) * $resultadosPorPagina);
							
							$getPeriodos = $this->model->getPeriodos($indice,$resultadosPorPagina);
							$this->view->periodos = $getPeriodos;
							$this->view->paginaActual = $paginaActual;
							$this->view->totalPaginas = $totalPaginas;
							$this->view->render('admin/periodo');

						}else{
							echo 'No existe la pagina';
						}
					}else{
						echo 'Error al mostrar la pagina';
					}
				
				break;

			case 'POST':
					// DATOS DE FORMULARIO
					$periodo = $_POST['add__periodo'];
					$lapso = $_POST['add__lapso'];
					$estatus = $_POST['add__estatus'];
					$datos = [
						'periodo' => $periodo,
						'lapso' => $lapso,
						'estatus' => $estatus
					];
					$insert = $this->model->addPeriodo($datos);
					if ( $insert ) {
						$getPeriodo = $this->model->getPeriodo($datos);
						$respuesta['status'] = true;
						$respuesta['respuesta'] = "PERIODO AGREGADO EXITOSAMENTE";
						$respuesta['json'] = [
							'id' => $getPeriodo['id_periodo'],
							'periodo' => $getPeriodo['periodo'],
							'lapso' => $getPeriodo['lapso'],
							'estatus' => $getPeriodo['status']
						];
					}else {
						$respuesta['status'] = false;
						$respuesta['respuesta'] = "ERROR AL AGREGAR PERIODO";
						
					}
					echo json_encode($respuesta);
				break;

			case 'PUT':
					// DATOS DEL FORMULARIO
					$_PUT = json_decode(file_get_contents('php://input'),true);
					$a = gettype($_PUT);
					$id_periodo = (int)$url[0];

					$periodo = $_PUT['edit__periodo'];
					$lapso = (int)$_PUT['edit__lapso'];
					$estatus = (int)$_PUT['edit__estatus'];
					$datos = [
						'id_periodo' => $id_periodo,
						'periodo' => $periodo,
						'lapso' => $lapso,
						'estatus' => $estatus
					];
					$update = $this->model->updatePeriodo($datos);
					if ( $update ) {
						$getPeriodo = $this->model->getPeriodo($datos);
						$respuesta['status'] = true;
						$respuesta['respuesta'] = "EL PERIODO FUE ADITADA EXITOSAMENTE";
						$respuesta['json'] = [
							'id' => $getPeriodo['id_periodo'],
							'periodo' => $getPeriodo['periodo'],
							'lapso' => $getPeriodo['lapso'],
							'estatus' => $getPeriodo['status']
						];

					}else{
						$respuesta['status'] = false;
						$respuesta['respuesta'] = "ERROR AL EDITAR PERIODO";
					}
					echo json_encode($respuesta);
				break;

			case 'DELETE':

					$periodo = $url[0];
					$eliminar = $this->model->deletePeriodo($periodo);

					if ( $eliminar ) {
						$respuesta['status'] = true;
						$respuesta['respuesta'] = "El periodo numero id ".$periodo." a sido eliminado";
					}else{
						$respuesta['status'] = false;
						$respuesta['respuesta'] = "Error al intentar eliminar el contenido periodo ".$periodo;
					}

					echo json_encode($respuesta);
				break;
		}

		
	}



	// PROFESOR GESTIONAR LOS PROFESORED CRUD

	public function profesor($url = null)
	{
		
		$sesion = new Sesion();
		$sesion->validateSesion();
		$usuario = $sesion->getSesion();
		
		$navbar = new Navbar($usuario);
		$navbarMaterias = $navbar->navbarMaterias($usuario);
		$this->view->usuario = $usuario;
		$this->view->navbarMaterias = $navbarMaterias;
		$respuesta = ['status' => false, 'respuesta' => "", 'json' => ""];

		switch ( $_SERVER['REQUEST_METHOD'] ) {
			case 'GET':
				$paginaActual = 1;
				$totalPaginas;
				$nResultados;
				$resultadosPorPagina  = 10;
				$indice = 0;

				$nResultados = ($this->model->totalProfesores() === true)? $this->model->totalProfesores()['total'] : null ;


				$totalPaginas = ceil($nResultados / $resultadosPorPagina);
				
				if ( !isset($url[0]) || $url[0] === '0' ) {
					$url[0] = 1;
				}
					if ( is_numeric($url[0]) ) {
						if ( $url[0] >= 1 && $url[0] <= $totalPaginas || empty($nResultados) ) {
							$paginaActual = $url[0];
							$indice =(($paginaActual - 1) * $resultadosPorPagina);
							
							$getProfesores = $this->model->getProfesores($indice,$resultadosPorPagina);
							$this->view->profesores = $getProfesores;
							$this->view->paginaActual = $paginaActual;
							$this->view->totalPaginas = $totalPaginas;
							$this->view->render('admin/profesor');

						}else{
							echo 'No existe la pagina';
						}
					}else{
						echo 'Error al mostrar la pagina';
					}


				
				break;

			case 'POST':
					// DATOS DE FORMULARIO
					$cedula = $_POST['add__cedula'];
					$nombre = $_POST['add__nombre'];
					$email = $_POST['add__email'];
					$tlf = $_POST['add__tlf'];
					$datos = [
						'cedula' => $cedula,
						'nombre' => $nombre,
						'email' => $email,
						'tlf' => $tlf
					];
					
					if( $this->model->getProfesor($datos) ) {
						$insert = null;
					}else{
						$insert = $this->model->addProfesor($datos);
					}

					if ( $insert ) {
						$getProfesor = $this->model->getProfesor($datos);
						$respuesta['status'] = true;
						$respuesta['respuesta'] = "PROFESOR AGREGADO EXITOSAMENTE";
						$respuesta['json'] = [
							'id' => $getProfesor['id_personal'],
							'cedula' => $getProfesor['cedu_pers'],
							'nombre' => $getProfesor['nombres'],
							'email' => $getProfesor['email'],
							'tlf' => $getProfesor['tlf']
						];
					}else {
						$respuesta['status'] = false;
						$respuesta['respuesta'] = "ERROR AL AGREGAR PROFESOR O CEDULA YA USADA";
					}
					echo json_encode($respuesta);
				break;

			case 'PUT':
					// DATOS DEL FORMULARIO
					$_PUT = json_decode(file_get_contents('php://input'),true);
					$id_profesor = (int)$url[0];

					$cedula = $_PUT['edit__cedula'];
					$nombre = $_PUT['edit__nombre'];
					$email = $_PUT['edit__email'];
					$tlf = ((int)$_PUT['edit__tlf'] === 0 )? "": (int)$_PUT['edit__tlf'] ;

					$datos = [
						'id' => $id_profesor,
						'cedula' => $cedula,
						'nombre' => $nombre,
						'email' => $email,
						'tlf' => $tlf
					];
					$update = $this->model->updateProfesor($datos);
					if ( $update ) {
						$getProfesor = $this->model->getProfesor($datos);
						$respuesta['status'] = true;
						$respuesta['respuesta'] = "EL PROFESOR FUE ADITADA EXITOSAMENTE";
						$respuesta['json'] = [
							'id' => $getProfesor['id_personal'],
							'cedula' => $getProfesor['cedu_pers'],
							'nombre' => $getProfesor['nombres'],
							'email' => $getProfesor['email'],
							'tlf' => $getProfesor['tlf']
						];

					}else{
						$respuesta['status'] = false;
						$respuesta['respuesta'] = "ERROR AL EDITAR PROFESOR";
					}
					echo json_encode($respuesta);
				break;

			case 'DELETE':

					$profesor = $url[0];
					$eliminar = $this->model->deleteProfesor($profesor);
					if ( $eliminar ) {
						$respuesta['status'] = true;
						$respuesta['respuesta'] = "El profesor numero id ".$profesor." a sido eliminado";
					}else{
						$respuesta['status'] = false;
						$respuesta['respuesta'] = "Error al intentar eliminar el contenido profesor ".$profesor;
					}

					echo json_encode($respuesta);
				break;
		}

		
	}

	// GESTION Y APERTURA DE GRADO 
	public function grado($url = null)
	{
		
		$sesion = new Sesion();
		$sesion->validateSesion();
		$usuario = $sesion->getSesion();
		
		$navbar = new Navbar($usuario);
		$navbarMaterias = $navbar->navbarMaterias($usuario);
		$this->view->usuario = $usuario;
		$this->view->navbarMaterias = $navbarMaterias;
		$respuesta = ['status' => false, 'respuesta' => "", 'json' => ""];

		switch ( $_SERVER['REQUEST_METHOD'] ) {
			case 'GET':
				$paginaActual = 1;
				$totalPaginas;
				$nResultados;
				$resultadosPorPagina  = 10;
				$indice = 0;

				$nResultados = ($this->model->totalGrados() === true)? $this->model->totalGrados()['total'] : null ;

			
				$totalPaginas = ceil($nResultados / $resultadosPorPagina);
				
				if ( !isset($url[0]) || $url[0] === '0' ) {
					$url[0] = 1;
				}
					if ( is_numeric($url[0]) ) {
						if ( ($url[0] >= 1 && $url[0] <= $totalPaginas)|| empty($nResultados) ) {
							$paginaActual = $url[0];
							$indice =(($paginaActual - 1) * $resultadosPorPagina);
							
							$getGrados = $this->model->getGrados($indice,$resultadosPorPagina);
							$this->view->grados = $getGrados;
							$this->view->paginaActual = $paginaActual;
							$this->view->totalPaginas = $totalPaginas;
							
							$this->view->gradoEducacion = $this->model->getGradoEspecialidad();
							$this->view->secciones = $this->model->getSeccion();
							$this->view->periodos = $this->model->getPeriodos(0,20);
							$this->view->render('admin/grado');

						}else{
							echo 'No existe la pagina';
						}
					}else{
						echo 'Error al mostrar la pagina';
					}


				
				break;

			case 'POST':
					// DATOS DE FORMULARIO
					$grado = $_POST['add__grado'];
					$seccion = $_POST['add__seccion'];
					$periodo = $_POST['add__periodo'];
					$datos = [
						'grado' => $grado,
						'seccion' => $seccion,
						'periodo' => $periodo
					];
					
					if( $this->model->getGradoSeccion($datos) ) {
						$insert = null;
					}else{
						$insert = $this->model->addGrado($datos);
					}

					if ( $insert ) {
						$getGradoSeccion = $this->model->getGradoSeccion($datos);
						$respuesta['status'] = true;
						$respuesta['respuesta'] = "GRADO Y SECCION CREADO EXITOSAMENTE";
						$respuesta['json'] = [
							'id' => $getGradoSeccion['id_profesorcursogrupo'],
							'educacion' => $getGradoSeccion['descripcion'],
							'grado' => $getGradoSeccion['especial'],
							'seccion' => $getGradoSeccion['seccion'],
							'periodo' => $getGradoSeccion['periodo']
						];
					}else {
						$respuesta['status'] = false;
						$respuesta['respuesta'] = "ERROR AL CREAR GRADO Y SCCION O YA ESTA CREADO";
					}
					echo json_encode($respuesta);
				break;

			case 'DELETE':

					$_DELETE = json_decode(file_get_contents('php://input'),true);

					$grado = $_DELETE['delete__grado'];
					$seccion = $_DELETE['delete__seccion'];
					$periodo = $_DELETE['delete__periodo'];

					$datos = [
						'grado' => $grado,
						'seccion' => $seccion,
						'periodo' => $periodo
					];

					$eliminar = $this->model->deleteGRado($datos);
					if ( $eliminar ) {
						$respuesta['status'] = true;
						$respuesta['respuesta'] = "EL GRADO A SIDO ELIMINADO";
					}else{
						$respuesta['status'] = false;
						$respuesta['respuesta'] = "ERROR AL INTENTAR ELIMINAR GRADO ";
					}

					echo json_encode($respuesta);
				break;
		}
	}


	// ASIGNATURA MUESTRA LAS MATERIAS Y SE ASIGNAN MATERIAS A LOS PROFESORES

	public function asignatura($url = null)
	{
		
		$sesion = new Sesion();
		$sesion->validateSesion();
		$usuario = $sesion->getSesion();
		
		$navbar = new Navbar($usuario);
		$navbarMaterias = $navbar->navbarMaterias($usuario);
		$this->view->usuario = $usuario;
		$this->view->navbarMaterias = $navbarMaterias;
		$respuesta = ['status' => false, 'respuesta' => "", 'json' => ""];

		switch ( $_SERVER['REQUEST_METHOD'] ) {
			case 'GET':
				$paginaActual = 1;
				$totalPaginas;
				$nResultados;
				$resultadosPorPagina  = 10;
				$indice = 0;

				$nResultados = $this->model->totalAsignaturas()['total'];

				$totalPaginas = ceil($nResultados / $resultadosPorPagina);
				
				if ( !isset($url[0]) || $url[0] === '0' ) {
					$url[0] = 1;
				}
					if ( is_numeric($url[0]) ) {
						if ( $url[0] >= 1 && $url[0] <= $totalPaginas || empty($nResultados) ) {
							$paginaActual = $url[0];
							$indice =(($paginaActual - 1) * $resultadosPorPagina);
							
							$getAsignaturas = $this->model->getAsignaturas($indice,$resultadosPorPagina);
							$this->view->asignaturas = $getAsignaturas;
							$this->view->paginaActual = $paginaActual;
							$this->view->totalPaginas = $totalPaginas;
							$this->view->render('admin/asignatura');

						}else{
							echo 'No existe la pagina';
						}
					}else{
						echo 'Error al mostrar la pagina';
					}


				
				break;

			case 'PUT':
					// DATOS DEL FORMULARIO
					$_PUT = json_decode(file_get_contents('php://input'),true);
					
					$id_asignatura = (int)$url[0];
					$cedula = $_PUT['edit__cedula'];

					$datos = [
						'id' => $id_asignatura,
						'cedula' => $cedula
					];

					$update = $this->model->updateMateriaProfesor($datos);

					if ( $update ) {
						$getProfesor = $this->model->getProfesor($datos);
						$respuesta['status'] = true;
						$respuesta['respuesta'] = "LA MATERIA FUE ASIGNADA AL PROFESOR EXITOSAMENTE";
						$respuesta['json'] = [
							'id_asignatura' => $id_asignatura,
							'id_profesor' => $getProfesor['id_personal'],
							'cedula' => $getProfesor['cedu_pers'],
							'nombre' => $getProfesor['nombres']
						];

					}else {
						$respuesta['status'] = false;
						$respuesta['respuesta'] = "ERROR AL ASIGNAR LA MATERIA AL PROFESOR ";
					}
					echo json_encode($respuesta);
				break;

		}
	}

	//// GESTION DE ALUMNOS 

	public function alumno($url = null)
	{
		
		$sesion = new Sesion();
		$sesion->validateSesion();
		$usuario = $sesion->getSesion();
		
		$navbar = new Navbar($usuario);
		$navbarMaterias = $navbar->navbarMaterias($usuario);
		$this->view->usuario = $usuario;
		$this->view->navbarMaterias = $navbarMaterias;
		$respuesta = ['status' => false, 'respuesta' => "", 'json' => ""];

		switch ( $_SERVER['REQUEST_METHOD'] ) {
			case 'GET':
				$paginaActual = 1;
				$totalPaginas;
				$nResultados;
				$resultadosPorPagina  = 10;
				$indice = 0;

				$nResultados = $this->model->totalAlumnos()['total'];

				$totalPaginas = ceil($nResultados / $resultadosPorPagina);
				
				if ( !isset($url[0]) || $url[0] === '0' ) {
					$url[0] = 1;
				}
					if ( is_numeric($url[0]) ) {
						if ( $url[0] >= 1 && $url[0] <= $totalPaginas || empty($nResultados)) {
							$paginaActual = $url[0];
							$indice =(($paginaActual - 1) * $resultadosPorPagina);
							
							$getAlumnos = $this->model->getAlumnos($indice,$resultadosPorPagina);
							$this->view->alumnos = $getAlumnos;
							$this->view->paginaActual = $paginaActual;
							$this->view->totalPaginas = $totalPaginas;
							$this->view->render('admin/alumno');

						}else{
							echo 'No existe la pagina';
						}
					}else{
						echo 'Error al mostrar la pagina';
					}
				
				break;

			case 'POST':
					// DATOS DE FORMULARIO
					$cedula = $_POST['add__cedula'];
					$nombre = $_POST['add__nombre'];
					$apellido = $_POST['add__apellido'];
					$email = $_POST['add__email'];
					$tlf = $_POST['add__tlf'];
					$representante = $_POST['add__representante'];

					$datos = [
						'cedula' => $cedula,
						'nombre' => $nombre,
						'apellido' => $apellido,
						'email' => $email,
						'tlf' => $tlf,
						'representante' => $representante
					];


					if( $this->model->getAlumno($datos) ) {
						$insert = null;
					}else{
						$insert = $this->model->addAlumno($datos);
					}


					if ( $insert ) {
						$getAlumno = $this->model->getAlumno($datos);
						$respuesta['status'] = true;
						$respuesta['respuesta'] = "PERIODO AGREGADO EXITOSAMENTE";
						$respuesta['json'] = [
							'id' => $getAlumno['id_estudia'],
							'nombre' => $getAlumno['p_nombres'],
							'apellido' => $getAlumno['p_apellido'],
							'email' => $getAlumno['email'],
							'tlf' => $getAlumno['tlf1'],
							'representante' => $getAlumno['representante']
						];
					}else {
						$respuesta['status'] = false;
						$respuesta['respuesta'] = "ERROR AL AGREGAR PERIODO";
						
					}
					echo json_encode($respuesta);
				break;

			case 'PUT':
					// DATOS DEL FORMULARIO
					$_PUT = json_decode(file_get_contents('php://input'),true);
					$a = gettype($_PUT);
					$id_estudia = (int)$url[0];

					$cedula = $_PUT['edit__cedula'];
					$nombre = $_PUT['edit__nombre'];
					$apellido = $_PUT['edit__apellido'];
					$email = $_PUT['edit__email'];
					$tlf = $_PUT['edit__tlf'];
					$representante = $_PUT['edit__representante'];

					$datos = [
						'id_estudia' => $id_estudia,
						'cedula' => $cedula,
						'nombre' => $nombre,
						'apellido' => $apellido,
						'email' => $email,
						'tlf' => $tlf,
						'representante' => $representante
					];
					
					$update = $this->model->updateAlumno($datos);
					
					if ( $update ) {
						$getAlumno = $this->model->getAlumno($datos);
						$respuesta['status'] = true;
						$respuesta['respuesta'] = "EL PERIODO FUE ADITADA EXITOSAMENTE";
						$respuesta['json'] = [
							'id' => $getAlumno['id_estudia'],
							'cedula' => $getAlumno['cedula'],
							'nombre' => $getAlumno['p_nombres'],
							'apellido' => $getAlumno['p_apellido'],
							'email' => $getAlumno['email'],
							'tlf' => $getAlumno['tlf1'],
							'representante' => $getAlumno['representante']
						];

					}else{
						$respuesta['status'] = false;
						$respuesta['respuesta'] = "ERROR AL EDITAR PERIODO";
					}
					echo json_encode($respuesta);
				break;

			case 'DELETE':

					$alumno = $url[0];
					$eliminar = $this->model->deleteAlumno($alumno);

					if ( $eliminar ) {
						$respuesta['status'] = true;
						$respuesta['respuesta'] = "EL ALUMNO A SIDO ELIMINADO EXITOSAMENTE";
					}else{
						$respuesta['status'] = false;
						$respuesta['respuesta'] = " ERROR AL INTENTAR ELIMINAR EL ALUMNO";
					}

					echo json_encode($respuesta);
				break;
		}

		
	}

}

?>