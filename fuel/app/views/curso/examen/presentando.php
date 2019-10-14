<section class="session">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
			    <!-- Contenido -->
			    <!-- Barra -->
			    <div class="row">
			    	<div class="col-xs-4">
			    		<?php echo "Vidas: "; ?>
			    		<?php
			    			$vidas_posibles = intval($examen->vidas);
			    			$vidas_usadas = 0;
			    			if(isset($presenta)){
			    				$vidas_usadas = intval($presenta->vidas);
			    			}
			    			$vidas_totales = $vidas_posibles - $vidas_usadas;
			    			for ($i=0; $i < $vidas_totales; $i++) { 
			    				echo '<i class="fa fa-heart" aria-hidden="true"></i>';
			    			}
			    			for ($i=0; $i < $vidas_usadas; $i++) { 
			    				echo '<i class="fa fa-heart-o" aria-hidden="true"></i>';
			    			}
			    		?>
			    	</div>
			    	<div class="col-xs-4 materia materia_peque">
			    		<?php echo $examen->nombre; ?>		
			    	</div>
			    	<div class="col-xs-4">
			    		<?php echo "Oportunidades: "; ?>
			    		<?php
			    			$oportunidades_posibles = intval($examen->oportunidades);
			    			$oportunidades_usadas = 0;
			    			if(isset($presenta)){
			    				$oportunidades_usadas = intval($presenta->oportunidades);
			    			}
			    			$oportunidades_totales = $oportunidades_posibles - $oportunidades_usadas;
			    			for ($i=0; $i < $oportunidades_totales; $i++) { 
			    				echo '<i class="fa fa-heart" aria-hidden="true"></i>';
			    			}
			    			for ($i=0; $i < $oportunidades_usadas; $i++) { 
			    				echo '<i class="fa fa-heart-o" aria-hidden="true"></i>';
			    			}
			    		?>
			    	</div>
			    </div>
			    <hr>
			    <!-- /Barra -->

			    <!-- Informacion -->
			    	<div class="col-xs-12">
				    	<div class="col-xs-12">
				    		<h4>Tiempo restante: <?php echo $pregunta->tiempo ?></h4>
				    	</div>
				    </div>
				    <div class="col-xs-12">
				    	<div class="col-xs-12">
				    		<h4>Pregunta:</h4>
				    	</div>
				    	<div class="col-xs-12">
				    		<?php echo $pregunta->texto ?>
				    	</div>
				    </div>
				    <div class="col-xs-12 table">
				    	<div class="col-xs-12">
				    		<h4>Respuestas:</h4>
				    	</div>
				    	<div id="respuestas" class="col-xs-12 table-row">
				    		<?php
				    			$i = 0;
				    			foreach ($respuestas as $respuesta) {
				    				echo '<a id="respuesta_'.$i.'" class="col-xs-6 col-md-6 col-lg-4 examen respuesta" href="javascript:agregaEstiloSelected(respuesta_'.$i.',respuestas)">';
				    				echo $respuesta->contenido;
				    				echo '</a>';
				    				$i++;
				    			}
				    		?>
				    	</div>
				    </div>
				    <hr style="border:2px dotted" />
				    <div class="col-xs-12">
				    	<div class="col-xs-12">
				    		<h4>Retroalimentación:</h4>
				    	</div>
				    	<div class="col-xs-12">
				    		<?php
				    			echo $pregunta->justificacion;
				    		?>
				    	</div>
				    </div>
				    <div class="col-xs-12">
				    	<div class="col-xs-12">
				    		<h4>Bibliografía:</h4>
				    	</div>
				    	<div class="col-xs-12">
				    		<?php
				    			echo $referencia->nombre.', '.$referencia->numero.'ª edición: página '.$referencia->pagina.', capítulo '.$referencia->capitulo;
				    		?>
				    	</div>
				    </div>
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
<!-- Footer -->
<footer class="text-center" style="padding-top: 33px;">
    <div class="footer-above">
        <div class="row">
        	<?php echo Form::open('curso/examen/presentando'); ?>           
            <div class="col-xs-6">
				<?php echo Form::input('respuesta_elegida','',array('type' => 'hidden'));?>
                <?php echo Form::button('abandonar', 'Abandonar', array('class' => 'btn btn-primary btn-block', 'value' => 'abandonar', 'type' => 'button')); ?>
            </div>
            <div class="col-xs-6">
                <?php echo Form::button('evaluar', 'Evaluar', array('class' => 'btn btn-danger btn-block', 'value' => 'evaluar')); ?>
            </div>
            <?php echo Form::close(); ?>
        </div>
    </div>
</footer>