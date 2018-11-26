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
			    		<i i class="fa fa-file-text-o fav_icon"></i>
			    	</div>
			    </div>
			    <hr>
			    <!-- /Barra -->

			    <!-- Pestanias -->
			    <div id="pestanias" class="row">
			    	<ul class="nav nav-tabs pestania">
		    			<li id="crear" class="col-xs-4 active"><a href="javascript:cambiarPestania(pestanias, crear);">Editar</a></li>					
		    			<li id="probar" class="col-xs-4"><a href="javascript:cambiarPestania(pestanias, probar);">Probar</a></li>						
		    			<li id="temas" class="col-xs-4"><a href="javascript:cambiarPestania(pestanias, temas);">Temas</a></li>
					</ul>
				</div>
			    <!-- Pestanias -->

			    <!-- Area de trabajo -->
			    <div id="area_pestanias">
			    	<div id="area_crear" class="area">
			    		<!-- Lista Examenes -->
			    		<?php
			    			if(isset($examenes)){
			    				echo '<div class="row">';
					    		foreach ($examenes as $examen) {
					    			
									echo '<div class="col-xs-12 col-md-6 col-lg-4 examen">';
										echo '<a href="examen/editar?id_examen='.$examen->id_examen.'">';
										echo '<div class="row">';
											echo '<div class="col-xs-6">';
												echo $examen->nombre;
												echo '<br>Inicio: '.$examen->fecha_inicio;
												echo '<br>Final: '.$examen->fecha_fin;
											echo '</div>';
											echo '<div class="col-xs-6">';
												echo 'Temas: ';
												if(isset($temas)){
													$es_primero = True;
													foreach ($temas as $tema) {
														if($tema->id_examen==$examen->id_examen){
															if($es_primero){
																echo $tema->nombre;
																$es_primero=False;
															}else{
																echo ", ".$tema->nombre;
															}
														}
													}													
												}else{
													echo 'Sin fijar';
												}
											echo '</div>';
										echo '</div>';
										echo '</a>';
									echo '</div>';
					    		}
					    		echo '</div>';
			    			}else{
			    				echo "Aun sin examen";
			    			}
			    		?>
			    		<!-- /Lista Examenes -->
			    		<br>
			    		<!-- Seccion agregar -->
			    		<div class="row">
					    	<button id="mostrarCrearExamen" class="btn btn-primary btn-block btn-lg" onclick="mostrarFormulario('mostrarCrearExamen','agregarExamen','+ Crear nuevo examen','- Cancelar creación de examen')">+ Crear nuevo examen</button>
					    </div>
					    <br>
					    <div id="agregarExamen" class="row" style="display: none;">
						    <?php echo Form::open('curso/crear_examen');?>
						    <div class="form-group">
						    	<div class="col-xs-12 col-sm-3">
						    		<?php echo Form::label('Nombre del examen', 'nombre_examen');?>
						    	</div>
						    	<div class="col-xs-12 col-sm-7">
						    		<?php echo Form::input('nombre_examen','',array('class'=>'form-control','type' => 'text', 'placeholder'=>'Nombre del examen'));?>
						    	</div>
							    <div class="col-xs-12 col-sm-2">
							    	<?php echo Form::button('boton_agregar_curso', '+ Agregar', array('class' => 'btn btn-primary btn-block'));?>
							    </div>
						    </div>
						    <?php echo Form::close();?>
					    </div>
			    		<!-- /Seccion agregar -->
			    	</div>
			    	<div id="area_probar" class="area oculto">
			    		Area PROBAR
			    	</div>
			    	<div id="area_temas" class="area oculto">
			    		Area TEMAS
			    	</div>
			    </div>
			    <!-- Area de trabajo -->
			    
			    <!-- /Contenido -->
			</div>
		</div>
	</div>
</section>
