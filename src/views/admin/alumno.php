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
					<h3>PERIODOS<h3>
				</div>
			</section>

			<section class="tabla">
				<div class="contenido">
					
				</div>

				<div class="paginas">
					<ul>
						<?php for( $i=1; $i <= $this->totalPaginas; $i++ ): ?>
							
							<?php if ( $i === (int)$this->paginaActual ): ?>
								<li class="actual"> <a href="<?= constant('URL') ?>admin/alumno/<?= $i ?>"><?= $i ?></a></li>
							<?php else: ?>
								<li> <a href="<?= constant('URL') ?>admin/alumno/<?= $i ?>"><?= $i ?></a></li>
							<?php endif ?>
						<?php endfor ?>
					</ul>
				</div>

				<div class="contenido">

				<form id="buscador__alumnos" name="buscador__alumno">
						<div class="grupo" style="display: inline-block; margin-bottom:20px;">
							<input id="busqueda" name="busqueda" type="text" placeholder="Buscar alumno por uno solo de estos campos (cedula,nombres,apellidos)">
						</div>
						<div class="grupo botones" style="display: inline-block;">
							<button id="btn__buscar" type="submit">BUSCAR</button>
						</div>
					</form>
					<div id="resultado__busqueda">
						<table class="table" style="border-collapse: collapse; display: block; margin-bottom:20px;">
							<tbody>
								
							</tbody>
						</table>
					</div>

					<table class="table" style="border-collapse: collapse; display: block;">
						<thead>
							<tr>
								<th>BLOQ</th>
								<th>CEDULA</th>
								<th>NOMBRE</th>
								<th>APELLIDO</th>
								<th>EMAIL</th>
								<th>TLF</th>
								<th>REPRESENTANTE</th>
								<th></th>
								<th></th>
							</tr>
						</thead>
						<div id="adds"></div>
						<tr class="add__periodo">
							<form id="add__periodo" name="add__periodo" enctype="multipart/form-data">
								<td></td>
								<td>
									<div class="inputs">
										<input id="add__cedula" name="add__cedula" type="text" placeholder="cedula(solo numeros)" >
										<p class="formulario__input-error">* Este campo debe llenarse obligatoriamente</p>
									</div>
								</td>
								<td>
									<div class="inputs">
										<input id="add__nombre" name="add__nombre" type="text" placeholder="Nombre">
										<p class="formulario__input-error">* Este campo debe llenarse obligatoriamente</p>
									</div>
								</td>
								<td>
									<div class="inputs">
										<input id="add__apellido" name="add__apellido" type="text" placeholder="Apellido">
										<p class="formulario__input-error">* Este campo debe llenarse obligatoriamente</p>
									</div>
								</td>
								<td>
									<div class="inputs">
										<input id="add__email" name="add__email" type="text" placeholder="Email">
										<p class="formulario__input-error">* Este campo debe llenarse obligatoriamente</p>
									</div>
								</td>
								<td>
									<div class="inputs">
										<input id="add__tlf" name="add__tlf" type="text" placeholder="04169300910">
										<p class="formulario__input-error">* Este campo debe llenarse obligatoriamente</p>
									</div>
								</td>
								<td>
									<div class="inputs">
										<input id="add__representante" name="add__representante" type="text" placeholder="Nombre y Apellido">
										<p class="formulario__input-error">* Este campo debe llenarse obligatoriamente</p>
									</div>
								</td>
								
								<td>
									<button type="submit" id="btn__add">GUARDAR</button>
								</td>
								<td>
									<button type="button" id="btn__clear">LIMPIAR</button>
								</td>
							</form>
						</tr>
						<tr class="errores">
							<td colspan=5>
								<div class="grupo__error">
									<div class="mensaje__error">
										<p>No se puedo guardar, por favor revise todo los campos y verifique que no tengan ningun error.</p>
									</div>
									<div class="mensaje__exito">
									</div>
								</div>
							</td>
						</tr>
						</div>
						
						<tbody id="periodos">
						<?php foreach ($this->alumnos as $alumno): ?>
						<tr class="periodo" data-alumno="<?= $alumno['id_estudia'] ?>">
							<td class="td__bloqueo">
								<input class="bloqueo" type="checkbox" <?= $alumno['bloqueo']==0 ? 'value="0"': 'value="1" checked' ?>/>
							</td>
							<td class="cedula"><?= $alumno['cedula'] ?></td>
							<td class="nombre"><?= $alumno['p_nombres'] ?></td>
							<td class="apellido"><?= $alumno['p_apellido'] ?></td>
							<td class="email"><?= $alumno['email'] ?></td>
							<td class="tlf"><?= $alumno['tlf1'] ?></td>
							<td class="representante"><?= $alumno['representante'] ?></td>
							<td class="td__btnEditar"><button type="submit" class="btnEditar" data-alumno="<?= $alumno['id_estudia'] ?>">EDITAR</button></td>
							<td class="td__btnEliminar"><button type="button" class="btnEliminar" data-alumno="<?= $alumno['id_estudia'] ?>">ELIMINAR</button></td>
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
	<script src="<?= constant('URL') ?>public/js/alumno.js?v=1.1"></script>
	<!-- /JS -->

</body>
</html>