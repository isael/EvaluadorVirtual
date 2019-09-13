<?php
/**
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package    Fuel
 * @version    1.8
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2016 Fuel Development Team
 * @link       http://fuelphp.com
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

	public static function getModalPregunta($temas, $bibliografias, $tipos, $is_modal = false, $id_pregunta = null){
		$pregunta_texto="";
		$pregunta_justificacion="";
		if(isset($id_pregunta)){
			$pregunta = Model_Pregunta::find_one_by('id_pregunta', $id_pregunta);
			$pregunta_texto=$pregunta->texto;
			$pregunta_justificacion=$pregunta->justificacion;
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
				array_push($lista_de_fuentes, array($fuente->id_fuente, $fuente->nombre." - ".$fuente->autores.". Edición: ".$fuente->numero));
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

		$sufijo_modal = "";
		if($is_modal){
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
		}else{
			$result = $result.Form::open('curso/examen/crear_pregunta');			
		}

		$result = $result.'
							<div class="form-group">
								<div class="col-xs-12 col-sm-12">'.
									Form::label('Tema', 'pregunta_tema'.$sufijo_modal).'
								</div>
								<div class="col-xs-12 col-sm-12 table">'.
									Special_Selector::createSpecialSelector("pregunta_tema".$sufijo_modal, "results_tema".$sufijo_modal, $lista_de_temas,"Selecciona o crea un tema" , $boton_agregar_tema).'
								</div>
								<div class="col-xs-12 col-sm-12">'.
									Form::label('Bibliografía', 'pregunta_bibliografia'.$sufijo_modal).'
								</div>
								<div class="col-xs-12 col-sm-12">'.
									Special_Selector::createSpecialSelector("pregunta_bibliografia".$sufijo_modal, "results_fuente".$sufijo_modal, $lista_de_fuentes,"Selecciona una fuente" , $boton_agregar_bibliografia).'
								</div>
								<div class="col-xs-12 col-sm-12 table">
									<div class="col-xs-4 col-sm-4 table-row">
										<div class="col-xs-12 col-sm-12">'.
											Form::label('Página', 'pregunta_bibliografia_pagina'.$sufijo_modal).'
										</div>
										<div class="col-xs-12 col-sm-12">'.
											Form::input('pregunta_bibliografia_pagina'.$sufijo_modal,'',array('class'=>'form-control','type' => 'text', 'placeholder'=>'Página')).'
										</div>
									</div>
									<div class="col-xs-8 col-sm-8 table-row">
										<div class="col-xs-12 col-sm-12">'.
											Form::label('Capítulo', 'pregunta_bibliografia_capitulo'.$sufijo_modal).'
										</div>
										<div class="col-xs-12 col-sm-12">'.
											Form::input('pregunta_bibliografia_capitulo'.$sufijo_modal,'',array('class'=>'form-control','type' => 'text', 'placeholder'=>'Capítulo')).'
										</div>
									</div>
								</div>

								<div class="col-xs-12 col-sm-12 table">
									<div class="col-xs-4 col-sm-4 table-row">
										<div>'.
											Form::label('Dificultad', 'pregunta_dificultad'.$sufijo_modal).'
										</div>
										<div>'.
											Special_Selector::createSpecialSelector("pregunta_dificultad".$sufijo_modal, "results_dificultad".$sufijo_modal, $dificultades,"...").'
										</div>
									</div>
									<div class="col-xs-4 col-sm-4 table-row">
										<div class="col-xs-12 col-sm-12">'.
											Form::label('Tiempo', 'pregunta_tiempo'.$sufijo_modal).'
										</div>
										<div class="col-xs-12 col-sm-12">'.
											Form::input('pregunta_tiempo'.$sufijo_modal,'',array('class'=>'form-control','type' => 'text', 'placeholder'=>'segs')).'
										</div>
									</div>
									<div class="col-xs-4 col-sm-4 table-row">
										<div class="col-xs-12 col-sm-12">'.
											Form::label('Tipo', 'pregunta_tipo'.$sufijo_modal).'
										</div>
										<div class="col-xs-12 col-sm-12">'.
											Special_Selector::createSpecialSelector("pregunta_tipo".$sufijo_modal, "results_tipo".$sufijo_modal, $lista_de_tipos,"Selecciona un tipo",$boton_extra).'
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
									<!-- Aquí van las respuestas -->
									*-* Selecciona un tipo de pregunta primero *-*
								</div>'.
									Form::input("pregunta_cantidad_respuestas",'', array('type' => 'hidden')).'
								<div class="col-xs-12 col-sm-12">'.
									Form::label('Justificación', 'pregunta_justificacion'.$sufijo_modal).'
								</div>
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
								<button type="button" class="btn btn-primary btn-block" data-dismiss="modal">Duplicar pregunta</button>
							</div>
							<br>
							<div class="col-xs-6">
								<button type="button" class="btn btn-primary btn-block" data-dismiss="modal">Cancelar</button>
							</div>
							<div class="col-xs-6">'.
								Html::anchor('sesion/cerrar','Guardar',array('type' => 'button', 'class' => 'btn btn-danger btn-block')).'
							</div>
                          </div>
                      </div>
				</div>
			</div>';
		}else{
			$result = $result.Form::close();
		}
		return $result;
	}
}
