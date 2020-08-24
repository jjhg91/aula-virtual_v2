<?php
require_once('views/Template/template.php');
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

		<?php Navbar($this->usuario, $this->navbarMaterias); ?>

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
		<div id="contenido">
			<?php foreach ($this->contenidos as $contenido): ?>
			<section class="contenido" data-contenido="<?= $contenido[0] ?>">
				<div class="titulo">
					<div class="titulo_izq">
						<h4>Objetivo <span class="objetivo__numero"><?= $contenido[2] ?></span></h4>

					</div>

					<?php if($_SESSION['user'] == 'profesor'): ?>
					<div class="titulo_der ">
						<div class="enlaces">
							<button title="Editar" class="btnModalEditar item icon-pencil btnInfo" type="button" data-contenido="<?= $contenido[0] ?>"></button>
							<button title="Eliminar" class="btnEliminar icon-bin btnInfo" data-materia="<?= $contenido[1] ?>" data-contenido="<?= $contenido[0] ?>" data-objetivo="<?= $contenido[2] ?>" type="button" ></button>
						</div>
					</div>
					<?php endif; ?>

				</div>
				<div class="contenido ">
					<div class="contenido__descripcion">
					<?= $contenido[3] ?>
					</div>
					<!-- <p> <?= nl2br(ucfirst($contenido[3])) ?> </p> -->

				<!-- MOSTAR LINKS -->
					<div class="trabajos">
						<?php if ($contenido[8] or $contenido[9] or $contenido[10] or $contenido[11]): ?>
						<br>
						<br>
						<h4>Links</h4>
						<br>
						<?php endif ?>

						<?php if ($contenido[8]): ?>
						<a href="<?= $contenido[12] ?>"><?= $contenido[8] ?></a>
						<br>
						<br>
						<?php endif ?>

						<?php if ($contenido[9]): ?>
						<a href="<?= $contenido[13] ?>"><?= $contenido[9] ?></a>
						<br>
						<br>
						<?php endif ?>

						<?php if ($contenido[10]): ?>
						<a href="<?= $contenido[14] ?>"><?= $contenido[10] ?></a>
						<br>
						<br>
						<?php endif ?>

						<?php if ($contenido[11]): ?>
						<a href="<?= $contenido[15] ?>"><?= $contenido[11] ?></a>
						<br>
						<br>
						<?php endif ?>
					</div>
				<!-- /MOSTAR LINKS -->

				<!-- MOSTRAR ARCHIVOS  -->
					<div class="trabajos mostrar_archivos">
						<?php if ($contenido[4] or $contenido[5] or $contenido[6] or $contenido[7]): ?>
						<br>
						<br>
						<h4>Descarga de Materiales</h4>
						<br>
						<?php endif ?>

						<?php if ($contenido[4]): ?>
						<a class="link1" href="<?= constant('URL') ?>public/upload/contenido/<?= $contenido[1]?>/<?= $contenido[0] ?>/<?= $contenido[4] ?>" download>Material 1</a>
						<br>
						<br>
						<?php endif ?>

						<?php if ($contenido[5]): ?>
						<a class="link2" href="<?= constant('URL') ?>public/upload/contenido/<?= $contenido[1]?>/<?= $contenido[0] ?>/<?= $contenido[5] ?>" download>Material 2</a>
						<br>
						<br>
						<?php endif ?>

						<?php if ($contenido[6]): ?>
						<a class="link3" href="<?= constant('URL') ?>public/upload/contenido/<?= $contenido[1]?>/<?= $contenido[0] ?>/<?= $contenido[6] ?>" download>Material 3</a>
						<br>
						<br>
						<?php endif ?>

						<?php if ($contenido[7]): ?>
						<a class="link4" href="<?= constant('URL') ?>public/upload/contenido/<?= $contenido[1]?>/<?= $contenido[0] ?>/<?= $contenido[7] ?>" download>Material 4</a>
						<br>
						<br>
						<?php endif ?>
					</div>
				<!-- /MOSTART ARCHIVOS  -->




			<!-- MODAL EDITAR CONTENIDO -->

				<?php if ($_SESSION['user'] === 'profesor'): ?>
					



				<?php endif ?>
			<!-- /MODAL EDITAR CONTENIDO-->



				</div>

			</section>
			<?php endforeach ?>
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
							<label for="message">Contenido</label>
							<div id="editor" style="height: 375px;"></div>
							<p id="editor_contador">caracteres (<span id="editor_caracteres">0</span>/50000)</p>
							<textarea name="message" id="message" cols="20" rows="10" placeholder="Contenido" style="display:none;"></textarea>
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
												<label for="message">Contenido</label>
												<div id="editar__descripcion" style="height: 375px;"></div>
												<p id="editar_contador">caracteres (<span id="editar_caracteres">0</span>/50000)</p>
												<textarea id="message__editar" name="message" cols="20" rows="10" placeholder="Contenido" style="display:none;"></textarea>
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
	<script src="<?= constant('URL') ?>public/js/contenido.js"></script>


	<!-- /JS -->

</body>
</html>