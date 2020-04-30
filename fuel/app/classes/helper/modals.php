<?php
/**
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package	Fuel
 * @version	1.8
 * @author	 Fuel Development Team
 * @license	MIT License
 * @copyright  2010 - 2016 Fuel Development Team
 * @link	   http://fuelphp.com
 */

/**
 * The Special Selector Helper.
 *
 * A basic controller example.  Has examples of how to set the
 * response body and status.
 *
 * @package  app
 * @extends  Controller
 */
class Modals
{
	public static function getModalExamen($temas, $temas_externos, $is_modal = false, $id_examen = null){
		$id_curso = SESSION::get('id_curso');
		$result = '';
		$examen_vidas = '1';
		$examen_oportunidades = '3';
		$examen_tema = '';
		$examen_tema_id = '';
		$examen_tema_nivel_desde = '1';
		$examen_tema_nivel_hasta = '3';
		$sufijo_modal = '';
		$temas_y_niveles='';
		$dia_actual = date("Y-m-d");
		$examen_nombre = 'Examen: ('.$dia_actual.')';
		$examen_inicio = $dia_actual;
		$examen_final = date("Y-m-d",strtotime($dia_actual."+ 1 month"));
		$examen_cantidad_preguntas = '10';
		$vidas = array(array(1,1),array(2,2),array(3,3));
		$niveles = array(array(1,1),array(2,2),array(3,3));
		$oportunidades = array(array(3,3),array(4,4),array(5,5));
		$multiplo_total_preguntas = 1.5;
		$lista_de_temas = [];
		$examen_lista_de_cantidad_de_preguntas = '';
		$examen_lista_de_nombres_de_preguntas = '';
		$examen_temas_modal = '';
		$examen_temas_rangos = [];
		if(isset($temas)){
			foreach ($temas as $tema) {
				$id_tema = $tema->id_tema;
				$preguntas_nivel_1 = Model_Pregunta::find(function ($query) use ($id_tema){
				return $query->join('Genera')
							 ->on('Genera.id_pregunta', '=', 'Pregunta.id_pregunta')
							 ->where('Genera.id_tema', '=', $id_tema)
							 ->where('Pregunta.dificultad', '=', '1');
				});
				$preguntas_nivel_2 = Model_Pregunta::find(function ($query) use ($id_tema){
				return $query->join('Genera')
							 ->on('Genera.id_pregunta', '=', 'Pregunta.id_pregunta')
							 ->where('Genera.id_tema', '=', $id_tema)
							 ->where('Pregunta.dificultad', '=', '2');
				});
				$preguntas_nivel_3 = Model_Pregunta::find(function ($query) use ($id_tema){
				return $query->join('Genera')
							 ->on('Genera.id_pregunta', '=', 'Pregunta.id_pregunta')
							 ->where('Genera.id_tema', '=', $id_tema)
							 ->where('Pregunta.dificultad', '=', '3');
				});
				//Es super importante no modificar la manera en que se muestran las preguntas ($texto_tema) para el funcionamiento actual, es decir con la cantidad de preguntas por nivel.
				//En caso de querer modificarlo, la manera de obtener el número de preguntas por cada tema y nivel deberá ser acorde a lo que necesiten los metodos para conteo de preguntas.
				$cantidad_preguntas_nivel_1 = is_array($preguntas_nivel_1) ? sizeof($preguntas_nivel_1) : 0;
				$cantidad_preguntas_nivel_2 = is_array($preguntas_nivel_2) ? sizeof($preguntas_nivel_2) : 0;
				$cantidad_preguntas_nivel_3 = is_array($preguntas_nivel_3) ? sizeof($preguntas_nivel_3) : 0;

				$texto_tema = $tema->nombre.':&nbsp;&nbsp;&nbsp;&nbsp;preguntas: N1: '.$cantidad_preguntas_nivel_1.', N2: '.$cantidad_preguntas_nivel_2.', N3: '.$cantidad_preguntas_nivel_3.'.';
				array_push($lista_de_temas, array($id_tema, $texto_tema));

				$input_preguntas_por_tema = Form::input('input_'.$id_tema.$sufijo_modal,$cantidad_preguntas_nivel_1.','.$cantidad_preguntas_nivel_2.','.$cantidad_preguntas_nivel_3,array('class'=>'form-control','type' => 'hidden'));
				$examen_lista_de_cantidad_de_preguntas = $examen_lista_de_cantidad_de_preguntas.$input_preguntas_por_tema;

				$input_nombre_por_tema = Form::input('input_tema_'.$id_tema.$sufijo_modal,$tema->nombre,array('class'=>'form-control','type' => 'hidden'));
				$examen_lista_de_nombres_de_preguntas = $examen_lista_de_nombres_de_preguntas.$input_nombre_por_tema;

				if($is_modal && isset($id_examen)){
					$rango = Model_BasadoEn::find(array('id_examen' => $id_examen, 'id_tema' => $id_tema ));
					if(isset($rango)){
						array_push($examen_temas_rangos, $rango->id_tema.'-'.$rango->desde_dificultad.'-'.$rango->hasta_dificultad);
					}
				}
			}
		}
		if(isset($temas_externos)){
			foreach ($temas_externos as $tema_externo) {
				$id_tema = $tema_externo->id_tema;
				$preguntas_nivel_1 = Model_Pregunta::find(function ($query) use ($id_tema, $id_curso){
				return $query->join('Genera')
							 ->on('Genera.id_pregunta', '=', 'Pregunta.id_pregunta')
							 ->join('CursoPreguntasCompartidas')
							 ->on('CursoPreguntasCompartidas.id_pregunta', '=', 'Genera.id_pregunta')
							 ->where('CursoPreguntasCompartidas.id_curso', '=', $id_curso)
							 ->where('Genera.id_tema', '=', $id_tema)
							 ->where('Pregunta.dificultad', '=', '1');
				});
				$preguntas_nivel_2 = Model_Pregunta::find(function ($query) use ($id_tema, $id_curso){
				return $query->join('Genera')
							 ->on('Genera.id_pregunta', '=', 'Pregunta.id_pregunta')
							 ->join('CursoPreguntasCompartidas')
							 ->on('CursoPreguntasCompartidas.id_pregunta', '=', 'Genera.id_pregunta')
							 ->where('CursoPreguntasCompartidas.id_curso', '=', $id_curso)
							 ->where('Genera.id_tema', '=', $id_tema)
							 ->where('Pregunta.dificultad', '=', '2');
				});
				$preguntas_nivel_3 = Model_Pregunta::find(function ($query) use ($id_tema, $id_curso){
				return $query->join('Genera')
							 ->on('Genera.id_pregunta', '=', 'Pregunta.id_pregunta')
							 ->join('CursoPreguntasCompartidas')
							 ->on('CursoPreguntasCompartidas.id_pregunta', '=', 'Genera.id_pregunta')
							 ->where('CursoPreguntasCompartidas.id_curso', '=', $id_curso)
							 ->where('Genera.id_tema', '=', $id_tema)
							 ->where('Pregunta.dificultad', '=', '3');
				});
				$cantidad_preguntas_nivel_1 = is_array($preguntas_nivel_1) ? sizeof($preguntas_nivel_1) : 0;
				$cantidad_preguntas_nivel_2 = is_array($preguntas_nivel_2) ? sizeof($preguntas_nivel_2) : 0;
				$cantidad_preguntas_nivel_3 = is_array($preguntas_nivel_3) ? sizeof($preguntas_nivel_3) : 0;

				$texto_tema = $tema_externo->nombre.':&nbsp;&nbsp;&nbsp;&nbsp;preguntas: N1: '.$cantidad_preguntas_nivel_1.', N2: '.$cantidad_preguntas_nivel_2.', N3: '.$cantidad_preguntas_nivel_3.'.';
				array_push($lista_de_temas, array($id_tema, $texto_tema));

				$input_preguntas_por_tema = Form::input('input_'.$id_tema.$sufijo_modal,$cantidad_preguntas_nivel_1.','.$cantidad_preguntas_nivel_2.','.$cantidad_preguntas_nivel_3,array('class'=>'form-control','type' => 'hidden'));
				$examen_lista_de_cantidad_de_preguntas = $examen_lista_de_cantidad_de_preguntas.$input_preguntas_por_tema;

				$input_nombre_por_tema = Form::input('input_tema_'.$id_tema.$sufijo_modal,$tema_externo->nombre,array('class'=>'form-control','type' => 'hidden'));
				$examen_lista_de_nombres_de_preguntas = $examen_lista_de_nombres_de_preguntas.$input_nombre_por_tema;

				if($is_modal && isset($id_examen)){
					$rango = Model_BasadoEn::find(array('id_examen' => $id_examen, 'id_tema' => $id_tema ));
					if(isset($rango))
						array_push($examen_temas_rangos, $rango->id_tema.'-'.$rango->desde_dificultad.'-'.$rango->hasta_dificultad);
				}
			}
		}
		if($is_modal){

			$examen = Model_Examen::find_one_by('id_examen', $id_examen);

			$examen_nombre = $examen->nombre;
			$examen_inicio = substr($examen->fecha_inicio, 0, 10);
			$examen_final = substr($examen->fecha_fin, 0, 10);
			$examen_cantidad_preguntas = $examen->preguntas_por_mostrar;
			$examen_vidas = $examen->vidas;
			$examen_oportunidades = $examen->oportunidades;

			$sufijo_modal = "_modal";
			$result =
			'<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="myModalLabel">Modificar Examen</h4>
					</div>
					<div class="modal-body">';
			$temas_y_niveles =	'<input type="hidden" id="examen_temas_modal" name="examen_temas_modal" value="'.implode(',', $examen_temas_rangos).'" onclick="javascript:rellenar_modal_examen_con_temas(examen_temas_modal,lista_de_preguntas_por_tema,examen_tema,examen_tema_nivel_desde,examen_tema_nivel_hasta);">';
								// <div class="col-xs-12 col-sm-12 table-row">
								// 	<div class="col-xs-1 col-sm-1 table-row">
								// 		<button type="button" class="btn btn-danger btn-block btn-lg">-</button>
								// 	</div>
								// 	<div class="col-xs-10 col-sm-10 table-row">
								// 		<span>Mi primer tema. &nbsp;&nbsp;&nbsp;&nbsp;Cantidad de preguntas:</span>
								// 		<span id="span_7">  N1: 3,   N2: 2,   N3: 1.</span>
								// 	</div>
								// </div>
								// <div class="col-xs-12 col-sm-12 table-row">
								// 	<div class="col-xs-1 col-sm-1 table-row">
								// 		<button type="button" class="btn btn-danger btn-block btn-lg">-</button>
								// 	</div>
								// 	<div class="col-xs-10 col-sm-10 table-row">
								// 		<span>Mi tercer tema. &nbsp;&nbsp;&nbsp;&nbsp;Cantidad de preguntas:</span>
								// 		<span id="span_9">  N1: 2,   N2: 2,   N3: 0.</span>
								// 	</div>
								// </div>';
		}
		$result = $result.Form::open(array('action' => 'curso/examen/crear_examen', 'accept-charset' => 'utf-8', 'method' => 'post', 'autocomplete' => 'off', 'onsubmit' => 'javascript:{return es_valido_formulario_crear_examen(\''.$sufijo_modal.'\')}'));
		$result = $result.'<div class="form-group">
								<div class="col-xs-12 col-sm-12 table">
									<div class="col-xs-12 col-sm-12">'.
										Form::label('Nombre', 'examen_nombre'.$sufijo_modal).'
									</div>
									<div class="col-xs-12 col-sm-12">'.
										Form::input('examen_nombre'.$sufijo_modal,$examen_nombre,array('class'=>'form-control','type' => 'text')).'
									</div>
								</div>
								<div class="col-xs-12 col-sm-12">'.
									Form::label('Vidas y oportunidades', '').'
								</div>
								<div class="col-xs-12 col-sm-12 table">
									<div class="col-xs-6 col-sm-6 table-row">
										<div class="col-xs-12 col-sm-12">'.
											Form::label('Vidas / Intentos', 'examen_vidas'.$sufijo_modal).'
										</div>
										<div class="col-xs-12 col-sm-12">'.
											Special_Selector::createSpecialSelector("examen_vidas".$sufijo_modal, "results_vidas".$sufijo_modal, $vidas,"..." , null, array('value' => $examen_vidas), $examen_vidas).'
										</div>
									</div>
									<div class="col-xs-6 col-sm-6 table-row">
										<div class="col-xs-12 col-sm-12">'.
											Form::label('Oportunidades por cada vida', 'examen_oportunidades'.$sufijo_modal).'
										</div>
										<div class="col-xs-12 col-sm-12">'.
											Special_Selector::createSpecialSelector("examen_oportunidades".$sufijo_modal, "results_oportunidades".$sufijo_modal, $oportunidades,"..." , null, array('value' => $examen_oportunidades), $examen_oportunidades).'
										</div>
									</div>
								</div>
								<div class="col-xs-12 col-sm-12">'.
									Form::label('Vigencia', '').'
								</div>
								<div class="col-xs-12 col-sm-12 table">
									<div class="col-xs-6 col-sm-6 table-row">
										<div class="col-xs-12 col-sm-12">'.
											Form::label('Inicio', 'examen_inicio'.$sufijo_modal).'
										</div>
										<div class="col-xs-12 col-sm-12">'.
											Form::input('examen_inicio'.$sufijo_modal,$examen_inicio,array('class'=>'form-control','type' => 'date', 'placeholder'=>'AAAA-MM-DD')).'
										</div>
									</div>
									<div class="col-xs-6 col-sm-6 table-row">
										<div class="col-xs-12 col-sm-12">'.
											Form::label('Final', 'examen_final'.$sufijo_modal).'
										</div>
										<div class="col-xs-12 col-sm-12">'.
											Form::input('examen_final'.$sufijo_modal,$examen_final,array('class'=>'form-control','type' => 'date', 'placeholder'=>'AAAA-MM-DD')).'
										</div>
									</div>
								</div>
								<div class="col-xs-12 col-sm-12">'.
									Form::label('Preguntas y temas', '').'
								</div>
								<div class="col-xs-12 col-sm-12 table">
									<div class="col-xs-6 col-sm-6 table-row">
										<div class="col-xs-12 col-sm-12">'.
											Form::label('Cantidad de preguntas', 'examen_cantidad_preguntas'.$sufijo_modal).'
										</div>
										<div class="col-xs-12 col-sm-12">'.
											Form::input('examen_cantidad_preguntas'.$sufijo_modal,$examen_cantidad_preguntas,array('class'=>'form-control','type' => 'text','onchange' => 'javascript:cambia_preguntas_faltantes('.($is_modal ? 'true':'false').');')).'
										</div>
									</div>
									<div class="col-xs-6 col-sm-6 table-row">
										<div class="col-xs-12 col-sm-12">'.
											Form::label('Preguntas por añadir', 'examen_faltante').'
										</div>
										<div class="col-xs-12 col-sm-12">'.
											'<div id="preguntas_faltantes'.$sufijo_modal.'">'.intval($examen_cantidad_preguntas)*$multiplo_total_preguntas.'</div>
											<div>'.
											Form::input("preguntas_agregadas".$sufijo_modal,'0', array('type' => 'hidden')).''.
											'</div>
											<div>'.
											Form::input("preguntas_multiplo".$sufijo_modal,$multiplo_total_preguntas, array('type' => 'hidden')).'
											</div>
										</div>
									</div>
								</div>'.
								Form::input("id_examen",$id_examen ? $id_examen : '', array('type' => 'hidden')).'
								<div class="col-xs-1"></div>
									<div class="col-xs-10">
										<button type="button" id="mostrarAgregarPreguntasPorTema'.$sufijo_modal.'" class="btn btn-primary btn-block btn-lg" onclick="mostrarFormulario(\'mostrarAgregarPreguntasPorTema'.$sufijo_modal.'\',\'agregarPreguntasPorTema'.$sufijo_modal.'\',\'+ Agregar preguntas\',\'- Cancelar agregar preguntas\')">+ Agregar preguntas</button>
										<div id="agregarPreguntasPorTema'.$sufijo_modal.'" class="row" style="display: none;">'.'
											<div class="col-xs-12 col-sm-12">'.
												Form::label('Tema', 'examen_tema'.$sufijo_modal).'
											</div>
											<div class="col-xs-12 col-sm-12">'.
												Special_Selector::createSpecialSelector("examen_tema".$sufijo_modal, "results_examen_tema".$sufijo_modal, $lista_de_temas,"Selecciona" , null, array('value' => $examen_tema), $examen_tema_id).'
												<div>'.
													$examen_lista_de_cantidad_de_preguntas.
													$examen_lista_de_nombres_de_preguntas.'
												</div>
											</div>
											<div class="col-xs-12 col-sm-12 table">
												<div class="col-xs-6 col-sm-6 table-row">
													<div class="col-xs-12 col-sm-12">'.
														Form::label('Desde nivel', 'examen_tema_nivel_desde'.$sufijo_modal).'
													</div>
													<div class="col-xs-12 col-sm-12">'.
														Special_Selector::createSpecialSelector("examen_tema_nivel_desde".$sufijo_modal, "results_examen_tema_nivel_desde".$sufijo_modal, $niveles,"..." , null, array('value' => $examen_tema_nivel_desde), $examen_tema_nivel_desde).'
													</div>
												</div>
												<div class="col-xs-6 col-sm-6 table-row">
													<div class="col-xs-12 col-sm-12">'.
														Form::label('Hasta nivel', 'examen_tema_nivel_hasta'.$sufijo_modal).'
													</div>
													<div class="col-xs-12 col-sm-12">'.
														Special_Selector::createSpecialSelector("examen_tema_nivel_hasta".$sufijo_modal, "results_examen_tema_nivel_hasta".$sufijo_modal, $niveles,"..." , null, array('value' => $examen_tema_nivel_hasta), $examen_tema_nivel_hasta).'
													</div>
												</div>
											</div>											
											<div class="col-xs-12 col-sm-12 table">
												<button type="button" id="agregarPreguntasPorTema'.$sufijo_modal.'" class="btn btn-primary btn-block" onclick="javascript:agregarPreguntasPorTemaYNivel(lista_de_preguntas_por_tema,examen_tema,examen_tema_nivel_desde,examen_tema_nivel_hasta,'.($is_modal ? 'true':'false').');">+ Agregar preguntas del tema y dificultad seleccionados</button>
											</div>
										</div>
									</div>								
								<div class="col-xs-1"></div>
								<br>
								<div id="lista_de_preguntas_por_tema'.$sufijo_modal.'" class="table" >
									<br>'.
									$temas_y_niveles.'
								</div>
							</div>';
		if($is_modal){
			$result = $result.'
					</div>
					<div class="modal-footer">
						  <div class="row text-center">
							<div class="col-xs-12">'.
								Html::anchor('curso/examen/presentar/'.$id_examen,'Probar vista previa del examen',array('class'=>'btn btn-primary btn-block btn-lg')).
								Form::input('pregunta_duplicada','', array('type' => 'hidden')).'
							</div>
							<br>	
							<div class="col-xs-6">
								<button type="button" class="btn btn-primary btn-block" data-dismiss="modal">Cancelar</button>
							</div>
							<div class="col-xs-6">'.
								Form::submit('guardar_examen','Guardar',array('class' => 'btn btn-danger btn-block')).'
							</div>
						  </div>
					  </div>
				</div>
			</div>';
		}else{
			$result = $result.'<br>
								<div class="col-xs-12 col-sm-12">'.
									Form::button('boton_agregar_examen', '+ Agregar', array('class' => 'btn btn-primary btn-block')).'
								</div>
								<br>';
		}
		$result = $result.Form::close();
		echo $result;
	}

