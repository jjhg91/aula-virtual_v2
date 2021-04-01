<?php
require_once('views/Template/template.php');
require_once('layout/contenidos.php');
    //require_once('../../src/controller/contenido.php');
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
	<title>UEPJMC</title>


	<!-- CUSTOM CSS -->
	<link rel="stylesheet" href="<?= constant('URL') ?>public/icon/icomoon/style.css">
	<link rel="stylesheet" href="<?= constant('URL') ?>public/css/contenido.css">

	<!-- /CUSTOM CSS -->
	<script src="<?= constant('URL') ?>public/js/jquery/jquery-3.5.0.min.js"></script>
	<script src="<?= constant('URL') ?>public/js/jquery/jquery.cookie.js"></script>

	<!-- <script src="<?= constant('URL') ?>public/ckeditor5-build-classic/ckeditor.js"></script> -->
	

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

			<?php TarjetaInformativa('CONTENIDO', $this->barMateria); ?>

		<!-- MOSTAR SI CONTENIDO NO EXISTE -->

			<?php if (empty($this->contenidos)): ?>
			<section>
				<div class="contenido">
					<p>Aun no se ha cargado ningún contenido a esta materia. </p>

					<?php if ($_SESSION['user'] == 'profesor'): ?>
						<br>
						<p>Por favor cargue el contenido (temas y objetivos) que se impartirá en esta asignatura </p>
					<?php endif ?>

				</div>
			</section>
			<?php endif ?>

		<!-- /MOSTART SI CONTENIDO NO EXISTE -->


		<!-- MOSTAR CONTENIDO -->
		<div id="contenido" class="acordion">
			<?php 
				$contenidosLayout = new Contenidos();
				$contenidosLayout->showContenidos($this->contenidos,$this->periodo->lapso,'1');
				$contenidosLayout->showContenidos($this->contenidos,$this->periodo->lapso,'2');
				$contenidosLayout->showContenidos($this->contenidos,$this->periodo->lapso,'3');
			?>
		</div>
		<!-- /MOSTART CONTENIDO -->



		<!-- AGREGAR NUEVO CONTENIDO -->

			<?php if ($_SESSION['user'] === 'profesor'): ?>
			<section class="section_agregar">
				<div class="titulo">
					<h3>Crear Nuevo Contenido</h3>
				</div>
				
				<div class="contenido">

				<!-- FORMULARIO AGREGAR CONTENIDO -->
					<form id="add_contenido" name="agregar_contenido" method="post"  enctype="multipart/form-data" >
						<div class="grupo">
							<label for="numero">Numero de Objetivo</label>
							<input id="numero" name="numero" type="number" placeholder="Numero de Objetivo">
							<p class="formulario__input-error">* Este campo debe llenarse obligatoriamente, Los Numeros de objetivo se deben representar con numeros enteros del 1 al 9999 </p>
						</div>

						<div class="grupo">
							<label for="lapso_form">Lapso</label>
							<select name="lapso_form" id="lapso_form">
								<?php
								for ($i=1; $i <= 3 ; $i++) { 
									if($this->periodo->lapso === (string)$i){
										echo "<option value='$i' selected>$i</option>";
									}else {
										echo "<option value='$i'>$i</option>";
									}
								}
								?>
							</select>
							<p class="formulario__input-error">* Este campo debe llenarse obligatoriamente, Debe selecionar un lapso </p>
						</div>


						<div class="grupo">
							<label for="descripcion">Contenido</label>
							<div id="editor" style="height: 375px;"></div>
							<p id="editor_contador">caracteres (<span id="editor_caracteres">0</span>/50000)</p>
							<textarea name="descripcion" id="descripcion" cols="20" rows="10" placeholder="Contenido" style="display:none;"></textarea>
						</div>

						
						
						<div class="grupo_oculto">
							<input type="text" name="materia" value="<?= $this->barMateria[2] ?>" style="display: none;">
						</div>




					<!-- SECCION DE AGREGAR ARCHIVOS -->

						<div class="grupo">
							<div>
								<br>
								<br>
								<h3>Agregar Archivos</h3>
								<br>
							</div>

							<div id="grupo_archivos">
								<input type="file" name="file[]" class="file1" id="file1">
								<p class="formulario__input-error"></p>
							</div>

							<button class="btnInfo" type="button" id="add_input_archivo">Otro Archivo</button>
						</div>

					<!-- /SECCION DE AGREGAR ARCHIVOS -->
						<div class="grupo">
							<div class="mensaje__error">
								<p>No se puedo guardar, por favor revise todo los campos y verifique que no tengan ningun error.</p>
							</div>
							<div class="mensaje__exito">
							</div>
						</div>

						<div class="grupo">
							<button id="btnSubmit" class="item btnTrue" type="submit" >Guardar</button>
							<button id="btnModalPreview" class="item btnInfo" type="button" >Previsualizar</button>
						</div>
						
					</form>
					<!-- /FORMULARIO AGREGAR CONTENIDO -->

					<!-- SECCION DE PREVIEW MODAL -->

					<div class="modal" id="modalPreview">
							<div class="flex" id="flexPreview">
								<div class="modal__contenido">
									<div class="modal__header">
										<h3>Previsualización</h3>
										<a id="btnCerrarPreview">&times;</a>
									</div>
									<div class="modal__preview">
										<div id="preview__numero"></div>
										<div id="preview__descripcion" ></div>
										<div id="preview__archivos"></div>
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
										<form id="editar_contenido" name="agregar_contenido"   enctype="multipart/form-data" >
											<div class="grupo">
												<label for="numero">Numero de Objetivo</label>
												<input name="numero" type="number" placeholder="Numero de Objetivo">
												<p class="formulario__input-error">* Este campo debe llenarse obligatoriamente, Los Numeros de objetivo se deben representar con numeros enteros del 1 al 9999 </p>
											</div>

											<div class="grupo">
												<label for="lapso_form">Lapso</label>
												<select name="lapso_form" id="lapso_form">
													<?php
													for ($i=1; $i <= 3 ; $i++) { 
														if($this->periodo->lapso === (string)$i){
															echo "<option value='$i' selected>$i</option>";
														}else {
															echo "<option value='$i'>$i</option>";
														}
													}
													?>
												</select>
												<p class="formulario__input-error">* Este campo debe llenarse obligatoriamente, Debe selecionar un lapso </p>
											</div>

											<div class="grupo">
												<label for="descripcion">Contenido</label>
												<div id="editar__descripcion" style="height: 375px;"></div>
												<p id="editar_contador">caracteres (<span id="editar_caracteres">0</span>/50000)</p>
												<textarea id="descripcion__editar" name="descripcion" cols="20" rows="10" placeholder="Contenido" style="display:none;"></textarea>
											</div>

											
											
											<div class="grupo_oculto">
												<input type="text" name="materia" value="<?= $this->barMateria[2] ?>" style="display: none;">
												<input type="text" name="contenido" style="display: none;">

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



											<div class="grupo">
												<div class="mensaje__error"></div>
												<div class="mensaje__exito"></div>
											</div>

											<div class="grupo">
												<button id="btnSubmitEditar" class="item btnTrue" type="submit" >Guardar</button>
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
		<!-- AGREGAR NUEVO CONTENIDO -->

		</main>

	</div>


	<footer>

	</footer>



	<!-- Main Quill library -->
	<script src="<?= constant('URL') ?>public/quill/quill.min.js"></script>

	<!-- JS -->
	<script src="<?= constant('URL') ?>public/js/config.js"></script>
	<script src="<?= constant('URL') ?>public/js/menu.js"></script>
	<script type="module" src="<?= constant('URL') ?>public/js/contenido.js"></script>

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