<section class="session">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
			    <!-- Contenido -->
			    <?php 
					// $listaDeExamenes = ["Examen 1", "Examen 2", "Examen 3", "Examen 4", "Examen 5", "Examen 6"];//ISAEL obtener desde controlador
					$listaDeExamenes = $promedios['examenes'];
					$nombresExamenes = [];
					foreach ($listaDeExamenes as $examen) {
						// $nombreExamen = $examen->nombre; ISAEL cambiar por este valor
						$nombreExamen = $examen;
						array_push($nombresExamenes, "'".$nombreExamen."'");
					}
					// $calificaciones = [10, 9, 8.3, 5, 2, 3];//ISAEL obtener desde controlador
					$calificaciones = $promedios['promedios'];
					// $asistencia = [12, 19, 29, 14, 22, 13];//ISAEL obtener desde controlador
					// $asistencia = $promedios['asistencia'];
					$promedio = array_sum($calificaciones)/sizeof($calificaciones);

					$nombresTemasFallados = [];
					$numeroDeFallas = [];
					$listaDeTemasFallados = $temasFallados['temas'];
					// echo var_dump($listaDeTemasFallados);
					foreach ($listaDeTemasFallados as $nombre => $valor) {
						array_push($nombresTemasFallados, "'".$nombre."'");
						array_push($numeroDeFallas, $valor);
					}
					$temaMasFallado = $nombresTemasFallados[0];
				?>
			    <!-- Barra -->
			    <div class="row">
			    	<div class="col-xs-2">
			    		<?php echo Html::anchor('curso/alumno','<i class="fa fa-chevron-circle-left"></i>', array('class' => 'btn btn-primary btn-block btn-lg')); ?>	

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
				<!-- /Pestanias -->
				<!-- Area de trabajo -->
				<div id="area_pestanias">
					<!-- General -->
					<div id="area_general" class="area<?php echo $pestania == 'general' || $pestania == '' ? " expuesto": " oculto"; ?>">
						<!-- Seccion agregar pregunta -->
						<br>
						<div id="myChartGeneralTitulo">
							<?php
								echo "Promedio general: ".round($promedio,2);
							?>
						</div>
						<br>
						<div class='canvas_chart'>
							<canvas id="myChartGeneral"></canvas>
							<script type="text/javascript">
								let nombresExamenes = [<?php echo implode(", ", $nombresExamenes); ?>];
								let calificaciones = [<?php echo implode(", ", $calificaciones); ?>];
								let ctxMyChartGeneral = document.getElementById('myChartGeneral').getContext('2d');
								let barChartData = {
									labels: nombresExamenes,
									datasets: [{
										label: 'Calificación promedio',
										yAxisID: 'promedio',
										backgroundColor: 'rgba(54, 162, 235, 0.2)',
										borderColor: 'rgba(54, 162, 235, 0.2)',
										borderWidth: 1,
										data: calificaciones
									}]
								};
								let myChartGeneral = new Chart(ctxMyChartGeneral, {
									type: 'bar',
									data: barChartData,
									options: {
										scales: {
											yAxes: [{
												id: 'promedio',
												type: 'linear',
												position: 'left',
												ticks: {
													max: 10,
													min: 0
												}
											}]
										}
									}
								});
							</script>
						</div>
						<!-- /Seccion agregar pregunta -->						
						<br>
					</div>
					<!-- /General -->
					<!-- Temas -->
					<div id="area_temas" class="area<?php echo $pestania == 'temas' ? " expuesto": " oculto"; ?>">
						<!-- Seccion agregar pregunta -->
						<br>
						<div id="myChartTemasTitulo">
							<?php
								echo "Tema más fallado: ".$temaMasFallado;	
							?>
						</div>
						<br>
						<div class="canvas_chart">
							<canvas id="myChartTemas"></canvas>
							<script type="text/javascript">
								let ctxMyChartTemas = document.getElementById('myChartTemas');
								let nombresTemasFallados = [<?php echo implode(", ", $nombresTemasFallados); ?>];
								let numeroDeFallas = [<?php echo implode(", ", $numeroDeFallas); ?>];
								let polarChartData =  {
										datasets: [{
											data: numeroDeFallas,
											backgroundColor: [
												'rgba(54, 162, 235, 1)',
												'rgba(75, 206, 86, 1)',
												'rgba(255, 106, 86, 1)',
												'rgba(215, 206, 186, 1)',
												'rgba(205, 26, 186, 1)',
											],
											label: 'Los 10 temas más fallados' // for legend
										}],
										labels: nombresTemasFallados
									};
								let myChartTemas = Chart.PolarArea(ctxMyChartTemas, {
									data: polarChartData,
									options: {
										responsive: true,
										legend: {
											position: 'right',
										},
										title: {
											display: true,
											text: 'Los 10 temas más fallados'
										},
										scale: {
											ticks: {
												beginAtZero: true
											},
											reverse: false
										},
										animation: {
											animateRotate: false,
											animateScale: true
										}
									}
								});
							</script>
						</div>	
						<hr>					
						<div>
							<h4>Listado completo de Temas</h4>
						</div>
						<br>
						<div class="col-xs-12 table">
							<div class="col-xs-4 table-row">
								Tema
							</div>
							<div class="col-xs-4 table-row">
								Examen
							</div>
							<div class="col-xs-4 table-row">
								Errores
							</div>
						</div>
						<hr>
						<div class="col-xs-12">
							<?php 
								$listaDeExamenesFallados = $temasFallados['examenes'];
								$listaDeFallos = $temasFallados['errores'];
								$indice = 0;
								foreach ($nombresTemasFallados as $nombresTemasFallados) {
									echo '<div class="col-xs-12 table">
										<div class="col-xs-4 table-row">'.
											$nombresTemasFallados.'
										</div>
										<div class="col-xs-4 table-row">'.
											'$listaDeExamenesFallados[$indice]'.'
										</div>
										<div class="col-xs-4 table-row">'.
											$listaDeFallos[$indice].'
										</div>
									</div>';
									$indice++;
								}
							?>
						</div>
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
<!-- Footer -->
<footer class="text-center" style="padding-top: 33px;">
    <div class="footer-above">
        <div class="row">
            <div class="col-xs-12">
                <?php echo Form::button('imprimir', '<i class="fa fa-print" aria-hidden="true"></i> Imprimir las estadísticas', array('class' => 'btn btn-primary btn-block', 'onclick' => 'javascript:imprimirEstadisticas(["area_general","area_temas"]);')); ?>
            </div>
        </div>
    </div>
</footer>