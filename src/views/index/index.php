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
	<link rel="stylesheet" href="<?= constant('URL') ?>public/css/index.css">
	<!-- /CUSTOM CSS -->
	<script src="<?= constant('URL') ?>public/js/jquery/jquery-3.5.0.min.js"></script>

</head>
<body>
	<div class="opacidad">
		<main>
			<img src="<?= constant('URL') ?>public/media/LogoIUTJMC.png" alt="" height="300" >
			<section>
				<hgroup>
					<h1>
						Unidad Educativa Privada 
						<br />
						"José María Carreño"
					</h1>
					<hr>
					<h3>Aula Virtual</h3>
					
				</hgroup>
				<form name="formulario-login" method="post" 	action="<?= constant('URL')?>index/login">
					<div class="group">
						<label for="user">Usuario</label>
						<input name="user" type="text" placeholder="Usuario">
					</div>
					<div class="group">
						<label for="pass">Contraseña</label>
						<input name="pass" type="password" placeholder="Contraseña">
					</div>
					<div class="group group_radio">
						<div class="radio">
							<input type="radio" id="alumno" name="level" value="alumno" checked="true" >
							<label for="alumno" class="label_radio">Alumno</label>
						</div>
						<div class="radio">
							<input type="radio" id="profesor" name="level" value="profesor">
							<label for="profesor" class="label_radio">Profesor</label>
						</div>
						
					</div>
					<div class="group group_button">
						<button class="btnTrue">ENTRAR</button>
					</div>
				</form>			
			</section>
		</main>

		<footer>
			
		</footer>
	</div>



	<!-- JS -->

	<!-- /JS -->

</body>
</html>