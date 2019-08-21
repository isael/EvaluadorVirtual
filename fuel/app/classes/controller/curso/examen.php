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
		// $id_curso = SESSION::get('id_curso');
		// if (isset($id_curso)) {
		// 	$id_examen = trim(Input::get('id_examen'));
		// 	if (isset($id_examen) && $id_examen!="") {
		// 		$volver = "curso/examen/temas?id_examen=".$id_examen;
		// 		$curso = Model_Curso::find_one_by('id_curso',$id_curso);
		// 		$data = array('curso'=>$curso, 'volver'=>$volver);;
		// 		$this->template->content = View::forge('curso/temas/crear', $data);
		// 	}else{
		// 		Response::redirect('curso/index');
		// 	}
		// }else{
			Response::redirect('sesion/index');
		// }
		

	}

}