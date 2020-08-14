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
	<title>IUTJMC - Evaluaciones</title>


	<!-- CUSTOM CSS -->
	<link rel="stylesheet" href="<?= constant('URL') ?>public/icon/icomoon/style.css">
	<link rel="stylesheet" href="<?= constant('URL') ?>public/css/evaluaciones.css">
	<!-- /CUSTOM CSS -->
	<script src="<?= constant('URL') ?>public/js/jquery/jquery-3.5.0.min.js"></script>
	<script src="<?= constant('URL') ?>public/js/jquery/jquery.cookie.js"></script>


</head>
<body>

	<?php Loader(); ?>
	<?php Headerr(); ?>


	<div class="contenido">

		<?php Navbar($this->usuario, $this->navbarMaterias); ?>

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
							<a title="Editar" href="#ModalEditar<?= $this->actividad[0] ?>"><span class="icon-pencil"></span></a>
						</div>
					</div>
					<?php endif ?>

				</div>
				<div class="contenido">
					<p><strong>Fecha limite: </strong><?= $this->actividad[4] ?></p>
					<p><strong>Valor: </strong><?= $this->actividad[1] ?>%</p>
					<p><strong>Punto: </strong><?= $this->actividad[1] * 0.20 ?>pts</p>
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

					<!-- MODAL EDITAR EVALUACION -->
					<?php if ($_SESSION['user'] === 'profesor'): ?>

					<div id="ModalEditar<?= $this->actividad[0] ?>" class="editar">
						<form method="post" enctype="multipart/form-data" action="<?= constant('URL') ?>evaluacion/edit/<?= $this->barMateria[2] ?>/<?= $this->actividad[0]?>">
							<div class="grupo">
								<label for="plan">Evaluacion</label>
								<select name="plan" id="plan_evaluacion">
									<option value="<?= $this->actividad[22] ?>" selected><?= $this->actividad[2].": ".$this->actividad[1]."% - ".$this->actividad[21] ?></option>

								</select>
							</div>
							<div class="grupo">
								<label for="fecha">Fecha</label>
								<?php
									$f = $this->actividad[4];
									$dias = explode("-", $f);
								?>
								<input type="date" id="fecha_evaluacion" name="fecha" value="<?= $dias[2].'-'.$dias[1].'-'.$dias[0] ?>">
							</div>

							<div class="grupo">
								<textarea name="descripcion" id="descripcion_evaluacion" cols="20" rows="10" placeholder="Descripcion de la evaluacion"><?= $this->actividad[5] ?></textarea>
							</div>


						<!-- SECCION DE AGREGAR LINKS -->

							<div class="grupo">
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
									Aparecerá de esta manera a los alumnos <a href="https://iutjmc.com.ve">Pagina Web del Instituto</a>
								</small></p>
							</div>

							<div class="grupo">
								<span>Link 1</span>
								<div class="grupo">
									<label for="">Nombre del Link</label>
									<input id="nlink1" name="nlink1"  type="text" placeholder="Nombre del link 1" value="<?= $this->actividad[13] ?>">
								</div>
								<div class="grupo">
									<label for="">Url del Link</label>
									<input id="link1" name="link1" type="text" placeholder="Url del Link 1" value="<?= $this->actividad[17] ?>">
								</div>
							</div>

							<div class="grupo">
								<span>Link 2</span>
								<div class="grupo">
									<label for="">Nombre del Link</label>
									<input id="nlink2" name="nlink2" type="text" placeholder="Nombre del link 2" value="<?= $this->actividad[14] ?>">
								</div>
								<div class="grupo">
									<label for="">Url del Link</label>
									<input id="link2" name="link2" type="text" placeholder="Url del Link 2" value="<?= $this->actividad[18] ?>">
								</div>
							</div>

							<div class="grupo">
								<span>Link 3</span>
								<div class="grupo">
									<label for="">Nombre del Link</label>
									<input id="nlink3" name="nlink3" type="text" placeholder="Nombre del link 3" value="<?= $this->actividad[15] ?>">
								</div>
								<div class="grupo">
									<label for="">Url del Link</label>
									<input id="link3" name="link3" type="text" placeholder="Url del Link 3" value="<?= $this->actividad[19] ?>">
								</div>

							</div>

							<div class="grupo">
								<span>Link 4</span>
								<div class="grupo">
									<label for="">Nombre del Link</label>
									<input id="nlink4" name="nlink4" type="text" placeholder="Nombre del link 4" value="<?= $this->actividad[16] ?>">
								</div>
								<div class="grupo">
									<label for="">Url del Link</label>
									<input id="link4" name="link4" type="text" placeholder="Url del Link 4" value="<?= $this->actividad[20] ?>">
								</div>
							</div>

						<!-- /SECCION DE AGREGAR LINKS -->



						<!-- EDITAR ARCHIVOS -->
							<div class="grupo">
								<br>
								<br>
								<h3>Archivos</h3>
							</div>

							<div class="grupo">
								<?php if ($this->actividad[6]): ?>
								<a href="<?= constant('URL') ?>public/upload/actividad/<?= $this->actividad[10]?>/<?= $this->actividad[0] ?>/<?= $this->actividad[6] ?>" download>Material 1</a>
								<br>
								<br>
								<?php else: ?>
								<p>Material 1 - SIN CARGAR</p>
								<br>
								<?php endif ?>
								<input name="file[]" type="file">
							</div>
							<div class="grupo">
								<?php if ($this->actividad[7]): ?>
								<a href="<?= constant('URL') ?>public/upload/actividad/<?= $this->actividad[10]?>/<?= $this->actividad[0] ?>/<?= $this->actividad[7] ?>" download>Material 2</a>
								<br>
								<br>
								<?php else: ?>
								<p>Material 2 - SIN CARGAR</p>
								<br>
								<?php endif ?>
								<input name="file[]" type="file">
							</div>
							<div class="grupo">
								<?php if ($this->actividad[8]): ?>
								<a href="<?= constant('URL') ?>public/upload/actividad/<?= $this->actividad[10]?>/<?= $this->actividad[0] ?>/<?= $this->actividad[8] ?>" download>Material 3</a>
								<br>
								<br>
								<?php else: ?>
								<p>Material 3 - SIN CARGAR</p>
								<br>
								<?php endif ?>
								<input name="file[]" type="file">
							</div>
							<div class="grupo">
								<?php if ($this->actividad[9]): ?>
								<a href="<?= constant('URL') ?>public/upload/actividad/<?= $this->actividad[10]?>/<?= $this->actividad[0] ?>/<?= $this->actividad[9] ?>" download>Material 4</a>
								<br>
								<br>
								<?php else: ?>
								<p>Material 4 - SIN CARGAR</p>
								<br>
								<?php endif ?>
								<input name="file[]" type="file">
							</div>
						<!-- /EDITAR ARCHIVOS -->



							<div class="grupo_oculto">
								<input type="text" name="mat" style="display: none;" value="<?= $this->actividad[10] ?> ">
								<input type="text" name="actividad" style="display: none;" value="<?= $this->actividad[0] ?> ">
							</div>


							<div class="botones">
								<button class="item" type="submit" >Guardar</button>
								<a class="item close cerrar" href="#close"  >Cancelar</a>
							</div>



						</form>


					</div>

					<?php endif ?>
				<!-- /MODAL EDITAR EVALUACION -->

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

		<?php foreach ($this->evaluacionesEntregadas as $actividad): ?>

		<section class="trabajos cargados">
				<div class="titulo">
					<div class="titulo_izq">
						<h4><?= $actividad[35]." ".$actividad[36]  ?></h4>
					</div>
					<div class="titulo_der">
						<div class="enlaces">

							<a title="Corregir Evaluación" href="#OpenModal<?= $actividad[3] ?>"><span class="icon-pencil"></span></a>
						</div>
					</div>
				</div>
				<div class="contenido">

					<span><small><strong>C.I: </strong><?= $actividad[34] ?></small></span>
					<br>
					<span><small><strong>Fecha de Entrega: </strong><?= $actividad[4]  ?></small></span>
					<br>
					<br>
					
					<?php if( !isset($actividad[10]) ): ?>
					<span><strong>Estatus: </strong>SIN CORREGIR</span>
					<?php else: ?>
					<span><strong>Estatus: </strong>CORREGIDO</span>
					<br>
					<span><strong>Nota: </strong><?= $actividad[10] ?></span>
					<br>
					<span><strong>Observacion: </strong><?= $actividad[11] ?></span>


					<!-- MOSTRAR CORRECIONES -->


						<?php if ($actividad[30] or $actividad[31] or $actividad[32] or $actividad[33]): ?>
						<br>
						<br>
						<h4>Descargar Correcciones</h4>
						<br>
						<?php endif ?>

						<?php if ($actividad[30]): ?>
						<a href="<?= constant('URL') ?>public/upload/correcciones/<?= $actividad[1] ?>/<?= $actividad[2] ?>/<?= $actividad[30] ?>" download>Material 1</a>
						<br>
						<br>
						<?php endif ?>

						<?php if ($actividad[31]): ?>
						<a href="<?= constant('URL') ?>public/upload/correcciones/<?= $actividad[1] ?>/<?= $actividad[2] ?>/<?= $actividad[31] ?>" download>Material 2</a>
						<br>
						<br>
						<?php endif ?>

						<?php if ($actividad[32]): ?>
						<a href="<?= constant('URL') ?>public/upload/correcciones/<?= $actividad[1] ?>/<?= $actividad[2] ?>/<?= $actividad[32] ?>" download>Material 3</a>
						<br>
						<br>
						<?php endif ?>

						<?php if ($actividad[33]): ?>
						<a href="<?= constant('URL') ?>public/upload/correcciones/<?= $actividad[1] ?>/<?= $actividad[2] ?>/<?= $actividad[33] ?>" download>Material 4</a>
						<br>
						<br>
						<?php endif ?>


					<!-- /MOSTRAR CORRECIONES -->

					<?php endif; ?>



				<!-- DESCRIPCION ENTRAGADA POR EL ESTUDIANTE -->
				<div class="Trabajos">
					<br>
					<br>
					<h3>DATOS ENVIADOS POR EL ESTUDIANTE</h3>

					<?php if ($actividad[29]): ?>
					<h4>Descripcion</h4>
					<br>
					<p><?= nl2br($actividad[29]); ?></p>
					<?php endif ?>

				</div>
				<!-- /DESCRIPCION ENTRAGADA POR EL ESTUDIANTE -->




				<!-- ARCHIVOS ENTREGADOS POR EL ESTUDIANTE -->
					<div class="trabajos">

						<?php if ($actividad[5] or $actividad[6] or $actividad[7] or $actividad[8]): ?>
						<br>
						<br>
						<h4>Archivos</h4>
						<br>
						<?php endif ?>

						<?php if ($actividad[5]): ?>
						<a href="<?= constant('URL') ?>public/upload/evaluacion/<?= $actividad[1].'/'.$actividad[0].'/'.$actividad[5] ?>" download>Archivo 1</a>
						<br>
						<br>
						<?php endif ?>

						<?php if ($actividad[6]): ?>
						<a href="<?= constant('URL') ?>public/upload/evaluacion/<?= $actividad[1].'/'.$actividad[0].'/'.$actividad[6] ?>" download>Archivo 2</a>
						<br>
						<br>
						<?php endif ?>

						<?php if ($actividad[7]): ?>
						<a href="<?= constant('URL') ?>public/upload/evaluacion/<?= $actividad[1].'/'.$actividad[0].'/'.$actividad[7] ?>" download>Archivo 3</a>
						<br>
						<br>
						<?php endif ?>

						<?php if ($actividad[8]): ?>
						<a href="<?= constant('URL') ?>public/upload/evaluacion/<?= $actividad[1].'/'.$actividad[0].'/'.$actividad[8] ?>" download>Archivo 4</a>
						<?php endif ?>
					</div>
				<!-- /ARCHIVOS ENTREGADOS POR EL ESTUDIANTE -->


				<!-- CORREGIR EVALUACION PROFESOR -->
					<div id="OpenModal<?= $actividad[3] ?>" class="Modal">
						<form enctype="multipart/form-data" method="post" action="<?= constant('URL') ?>nota/addNota/<?= $actividad[1] ?>/<?= $actividad[0]?>">
							<div class="grupo">
								<label for="nota">Nota</label>
								<select name="nota" id="nota">
									<?php
									$n = 0;
									while ( $n <= 20) {

										if ($actividad[10] == $n) {
											print '<option selected="selected" value="'.$n.'">'.$n.'</option>';
										}else{
											print '<option value="'.$n.'">'.$n.'</option>';
										}
										$n++;

									} ?>
								</select>
							</div>
							<div class="grupo">
								<label for="">Observacion</label>
								<textarea name="observacion" id="observacion" cols="30" rows="10"><?= $actividad[11] ?></textarea>
							</div>

							<div class="grupo_oculto">
								<input type="text" name="materia" value="<?= $actividad[1] ?>" style="display: none;">
								<input type="text" name="plan" value="<?= $actividad[2] ?>" style="display: none;">
								<input type="text" name="alumno" value="<?= $actividad[3] ?>" style="display: none;">
							</div>

							<div class="grupo">

								<div class="grupo">

									<h3>Archivos</h3>
								</div>
								<input type="file" name="file[]">
								<br>
								<input type="file" name="file[]">
								<br>
								<input type="file" name="file[]">
								<br>
								<input type="file" name="file[]">
							</div>

							<div class="botones">
								<button  type="submit">Guardar</button>
								<a  href="#close" class="cerrar">Cerrar</a>
							</div>



						</form>
					</div>
				<!-- /CORREGIR EVALUACION PROFESOR -->

				

				

				</div>
		</section>


		<?php endforeach; ?>
		</div>

		<?php endif ?>

		<!-- /PROFESOR -->



		<!-- ALUMNO  -->
		<?php if ( $this->usuario['user'] === 'alumno' ): ?>


			<!-- ALUMNO MUESTRA LA EVALUACION YA ENTREGADA -->
