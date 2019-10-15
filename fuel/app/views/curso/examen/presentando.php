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
				    		<span>Tiempo restante: </span>
				    		<span id="tiempo"> <?php echo $pregunta->tiempo ?></span>
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
			    <!-- /Informacion -->
			    
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
                <?php echo Form::button('evaluar', 'Evaluar', array('class' => 'btn btn-danger btn-block', 'value' => 'evaluar', 'id' => 'boton_evaluar')); ?>
            </div>
            <?php echo Form::close(); ?>
        </div>
    </div>
</footer>
<script type="text/javascript">
	function loop() {
		if(typeof waiting === 'function'){
			waiting();
		}else{
			setTimeout(function(){
				loop();
			},100);
		}
	}
	loop();
	
</script>