<?php
	// require_once('../../src/controller/cargarNota.php');
	// require_once('../../src/controller/alumnoStatus.php');
	require_once('views/Template/template.php');
?>

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
	<title>AULA - Cargar Notas</title>


	<!-- CUSTOM CSS -->
	<link rel="stylesheet" href="<?= constant('URL') ?>public/icon/icomoon/style.css">
	<link rel="stylesheet" href="<?= constant('URL') ?>public/css/cargarNota.css">
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



			<section class="plan_evaluacion">
				<div class="titulo">
					<div class="titulo_izq">
						<?php if ($this->plan[6] != 8 ): ?>
							<h4><?= $this->plan[2] ?></h4>
						<?php else: ?>
							<h4><?= ucfirst($this->plan[7]) ?></h4>
						<?php endif ?>

						<!-- <h4><?= $this->plan[2] ?></h4> -->
						<span><small><?= $this->plan[4] ?></small></span>
					</div>

				</div>
				<div class="contenido">
					<span><small>Valor: <?= $this->plan[3] ?>%</small></span>
					<br>
					<span><small>Punto: <?= $this->plan[3] * 0.20 ?>pts</small></span>
					<br>
					<br>
					<p> <?= $this->plan[5] ?> </p>

				</div>
			</section>







			<?php foreach ($this->alumnos as $alumno): ?>
			<section class="plan_evaluacion">
				<div class="titulo">
					<div class="titulo_izq">
						<h3><?= $alumno[1]." ".$alumno[2] ?></h3>
						<span><small><strong>C.I: </strong><?= $alumno[3] ?></small></span>
					</div>
					<div class="titulo_der">
						<div class="enlaces">
							<a href="#ModalCargarNota<?= $alumno[0] ?>"><span class="icon-pencil"></span></a>
						</div>

					</div>
				</div>
				<div class="contenido">
					<?php if (!$alumno[6]): ?>
					<h4>SIN CORREGIR</h4>
					<?php else: ?>
						<p><strong>NOTA: </strong><?= $alumno[6][4] ?></p>
						<p><strong>OBSERVACION: </strong><?= $alumno[6][5] ?></p>



						<!-- MOSTRAR CORRECIONES -->
						<div class="trabajos">

							<?php if ($alumno[6][6] or $alumno[6][7] or $alumno[6][8] or $alumno[6][9]): ?>
							<br>
							<br>
							<h4>Descargar Correcciones</h4>
							<br>
							<?php endif ?>

							<?php if ($alumno[6][6]): ?>
							<a href="<?= constant('URL')?>public/upload/correcciones/<?= $this->plan[1] ?>/<?= $this->plan[0] ?>/<?= $alumno[6][6] ?>" download>Material 1</a>
							<br>
							<br>
							<?php endif ?>

							<?php if ($alumno[6][7]): ?>
							<a href="<?= constant('URL')?>public/upload/correcciones/<?= $this->plan[1] ?>/<?= $this->plan[0] ?>/<?= $alumno[6][7] ?>" download>Material 2</a>
							<br>
							<br>
							<?php endif ?>

							<?php if ($alumno[6][8]): ?>
							<a href="<?= constant('URL')?>public/upload/correcciones/<?= $this->plan[1] ?>/<?= $this->plan[0] ?>/<?= $alumno[6][8] ?>" download>Material 3</a>
							<br>
							<br>
							<?php endif ?>

							<?php if ($alumno[6][9]): ?>
							<a href="<?= constant('URL')?>public/upload/correcciones/<?= $this->plan[1] ?>/<?= $this->plan[0] ?>/<?= $alumno[6][9] ?>" download>Material 4</a>
							<br>
							<br>
							<?php endif ?>

						</div>
						<!-- /MOSTRAR CORRECIONES -->
					<?php endif ?>





				<div id="ModalCargarNota<?= $alumno[0] ?>" class="editar">
					<form enctype="multipart/form-data" method="post" action="<?= constant('URL') ?>nota/addNota/<?= $this->plan[1] ?>/<?= $this->plan[0] ?>">
						<div class="grupo">
							<label for="nota">Nota</label>
							<select name="nota" id="nota">
								<?php
								$n = 0;
								while ( $n <= 20) {

									if ($alumno[6][4] == $n) {
										print '<option selected="selected" value="'.$n.'">'.$n.'</option>';
									}else{
										print '<option value="'.$n.'">'.$n.'</option>';
									}
									$n++;

								} ?>
							</select>
						</div>

						<div class="grupo">
							<label for="observacion">Observacion</label>
							<textarea name="observacion" id="observacion" cols="30" rows="10"><?= ( empty($alumno[6][5]) ) ? "" : $alumno[6][5] ?></textarea>
						</div>

						<div class="grupo">

							<div class="grupo">
								<br>
								<br>
								<h3>Archivos</h3>
							</div>
							<input type="file" name="file[]">
							<br>
							<br>
							<input type="file" name="file[]">
							<br>
							<br>
							<input type="file" name="file[]">
							<br>
							<br>
							<input type="file" name="file[]">
						</div>

						<div class="grupo_oculto">
							<input type="text" name="materia" value="<?= $this->plan[1] ?>" style="display: none;">
							<input type="text" name="plan" value="<?= $this->plan[0] ?>" style="display: none;">
							<input type="text" name="alumno" value="<?= $alumno[0] ?>" style="display: none;">
						</div>

						<div class="botones">
							<button class="item" type="submit" >Guardar</button>
							<a class="item close" href="#close" class="cerrar" >Cancelar</a>
						</div>
					</form>
				</div>
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