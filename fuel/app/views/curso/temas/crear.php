<section class="session">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
			    <!-- Contenido -->
			    <!-- Barra -->
			    <div class="row">
			    	<div class="col-xs-2 materia">
			    		<?php echo Html::anchor($volver,'<i class="fa fa-arrow-left"></i>', array('class' => 'btn btn-primary btn-block btn-lg')); ?>	

			    	</div>
			    	<div class="col-xs-8 materia materia_peque">
			    		<?php echo $curso->nombre; ?>		
			    	</div>
			    	<div class="col-xs-2">
			    		<i i class="fa fa-file-text-o fav_icon"></i>
			    	</div>
			    </div>
			    <hr>
			    <!-- /Barra -->
			    
			    <!-- Temas -->
			    <p>Nombre del tema</p>
			    <?php  
			    	echo "Aquí se editan temas";
			    ?>
			    <!-- /Temas -->
			    <!-- /Contenido -->
			</div>
		</div>
	</div>
</section>