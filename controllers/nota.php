<?php
require_once 'navbar.php';
/**
 *
 */
class Nota extends Controller
{
	function __construct()
	{
		parent::__construct();
	}

	public function render()
	{
		echo 'nota';
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
				$planes = $this->model->getPlanes($materia[0]);
                $this->view->planes = $planes;
				$this->view->render('nota/index');

			}else{
				echo "MATERIA NO VALIDA O NO INSCRITA";
			}


		}else{
			echo "DIRECCION URL INVALIDA";
			exit;
		}

	}

	public function cargar($url)
	{
		$materia = $url[0];
		$plan = $url[1];

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
				$this->view->barMateria = $barMateria;
				$alumnos = $this->model->getAlumnos($materia, $plan);
				$plan = $this->model->getPlan($materia, $plan);
				$this->view->alumnos = $alumnos;
				$this->view->plan = $plan;
				$this->view->render('nota/cargar');

			}else{
				echo "MATERIA NO VALIDA O NO INSCRITA";
			}


		}else{
			echo "DIRECCION URL INVALIDA";
			exit;
		}
	}

	public function addNota($url)
	{
		$materia = (int)$_POST['materia'];
		$plan = (int)$_POST['plan'];

		$sesion = new Sesion();
		$sesion->validateSesion();
		$usuario = $sesion->getSesion();

		$navbar = new Navbar($usuario);
		$navbarMaterias = $navbar->navbarMaterias($usuario);

		$this->view->usuario = $usuario;
		$this->view->navbarMaterias = $navbarMaterias;
		$respuesta = ['status' => false, 'respuesta' => ""];


		if ( ctype_digit($materia) && ctype_digit($plan) ) {

			$barMateria = $navbar->barMateria($usuario,$materia);
			if ($barMateria) {
				//DATOS DEL FORMULARIO
				$alumno = (int)$_POST['alumno'];
				$nota = $_POST['nota'];
				$observacion = $_POST['observacion'];

				$datos = [
					'materia' => $materia,
					'plan' => $plan,
					'alumno' => $alumno,
					'nota' => $nota,
					'observacion' => $observacion
				];

				$agregarNota = $this->model->addNota($datos);
				
				$respuesta['status'] = true;
				$respuesta['respuesta'] = "NOTA SIN ARCHIVOS AGREGADA EXITOSAMENTE";
				
				if ( $agregarNota ) {

					$num_file = count($_FILES['file']['name']);
					for ($i=0; $i < $num_file; $i++) {
						if ( !empty($_FILES['file']['name'][$i]) ) {
							$tmp = $_FILES['file']['tmp_name'][$i];
							$size = $_FILES['file']['size'][$i];
							$tip = explode(".", $_FILES['file']['name'][$i]);
							$tipo = end($tip);
							$n = $i +1;
							$nombre = "Rev-$alumno-$n";

							$limite = 20480 *1024;
							$ruta = "public/upload/correcciones/$materia/$plan/";
							$extensiones = array('pdf','doc','docx','xlsx','xls','txt','pptx','ppt','pub','jpg','jpeg','gif','png','ai','svg','git','psd','raw','mp4','m4v','mov','mpg','mpeg','swf','zip','rar','mp3','wav','opus','PDF','DOC','DOCX','XLSX','XLS','TXT','PPTX','PPT','PUB','JPG','JPEG','GIF','PNG','AI','SVG','GIT','PSD','RAW','MP4','M4V','MOV','MPG','MPEG','SWF','ZIP','RAR','MP3','WAV','OPUS','Pdf','Doc','Docx','Xlsx','Xls','Txt','Pptx','Ppt','Pub','Jpg','Jpeg','Gif','Png','Ai','Svg','Git','Psd','Raw','Mp4','M4V','Mov','Mpg','Mpeg','Swf','Zip','Rar','Mp3','Wav','Opus');

							if( in_array($tipo, $extensiones) ){
								if ( $size <= $limite ) {
									if( !file_exists($ruta) ){
										mkdir($ruta,0777,true);
									}
									$upload = move_uploaded_file($tmp, $ruta.$nombre.".".$tipo);
									if ( $upload && file_exists($ruta.$nombre.".".$tipo) ) {
										$this->model->updateArchivo($n, $alumno, $plan, $nombre.".".$tipo);

										$respuesta['status'] = true;
										$respuesta['respuesta'] = "NOTA CON ARCHIVOS AGREGADA EXITOSAMENTE";

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
				}else {
					$respuesta['status'] = false;
					$respuesta['respuesta'] = "NO SE PUDO AGREGAR LA NOTA AL ALUMNO";
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