<?php

/**
 *
 */
class AlumnoModel extends Model
{
	function __construct()
	{
		parent::__construct();
	}

	public function getAlumnos($materia)
	{
		$query = $this->db->connect1()->prepare("
			SELECT
				estudiante.id_estudia,
				estudiante.p_apellido as apellidos,
				estudiante.p_nombres as nombres,
				estudiante.cedula,
				pensum.descripcion,
				especialidad.especial
			FROM inscripcion
			INNER JOIN profesorcursogrupo ON inscripcion.id_profesorcursogrupo = profesorcursogrupo.id_profesorcursogrupo
			INNER JOIN pensum ON profesorcursogrupo.curso = pensum.id_pensum
			INNER JOIN especialidad ON pensum.id_especialidad = especialidad.id_especialidad
			INNER JOIN estudiante ON inscripcion.id_estudia = estudiante.id_estudia
			INNER JOIN periodo ON periodo.id_periodo = profesorcursogrupo.periodo
			WHERE
				profesorcursogrupo.id_profesorcursogrupo = :materia AND
				periodo.status = 1 
			GROUP BY estudiante.id_estudia
			ORDER BY estudiante.p_apellido ASC, estudiante.p_nombres ASC
		");
		
		$query->bindParam(':materia',$materia);
		$query->execute();
		$respuesta = $query->fetchAll(PDO::FETCH_OBJ);



		return $respuesta;
	}

}


?>