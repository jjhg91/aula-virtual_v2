<?php 

/**
 * 
 */
class PerfilModel extends Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function getPerfilEstudiante($datos)
	{
		$query = $this->db->connect1()->prepare("
            SELECT 
                cedula, p_apellido, p_nombres, genero, email, tlf
            FROM 
                estudiante
            WHERE
                id_estudia = :id_estudia
        ");
        $query->bindParam(':id_estudia', $datos['id_estudia']);
        $query->execute();
		$respuesta = $query->fetchAll(PDO::FETCH_ASSOC);
		return $respuesta;
	}

	public function getPerfilProfesor($datos)
	{
		$query = $this->db->connect1()->prepare("
            SELECT 
                cedu_pers, nombres, email, tlf, 
            FROM 
                personal
            WHERE
                id_personal = :id_personal
        ");
        $query->bindParam(':id_personal', $datos['id_personal']);
        $query->execute();
		$respuesta = $query->fetchAll(PDO::FETCH_ASSOC);
		return $respuesta;
	}

    public function setEmailEstudiante($datos){
        $query = $this->db->connect1()->prepare("
            UPDATE
                estudiante 
            SET 
                email = :email
            WHERE
                id_estudia = :id_estudia
        ");
        $query->bindParam();
        $query->bindParam(':email', $datos['email']);
        $query->bindParam(':id_estudia', $datos['id_estudia']);
        $respuesta = $query->execute() ? true:false;
        
		return $respuesta;
    }

    public function setEmailPersonal($datos){
        $query = $this->db->connect1()->prepare("
            UPDATE 
                personal
            SET 
                email = :email
            WHERE
                id_espersonal = :id_personal
        ");
        $query->bindParam();
        $query->bindParam(':email', $datos['email']);
        $query->bindParam(':id_espersonal', $datos['id_espersonal']);
        $respuesta = $query->execute() ? true:false;
        
		return $respuesta;
    }

    public function setPassEstudiante($datos){
        $query = $this->db->connect1()->prepare("
            UPDATE
                estudiante 
            SET 
                password = :password
            WHERE
                id_estudia = :id_estudia
        ");
        $query->bindParam();
        $query->bindParam(':password', $datos['password']);
        $query->bindParam(':id_estudia', $datos['id_estudia']);
        $respuesta = $query->execute() ? true:false;
        
		return $respuesta;
    }

    public function setPassPersonal($datos){
        $query = $this->db->connect1()->prepare("
            UPDATE 
                personal
            SET 
                password = :password
            WHERE
                id_espersonal = :id_personal
        ");
        $query->bindParam();
        $query->bindParam(':password', $datos['password']);
        $query->bindParam(':id_espersonal', $datos['id_espersonal']);
        $respuesta = $query->execute() ? true:false;
        
		return $respuesta;
    }

}


?>