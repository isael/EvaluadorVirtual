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
			    		<i i class="fa fa-bar-chart fav_icon"></i>
			    	</div>
			    </div>
			    <hr>
			    <!-- /Barra -->
			    <!-- Pestanias -->
				<?php if(!isset($pestania)){$pestania = '';} ?>
				<div id="pestanias" class="row">
					<ul class="nav nav-tabs pestania">
						<li id="general" class="col-xs-6<?php echo $pestania == 'general' || $pestania == '' ? " active": ""; ?>"><a href="javascript:cambiarPestania(pestanias, general);">General</a></li>
						<li id="temas" class="col-xs-6<?php echo $pestania == 'temas' ? " active": ""; ?>"><a href="javascript:cambiarPestania(pestanias, temas);">Temas</a></li>
					</ul>
				</div>
				<!-- Pestanias -->
				<!-- Area de trabajo -->
				<div id="area_pestanias">
					<!-- General -->
					<div id="area_general" class="area<?php echo $pestania == 'general' || $pestania == '' ? " expuesto": " oculto"; ?>">
						<!-- Seccion agregar pregunta -->
						<br>
						<?php
							echo "Area General";	
						?>
						<canvas id="myChart"></canvas>
						<script type="text/javascript">
							var ctx = document.getElementById('myChart').getContext('2d');
							var chart = new Chart(ctx, {
							    // The type of chart we want to create
							    type: 'line',

							    // The data for our dataset
							    data: {
							        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
							        datasets: [{
							            label: 'My First dataset',
							            backgroundColor: 'rgb(255, 99, 132)',
							            borderColor: 'rgb(255, 99, 132)',
							            data: [0, 10, 5, 2, 20, 30, 45]
							        }]
							    },

							    // Configuration options go here
							    options: {}
							});
						</script>
						<!-- /Seccion agregar pregunta -->
						<br>
					</div>
					<!-- /General -->
					<!-- Temas -->
					<div id="area_temas" class="area<?php echo $pestania == 'temas' ? " expuesto": " oculto"; ?>">
						<!-- Seccion agregar pregunta -->
						<br>
						<?php
							echo "Area Temas";	
						?>
						<!-- /Seccion agregar pregunta -->
						<br>
					</div>
					<!-- /Temas -->
				</div>
				<!-- /Area de trabajo -->
			    <!-- /Contenido -->
			</div>
		</div>
	</div>
</section>