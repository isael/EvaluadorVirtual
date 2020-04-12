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
class Controller_Curso extends Controller_Template
{

	public $template = 'template';

	public function before()
	{
		parent::before();
		$this->template->nav_bar = View::forge('nav_bar_sesion');
		$this->template->title = "Evaluador Virtual";
	}

	/**
	 * Controlador de la vista principal de la aplicacion
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_index()
	{
		$id=SESSION::get('id_sesion');
		if(isset($id)){
			$id_curso = SESSION::get('id_curso');
			if(!isset($id_curso)){
				$id_curso = Input::get('id');
				SESSION::set('id_curso',$id_curso);
			}
			$curso = Model_Curso::find_one_by('id_curso',$id_curso);
			$hoy = date('Y-m-d H:i:s');
			$delete_data_date_value = strtotime ( '-30 days' , strtotime ($hoy));
			$delete_data_date = date( "Y-m-d H:i:s" , $delete_data_date_value);
			if($curso && $curso->activo && $curso->fecha_fin < $hoy){
				$curso->activo = 0;
				$curso->save();
			}
			SESSION::set('id_curso',$id_curso);
			// echo var_dump($curso->fecha_fin < $delete_data_date);
			// echo var_dump($curso->fecha_fin);
			// echo var_dump($delete_data_date);
			// die();
			if($curso && !$curso->activo && $curso->fecha_fin < $delete_data_date){
				$this->borrar_informacion();
			}
			$tipo_usuario = substr($id,0,1);
			if($tipo_usuario == "p"){
				$sesion = "profesor";
			}else{
				$sesion = "alumno";
			}
			Response::redirect("curso/".$sesion);
		}else{
			Response::redirect('sesion/inicio');
		}
	}

	/**
	 * Controlador de la vista principal del alumno
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_alumno()
	{
		$id=SESSION::get('id_sesion');
		if(isset($volver) && $volver === 'volver'){
			SESSION::delete('id_examen');
		}
		if(isset($id) && ($tipo_usuario = substr($id,0,1))=='a'){
			$id_curso = SESSION::get('id_curso');
			$curso = Model_Curso::find_one_by('id_curso',$id_curso);
			$hoy = date('Y-m-d H:i:s');

			$n_cuenta = substr($id, 1);

			$examenes = Model_Examen::find(function ($query) use ($id_curso, $hoy){
				return $query->join('Evalua')
							 ->on('Evalua.id_examen', '=', 'Examen.id_examen')
							 ->where('Evalua.id_curso', $id_curso)
							 ->order_by('Examen.fecha_fin');
			});
			$examenes_disponibles=[];
			$examenes_hechos=[];
			$cantidad_presentados = 0;
			$suma_calificacion_presentados = 0;
			$promedio = 0;
			if(isset($examenes)){
				foreach ($examenes as $examen) {
					if($examen->fecha_fin >= $hoy && $examen->fecha_inicio <= $hoy){
						array_push($examenes_disponibles, $examen->id_examen);
					}
					$presenta = Model_Presenta::find(array('n_cuenta' => $n_cuenta, 'id_examen' => $examen->id_examen));
					if(isset($presenta) && $presenta->terminado > 0){
						array_push($examenes_hechos, $examen->id_examen);
						$cantidad_presentados++;
						$suma_calificacion_presentados = $suma_calificacion_presentados + intval($presenta->calificacion);
					}
				}
			}

			if($cantidad_presentados > 0){
				$promedio = $suma_calificacion_presentados / $cantidad_presentados;
			}

			$data = array('curso' => $curso, 'examenes' => $examenes, 'examenes_disponibles' => $examenes_disponibles, 'examenes_hechos' => $examenes_hechos, 'promedio' => $promedio, 'hoy' => $hoy);
			$this->template->content = View::forge('curso/alumno', $data);
		}else{
			Response::redirect('sesion/index');
		}
	}

	/**
	 * Controlador de la vista principal del profesor
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_profesor()
	{
		$id=SESSION::get('id_sesion');

		if(isset($id) && ($tipo_usuario = substr($id,0,1))=='p'){

			$id_curso = SESSION::get('id_curso');
			$curso = Model_Curso::find_one_by('id_curso',$id_curso);
			if($curso == null){
				Response::redirect('sesion/index');
			}
			$alumnos = Model_Alumno::find(function ($query) use ($id_curso){
				return $query->join('Cursa')
							 ->on('Cursa.n_cuenta', '=', 'Alumno.n_cuenta')
							 ->where('Cursa.id_curso', $id_curso)
							 ->order_by('Cursa.estado');
			});

			$hay_informacion_por_borrar = isset($alumnos) && $curso->activo === '0';
			$data = array('curso' => $curso, 'alumnos' => $alumnos, 'hay_informacion_por_borrar' => $hay_informacion_por_borrar);
			$this->template->content = View::forge('curso/profesor', $data);
		}else{
			Response::redirect('sesion/index');
		}
	}

	/**
	 * Controlador que cambia entre curso activo y curso no activo
	 *
	 */

