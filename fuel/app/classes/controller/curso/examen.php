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
 * The Welcome Controller.
 *
 * A basic controller example.  Has examples of how to set the
 * response body and status.
 *
 * @package  app
 * @extends  Controller
 */

class Controller_Curso_Examen extends Controller_Template
{

	public $template = 'template';

	public function before()
	{
		parent::before();
		$this->template->nav_bar = View::forge('nav_bar_sesion');
		$this->template->title = "Evaluador Virtual";

		$this->revisar_fecha_preguntas_compartidas();
	}

	private function revisar_fecha_preguntas_compartidas(){
		$id_curso = SESSION::get('id_curso');
		$date= date("Y-m-d H:i:s");
		$old_date_value = strtotime ( '-10 days' , strtotime ($date));
		$old_date = date( "Y-m-d H:i:s" , $old_date_value);
		$lista_preguntas_compartidas = Model_CursoPreguntasCompartidas::find('all',array('where' => array(array('id_curso', $id_curso),array('por_cambiar', '1'),array('fecha_de_modificacion', '<=', $old_date))));
		if(isset($lista_preguntas_compartidas)){
			$sql = "UPDATE `CursoPreguntasCompartidas` SET `por_cambiar`= false WHERE `fecha_de_modificacion` <= '".$old_date."' ";
			$respuesta_sql = DB::query($sql)->execute();
		}

		foreach ($lista_preguntas_compartidas as $pregunta_compartida) {
			$this->elimina_respaldo($pregunta_compartida->id_pregunta);
		}
	}
	/**
	 * Controlador que permite la creación y modificación de una fuente bibliográfica
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_crear_examen()
	{
		$id_curso = SESSION::get('id_curso');
		$id_examen = trim(Input::post('id_examen'));
		$modificar_examen = False;
		$sufijo_modal = '';
		if($id_examen !== null && $id_examen !== ''){
			$modificar_examen = True;
			$sufijo_modal = '_modal';
		}
		$examen_temas_y_niveles = trim(Input::post('examen_temas'.$sufijo_modal));
		$examen_nombre = trim(Input::post('examen_nombre'.$sufijo_modal));
		$examen_vidas_value = trim(Input::post('examen_vidas'.$sufijo_modal.'_option_selected'));
		$examen_oportunidades_value = trim(Input::post('examen_oportunidades'.$sufijo_modal.'_option_selected'));
		$examen_inicio = trim(Input::post('examen_inicio'.$sufijo_modal));
		$examen_final = trim(Input::post('examen_final'.$sufijo_modal));
		$examen_cantidad_preguntas = trim(Input::post('examen_cantidad_preguntas'.$sufijo_modal));
		$preguntas_agregadas = trim(Input::post('preguntas_agregadas'.$sufijo_modal));
		$preguntas_multiplo = trim(Input::post('preguntas_multiplo'.$sufijo_modal));
		$muestra_respuestas = trim(Input::post('muestra_respuestas'.$sufijo_modal));

		$mensaje="";
		$error = False;
		$examen_temas_y_niveles_arreglo = [];

		if($examen_cantidad_preguntas==null||$examen_cantidad_preguntas===""){
			$error=True;
			$mensaje=$mensaje."El campo Cantidad de preguntas está vacío.<br>";
		}elseif($preguntas_multiplo==null || $preguntas_multiplo === ""){
			$error=True;
			$mensaje=$mensaje."El campo Cantidad de preguntas está vacío.<br>";
		}elseif(intval($preguntas_multiplo)*intval($examen_cantidad_preguntas) > intval($preguntas_agregadas)*intval($preguntas_multiplo)){
			$error=True;
			$mensaje=$mensaje."Las preguntas son insuficientes para crear el examen.<br>";
		}

		if($examen_nombre==null||$examen_nombre===""){
			$error=True;
			$mensaje=$mensaje."El campo Nombre está vacío.<br>";
		}

		if($examen_vidas_value==null||$examen_vidas_value===""){
			$error=True;
			$mensaje=$mensaje."El campo de Vidas está vacío.<br>";
		}elseif(!preg_match("/^[0-9]+$/",$examen_vidas_value)){
			$error=True;
			$mensaje=$mensaje."El campo de Vidas contiene más que números.<br>";
		}

		if($examen_oportunidades_value==null||$examen_oportunidades_value===""){
			$error=True;
			$mensaje=$mensaje."El campo de Oportunidades está vacío.<br>";
		}elseif(!preg_match("/^[0-9]+$/",$examen_oportunidades_value)){
			$error=True;
			$mensaje=$mensaje."El campo de Oportunidades contiene más que números.<br>";
		}

		if($examen_inicio==null||$examen_inicio===""){
			$error=True;
			$mensaje=$mensaje."El campo de Vigencia-Inicio está vacío.<br>";
		}elseif(!preg_match("/^([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))$/",$examen_inicio)){
			$error=True;
			$mensaje=$mensaje."El campo de Vigencia-Inicio no tiene el formato de fecha AAAA-MM-DD.<br>";
		}else{
			$arreglo_fecha = explode("-", $examen_inicio);
			if(!checkdate(intval($arreglo_fecha[1]), intval($arreglo_fecha[2]), intval($arreglo_fecha[0]))){
				$error=True;
				$mensaje=$mensaje."El campo de Vigencia-Inicio no tiene una fecha válida.<br>";
			}
		}

		if($examen_final==null||$examen_final===""){
			$error=True;
			$mensaje=$mensaje."El campo de Vigencia-Final está vacío.<br>";
		}elseif(!preg_match("/^([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))$/",$examen_final)){
			$error=True;
			$mensaje=$mensaje."El campo de Vigencia-Final no tiene el formato de fecha AAAA-MM-DD.<br>";
		}else{
			$arreglo_fecha = explode("-", $examen_final);
			if(!checkdate(intval($arreglo_fecha[1]), intval($arreglo_fecha[2]), intval($arreglo_fecha[0]))){
				$error=True;
				$mensaje=$mensaje."El campo de Vigencia-Final no tiene una fecha válida.<br>";
			}
		}

		if(!$error){
			if($examen_final<$examen_inicio){
				$error=True;
				$mensaje=$mensaje."El campo de Vigencia-Final no puede ser antes de la Vigencia-Inicio.<br>";
			}
		}

		$tema=null;
		if(isset($examen_temas_y_niveles) && $examen_temas_y_niveles!==""){
			$examen_temas_y_niveles_arreglo = explode(",",$examen_temas_y_niveles);
		}else{
			$error=True;
			$mensaje=$mensaje."No se tiene registrada ninguna pregunta para el examen.<br>";
		}

		if(!$error){
			DB::start_transaction();
			try{
				if($modificar_examen){
					$new_examen = Model_Examen::find_one_by('id_examen',$id_examen);
					$new_examen->nombre = $examen_nombre;
					$new_examen->fecha_inicio = $examen_inicio;
					$new_examen->fecha_fin = $examen_final.' 23:59:59';
					$new_examen->oportunidades = $examen_oportunidades_value;
					$new_examen->vidas = $examen_vidas_value;
					$new_examen->preguntas_por_mostrar = $examen_cantidad_preguntas;
					$new_examen->preguntas_por_mezclar = $preguntas_agregadas;
					$new_examen->muestra_respuestas = $muestra_respuestas === 'on' ? true : false;
					// $new_examen->save();
					if ($new_examen->save() < 0){
				        throw new \Exception('Falla creación de examen en Examen');
				    }


					$length = sizeof($examen_temas_y_niveles_arreglo);
					for ($i=0; $i < $length; $i++) {
						$tema_niveles_array = explode("-",$examen_temas_y_niveles_arreglo[$i]);
						$new_basado_en = Model_BasadoEn::find(array('id_examen' => $id_examen, 'id_tema' => $tema_niveles_array[0]));
						$new_basado_en->desde_dificultad = $tema_niveles_array[1];
						$new_basado_en->hasta_dificultad = $tema_niveles_array[2];
						// $new_basado_en->save();
						if ($new_basado_en->save() < 0){
					        throw new \Exception('Falla creación de examen en BasadoEn');
					    }
					}
					$mensaje=$mensaje."El examen fue actualizado con éxito.<br>";
				}else{
					$new_examen = new Model_Examen();
					$new_examen->nombre = $examen_nombre;
					$new_examen->fecha_inicio = $examen_inicio;
					$new_examen->fecha_fin = $examen_final;
					$new_examen->oportunidades = $examen_oportunidades_value;
					$new_examen->vidas = $examen_vidas_value;
					$new_examen->preguntas_por_mostrar = $examen_cantidad_preguntas;
					$new_examen->preguntas_por_mezclar = $preguntas_agregadas;
					$new_examen->muestra_respuestas = $muestra_respuestas === 'on' ? true : false;
					// $new_examen->save();
					if ($new_examen->save() < 0){
				        throw new \Exception('Falla creación de examen en Examen');
				    }
					$id_examen = $new_examen->id_examen;

					$new_evalua = new Model_Evalua();
					$new_evalua->id_curso = $id_curso;
					$new_evalua->id_examen = $id_examen;
					// $new_evalua->save();
					if ($new_evalua->save() < 0){
				        throw new \Exception('Falla creación de examen en Evalua');
				    }

					$length = sizeof($examen_temas_y_niveles_arreglo);
					for ($i=0; $i < $length; $i++) {
						$tema_niveles_array = explode("-",$examen_temas_y_niveles_arreglo[$i]);
						$new_basado_en = new Model_BasadoEn();
						$new_basado_en->id_examen = $id_examen;
						$new_basado_en->id_tema = $tema_niveles_array[0];
						$new_basado_en->desde_dificultad = $tema_niveles_array[1];
						$new_basado_en->hasta_dificultad = $tema_niveles_array[2];
						// $new_basado_en->save();
						if ($new_basado_en->save() < 0){
					        throw new \Exception('Falla creación de examen en BasadoEn');
					    }
					}
					$mensaje=$mensaje."El examen fue creado con éxito.<br>";

				}
				DB::commit_transaction();
			}catch(\Exception $ex){
				DB::rollback_transaction();
			}
		}

		if($error){
			// $data = array('nombre'=> $nombre, 'autores' => $autores, 'numero' => $numero, 'anio' => $anio, 'liga' => $liga);
			SESSION::set('mensaje',$mensaje);
			SESSION::set('pestania','edicion');
			// SESSION::set('data',$data);
			Response::redirect('curso/examenes');
		}else{
			SESSION::set('mensaje',$mensaje);
			SESSION::set('pestania','edicion');
			Response::redirect('curso/examenes');
		}
	}
	/**
	 * Controlador que permite la creación y modificación de una fuente bibliográfica
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_crear_bibliografia()
	{
		$id_curso = SESSION::get('id_curso');
		$data = null;
		$modificar_bibliografia = False;
		$sufijo_modal = '';
		$id_fuente = trim(Input::post('fuente_id'));
		$numero_fuente = trim(Input::post('fuente_numero'));
		if($id_fuente !== null && $id_fuente !== '' && $numero_fuente !== null && $numero_fuente !== ''){
			$modificar_bibliografia = True;
			$sufijo_modal = '_modal';
		}
		$nombre = trim(Input::post('nombre_bibliografia'.$sufijo_modal));
		$autores=trim(Input::post('autor_bibliografia'.$sufijo_modal));
		$numero=trim(Input::post('numero_edicion_bibliografia'.$sufijo_modal));
		$anio=trim(Input::post('anio_bibliografia'.$sufijo_modal));
		$liga=trim(Input::post('link_bibliografia'.$sufijo_modal));

		$mensaje="";
		$error = False;
		$edicion = null;
		if(!$modificar_bibliografia){
			$fuente = Model_Fuente::find_one_by(array('nombre' => $nombre, 'autores' => $autores ));
			if($fuente!=null){
				$edicion = Model_Edicion::find(array($fuente->id_fuente, $numero ));
			}
		}

		if($edicion==null){
			if($nombre==null||$nombre===""){
				$error=True;
				$mensaje=$mensaje."El campo de Nombre está vacío.<br>";
			}

			if($autores==null||$autores===""){
				$error=True;
				$mensaje=$mensaje."El campo de Autores está vacío.<br>";
			}

			if($numero==null||$numero===""){
				$error=True;
				$mensaje=$mensaje."El campo de Número está vacío.<br>";
			}elseif(!preg_match("/^[0-9]+$/",$numero)){
				$error=True;
				$mensaje=$mensaje."El campo de Número contiene más que números.<br>";
			}

			if($anio==null||$anio===""){
				$error=True;
				$mensaje=$mensaje."El campo de Año está vacío.<br>";
			}elseif(!preg_match("/^(19|20)[0-9]{2}$/",$anio)){
				$error=True;
				$mensaje=$mensaje."El campo de Año no tiene el formato 19## o 20##.<br>";
			}

			if($liga==null||$liga===""){
				$liga="";
			}elseif(!preg_match("/^(http)[s]*:\/\/(.*)$/i",$liga)){
				$error=True;
				$mensaje=$mensaje."El campo de Enlace en línea no contiene el formato válido (i.e. http://servidor.com/archivo.pdf).<br>";
			}

			if(!$error){
				DB::start_transaction();
				try{
					if($modificar_bibliografia){
						$fuente = Model_Fuente::find_one_by('id_fuente',$id_fuente);
						$fuente->nombre = $nombre;
						$fuente->autores = $autores;
						// $fuente->save();
						if ($fuente->save() < 0){
					        throw new \Exception('Falla creación de bibliografía en Fuente');
					    }

						$numero_fuente_iguales = $numero_fuente === $numero;
						if($numero_fuente_iguales){
							$edicion = Model_Edicion::find(array($id_fuente, $numero_fuente));
							$edicion->anio = $anio;
							$edicion->liga = $liga;
							// $edicion->save();
							if ($edicion->save() < 0){
						        throw new \Exception('Falla creación de bibliografía en Edición');
						    }
						}else{
							$edicion = Model_Edicion::find(array($id_fuente, $numero_fuente));
							// $edicion->delete();
							if (!$edicion->delete()){
						        throw new \Exception('Falla creación de bibliografía en Edición');
						    }
							$nueva_edicion = new Model_Edicion();
							$nueva_edicion->id_fuente = $id_fuente;
							$nueva_edicion->numero = $numero;
							$nueva_edicion->anio = $anio;
							$nueva_edicion->liga = $liga;
							// $nueva_edicion->save();
							if ($nueva_edicion->save() < 0){
						        throw new \Exception('Falla creación de bibliografía en Edición');
						    }
						}
						$mensaje = "La bibliografía ".$fuente->nombre." número ".$numero." ha sido actualizada con éxito.";

					}else{
						if($fuente==null){
							$fuente = new Model_Fuente();
							$fuente->nombre = $nombre;
							$fuente->autores = $autores;
							// $fuente->save();
							if ($fuente->save() < 0){
						        throw new \Exception('Falla creación de bibliografía en Fuente');
						    }
						}
						$nueva_edicion = new Model_Edicion();
						$nueva_edicion->id_fuente = $fuente->id_fuente;
						$nueva_edicion->numero = $numero;
						$nueva_edicion->anio = $anio;
						$nueva_edicion->liga = $liga;
						// $nueva_edicion->save();
						if ($nueva_edicion->save() < 0){
					        throw new \Exception('Falla creación de bibliografía en Edición');
					    }

						$curso_fuente = new Model_CursoFuente();
						$curso_fuente->id_curso = $id_curso;
						$curso_fuente->id_fuente = $fuente->id_fuente;
						// $curso_fuente->save();
						if ($curso_fuente->save() < 0){
					        throw new \Exception('Falla creación de bibliografía en CursoFuente');
					    }

						$mensaje = "La bibliografía ".$fuente->nombre." número ".$nueva_edicion->numero." ha sido registrada con éxito.";
					}
					DB::commit_transaction();
				}catch(\Exception $ex){
					DB::rollback_transaction();
				}
			}

		}else{
			$error=True;
			$mensaje=$mensaje."Esta bibliografía ya existe.<br>";
		}
		$curso = Model_Curso::find_one_by('id_curso',$id_curso);
		if($error){
			$data = array('nombre'=> $nombre, 'autores' => $autores, 'numero' => $numero, 'anio' => $anio, 'liga' => $liga);
			SESSION::set('mensaje',$mensaje);
			SESSION::set('pestania','bibliografia');
			SESSION::set('data',$data);
			Response::redirect('curso/examenes');
		}else{
			SESSION::set('mensaje',$mensaje);
			SESSION::set('pestania','bibliografia');
			Response::redirect('curso/examenes');
		}

	}


	/**
	 * Se encarga de copiar la pregunta y tablas relacionadas a ella.
	 * @access private
	 * @return void
	 */
	private function copiar_pregunta($old_pregunta, $id_tema, $id_fuente, $completa = False){
		//Revisar CursoTema y CursoFuente si es $completa == True

		// Copiamos la pregunta
		$id_curso = SESSION::get('id_curso');
		$id_pregunta = $old_pregunta->id_pregunta;
		DB::start_transaction();
		try{
			$pregunta = new Model_Pregunta();
			$pregunta->texto = $old_pregunta->texto;
			$pregunta->dificultad = $old_pregunta->dificultad;
			$pregunta->justificacion = $old_pregunta->justificacion;
			$pregunta->tiene_subpreguntas = $old_pregunta->tiene_subpreguntas;
			$pregunta->tiempo = $old_pregunta->tiempo;
			// $pregunta->save();
			if ($pregunta->save() < 0){
		        throw new \Exception('Falla en copia de pregunta en Pregunta');
		    }
			$new_id_pregunta = $pregunta->id_pregunta;

			//Copiamos las fuentes

			$old_fundamentado_en_lista = Model_FundamentadoEn::find('all',array('where' => array(array('id_pregunta', $id_pregunta))));
			$old_fundamentado_en = reset($old_fundamentado_en_lista);
			$old_id_referencia = null;
			if(isset($old_fundamentado_en)){
				$fundamentado_en = new Model_FundamentadoEn();
				$fundamentado_en->id_pregunta = $new_id_pregunta;
				$fundamentado_en->id_referencia = $old_fundamentado_en->id_referencia;
				// $fundamentado_en->save();
				if ($fundamentado_en->save() < 0){
			        throw new \Exception('Falla en copia de pregunta en FundamentadoEn');
			    }
			}

			//Copiamos el tipo
			$old_de_tipo_lista = Model_DeTipo::find('all',array('where' => array(array('id_pregunta', $id_pregunta))));
			$old_de_tipo = reset($old_de_tipo_lista);
			if(isset($old_de_tipo)){
				$de_tipo = new Model_DeTipo();
				$de_tipo->id_tipo = $old_de_tipo->id_tipo;
				$de_tipo->id_pregunta = $new_id_pregunta;
				// $de_tipo->save();
				if ($de_tipo->save() < 0){
			        throw new \Exception('Falla en copia de pregunta en DeTipo');
			    }
			}

			//Manejo del Genera Y Tema
			if($completa){
				//Debo revisar que el tema que tenga un nombre similar y exista en curso tema
				$old_tema = Model_Tema::find_one_by( 'id_tema', $id_tema);
				$nombre = $old_tema->nombre;
				$similar_tema_lista = Model_Tema::find(function ($query) use ($id_curso, $nombre){
					return $query->join('CursoTema')
								->on('Tema.id_tema', '=', 'CursoTema.id_tema')
								->where('Tema.nombre', '=', $nombre)
								->where('CursoTema.id_curso', '=', $id_curso);
				});

				if(isset($similar_tema_lista)){
					$similar_tema = reset($similar_tema_lista);
					$id_tema = $similar_tema->id_tema;
				}else{				
					$new_tema = new Model_Tema();
					$new_tema->nombre = $old_tema->nombre;
					// $new_tema->save();
					if ($new_tema->save() < 0){
				        throw new \Exception('Falla en copia de pregunta Tema');
				    }
					$id_tema = $new_tema->id_tema;
				}

				// Se crea un nuevo Genera
				$genera = new Model_Genera();
				$genera->id_pregunta = $new_id_pregunta;
				$genera->id_tema = $id_tema;
				// $genera->save();
				if ($genera->save() < 0){
			        throw new \Exception('Falla en copia de pregunta en Genera');
			    }

			}else{			
				//Copiamos el Genera
				$old_genera_lista = Model_Genera::find('all',array('where' => array(array('id_pregunta', $id_pregunta))));
				$old_genera = reset($old_genera_lista);
				if(isset($old_genera)){
					$genera = new Model_Genera();
					$genera->id_pregunta = $new_id_pregunta;
					$genera->id_tema = $old_genera->id_tema;
					// $genera->save();
					if ($genera->save() < 0){
				        throw new \Exception('Falla en copia de pregunta en Genera');
				    }
				}
			}


			//Copiamos los Contiene (son por respuesta)
			$old_respuestas = Model_Respuesta::find(function ($query) use ($id_pregunta){
				return $query->join('Contiene')
							->on('Contiene.id_respuesta', '=', 'Respuesta.id_respuesta')
							->where('Contiene.id_pregunta', $id_pregunta);
			});
			foreach ($old_respuestas as $old_respuesta) {
				$new_respuesta = new Model_Respuesta();
				$new_respuesta->contenido = $old_respuesta->contenido;
				$new_respuesta->porcentaje = $old_respuesta->porcentaje;
				// $new_respuesta->save();
				if ($new_respuesta->save() < 0){
			        throw new \Exception('Falla en copia de pregunta en Respuesta');
			    }
				$contiene = new Model_Contiene();
				$contiene->id_pregunta = $new_id_pregunta;
				$contiene->id_respuesta = $new_respuesta->id_respuesta;
				// $contiene->save();
				if ($contiene->save() < 0){
			        throw new \Exception('Falla en copia de pregunta en Contiene');
			    }
			}

			//Aumentamos cantidad_de_preguntas en CursoTema y TemaFuente
			
			$tema_fuente = Model_TemaFuente::find(array($id_tema, $id_fuente));
			if(isset($tema_fuente)){
				$cantidad_tema_fuente_string = $tema_fuente->cantidad_preguntas;
				$tema_fuente->cantidad_preguntas = intval($cantidad_tema_fuente_string) + 1;
				// $tema_fuente->save();
				if ($tema_fuente->save() < 0){
			        throw new \Exception('Falla en copia de pregunta en TemaFuente');
			    }
			}else{
				$tema_fuente = new Model_TemaFuente();
				$tema_fuente->id_tema = $id_tema;
				$tema_fuente->id_fuente = $id_fuente;
				$tema_fuente->cantidad_preguntas = 1;
				// $tema_fuente->save();
				if ($tema_fuente->save() < 0){
			        throw new \Exception('Falla en copia de pregunta en TemaFuente');
			    }
			}

			$curso_tema = Model_CursoTema::find(array($id_curso, $id_tema));

			if(isset($curso_tema)){
				$cantidad_curso_tema_string = $curso_tema->cantidad_preguntas;
				$curso_tema->cantidad_preguntas = intval($cantidad_curso_tema_string) + 1;
				// $curso_tema->save();
				if ($curso_tema->save() < 0){
			        throw new \Exception('Falla en copia de pregunta en CursoTema');
			    }
			}else{
				$curso_tema = new Model_CursoTema();
				$curso_tema->id_curso = $id_curso;
				$curso_tema->id_tema = $id_tema;
				$curso_tema->cantidad_preguntas = 1;
				// $curso_tema->save();
				if ($curso_tema->save() < 0){
			        throw new \Exception('Falla en copia de pregunta en CursoTema');
			    }
			}

			$curso_fuente = Model_CursoFuente::find(array($id_curso, $id_fuente));
			if(!isset($curso_fuente)){
				$curso_fuente = new Model_CursoFuente();
				$curso_fuente->id_curso = $id_curso;
				$curso_fuente->id_fuente = $id_fuente;
				// $curso_fuente->save();
				if ($curso_fuente->save() < 0){
			        throw new \Exception('Falla en copia de pregunta en CursoFuente');
			    }
			}
			DB::commit_transaction();
			return $pregunta;
		}catch(\Exception $ex){
			DB::rollback_transaction();
		}
	}

