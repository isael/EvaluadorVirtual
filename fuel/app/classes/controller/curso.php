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
			SESSION::set('id_curso',$id_curso);
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
		if(isset($id) && ($tipo_usuario = substr($id,0,1))=='a'){
			$id_curso = SESSION::get('id_curso');
			$curso = Model_Curso::find_one_by('id_curso',$id_curso);
			
			/*$alumnos = Model_Alumno::find(function ($query) use ($id_curso){
			    return $query->join('Cursa')
			                 ->on('Cursa.n_cuenta', '=', 'Alumno.n_cuenta')
			                 ->where('Cursa.id_curso', $id_curso)
			                 ->order_by('Cursa.estado');
			});*/
			$alumnos=null;

			$data = array('curso' => $curso, 'alumnos' => $alumnos);
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
			$data = array('curso' => $curso, 'alumnos' => $alumnos);
			$this->template->content = View::forge('curso/profesor', $data);
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
			
			/*$alumnos = Model_Alumno::find(function ($query) use ($id_curso){
			    return $query->join('Cursa')
			                 ->on('Cursa.n_cuenta', '=', 'Alumno.n_cuenta')
			                 ->where('Cursa.id_curso', $id_curso)
			                 ->order_by('Cursa.estado');
			});*/
			$alumnos=null;

			$data = array('curso' => $curso, 'alumnos' => $alumnos);
			
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
	public function action_examenes()
	{	
		$id=SESSION::get('id_sesion');
		$id_curso = SESSION::get('id_curso');
		if(isset($id) && isset($id_curso) && ($tipo_usuario = substr($id,0,1))=='p'){
			$curso = Model_Curso::find_one_by('id_curso',$id_curso);
			
			$examenes = Model_Examen::find(function ($query) use ($id_curso){
			    return $query->join('Evalua')
			                 ->on('Evalua.id_examen', '=', 'Examen.id_examen')
			                 ->where('Evalua.id_curso', $id_curso)
			                 ->order_by('Evalua.id_examen');
			});
			// if(isset($examenes)){
			// 	$id_examenes = array();
			// 	foreach ($examenes as $examen) {
			// 		$id_examenes[] = $examen->id_examen;
			// 	}
			// 	$temas = Model_Tema::find(function ($query) use ($id_examenes){
			//     return $query->join('BasadoEn')
			//                  ->on('BasadoEn.id_tema', '=', 'Tema.id_tema')
			//                  ->where('BasadoEn.id_examen', 'IN', $id_examenes)
			//                  ->order_by('BasadoEn.id_examen');
			// 	});
			// }else{
			// 	$temas = null;
			// }

			$temas = Model_Tema::find(function ($query) use ($id_curso){
				return $query->join('CursoTema')
			                 ->on('CursoTema.id_tema', '=', 'Tema.id_tema')
			                 ->where('CursoTema.id_curso', '=', $id_curso);
			});

			$tipos = Model_Tipo::find_all();

			$preguntas = Model_Pregunta::find(function ($query) use ($id_curso){
			    return $query->join('Genera')
			                 ->on('Genera.id_pregunta', '=', 'Pregunta.id_pregunta')
			                 ->join('Tema')
			                 ->on('Tema.id_tema', '=', 'Genera.id_tema')
			                 ->join('CursoTema')
			                 ->on('CursoTema.id_tema', '=', 'Tema.id_tema')
			                 ->where('CursoTema.id_curso', '=', $id_curso)
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

			$data = array('curso' => $curso, 'temas' => $temas, 'examenes' => $examenes, 'bibliografias' => $bibliografias, 'preguntas' => $preguntas, 'tipos' => $tipos);
			
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
			
			/*$alumnos = Model_Alumno::find(function ($query) use ($id_curso){
			    return $query->join('Cursa')
			                 ->on('Cursa.n_cuenta', '=', 'Alumno.n_cuenta')
			                 ->where('Cursa.id_curso', $id_curso)
			                 ->order_by('Cursa.estado');
			});*/
			$alumnos=null;

			$data = array('curso' => $curso, 'alumnos' => $alumnos);
			
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

}