<?php


class Evaluaciones
{
    public function showEvaluaciones($evaluaciones, $lapsoActivo, $lapso, $usuario, $barMateria)
    {
        ?>
        <!-- LAPSO <?= $lapso?> -->
        <div class="box-lapso <?= $lapsoActivo === $lapso? 'active': '' ?> <?= 'lapso-'.$lapso?>">
				<div class="box-label"> Lapso <?= $lapso ?></div>
				<div class="box-contenidos-lapso">
					<!-- <?php // foreach ($evaluaciones as $evaluacion): ?>
						<?php 
							// if( $evaluacion->lapso === $lapso ){
							//	$this->showEvaluacion($evaluacion,$usuario,$barMateria,$totalAlumnos);
							// }
						?>
					<?php // endforeach ?> -->
				</div>
			</div>
            <!-- /LAPSO <?= $lapso?> -->
    <?php 
    }


    public function showEvaluacion($evaluacion, $usuario, $barMateria, $totalAlumnos)
    {
    ?>
        <section class="evaluacion" data-evaluacion="<?= $evaluacion->id_actividades ?>" data-plan="<?= $evaluacion->id_plan_evaluacion ?>">
            <div class="titulo">
                <div class="titulo_izq">
                    <?php if ( $evaluacion->id_tipo_evaluacion != 8 ): ?>
                    <h4 class="tipo"><?= $evaluacion->tipo_evaluacion ?></h4>
                    <?php else: ?>
                    <h4><?= ucfirst($evaluacion->otros) ?></h4>
                    <?php endif ?>
                </div>

                <?php if ($_SESSION['user'] == 'profesor'): ?>
                <div class="titulo_der">
                    <div class="enlaces">
                        <button title="Editar" class="btnModalEditar item icon-pencil btnInfo" type="button" data-evaluacion="<?= $evaluacion->id_actividades ?>"></button>
                        <button title="Eliminar" class="btnEliminar icon-bin btnInfo" data-materia="<?= $this->barMateria[2] ?>" data-evaluacion="<?= $evaluacion->id_actividades ?>" type="button" ></button>
                    </div>
                </div>
                <?php endif ?>
            </div>
            <div class="contenido">
                <p><strong>Fecha limite: </strong><span class="fecha"><?= $evaluacion->fecha ?></span></p>
                <p><strong>Valor: </strong><span class="valor">20pts</span></p>
                <br>
                <p><strong>Descripcion: </strong></p>
                <div class="editor__qe">
                    <?= nl2br($evaluacion->descripcion) ?>
                </div>
            
                <div class="trabajos mostrar_archivos">

                    <?php if ($evaluacion->file1 or $evaluacion->file2 or $evaluacion->file3 or $evaluacion->file4): ?>
                    <br>
                    <br>
                    <h4>Descarga de Materiales</h4>
                    <br>
                    <?php endif ?>

                    <?php if ($evaluacion->file1): ?>
                    <a class="link1" href="<?= constant('URL')?>public/upload/actividad/<?= $this->barMateria[2]?>/<?= $evaluacion->id_actividades ?>/<?= $evaluacion->file1 ?>" download>Material 1</a>
                    <br>
                    <br>
                    <?php endif ?>

                    <?php if ($evaluacion->file2): ?>
                    <a class="link2" href="<?= constant('URL')?>public/upload/actividad/<?= $this->barMateria[2]?>/<?= $evaluacion->id_actividades ?>/<?= $evaluacion->file2 ?>" download>Material 2</a>
                    <br>
                    <br>
                    <?php endif ?>

                    <?php if ($evaluacion->file3): ?>
                    <a class="link3" href="<?= constant('URL')?>public/upload/actividad/<?= $this->barMateria[2]?>/<?= $evaluacion->id_actividades ?>/<?= $evaluacion->file3 ?>" download>Material 3</a>
                    <br>
                    <br>
                    <?php endif ?>

                    <?php if ($evaluacion->file4): ?>
                    <a class="link4" href="<?= constant('URL')?>public/upload/actividad/<?= $this->barMateria[2]?>/<?= $evaluacion->id_actividades ?>/<?= $evaluacion->file4 ?>" download>Material 4</a>
                    <br>
                    <br>
                    <?php endif ?>

                </div>
                <br>
                <a href="<?= constant('URL') . 'evaluacion/detail/' . $barMateria[2] . '/' . $evaluacion->id_actividades?>">Detalles</a>

                <?php if ($usuario['user'] == 'profesor'): ?>
                <br>
                <br>
                <a href="<?= constant('URL') . 'evaluacion/detail/' . $barMateria[2] . '/' . $evaluacion->id_actividades?>#Entregadas">Actividades entregadas (<?= $evaluacion->entregados .  " / " . $totalAlumnos[0] ?>)</a>
                <?php endif ?>
            </div>
        </section>
    <?php
    }
}












?>