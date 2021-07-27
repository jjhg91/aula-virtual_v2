<?php 
	
	//require_once('../../src/controller/asignatura.php');
	
	//require_once('../../src/controller/navbar.php');


?>

<?php function Loader(){ ?>
	<!-- LOADER
	PANTALLA PARA MOSTRAR HASTA QUE CARGUE LA PAGINA -->
	<div class="loader">
		<img src="public/media/LogoIUTJMC.png" alt="" width="200">
		<span>Cargando...</span>
	</div>
	<!-- /LOADER -->
<?php } ?>

<?php function Headerr(){ ?>
	<!-- HEADER
	BARRA SUPERIOR DE TITULO ESTA TIENE 
	EL BOTON DEL NAV, EL NOMBRE Y EL BOTON SALIR -->
	<header>
		<div class="padre">
			
			<button class="menuPadre"><span class="icon-menu"></span></button>
				
			
			
			<div>

				<h4 class="grande">Unidad Educativa Privada "José María Carreño"</h4>
				<h4 class="chico">UEPJMC</h4>
			</div>
			<div>
				<a title="Manual de usuario Alumnos" href="<?= constant('URL') ?>public/media/manuales/manual_de_usuario_alumno.pdf" download=""><span class="icon-map"></span></a>
				<a href="<?= constant('URL') ?>index/logout">SALIR</a>
			</div>
			
		</div>
	</header>
	<!-- /HEADER -->
<?php } ?>

