<?php 

/**
 * 
 */
class Index extends Controller
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function render()
	{
		$this->view->render('index/index');
	}

	public function login()
	{
		$sesion = new Sesion();
		
		$user = (int)$_POST['user'];
		$pass = (int)$_POST['pass']; 
		$level = $_POST['level'];
		$datosModel = [
			'user'  => $user,
			'pass'  => $pass,
			'level' => $level
		];
		if($level == 'alumno'){
			 $alumno = $this->model->loginAlumno($datosModel);
			 if ( $alumno ) {
			 	$datosSesion = [
			 		'alumno',
			 		$alumno[0],
			 		$alumno[1],
			 		ucwords(strtolower($alumno[2] . " " . $alumno[3])),
			 		$alumno[4]
			 	];
			 	$sesion->setSesion($datosSesion);
			 	
			 	header("location: " . constant('URL') . 'main');
			 }else{
			 	echo "ERROR AL HACER LOGIN ALUMNO";
			 }
		}elseif ($level == 'profesor') {
			$profesor = $this->model->loginProfesor($datosModel);
			if ($profesor) {
			 	$datosSesion = [
			 		'profesor',
			 		$profesor[0],
			 		$profesor[1],
			 		ucwords(strtolower($profesor[2])),
			 		1
			 	];
			 	$sesion->setSesion($datosSesion);

			 	header("location: " . constant('URL') . 'main');
			 }else{
			 	echo "ERROR AL HACER LOGIN PROFESOR";
			 }
		}

	}



	public function logout()
	{
		$sesion = new Sesion();
		$sesion->closeSesion();
		header("location: " . constant('URL'));
	}


}

?>