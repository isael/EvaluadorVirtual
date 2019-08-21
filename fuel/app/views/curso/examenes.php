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
		    			<li id="edicion" class="col-xs-4 active"><a href="javascript:cambiarPestania(pestanias, edicion);">Edición</a></li>					
		    			<li id="bibliografia" class="col-xs-4"><a href="javascript:cambiarPestania(pestanias, bibliografia);">Bibliografía</a></li>						
		    			<li id="preguntas" class="col-xs-4"><a href="javascript:cambiarPestania(pestanias, preguntas);">Preguntas</a></li>
					</ul>
				</div>
			    <!-- Pestanias -->

			    <!-- Area de trabajo -->
			    <div id="area_pestanias">
			    	<!-- Edicion -->
			    	<div id="area_edicion" class="area">
			    		<!-- Lista Examenes -->
			    		<?php
			    			$cual_boton = "examen";
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
			    				//Verificar si hay preguntas
			    				if(isset($preguntas)){
			    					echo "Aun sin examen";
			    				}else{
			    					$cual_boton = "preguntas";
			    					echo "Para poder generar exámenes y preguntas deben existir la bibliografía y un conjunto de preguntas";
			    					if(!isset($bibliografias)){
			    						$cual_boton = "bibliografia";
			    					}
			    				}
			    			}
			    		?>
			    		<!-- /Lista Examenes -->
			    		<br>
			    		<!-- Seccion agregar examenes -->
			    		<?php 
			    			switch($cual_boton){
				    			case "preguntas":
				    			?>
				    				<div class="row">
								    	<a class="btn btn-primary btn-block btn-lg" href="javascript:cambiarPestania(pestanias, preguntas);">Crear Preguntas</a>
								    </div>
								<?php 
									break;
								case "bibliografia":
								?>
									<div class="row">
								    	<a class="btn btn-primary btn-block btn-lg" href="javascript:cambiarPestania(pestanias, bibliografia);">Crear Bibliografía</a>
								    </div>
								<?php 
									break;
								case "examen":
								default:
								?>
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

						    	<?php 
						    }
						    ?>
			    		<!-- /Seccion agregar examenes -->
			    	</div>
			    	<!-- /Edicion -->

			    	<!-- Bibliografia -->
			    	<div id="area_bibliografia" class="area oculto">
			    		<!-- Lista Bibliografias -->
			    		<?php
			    			if(isset($bibliografia)){//TODO_ISAEL Cambiar por lista de bibliografia
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
			    				//Verificar si hay preguntas
			    				echo "La bibliografía será necesaria para poder relacionar los temas y preguntas con un libro o fuente especifico";
			    			}
			    		?>
			    		<!-- /Lista Bibliografias -->
			    		<br>
			    		<!-- Seccion agregar bibliografia -->
			    		<div class="row">
					    	<button id="mostrarCrearExamen" class="btn btn-primary btn-block btn-lg" onclick="mostrarFormulario('mostrarCrearExamen','agregarExamen','+ Agregar nueva bibliografía','- Cancelar nueva bibliografía')">+ Agregar nueva bibliografía</button>
					    </div>
					    <br>
					    <div id="agregarExamen" class="row" style="display: none;">
						    <?php echo Form::open('curso/examen/crear_bibliografia');?>
						    <div class="form-group">
						    	<div class="col-xs-12 col-sm-12">
						    		<?php echo Form::label('Nombre', 'nombre_bibliografia');?>
						    	</div>
						    	<div class="col-xs-12 col-sm-12">
						    		<?php echo Form::input('nombre_bibliografia','',array('class'=>'form-control','type' => 'text', 'placeholder'=>'Nombre de la fuente'));?>
						    	</div>
						    	<div class="col-xs-12 col-sm-12">
						    		<?php echo Form::label('Autor(es)', 'autor_bibliografia');?>
						    	</div>
						    	<div class="col-xs-12 col-sm-12">
						    		<?php echo Form::input('autor_bibliografia','',array('class'=>'form-control','type' => 'text', 'placeholder'=>'Nombre de los autores'));?>
						    	</div>
						    	<div class="col-xs-12 col-sm-12">
						    		<?php echo Form::label('Edición', 'edicion_bibliografia');?>
						    	</div>						    	
						    	<div class="col-xs-4 col-sm-4">
						    		<?php echo Form::label('#', 'numero_edicion_bibliografia');?>
						    	</div>
						    	<div class="col-xs-8 col-sm-8">
						    		<?php echo Form::label('Año', 'anio_bibliografia');?>
						    	</div>
						    	<div class="col-xs-4 col-sm-4">
						    		<?php echo Form::input('numero_edicion_bibliografia','',array('class'=>'form-control','type' => 'text', 'placeholder'=>'Número'));?>
						    	</div>
						    	<div class="col-xs-8 col-sm-8">
						    		<?php echo Form::input('anio_bibliografia','',array('class'=>'form-control','type' => 'text', 'placeholder'=>'Año'));?>
						    	</div>
						    	<div class="col-xs-12 col-sm-12">
						    		<?php echo Form::label('Enlace en línea (si existe)', 'link_bibliografia');?>
						    	</div>
						    	<div class="col-xs-12 col-sm-12">
						    		<?php echo Form::input('link_bibliografia','',array('class'=>'form-control','type' => 'text', 'placeholder'=>'Enlace o link a la fuente'));?>
						    	</div>
						    	<br>
							    <div class="col-xs-12 col-sm-12">
							    	<?php echo Form::button('boton_agregar_bibliografia', '+ Agregar', array('class' => 'btn btn-primary btn-block'));?>
							    </div>
						    </div>
						    <?php echo Form::close();?>
					    </div>
			    		<!-- /Seccion agregar bibliografia -->
			    	</div>
			    	<!-- /Bibliografia -->

			    	<!-- Preguntas -->
			    	<div id="area_preguntas" class="area oculto">
			    		<!-- Lista Bibliografias -->
			    		<?php
			    			$cual_boton = "preguntas";
			    			if(isset($preguntas)){//TODO_ISAEL Cambiar por lista de preguntas
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
			    				//Verificar si hay preguntas
		    					if(isset($bibliografias)){		    						
		    						echo "Las preguntas se separan por temas";
		    					}else{
		    						$cual_boton = "bibliografia";
		    						echo "Para crear preguntas debe existir bibliografía";
		    					}
			    			}
			    		?>
			    		<!-- /Lista Bibliografias -->
			    		<br>
			    		<!-- Seccion agregar bibliografia -->
			    		<?php 
			    			switch($cual_boton){
								case "bibliografia":
								?>
									<div class="row">
								    	<a class="btn btn-primary btn-block btn-lg" href="javascript:cambiarPestania(pestanias, bibliografia);">Crear Bibliografía</a>
								    </div>
								<?php 
									break;
								case "preguntas":
								default:
								?>
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

						    	<?php 
						    }
						    ?>
			    		<!-- /Seccion agregar bibliografia -->
			    	</div>
			    	<!-- /Preguntas -->
			    </div>
			    <!-- Area de trabajo -->
			    
			    <!-- /Contenido -->
			</div>
		</div>
	</div>
</section>
