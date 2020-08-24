<?php
require_once 'navbar.php';
/**
 *
 */
class Evaluacion extends Controller
{

	function __construct()
	{
		parent::__construct();
	}

	public function render()
	{
		echo 'Evaluacion';
	}

	public function all($url)
	{
		$materia = $url[0];
		$sesion = new Sesion();
		$sesion->validateSesion();
		$usuario = $sesion->getSesion();
		

		$navbar = new Navbar($usuario);
		$navbarMaterias = $navbar->navbarMaterias($usuario);

		$this->view->usuario = $usuario;
		$this->view->navbarMaterias = $navbarMaterias;


		if (  ctype_digit($materia) ) {
			$barMateria = $navbar->barMateria($usuario,$materia);
			if ($barMateria) {
				$this->view->barMateria  = $barMateria;
				$actividades             = $this->model->getEvaluaciones($materia);
				$this->view->actividades = $actividades;

				if ( $usuario['user'] == 'profesor' ) {
					$planes                    = $this->model->getPlanes($materia);
					$this->view->planes        = $planes;
					$totalAlumnos              = $this->model->getTotalAlumnos($materia);
					$this->view->totalAlumnos  = $totalAlumnos;
				}

				$this->view->render('evaluacion/index');

			}else{
				echo "MATERIA NO VALIDA O NO INSCRITA";
			}

		}else{
			echo "DIRECCION URL INVALIDA";
			exit;
		}
	}

	public function detail($url)
	{
		$materia = $url[0];
		$evaluacion = $url[1];

		$sesion = new Sesion();
		$sesion->validateSesion();
		$usuario = $sesion->getSesion();

		$navbar = new Navbar($usuario);
		$navbarMaterias = $navbar->navbarMaterias($usuario);

		$this->view->usuario = $usuario;
		$this->view->navbarMaterias = $navbarMaterias;


		if (  ctype_digit($materia) && ctype_digit($evaluacion) ) {
			$barMateria = $navbar->barMateria($usuario,$materia);
			if ($barMateria) {
				$this->view->barMateria = $barMateria;
				$actividad = $this->model->getEvaluacion($url[1]);
				$this->view->actividad = $actividad;
				if ( $usuario['user'] == 'alumno' ) {
					$actividadAlumno = $this->model->getEvaluacionEntregada($evaluacion, $usuario['id']);
					$this->view->actividadAlumno = $actividadAlumno;
				}elseif( $usuario['user'] == 'profesor' ){
					$evaluacionesEntregadas = $this->model->getEvaluacionesEntregadas($evaluacion);
					$this->view->evaluacionesEntregadas = $evaluacionesEntregadas;
				}

				$this->view->render('evaluacion/detail');

			}else{
				echo "MATERIA NO VALIDA O NO INSCRITA";
			}


		}else{
			echo "DIRECCION URL INVALIDA";
			exit;
		}
	}

