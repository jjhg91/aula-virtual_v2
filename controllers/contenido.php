<?php
require_once 'navbar.php';
/**
 *
 */
class Contenido extends Controller
{
	function __construct()
	{
		parent::__construct();
	}

	public function render()
	{
		echo 'contenido';
	}

	public function all($materia)
	{
		$sesion = new Sesion();
		$sesion->validateSesion();
		$usuario = $sesion->getSesion();

		$navbar = new Navbar($usuario);
		$navbarMaterias = $navbar->navbarMaterias($usuario);

		$periodo = $navbar->periodoActivo();

		$this->view->usuario = $usuario;
		$this->view->navbarMaterias = $navbarMaterias;
		$this->view->periodo = $periodo;

		if (  ctype_digit($materia[0]) ) {

			$barMateria = $navbar->barMateria($usuario,$materia[0]);
			if ($barMateria) {
				$this->view->barMateria = $barMateria;
				$contenidos = $this->model->getContenido($materia[0]);
				$this->view->contenidos = $contenidos;
				$this->view->render('contenido/index');

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
		$contenido = $url[1];
		$numero = $url[2];

		$sesion = new Sesion();
		$sesion->validateSesion();
		$usuario = $sesion->getSesion();
		$respuesta = ['status' => false, 'respuesta' => ""];
		if (  ctype_digit($materia) && ctype_digit($contenido) ) {
			$navbar = new Navbar($usuario);
			$barMateria = $navbar->barMateria($usuario,$materia);
			if ($barMateria) {
				$eliminar = $this->model->deleteContendio($materia, $contenido);

				if ( $eliminar ) {
					$respuesta['status'] = true;
					$respuesta['respuesta'] = "El contenido numero ".$numero." a sido eliminado";
				}else{
					$respuesta['status'] = false;
					$respuesta['respuesta'] = "Error al intentar eliminar el contenido numero ".$numero;
				}



			}else{
				$respuesta['status'] = false;
				$respuesta['respuesta'] = "Error al intentar eliminar el contenido numero ".$numero.". MATERIA NO VALIDA O NO INSCRITA";
			}

		}else{
			$respuesta['status'] = false;
			$respuesta['respuesta'] = "Error al intentar eliminar el contenido numero ".$numero.". DIRECCION URL INVALIDA";
		}

		echo json_encode($respuesta);
	}

	public function add($url)
	{
		//URLS VARIABLES
		
		$materia = $url[0];

		$sesion = new Sesion();
		$sesion->validateSesion();
		$usuario = $sesion->getSesion();
		$respuesta = ['status' => false, 'respuesta' => "", 'idContenido' => ""];

		if (  ctype_digit($materia) ) {
			$navbar = new Navbar($usuario);
			$barMateria = $navbar->barMateria($usuario,$materia);
			if ($barMateria) {
				
				// DATOS DE FORMULARIO
				$numero = (int)$_POST['numero'];
				$lapso = (int)$_POST['lapso_form'];
				$descripcion = $_POST['message'];

				$datos = [
					'materia' => $materia,
					'numero' => $numero,
					'descripcion' => $descripcion,
					'lapso' => $lapso
				];

				$insert = $this->model->addContenido($datos);
				$idContenido = $this->model->getIdContenido($materia, $numero, $descripcion);
				
				$respuesta['status'] = true;
				$respuesta['respuesta'] = "DATOS SIN ARCHIVOS CARGADOS EXITOSAMENTE";
				$respuesta['idContenido'] = $idContenido;
				if ( $insert ) {
					

					$num_file = count($_FILES['file']['name']);
					$pp = $_FILES['file']['name'];
					for ($i=0; $i < $num_file; $i++) {
						if ( !empty($_FILES['file']['name'][$i]) ) {
							$tmp = $_FILES['file']['tmp_name'][$i];
							$size = $_FILES['file']['size'][$i];
							$tip = explode(".", $_FILES['file']['name'][$i]);
							$tipo = end($tip);
							$n = $i +1;
							$nombre = "$materia-$n";
							$pp[$i] = $nombre;

							$limite = 20480 *1024;
							//$ruta = constant('URL')."public/upload/contenido/$materia/$contenido/";
							$ruta = "public/upload/contenido/$materia/$idContenido/";
							$extensiones = array('pdf','doc','docx','xlsx','xls','txt','pptx','ppt','pub','jpg','jpeg','gif','png','ai','svg','git','psd','raw','mp4','m4v','mov','mpg','mpeg','swf','zip','rar','mp3','wav','opus','PDF','DOC','DOCX','XLSX','XLS','TXT','PPTX','PPT','PUB','JPG','JPEG','GIF','PNG','AI','SVG','GIT','PSD','RAW','MP4','M4V','MOV','MPG','MPEG','SWF','ZIP','RAR','MP3','WAV','OPUS','Pdf','Doc','Docx','Xlsx','Xls','Txt','Pptx','Ppt','Pub','Jpg','Jpeg','Gif','Png','Ai','Svg','Git','Psd','Raw','Mp4','M4V','Mov','Mpg','Mpeg','Swf','Zip','Rar','Mp3','Wav','Opus');

							if( in_array($tipo, $extensiones) ){
								if ( $size <= $limite ) {
									if( !file_exists($ruta) ){
										mkdir($ruta,0777,true);
									}
									$upload = move_uploaded_file($tmp, $ruta.$nombre.".".$tipo);
									if ( $upload && file_exists($ruta.$nombre.".".$tipo) ) {
										$this->model->updateArchivo($n, $materia, $idContenido, $nombre.".".$tipo);
										$respuesta['status'] = true;
										$respuesta['respuesta'] = "DATOS Y ARCHIVOS CARGADOS EXITOSAMENTE";
										$respuesta['idContenido'] = $idContenido;
									}else {
										$this->model->deleteContendio($materia, $idContenido);
										$respuesta['status'] = false;
										$respuesta['respuesta'] = "ERROR AL GUARDAR EL ARCHIVO, por favor revise su conexcion a internet";
									break;
									}

								}else {
									$respuesta['status'] = false;
									$respuesta['respuesta'] = "EL TAMAÑO DEL ARCHIVO EXCEDE  LO PERMITIDO";
								}
							}else{
								$respuesta['status'] = false;
								$respuesta['respuesta'] = "TIPO DE ARCHIVO NO VALIDO";
							}

						}

					}
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

	public function edit($url)
	{
		$materia = (int)$_POST['materia'];
		$contenido = (int)$_POST['contenido'];

		$sesion = new Sesion();
		$sesion->validateSesion();
		$usuario = $sesion->getSesion();
		$respuesta = ['status' => false, 'respuesta' => ""];

		if (  ctype_digit($materia) && ctype_digit($contenido) ) {
			$navbar = new Navbar($usuario);
			$barMateria = $navbar->barMateria($usuario,$materia);

			if ($barMateria) {
				// DATOS DEL FORMULARIO
				$numero = (int)$_POST['numero'];
				$descripcion = $_POST['message'];
				
				$datos = [
					'materia' => $materia,
					'contenido' => $contenido,
					'numero' => $numero,
					'descripcion' => $descripcion
				];
				
				$editar = $this->model->editContenido($datos);
				
				$respuesta['status'] = true ;
				$respuesta['respuesta'] = "CONTENIDO SIN ARCHIVOS, EDITADO EXITOSAMENTE";

				if ( $editar ) {
					$idContenido = $contenido;
					
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
							//$ruta = constant('URL')."public/upload/contenido/$materia/$contenido/";
							$ruta = "public/upload/contenido/$materia/$idContenido/";
							$extensiones = array('pdf','doc','docx','xlsx','xls','txt','pptx','ppt','pub','jpg','jpeg','gif','png','ai','svg','git','psd','raw','mp4','m4v','mov','mpg','mpeg','swf','zip','rar','mp3','wav','opus','PDF','DOC','DOCX','XLSX','XLS','TXT','PPTX','PPT','PUB','JPG','JPEG','GIF','PNG','AI','SVG','GIT','PSD','RAW','MP4','M4V','MOV','MPG','MPEG','SWF','ZIP','RAR','MP3','WAV','OPUS','Pdf','Doc','Docx','Xlsx','Xls','Txt','Pptx','Ppt','Pub','Jpg','Jpeg','Gif','Png','Ai','Svg','Git','Psd','Raw','Mp4','M4V','Mov','Mpg','Mpeg','Swf','Zip','Rar','Mp3','Wav','Opus');

							if( in_array($tipo, $extensiones) ){
								if ( $size <= $limite ) {
									if( !file_exists($ruta) ){
										mkdir($ruta,0777,true);
									}
									$upload = move_uploaded_file($tmp, $ruta.$nombre.".".$tipo);
									if ( $upload && file_exists($ruta.$nombre.".".$tipo) ) {
										$this->model->updateArchivo($n, $materia, $idContenido, $nombre.".".$tipo);
										
										$respuesta['status'] = true ;
										$respuesta['respuesta'] = "ARCHIVO CARGADO EXITOSAMENTE";
										
									}else {
										$respuesta['status'] = false ;
										$respuesta['respuesta'] = "ERROR AL GUARDAR EL ARCHIVO, por favor revise su conexcion a internet";
									}

								}else {
									$respuesta['status'] = false ;
									$respuesta['respuesta'] = "EL TAMAÑO DEL ARCHIVO EXCEDE  LO PERMITIDO";
								}
							}else{
								$respuesta['status'] = false ;
								$respuesta['respuesta'] = "TIPO DE ARCHIVO NO VALIDO";
							}

						}

					}
					// header('Location: ' . constant('URL') . 'contenido/all/' . $materia);
				}else{
					$respuesta['status'] = false ;
				$respuesta['respuesta'] = "ERROR AL EDITAR CONTENIDO";
				}



			}else{
				$respuesta['status'] = false ;
				$respuesta['respuesta'] = "MATERIA NO VALIDA O NO INSCRITA";
			}

		}else{
			$respuesta['status'] = false ;
			$respuesta['respuesta'] = "DIRECCION URL INVALIDA";
		}


		
		echo json_encode($respuesta);
	}

}

?>