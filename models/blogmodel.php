<?php

/**
 *
 */
class BlogModel extends Model
{
	function __construct()
	{
		parent::__construct();
	}

	public function getPosts($materia)
	{
		$query = $this->db->connect2()->prepare("
			SELECT * FROM blog
			WHERE id_profesorcursogrupo = :materia
			ORDER BY STR_TO_DATE(fecha,'%d-%m-%Y') ASC
		");
		$query->bindParam(':materia', $materia);
		$query->execute();
		$respuesta = $query->fetchAll(PDO::FETCH_OBJ);

		return $respuesta;
	}

	public function deleteBlog($materia, $blog)
	{
		$query = $this->db->connect2()->prepare("
			DELETE FROM blog
			WHERE
			id_profesorcursogrupo = :materia AND
			id_blog = :blog
		");
		$query->bindParam(':materia', $materia);
		$query->bindParam(':blog', $blog);

		if ( $query->execute() ) {
			$respuesta = true;
		}else {
			$respuesta = false;
		}

		return $respuesta;
	}

	public function addBlog($datos)
	{
		$query = $this->db->connect2()->prepare("
			INSERT INTO blog(
				id_profesorcursogrupo,
				fecha,
				descripcion,
				titulo,
				lapso)
			VALUES(
				:materia,
				:fecha,
				:descripcion,
				:titulo,
				:lapso)
		");
		$query->bindParam(':materia',$datos['materia']);
		$query->bindParam(':fecha',$datos['fecha']);
		$query->bindParam(':descripcion',$datos['descripcion']);
		$query->bindParam(':titulo',$datos['titulo']);
		$query->bindParam(':lapso',$datos['lapso']);

		if ( $query->execute() ) {
			$respuesta = true;
		}else {
			$respuesta = false;
		}

		return $respuesta;
	}

	public function getIdBlog($materia, $fecha, $titulo, $descripcion)
	{
		$query = $this->db->connect2()->prepare("
			SELECT * FROM blog
			WHERE
			id_profesorcursogrupo = :materia AND
			fecha = :fecha AND
			titulo = :titulo AND
			descripcion = :descripcion
			");
		$query->bindParam(':materia', $materia);
		$query->bindParam(':fecha', $fecha);
		$query->bindParam(':titulo', $titulo);
		$query->bindParam(':descripcion', $descripcion);
		$query->execute();
		$respuesta = $query->fetch()[0];
		
		return $respuesta;
	}

	public function updateArchivo($n, $materia, $blog, $archivo)
	{
		$query = $this->db->connect2()->prepare("
			UPDATE blog
			SET
			file".$n." = :archivo
			WHERE
			id_blog = :blog AND
			id_profesorcursogrupo = :materia;
		");
		$query->bindParam(':archivo',$archivo);
		$query->bindParam(':blog',$blog);
		$query->bindParam(':materia',$materia);

		if ( $query->execute() ) {
			$respuesta = true;
		}else {
			$respuesta = false;
		}

		return $respuesta;
	}

	public function editBlog($datos)
	{
		$query = $this->db->connect2()->prepare("
			UPDATE blog SET
			id_profesorcursogrupo = :materia,
			fecha = :fecha,
			descripcion = :descripcion,
			titulo = :titulo,
			lapso = :lapso
			WHERE id_blog = :blog
		");
		$query->bindParam(':materia',$datos['materia']);
		$query->bindParam(':fecha',$datos['fecha']);
		$query->bindParam(':descripcion',$datos['descripcion']);
		$query->bindParam(':titulo',$datos['titulo']);
		$query->bindParam(':lapso',$datos['lapso']);

		$query->bindParam(':blog',$datos['blog']);


		if ( $query->execute() ) {
			$respuesta = true;
		}else {
			$respuesta = false;
		}

		return $respuesta;
	}
}


?>