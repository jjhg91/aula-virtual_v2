<?php 
require_once 'navbar.php';
/**
 * 
 */
class Plan extends Controller
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
		$navbarMaterias = $navbar->buscarMaterias($usuario);
		$this->view->usuario = $usuario;
		$this->view->navbarMaterias = $navbarMaterias;

		echo 'Plan';
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

				$planes         = $this->model->getPlanes($materia[0]);
				$tipoEvaluacion = $this->model->getTipoEvaluacion();
				$valor          = $this->model->getValor();
				$semana         = $this->model->getSemana();

				$this->view->barMateria     = $barMateria;
				$this->view->planes         = $planes;
				$this->view->tipoEvaluacion = $tipoEvaluacion;
				$this->view->valores        = $valor;
				$this->view->semanas        = $semana;

				$this->view->render('plan/index');

			}else{
				echo "MATERIA NO VALIDA O NO INSCRITA";
			}
				
			
		}else{
			echo "DIRECCION URL INVALIDA";
			exit;
		}
	}

	public function delete($url)
	{
		$materia = $url[0];
		$plan = $url[1];

		$sesion = new Sesion();
		$sesion->validateSesion();
		$usuario = $sesion->getSesion();
		$respuesta = ['status' => false, 'respuesta' => "", 'html' => ""];

		if (  ctype_digit($materia) && ctype_digit($plan) ) {
			$navbar = new Navbar($usuario);
			$barMateria = $navbar->barMateria($usuario,$materia);
			if ($barMateria) {
				$eliminar = $this->model->deletePlan($materia, $plan);

				if ( $eliminar ) {
					$respuesta['status'] = true;
					$respuesta['respuesta'] = "ELEMENTO DEL PLAN DE EVALUACION ELIMINADO EXITOSAMENTE";
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

	public function add($url)
	{

		//URLS VARIABLES
		$materia = $url[0];

		$sesion = new Sesion();
		$sesion->validateSesion();
		$usuario = $sesion->getSesion();
		$respuesta = ['status' => false, 'respuesta' => "", 'idPlan' => "0"];

		if (  ctype_digit($materia) ) {
			$navbar = new Navbar($usuario);
			$barMateria = $navbar->barMateria($usuario,$materia);

			if ($barMateria) {
				// DATOS DE FORMULARIO
				$valor = 1;
				$tipo = (int)$_POST['tipo'];
				$semana = $_POST['semana'];
				$descripcion = $_POST['descripcion'];
				$otros = $_POST['otros'];

				$id = $_SESSION['id'];

				$datos = [
					'materia' => $materia,
					'valor' => $valor,
					'tipo' => $tipo,
					'semana' => $semana,
					'descripcion' => $descripcion,
					'otros' => $otros
				];
				$insert = $this->model->addPlan($datos);
				
				if ( $insert ) {
				
					$idPlan = $this->model->getIdPlan($datos);
					$respuesta['status'] = true;
					$respuesta['respuesta'] = "LA EVALUACION FUE AGREGADA EXITOSAMENTE AL PLAN DE EVALUACION";
					$respuesta['idPlan'] = $idPlan;
					$respuesta['materia'] = $datos['materia'];
					
					
					

				}else {
					$respuesta['status'] = false;
					$respuesta['respuesta'] = "MAXIMO DE EVALUACIONES INSCRITAS ALCANZADAS O SUPERADO EL 100% A EVALUAR";
					
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

	public function edit($url)
	{
		$materia = (int)$_POST['materia'];
		$plan = (int)$_POST['plan'];

		$sesion = new Sesion();
		$sesion->validateSesion();
		$usuario = $sesion->getSesion();
		$respuesta = ['status' => false, 'respuesta' => ""];

		if (  ctype_digit($materia) && ctype_digit($plan) ) {
			$navbar = new Navbar($usuario);
			$barMateria = $navbar->barMateria($usuario,$materia);
			if ($barMateria) {
				// DATOS DEL FORMULARIO
				$valor = (int)$_POST['valor'];
				$tipo = (int)$_POST['tipo'];
				$semana = $_POST['semana'];
				$descripcion = $_POST['descripcion'];
				$otros = $_POST['otros'];

				$datos = [
					'materia' => $materia,
					'plan' => $plan,
					'valor' => $valor,
					'tipo' => $tipo,
					'semana' => $semana,
					'descripcion' => $descripcion,
					'otros' => $otros
				];

				$update = $this->model->updatePlan($datos);

				if ( $update ) {
					$respuesta['status'] = true;
					$respuesta['respuesta'] = "LA EVALUACION DEL PLAN DE EVALUACIONES FUE ADITADA EXITOSAMENTE";

				}else{
					$respuesta['status'] = false;
					$respuesta['respuesta'] = "ERROR AL EDITAR CONTENIDO";
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
}

?>