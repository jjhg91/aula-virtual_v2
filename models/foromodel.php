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

	public function getTemas($materia)
	{
		$query = $this->db->connect2()->prepare("
			SELECT * FROM foro_tema 
			WHERE id_materia = :materia
		");
		$query->bindParam(':materia', $materia);
		$query->execute();
		$respuesta = $query->fetchAll();
		return $respuesta;
	}

	public function getIdTema($datos)
	{
		$query = $this->db->connect2()->prepare("
				SELECT
					id_foro_tema
				FROM foro_tema
				WHERE
					id_materia = :materia AND 
					titulo = :titulo AND 
					descripcion = :descripcion
			");
		$query->bindParam(':materia', $datos['materia']);
		$query->bindParam(':titulo', $datos['titulo']);
		$query->bindParam(':descripcion', $datos['descripcion']);
		$query->execute();
		$respuesta = $query->fetch()[0];

		return $respuesta;
	}

	public function getIdPost($datos)
	{
		$query = $this->db->connect2()->prepare("
				SELECT
					id_foro
				FROM foro
				WHERE
					id_profesorcursogrupo = :materia AND
					fecha = :fecha AND
					descripcion = :descripcion AND
					usuario = :usuario AND
					nivel = :nivel
			");
		$query->bindParam(':materia', $datos['materia']);
		$query->bindParam(':fecha', $datos['fecha']);
		$query->bindParam(':descripcion', $datos['mensaje']);
		$query->bindParam(':usuario', $datos['usuario']);
		$query->bindParam(':nivel', $datos['level']);
		$query->execute();
		$respuesta = $query->fetch()[0];

		return $respuesta;
	}

	public function getPostsGeneral($materia)
	{
		$query = $this->db->connect2()->prepare("
			SELECT * FROM foro
			WHERE
			id_profesorcursogrupo = :materia AND
			id_foro_tema is null
			ORDER BY STR_TO_DATE(fecha,'%m-%d-%Y') ASC
		");
		$query->bindParam(':materia', $materia);
		$query->execute();
		$res1 = $query->fetchAll();
		$respuesta = [];

		// DE 7  EN ADELANTE
		foreach ($res1 as $nombres) {
			if ($nombres[3] == 'alumno') {
				$query2 = $this->db->connect1()->prepare("
					SELECT p_nombres, p_apellido from estudiante
					WHERE id_estudia = :id
				");
				$query2->bindParam(':id', $nombres[2]);
				$query2->execute();
				$resp22 = $query2->fetch();
				$resp2[0] = $resp22[0] . " " . $resp22[1];

			} elseif($nombres[3] == 'profesor') {
				$query2 = $this->db->connect1()->prepare("
					SELECT nombres from personal
					WHERE id_personal = :id
				");
				$query2->bindParam(':id', $nombres[2]);
				$query2->execute();
				$resp2 = $query2->fetch();
			}

			//RESPUESTAS A PARTIR DE 9
			$query3 = $this->db->connect2()->prepare("
				SELECT * from foro_respuesta
				WHERE id_foro = :id_foro
			");
			$query3->bindParam('id_foro', $nombres[0]);
			$query3->execute();
			$resp3 = $query3->fetchAll();
			$respu = [];

			foreach ($resp3 as $respNombre) {
				if ($respNombre[3] == 'alumno') {
					$query4 = $this->db->connect1()->prepare("
						SELECT p_nombres, p_apellido from estudiante
						WHERE id_estudia = :id
					");
					$query4->bindParam(':id', $respNombre[2]);
					$query4->execute();
					$respN22 = $query4->fetch();
					$respN2[0] = $respN22[0] . " " . $respN22[1];


				} elseif($respNombre[3] == 'profesor') {
					$query4 = $this->db->connect1()->prepare("
						SELECT nombres from personal
						WHERE id_personal = :id
					");
					$query4->bindParam(':id', $respNombre[2]);
					$query4->execute();
					$respN2 = $query4->fetch();
				}
				$rrr = array_merge($respNombre,$respN2);
				array_push($respu,$rrr);
			}


			$item = new ForoPost();
			$item->post = $nombres;
			$item->nombre = $resp2[0];
			$item->respuestas = $respu;
			array_push($respuesta,$item);

		}

		return $respuesta;
	}

	public function getPosts($materia,$tema)
	{
		$query = $this->db->connect2()->prepare("
			SELECT * FROM foro
			WHERE
			id_profesorcursogrupo = :materia AND
			id_foro_tema = :tema
			ORDER BY STR_TO_DATE(fecha,'%m-%d-%Y') ASC
			");
		$query->bindParam(':materia', $materia);
		$query->bindParam(':tema', $tema);
		$query->execute();
		$res1 = $query->fetchAll();
		$respuesta = [];

		// DE 7  EN ADELANTE
		foreach ($res1 as $nombres) {
			if ($nombres[3] == 'alumno') {
				$query2 = $this->db->connect1()->prepare("
					SELECT p_nombres, p_apellido from estudiante
					WHERE id_estudia = :id
				");
				$query2->bindParam(':id', $nombres[2]);
				$query2->execute();
				$resp22 = $query2->fetch();
				$resp2[0] = $resp22[0] . " " . $resp22[1];


			} elseif($nombres[3] == 'profesor') {
				$query2 = $this->db->connect1()->prepare("
					SELECT nombres from personal
					WHERE id_personal = :id
				");
				$query2->bindParam(':id', $nombres[2]);
				$query2->execute();
				$resp2 = $query2->fetch();
			}

			//RESPUESTAS A PARTIR DE 9
			$query3 = $this->db->connect2()->prepare("
				SELECT * from foro_respuesta
				WHERE id_foro = :id_foro
			");
			$query3->bindParam('id_foro', $nombres[0]);
			$query3->execute();
			$resp3 = $query3->fetchAll();
			$respu = [];

			foreach ($resp3 as $respNombre) {
				if ($respNombre[3] == 'alumno') {
					$query4 = $this->db->connect1()->prepare("
						SELECT p_nombres, p_apellido from estudiante
						WHERE id_estudia = :id
					");
					$query4->bindParam(':id', $respNombre[2]);
					$query4->execute();
					$respN22 = $query4->fetch();
					$respN2[0] = $respN22[0] . " " . $respN22[1];


				} elseif($respNombre[3] == 'profesor') {
					$query4 = $this->db->connect1()->prepare("
						SELECT nombres from personal
						WHERE id_personal = :id
					");
					$query4->bindParam(':id', $respNombre[2]);
					$query4->execute();
					$respN2 = $query4->fetch();
				}
				$rrr = array_merge($respNombre,$respN2);
				array_push($respu,$rrr);
			}

			$item = new ForoPost();
			$item->post = $nombres;
			$item->nombre = $resp2[0];
			$item->respuestas = $respu;
			array_push($respuesta,$item);

		}

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

	public function addPost($datos)
	{
		$query = $this->db->connect2()->prepare("
			INSERT INTO foro(
				id_profesorcursogrupo,
				usuario,
				nivel,
				fecha,
				descripcion,
				id_foro_tema)
			VALUES(
				:materia,
				:usuario,
				:level,
				:fecha,
				:mensaje,
				:tema)
		");
		$query->bindParam(':materia',$datos['materia']);
		$query->bindParam(':usuario',$datos['usuario']);
		$query->bindParam(':level',$datos['level']);
		$query->bindParam(':fecha',$datos['fecha']);
		$query->bindParam(':mensaje',$datos['mensaje']);
		$query->bindParam(':tema',$datos['tema']);

		if	( $query->execute() ) {
			$respuesta = true;
		}else {
			$respuesta = false;
		}

		return $respuesta;
	}

	public function addRespuestaPost($datos)
	{
		$query = $this->db->connect2()->prepare("
			INSERT INTO foro_respuesta(
				id_foro,
				usuario,
				nivel,
				fecha,
				descripcion)
			VALUES(
				:post,
				:usuario,
				:level,
				:fecha,
				:mensaje)
		");
		$query->bindParam(':post',$datos['post']);
		$query->bindParam(':usuario',$datos['usuario']);
		$query->bindParam(':level',$datos['level']);
		$query->bindParam(':fecha',$datos['fecha']);
		$query->bindParam(':mensaje',$datos['mensaje']);

		if	( $query->execute() ) {
			$respuesta = true;
		}else {
			$respuesta = false;
		}

		return $respuesta;
	}

	public function deletePost($materia, $foro)
	{
		$query = $this->db->connect2()->prepare("
			DELETE FROM foro
			WHERE
			id_profesorcursogrupo = :materia AND
			id_foro = :foro
		");
		$query->bindParam(':materia',$materia);
		$query->bindParam(':foro',$foro);

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