	public static function getModalBibliografia($is_modal = false, $id_fuente = null, $numero = null){
		$result = '';
		$nombre_bibliografia = '';
		$autor_bibliografia = '';
		$numero_edicion_bibliografia = '';
		$anio_bibliografia = '';
		$link_bibliografia = '';
		$sufijo_modal = '';
		if($is_modal){
			$fuente = Model_Fuente::find_one_by('id_fuente', $id_fuente);
			$edicion = Model_Edicion::find(array($id_fuente, $numero));
			if(isset($fuente) && isset($edicion)){
				$nombre_bibliografia = $fuente->nombre;
				$autor_bibliografia = $fuente->autores;
				$numero_edicion_bibliografia = $edicion->numero;
				$anio_bibliografia = $edicion->anio;
				$link_bibliografia = $edicion->liga;
			}
			$sufijo_modal = "_modal";
			$result =
			'<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="myModalLabel">Modificar Bibliografía</h4>
					</div>
					<div class="modal-body">';
		}
		$result = $result.Form::open(array('action' => 'curso/examen/crear_bibliografia', 'accept-charset' => 'utf-8', 'method' => 'post', 'onsubmit' => 'javascript:{return es_valido_formulario_crear_bibliografia(\''.$sufijo_modal.'\')}'));
		$result = $result.'<div class="form-group">
								<div class="col-xs-12 col-sm-12">'.
									Form::label('Nombre', 'nombre_bibliografia').'
								</div>
								<div class="col-xs-12 col-sm-12">'.
									Form::input('nombre_bibliografia'.$sufijo_modal,$nombre_bibliografia,array('class'=>'form-control','type' => 'text', 'placeholder'=>'Nombre de la fuente')).'
								</div>
								<div class="col-xs-12 col-sm-12">'.
									Form::label('Autor(es)', 'autor_bibliografia').'
								</div>
								<div class="col-xs-12 col-sm-12">'.
									Form::input('autor_bibliografia'.$sufijo_modal,$autor_bibliografia,array('class'=>'form-control','type' => 'text', 'placeholder'=>'Nombre de los autores')).'
								</div>
								<div class="col-xs-12 col-sm-12">'.
									Form::label('Edición', 'edicion_bibliografia').'
								</div>
								<div class="col-xs-12 col-sm-12 table">
									<div class="col-xs-4 col-sm-4 table-row">
										<div class="col-xs-12 col-sm-12">'.
											Form::label('#', 'numero_edicion_bibliografia').'
										</div>
										<div class="col-xs-12 col-sm-12">'.
											Form::input('numero_edicion_bibliografia'.$sufijo_modal,$numero_edicion_bibliografia,array('class'=>'form-control','type' => 'text', 'placeholder'=>'Número')).'
										</div>
									</div>
									<div class="col-xs-8 col-sm-8 table-row">
										<div class="col-xs-12 col-sm-12">'.
											Form::label('Año', 'anio_bibliografia').'
										</div>
										<div class="col-xs-12 col-sm-12">'.
											Form::input('anio_bibliografia'.$sufijo_modal,$anio_bibliografia,array('class'=>'form-control','type' => 'text', 'placeholder'=>'Año')).'
										</div>
									</div>
								</div>
								<div class="col-xs-12 col-sm-12">'.
									Form::label('Enlace en línea (si existe)', 'link_bibliografia').'
								</div>'.
								Form::input("fuente_id",$id_fuente? $id_fuente : '', array('type' => 'hidden')).''.
								Form::input("fuente_numero",$numero ? $numero : '', array('type' => 'hidden')).'
								<div class="col-xs-12 col-sm-12">'.
									Form::input('link_bibliografia'.$sufijo_modal,$link_bibliografia,array('class'=>'form-control','type' => 'text', 'placeholder'=>'Enlace o link a la fuente')).'
								</div>'.
									($link_bibliografia!==null && $link_bibliografia!=="" ? 										
								'<br>
								<div class="col-xs-12 col-sm-12">'.
										Html::anchor($link_bibliografia,'Visitar la fuente',array('class'=>'form-control','target'=>'_blank')).'
								</div>'
								: "").'
								
							</div>';
		if($is_modal){
			$result = $result.'
					</div>
					<div class="modal-footer">
						  <div class="row text-center">
							<div class="col-xs-6">
								<button type="button" class="btn btn-primary btn-block" data-dismiss="modal">Cancelar</button>
							</div>
							<div class="col-xs-6">'.
								Form::submit('guardar_bibliografia','Guardar',array('class' => 'btn btn-danger btn-block')).'
							</div>
						  </div>
					  </div>
				</div>
			</div>';
		}else{
			$result = $result.'<br>
								<div class="col-xs-12 col-sm-12">'.
									Form::button('boton_agregar_bibliografia', '+ Agregar', array('class' => 'btn btn-primary btn-block')).'
								</div>
								<br>';
		}
		$result = $result.Form::close();
		echo $result;
	}

