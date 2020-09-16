<?php 

include_once 'models/foroPost.php';

/**
 * 
 */
class MensajeInicioModel extends Model
{

	function __construct()
	{
		parent::__construct();
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

	public function getMensaje($datos)
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
				seccion.seccion = :seccion AND
				titulo = :titulo AND
				mensaje = :mensaje
		");
		$query->bindParam(':periodo', $datos['periodo']);
		$query->bindParam(':educacion', $datos['educacion']);
		$query->bindParam(':grado', $datos['grado']);
		$query->bindParam(':seccion', $datos['seccion']);
		$query->bindParam(':titulo', $datos['titulo']);
		$query->bindParam(':mensaje', $datos['mensaje']);
		$query->execute();
		$respuesta = $query->fetch(PDO::FETCH_ASSOC);

		return $respuesta;
	}


	public function deleteMensaje($mensaje)
	{
		$query = $this->db->connect1()->prepare("
			DELETE FROM mensaje_inicio
			WHERE
			id_mensaje_inicio = :mensaje
		");
		$query->bindParam(':mensaje', $mensaje);

		if ( $query->execute() ) {
			$respuesta = true;
		}else {
			$respuesta = false;
		}

		return $respuesta;
	}


	public function addMensaje($datos)
	{
		$queryPeriodo = $this->db->connect1()->prepare("
			SELECT id_periodo FROM periodo
			WHERE
				periodo = :periodo
		");
		$queryPeriodo->bindParam(':periodo', $datos['periodo']);
		$queryPeriodo->execute();
		$periodo = $queryPeriodo->fetch()[0];


		$queryEducacion = $this->db->connect1()->prepare("
			SELECT id_educacion FROM educacion
			WHERE
				descripcion = :educacion
		");
		$queryEducacion->bindParam(':educacion', $datos['educacion']);
		$queryEducacion->execute();
		$educacion = $queryEducacion->fetch()[0];

		$queryGrado = $this->db->connect1()->prepare("
			SELECT id_especialidad FROM especialidad
			WHERE
				especial = :grado
		");
		$queryGrado->bindParam(':grado', $datos['grado']);
		$queryGrado->execute();
		$grado = $queryGrado->fetch()[0];
		
		$querySeccion = $this->db->connect1()->prepare("
			SELECT id_seccion FROM seccion
			WHERE
				seccion = :seccion
		");
		$querySeccion->bindParam(':seccion', $datos['seccion']);
		$querySeccion->execute();
		$seccion = $querySeccion->fetch()[0];
		
		$query = $this->db->connect1()->prepare("
			INSERT INTO mensaje_inicio(
				titulo,
				mensaje,
				id_periodo,
				id_educacion,
				id_grado,
				id_seccion
			)
			VALUES(
				:titulo,
				:mensaje,
				:periodo,
				:educacion,
				:grado,
				:seccion
			)
		");
		$query->bindParam(':titulo',$datos['titulo']);
		$query->bindParam(':mensaje',$datos['mensaje']);
		$query->bindParam(':periodo',$periodo);
		$query->bindParam(':educacion',$educacion);
		$query->bindParam(':grado',$grado);
		$query->bindParam(':seccion',$seccion);

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