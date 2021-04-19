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

		<section class="trabajos cargados">
				<div class="contenido">
					<h3>Evaluaciones Entregadas </h3>
					</div>
				</div>
		</section>

		<?php endif ?>
		<!-- /PROFESOR -->
		<div id="trabajos__cargados">
		
		</div>
		<div class="div__agregar_evaluacion"></div>





		




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
			<option >Sin cargar notas</option>
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
	<script src="<?= constant('URL') ?>public/js/config.js?v=1.1"></script>
	<script src="<?= constant('URL') ?>public/js/menu.js?v=1.1"></script>
	<script type="module" src="<?= constant('URL')?>public/js/evaluaciones__detail.js?v=1.1"></script>
	<!-- /JS -->

</body>
</html>