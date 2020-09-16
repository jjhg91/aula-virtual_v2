<?php 

/**
 * 
 */
class MainModel extends Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function buscar()
	{
		echo "INSERTAR DATOS";
	}

	public function getMensajes($datos)
	{
		$query = $this->db->connect1()->prepare("
			SELECT * FROM mensaje_inicio
			INNER JOIN periodo ON periodo.id_periodo = mensaje_inicio.id_periodo
			INNER JOIN educacion ON educacion.id_educacion = mensaje_inicio.id_educacion
			INNER JOIN especialidad ON especialidad.id_especialidad = mensaje_inicio.id_grado
			INNER JOIN seccion ON seccion.id_seccion = mensaje_inicio.id_seccion
			WHERE
				periodo.periodo = :periodo AND
				educacion.descripcion = :educacion AND
				especialidad.especial = :grado AND
				seccion.seccion = :seccion
		");
		$query->bindParam(':periodo', $datos['periodo']);
		$query->bindParam(':educacion', $datos['educacion']);
		$query->bindParam(':grado', $datos['grado']);
		$query->bindParam(':seccion', $datos['seccion']);
		$query->execute();
		$respuesta = $query->fetchAll(PDO::FETCH_ASSOC);
		return $respuesta;
	}
}


?>