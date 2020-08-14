<?php
require_once 'navbar.php';
/**
 *
 */
class Blog extends Controller
{
	function __construct()
	{
		parent::__construct();
	}

	public function render()
	{
		$sesion = new Sesion();
		$sesion->validateSesion();
		$usuario = $sesion->getSesion();

		$navbar = new Navbar($usuario);
		$navbarMaterias = $navbar->buscarMaterias($usuario);
		$this->view->usuario = $usuario;
		$this->view->navbarMaterias = $navbarMaterias;

		echo 'Blog';
	}

	public function all($materia)
	{
		$sesion = new Sesion();
		$sesion->validateSesion();
		$usuario = $sesion->getSesion();

		$navbar = new Navbar($usuario);
		$navbarMaterias = $navbar->navbarMaterias($usuario);

		$this->view->usuario = $usuario;
		$this->view->navbarMaterias = $navbarMaterias;


		if (  ctype_digit($materia[0]) ) {

			$barMateria = $navbar->barMateria($usuario,$materia[0]);
			if ($barMateria) {
				$this->view->barMateria = $barMateria;
				$posts = $this->model->getPosts($materia[0]);
				$this->view->posts = $posts;
				$this->view->render('blog/index');

			}else{
				echo "MATERIA NO VALIDA O NO INSCRITA";
			}

		}else{
			echo "DIRECCION URL INVALIDA";
			exit;
		}
	}

	public function delete($url)
	{
		$materia = $url[0];
		$blog = $url[1];

		$sesion = new Sesion();
		$sesion->validateSesion();
		$usuario = $sesion->getSesion();
		$respuesta = ['status' => false, 'respuesta' => ""];

		if (  ctype_digit($materia) && ctype_digit($blog) ) {
			$navbar = new Navbar($usuario);
			$barMateria = $navbar->barMateria($usuario,$materia);
			if ($barMateria) {
				$eliminar = $this->model->deleteBlog($materia, $blog);
				
				if ( $eliminar ) {
					$respuesta['status'] = true;
					$respuesta['respuesta'] = 'POST DEL BLOG ELIMINADO EXITOSAMENTE';
				}else{
					$respuesta['status'] = false;
					$respuesta['respuesta'] = "ERROR AL ELIMINAR CONTENIDO";
				}

			}else{
				$respuesta['status'] = false;
				$respuesta['respuesta'] = "MATERIA NO VALIDA O NO INSCRITA";
			}

		}else{
			$respuesta['status'] = false;
			$respuesta['respuesta'] = "DIRECCION URL INVALIDA";
		}
		echo json_encode($respuesta);
	}

	public function add($url)
	{
		//URLS VARIABLES
		$materia = (int)$_POST['materia'];

		$sesion = new Sesion();
		$sesion->validateSesion();
		$usuario = $sesion->getSesion();

		if (  ctype_digit($materia) ) {
			$navbar = new Navbar($usuario);
			$barMateria = $navbar->barMateria($usuario,$materia);
			if ($barMateria) {
				// DATOS DE FORMULARIO
				$titulo = $_POST['title'];
				$descripcion = $_POST['descripcion'];
				$fecha = date("m-d-Y",time()) ;
				$respuesta = ['status' => false, 'respuesta' => "", 'idBlog' => ""];

				$datos = [
					'materia' => $materia,
					'titulo' => $titulo,
					'descripcion' => $descripcion,
					'fecha' => $fecha
				];
				$insert = $this->model->addBlog($datos);
				$idBlog = $this->model->getIdBlog($materia, $fecha, $titulo, $descripcion);

				$respuesta['status'] = true;
				$respuesta['respuesta'] = "POST AGREGADO EXITOSAMENTE EN EL BLOG";
				$respuesta['idBlog'] = $idBlog;

				if ( $insert ) {
					$num_file = count($_FILES['file']['name']);
					for ($i=0; $i < $num_file; $i++) {
						if ( !empty($_FILES['file']['name'][$i]) ) {
							$tmp = $_FILES['file']['tmp_name'][$i];
							$size = $_FILES['file']['size'][$i];
							$tip = explode(".", $_FILES['file']['name'][$i]);
							$tipo = end($tip);
							$n = $i +1;
							$nombre = "$materia-$n";

							$limite = 20480 *1024;
							//$ruta = constant('URL')."public/upload/blog/$materia/$blog/";
							$ruta = "public/upload/blog/$materia/$idBlog/";
							$extensiones = array('pdf','doc','docx','xlsx','xls','txt','pptx','ppt','pub','jpg','jpeg','gif','png','ai','svg','git','psd','raw','mp4','m4v','mov','mpg','mpeg','swf','zip','rar','mp3','wav','opus','PDF','DOC','DOCX','XLSX','XLS','TXT','PPTX','PPT','PUB','JPG','JPEG','GIF','PNG','AI','SVG','GIT','PSD','RAW','MP4','M4V','MOV','MPG','MPEG','SWF','ZIP','RAR','MP3','WAV','OPUS','Pdf','Doc','Docx','Xlsx','Xls','Txt','Pptx','Ppt','Pub','Jpg','Jpeg','Gif','Png','Ai','Svg','Git','Psd','Raw','Mp4','M4V','Mov','Mpg','Mpeg','Swf','Zip','Rar','Mp3','Wav','Opus');

							if( in_array($tipo, $extensiones) ){
								if ( $size <= $limite ) {
									if( !file_exists($ruta) ){
										mkdir($ruta,0777,true);
									}
									$upload = move_uploaded_file($tmp, $ruta.$nombre.".".$tipo);
									if ( $upload && file_exists($ruta.$nombre.".".$tipo) ) {
										$this->model->updateArchivo($n, $materia, $idBlog, $nombre.".".$tipo);
										
										$respuesta['status'] = true;
										$respuesta['respuesta'] = "ARCHIVO CARGADO EXITOSAMENTE";
										$respuesta['idBlog'] = $idBlog;
									}else {
										$respuesta['status'] = flase;
										$respuesta['respuesta'] = "ERROR AL GUARDAR EL ARCHIVO, por favor revise su conexcion a internet";
									}

								}else {
									$respuesta['status'] = flase;
									$respuesta['respuesta'] = "EL TAMAÑO DEL ARCHIVO EXCEDE  LO PERMITIDO";
								}
							}else{
								$respuesta['status'] = flase;
								$respuesta['respuesta'] = "TIPO DE ARCHIVO NO VALIDO";
							}

						}

					}
				}


			}else{
				$respuesta['status'] = flase;
				$respuesta['respuesta'] = "MATERIA NO VALIDA O NO INSCRITA";
			}

		}else{
			$respuesta['status'] = flase;
			$respuesta['respuesta'] = "DIRECCION URL INVALIDA";
		}
		echo json_encode($respuesta);
	}