	public function action_alta_baja(){
		$id=SESSION::get('id_sesion');
		$id_curso = SESSION::get('id_curso');
		if(isset($id_curso) && isset($id) && ($tipo_usuario = substr($id,0,1))=='p'){
			$curso = Model_Curso::find_one_by('id_curso',$id_curso);
			$curso->activo = $curso->activo === '1' ? '0' : '1';
			$curso->save();
			Response::redirect('curso/profesor');
		}else{
			Response::redirect('sesion/index');
		}
	}

	/**
	 * Controlador que cambia las fechas de inicio, fin y la clave del curso
	 *
	 */

	public function action_borrar_informacion(){
		$id=SESSION::get('id_sesion');
		$id_curso = SESSION::get('id_curso');
		if(isset($id_curso) && isset($id) && ($tipo_usuario = substr($id,0,1))=='p'){
			$this->borrar_informacion();
			Response::redirect('curso/profesor');
		}else{
			Response::redirect('sesion/index');
		}
	}

	/**
	 *
	 */
	private function borrar_informacion(){
		$id=SESSION::get('id_sesion');
		$id_curso = SESSION::get('id_curso');
		DB::start_transaction();
		try{
			//Borrar todos los Cursa cuyo id_curso = id_curso
			$cursa = Model_Cursa::find('first',array('where' => array(array('id_curso', $id_curso))));
			if(isset($cursa)){
				$sql = "DELETE FROM `Cursa` WHERE `id_curso` =".$id_curso;
				$borrado = DB::query($sql)->execute();
				if (!$borrado){
					throw new \Exception('Falla al borrar los elementos de Cursa');
				}
			}
			//Buscar los id de Examenes que tenga Evalua con el Curso y guardarlos en $lista_examenes
			$lista_examenes = [];
			$examenes = Model_Examen::find(function ($query) use ($id_curso){
				return $query->join('Evalua')
						 ->on('Evalua.id_examen', '=', 'Examen.id_examen')
						 ->where('Evalua.id_curso', $id_curso);
			});
			if(isset($examenes)){
				foreach ($examenes as $examen) {
					array_push($lista_examenes, '"'.$examen->id_examen.'"');
				}
			}else{
				$lista_examenes = [''];
			}
			$lista_examenes_string = implode(",", $lista_examenes);
			//Borrar todos los Presenta cuyo id_examen esté en $lista_examenes
			$presenta = Model_Presenta::find('first',array('where' => array(array('id_examen', 'IN', $lista_examenes))));
			if(isset($presenta)){
				$sql = "DELETE FROM `Presenta` WHERE `id_examen` IN (".$lista_examenes_string.")";
				$borrado = DB::query($sql)->execute();					
				if (!$borrado){
					throw new \Exception('Falla al borrar los elementos de Presenta');
				}
			}
			//Borrar todos los Comete Errores En cuyo id_examen esté en $lista_examenes
			$comete_errores_en = Model_CometeErroresEn::find('first',array('where' => array(array('id_examen', 'IN', $lista_examenes))));
			if(isset($comete_errores_en)){
				$sql = "DELETE FROM `CometeErroresEn` WHERE `id_examen` IN (".$lista_examenes_string.")";
				$borrado = DB::query($sql)->execute();					
				if (!$borrado){
					throw new \Exception('Falla al borrar los elementos de Presenta');
				}
			}
			DB::commit_transaction();
		}catch(\Exception $ex){
			DB::rollback_transaction();
			SESSION::set('mensaje',"Hubo un error al borrar la información: ".$ex->getMessage());
		}
	}

	/**
	 * Controlador que cambia las fechas de inicio, fin y la clave del curso
	 *
	 */

	public function action_reestablecer_curso(){
		$id_curso = SESSION::get('id_curso');
		$id=SESSION::get('id_sesion');
		$clave_curso = trim(Input::post('clave_curso'));
		if(isset($id_curso) && isset($clave_curso) && isset($id) && ($tipo_usuario = substr($id,0,1))=='p'){
			$curso = Model_Curso::find_one_by('id_curso',$id_curso);
			if($curso->activo === '0'){
				$hoy= date("Y-m-d H:i:s");
				$new_date_value = strtotime ( '+5 months' , strtotime ($hoy));
				$new_date = date( "Y-m-d H:i:s" , $new_date_value);
				$curso->clave = $clave_curso;
				$curso->fecha_inicio = $hoy;
				$curso->fecha_fin = $new_date;
				$curso->activo = '1';
				try{
					$curso->save();
				}catch(Database_Exception $e){
					$pos = strpos($e->getMessage(), "Duplicate entry");	//Es el error que marca cuando hay duplicados
					if ($pos !== false) {
						$mensaje="Ya existe un curso con esa clave '$clave_curso'";
					} else {
						$mensaje="Hubo un error al crear el curso";
					}
					SESSION::set('mensaje',$mensaje);
				}
			}
			Response::redirect('curso/profesor');
		}else{
			Response::redirect('sesion/index');
		}
	}

