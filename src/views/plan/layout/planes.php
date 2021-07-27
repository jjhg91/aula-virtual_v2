<?php

class PlanesEvaluaciones
{
    
    public function showPlanesEvaluaciones($planes, $lapsoActivo, $lapso, $barMateria)
    {
        ?>
        <!-- LAPSO <?= $lapso?> -->
        <div class="box-lapso <?= $lapsoActivo === $lapso? 'active': '' ?> <?= 'lapso-'.$lapso?>">
				<div class="box-label"> Lapso <?= $lapso ?></div>
				<div class="box-contenidos-lapso">
					<!-- <?php // foreach ($planes as $plan): ?>
						<?php 
							// if( $plan->lapso === $lapso ){
							// 	$this->showPlanEvaluacion($plan,$barMateria);
							// }
						?>
					<?php // endforeach ?> -->
				</div>
			</div>
            <!-- /LAPSO <?= $lapso?> -->
    <?php
    }
    
    public function showPlanEvaluacion($plan, $barMateria)
    {
        ?>

        <section class="plan_evaluacion" data-plan="<?= $plan->id_plan_evaluacion ?>">
				<div class="titulo">
					<div class="titulo_izq">
						<?php if ($plan->id_tipo_evaluacion != 8): ?>
							<h4><?= $plan->tipo_evaluacion ?></h4>
						<?php else: ?>
							<h4><?= ucfirst($plan->otros) ?></h4>
						<?php endif ?>
					</div>

					<?php if($_SESSION['user'] == 'profesor'): ?>
					<div class="titulo_der">
						<div class="enlaces">
							<button title="Editar" class="btnModalEditar item icon-pencil btnInfo" type="button" data-plan="<?= $plan->id_plan_evaluacion ?>"></button>
							<button title="Eliminar" class="btnEliminar icon-bin btnInfo" data-materia="<?= $plan->id_profesorcursogrupo ?>" data-plan="<?= $plan->id_plan_evaluacion ?>" type="button" ></button>
						</div>
					</div>
					<?php endif; ?>
				</div>
				<div class="contenido">
					<span class="semana"><small><?= $plan->semana ?></small></span>
					<br>
					<?php if ( $barMateria[5] === 'Bachillerato' ): ?>
						<span class="valor"><small><strong>Valor: </strong><span>20pts</span></small></span>
					<?php endif?>
					
					<?php if ($_SESSION['user'] == 'alumno'): ?>
					<br>
					<br>
					<?php if (isset($nota[0])): ?>
						<span><small><strong>Nota: </strong><?= $nota[4] ?></small></span>
						<br>
						<span><small><strong>Observacion: </strong><?= $nota[5] ?></small></span>
					<?php else: ?>
						<span><small><strong>Nota: </strong>SIN CORREGIR</small></span>
					<?php endif ?>
					<?php endif ?>

					<br>
					<br>
					<p><strong>Descripcion: </strong></p>
					<div class="descripcion">
						<?= nl2br($plan->descripcion) ?>
					</div>
				</div>
			</section>
            
            <?php
    }
}








?>