	/**
	 * Borra la pregunta y sus datos relacionados
	 */
	private function borra_pregunta($pregunta){		
		$genera = Model_Genera::find('first',array('where' => array(array('id_pregunta', $pregunta->id_pregunta))));
		//Obtenemos el id del tema para cambiar la cantidad de preguntas
		$id_tema = null;
		if(isset($genera)){
			$id_tema = $genera->id_tema;
		}
		//Obtenemos el id de la fuente para cambiar la cantidad de preguntas
		$id_fuente = null;
		$fundamentado_en = Model_FundamentadoEn::find('first',array('where' => array(array('id_pregunta', $pregunta->id_pregunta))));
		if(isset($fundamentado_en)){
			$referencia_fuente = Model_ReferenciaFuente::find('first',array('where' => array(array('id_referencia', $fundamentado_en->id_referencia))));
			if(isset($referencia_fuente)){
				$id_fuente = $referencia_fuente->id_fuente;
			}
		}

		//Borramos primero la pregunta
		$pregunta->delete();

		//Luego, si obtuvimos los Id's entonces los disminuimos
		if(isset($id_tema) && isset($id_fuente)){
			$this->disminuir_cantidad_preguntas($id_tema, $id_fuente);
		}
	}

	/**
	 * Método que reduce en 1 el campo cantidad_preguntas de TemaFuente y CursoTema 
	 *
	 */
	private function disminuir_cantidad_preguntas($id_tema, $id_fuente){
		$id_curso = SESSION::get('id_curso');
		DB::start_transaction();
		try{
			$curso_tema = Model_CursoTema::find(array($id_curso, $id_tema));
			if(isset($curso_tema)){
				$cantidad_curso_tema_string = $curso_tema->cantidad_preguntas;
				$cantidad_curso_tema = intval($cantidad_curso_tema_string);
				if($cantidad_curso_tema > 1){
					$curso_tema->cantidad_preguntas =  $cantidad_curso_tema - 1;
					// $curso_tema->save();
					if ($curso_tema->save() < 0){
				        throw new \Exception('Falla en disminuir cantidad preguntas en CursoFuente');
				    }
				}else{
					// $curso_tema->delete();
					if (!$curso_tema->delete()){
				        throw new \Exception('Falla en disminuir cantidad preguntas en CursoFuente');
				    }
				}
			}

			$tema_fuente = Model_TemaFuente::find(array($id_tema, $id_fuente));
			if(isset($tema_fuente)){			
				$cantidad_tema_fuente_string = $tema_fuente->cantidad_preguntas;
				$cantidad_tema_fuente = intval($cantidad_tema_fuente_string);
				if($cantidad_tema_fuente > 1){
					$tema_fuente->cantidad_preguntas =  $cantidad_tema_fuente - 1;
					// $tema_fuente->save();
					if ($tema_fuente->save() < 0){
				        throw new \Exception('Falla en disminuir cantidad preguntas en TemaFuente');
				    }
				}else{
					// $tema_fuente->delete();
					if (!$tema_fuente->delete()){
				        throw new \Exception('Falla en disminuir cantidad preguntas en TemaFuente');
				    }
				}
			}
			DB::commit_transaction();
		}catch(\Exception $ex){
			DB::rollback_transaction();
		}
	}

