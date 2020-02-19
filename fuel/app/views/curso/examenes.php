<section class="session">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 text-center">
				<!-- Contenido -->

				<!-- SESSION -->
				<?php
					$pestania = SESSION::get('pestania');
					$data = SESSION::get('data');
					$idPregunta = SESSION::get('id_pregunta');
					$externa = SESSION::get('externa');
					$idFuente = SESSION::get('id_fuente');
					$numeroFuente = SESSION::get('numero_fuente');
					$idExamen = SESSION::get('id_examen');
					$es_compartida = SESSION::get('es_compartida');
					if(isset($pestania)){
						SESSION::delete('pestania');
					}
					if(isset($data)){
						SESSION::delete('data');
					}
					if(isset($idPregunta)){
						SESSION::delete('id_pregunta');
					}
					if(isset($externa)){
						SESSION::delete('externa');
					}else{
						$externa=False;
					}
					if(isset($idFuente)){
						SESSION::delete('id_fuente');
					}
					if(isset($numeroFuente)){
						SESSION::delete('numero_fuente');
					}
					if(isset($idExamen)){
						SESSION::delete('id_examen');
					}
					if(isset($es_compartida)){
						SESSION::delete('es_compartida');
					}else{
						$es_compartida = 'false';
					}
				?>
				<!-- /SESSION -->

				<!-- EXTRA -->
				<?php
					$lista_de_tipos_min_max_resp = [];
					if(isset($tipos)){
						foreach ($tipos as $tipo) {
							array_push($lista_de_tipos_min_max_resp, array($tipo->id_tipo, $tipo->min_respuestas, $tipo->max_respuestas));
						}
					}
				?>
				<!-- /EXTRA -->

				<!-- Barra -->
				<div class="row">
					<div class="col-xs-2">
						<?php echo Html::anchor('curso/profesor','<i class="fa fa-chevron-circle-left"></i>', array('class' => 'btn btn-primary btn-block btn-lg')); ?>
					</div>
					<div class="col-xs-8 materia materia_peque">
						<?php echo $curso->nombre;; ?>
					</div>
					<div class="col-xs-2">
						<i i class="fa fa-file-text-o fav_icon"></i>
					</div>
				</div>
				<hr>
				<!-- /Barra -->

				<!-- Pestanias -->
				<?php if(!isset($pestania)){$pestania = '';} ?>
				<div id="pestanias" class="row">
					<ul class="nav nav-tabs pestania">
						<li id="edicion" class="col-xs-4<?php echo $pestania == 'edicion' || $pestania == '' ? " active": ""; ?>"><a href="javascript:cambiarPestania(pestanias, edicion);">Edición</a></li>
						<li id="bibliografia" class="col-xs-4<?php echo $pestania == 'bibliografia' ? " active": ""; ?>"><a href="javascript:cambiarPestania(pestanias, bibliografia);">Bibliografía</a></li>
						<li id="preguntas" class="col-xs-4<?php echo $pestania == 'preguntas' ? " active": ""; ?>"><a href="javascript:cambiarPestania(pestanias, preguntas);">Preguntas</a></li>
					</ul>
				</div>
				<!-- Pestanias -->

				<!-- Area de trabajo -->
				<div id="area_pestanias">
					<!-- Edicion -->
					<div id="area_edicion" class="area<?php echo $pestania == 'edicion' || $pestania == '' ? " expuesto": " oculto"; ?>">
						<!-- Lista Examenes -->
						<?php
							$cual_boton = "examen";
							if(isset($examenes)){
								echo '<div class="row">';
								foreach ($examenes as $examen) {
									echo '<div class="col-xs-12 col-md-6 col-lg-4 examen">';
										echo Html::anchor('curso/examen/mostrar_examen/'.$examen->id_examen,
												'<div class="row">'.
													'<div class="col-xs-3">'.
														'<i i="" class="fa fa-file-text-o fav_icon"></i>'.
													'</div>'.
													'<div class="col-xs-9">'.
														$examen->nombre.': '.
														' '.$examen->preguntas_por_mostrar.' preguntas'.
													'</div>'.
												'</div>'
											, array('class' => ''));
									echo '</div>';
								}
								echo '</div>';
							}else{
								//Verificar si hay preguntas
								if(isset($preguntas)){
									echo "Aun sin examen";
								}else{
									$cual_boton = "preguntas";
									echo "Para poder generar exámenes y preguntas deben existir la bibliografía y un conjunto de preguntas";
									if(!isset($bibliografias)){
										$cual_boton = "bibliografia";
									}
								}
							}
						?>
						<!-- /Lista Examenes -->
						<br>
						<!-- Seccion agregar examenes -->
						<?php
							switch($cual_boton){
								case "preguntas":
								?>
									<div class="row">
										<a class="btn btn-primary btn-block btn-lg" href="javascript:cambiarPestania(pestanias, preguntas);">Crear Preguntas</a>
									</div>
								<?php
									break;
								case "bibliografia":
								?>
									<div class="row">
										<a class="btn btn-primary btn-block btn-lg" href="javascript:cambiarPestania(pestanias, bibliografia);">Crear Bibliografía</a>
									</div>
								<?php
									break;
								case "examen":
								default:
								?>
									<div class="row">
										<button id="mostrarCrearExamen" class="btn btn-primary btn-block btn-lg" onclick="mostrarFormulario('mostrarCrearExamen','agregarExamen','+ Crear nuevo examen','- Cancelar creación de examen')">+ Crear nuevo examen</button>
									</div>
									<br>
									<div id="agregarExamen" class="row" style="display: none;">
										<?php echo Modals::getModalExamen($temas, $temas_externos); ?>
									</div>

								<?php
							}
							?>
						<!-- /Seccion agregar examenes -->
					</div>
					<!-- /Edicion -->

					<!-- Bibliografia -->
					<div id="area_bibliografia" class="area<?php echo $pestania == 'bibliografia' ? " expuesto": " oculto"; ?>">
						<!-- Lista Bibliografias -->
						<?php
							if(isset($bibliografias)){//TODO_ISAEL Cambiar por lista de bibliografia
								echo '<div class="row">';
								foreach ($bibliografias as $fuente) {
									echo '<div class="col-xs-12 col-md-6 col-lg-4">';
										echo '<div class="col-xs-3">';
											echo '<i class="fa fa-book" aria-hidden="true"></i>';
										echo '</div>';
										echo '<div class="col-xs-9">';
											echo Html::anchor('curso/examen/mostrar_bibliografia/'.$fuente->id_fuente.'/'.$fuente->numero,$fuente->nombre.' - '.$fuente->autores.'. '.$fuente->numero.'ª Edición, '.$fuente->anio.'<br>', array('class' => ''));
											echo "<br>";
										echo '</div>';
										echo "</br>";
									echo '</div>';
								}
								echo '</div>';
							}else{
								//Verificar si hay preguntas
								echo "La bibliografía será necesaria para poder relacionar los temas y preguntas con un libro o fuente especifico";
							}
						?>
						<!-- /Lista Bibliografias -->
						<br>
						<!-- Seccion agregar bibliografia -->
						<div class="row">
							<button id="mostrarCrearBibliografia" class="btn btn-primary btn-block btn-lg" onclick="mostrarFormulario('mostrarCrearBibliografia','agregarBibliografia','+ Agregar nueva bibliografía','- Cancelar nueva bibliografía')">+ Agregar nueva bibliografía</button>
						</div>
						<br>
						<div id="agregarBibliografia" class="row" style="display: none;">
							<?php echo Modals::getModalBibliografia(); ?>
						</div>
						<!-- /Seccion agregar bibliografia -->
					</div>
					<!-- /Bibliografia -->

					<!-- Preguntas -->
					<div id="area_preguntas" class="area<?php echo $pestania == 'preguntas' ? " expuesto": " oculto"; ?>">
						<!-- Lista Preguntas Vacia-->
						<?php
							$cual_boton = "preguntas";
							if(!isset($preguntas)){
								//Verificar si hay bibliografía
								if(isset($bibliografias)){
									echo "Las preguntas se separan por temas";
								}else{
									$cual_boton = "bibliografia";
									echo "Para crear preguntas debe existir bibliografía";
								}
							}
						?>
						<!-- /Lista Preguntas Vacia-->
						<!-- Seccion agregar pregunta -->
						<br>
						<?php
							switch($cual_boton){
								case "bibliografia":
								?>
									<div class="row">
										<a class="btn btn-primary btn-block btn-lg" href="javascript:cambiarPestania(pestanias, bibliografia);">Crear Bibliografía</a>
									</div>
								<?php
									break;
								case "preguntas":
								default:
								?>
									<div class="row">
										<button id="mostrarCrearPregunta" class="btn btn-primary btn-block btn-lg" onclick="mostrarFormulario('mostrarCrearPregunta','agregarPregunta','+ Agrega nueva pregunta','- Cancelar nueva pregunta')">+ Agrega nueva pregunta</button>
									</div>
									<br>
									<div id="agregarPregunta" class="row" style="display: none;">
										<?php
											echo Modals::getModalPregunta($temas, $bibliografias, $tipos);
										?>
									</div>
									<div class="row">
										<button id="mostrarCrearPreguntaCompartida" class="btn btn-primary btn-block btn-lg" onclick="mostrarFormulario('mostrarCrearPreguntaCompartida','agregarPreguntaCompartida','+ Agrega preguntas compartidas','- Cancelar preguntas compartidas')">+ Agrega preguntas compartidas</button>
									</div>
									<div id="agregarPreguntaCompartida" class="row" style="display: none;">
										<?php
											echo Modals::getModalPreguntaCompartidaFormulario($profesores);
										?>
									</div>

								<?php
							}
							?>
						<!-- /Seccion agregar pregunta -->
						<br>
						<!-- Lista Preguntas -->
						<?php
							$cual_boton = "preguntas";
							if(isset($preguntas)){
								echo '<div class="row">';
								echo "<h4>Preguntas propias</h4>";
								$tema_actual = "";
								foreach ($preguntas as $pregunta) {
									if($tema_actual !== $pregunta->nombre){
										if($tema_actual !== "")
											echo "</div>";
										$tema_actual = $pregunta->nombre;
										echo '<div class="col-xs-12 table">';
										echo "<h5>".$tema_actual."</h5>";
									}
									echo '<div class="col-xs-12 col-md-6 col-lg-4">';
										echo '<div class="col-xs-9">';
											echo Html::anchor('curso/examen/mostrar_pregunta/'.$pregunta->id_pregunta,'<b>Nivel '.$pregunta->dificultad.':</b> <i><span>'.$pregunta->texto.'</span></i>', array('class' => ''));
											echo "<br>";
										echo '</div>';
										echo '<div class="col-xs-3">';
											$texto = $pregunta->compartida === '1' ? 'Dejar de compartir' : 'Compartir';
											echo Html::anchor('curso/examen/compartir_pregunta/'.$pregunta->id_pregunta,$texto, array('class' => 'btn btn-primary btn-block'));
										echo '</div>';
										echo "</br>";
									echo '</div>';
								}
								if($tema_actual !== "")
									echo "</div>";
								echo '</div>';
							}
							if(isset($preguntas_externas)){
								echo '<div class="row">';
								echo "<h4>Preguntas externas</h4>";
								$tema_actual = "";
								foreach ($preguntas_externas as $pregunta_externa) {
									if($tema_actual !== $pregunta_externa->nombre){
										if($tema_actual !== "")
											echo "</div>";
										$tema_actual = $pregunta_externa->nombre;
										echo '<div class="col-xs-12 table">';
										echo "<h5>".$tema_actual."</h5>";
									}
									echo '<div class="col-xs-12 col-md-6 col-lg-4">';
										echo '<div class="col-xs-9">';
											echo Html::anchor('curso/examen/mostrar_pregunta/'.$pregunta_externa->id_pregunta.'/externa','<b>Nivel '.$pregunta_externa->dificultad.':</b> <i><span>'.$pregunta_externa->texto.'</span></i>', array('class' => ''));
											echo "<br>";
										echo '</div>';
										echo '<div class="col-xs-3">';
											echo '<i class="fa fa-cloud-download"></i>';
										echo '</div>';
										echo "</br>";
									echo '</div>';
								}
								if($tema_actual !== "")
									echo "</div>";
								echo '</div>';
							}
						?>
						<!-- /Lista Preguntas -->
					</div>
					<!-- /Preguntas -->
				</div>
				<!-- /Area de trabajo -->

				<!-- Modales -->
				<div id="botonModal">

				</div>

				<?php
					if(isset($idExamen)){
				?>
				<div class="modal fade" id="modalExamen" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<?php echo Modals::getModalExamen($temas, $temas_externos, True, $idExamen); ?>
				</div>
				<?php
					}
				?>

				<?php
					if(isset($idFuente)){
				?>
				<div class="modal fade" id="modalBibliografia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<?php echo Modals::getModalBibliografia(True, $idFuente, $numeroFuente); ?>
				</div>
				<?php
					}
				?>

				<?php
					if(isset($idPregunta)){
				?>
				<div class="modal fade" id="modalPregunta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<?php
						if($externa)
							echo Modals::getModalPreguntaCompartida($idPregunta, null, null, True);
						else
							echo Modals::getModalPregunta($temas, $bibliografias, $tipos, $es_compartida, True, $idPregunta);
					?>
				</div>
				<?php
					}
				?>

				<div class="modal fade" id="modalAgregarTema" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<h4 class="modal-title" id="myModalLabel">Agregar nuevo tema</h4>
							</div>

							<div class="form-group">
								<div class="modal-body">
									<div class="input-group">
										<?php echo Form::label('Escribe el nombre del nuevo tema. Este se agregará hasta que se haya guardado la pregunta correctamente.', 'modal_tema_input');?>
										<input id="modal_tema_input" type="text" class="form-control" placeholder="Cuida la ortografía al escribir el tema">
									</div>
								</div>
								<div class="modal-footer">
									<div class="row text-center">
										<div class="col-xs-6">
											<button id="cancelarTema" type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Cancelar</button>
										</div>
										<div class="col-xs-6">
											<?php echo Html::anchor('javascript:agregarNuevoElementoEnLista(modal_tema_input,results_tema,pregunta_tema,cancelarTema);','Guardar Cambios', array('class' => 'btn btn-primary btn-block')); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="modal fade" id="modalAgregarBibliografia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<h4 class="modal-title" id="myModalLabel">Agregar nueva bibliografía</h4>
							</div>

							<div class="form-group">
								<div class="modal-body">
									<div class="input-group">
										<?php echo Form::label('Será redirigido a la pestaña de creación de biografía y se perderán los datos de esta pantalla. ¿Está seguro de querer continuar?', 'modal_tema_input');?>
									</div>
								</div>
								<div class="modal-footer">
									<div class="row text-center">
										<div class="col-xs-6">
											<button id="cancelarBibliografia" type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Cancelar</button>
										</div>
										<div class="col-xs-6">
											<?php echo Html::anchor('javascript:cambiarPestania(pestanias, bibliografia);cancelarBibliografia.click();','Ir a bibliografías', array('class' => 'btn btn-primary btn-block')); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="modal fade" id="modalActualizarPreguntaCompartida" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<h4 class="modal-title" id="myModalLabel">Actualizando pregunta compartida</h4>
							</div>

							<div class="form-group">
								<div class="modal-body">
									Al actualizar la pregunta, se actualizará su versión en linea y quienes tengan esta pregunta en sus repositorios recibirán una invitación para actualizarla localmente.
									<br>
									Revisa bien los cambios, ya que no podrás modificar la pregunta de nuevo sino hasta en 10 días.
								</div>
								<div class="modal-footer">
									<div class="row text-center">
										<div class="col-xs-6">
											<button id="cancelarActualizacionPregunta" type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Cancelar</button>
										</div>
										<div class="col-xs-6">
											<?php echo Html::anchor('javascript:submitPregunta();','Guardar Cambios', array('class' => 'btn btn-primary btn-block')); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- /Modales -->

				<!-- /Contenido -->
			</div>
		</div>
	</div>