	public static function getModalPregunta($temas, $bibliografias, $tipos, $es_compartida = false, $is_modal = false, $id_pregunta = null){
		$pregunta_texto="";
		$pregunta_justificacion="";
		$pregunta_tiempo="";
		$pregunta_dificultad="";
		$pregunta_tema="";
		$pregunta_tema_id="";
		$pregunta_bibliografia="";
		$pregunta_bibliografia_id="";
		$pregunta_pagina="";
		$pregunta_capitulo="";
		$pregunta_tipo="";
		$pregunta_tipo_id="";
		$respuestas="";
		$cantidad_respuestas = "";

		if(isset($id_pregunta)){
			$pregunta = Model_Pregunta::find_one_by('id_pregunta', $id_pregunta);
			$pregunta_texto=$pregunta->texto;
			$pregunta_justificacion=$pregunta->justificacion;
			$pregunta_dificultad=$pregunta->dificultad;
			$pregunta_tiempo=$pregunta->tiempo;

			$tipos = Model_Tipo::find(function ($query) use ($id_pregunta){
				return $query->join('DeTipo')
						 ->on('DeTipo.id_tipo', '=', 'Tipo.id_tipo')
						 ->where('DeTipo.id_pregunta', '=', $id_pregunta);
			});
			$tipo = reset($tipos);
			$pregunta_tipo = $tipo->nombre;
			$pregunta_tipo_id = $tipo->id_tipo;

			$_bibliografias = Model_Referencia::find(function ($query) use ($id_pregunta){
				return $query->join('FundamentadoEn')
						 ->on('FundamentadoEn.id_referencia', '=', 'Referencia.id_referencia')
						 ->join('ReferenciaFuente')
						 ->on('ReferenciaFuente.id_referencia', '=', 'Referencia.id_referencia')
						 ->join('Fuente')
						 ->on('Fuente.id_fuente', '=', 'ReferenciaFuente.id_fuente')
						 ->join('Edicion')
						 ->on('Edicion.id_fuente', '=', 'Fuente.id_fuente')
						 ->where('FundamentadoEn.id_pregunta', '=', $id_pregunta);
			});
			$bibliografia = reset($_bibliografias);
			$pregunta_bibliografia = $bibliografia->nombre." - ".$bibliografia->autores.". Edición: ".$bibliografia->numero;
			$pregunta_bibliografia_id = $bibliografia->id_fuente.'.'.$bibliografia->numero;
			$pregunta_capitulo = $bibliografia->capitulo;
			$pregunta_pagina = $bibliografia->pagina;

			$_temas = Model_Tema::find(function ($query) use ($id_pregunta){
				return $query->join('Genera')
						 ->on('Genera.id_tema', '=', 'Tema.id_tema')
						 ->where('Genera.id_pregunta', '=', $id_pregunta);
			});
			$tema = reset($_temas);
			$pregunta_tema = $tema->nombre;
			$pregunta_tema_id = $tema->id_tema;

			$_respuestas = Model_Respuesta::find(function ($query) use ($id_pregunta){
				return $query->join('Contiene')
						 ->on('Contiene.id_respuesta', '=', 'Respuesta.id_respuesta')
						 ->where('Contiene.id_pregunta', '=', $id_pregunta);
			});
			$i = 1;
			$cantidad_respuestas_entero = 0;
			foreach ((array) $_respuestas as $respuesta) {
				$respuestas = $respuestas.'<div class="col-xs-12 col-sm-12 table">'.
									Form::input('pregunta_id_respuesta_'.$i.'_modal',$respuesta->id_respuesta, array('type' => 'hidden')).'
									<div class="col-xs-1 col-sm-1 table-row">'.
										Form::label('R.'.$i, 'pregunta_respuesta_'.$i.'_modal').'
									</div>
									<div class="col-xs-8 col-sm-8 table-row">'.
										Form::input('pregunta_respuesta_'.$i.'_modal',$respuesta->contenido,array('class'=>'form-control','type' => 'text')).'
									</div>
									<div class="col-xs-2 col-sm-2 table-row">'.
										Form::input('pregunta_respuesta_porcentaje_'.$i.'_modal',$respuesta->porcentaje,array('class'=>'form-control','type' => 'text')).'
									</div>
									<div class="col-xs-1 col-sm-1 table-row">'.
										Form::label('%', 'pregunta_respuesta_porcentaje_'.$i.'_modal').'
									</div>
								</div>
								<br>';
				$i++;
				$cantidad_respuestas_entero++;
			}
			if($cantidad_respuestas_entero){
				$cantidad_respuestas = strval($cantidad_respuestas_entero);
			}
			
		}else{
			$id_pregunta = '';
		}

		$result = '';
		$boton_agregar_tema = array("href" => "", "value" => "+ Agregar nuevo tema", "data-toggle" => "modal", "data-target" => "#modalAgregarTema");
		$lista_de_temas = [];
		if(isset($temas)){
			foreach ($temas as $tema) {
				array_push($lista_de_temas, array($tema->id_tema, $tema->nombre));
			}
		}

		$boton_agregar_bibliografia = array("href" => "", "value" => "+ Agregar nueva bibliografía", "data-toggle" => "modal", "data-target" => "#modalAgregarBibliografia");
		$lista_de_fuentes = [];
		if(isset($bibliografias)){
			foreach ($bibliografias as $fuente) {
				array_push($lista_de_fuentes, array($fuente->id_fuente.'.'.$fuente->numero, $fuente->nombre." - ".$fuente->autores.". Edición: ".$fuente->numero));
			}
		}


		$dificultades = array(array(1,1),array(2,2),array(3,3));


		$lista_de_tipos = [];
		if(isset($tipos)){
			foreach ($tipos as $tipo) {
				array_push($lista_de_tipos, array($tipo->id_tipo, $tipo->nombre));
			}
		}
		$boton_extra=null;
		$tipo_attributes=array('value' => $pregunta_tipo);

		$sufijo_modal = "";
		if($is_modal){
			$tipo_attributes = array_merge($tipo_attributes, array('disabled' => 'true'));
			$boton_agregar_tema = null;
			$boton_agregar_bibliografia = null;
			$sufijo_modal = "_modal";
			$result =
			'<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="myModalLabel">Modificar Pregunta</h4>
					</div>
					<div class="modal-body">';
		}
		$result = $result.Form::open(array('action' => 'curso/examen/crear_pregunta', 'accept-charset' => 'utf-8', 'method' => 'post',  'id' => 'pregunta_formulario'.$sufijo_modal, 'autocomplete' => 'off', 'onsubmit' => 'javascript:{return es_valido_formulario_crear_pregunta(\''.$sufijo_modal.'\')}'));

		$result = $result.'
							<div class="form-group">
								<div class="col-xs-12 col-sm-12">'.
									Form::label('Tema', 'pregunta_tema'.$sufijo_modal).'
								</div>
								<div class="col-xs-12 col-sm-12 table">'.
									Special_Selector::createSpecialSelector("pregunta_tema".$sufijo_modal, "results_tema".$sufijo_modal, $lista_de_temas,"Selecciona o crea un tema" , $boton_agregar_tema, array('value' => $pregunta_tema), $pregunta_tema_id).'
								</div>
								<div class="col-xs-12 col-sm-12">'.
									Form::label('Bibliografía', 'pregunta_bibliografia'.$sufijo_modal).'
								</div>
								<div class="col-xs-12 col-sm-12">'.
									Special_Selector::createSpecialSelector("pregunta_bibliografia".$sufijo_modal, "results_fuente".$sufijo_modal, $lista_de_fuentes,"Selecciona una fuente" , $boton_agregar_bibliografia,array('value' => $pregunta_bibliografia),$pregunta_bibliografia_id).'
								</div>
								<div class="col-xs-12 col-sm-12 table">
									<div class="col-xs-4 col-sm-4 table-row">
										<div class="col-xs-12 col-sm-12">'.
											Form::label('Página', 'pregunta_bibliografia_pagina'.$sufijo_modal).'
										</div>
										<div class="col-xs-12 col-sm-12">'.
											Form::input('pregunta_bibliografia_pagina'.$sufijo_modal,$pregunta_pagina,array('class'=>'form-control','type' => 'text', 'placeholder'=>'Página')).'
										</div>
									</div>
									<div class="col-xs-8 col-sm-8 table-row">
										<div class="col-xs-12 col-sm-12">'.
											Form::label('Capítulo', 'pregunta_bibliografia_capitulo'.$sufijo_modal).'
										</div>
										<div class="col-xs-12 col-sm-12">'.
											Form::input('pregunta_bibliografia_capitulo'.$sufijo_modal,$pregunta_capitulo,array('class'=>'form-control','type' => 'text', 'placeholder'=>'Capítulo')).'
										</div>
									</div>
								</div>

								<div class="col-xs-12 col-sm-12 table">
									<div class="col-xs-4 col-sm-4 table-row">
										<div>'.
											Form::label('Dificultad', 'pregunta_dificultad'.$sufijo_modal).'
										</div>
										<div>'.
											Special_Selector::createSpecialSelector("pregunta_dificultad".$sufijo_modal, "results_dificultad".$sufijo_modal, $dificultades,"...",null,array('value' => $pregunta_dificultad ),$pregunta_dificultad).'
										</div>
									</div>
									<div class="col-xs-4 col-sm-4 table-row">
										<div class="col-xs-12 col-sm-12">'.
											Form::label('Tiempo', 'pregunta_tiempo'.$sufijo_modal).'
										</div>
										<div class="col-xs-12 col-sm-12">'.
											Form::input('pregunta_tiempo'.$sufijo_modal,$pregunta_tiempo,array('class'=>'form-control','type' => 'text', 'placeholder'=>'segs')).'
										</div>
									</div>
									<div class="col-xs-4 col-sm-4 table-row">
										<div class="col-xs-12 col-sm-12">'.
											Form::label('Tipo', 'pregunta_tipo'.$sufijo_modal).'
										</div>
										<div class="col-xs-12 col-sm-12">'.
											Special_Selector::createSpecialSelector("pregunta_tipo".$sufijo_modal, "results_tipo".$sufijo_modal, $lista_de_tipos,"Selecciona un tipo",$boton_extra,$tipo_attributes,$pregunta_tipo_id).'
										</div>
									</div>
								</div>
								<div class="col-xs-12 col-sm-12">'.
									Form::label('Pregunta', 'pregunta_texto'.$sufijo_modal).'
								</div>
								<div class="col-xs-12 col-sm-12">'.
									Form::input('pregunta_texto'.$sufijo_modal,$pregunta_texto,array('class'=>'form-control','type' => 'text', 'placeholder'=>'Texto, URLVideo o URLImágen')).'
								</div>

								<div class="col-xs-12 col-sm-12">'.
									Form::label('Respuestas y porcentaje', '').'
								</div>
								<div id="respuestas'.$sufijo_modal.'"">
									<!-- Aquí van las respuestas -->'.
									$respuestas.'
									*-* Selecciona un tipo de pregunta primero *-*
								</div>'.
									Form::input('pregunta_cantidad_respuestas'.$sufijo_modal,$cantidad_respuestas, array('type' => 'hidden')).'
								<div class="col-xs-12 col-sm-12">'.
									Form::label('Justificación', 'pregunta_justificacion'.$sufijo_modal).'
								</div>'.
									Form::input("pregunta_id",$id_pregunta, array('type' => 'hidden')).'
								<div class="col-xs-12 col-sm-12">'.
									Form::input('pregunta_justificacion'.$sufijo_modal,$pregunta_justificacion,array('class'=>'form-control','type' => 'text', 'placeholder'=>'Justificación')).'
								</div>
							</div>';
		if($is_modal){
			$result = $result.'
					</div>
					<div class="modal-footer">
						  <div class="row text-center">
							<div class="col-xs-12">
								<button type="button" class="btn btn-primary btn-block" onclick="javascript:duplicaPregunta()">Duplicar pregunta</button>'.
								Form::input('pregunta_duplicada','', array('type' => 'hidden')).'
							</div>
							<br>
							<div class="col-xs-6">
								<button type="button" class="btn btn-primary btn-block" data-dismiss="modal">Cancelar</button>
							</div>
							<div class="col-xs-6">
								<button type="button" class="btn btn-danger btn-block" onclick="javascript:muestraModalActualizarPreguntaCompartida('.$es_compartida.')">Guardar</button>
							</div>
						  </div>
					  </div>
				</div>
			</div>';
		}else{
			$result = $result.'<br>
								<div class="col-xs-12 col-sm-12">'.
									Form::button('boton_agregar_pregunta', '+ Agregar', array('class' => 'btn btn-primary btn-block')).'
								</div>
								<br>';
		}
		$result = $result.Form::close();
		return $result;
	}