	/**
	 * Controlador que permite la creación, actualización y duplicación de una pregunta
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_crear_pregunta()
	{
		$id_curso = SESSION::get('id_curso');
		$data = null;
		$mensaje="";
		$error = False;
		$modal = "";
		$modificar_pregunta = False;
		$duplicar_pregunta = False;
		$respaldar_pregunta = False;
		$nueva_pregunta = False;
		$pregunta_id = trim(Input::post('pregunta_id'));

		if(isset($pregunta_id)  && $pregunta_id!==""){
			$modal = "_modal";
			$modificar_pregunta = True;
		}
		$pregunta_duplicada = trim(Input::post('pregunta_duplicada'));
		$pregunta_tipo = trim(Input::post('pregunta_tipo'.$modal.'_option_selected'));
		$pregunta_tema_id = trim(Input::post('pregunta_tema'.$modal.'_option_selected'));
		$pregunta_tema = trim(Input::post('pregunta_tema'.$modal));
		$pregunta_bibliografia=trim(Input::post('pregunta_bibliografia'.$modal.'_option_selected'));
		$pregunta_bibliografia_pagina=trim(Input::post('pregunta_bibliografia_pagina'.$modal));
		$pregunta_bibliografia_capitulo=trim(Input::post('pregunta_bibliografia_capitulo'.$modal));
		$pregunta_dificultad=trim(Input::post('pregunta_dificultad'.$modal));
		$pregunta_tiempo=trim(Input::post('pregunta_tiempo'.$modal));
		$pregunta_texto=trim(Input::post('pregunta_texto'.$modal));
		$pregunta_justificacion=trim(Input::post('pregunta_justificacion'.$modal));
		$pregunta_cantidad=trim(Input::post('pregunta_cantidad_respuestas'.$modal));

		if (isset($pregunta_duplicada) && $pregunta_duplicada === "duplicada") {
			$modificar_pregunta = False;
			$duplicar_pregunta = True;
		}

		$tema=null;
		if(isset($pregunta_tema_id) && $pregunta_tema_id!=="" && isset($pregunta_tema) && $pregunta_tema!==""){
			if(is_numeric($pregunta_tema_id)){
				$tema = Model_Tema::find_one_by( 'id_tema', $pregunta_tema_id);
			}
		}else{
			$error=True;
			$mensaje=$mensaje."El campo de Tema no fue correctamente seleccionado.<br>";
		}

		$fuente=null;
		if(isset($pregunta_bibliografia) && $pregunta_bibliografia!=="" && is_numeric($pregunta_bibliografia)){
			$array_fuente = explode(".", $pregunta_bibliografia);
			$id = $array_fuente[0];
			$numero = $array_fuente[1];
			$_fuentes = Model_Fuente::find(function ($query) use ($numero,$id){
				return $query->join('Edicion')
							->on('Fuente.id_fuente', '=', 'Edicion.id_fuente')
							->where('Edicion.numero', '=', $numero)
							->where('Edicion.id_fuente', '=', $id);
			});
			$fuente = reset($_fuentes);
			if(!isset($fuente)){
				$error=True;
				$mensaje=$mensaje."El campo de Selección de Bibliografía tiene un error en sus parámetros.<br>";
			}
		}else{
			$error=True;
			$mensaje=$mensaje."El campo de Bibliografía no fue correctamente seleccionado.<br>";
		}

		if($pregunta_bibliografia_pagina==null||$pregunta_bibliografia_pagina===""){
			$error=True;
			$mensaje=$mensaje."El campo de Página está vacío.<br>";
		}elseif(!preg_match("/^[0-9]+$/",$pregunta_bibliografia_pagina)){
			$error=True;
			$mensaje=$mensaje."El campo de Página contiene más que números.<br>";
		}elseif (intval($pregunta_bibliografia_pagina) > 8**5 -1) {
			$error=True;
			$mensaje=$mensaje."El valor de la Página es muy alto. Revisa la página de la fuente.<br>";
		}

		if($pregunta_bibliografia_capitulo==null||$pregunta_bibliografia_capitulo===""){
			$error=True;
			$mensaje=$mensaje."El campo de Capítulo está vacío.<br>";
		}elseif(!preg_match("/^[0-9]+$/",$pregunta_bibliografia_capitulo)){
			$error=True;
			$mensaje=$mensaje."El campo de Capítulo contiene más que números.<br>";
		}elseif (intval($pregunta_bibliografia_capitulo) > 8**3-1) {
			$error=True;
			$mensaje=$mensaje."El valor del Capítulo es muy alto. Revisa el capítulo de la fuente.<br>";
		}

		if($pregunta_dificultad==null||$pregunta_dificultad===""){
			$error=True;
			$mensaje=$mensaje."El campo de Dificultad está vacío.<br>";
		}elseif(!preg_match("/^[0-9]+$/",$pregunta_dificultad)){
			$error=True;
			$mensaje=$mensaje."El campo de Dificultad contiene más que números.<br>";
		}

		if($pregunta_tiempo==null||$pregunta_tiempo===""){
			$error=True;
			$mensaje=$mensaje."El campo de Tiempo está vacío.<br>";
		}elseif(!preg_match("/^[0-9]+$/",$pregunta_tiempo)){
			$error=True;
			$mensaje=$mensaje."El campo de Tiempo contiene más que números.<br>";
		}elseif (intval($pregunta_tiempo) > 600) {
			$error=True;
			$mensaje=$mensaje."El tiempo no debe exceder los 10 minutos.<br>";
		}

		if($pregunta_tipo==null||$pregunta_tipo===""){
			$error=True;
			$mensaje=$mensaje."El campo de Tipo está vacío.<br>";
		}

		if($pregunta_texto==null||$pregunta_texto===""){
			$error=True;
			$mensaje=$mensaje."El campo de Pregunta está vacío.<br>";
		}

		$conjunto_respuestas = array();
		$conjunto_id_respuestas = array();
		$conjunto_porcentajes = array();
		$cantidad_respuestas = 0;
		if(isset($pregunta_cantidad)){
			$cantidad_respuestas = intval($pregunta_cantidad);
			$maximo_porcentaje = 0;
			for ($i=1; $i <= $cantidad_respuestas; $i++) {
				$respuesta = trim(Input::post('pregunta_respuesta_'.$i.$modal));
				$id_respuesta = trim(Input::post('pregunta_id_respuesta_'.$i.$modal));
				$porcentaje_texto = trim(Input::post('pregunta_respuesta_porcentaje_'.$i.$modal));
				$porcentaje = 0;
				if(isset($respuesta) && $respuesta !== ''){
					if(isset($id_respuesta)){
						array_push($conjunto_id_respuestas, $id_respuesta);
					}
					array_push($conjunto_respuestas, $respuesta);
					if(isset($porcentaje_texto)  && $porcentaje_texto !== ''){
						if(is_numeric($porcentaje_texto)){
							$porcentaje = intval($porcentaje_texto);
							$porcentaje = $porcentaje >= 0 ? ( $porcentaje <= 100 ? $porcentaje : 100 ) : 0 ;
							$maximo_porcentaje = $maximo_porcentaje > $porcentaje ? $maximo_porcentaje : $porcentaje;
						}else{
							$porcentaje = 0;
						}
					}else{
						$porcentaje = 0;
					}
					array_push($conjunto_porcentajes, $porcentaje);
				}else{
					$error = True;
					$mensaje = $mensaje."Hay respuestas y/o porcentajes sin llenar.<br>";
					$i=$cantidad_respuestas+1; //Detiene el for
				}
			}
			if($maximo_porcentaje!=100){
				$error = True;
				$mensaje = $mensaje."Debe haber al menos una respuesta con porcentaje del 100%.<br>";
			}
		}else{
			$error = True;
			$mensaje = $mensaje."Ha sido borrado un dato importante desde el HTML. Favor de no hacerlo.<br>";
		}

		if($pregunta_justificacion==null||$pregunta_justificacion===""){
			$error=True;
			$mensaje=$mensaje."El campo de Justificación está vacío.<br>";
		}

		$lista_preguntas_compartidas = Model_CursoPreguntasCompartidas::find('all',array('where' => array(array('id_pregunta', $pregunta_id))));
		if(!$duplicar_pregunta && isset($lista_preguntas_compartidas)){
			$pregunta_compartida = reset($lista_preguntas_compartidas);
			if(isset($pregunta_compartida) && isset($pregunta_compartida->por_cambiar) && $pregunta_compartida->por_cambiar === '1'){
				$date= date("Y-m-d H:i:s");
				$old_date_value = strtotime ( '-10 days' , strtotime ($date));
				$old_date = date( "Y-m-d H:i:s" , $old_date_value);
				$update_date = $pregunta_compartida->fecha_de_modificacion;
				if(strcmp($old_date, $update_date) < 0){ //Si aun no se ha cumplido la fecha
					$error=True;
					$mensaje=$mensaje."No se puede actualizar la aplicación hasta que transcurran 10 días desde su última actualización.";
				}else{
					$sql = "UPDATE `CursoPreguntasCompartidas` SET `por_cambiar`= false WHERE `id_pregunta`= '".$pregunta_id."' ";
					$respuesta_sql = DB::query($sql)->execute();
				}
			}
		}

		if(!$error){
			DB::start_transaction(); 
			try{
				/* Bibliografías */

