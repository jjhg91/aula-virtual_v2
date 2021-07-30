<?php 
require_once 'navbar.php';

/**
 *
 */
class Perfil extends Controller
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

		$this->view->render('perfil/index');
	}

    public function apiPerfil($url = null)
	{
        $sesion = new Sesion();
		$sesion->validateSesion();
		$usuario = $sesion->getSesion();
		
		$navbar = new Navbar($usuario);
		$navbarMaterias = $navbar->navbarMaterias($usuario);
		$periodo = $navbar->periodoActivo();

		$this->view->periodo = $periodo;
		$this->view->usuario = $usuario;
		$this->view->navbarMaterias = $navbarMaterias;
		$respuesta = ['status' => false, 'respuesta' => "", 'json' => ""];

        $rol = $usuario['user'];

        switch ( $_SERVER['REQUEST_METHOD'] ) {
			case 'GET':
                $datos = [
                    'id' => $usuario['id']
                ];
                if( $rol == 'estudiante' ){
                    $perfil = $this->model->setPerfilEstudiante($datos);
                }elseif ( $rol == 'profesor' ) {
                    $perfil = $this->model->getPerfilProfesor($datos);
                }
                if($perfil){
                    $respuesta['status'] = true;
                    $respuesta['json'] = $perfil;
                }
                echo json_encode($respuesta);
                break;
            case 'PUT':
                $_PUT = json_decode(file_get_contents('php://input'),true);
                $email = $_PUT['email'];
                $tlf = $_PUT['tlf'];
                $pass = $_PUT['pass'];
                $img = $_PUT['img'];
                if($email){
                    $datos = [
                        'id' => $usuario['id'],
                        'email' => $email
                    ];
                    if ( $rol == 'estudiante' ) {
                        $update = $this->model->setEmailEstudiante($datos);
                    }elseif ($rol == 'profesor') {
                        $update = $this->model->setEmailProfesor($datos);
                    }
                }elseif ($tlf) {
                    $datos = [
                        'id' => $usuario['id'],
                        'tlf' => $tlf
                    ];
                    if ( $rol == 'estudiante' ) {
                        $update = $this->model->setTlfEstudiante($datos);
                    }elseif ($rol == 'profesor') {
                        $update = $this->model->setTlfProfesor($datos);
                    }
                }elseif ($pass) {
                    $password = password_hash($pass, PASSWORD_ARGON2I);
                    $datos = [
                        'id' => $usuario['id'],
                        $pass => $password
                    ];
                    if ( $rol == 'estudiante' ) {
                        $update = $this->model->setPassEstudiante($datos);
                    }elseif ($rol == 'profesor') {
                        $update = $this->model->setPassProfesor($datos);
                    }
                    if($update){
                        $respuesta['status'] = true;
                    }
                }elseif ($img) {
                    if ( $rol == 'estudiante' ) {
                        $update = $this->model->setImgEstudiante($datos);
                    }elseif ($rol == 'profesor') {
                        $update = $this->model->setImgProfesor($datos);
                    }
                    if($update){
                        $respuesta['status'] = true;
                    }
                }
                echo json_encode($respuesta);
                break;
        }
    }
}
?>