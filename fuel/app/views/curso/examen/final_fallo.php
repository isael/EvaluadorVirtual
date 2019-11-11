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
							$vidas_posibles = intval($examen->vidas);
							$vidas_usadas = 1;
							$es_test = True;
							if(isset($presenta)){
								$es_test = False;
								$vidas_usadas = intval($presenta->vidas);
							}
							$vidas_totales = $vidas_posibles - $vidas_usadas;
							for ($i=0; $i < $vidas_totales; $i++) { 
								echo '<i class="fa fa-heart" aria-hidden="true"></i>';
							}
							for ($i=0; $i < $vidas_usadas; $i++) { 
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
							$fallas = SESSION::get('fallas');
							if(isset($fallas)){
								SESSION::delete('fallas');
							}
							$oportunidades_posibles = intval($examen->oportunidades);
							for ($i=0; $i < $oportunidades_posibles; $i++) { 
								echo '<i class="fa fa-star-o" aria-hidden="true"></i>';
							}
						?>
					</div>
				</div>
				<hr>
				<!-- /Barra -->

				<!-- Informacion -->
					<div class="col-xs-12">
						<div class="col-xs-12">
							<span>
								Ya no tienes más oportunidades. Se te restará una vida. Intenta presentar el examen nuevamente luego de haber estudiado mejor.
							</span>
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
        	<?php echo $es_test ? Form::open('curso/examenes') : Form::open('curso/alumno'); ?>
            <div class="col-xs-12">
                <?php echo Form::button('salir', 'Salir', array('class' => 'btn btn-danger btn-block')); ?>
            </div>
            <?php echo Form::close(); ?>
        </div>
    </div>
</footer>