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


	<link rel="Shortcut Icon" type="image/x-icon" href="public/media/logo.ico" />
	<title>IUTJMC - Inicio</title>
	

	<!-- CUSTOM CSS -->
	<link rel="stylesheet" href="public/icon/icomoon/style.css">
	<link rel="stylesheet" href="public/css/inicio.css">
	<!-- /CUSTOM CSS -->
	<script src="public/js/jquery/jquery-3.5.0.min.js"></script>
	<script src="public/js/jquery/jquery.cookie.js"></script>
	

</head>
<body>

	<?php Loader(); ?>
	<?php Headerr(); ?>

	
	<div class="contenido">
		
		<?php Navbar($this->usuario, $this->navbarMaterias); ?>

		<main class="main_completo">
			<section>
				<div class="contenido">

					<?php if ($this->usuario['user'] == 'alumno'): ?>
					<p>
						<strong>Bienvenido,</strong>
						<br>
						<br> 
						<br>
						El aula virtual consta de 5 módulos donde podrás interactuar en tus materias inscritas.
						<br>
						<br>
						<strong>1)	Contenido: </strong>Aquí podrás observar el contenido de la materia, obteniendo información de los temas que veras en la materia.
						<br>
						<br>
						<strong>2)	Plan de evaluación: </strong>Observaras el plan de evaluación asignado por el profesor, también puedes ver tu nota en las diferentes evaluaciones que hayan sido corregidas.
						<br>
						<br>
						<strong>3)	Evaluaciones: </strong>Se podrá observar las evaluaciones creadas por el profesor para ser entregadas por este medio con los siguientes formatos (Word, Excel, pdf, txt, PowerPoint, Publisher, imágenes y videos)
						<br>
						<br>
						<strong>4)	Blog: </strong>Se podrá observar información propiciada por el profesor referente a la materia, como material de apoyo para la materia.
						<br>
						<br>
						<strong>5)	Foro: </strong>Se podrá interactuar en un chat abierto con el profesor y todos los alumnos inscritos en esta materia.
					</p>
					<?php endif ?>

					<?php if ($_SESSION['user'] == 'profesor'): ?>
					<p>
						<strong>Bienvenido,</strong>
						 <br>
						 <br>
						 <br>
						El aula virtual consta de 5 módulos donde podrás interactuar en tus materias inscritas.
						<br>
						<br>
						<strong>1)	Contenido: </strong>Podrás Cargar contenido de la materia, para que los alumnos puedan obteniendo información de los temas que verán en la materia.
						<br>
						<br>
						<strong>2)	Plan de evaluación: </strong>Podrás cargar un plan de evaluación donde el máximo de evaluaciones será de 6, este será observado por los alumnos donde también ellos podrán ver si la evaluación fue corregida y cargada, observando sus notas. 
						<br>
						<br>
						<strong>3)	Evaluaciones: </strong>Podrá crear evaluaciones donde los alumnos podrán cargar y entregadas por este medio con los siguientes formatos (Word, Excel, pdf, txt, PowerPoint, Publisher, imágenes y videos), se deberá cargar el plan de evaluación primero para luego crear una evaluación.
						<br>
						<br>
						<strong>4)	Blog: </strong>Podrás proporcionar información y material de apoyo referente a la materia para que los alumnos puedan observar.
						<br>
						<br>
						<strong>5)	Foro: </strong>Se podrá interactuar en un chat abierto con el profesor y todos los alumnos inscritos en esta materia.
						<br>
						<br>   
						<strong>6)	Alumnos: </strong>Tendrás un listado de los alumnos inscrito en esa materia y de su última fecha de ingreso en el aula virtual.
						<br>
						<br>
						<strong>7)	Cargar Nota: </strong>Podrás cargar, ver y modificar la nota de los alumnos en las evaluaciones previamente cargadas en el plan de evaluación. 

					</p>
					<?php endif ?>
				</div>
			</section>
		</main>

	</div>
	
		
	

	<footer>
		
	</footer>
	



	<!-- JS -->
	<script src="public/js/menu.js"></script>
	<!-- /JS -->

</body>
</html>