<section class="session">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 text-center">
				<!-- Contenido -->
				<?php
				?>
				<!-- Barra -->
				<div class="row">
					<div class="col-xs-2">
						<?php echo Html::anchor('curso/examenes','<i class="fa fa-chevron-circle-left"></i>', array('class' => 'btn btn-primary btn-block btn-lg')); ?>

					</div>
					<div class="col-xs-8 materia materia_peque">
						Preguntas compartidas
					</div>
					<div class="col-xs-2">
						<i i class="fa fa-file-text-o fav_icon"></i>
					</div>
				</div>
				<hr>
				<!-- /Barra -->
			   
				<!-- Area de trabajo -->
				
					<div class="col-xs-12">
						<?php
							if(isset($cursos)){
								foreach ($cursos as $curso) {
									echo '<div class="col-xs-12 table">';
										echo '<h4>'.$curso->nombre.'</h4>';
									echo '</div>';
									echo $curso->id_curso;
									echo '<div class="col-xs-12" table>';
										echo '<div class="col-xs-3 table-row">';
											echo isset($materia) ?
												Html::anchor('curso/examen/preguntas_compartidas/'.$materia.'/'.$curso->id_curso,'Ver lista de preguntas', array('class' => 'btn btn-primary btn-block btn-lg'))
												: 'Hubo un error en los datos';
										echo '</div>';
										echo '<div class="col-xs-9 table-row">';
											echo 'Imparte el profesor '.$curso->nombres.' '.$curso->apellidos.'. Temas incluidos: ';
											if(isset($temas_cursos)){
												if(in_array($curso->id_curso, $temas_cursos)){
													$temas = $temas_cursos[$curso->id_curso];
													if (isset($temas)) {
														$i = 0;
														foreach ($temas as $tema) {
															if($i > 0){
																echo ', ';
															}
															echo $tema->nombre;
															$i++;
														}
														echo '.';
													}
												}
											}
										echo '</div>';
									echo '</div>';
									echo '<br>';
								}
							}
						 ?>
					</div>
				<!-- /Area de trabajo -->
				<!-- /Contenido -->
			</div>
		</div>
	</div>
</section>