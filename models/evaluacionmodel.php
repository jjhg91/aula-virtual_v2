<?php

/**
 *
 */
class EvaluacionModel extends Model
{
	function __construct()
	{
		parent::__construct();
	}
	public function getPlanes($materia)
	{
		$query = $this->db->connect2()->prepare("
			SELECT
			plan_evaluacion.id_plan_evaluacion,
			tipo_evaluacion.descripcion,
			valor.descripcion,
			plan_evaluacion.descripcion,
			tipo_evaluacion.id_tipo_evaluacion,
			plan_evaluacion.otros,
			actividades.id_actividades
			FROM plan_evaluacion
			INNER JOIN tipo_evaluacion ON plan_evaluacion.tipo_evaluacion = tipo_evaluacion.id_tipo_evaluacion
			INNER JOIN valor ON plan_evaluacion.valor = valor.id_valor
			LEFT JOIN actividades ON plan_evaluacion.id_plan_evaluacion = actividades.id_plan_evaluacion
			WHERE
			plan_evaluacion.id_profesorcursogrupo = :materia 
		");
		$query->bindParam(':materia',$materia);
		$query->execute();
		$respuesta = $query->fetchAll();

		return $respuesta;
	}

	public function getEvaluaciones($materia)
	{
		$query = $this->db->connect2()->prepare("
			SELECT
			actividades.id_actividades,
			valor.descripcion as valor,
			tipo_evaluacion.descripcion as tipo_evaluacion,
			actividades.publicacion,
			actividades.fecha,
			actividades.descripcion,
			tipo_evaluacion.id_tipo_evaluacion,
			plan_evaluacion.otros,
			COUNT(actividades_estudiante.id_actividades) AS entregados,
			actividades.file1,
			actividades.file2,
			actividades.file3,
			actividades.file4,
			actividades.id_plan_evaluacion,
			LEFT(plan_evaluacion.descripcion,200) AS plan,
			actividades.lapso
			FROM actividades
			INNER JOIN plan_evaluacion ON actividades.id_plan_evaluacion = plan_evaluacion.id_plan_evaluacion
			INNER JOIN tipo_evaluacion  ON plan_evaluacion.tipo_evaluacion = tipo_evaluacion.id_tipo_evaluacion
			INNER JOIN valor ON plan_evaluacion.valor = valor.id_valor
			LEFT JOIN actividades_estudiante ON actividades_estudiante.id_actividades = actividades.id_actividades
			WHERE
			actividades.id_profesorcursogrupo = :materia
			GROUP BY actividades.id_actividades
			ORDER BY STR_TO_DATE(actividades.fecha,'%d-%m-%Y') ASC
		");
		$query->bindParam(':materia', $materia);
		$query->execute();
		$respuesta = $query->fetchAll(PDO::FETCH_OBJ);

		return $respuesta;
	}

	public function getTotalAlumnos($materia)
	{
		$query = $this->db->connect1()->prepare("
			SELECT COUNT(id_profesorcursogrupo) FROM inscripcion
			WHERE
			id_profesorcursogrupo = :materia
		");
		$query->bindParam(':materia',$materia);
		$query->execute();
		$respuesta = $query->fetch();
		return $respuesta;
	}


	public function getEvaluacion($evaluacion)
	{
		$query = $this->db->connect2()->prepare("
			SELECT
			actividades.id_actividades,
			valor.descripcion,
			tipo_evaluacion.descripcion,
			actividades.publicacion,
			actividades.fecha,
			actividades.descripcion,
			actividades.file1,
			actividades.file2,
			actividades.file3,
			actividades.file4,
			actividades.id_profesorcursogrupo,
			tipo_evaluacion.id_tipo_evaluacion,
			plan_evaluacion.otros,
			actividades.nlink1,
			actividades.nlink2,
			actividades.nlink3,
			actividades.nlink4,
			actividades.link1,
			actividades.link2,
			actividades.link3,
			actividades.link4,
			plan_evaluacion.descripcion,
			plan_evaluacion.id_plan_evaluacion
			FROM actividades
			INNER JOIN plan_evaluacion ON actividades.id_plan_evaluacion = plan_evaluacion.id_plan_evaluacion
			INNER JOIN tipo_evaluacion ON plan_evaluacion.tipo_evaluacion = tipo_evaluacion.id_tipo_evaluacion
			INNER JOIN valor ON plan_evaluacion.valor = valor.id_valor
			WHERE
			actividades.id_actividades = :evaluacion
		");
		$query->bindParam(':evaluacion', $evaluacion);
		$query->execute();
		$respuesta = $query->fetch();

		return $respuesta;
	}

	public function getEvaluacionEntregada($evaluacion, $alumno)
	{
		$query = $this->db->connect2()->prepare("
			SELECT
				A.id_actividades,
				A.id_profesorcursogrupo,
				A.id_plan_evaluacion,
				actividades_estudiante.id_estudiante,
				actividades_estudiante.fecha,
				actividades_estudiante.file1,
				actividades_estudiante.file2,
				actividades_estudiante.file3,
				actividades_estudiante.file4,
				actividades_estudiante.corregido,
				(SELECT notas.nota FROM notas WHERE notas.id_estudiante = actividades_estudiante.id_estudiante AND notas.id_plan_evaluacion = A.id_plan_evaluacion) as nota,
				(SELECT notas.observacion FROM notas WHERE notas.id_estudiante = actividades_estudiante.id_estudiante AND notas.id_plan_evaluacion = A.id_plan_evaluacion) as observacion,
				actividades_estudiante.id_actividades_estudiante,
				A.nlink1,
				A.nlink2,
				A.nlink3,
				A.nlink4,
				A.link1,
				A.link2,
				A.link3,
				A.link4,
				actividades_estudiante.nlink1,
				actividades_estudiante.nlink2,
				actividades_estudiante.nlink3,
				actividades_estudiante.nlink4,
				actividades_estudiante.link1,
				actividades_estudiante.link2,
				actividades_estudiante.link3,
				actividades_estudiante.link4,
				actividades_estudiante.descripcion,
				(SELECT notas.file1 FROM notas WHERE notas.id_estudiante = actividades_estudiante.id_estudiante AND notas.id_plan_evaluacion = A.id_plan_evaluacion) as revision1,
				(SELECT notas.file2 FROM notas WHERE notas.id_estudiante = actividades_estudiante.id_estudiante AND notas.id_plan_evaluacion = A.id_plan_evaluacion) as revision2,
				(SELECT notas.file3 FROM notas WHERE notas.id_estudiante = actividades_estudiante.id_estudiante AND notas.id_plan_evaluacion = A.id_plan_evaluacion) as revision3,
				(SELECT notas.file4 FROM notas WHERE notas.id_estudiante = actividades_estudiante.id_estudiante AND notas.id_plan_evaluacion = A.id_plan_evaluacion) as revision4,
				B.p_nombres as nombres,
				B.p_apellido as apellidos,
				B.cedula
			
			FROM uepjmc_aula.actividades A
			INNER JOIN plan_evaluacion ON A.id_plan_evaluacion = plan_evaluacion.id_plan_evaluacion
			INNER JOIN tipo_evaluacion ON plan_evaluacion.tipo_evaluacion = tipo_evaluacion.id_tipo_evaluacion
			INNER JOIN valor ON plan_evaluacion.valor = valor.id_valor
			INNER JOIN actividades_estudiante ON actividades_estudiante.id_actividades = A.id_actividades
			INNER JOIN uepjmc_jmc.estudiante B ON actividades_estudiante.id_estudiante = B.id_estudia
			WHERE
				A.id_actividades = :evaluacion AND  
				actividades_estudiante.id_estudiante = :alumno
		");
		$query->bindParam(':evaluacion', $evaluacion);
		$query->bindParam(':alumno', $alumno);
		$query->execute();
		$respuesta = $query->fetchAll(PDO::FETCH_OBJ);

		return  $respuesta;
	}

	public function getEvaluacionesEntregadas($evaluacion)
	{
		$query = $this->db->connect2()->prepare("
			SELECT
				A.id_actividades,
				A.id_profesorcursogrupo,
				A.id_plan_evaluacion,
				actividades_estudiante.id_estudiante,
				actividades_estudiante.fecha,
				actividades_estudiante.file1,
				actividades_estudiante.file2,
				actividades_estudiante.file3,
				actividades_estudiante.file4,
				actividades_estudiante.corregido,
				(SELECT notas.nota FROM notas WHERE notas.id_estudiante = actividades_estudiante.id_estudiante AND notas.id_plan_evaluacion = A.id_plan_evaluacion) as nota,
				(SELECT notas.observacion FROM notas WHERE notas.id_estudiante = actividades_estudiante.id_estudiante AND notas.id_plan_evaluacion = A.id_plan_evaluacion) as observacion,
				actividades_estudiante.id_actividades_estudiante,
				A.nlink1,
				A.nlink2,
				A.nlink3,
				A.nlink4,
				A.link1,
				A.link2,
				A.link3,
				A.link4,
				actividades_estudiante.nlink1,
				actividades_estudiante.nlink2,
				actividades_estudiante.nlink3,
				actividades_estudiante.nlink4,
				actividades_estudiante.link1,
				actividades_estudiante.link2,
				actividades_estudiante.link3,
				actividades_estudiante.link4,
				actividades_estudiante.descripcion,
				(SELECT notas.file1 FROM notas WHERE notas.id_estudiante = actividades_estudiante.id_estudiante AND notas.id_plan_evaluacion = A.id_plan_evaluacion) as revision1,
				(SELECT notas.file2 FROM notas WHERE notas.id_estudiante = actividades_estudiante.id_estudiante AND notas.id_plan_evaluacion = A.id_plan_evaluacion) as revision2,
				(SELECT notas.file3 FROM notas WHERE notas.id_estudiante = actividades_estudiante.id_estudiante AND notas.id_plan_evaluacion = A.id_plan_evaluacion) as revision3,
				(SELECT notas.file4 FROM notas WHERE notas.id_estudiante = actividades_estudiante.id_estudiante AND notas.id_plan_evaluacion = A.id_plan_evaluacion) as revision4,
				B.p_nombres as nombres,
				B.p_apellido as apellidos,
				B.cedula
			
			FROM uepjmc_aula.actividades A
			INNER JOIN plan_evaluacion ON A.id_plan_evaluacion = plan_evaluacion.id_plan_evaluacion
			INNER JOIN tipo_evaluacion ON plan_evaluacion.tipo_evaluacion = tipo_evaluacion.id_tipo_evaluacion
			INNER JOIN valor ON plan_evaluacion.valor = valor.id_valor
			INNER JOIN actividades_estudiante ON actividades_estudiante.id_actividades = A.id_actividades
			INNER JOIN uepjmc_jmc.estudiante B ON actividades_estudiante.id_estudiante = B.id_estudia
			WHERE
				A.id_actividades = :evaluacion
		");
		$query->bindParam(':evaluacion', $evaluacion);
		$query->execute();
		$respuesta = $query->fetchAll(PDO::FETCH_OBJ);
		

		return  $respuesta;
	}

	public function addEvaluacion($datos)
	{
		$query = $this->db->connect2()->prepare("
			INSERT INTO actividades(
				id_profesorcursogrupo,
				id_plan_evaluacion,
				publicacion,
				fecha,
				descripcion,
				lapso)
			VALUES(
				:materia,
				:plan,
				:publicado,
				:fecha,
				:descripcion,
				:lapso)
		");
		$query->bindParam(':materia',$datos['materia']);
		$query->bindParam(':plan',$datos['plan']);
		$query->bindParam(':publicado',$datos['publicado']);
		$query->bindParam(':fecha',$datos['fecha']);
		$query->bindParam(':descripcion',$datos['descripcion']);
		$query->bindParam(':lapso',$datos['lapso']);

		if ( $query->execute() ) {
			$respuesta = true;
		}else {
			$respuesta = false;
		}

		return $respuesta;
	}

	public function getIdEvaluacion($datos)
	{
		$query = $this->db->connect2()->prepare("
			SELECT * FROM actividades
			WHERE
			id_profesorcursogrupo = :materia AND
			id_plan_evaluacion = :plan AND
			publicacion = :publicado AND
			fecha = :fecha AND
			descripcion = :descripcion
		");
		$query->bindParam(':materia',$datos['materia']);
		$query->bindParam(':plan',$datos['plan']);
		$query->bindParam(':publicado',$datos['publicado']);
		$query->bindParam(':fecha',$datos['fecha']);
		$query->bindParam(':descripcion',$datos['descripcion']);
		$query->execute();
		$respuesta = $query->fetch()[0];

		return $respuesta;
	}

	public function updateArchivoEvaluacion($n, $materia, $actividad, $archivo)
	{
		$query = $this->db->connect2()->prepare("
			UPDATE actividades
			SET
			file".$n." = :archivo
			WHERE
			id_profesorcursogrupo = :materia AND
			id_actividades = :actividad
		");
		$query->bindParam(':archivo',$archivo);
		$query->bindParam(':materia',$materia);
		$query->bindParam(':actividad',$actividad);

		if ( $query->execute() ) {
			$respuesta = true;
		}else {
			$respuesta = false;
		}
		return $respuesta;
	}

	public function deleteEvaluacion($materia, $evaluacion)
	{
		$query = $this->db->connect2()->prepare("
			DELETE FROM actividades
			WHERE
			id_profesorcursogrupo = :materia AND
			id_actividades = :evaluacion
		");
		$query->bindParam(':materia',$materia);
		$query->bindParam(':evaluacion',$evaluacion);

		if ( $query->execute() ) {
			$respuesta = true;
		}else {
			$respuesta = false;
		}

		return $respuesta;
	}


	public function updateEvaluacion($datos)
	{
		$query = $this->db->connect2()->prepare("
			UPDATE actividades SET
			id_plan_evaluacion = :plan,
			publicacion = :publicado,
			fecha = :fecha,
			descripcion = :descripcion,
			lapso = :lapso
			WHERE
			id_profesorcursogrupo = :materia AND
			id_actividades = :evaluacion
		");
		$query->bindParam(':materia',$datos['materia']);
		$query->bindParam(':evaluacion',$datos['evaluacion']);
		$query->bindParam(':plan',$datos['plan']);
		$query->bindParam(':publicado',$datos['publicado']);
		$query->bindParam(':fecha',$datos['fecha']);
		$query->bindParam(':descripcion',$datos['descripcion']);
		$query->bindParam(':lapso',$datos['lapso']);

		if ( $query->execute() ) {
			$respuesta = true;
		}else {
			$respuesta = false;
		}

		return $respuesta;
	}


	public function addEvaluacionAlumno($datos)
	{
		$query = $this->db->connect2()->prepare("
		INSERT INTO actividades_estudiante(
			id_profesorcursogrupo,
			id_actividades,
			id_estudiante,
			fecha,
			descripcion,
			nlink1,
			nlink2,
			nlink3,
			nlink4,
			link1,
			link2,
			link3,
			link4)
		VALUES(
			:materia,
			:evaluacion,
			:alumno,
			:fecha,
			:descripcion,
			:nlink1,
			:nlink2,
			:nlink3,
			:nlink4,
			:link1,
			:link2,
			:link3,
			:link4)
		");
		$query->bindParam(':materia',$datos['materia']);
		$query->bindParam(':evaluacion',$datos['evaluacion']);
		$query->bindParam(':alumno',$datos['alumno']);
		$query->bindParam(':fecha',$datos['fecha']);
		$query->bindParam(':descripcion',$datos['descripcion']);
		$query->bindParam(':nlink1',$datos['nlink1']);
		$query->bindParam(':nlink2',$datos['nlink2']);
		$query->bindParam(':nlink3',$datos['nlink3']);
		$query->bindParam(':nlink4',$datos['nlink4']);
		$query->bindParam(':link1',$datos['link1']);
		$query->bindParam(':link2',$datos['link2']);
		$query->bindParam(':link3',$datos['link3']);
		$query->bindParam(':link4',$datos['link4']);

		if ( $query->execute() ) {
			$respuesta = true;
		}else {
			$respuesta = false;
		}

		return $respuesta;
	}

	public function updateArchivoEvaluacionAlumno($n, $datos, $archivo)
	{
		$query = $this->db->connect2()->prepare("
			UPDATE actividades_estudiante
			SET
				fecha = :fecha,
				file".$n." = :archivo
			WHERE
				id_estudiante = :alumno AND
				id_profesorcursogrupo = :materia AND
				id_actividades = :evaluacion
		");
		$query->bindParam(':materia',$datos['materia']);
		$query->bindParam(':evaluacion',$datos['evaluacion']);
		$query->bindParam(':fecha',$datos['fecha']);
		$query->bindParam(':archivo',$archivo);
		$query->bindParam(':alumno',$datos['alumno']);

		if ( $query->execute() ) {
			$respuesta = true;
		}else {
			$respuesta = false;
		}

		return $respuesta;
	}

	public function updateEvaluacionAlumno($datos)
	{
		$query = $this->db->connect2()->prepare("
		UPDATE actividades_estudiante
		SET
			fecha       = :fecha,
			descripcion = :descripcion,
			nlink1      = :nlink1,
			nlink2      = :nlink2,
			nlink3      = :nlink3,
			nlink4      = :nlink4,
			link1       = :link1,
			link2       = :link2,
			link3       = :link3,
			link4       = :link4
		WHERE
			id_actividades_estudiante = :evaluacionAlumno AND
			id_profesorcursogrupo     = :materia AND
			id_actividades            = :evaluacion AND
			id_estudiante             = :alumno
		");
		$query->bindParam(':materia',$datos['materia']);
		$query->bindParam(':evaluacion',$datos['evaluacion']);
		$query->bindParam(':evaluacionAlumno',$datos['evaluacionAlumno']);
		$query->bindParam(':alumno',$datos['alumno']);
		$query->bindParam(':fecha',$datos['fecha']);
		$query->bindParam(':descripcion',$datos['descripcion']);
		$query->bindParam(':nlink1',$datos['nlink1']);
		$query->bindParam(':nlink2',$datos['nlink2']);
		$query->bindParam(':nlink3',$datos['nlink3']);
		$query->bindParam(':nlink4',$datos['nlink4']);
		$query->bindParam(':link1',$datos['link1']);
		$query->bindParam(':link2',$datos['link2']);
		$query->bindParam(':link3',$datos['link3']);
		$query->bindParam(':link4',$datos['link4']);

		if ( $query->execute() ) {
			$respuesta = true;
		}else {
			$respuesta = false;
		}

		return $respuesta;
	}

}


?>