<section class="session">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
			    <!-- Contenido -->
			    <div class="row">
			    	
				    	<div class="col-xs-2">
				    		<?php echo Html::anchor('sesion/alumno','<i class="fa fa-chevron-circle-left"></i>', array('class' => 'btn btn-primary btn-block btn-lg')); ?>	
				    	</div>
				    	<div class="col-xs-8 materia">
				    		<?php echo $curso->nombre;; ?>		
				    	</div>
			    </div>
			    <!-- /Barra -->
			    <br>
				<p>Promedio en la materia</p>    
			    <div class="row">	
			    	<div class="col-xs-6">		
					    <div class="mega">
					    	<?php echo "9";//"<h3>".$curso->nombre."</h3>" ?>	
					    </div>	
				    </div>			    	
			    	<div class="col-xs-6">
			    		<br>
			    		<br>
			    		<?php echo Html::anchor('curso/mis_estadisticas','<i class="fa fa-bar-chart"></i> <br> Ver mis estadísticas',array('class'=>'btn btn-primary btn-block btn-lg')) ;?>  
			    	</div>
			    </div>
			    <hr>

			    <?php  
			    	echo "<h3>Exámenes disponibles</h3>";
			    	if (isset($examenes)) {		
			    		$contador = 0;	    		
			    		foreach ($alumnos as $alumno) {
			    			if($alumno->estado=='e'){
			    				echo $alumno->nombres." ";
					    		echo $alumno->apellidos." ";
					    		echo $alumno->estado." ";
					    		echo Form::open(array('action' => 'curso/responder', 'method' => 'post'));
					    		echo Form::hidden('n_cuenta',$alumno->n_cuenta);
					    		echo Form::button('aceptar', 'Aceptar', array('class' => 'btn btn-primary btn-block acepta_rechaza', 'value' => '1'));
					    		echo Form::button('rechazar', 'Rechazar', array('class' => 'btn btn-danger btn-block acepta_rechaza', 'value' => '1'));
					    		echo Form::close();
					    		echo "<br>";
					    		$contador = $contador+1;
			    			}				    		
				    	}
				    	if ($contador==0) {
				    		echo "<p>-*- No hay exámenes disponibles -*-</p>";
				    	}
			    	}
			    	
			    ?>
			    <!-- /Contenido -->
			</div>
		</div>
	</div>
</section>