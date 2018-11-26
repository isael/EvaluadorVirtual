<?php echo Form::open(array('action' => 'curso/responder_todos', 'method' => 'post', 'name' => 'form_alumnos','id' => 'form_alumnos' ));?>
<section class="session">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
			    <!-- Contenido -->
			    <!-- Barra -->
			    <div class="row">
			    	<div class="col-xs-2">
			    		<?php echo Html::anchor('curso/profesor','<i class="fa fa-chevron-circle-left"></i>', array('class' => 'btn btn-primary btn-block btn-lg')); ?>	

			    	</div>
			    	<div class="col-xs-8 materia materia_peque">
			    		<?php echo $curso->nombre;; ?>		
			    	</div>
			    	<div class="col-xs-2">
			    		<i i class="fa fa-users fav_icon"></i>
			    	</div>
			    </div>
			    <hr>
			    <!-- /Barra -->


			    <!-- Lista de Alumnos -->
			    <div class="row" id="cabecera">
			    	<div class="col-xs-1">
			    		<h4><input type="checkbox" name="check_todos" id="check_todos"></h4>
			    	</div>
			    	<div class="col-xs-8 text-left">
			    		<h4>Alumnos</h4>
			    	</div>
			    	<div class="col-xs-3 text-right">
			    		<h4>Estado</h4>
			    	</div>
			    </div>
			    <div class="row">
				    <?php  
				    	if (isset($alumnos)) {		
				    		$contador = 0;	    		
				    		foreach ($alumnos as $alumno) {
				    			switch ($alumno->estado) {
				    				case 'e':
				    					$estado = "Esperando";
				    					$color = " esperando";
				    					break;
				    				case 'a':
				    					$estado = "Aceptado";
				    					$color = "";
				    					break;
			    					case 'r':
				    					$estado = "Rechazado";
				    					$color = " rechazado";
				    					break;
				    				default:
				    					$estado = "Error";
				    					$color = "";
				    					break;
				    			}
				    			echo "<div class='renglon".$color."'>";
				    				echo "<div class='col-xs-1'>";
				    					echo "<input type='checkbox' name='".$alumno->n_cuenta."' id='".$alumno->n_cuenta."' value='".$alumno->n_cuenta."'>";
				    				echo "</div>";
				    				echo "<div class='col-xs-8 text-left'>";
			    						echo $alumno->nombres." ";
					    				echo $alumno->apellidos." ";
					    			echo "</div>";
					    			echo "<div class='col-xs-3 text-right'>".$estado;
				    				echo "</div>";
				    			echo "<br>";
				    			echo "</div>";
				    			$contador = $contador+1;
					    		
					    	}
				    	}else{
				    		echo "<p>-*- No hay aún alumnos en el curso -*-</p>";
				    	}
				    	
				    ?>
			    </div>
			    <!-- /Lista de Alumnos -->



			    <!-- /Contenido -->
			</div>
		</div>
	</div>
</section>

<!-- Footer -->
<footer class="text-center" style="padding-top: 33px;">
    <div class="footer-above">
        <div class="row">                    
            <div class="col-xs-6">
                <?php echo Form::button('aceptar', 'Aceptar', array('class' => 'btn btn-primary btn-block acepta_rechaza', 'value' => 'aceptar')); ?>
            </div>
            <div class="col-xs-6">
                <?php echo Form::button('rechazar', 'Rechazar', array('class' => 'btn btn-danger btn-block acepta_rechaza', 'value' => 'rechazar')); ?>
            </div>
        </div>
    </div>
</footer>

<?php echo Form::close();?>