	public static function getModalPreguntaCompartida($id_pregunta = null, $materia, $id_curso_compartido, $checked){
		$pregunta_texto="";
		$pregunta_justificacion="";
		$pregunta_tiempo="";
		$pregunta_dificultad="";
		$pregunta_tema="";
		$pregunta_bibliografia="";
		$pregunta_pagina="";
		$pregunta_capitulo="";
		$pregunta_tipo="";
		$pregunta_tipo_id="";
		$respuestas="";
		$cantidad_respuestas = "";

		if(isset($id_pregunta)){
			$pregunta = Model_Pregunta::find_one_by('id_pregunta', $id_pregunta);
			$pregunta_texto=$pregunta->texto;
			$pregunta_justificacion=$pregunta->justificacion;
			$pregunta_dificultad=$pregunta->dificultad;
			$pregunta_tiempo=$pregunta->tiempo;

			$tipos = Model_Tipo::find(function ($query) use ($id_pregunta){
				return $query->join('DeTipo')
						 ->on('DeTipo.id_tipo', '=', 'Tipo.id_tipo')
						 ->where('DeTipo.id_pregunta', '=', $id_pregunta);
			});
			$tipo = reset($tipos);
			$pregunta_tipo = $tipo->nombre;
			$pregunta_tipo_id = $tipo->id_tipo;

			$_bibliografias = Model_Referencia::find(function ($query) use ($id_pregunta){
				return $query->join('FundamentadoEn')
						 ->on('FundamentadoEn.id_referencia', '=', 'Referencia.id_referencia')
						 ->join('ReferenciaFuente')
						 ->on('ReferenciaFuente.id_referencia', '=', 'Referencia.id_referencia')
						 ->join('Fuente')
						 ->on('Fuente.id_fuente', '=', 'ReferenciaFuente.id_fuente')
						 ->join('Edicion')
						 ->on('Edicion.id_fuente', '=', 'Fuente.id_fuente')
						 ->where('FundamentadoEn.id_pregunta', '=', $id_pregunta);
			});
			$bibliografia = reset($_bibliografias);
			$pregunta_bibliografia = $bibliografia->nombre." - ".$bibliografia->autores.". Edición: ".$bibliografia->numero;
			$pregunta_capitulo = $bibliografia->capitulo;
			$pregunta_pagina = $bibliografia->pagina;

			$_temas = Model_Tema::find(function ($query) use ($id_pregunta){
				return $query->join('Genera')
						 ->on('Genera.id_tema', '=', 'Tema.id_tema')
						 ->where('Genera.id_pregunta', '=', $id_pregunta);
			});
			$tema = reset($_temas);
			$pregunta_tema = $tema->nombre;

			$_respuestas = Model_Respuesta::find(function ($query) use ($id_pregunta){
				return $query->join('Contiene')
						 ->on('Contiene.id_respuesta', '=', 'Respuesta.id_respuesta')
						 ->where('Contiene.id_pregunta', '=', $id_pregunta);
			});
			$i = 1;
			$cantidad_respuestas_entero = 0;
			foreach ((array) $_respuestas as $respuesta) {
				$respuestas = $respuestas.'<div class="col-xs-12 col-sm-12 table">'.
									Form::input('pregunta_id_respuesta_'.$i.'_modal',$respuesta->id_respuesta, array('type' => 'hidden')).'
									<div class="col-xs-1 col-sm-1 table-row">'.
										Form::label('R.'.$i, 'pregunta_respuesta_'.$i.'_modal').'
									</div>
									<div class="col-xs-8 col-sm-8 table-row">'.
										Form::input('pregunta_respuesta_'.$i.'_modal',$respuesta->contenido,array('disabled' => 'true','class'=>'form-control','type' => 'text')).'
									</div>
									<div class="col-xs-2 col-sm-2 table-row">'.
										Form::input('pregunta_respuesta_porcentaje_'.$i.'_modal',$respuesta->porcentaje,array('disabled' => 'true','class'=>'form-control','type' => 'text')).'
									</div>
									<div class="col-xs-1 col-sm-1 table-row">'.
										Form::label('%', 'pregunta_respuesta_porcentaje_'.$i.'_modal').'
									</div>
								</div>
								<br>';
				$i++;
				$cantidad_respuestas_entero++;
			}
			if($cantidad_respuestas_entero){
				$cantidad_respuestas = strval($cantidad_respuestas_entero);
			}
		}else{
			$id_pregunta = '';
		}

		$result = '';

		$boton_agregar_bibliografia = array("href" => "", "value" => "+ Agregar nueva bibliografía", "data-toggle" => "modal", "data-target" => "#modalAgregarBibliografia");

		$dificultades = array(array(1,1),array(2,2),array(3,3));

		$boton_agregar_bibliografia = null;
		$sufijo_modal = "_modal";
		$result =
		'<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Pregunta Compartida</h4>
				</div>
				<div class="modal-body">';
		$result = $result.Form::open('curso/examen/agregar_pregunta_compartida');

		$result = $result.'
							<div class="form-group">
								<div class="col-xs-12 col-sm-12">'.
									Form::label('Tema', 'pregunta_tema'.$sufijo_modal).'
								</div>
								<div class="col-xs-12 col-sm-12 table">'.$pregunta_tema.'
								</div>
								<div class="col-xs-12 col-sm-12">'.
									Form::label('Bibliografía', 'pregunta_bibliografia'.$sufijo_modal).'
								</div>
								<div class="col-xs-12 col-sm-12">'.$pregunta_bibliografia.'
								</div>
								<div class="col-xs-12 col-sm-12 table">
									<div class="col-xs-4 col-sm-4 table-row">
										<div class="col-xs-12 col-sm-12">'.
											Form::label('Página', 'pregunta_bibliografia_pagina'.$sufijo_modal).'
										</div>
										<div class="col-xs-12 col-sm-12">'.
											Form::input('pregunta_bibliografia_pagina'.$sufijo_modal,$pregunta_pagina,array('disabled' => 'true','class'=>'form-control','type' => 'text', 'placeholder'=>'Página')).'
										</div>
									</div>
									<div class="col-xs-8 col-sm-8 table-row">
										<div class="col-xs-12 col-sm-12">'.
											Form::label('Capítulo', 'pregunta_bibliografia_capitulo'.$sufijo_modal).'
										</div>
										<div class="col-xs-12 col-sm-12">'.
											Form::input('pregunta_bibliografia_capitulo'.$sufijo_modal,$pregunta_capitulo,array('disabled' => 'true','class'=>'form-control','type' => 'text', 'placeholder'=>'Capítulo')).'
										</div>
									</div>
								</div>

								<div class="col-xs-12 col-sm-12 table">
									<div class="col-xs-4 col-sm-4 table-row">
										<div>'.
											Form::label('Dificultad', 'pregunta_dificultad'.$sufijo_modal).'
										</div>
										<div>'.$pregunta_dificultad.'
										</div>
									</div>
									<div class="col-xs-4 col-sm-4 table-row">
										<div class="col-xs-12 col-sm-12">'.
											Form::label('Tiempo', 'pregunta_tiempo'.$sufijo_modal).'
										</div>
										<div class="col-xs-12 col-sm-12">'.
											Form::input('pregunta_tiempo'.$sufijo_modal,$pregunta_tiempo,array('disabled' => 'true','class'=>'form-control','type' => 'text', 'placeholder'=>'segs')).'
										</div>
									</div>
									<div class="col-xs-4 col-sm-4 table-row">
										<div class="col-xs-12 col-sm-12">'.
											Form::label('Tipo', 'pregunta_tipo'.$sufijo_modal).'
										</div>
										<div class="col-xs-12 col-sm-12">'.$pregunta_tipo.'
										</div>
									</div>
								</div>
								<div class="col-xs-12 col-sm-12">'.
									Form::label('Pregunta', 'pregunta_texto'.$sufijo_modal).'
								</div>
								<div class="col-xs-12 col-sm-12">'.
									Form::input('pregunta_texto'.$sufijo_modal,$pregunta_texto,array('disabled' => 'true','class'=>'form-control','type' => 'text', 'placeholder'=>'Texto, URLVideo o URLImágen')).'
								</div>

								<div class="col-xs-12 col-sm-12">'.
									Form::label('Respuestas y porcentaje', '').'
								</div>
								<div id="respuestas'.$sufijo_modal.'"">
									<!-- Aquí van las respuestas -->'.
									$respuestas.'
									*-* Selecciona un tipo de pregunta primero *-*
								</div>'.
									Form::input('pregunta_cantidad_respuestas'.$sufijo_modal,$cantidad_respuestas, array('type' => 'hidden')).'
								<div class="col-xs-12 col-sm-12">'.
									Form::label('Justificación', 'pregunta_justificacion'.$sufijo_modal).'
								</div>'.
									Form::input("pregunta_id",$id_pregunta, array('type' => 'hidden')).
									Form::input("materia",$materia, array('type' => 'hidden')).
									Form::input("id_curso_compartido",$id_curso_compartido, array('type' => 'hidden')).'
								<div class="col-xs-12 col-sm-12">'.
									Form::input('pregunta_justificacion'.$sufijo_modal,$pregunta_justificacion,array('disabled' => 'true','class'=>'form-control','type' => 'text', 'placeholder'=>'Justificación')).'
								</div>
							</div>';
		$result = $result.'
				</div>
				<div class="modal-footer">
					  <div class="row text-center">
						<div class="col-xs-6">
							<button type="button" class="btn btn-primary btn-block" data-dismiss="modal">Cancelar</button>
						</div>
						<div class="col-xs-6">'.
							Form::submit('agregar_pregunta',($checked ? 'Borrar':'Agregar'),array('class' => 'btn btn-'.($checked ? 'danger':'success').' btn-block')).'
						</div>
					  </div>
				  </div>
			</div>
		</div>';
		$result = $result.Form::close();
		return $result;
	}

