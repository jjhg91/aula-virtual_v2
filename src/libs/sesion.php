<?php 

/**
 * 
 */
class Sesion
{
	function __construct()
	{
		session_start();
	}

	public function setSesion($args)
	{
		$_SESSION['loggedin'] = true;
		$_SESSION['user']     = $args[0];
		$_SESSION['id']       = $args[1];
		$_SESSION['cedula']   = $args[2];
		$_SESSION['nombre']   = $args[3];
		$_SESSION['genero']   = $args[4];
	}

	public function closeSesion(){
		unset($_SESSION['loggedin']);
		unset($_SESSION['user']);
		unset($_SESSION['id']);
		unset($_SESSION['cedula']);
		unset($_SESSION['nombre']);
		unset($_SESSION['genero']);
		session_destroy();
	}

	public function getSesion()
	{
		$args = [
			'loggedin' => (isset($_SESSION['loggedin'])) ? $_SESSION['loggedin'] : null,
			'user'     => (isset($_SESSION['user']))     ? $_SESSION['user']     : null,
			'id'       => (isset($_SESSION['id']))       ? $_SESSION['id']       : null,
			'cedula'   => (isset($_SESSION['cedula']))   ? $_SESSION['cedula']   : null,
			'nombre'   => (isset($_SESSION['nombre']))   ? $_SESSION['nombre']   : null,
			'genero'   => (isset($_SESSION['genero']))   ? $_SESSION['genero']   : null
		];

		return $args;
	}

	public function validateSesion()
	{
		$respuesta = "";
		$datos = $this->getSesion();
		$fecha = date("d-m-y h:i:s",time());
		if (isset($datos['loggedin']) && $datos['loggedin'] == true) {
			if($datos['user'] === 'alumno'){
				$fecha = date("d-m-y h:i:s",time());
				$db = new Database();
				$query = $db->connect2()->prepare("
					INSERT INTO alumnos (
						id_estudiante,
						fecha)
					VALUES(
						:alumno,
						:fecha)
				");
				$query->bindParam(':alumno',$datos['id']);
				$query->bindParam(':fecha',$fecha);
				$query->execute();
				

				// $ins = $myPDO2->prepare("INSERT INTO alumnos (id_estudiante, fecha) VALUES($id, '$fecha');");
	  			// $ins->execute();
			}
			$respuesta = true;
		}else{
			$respuesta = false;
			header("location: " . constant('URL'));
		}
		return $respuesta; 
	}
}

?>