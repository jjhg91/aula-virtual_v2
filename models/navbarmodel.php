<?php

/**
 *
 */
class NavbarModel extends Model
{
	function __construct()
	{
		parent::__construct();
	}

	public function navbarMateriasAlumno($args)
	{
		$query = $this->db->connect1()->prepare("
			SELECT
				pensum.descripcion,
				especialidad.descripcion,
				profesorcursogrupo.id_profesorcursogrupo,
				especialidad.especial,
				periodo.periodo,
				periodo.status
			FROM inscripcion
			INNER JOIN profesorcursogrupo ON inscripcion.id_profesorcursogrupo = profesorcursogrupo.id_profesorcursogrupo
			INNER JOIN pensum ON profesorcursogrupo.curso = pensum.id_pensum
			INNER JOIN especialidad ON pensum.id_especialidad = especialidad.id_especialidad
            INNER JOIN estudiante ON estudiante.id_estudia = inscripcion.id_estudia
            INNER JOIN periodo ON periodo.id_periodo = profesorcursogrupo.periodo
			WHERE
			estudiante.id_estudia = :id
			AND
			periodo.status = 1
		");
		$query->bindParam(':id', $args);
		$query->execute();
		$resultado = $query->fetchAll();

		return $resultado;

	}

	public function navbarMateriasProfesor($args)
	{
		$query = $this->db->connect1()->prepare("

			SELECT
				pensum.descripcion,
				especialidad.descripcion,
				profesorcursogrupo.id_profesorcursogrupo,
				especialidad.especial,
				periodo.periodo
            FROM profesorcursogrupo
			INNER JOIN pensum ON profesorcursogrupo.curso = pensum.id_pensum
			INNER JOIN especialidad ON pensum.id_especialidad = especialidad.id_especialidad
            INNER JOIN periodo ON periodo.id_periodo = profesorcursogrupo.periodo
			WHERE
				personal = :id AND
				periodo.status = 1
		");
		$query->bindParam(':id', $args);
		$query->execute();
		$respuesta= $query->fetchAll();

		return $respuesta;
	}

	public function barMateriaAlumno($usuario,$materia)
	{
		$query = $this->db->connect1()->prepare("
            SELECT
            pensum.descripcion,
            especialidad.descripcion,
            profesorcursogrupo.id_profesorcursogrupo,
            personal.nombres,
            especialidad.especial
            FROM inscripcion
            INNER JOIN profesorcursogrupo ON inscripcion.id_profesorcursogrupo = profesorcursogrupo.id_profesorcursogrupo
            INNER JOIN pensum ON profesorcursogrupo.curso = pensum.id_pensum
            INNER JOIN especialidad ON pensum.id_especialidad = especialidad.id_especialidad
            INNER JOIN personal ON profesorcursogrupo.personal = personal.id_personal
            WHERE
            id_estudia = :usuario AND
            periodo = 71 AND
            profesorcursogrupo.id_profesorcursogrupo = :materia
            ");
		$query->bindParam(':usuario', $usuario);
		$query->bindParam(':materia', $materia);
        $query->execute();
        $resultado = $query->fetch();

        return $resultado;
	}

	public function barMateriaProfesor($usuario,$materia)
	{
		$query = $this->db->connect1()->prepare("
			SELECT
			pensum.descripcion,
			especialidad.descripcion,
			profesorcursogrupo.id_profesorcursogrupo,
			personal.nombres,
			especialidad.especial
			FROM profesorcursogrupo
			INNER JOIN pensum ON profesorcursogrupo.curso = pensum.id_pensum
			INNER JOIN especialidad ON pensum.id_especialidad = especialidad.id_especialidad
			INNER JOIN personal ON profesorcursogrupo.personal = personal.id_personal
			WHERE
			personal = :id AND
			profesorcursogrupo.id_profesorcursogrupo = :materia AND
			periodo = 71
		");
		$query->bindParam(':id', $usuario);
		$query->bindParam(':materia', $materia);
		$query->execute();
		$respuesta = $query->fetch();

		return $respuesta;
	}
}


?>