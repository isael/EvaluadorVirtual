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
     
    }

	/**
	 * Controlador que reenvia a la pagina de edicion de cada examen
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_editar()
	{	
		$id_curso = SESSION::get('id_curso');
		if (isset($id_curso)) {
			$id_examen = trim(Input::get('id_examen'));
			if (isset($id_examen) && $id_examen!="") {
				$examen = Model_Examen::find_one_by('id_examen',$id_examen);
				$curso = Model_Curso::find_one_by('id_curso',$id_curso);
				$temas = Model_Tema::find(function ($query) use ($examen){
			    return $query->join('BasadoEn')
			                 ->on('BasadoEn.id_tema', '=', 'Tema.id_tema')
			                 ->where('BasadoEn.id_examen', '=', $examen->id_examen)
			                 ->order_by('BasadoEn.id_examen');
				});
				$data = array('examen' => $examen , 'curso'=>$curso,'temas'=>$temas);;
				$this->template->content = View::forge('curso/examen/editar', $data);
			}else{
				Response::redirect('curso/index');
			}
		}else{
			Response::redirect('sesion/index');
		}
		

	}

	/**
	 * Controlador que muestra la pantalla de seleccion de temas para
	 * la creacion del examen correspondiente.
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_temas()
	{	
		$id_curso = SESSION::get('id_curso');
		if (isset($id_curso)) {
			$id_examen = trim(Input::get('id_examen'));
			if (isset($id_examen) && $id_examen!="") {
				$examen = Model_Examen::find_one_by('id_examen',$id_examen);
				$volver = "curso/examen/editar?id_examen=".$examen->id_examen;
				$curso = Model_Curso::find_one_by('id_curso',$id_curso);
				$temas = Model_Tema::find(function ($query) use ($id_curso,$id_examen){
			    return $query->join('CursoTema')
			                 ->on('CursoTema.id_tema', '=', 'Tema.id_tema')
			                 ->join('BasadoEn')
			                 ->on('BasadoEn.id_tema', '=', 'Tema.id_tema')
			                 ->where('CursoTema.id_curso', '=', $id_curso)
			                 ->order_by('BasadoEn.id_examen');
				});
				$data = array('examen' => $examen , 'curso'=>$curso,'temas'=>$temas,'volver'=>$volver);;
				$this->template->content = View::forge('curso/examen/temas', $data);
			}else{
				Response::redirect('curso/index');
			}
		}else{
			Response::redirect('sesion/index');
		}
		

	}
	/**
	 * Controlador que permite la creación de temas a a
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_crear_tema()
	{	
		$id_curso = SESSION::get('id_curso');
		if (isset($id_curso)) {
			$id_examen = trim(Input::get('id_examen'));
			if (isset($id_examen) && $id_examen!="") {
				$volver = "curso/examen/temas?id_examen=".$id_examen;
				$curso = Model_Curso::find_one_by('id_curso',$id_curso);
				$data = array('curso'=>$curso, 'volver'=>$volver);;
				$this->template->content = View::forge('curso/temas/crear', $data);
			}else{
				Response::redirect('curso/index');
			}
		}else{
			Response::redirect('sesion/index');
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

		$mensaje="";
		$error = False;

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
			if(!checkdate(intval($arreglo_fecha[2]), intval($arreglo_fecha[1]), intval($arreglo_fecha[0]))){
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
			if(!checkdate(intval($arreglo_fecha[2]), intval($arreglo_fecha[1]), intval($arreglo_fecha[0]))){
				$error=True;
				$mensaje=$mensaje."El campo de Vigencia-Final no tiene una fecha válida.<br>";
			}
		}

		$tema=null;
		if(isset($examen_temas_y_niveles) && $examen_temas_y_niveles!==""){
			// if(is_numeric($pregunta_tema_id)){
			// 	$tema = Model_Tema::find_one_by( 'id_tema', $pregunta_tema_id);
			// }
		}else{
			$error=True;
			$mensaje=$mensaje."No se tiene registrada ninguna pregunta para el examen.<br>";
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
				if($modificar_bibliografia){
					$fuente = Model_Fuente::find_one_by('id_fuente',$id_fuente);
					$fuente->nombre = $nombre;
					$fuente->autores = $autores;
					$fuente->save();

					$numero_fuente_iguales = $numero_fuente === $numero;
					if($numero_fuente_iguales){
						$edicion = Model_Edicion::find(array($id_fuente, $numero_fuente));
						$edicion->anio = $anio;
						$edicion->liga = $liga;
						$edicion->save();
					}else{
						$edicion = Model_Edicion::find(array($id_fuente, $numero_fuente));
						$edicion->delete();
						$nueva_edicion = new Model_Edicion();
						$nueva_edicion->id_fuente = $id_fuente;
						$nueva_edicion->numero = $numero;
						$nueva_edicion->anio = $anio;
						$nueva_edicion->liga = $liga;
						$nueva_edicion->save();
					}
					$mensaje = "La bibliografía ".$fuente->nombre." número ".$numero." ha sido actualizada con éxito.";

				}else{
					if($fuente==null){
						$fuente = new Model_Fuente();
						$fuente->nombre = $nombre;
						$fuente->autores = $autores;
						$fuente->save();
					}
					$nueva_edicion = new Model_Edicion();
					$nueva_edicion->id_fuente = $fuente->id_fuente;
					$nueva_edicion->numero = $numero;
					$nueva_edicion->anio = $anio;
					$nueva_edicion->liga = $liga;
					$nueva_edicion->save();

					$curso_fuente = new Model_CursoFuente();
					$curso_fuente->id_curso = $id_curso;
					$curso_fuente->id_fuente = $fuente->id_fuente;
					$curso_fuente->save();

					$mensaje = "La bibliografía ".$fuente->nombre." número ".$nueva_edicion->numero." ha sido registrada con éxito.";
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
				$fuente = Model_Fuente::find_one_by( 'id_fuente', $pregunta_bibliografia);
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
	
		if(!$error){
			/* Bibliografías */

			$id_pregunta = null;
			$id_referencia=null;
			$fundamentado_en = null;

			if($modificar_pregunta){
				$id_pregunta=$pregunta_id;
				$fundamentado_en_lista = Model_FundamentadoEn::find('all',array('where' => array(array('id_pregunta', $pregunta_id))));
				if(isset($fundamentado_en_lista)){
					$fundamentado_en = reset($fundamentado_en_lista);
					$id_referencia = $fundamentado_en->id_referencia;

					$new_referencia = Model_Referencia::find_one_by('id_referencia',$id_referencia);
					if(isset($new_referencia)){
						$update_referencia = False;
						$pagina_iguales = ($new_referencia->pagina === $pregunta_bibliografia_pagina);
						if(!$pagina_iguales){
							$new_referencia->pagina = $pregunta_bibliografia_pagina;
							$update_referencia = True;
						}
						$capitulo_iguales = ($new_referencia->capitulo === $pregunta_bibliografia_capitulo);
						if(!$capitulo_iguales){
							$new_referencia->capitulo = $pregunta_bibliografia_capitulo;
							$update_referencia = True;
						}
						if($update_referencia){
							$new_referencia->save();
						}
					}

					$new_referencia_fuente_lista = Model_ReferenciaFuente::find('all',array('where' => array(array('id_referencia', $id_referencia))));
					if(isset($new_referencia_fuente_lista)){
						$new_referencia_fuente = reset($new_referencia_fuente_lista);
						$update_referencia_fuente = False;
						$fuente_iguales = ($new_referencia_fuente->id_fuente === $pregunta_bibliografia);
						if(!$fuente_iguales){
							$new_referencia_fuente->delete();
							$new_referencia_fuente = new Model_ReferenciaFuente();							
							$new_referencia_fuente->id_fuente = $pregunta_bibliografia;
							$new_referencia_fuente->id_referencia = $id_referencia;
							$update_referencia_fuente = True;
						}
						if($update_referencia_fuente){
							$new_referencia_fuente->save();
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
							$new_pregunta->save();
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
							$porcentaje_iguales = ($resp->porcentaje === $porcentaje_actual);
							if(!$porcentaje_iguales){
								$resp->porcentaje = $porcentaje_actual;
								$update_respuesta = True;
							}
							if($update_respuesta){
								$resp->save();
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
							$genera->delete();
							$new_genera = new Model_Genera();
							$genera->id_pregunta = $id_pregunta;
							$genera->id_tema = $id_tema_actual;
							$genera->save();
						}

						$id_fuente = $fuente->id_fuente;

						$tema_fuente = Model_TemaFuente::find(array($id_tema_antiguo, $id_fuente));
						if(isset($tema_fuente)){
							$cantidad_tema_fuente_string = $tema_fuente->cantidad_preguntas;
							$cantidad_tema_fuente = intval($cantidad_tema_fuente_string);
							if($cantidad_tema_fuente > 1){
								$tema_fuente->cantidad_preguntas =  $cantidad_tema_fuente -1;
								$tema_fuente->save();
							}else{
								$tema_fuente->delete();
							}
							$tema_fuente_nuevo = Model_TemaFuente::find(array($id_tema_actual, $id_fuente));
							if(isset($tema_fuente_nuevo)){
								$cantidad = intval($tema_fuente_nuevo->cantidad_preguntas);
								$tema_fuente_nuevo->cantidad_preguntas = $cantidad + 1;
								$tema_fuente_nuevo->save();
							}else{
								$tema_fuente_nuevo = new Model_TemaFuente();
								$tema_fuente_nuevo->id_fuente = $id_fuente;
								$tema_fuente_nuevo->id_tema = $id_tema_actual;
								$tema_fuente_nuevo->cantidad_preguntas = 1;
								$tema_fuente_nuevo->save();
							}
						}

						$curso_tema = Model_CursoTema::find(array($id_curso, $id_tema_antiguo));
						if(isset($curso_tema)){
							$cantidad_curso_tema_string = $curso_tema->cantidad_preguntas;
							$cantidad_curso_tema = intval($cantidad_curso_tema_string);
							if($cantidad_curso_tema > 1){
								$curso_tema->cantidad_preguntas =  $cantidad_curso_tema -1;
								$curso_tema->save();
							}else{
								$curso_tema->delete();
							}
							$curso_tema_nuevo = Model_CursoTema::find(array($id_curso, $id_tema_actual));
							if(isset($curso_tema_nuevo)){
								$cantidad = intval($curso_tema_nuevo->cantidad_preguntas);
								$curso_tema_nuevo->cantidad_preguntas = $cantidad + 1;
								$curso_tema_nuevo->save();
							}else{
								$curso_tema_nuevo = new Model_CursoTema();
								$curso_tema_nuevo->id_curso = $id_curso;
								$curso_tema_nuevo->id_tema = $id_tema_actual;
								$curso_tema_nuevo->cantidad_preguntas = 1;
								$curso_tema_nuevo->save();
							}
						}
					}

				}
			}else{
				$referencia = new Model_Referencia();
				$referencia->capitulo = $pregunta_bibliografia_capitulo;
				$referencia->pagina = $pregunta_bibliografia_pagina;
				$referencia->save();
				$id_referencia=$referencia->id_referencia;

				$referencia_fuente = new Model_ReferenciaFuente();
				$referencia_fuente->id_referencia = $referencia->id_referencia;
				$referencia_fuente->id_fuente = $fuente->id_fuente;
				$referencia_fuente->save();

				$tipo = Model_Tipo::find_one_by('id_tipo',$pregunta_tipo);//Pendiente

				$pregunta = new Model_Pregunta();
				$pregunta->texto = $pregunta_texto;
				$pregunta->dificultad = $pregunta_dificultad;
				$pregunta->justificacion = $pregunta_justificacion;
				$pregunta->tiene_subpreguntas = $tipo->tiene_subpreguntas; //Pendiente
				$pregunta->tiempo = $pregunta_tiempo;
				$pregunta->save();
				$id_pregunta = $pregunta->id_pregunta;

				$de_tipo = new Model_DeTipo();
				$de_tipo->id_tipo = $tipo->id_tipo;
				$de_tipo->id_pregunta = $id_pregunta;
				$de_tipo->save();

				$fundamentado_en = new Model_FundamentadoEn();
				$fundamentado_en->id_pregunta = $id_pregunta;
				$fundamentado_en->id_referencia = $id_referencia;
				$fundamentado_en->save();

				for ($i=0; $i < $cantidad_respuestas; $i++) {
					$texto_actual = $conjunto_respuestas[$i];
					$porcentaje_actual = $conjunto_porcentajes[$i];
					$resp = new Model_Respuesta();
					$resp->contenido = $texto_actual;
					$resp->porcentaje = $porcentaje_actual;
					$resp->save();

					$contiene = new Model_Contiene();
					$contiene->id_pregunta = $id_pregunta;
					$contiene->id_respuesta = $resp->id_respuesta;
					$contiene->save();
				}

				if(!isset($tema)){
					$tema = new Model_Tema();
					$tema->nombre = $pregunta_tema;
					$tema->save();
				}

				$genera = new Model_Genera();
				$genera->id_pregunta = $id_pregunta;
				$genera->id_tema = $tema->id_tema;
				$genera->save();

				$tema_fuente = Model_TemaFuente::find(array($tema->id_tema, $fuente->id_fuente));
				if(!isset($tema_fuente)){
					$tema_fuente = new Model_TemaFuente();
					$tema_fuente->id_fuente = $fuente->id_fuente;
					$tema_fuente->id_tema = $tema->id_tema;
					$tema_fuente->cantidad_preguntas = 1;
					$tema_fuente->save();
				}else{
					$cantidad_tema_fuente_string = $tema_fuente->cantidad_preguntas;
					$tema_fuente->cantidad_preguntas = intval($cantidad_tema_fuente_string) + 1;
					$tema_fuente->save();
				}

				$curso_tema = Model_CursoTema::find(array($id_curso, $tema->id_tema));
				if(!isset($curso_tema)){
					$curso_tema = new Model_CursoTema();
					$curso_tema->id_curso = $id_curso;
					$curso_tema->id_tema = $tema->id_tema;
					$curso_tema->cantidad_preguntas = 1;
					$curso_tema->save();
				}else{
					$cantidad_curso_tema_string = $curso_tema->cantidad_preguntas;
					$curso_tema->cantidad_preguntas = intval($cantidad_curso_tema_string) + 1;
					$curso_tema->save();
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
	public function action_mostrar_pregunta($id_pregunta)
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
			SESSION::set('pestania','preguntas');
			Response::redirect('curso/examenes');
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

}