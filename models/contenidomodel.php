<?php

/**
 *
 */
class ContenidoModel extends Model
{
	function __construct()
	{
		parent::__construct();
	}

	public function getContenido($materia)
	{
		//$materia = (int)$Materia;
		$query = $this->db->connect2()->prepare("
			SELECT * FROM contenido
			WHERE id_profesorcursogrupo = :materia
			ORDER BY numero ASC
		");
		$query->bindParam(':materia',$materia);
		$query->execute();
		$respuesta = $query->fetchAll(PDO::FETCH_OBJ);

		return $respuesta;
	}

	public function deleteContendio($materia, $contenido)
	{
		$query = $this->db->connect2()->prepare("
			DELETE FROM contenido WHERE id_contenido = :contenido AND id_profesorcursogrupo = :materia
		");
		$query->bindParam(':contenido', $contenido);
		$query->bindParam(':materia', $materia);

		if ( $query->execute() ) {
			$respuesta = true;
		}else {
			$respuesta = false;
		}

		return $respuesta;
	}

	public function addContenido($datos)
	{
		$query = $this->db->connect2()->prepare("
			INSERT INTO contenido(
				id_profesorcursogrupo,
				numero,
				descripcion)
			VALUES(
				:materia,
				:numero,
				:descripcion)
		");
		$query->bindParam(':materia',$datos['materia']);
		$query->bindParam(':numero',$datos['numero']);
		$query->bindParam(':descripcion',$datos['descripcion']);

		if ( $query->execute() ) {
			$respuesta = true;
		}else {
			$respuesta = false;
		}

		return $respuesta;
	}

	public function getIdContenido($materia, $numero, $descripcion)
	{
		$query = $this->db->connect2()->prepare("
				SELECT id_contenido FROM contenido
				WHERE id_profesorcursogrupo = :materia
				AND numero = :numero
				AND descripcion = :descripcion
			");
		$query->bindParam(':materia', $materia);
		$query->bindParam(':numero', $numero);
		$query->bindParam(':descripcion', $descripcion);
		$query->execute();
		$respuesta = $query->fetch()[0];

		return $respuesta;
	}

	public function updateArchivo($n, $materia, $contenido, $archivo)
	{
		$query = $this->db->connect2()->prepare("
			UPDATE contenido
			SET
			file".$n." = :archivo
			WHERE
			id_contenido = :contenido AND
			id_profesorcursogrupo = :materia;
		");
		$query->bindParam(':archivo',$archivo);
		$query->bindParam(':contenido',$contenido);
		$query->bindParam(':materia',$materia);

		if ( $query->execute() ) {
			$respuesta = true;
		}else {
			$respuesta = false;
		}

		return $respuesta;
	}

	public function editContenido($datos)
	{
		$query = $this->db->connect2()->prepare("
			UPDATE contenido SET
			id_profesorcursogrupo = :materia,
			numero = :numero,
			descripcion = :descripcion
			WHERE id_contenido = :contenido;
		");
		$query->bindParam(':materia',$datos['materia']);
		$query->bindParam(':numero',$datos['numero']);
		$query->bindParam(':descripcion',$datos['descripcion']);
		$query->bindParam(':contenido',$datos['contenido']);


		if ( $query->execute() ) {
			$respuesta = true;
		}else {
			$respuesta = false;
		}

		return $respuesta;
	}
}


?>