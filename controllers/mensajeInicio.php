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

	}


	public function periodo($url = null)
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
				$materia = (int)$url[0];
				$navbar = new Navbar($usuario);
				$navbarMaterias = $navbar->navbarMaterias($usuario);
				$this->view->usuario = $usuario;
				$this->view->navbarMaterias = $navbarMaterias;
				
				$this->view->render('mensajeInicio/index');

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






}

?>