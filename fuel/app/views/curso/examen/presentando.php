<section class="session">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
			    <!-- Contenido -->
			    <!-- Barra -->
			    <div class="row">
			    	<div class="col-xs-12 materia materia_peque">
			    		<?php echo "Examen 2"; ?>		
			    	</div>
			    </div>
			    <hr>
			    <!-- /Barra -->

			    <!-- Informacion -->
			    	<!-- <?php 
			    		$vidas_restantes = 0;
			    		$vidas_totales = 0;
			    		$oportunidades_restantes = 0;
			    		$oportunidades_totales = 0;
			    		if(isset($examen)){
			    			$vidas_totales = $examen->vidas;
			    			$oportunidades_totales = $examen->oportunidades;

			    			$vidas_restantes = $vidas_totales;
			    			$oportunidades_restantes = $oportunidades_totales;
			    		}
			    		if(isset($presenta)){
			    			$vidas_restantes = intval($vidas_totales) - intval($presenta->vidas);
			    			$oportunidades_restantes = intval($oportunidades_totales) - intval($presenta->oportunidades);
			    		}

			    		$tiempo = 0;
			    		if(isset($preguntas)){
				    		foreach ($preguntas as $pregunta) {
				    			$tiempo = $tiempo + intval($pregunta->tiempo);
				    		}
				    	}
				    	$minutos = $tiempo / 60;
				    	$segundos = ($tiempo % 60) < 10 ? '0'.($tiempo % 60) : ($tiempo % 60) ;

			    	?> -->
			    <!-- /Informacion -->

			    <!-- Informacion de Examen -->
			    <!-- <div class="row">
				    <p>-*- Estudia antes de presentar el examen -*-</p>
				    <div class="col-xs-12">
				    	<div class="col-xs-6">
				    		<h4>Vidas: <?php echo $vidas_restantes.'/'.$vidas_totales; ?></h4>
				    	</div>
				    	<div class="col-xs-6">
				    		<h4>Oportunidades: <?php echo $oportunidades_restantes.'/'.$oportunidades_totales; ?></h4>
				    	</div>
				    </div>

				    <div class="col-xs-12">
				    	<h4>Tiempo máximo: <?php echo $minutos.':'.$segundos ?> minutos</h4>
				    </div>
				    <br>
				    <div class="col-xs-12">
				    	<h4>Temas</h4>
				    	<?php
					    	if(isset($temas)){
					    		foreach ($temas as $tema) {
					    			echo '<p>'.$tema->nombre.'</p>';
					    		}
					    	}
				    	?>
				    </div>
				    <br>
				    <div class="col-xs-12">
				    	<h4>Bibliografía</h4>
				    	<?php
					    	if(isset($fuentes)){
					    		foreach ($fuentes as $fuente) {
					    			echo '<p>'.$fuente->nombre.'</p>';
					    		}
					    	}
				    	?>
				    </div>
				    <br>
				    <?php
					    	if(isset($preguntas)){
					    		foreach ($preguntas as $pregunta) {
					    			echo '<p>'.$pregunta->texto.'</p>';
					    		}
					    		SESSION::set('preguntas',$preguntas);
					    		SESSION::set('siguiente_posicion_pregunta',0);
					    	}
				    	?>
				    <div class="col-xs-12">
				    	<button class="btn btn-primary btn-block btn-lg">Comenzar Examen</button>
				    </div>
			    </div> -->
			    <!-- /Informacion de Examen -->
			    
			    <!-- /Contenido -->
			</div>
		</div>
	</div>
</section>