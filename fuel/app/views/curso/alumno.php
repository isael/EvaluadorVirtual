<section class="session">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 text-center">
				<?php
					$curso_inicio = '2019-07-04';//substr($curso->fecha_inicio, 0, 10);
					$curso_final = '2020-01-04';//substr($curso->fecha_fin, 0, 10);
				?>
				<!-- Contenido -->
				<div class="row">

						<div class="col-xs-2">
							<?php echo Html::anchor('sesion/alumno','<i class="fa fa-chevron-circle-left"></i>', array('class' => 'btn btn-primary btn-block btn-lg')); ?>
						</div>
						<div class="col-xs-8 materia">
							<?php echo $curso->nombre;; ?>
						</div>
				</div>
				<!-- /Barra -->
				<br>
				<div class="row">
					<div class="col-xs-12 table">
						<div class="col-xs-6 table-row">
							<p>Promedio en la materia</p>
						</div>
						<div class="col-xs-6 table-row">
							<p>Vigencia del curso</p>
						</div>
					</div>
					<div class="col-xs-12 table">
						<div class="col-xs-6 table-row">
							<div class="mega">
								<?php echo "9";//"<h3>".$curso->nombre."</h3>" ?>
							</div>
						</div>
						<div class="col-xs-6 table-row">
							<div class="col-xs-12 col-sm-12">
								<div class="col-xs-12 col-sm-12">
									<?php echo Form::label('Inicio', 'curso_inicio'); ?>
								</div>
								<div class="col-xs-12 col-sm-12">
									<?php echo Form::input('curso_inicio',$curso_inicio,array('class'=>'form-control','type' => 'date', 'placeholder'=>'DD/MM/AAAA', 'disabled' => 'true')); ?>
								</div>
							</div>
							<div class="col-xs-12 col-sm-12">
								<div class="col-xs-12 col-sm-12">
									<?php echo Form::label('Final', 'curso_final'); ?>
								</div>
								<div class="col-xs-12 col-sm-12">
									<?php echo Form::input('curso_final',$curso_final,array('class'=>'form-control','type' => 'date', 'placeholder'=>'DD/MM/AAAA', 'disabled' => 'true')); ?>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xs-12">
						<?php echo Html::anchor('curso/mis_estadisticas','<i class="fa fa-bar-chart"></i> <br> Ver mis estadísticas',array('class'=>'btn btn-primary btn-block btn-lg')) ;?>
					</div>
				</div>
				<hr>

				<?php
					echo "<h3>Exámenes disponibles</h3>";
					if (isset($examenes)) {
						$contador = 0;
						foreach ($examenes as $examen) {
							if(isset($examenes_disponibles) && in_array($examen->id_examen, $examenes_disponibles)){
								echo '<div class="col-xs-12 col-md-6 col-lg-4 examen">';
									echo Html::anchor('curso/examen/presentar/'.$examen->id_examen,
											'<div class="row">'.
												'<div class="col-xs-3">'.
													'<i i="" class="fa fa-file-text-o fav_icon"></i>'.
												'</div>'.
												'<div class="col-xs-6">'.
													$examen->nombre.': '.
													' <h5>'.$examen->preguntas_por_mostrar.' preguntas</h5>'.
												'</div>'.
												'<div class="col-xs-3">'.
													'<h4>Vigente</h4>'.
												'</div>'.
											'</div>'
										, array('class' => ''));
								echo '</div>';

							}
							$contador = $contador+1;
						}
						if ($contador==0) {
							echo "<p>-*- No hay exámenes disponibles -*-</p>";
						}
					}

				?>
				<!-- /Contenido -->
			</div>
		</div>
	</div>
</section>