				$id_pregunta = null;
				$id_referencia=null;
				$fundamentado_en = null;

				$old_pregunta = Model_Pregunta::find_one_by('id_pregunta',$pregunta_id);
				$curso_pregunta_compartida = Model_CursoPreguntasCompartidas::find('first',array('where' => array(array('id_pregunta', $pregunta_id))));
				if(isset($old_pregunta) && isset($curso_pregunta_compartida)){
					$id_pregunta = $pregunta_id;
					if($old_pregunta->compartida === '1' && !$duplicar_pregunta){
						$respaldar_pregunta = True;
						$sql = "UPDATE `CursoPreguntasCompartidas` SET `fecha_de_modificacion`= '".date("Y-m-d H:i:s")."', `por_cambiar`= true WHERE `id_pregunta`= '".$id_pregunta."' ";
						$respuesta_sql = DB::query($sql)->execute();						
						if (!$respuesta_sql){
					        throw new \Exception('Falla en crear pregunta en CursoPreguntasCompartidas');
					    }
					}
				}
				$nueva_pregunta = !($duplicar_pregunta || $respaldar_pregunta || $modificar_pregunta);

				if($duplicar_pregunta || $respaldar_pregunta){
					if(isset($old_pregunta)){
						//Se realiza el duplicado de la pregunta.
						$pregunta = $this->copiar_pregunta($old_pregunta, $tema->id_tema, $fuente->id_fuente);
						$new_id_pregunta = $pregunta->id_pregunta;
						/*// Copiamos la pregunta

						$pregunta = new Model_Pregunta();
						$pregunta->texto = $old_pregunta->texto;
						$pregunta->dificultad = $old_pregunta->dificultad;
						$pregunta->justificacion = $old_pregunta->justificacion;
						$pregunta->tiene_subpreguntas = $old_pregunta->tiene_subpreguntas;
						$pregunta->tiempo = $old_pregunta->tiempo;
						$pregunta->save();
						$new_id_pregunta = $pregunta->id_pregunta;

						//Copiamos las fuentes

						$old_fundamentado_en_lista = Model_FundamentadoEn::find('all',array('where' => array(array('id_pregunta', $id_pregunta))));
						$old_fundamentado_en = reset($old_fundamentado_en_lista);
						$old_id_referencia = null;
						if(isset($old_fundamentado_en)){
							$fundamentado_en = new Model_FundamentadoEn();
							$fundamentado_en->id_pregunta = $new_id_pregunta;
							$fundamentado_en->id_referencia = $old_fundamentado_en->id_referencia;
							$fundamentado_en->save();
						}

						//Copiamos el tipo
						$old_de_tipo_lista = Model_DeTipo::find('all',array('where' => array(array('id_pregunta', $id_pregunta))));
						$old_de_tipo = reset($old_de_tipo_lista);
						if(isset($old_de_tipo)){
							$de_tipo = new Model_DeTipo();
							$de_tipo->id_tipo = $old_de_tipo->id_tipo;
							$de_tipo->id_pregunta = $new_id_pregunta;
							$de_tipo->save();
						}

						//Copiamos el Genera
						$old_genera_lista = Model_Genera::find('all',array('where' => array(array('id_pregunta', $id_pregunta))));
						$old_genera = reset($old_genera_lista);
						if(isset($old_genera)){
							$genera = new Model_Genera();
							$genera->id_pregunta = $new_id_pregunta;
							$genera->id_tema = $old_genera->id_tema;
							$genera->save();
						}

						//Copiamos los Contiene (son por respuesta)
						$old_respuestas = Model_Respuesta::find(function ($query) use ($id_pregunta){
							return $query->join('Contiene')
										->on('Contiene.id_respuesta', '=', 'Respuesta.id_respuesta')
										->where('Contiene.id_pregunta', $id_pregunta);
						});
						foreach ($old_respuestas as $old_respuesta) {
							$new_respuesta = new Model_Respuesta();
							$new_respuesta->contenido = $old_respuesta->contenido;
							$new_respuesta->porcentaje = $old_respuesta->porcentaje;
							$new_respuesta->save();
							$contiene = new Model_Contiene();
							$contiene->id_pregunta = $new_id_pregunta;
							$contiene->id_respuesta = $new_respuesta->id_respuesta;
							$contiene->save();
						}

						//Aumentamos cantidad_de_preguntas en CursoTema y TemaFuente

						$tema_fuente = Model_TemaFuente::find(array($tema->id_tema, $fuente->id_fuente));
						if(isset($tema_fuente)){
							$cantidad_tema_fuente_string = $tema_fuente->cantidad_preguntas;
							$tema_fuente->cantidad_preguntas = intval($cantidad_tema_fuente_string) + 1;
							$tema_fuente->save();
						}

						$curso_tema = Model_CursoTema::find(array($id_curso, $tema->id_tema));
						if(isset($curso_tema)){
							$cantidad_curso_tema_string = $curso_tema->cantidad_preguntas;
							$curso_tema->cantidad_preguntas = intval($cantidad_curso_tema_string) + 1;
							$curso_tema->save();
						}*/

						//En caso de ser una copia para respaldar se hace lo siguiente

						if($respaldar_pregunta){
							$respaldo = new Model_RespaldoDe();
							$respaldo->id_pregunta = $id_pregunta;
							$respaldo->id_pregunta_respaldo = $new_id_pregunta;
							// $respaldo->save();
							if ($respaldo->save() < 0){
						        throw new \Exception('Falla en crear pregunta en RespaldoDe');
						    }
						}

					}
				}