<?php if ( $this->actividadAlumno ): ?>
<section class="trabajos cargados">
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
					<a title="Editar" href="#ModalEditarEstudiante"><span class="icon-pencil"></span></a>

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



		<!-- LINKS ENTREGADOS POR EL ESTUDIANTE -->
			<div class="trabajos">

				<?php if ($this->actividadAlumno[21] or $this->actividadAlumno[22] or $this->actividadAlumno[23] or $this->actividadAlumno[24]): ?>
				<br>
				<br>
				<h4>Links</h4>
				<br>
				<?php endif ?>

				<?php if ($this->actividadAlumno[21]): ?>
				<a href="<?= $this->actividadAlumno[25] ?>"><?= $this->actividadAlumno[21] ?></a>
				<br>
				<br>
				<?php endif ?>

				<?php if ($this->actividadAlumno[22]): ?>
				<a href="<?= $this->actividadAlumno[26] ?>"><?= $this->actividadAlumno[22] ?></a>
				<br>
				<br>
				<?php endif ?>

				<?php if ($this->actividadAlumno[23]): ?>
				<a href="<?= $this->actividadAlumno[27] ?>"><?= $this->actividadAlumno[23] ?></a>
				<br>
				<br>
				<?php endif ?>

				<?php if ($this->actividadAlumno[24]): ?>
				<a href="<?= $this->actividadAlumno[28] ?>"><?= $this->actividadAlumno[24] ?></a>
				<br>
				<br>
				<?php endif ?>

			</div>
		<!-- /LINKS ENTREGADOS POR EL ESTUDIANTE -->


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
				<form method="post" enctype="multipart/form-data" action="<?= constant('URL') ?>evaluacion/updateEvaluacionAlumno/<?= $this->actividadAlumno[1] ?>/<?= $this->actividadAlumno[0]?>">

					<div class="grupo">
							<br>
							<br>
							<h3>Descripcion</h3>
						</div>
					<div class="grupo">
							<textarea name="descripcion" id="message" cols="30" rows="10" placeholder="Descripcion"><?= $this->actividadAlumno[29]; ?></textarea>
					</div>

					<!-- SECCION DE AGREGAR LINKS -->

						<div class="grupo">
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
								<input id="nlink1" name="nlink1"  type="text" placeholder="Nombre del link 1" value=" <?= $this->actividadAlumno[21] ?>">
							</div>
							<div class="grupo">
								<label for="">Url del Link</label>
								<input id="link1" name="link1" type="text" placeholder="Url del Link 1" value=" <?= $this->actividadAlumno[25] ?>">
							</div>
						</div>

						<div class="grupo">
							<span>Link 2</span>
							<div class="grupo">
								<label for="">Nombre del Link</label>
								<input id="nlink2" name="nlink2" type="text" placeholder="Nombre del link 2" value=" <?= $this->actividadAlumno[22] ?>">
							</div>
							<div class="grupo">
								<label for="">Url del Link</label>
								<input id="link2" name="link2" type="text" placeholder="Url del Link 2" value=" <?= $this->actividadAlumno[26] ?>">
							</div>
						</div>

						<div class="grupo">
							<span>Link 3</span>
							<div class="grupo">
								<label for="">Nombre del Link</label>
								<input id="nlink3" name="nlink3" type="text" placeholder="Nombre del link 3" value=" <?= $this->actividadAlumno[23] ?>">
							</div>
							<div class="grupo">
								<label for="">Url del Link</label>
								<input id="link3" name="link3" type="text" placeholder="Url del Link 3" value=" <?= $this->actividadAlumno[27] ?>">
							</div>

						</div>

						<div class="grupo">
							<span>Link 4</span>
							<div class="grupo">
								<label for="">Nombre del Link</label>
								<input id="nlink4" name="nlink4" type="text" placeholder="Nombre del link 4" value=" <?= $this->actividadAlumno[24] ?>">
							</div>
							<div class="grupo">
								<label for="">Url del Link</label>
								<input id="link4" name="link4" type="text" placeholder="Url del Link 4" value=" <?= $this->actividadAlumno[28] ?>">
							</div>
						</div>

					<!-- /SECCION DE AGREGAR LINKS -->

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
							<button class="item" type="submit" >Guardar</button>
							<a class="item close" href="#close" class="cerrar" >Cancelar</a>
						</div>
					</form>
			</div>
		<!-- /MODAL EDITAR EVALUACION ENVIADA POR ALUMNO -->

		</div>
</section>

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

					<!-- SECCION DE AGREGAR LINKS -->

						<div class="grupo">
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
						</div>

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

						<button>Guardar</button>
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




		</main>

	</div>



	<footer>

	</footer>




	<!-- JS -->
	<script src="<?= constant('URL') ?>public/js/menu.js"></script>
	<!-- /JS -->

</body>
</html>