	public static function getModalPreguntaCompartidaActualizada($id_pregunta = null, $materia, $id_curso_compartido, $checked){
		$pregunta_texto="";
		$pregunta_justificacion="";
		$pregunta_tiempo="";
		$pregunta_dificultad="";
		$pregunta_tema="";
		$pregunta_bibliografia="";
		$pregunta_pagina="";
		$pregunta_capitulo="";
		$pregunta_tipo="";
		$pregunta_tipo_id="";
		$respuestas="";
		$cantidad_respuestas = "";


		$pregunta_respaldo_texto="";
		$pregunta_respaldo_justificacion="";
		$pregunta_respaldo_tiempo="";
		$pregunta_respaldo_dificultad="";
		$pregunta_respaldo_tema="";
		$pregunta_respaldo_bibliografia="";
		$pregunta_respaldo_pagina="";
		$pregunta_respaldo_capitulo="";
		$pregunta_respaldo_tipo="";
		$pregunta_respaldo_tipo_id="";
		$respuestas_respaldo="";
		$cantidad_respuestas_respaldo = "";

		if(isset($id_pregunta)){
			$id_pregunta_respaldo = $id_pregunta;
			$pregunta_respaldo = Model_Pregunta::find_one_by('id_pregunta', $id_pregunta_respaldo);
			$respaldo_lista = Model_RespaldoDe::find('all',array('where' => array(array('id_pregunta_respaldo', $id_pregunta_respaldo))));
			$respaldo = reset($respaldo_lista);
			$id_pregunta = $respaldo->id_pregunta;
			$pregunta = Model_Pregunta::find_one_by('id_pregunta', $id_pregunta);

			$pregunta_texto=$pregunta->texto;
			$pregunta_justificacion=$pregunta->justificacion;
			$pregunta_dificultad=$pregunta->dificultad;
			$pregunta_tiempo=$pregunta->tiempo;


			$pregunta_respaldo_texto=$pregunta_respaldo->texto;
			$pregunta_respaldo_justificacion=$pregunta_respaldo->justificacion;
			$pregunta_respaldo_dificultad=$pregunta_respaldo->dificultad;
			$pregunta_respaldo_tiempo=$pregunta_respaldo->tiempo;
			/* Tipos */
			$tipos = Model_Tipo::find(function ($query) use ($id_pregunta){
				return $query->join('DeTipo')
						 ->on('DeTipo.id_tipo', '=', 'Tipo.id_tipo')
						 ->where('DeTipo.id_pregunta', '=', $id_pregunta);
			});
			$tipo = reset($tipos);
			$pregunta_tipo = $tipo->nombre;
			$pregunta_tipo_id = $tipo->id_tipo;

			$tipos_respaldo = Model_Tipo::find(function ($query) use ($id_pregunta_respaldo){
				return $query->join('DeTipo')
						 ->on('DeTipo.id_tipo', '=', 'Tipo.id_tipo')
						 ->where('DeTipo.id_pregunta', '=', $id_pregunta_respaldo);
			});
			$tipo_respaldo = reset($tipos);
			$pregunta_respaldo_tipo = $tipo_respaldo->nombre;
			$pregunta_respaldo_tipo_id = $tipo_respaldo->id_tipo;
			/* /Tipos */
			/* Bibliografías */
			$_bibliografias = Model_Referencia::find(function ($query) use ($id_pregunta){
				return $query->join('FundamentadoEn')
						 ->on('FundamentadoEn.id_referencia', '=', 'Referencia.id_referencia')
						 ->join('ReferenciaFuente')
						 ->on('ReferenciaFuente.id_referencia', '=', 'Referencia.id_referencia')
						 ->join('Fuente')
						 ->on('Fuente.id_fuente', '=', 'ReferenciaFuente.id_fuente')
						 ->join('Edicion')
						 ->on('Edicion.id_fuente', '=', 'Fuente.id_fuente')
						 ->where('FundamentadoEn.id_pregunta', '=', $id_pregunta);
			});
			$bibliografia = reset($_bibliografias);
			$pregunta_bibliografia = $bibliografia->nombre." - ".$bibliografia->autores.". Edición: ".$bibliografia->numero;
			$pregunta_capitulo = $bibliografia->capitulo;
			$pregunta_pagina = $bibliografia->pagina;

			$_bibliografias_respaldo = Model_Referencia::find(function ($query) use ($id_pregunta_respaldo){
				return $query->join('FundamentadoEn')
						 ->on('FundamentadoEn.id_referencia', '=', 'Referencia.id_referencia')
						 ->join('ReferenciaFuente')
						 ->on('ReferenciaFuente.id_referencia', '=', 'Referencia.id_referencia')
						 ->join('Fuente')
						 ->on('Fuente.id_fuente', '=', 'ReferenciaFuente.id_fuente')
						 ->join('Edicion')
						 ->on('Edicion.id_fuente', '=', 'Fuente.id_fuente')
						 ->where('FundamentadoEn.id_pregunta', '=', $id_pregunta_respaldo);
			});
			$bibliografia_respaldo = reset($_bibliografias_respaldo);
			$pregunta_respaldo_bibliografia = $bibliografia_respaldo->nombre." - ".$bibliografia_respaldo->autores.". Edición: ".$bibliografia_respaldo->numero;
			$pregunta_respaldo_capitulo = $bibliografia_respaldo->capitulo;
			$pregunta_respaldo_pagina = $bibliografia_respaldo->pagina;
			/* /Bibliografías */
			/* Tema */
			$_temas = Model_Tema::find(function ($query) use ($id_pregunta){
				return $query->join('Genera')
						 ->on('Genera.id_tema', '=', 'Tema.id_tema')
						 ->where('Genera.id_pregunta', '=', $id_pregunta);
			});
			$tema = reset($_temas);
			$pregunta_tema = $tema->nombre;

			$_temas_respaldo = Model_Tema::find(function ($query) use ($id_pregunta_respaldo){
				return $query->join('Genera')
						 ->on('Genera.id_tema', '=', 'Tema.id_tema')
						 ->where('Genera.id_pregunta', '=', $id_pregunta_respaldo);
			});
			$tema_respaldo = reset($_temas_respaldo);
			$pregunta_respaldo_tema = $tema_respaldo->nombre;
			/* /Tema */
			$_respuestas = Model_Respuesta::find(function ($query) use ($id_pregunta){
				return $query->join('Contiene')
						 ->on('Contiene.id_respuesta', '=', 'Respuesta.id_respuesta')
						 ->where('Contiene.id_pregunta', '=', $id_pregunta);
			});
			$i = 1;
			$cantidad_respuestas_entero = 0;

			$_respuestas_respaldo = Model_Respuesta::find(function ($query) use ($id_pregunta_respaldo){
				return $query->join('Contiene')
						 ->on('Contiene.id_respuesta', '=', 'Respuesta.id_respuesta')
						 ->where('Contiene.id_pregunta', '=', $id_pregunta_respaldo);
			});
			$j = 0;
			$cantidad_respuestas_respaldo_entero = 0;
			foreach ((array) $_respuestas as $respuesta) {
				$respuestas = $respuestas.'<div class="col-xs-12 col-sm-12 table">'.
									Form::input('pregunta_id_respuesta_'.$i.'_modal',$respuesta->id_respuesta, array('type' => 'hidden')).'
									<div class="col-xs-1 col-sm-1 table-row">'.
										Form::label('R.'.$i, 'pregunta_respuesta_'.$i.'_modal').'
									</div>
									<div class="col-xs-8 col-sm-8 table-row">'.
										Form::input('pregunta_respuesta_'.$i.'_modal',$respuesta->contenido,array('disabled' => 'true','class'=>'form-control','type' => 'text')).'
									</div>
									<div class="col-xs-2 col-sm-2 table-row">'.
										Form::input('pregunta_respuesta_porcentaje_'.$i.'_modal',$respuesta->porcentaje,array('disabled' => 'true','class'=>'form-control','type' => 'text')).'
									</div>
									<div class="col-xs-1 col-sm-1 table-row">'.
										Form::label('%', 'pregunta_respuesta_porcentaje_'.$i.'_modal').'
									</div>
								</div>
								'.(($_respuestas_respaldo[$j]->contenido !== $respuesta->contenido ||
								$_respuestas_respaldo[$j]->porcentaje !== $respuesta->porcentaje) ?
								'<div class="col-xs-12 col-sm-12 table">'.
									Form::input('pregunta_id_respuesta_'.$i.'_modal',$_respuestas_respaldo[$j]->id_respuesta, array('type' => 'hidden')).'
									<div class="col-xs-1 col-sm-1 table-row">'.
										Form::label('R.'.$i, 'pregunta_respuesta_'.$i.'_modal').'
									</div>
									<div class="col-xs-8 col-sm-8 table-row update-alert-input">'.
										$_respuestas_respaldo[$j]->contenido.'
									</div>
									<div class="col-xs-2 col-sm-2 table-row update-alert-input">'.
										$_respuestas_respaldo[$j]->porcentaje.'
									</div>
									<div class="col-xs-1 col-sm-1 table-row">'.
										Form::label('%', 'pregunta_respuesta_porcentaje_'.$i.'_modal').'
									</div>
								</div>':'').'
								<br>';
				$i++;
				$j++;
				$cantidad_respuestas_entero++;
			}
			if($cantidad_respuestas_entero){
				$cantidad_respuestas = strval($cantidad_respuestas_entero);
			}
		}else{
			$id_pregunta = '';
		}

