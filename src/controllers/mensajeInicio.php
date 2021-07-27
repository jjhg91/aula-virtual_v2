<?php 
require_once 'navbar.php';
/**
 * 
 */
class MensajeInicio extends Controller
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function render()
	{

	}

	

	public function mensajes($url = null)
	{

		// $_SESSION['grado'] = $respuesta[0][3];
		// $_SESSION['seccion'] = $respuesta[0][8];
		// $_SESSION['periodo'] = $respuesta[0][6];

		$sesion = new Sesion();
		$sesion->validateSesion();
		$usuario = $sesion->getSesion();

		$respuesta = ['status' => false, 'respuesta' => "", 'json' => ""];
		
		switch ( $_SERVER['REQUEST_METHOD'] ) {
			case 'GET':
				
				$navbar = new Navbar($usuario);
				$navbarMaterias = $navbar->navbarMaterias($usuario);
				$this->view->usuario = $usuario;
				$this->view->navbarMaterias = $navbarMaterias;
				
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
				$this->view->render('mensajeInicio/index');

				break;

			case 'POST':
					// DATOS DE FORMULARIO
					$periodo = $_POST['add__periodo'];
					$educacion = $_POST['add__educacion'];
					$grado = $_POST['add__grado'];
					$seccion = $_POST['add__seccion'];
					$titulo = $_POST['titulo'];
					$mensaje = $_POST['descripcion'];

					$datos = [
						'periodo' => $periodo,
						'educacion' => $educacion,
						'grado' => $grado,
						'seccion' => $seccion,
						'titulo' => $titulo,
						'mensaje' => $mensaje
					];
					$insert = $this->model->addMensaje($datos);

					if ( $insert ) {
						$getMensaje = $this->model->getMensaje($datos);
						$respuesta['status'] = true;
						$respuesta['respuesta'] = "PERIODO AGREGADO EXITOSAMENTE";
						$respuesta['json'] = $getMensaje;
					}else {
						$respuesta['status'] = false;
						$respuesta['respuesta'] = "ERROR AL AGREGAR PERIODO";
					}
					echo json_encode($respuesta);
				break;

			// case 'PUT':
			// 		// DATOS DEL FORMULARIO
			// 		$_PUT = json_decode(file_get_contents('php://input'),true);
			// 		$a = gettype($_PUT);
			// 		$id_periodo = (int)$url[0];

			// 		$periodo = $_PUT['edit__periodo'];
			// 		$lapso = (int)$_PUT['edit__lapso'];
			// 		$estatus = (int)$_PUT['edit__estatus'];
			// 		$datos = [
			// 			'id_periodo' => $id_periodo,
			// 			'periodo' => $periodo,
			// 			'lapso' => $lapso,
			// 			'estatus' => $estatus
			// 		];
			// 		$update = $this->model->updatePeriodo($datos);
			// 		if ( $update ) {
			// 			$getPeriodo = $this->model->getPeriodo($datos);
			// 			$respuesta['status'] = true;
			// 			$respuesta['respuesta'] = "EL PERIODO FUE ADITADA EXITOSAMENTE";
			// 			$respuesta['json'] = [
			// 				'id' => $getPeriodo['id_periodo'],
			// 				'periodo' => $getPeriodo['periodo'],
			// 				'lapso' => $getPeriodo['lapso'],
			// 				'estatus' => $getPeriodo['status']
			// 			];

			// 		}else{
			// 			$respuesta['status'] = false;
			// 			$respuesta['respuesta'] = "ERROR AL EDITAR PERIODO";
			// 		}
			// 		echo json_encode($respuesta);
			// 	break;

			case 'DELETE':

					$mensaje = $url[0];
					$eliminar = $this->model->deleteMensaje($mensaje);

					if ( $eliminar ) {
						$respuesta['status'] = true;
						$respuesta['respuesta'] = "El mensaje numero id ".$mensaje." a sido eliminado";
					}else{
						$respuesta['status'] = false;
						$respuesta['respuesta'] = "Error al intentar eliminar el mensaje periodo ".$mensaje;
					}

					echo json_encode($respuesta);
				break;
		}

	}






}

?>