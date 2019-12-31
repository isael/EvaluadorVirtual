<section class="session">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 text-center">
				<!-- Contenido -->
				<?php
					$idPregunta = SESSION::get('id_pregunta');
					if(isset($idPregunta)){
						SESSION::delete('id_pregunta');
					}
				?>
				<!-- Barra -->
				<div class="row">
					<div class="col-xs-2">
						<?php echo Html::anchor('curso/examen/materias_preguntas_compartidas/'.$materia,'<i class="fa fa-chevron-circle-left"></i>', array('class' => 'btn btn-primary btn-block btn-lg')); ?>

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
							if(isset($preguntas)){
								$tema_actual = '';
								foreach ($preguntas as $pregunta) {
									if($pregunta->nombre !== $tema_actual){
										$tema_actual = $pregunta->nombre;
										echo '<h4>'.$tema_actual.'</h4>';
									}
									echo '<div class="col-xs-12">';
										echo '<div class="col-xs-1">';
											echo '<input type="checkbox" name="'.$pregunta->id_pregunta.'" value="'.$pregunta->id_pregunta.'" '.(isset($preguntas_compartidas_agregadas) && in_array($pregunta->id_pregunta, $preguntas_compartidas_agregadas)? 'checked ' :  '').'disabled>';
										echo '</div>';
										echo '<div class="col-xs-8">';
											echo Html::anchor('curso/examen/mostrar_pregunta_compartida/'.$materia.'/'.$id_curso_compartido.'/'.$pregunta->id_pregunta,$pregunta->texto, array());
										echo '</div>';
										echo '<div class="col-xs-3">';
											echo 'Nivel '.$pregunta->dificultad;
										echo '</div>';
									echo '</div>';
								}
							}
						 ?>
					</div>
				<!-- /Area de trabajo -->
				<!-- Modales -->
					<div id="botonModal">
					</div>
					<?php
						if(isset($idPregunta)){
					?>
					<div class="modal fade" id="modalPregunta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<?php echo Modals::getModalPreguntaCompartida($idPregunta, $materia, $id_curso_compartido); ?>
					</div>
					<?php
						}
					?>
				<!-- /Modales -->
				<!-- /Contenido -->
			</div>
		</div>
	</div>
</section>

<script type="text/javascript">
	<?php
	if(isset($idPregunta)){
		?>
			let botonModalPregunta = document.createElement('button');
			botonModalPregunta.setAttribute('data-toggle','modal');
			botonModalPregunta.setAttribute('data-target','#modalPregunta');
			botonModalPregunta.style.visibility = "hidden";
			let padre = document.getElementById('botonModal');
			padre.appendChild(botonModalPregunta);
			setTimeout(function(){
				botonModalPregunta.click();
				padre.removeChild(botonModalPregunta);
			},100);

		<?php
	}
	?>
</script>