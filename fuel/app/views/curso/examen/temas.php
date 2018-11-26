<section class="session">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
			    <!-- Contenido -->
			    <!-- Barra -->
			    <div class="row">
			    	<div class="col-xs-2">
			    		<?php echo Html::anchor('curso/examen/editar?id_examen='.$examen->id_examen
,'<i class="fa fa-chevron-circle-left"></i>', array('class' => 'btn btn-primary btn-block btn-lg')); ?>	

			    	</div>
			    	<div class="col-xs-8 materia materia_peque">
			    		<?php echo $curso->nombre;?>		
			    	</div>
			    	<div class="col-xs-2">
			    		<i i class="fa fa-file-text-o fav_icon"></i>
			    	</div>
			    </div>
			    <hr>
			    <!-- /Barra -->
			    <!-- Temas -->
			    <div class="materia materia_peque">
		    		<?php echo $examen->nombre."/Temas"; ?>		
		    	</div>
			    <div class="row">
			    	<?php
			    		if (isset($temas)) {
				    		foreach ($temas as $tema) {
				    			echo '<div class="col-xs-12 col-sm-6 col-md-4">';
						    		echo $tema->nombre;
						    	echo '</div>	';
				    		}
			    		}
			    		
			    	?>
			    	
			    </div>
			    <?php //echo Html::anchor('curso/examen/crear_tema?id_examen='.$examen->id_examen,'+ Crear Tema',array('class' => 'btn btn-primary btn-lg btn-block')); ?>
			    <!-- /Temas -->
			    <!-- Seccion agregar -->
		    		<div class="row">
				    	<button id="mostrarCrearTema" class="btn btn-primary btn-block btn-lg" onclick="mostrarFormulario('mostrarCrearTema','agregarTema','+ Crear nuevo tema','- Cancelar creación de tema')">+ Crear nuevo tema</button>
				    </div>
				    <br>
				    <div id="agregarTema" class="row" style="display: none;">
					    <?php echo Form::open('curso/examen/crear_tema');?>
					    <div class="form-group">
					    	<div class="col-xs-12 col-sm-3">
					    		<?php echo Form::label('Nombre del tema', 'nombre_tema');?>
					    	</div>
					    	<div class="col-xs-12 col-sm-7">
					    		<?php echo Form::input('nombre_tema','',array('class'=>'form-control','type' => 'text', 'placeholder'=>'Nombre del tema'));?>
					    	</div>
						    <div class="col-xs-12 col-sm-2">
						    	<?php echo Form::button('boton_agregar_tema', '+ Agregar', array('class' => 'btn btn-primary btn-block'));?>
						    </div>
					    </div>
					    <?php echo Form::close();?>
				    </div>
		    		<!-- /Seccion agregar -->
			    <!-- /Contenido -->
			</div>
		</div>
	</div>
</section>