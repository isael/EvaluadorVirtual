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
							$vidas_posibles = intval($examen->vidas);
							$vidas_usadas = 1;
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
							$oportunidades_posibles = intval($examen->oportunidades);
							$oportunidades_usadas = 0;
							if(isset($fallas)){
								SESSION::delete('fallas');
							}
							if(isset($presenta)){
								$oportunidades_usadas = intval($presenta->oportunidades);
							}else{
								if(isset($fallas)){
									$oportunidades_usadas = $fallas;
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
							<h4>Calificación:</h4>
						</div>
						<div class="col-xs-12">
							<h4>0</h4>
						</div>
					</div>					
					<div class="col-xs-12">
						<?php
							echo "Ya no podrás presentar de nuevo la prueba. Estudia más para el próximo examen.";
						?>
					</div>
					<br>
					<div class="col-xs-12">
						<div class="col-xs-12">
							<?php
								if(isset($errores)){
									echo '<h4>Errores:</h4>';
								}
							?>
						</div>
						<div class="col-xs-12">
							<?php
								if(isset($errores)){
									foreach ($errores as $error) {										
										echo '<button class="btn btn-primary btn-block btn-lg" data-toggle="modal" data-target="#modalError'.$error['id_pregunta'].'">';
					                        echo $error['titulo'];
					                    echo '</button>';
										echo '<br>';
					                    echo '<div class="modal fade" id="modalError'.$error['id_pregunta'].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">';
						                	echo '<div class="modal-dialog" role="document">';
							                    echo '<div class="modal-content">';
								                    echo '<div class="modal-header">';
								                        echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
								                          echo '<span aria-hidden="true">&times;</span>';
								                        echo '</button>';
								                        echo '<h4 class="modal-title" id="myModalLabel">'.$error['titulo'].'</h4>';
								                    echo '</div>';
							                        echo '<div class="modal-body">';
							                        	echo Form::open('curso/examen/crear_examen');
							                          	echo '<div class="form-group">
																<div class="col-xs-12 col-sm-12 table">
																	<div class="col-xs-12 col-sm-12">'.
																		Form::label('Pregunta', $error['id_pregunta']).'
																	</div>
																	<div class="col-xs-12 col-sm-12">'.
																		Form::input($error['id_pregunta'],$error['texto_pregunta'],array('class'=>'form-control','type' => 'text','readonly' => 'true')).'
																	</div>
																</div>
															</div>';
														echo '<div class="form-group">
																<div class="col-xs-12 col-sm-12 table">
																	<div class="col-xs-12 col-sm-12">'.
																		Form::label('Respuesta dada', $error['id_respuesta']).'
																	</div>
																	<div class="col-xs-12 col-sm-12">'.
																		Form::input($error['id_respuesta'],$error['texto_respuesta'],array('class'=>'form-control','type' => 'text','readonly' => 'true')).'
																	</div>
																</div>
															</div>';
														if($error['muestra_respuestas'] === '1'){
															echo '<div class="form-group">
																	<div class="col-xs-12 col-sm-12 table">
																		<div class="col-xs-12 col-sm-12">'.
																			Form::label('Respuesta correcta', $error['id_respuesta_correcta']).'
																		</div>
																		<div class="col-xs-12 col-sm-12">'.
																			Form::input($error['id_respuesta_correcta'],$error['texto_respuesta_correcta'],array('class'=>'form-control','type' => 'text','readonly' => 'true')).'
																		</div>
																	</div>
																</div>';
														}else{
															echo '<div class="form-group">
																	<div class="col-xs-12 col-sm-12 table">
																		<div class="col-xs-12 col-sm-12">'.
																			Form::label('Tema relacionado', $error['id_tema']).'
																		</div>
																		<div class="col-xs-12 col-sm-12">'.
																			Form::input($error['id_tema'],$error['texto_tema'],array('class'=>'form-control','type' => 'text','readonly' => 'true')).'
																		</div>
																	</div>
																</div>';
														}
														echo '<div class="form-group">
																<div class="col-xs-12 col-sm-12 table">
																	<div class="col-xs-12 col-sm-12">'.
																		Form::label('Justificación', 'justificacion_'.$error['id_pregunta']).'
																	</div>
																	<div class="col-xs-12 col-sm-12">'.
																		Form::input('justificacion_'.$error['id_pregunta'],$error['justificacion'],array('class'=>'form-control','type' => 'text','readonly' => 'true')).'
																	</div>
																</div>
															</div>';
														echo '<div class="form-group">
																<div class="col-xs-12 col-sm-12 table">
																	<div class="col-xs-12 col-sm-12">'.
																		Form::label('Bibliografía', 'bibliografia_'.$error['id_pregunta']).'
																	</div>
																	<div class="col-xs-12 col-sm-12">'.
																		Form::input('bibliografia_'.$error['id_pregunta'],$error['bibliografia'],array('class'=>'form-control','type' => 'text','readonly' => 'true')).'
																	</div>
																</div>
															</div>';
														echo '<div class="form-group">
																<div class="col-xs-12 col-sm-12 table">
																	<div class="col-xs-12 col-sm-12 table-row">
																		<span> Si crees que hubo un error en tu evaluación consulta directamente al profesor. </span>
																	</div>
																</div>
															</div>';
														echo Form::close();
							                        echo '</div>';
							                        echo '<div class="modal-footer">';
							                            echo '<div class="row text-center">';
							                              echo '<div class="col-xs-12">';
							                                  echo '<button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Cerrar</button>';
							                              echo '</div>';
							                            echo '</div>';
							                        echo '</div>';
							                    echo '</div>';
						                	echo '</div>';
						                echo '</div>';
									}
								}
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
        	<?php echo $es_test ? Form::open('curso/examenes') : Form::open('curso/alumno'); ?>
            <div class="col-xs-12">
                <?php echo Form::button('salir', 'Salir', array('class' => 'btn btn-danger btn-block')); ?>
            </div>
            <?php echo Form::close(); ?>
        </div>
    </div>
</footer>