<?php 

include_once 'models/foroPost.php';

/**
 * 
 */
class ForoModel extends Model
{

	function __construct()
	{
		parent::__construct();
	}

	public function getMensajes($materia)
	{
		$query = $this->db->connect2()->prepare("
			SELECT * FROM mensaje_inicio
			WHERE
				id_periodo = :periodo AND
				id_educacion = :educacion AND
				id_grado = :grado AND
				id_seccion = :seccion
		");
		$query->bindParam(':periodo', $datos['periodo']);
		$query->bindParam(':educacion', $datos['educacion']);
		$query->bindParam(':grado', $datos['grado']);
		$query->bindParam(':seccion', $datos['seccion']);
		$query->execute();
		$respuesta = $query->fetchAll(PDO::FETCH_ASSOC);
		return $respuesta;
	}

	public function getMensaje($datos)
	{
		$query = $this->db->connect2()->prepare("
				SELECT * FROM mensaje_inicio
				WHERE
					mensaje = :mensaje AND
					id_periodo = :periodo AND
					id_educacion = :educacion AND
					id_grado = :grado AND
					id_seccion = :seccion
			");
		$query->bindParam(':mensaje', $datos['mensaje']);
		$query->bindParam(':periodo', $datos['periodo']);
		$query->bindParam(':educacion', $datos['educacion']);
		$query->bindParam(':grado', $datos['grado']);
		$query->bindParam(':seccion', $datos['seccion']);
		$query->execute();
		$respuesta = $query->fetch(PDO::FETCH_ASSOC);

		return $respuesta;
	}


	public function deleteForo($materia, $foro)
	{
		$query = $this->db->connect2()->prepare("
			DELETE FROM foro_tema
			WHERE
			id_materia = :materia AND
			id_foro_tema = :foro
		");
		$query->bindParam(':materia', $materia);
		$query->bindParam(':foro', $foro);

		if ( $query->execute() ) {
			$respuesta = true;
		}else {
			$respuesta = false;
		}

		return $respuesta;
	}


	public function addForo($datos)
	{
		$query = $this->db->connect2()->prepare("
			INSERT INTO foro_tema(
				id_materia,
				titulo,
				descripcion)
			VALUES(
				:materia,
				:titulo,
				:descripcion)
		");
		$query->bindParam(':materia',$datos['materia']);
		$query->bindParam(':titulo',$datos['titulo']);
		$query->bindParam(':descripcion',$datos['descripcion']);

		if	( $query->execute() ) {
			$respuesta = true;
		}else {
			$respuesta = false;
		}

		return $respuesta;
	}

	
	public function editForoTema($datos)
	{
		$query = $this->db->connect2()->prepare("
			UPDATE foro_tema SET
				titulo = :titulo,
				descripcion = :descripcion
			WHERE
				id_materia = :materia AND
				id_foro_tema = :foro;
		");
		$query->bindParam(':titulo',$datos['titulo']);
		$query->bindParam(':descripcion',$datos['descripcion']);
		$query->bindParam(':materia',$datos['materia']);
		$query->bindParam(':foro',$datos['foro']);

		if ( $query->execute() ) {
			$respuesta = true;
		}else {
			$respuesta = false;
		}

		return $respuesta;
	}

}


?>