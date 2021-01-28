<?php


class PostsLapso
{
    public function showPosts($posts, $lapsoActivo, $lapso)
    {
        ?>
        <!-- LAPSO <?= $lapso?> -->
        <div class="box-lapso <?= $lapsoActivo === $lapso? 'active': '' ?>">
				<div class="box-label"> Lapso <?= $lapso ?></div>
				<div class="box-contenidos-lapso">
					<?php foreach ($posts as $post): ?>
						<?php 
							if( $post->lapso === $lapso ){
								$this->showPost($post);
							}
						?>
					<?php endforeach ?>
				</div>
			</div>
            <!-- /LAPSO <?= $lapso?> -->
    <?php 
    }


    public function showPost($post)
    {
    ?>
        <section class="blog" data-blog="<?= $post->id_blog ?>">
            <div class="titulo">
                <div class="titulo_izq">
                    <h4><?= ucfirst($post->titulo) ?></h4>
                    <span><small><small>Fecha: <?= $post->fecha ?></small></small></span>
                </div>
                <?php if ($_SESSION['user'] == 'profesor'): ?>
                <div class="titulo_der">
                    <div class="enlaces">
                        <button title="Editar" class="btnModalEditar item icon-pencil btnInfo" type="button" data-blog="<?= $post->id_blog ?>"></button>
                        <button title="Eliminar" class="btnEliminar icon-bin btnInfo" data-materia="<?= $post->id_profesorcursogrupo ?>" data-blog="<?= $post->id_blog ?>" type="button" ></button>
                    </div>
                </div>
                <?php endif ?>
            </div>

            <div class="contenido">
                <div class="descripcion__qe">
                    <?= nl2br($post->descripcion); ?>
                </div>
                <div class="trabajos">
                    <?php if ($post->file1 or $post->file2 or $post->file3 or $post->file4): ?>
                    <br>
                    <br>
                    <h4>Descarga de Materiales</h4>
                    <br>
                    <?php endif ?>

                    <?php if ($post->file1): ?>
                    <a class="link1" href="<?= constant('URL')?>public/upload/blog/<?= $post->id_profesorcursogrupo?>/<?= $post->id_blog ?>/<?= $post->file1 ?>" download>Material 1</a>
                    <br>
                    <br>
                    <?php endif ?>

                    <?php if ($post->file2): ?>
                    <a class="link2" href="<?= constant('URL')?>public/upload/blog/<?= $post->id_profesorcursogrupo?>/<?= $post->id_blog ?>/<?= $post->file2 ?>" download>Material 2</a>
                    <br>
                    <br>
                    <?php endif ?>

                    <?php if ($post->file3): ?>
                    <a class="link3" href="<?= constant('URL')?>public/upload/blog/<?= $post->id_profesorcursogrupo?>/<?= $post->id_blog ?>/<?= $post->file3 ?>" download>Material 3</a>
                    <br>
                    <br>
                    <?php endif ?>

                    <?php if ($post->file4): ?>
                    <a class="link4" href="<?= constant('URL')?>public/upload/blog/<?= $post->id_profesorcursogrupo?>/<?= $post->id_blog ?>/<?= $post->file4 ?>" download>Material 4</a>
                    <br>
                    <br>
                    <?php endif ?>
                </div>
            </div>
        </section>
    
    <?php
    }
}












?>