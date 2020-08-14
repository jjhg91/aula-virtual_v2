<?php 
	
	//require_once('../../src/controller/asignatura.php');
	
	//require_once('../../src/controller/navbar.php');


?>

<?php function Loader(){ ?>
	<!-- LOADER
	PANTALLA PARA MOSTRAR HASTA QUE CARGUE LA PAGINA -->
	<div class="loader">
		<img src="public/media/logo.jpg" alt="" width="200">
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

				<h4 class="grande">Instituto Universitario de Tecnología "José María Carreño"</h4>
				<h4 class="chico">IUTJMC</h4>
			</div>
			<div>
				<a title="Manual de usuario Alumnos" href="<?= constant('URL') ?>public/media/manuales/manual_de_usuario_alumno.pdf" download=""><span class="icon-map"></span></a>
				<a href="<?= constant('URL') ?>index/logout">SALIR</a>
			</div>
			
		</div>
	</header>
	<!-- /HEADER -->
<?php } ?>

<?php function Navbar($usuario, $navbarMaterias){ ?>
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

			<h4><?= $usuario['nombre'] ?></h4>
			
			<?php if ( $usuario['user'] === 'alumno' ): ?>
				<span><small>Alumno</small></span>
			<?php else: ?>
				<span><small>Profesor</small></span>
			<?php endif; ?>	
				
			
			<span><small>2020-2</small></span>	
		</div>
		<!-- /DATOS PERSONALES DEL USUARIO -->
		
		<hr>

		<!-- MENU 
		MUESTRA LOS MENU DE INICIO Y DE CADA MATERIA -->
		<div class="menu">
			<ul>				
				<li class="submenu">
					<a href="<?= constant('URL') ?>main">Inicio</a>
				</li>


				<?php foreach ($navbarMaterias as $row): ?>
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
			<h4>Carrera: <?= $barMateria[4] ?></h4>
			<h4>Materia: <?= $barMateria[0] ?></h4>
			<h4>Profesor: <?= $barMateria[3] ?></h4>
			<h4>Periodo: 2020-2</h4>
		</hgroup>
			
		<hgroup class="hgroup_der">
						<h3><?= $titulo ?></h3>
		</hgroup>
		
	</section>
	<!-- /SECTION -->
<?php } ?>