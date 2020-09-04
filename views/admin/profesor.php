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
		
		<?php Navbar($this->usuario, $this->navbarMaterias); ?>

		<main class="main_completo">
			<section>
				<div class="contenido">
					<h3>PROFESORES<h3>
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
								<li class="actual"> <a href="<?= constant('URL') ?>admin/profesor/<?= $i ?>"><?= $i ?></a></li>
							<?php else: ?>
								<li> <a href="<?= constant('URL') ?>admin/profesor/<?= $i ?>"><?= $i ?></a></li>
							<?php endif ?>
						<?php endfor ?>
					</ul>
				</div>

				<div class="contenido">
					<table class="table" style="border-collapse: collapse; display: block;">
						<thead>
							<tr>
								<th>CEDULA</th>
								<th>NOMBRE Y APELLIDO</th>
								<th>EMAIL</th>
								<th>TLF</th>
								<th></th>
								<th></th>
							</tr>
						</thead>
						<div id="adds"></div>
						<tr class="add__periodo">
							<form id="add__periodo" name="add__periodo" enctype="multipart/form-data">
								<td>
									<div class="inputs">
										<input id="add__cedula" name="add__cedula" type="text" placeholder="solo numeros">
										<p class="formulario__input-error">* Este campo debe llenarse obligatoriamente</p>
									</div>
								</td>
								<td>
									<div class="inputs">
										<input id="add__nombre" name="add__nombre" type="text" placeholder="Nombre y Apellido">
										<p class="formulario__input-error">* Este campo debe llenarse obligatoriamente</p>
									</div>
								</td>
								<td>
									<div class="inputs">
										<input id="add__email" name="add__email" type="text" placeholder="ejemplo@email.com">
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
						<?php foreach ($this->profesores as $profesor): ?>
						<tr class="periodo" data-profesor="<?= $profesor['id_personal'] ?>">
							<td class="cedula"><?= $profesor['cedu_pers'] ?></td>
							<td class="nombre"><?= $profesor['nombres'] ?></td>
							<td class="email"><?= $profesor['email'] ?></td>
							<td class="tlf"><?= $profesor['tlf'] ?></td>
							<td class="td__btnEditar"><button type="submit" class="btnEditar" data-profesor="<?= $profesor['id_personal'] ?>">EDITAR</button></td>
							<td class="td__btnEliminar"><button type="button" class="btnEliminar" data-profesor="<?= $profesor['id_personal'] ?>">ELIMINAR</button></td>
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
	<script src="<?= constant('URL') ?>public/js/config.js"></script>
	<script src="<?= constant('URL') ?>public/js/menu.js"></script>
	<script src="<?= constant('URL') ?>public/js/profesor.js"></script>
	<!-- /JS -->

</body>
</html>