<?php
	require_once('views/Template/template.php');
	require_once('layout/planes.php');
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
	<link rel="stylesheet" href="<?= constant('URL') ?>public/css/planEvaluacion.css">
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

			<?php TarjetaInformativa('CARGAR NOTA', $this->barMateria); ?>


			<?php if ( empty($this->planes) ): ?>
			<section>
				<div class="contenido">
					<p>Aun no has cargado el plan de evaluaciones, para realizar la carga de las notas primero deberás cargar el plan de evaluación. </p>
				</div>
			</section>
			<?php endif ?>

			<div class="acordion">
				<?php 
					$planesLapso = new Planes();
					$planesLapso->showPlanes($this->planes, $this->periodo->lapso,'1');
					$planesLapso->showPlanes($this->planes, $this->periodo->lapso,'2');
					$planesLapso->showPlanes($this->planes, $this->periodo->lapso,'3');
				?>
			</div>


		</main>

	</div>




	<footer>

	</footer>




	<!-- JS -->
	<script src="<?= constant('URL') ?>public/js/menu.js?v=1.1"></script>
	
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

<?php endif ?>