		$result = '';

		$boton_agregar_bibliografia = null;
		$sufijo_modal = "_modal";
		$result =
		'<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Pregunta Compartida Actualizada</h4>
				</div>
				<div class="modal-body">
					<div class="update-alert">
						<h4>Actualización requerida</h4>
						<p>Los valores antiguos están en color azul.</p>
					</div>';
		$result = $result.Form::open('curso/examen/actualizar_pregunta_compartida');

		$result = $result.'
							<div class="form-group">
								<div class="col-xs-12 col-sm-12">'.
									Form::label('Tema', 'pregunta_tema'.$sufijo_modal).'
								</div>
								<div class="col-xs-12 col-sm-12">'.$pregunta_tema.'
								</div>
								'.($pregunta_respaldo_tema !== $pregunta_tema ?
								'<div class="col-xs-12 col-sm-12 update-alert">'.$pregunta_respaldo_tema.'
								</div>':'').'
								<br/>
								<div class="col-xs-12 col-sm-12" table>'.
									Form::label('Bibliografía', 'pregunta_bibliografia'.$sufijo_modal).'
								</div>
								<div class="col-xs-12 col-sm-12">'.$pregunta_bibliografia.'
								</div>
								'.($pregunta_respaldo_bibliografia !== $pregunta_bibliografia ?
								'<div class="col-xs-12 col-sm-12 update-alert">'.$pregunta_respaldo_bibliografia.'
								</div>':'').'
								<div class="col-xs-12 col-sm-12 table">
									<div class="col-xs-4 col-sm-4 table-row">
										<div class="col-xs-12 col-sm-12">'.
											Form::label('Página', 'pregunta_bibliografia_pagina'.$sufijo_modal).'
										</div>
										<div class="col-xs-12 col-sm-12">'.
											Form::input('pregunta_bibliografia_pagina'.$sufijo_modal,$pregunta_pagina,array('disabled' => 'true','class'=>'form-control','type' => 'text', 'placeholder'=>'Página')).'
										</div>
										'.($pregunta_respaldo_pagina !== $pregunta_pagina ?
										'<div class="col-xs-12 col-sm-12 update-alert-input">'.
											$pregunta_respaldo_pagina.'
										</div>':'').'
									</div>
									<div class="col-xs-8 col-sm-8 table-row">
										<div class="col-xs-12 col-sm-12">'.
											Form::label('Capítulo', 'pregunta_bibliografia_capitulo'.$sufijo_modal).'
										</div>
										<div class="col-xs-12 col-sm-12">'.
											Form::input('pregunta_bibliografia_capitulo'.$sufijo_modal,$pregunta_capitulo,array('disabled' => 'true','class'=>'form-control','type' => 'text', 'placeholder'=>'Capítulo')).'
										</div>
										'.($pregunta_respaldo_capitulo !== $pregunta_capitulo ?
										'<div class="col-xs-12 col-sm-12 update-alert-input">'.
											$pregunta_respaldo_capitulo.'
										</div>':'').'
									</div>
								</div>

