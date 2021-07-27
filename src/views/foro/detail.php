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
	<link rel="stylesheet" href="<?= constant('URL') ?>public/css/evaluaciones.css">
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

			<?php TarjetaInformativa('FORO', $this->barMateria); ?>



			<?php if (empty($this->posts)): ?>
			<section>
				<div class="contenido">
					<p>El chat del foro de la materia esta vacío. </p>

				</div>
			</section>
			<?php endif ?>


			<div id="posts">
			<?php
				include_once 'models/foroPost.php';
				foreach ($this->posts as $row):
					$post = new ForoPost();
					$post = $row;
			?>
			<section class="post" data-post="<?= $post->post[0] ?>" data-foro="<?= ($post->post[6] == 0) ? 0 : $post->post[6] ?>">
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
							<!-- <a href="<?= constant('URL') ?>foro/deletePost/<?= $this->barMateria[2] ?>/<?= ($post->post[6] == 0) ? 0 : $post->post[6] ?>/<?= $post->post[0] ?>"><span class="icon-bin"></span></a> -->
							<button title="Eliminar" class="btnEliminar icon-bin btnInfo" data-materia="<?= $this->barMateria[2] ?>" data-foro="<?= ($post->post[6] == 0) ? 0 : $post->post[6] ?>" data-post="<?= $post->post[0] ?>" type="button" ></button>
						</div>
					</div>
					<?php endif ?>

				</div>
				<div class="contenido">
					<div class="message__qe"><?= nl2br($post->post[5]) ?></div>
				</div>

                <!-- RESPUESTAS -->

				<?php if (!empty($post->respuestas)): ?>
                <div class="contenido contenido__respuestas">
                    <div>
                        <h4>Respuestas</h4>
                        <br>
					</div>
					<div class="respuestas">
						<?php  foreach ($post->respuestas as $respuesta): ?>
							<div class="respuesta">
								<p class="nombreHora"><b> <?=  ucwords(strtolower($respuesta[6])) ?> <small>(<?= $respuesta[4] ?>)</small>:</b></p>
								<div class="mensaje__qe"><?= $respuesta[5] ?></div>
								<br>
							</div>
						<?php endforeach ?>
					</div>
                </div>
                <?php endif ?>
                <!-- /RESPUESTAS -->

                <!-- RESPONDER -->
                <div class="contenido">
					<!-- <a href="#ModalResponder<?= $post->post[0] ?>">Responder</a> -->
					<button title="Responder" class="btnResponder btnInfo" data-materia="<?= $this->barMateria[2] ?>" data-foro="<?= ($post->post[6] == 0) ? 0 : $post->post[6] ?>" data-post="<?= $post->post[0] ?>" type="button" >Responder</button>
					
					<div id="ModalResponder<?= $post->post[0] ?>" class="editar">
						<form id="respuesta<?= $post->post[0] ?>" method="post" action="<?= constant('URL') ?>foro/addRespuestaPost/<?= $this->barMateria[2] ?>/<?= $post->post[0]?>">
							<div class="grupo">
								<div class="responder__message-qe" style="height: 375px;"></div>
								<p class="responder__contador">caracteres (<span class="responder__caracteres">0</span>/50000)</p>
								<textarea name="message" class="message__responder" cols="30" rows="10" style="display: none;"></textarea>
								<p class="formulario__input-error">* Este campo debe llenarse obligatoriamente</p>
							</div>

							<div class="grupo_oculto">
								<input type="text" name="post" value="<?= $post->post[0] ?>" style="display: none;">
								<input type="text" name="materia" value="<?= $this->barMateria[2] ?>" style="display: none;">
								<input type="text" name="tema" value="<?= $post->post[6] ?>" style="display: none;">

							</div>

							<div class="grupo">
								<div class="mensaje__error">
									<p>No se puedo guardar, por favor revise todo los campos y verifique que no tengan ningun error.</p>
								</div>
								<div class="mensaje__exito">
								</div>
							</div>

							<div class="grupo">
								<button form="respuesta<?= $post->post[0] ?>" class="formResponder btnTrue" type="submit">Guardar</button>
								<button title="Cancelar" class="btnCancelar btnInfo" type="button" >Cancelar</button>

							</div>

						</form>

                    </div>
                </div>
                <!-- /RESPONDER -->

			</section>
			<?php endforeach; ?>
			</div>

			<section class="section_agregar">
				<div class="titulo">
					<h3>Cargar contenido al foro</h3>
				</div>
				<div class="contenido">
					<form id="add__post" name="add__post" method="post">
						
						<div class="grupo">
							<div id="add__message-qe" style="height: 375px;"></div>
							<p id="add__contador">caracteres (<span id="add__caracteres">0</span>/50000)</p>
							<textarea name="message" id="message__add" cols="30" rows="10" style="display: none;"></textarea>
							<p class="formulario__input-error">* Este campo debe llenarse obligatoriamente</p>
						</div>

						<div class="grupo_oculto">
							<input type="text" name="materia" value="<?= $this->barMateria[2] ?>" style="display: none;">
							<input type="text" name="foro" value="<?= $this->foro ?>" style="display: none;">

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
						</div>
					</form>
				</div>
			</section>
		</main>

	</div>



	<footer>

	</footer>


	<!-- Main Quill library -->
	<script src="<?= constant('URL') ?>public/quill/quill.min.js"></script>

	<!-- JS -->
	<script src="<?= constant('URL') ?>public/js/config.js?v=1.1"></script>
	<script src="<?= constant('URL') ?>public/js/menu.js?v=1.1"></script>
	<script src="<?= constant('URL') ?>public/js/foroDetail.js?v=1.1"></script>
	<!-- /JS -->

</body>
</html>