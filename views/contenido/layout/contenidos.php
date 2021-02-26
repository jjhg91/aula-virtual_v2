<?php


class Contenidos
{
    public function showContenidos($contenidos, $lapsoActivo, $lapso)
    {
        ?>
        <!-- LAPSO <?= $lapso?> -->
        <div class="box-lapso <?= $lapsoActivo === $lapso? 'active': '' ?> <?= 'lapso-'.$lapso?>">
				<div class="box-label"> Lapso <?= $lapso ?></div>
				<div class="box-contenidos-lapso">
					<?php foreach ($contenidos as $contenido): ?>
						<?php 
							if( $contenido->lapso === $lapso ){
								$this->showContenido($contenido);
							}
						?>
					<?php endforeach ?>
				</div>
			</div>
            <!-- /LAPSO <?= $lapso?> -->
    <?php 
    }


    public function showContenido($contenido)
    {
    ?>
    
        <section class="contenido" data-contenido="<?= $contenido->id_contenido ?>">
            <div class="titulo">
                <div class="titulo_izq">
                    <h4>Objetivo <span class="objetivo__numero"><?= $contenido->numero ?></span></h4>
                </div>

                <?php if($_SESSION['user'] == 'profesor'): ?>
                <div class="titulo_der ">
                    <div class="enlaces">
                        <button title="Editar" class="btnModalEditar item icon-pencil btnInfo" type="button" data-contenido="<?= $contenido->id_contenido ?>"></button>
                        <button title="Eliminar" class="btnEliminar icon-bin btnInfo" data-materia="<?= $contenido->id_profesorcursogrupo ?>" data-contenido="<?= $contenido->id_contenido ?>" data-objetivo="<?= $contenido->numero ?>" type="button" ></button>
                    </div>
                </div>
                <?php endif; ?>

            </div>
            <div class="contenido ">
                <div class="contenido__descripcion">
                    <?= $contenido->descripcion ?>
                </div>
            
            <!-- MOSTRAR ARCHIVOS  -->
                <div class="trabajos mostrar_archivos">
                    <?php if ($contenido->file1 or $contenido->file2 or $contenido->file3 or $contenido->file4): ?>
                    <br>
                    <br>
                    <h4>Descarga de Materiales</h4>
                    <br>
                    <?php endif ?>

                    <?php if ($contenido->file1): ?>
                    <a class="link1" href="<?= constant('URL') ?>public/upload/contenido/<?= $contenido->id_profesorcursogrupo ?>/<?= $contenido->id_contenido ?>/<?= $contenido->file1 ?>" download>Material 1</a>
                    <br>
                    <br>
                    <?php endif ?>

                    <?php if ($contenido->file2): ?>
                    <a class="link2" href="<?= constant('URL') ?>public/upload/contenido/<?= $contenido->id_profesorcursogrupo ?>/<?= $contenido->id_contenido ?>/<?= $contenido->file2 ?>" download>Material 2</a>
                    <br>
                    <br>
                    <?php endif ?>

                    <?php if ($contenido->file3): ?>
                    <a class="link3" href="<?= constant('URL') ?>public/upload/contenido/<?= $contenido->id_profesorcursogrupo ?>/<?= $contenido->id_contenido ?>/<?= $contenido->file3 ?>" download>Material 3</a>
                    <br>
                    <br>
                    <?php endif ?>

                    <?php if ($contenido->file4): ?>
                    <a class="link4" href="<?= constant('URL') ?>public/upload/contenido/<?= $contenido->id_profesorcursogrupo ?>/<?= $contenido->id_contenido ?>/<?= $contenido->file4 ?>" download>Material 4</a>
                    <br>
                    <br>
                    <?php endif ?>
                </div>
            <!-- /MOSTART ARCHIVOS  -->
            </div>
        </section>
    <?php
    }
}












?>