								<div class="col-xs-12 col-sm-12 table">
									<div class="col-xs-4 col-sm-4 table-row">
										<div class="col-xs-12 col-sm-12">'.
											Form::label('Dificultad', 'pregunta_dificultad'.$sufijo_modal).'
										</div>
										<div class="col-xs-12 col-sm-12">'.$pregunta_dificultad.'
										</div>
										'.($pregunta_respaldo_dificultad !== $pregunta_dificultad ?
										'<div class="col-xs-12 col-sm-12 update-alert">'.
											$pregunta_respaldo_dificultad.'
										</div>':'').'
									</div>
									<div class="col-xs-4 col-sm-4 table-row">
										<div class="col-xs-12 col-sm-12">'.
											Form::label('Tiempo', 'pregunta_tiempo'.$sufijo_modal).'
										</div>
										<div class="col-xs-12 col-sm-12">'.$pregunta_tiempo.'
										</div>
										'.($pregunta_respaldo_tiempo !== $pregunta_tiempo ?
										'<div class="col-xs-12 col-sm-12 update-alert">'.
											$pregunta_respaldo_tiempo.'
										</div>':'').'
									</div>
									<div class="col-xs-4 col-sm-4 table-row">
										<div class="col-xs-12 col-sm-12">'.
											Form::label('Tipo', 'pregunta_tipo'.$sufijo_modal).'
										</div>
										<div class="col-xs-12 col-sm-12">'.$pregunta_tipo.'
										</div>
										'.($pregunta_respaldo_tipo !== $pregunta_tipo ?
										'<div class="col-xs-12 col-sm-12 update-alert">'.
											$pregunta_respaldo_tipo.'
										</div>':'').'
									</div>
								</div>
								<div class="col-xs-12 col-sm-12">'.
									Form::label('Pregunta', 'pregunta_texto'.$sufijo_modal).'
								</div>
								<div class="col-xs-12 col-sm-12">'.
									Form::input('pregunta_texto'.$sufijo_modal,$pregunta_texto,array('disabled' => 'true','class'=>'form-control','type' => 'text', 'placeholder'=>'Texto, URLVideo o URLImágen')).'
								</div>
								'.($pregunta_respaldo_texto !== $pregunta_texto ?
								'<div class="col-xs-12 col-sm-12 update-alert-input">'.
									$pregunta_respaldo_texto.'
								</div>':'').'

