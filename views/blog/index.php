<?php 
require_once('views/Template/template.php'); 
require_once('layout/posts.php'); 
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
	<link rel="stylesheet" href="<?= constant('URL') ?>public/css/blog.css">
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

			<?php TarjetaInformativa('BLOG', $this->barMateria); ?>


			<?php if (empty($this->posts)): ?>
			<section>
				<div class="contenido">
					<p>Aun no se a cargado ninguna informacacion ni material de apoyo en el blog. </p>

					<?php if ($_SESSION['user'] == 'profesor'): ?>
						<br>
						<p>Por favor alguna información o material de apoyo para la materia</p>
						<br>
						<p>* Deberá asignarle un título. </p>



					<?php endif ?>

				</div>
			</section>
			<?php endif ?>

			<div id="blogs" class="acordion">
			<?php 
				$postsLapso = new PostsLapso();
				$postsLapso->showPosts($this->posts, $this->periodo->lapso, '1');
				$postsLapso->showPosts($this->posts, $this->periodo->lapso, '2');
				$postsLapso->showPosts($this->posts, $this->periodo->lapso, '3');
				
			?>
			</div>

		<!-- SECCION AGREGAR CONTENIDO AL BLOG -->

			<?php if ($_SESSION['user'] === 'profesor'): ?>
			<section class="section_agregar">
				<div class="titulo">
					<h3>Cargar contenido al blog</h3>
				</div>
				<div class="contenido">
					<form id="add__blog" name="agregar_blog" method="post" enctype="multipart/form-data" >
						<div class="grupo">
							<label for="title">Titulo</label>
							<input name="title" id="title" type="text" placeholder="Titulo">
							<p class="formulario__input-error">* Este campo debe llenarse obligatoriamente</p>
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
							<div id="editor" style="height: 375px;"></div>
							<p id="editor_contador">caracteres (<span id="editor_caracteres">0</span>/50000)</p>
							<textarea name="descripcion" id="descripcion" cols="30" rows="10" style="display: none;"></textarea>
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
							<div class="mensaje__exito"></div>
						</div>

						<div class="grupo">
							<button id="btnSubmit" class="item btnTrue" type="submit" >Guardar</button>
							<button id="btnModalPreview" class="item btnInfo" type="button" >Previsualizar</button>
						</div>
						
					</form>


					<!-- SECCION DE PREVIEW MODAL -->
					<div class="modal" id="modalPreview">
							<div class="flex" id="flexPreview">
								<div class="modal__contenido">
									<div class="modal__header">
										<h3>Previsualización</h3>
										<a id="btnCerrarPreview">&times;</a>
									</div>
									<div class="modal__preview">
										<div id="preview__title"></div>
										<div id="preview__descripcion"></div>
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
										<!-- FORMULARIO EDITAR BLOG -->
										<form id="edit__blog" name="agregar_blog" method="post" enctype="multipart/form-data" >
											<div class="grupo">
												<label for="title">Titulo</label>
												<input name="title" id="title__edit" type="text" placeholder="Titulo">
												<p class="formulario__input-error">* Este campo debe llenarse obligatoriamente</p>
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
												<div id="editar__descripcion" style="height: 375px;"></div>
												<p id="editor_contador__edit">caracteres (<span id="editor_caracteres__edit">0</span>/50000)</p>
												<textarea name="descripcion" id="descripcion__editar" cols="30" rows="10" style="display: none;"></textarea>
											</div>

											<div class="grupo_oculto">
												<input type="text" name="materia" value="<?= $this->barMateria[2] ?>" style="display: none;">
												<input type="text" name="blog" value="" style="display: none;">
											</div>


											<!-- SECCION DE AGREGAR ARCHIVOS -->
											<div class="grupo">
												<div>
													<br>
													<br>
													<h3>Agregar Archivos</h3>
													<br>
												</div>
												<div id="grupo_archivos__edit">
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
												<div class="mensaje__error">
													<p>No se puedo guardar, por favor revise todo los campos y verifique que no tengan ningun error.</p>
												</div>
												<div class="mensaje__exito"></div>
											</div>

											<div class="grupo">
												<button id="btnSubmitEditar" class="item btnTrue" type="submit" >Guardar</button>
											</div>

										</form>
										<!-- /FORMULARIO EDITAR BLOG -->

									</div>
								</div>
							</div>
						</div>
					<!-- /SECCION DE EDITAR MODAL -->
				</div>
			</section>
			<?php endif; ?>

		<!-- /SECCION AGREGAR CONTENIDO AL BLOG -->

		</main>

	</div>
	


	<footer>

	</footer>

	<!-- Main Quill library -->
	<script src="<?= constant('URL') ?>public/quill/quill.min.js"></script>

	<!-- JS -->
	<script src="<?= constant('URL') ?>public/js/config.js?v=1.1"></script>
	<script src="<?= constant('URL') ?>public/js/menu.js?v=1.1"></script>
	<script type="module" src="<?= constant('URL') ?>public/js/blog.js?v=1.1"></script>

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