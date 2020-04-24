<section class="session">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 text-center">
				<!-- Contenido -->
				<!-- Barra -->
				<div class="row">
						<div class="col-xs-2 materia">
							<?php echo Html::anchor('sesion/profesor','<i class="fa fa-arrow-left"></i>', array('class' => 'btn btn-primary btn-block btn-lg')); ?>
						</div>
						<div class="col-xs-2">
						</div>
						<div class="col-xs-4 materia">
								<!-- <?php echo $curso->nombre;?> -->
							<?php echo Form::button('modificar_curso', '<i class="fa fa-pencil"></i>'.' '.$curso->nombre, array('class' => 'btn btn-primary btn-block btn-lg btn-materia', 'type' => 'button', 'data-toggle' => 'modal', 'data-target' => '#modalModificarCurso'));?>
						</div>
				</div>
				<!-- /Barra -->

				<hr>
				<div class="row table">
					<div class="col-xs-12 col-md-6 table-row">
						<div class="col-xs-6 table-row">
							<div class="col-md-12">
								<h4>Inicio</h4>
							</div>
							<div class="col-md-12">
								<?php echo Form::input('curso_inicio',substr($curso->fecha_inicio, 0, 10),array('class'=>'form-control', 'disabled' => 'true','type' => 'date', 'placeholder'=>'DD/MM/AAAA')); ?>
							</div>
						</div>

						<div class="col-xs-6 table-row">
							<div class="col-md-12">
								<h4>Fin</h4>
							</div>
							<div class="col-md-12">
								<?php echo Form::input('curso_final',substr($curso->fecha_fin, 0, 10),array('class'=>'form-control', 'disabled' => 'true','type' => 'date', 'placeholder'=>'DD/MM/AAAA')); ?>
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-md-6 table-row">
						<div class="col-md-12">
							<h4>
							<?php
								$texto_activo = $curso->activo === '1' ? 'Curso Vigente' : 'Curso dado de Baja';
								echo $texto_activo;
							?>
							</h4>
						</div>
						<div class="col-md-12">
							<?php
								$texto = $curso->activo === '1' ? '<i class="fa fa-times-circle"></i>'.' Dar de baja' : '<i class="fa fa-check-circle"></i>'.' Dar de alta';
								$tipo = $curso->activo === '1' ? 'btn-danger' : 'btn-info';
								echo Form::button('alta_baja', $texto, array('class' => 'btn '.$tipo.' btn-block btn-lg', 'type' => 'button', 'data-toggle' => 'modal', 'data-target' => '#modalDarDeAltaBaja'));
							?>
						</div>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-xs-4">
						<?php echo Html::anchor('curso/examenes','<i class="fa fa-file-text-o"></i> <br> Exámenes',array('class'=>'btn btn-primary btn-block btn-lg')) ;?>
					</div>
					<div class="col-xs-4">
						<?php echo Html::anchor('curso/estadisticas','<i class="fa fa-bar-chart"></i> <br> Estadísticas',array('class'=>'btn btn-primary btn-block btn-lg')) ;?>
					</div>
					<div class="col-xs-4">
						<?php echo Html::anchor('curso/alumnos','<i class="fa fa-users"></i> <br> Alumnos',array('class'=>'btn btn-primary btn-block btn-lg')) ;?>
					</div>
				</div>
				<br>
				<?php
					if($curso->activo === '1'){
						echo "<h4>Solicitudes al curso</h4>";
						$contador = 0;
						if (isset($alumnos)) {
							foreach ($alumnos as $alumno) {
								echo "<div class='row'>";
								if($alumno->estado=='e'){
									echo "<div class='col-xs-12 col-sm-6 col-md-4 col-lg-3'>";
									$ruta_foto = "assets/img/usuarios/a/".$alumno->n_cuenta;
									$foto_a = Uri::base(false).$ruta_foto;
									$existe = File::exists(DOCROOT.$ruta_foto);
									if (!$existe) {
										$foto_a = Uri::base(false)."assets/img/usuarios/default.png";
									}

									echo "<div class='col-xs-6'>";
									echo "<div class='foto solicitud' style='background-image: url(".$foto_a.")'></div>";
									echo $alumno->nombres." ";
									echo $alumno->apellidos." ";

									echo "</div>";
									echo Form::open(array('action' => 'curso/responder', 'method' => 'post'));
									echo Form::hidden('n_cuenta',$alumno->n_cuenta);
									echo "<div class='col-xs-6'>";
									echo Form::button('aceptar', 'Aceptar', array('class' => 'btn btn-primary btn-block acepta_rechaza', 'value' => '1'));
									echo Form::button('rechazar', 'Rechazar', array('class' => 'btn btn-danger btn-block acepta_rechaza', 'value' => '1'));
									echo "</div>";
									echo Form::close();
									echo "<br>";
									$contador = $contador+1;
									echo "<div>";
								}
								echo "<div>";
							}
						}
						if ($contador==0) {
							echo "<p>-*- Ninguna solicitud pendiente -*-</p>";
						}
					}else{
						echo "<h4>Solicitudes inactivas</h4>";
						if($hay_informacion_por_borrar){//Hay información por borrar
								echo "Curso dado de baja. Te restan 30 días para consultar e imprimir la información.";
								echo Form::button('alta_baja', "Borrar todo", array('class' => 'btn btn-danger btn-block btn-lg', 'type' => 'button', 'data-toggle' => 'modal', 'data-target' => '#modalBorrarInformacionCurso'));
						}else{
							echo "Necesitas dar de alta el curso, agregando primero una nueva clave que corresponda con la clave del curso del nuevo periodo.";
						}
					}

				?>


				<!-- /Contenido -->

				<!-- Modales -->
				<?php
				if($curso->activo){
				?>
					<div class="modal fade" id="modalModificarCurso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
								<h4 class="modal-title" id="myModalLabel">Modificar curso</h4>
								</div>
								<?php
									echo Form::open('curso/modificar_curso');
								?>
									<div class="form-group">
										<div class="modal-body">
											<?php
												echo '<div id="agregarCurso" class="row table">
														<div class="col-xs-12 table-row">'.
															Form::label('Nombre', 'nombre_curso_modificado').'
														</div>
														<div class="col-xs-12 table-row">'.
															Form::input('nombre_curso_modificado',$curso->nombre,array('class'=>'form-control','type' => 'text', 'placeholder'=>'Nuevo nombre')).'
														</div>
														<div class="col-xs-12 table-row">'.
															Form::label('Clave', 'clave_curso_modificado').'
														</div>
														<div class="col-xs-12 table-row">'.
															Form::input('clave_curso_modificado',$curso->clave,array('class'=>'form-control','type' => 'text', 'placeholder'=>'Nueva clave')).'
														</div>
														<div class="col-xs-12 table-row">'.
															Form::label('Inicio de curso', 'inicio_curso_modificado').'
														</div>
														<div class="col-xs-12 table-row">'.
															Form::input('inicio_curso_modificado',substr($curso->fecha_inicio, 0, 10),array('class'=>'form-control','type' => 'date', 'placeholder'=>'DD/MM/AAAA')).'
														</div>
														<div class="col-xs-12 table-row">'.
															Form::label('Fin de curso', 'fin_curso_modificado').'
														</div>
														<div class="col-xs-12 table-row">'.
															Form::input('fin_curso_modificado',substr($curso->fecha_fin, 0, 10),array('class'=>'form-control','type' => 'date', 'placeholder'=>'DD/MM/AAAA')).'
														</div>
													</div>';
											?>
										</div>
										<div class="modal-footer">
											<div class="row text-center">
												<div class="col-xs-6">
													<button id="cancelarActualizacionPregunta" type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Cancelar</button>
												</div>
												<div class="col-xs-6">
													<?php
														echo Form::button('boton_agregar_curso', 'Guardar cambios', array('class' => 'btn btn-primary btn-block'));
													?>
												</div>
											</div>
										</div>
									</div>
								<?php
									echo Form::close();
								?>
							</div>
						</div>
					</div>
				<?php
				}
				?>

				<div class="modal fade" id="modalDarDeAltaBaja" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<h4 class="modal-title" id="myModalLabel">Vigencia del curso</h4>
							</div>
							<?php
								if(!$curso->activo && !$hay_informacion_por_borrar){
									echo Form::open('curso/reestablecer_curso');
								}
							?>
							<div class="form-group">
								<div class="modal-body">
									<?php
										$texto_modal_baja = "El curso será dado de baja. 
											<br>
											El sistema guardará la información del curso por un mes más, después de darlo de baja. 
											<br>
											Si antes del mes se da de alta, toda la configuración se mantendrá normal, salvo que ya se haya borrado la información del curso pasado.";
										$texto_modal_alta = "El curso será dado de alta.
											<br>
											Si ya fue borrada la información del curso pasado, se activará el curso actualizando las fechas de inicio y fin a partir del día de hoy. En caso contrario, se activa con la información antigua.";
										$texto_modal_alta_nueva = 'Tu curso se reiniciará
											<br>
											Para dar de alta el curso se requiere que escribas una nueva clave, que esté relacionada con la clave de la materia de la institución, con el año en curso y que de preferencia sea diferente a la anterior.
											<br>
											Clave anterior: '.$curso->clave.'
											<br>
											<br>
											<div id="agregarCurso" class="row">
												<div class="col-xs-12">'.
													Form::label('Nueva clave del curso', 'clave_curso').'
												</div>
												<div class="col-xs-12">'.
													Form::input('clave_curso','',array('class'=>'form-control','type' => 'text', 'placeholder'=>'Nueva clave')).'
												</div>
											</div>';
										$texto_modal = $curso->activo === '1' ? $texto_modal_baja : $texto_modal_alta;
										if(!$curso->activo && !$hay_informacion_por_borrar){
											$texto_modal = $texto_modal_alta_nueva;
										}
										echo $texto_modal;
									?>
								</div>
								<div class="modal-footer">
									<div class="row text-center">
										<div class="col-xs-6">
											<button id="cancelarActualizacionPregunta" type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Cancelar</button>
										</div>
										<div class="col-xs-6">
											<?php 
												if(!$curso->activo && !$hay_informacion_por_borrar){
													echo Form::button('boton_agregar_curso', 'Agregar nueva clave', array('class' => 'btn btn-primary btn-block'));
												}else{
													echo Html::anchor('curso/alta_baja', $texto, array('class' => 'btn '.$tipo.' btn-block btn-lg'));	
												}
											?>
										</div>
									</div>
								</div>
							</div>
							<?php 
								if(!$curso->activo && !$hay_informacion_por_borrar){
									echo Form::close();
								}
							?>
						</div>
					</div>
				</div>

				<div class="modal fade" id="modalBorrarInformacionCurso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<h4 class="modal-title" id="myModalLabel">Borrado de información</h4>
							</div>

							<div class="form-group">
								<div class="modal-body">
									<?php
										echo "¿Estás seguro que deseas  borrar toda la información del curso pasado? Esta acción no se puede revertir.";
									?>
								</div>
								<div class="modal-footer">
									<div class="row text-center">
										<div class="col-xs-6">
											<button id="cancelarActualizacionPregunta" type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Cancelar</button>
										</div>
										<div class="col-xs-6">
											<?php echo Html::anchor('curso/borrar_informacion', "Borrar todo", array('class' => 'btn btn-danger btn-block btn-lg')); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- /Modales -->

			</div>
		</div>
	</div>
</section>
<!-- Mensaje -->
	<div class="container">
		<div class="row">
			<div class="col-lg-12 text-center">
			  <?php	   
				$usuario = SESSION::get('usuario');
				$mensaje = SESSION::get('mensaje');
				  if(isset($mensaje)){
					  echo "<div class='alert alert-warning alert-dismissible fade in' style='z-index: 100;'>";
					  echo $mensaje;
					  echo "</div>";
					  SESSION::delete('mensaje');
				  }
			  ?> 
			</div>
		</div>
	</div>
<!-- /Mensaje -->