</section>

<script type="text/javascript">
	let types =
	<?php
		echo "{";
		$length = sizeof($lista_de_tipos_min_max_resp);
		for ($i = 0; $i < $length; $i++) {
			$type =$lista_de_tipos_min_max_resp[$i];
			echo "'".$type[0]."'";
			echo " : ";
			echo "[";
			echo "'".$type[1]."',";
			echo "'".$type[2]."'";
			echo "]";
			echo ",";
		}
		echo "}";
	?>;
	<?php
	if(isset($idExamen)){
		?>
			let botonModalExamen = document.createElement('button');
			botonModalExamen.setAttribute('data-toggle','modal');
			botonModalExamen.setAttribute('data-target','#modalExamen');
			botonModalExamen.style.visibility = "hidden";
			let padre = document.getElementById('botonModal');
			padre.appendChild(botonModalExamen);
			setTimeout(function(){
				botonModalExamen.click();
				padre.removeChild(botonModalExamen);
				let input_oculto = document.getElementById('examen_temas_modal');
				input_oculto.click();
			},100);

		<?php
	}
	?>
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
	<?php
	if(isset($idFuente)){
		?>
			let botonModalBibliografia = document.createElement('button');
			botonModalBibliografia.setAttribute('data-toggle','modal');
			botonModalBibliografia.setAttribute('data-target','#modalBibliografia');
			botonModalBibliografia.style.visibility = "hidden";
			let padre = document.getElementById('botonModal');
			padre.appendChild(botonModalBibliografia);
			setTimeout(function(){
				botonModalBibliografia.click();
				padre.removeChild(botonModalBibliografia);
			},100);

		<?php
	}
	?>
</script>
