<section class="session">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 text-center">
				<!-- Contenido -->
				
				<div class="materia">Lista de Cursos</div>
				<br>
				<div class="row">
					<div class="col-xs-2"><h4>Clave</h4></div>
					<div class="col-xs-7"><h4>Curso</h4></div>
					<div class="col-xs-3"><h4>Estado</h4></div>
				</div>
				<br>
				<!-- Lista de Cursos -->
				<div class="row">
				<?php
					if(isset($cursos)){
						$notificacion = "";
						$fila="";
						$tiene_examenes = False;
						foreach ($cursos as $curso) {
							if($curso['estado']=='a'){
								$tiene_examenes = intval($curso['examenes_totales']) - intval($curso['examenes_pasados']) - intval($curso['examenes_terminados']) != 0;
								if($tiene_examenes){
									$notificacion = "<div class='secondary'><i class='fa fa-exclamation-circle'></i> <i class='fa fa-file-text-o'></i></div>";
								}else{
									$notificacion = "<i class='fa fa-check'></i>";
								}
								$fila = "<div class='renglon casilla'>".
									"<div class='row'>".
									"<div class='col-xs-2'><u>".
									$curso['clave'].
									"</u></div>".
									"<div class='col-xs-7'><u>".
									$curso['nombre'].
									"</u></div>".
									"<div class='col-xs-3'><u>".
									$notificacion.
									"</u></div>".
									"</div>".
									"</div>";
							}elseif ($curso['estado']=='e') {
								$fila = "<div class='renglon casilla esperando'>".
									"<div class='row'>".
									"<div class='col-xs-2'>".
									$curso['clave'].
									"</div>".
									"<div class='col-xs-7'>".
									$curso['nombre'].
									"</div>".
									"<div class='col-xs-3'>".
									"En espera.".
									"</div>".
									"</div>".
									"</div>";
							}else{
								$fila = "<div class='renglon casilla rechazado'>".
									"<div class='row'>".
									"<div class='col-xs-2'>".
									$curso['clave'].
									"</div>".
									"<div class='col-xs-7'>".
									$curso['nombre'].
									"</div>".
									"<div class='col-xs-3'>".
									"Rechazado.".
									"</div>".
									"</div>".
									"</div>";
							}
							echo Html::anchor('curso?id='.$curso['curso_id'].'&date='.time(), $fila);
							
						}
					}
				?>
				</div>
				<!-- /Lista de Cursos -->

				<!-- Solicitar nuevo curso -->
				<br>
				<div class="row">
				<hr>
					<button id="mostrarSolicitar" class="btn-primary btn-block" onclick="mostrarFormulario('mostrarSolicitar','agregarCurso','+ Solicitar nuevo curso','- Cancelar solicitud del curso')">+ Solicitar nuevo curso</button> 
				</div>
				<br>
				<div id="agregarCurso" class="row" style="display: none;">
					<?php echo Form::open(array('action' => 'sesion/solicitar_curso', 'accept-charset' => 'utf-8', 'method' => 'post', 'onsubmit' => 'javascript:{return es_valido_formulario_solicitar_curso()}'));?>
					<div class="form-group">
						<div class="col-xs-12 col-sm-1">
							<?php echo Form::label('Curso', 'clave_curso');?>
						</div>
						<div class="col-xs-12 col-sm-9">
							<?php echo Form::input('clave_curso','',array('class'=>'form-control','type' => 'text', 'placeholder'=>'Clave del curso'));?>
						</div>
						<br>
						<div class="col-xs-12 col-sm-2">
							<?php echo Form::button('boton_agregar_curso', '+ Solicitar', array('class' => 'btn btn-primary btn-block'));?>
						</div>
					</div>
					<?php echo Form::close();?>
				</div>
				<!-- /Solicitar nuevo curso -->
				<!-- /Contenido -->
			</div>
		</div>
	</div>
</section>