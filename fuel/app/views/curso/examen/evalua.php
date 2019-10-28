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
							$vidas_usadas = 0;
							if(isset($presenta)){
								$vidas_usadas = intval($presenta->vidas)-1;
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
							$oportunidades_posibles = intval($examen->oportunidades);
							$oportunidades_usadas = 0;
							if(isset($presenta)){
								$oportunidades_usadas = intval($presenta->oportunidades) > $oportunidades_posibles ? $oportunidades_posibles : intval($presenta->oportunidades);
							}else{
								if(isset($fallas)){
									$oportunidades_usadas = $fallas > $oportunidades_posibles ? $oportunidades_posibles : $fallas;
								}
							}
							$oportunidades_totales = $oportunidades_posibles - $oportunidades_usadas;
							for ($i=0; $i < $oportunidades_totales; $i++) {
								echo '<i class="fa fa-star" aria-hidden="true"></i>';
							}
							for ($i=0; $i < $oportunidades_usadas; $i++) {
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
							<h4>
								<?php
									echo $evaluacion > 0 ? ($evaluacion == 100 ? 'RESPUESTA CORRECTA' : 'RESPUESTA BUENA, MAS NO LA MEJOR' ) : 'RESPUESTA INCORRECTA';
								?>
							</h4>
						</div>
					</div>
					<hr style="border:2px dotted" />
					<div class="col-xs-12">
						<div class="col-xs-12">
							<h4>Valor de la respuesta:</h4>
						</div>
						<div class="col-xs-12">
							<?php
								echo $evaluacion;
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
			<?php echo Form::open('curso/examen/presentando'); ?>
			<div class="col-xs-6">
				<?php echo Form::button('abandonar', 'Abandonar', array('class' => 'btn btn-primary btn-block', 'value' => 'abandonar', 'type' => 'button')); ?>
			</div>
			<div class="col-xs-6">
				<?php echo Form::button('evaluar', 'Siguiente Pregunta', array('class' => 'btn btn-danger btn-block', 'value' => 'evaluar', 'id' => 'boton_evaluar')); ?>
			</div>
			<?php echo Form::close(); ?>
		</div>
	</div>
</footer>