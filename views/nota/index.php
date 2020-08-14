<?php
    //require_once('../../src/controller/cargarNota.php');

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
	<title>IUTJMC - Cargar Notas</title>


	<!-- CUSTOM CSS -->
	<link rel="stylesheet" href="<?= constant('URL') ?>public/icon/icomoon/style.css">
	<link rel="stylesheet" href="<?= constant('URL') ?>public/css/planEvaluacion.css">
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

			<?php TarjetaInformativa('CARGAR NOTA', $this->barMateria); ?>





			<?php if ( empty($this->planes) ): ?>
			<section>
				<div class="contenido">
					<p>Aun no has cargado el plan de evaluaciones, para realizar la carga de las notas primero deberás cargar el plan de evaluación. </p>
				</div>
			</section>
			<?php endif ?>

			<?php foreach ($this->planes as $plan): ?>
			<section class="plan_evaluacion">
				<div class="titulo">
					<div class="titulo_izq">
						<?php if ($plan[6] != 8 ): ?>
							<h4><?= $plan[2] ?></h4>
						<?php else: ?>
							<h4><?= ucfirst($plan[7]) ?></h4>
						<?php endif ?>

						<span><small><?= $plan[4] ?></small></span>
					</div>
					<div class="titulo_der">
						<div class="enlaces">
						<a href="<?= constant('URL') ?>nota/cargar/<?= $plan[1] ?>/<?= $plan[0] ?>"><span class="icon-plus"></span></a>


					</div>
					</div>

				</div>
				<div class="contenido">
					<span><small>Valor: <?= $plan[3] ?>%</small></span>
					<br>
					<span><small>Punto: <?= $plan[3] * 0.20 ?>pts</small></span>
					<br>
					<br>
					<p> <?= $plan[5] ?> </p>


				</div>
			</section>
			<?php endforeach; ?>


		</main>

	</div>




	<footer>

	</footer>




	<!-- JS -->
	<script src="<?= constant('URL') ?>public/js/menu.js"></script>
	<!-- /JS -->

</body>
</html>

<?php endif ?>