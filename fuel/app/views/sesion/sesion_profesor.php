<section class="session">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 text-center">
				<!-- Contenido -->

				<div class="materia secondary">Lista de Cursos</div>
				<br>
				<div class="row">
					<div class="col-xs-2"><h4>Clave</h4></div>
					<div class="col-xs-7"><h4>Nombre</h4></div>
					<div class="col-xs-3"><h4>Alumnos</h4></div>
				</div>
				<br>
				<!-- Lista de Cursos -->

				<?php
					if(isset($cursos)){
						foreach ($cursos as $curso) {
							if($curso['esperando'] === '0'){
								$alumnos="<span>".
									$curso['aceptados'].
									"<span>";
							}else{
								$alumnos="<span class='text-danger'>".
									$curso['aceptados'].
									"+".$curso['esperando'].
									"</span>";
							}
							echo Html::anchor('curso?id='.$curso['id_curso'].'&date='.time(), "<div class='renglon casilla'>".
								"<div class='row'>".
									"<div class='col-xs-2'><span>".
									$curso['clave'].
									"</span></div>".
									"<div class='col-xs-7 overflow'><span>".
									$curso['nombre'].
									"</span></div>".
									"<div class='col-xs-3'>".
									$alumnos.
									"</div>".
								"</div>".
							"</div>");
						}
					}
				?>
				<!-- /Lista de Cursos -->

				<!-- Agregar nuevo curso -->
				<br>
				<div class="row">
				<hr>
					<button id="mostrarCrear" class="btn btn-primary btn-block btn-lg" onclick="mostrarFormulario('mostrarCrear','agregarCurso','+ Creación de nuevo examen','- Cancelar creación de curso')">+ Creación de nuevo curso</button>
				</div>
				<br>
				<div id="agregarCurso" class="row" style="display: none;">
					<?php echo Form::open(array('action' => 'sesion/agregar_curso', 'accept-charset' => 'utf-8', 'method' => 'post', 'onsubmit' => 'javascript:{return es_valido_formulario_agregar_curso()}'));?>

					<div class="form-group">
						<div class="table">
							<div class="col-xs-12 col-sm-1 table-row">
								<?php echo Form::label('Clave', 'clave_curso');?>
							</div>
							<div class="col-xs-12 col-sm-2 table-row">
								<?php echo Form::input('clave_curso','',array('class'=>'form-control','type' => 'text', 'placeholder'=>'Clave del curso'));?>
							</div>
							<div class="col-xs-12 col-sm-2 table-row">
								<?php echo Form::label('Nombre', 'nombre_curso');?>
							</div>
							<div class="col-xs-12 col-sm-5 table-row">
								<?php echo Form::input('nombre_curso','',array('class'=>'form-control','type' => 'text', 'placeholder'=>'Nombre del nuevo curso'));?>
							</div>
							<br>
							<div class="col-xs-12 col-sm-2">
								<?php echo Form::button('boton_agregar_curso', '+ Agregar', array('class' => 'btn btn-primary btn-block'));?>
							</div>
						</div>
					</div>
					<?php echo Form::close();?>
				</div>
				<!-- /Agregar nuevo curso -->
				<!-- /Contenido -->
			</div>
		</div>
	</div>
</section>