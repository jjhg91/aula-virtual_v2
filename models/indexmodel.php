<?php 

/**
 * 
 */
class IndexModel extends Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function loginAlumno($datos)
	{
		
		$query = $this->db->connect1()->prepare("
			SELECT 
			id_estudia, 
			cedula, 
			p_nombres, 
			p_apellido, 
			genero 
			FROM estudiante 
			WHERE 
			cedula = :user AND 
			cedula = :pass");
		$query->bindParam(':user', $datos['user']);
		$query->bindParam(':pass', $datos['pass']);
		$query->execute();
		$resultado = $query->fetch();

		if ( $resultado ) {
			return $resultado;
		}else{
			return false;
		}
			
		
			
	
		
	}
	public function loginProfesor($datos)
	{
		$query =  $this->db->connect1()->prepare("
			SELECT 
			id_personal, 
			cedu_pers, 
			nombres 
			FROM personal 
			WHERE 
			cedu_pers = :user AND 
			cedu_pers = :pass ");
		$query->bindParam(':user', $datos['user']);
		$query->bindParam(':pass', $datos['pass']);
		$query->execute();
		$resultado = $query->fetch();

		if ( $resultado ) {
			return $resultado;
		}else{
			return false;
		}
	}
}


?>