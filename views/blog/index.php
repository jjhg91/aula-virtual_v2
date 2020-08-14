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
	<title>IUTJMC - Blog</title>


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

		<?php Navbar($this->usuario, $this->navbarMaterias); ?>

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

			<div id="blogs">
			<?php foreach ($this->posts as $post): ?>
			<section class="blog" data-blog="<?= $post[0]?>">
				<div class="titulo">
					<div class="titulo_izq">
						<h4><?= ucfirst($post[4]) ?></h4>
						<span><small><small>Fecha: <?= $post[2] ?></small></small></span>
					</div>

					<?php if ($_SESSION['user'] == 'profesor'): ?>
					<div class="titulo_der">
						<div class="enlaces">
							<button title="Editar" class="btnModalEditar item icon-pencil btnInfo" type="button" data-blog="<?= $post[0] ?>"></button>
							<button title="Eliminar" class="btnEliminar icon-bin btnInfo" data-materia="<?= $post[1] ?>" data-blog="<?= $post[0] ?>" type="button" ></button>
						</div>
					</div>
					<?php endif ?>
				</div>
				<div class="contenido">
					<div class="descripcion__qe"><?= nl2br($post[3]); ?></div>
					



					<div class="trabajos">

						<?php if ($post[9] or $post[10] or $post[11] or $post[12]): ?>
						<br>
						<br>
						<h4>Links</h4>
						<br>
						<?php endif ?>

						<?php if ($post[9]): ?>
						<a href="<?= $post[13] ?>"><?= $post[9] ?></a>
						<br>
						<br>
						<?php endif ?>

						<?php if ($post[10]): ?>
						<a href="<?= $post[14] ?>"><?= $post[10] ?></a>
						<br>
						<br>
						<?php endif ?>

						<?php if ($post[11]): ?>
						<a href="<?= $post[15] ?>"><?= $post[11] ?></a>
						<br>
						<br>
						<?php endif ?>

						<?php if ($post[12]): ?>
						<a href="<?= $post[16] ?>"><?= $post[12] ?></a>
						<br>
						<br>
						<?php endif ?>

					</div>










					
					<div class="trabajos">

						<?php if ($post[5] or $post[6] or $post[7] or $post[8]): ?>
						<br>
						<br>
						<h4>Descarga de Materiales</h4>
						<br>
						<?php endif ?>

						<?php if ($post[5]): ?>
						<a class="link1" href="<?= constant('URL')?>public/upload/blog/<?= $post[1]?>/<?= $post[0] ?>/<?= $post[5] ?>" download>Material 1</a>
						<br>
						<br>
						<?php endif ?>

						<?php if ($post[6]): ?>
						<a class="link2" href="<?= constant('URL')?>public/upload/blog/<?= $post[1]?>/<?= $post[0] ?>/<?= $post[6] ?>" download>Material 2</a>
						<br>
						<br>
						<?php endif ?>

						<?php if ($post[7]): ?>
						<a class="link3" href="<?= constant('URL')?>public/upload/blog/<?= $post[1]?>/<?= $post[0] ?>/<?= $post[7] ?>" download>Material 3</a>
						<br>
						<br>
						<?php endif ?>

						<?php if ($post[8]): ?>
						<a class="link4" href="<?= constant('URL')?>public/upload/blog/<?= $post[1]?>/<?= $post[0] ?>/<?= $post[8] ?>" download>Material 4</a>
						<br>
						<br>
						<?php endif ?>

					</div>

				</div>
			</section>	
			<?php endforeach; ?>
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

							<button type="button" id="add_input_archivo">Otro Archivo</button>
						</div>
					<!-- /SECCION DE AGREGAR ARCHIVOS -->

						<div class="grupo">
							<div class="mensaje__error">
								<p>No se puedo guardar, por favor revise todo los campos y verifique que no tengan ningun error.</p>
							</div>
							<div class="mensaje__exito"></div>
						</div>

						<div class="grupo">
							<button id="btnSubmit" class="item" type="submit" >Guardar</button>
							<button id="btnModalPreview" class="item" type="button" >Previsualizar</button>
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
		<div id="editor__edit" style="height: 375px;"></div>
		<p id="editor_contador__edit">caracteres (<span id="editor_caracteres__edit">0</span>/50000)</p>
		<textarea name="descripcion" id="descripcion__edit" cols="30" rows="10" style="display: none;"></textarea>
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
		<button id="btnSubmit__edit" class="item" type="submit" >Guardar</button>
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
	<script src="<?= constant('URL') ?>public/js/config.js"></script>
	<script src="<?= constant('URL') ?>public/js/menu.js"></script>
	<script src="<?= constant('URL') ?>public/js/blog.js"></script>
	<!-- /JS -->

</body>
</html>