<?php function Navbar($usuario, $navbarMaterias, $periodo){ ?>
	<!-- NAV
	MUESTRA LOS DATOS DEL USUARIO Y MENU DE
	MATERIAS INSCRITAS DONDE -->
	<nav class="nav_oculto">

		<!-- DATOS PERSONALES DEL USUARIO
		FOTO, NOMBRE, PERIODO CURSANDO -->
		<div class="datos_personales">

			<!-- prueba -->
			<?php if($usuario['genero'] == 1): ?>
				<img src="<?= constant('URL') ?>public/media/h.jpg" alt="..." >
			<?php else: ?>
				<img src="<?= constant('URL') ?>public/media/m.jpg" alt="..." >
			<?php endif; ?>
			<!-- prueba -->

			<!-- <img src="../../media/user.jpg" alt=""> -->

			<h4 id="nombre__usuario"><?= $usuario['nombre'] ?></h4>
			
			<?php if ( $usuario['user'] === 'alumno' ): ?>
				<span><small>Estudiante</small></span>
			<?php elseif ( $usuario['user'] === 'profesor' ): ?>
				<span><small>Profesor</small></span>
			<?php endif; ?>	
				
			
			<!-- <span><small>2020-2</small></span>	 -->
			<span><small>Periodo Actual: <?= $periodo->periodo ?></small></span>
			<span><small>Lapso en curso: <?= $periodo->lapso ?></small></span>

		</div>
		<!-- /DATOS PERSONALES DEL USUARIO -->
		
		<hr>

		<!-- MENU 
		MUESTRA LOS MENU DE INICIO Y DE CADA MATERIA -->
		<div class="menu">
			<ul>		
				<?php if($usuario['user'] != 'admin'): ?>		
				<li class="submenu">
					<a href="<?= constant('URL') ?>main">Inicio</a>
				</li>
				<?php endif ?>
				<?php if ( $usuario['user'] === 'profesor' && ($_SESSION['nivel'] === 'Primaria' || $_SESSION['nivel'] === 'Preescolar') && $navbarMaterias[0][3] === $navbarMaterias[1][3] && $navbarMaterias[0][4] === $navbarMaterias[1][4] && $navbarMaterias[0][6] === $navbarMaterias[1][6] ): ?>
					<li class="submenu">
						<a href="<?= constant('URL') ?>mensajeInicio/mensajes">Mensajes de Inicio</a>
					</li>
				<?php endif ?>
				
				<?php if ( $usuario['user'] === 'admin' ): ?>
					<li class="submenu">
						<a href="<?= constant('URL') ?>admin/inicio">Inicio</a>
					</li>
					<li class="submenu">
						<a href="<?= constant('URL') ?>admin/profesor">Profesores</a>
					</li>
					<li class="submenu">
						<a href="<?= constant('URL') ?>admin/alumno">Alumnos</a>
					</li>

					<li class="submenu">
						<a href="<?= constant('URL') ?>admin/periodo">Periodos</a>
					</li>
					<li class="submenu">
						<a href="<?= constant('URL') ?>admin/grado">Grados</a>
					</li>
					<li class="submenu">
						<a href="<?= constant('URL') ?>admin/asignatura">Asignaturas</a>
					</li>
				<?php endif ?>

				<?php  foreach ($navbarMaterias as $row): ?>

				<li class="submenu">

					<?php if(!empty($_GET['mat']) and $_GET['mat'] == $row[2] ): ?>
						<a class="aqui active">
					<?php else: ?>
						<a class="aqui">
					<?php endif ?>

					<!-- <a class="aqui"> -->
						<div>
							<span><?= $row[0] ?></span><br>
							<span class="carrera"><small><?= $row[3] ?></small></span>
							<?php if ($usuario['user'] === 'alumno' ): ?>
								<span class="carrera"><small><small>seccion <?= $row[7] ?></small></small></span>
							<?php elseif ($usuario['user'] === 'profesor'): ?>
							<span class="carrera"><small><small>seccion <?= $row[6] ?></small></small></span>
							<?php endif ?>
						</div>
						
					</a>

					<?php if(!empty($_GET['mat']) and $_GET['mat'] == $row[2] ): ?>
						<ul class="children open">
					<?php else: ?>
						<ul class="children">
					<?php endif ?>

					<!-- <ul class="children"> -->
						<li>
							<a href="<?= constant('URL') ?>contenido/all/<?= $row[2] ?>">Contenido</a>
						</li>
						<li>
							<a href="<?= constant('URL') ?>plan/all/<?= $row[2] ?>">Plan Evaluacion</a>
						</li>
						<li>
							<a href="<?= constant('URL') ?>evaluacion/all/<?= $row[2] ?>">Evaluaciones</a>
						</li>
						<li>
							<a href="<?= constant('URL') ?>blog/all/<?= $row[2] ?>">Blog</a>
						</li>
						<li>
							<a href="<?= constant('URL') ?>foro/all/<?= $row[2] ?>">Foro</a>
						</li>
					
						<?php if ($_SESSION['user'] === 'profesor'): ?>
						<li>
							<a href="<?= constant('URL') ?>alumno/all/<?= $row[2] ?>">Alumnos</a>
						</li>
						<li>
							<a href="<?= constant('URL') ?>nota/all/<?= $row[2] ?>">Cargar Nota</a>
						</li>
						<?php endif; ?>
					
					</ul>
				</li>
				<?php endforeach; ?>





			</ul>
		</div>
		<!-- /MENU -->	
			
	</nav>
	<!-- /NAV -->
<?php } ?>

<?php function TarjetaInformativa($titulo,$barMateria){ 
	?>

	
	<!-- SECTION 
	TARJETA INFORMATIVA NOMRE DE LA PAGINA 
	NOMRES DE LA CARRERA, MATERIA, PROFESOR Y PERIODO -->
	<section class="tarjeta_informacion">
		<hgroup class="hgroup_izq"	>
			<!-- <h4>Carrera: <?= $barMateria[4] ?></h4> -->
			<h4><?= $barMateria[4] ?></h4>
			<!-- <h4>Materia: <?= $barMateria[0] ?></h4> -->
			<h4>Asignatura: <?= $barMateria[0] ?></h4> 
			<h4>Profesor: <?= $barMateria[3] ?></h4>
			<!-- <h4>Periodo: 2020-2</h4> -->
			<h4>Año escolar: 2020-2021</h4>
		</hgroup>
			
		<hgroup class="hgroup_der">
						<h3><?= $titulo ?></h3>
		</hgroup>
		
	</section>
	<!-- /SECTION -->
<?php } ?>