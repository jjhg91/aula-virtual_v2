<?php
require_once 'navbar.php';
/**
 *
 */
class Foro extends Controller
{

	function __construct()
	{
		parent::__construct();
	}

	public function render()
	{
		echo 'Foro';
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
				$temas = $this->model->getTemas($materia[0]);
				$this->view->temas = $temas;
				$this->view->render('foro/index');

			}else{
				echo "MATERIA NO VALIDA O NO INSCRITA";
			}


		}else{
			echo "DIRECCION URL INVALIDA";
			exit;
		}
	}

	public function detail($url)
	{
		$sesion = new Sesion();
		$sesion->validateSesion();
		$usuario = $sesion->getSesion();

		$navbar = new Navbar($usuario);
		$navbarMaterias = $navbar->navbarMaterias($usuario);

		$this->view->usuario = $usuario;
		$this->view->navbarMaterias = $navbarMaterias;


		if (  ctype_digit($url[0]) && ctype_digit($url[1]) ) {

			$barMateria = $navbar->barMateria($usuario,$url[0]);
			if ($barMateria) {
				if ( $url[1] == 0) {
					$posts = $this->model->getPostsGeneral($url[0]);
				}elseif ( $url[1] > 0 ) {
					$posts = $this->model->getPosts($url[0],$url[1]);
				}
				$this->view->foro = $url[1];
				$this->view->barMateria = $barMateria;
				$this->view->posts = $posts;
				$this->view->render('foro/detail');

			}else{
				echo "MATERIA NO VALIDA O NO INSCRITA";
			}


		}else{
			echo "DIRECCION URL INVALIDA";
			exit;
		}

	}

	public function deleteForo($url)
	{
		$materia = $url[0];
		$foro = $url[1];

		$sesion = new Sesion();
		$sesion->validateSesion();
		$usuario = $sesion->getSesion();
		$respuesta = ['status' => false, 'respuesta' => ""];

		if (  ctype_digit($materia) && ctype_digit($foro) ) {
			$navbar = new Navbar($usuario);
			$barMateria = $navbar->barMateria($usuario,$materia);
			if ($barMateria) {
				$eliminar = $this->model->deleteForo($materia, $foro);
				if ( $eliminar ) {
					$respuesta['status'] = true;
					$respuesta['respuesta'] = "EL FORO SE A ELIMINADO EXITOSAMENTE";
				}else{
					$respuesta['status'] = false;
					$respuesta['respuesta'] = "ERROR AL ELIMINAR CONTENIDO";
				}
			}else{
				$respuesta['status'] = false;
				$respuesta['respuesta'] = "MATERIA NO VALIDA O NO INSCRITA";
			}

		}else{
			$respuesta['status'] = false;
			$respuesta['respuesta'] = "DIRECCION URL INVALIDA";
		}
		echo json_encode($respuesta);
	}

	public function addForo($url)
	{
		//URLS VARIABLES
		$materia = $_POST['materia'];

		$sesion = new Sesion();
		$sesion->validateSesion();
		$usuario = $sesion->getSesion();
		$respuesta = ['status' => false, 'respuesta' => "", 'idForo' => ""];

		if (  ctype_digit($materia) ) {
			$navbar = new Navbar($usuario);
			$barMateria = $navbar->barMateria($usuario,$materia);
			if ($barMateria) {
				// DATOS DE FORMULARIO
				$titulo = $_POST['titulo'];
				$descripcion = $_POST['descripcion'];

				$datos = [
					'materia' => $materia,
					'titulo' => $titulo,
					'descripcion' => $descripcion
				];
				$insert = $this->model->addForo($datos);

				if ( $insert ) {
					$idForo = $this->model->getIdTema($datos);

					$respuesta['status'] = true;
					$respuesta['respuesta'] = "FORO CREADO EXITOSAMENTE";
					$respuesta['idForo'] = $idForo;
				}


			}else{
				$respuesta['status'] = false;
				$respuesta['respuesta'] = "MATERIA NO VALIDA O NO INSCRITA";
			}

		}else{
			$respuesta['status'] = false;
			$respuesta['respuesta'] = "DIRECCION URL INVALIDA";
		}
		
		echo json_encode($respuesta);
	}

	public function addPost($url)
	{
		//URLS VARIABLES
		$materia = (int)$_POST['materia'];
		$tem = (int)$_POST['foro'];

		$sesion = new Sesion();
		$sesion->validateSesion();
		$usuario = $sesion->getSesion();
		$respuesta = ['status' => false, 'respuesta' => "",'idPost' => "", 'fecha' => ""];

		if (  is_int($materia) && is_int($tem) ) {
			$navbar = new Navbar($usuario);
			$barMateria = $navbar->barMateria($usuario,$materia);
			if ($barMateria) {
				// DATOS DE FORMULARIO
				$mensaje = $_POST['message'];
				$user = $usuario['id'];
				$level = $usuario['user'];
				$fecha = date("m-d-Y",time());
				if ( $tem == 0 ) {
					$tema = null;
				}else{
					$tema = $tem;
				}

				$datos = [
					'materia' => $materia,
					'mensaje' => $mensaje,
					'usuario' => $user,
					'level' => $level,
					'fecha' => $fecha,
					'tema' => $tema
				];
				$insert = $this->model->addPost($datos);
				$idPost = $this->model->getIdPost($datos);

				if ( $insert ) {
					$respuesta['status'] = true;
					$respuesta['respuesta'] = "POST AGREGADO EN EL FORO EXITOSAMENTE";
					$respuesta['idPost'] = $idPost;
					$respuesta['fecha'] = $fecha;
				}

			}else{
				$respuesta['status'] = false;
				$respuesta['respuesta'] = "MATERIA NO VALIDA O NO INSCRITA";
			}

		}else{
			$respuesta['status'] = false;
			$respuesta['respuesta'] = "DIRECCION URL INVALIDA";
		}
		echo json_encode($respuesta);
	}

	public function addRespuestaPost($url)
	{
		//URLS VARIABLES
		$materia = (int)$_POST['materia'];
		$post = (int)$_POST['post'];
		$tem = (int)$_POST['tema'];

		$sesion = new Sesion();
		$sesion->validateSesion();
		$usuario = $sesion->getSesion();
		$respuesta = ['status' => false, 'respuesta' => "", 'fecha' => ""];

		if (  is_int($materia) && is_int($post) && is_int($tem) ) {
			$navbar = new Navbar($usuario);
			$barMateria = $navbar->barMateria($usuario,$materia);
			if ($barMateria) {
				// DATOS DE FORMULARIO
				$mensaje = $_POST['message'];
				$user = $usuario['id'];
				$level = $usuario['user'];
				$fecha = date("m-d-Y",time()) ;
				if ( $tem == 0 ) {
					$tema = null;
				}else{
					$tema = $tem;
				}

				$datos = [
					'materia' => $materia,
					'mensaje' => $mensaje,
					'usuario' => $user,
					'level' => $level,
					'fecha' => $fecha,
					'tema' => $tema,
					'post' => $post
				];
				$insert = $this->model->addRespuestaPost($datos);
				// $idRespuesta = $this->model->getRespuestaPost($datos);
				if ( $insert ) {
					$respuesta['status'] = true;
					$respuesta['respuesta'] = "POST GUARDADO EXITOSAMENTE";
					$respuesta['fecha'] = $fecha;
				}


			}else{
				$respuesta['status'] = false;
				$respuesta['respuesta'] = "MATERIA NO VALIDA O NO INSCRITA";
			}

		}else{
			$respuesta['status'] = false;
			$respuesta['respuesta'] = "DIRECCION URL INVALIDA";
		}
		echo json_encode($respuesta);
	}

	public function deletePost($url)
	{
		$materia = $url[0];
		$tema = $url[1];
		$post = $url[2];

		$sesion = new Sesion();
		$sesion->validateSesion();
		$usuario = $sesion->getSesion();
		$respuesta = ['status' => false, 'respuesta' => ""];

		if (  ctype_digit($materia) && ctype_digit($post) ) {
			$navbar = new Navbar($usuario);
			$barMateria = $navbar->barMateria($usuario,$materia);
			if ($barMateria) {
				$eliminar = $this->model->deletePost($materia, $url[2]);
				if ( $eliminar ) {
					$respuesta['status'] = true;
					$respuesta['respuesta'] = "POST ELIMINADO EXITOSAMENTE";
				}else{
					$respuesta['status'] = false;
					$respuesta['respuesta'] = "ERROR AL ELIMINAR CONTENIDO";
				}
			}else{
				$respuesta['status'] = false;
				$respuesta['respuesta'] = "MATERIA NO VALIDA O NO INSCRITA";
			}
		}else{
			$respuesta['status'] = false;
			$respuesta['respuesta'] = "DIRECCION URL INVALIDA";
		}
		echo json_encode($respuesta);
	}


	public function editForo($url)
	{
		$materia = (int)$_POST['materia'];
		$foro = (int)$_POST['foro'];

		$gg = gettype($foro);
		$g = gettype($materia);

		$sesion = new Sesion();
		$sesion->validateSesion();
		$usuario = $sesion->getSesion();
		$respuesta = ['status' => false, 'respuesta' => ""];

		if (  is_int($materia) && is_int($foro) ) {
			$navbar = new Navbar($usuario);
			$barMateria = $navbar->barMateria($usuario,$materia);

			if ($barMateria) {
				// DATOS DEL FORMULARIO
				$titulo = $_POST['titulo'];
				$descripcion = $_POST['descripcion'];
				
				$datos = [
					'materia' => $materia,
					'foro' => $foro,
					'titulo' => $titulo,
					'descripcion' => $descripcion
				];
				
				$editar = $this->model->editForoTema($datos);
				
				if ( $editar ) {
					$respuesta['status'] = true ;
					$respuesta['respuesta'] = "CONTENIDO SIN ARCHIVOS, EDITADO EXITOSAMENTE";
				}else{
					$respuesta['status'] = false ;
					$respuesta['respuesta'] = "ERROR AL EDITAR CONTENIDO";
				}



			}else{
				$respuesta['status'] = false ;
				$respuesta['respuesta'] = "MATERIA NO VALIDA O NO INSCRITA";
			}

		}else{
			$respuesta['status'] = false ;
			$respuesta['respuesta'] = "DIRECCION URL INVALIDA";
		}


		
		echo json_encode($respuesta);
	}

}

?>