<?php


class Planes
{
    public function showPlanes($planes, $lapsoActivo, $lapso)
    {
        ?>
        <!-- LAPSO <?= $lapso?> -->
        <div class="box-lapso <?= $lapsoActivo === $lapso? 'active': '' ?>">
				<div class="box-label"> Lapso <?= $lapso ?></div>
				<div class="box-contenidos-lapso">
					<?php foreach ($planes as $plan): ?>
						<?php 
							if( $plan->lapso === $lapso ){
								$this->showPlan($plan);
							}
						?>
					<?php endforeach ?>
				</div>
			</div>
            <!-- /LAPSO <?= $lapso?> -->
    <?php 
    }


    public function showPlan($plan)
    {
    ?>
        <section class="plan_evaluacion">
            <div class="titulo">
                <div class="titulo_izq">
                    <?php if ($plan->id_tipo_evaluacion != 8 ): ?>
                    <h4><?= $plan->tipo_evaluacion ?></h4>
                    <?php else: ?>
                    <h4><?= ucfirst($plan->otros) ?></h4>
                    <?php endif ?>
                    <span><small><?= $plan->semana ?></small></span>
                </div>
                <div class="titulo_der">
                    <div class="enlaces">
                        <a href="<?= constant('URL') ?>nota/cargar/<?= $plan->id_profesorcursogrupo ?>/<?= $plan->id_plan_evaluacion ?>"><span class="icon-plus"></span></a>
                    </div>
                </div>
            </div>
            <div class="contenido">
                <span><small>Valor: <?= $plan->valor ?>%</small></span>
                <br>
                <span><small>Punto: <?= $plan->valor * 0.20 ?>pts</small></span>
                <br>
                <br>
                <p> <?= $plan->descripcion ?> </p>
            </div>
        </section>
    <?php
    }
}




?>