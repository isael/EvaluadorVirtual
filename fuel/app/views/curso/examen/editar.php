<section class="session">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
			    <!-- Contenido -->
			    <!-- Barra -->
			    <div class="row">
			    	<div class="col-xs-2">
			    		<?php echo Html::anchor('curso/examenes','<i class="fa fa-chevron-circle-left"></i>', array('class' => 'btn btn-primary btn-block btn-lg')); ?>	

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
			    <!-- Propiedades de examen -->
			    <div class="materia materia_peque">
		    		<?php echo $examen->nombre; ?>		
		    	</div>
			    <div class="row">
			    	<div class="col-xs-4">
			    		Tiempo<br>
			    		<?php echo Form::input('tiempo', '', array('type'=>'number'));?> minutos
			    	</div>	
			    	<div class="col-xs-4">
			    		Oportunidades<br>
			    		<?php echo Form::input('oportunidades', '', array('type'=>'number'));?>
			    	</div>
			    	<div class="col-xs-4">
			    		Vidas<br>
			    		<?php echo Form::input('vidas', '', array('type'=>'number'));?>
			    	</div>
			    </div>
			    <!-- /Propiedades de examen -->
			    <!-- Temas -->
			    <hr>
			    <p>Temas</p>
			    <?php  
			    	if(False){

			    	}
			    ?>
			    <?php echo Html::anchor('curso/examen/temas?id_examen='.$examen->id_examen,'+ Agregar Tema',array('class' => 'btn btn-primary btn-lg btn-block')); ?>
			    <!-- /Temas -->
			    <!-- /Contenido -->
			</div>
		</div>
	</div>
</section>