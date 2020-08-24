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
	<link rel="stylesheet" href="<?= constant('URL') ?>public/css/foro.css">
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

			<?php TarjetaInformativa('FOROS', $this->barMateria); ?>

			
			<!-- FORO GENERAL -->
			<section class="foro">
				<div class="titulo">
					<div class="titulo_izq">
						<h4>GENERAL</h4>
					</div>


				</div>
				<div class="contenido">

					<p><strong>Descripcion: </strong></p>
					<div class="contenido__qe"> DISCUSIONES GENERALES DE LA MATERIA</div>
					<br>
					<a href="<?= constant('URL') ?>foro/detail/<?= $this->barMateria[2] ?>/0">INGRESAR AL FORO</a>


				</div>
			</section>
			<!-- /FORO GENERAL -->

			<div id="foros">
			<?php foreach ($this->temas as $tema): ?>
			<section class="foro" data-foro="<?= $tema[0]?>">
				<div class="titulo">
					<div class="titulo_izq">
						<h4 class="title"><?= ucfirst($tema[2]) ?></h4>
					</div>

					<?php if ($_SESSION['user'] == 'profesor'): ?>
					<div class="titulo_der">
						<div class="enlaces">
							<button title="Editar" class="btnModalEditar item icon-pencil btnInfo" type="button" data-foro="<?= $tema[0] ?>"></button>
							<button title="Eliminar" class="btnEliminar icon-bin btnInfo" data-materia="<?= $tema[1] ?>" data-foro="<?= $tema[0] ?>" type="button" ></button>
						</div>
					</div>
					<?php endif ?>

				</div>
				<div class="contenido">

					<p><strong>Descripcion: </strong></p>
					<div class="contenido__qe"><?= $tema[3]?></div>
					<br>
					<a href="<?= constant('URL') ?>foro/detail/<?= $this->barMateria[2] . "/" . $tema[0] ?>">INGRESAR AL FORO </a>



				</div>
			</section>
			<?php endforeach; ?>
			</div>

			<?php if ($_SESSION['user'] === 'profesor'): ?>
			<section class="section_agregar">
				<div class="titulo">
					<h3>Crear Foro</h3>
				</div>
				<div class="contenido">
					<form id="add__foro" method="post" >
						<div class="grupo">
							<label for="titulo">Titulo del foro</label>
							<input name="titulo" type="text" placeholder="Titulo del foro">
							<p class="formulario__input-error">* Este campo debe llenarse obligatoriamente</p>
						</div>
						<div class="grupo">
							<label for="descripcion">Descripcion del foro</label>
							<div id="add__descripcion__qe" style="height: 375px;"></div>
							<p id="add__contador">caracteres (<span id="add__caracteres">0</span>/50000)</p>
							<textarea name="descripcion" id="add__descripcion" cols="20" rows="10" placeholder="Descripcion del foro" style="display: none;"></textarea>
						</div>


						<div class="grupo_oculto">
							<input type="text" name="materia" style="display: none;" value="<?= $this->barMateria[2] ?>">
						</div>


						<div class="grupo">
							<div class="mensaje__error">
								<p>No se puedo guardar, por favor revise todo los campos y verifique que no tengan ningun error.</p>
							</div>
							<div class="mensaje__exito">
							</div>
						</div>

						<div class="grupo">
							<button class="btnTrue" id="btnSubmit" type="submit">Guardar</button>
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
										<div id="preview__titulo"></div>
										<div id="preview__descripcion2" >
											<p><b>Descripcion: </b></p>
										</div>
										<div id="preview__descripcion" ></div>
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
										<!-- FORMULARIO EDITAR FORO -->
<form id="edit__foro" method="post" >
	<div class="grupo">
		<label for="titulo">Titulo del foro</label>
		<input name="titulo" type="text" placeholder="Titulo del foro">
		<p class="formulario__input-error">* Este campo debe llenarse obligatoriamente</p>
	</div>
	<div class="grupo">
		<label for="descripcion">Descripcion del foro</label>
		<div id="edit__descripcion__qe" style="height: 375px;"></div>
		<p id="edit__contador">caracteres (<span id="edit__caracteres">0</span>/50000)</p>
		<textarea name="descripcion" id="edit__descripcion" cols="20" rows="10" placeholder="Descripcion del foro" style="display: none;"></textarea>
	</div>


	<div class="grupo_oculto">
		<input type="text" name="materia" style="display: none;" value="<?= $this->barMateria[2] ?>">
		<input type="text" name="foro" style="display: none;" value="">
	</div>


	<div class="grupo">
		<div class="mensaje__error">
			<p>No se puedo guardar, por favor revise todo los campos y verifique que no tengan ningun error.</p>
		</div>
		<div class="mensaje__exito">
		</div>
	</div>

	<div class="grupo">
		<button class="btnTrue" id="btnSubmit__edit" type="submit">Guardar</button>
	</div>

</form>
										<!-- /FORMULARIO EDITAR FORO -->

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
	<script src="<?= constant('URL') ?>public/js/foro.js"></script>
	<!-- /JS -->

</body>
</html>