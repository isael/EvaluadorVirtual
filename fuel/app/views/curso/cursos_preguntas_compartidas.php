<section class="session">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 text-center">
				<!-- Contenido -->
				<?php
				?>
				<!-- Barra -->
				<div class="row">
					<div class="col-xs-2 materia">
						<?php echo Html::anchor('curso/examenes','<i class="fa fa-arrow-left"></i>', array('class' => 'btn btn-primary btn-block btn-lg')); ?>

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
							if(isset($cursos) && sizeof($cursos)>0){
								foreach ($cursos as $curso) {
									echo '<div class="col-xs-12 table">';
										echo '<h4>'.$curso->nombre.'</h4>';
									echo '</div>';
									echo '<div class="col-xs-12" table>';
										echo '<div class="col-xs-3 table-row">';
											echo isset($materia) ?
												Html::anchor('curso/examen/preguntas_compartidas/'.$materia.'/'.$curso->id_curso,'Ver lista', array('class' => 'btn btn-primary btn-block btn-lg'))
												: 'Hubo un error en los datos';
										echo '</div>';
										echo '<div class="col-xs-9 table-row">';
											echo 'Imparte el profesor '.$curso->nombres.' '.$curso->apellidos.'. Temas incluidos: ';
											if(isset($temas_cursos)){
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
										echo '</div>';
									echo '</div>';
									echo '<br>';
								}
							}
							else{
								echo "No hay coincidencias con el curso que indicaste, inténtalo de nuevo.";
							}
						 ?>
					</div>
				<!-- /Area de trabajo -->
				<!-- /Contenido -->
			</div>
		</div>
	</div>
</section>