	public function edit($url)
	{
		$materia = $_POST['materia'];
		$blog = $_POST['blog'];

		$sesion = new Sesion();
		$sesion->validateSesion();
		$usuario = $sesion->getSesion();
		$respuesta = ['status' => false, 'respuesta' => "", 'idBlog' => ""];
		
		if (  ctype_digit($materia) && ctype_digit($blog) ) {
			$navbar = new Navbar($usuario);
			$barMateria = $navbar->barMateria($usuario,$materia);
			if ($barMateria) {
				// DATOS DEL FORMULARIO
				$titulo = $_POST['title'];
				$descripcion = $_POST['descripcion'];
				$fecha = date("m-d-Y",time()) ;

				
				$datos = [
					'materia' => $materia,
					'blog' => $blog,
					'titulo' => $titulo,
					'descripcion' => $descripcion,
					'fecha' => $fecha
				];
				
				$editar = $this->model->editBlog($datos);
				$idBlog = $this->model->getIdBlog($materia, $fecha, $titulo, $descripcion);

				 $respuesta['status'] = true;
				 $respuesta['respuesta'] = "POST DEL BLOG GUARDADO EXITOSAMENTE";
				 $respuesta['idBlog'] = $idBlog;

				if ( $editar ) {
					$num_file = count($_FILES['file']['name']);
					for ($i=0; $i < $num_file; $i++) {
						if ( !empty($_FILES['file']['name'][$i]) ) {
							$tmp = $_FILES['file']['tmp_name'][$i];
							$size = $_FILES['file']['size'][$i];
							$tip = explode(".", $_FILES['file']['name'][$i]);
							$tipo = end($tip);
							$n = $i +1;
							$nombre = "$materia-$n";

							$limite = 20480 *1024;
							//$ruta = constant('URL')."public/upload/blog/$materia/$blog/";
							$ruta = "public/upload/blog/$materia/$idBlog/";
							$extensiones = array('pdf','doc','docx','xlsx','xls','txt','pptx','ppt','pub','jpg','jpeg','gif','png','ai','svg','git','psd','raw','mp4','m4v','mov','mpg','mpeg','swf','zip','rar','mp3','wav','opus','PDF','DOC','DOCX','XLSX','XLS','TXT','PPTX','PPT','PUB','JPG','JPEG','GIF','PNG','AI','SVG','GIT','PSD','RAW','MP4','M4V','MOV','MPG','MPEG','SWF','ZIP','RAR','MP3','WAV','OPUS','Pdf','Doc','Docx','Xlsx','Xls','Txt','Pptx','Ppt','Pub','Jpg','Jpeg','Gif','Png','Ai','Svg','Git','Psd','Raw','Mp4','M4V','Mov','Mpg','Mpeg','Swf','Zip','Rar','Mp3','Wav','Opus');

							if( in_array($tipo, $extensiones) ){
								if ( $size <= $limite ) {
									if( !file_exists($ruta) ){
										mkdir($ruta,0777,true);
									}
									$upload = move_uploaded_file($tmp, $ruta.$nombre.".".$tipo);
									if ( $upload && file_exists($ruta.$nombre.".".$tipo) ) {
										$this->model->updateArchivo($n, $materia, $idBlog, $nombre.".".$tipo);

										$respuesta['status'] = true;
										$respuesta['respuesta'] = "POST CON ARCHIVOS DEL BLOG GUARDADO EXITOSAMENTE";
										$respuesta['idBlog'] = $idBlog;
									}else {
										$respuesta['status'] = false;
										$respuesta['respuesta'] = "ERROR AL GUARDAR EL ARCHIVO, POR FAVOR REVISE SU CONEXCION A INTERNET";
									}
								}else {
									$respuesta['status'] = false;
									$respuesta['respuesta'] = "EL TAMAÑO DEL ARCHIVO EXCEDE  LO PERMITIDO";
								}
							}else{
								$respuesta['status'] = false;
								$respuesta['respuesta'] = "FORMATO DE ARCHIVO NO VALIDO";
							}
						}
					}
				}else{
					$respuesta['status'] = false;
					$respuesta['respuesta'] = "ERROR AL EDITAR CONTENIDO";
				}
			}else{
				$respuesta['status'] = false;
				$respuesta['respuesta'] = "MATERIA NO VALIDA O NO INSCRITA";
			}

		}else{
			$respuesta['status'] = false;
			$respuesta['respuesta'] = "DIRECCION URL INVALIDA";
		}
		echo json_encode($respuesta);
	}

}

?>