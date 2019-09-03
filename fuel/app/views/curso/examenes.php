<section class="session">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 text-center">
				<!-- Contenido -->

				<!-- SESSION -->
				<?php
					$pestania = SESSION::get('pestania');
					$data = SESSION::get('data');
					if(isset($pestania)){
						SESSION::delete('pestania');
					}
					if(isset($data)){
						SESSION::delete('data');
					}
				?>
				<!-- /SESSION -->

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
										echo '<a href="examen/editar?id_examen='.$examen->id_examen.'">';
										echo '<div class="row">';
											echo '<div class="col-xs-6">';
												echo $examen->nombre;
												echo '<br>Inicio: '.$examen->fecha_inicio;
												echo '<br>Final: '.$examen->fecha_fin;
											echo '</div>';
											echo '<div class="col-xs-6">';
												echo 'Temas: ';
												if(isset($temas)){
													$es_primero = True;
													foreach ($temas as $tema) {
														if($tema->id_examen==$examen->id_examen){
															if($es_primero){
																echo $tema->nombre;
																$es_primero=False;
															}else{
																echo ", ".$tema->nombre;
															}
														}
													}
												}else{
													echo 'Sin fijar';
												}
											echo '</div>';
										echo '</div>';
										echo '</a>';
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
										<?php echo Form::open('curso/crear_examen');?>
										<div class="form-group">
											<div class="col-xs-12 col-sm-3">
												<?php echo Form::label('Nombre del examen', 'nombre_examen');?>
											</div>
											<div class="col-xs-12 col-sm-7">
												<?php echo Form::input('nombre_examen','',array('class'=>'form-control','type' => 'text', 'placeholder'=>'Nombre del examen'));?>
											</div>
											<div class="col-xs-12 col-sm-2">
												<?php echo Form::button('boton_agregar_curso', '+ Agregar', array('class' => 'btn btn-primary btn-block'));?>
											</div>
										</div>
										<?php echo Form::close();?>
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
									echo $fuente->nombre." - ".$fuente->autores.". Edición: ".$fuente->numero;
									// echo '<div class="col-xs-12 col-md-6 col-lg-4 examen">';
									// 	echo '<a href="examen/editar?id_examen='.$examen->id_examen.'">';
									// 	echo '<div class="row">';
									// 		echo '<div class="col-xs-6">';
									// 			echo $examen->nombre;
									// 			echo '<br>Inicio: '.$examen->fecha_inicio;
									// 			echo '<br>Final: '.$examen->fecha_fin;
									// 		echo '</div>';
									// 		echo '<div class="col-xs-6">';
									// 			echo 'Temas: ';
									// 			if(isset($temas)){
									// 				$es_primero = True;
									// 				foreach ($temas as $tema) {
									// 					if($tema->id_examen==$examen->id_examen){
									// 						if($es_primero){
									// 							echo $tema->nombre;
									// 							$es_primero=False;
									// 						}else{
									// 							echo ", ".$tema->nombre;
									// 						}
									// 					}
									// 				}
									// 			}else{
									// 				echo 'Sin fijar';
									// 			}
									// 		echo '</div>';
									// 	echo '</div>';
									// 	echo '</a>';
									// echo '</div>';
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
							<?php echo Form::open('curso/examen/crear_bibliografia');?>
							<div class="form-group">
								<div class="col-xs-12 col-sm-12">
									<?php echo Form::label('Nombre', 'nombre_bibliografia');?>
								</div>
								<div class="col-xs-12 col-sm-12">
									<?php echo Form::input('nombre_bibliografia','',array('class'=>'form-control','type' => 'text', 'placeholder'=>'Nombre de la fuente'));?>
								</div>
								<div class="col-xs-12 col-sm-12">
									<?php echo Form::label('Autor(es)', 'autor_bibliografia');?>
								</div>
								<div class="col-xs-12 col-sm-12">
									<?php echo Form::input('autor_bibliografia','',array('class'=>'form-control','type' => 'text', 'placeholder'=>'Nombre de los autores'));?>
								</div>
								<div class="col-xs-12 col-sm-12">
									<?php echo Form::label('Edición', 'edicion_bibliografia');?>
								</div>
								<div class="col-xs-12 col-sm-12 table">
									<div class="col-xs-4 col-sm-4 table-row">
										<div class="col-xs-12 col-sm-12">
											<?php echo Form::label('#', 'numero_edicion_bibliografia');?>
										</div>
										<div class="col-xs-12 col-sm-12">
											<?php echo Form::input('numero_edicion_bibliografia','',array('class'=>'form-control','type' => 'text', 'placeholder'=>'Número'));?>
										</div>
									</div>
									<div class="col-xs-8 col-sm-8 table-row">
										<div class="col-xs-12 col-sm-12">
											<?php echo Form::label('Año', 'anio_bibliografia');?>
										</div>
										<div class="col-xs-12 col-sm-12">
											<?php echo Form::input('anio_bibliografia','',array('class'=>'form-control','type' => 'text', 'placeholder'=>'Año'));?>
										</div>
									</div>
								</div>
								<div class="col-xs-12 col-sm-12">
									<?php echo Form::label('Enlace en línea (si existe)', 'link_bibliografia');?>
								</div>
								<div class="col-xs-12 col-sm-12">
									<?php echo Form::input('link_bibliografia','',array('class'=>'form-control','type' => 'text', 'placeholder'=>'Enlace o link a la fuente'));?>
								</div>
								<br>
								<div class="col-xs-12 col-sm-12">
									<?php echo Form::button('boton_agregar_bibliografia', '+ Agregar', array('class' => 'btn btn-primary btn-block'));?>
								</div>
							</div>
							<?php echo Form::close();?>
						</div>
						<!-- /Seccion agregar bibliografia -->
					</div>
					<!-- /Bibliografia -->

					<!-- Preguntas -->
					<div id="area_preguntas" class="area<?php echo $pestania == 'preguntas' ? " expuesto": " oculto"; ?>">
						<!-- Lista Bibliografias -->
						<?php
							$cual_boton = "preguntas";
							if(isset($preguntas)){//TODO_ISAEL Cambiar por lista de preguntas
								echo '<div class="row">';
								foreach ($examenes as $examen) {
									
									echo '<div class="col-xs-12 col-md-6 col-lg-4 examen">';
										echo '<a href="examen/editar?id_examen='.$examen->id_examen.'">';
										echo '<div class="row">';
											echo '<div class="col-xs-6">';
												echo $examen->nombre;
												echo '<br>Inicio: '.$examen->fecha_inicio;
												echo '<br>Final: '.$examen->fecha_fin;
											echo '</div>';
											echo '<div class="col-xs-6">';
												echo 'Temas: ';
												if(isset($temas)){
													$es_primero = True;
													foreach ($temas as $tema) {
														if($tema->id_examen==$examen->id_examen){
															if($es_primero){
																echo $tema->nombre;
																$es_primero=False;
															}else{
																echo ", ".$tema->nombre;
															}
														}
													}
												}else{
													echo 'Sin fijar';
												}
											echo '</div>';
										echo '</div>';
										echo '</a>';
									echo '</div>';
								}
								echo '</div>';
							}else{
								//Verificar si hay preguntas
								if(isset($bibliografias)){									
									echo "Las preguntas se separan por temas";
								}else{
									$cual_boton = "bibliografia";
									echo "Para crear preguntas debe existir bibliografía";
								}
							}
						?>
						<!-- /Lista Bibliografias -->
						<br>
						<!-- Seccion agregar pregunta -->
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
										<?php echo Form::open('curso/examen/crear_pregunta');?>
										<div class="form-group">
											<div class="col-xs-12 col-sm-12">
												<?php echo Form::label('Tema', 'pregunta_tema');?>
											</div>
											<div class="col-xs-12 col-sm-12 table">
												<?php
													$boton_agregar_tema = array("href" => "", "value" => "+ Agregar nuevo tema", "data-toggle" => "modal", "data-target" => "#modalAgregarTema");
													$lista_de_temas = [];
													if(isset($temas)){
														foreach ($temas as $tema) {
															array_push($lista_de_temas, array($tema->id_tema, $tema->nombre));
														}
													}
													echo Special_Selector::createSpecialSelector("pregunta_tema", "results_tema", $lista_de_temas,"Selecciona o crea un tema" , $boton_agregar_tema);
												?>
											</div>
											<div class="col-xs-12 col-sm-12">
												<?php echo Form::label('Bibliografía', 'pregunta_bibliografia');?>
											</div>
											<div class="col-xs-12 col-sm-12">
												<?php
													$boton_agregar_bibliografia = array("href" => "", "value" => "+ Agregar nueva bibliografía", "data-toggle" => "modal", "data-target" => "#modalAgregarBibliografia");
													$lista_de_fuentes = [];
													if(isset($bibliografias)){
														foreach ($bibliografias as $fuente) {
															array_push($lista_de_fuentes, array($fuente->id_fuente, $fuente->nombre." - ".$fuente->autores.". Edición: ".$fuente->numero));
														}
													}
													echo Special_Selector::createSpecialSelector("pregunta_bibliografia", "results_fuente", $lista_de_fuentes,"Selecciona una fuente" , $boton_agregar_bibliografia);
												?>
											</div>
											<div class="col-xs-12 col-sm-12 table">
												<div class="col-xs-4 col-sm-4 table-row">
													<div class="col-xs-12 col-sm-12">
														<?php echo Form::label('Página', 'pregunta_bibliografia_pagina');?>
													</div>
													<div class="col-xs-12 col-sm-12">
														<?php echo Form::input('pregunta_bibliografia_pagina','',array('class'=>'form-control','type' => 'text', 'placeholder'=>'Página'));?>
													</div>
												</div>
												<div class="col-xs-8 col-sm-8 table-row">
													<div class="col-xs-12 col-sm-12">
														<?php echo Form::label('Capítulo', 'pregunta_bibliografia_capitulo');?>
													</div>
													<div class="col-xs-12 col-sm-12">
														<?php echo Form::input('pregunta_bibliografia_capitulo','',array('class'=>'form-control','type' => 'text', 'placeholder'=>'Capítulo'));?>
													</div>
												</div>
											</div>

											<div class="col-xs-12 col-sm-12 table">
												<div class="col-xs-6 col-sm-6 table-row">
													<div>
														<?php echo Form::label('Dificultad', 'pregunta_dificultad');?>
													</div>
													<div>
														<?php 
															$dificultades = array(array(1,1),array(2,2),array(3,3));
															echo Special_Selector::createSpecialSelector("pregunta_dificultad", "results_dificultad", $dificultades,"...");
														?>
													</div>
												</div>
												<div class="col-xs-6 col-sm-6 table-row">
													<div class="col-xs-12 col-sm-12">
														<?php echo Form::label('Tiempo', 'pregunta_tiempo');?>
													</div>
													<div class="col-xs-12 col-sm-12">
														<?php echo Form::input('pregunta_tiempo','',array('class'=>'form-control','type' => 'text', 'placeholder'=>'segs'));?>
													</div>
												</div>
											</div>

											<div class="col-xs-12 col-sm-12">
												<?php
													$tipo = '1' // Este valor podría cambiar de acuerdo a las necesidades futuras de la aplicación e incluso podría ser opcional. Se dejará pendiente para una futura versión.
													echo Form::input("pregunta_tipo",$tipo, array('type' => 'hidden')); 
												?>
											</div>
											<div class="col-xs-12 col-sm-12">
												<?php
													$tiene_subpregunta = '0' // Este valor podría cambiar de acuerdo a las necesidades futuras de la aplicación e incluso podría ser opcional. Se dejará pendiente para una futura versión.
													echo Form::input("pregunta_tiene_subpregunta",$tiene_subpregunta, array('type' => 'hidden'));
												?>
											</div>

											<div class="col-xs-12 col-sm-12">
												<?php echo Form::label('Pregunta', 'pregunta_texto');?>
											</div>
											<div class="col-xs-12 col-sm-12">
												<?php echo Form::input('pregunta_texto','',array('class'=>'form-control','type' => 'text', 'placeholder'=>'Texto, URLVideo o URLImágen'));?>
											</div>

											<div class="col-xs-12 col-sm-12">
												<?php echo Form::label('Respuestas y porcentaje', '');?>
											</div>
											<?php 
												$numero_de_preguntas = 4; // Este valor podría cambiar de acuerdo a las necesidades futuras de la aplicación e incluso podría ser opcional. Se dejará pendiente para una futura versión.
												echo Form::input("pregunta_cantidad_respuestas",$numero_de_preguntas, array('type' => 'hidden'));
												for ($i=1; $i <= $numero_de_preguntas ; $i++) {
													?>
														<div class="col-xs-12 col-sm-12 table">
															<div class="col-xs-1 col-sm-1 table-row">
																<?php echo Form::label('R.'.$i, 'pregunta_respuesta_'.$i);?>
															</div>
															<div class="col-xs-8 col-sm-8 table-row">
																<?php echo Form::input('pregunta_respuesta_'.$i,'',array('class'=>'form-control','type' => 'text', 'placeholder'=>'Texto, URLVideo o URLImágen'));?>
															</div>
															<div class="col-xs-2 col-sm-2 table-row">
																<?php echo Form::input('pregunta_respuesta_porcentaje_'.$i,'',array('class'=>'form-control','type' => 'text', 'placeholder'=>'0'));?>
															</div>
															<div class="col-xs-1 col-sm-1 table-row">
																<?php echo Form::label('%', 'pregunta_respuesta_porcentaje_'.$i);?>
															</div>
														</div>
													<?php
												}
											?>
											

											<div class="col-xs-12 col-sm-12">
												<?php echo Form::label('Justificación', 'pregunta_justificacion');?>
											</div>
											<div class="col-xs-12 col-sm-12">
												<?php echo Form::input('pregunta_justificacion','',array('class'=>'form-control','type' => 'text', 'placeholder'=>'Justificación'));?>
											</div>
											<br>
											<div class="col-xs-12 col-sm-12">
												<?php echo Form::button('boton_agregar_bibliografia', '+ Agregar', array('class' => 'btn btn-primary btn-block'));?>
											</div>
										</div>
										<?php echo Form::close();?>
									</div>
									<br>
									<div class="row">
										<button id="mostrarCrearPreguntaCompartida" class="btn btn-primary btn-block btn-lg" onclick="mostrarFormulario('mostrarCrearPreguntaCompartida','agregarPreguntaCompartida','+ Agrega preguntas compartidas','- Cancelar preguntas compartidas')">+ Agrega preguntas compartidas</button>
									</div>
									<div id="agregarPreguntaCompartida" class="row" style="display: none;">
										<?php echo Form::open('curso/examen/crear_pregunta');?>
										<div class="form-group">
											<div class="col-xs-12 col-sm-12">
												<?php echo Form::label('Nombre', 'nombre_bibliografia');?>
											</div>
											<div class="col-xs-12 col-sm-12">
												<?php echo Form::input('nombre_bibliografia','',array('class'=>'form-control','type' => 'text', 'placeholder'=>'Nombre de la fuente'));?>
											</div>
											<div class="col-xs-12 col-sm-12">
												<?php echo Form::label('Autor(es)', 'autor_bibliografia');?>
											</div>
											<div class="col-xs-12 col-sm-12">
												<?php echo Form::input('autor_bibliografia','',array('class'=>'form-control','type' => 'text', 'placeholder'=>'Nombre de los autores'));?>
											</div>
											<div class="col-xs-12 col-sm-12">
												<?php echo Form::label('Edición', 'edicion_bibliografia');?>
											</div>
											<div class="col-xs-12 col-sm-12 table">
												<div class="col-xs-4 col-sm-4 table-row">
													<div class="col-xs-12 col-sm-12">
														<?php echo Form::label('#', 'numero_edicion_bibliografia');?>
													</div>
													<div class="col-xs-12 col-sm-12">
														<?php echo Form::input('numero_edicion_bibliografia','',array('class'=>'form-control','type' => 'text', 'placeholder'=>'Número'));?>
													</div>
												</div>
												<div class="col-xs-8 col-sm-8 table-row">
													<div class="col-xs-12 col-sm-12">
														<?php echo Form::label('Año', 'anio_bibliografia');?>
													</div>
													<div class="col-xs-12 col-sm-12">
														<?php echo Form::input('anio_bibliografia','',array('class'=>'form-control','type' => 'text', 'placeholder'=>'Año'));?>
													</div>
												</div>
											</div>
											<div class="col-xs-12 col-sm-12">
												<?php echo Form::label('Enlace en línea (si existe)', 'link_bibliografia');?>
											</div>
											<div class="col-xs-12 col-sm-12">
												<?php echo Form::input('link_bibliografia','',array('class'=>'form-control','type' => 'text', 'placeholder'=>'Enlace o link a la fuente'));?>
											</div>
											<br>
											<div class="col-xs-12 col-sm-12">
												<?php echo Form::button('boton_agregar_bibliografia', '+ Agregar', array('class' => 'btn btn-primary btn-block'));?>
											</div>
										</div>
										<?php echo Form::close();?>
									</div>

								<?php 
							}
							?>
						<!-- /Seccion agregar pregunta -->
					</div>
					<!-- /Preguntas -->
				</div>
				<!-- /Area de trabajo -->

				<!-- Modales -->
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

				<!-- /Modales -->
				
				<!-- /Contenido -->
			</div>
		</div>
	</div>
</section>
