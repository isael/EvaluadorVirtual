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
	 * Controlador que muestra la pantalla de creacion de temas para
	 * la creacion del examen correspondiente.
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
	 * Controlador que muestra la pantalla de creacion de fuentes bibliográficas para
	 * la creacion del examen correspondiente.
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_crear_bibliografia()
	{
		$id_curso = SESSION::get('id_curso');
		$data = null;
		$nombre = trim(Input::post('nombre_bibliografia'));
		$autores=trim(Input::post('autor_bibliografia'));
		$numero=trim(Input::post('numero_edicion_bibliografia'));
		$anio=trim(Input::post('anio_bibliografia'));
		$liga=trim(Input::post('link_bibliografia'));

		$mensaje="";
		$error = False;
		$edicion = null;
		$fuente = Model_Fuente::find_one_by(array('nombre' => $nombre, 'autores' => $autores ));
		if($fuente!=null){
			$edicion = Model_Edicion::find(array($fuente->id_fuente, $numero ));
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
	 * Controlador que muestra la pantalla de creacion de fuentes bibliográficas para
	 * la creacion del examen correspondiente.
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

		$pregunta_id = trim(Input::post('pregunta_id'));
		$pregunta_tipo = trim(Input::post('pregunta_tipo'));
		$pregunta_tiene_subpregunta = trim(Input::post('pregunta_tiene_subpregunta'));
		$pregunta_tema = trim(Input::post('pregunta_tema_option_selected'));
		$pregunta_bibliografia=trim(Input::post('pregunta_bibliografia_option_selected'));
		$pregunta_bibliografia_pagina=trim(Input::post('pregunta_bibliografia_pagina'));
		$pregunta_bibliografia_capitulo=trim(Input::post('pregunta_bibliografia_capitulo'));
		$pregunta_dificultad=trim(Input::post('pregunta_dificultad'));
		$pregunta_tiempo=trim(Input::post('pregunta_tiempo'));
		$pregunta_texto=trim(Input::post('pregunta_texto'));
		$pregunta_justificacion=trim(Input::post('pregunta_justificacion'));
		$pregunta_cantidad=trim(Input::post('pregunta_cantidad_respuestas'));

		$tema=null;
		if(isset($pregunta_tema) && $pregunta_tema!==""){
			if(is_numeric($pregunta_tema)){				
				$tema = Model_Tema::find_one_by( 'nombre', $pregunta_tema));
			}
		}else{
			$error=True;
			$mensaje=$mensaje."El campo de Tema no fue correctamente seleccionado.<br>";
		}

		$fuente=null;
		if(isset($pregunta_bibliografia) && $pregunta_bibliografia!=="" && is_numeric($pregunta_bibliografia)){
				$fuente = Model_Fuente::find_one_by( 'id_fuente', $pregunta_bibliografia));
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
		}

		if($pregunta_bibliografia_capitulo==null||$pregunta_bibliografia_capitulo===""){
			$error=True;
			$mensaje=$mensaje."El campo de Capítulo está vacío.<br>";
		}elseif(!preg_match("/^[0-9]+$/",$pregunta_bibliografia_capitulo)){
			$error=True;
			$mensaje=$mensaje."El campo de Capítulo contiene más que números.<br>";
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
		}

		if($pregunta_tipo==null||$pregunta_tipo===""){
			$error=True;
			$mensaje=$mensaje."El campo de Tipo está vacío.<br>";
		}

		if($pregunta_tiene_subpregunta==null||$pregunta_tiene_subpregunta===""){
			$error=True;
			$mensaje=$mensaje."El campo de Tiene subpregunta está vacío.<br>";
		}

		if($pregunta_texto==null||$pregunta_texto===""){
			$error=True;
			$mensaje=$mensaje."El campo de Pregunta está vacío.<br>";
		}

		$conjunto_respuestas = array();
		$conjunto_porcentajes = array();
		if(isset($pregunta_cantidad)){
			$cantidad = intval($pregunta_cantidad);
			$maximo_porcentaje = 0;
			for ($i=1; $i <= $cantidad; $i++) {
				$respuesta = trim(Input::post('pregunta_respuesta_'.$i));
				$porcentaje_texto = trim(Input::post('pregunta_respuesta_porcentaje_'.$i));
				$porcentaje = 0;
				if(isset($respuesta) && $respuesta !== ''){
					array_push($conjunto_respuestas, $respuesta);
					if(isset($porcentaje_texto)  && $porcentaje_texto !== '')){
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
					$mensaje = "Hay respuestas y/o porcentajes sin llenar.<br>";
					$i=$cantidad+1; //Detiene el for
				}
			}
			if($maximo_porcentaje!=100){
				$error = True;
				$mensaje = "Debe haber al menos una respuesta con porcentaje del 100%.<br>";
			}
		}

		if($pregunta_justificacion==null||$pregunta_justificacion===""){
			$error=True;
			$mensaje=$mensaje."El campo de Justificación está vacío.<br>";
		}
	
		if(!$error){
			$referencias = Model_Referencia::find(function ($query) use ($fuente, $pregunta_bibliografia_capitulo, $pregunta_bibliografia_pagina){
		    	return $query->join('ReferenciaFuente')
		                 ->on('ReferenciaFuente.id_referencia', '=', 'Referencia.id_referencia')
		                 ->join('Fuente')
		                 ->on('Fuente.id_fuente', '=', 'ReferenciaFuente.id_fuente')
		                 ->where('ReferenciaFuente.id_fuente', '=', $fuente->id_fuente)
		                 ->and_where('Referencia.pagina', $pregunta_bibliografia_pagina)
		                 ->and_where('Referencia.capitulo', $pregunta_bibliografia_capitulo)
		                 ->order_by('Fuente.id_examen');
			});

			$id_referencia="";
			if(isset($referencias)){
				$referencia_completa = reset($referencias);
				$id_referencia=$referencia_completa->id_referencia;
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
			}

			$id_pregunta = null;
			$fundamentado_en = null;
			if(isset($pregunta_id)){
				$fundamentado_en = Model_FundamentadoEn::find_one_by(array('id_referencia' => $id_referencia, 'id_pregunta' => $pregunta_id ));
				if(isset($fundamentado_en)){
					$id_pregunta = $pregunta_id;
				}
			}else{
				$pregunta = new Model_Pregunta();
				$pregunta->texto = $pregunta_texto;
				$pregunta->dificultad = $pregunta_dificultad;
				$pregunta->justificacion = $pregunta_justificacion;
				$pregunta->tiene_subpregunta = $pregunta_tiene_subpregunta; //Pendiente
				$pregunta->save();
				$id_pregunta = $pregunta->id_pregunta;

				$tipo = Model_Tipo::find_one_by('id_tipo',$pregunta_tipo);//Pendiente
				$de_tipo = new Model_DeTipo();
				$de_tipo->id_tipo = $tipo->id_tipo;
				$de_tipo->id_pregunta = $id_pregunta;
				$de_tipo->save();
			}
			if(!isset($fundamentado_en))
				$fundamentado_en = new Model_FundamentadoEn();
				$fundamentado_en->id_pregunta = $id_pregunta;
				$fundamentado_en->id_referencia = $id_referencia;
				$fundamentado_en->save();
			}


			if($tema==null){					
				$tema = new Model_Tema();
				$tema->nombre = $pregunta_tema;
				$tema->save();
			}

			$tema_fuente = Model_TemaFuente::find_one_by(array('id_tema' => $tema->id_tema, 'id_fuente' => $fuente->id_fuente ));
			if(!isset($tema_fuente)){
				$tema_fuente = new Model_TemaFuente();
				$tema_fuente->id_fuente = $fuente->id_fuente;
				$tema_fuente->id_tema = $tema->id_tema;
				$tema_fuente->save();
			}

			$curso_tema = Model_CursoTema::find_one_by(array('id_curso' => $id_curso ,'id_tema' => $tema->id_tema));
			if(!isset($curso_tema)){
				$curso_tema = new Model_CursoTema();
				$curso_tema->id_curso = $id_curso;
				$curso_tema->id_tema = $tema->id_tema;
				$curso_tema->save();
			}


			$mensaje = "La nueva pregunta ha sido agregada con éxito.";
		}

		$curso = Model_Curso::find_one_by('id_curso',$id_curso);
		if($error){
			$data = array('nombre'=> $nombre, 'autores' => $autores, 'numero' => $numero, 'anio' => $anio, 'liga' => $liga);
			SESSION::set('mensaje',$mensaje);
			SESSION::set('pestania','preguntas');
			SESSION::set('data',$data);
			Response::redirect('curso/examenes');
		}else{
			SESSION::set('mensaje',$mensaje);
			SESSION::set('pestania','preguntas');
			Response::redirect('curso/examenes');
		}

	}

}