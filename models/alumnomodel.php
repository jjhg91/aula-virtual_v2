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
			estudiante.p_apellido,
			estudiante.p_nombres,
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
			ORDER BY estudiante.p_apellido ASC, estudiante.p_nombres ASC
		");
		
		$query->bindParam(':materia',$materia);
		$query->execute();
		$respu = $query->fetchAll();
		$respuesta = [];
		foreach ($respu as $alumno) {
			//APARTIR DE 6
			$query2 = $this->db->connect2()->query("SELECT fecha FROM alumnos WHERE id_estudiante = $alumno[0] ORDER BY fecha DESC LIMIT 1");
			$fech = $query2->fetch();

			$fecha = (is_array($fech)) ? $fech : ['fecha' => '', '0' => ''];
			
			$respu2 = array_merge($alumno,$fecha);
			array_push($respuesta, $respu2);
		}


		return $respuesta;
	}

}


?>