				if($modificar_pregunta){
					$id_pregunta=$pregunta_id;
					$fundamentado_en_lista = Model_FundamentadoEn::find('all',array('where' => array(array('id_pregunta', $pregunta_id))));
					if(isset($fundamentado_en_lista)){
						$fundamentado_en = reset($fundamentado_en_lista);
						$id_referencia = $fundamentado_en->id_referencia;

						$update_referencia = False;
						$current_referencia = Model_Referencia::find_one_by('id_referencia',$id_referencia);
						if(isset($current_referencia)){
							$pagina_iguales = ($current_referencia->pagina === $pregunta_bibliografia_pagina);
							if(!$pagina_iguales){
								$current_referencia->pagina = $pregunta_bibliografia_pagina;
								$update_referencia = True;
							}
							$capitulo_iguales = ($current_referencia->capitulo === $pregunta_bibliografia_capitulo);
							if(!$capitulo_iguales){
								$current_referencia->capitulo = $pregunta_bibliografia_capitulo;
								$update_referencia = True;
							}
							if($update_referencia){
								$similar_referencia_lista = Model_Referencia::find(function ($query) use ($id_pregunta, $pregunta_bibliografia_capitulo, $pregunta_bibliografia_pagina, $fuente){
									return $query->join('ReferenciaFuente')
												->on('ReferenciaFuente.id_referencia', '=', 'Referencia.id_referencia')
												->where('Referencia.capitulo', $pregunta_bibliografia_capitulo)
												->where('Referencia.pagina', $pregunta_bibliografia_pagina)
												->where('ReferenciaFuente.id_fuente', $fuente->id_fuente);
								});
								$similar_referencia = null;
								if(isset($similar_referencia_lista)){
									$similar_referencia = reset($similar_referencia_lista);
								}

								// Ya existe una referencia con esas propiedades, diferente a la actual
								if(isset($similar_referencia)){
									$fundamentado_en->id_referencia = $similar_referencia->id_referencia;
									// $fundamentado_en->save();
									if ($fundamentado_en->save() < 0){
								        throw new \Exception('Falla en crear pregunta en FundamentadoEn');
								    }

									// Preguntar si aun se usa la referencia pasada, si no borrarla y también de la lista de Referencia Fuente

									$borrar_referencia = False;
									$old_referencia_fundamentado_en_lista = Model_FundamentadoEn::find('all',array('where' => array(array('id_referencia', $id_referencia))));
									if(isset($old_referencia_fundamentado_en_lista)){
										$old_referencia_fundamentado_en = reset($old_referencia_fundamentado_en_lista);
										if(!isset($old_referencia_fundamentado_en)){ // Es decir que no tiene ninguna referencia
											$borrar_referencia = True;
										}
									}else{
										$borrar_referencia = True;
									}

									if($borrar_referencia){
										// $current_referencia->delete();
										if (!$current_referencia->delete()){
									        throw new \Exception('Falla en crear pregunta en Referencia');
									    }

										$current_referencia_fuente_lista = Model_ReferenciaFuente::find('all',array('where' => array(array('id_referencia', $id_referencia))));
										if(isset($current_referencia_fuente_lista)){
											$current_referencia_fuente = reset($current_referencia_fuente_lista);
											if(isset($current_referencia_fuente)){
												// $current_referencia_fuente->delete();
												if (!$current_referencia_fuente->delete()){
											        throw new \Exception('Falla en crear pregunta en ReferenciaFuente');
											    }
											}
										}
									}

								}else{
									// $current_referencia->save();
									if ($current_referencia->save() < 0){
								        throw new \Exception('Falla en crear pregunta en Referencia');
								    }
								}
							}
						}
						if($fundamentado_en->id_referencia === $id_referencia){ //Si no se cambio y solo se actualizó o no se realizó ningún cambio en la referencia
							$current_referencia_fuente_lista = Model_ReferenciaFuente::find('all',array('where' => array(array('id_referencia', $id_referencia))));
							if(isset($current_referencia_fuente_lista)){
								$current_referencia_fuente = reset($current_referencia_fuente_lista);
								$update_referencia_fuente = False;
								$fuente_iguales = ($current_referencia_fuente->id_fuente === $fuente->id_fuente);
								if(!$fuente_iguales){
									// $current_referencia_fuente->delete();
									if (!$current_referencia_fuente->delete()){
								        throw new \Exception('Falla en crear pregunta en ReferenciaFuente');
								    }
									$current_referencia_fuente = new Model_ReferenciaFuente();
									$current_referencia_fuente->id_fuente = $fuente->id_fuente;
									$current_referencia_fuente->id_referencia = $id_referencia;
									$current_referencia_fuente->numero_edicion = $fuente->numero;
									$update_referencia_fuente = True;
								}
								if($update_referencia_fuente){
									// $current_referencia_fuente->save();
									if ($current_referencia_fuente->save() < 0){
								        throw new \Exception('Falla en crear pregunta en ReferenciaFuente');
								    }
								}
							}
						}

						$new_pregunta = Model_Pregunta::find_one_by('id_pregunta',$id_pregunta);
						if(isset($new_pregunta)){
							$update_pregunta = False;
							$texto_iguales = ($new_pregunta->texto === $pregunta_texto);
							if(!$texto_iguales){
								$new_pregunta->texto = $pregunta_texto;
								$update_pregunta = True;
							}
							$dificultad_iguales = ($new_pregunta->dificultad === $pregunta_dificultad);
							if(!$dificultad_iguales){
								$new_pregunta->dificultad = $pregunta_dificultad;
								$update_pregunta = True;
							}
							$justificacion_iguales = ($new_pregunta->justificacion === $pregunta_justificacion);
							if(!$justificacion_iguales){
								$new_pregunta->justificacion = $pregunta_justificacion;
								$update_pregunta = True;
							}
							$tiempo_iguales = ($new_pregunta->tiempo === $pregunta_tiempo);
							if(!$tiempo_iguales){
								$new_pregunta->tiempo = $pregunta_tiempo;
								$update_pregunta = True;
							}
							if($update_pregunta){
								// $new_pregunta->save();
								if ($new_pregunta->save() < 0){
							        throw new \Exception('Falla en crear pregunta en RespaldoDe');
							    }
							}
						}

						$cantidad_respuestas = sizeof($conjunto_id_respuestas);
						for ($i=0; $i < $cantidad_respuestas; $i++) {
							$id_respuesta_actual = $conjunto_id_respuestas[$i];
							$texto_actual = $conjunto_respuestas[$i];
							$porcentaje_actual = $conjunto_porcentajes[$i];
							$resp = Model_Respuesta::find_one_by('id_respuesta',$id_respuesta_actual);
							if(isset($resp)){
								$update_respuesta = False;
								$contenido_iguales = ($resp->contenido === $texto_actual);
								if(!$contenido_iguales){
									$resp->contenido = $texto_actual;
									$update_respuesta = True;
								}
								$porcentaje_iguales = ($resp->porcentaje == $porcentaje_actual);
								if(!$porcentaje_iguales){
									$resp->porcentaje = $porcentaje_actual;
									$update_respuesta = True;
								}
								if($update_respuesta){
									// $resp->save();
									if ($resp->save() < 0){
								        throw new \Exception('Falla en crear pregunta en Respuesta');
								    }
								}
							}
						}

						$genera_lista = Model_Genera::find('all',array('where' => array(array('id_pregunta', $id_pregunta))));
						if(isset($genera_lista)){
							$genera = reset($genera_lista);
							$update_tema = False;
							$id_tema_antiguo = $genera->id_tema;
							$id_tema_actual = $tema->id_tema;

							$id_tema_iguales = ($id_tema_antiguo === $id_tema_actual);
							if(!$id_tema_iguales){
								// $genera->delete();
								if (!$genera->delete()){
							        throw new \Exception('Falla en crear pregunta en Genera');
							    }
								$new_genera = new Model_Genera();
								$genera->id_pregunta = $id_pregunta;
								$genera->id_tema = $id_tema_actual;
								// $genera->save();
								if ($genera->save() < 0){
							        throw new \Exception('Falla en crear pregunta en Genera');
							    }

								$id_fuente = $fuente->id_fuente;

								$tema_fuente = Model_TemaFuente::find(array($id_tema_antiguo, $id_fuente));
								if(isset($tema_fuente)){
									$cantidad_tema_fuente_string = $tema_fuente->cantidad_preguntas;
									$cantidad_tema_fuente = intval($cantidad_tema_fuente_string);
									if($cantidad_tema_fuente > 1){
										$tema_fuente->cantidad_preguntas =  $cantidad_tema_fuente -1;
										// $tema_fuente->save();
										if ($tema_fuente->save() < 0){
									        throw new \Exception('Falla en crear pregunta en TemaFuente');
									    }
									}else{
										// $tema_fuente->delete();
										if (!$tema_fuente->delete()){
									        throw new \Exception('Falla en crear pregunta en TemaFuente');
									    }
									}
									$tema_fuente_nuevo = Model_TemaFuente::find(array($id_tema_actual, $id_fuente));
									if(isset($tema_fuente_nuevo)){
										$cantidad = intval($tema_fuente_nuevo->cantidad_preguntas);
										$tema_fuente_nuevo->cantidad_preguntas = $cantidad + 1;
										// $tema_fuente_nuevo->save();
										if ($tema_fuente_nuevo->save() < 0){
									        throw new \Exception('Falla en crear pregunta en TemaFuente');
									    }
									}else{
										$tema_fuente_nuevo = new Model_TemaFuente();
										$tema_fuente_nuevo->id_fuente = $id_fuente;
										$tema_fuente_nuevo->id_tema = $id_tema_actual;
										$tema_fuente_nuevo->cantidad_preguntas = 1;
										// $tema_fuente_nuevo->save();
										if ($tema_fuente_nuevo->save() < 0){
									        throw new \Exception('Falla en crear pregunta en TemaFuente');
									    }
									}
								}

								$curso_tema = Model_CursoTema::find(array($id_curso, $id_tema_antiguo));
								if(isset($curso_tema)){
									$cantidad_curso_tema_string = $curso_tema->cantidad_preguntas;
									$cantidad_curso_tema = intval($cantidad_curso_tema_string);
									if($cantidad_curso_tema > 1){
										$curso_tema->cantidad_preguntas =  $cantidad_curso_tema -1;
										// $curso_tema->save();
										if ($tema_fuente->save() < 0){
									        throw new \Exception('Falla en crear pregunta en CursoTema');
									    }
									}else{
										// $curso_tema->delete();
										if (!$curso_tema->delete()){
									        throw new \Exception('Falla en crear pregunta en TemaFuente');
									    }
									}
									$curso_tema_nuevo = Model_CursoTema::find(array($id_curso, $id_tema_actual));
									if(isset($curso_tema_nuevo)){
										$cantidad = intval($curso_tema_nuevo->cantidad_preguntas);
										$curso_tema_nuevo->cantidad_preguntas = $cantidad + 1;
										// $curso_tema_nuevo->save();
										if ($curso_tema_nuevo->save() < 0){
									        throw new \Exception('Falla en crear pregunta en CursoTema');
									    }
									}else{
										$curso_tema_nuevo = new Model_CursoTema();
										$curso_tema_nuevo->id_curso = $id_curso;
										$curso_tema_nuevo->id_tema = $id_tema_actual;
										$curso_tema_nuevo->cantidad_preguntas = 1;
										// $curso_tema_nuevo->save();
										if ($curso_tema_nuevo->save() < 0){
									        throw new \Exception('Falla en crear pregunta en CursoTema');
									    }
									}
								}
							}
						}
					}
				}
				if($nueva_pregunta){
					$tipo = Model_Tipo::find_one_by('id_tipo',$pregunta_tipo);//Pendiente

					$pregunta = new Model_Pregunta();
					$pregunta->texto = $pregunta_texto;
					$pregunta->dificultad = $pregunta_dificultad;
					$pregunta->justificacion = $pregunta_justificacion;
					$pregunta->tiene_subpreguntas = $tipo->tiene_subpreguntas; //Pendiente
					$pregunta->tiempo = $pregunta_tiempo;
					// $pregunta->save();
					if ($pregunta->save() < 0){
				        throw new \Exception('Falla en crear pregunta en Pregunta');
				    }
					$id_pregunta = $pregunta->id_pregunta;

					$de_tipo = new Model_DeTipo();
					$de_tipo->id_tipo = $tipo->id_tipo;
					$de_tipo->id_pregunta = $id_pregunta;
					// $de_tipo->save();
					if ($de_tipo->save() < 0){
				        throw new \Exception('Falla en crear pregunta en DeTipo');
				    }

					$id_referencia="";
					//Buscar Referencias que cumplan con las propiedades y que además cumplan con las propiedades de fuente y que esten en la tabla de ReferenciaFuente
					$old_referencia_lista = Model_Referencia::find(function ($query) use ($id_pregunta, $pregunta_bibliografia_capitulo, $pregunta_bibliografia_pagina, $fuente){
						return $query->join('ReferenciaFuente')
									->on('ReferenciaFuente.id_referencia', '=', 'Referencia.id_referencia')
									->where('Referencia.capitulo', $pregunta_bibliografia_capitulo)
									->where('Referencia.pagina', $pregunta_bibliografia_pagina)
									->where('ReferenciaFuente.id_fuente', $fuente->id_fuente);
					});
					$old_referencia = isset($old_referencia_lista) ? reset($old_referencia_lista) : null;
					if(isset($old_referencia)){
						//En caso de entregar un elemento se agregará el elemento a FundamentadoEn con el id_pregunta y con ese elemento encontrado (id_referencia)
						$id_referencia=$old_referencia->id_referencia;
					}else{
						$referencia = new Model_Referencia();
						$referencia->capitulo = $pregunta_bibliografia_capitulo;
						$referencia->pagina = $pregunta_bibliografia_pagina;
						// $referencia->save();
						if ($referencia->save() < 0){
					        throw new \Exception('Falla en crear pregunta en Referencia');
					    }
						$id_referencia=$referencia->id_referencia;

						$referencia_fuente = new Model_ReferenciaFuente();
						$referencia_fuente->id_referencia = $referencia->id_referencia;
						$referencia_fuente->id_fuente = $fuente->id_fuente;
						$referencia_fuente->numero_edicion = $fuente->numero;
						// $referencia_fuente->save();
						if ($referencia_fuente->save() < 0){
					        throw new \Exception('Falla en crear pregunta en ReferenciaFuente');
					    }
					}

					//En cualquier caso se guarda FundamentadoEn ya que al ser nueva no existe aun esa relación
					$fundamentado_en = new Model_FundamentadoEn();
					$fundamentado_en->id_pregunta = $id_pregunta;
					$fundamentado_en->id_referencia = $id_referencia;
					// $fundamentado_en->save();
					if ($fundamentado_en->save() < 0){
				        throw new \Exception('Falla en crear pregunta en FundamentadoEn');
				    }

					for ($i=0; $i < $cantidad_respuestas; $i++) {
						$texto_actual = $conjunto_respuestas[$i];
						$porcentaje_actual = $conjunto_porcentajes[$i];
						$resp = new Model_Respuesta();
						$resp->contenido = $texto_actual;
						$resp->porcentaje = $porcentaje_actual;
						// $resp->save();
						if ($resp->save() < 0){
					        throw new \Exception('Falla en crear pregunta en Respuesta');
					    }

						$contiene = new Model_Contiene();
						$contiene->id_pregunta = $id_pregunta;
						$contiene->id_respuesta = $resp->id_respuesta;
						// $contiene->save();
						if ($contiene->save() < 0){
					        throw new \Exception('Falla en crear pregunta en Contiene');
					    }
					}

					if(!isset($tema)){
						$tema = new Model_Tema();
						$tema->nombre = $pregunta_tema;
						// $tema->save();
						if ($tema->save() < 0){
					        throw new \Exception('Falla en crear pregunta en Tema');
					    }
					}

					$genera = new Model_Genera();
					$genera->id_pregunta = $id_pregunta;
					$genera->id_tema = $tema->id_tema;
					// $genera->save();
					if ($genera->save() < 0){
				        throw new \Exception('Falla en crear pregunta en Genera');
				    }

					$tema_fuente = Model_TemaFuente::find(array($tema->id_tema, $fuente->id_fuente));
					if(!isset($tema_fuente)){
						$tema_fuente = new Model_TemaFuente();
						$tema_fuente->id_fuente = $fuente->id_fuente;
						$tema_fuente->id_tema = $tema->id_tema;
						$tema_fuente->cantidad_preguntas = 1;
						// $tema_fuente->save();
						if ($tema_fuente->save() < 0){
					        throw new \Exception('Falla en crear pregunta en TemaFuente');
					    }
					}else{
						$cantidad_tema_fuente_string = $tema_fuente->cantidad_preguntas;
						$tema_fuente->cantidad_preguntas = intval($cantidad_tema_fuente_string) + 1;
						// $tema_fuente->save();
						if ($tema_fuente->save() < 0){
					        throw new \Exception('Falla en crear pregunta en TemaFuente');
					    }
					}

					$curso_tema = Model_CursoTema::find(array($id_curso, $tema->id_tema));
					if(!isset($curso_tema)){
						$curso_tema = new Model_CursoTema();
						$curso_tema->id_curso = $id_curso;
						$curso_tema->id_tema = $tema->id_tema;
						$curso_tema->cantidad_preguntas = 1;
						// $curso_tema->save();
						if ($curso_tema->save() < 0){
					        throw new \Exception('Falla en crear pregunta en CursoTema');
					    }
					}else{
						$cantidad_curso_tema_string = $curso_tema->cantidad_preguntas;
						$curso_tema->cantidad_preguntas = intval($cantidad_curso_tema_string) + 1;
						// $curso_tema->save();
						if ($curso_tema->save() < 0){
					        throw new \Exception('Falla en crear pregunta en CursoTema');
					    }
					}
				}
				if($modificar_pregunta){
					$mensaje = $mensaje."La pregunta fue actualizada con éxito.";
				}else{
					if (isset($pregunta_duplicada) && $pregunta_duplicada === "duplicada") {
						$mensaje = $mensaje."La pregunta fue duplicada con éxito";
					}else{
						$mensaje = $mensaje."La nueva pregunta ha sido agregada con éxito.";
					}
				}
				DB::commit_transaction();
			}catch(\Exception $ex){
				DB::rollback_transaction();
			}
		}

		if($error){
			// $data = array('nombre'=> $nombre, 'autores' => $autores, 'numero' => $numero, 'anio' => $anio, 'liga' => $liga);
			SESSION::set('mensaje',$mensaje);
			SESSION::set('pestania','preguntas');
			// SESSION::set('data',$data);
			Response::redirect('curso/examenes');
		}else{
			SESSION::set('mensaje',$mensaje);
			SESSION::set('pestania','preguntas');
			Response::redirect('curso/examenes');
		}

	}

	/**
	 * Controlador que enviará la instrucción de mostrar la modal para modificar pregunta.
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_mostrar_pregunta($id_pregunta, $externa = null)
	{
		$id_curso = SESSION::get('id_curso');
		$mensaje = "";
		$error = False;
		if($error){
			// $data = array('nombre'=> $nombre, 'autores' => $autores, 'numero' => $numero, 'anio' => $anio, 'liga' => $liga);
			SESSION::set('mensaje',$mensaje);
			SESSION::set('pestania','preguntas');
			// SESSION::set('data',$data);
			Response::redirect('curso/examenes');
		}else{
			SESSION::set('id_pregunta',$id_pregunta);
			if(isset($externa))
				SESSION::set('externa',True);
			$pregunta = Model_Pregunta::find_one_by('id_pregunta',$id_pregunta);
			if(isset($pregunta)){
				if($pregunta->compartida === '1'){
					SESSION::set('es_compartida','true');
				}
				$respaldo_lista = Model_RespaldoDe::find('all',array('where' => array(array('id_pregunta_respaldo', $id_pregunta))));
				if(isset($respaldo_lista)){
					$respaldo = reset($respaldo_lista);
					if(isset($respaldo)){
						SESSION::set('por_actualizar',$respaldo);
					}
				}
			}
			SESSION::set('pestania','preguntas');
			Response::redirect('curso/examenes');
		}

	}

	/**
	 * Controlador que enviará la instrucción de mostrar la modal para modificar pregunta.
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_mostrar_pregunta_compartida($id_pregunta, $materia = null, $id_curso_compartido = null)
	{
		$id_curso = SESSION::get('id_curso');
		$mensaje = "Hubo un error con los datos recibidos";
		$error = !(isset($materia) && isset($id_curso_compartido));
		if($error){
			// $data = array('nombre'=> $nombre, 'autores' => $autores, 'numero' => $numero, 'anio' => $anio, 'liga' => $liga);
			SESSION::set('mensaje',$mensaje);
			SESSION::set('pestania','preguntas');
			// SESSION::set('data',$data);
			Response::redirect('curso/preguntas_compartidas');
		}else{
			SESSION::set('materia',$materia);
			SESSION::set('id_curso_compartido',$id_curso_compartido);
			SESSION::set('id_pregunta',$id_pregunta);
			SESSION::set('pestania','preguntas');
			Response::redirect('curso/preguntas_compartidas');
		}

	}

	/**
	 * Controlador que enviará la instrucción de mostrar la modal para modificar bibliografía.
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_mostrar_bibliografia($id_fuente,$numero_fuente)
	{
		$id_curso = SESSION::get('id_curso');
		$mensaje = "";
		$error = False;
		if($error){
			// $data = array('nombre'=> $nombre, 'autores' => $autores, 'numero' => $numero, 'anio' => $anio, 'liga' => $liga);
			SESSION::set('mensaje',$mensaje);
			SESSION::set('pestania','bibliografia');
			// SESSION::set('data',$data);
			Response::redirect('curso/examenes');
		}else{
			SESSION::set('numero_fuente',$numero_fuente);
			SESSION::set('id_fuente',$id_fuente);
			SESSION::set('pestania','bibliografia');
			Response::redirect('curso/examenes');
		}

	}

	/**
	 * Controlador que enviará la instrucción de mostrar la modal para modificar un examen.
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_mostrar_examen($id_examen)
	{
		$id_curso = SESSION::get('id_curso');
		$mensaje = "";
		$error = False;
		if($error){
			// $data = array('nombre'=> $nombre, 'autores' => $autores, 'numero' => $numero, 'anio' => $anio, 'liga' => $liga);
			SESSION::set('mensaje',$mensaje);
			SESSION::set('pestania','edicion');
			// SESSION::set('data',$data);
			Response::redirect('curso/examenes');
		}else{
			SESSION::set('id_examen',$id_examen);
			SESSION::set('pestania','edicion');
			Response::redirect('curso/examenes');
		}

	}

	/**
	 * Controlador que crea la cookie de id_examen para no hacerla visible en la URL y se
	 * redirije al método que si muestra la información.
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_presentar($id_examen)
	{
		$id_curso = SESSION::get('id_curso');
		$curso = Model_Curso::find_one_by('id_curso',$id_curso);
		if(isset($curso) && $curso->activo){
			SESSION::set('id_examen',$id_examen);
			SESSION::delete('n_cuenta');
			$id = SESSION::get('id_sesion');
			if(isset($id) && substr($id,0,1)=='a'){
				$n_cuenta = substr($id,1);
				SESSION::set('n_cuenta',$n_cuenta);
			}
			Response::redirect('curso/examen/presentar_inicio');
		}else{
			Response::redirect('curso/alumno');
		}
	}

	/**
	 * Controlador que llevará a la pantalla previa a presentar un examen.
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_presentar_inicio()
	{
		$id_curso = SESSION::get('id_curso');
		$id_examen = SESSION::get('id_examen');
		$n_cuenta = SESSION::get('n_cuenta');
		$es_test = True;
		if(isset($n_cuenta)){
			$es_test = False;
		}

		if(isset($id_examen)){
			SESSION::delete('siguiente_posicion_pregunta');
			DB::start_transaction(); 
			try{
				$examen = Model_Examen::find_one_by('id_examen',$id_examen);
				$presenta = null;
				if(!$es_test){
					$presenta = Model_Presenta::find(array('n_cuenta' => $n_cuenta, 'id_examen' => $id_examen));
					if(isset($presenta)){
						if(!($presenta->vidas < $examen->vidas) && intval($presenta->calificacion) == 0){
							Response::redirect('curso/examen/final/sin_vidas');
							die();
						}elseif($presenta->terminado > 0){
							Response::redirect('curso/examen/final/terminado');
							die();
						}else{
							$presenta->oportunidades = 0;
							// $presenta->save();
							if ($presenta->save() < 0){
						        throw new \Exception('Falla en presenta en Presenta');
						    }
						}
					}else{
						$presenta = new Model_Presenta();
						$presenta->id_examen = $id_examen;
						$presenta->n_cuenta = $n_cuenta;
						$presenta->vidas = 0;
						$presenta->oportunidades = 0;
						$presenta->calificacion = 0;
						$presenta->terminado = 0;
						// $presenta->save();
						if ($presenta->save() < 0){
					        throw new \Exception('Falla en presenta en Presenta');
					    }
					}
				}

				$temas = Model_Tema::find(function ($query) use ($id_examen){
					return $query->join('BasadoEn')
								->on('Tema.id_tema', '=', 'BasadoEn.id_tema')
								->where('BasadoEn.id_examen', $id_examen);
				});

				$temas_ids = [];

				$preguntas = null;
				if(isset($temas)){
					foreach($temas as $tema) {
						array_push($temas_ids, $tema->id_tema);
					}
					$preguntas = Model_Pregunta::find(function ($query) use ($temas,$id_examen){
							$query->select('tiempo','Pregunta.id_pregunta')
								->join('Genera')
								->on('Pregunta.id_pregunta', '=', 'Genera.id_pregunta')
								->where('Genera.id_tema','<', '0');
							foreach($temas as $tema) {
								$query->or_where_open();
								$query->where('Genera.id_tema', $tema->id_tema);
								$query->and_where("Pregunta.dificultad","BETWEEN",array($tema->desde_dificultad, $tema->hasta_dificultad ));
								$query->or_where_close();
							}
							return $query;
					});
					shuffle($preguntas);
					$preguntas = array_slice($preguntas, 0, intval($examen->preguntas_por_mostrar));
				}

				$fuentes = Model_Fuente::find(function ($query) use ($temas_ids){
					return $query->select('nombre')
								->join('TemaFuente')
								->on('TemaFuente.id_fuente', '=', 'Fuente.id_fuente')
								->where('TemaFuente.id_tema', 'IN', $temas_ids)
								->order_by('nombre')
								->group_by('nombre');
				});

				$data = array('examen' => $examen, 'temas' => $temas, 'preguntas' => $preguntas, 'presenta' => $presenta, 'fuentes' => $fuentes, 'n_cuenta' => $n_cuenta);
				$mensaje = "";
				if(isset($preguntas)){
					$preguntas_ids = [];
					foreach ($preguntas as $pregunta) {
						array_push($preguntas_ids, $pregunta->id_pregunta);
					}
					SESSION::set('preguntas_ids',$preguntas_ids);
				}
				DB::commit_transaction();
			}catch(\Exception $ex){
				DB::rollback_transaction();
			}
			$this->template->content = View::forge('curso/examen/presentar_inicio', $data);
		}else{
			SESSION::set('pestania','edicion');
			Response::redirect('curso/examenes');
		}
	}

	/**
	 * Controlador que llevará a la pantalla previa a presentar un examen.
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_presentando()
	{
		$id_curso = SESSION::get('id_curso');
		$n_cuenta = SESSION::get('n_cuenta');
		$id_examen = SESSION::get('id_examen');
		$siguiente_posicion_pregunta = SESSION::get('siguiente_posicion_pregunta');
		$preguntas = SESSION::get('preguntas_ids');

		$evaluado = SESSION::get('evaluado');
		$limite_tiempo_pregunta = SESSION::get('limite_tiempo_pregunta');

		$es_test = True;
		$tiempo = -1;
		if(isset($n_cuenta)){
			$es_test = False;
		}

		$presenta = null;
		$examen = Model_Examen::find_one_by('id_examen', $id_examen);
		$fallas = SESSION::get('fallas');
		if(isset($fallas)){
			if(intval($fallas) > intval($examen->oportunidades)){
				SESSION::delete('siguiente_posicion_pregunta');
				Response::redirect('curso/examen/final');
				die();
			}
		}
		if(isset($evaluado) && $evaluado == True){
			SESSION::delete('evaluado');
			if(isset($siguiente_posicion_pregunta)){
				$siguiente_posicion_pregunta_entero = intval($siguiente_posicion_pregunta);
				$siguiente_posicion_pregunta_entero++;
				if($siguiente_posicion_pregunta_entero < intval($examen->preguntas_por_mostrar)){
					SESSION::set('siguiente_posicion_pregunta', $siguiente_posicion_pregunta_entero);
					$siguiente_posicion_pregunta = ''.$siguiente_posicion_pregunta_entero;
				}else{
					SESSION::delete('siguiente_posicion_pregunta');
					Response::redirect('curso/examen/final');
					die();
				}
			}else{//No debería entrar a este caso ya que si fue evaluado, no podrá ser el siguiente cero
				// $siguiente_posicion_pregunta = '0';
				// SESSION::set('siguiente_posicion_pregunta', $siguiente_posicion_pregunta);
			}
		}else{
			 //En caso de recargar pregunta
			if(isset($siguiente_posicion_pregunta)){
				if(isset($limite_tiempo_pregunta)){
					$tiempo = $limite_tiempo_pregunta - time();
				}
			}else{//Entra por primera vez
				$siguiente_posicion_pregunta = '0';
				SESSION::set('siguiente_posicion_pregunta', $siguiente_posicion_pregunta);
				if(!$es_test){
					$presenta = Model_Presenta::find(array('n_cuenta' => $n_cuenta, 'id_examen' => $id_examen));
					if(isset($presenta)){
						$vidas_usadas = $presenta->vidas;
						$presenta->vidas = $vidas_usadas+1;
						$presenta->save();
					}
				}
			}
		}

		$pregunta = Model_Pregunta::find_one_by('id_pregunta',$preguntas[intval($siguiente_posicion_pregunta)]);


		if(!isset($limite_tiempo_pregunta)){
			SESSION::set('limite_tiempo_pregunta',time()+(30));
		}
		$tiempo = $tiempo < 0 ? $pregunta->tiempo : $tiempo;


		$id_pregunta = $pregunta->id_pregunta;
		$respuestas = Model_Respuesta::find(function ($query) use ($id_pregunta){
				return $query->join('Contiene')
							->on('Contiene.id_respuesta', '=', 'Respuesta.id_respuesta')
							->where('Contiene.id_pregunta', $id_pregunta);
			});
		shuffle($respuestas);
		$_referencias = Model_Referencia::find(function ($query) use ($id_pregunta){
				return $query->join('FundamentadoEn')
						 ->on('FundamentadoEn.id_referencia', '=', 'Referencia.id_referencia')
						 ->join('ReferenciaFuente')
						 ->on('ReferenciaFuente.id_referencia', '=', 'Referencia.id_referencia')
						 ->join('Fuente')
						 ->on('Fuente.id_fuente', '=', 'ReferenciaFuente.id_fuente')
						 ->join('Edicion')
						 ->on('Edicion.id_fuente', '=', 'Fuente.id_fuente')
						 ->and_on('ReferenciaFuente.numero_edicion', '=','Edicion.numero')
						 ->where('FundamentadoEn.id_pregunta', '=', $id_pregunta);
			});
		$referencia = reset($_referencias);

		$data = array('examen' => $examen, 'presenta' => $presenta, 'pregunta' => $pregunta, 'respuestas' => $respuestas, 'referencia' => $referencia, 'tiempo' => $tiempo);

		$respuestas_ids = [];
		foreach ($respuestas as $respuesta) {
			array_push($respuestas_ids, $respuesta->id_respuesta);
		}
		SESSION::set('respuestas_ids',$respuestas_ids);

		$mensaje = "";
		$this->template->nav_bar = null;
		$this->template->content = View::forge('curso/examen/presentando', $data);
		
	}

	/**
	 * Controlador que llevará a la pantalla previa a presentar un examen.
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_evalua()
	{
		$id_curso = SESSION::get('id_curso');
		$n_cuenta = SESSION::get('n_cuenta');
		$id_examen = SESSION::get('id_examen');
		$puntaje_obtenido = SESSION::get('puntaje_obtenido');
		$limite_tiempo_pregunta = SESSION::get('limite_tiempo_pregunta');
		$siguiente_posicion_pregunta = SESSION::get('siguiente_posicion_pregunta');
		$preguntas = SESSION::get('preguntas_ids');

		$respuesta_elegida = trim(Input::post('respuesta_elegida'));
		$respuestas_ids_actuales = SESSION::get('respuestas_ids');

		$es_test = True;
		$evaluacion = 0;
		$hubo_respuesta = True;
		$hizo_trampa = False;
		$id_respuesta_elegida = $respuesta_elegida < 0 ? $respuesta_elegida : $respuestas_ids_actuales[intval($respuesta_elegida)];
		$id_pregunta_actual = $preguntas[intval($siguiente_posicion_pregunta)];

		if(!isset($respuestas_ids_actuales)){
			Response::redirect('curso/examen/presentando');
			die();
		}

		if(isset($n_cuenta)){
			$es_test = False;
		}
		if(isset($limite_tiempo_pregunta)){
			SESSION::delete('limite_tiempo_pregunta');
		}
		if($id_respuesta_elegida < 0){
			$hubo_respuesta = False;
			$hizo_trampa = True;
		}
		if(!isset($respuesta_elegida) || $respuesta_elegida === ''){
			$hubo_respuesta = False;
			$id_respuesta_elegida = -1;
		}

		$examen = Model_Examen::find_one_by('id_examen', $id_examen);

		$pregunta = Model_Pregunta::find_one_by('id_pregunta',$id_pregunta_actual);
		$id_pregunta = $pregunta->id_pregunta;
		$respuesta = $hubo_respuesta ? Model_Respuesta::find_one_by('id_respuesta',$id_respuesta_elegida) : null ;

		$presenta = null;

		$evaluacion = $hubo_respuesta ? intval($respuesta->porcentaje) : 0;
		$fallas = 0;
		$respuestas_no_exitosas = null;

		if(isset($puntaje_obtenido)){
			SESSION::delete('puntaje_obtenido');
			$nuevo_puntaje = intval($puntaje_obtenido) + $evaluacion;
			SESSION::set('puntaje_obtenido', $nuevo_puntaje);
		}else{
			SESSION::set('puntaje_obtenido', $evaluacion);
		}

		if($evaluacion == 100){
			//Si lo hace bien
		}else{
			DB::start_transaction(); 
			try{
				if($evaluacion == 0){
					if(!$es_test){
						$presenta = Model_Presenta::find(array('n_cuenta' => $n_cuenta, 'id_examen' => $id_examen));
						if(isset($presenta)){
							$oportunidades_usadas = $presenta->oportunidades;
							$presenta->oportunidades = $oportunidades_usadas + 1;
							// $presenta->save();
							if ($presenta->save() < 0){
						        throw new \Exception('Falla evalua en Presenta');
							}
						}
					}
					$fallas = SESSION::get('fallas');
					if(isset($fallas)){
						$fallas++;
						SESSION::delete('fallas');
					}else{
						$fallas = 1;
					}
					SESSION::set('fallas',$fallas);
				}
				$respuestas_no_exitosas = SESSION::get('respuestas_no_exitosas');
				if(isset($respuestas_no_exitosas)){
					array_push($respuestas_no_exitosas, array(intval($siguiente_posicion_pregunta), $id_pregunta_actual, $id_respuesta_elegida) );
					SESSION::delete('respuestas_no_exitosas');
				}else{
					$respuestas_no_exitosas = [array(intval($siguiente_posicion_pregunta), $id_pregunta_actual, $id_respuesta_elegida)];
				}
				SESSION::set('respuestas_no_exitosas',$respuestas_no_exitosas);
				if(!$es_test){
					$id_respuesta = $id_respuesta_elegida < 0 ? (-1 * $id_pregunta_actual) : $id_respuesta_elegida;
					$comete_error = Model_CometeErroresEn::find(array('id_respuesta' => $id_respuesta, 'n_cuenta' => $n_cuenta ));
					$genera_lista = Model_Genera::find('all',array('where' => array(array('id_pregunta', $id_pregunta_actual))));
					$id_tema = null;
					if(isset($genera_lista)){
						$genera = reset($genera_lista);
						$id_tema = $genera->id_tema;
					}
					if(!isset($comete_error) && isset($id_tema)){
						$comete_error = new Model_CometeErroresEn();
						$comete_error->id_respuesta = $id_respuesta;
						$comete_error->id_pregunta = $id_pregunta_actual;
						$comete_error->id_tema = $id_tema;
						$comete_error->n_cuenta = $n_cuenta;
						$comete_error->id_examen = $id_examen;
						// $comete_error->save();
						if ($comete_error->save() < 0){
					        throw new \Exception('Falla evalua en CometeErroresEn');
						}
					}
				}
				DB::commit_transaction();
			}catch(\Exception $ex){
				DB::rollback_transaction();
			}
		}


		if(isset($respuestas_ids_actuales)){
			SESSION::delete('respuestas_ids');
		}

		$data = array('examen' => $examen, 'presenta' => $presenta, 'evaluacion' => $evaluacion, 'hizo_trampa' => $hizo_trampa);
		SESSION::set('evaluado',True);
		$mensaje = "";
		$this->template->nav_bar = null;
		$this->template->content = View::forge('curso/examen/evalua', $data);
		// }
	}

	/**
	 * Controlador que llevará a la pantalla previa a presentar un examen.
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_final($ruta_especial = null)
	{
		$id_curso = SESSION::get('id_curso');
		$n_cuenta = SESSION::get('n_cuenta');
		$id_examen = SESSION::get('id_examen');
		$puntaje_obtenido = SESSION::get('puntaje_obtenido');
		$respuestas_no_exitosas = SESSION::get('respuestas_no_exitosas');
		$preguntas_ids = SESSION::get('preguntas_ids');

		$es_test = True;
		$evaluacion = 0;
		$presenta = null;

		if(isset($n_cuenta)){
			$es_test = False;
		}

		if(!isset($id_examen)){
			if($es_test){				
				Response::redirect('curso/examenes');
			}else{
				Response::redirect('curso/alumno');
			}
			die();
		}

		DB::start_transaction();
		try{
			$examen = Model_Examen::find_one_by('id_examen', $id_examen);

			if(!$es_test){
				$presenta = Model_Presenta::find(array('n_cuenta' => $n_cuenta, 'id_examen' => $id_examen));
			}

			if(isset($ruta_especial)){			
				SESSION::delete('id_examen');
				SESSION::delete('preguntas_ids');
				SESSION::delete('puntaje_obtenido');
				SESSION::delete('respuestas_no_exitosas');
				SESSION::delete('fallas');
				SESSION::delete('evaluado');
				switch ($ruta_especial) {
					case 'terminado':
						$respuestas_no_exitosas = [];
						$numero_pregunta = 0;
						$comete_error = Model_CometeErroresEn::find('all', array('where' => array(array('n_cuenta', $n_cuenta), array(array('id_examen', $id_examen)) ) ) );
						foreach ($comete_error as $error_cometido) {
							array_push($respuestas_no_exitosas, array($numero_pregunta, $error_cometido->id_pregunta, $error_cometido->id_respuesta));
							$numero_pregunta++;
						}
						break;
					case 'sin_vidas':
						if(!$es_test){
							if(isset($presenta)){
								$presenta->terminado = 1;
								// $presenta->save();
								if ($presenta->save() < 0){
							        throw new \Exception('Falla final en Presenta');
								}
							}
						}
						$data = array('examen' => $examen);
						$this->template->content = View::forge('curso/examen/final_sin_vidas', $data);
						break;
					case 'abandonado':
						SESSION::delete('fallas');
						if(!$es_test){
							if(isset($presenta) && isset($examen)){
								if(!($examen->vidas > $presenta->vidas)){
									$presenta->terminado = 1;
									// $presenta->save();	
									if ($presenta->save() < 0){
								        throw new \Exception('Falla final en Presenta');
									}							
								}
							}
							Response::redirect('curso/alumno');
						}else{
							Response::redirect('curso/examenes');
						}
						break;
					default:
						# code...
						break;
				}
			}
			if(!isset($ruta_especial) || $ruta_especial=== 'terminado'){
				$errores = [];
				if(isset($respuestas_no_exitosas)){
					foreach ($respuestas_no_exitosas as $respuesta) {
						$numero_pregunta = $respuesta[0];
						$id_pregunta = $respuesta[1];
						$id_respuesta = $respuesta[2];
						$pregunta = Model_Pregunta::find_one_by('id_pregunta',$id_pregunta);
						$genera = Model_Genera::find('first',array('where' => array(array('id_pregunta', $id_pregunta))));
						$tema = null;
						if(isset($genera)){
							$id_tema = $genera->id_tema;
							$tema = Model_Tema::find_one_by('id_tema',$id_tema);
						}
						$respuesta = ($id_respuesta >= 0) ? Model_Respuesta::find_one_by('id_respuesta',$id_respuesta) : null;
						$_respuestas = Model_Respuesta::find(function ($query) use ($id_pregunta){
							return $query->join('Contiene')
										->on('Respuesta.id_respuesta', '=', 'Contiene.id_respuesta')
										->where('Contiene.id_pregunta', '=', $id_pregunta)
										->where('Respuesta.porcentaje','=','100');
						});
						$respuesta_correcta = reset($_respuestas);

						$_referencias = Model_Referencia::find(function ($query) use ($id_pregunta){
								return $query->join('FundamentadoEn')
										 ->on('FundamentadoEn.id_referencia', '=', 'Referencia.id_referencia')
										 ->join('ReferenciaFuente')
										 ->on('ReferenciaFuente.id_referencia', '=', 'Referencia.id_referencia')
										 ->join('Fuente')
										 ->on('Fuente.id_fuente', '=', 'ReferenciaFuente.id_fuente')
										 ->join('Edicion')
										 ->on('Edicion.id_fuente', '=', 'Fuente.id_fuente')
										 ->and_on('ReferenciaFuente.numero_edicion', '=','Edicion.numero')
										 ->where('FundamentadoEn.id_pregunta', '=', $id_pregunta);
							});
						$referencia = reset($_referencias);

						$respuesta_porcentaje = isset($respuesta) ? $respuesta->porcentaje : 0;
						if($respuesta_porcentaje > 0){
							$titulo = "Mejora en pregunta";
						}else{
							$titulo = "Error en pregunta";
						}
						$titulo = $titulo.' '.($numero_pregunta+1);
						$texto_pregunta = $pregunta->texto;
						$texto_respuesta = isset($respuesta) ? $respuesta->contenido : 'Sin respuesta';
						$texto_respuesta_correcta = $respuesta_correcta->contenido;
						$justificacion = $pregunta->justificacion;
						$bibliografia = $referencia->nombre.', '.$referencia->numero.'ª edición: página '.$referencia->pagina.', capítulo '.$referencia->capitulo;

						array_push($errores, array('n_cuenta' => $n_cuenta, 'titulo' => $titulo, 'id_pregunta' => $id_pregunta, 'texto_pregunta' => $texto_pregunta, 'muestra_respuestas' => $examen->muestra_respuestas , 'id_tema' => $tema->id_tema, 'texto_tema' => $tema->nombre, 'id_respuesta' => $id_respuesta, 'texto_respuesta' => $texto_respuesta, 'id_respuesta_correcta' => $respuesta_correcta->id_respuesta, 'texto_respuesta_correcta' => $texto_respuesta_correcta, 'justificacion' => $justificacion, 'bibliografia' => $bibliografia ) );

					}
				}

				$p = intval($puntaje_obtenido) / 100;
				$op = intval($examen->oportunidades);
				$tp = intval($examen->preguntas_por_mostrar);
				$v = $es_test ? 1 : intval($presenta->vidas);
				$calificacion = ($p * ( (($tp-$op) / $tp) ** ($v - 1)) ) * (10 / $tp);
				$puntaje_obtenido = $p * (10 / $tp);

				$data = array('examen' => $examen, 'puntaje_obtenido' => $puntaje_obtenido, 'calificacion' => $calificacion, 'errores' => $errores, 'presenta' => $presenta);
				$fallas = SESSION::get('fallas');

				if(isset($id_examen)){
					SESSION::delete('id_examen');
					SESSION::delete('preguntas_ids');
					SESSION::delete('puntaje_obtenido');
					SESSION::delete('respuestas_no_exitosas');
					SESSION::delete('evaluado');
				}
				if(isset($ruta_especial) && $ruta_especial=== 'terminado'){
					$this->template->content = View::forge('curso/examen/final_terminado', $data);
				}elseif(isset($fallas) && intval($fallas) > intval($examen->oportunidades)){
					$fue_ultima_vida = False;
					if(!$es_test){
						if(isset($presenta) && !($presenta->vidas < $examen->vidas)){
							$presenta->terminado = 1;
							// $presenta->save();
							if ($presenta->save() < 0){
						        throw new \Exception('Falla final en Presenta');
							}
							$fue_ultima_vida = True;
						}
					}
					if($fue_ultima_vida)
						$this->template->content = View::forge('curso/examen/final_fallo_ultimo', $data);
					else
						$this->template->content = View::forge('curso/examen/final_fallo', $data);
				}else{
					if(!$es_test){
						if(isset($presenta) && $presenta->terminado != 1){
							$presenta->terminado = 1;
							$presenta->calificacion = $calificacion;
							// $presenta->save();
							if ($presenta->save() < 0){
						        throw new \Exception('Falla final en Presenta');
							}
						}
					}
					$this->template->content = View::forge('curso/examen/final', $data);
				}
			}
			DB::commit_transaction();
		}catch(\Exception $ex){
			DB::rollback_transaction();
		}
	}

	/**
	 * Controlador que llevará a la pantalla previa a presentar un examen.
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_compartir_pregunta($id_pregunta){
		$mensaje = null;
		if(isset($id_pregunta)){
			$pregunta = Model_Pregunta::find_one_by('id_pregunta',$id_pregunta);
			if(isset($pregunta)){
				if($pregunta->compartida === '0'){
					$pregunta->compartida = '1';
				}else{
					$pregunta_compartida = Model_CursoPreguntasCompartidas::find('first',array('where' => array(array('id_pregunta', $id_pregunta))));
					if(isset($pregunta_compartida)){
						$mensaje = 'Esta pregunta solo puede ser actualizada, ya que alguna profesora o profesor la está utilizando.';
					}else{
						$pregunta->compartida = '0';
					}
				}
				$pregunta->save();
				if(!isset($mensaje)){
					$mensaje = 'Pregunta actualizada con éxito.';
				}
			}
		}
		if(isset($mensaje)){
			SESSION::set('mensaje',$mensaje);
		}
		SESSION::set('pestania','preguntas');
		Response::redirect('curso/examenes');
	}

	/**
	 * Controlador que llevará a la pantalla previa a presentar un examen.
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_materias_preguntas_compartidas($param_materia = null){
		$materia = isset($param_materia) ? $param_materia : trim(Input::post('pregunta_compartida_materia'));

		SESSION::set('materia',$materia);
		SESSION::set('pestania','preguntas');
		Response::redirect('curso/cursos_preguntas_compartidas');
	}

	/**
	 * Controlador que llevará a la pantalla de las preguntas compartidas de una materia en especifico
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_preguntas_compartidas($materia = null, $id_curso_compartido = null){
		if(isset($materia) && isset($id_curso_compartido)){
			SESSION::set('id_curso_compartido',$id_curso_compartido);
			SESSION::set('materia',$materia);
			SESSION::set('pestania','preguntas');
			Response::redirect('curso/preguntas_compartidas');
		}else{
			SESSION::set('pestania','preguntas');
			Response::redirect('curso/examenes');
		}
	}

	/**
	 *
	 */
	public function action_agregar_pregunta_compartida(){
		$id_curso = SESSION::get('id_curso');
		$id_pregunta = trim(Input::post('pregunta_id'));
		$materia = trim(Input::post('materia'));
		$id_curso_compartido = trim(Input::post('id_curso_compartido'));
		$pregunta_compartida = Model_CursoPreguntasCompartidas::find(array('id_curso' => $id_curso, 'id_pregunta' => $id_pregunta ));
		if(isset($pregunta_compartida)){
			$pregunta_compartida->delete();
		}else{
			$pregunta_compartida = new Model_CursoPreguntasCompartidas();
			$pregunta_compartida->id_curso = $id_curso;
			$pregunta_compartida->id_pregunta = $id_pregunta;
			$pregunta_compartida->fecha_de_modificacion = date("Y-m-d H:i:s");
			$pregunta_compartida->por_cambiar = '0';
			$pregunta_compartida->save();
		}
		Response::redirect('curso/examen/preguntas_compartidas/'.$materia.'/'.$id_curso_compartido);
	}

	/**
	 *
	 *	Elimina la pregunta de respaldo
	 *
	 */
	private function elimina_respaldo($id_pregunta){
		$respaldo = Model_RespaldoDe::find('first',array('where' => array(array('id_pregunta', $id_pregunta))));
		if(isset($respaldo)){
			$id_pregunta_respaldo = $respaldo->id_pregunta_respaldo;
			$pregunta = Model_Pregunta::find_one_by('id_pregunta',$id_pregunta_respaldo);
			if(isset($pregunta)){
				$this->borra_pregunta($pregunta);
			}
			$respaldo->delete();
		}
	}

	/**
	 *
	 */
	public function action_actualizar_pregunta_compartida($pregunta_id = null){
		$id_curso = SESSION::get('id_curso');
		$mensaje = SESSION::get('mensaje');
		$id_pregunta = Input::post('pregunta_id');
		$id_pregunta = isset($id_pregunta) ? trim($id_pregunta) : $pregunta_id;
		$pregunta_compartida = Model_CursoPreguntasCompartidas::find(array('id_curso' => $id_curso, 'id_pregunta' => $id_pregunta ));
		if(isset($pregunta_compartida)){
			$pregunta_compartida->por_cambiar = '0';
			$pregunta_compartida->save();
			if(!isset($mensaje)){
				SESSION::set('mensaje','Pregunta actualizada');
			}
			$primera_pregunta_compartida = Model_CursoPreguntasCompartidas::find('first',array('where' => array(array('id_pregunta', $id_pregunta),array('por_cambiar', '1'))));

			if(!isset($primera_pregunta_compartida)){
				$this->elimina_respaldo($id_pregunta);
			}
		}
		SESSION::set('pestania','preguntas');
		Response::redirect('curso/examenes');
	}


	/**
	 *
	 */
	public function action_guardar_pregunta_compartida($id_pregunta){
		$id_curso = SESSION::get('id_curso');

		$respaldo = Model_RespaldoDe::find('first',array('where' => array(array('id_pregunta', $id_pregunta))));
		if(isset($respaldo)){
			$id_pregunta_respaldo = $respaldo->id_pregunta_respaldo;
			$pregunta_respaldo = Model_Pregunta::find_one_by('id_pregunta',$id_pregunta_respaldo);

			$id_tema = null;
			$genera = Model_Genera::find('first',array('where' => array(array('id_pregunta', $id_pregunta))));
			if(isset($genera)){
				$id_tema = $genera->id_tema;
			}

			$id_fuente = null;
			$fundamentado_en = Model_FundamentadoEn::find('first',array('where' => array(array('id_pregunta', $id_pregunta))));
			if(isset($fundamentado_en)){
				$referencia_fuente = Model_ReferenciaFuente::find('first',array('where' => array(array('id_referencia', $fundamentado_en->id_referencia))));
				if(isset($referencia_fuente)){
					$id_fuente = $referencia_fuente->id_fuente;
				}
			}

			if(isset($pregunta_respaldo) && isset($id_fuente) && isset($id_fuente)){
				$completa = True;
				$pregunta = $this->copiar_pregunta($pregunta_respaldo, $id_tema, $id_fuente, $completa);
				SESSION::set('mensaje','Pregunta guardada y actualizada');
			}

		}
		Response::redirect('curso/examen/actualizar_pregunta_compartida/'.$id_pregunta);
	}
}