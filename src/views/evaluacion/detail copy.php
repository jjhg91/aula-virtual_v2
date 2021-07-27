<?php require_once('views/Template/template.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">


	<!-- PROBANDO RESPOSNIVE DESIGN -->
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- /PROBANDO RESPOSNIVE DESIGN -->



	<link rel="Shortcut Icon" type="image/x-icon" href="<?= constant('URL') ?>public/media/logo.ico" />
	<title>UEPJMC</title>


	<!-- CUSTOM CSS -->
	<link rel="stylesheet" href="<?= constant('URL') ?>public/icon/icomoon/style.css">
	<link rel="stylesheet" href="<?= constant('URL') ?>public/css/evaluaciones.css">
	<!-- /CUSTOM CSS -->
	<script src="<?= constant('URL') ?>public/js/jquery/jquery-3.5.0.min.js"></script>
	<script src="<?= constant('URL') ?>public/js/jquery/jquery.cookie.js"></script>


	
	<!-- Theme included stylesheets -->
	<link href="<?= constant('URL') ?>public/quill/quill.snow.css" rel="stylesheet">
	<link href="<?= constant('URL') ?>public/quill/quill.bubble.css" rel="stylesheet">


</head>
<body>

	<?php Loader(); ?>
	<?php Headerr(); ?>


	<div class="contenido">

		<?php Navbar($this->usuario, $this->navbarMaterias, $this->periodo); ?>

		<main class="main_completo">

			<?php TarjetaInformativa('DETALLES EVALUACION', $this->barMateria); ?>

		<!-- MOSTRAR DETALLES DE LA EVALUACION -->
			<section class="plan_evaluacion">
				<div class="titulo">
					<div class="titulo_izq">
						<?php if ($this->actividad[11] != 8): ?>
							<h4><?= $this->actividad[2] ?></h4>
						<?php else: ?>
							<h4><?= ucfirst($this->actividad[12]) ?></h4>
						<?php endif ?>
					</div>

					<?php if ($_SESSION['user'] == 'profesor'): ?>
					<div class="titulo_der">
						<div class="enlaces">
						
						</div>
					</div>
					<?php endif ?>

				</div>
				<div class="contenido">
					<p><strong>Fecha limite: </strong><?= $this->actividad[4] ?></p>
					<p><strong>Valor: </strong>20pts</p>
					<br>

					<p><strong>Descripcion: </strong><?= nl2br($this->actividad[5]) ?></p>







					<div class="trabajos">

						<?php if ($this->actividad[13] or $this->actividad[14] or $this->actividad[15] or $this->actividad[16]): ?>
						<br>
						<br>
						<h4>Links</h4>
						<br>
						<?php endif ?>

						<?php if ($this->actividad[13]): ?>
						<a href="<?= $this->actividad[17] ?>"><?= $this->actividad[13] ?></a>
						<br>
						<br>
						<?php endif ?>

						<?php if ($this->actividad[14]): ?>
						<a href="<?= $this->actividad[18] ?>"><?= $this->actividad[14] ?></a>
						<br>
						<br>
						<?php endif ?>

						<?php if ($this->actividad[15]): ?>
						<a href="<?= $this->actividad[19] ?>"><?= $this->actividad[15] ?></a>
						<br>
						<br>
						<?php endif ?>

						<?php if ($this->actividad[16]): ?>
						<a href="<?= $this->actividad[20] ?>"><?= $this->actividad[16] ?></a>
						<br>
						<br>
						<?php endif ?>

					</div>










					<div class="trabajos">

						<?php if ($this->actividad[6] or $this->actividad[7] or $this->actividad[8] or $this->actividad[9]): ?>
						<br>
						<br>
						<h4>Descarga de Materiales</h4>
						<br>
						<?php endif ?>

						<?php if ($this->actividad[6]): ?>
						<a href="<?= constant('URL')?>public/upload/actividad/<?= $this->actividad[10]?>/<?= $this->actividad[0] ?>/<?= $this->actividad[6] ?>" download>Material 1</a>
						<br>
						<br>
						<?php endif ?>

						<?php if ($this->actividad[7]): ?>
						<a href="<?= constant('URL')?>public/upload/actividad/<?= $this->actividad[10]?>/<?= $this->actividad[0] ?>/<?= $this->actividad[7] ?>" download>Material 2</a>
						<br>
						<br>
						<?php endif ?>

						<?php if ($this->actividad[8]): ?>
						<a href="<?= constant('URL')?>public/upload/actividad/<?= $this->actividad[10]?>/<?= $this->actividad[0] ?>/<?= $this->actividad[8] ?>" download>Material 3</a>
						<br>
						<br>
						<?php endif ?>

						<?php if ($this->actividad[9]): ?>
						<a href="<?= constant('URL')?>public/upload/actividad/<?= $this->actividad[10]?>/<?= $this->actividad[0] ?>/<?= $this->actividad[9] ?>" download>Material 4</a>
						<br>
						<br>
						<?php endif ?>

					</div>

				</div>
			</section>
		<!-- /MOSTRAR DETALLES DE LA EVALUACION -->



		<!-- PROFESOR -->

		<?php if($_SESSION['user'] == 'profesor'): ?>

		<div id="Entregadas">
		<?php if ( !$this->evaluacionesEntregadas ): ?>

		<section class="trabajos cargados">
				<div class="contenido">
					<h3>Ningun alumnos a entregado la evaluación. </h3>
					</div>
				</div>
		</section>

		<?php else: ?>
		<section class="trabajos cargados">
				<div class="contenido">
					<h3>Evaluaciones Entregadas </h3>
					</div>
				</div>
		</section>
		<?php endif ?>


		<div id="trabajos__cargados">
		<?php foreach ($this->evaluacionesEntregadas as $evaluacionEntregada): ?>
		<section class="trabajo__cargado" data-alumno="<?= $evaluacionEntregada[3] ?>">
				<div class="titulo">
					<div class="titulo_izq">
						<h4 class="nombre"><?= $evaluacionEntregada[29]." ".$evaluacionEntregada[30]  ?></h4>
					</div>
					<div class="titulo_der">
						<div class="enlaces">

							<!-- <a title="Corregir Evaluación" href="#OpenModal<?= $evaluacionEntregada[3] ?>"><span class="icon-pencil"></span></a> -->
							<button title="Editar" class="btnModalEditar item icon-pencil btnInfo" type="button" data-alumno="<?= $evaluacionEntregada[3] ?>"></button>
						</div>
					</div>
				</div>
				<div class="contenido">

					<span class="cedula"><small><strong>C.I: </strong><?= $evaluacionEntregada[28] ?></small></span>
					<br>
					<span><small><strong>Fecha de Entrega: </strong><?= $evaluacionEntregada[4]  ?></small></span>
					<br>
					<br>
					
					<div class="correciones">
					<?php if( !isset($evaluacionEntregada[31]) ): ?>
					<span><strong>Estatus: </strong>SIN CORREGIR</span>
					<?php else: ?>
					<span><strong>Estatus: </strong>CORREGIDO</span>
					<br>
					<span><strong>Nota: </strong><span class="valor__nota"><?= $evaluacionEntregada[31] ?></span></span>
					<br>
					<span><strong>Observacion: </strong></span>
					<div class="observacion__qe"><?= $evaluacionEntregada[32] ?></div>


					<!-- MOSTRAR CORRECIONES -->


						<?php if ($evaluacionEntregada[33] or $evaluacionEntregada[34] or $evaluacionEntregada[35] or $evaluacionEntregada[36]): ?>
						<br>
						<br>
						<h4>Descargar Correcciones</h4>
						<br>
						<?php endif ?>

						<?php if ($evaluacionEntregada[33]): ?>
						<a class="link1" href="<?= constant('URL') ?>public/upload/correcciones/<?= $evaluacionEntregada[1] ?>/<?= $evaluacionEntregada[2] ?>/<?= $evaluacionEntregada[33] ?>" download>Corrección 1</a>
						<br>
						<br>
						<?php endif ?>

						<?php if ($evaluacionEntregada[34]): ?>
						<a class="link2" href="<?= constant('URL') ?>public/upload/correcciones/<?= $evaluacionEntregada[1] ?>/<?= $evaluacionEntregada[2] ?>/<?= $evaluacionEntregada[34] ?>" download>Corrección 2</a>
						<br>
						<br>
						<?php endif ?>

						<?php if ($evaluacionEntregada[35]): ?>
						<a class="link3" href="<?= constant('URL') ?>public/upload/correcciones/<?= $evaluacionEntregada[1] ?>/<?= $evaluacionEntregada[2] ?>/<?= $evaluacionEntregada[35] ?>" download>Corrección 3</a>
						<br>
						<br>
						<?php endif ?>

						<?php if ($evaluacionEntregada[36]): ?>
						<a class="link4" href="<?= constant('URL') ?>public/upload/correcciones/<?= $evaluacionEntregada[1] ?>/<?= $evaluacionEntregada[2] ?>/<?= $evaluacionEntregada[36] ?>" download>Corrección 4</a>
						<br>
						<br>
						<?php endif ?>


					<!-- /MOSTRAR CORRECIONES -->
						
					<?php endif; ?>
					</div>



				<!-- DESCRIPCION ENTRAGADA POR EL ESTUDIANTE -->
				<div class="Trabajos">
					<br>
					<br>
					<h3>DATOS ENVIADOS POR EL ESTUDIANTE</h3>
					

					<?php if ($evaluacionEntregada[27]): ?>
					<h4>Descripcion:</h4>
					<br>
					<p><?= nl2br($evaluacionEntregada[27]); ?></p>
					<?php endif ?>

				</div>
				<!-- /DESCRIPCION ENTRAGADA POR EL ESTUDIANTE -->

				<!-- LINKS ENTREGADOS POR EL ESTUDIANE -->
				<div class="trabajos">
						<?php if ($evaluacionEntregada[23] or $evaluacionEntregada[24] or $evaluacionEntregada[25] or $evaluacionEntregada[26]): ?>
						<br>
						<br>
						<h4>Links</h4>
						<br>
						<?php endif ?>

						<?php if ($evaluacionEntregada[23]): ?>
						<a href="<?= $evaluacionEntregada[23] ?>"><?= $evaluacionEntregada[19] ?></a>
						<br>
						<br>
						<?php endif ?>

						<?php if ($evaluacionEntregada[24]): ?>
						<a href="<?= $evaluacionEntregada[24] ?>"><?= $evaluacionEntregada[20] ?></a>
						<br>
						<br>
						<?php endif ?>

						<?php if ($evaluacionEntregada[25]): ?>
						<a href="<?= $evaluacionEntregada[25] ?>"><?= $evaluacionEntregada[21] ?></a>
						<br>
						<br>
						<?php endif ?>

						<?php if ($evaluacionEntregada[26]): ?>
						<a href="<?= $evaluacionEntregada[26] ?>"><?= $evaluacionEntregada[22] ?></a>
						<br>
						<br>
						<?php endif ?>
					</div>
				<!-- /LINKS ENTREGADOS POR EL ESTUDIANE -->


				<!-- ARCHIVOS ENTREGADOS POR EL ESTUDIANTE -->
					<div class="trabajos">

						<?php if ($evaluacionEntregada[5] or $evaluacionEntregada[6] or $evaluacionEntregada[7] or $evaluacionEntregada[8]): ?>
						<br>
						<br>
						<h4>Archivos</h4>
						<br>
						<?php endif ?>

						<?php if ($evaluacionEntregada[5]): ?>
						<a href="<?= constant('URL') ?>public/upload/evaluacion/<?= $evaluacionEntregada[1].'/'.$evaluacionEntregada[0].'/'.$evaluacionEntregada[5] ?>" download>Archivo 1</a>
						<br>
						<br>
						<?php endif ?>

						<?php if ($evaluacionEntregada[6]): ?>
						<a href="<?= constant('URL') ?>public/upload/evaluacion/<?= $evaluacionEntregada[1].'/'.$evaluacionEntregada[0].'/'.$evaluacionEntregada[6] ?>" download>Archivo 2</a>
						<br>
						<br>
						<?php endif ?>

						<?php if ($evaluacionEntregada[7]): ?>
						<a href="<?= constant('URL') ?>public/upload/evaluacion/<?= $evaluacionEntregada[1].'/'.$evaluacionEntregada[0].'/'.$evaluacionEntregada[7] ?>" download>Archivo 3</a>
						<br>
						<br>
						<?php endif ?>

						<?php if ($evaluacionEntregada[8]): ?>
						<a href="<?= constant('URL') ?>public/upload/evaluacion/<?= $evaluacionEntregada[1].'/'.$evaluacionEntregada[0].'/'.$evaluacionEntregada[8] ?>" download>Archivo 4</a>
						<?php endif ?>
					</div>
				<!-- /ARCHIVOS ENTREGADOS POR EL ESTUDIANTE -->

				</div>
		</section>
		<?php endforeach; ?>
		<!-- </div> -->
		</div>

		<?php endif ?>

		<!-- /PROFESOR -->



		<!-- ALUMNO  -->
		<?php if ( $this->usuario['user'] === 'alumno' ): ?>
			<!-- ALUMNO MUESTRA LA EVALUACION YA ENTREGADA -->
			<?php if ( $this->actividadAlumno ): ?>
			<div id="trabajos__cargados">
			<section class="trabajo cargado">
				<div class="titulo">
					<div class="titulo_izq">
						<h4><?= $this->usuario['nombre']  ?></h4>
					</div>
				<?php
					$fecha = strtotime(date("d-m-Y",time()));
					$flimite = strtotime($this->actividad[4]."+ 1 days");
					if ( $fecha < $flimite ):
				?>
				<div class="titulo_der">
					<div class="enlaces">
						<a title="Editar" href="#ModalEditarEstudiante" class="btnEditarAlumno">
							<span class="icon-pencil"></span>
						</a>
					</div>
				</div>
				<?php endif ?>
			</div>
			<div class="contenido">
				<span><small><strong>C.I: </strong><?= $this->usuario['cedula'] ?></small></span>
				<br>
				<span><small><strong>Fecha de Entrega: </strong><?= $this->actividadAlumno[4] ?></small></span>
				<br>
				<br>
				<br>
				<?php if(!$this->actividadAlumno[10]): ?>
				<span><strong>Estatus: </strong>SIN CORREGIR</span>
				<?php else: ?>
				<span><strong>Estatus: </strong>CORREGIDO</span>
				<br>
				<span><strong>Nota: </strong><?= $this->actividadAlumno[10] ?></span>
				<br>
				<span><strong>Observacion: </strong><?= $this->actividadAlumno[11] ?></span>

				<!-- MOSTRAR CORRECIONES -->
				<?php if ($this->actividadAlumno[30] or $this->actividadAlumno[31] or $this->actividadAlumno[32] or $this->actividadAlumno[33]): ?>
				<br>
				<br>
				<h4>Descargar Correcciones php</h4>
				<br>
				<?php endif ?>

				<?php if ($this->actividadAlumno[30]): ?>
				<a href="<?= constant('URL') ?>upload/correcciones/<?= $this->actividadAlumno[1] ?>/<?= $this->actividadAlumno[2] ?>/<?= $this->actividadAlumno[30] ?>" download>Correccion 1</a>
				<br>
				<br>
				<?php endif ?>

				<?php if ($this->actividadAlumno[31]): ?>
				<a href="<?= constant('URL') ?>upload/correcciones/<?= $this->actividadAlumno[1] ?>/<?= $this->actividadAlumno[2] ?>/<?= $this->actividadAlumno[31] ?>" download>Correccion 2</a>
				<br>
				<br>
				<?php endif ?>

				<?php if ($this->actividadAlumno[32]): ?>
				<a href="<?= constant('URL') ?>upload/correcciones/<?= $this->actividadAlumno[1] ?>/<?= $this->actividadAlumno[2] ?>/<?= $this->actividadAlumno[32] ?>" download>Correccion 3</a>
				<br>
				<br>
				<?php endif ?>

				<?php if ($this->actividadAlumno[33]): ?>
				<a href="<?= constant('URL') ?>upload/correcciones/<?= $this->actividadAlumno[1] ?>/<?= $this->actividadAlumno[2] ?>/<?= $this->actividadAlumno[33] ?>" download>Correccion 4</a>
				<br>
				<br>
				<?php endif ?>


			<!-- /MOSTRAR CORRECIONES -->



			<?php endif ?>



		<!-- DESCRIPCION ENTRAGADA POR EL ESTUDIANTE -->
		<?php if ($this->actividadAlumno[29]): ?>
		<div class="Trabajos">
			<br>
			<br>
			<h4>Descripcion</h4>
			<br>
			<p><?= nl2br($this->actividadAlumno[29]); ?></p>
		</div>
		<?php endif ?>
		<!-- /DESCRIPCION ENTRAGADA POR EL ESTUDIANTE -->



		<!-- LINKS ENTREGADOS POR EL ESTUDIANE -->
		<div class="trabajos">
						<?php if ($this->actividadAlumno[23] or $this->actividadAlumno[24] or $this->actividadAlumno[25] or $this->actividadAlumno[26]): ?>
						<br>
						<br>
						<h4>Links</h4>
						<br>
						<?php endif ?>

						<?php if ($this->actividadAlumno[23]): ?>
						<a href="<?= $this->actividadAlumno[23] ?>"><?= $this->actividadAlumno[19] ?></a>
						<br>
						<br>
						<?php endif ?>

						<?php if ($this->actividadAlumno[24]): ?>
						<a href="<?= $this->actividadAlumno[24] ?>"><?= $this->actividadAlumno[20] ?></a>
						<br>
						<br>
						<?php endif ?>

						<?php if ($this->actividadAlumno[25]): ?>
						<a href="<?= $this->actividadAlumno[25] ?>"><?= $this->actividadAlumno[21] ?></a>
						<br>
						<br>
						<?php endif ?>

						<?php if ($this->actividadAlumno[26]): ?>
						<a href="<?= $this->actividadAlumno[26] ?>"><?= $this->actividadAlumno[22] ?></a>
						<br>
						<br>
						<?php endif ?>
					</div>
				<!-- /LINKS ENTREGADOS POR EL ESTUDIANE -->

		<!-- ARCHIVOS ENTREGADOS POR EL ESTUDIANTE -->
			<?php if ($this->actividadAlumno[5] or $this->actividadAlumno[6] or $this->actividadAlumno[7] or $this->actividadAlumno[8]): ?>
			<div class="trabajos">
				<br>
				<br>
				<h4>Archivos</h4>
				<br>
				<?php if ($this->actividadAlumno[5]): ?>
				<a href="<?= constant('URL') ?>public/upload/evaluacion/<?= $this->actividadAlumno[1].'/'.$this->actividadAlumno[0].'/'.$this->actividadAlumno[5] ?>" download>Archivo 1</a>
				<br>
				<br>
				<?php endif ?>

				<?php if ($this->actividadAlumno[6]): ?>
				<a href="<?= constant('URL') ?>public/upload/evaluacion/<?= $this->actividadAlumno[1].'/'.$this->actividadAlumno[0].'/'.$this->actividadAlumno[6] ?>" download>Archivo 2</a>
				<br>
				<br>
				<?php endif ?>

				<?php if ($this->actividadAlumno[7]): ?>
				<a href="<?= constant('URL') ?>public/upload/evaluacion/<?= $this->actividadAlumno[1].'/'.$this->actividadAlumno[0].'/'.$this->actividadAlumno[7] ?>" download>Archivo 3</a>
				<br>
				<br>
				<?php endif ?>

				<?php if ($this->actividadAlumno[8]): ?>
				<a href="<?= constant('URL') ?>public/upload/evaluacion/<?= $this->actividadAlumno[1].'/'.$this->actividadAlumno[0].'/'.$this->actividadAlumno[8] ?>" download>Archivo 4</a>
				<?php endif ?>
			</div>
			<?php endif ?>
		<!-- /ARCHIVOS ENTREGADOS POR EL ESTUDIANTE -->

		<!-- MODAL EDITAR EVALUACION ENVIADA POR ALUMNO -->
			<div id="ModalEditarEstudiante" class="editar">
				<form id="FormEditarEstudiante" method="post" enctype="multipart/form-data" action="<?= constant('URL') ?>evaluacion/updateEvaluacionAlumno/<?= $this->actividadAlumno[1] ?>/<?= $this->actividadAlumno[0]?>">

					<div class="grupo">
							<br>
							<br>
							<h3>Descripcion</h3>
						</div>
					<div class="grupo">
							<textarea name="descripcion" id="message" cols="30" rows="10" placeholder="Descripcion"><?= $this->actividadAlumno[29]; ?></textarea>
					</div>


					<!-- CARGAR ARCHIVO -->
						<div class="grupo">
							<br>
							<br>
							<h3>Archivos</h3>
						</div>
						<div class="grupo">
							<div class="grupo">
								<?php if ($this->actividadAlumno[5]): ?>
									<a href="<?= constant('URL') ?>public/upload/evaluacion/<?= $this->actividadAlumno[1].'/'.$this->actividadAlumno[0].'/'.$this->actividadAlumno[5] ?>" class="col-md-12 col-xs-12 col-sm-12" download><strong>ARCHIVO 1 CARGADO</strong></a>
								<?php else: ?>
									<a>SIN CARGAR</a>
								<?php endif; ?>
								<input id="file1" name="file[]" type="file">
							</div>

							<div class="grupo">
								<?php if ($this->actividadAlumno[6]): ?>
									<a href="<?= constant('URL') ?>public/upload/evaluacion/<?= $this->actividadAlumno[1].'/'.$this->actividadAlumno[0].'/'.$this->actividadAlumno[6] ?>" class="col-md-12 col-xs-12 col-sm-12" download><strong>ARCHIVO 2 CARGADO</strong></a>
								<?php else: ?>
									<a>SIN CARGAR</a>
								<?php endif; ?>
								<input id="file2" name="file[]" type="file">
							</div>

							<div class="grupo">
								<?php if ($this->actividadAlumno[7]): ?>
									<a href="<?= constant('URL') ?>public/upload/evaluacion/<?= $this->actividadAlumno[1].'/'.$this->actividadAlumno[0].'/'.$this->actividadAlumno[7] ?>" class="col-md-12 col-xs-12 col-sm-12" download><strong>ARCHIVO 3 CARGADO</strong></a>
								<?php else: ?>
									<a>SIN CARGAR</a>
								<?php endif; ?>
								<input id="file3" name="file[]" type="file">
							</div>

							<div class="grupo">
								<?php if ($this->actividadAlumno[8]): ?>
									<a href="<?= constant('URL') ?>public/upload/evaluacion/<?= $this->actividadAlumno[1].'/'.$this->actividadAlumno[0].'/'.$this->actividadAlumno[8] ?>" class="col-md-12 col-xs-12 col-sm-12" download><strong>ARCHIVO 4 CARGADO</strong></a>
								<?php else: ?>
									<a>SIN CARGAR</a>
								<?php endif; ?>
								<input id="file4" name="file[]" type="file">
							</div>

						</div>
					<!-- /CARGAR ARCHIVO -->

						<div class="form-group row">
							<input type="text" name="materia" value="<?= $this->actividad[10]  ?>" style="display: none;">
							<input type="text" name="evaluacion" value="<?= $this->actividad[0] ?>" style="display: none;">
							<input type="text" name="evaluacionAlumno" value="<?= $this->actividadAlumno[12] ?>" style="display: none;">
						</div>

						<div class="botones">
							<button class="item btnTrue" type="submit" >Guardar</button>
							<a class="item close" href="#close" class="cerrar" >Cancelar</a>
						</div>
					</form>
			</div>
		<!-- /MODAL EDITAR EVALUACION ENVIADA POR ALUMNO -->

		</div>
</section>

			
</div>

<!-- /ALUMNO MUESTRA LA EVALUACION YA ENTREGADA -->
<?php else: ?>

			<?php
				$flimite = strtotime($this->actividad[4]."+ 1 days");
				$fecha = strtotime(date("d-m-Y",time()));
				if ( $flimite > $fecha ):
			?>
			<!-- FORMULARIO PARA QUE EL ALUMNO CARGUE LA EVALUACION -->
			<section class="section_agregar">
				<div class="titulo">
					<h3>Cargar Evaluacion</h3>
				</div>
				<div class="contenido">
					<form method="post" enctype="multipart/form-data" action="<?= constant('URL') ?>evaluacion/addEvaluacionAlumno/<?= $this->actividad[10].'/'.$this->actividad[0] ?>">

					<div class="grupo">
							<br>
							<br>
							<h3>Descripcion</h3>
						</div>
					<div class="grupo">
							<textarea name="descripcion" id="message" cols="30" rows="10" placeholder="Descripcion"></textarea>
					</div>
					<!-- <div class="grupo">
						<div id="editor" style="height: 375px;"></div>
						<textarea name="descripcion" id="descripcion" cols="20" rows="10" style="display:none;"></textarea>
						<p id="editor_contador">caracteres (<span id="editor_caracteres">0</span>/50000)</p>
					</div> -->

					<!-- SECCION DE AGREGAR LINKS -->

						<!-- <div class="grupo">
							<br>
							<br>
							<h3>Links</h3>
							<br>
							<p><small>
								Para agregar un link tendrás que colocar un nombre en el campo (Nombre link) y luego colocar el link en el campo de abajo (Link) colocar el link. 
								<br>
								<br>
								Ejemplo:

								<br>
								Nombre Link = Pagina Web del Instituto
								<br>
								Url del Link = https://iutjmc.com.ve
								<br>
								<br>
								Aparecerá de esta manera al profesor <a href="https://iutjmc.com.ve">Pagina Web del Instituto</a>
							</small></p>
						</div>

						<div class="grupo">
							<span>Link 1</span>
							<div class="grupo">
								<label for="">Nombre del Link</label>
								<input id="nlink1" name="nlink1"  type="text" placeholder="Nombre del link 1">
							</div>
							<div class="grupo">
								<label for="">Url del Link</label>
								<input id="link1" name="link1" type="text" placeholder="Url del Link 1">
							</div>
						</div>

						<div class="grupo">
							<span>Link 2</span>
							<div class="grupo">
								<label for="">Nombre del Link</label>
								<input id="nlink2" name="nlink2" type="text" placeholder="Nombre del link 2">
							</div>
							<div class="grupo">
								<label for="">Url del Link</label>
								<input id="link2" name="link2" type="text" placeholder="Url del Link 2">
							</div>
						</div>

						<div class="grupo">
							<span>Link 3</span>
							<div class="grupo">
								<label for="">Nombre del Link</label>
								<input id="nlink3" name="nlink3" type="text" placeholder="Nombre del link 3">
							</div>
							<div class="grupo">
								<label for="">Url del Link</label>
								<input id="link3" name="link3" type="text" placeholder="Url del Link 3">
							</div>

						</div>

						<div class="grupo">
							<span>Link 4</span>
							<div class="grupo">
								<label for="">Nombre del Link</label>
								<input id="nlink4" name="nlink4" type="text" placeholder="Nombre del link 4">
							</div>
							<div class="grupo">
								<label for="">Url del Link</label>
								<input id="link4" name="link4" type="text" placeholder="Url del Link 4">
							</div>
						</div> -->

					<!-- /SECCION DE AGREGAR LINKS -->

					<!-- CARGAR ARCHIVO -->
						<div class="grupo">
							<br>
							<br>
							<h3>Archivos</h3>
						</div>
						<div class="grupo">
							<div class="grupo">
								<?php if ( isset($this->actividadAlumno[4]) ): ?>
									<a href="<?= constant('URL') ?>public/upload/evaluacion/<?= $this->actividadAlumno[1] ?>/ <?= $this->actividadAlumno[0] ?>/ <?= $this->actividadAlumno[4] ?>" class="col-md-12 col-xs-12 col-sm-12" download><strong>ARCHIVO 1 CARGADO</strong></a>
								<?php else: ?>
									<a>SIN CARGAR</a>
								<?php endif; ?>


								<input id="file1" name="file[]" type="file">
							</div>
							<div class="grupo">
								<?php if ( isset($this->actividadAlumno[5]) ): ?>
									<a href="<?= constant('URL') ?>public/upload/evaluacion/<?= $this->actividadAlumno[1] ?>/ <?= $this->actividadAlumno[0] ?>/ <?= $this->actividadAlumno[5] ?>" class="col-md-12 col-xs-12 col-sm-12" download><strong>ARCHIVO 2 CARGADO</strong></a>
								<?php else: ?>
									<a>SIN CARGAR</a>
								<?php endif; ?>


								<input id="file2" name="file[]" type="file">
							</div>
							<div class="grupo">
								<?php if ( isset($this->actividadAlumno[6]) ): ?>
									<a href="<?= constant('URL') ?>public/upload/evaluacion/<?= $this->actividadAlumno[1] ?>/ <?= $this->actividadAlumno[0] ?>/ <?= $this->actividadAlumno[6] ?>" class="col-md-12 col-xs-12 col-sm-12" download><strong>ARCHIVO 3 CARGADO</strong></a>
								<?php else: ?>
									<a>SIN CARGAR</a>
								<?php endif; ?>

								<input id="file3" name="file[]" type="file">
							</div>
							<div class="grupo">
								<?php if ( isset($this->actividadAlumno[7]) ): ?>
									<a href="<?= constant('URL') ?>public/upload/evaluacion/<?= $this->actividadAlumno[1] ?>/ <?= $this->actividadAlumno[0] ?>/ <?= $this->actividadAlumno[7] ?>" class="col-md-12 col-xs-12 col-sm-12" download><strong>ARCHIVO 4 CARGADO</strong></a>
								<?php else: ?>
									<a>SIN CARGAR</a>
								<?php endif; ?>


								<input id="file4" name="file[]" type="file">
							</div>
						</div>
					<!-- /CARGAR ARCHIVO -->

						<div class="form-group row">
							<input type="text" name="materia" value="<?= $this->actividad[10]  ?>" style="display: none;">
							<input type="text" name="alumno" value="<?= $this->usuario['id'] ?>" style="display: none;">
							<input type="text" name="evaluacion" value="<?= $this->actividad[0] ?>" style="display: none;">
						</div>

						<button class="btnTrue">Guardar</button>
					</form>
				</div>
			</section>
			
			<?php else: ?>
				<section>
					<div class="contenido">
						<h1>La fecha límite de entrega de la evaluación ha finalizado</h1>
					</div>
				</section>
			<?php endif ?>
				<!-- /FORMULARIO PARA QUE EL ALUMNO CARGUE LA EVALUACION -->
<?php endif ?>


				<?php endif ?>

				<!-- /ALUMNO -->






				<section class="section_agregar">
<!-- AGREGAR NOTAS -->
	<!-- SECCION DE PREVIEW MODAL -->

	<div class="modal" id="modalEditar">
							<div class="flex" id="flexEditar">
								<div class="modal__contenido">
									<div class="modal__header">
										<h3>Previsualización</h3>
										<a id="btnCerrarEditar">&times;</a>
									</div>
									<div class="modal__preview">
										<!-- FORMULARIO AGREGAR Y EDITAR NOTAS -->
<form id="set__nota" enctype="multipart/form-data" method="post" >
	<div class="grupo">
		<label for="nota">Nota </label>
		<select name="nota" id="nota">
		<?php if ($this->barMateria[5] === 'Bachillerato'): ?>
			<option value="" selected="selected">Sin cargar notas</option>
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="4">4</option>
			<option value="5">5</option>
			<option value="6">6</option>
			<option value="7">7</option>
			<option value="8">8</option>
			<option value="9">9</option>
			<option value="10">10</option>
			<option value="11">11</option>
			<option value="12">12</option>
			<option value="13">13</option>
			<option value="14">14</option>
			<option value="15">15</option>
			<option value="16">16</option>
			<option value="17">17</option>
			<option value="18">18</option>
			<option value="19">19</option>
			<option value="20">20</option>
			<?php elseif ( $this->barMateria[5] === 'Primaria'): ?>
			<option value="A">A</option>
			<option value="B">B</option>
			<option value="C">C</option>
			<option value="D">D</option>
			<option value="E">E</option>
			<option value="F">F</option>
			<?php elseif ( $this->barMateria[5] === 'Preescolar'): ?>
				<option value="EXCELENTE">EXCELENTE</option>
				<option value="MUY BIEN">MUY BIEN</option>
				<option value="BIEN">BIEN</option>
			<?php endif ?>
		</select>
		<p class="formulario__input-error">* Este campo debe llenarse obligatoriamente</p>
	</div>

	<div class="grupo">
		<label for="observacion">Observacion</label>
		<div id="editor" style="height: 375px;"></div>
		<p id="editor_contador">caracteres (<span id="editor_caracteres">0</span>/50000)</p>
		<textarea name="observacion" id="observacion" cols="30" rows="10" style="display: none;"></textarea>
	</div>

	<!-- SECCION DE AGREGAR ARCHIVOS -->

	<div class="grupo">
		<div>
			<br>
			<br>
			<h3>Agregar Archivos</h3>
			<br>
		</div>

		<div id="grupo_archivos_editar">
			<div id="link1"></div>
			<input type="file" name="file[]" class="file1">
			<p class="formulario__input-error"></p>
			<div id="link2"></div>
			<input type="file" name="file[]" class="file2">
			<p class="formulario__input-error"></p>
			<div id="link3"></div>
			<input type="file" name="file[]" class="file3">
			<p class="formulario__input-error"></p>
			<div id="link4"></div>
			<input type="file" name="file[]" class="file4">
			<p class="formulario__input-error"></p>
		</div>
	</div>

	<!-- /SECCION DE AGREGAR ARCHIVOS -->

	<div class="grupo_oculto">
		<input type="text" name="materia" value="<?= $this->actividad[10] ?>" style="display: none;">
		<input type="text" name="plan" value="<?= $this->actividad[22] ?>" style="display: none;">
		<input type="text" name="alumno" value="" style="display: none;">
		<input type="text" name="evaluacion" value="<?= $this->actividad[0] ?>" style="display: none;">
		<input type="text" name="corregir" value="true" style="display: none;">
	</div>

	<div class="grupo">
		<div class="mensaje__error">
			<p>No se puedo guardar, por favor revise todo los campos y verifique que no tengan ningun error.</p>
		</div>
		<div class="mensaje__exito">
		</div>
	</div>

	<div class="grupo botones">
		<button id="btnSubmit" class="item btnTrue" type="submit" >Guardar</button>
	</div>
</form>
										<!-- /FORMULARIO AGREGAR Y EDITAR NOTAS -->
									</div>
								</div>
							</div>
						</div>

					<!-- /SECCION DE PREVIEW MODAL -->
<!-- /AGREGAR NOTAS -->
</section>

		</main>

	</div>



	<footer>

	</footer>




	<!-- Main Quill library -->
	<script src="<?= constant('URL') ?>public/quill/quill.min.js"></script>

	<!-- JS -->
	<script src="<?= constant('URL') ?>public/js/config.js"></script>
	<script src="<?= constant('URL') ?>public/js/menu.js"></script>
	<script src="<?= constant('URL') ?>public/js/evaluaciones__detail.js"></script>
	<!-- /JS -->

</body>
</html>