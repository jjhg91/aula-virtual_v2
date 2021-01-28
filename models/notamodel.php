<?php

/**
 *
 */
class NotaModel extends Model
{
	function __construct()
	{
		parent::__construct();
	}

	public function getPlanes($materia)
	{
		$query = $this->db->connect2()->prepare("
			SELECT
			id_plan_evaluacion,
			id_profesorcursogrupo,
			tipo_evaluacion.descripcion as tipo_evaluacion,
			valor.descripcion as valor,
			semana.descripcion as semana,
			plan_evaluacion.descripcion,
			tipo_evaluacion.id_tipo_evaluacion,
			plan_evaluacion.otros,
			lapso
			FROM plan_evaluacion
			INNER JOIN tipo_evaluacion ON plan_evaluacion.tipo_evaluacion = tipo_evaluacion.id_tipo_evaluacion
			INNER JOIN valor ON plan_evaluacion.valor = valor.id_valor
			INNER JOIN semana ON semana.id_semana = plan_evaluacion.semana
			WHERE  id_profesorcursogrupo = :materia
			ORDER BY semana.descripcion ASC
		");
		$query->bindParam(':materia',$materia);
		$query->execute();
		$respuesta = $query->fetchAll(PDO::FETCH_OBJ);

		return $respuesta;
	}

	public function getPlan($materia, $plan)
	{
		$query = $this->db->connect2()->prepare("
			SELECT
			id_plan_evaluacion,
			id_profesorcursogrupo,
			tipo_evaluacion.descripcion,
			valor.descripcion,
			semana.descripcion,
			plan_evaluacion.descripcion,
			tipo_evaluacion.id_tipo_evaluacion,
			plan_evaluacion.otros
			FROM plan_evaluacion
			INNER JOIN tipo_evaluacion ON plan_evaluacion.tipo_evaluacion = tipo_evaluacion.id_tipo_evaluacion
			INNER JOIN valor ON plan_evaluacion.valor = valor.id_valor
			INNER JOIN semana ON semana.id_semana = plan_evaluacion.semana
			WHERE
			id_profesorcursogrupo = :materia AND
			id_plan_evaluacion = :plan
			ORDER BY semana.descripcion ASC
		");
		$query->bindParam(':materia',$materia);
		$query->bindParam(':plan',$plan);
		$query->execute();
		$respuesta = $query->fetch();

		return $respuesta;
	}

	public function getAlumnos($materia, $plan)
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
			WHERE
			profesorcursogrupo.id_profesorcursogrupo = :materia AND
			profesorcursogrupo.periodo = 71
			ORDER BY estudiante.p_apellido ASC, estudiante.p_nombres ASC
		");
		$query->bindParam(':materia',$materia);
		$query->execute();
		$respu = $query->fetchAll();
		$respuesta = [];

		// APARTIR DE 6
		foreach ($respu as $alumno) {
			$query2 = $this->db->connect2()->prepare("
				SELECT * FROM notas
				WHERE
				id_plan_evaluacion = :plan AND
				id_estudiante = :alumno
			");
			$query2->bindParam(':plan', $plan);
			$query2->bindParam(':alumno', $alumno[0]);
			$query2->execute();
			$nota[0] = $query2->fetch();

			$respu2 = array_merge($alumno, $nota);
			array_push($respuesta, $respu2);
		}
		
		return $respuesta;
	}

	public function addNota($datos)
	{
		$query = $this->db->connect2()->prepare("
			SELECT * FROM notas
			WHERE
			id_plan_evaluacion = :plan AND
			id_estudiante = :alumno
		");

		$query->bindParam(':plan', $datos['plan']);
		$query->bindParam(':alumno', $datos['alumno']);
		$query->execute();
		
		$buscarNota = $query->fetch();
		if ( !$buscarNota ) {
			$query2 = $this->db->connect2()->prepare("
				INSERT INTO notas (
					id_estudiante,
					id_plan_evaluacion,
					nota,
					observacion)
				VALUES(
					:alumno,
					:plan,
					:nota,
					:observacion)
			");
			$query2->bindParam(':alumno',$datos['alumno']);
			$query2->bindParam(':plan',$datos['plan']);
			$query2->bindParam(':nota',$datos['nota']);
			$query2->bindParam(':observacion',$datos['observacion']);
			if ( $query2->execute() ) {
				$respuesta = true;
			}else {
				$respuesta = false;
			}
		}else {
			$query2 = $this->db->connect2()->prepare("
				UPDATE notas
				SET
				nota = :nota,
				observacion = :observacion
				WHERE
				id_estudiante = :alumno AND
				id_plan_evaluacion = :plan
			");
			$query2->bindParam(':nota',$datos['nota']);
			$query2->bindParam(':observacion',$datos['observacion']);
			$query2->bindParam(':alumno',$datos['alumno']);
			$query2->bindParam(':plan',$datos['plan']);
			if ( $query2->execute() ) {
				$respuesta = true;
			}else {
				$respuesta = false;
			}
		}
		return $respuesta;
	}

	public function updateArchivo($n, $alumno, $plan, $archivo)
	{
		$query = $this->db->connect2()->prepare("
			UPDATE notas
			SET
			file".$n." = :archivo
			WHERE
			id_estudiante = :alumno AND
			id_plan_evaluacion = :plan
		");
		$query->bindParam(':archivo',$archivo);
		$query->bindParam(':alumno',$alumno);
		$query->bindParam(':plan',$plan);

		if ( $query->execute() ) {
			$respuesta = true;
		}else {
			$respuesta = false;
		}

		return $respuesta;
	}

	public function getEvaluacionEntregada($datos)
	{
		$query = $this->db->connect2()->prepare("
		SELECT
			actividades.id_actividades,
			actividades.id_profesorcursogrupo,
			actividades.id_plan_evaluacion,
			actividades_estudiante.id_estudiante,
			actividades_estudiante.fecha,
			actividades_estudiante.file1,
			actividades_estudiante.file2,
			actividades_estudiante.file3,
			actividades_estudiante.file4,
			actividades_estudiante.corregido,
			actividades_estudiante.id_actividades_estudiante,
			actividades.nlink1,
			actividades.nlink2,
			actividades.nlink3,
			actividades.nlink4,
			actividades.link1,
			actividades.link2,
			actividades.link3,
			actividades.link4,
			actividades_estudiante.nlink1,
			actividades_estudiante.nlink2,
			actividades_estudiante.nlink3,
			actividades_estudiante.nlink4,
			actividades_estudiante.link1,
			actividades_estudiante.link2,
			actividades_estudiante.link3,
			actividades_estudiante.link4,
			actividades_estudiante.descripcion,
			(SELECT notas.nota FROM notas WHERE notas.id_estudiante = actividades_estudiante.id_estudiante AND notas.id_plan_evaluacion = actividades.id_plan_evaluacion) as nota,
			(SELECT notas.observacion FROM notas WHERE notas.id_estudiante = actividades_estudiante.id_estudiante AND notas.id_plan_evaluacion = actividades.id_plan_evaluacion) as observacion,
			(SELECT notas.file1 FROM notas WHERE notas.id_estudiante = actividades_estudiante.id_estudiante AND notas.id_plan_evaluacion = actividades.id_plan_evaluacion) as correccion1,
			(SELECT notas.file2 FROM notas WHERE notas.id_estudiante = actividades_estudiante.id_estudiante AND notas.id_plan_evaluacion = actividades.id_plan_evaluacion) as correccion2,
			(SELECT notas.file3 FROM notas WHERE notas.id_estudiante = actividades_estudiante.id_estudiante AND notas.id_plan_evaluacion = actividades.id_plan_evaluacion) as correccion3,
			(SELECT notas.file4 FROM notas WHERE notas.id_estudiante = actividades_estudiante.id_estudiante AND notas.id_plan_evaluacion = actividades.id_plan_evaluacion) as correccion4
		FROM actividades
		INNER JOIN plan_evaluacion ON actividades.id_plan_evaluacion = plan_evaluacion.id_plan_evaluacion
		INNER JOIN tipo_evaluacion ON plan_evaluacion.tipo_evaluacion = tipo_evaluacion.id_tipo_evaluacion
		INNER JOIN valor ON plan_evaluacion.valor = valor.id_valor
		INNER JOIN actividades_estudiante ON actividades_estudiante.id_actividades = actividades.id_actividades
		WHERE
			actividades.id_actividades = :evaluacion AND
			actividades_estudiante.id_estudiante = :alumno

		");
		$query->bindParam(':evaluacion', $datos['evaluacion']);
		$query->bindParam(':alumno', $datos['alumno']);
		$query->execute();
		$respuesta = $query->fetch(PDO::FETCH_ASSOC);

		return  $respuesta;
	}






}


?>