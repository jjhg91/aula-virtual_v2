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
	<link rel="stylesheet" href="<?= constant('URL') ?>public/css/periodo.css">
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
			<section>
				<div class="contenido">
					<h3>ASIGNATURAS<h3>
				</div>
			</section>

			<section class="tabla">
				<div class="contenido">
					<!-- <button>BUSCAR</button> -->
				</div>

				<div class="paginas">
					<ul>
						<?php for( $i=1; $i <= $this->totalPaginas; $i++ ): ?>
							
							<?php if ( $i === (int)$this->paginaActual ): ?>
								<li class="actual"> <a href="<?= constant('URL') ?>admin/asignatura/<?= $i ?>"><?= $i ?></a></li>
							<?php else: ?>
								<li> <a href="<?= constant('URL') ?>admin/asignatura/<?= $i ?>"><?= $i ?></a></li>
							<?php endif ?>
						<?php endfor ?>
					</ul>
				</div>

				<div class="contenido">
					<table class="table"  >
						<thead>
							<tr>
								<th>EDUCACION</th>
								<th>GRADO</th>
								<th>SECCION</th>
								<th>MATERIA</th>
								<th>PERIODO</th>
								<th>CEDULA PROFESOR</th>
								<th>NOMBRE PROFESOR</th>
								<th></th>
							</tr>
						</thead>
						<tbody id="periodos">
						<?php foreach ($this->asignaturas as $asignatura): ?>
						<tr class="periodo" data-asignatura="<?= $asignatura['id_profesorcursogrupo'] ?>">
							<td class="educacion"><?= $asignatura['educacion'] ?></td>
							<td class="grado"><?= $asignatura['especial'] ?></td>
							<td class="seccion"><?= $asignatura['seccion'] ?></td>
							<td class="materia"><?= $asignatura['pensum'] ?></td>
							<td class="periodo"><?= $asignatura['periodo'] ?></td>
							<td class="cedula"><?= $asignatura['cedu_pers'] ?></td>
							<td class="nombre"><?= $asignatura['nombres'] ?></td>
							<td class="td__btnEditar"><button type="submit" class="btnEditar" data-asignatura="<?= $asignatura['id_profesorcursogrupo'] ?>">ASIGNAR <br>PROFESOR</button></td>
						</tr>
						<?php endforeach ?>
						</tbody>
					</table>
				</div>

			</section>



		</main>

	</div>



	<footer>

	</footer>




	<!-- JS -->
	<script src="<?= constant('URL') ?>public/js/config.js?v=1.1"></script>
	<script src="<?= constant('URL') ?>public/js/menu.js?v=1.1"></script>
	<script src="<?= constant('URL') ?>public/js/asignatura.js?v=1.1"></script>
	<!-- /JS -->

</body>
</html>