								<div class="col-xs-12 col-sm-12">'.
									Form::label('Respuestas y porcentaje', '').'
								</div>
								<div id="respuestas'.$sufijo_modal.'"">
									<!-- Aquí van las respuestas -->'.
									$respuestas.'
									*-* Selecciona un tipo de pregunta primero *-*
								</div>
								<div class="col-xs-12 col-sm-12">'.
									Form::label('Justificación', 'pregunta_justificacion'.$sufijo_modal).'
								</div>'.
									Form::input("pregunta_id",$id_pregunta, array('type' => 'hidden')).
									Form::input("materia",$materia, array('type' => 'hidden')).
									Form::input("id_curso_compartido",$id_curso_compartido, array('type' => 'hidden')).'
								<div class="col-xs-12 col-sm-12">'.
									Form::input('pregunta_justificacion'.$sufijo_modal,$pregunta_justificacion,array('disabled' => 'true','class'=>'form-control','type' => 'text', 'placeholder'=>'Justificación')).'
								</div>
								'.($pregunta_respaldo_justificacion !== $pregunta_justificacion ?
								'<div class="col-xs-12 col-sm-12 update-alert-input">'.
									$pregunta_respaldo_justificacion.'
								</div>':'').'
							</div>';
		$result = $result.'
				</div>
				<div class="modal-footer">
					  <div class="row text-center">
						<div class="col-xs-4">
							<button type="button" class="btn btn-primary btn-block" data-dismiss="modal">Cancelar</button>
						</div>
						<div class="col-xs-4">'.
							Html::anchor('curso/examen/guardar_pregunta_compartida/'.$id_pregunta,'Respaldar y Actualizar',array('class'=>'btn btn-success btn-block')).'
						</div>
						<div class="col-xs-4">'.
							Form::submit('actualizar_pregunta_respaldo','Solo Actualizar',array('class' => 'btn btn-danger btn-block')).'
						</div>
					  </div>
				  </div>
			</div>
		</div>';
		$result = $result.Form::close();
		return $result;
	}

	public static function getModalPreguntaCompartidaFormulario($profesores){
		$result = '';
		$lista_de_profesores = [];
		if(isset($tipos)){
			foreach ($tipos as $tipo) {
				array_push($lista_de_profesores, array($tipo->id_tipo, $tipo->nombre));
			}
		}
		$lista_de_temas = [];
		if(isset($tipos)){
			foreach ($tipos as $tipo) {
				array_push($lista_de_temas, array($tipo->id_tipo, $tipo->nombre));
			}
		}
		$boton_extra=null;
		$result = '';
		$default_id_profesor = '';
		$default_id_tema = '';
		$result = $result.Form::open('curso/examen/materias_preguntas_compartidas');
		$result = $result.'<div class="form-group">
							<div class="table">
								<br>
								<div class="col-xs-12 col-sm-12 table-row">'.
									Form::label('Nombre del curso del cual quieres obtener preguntas compartidas.', 'pregunta_compartida_materia').'
								</div>
								<div class="col-xs-12 col-sm-12 table-row">'.
									Form::input('pregunta_compartida_materia','', array('class'=>'form-control','type' => 'text', 'placeholder'=>'Escribe el nombre del curso lo más parecido a como está en la tira de materias')).'
								</div>
								<br>
								<div class="col-xs-12 col-sm-12 table-row">'.
									Form::button('boton_buscar_preguntas', 'Buscar', array('class' => 'btn btn-primary btn-block')).'
								</div>
							</div>
						</div>';
		$result = $result.Form::close();
		return $result;
	}

	public static function getModalAbandonar($value='')
	{
		echo '<div class="modal fade" id="modalAbandonar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">';
			echo '<div class="modal-dialog" role="document">';
				echo '<div class="modal-content">';
					echo '<div class="modal-header">';
						echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
						  echo '<span aria-hidden="true">&times;</span>';
						echo '</button>';
						echo '<h4 class="modal-title" id="myModalLabel"> Abandonando Examen </h4>';
					echo '</div>';
					echo '<div class="modal-body">';
						echo '<div class="form-group">
								<div class="col-xs-12 col-sm-12 table">
									<div class="col-xs-12 col-sm-12">
										¿Estás seguro de salir del examen? Esto te restará una vida y afectará tu calificación
									</div>
								</div>
							</div>';
					echo '</div>';
					echo '<div class="modal-footer">';
						echo '<div class="row text-center">';
						  echo '<div class="col-xs-6">';
							  echo '<button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Cerrar</button>';
						  echo '</div>';
						  echo '<div class="col-xs-6">';
							  echo Html::anchor('curso/examen/final/abandonado','Abandonar',array('class'=>'btn btn-primary btn-block btn-lg'));
						  echo '</div>';
						echo '</div>';
					echo '</div>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
	}
}
