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
					$asistencia = $promedios['asistencia'];
					$promedio = array_sum($calificaciones)/sizeof($calificaciones);

					$nombresTemasFallados = [];
					$numeroDeFallas = [];
					$listaDeTemasFallados = $temasFallados['temas'];
					// echo var_dump($listaDeTemasFallados);
					foreach ($listaDeTemasFallados as $nombre => $valor) {
						array_push($nombresTemasFallados, "'".$nombre."'");
						array_push($numeroDeFallas, $valor);
					}
					// $numeroDeAlumnosTotal = 40;//ISAEL obtener desde controlador
					$numeroDeAlumnosTotal = sizeof($calificacionesAlumnos);
					// $nombresAlumnos = ['Maria', 'Juan', 'Lalo', 'Abril', 'Jonas', 'Lola', 'Juan', 'Lalo', 'Abril', 'Jonas', 'Lola', 'Juan', 'Lalo', 'Abril', 'Jonas', 'Lola', 'Juan', 'Lalo', 'Abril', 'Jonas', 'Lola', 'Juan', 'Lalo', 'Abril', 'Jonas', 'Lola', 'Juan', 'Lalo', 'Abril', 'Jonas', 'Lola', 'Juan', 'Lalo', 'Abril', 'Jonas', 'Lola'];
					$nombresAlumnos = [];
					foreach ($calificacionesAlumnos as $nombre => $datos) {
						array_push($nombresAlumnos, "'".$nombre."'");
					}
					$alumnosLength = sizeof($nombresAlumnos);
					$aspectRatio = $alumnosLength > 17 ? 1/(1+intval($alumnosLength/17)) : ($alumnosLength < 9 ? 2 : 1 ) ; 
					$temaMasFallado = "Usabilidad";
				?>
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
						<li id="general" class="col-xs-4<?php echo $pestania == 'general' || $pestania == '' ? " active": ""; ?>"><a href="javascript:cambiarPestania(pestanias, general);">General</a></li>
						<li id="temas" class="col-xs-4<?php echo $pestania == 'temas' ? " active": ""; ?>"><a href="javascript:cambiarPestania(pestanias, temas);">Temas</a></li>
						<li id="alumnos" class="col-xs-4<?php echo $pestania == 'alumnos' ? " active": ""; ?>"><a href="javascript:cambiarPestania(pestanias, alumnos);">Alumnos</a></li>
					</ul>
				</div>
				<!-- /Pestanias -->
				<!-- Area de trabajo -->
				<div id="area_pestanias">
					<!-- General -->
					<div id="area_general" class="area<?php echo $pestania == 'general' || $pestania == '' ? " expuesto": " oculto"; ?>">
						<!-- Seccion agregar pregunta -->
						<br>
						<div>
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
								let asistencia = [<?php echo implode(", ", $asistencia); ?>];
								let numeroDeAlumnosTotal = <?php echo $numeroDeAlumnosTotal; ?>;
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
									},{
										label: 'Alumnos que han terminado el examen',
										yAxisID: 'asistencia',
										backgroundColor: 'rgba(255, 206, 86, 0.2)',
										borderColor: 'rgba(255, 206, 86, 1)',
										borderWidth: 1,
										data: asistencia
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
											}, {
												id: 'asistencia',
												type: 'linear',
												position: 'right',
												ticks: {
													max: numeroDeAlumnosTotal,
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
						<div>
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
											$listaDeExamenesFallados[$indice].'
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
					<!-- Alumnos -->
					<div id="area_alumnos" class="area<?php echo $pestania == 'alumnos' ? " expuesto": " oculto"; ?>">
						<!-- Seccion agregar pregunta -->
						<br>
						<div>
							<?php
								echo "Promedio de suma de calificaciones: ".round($promedio,2);
							?>
						</div>
						<!-- /Seccion agregar pregunta -->
						<br>
						<div class="canvas_chart">
							<canvas id="myChartAlumnos"></canvas>
							<script type="text/javascript">
								let aspectoPantalla = <?php echo $aspectRatio;?>;
								let nombresAlumnos = [<?php echo implode(", ", $nombresAlumnos); ?>];
								let horizontalBarChartData = {
									labels: nombresAlumnos,
									datasets: [{
										label: 'Examen 1',
										backgroundColor: 'rgba(54, 162, 235, 0.2)',
										borderColor: 'rgba(54, 162, 235, 1)',
										data: calificaciones
									}, {
										label: 'Examen 2',
										backgroundColor: 'rgba(75, 206, 86, 0.2)',
										borderColor: 'rgba(75, 206, 86, 1)',
										data: asistencia
									}, {
										label: 'Examen 3',
										backgroundColor: 'rgba(255, 106, 86, 0.2)',
										borderColor: 'rgba(255, 106, 86, 1)',
										data: asistencia
									}, {
										label: 'Examen 4',
										backgroundColor: 'rgba(215, 206, 16, 0.2)',
										borderColor: 'rgba(215, 206, 16, 1)',
										data: asistencia
									}, {
										label: 'Examen 5',
										backgroundColor: 'rgba(205, 26, 186, 0.2)',
										borderColor: 'rgba(205, 26, 186, 1)',
										data: asistencia
									}]

								};
								let type_chart = 'horizontalBar';
								if(window.innerWidth && window.innerHeight &&
									window.innerWidth > window.innerHeight &&
									<?php echo ($alumnosLength > 30 ? 'false' : 'true'); ?>){
									type_chart = 'bar';
									aspectoPantalla = null;
								}
								let ctxMyChartAlumnos = document.getElementById('myChartAlumnos').getContext('2d');
								let myChartAlumnos = new Chart(ctxMyChartAlumnos, {
									type: type_chart,
									data: horizontalBarChartData,
									options: {
										// Elements options apply to all of the options unless overridden in a dataset
										// In this case, we are setting the border of each horizontal bar to be 2px wide
										elements: {
											rectangle: {
												borderWidth: 2,
											}
										},
										responsive: true,
										aspectRatio: aspectoPantalla,
										legend: {
											position: 'right',
										},
										title: {
											display: true,
											text: 'Chart.js Horizontal Bar Chart'
										},
										scales: {
											xAxes: [{
												stacked: true,
											}],
											yAxes: [{
												stacked: true
											}]
										}
									}
								});

							</script>
						</div>
					</div>
					<!-- /Alumnos -->
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
                <?php echo Form::button('imprimir', '<i class="fa fa-print" aria-hidden="true"></i> Imprimir las estadísticas', array('class' => 'btn btn-primary btn-block')); ?>
            </div>
        </div>
    </div>
</footer>