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

			<?php TarjetaInformativa('FORO', $this->barMateria); ?>



			<?php if (empty($this->posts)): ?>
			<section>
				<div class="contenido">
					<p>El chat del foro de la materia esta vacío. </p>

				</div>
			</section>
			<?php endif ?>



			<?php
				include_once 'models/foroPost.php';
				foreach ($this->posts as $row):
					$post = new ForoPost();
					$post = $row;
			?>
			<section class="plan_evaluacion">
				<div class="titulo">
					<div class="titulo_izq">
						<h3><?= ucwords(strtolower($post->nombre)) ?></h3>
						<?php
							$fee = explode("-", $post->post[4]);
						?>
						<span><small>Fecha: <?= $fee[1]."-".$fee[0]."-".$fee[2] ?></small></span>
					</div>

					<?php if($_SESSION['user'] == 'profesor'): ?>
					<div class="titulo_der">
						<div class="enlaces">
							<a href="<?= constant('URL') ?>foro/deletePost/<?= $this->barMateria[2] ?>/<?= ($post->post[6] == 0) ? 0 : $post->post[6] ?>/<?= $post->post[0] ?>"><span class="icon-bin"></span></a>
						</div>
					</div>
					<?php endif ?>

				</div>
				<div class="contenido">
					<p> <?= nl2br($post->post[5]) ?> </p>
				</div>

                <!-- RESPUESTAS -->

				<?php if (!empty($post->respuestas)): ?>
                <div class="contenido">
                    <div>
                        <h4>Respuestas</h4>
                        <br>
                    </div>
					<?php  foreach ($post->respuestas as $respuesta):


                    ?>
						<div>
							<p><b> <?=  ucwords(strtolower($respuesta[6])) ?> <small>(<?= $respuesta[4] ?>)</small>:</b></p>
							<p>----- <?= $respuesta[5] ?></p>
							<br>
						</div>
                    <?php endforeach ?>

                </div>
                <?php endif ?>
                <!-- /RESPUESTAS -->

                <!-- RESPONDER -->
                <div class="contenido">
                    <a href="#ModalResponder<?= $post->post[0] ?>">Responder</a>
                    <div id="ModalResponder<?= $post->post[0] ?>" class="editar">
						<form id="respuesta<?= $post->post[0] ?>" method="post" action="<?= constant('URL') ?>foro/addRespuestaPost/<?= $this->barMateria[2] ?>/<?= $post->post[0]?>">
							<div class="grupo">
								<textarea name="message" id="message" cols="30" rows="10" placeholder="Responder mensaje"></textarea>
							</div>
							<div class="grupo_oculto">
								<input type="text" name="post" value="<?= $post->post[0] ?>" style="display: none;">
								<input type="text" name="materia" value="<?= $this->barMateria[2] ?>" style="display: none;">
								<input type="text" name="tema" value="<?= $post->post[6] ?>" style="display: none;">

							</div>
							<div class="botones">
								<button form="respuesta<?= $post->post[0] ?>" class="item" type="submit">Guardar</button>
								<a href="#cerrar" class="item close cerrar" >Cancelar</a>
							</div>

						</form>

                    </div>
                </div>
                <!-- /RESPONDER -->

			</section>
			<?php endforeach; ?>

			<section class="section_agregar">
				<div class="titulo">
					<h3>Cargar contenido al foro</h3>
				</div>
				<div class="contenido">
					<form name="agregar_foro" method="post" action="<?= constant('URL') ?>foro/addPost/<?= $this->barMateria[2] ?>/<?= $this->foro[0] ?>">
						<div class="grupo">
							<textarea name="message" id="message" cols="30" rows="10" placeholder="Contenido foro"></textarea>
						</div>
						<div class="grupo_oculto">
							<input type="text" name="materia" value="<?= $this->barMateria[2] ?>" style="display: none;">
							<input type="text" name="tema" value="<?= $this->foro[0] ?>" style="display: none;">

						</div>
						<button type="submit">Guardar</button>
					</form>
				</div>
			</section>
		</main>

	</div>



	<footer>

	</footer>

	<!-- JS -->
	<script src="<?= constant('URL') ?>public/js/menu.js"></script>
	<!-- /JS -->

</body>
</html>