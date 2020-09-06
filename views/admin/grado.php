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
					<h3>GRADOS<h3>
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
								<li class="actual"> <a href="<?= constant('URL') ?>admin/grado/<?= $i ?>"><?= $i ?></a></li>
							<?php else: ?>
								<li> <a href="<?= constant('URL') ?>admin/grado/<?= $i ?>"><?= $i ?></a></li>
							<?php endif ?>
						<?php endfor ?>
					</ul>
				</div>

				<div class="contenido">
					<table class="table" style="border-collapse: collapse; display: block;">
						<thead>
							<tr>
								<th>EDUCACION</th>
								<th>GRADO</th>
								<th>SECCION</th>
								<th>PERIODO</th>
								<th></th>
								<th></th>
							</tr>
						</thead>
						<div id="adds"></div>
						<tr class="add__periodo">
							<form id="add__periodo" name="add__periodo" enctype="multipart/form-data">
								<td>
									<div class="inputs">
										<select id="add__educacion">
										<option value="0" selected="true" disabled="true">INVALDIO</option>
										</select>
										<p class="formulario__input-error">* Este campo debe llenarse obligatoriamente</p>
									</div>
								</td>
								<td>
									<div class="inputs">
										<select id="add__grado" name="add_grado">
											<option value="0" selected="true" disabled="true">Seleccionar Una</option>
											<?php foreach ($this->gradoEducacion as $educacion): ?>
												<option value="<?= $educacion['id_especialidad']?>" ><?= $educacion['descripcion'] .' - '. $educacion['especial']?></option>
											<?php endforeach ?>
										</select>
										<p class="formulario__input-error">* Este campo debe llenarse obligatoriamente</p>
									</div>
								</td>
								<td>
									<div class="inputs">
										<select id="add__seccion">
											<option value="0" selected="true" disabled="true">Seleccionar Una</option>
											<?php foreach ($this->secciones as $seccion): ?>
												<option value="<?= $seccion['id_seccion']?>" ><?= $seccion['seccion'] ?></option>
											<?php endforeach ?>
										</select>
										<p class="formulario__input-error">* Este campo debe llenarse obligatoriamente</p>
									</div>
								</td>
								<td>
									<div class="inputs">
										<select id="add__periodo">
											<option value="0" selected="true" disabled="true">Seleccionar Una</option>
											<?php foreach ($this->periodos as $periodo): ?>
												<option value="<?= $periodo['id_periodo']?>" ><?= $periodo['periodo'] .' - '. $periodo['status']?> </option>
											<?php endforeach ?>
										</select>
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
						<?php foreach ($this->grados as $grado): ?>
						<tr class="periodo" data-grado="<?= $grado['id_profesorcursogrupo'] ?>">
							<td class="educacion"><?= $grado['descripcion'] ?></td>
							<td class="grado"><?= $grado['especial'] ?></td>
							<td class="seccion"><?= $grado['seccion'] ?></td>
							<td class="periodo"><?= $grado['periodo'] ?></td>
							<td class="td__btnInscritos"><button type="button" class="btnAlumnosInscritos" data-grado="<?= $grado['id_profesorcursogrupo'] ?>">Alumnos Inscitos</button></td>
							<td class="td__btnEliminar"><button type="button" class="btnEliminar" data-grado="<?= $grado['id_profesorcursogrupo'] ?>">ELIMINAR</button></td>
						</tr>
						<?php endforeach ?>
						</tbody>
					</table>




					<!-- SECCION DE PREVIEW MODAL -->

					<div class="modal" id="modalPreview">
							<div class="flex" id="flexPreview">
								<div class="modal__contenido">
									<div class="modal__header">
										<h3><span id="modal__grado"></span> - Seccion <span id="modal__seccion"></span></h3>
										<a id="btnCerrarPreview">&times;</a>
									</div>
									<div class="modal__preview">
										<table>
											<thead>
												<tr>
													<th>CEDULA</th>
													<th>NOMBRE</th>
													<th>APELLIDO</th>
													<th>ELIMINAR</th>
												</tr>
											</thead>
											
											<tbody id="ins__tbody">
											<tr id="ins__alumno">
												<form id="ins__form" name="ins__form" enctype="multipart/form-data">
													<td>
														<div class="inputs">
															<input id="ins__cedula" name="ins__cedula" type="text" placeholder="Cedula de Identidad">
															<p class="formulario__input-error">* Este campo debe llenarse obligatoriamente</p>
														</div>
													</td>
													<td>
														<button type="submit" id="btn__ins">INSCRIBIR</button>
													</td>
													<td>
														<button type="button" id="btn__clear">LIMPIAR</button>
													</td>
												</form>
											</tr>
												<!-- <tr>
													<td class="cedula">21151272</td>
													<td class="nombre">JUAN</td>
													<td class="apellido">HERRERA</td>
													<td class="td__btnEliminar__ins"><button type="button" class="btnEliminar__ins" data-grado="<?= $grado['id_profesorcursogrupo'] ?>">ELIMINAR</button></td>
												</tr> -->
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>

					<!-- /SECCION DE PREVIEW MODAL -->
				</div>

			</section>



		</main>

	</div>
	
		
	

	<footer>
		
	</footer>
	



	<!-- JS -->
	<script src="<?= constant('URL') ?>public/js/config.js"></script>
	<script src="<?= constant('URL') ?>public/js/menu.js"></script>
	<script src="<?= constant('URL') ?>public/js/grado.js"></script>
	<!-- /JS -->

</body>
</html>