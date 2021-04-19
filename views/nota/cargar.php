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
	<link rel="stylesheet" href="<?= constant('URL') ?>public/css/cargarNota.css">
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

			<?php TarjetaInformativa('CARGAR NOTA', $this->barMateria); ?>



			<section class="plan_evaluacion">
				<div class="titulo">
					<div class="titulo_izq">
						<?php if ( $this->plan[6] != 8 ): ?>
							<h4><?= $this->plan[2] ?></h4>
						<?php else: ?>
							<h4><?= ucfirst($this->plan[7]) ?></h4>
						<?php endif ?>

						<!-- <h4><?= $this->plan[2] ?></h4> -->
						<span><small><?= $this->plan[4] ?></small></span>
					</div>

				</div>
				<div class="contenido">
					<span><small>Valor: <?= $this->plan[3] ?>%</small></span>
					<br>
					<span><small>Punto: <?= $this->plan[3] * 0.20 ?>pts</small></span>
					<br>
					<br>
					<p> <?= $this->plan[5] ?> </p>

				</div>
			</section>






			<div id="notas">
			<?php foreach ($this->alumnos as $alumno): ?>
			<section class="nota" data-alumno="<?= $alumno[0] ?>">
				<div class="titulo">
					<div class="titulo_izq">
						<h3 class="nombre"><?= $alumno[1]." ".$alumno[2] ?></h3>
						<span class="cedula"><small><strong>C.I: </strong><?= $alumno[3] ?></small></span>
					</div>
					<div class="titulo_der">
						<div class="enlaces">
							<button title="Editar" class="btnModalEditar item icon-pencil btnInfo" type="button" data-alumno="<?= $alumno[0] ?>"></button>
						</div>

					</div>
				</div>
				<div class="contenido">
					<?php if (!$alumno[6]): ?>
					<h4>SIN CORREGIR</h4>
					<?php else: ?>
						<p><strong>NOTA: </strong><span class="valor__nota"><?= $alumno[6][4] ?></span></p>
						<p><strong>OBSERVACION: </strong></p>
						<div class="observacion__qe"><?= $alumno[6][5] ?></div>



						<!-- MOSTRAR CORRECIONES -->
						<div class="trabajos">
							<?php if ($alumno[6][6] or $alumno[6][7] or $alumno[6][8] or $alumno[6][9]): ?>
							<br>
							<br>
							<h4>Descargar Correcciones</h4>
							<br>
							<?php endif ?>

							<?php if ($alumno[6][6]): ?>
							<a class="link1" href="<?= constant('URL')?>public/upload/correcciones/<?= $this->plan[1] ?>/<?= $this->plan[0] ?>/<?= $alumno[6][6] ?>" download>Material 1</a>
							<br>
							<br>
							<?php endif ?>

							<?php if ($alumno[6][7]): ?>
							<a class="link2" href="<?= constant('URL')?>public/upload/correcciones/<?= $this->plan[1] ?>/<?= $this->plan[0] ?>/<?= $alumno[6][7] ?>" download>Material 2</a>
							<br>
							<br>
							<?php endif ?>

							<?php if ($alumno[6][8]): ?>
							<a class="link3" href="<?= constant('URL')?>public/upload/correcciones/<?= $this->plan[1] ?>/<?= $this->plan[0] ?>/<?= $alumno[6][8] ?>" download>Material 3</a>
							<br>
							<br>
							<?php endif ?>

							<?php if ($alumno[6][9]): ?>
							<a class="link4" href="<?= constant('URL')?>public/upload/correcciones/<?= $this->plan[1] ?>/<?= $this->plan[0] ?>/<?= $alumno[6][9] ?>" download>Material 4</a>
							<br>
							<br>
							<?php endif ?>

						</div>
						<!-- /MOSTRAR CORRECIONES -->
					<?php endif ?>

				</div>
			</section>
			<?php endforeach; ?>
			</div>


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
		<label for="nota">Nota</label>
		<select name="nota" id="nota">
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
		<input type="text" name="materia" value="<?= $this->plan[1] ?>" style="display: none;">
		<input type="text" name="plan" value="<?= $this->plan[0] ?>" style="display: none;">
		<input type="text" name="alumno" value="" style="display: none;">
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

		</main>

	</div>




	<footer>

	</footer>




	<!-- Main Quill library -->
	<script src="<?= constant('URL') ?>public/quill/quill.min.js"></script>

	<!-- JS -->
	<script src="<?= constant('URL') ?>public/js/config.js?v=1.1"></script>
	<script src="<?= constant('URL') ?>public/js/menu.js?v=1.1"></script>
	<script src="<?= constant('URL') ?>public/js/notaCarga.js?v=1.1"></script>
	<!-- /JS -->

</body>
</html>