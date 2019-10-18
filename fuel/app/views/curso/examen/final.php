<section class="session">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
				<!-- Contenido -->
				<!-- Barra -->
				<div class="row">
					<div class="col-xs-4">
						<?php echo "Vidas: "; ?>
						<?php
							$fallas = SESSION::get('fallas');
							if(isset($fallas)){
								SESSION::delete('fallas');
							}
							$vidas_posibles = intval($examen->vidas);
							for ($i=0; $i < $vidas_posibles; $i++) { 
								echo '<i class="fa fa-heart-o" aria-hidden="true"></i>';
							}
						?>
					</div>
					<div class="col-xs-4 materia materia_peque">
						<?php echo $examen->nombre; ?>
					</div>
					<div class="col-xs-4">
						<?php echo "Oportunidades: "; ?>
						<?php
							$oportunidades_posibles = intval($examen->oportunidades);
							for ($i=0; $i < $oportunidades_posibles; $i++) { 
								echo '<i class="fa fa-heart-o" aria-hidden="true"></i>';
							}
						?>
					</div>
				</div>
				<hr>
				<!-- /Barra -->

				<!-- Informacion -->
					<div class="col-xs-12">
						<div class="col-xs-12">
							<h4>Calificación:</h4>
						</div>
						<div class="col-xs-12">
							<?php
								$factor = intval($examen->preguntas_por_mostrar)*10;
								$puntaje_obtenido = SESSION::get('puntaje_obtenido');
								if(isset($puntaje_obtenido)){
									SESSION::delete('puntaje_obtenido');
								}
								$puntaje_obtenido = intval($puntaje_obtenido)/$factor;
								echo  $puntaje_obtenido.'/10';
							?>
						</div>
					</div>
				<!-- /Informacion -->
				
				<!-- /Contenido -->
			</div>
		</div>
	</div>
</section>
<!-- Footer -->
<footer class="text-center" style="padding-top: 33px;">
	<div class="footer-above">
        <div class="row">
        	<?php echo Form::open('curso/examenes'); ?>
            <div class="col-xs-12">
                <?php echo Form::button('salir', 'Salir', array('class' => 'btn btn-danger btn-block')); ?>
            </div>
            <?php echo Form::close(); ?>
        </div>
    </div>
</footer>