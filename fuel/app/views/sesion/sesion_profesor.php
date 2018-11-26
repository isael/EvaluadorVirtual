<section class="session">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
			    <!-- Contenido -->
			    
			    <div class="materia">Lista de Cursos</div>
			    <div class="row">
			    	<div class="col-xs-1"><h4>Clave</h4></div>
				    <div class="col-xs-8"><h4>Curso</h4></div>
				    <div class="col-xs-3"><h4>Avisos</h4></div>
			    </div>
			    <br>
			    <!-- Lista de Cursos -->
			    
			    <?php
			    	if(isset($cursos)){
				    	foreach ($cursos as $curso) {
				    		echo "<div class='renglon'>";
				    		echo "<div class='row'>";
				    		echo "<div class='col-xs-1'><u>";
				    		echo Html::anchor('curso?id='.$curso->id_curso, $curso->clave);
				    		echo "</u></div>";
				    		echo "<div class='col-xs-8'><u>";
				    		echo Html::anchor('curso?id='.$curso->id_curso, $curso->nombre);
				    		echo "</u></div>";
				    		echo "<div class='col-xs-3'><u>";
				    		echo Html::anchor('curso?id='.$curso->id_curso, "0");
				    		echo "</u></div>";
				    		echo "</div>";
				    		echo "</div>";
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
				    <?php echo Form::open('sesion/agregar_curso');?>
				    <div class="form-group">
				    	<div class="col-xs-12 col-sm-1">
				    		<?php echo Form::label('Clave', 'clave_curso');?>
				    	</div>
				    	<div class="col-xs-12 col-sm-2">
				    		<?php echo Form::input('clave_curso','',array('class'=>'form-control','type' => 'text', 'placeholder'=>'Clave del curso'));?>
				    	</div>
				    	<div class="col-xs-12 col-sm-2">
				    		<?php echo Form::label('Nombre', 'nombre_curso');?>
				    	</div>
					    <div class="col-xs-12 col-sm-5">
					    	<?php echo Form::input('nombre_curso','',array('class'=>'form-control','type' => 'text', 'placeholder'=>'Nombre del nuevo curso'));?>
					    	<br>
					    </div>
					    <div class="col-xs-12 col-sm-2">
					    	<?php echo Form::button('boton_agregar_curso', '+ Agregar', array('class' => 'btn btn-primary btn-block'));?>
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