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
	<title>IUTJMC - Foro</title>


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

			<?php TarjetaInformativa('FOROS', $this->barMateria); ?>

			<!-- FORO GENERAL -->
			<section class="plan_evaluacion">
				<div class="titulo">
					<div class="titulo_izq">
						<h4>GENERAL</h4>
					</div>


				</div>
				<div class="contenido">

					<p><strong>Descripcion: </strong> DISCUSIONES GENERALES DE LA MATERIA</p>
					<br>
					<a href="<?= constant('URL') ?>foro/detail/<?= $this->barMateria[2] ?>/0">INGRESAR AL FORO</a>


				</div>
			</section>
			<!-- /FORO GENERAL -->


			<?php foreach ($this->temas as $tema): ?>
			<section class="plan_evaluacion">
				<div class="titulo">
					<div class="titulo_izq">
						<h4><?= ucfirst($tema[2]) ?></h4>
					</div>

					<?php if ($_SESSION['user'] == 'profesor'): ?>
					<div class="titulo_der">
						<div class="enlaces">
							<!-- <a title="Editar" href="#ModalEditar"><span class="icon-pencil"></span></a> -->
							<a title="Eliminar" href="<?= constant('URL') ?>foro/deleteForo/<?= $tema[1] ?>/<?= $tema[0] ?>"><span class="icon-bin"></span></a>
						</div>
					</div>
					<?php endif ?>

				</div>
				<div class="contenido">

					<p><strong>Descripcion: </strong><?= $tema[3]?></p>
					<br>
					<a href="<?= constant('URL') ?>foro/detail/<?= $this->barMateria[2] . "/" . $tema[0] ?>">INGRESAR AL FORO </a>



				</div>
			</section>
			<?php endforeach; ?>

			<?php if ($_SESSION['user'] === 'profesor'): ?>
			<section class="section_agregar">
				<div class="titulo">
					<h3>Crear Foro</h3>
				</div>
				<div class="contenido">
					<form method="post" action="<?= constant('URL') ?>foro/addForo/<?= $this->barMateria[2] ?>">
						<div class="grupo">
							<label for="titulo">Titulo del foro</label>
							<input name="titulo" type="text" placeholder="Titulo del foro">
						</div>
						<div class="grupo">
							<label for="descripcion">Descripcion del foro</label>
							<textarea name="descripcion" id="descripcion_evaluacion" cols="20" rows="10" placeholder="Descripcion del foro"></textarea>
						</div>


						<div class="grupo_oculto">
							<input type="text" name="materia" style="display: none;" value="<?= $this->barMateria[2] ?>">
						</div>



						<div class="botones">
							<button id="btnSubmit" type="submit">Guardar</button>
						</div>


					</form>
				</div>
			</section>
			<?php endif; ?>

		</main>

	</div>


	<footer>

	</footer>



	<!-- JS -->
	<script src="<?= constant('URL') ?>public/js/menu.js"></script>

	<!-- /JS -->

</body>
</html>