	/**
	 * Controlador que se encarga de actualizar el estado de la tabla
	 * Cursa y saber si es (a) aceptado, (r) rechazado o sigue en (e) espera
	 * @access  public
	 * @return  Response
	 */
	public function action_responder()
	{	
		$n_cuenta = Input::post('n_cuenta');
		$estado = Input::post('aceptar');
		$estado2 = Input::post('rechazar');
		$id_curso = SESSION::get('id_curso');
		$solicitud = Model_Cursa::find(array($n_cuenta,$id_curso));
		if($estado=="1"){			
			$solicitud->estado='a';
		}elseif ($estado2=="1"){
			$solicitud->estado='r';
		}
		$solicitud->save();
		Response::redirect('curso/index');
	}

	/**
	 * Controlador que se encarga de actualizar el estado de la tabla
	 * Cursa y saber si es (a) aceptado, (r) rechazado o sigue en (e) espera
	 * por cada alumno que haya seleccionado en la vista
	 * @access  public
	 * @return  Response
	 */
	public function action_responder_todos()
	{	
		$inputs = Input::all();
		$accion = null;
		$alumnos = array();		
		foreach ($inputs as $input => $value) {
			if ($value != "on"){
				if ($value != "aceptar" && $value != "rechazar"){
					$alumnos[] = $value;
				}else{
					$accion = $value;
				}
			}	

		}
		if(isset($alumnos) && isset($accion)){
			$id_curso = SESSION::get('id_curso');
			foreach ($alumnos as $alumno) {
				$solicitud = Model_Cursa::find(array($alumno,$id_curso));
				if($accion=="aceptar"){
					$solicitud->estado='a';
				}elseif ($accion=="rechazar"){
					$solicitud->estado='r';
				}
				$solicitud->save();
			}
		}
		/*$n_cuenta = Input::post('n_cuenta');
		$estado = Input::post('aceptar');
		$estado2 = Input::post('rechazar');
		$id_curso = SESSION::get('id_curso');
		$solicitud = Model_Cursa::find(array($n_cuenta,$id_curso));
		if($estado=="1"){
			$solicitud->estado='a';
		}elseif ($estado2=="1"){
			$solicitud->estado='r';
		}
		$solicitud->save();*/
		Response::redirect('curso/alumnos');
	}

