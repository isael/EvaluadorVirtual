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
	 * Controlador que muestra la pantalla de creacion de temas para
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
			if($nombre==null||$nombre==""){
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
				$liga==="";
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

}