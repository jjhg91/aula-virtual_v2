<?php

/**
 *
 */
class PlanModel extends Model
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
			INNER JOIN semana ON plan_evaluacion.semana = semana.id_semana
			WHERE
			id_profesorcursogrupo = :materia
			ORDER BY semana.descripcion ASC
		");
		$query->bindParam(':materia', $materia);
		$query->execute();
		$respuesta = $query->fetchAll(PDO::FETCH_OBJ);

		if ( $respuesta) {
			return $respuesta;
		}else{
			return false;
		}
	}

	public function getIdPlan($datos)
	{
		$query = $this->db->connect2()->prepare("
			SELECT
			id_plan_evaluacion
			FROM plan_evaluacion
			INNER JOIN tipo_evaluacion ON plan_evaluacion.tipo_evaluacion = tipo_evaluacion.id_tipo_evaluacion
			INNER JOIN valor ON plan_evaluacion.valor = valor.id_valor
			INNER JOIN semana ON plan_evaluacion.semana = semana.id_semana
			WHERE
			plan_evaluacion.id_profesorcursogrupo = :materia AND
			plan_evaluacion.valor = :valor AND
			plan_evaluacion.tipo_evaluacion = :tipo AND
			plan_evaluacion.semana = :semana AND
			plan_evaluacion.descripcion = :descripcion
		");
		
		$query->bindParam(':materia', $datos['materia']);
		$query->bindParam(':valor', $datos['valor']);
		$query->bindParam(':tipo', $datos['tipo']);
		$query->bindParam(':semana', $datos['semana']);
		$query->bindParam(':descripcion', $datos['descripcion']);

		$query->execute();
		$respuesta = $query->fetch()[0];

		if ( $respuesta) {
			return $respuesta;
		}else{
			return false;
		}
	}

	public function getTipoEvaluacion()
	{
		$query = $this->db->connect2()->query("SELECT * FROM tipo_evaluacion");
		$respuesta = $query->fetchAll();

		return $respuesta;
	}

	public function getValor()
	{
		$query = $this->db->connect2()->query("SELECT * FROM valor");
		$respuesta = $query->fetchAll();

		return $respuesta;
	}

	public function getSemana()
	{
		$query = $this->db->connect2()->query("SELECT * FROM semana");
		$respuesta = $query->fetchAll();

		return $respuesta;
	}

	public function deletePlan($materia, $plan)
	{
		$query = $this->db->connect2()->prepare("
			DELETE FROM plan_evaluacion WHERE id_plan_evaluacion = :plan AND id_profesorcursogrupo = :materia
		");
		$query->bindParam(':plan', $plan);
		$query->bindParam(':materia', $materia);

		if ( $query->execute() ) {
			$respuesta = true;
		}else {
			$respuesta = false;
		}

		return $respuesta;
	}

	public function addPlan($datos)
	{
		$query = $this->db->connect2()->prepare("
			SELECT
			SUM(valor.descripcion),
			COUNT(valor.descripcion)
			FROM plan_evaluacion
			INNER JOIN valor on plan_evaluacion.valor = valor.id_valor
			WHERE plan_evaluacion.id_profesorcursogrupo = :materia
		");
		$query->bindParam(':materia',$datos['materia']);
		$query->execute();
		$sc = $query->fetch();

		$val = $this->db->connect2()->prepare("
				SELECT descripcion FROM valor
				WHERE
				id_valor = :valor
			");
		$val->bindParam(':valor', $datos['valor']);
		$val->execute();
		$valor = $val->fetch();

		$prevenir = (int)$sc[0] + (int)$valor[0];
		if ( $prevenir <= 100 ) {
			if ( $sc[1] < 10 ) {
				if ( !empty($datos['otros']) && $datos['tipo'] == 8 ) {
					$query2 = $this->db->connect2()->prepare("
						INSERT INTO plan_evaluacion(
							id_profesorcursogrupo,
							tipo_evaluacion,
							otros,
							valor,
							descripcion,
							semana,
							lapso)
						VALUES(
							:materia,
							:tipo,
							:otros,
							:valor,
							:descripcion,
							:semana,
							:lapso)
					");
					$query2->bindParam(':materia',$datos['materia']);
					$query2->bindParam(':tipo',$datos['tipo']);
					$query2->bindParam(':otros',$datos['otros']);
					$query2->bindParam(':valor',$datos['valor']);
					$query2->bindParam(':descripcion',$datos['descripcion']);
					$query2->bindParam(':semana',$datos['semana']);
					$query2->bindParam(':lapso',$datos['lapso']);
					$query2->execute();
					$respuesta = true;
				}else {
					$query2 = $this->db->connect2()->prepare("
						INSERT INTO plan_evaluacion(
							id_profesorcursogrupo,
							tipo_evaluacion,
							valor,
							descripcion,
							semana,
							lapso)
						VALUES(
							:materia,
							:tipo,
							:valor,
							:descripcion,
							:semana,
							:lapso)
					");
					$query2->bindParam(':materia',$datos['materia']);
					$query2->bindParam(':tipo',$datos['tipo']);
					$query2->bindParam(':valor',$datos['valor']);
					$query2->bindParam(':descripcion',$datos['descripcion']);
					$query2->bindParam(':semana',$datos['semana']);
					$query2->bindParam(':lapso',$datos['lapso']);
					$query2->execute();
					$respuesta = true;
				}
			}else {
				$respuesta = false;
			}
		}else {
			$respuesta = false;
		}
		return $respuesta;
	}


	public function updatePlan($datos)
	{
		$query = $this->db->connect2()->prepare("
			UPDATE plan_evaluacion SET
			id_profesorcursogrupo = :materia,
			tipo_evaluacion = :tipo,
			otros = :otros,
			valor = :valor,
			descripcion = :descripcion,
			semana = :semana,
			lapso = :lapso
			WHERE
			id_plan_evaluacion = :plan
		");
		$query->bindParam(':materia',$datos['materia']);
		$query->bindParam(':tipo',$datos['tipo']);
		$query->bindParam(':otros',$datos['otros']);
		$query->bindParam(':valor',$datos['valor']);
		$query->bindParam(':descripcion',$datos['descripcion']);
		$query->bindParam(':semana',$datos['semana']);
		$query->bindParam(':lapso',$datos['lapso']);
		$query->bindParam(':plan',$datos['plan']);

		if ( $query->execute() ) {
			$respuesta = true;
		}else {
			$respuesta = false;
		}

		return $respuesta;
	}
}


?>