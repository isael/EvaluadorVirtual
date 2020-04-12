<section class="session">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 text-center">
				<!-- Contenido -->
				
				<div class="materia">Lista de Cursos</div>
				<div class="row">
					<div class="col-xs-2"><h4>Clave</h4></div>
					<div class="col-xs-7"><h4>Curso</h4></div>
					<div class="col-xs-3"><h4>Avisos</h4></div>
				</div>
				<br>
				<!-- Lista de Cursos -->
				<div class="row">
				<?php
					if(isset($cursos)){
						foreach ($cursos as $curso) {
							if($curso->estado=='a'){
								echo "<div class='renglon'>";
								echo "<div class='row'>";
								echo "<div class='col-xs-2'><u>";
								echo Html::anchor('curso?id='.$curso->id_curso, $curso->clave);
								echo "</u></div>";
								echo "<div class='col-xs-7'><u>";
								echo Html::anchor('curso?id='.$curso->id_curso, $curso->nombre);
								echo "</u></div>";
								echo "<div class='col-xs-3'><u>";
								echo Html::anchor('curso?id='.$curso->id_curso, $curso->estado);
								echo "</u></div>";
								echo "</div>";
								echo "</div>";
							}elseif ($curso->estado=='e') {
								echo "<div class='renglon esperando'>";
								echo "<div class='row'>";
								echo "<div class='col-xs-2'>";
								echo $curso->clave;
								echo "</div>";
								echo "<div class='col-xs-7'>";
								echo $curso->nombre;
								echo "</div>";
								echo "<div class='col-xs-3'>";
								echo "En espera.";
								echo "</div>";
								echo "</div>";
								echo "</div>";
							}else{
								echo "<div class='renglon rechazado'>";
								echo "<div class='row'>";
								echo "<div class='col-xs-2'>";
								echo $curso->clave;
								echo "</div>";
								echo "<div class='col-xs-7'>";
								echo $curso->nombre;
								echo "</div>";
								echo "<div class='col-xs-3'>";
								echo "Rechazado.";
								echo "</div>";
								echo "</div>";
								echo "</div>";
							}
							
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
					<?php echo Form::open('sesion/solicitar_curso');?>
					<div class="form-group">
						<div class="col-xs-12 col-sm-1">
							<?php echo Form::label('Curso', 'clave_curso');?>
						</div>
						<div class="col-xs-12 col-sm-9">
							<?php echo Form::input('clave_curso','',array('class'=>'form-control','type' => 'text', 'placeholder'=>'Clave del curso'));?>
							<br>
						</div>
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