	/**
	 * Controlador que muestra las estadisticas del alumno
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_mis_estadisticas()
	{	
		$id=SESSION::get('id_sesion');
		if(isset($id) && ($tipo_usuario = substr($id,0,1))=='a'){
			$id_curso = SESSION::get('id_curso');
			$curso = Model_Curso::find_one_by('id_curso',$id_curso);
			$n_cuenta = substr($id, 1);
			
			$calificaciones = Model_Examen::find(function ($query) use ($id_curso,$n_cuenta){
				return $query->select('Examen.nombre','Presenta.calificacion')
							 ->join('Evalua')
							 ->on('Evalua.id_examen', '=', 'Examen.id_examen')
							 ->join('Presenta')
							 ->on('Presenta.id_examen', '=', 'Examen.id_examen')
							 ->where('Evalua.id_curso', $id_curso)
							 ->where('Presenta.n_cuenta', $n_cuenta)
							 ->where('Presenta.terminado', '=', '1')
							 ->order_by('Examen.id_examen');
			});

			$promedios_arreglo_examenes = [];
			$promedios_arreglo_promedios = [];
			if(isset($calificaciones)){
				foreach ($calificaciones as $calificacion) {
					array_push($promedios_arreglo_examenes, $calificacion->nombre);
					array_push($promedios_arreglo_promedios, intval($calificacion->calificacion));
				}
			}

			$promedios = array('examenes' => $promedios_arreglo_examenes, 'promedios' => $promedios_arreglo_promedios);

			// $temas = Model_Tema::find(function ($query) use ($id_curso,$n_cuenta){
			//	 return $query->select('Tema.nombre',array('Examen.nombre','nombre_ex'))
			//				  ->join('CometeErroresEn')
			//				  ->on('CometeErroresEn.id_tema', '=', 'Tema.id_tema')
			//				  ->join('Examen')
			//				  ->on('Examen.id_examen', '=', 'CometeErroresEn.id_examen')
			//				  ->join('Evalua')
			//				  ->on('Evalua.id_examen', '=', 'Examen.id_examen')
			//				  ->where('Evalua.id_curso', $id_curso)
			//				  ->where('CometeErroresEn.n_cuenta', $n_cuenta)
			//				  ->order_by('nombre_ex')
			//				  ->order_by('Tema.nombre');
			// });

			$sql = "SELECT `Tema`.`nombre`, `Examen`.`nombre` AS `nombre_ex`, COUNT(*) AS `suma` FROM `Tema` JOIN `CometeErroresEn` ON (`CometeErroresEn`.`id_tema` = `Tema`.`id_tema`) JOIN `Examen` ON (`Examen`.`id_examen` = `CometeErroresEn`.`id_examen`) JOIN `Evalua` ON (`Evalua`.`id_examen` = `Examen`.`id_examen`) WHERE `Evalua`.`id_curso` = '".$id_curso."' AND `CometeErroresEn`.`n_cuenta` = '".$n_cuenta."' GROUP BY `Tema`.`nombre`, `nombre_ex`";
			$temas = DB::query($sql)->execute();

			$temas_ordenados_por_errores = [];
			$temas_arreglo_temas = [];
			$temas_arreglo_examenes = [];
			$temas_arreglo_examenes_por_tema = [];
			$temas_arreglo_errores = [];

			$tema = null;

			if(isset($temas)){
				foreach ($temas as $tema) {
					$nombre = $tema['nombre'];
					if(array_key_exists($nombre, $temas_arreglo_temas)){
						$temas_arreglo_examenes_por_tema[$nombre] = $temas_arreglo_examenes_por_tema[$nombre].', '.$tema['nombre_ex'];
						$temas_arreglo_temas[$nombre] = $temas_arreglo_temas[$nombre] + intval($tema['suma']);
					}else{
						$temas_arreglo_examenes_por_tema[$nombre] = $tema['nombre_ex'];
						$temas_arreglo_temas[$nombre] = intval($tema['suma']);
					}
				}
			}

			arsort($temas_arreglo_temas);
			if(isset($temas_arreglo_temas)){
				foreach ($temas_arreglo_temas as $key => $value) {
					array_push($temas_ordenados_por_errores, $key);
					array_push($temas_arreglo_errores, $value);
					array_push($temas_arreglo_examenes, $temas_arreglo_examenes_por_tema[$key]);
				}
			}

			$temasFallados = array('temas' => $temas_arreglo_temas, 'examenes' => $temas_arreglo_examenes, 'errores' => $temas_arreglo_errores );;

			$data = array('curso' => $curso, 'promedios' => $promedios, 'temasFallados' => $temasFallados);

			$this->template->content = View::forge('curso/mis_estadisticas', $data);
		}else{
			Response::redirect('sesion/index');
		}
	}
	/**
	 * Controlador que muestra las estadisticas del alumno
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_examenes($volver = null)
	{	
		$id=SESSION::get('id_sesion');
		if(isset($volver) && $volver === 'volver'){
			SESSION::delete('id_examen');
		}
		$id_curso = SESSION::get('id_curso');
		if(isset($id) && isset($id_curso) && ($tipo_usuario = substr($id,0,1))=='p'){
			$curso = Model_Curso::find_one_by('id_curso',$id_curso);
			
			$examenes = Model_Examen::find(function ($query) use ($id_curso){
				return $query->join('Evalua')
							 ->on('Evalua.id_examen', '=', 'Examen.id_examen')
							 ->where('Evalua.id_curso', $id_curso)
							 ->order_by('Evalua.id_examen');
			});

			$temas = Model_Tema::find(function ($query) use ($id_curso){
				return $query->join('CursoTema')
							 ->on('CursoTema.id_tema', '=', 'Tema.id_tema')
							 ->where('CursoTema.id_curso', '=', $id_curso);
			});

			$temas_externos = Model_Tema::find(function ($query) use ($id_curso){
				return $query->join('Genera')
							 ->on('Genera.id_tema', '=', 'Tema.id_tema')
							 ->join('Pregunta')
							 ->on('Pregunta.id_pregunta', '=', 'Genera.id_pregunta')
							 ->join('CursoPreguntasCompartidas')
							 ->on('CursoPreguntasCompartidas.id_pregunta', '=', 'Pregunta.id_pregunta')
							 ->where('CursoPreguntasCompartidas.id_curso', '=', $id_curso);
			});

			$tipos = Model_Tipo::find_all();

			$ids_preguntas_de_respaldo = [];
			$preguntas_de_respaldo = Model_RespaldoDe::find('all');
			if(isset($preguntas_de_respaldo)){
				foreach ($preguntas_de_respaldo as $pregunta_de_respaldo) {
					array_push($ids_preguntas_de_respaldo, $pregunta_de_respaldo->id_pregunta_respaldo);
				}
			}
			if($ids_preguntas_de_respaldo === []){
				$ids_preguntas_de_respaldo = [''];
			}
			$preguntas = Model_Pregunta::find(function ($query) use ($id_curso,$ids_preguntas_de_respaldo){
				return $query->join('Genera')
							 ->on('Genera.id_pregunta', '=', 'Pregunta.id_pregunta')
							 ->join('Tema')
							 ->on('Tema.id_tema', '=', 'Genera.id_tema')
							 ->join('CursoTema')
							 ->on('CursoTema.id_tema', '=', 'Tema.id_tema')
							 ->where('CursoTema.id_curso', '=', $id_curso)
							 ->where('Genera.id_pregunta', 'NOT IN', $ids_preguntas_de_respaldo)
							 ->order_by('Tema.nombre')
							 ->order_by('Pregunta.id_pregunta');
			});

			$preguntas_externas = Model_Pregunta::find(function ($query) use ($id_curso){
				return $query->join('Genera')
							 ->on('Genera.id_pregunta', '=', 'Pregunta.id_pregunta')
							 ->join('Tema')
							 ->on('Tema.id_tema', '=', 'Genera.id_tema')
							 ->join('PreguntasExternas')
							 ->on('PreguntasExternas.id_pregunta', '=', 'Pregunta.id_pregunta')
							 ->where('PreguntasExternas.id_curso', '=', $id_curso)
							 ->order_by('Tema.nombre')
							 ->order_by('Pregunta.id_pregunta');
			});

			$bibliografias = Model_Fuente::find(function ($query) use ($id_curso){
				return $query->join('Edicion')
							 ->on('Edicion.id_fuente', '=', 'Fuente.id_fuente')
							 ->join('CursoFuente')
							 ->on('CursoFuente.id_fuente', '=', 'Fuente.id_fuente')
							 ->where('CursoFuente.id_curso', $id_curso)
							 ->order_by('Fuente.nombre');
			});

			$profesores = null;

			$data = array('curso' => $curso, 'temas' => $temas, 'temas_externos' => $temas_externos, 'examenes' => $examenes, 'bibliografias' => $bibliografias, 'preguntas' => $preguntas,'preguntas_externas' => $preguntas_externas, 'tipos' => $tipos, 'profesores' => $profesores);
			
			$this->template->content = View::forge('curso/examenes', $data);
		}else{
			Response::redirect('sesion/index');
		}
	}
	/**
	 * Controlador que muestra las estadisticas de los alumnos
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_estadisticas()
	{	
		$id=SESSION::get('id_sesion');
		if(isset($id) && ($tipo_usuario = substr($id,0,1))=='p'){
			$id_curso = SESSION::get('id_curso');
			$curso = Model_Curso::find_one_by('id_curso',$id_curso);
			
			$calificaciones = Model_Examen::find(function ($query) use ($id_curso){
				return $query->select('Examen.nombre','Presenta.calificacion')
							 ->join('Evalua')
							 ->on('Evalua.id_examen', '=', 'Examen.id_examen')
							 ->join('Presenta')
							 ->on('Presenta.id_examen', '=', 'Examen.id_examen')
							 ->where('Evalua.id_curso', $id_curso)
							 ->where('Presenta.terminado', '=', '1')
							 ->order_by('Examen.id_examen');
			});

			$promedios_arreglo_examenes = [];
			$promedios_arreglo_promedios = [];
			$promedios_arreglo_asistencia = [];

			$examen_actual = null;
			$suma_calificaciones = 0;
			$asistencia_actual = 0;
			if(isset($calificaciones)){
				foreach ($calificaciones as $calificacion) {
					if(isset($examen_actual)){
						if($examen_actual !== $calificacion->nombre){
							array_push($promedios_arreglo_examenes, $examen_actual);
							array_push($promedios_arreglo_asistencia, $asistencia_actual);
							array_push($promedios_arreglo_promedios, intval($suma_calificaciones / $asistencia_actual));
							$examen_actual = $calificacion->nombre;
							$suma_calificaciones = intval($calificacion->calificacion);
							$asistencia_actual = 1;
						}else{
							$suma_calificaciones = $suma_calificaciones + intval($calificacion->calificacion);
							$asistencia_actual = $asistencia_actual + 1;
						}
					}else{
						$examen_actual = $calificacion->nombre;
						$suma_calificaciones = intval($calificacion->calificacion);
						$asistencia_actual = 1;
					}
				}
				array_push($promedios_arreglo_examenes, $examen_actual);
				array_push($promedios_arreglo_asistencia, $asistencia_actual);
				array_push($promedios_arreglo_promedios, intval($suma_calificaciones / $asistencia_actual));
			}

			$promedios = array('examenes' => $promedios_arreglo_examenes, 'promedios' => $promedios_arreglo_promedios, 'asistencia' => $promedios_arreglo_asistencia);

			$sql = "SELECT `Tema`.`nombre`, `Examen`.`nombre` AS `nombre_ex`, COUNT(*) AS `suma` FROM `Tema` JOIN `CometeErroresEn` ON (`CometeErroresEn`.`id_tema` = `Tema`.`id_tema`) JOIN `Examen` ON (`Examen`.`id_examen` = `CometeErroresEn`.`id_examen`) JOIN `Evalua` ON (`Evalua`.`id_examen` = `Examen`.`id_examen`) WHERE `Evalua`.`id_curso` = '".$id_curso."' GROUP BY `Tema`.`nombre`, `nombre_ex`";
			$temas = DB::query($sql)->execute();

			$temas_ordenados_por_errores = [];
			$temas_arreglo_temas = [];
			$temas_arreglo_examenes = [];
			$temas_arreglo_examenes_por_tema = [];
			$temas_arreglo_errores = [];

			$tema = null;

			if(isset($temas)){
				foreach ($temas as $tema) {
					$nombre = $tema['nombre'];
					if(array_key_exists($nombre, $temas_arreglo_temas)){
						$temas_arreglo_examenes_por_tema[$nombre] = $temas_arreglo_examenes_por_tema[$nombre].', '.$tema['nombre_ex'];
						$temas_arreglo_temas[$nombre] = $temas_arreglo_temas[$nombre] + intval($tema['suma']);
					}else{
						$temas_arreglo_examenes_por_tema[$nombre] = $tema['nombre_ex'];
						$temas_arreglo_temas[$nombre] = intval($tema['suma']);
					}
				}
			}

			arsort($temas_arreglo_temas);
			if(isset($temas_arreglo_temas)){
				foreach ($temas_arreglo_temas as $key => $value) {
					array_push($temas_ordenados_por_errores, $key);
					array_push($temas_arreglo_errores, $value);
					array_push($temas_arreglo_examenes, $temas_arreglo_examenes_por_tema[$key]);
				}
			}
			// $temas = Model_Tema::find(function ($query) use ($id_curso){
			//	 return $query->select('Tema.nombre',array('Examen.nombre','nombre_ex'))
			//				  ->join('CometeErroresEn')
			//				  ->on('CometeErroresEn.id_tema', '=', 'Tema.id_tema')
			//				  ->join('BasadoEn')
			//				  ->on('BasadoEn.id_tema', '=', 'Tema.id_tema')
			//				  ->join('Examen')
			//				  ->on('Examen.id_examen', '=', 'BasadoEn.id_examen')
			//				  ->join('Evalua')
			//				  ->on('Evalua.id_examen', '=', 'Examen.id_examen')
			//				  ->where('Evalua.id_curso', $id_curso)
			//				  ->order_by('nombre_ex')
			//				  ->order_by('Tema.nombre');
			// });

			// $temas_arreglo_temas = [];
			// $temas_arreglo_examenes = [];
			// $temas_arreglo_errores = [];

			// $tema_actual = null;
			// $examenes_actuales = null;
			// $errores_actuales = 0;

			// $temas_arreglo_examenes_compuestos = [];
			// if(isset($temas)){
			// 	foreach ($temas as $tema) {
			// 		if(isset($tema_actual)){
			// 			if($tema_actual !== $tema->nombre){
			// 				// array_push($temas_arreglo_temas, $tema_actual);
			// 				// array_push($temas_arreglo_examenes_compuestos, $examenes_actuales);
			// 				$temas_arreglo_temas[$tema_actual] = $errores_actuales;
			// 				$temas_arreglo_examenes_compuestos[$tema_actual."+++***+++".$examenes_actuales] = $errores_actuales;
			// 				array_push($temas_arreglo_errores, $errores_actuales);
			// 				$tema_actual = $tema->nombre;
			// 				$examenes_actuales = $tema->nombre_ex;
			// 				$errores_actuales = 1;
			// 			}else{
			// 				if(strpos($examenes_actuales, $tema->nombre_ex) === False){
			// 					$examenes_actuales = $examenes_actuales.", ".$tema->nombre_ex;
			// 				}
			// 				$errores_actuales = $errores_actuales + 1;
			// 			}
			// 		}else{
			// 			$tema_actual = $tema->nombre;
			// 			$examenes_actuales = $tema->nombre_ex;
			// 			$errores_actuales = 1;
			// 		}
			// 	}
			// }
			// $temas_arreglo_temas[$tema_actual] = $errores_actuales;
			// $temas_arreglo_examenes_compuestos[$tema_actual."+++***+++".$examenes_actuales] = $errores_actuales;
			// array_push($temas_arreglo_errores, $errores_actuales);
			// asort($temas_arreglo_errores);
			// arsort($temas_arreglo_temas);
			// arsort($temas_arreglo_examenes_compuestos);
			// foreach ($temas_arreglo_examenes_compuestos as $nombre_compuesto => $valor) {
			// 	$nombre_combinado_examen = explode("+++***+++", $nombre_compuesto);
			// 	array_push($temas_arreglo_examenes, $nombre_combinado_examen[1]);
			// }
			$temasFallados = array('temas' => $temas_arreglo_temas, 'examenes' => $temas_arreglo_examenes, 'errores' => $temas_arreglo_errores );;

			$calificacionesAlumnos = [];
			$sql = "SELECT `Alumno`.`nombres`, `Alumno`.`apellidos`, `Examen`.`nombre`, `Presenta`.`calificacion`, `Presenta`.`terminado` FROM `Alumno` JOIN `Presenta` ON (`Presenta`.`n_cuenta` = `Alumno`.`n_cuenta`) JOIN `Examen` ON (`Presenta`.`id_examen` = `Examen`.`id_examen`) JOIN `Evalua` ON (`Evalua`.`id_examen` = `Examen`.`id_examen`) WHERE `Evalua`.`id_curso` = '".$id_curso."' UNION (SELECT `Alumno`.`nombres`, `Alumno`.`apellidos`, `Examen`.`nombre`, 0 as calificacion, NULL as terminado FROM `Alumno` JOIN `Cursa` ON `Alumno`.`n_cuenta` = `Cursa`.`n_cuenta`, `Examen` JOIN `Evalua` ON (`Evalua`.`id_examen` = `Examen`.`id_examen`) WHERE `Evalua`.`id_curso` = '".$id_curso."' AND `Cursa`.`id_curso` = '".$id_curso."' AND `Cursa`.`estado` = 'a' AND (`Alumno`.`n_cuenta`, `Examen`.`id_examen`) NOT IN (SELECT `n_cuenta`, `id_examen` FROM Presenta)) ORDER BY `apellidos`,`nombres`, `nombre`";
			$calificaciones = DB::query($sql)->execute();

			// $calificaciones = Model_Alumno::find(function ($query) use ($id_curso){
			//	 return $query->select('Alumno.nombres', 'Alumno.apellidos', 'Examen.nombre', 'Presenta.calificacion', 'Presenta.terminado')
			//				  ->join('Presenta')
			//				  ->on('Presenta.n_cuenta', '=', 'Alumno.n_cuenta')
			//				  ->join('Examen')
			//				  ->on('Presenta.id_examen', '=', 'Examen.id_examen')
			//				  ->join('Evalua')
			//				  ->on('Evalua.id_examen', '=', 'Examen.id_examen')
			//				  ->where('Evalua.id_curso', $id_curso)
			//				  ->order_by('Alumno.apellidos');
			// });
			// $calificaciones_complemento = Model_Alumno::find(function ($query) use ($id_curso){
			//	 return $query->select('Alumno.nombres', 'Alumno.apellidos', 'jajaja', '0', 'NUL')
			//	 			->union($calificaciones, False)
			//				  // ->join('Examen')
			//				  // ->on('Presenta.id_examen', '=', 'Examen.id_examen')
			//				  // ->join('Evalua')
			//				  // ->on('Evalua.id_examen', '=', 'Examen.id_examen')
			//				  // ->where('Evalua.id_curso', $id_curso)
			//				  ->order_by('Alumnos.apellidos');
			// });
			if(isset($calificaciones)){
				foreach ($calificaciones as $calificacion) {
					$calificacion_apellidos = $calificacion['apellidos'];
					$calificacion_nombres = $calificacion['nombres'];
					$calificacion_nombre = $calificacion['nombre'];
					$calificacion_terminado = $calificacion['terminado'];
					$calificacion_calificacion = $calificacion['calificacion'];
					if(isset($calificacionesAlumnos[$calificacion_apellidos.' '.$calificacion_nombres])){
						$arreglo_actual = $calificacionesAlumnos[$calificacion_apellidos.' '.$calificacion_nombres];
						array_push($arreglo_actual, array('examen' => $calificacion_nombre, 'calificacion' => $calificacion_calificacion, 'terminado' => $calificacion_terminado ));
						$calificacionesAlumnos[$calificacion_apellidos.' '.$calificacion_nombres] = $arreglo_actual;
					}else{
						$calificacionesAlumnos[$calificacion_apellidos.' '.$calificacion_nombres] = [array('examen' => $calificacion_nombre, 'calificacion' => $calificacion_calificacion, 'terminado' => $calificacion_terminado )];
					}
				}
			}

			$data = array('curso' => $curso, 'promedios' => $promedios, 'temasFallados' => $temasFallados, 'calificacionesAlumnos' => $calificacionesAlumnos);

			$this->template->content = View::forge('curso/estadisticas', $data);
		}else{
			Response::redirect('sesion/index');
		}
	}
	/**
	 * Controlador que muestra las estadisticas del alumno
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_alumnos()
	{	
		$id=SESSION::get('id_sesion');
		if(isset($id) && ($tipo_usuario = substr($id,0,1))=='p'){
			$id_curso = SESSION::get('id_curso');
			$curso = Model_Curso::find_one_by('id_curso',$id_curso);
			
			$alumnos = Model_Alumno::find(function ($query) use ($id_curso){
				return $query->join('Cursa')
							 ->on('Cursa.n_cuenta', '=', 'Alumno.n_cuenta')
							 ->where('Cursa.id_curso', $id_curso)
							 ->order_by('Cursa.estado')
							 ->order_by('Alumno.apellidos');
			});

			$data = array('curso' => $curso, 'alumnos' => $alumnos);
			
			$this->template->content = View::forge('curso/alumnos', $data);
		}else{
			Response::redirect('sesion/index');
		}
	}

	/**
	 * Controlador que muestra las estadisticas del alumno
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_cursos_preguntas_compartidas(){
		$id=SESSION::get('id_sesion');
		$id_curso = SESSION::get('id_curso');
		if(isset($id) && ($tipo_usuario = substr($id,0,1))=='p'){
			$data = null;
			$materia = SESSION::get('materia');
			if(isset($materia)){
				SESSION::delete('materia');
			}else{
				Response::redirect('curso/examenes');
				die();
			}
			//busqueda de todos los cursos, id_curso, nombre y nombre del profesor que lo imparte.
			$cursos = Model_Curso::find(function ($query) use ($id_curso){
				return $query->select('Curso.id_curso','Curso.nombre','Profesor.apellidos','Profesor.nombres')
							 ->join('Imparte')
							 ->on('Imparte.id_curso', '=', 'Curso.id_curso')
							 ->join('CursoTema')
							 ->on('CursoTema.id_curso', '=', 'Curso.id_curso')
							 ->join('Tema')
							 ->on('Tema.id_tema', '=', 'CursoTema.id_tema')
							 ->join('Genera')
							 ->on('Genera.id_tema', '=', 'Tema.id_tema')
							 ->join('Pregunta')
							 ->on('Pregunta.id_pregunta', '=', 'Genera.id_pregunta')
							 ->join('Profesor')
							 ->on('Profesor.n_trabajador', '=', 'Imparte.n_trabajador')
							 ->where('Pregunta.compartida', '=', '1')
							 ->where('Curso.id_curso', '<>', $id_curso)
							 ->group_by('Curso.id_curso','Curso.nombre','Profesor.apellidos','Profesor.nombres');
			});
			//Comparar los cursos con la palabra de $materia que más se acerquen
			//Seleccionar los que contengan la o las palabras en un %80 y guardarlos en un arreglo
			$cursos_similares = [];
			if(isset($cursos)){
				foreach ($cursos as $curso) {
					$menor_texto = strlen($materia) > strlen($curso->nombre) ? $curso->nombre : $materia;
					$mayor_texto = strlen($materia) <= strlen($curso->nombre) ? $curso->nombre : $materia;
					$letras_iguales = similar_text($menor_texto, $mayor_texto);
					$similitud = 100 * ($letras_iguales / strlen($menor_texto));
					if($similitud < 70){
						$letras_iguales = similar_text($mayor_texto, $menor_texto);
						$similitud = 100 * ($letras_iguales / strlen($menor_texto));
					}
					if($similitud >= 70){
						array_push($cursos_similares, $curso);
					}
				}
			}

			//De cada curso, obtener los temas e irlos guardando en un arreglo, con key = id_curso.
			$temas_cursos =[];
			if(isset($cursos)){
				foreach ($cursos as $curso) {
					$id_curso_actual = $curso->id_curso;
					$temas = Model_Tema::find(function ($query) use ($id_curso_actual){
						return $query->join('CursoTema')
									 ->on('CursoTema.id_tema', '=', 'Tema.id_tema')
									 ->where('CursoTema.id_curso', '=', $id_curso_actual);
					});
					if(isset($temas)){
						$temas_cursos[$id_curso_actual] = $temas;
					}
				}
			}

			$data = array('cursos' => $cursos_similares, 'temas_cursos' => $temas_cursos, 'materia' => $materia);
			
			$this->template->content = View::forge('curso/cursos_preguntas_compartidas', $data);
		}else{
			Response::redirect('sesion/index');
		}
	}

	/**
	 * Controlador que muestra las estadisticas del alumno
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_preguntas_compartidas(){
		$id_curso = SESSION::get('id_curso');
		$id=SESSION::get('id_sesion');
		if(isset($id) && ($tipo_usuario = substr($id,0,1))=='p'){
			$data = null;
			$materia = SESSION::get('materia');
			$id_curso_compartido = SESSION::get('id_curso_compartido');
			if(isset($materia) || isset($id_curso_compartido)){
				SESSION::delete('materia');
				SESSION::delete('id_curso_compartido');
			}else{
				Response::redirect('curso/examenes');
				die();
			}

			//busqueda de todos los cursos, id_curso, nombre y nombre del profesor que lo imparte.
			$preguntas = Model_Pregunta::find(function ($query) use ($id_curso_compartido){
				return $query->select('Tema.id_tema','Tema.nombre','Pregunta.dificultad','Pregunta.id_pregunta','Pregunta.texto')
							 ->join('Genera')
							 ->on('Genera.id_pregunta', '=', 'Pregunta.id_pregunta')
							 ->join('Tema')
							 ->on('Tema.id_tema', '=', 'Genera.id_tema')
							 ->join('CursoTema')
							 ->on('CursoTema.id_tema', '=', 'Tema.id_tema')
							 ->where('CursoTema.id_curso', '=', $id_curso_compartido)
							 ->where('Pregunta.compartida', '=', '1')
							 ->order_by('Tema.id_tema')
							 ->order_by('Tema.nombre')
							 ->order_by('Pregunta.dificultad')
							 ->order_by('Pregunta.id_pregunta')
							 ->order_by('Pregunta.texto');
			});
			$preguntas_compartidas_agregadas = [];
			if(isset($preguntas)){
				foreach ($preguntas as $pregunta) {
					$pregunta_compartida = Model_CursoPreguntasCompartidas::find(array('id_curso' => $id_curso, 'id_pregunta' => $pregunta->id_pregunta ));
					if(isset($pregunta_compartida)){
						array_push($preguntas_compartidas_agregadas, $pregunta_compartida->id_pregunta);
					}
				}
			}

			$data = array('preguntas' => $preguntas, 'preguntas_compartidas_agregadas' => $preguntas_compartidas_agregadas, 'materia' => $materia, 'id_curso_compartido' => $id_curso_compartido);
			$this->template->content = View::forge('curso/preguntas_compartidas', $data);
		}else{
			Response::redirect('sesion/index');
		}
	}
}