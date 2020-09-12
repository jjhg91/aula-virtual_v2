<?php 

/**
 * 
 */
class AdminModel extends Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	
	public function totalPeriodos()
	{
		$query = $this->db->connect1()->prepare("
		SELECT COUNT(*) AS total FROM periodo
		");
		// $query->bindParam('',$datos['']);
		// $query->bindParam('',$datos['']);
		$query->execute();
		$resultado = $query->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function getPeriodos($pos, $n)
	{
		$query = $this->db->connect1()->prepare("
			SELECT * FROM periodo 
			INNER JOIN status_periodo ON status_periodo.id_status = periodo.status
			ORDER BY id_periodo DESC
			LIMIT ".$pos.", ".$n."
		");
		$query->execute();
		$resultado = $query->fetchAll();
		return $resultado;
	}
	


	public function addPeriodo($datos)
	{
		$query =  $this->db->connect1()->prepare("
			INSERT INTO
			periodo(
				periodo,
				lapso,
				status)
			VALUES (
				:periodo,
				:lapso,
				:estatus)
		");
		$query->bindParam(':periodo', $datos['periodo']);
		$query->bindParam(':lapso', $datos['lapso']);
		$query->bindParam(':estatus', $datos['estatus']);
		if ( $query->execute() ) {
			$resultado = true;
		}else{
			$resultado = false;
		}
		return $resultado;
	}

	public function getPeriodo($datos)
	{
		$query = $this->db->connect1()->prepare("
			SELECT 
				periodo.id_periodo,
				periodo.periodo,
				periodo.lapso,
				status_periodo.status
			FROM periodo
			INNER JOIN status_periodo ON status_periodo.id_status = periodo.status
			WHERE
				periodo.periodo = :periodo AND
				periodo.status = :estatus
		");
		$query->bindParam(':periodo',$datos['periodo']);
		$query->bindParam(':estatus',$datos['estatus']);
		$query->execute();
		$resultado = $query->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function deletePeriodo($periodo)
	{
		$query = $this->db->connect1()->prepare("
			DELETE FROM periodo WHERE id_periodo = :periodo
		");
		$query->bindParam(':periodo', $periodo);

		if ( $query->execute() ) {
			$respuesta = true;
		}else {
			$respuesta = false;
		}
		return $respuesta;
	}
	
	public function updatePeriodo($datos)
	{
		$query = $this->db->connect1()->prepare("
			UPDATE periodo SET
			periodo = :periodo,
			lapso = :lapso,
			status = :estatus
			WHERE
			id_periodo = :id_periodo
		");
		$query->bindParam(':periodo',$datos['periodo']);
		$query->bindParam(':lapso',$datos['lapso']);
		$query->bindParam(':estatus',$datos['estatus']);
		$query->bindParam(':id_periodo',$datos['id_periodo']);


		if ( $query->execute() ) {
			$respuesta = true;
		}else {
			$respuesta = false;
		}

		return $respuesta;
	}




	/////////// PROFESORES

	public function totalProfesores()
	{
		$query = $this->db->connect1()->prepare("
		SELECT COUNT(*) AS total FROM personal
		");
		// $query->bindParam('',$datos['']);
		// $query->bindParam('',$datos['']);
		$query->execute();
		$resultado = $query->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function getProfesores($pos, $n)
	{
		$query = $this->db->connect1()->prepare("
			SELECT * FROM personal 
			ORDER BY id_personal DESC
			LIMIT ".$pos.", ".$n."
		");
		$query->execute();
		$resultado = $query->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function deleteProfesor($profesor)
	{
		$query = $this->db->connect1()->prepare("
			DELETE FROM personal WHERE id_personal = :profesor
		");
		$query->bindParam(':profesor', $profesor);

		if ( $query->execute() ) {
			$respuesta = true;
		}else {
			$respuesta = false;
		}
		return $respuesta;
	}

	public function getProfesor($datos)
	{
		$query = $this->db->connect1()->prepare("
			SELECT
				*
			FROM personal
			WHERE
				cedu_pers = :cedula
		");
		$query->bindParam(':cedula',$datos['cedula']);
		$query->execute();
		$resultado = $query->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}


	
	public function addProfesor($datos)
	{
		$query =  $this->db->connect1()->prepare("
			INSERT INTO
			personal(
				cedu_pers,
				nombres,
				email,
				tlf)
			VALUES (
				:cedula,
				:nombre,
				:email,
				:tlf)
		");
		$query->bindParam(':cedula', $datos['cedula']);
		$query->bindParam(':nombre', $datos['nombre']);
		$query->bindParam(':email', $datos['email']);
		$query->bindParam(':tlf', $datos['tlf']);
		if ( $query->execute() ) {
			$resultado = true;
		}else{
			$resultado = false;
		}
		return $resultado;
	}


	
	public function updateProfesor($datos)
	{
		$query = $this->db->connect1()->prepare("
			UPDATE personal SET
			cedu_pers = :cedula,
			nombres = :nombre,
			email = :email,
			tlf = :tlf
			WHERE
			id_personal = :id
		");
		$query->bindParam(':cedula',$datos['cedula']);
		$query->bindParam(':nombre',$datos['nombre']);
		$query->bindParam(':email',$datos['email']);
		$query->bindParam(':tlf',$datos['tlf']);
		$query->bindParam(':id',$datos['id']);

		if ( $query->execute() ) {
			$respuesta = true;
		}else {
			$respuesta = false;
		}

		return $respuesta;
	}



	/// GRADOS 

	public function totalGrados()
	{
		$query = $this->db->connect1()->prepare("
		SELECT COUNT(*) AS total FROM profesorcursogrupo 
		INNER JOIN pensum ON pensum.id_pensum = profesorcursogrupo.curso
		GROUP BY profesorcursogrupo.seccion, pensum.id_especialidad
		");
		// $query->bindParam('',$datos['']);
		// $query->bindParam('',$datos['']);
		$query->execute();
		$resultado = $query->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function getGrados($pos, $n)
	{
		$query = $this->db->connect1()->prepare("
		SELECT
			profesorcursogrupo.id_profesorcursogrupo,
			educacion.descripcion,
			especialidad.especial,
			seccion.seccion,
			periodo.periodo
		FROM `profesorcursogrupo`
		INNER JOIN pensum ON pensum.id_pensum = profesorcursogrupo.curso
		INNER JOIN especialidad ON especialidad.id_especialidad = pensum.id_especialidad
		INNER JOIN seccion ON seccion.id_seccion = profesorcursogrupo.seccion
		INNER JOIN educacion on educacion.id_educacion = especialidad.educacion
		INNER JOIN periodo ON periodo.id_periodo = profesorcursogrupo.periodo
		GROUP BY profesorcursogrupo.seccion, pensum.id_especialidad
		ORDER BY especialidad.especial ASC, seccion.seccion ASC
		LIMIT ".$pos.", ".$n."
		");
		$query->execute();
		$resultado = $query->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function getGradoSeccion($datos)
	{
		$query = $this->db->connect1()->prepare("
		SELECT
			profesorcursogrupo.id_profesorcursogrupo,
			educacion.descripcion,
			especialidad.especial,
			seccion.seccion,
			periodo.periodo
		FROM `profesorcursogrupo`
		INNER JOIN pensum ON pensum.id_pensum = profesorcursogrupo.curso
		INNER JOIN especialidad ON especialidad.id_especialidad = pensum.id_especialidad
		INNER JOIN seccion ON seccion.id_seccion = profesorcursogrupo.seccion
		INNER JOIN educacion on educacion.id_educacion = especialidad.educacion
		INNER JOIN periodo ON periodo.id_periodo = profesorcursogrupo.periodo
		WHERE
			especialidad.id_especialidad = :grado AND
			seccion.id_seccion = :seccion AND
			periodo.id_periodo = :periodo
		GROUP BY profesorcursogrupo.seccion, pensum.id_especialidad
		ORDER BY especialidad.especial ASC, seccion.seccion ASC
		LIMIT 1
		");
		$query->bindParam('grado',$datos['grado']);
		$query->bindParam('seccion',$datos['seccion']);
		$query->bindParam('periodo',$datos['periodo']);
		$query->execute();
		$resultado = $query->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function getEducacion()
	{
		$query = $this->db->connect1()->prepare("
		SELECT
			*
		FROM educacion
		");
		$query->execute();
		$resultado = $query->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}
	public function getGradoEspecialidad()
	{
		$query = $this->db->connect1()->prepare("
		SELECT
			especialidad.id_especialidad,
			especialidad.especial,
			educacion.descripcion
		FROM especialidad
		INNER JOIN educacion ON educacion.id_educacion = especialidad.educacion
		ORDER BY educacion.id_educacion ASC, especialidad.id_especialidad ASC
		");
		$query->execute();
		$resultado = $query->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function getSeccion()
	{
		$query = $this->db->connect1()->prepare("
		SELECT
			*
		FROM seccion
		");
		$query->execute();
		$resultado = $query->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function addGrado($datos)
	{
		$queryMaterias = $this->db->connect1()->prepare("
			SELECT * FROM pensum WHERE id_especialidad = :grado
		");
		$queryMaterias->bindParam(':grado',$datos['grado']);
		$queryMaterias->execute();
		$materias = $queryMaterias->fetchAll(PDO::FETCH_ASSOC);

		foreach ($materias as $materia) {
			$query =  $this->db->connect1()->prepare("
				INSERT INTO
				profesorcursogrupo(
					curso,
					grupo,
					periodo,
					seccion)
				VALUES (
					:curso,
					1,
					:periodo,
					:seccion)
			");
			$query->bindParam(':curso', $materia['id_pensum']);
			$query->bindParam(':periodo', $datos['periodo']);
			$query->bindParam(':seccion', $datos['seccion']);
			$query->execute();
		}

		return true;
	}


	public function getInscritos($datos)
	{
		$query = $this->db->connect1()->prepare("
			SELECT
				inscripcion.id_inscripcion,
				especialidad.especial,
				pensum.descripcion,
				periodo.periodo,
				seccion.seccion,
				estudiante.p_nombres,
				estudiante.p_apellido,
				estudiante.cedula
			FROM
				`inscripcion`
			INNER JOIN profesorcursogrupo ON profesorcursogrupo.id_profesorcursogrupo = inscripcion.id_profesorcursogrupo
			INNER JOIN pensum ON pensum.id_pensum = profesorcursogrupo.curso
			INNER JOIN periodo ON periodo.id_periodo = profesorcursogrupo.periodo
			INNER JOIN seccion ON seccion.id_seccion = profesorcursogrupo.seccion
			INNER JOIN especialidad ON especialidad.id_especialidad = pensum.id_especialidad
			INNER JOIN estudiante ON estudiante.id_estudia = inscripcion.id_estudia
			WHERE
				especialidad.especial = :grado AND seccion.seccion = :seccion AND periodo.periodo = :periodo
			GROUP BY
				especialidad.especial,
				seccion.seccion,
				periodo.periodo,
				estudiante.id_estudia
		");
		$query->bindParam(':grado',$datos['grado']);
		$query->bindParam(':seccion',$datos['seccion']);
		$query->bindParam(':periodo',$datos['periodo']);
		$query->execute();
		$resultado = $query->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function getInscrito($datos)
	{
		$query = $this->db->connect1()->prepare("
			SELECT
				inscripcion.id_inscripcion,
				especialidad.especial,
				pensum.descripcion,
				periodo.periodo,
				seccion.seccion,
				estudiante.p_nombres,
				estudiante.p_apellido,
				estudiante.cedula
			FROM
				`inscripcion`
			INNER JOIN profesorcursogrupo ON profesorcursogrupo.id_profesorcursogrupo = inscripcion.id_profesorcursogrupo
			INNER JOIN pensum ON pensum.id_pensum = profesorcursogrupo.curso
			INNER JOIN periodo ON periodo.id_periodo = profesorcursogrupo.periodo
			INNER JOIN seccion ON seccion.id_seccion = profesorcursogrupo.seccion
			INNER JOIN especialidad ON especialidad.id_especialidad = pensum.id_especialidad
			INNER JOIN estudiante ON estudiante.id_estudia = inscripcion.id_estudia
			WHERE
				especialidad.especial = :grado AND 
				seccion.seccion = :seccion AND 
				periodo.periodo = :periodo AND 
				estudiante.cedula = :cedula
			GROUP BY
				especialidad.especial,
				seccion.seccion,
				periodo.periodo,
				estudiante.id_estudia
		");
		$query->bindParam(':grado',$datos['grado']);
		$query->bindParam(':seccion',$datos['seccion']);
		$query->bindParam(':periodo',$datos['periodo']);
		$query->bindParam(':cedula',$datos['cedula']);
		$query->execute();
		$resultado = $query->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function addInscripcionAlumno($datos)
	{
		$queryMaterias = $this->db->connect1()->prepare("
			SELECT
				profesorcursogrupo.id_profesorcursogrupo,
				especialidad.especial,
				pensum.descripcion,
				periodo.periodo
			FROM
				profesorcursogrupo
			INNER JOIN pensum ON pensum.id_pensum = profesorcursogrupo.curso
			INNER JOIN especialidad ON especialidad.id_especialidad = pensum.id_especialidad
			INNER JOIN seccion ON seccion.id_seccion = profesorcursogrupo.seccion
			INNER JOIN periodo ON periodo.id_periodo = profesorcursogrupo.periodo
			WHERE
				especialidad.especial = :grado AND
				seccion.seccion = :seccion AND
				periodo.periodo = :periodo
		");
		$queryMaterias->bindParam(':grado',$datos['grado']);
		$queryMaterias->bindParam(':seccion',$datos['seccion']);
		$queryMaterias->bindParam(':periodo',$datos['periodo']);
		$queryMaterias->execute();
		$materias = $queryMaterias->fetchAll(PDO::FETCH_ASSOC);

		$queryAlumno = $this->db->connect1()->prepare("
			SELECT
				*
			FROM
				estudiante
			WHERE
				cedula = :cedula
		");
		$queryAlumno->bindParam(':cedula',$datos['cedula']);
		$queryAlumno->execute();
		$alumno = $queryAlumno->fetch(PDO::FETCH_ASSOC);

		foreach ($materias as $materia) {
			$query =  $this->db->connect1()->prepare("
				INSERT INTO inscripcion(
					id_estudia,
					id_profesorcursogrupo
				)
				VALUES(
					:alumno,
					:materia
				)
			");
			$query->bindParam(':alumno', $alumno['id_estudia']);
			$query->bindParam(':materia', $materia['id_profesorcursogrupo']);
			$query->execute();
		}

		return true;
	}

	public function deleteGrado($datos)
	{
		$query = $this->db->connect1()->prepare("
			DELETE
				profesorcursogrupo
			FROM
				profesorcursogrupo
			INNER JOIN pensum ON pensum.id_pensum = profesorcursogrupo.curso
			INNER JOIN especialidad ON especialidad.id_especialidad = pensum.id_especialidad
			INNER JOIN seccion ON seccion.id_seccion = profesorcursogrupo.seccion
			INNER JOIN periodo ON periodo.id_periodo = profesorcursogrupo.periodo
			WHERE
				especialidad.especial = :grado AND seccion.seccion = :seccion AND periodo.periodo = :periodo
		");
		$query->bindParam(':grado', $datos['grado']);
		$query->bindParam(':seccion', $datos['seccion']);
		$query->bindParam(':periodo', $datos['periodo']);

		if ( $query->execute() ) {
			$respuesta = true;
		}else {
			$respuesta = false;
		}
		return $respuesta;
	}

	public function deleteInscripcion($datos)
	{
		$query = $this->db->connect1()->prepare("
			DELETE
				inscripcion
			FROM
				inscripcion
			INNER JOIN profesorcursogrupo ON profesorcursogrupo.id_profesorcursogrupo = inscripcion.id_profesorcursogrupo
			INNER JOIN pensum ON pensum.id_pensum = profesorcursogrupo.curso
			INNER JOIN periodo ON periodo.id_periodo = profesorcursogrupo.periodo
			INNER JOIN seccion ON seccion.id_seccion = profesorcursogrupo.seccion
			INNER JOIN especialidad ON especialidad.id_especialidad = pensum.id_especialidad
			INNER JOIN estudiante ON estudiante.id_estudia = inscripcion.id_estudia
			WHERE
				especialidad.especial = :grado AND
				seccion.seccion = :seccion AND
				periodo.periodo = :periodo AND
				estudiante.cedula = :cedula
		");
		$query->bindParam(':grado', $datos['grado']);
		$query->bindParam(':seccion', $datos['seccion']);
		$query->bindParam(':periodo', $datos['periodo']);
		$query->bindParam(':cedula', $datos['cedula']);

		if ( $query->execute() ) {
			$respuesta = true;
		}else {
			$respuesta = false;
		}
		return $respuesta;
	}


	////////////// ASIGNATURAS
	
	public function totalAsignaturas()
	{
		$query = $this->db->connect1()->prepare("
		SELECT COUNT(*) AS total FROM profesorcursogrupo
		");
		$query->execute();
		$resultado = $query->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function getAsignaturas($pos, $n)
	{
		$query = $this->db->connect1()->prepare("
			SELECT
				profesorcursogrupo.id_profesorcursogrupo,
				educacion.descripcion AS educacion,
				especialidad.especial,
				seccion.seccion,
				periodo.periodo,
				pensum.descripcion AS pensum,
				personal.cedu_pers,
				personal.nombres
			FROM
				profesorcursogrupo
			INNER JOIN pensum ON pensum.id_pensum = profesorcursogrupo.curso
			INNER JOIN especialidad ON especialidad.id_especialidad = pensum.id_especialidad
			INNER JOIN educacion ON educacion.id_educacion = especialidad.educacion
			INNER JOIN seccion ON seccion.id_seccion = profesorcursogrupo.seccion
			INNER JOIN periodo ON periodo.id_periodo = profesorcursogrupo.periodo
			LEFT JOIN personal ON personal.id_personal = profesorcursogrupo.personal
			ORDER BY
				id_profesorcursogrupo
			DESC
			LIMIT ".$pos.", ".$n."
		");
		$query->execute();
		$resultado = $query->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}


	public function updateMateriaProfesor($datos)
	{

		$queryProfesor = $this->db->connect1()->prepare("
			SELECT
				*
			FROM
				personal
			WHERE
				cedu_pers = :cedula
			LIMIT 1
		");
		$queryProfesor->bindParam(':cedula',$datos['cedula']);
		$queryProfesor->execute();
		$profesor = $queryProfesor->fetch(PDO::FETCH_ASSOC);
		
		if( $profesor ){
			$query = $this->db->connect1()->prepare("
				UPDATE profesorcursogrupo SET
				personal = :profesor
				WHERE
				id_profesorcursogrupo = :id
			");
			$query->bindParam(':profesor',$profesor['id_personal']);
			$query->bindParam(':id',$datos['id']);
			$query->execute();

			return $profesor;
		}else {
			return false;
		}	
	}


	/////////// ALUMNOS

	public function totalAlumnos()
	{
		$query = $this->db->connect1()->prepare("
		SELECT COUNT(*) AS total FROM estudiante
		");
		// $query->bindParam('',$datos['']);
		// $query->bindParam('',$datos['']);
		$query->execute();
		$resultado = $query->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function getAlumnos($pos, $n)
	{
		$query = $this->db->connect1()->prepare("
			SELECT * FROM estudiante 
			ORDER BY id_estudia DESC
			LIMIT ".$pos.", ".$n."
		");
		$query->execute();
		$resultado = $query->fetchAll(PDO::FETCH_ASSOC);
		return $resultado;
	}

	public function deleteAlumno($alumno)
	{
		$query = $this->db->connect1()->prepare("
			DELETE FROM estudiante WHERE id_estudia = :alumno
		");
		$query->bindParam(':alumno', $alumno);

		if ( $query->execute() ) {
			$respuesta = true;
		}else {
			$respuesta = false;
		}
		return $respuesta;
	}

	public function getAlumno($datos)
	{
		$query = $this->db->connect1()->prepare("
			SELECT
				*
			FROM estudiante
			WHERE
				cedula = :cedula
		");
		$query->bindParam(':cedula',$datos['cedula']);
		$query->execute();
		$resultado = $query->fetch(PDO::FETCH_ASSOC);
		return $resultado;
	}


	
	public function addAlumno($datos)
	{
		$queryID = $this->db->connect1()->prepare(" 
			SELECT id_estudia FROM estudiante
			ORDER BY id_estudia DESC
			LIMIT 1
		");
		$queryID->execute();
		$id_estudia = $queryID->fetch(PDO::FETCH_ASSOC);
		$id= ($id_estudia)? ((int)$id_estudia['id_estudia'] + 1): "1";


		
		$query =  $this->db->connect1()->prepare("
			INSERT INTO
			estudiante(
				id_estudia,
				cedula,
				p_nombres,
				p_apellido,
				email,
				tlf1,
				representante)
			VALUES (
				:id_estudia,
				:cedula,
				:nombre,
				:apellido,
				:email,
				:tlf,
				:representante)
		");
		$query->bindParam(':id_estudia', $id);
		$query->bindParam(':cedula', $datos['cedula']);
		$query->bindParam(':nombre', $datos['nombre']);
		$query->bindParam(':apellido', $datos['apellido']);
		$query->bindParam(':email', $datos['email']);
		$query->bindParam(':tlf', $datos['tlf']);
		$query->bindParam(':representante', $datos['representante']);
		if ( $query->execute() ) {
			$resultado = true;
		}else{
			$resultado = false;
		}
		return $resultado;
	}


	
	public function updateAlumno($datos)
	{
		$query = $this->db->connect1()->prepare("
			UPDATE estudiante SET
			cedula = :cedula,
			p_nombres = :nombre,
			p_apellido = :apellido,
			email = :email,
			tlf1 = :tlf,
			representante = :representante
			WHERE
			id_estudia = :id
		");
		$query->bindParam(':cedula',$datos['cedula']);
		$query->bindParam(':nombre',$datos['nombre']);
		$query->bindParam(':apellido',$datos['apellido']);
		$query->bindParam(':email',$datos['email']);
		$query->bindParam(':tlf',$datos['tlf']);
		$query->bindParam(':representante',$datos['representante']);
		$query->bindParam(':id',$datos['id_estudia']);

		if ( $query->execute() ) {
			$respuesta = true;
		}else {
			$respuesta = false;
		}

		return $respuesta;
	}


}


?>