	public function add($url)
	{
		//URLS VARIABLES
		$materia = (int)$_POST['materia'];

		$sesion = new Sesion();
		$sesion->validateSesion();
		$usuario = $sesion->getSesion();
		$respuesta = ['status' => false, 'respuesta' => "", 'idEvaluacion' => ""];

		if (  ctype_digit($materia) ) {
			$navbar = new Navbar($usuario);
			$barMateria = $navbar->barMateria($usuario,$materia);
			if ($barMateria) {
				// DATOS DE FORMULARIO
				$plan = (int)$_POST['plan'];
				$fecha = date("d-m-Y",strtotime($_POST['fecha']));
				$descripcion = $_POST['descripcion'];
				$publicado = date("d-m-Y",time());

				$datos = [
					'materia' => $materia,
					'plan' => $plan,
					'fecha' => $fecha,
					'descripcion' => $descripcion,
					'publicado' => $publicado
				];
				$insert = $this->model->addEvaluacion($datos);
				$idEvaluacion = $this->model->getIdEvaluacion($datos);

				$respuesta['status'] = true;
				$respuesta['respuesta'] = "EVALUACION GUARDADA EXITOSAMENTE";
				$respuesta['idEvaluacion'] = $idEvaluacion;

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
							$ruta = "public/upload/actividad/$materia/$idEvaluacion/";
							$extensiones = array('pdf','doc','docx','xlsx','xls','txt','pptx','ppt','pub','jpg','jpeg','gif','png','ai','svg','git','psd','raw','mp4','m4v','mov','mpg','mpeg','swf','zip','rar','mp3','wav','opus','PDF','DOC','DOCX','XLSX','XLS','TXT','PPTX','PPT','PUB','JPG','JPEG','GIF','PNG','AI','SVG','GIT','PSD','RAW','MP4','M4V','MOV','MPG','MPEG','SWF','ZIP','RAR','MP3','WAV','OPUS','Pdf','Doc','Docx','Xlsx','Xls','Txt','Pptx','Ppt','Pub','Jpg','Jpeg','Gif','Png','Ai','Svg','Git','Psd','Raw','Mp4','M4V','Mov','Mpg','Mpeg','Swf','Zip','Rar','Mp3','Wav','Opus');

							if( in_array($tipo, $extensiones) ){
								if ( $size <= $limite ) {
									if( !file_exists($ruta) ){
										mkdir($ruta,0777,true);
									}
									$upload = move_uploaded_file($tmp, $ruta.$nombre.".".$tipo);
									if ( $upload && file_exists($ruta.$nombre.".".$tipo) ) {
										$this->model->updateArchivoEvaluacion($n, $materia, $idEvaluacion, $nombre.".".$tipo);

										$respuesta['status'] = true;
										$respuesta['respuesta'] = "EVALUACION Y ARCHIVOS GUARDADA EXITOSAMENTE";
										$respuesta['idEvaluacion'] = $idEvaluacion;
									}else {
										$respuesta['status'] = false;
										$respuesta['respuesta'] = "ERROR AL GUARDAR EL ARCHIVO, por favor revise su conexcion a internet";
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

	public function delete($url)
	{
		$materia = $url[0];
		$evaluacion = $url[1];

		$sesion = new Sesion();
		$sesion->validateSesion();
		$usuario = $sesion->getSesion();
		$respuesta = ['status' => false, 'respuesta' => ""];

		if (  ctype_digit($materia) && ctype_digit($evaluacion) ) {
			$navbar = new Navbar($usuario);
			$barMateria = $navbar->barMateria($usuario,$materia);
			if ($barMateria) {
				$eliminar = $this->model->deleteEvaluacion($materia, $evaluacion);
				if ( $eliminar ) {
					$respuesta['status'] = true;
					$respuesta['respuesta'] = "EVALUACION ELIMINADA EXITOSAMENTE";
				}else{
					$respuesta['status'] = false;
					$respuesta['respuesta'] = "ERROR AL ELIMINAR EVALUACION";
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
		//URLS VARIABLES
		$materia = (int)$_POST['materia'];
		$evaluacion = (int)$_POST['evaluacion'];

		$sesion = new Sesion();
		$sesion->validateSesion();
		$usuario = $sesion->getSesion();
		$respuesta = ['status' => false, 'respuesta' => "", 'idEvaluacion' => ""];

		if (  ctype_digit($materia) && ctype_digit($evaluacion) ) {
			$navbar = new Navbar($usuario);
			$barMateria = $navbar->barMateria($usuario,$materia);
			if ($barMateria) {
				// DATOS DE FORMULARIO
				$plan = (int)$_POST['plan'];
				$fecha = date("d-m-Y",strtotime($_POST['fecha']));
				$descripcion = $_POST['descripcion'];
				$publicado = date("d-m-Y",time());

				$datos = [
					'materia' => $materia,
					'evaluacion' => $evaluacion,
					'plan' => $plan,
					'fecha' => $fecha,
					'descripcion' => $descripcion,
					'publicado' => $publicado
				];
				$update = $this->model->updateEvaluacion($datos);
				$idEvaluacion = $this->model->getIdEvaluacion($datos);

				$respuesta['status'] = true;
				$respuesta['respuesta'] = "EVALUACION EDITADA EXITOSAMENTE";
				$respuesta['idEvaluacion'] = $idEvaluacion;

				if ( $update ) {
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
							$ruta = "public/upload/actividad/$materia/$idEvaluacion/";
							$extensiones = array('pdf','doc','docx','xlsx','xls','txt','pptx','ppt','pub','jpg','jpeg','gif','png','ai','svg','git','psd','raw','mp4','m4v','mov','mpg','mpeg','swf','zip','rar','mp3','wav','opus','PDF','DOC','DOCX','XLSX','XLS','TXT','PPTX','PPT','PUB','JPG','JPEG','GIF','PNG','AI','SVG','GIT','PSD','RAW','MP4','M4V','MOV','MPG','MPEG','SWF','ZIP','RAR','MP3','WAV','OPUS','Pdf','Doc','Docx','Xlsx','Xls','Txt','Pptx','Ppt','Pub','Jpg','Jpeg','Gif','Png','Ai','Svg','Git','Psd','Raw','Mp4','M4V','Mov','Mpg','Mpeg','Swf','Zip','Rar','Mp3','Wav','Opus');

							if( in_array($tipo, $extensiones) ){
								if ( $size <= $limite ) {
									if( !file_exists($ruta) ){
										mkdir($ruta,0777,true);
									}
									$upload = move_uploaded_file($tmp, $ruta.$nombre.".".$tipo);
									if ( $upload && file_exists($ruta.$nombre.".".$tipo) ) {
										$this->model->updateArchivoEvaluacion($n, $materia, $idEvaluacion, $nombre.".".$tipo);
										
										$respuesta['status'] = true;
										$respuesta['respuesta'] = "EVALUACION CON ARCHIVOS EDITADA EXITOSAMENTE";
										$respuesta['idEvaluacion'] = $idEvaluacion;
									}else {
										$respuesta['status'] = false;
										$respuesta['respuesta'] = "ERROR AL GUARDAR EL ARCHIVO, por favor revise su conexcion a internet";
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

	public function addEvaluacionAlumno($url)
	{
		//URLS VARIABLES
		$materia = $_POST['materia'];
		$evaluacion = $_POST['evaluacion'];

		$sesion = new Sesion();
		$sesion->validateSesion();
		$usuario = $sesion->getSesion();

		if (  ctype_digit($materia) && ctype_digit($evaluacion) ) {
			$navbar = new Navbar($usuario);
			$barMateria = $navbar->barMateria($usuario,$materia);
			if ($barMateria) {
				// DATOS DE FORMULARIO
				$alumno = $usuario['id'];
				$fecha = strtotime(date("d-m-Y",time())) ;
				$descripcion = $_POST['descripcion'];

				$nlink1 = $_POST['nlink1'];
				$nlink2 = $_POST['nlink2'];
				$nlink3 = $_POST['nlink3'];
				$nlink4 = $_POST['nlink4'];

				$link1 = $_POST['link1'];
				$link2 = $_POST['link2'];
				$link3 = $_POST['link3'];
				$link4 = $_POST['link4'];

				$datos = [
					'materia' => $materia,
					'evaluacion' => $evaluacion,
					'alumno' => $alumno,
					'fecha' => date("d-m-Y",time()),
					'descripcion' => $descripcion,
					'nlink1' => $nlink1,
					'nlink2' => $nlink2,
					'nlink3' => $nlink3,
					'nlink4' => $nlink4,
					'link1' => $link1,
					'link2' => $link2,
					'link3' => $link3,
					'link4' => $link4
				];
				$insert = $this->model->addEvaluacionAlumno($datos);
				if ( $insert ) {
					// $idEvaluacion = $this->model->getIdEvaluacionAlumno($datos);

					$num_file = count($_FILES['file']['name']);
					for ($i=0; $i < $num_file; $i++) {
						if ( !empty($_FILES['file']['name'][$i]) ) {
							$tmp = $_FILES['file']['tmp_name'][$i];
							$size = $_FILES['file']['size'][$i];
							$tip = explode(".", $_FILES['file']['name'][$i]);
							$tipo = end($tip);
							$n = $i +1;
							$nombre = "$alumno-$n";

							$limite = 20480 *1024;
							$ruta = "public/upload/evaluacion/$materia/$evaluacion/";
							$extensiones = array('pdf','doc','docx','xlsx','xls','txt','pptx','ppt','pub','jpg','jpeg','gif','png','ai','svg','git','psd','raw','mp4','m4v','mov','mpg','mpeg','swf','zip','rar','mp3','wav','opus','PDF','DOC','DOCX','XLSX','XLS','TXT','PPTX','PPT','PUB','JPG','JPEG','GIF','PNG','AI','SVG','GIT','PSD','RAW','MP4','M4V','MOV','MPG','MPEG','SWF','ZIP','RAR','MP3','WAV','OPUS','Pdf','Doc','Docx','Xlsx','Xls','Txt','Pptx','Ppt','Pub','Jpg','Jpeg','Gif','Png','Ai','Svg','Git','Psd','Raw','Mp4','M4V','Mov','Mpg','Mpeg','Swf','Zip','Rar','Mp3','Wav','Opus');

							if( in_array($tipo, $extensiones) ){
								if ( $size <= $limite ) {
									if( !file_exists($ruta) ){
										mkdir($ruta,0777,true);
									}
									$upload = move_uploaded_file($tmp, $ruta.$nombre.".".$tipo);
									if ( $upload && file_exists($ruta.$nombre.".".$tipo) ) {
										$this->model->updateArchivoEvaluacionAlumno($n,$datos, $nombre.".".$tipo);
										echo "ARCHIVO CARGADO EXITOSAMENTE";
									}else {
										echo "ERROR AL GUARDAR EL ARCHIVO, por favor revise su conexcion a internet";
									}

								}else {
									echo "EL TAMAÑO DEL ARCHIVO EXCEDE  LO PERMITIDO";
								}
							}else{
								echo "TIPO DE ARCHIVO NO VALIDO";
							}

						}

					}
					header('Location: ' . constant('URL') . 'evaluacion/detail/' . $materia . '/' . $evaluacion);
				}


			}else{
				echo "MATERIA NO VALIDA O NO INSCRITA";
			}

		}else{
			echo "DIRECCION URL INVALIDA";
			exit;
		}
	}

	public function updateEvaluacionAlumno($url)
	{
		//URLS VARIABLES
		$materia = $_POST['materia'];
		$evaluacion = $_POST['evaluacion'];
		$evaluacionAlumno = $_POST['evaluacionAlumno'];

		$sesion = new Sesion();
		$sesion->validateSesion();
		$usuario = $sesion->getSesion();

		if (  ctype_digit($materia) && ctype_digit($evaluacion) && ctype_digit($evaluacionAlumno) ) {
			$navbar = new Navbar($usuario);
			$barMateria = $navbar->barMateria($usuario,$materia);
			if ($barMateria) {
				// DATOS DE FORMULARIO
				$alumno = $usuario['id'];
				$fecha = strtotime(date("d-m-Y",time())) ;
				$descripcion = $_POST['descripcion'];

				$nlink1 = $_POST['nlink1'];
				$nlink2 = $_POST['nlink2'];
				$nlink3 = $_POST['nlink3'];
				$nlink4 = $_POST['nlink4'];

				$link1 = $_POST['link1'];
				$link2 = $_POST['link2'];
				$link3 = $_POST['link3'];
				$link4 = $_POST['link4'];

				$datos = [
					'materia' => $materia,
					'evaluacion' => $evaluacion,
					'evaluacionAlumno' => $evaluacionAlumno,
					'alumno' => $alumno,
					'fecha' => date("d-m-Y",time()),
					'descripcion' => $descripcion,
					'nlink1' => $nlink1,
					'nlink2' => $nlink2,
					'nlink3' => $nlink3,
					'nlink4' => $nlink4,
					'link1' => $link1,
					'link2' => $link2,
					'link3' => $link3,
					'link4' => $link4
				];
				$update = $this->model->updateEvaluacionAlumno($datos);
				if ( $update ) {
					// $idEvaluacion = $this->model->getIdEvaluacionAlumno($datos);

					$num_file = count($_FILES['file']['name']);
					for ($i=0; $i < $num_file; $i++) {
						if ( !empty($_FILES['file']['name'][$i]) ) {
							$tmp = $_FILES['file']['tmp_name'][$i];
							$size = $_FILES['file']['size'][$i];
							$tip = explode(".", $_FILES['file']['name'][$i]);
							$tipo = end($tip);
							$n = $i +1;
							$nombre = "$alumno-$n";

							$limite = 20480 *1024;
							$ruta = "public/upload/evaluacion/$materia/$evaluacion/";
							$extensiones = array('pdf','doc','docx','xlsx','xls','txt','pptx','ppt','pub','jpg','jpeg','gif','png','ai','svg','git','psd','raw','mp4','m4v','mov','mpg','mpeg','swf','zip','rar','mp3','wav','opus','PDF','DOC','DOCX','XLSX','XLS','TXT','PPTX','PPT','PUB','JPG','JPEG','GIF','PNG','AI','SVG','GIT','PSD','RAW','MP4','M4V','MOV','MPG','MPEG','SWF','ZIP','RAR','MP3','WAV','OPUS','Pdf','Doc','Docx','Xlsx','Xls','Txt','Pptx','Ppt','Pub','Jpg','Jpeg','Gif','Png','Ai','Svg','Git','Psd','Raw','Mp4','M4V','Mov','Mpg','Mpeg','Swf','Zip','Rar','Mp3','Wav','Opus');

							if( in_array($tipo, $extensiones) ){
								if ( $size <= $limite ) {
									if( !file_exists($ruta) ){
										mkdir($ruta,0777,true);
									}
									$upload = move_uploaded_file($tmp, $ruta.$nombre.".".$tipo);
									if ( $upload && file_exists($ruta.$nombre.".".$tipo) ) {
										$this->model->updateArchivoEvaluacionAlumno($n,$datos, $nombre.".".$tipo);
										echo "ARCHIVO CARGADO EXITOSAMENTE";
									}else {
										echo "ERROR AL GUARDAR EL ARCHIVO, por favor revise su conexcion a internet";
									}

								}else {
									echo "EL TAMAÑO DEL ARCHIVO EXCEDE  LO PERMITIDO";
								}
							}else{
								echo "TIPO DE ARCHIVO NO VALIDO";
							}

						}

					}
					header('Location: ' . constant('URL') . 'evaluacion/detail/' . $materia . '/' . $evaluacion);
				}


			}else{
				echo "MATERIA NO VALIDA O NO INSCRITA";
			}

		}else{
			echo "DIRECCION URL INVALIDA";
			exit;
		}
	}

	


}

?>