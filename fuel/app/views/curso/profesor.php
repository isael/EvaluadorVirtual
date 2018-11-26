<section class="session">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
			    <!-- Contenido -->
			    <!-- Barra -->
			    <div class="row">
			    	
				    	<div class="col-xs-2">
				    		<?php echo Html::anchor('sesion/profesor','<i class="fa fa-chevron-circle-left"></i>', array('class' => 'btn btn-primary btn-block btn-lg')); ?>	
				    	</div>
				    	<div class="col-xs-8 materia">
				    		<?php echo $curso->nombre;; ?>		
				    	</div>
			    </div>
			    <!-- /Barra -->

			    <hr>
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
			    <hr>
			    <?php  
			    	echo "<h4>Solicitudes al curso</h4>";
			    	if (isset($alumnos)) {		
			    		$contador = 0;	    		
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
				    	if ($contador==0) {
				    		echo "<p>-*- Ninguna solicitud pendiente -*-</p>";
				    	}
			    	}
			    	
			    ?>

			    <!-- /Contenido -->
			</div>
		</div>
	</div>
</section>