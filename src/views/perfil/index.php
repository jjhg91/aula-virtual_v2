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
	<link rel="stylesheet" href="public/css/inicio.css">
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


			<section>
				<div class="titulo"	>
					<div class="titulo_izq">
                    	<h4>Perfil</h4>
                	</div>
				</div>
				<div class="contenido">
					<div>
						<img src="<?php constant('URL')?>public/media/h.jpg" alt="400">
						<a href="#">change image</a>
					</div>
					<div>
						<h3>Nombre</h3>
						<p>Pablito Perez</p>
					</div>
					<br>
					<div>
						<h3>Celular: </h3>
						<p>0412-9300911 <a href="#">change phone</a></p>
					</div>
					<br>
					<div>
						<h3>Correo: </h3>
						<p>ejemplo@gmail.com <a href="#">change email</a></p>
						
					</div>
					<br>
					<div>
						<h3>Periodo Academico en curso: </h3>
						<p>2020-2021</p>
					</div>
					<br>
					<div>
						<h3>Grado: </h3>
						<p>6to</p>
					</div>
					<br>
					<div>
						<h3>Seccion: </h3
						><p>A</p>
					</div>
					<br>
					<div>
						<h3>Contraseña: </h3>
						<p>sin contraseño / ********** / <a href="#">change password</a></p>		
					</div>
				</div>
			</section>
		</main>

	</div>
	
		
	

	<footer>
		
	</footer>
	


	<!-- Main Quill library -->
	<script src="<?= constant('URL') ?>public/quill/quill.min.js"></script>

	<!-- JS -->
	<script src="<?= constant('URL') ?>public/js/menu.js?v=1.1"></script>
	<script src="<?= constant('URL') ?>public/js/perfil.js?v=1.1"></script>
	<!-- /JS -->

	<script>
		var contenidoDescripcion = document.querySelectorAll('.contenido__qe');
		contenidoDescripcion.forEach( contenidos => {
			var quill3 = new Quill(contenidos,{
				readOnly: true,
				theme: 'bubble'
			});
		});
	</script>

</body>
</html>