<?php

	require_once('views/Template/template.php');
?>

<?php if ($_SESSION['user'] == 'profesor'): ?>
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


</head>
<body>

	<?php Loader(); ?>
	<?php Headerr(); ?>


	<div class="contenido">

		<?php Navbar($this->usuario, $this->navbarMaterias, $this->periodo); ?>

		<main class="main_completo">

			<?php TarjetaInformativa('ALUMNOS', $this->barMateria); ?>

			<?php foreach ($this->alumnos as $alumno): ?>
			<section class="plan_evaluacion">
				<div class="contenido">
					<h3><?= $alumno->apellidos." ".$alumno->nombres ?></h3>
					<span><small><strong>C.I: </strong><?= $alumno->cedula ?></small></span>
					<br>

					<a href="<?= constant('URL')."perfil/".$alumno->id_estudia ?>">Perfil</a>
					<a href="#">Mensajes</a>
					<a href="#">Historial de conexion</a>

					<!-- <?#php if ($alumno->fecha): ?> -->
					<!-- <span><small><strong>Fecha de ultimo inicio: </strong><?#= $alumno->fecha ?></small></span> -->
					<!-- <?#php else: ?> -->
					<!-- <span><small><strong>Fecha de ultimo inicio: </strong>No se ah conectado</small></span> -->
					<!-- <?#php endif; ?> -->
				</div>
			</section>
			<?php endforeach; ?>

		</main>

	</div>
	


	<footer>

	</footer>

	<!-- JS -->
	<script src="<?= constant('URL') ?>public/js/menu.js?v=1.1"></script>
	<!-- /JS -->

</body>
</html>
<?php endif ?>