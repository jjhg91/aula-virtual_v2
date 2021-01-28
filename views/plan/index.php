<?php 
require_once('views/Template/template.php'); 
require_once('layout/planes.php');
?>


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
	<title>IUTJMC - Plan de Evaluacion</title>




	<!-- CUSTOM CSS -->
	<link rel="stylesheet" href="<?= constant('URL') ?>public/icon/icomoon/style.css">
	<link rel="stylesheet" href="<?= constant('URL') ?>public/css/planEvaluacion.css">
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

			<?php TarjetaInformativa('PLAN DE EVALUACIÓN', $this->barMateria); ?>

			<?php if (empty($this->planes)): ?>
			<section>
				<div class="contenido">
					<p>Aun no se ha cargado el plan de evaluación a esta materia. </p>

					<?php if ($_SESSION['user'] == 'profesor'): ?>
						<br>
						<p>Por favor cargue el plan de evaluación que se impartirá en esta asignatura, recuerde que sin el plan de evaluación no podrá crear una evaluación para ser entregada por este medio, como tampoco podrá cargar las notas</p>
						<br>

					<?php endif ?>

				</div>
			</section>
			<?php endif ?>

			<div id="planes" class="acordion">
			<?php 
			if ($this->planes !== false) {
			
				$planesEvaluacionesLayout = new PlanesEvaluaciones();
				$planesEvaluacionesLayout->showPlanesEvaluaciones($this->planes,$this->periodo->lapso,'1',$this->barMateria);
				$planesEvaluacionesLayout->showPlanesEvaluaciones($this->planes,$this->periodo->lapso,'2',$this->barMateria);
				$planesEvaluacionesLayout->showPlanesEvaluaciones($this->planes,$this->periodo->lapso,'3',$this->barMateria);

			};?>
			
			</div>

			<?php if ($_SESSION['user'] === 'profesor'): ?>
			<section class="section_agregar">
				<div class="titulo">
					<h3>Cargar Plan de Evaluación</h3>
				</div>
				<div class="contenido">
					<form id="add_plan" method="post" id="agregar_plan_evaluacion" >
						<div class="grupo">
							<label for="tipo">Tipo de evaluacion</label>
							<select name="tipo" id="tipo_evaluacion" class="tipo">

								<?php foreach ($this->tipoEvaluacion as $tipo): ?>
									<option value="<?= $tipo[0]; ?> ">
									<?= $tipo[1]; ?>
									</option>
                                <?php endforeach; ?>
							</select>
							<p class="formulario__input-error">* Este campo debe llenarse obligatoriamente</p>
						</div>
						<div class="grupo oculto" id="otros">
							<label for="otros">Otros tipo de evaluacion </label>
							<input class="otros" name="otros" type="text">
							<p class="formulario__input-error">* Este campo debe llenarse obligatoriamente</p>
						</div>
						<?php if ( $_SESSION['nivel'] === 'Preescolar' ): ?>
							<div class="grupo" style="display:none;">
								<label for="valor">Valor de evaluacion</label>
								<select name="valor" id="valor_evaluacion" class="valor">
									<?php foreach ($this->valores as $valor): ?>
									<option value="<?= $valor[0]; ?> ">
										<?= $valor[1]; ?> %
									</option>
									<?php endforeach; ?>
								</select>
								<p class="formulario__input-error">* Este campo debe llenarse obligatoriamente</p>
							</div>
						<?php elseif ($_SESSION['nivel'] === 'Primaria'):?>
							<div class="grupo" style="display:none;">
								<label for="valor">Valor de evaluacion</label>
								<select name="valor" id="valor_evaluacion" class="valor">
									<?php foreach ($this->valores as $valor): ?>
									<option value="<?= $valor[0]; ?> ">
										<?= $valor[1]; ?> %
									</option>
									<?php endforeach; ?>
								</select>
								<p class="formulario__input-error">* Este campo debe llenarse obligatoriamente</p>
							</div>
						<?php endif?>
					

						<div class="grupo">
							<label for="semana">Semana de la evaluacion</label>
							<select name="semana" id="semana_evaluacion" class="semana">

								<?php foreach ($this->semanas as $semana): ?>
                                <option value="<?= $semana[0]; ?> ">
									<?= $semana[1]; ?>
                                </option>
                                <?php endforeach; ?>
							</select>
							<p class="formulario__input-error">* Este campo debe llenarse obligatoriamente</p>
						</div>
						<div class="grupo">
							<div id="editor"></div>
							<p id="editor_contador">caracteres (<span id="editor_caracteres">0</span>/50000)</p>
							<textarea name="descripcion" id="descripcion_evaluacion" cols="20" rows="10" style="display:none;"></textarea>
						</div>
						<div class="grupo_oculto">
							<input type="text" name="mat" value="<?= $this->barMateria[2] ?>"style="display: none;">
						</div>

						<div class="grupo">
							<div class="mensaje__error"></div>
							<div class="mensaje__exito"></div>
						</div>

						<div class="grupo">
							<button id="btnSubmit" class="item btnTrue" type="submit" >Guardar</button>
							<button id="btnModalPreview" class="item btnInfo" type="button" >Previsualizar</button>
						</div>

					</form>
					<!-- /FORMULARIO AGREGAR PLAN DE EVALUACION -->

					<!-- SECCION DE PREVIEW MODAL -->

					<div class="modal" id="modalPreview">
							<div class="flex" id="flexPreview">
								<div class="modal__contenido">
									<div class="modal__header">
										<h3>Previsualización</h3>
										<a id="btnCerrarPreview">&times;</a>
									</div>
									<div class="modal__preview">
										<div id="preview__tipo"></div>
										<div id="preview__semana" ></div>
										<!-- <div id="preview__valor"></div> -->
										<div id="preview__puntos"></div>
										<div id="preview__descripcion2"></div>
										<div id="preview__descripcion"></div>
									</div>
								</div>
							</div>
						</div>

					<!-- /SECCION DE PREVIEW MODAL -->
					
						<!-- SECCION DE EDITAR MODAL -->

						<div class="modal" id="modalEditar">
							<div class="flex" id="flexEditar">
								<div class="modal__contenido">
									<div class="modal__header">
										<h3>EDITAR</h3>
										<a id="btnCerrarEditar">&times;</a>
									</div>
									<div class="modal__preview">
										<!-- FORMULARIO AGREGAR CONTENIDO -->
										<form id="edit__plan" method="post">
	<div class="grupo">
		<label for="tipo">Tipo de evaluacion</label>
		<select name="tipo" class="tipo">
			<?php foreach ($this->tipoEvaluacion as $tipo): ?>
			<option value="<?= $tipo[0]; ?> ">
				<?= $tipo[1]; ?>
			</option>
			<?php endforeach; ?>
		</select>
		<p class="formulario__input-error">
			* Este campo debe llenarse obligatoriamente
		</p>
	</div>
	<div class="grupo oculto grupo__otros">
		<label for="otros">Otros tipo de evaluacion </label>
		<input class="otros" name="otros" type="text" />
		<p class="formulario__input-error">
			* Este campo debe llenarse obligatoriamente
		</p>
	</div>


	<div class="grupo">
		<label for="semana">Semana de la evaluacion</label>
		<select name="semana" class="semana">
			<?php foreach ($this->semanas as $semana): ?>
			<option value="<?= $semana[0]; ?> ">
				<?= $semana[1]; ?>
			</option>
			<?php endforeach; ?>
		</select>
		<p class="formulario__input-error">
			* Este campo debe llenarse obligatoriamente
		</p>
	</div>
	<div class="grupo">
		<div id="edit__qe" class="=editor" style="height: 375px;"></div>
		<p id="editor_contador">
			caracteres (<span id="edit_caracteres">0</span>/50000)
		</p>
		<textarea
			name="descripcion"
			id="edit__descripcion"
			cols="20"
			rows="10"
			style="display: none;"
		></textarea>
	</div>
	<div class="grupo_oculto">
		<input
			type="text"
			name="materia"
			value="<?= $this->barMateria[2] ?>"
			style="display: none;"
		/>
		<input
			type="text"
			name="plan"
			value=""
			style="display: none;"
		/>
	</div>

	<div class="grupo">
		<div class="mensaje__error"></div>
		<div class="mensaje__exito"></div>
	</div>

	<div class="grupo">
		<button id="btnSubmit__edit" class="item btnTrue" type="submit">Guardar</button>
	</div>
</form>

										<!-- /FORMULARIO AGREGAR CONTENIDO -->

									</div>
								</div>
							</div>
						</div>

					<!-- /SECCION DE EDITAR MODAL -->

				</div>
			</section>
			<?php endif; ?>

		</main>

	</div>




	<footer>

	</footer>



	<!-- Main Quill library -->
	<script src="<?= constant('URL') ?>public/quill/quill.min.js"></script>

	<!-- JS -->
	<script src="<?= constant('URL') ?>public/js/config.js"></script>
	<script src="<?= constant('URL') ?>public/js/menu.js"></script>
	<script src="<?= constant('URL') ?>public/js/planEvaluacion.js"></script>
	
	<script>


		const acordion = document.querySelectorAll('.box-label');
		acordion.forEach(element => {
			element.addEventListener('click', event => {
				const boxLapso = event.target.parentElement;
				boxLapso.classList.toggle('active');
			})
		});

	</script>
	
	
	<!-- /JS -->


</body>
</html>