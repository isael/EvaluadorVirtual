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
class Controller_Principal extends Controller_Template
{

	public $template = 'template';
	public function before()
    {
        parent::before(); 
        $this->template->nav_bar = View::forge('nav_bar');
        //$this->template->portfolio_modals = View::forge('portfolio_modals');
        $this->template->footer = View::forge('footer');
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
		$data = null;
		$this->template->color = " azul";
		$this->template->content = View::forge('principal/index', $data);
	}

	/**
	 * Controlador del inicio de sesion a la aplicacion
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_inicio()
	{
		Response::redirect('sesion/inicio');	
	}

	/**
	 * Controlador del registro a la aplicacion
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_cerrar()
	{
		$id=SESSION::get('id_sesion');
   		if(isset($id)){
			SESSION::delete('id_sesion');
			$mensaje = "Tu sesión ha sido cerrada. ¡Vuelve Pronto!";
			$data = array('mensaje' => $mensaje );
			$this->template->color = " azul";
			$this->template->content = View::forge('principal/index', $data);
		}else{
			Response::redirect('/');
		}
	}

	/**
	 * Controlador del registro a la aplicacion
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_registro()
	{
		$data = null;
		$this->template->content = View::forge('principal/registro', $data);
	}

	/**
	 * Controlador de la pagina de informacion de la aplicacion
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_acerca()
	{
		$data = null;
		$this->template->content = View::forge('principal/acerca', $data);
	}

	/**
	 * Controlador del registro de alumnos
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_registro_alumno()
	{
		$data = null;
		$ncuenta = trim(Input::post('ncuenta'));
		$nombres=trim(Input::post('nombres'));
		$apellidos=trim(Input::post('apellidos'));
		$correo=trim(Input::post('correo'));
		$contrasenia=trim(Input::post('pwd1'));
		$contrasenia2=trim(Input::post('pwd2'));


		if ($ncuenta==null)
			$this->template->content = View::forge('principal/registro_alumno', $data);
		else{
			$mensaje="";
			$error = False;

			$alumno1 = Model_Alumno::find_by('n_cuenta', $ncuenta);
			$alumno2 = Model_Alumno::find_by('correo', $correo);
			$profesor = Model_Profesor::find_by('correo',$correo);
			if ($alumno1==null && $alumno2==null && $profesor==null){
				
				if($nombres==null||$nombres==""){
					$error=True;
					$mensaje=$mensaje."El campo de Nombres está vacío.<br>";
				}
					
				if($apellidos==null||$apellidos===""){
					$error=True;
					$mensaje=$mensaje."El campo de Apellidos está vacío.<br>";
				}
				if($correo==null||$correo===""){
					$error=True;
					$mensaje=$mensaje."El campo de Correo está vacío.<br>";
				}else if(!preg_match("/^[a-z0-9_\-.+]+@[a-z]+\.[a-z.]+$/i",$correo)){
					$error=True;
					$mensaje=$mensaje."El campo de Correo no contiene el formato de un correo válido (i.e. correo@servido.com).<br>";
				}

				if($ncuenta==null||$ncuenta===""){
					$error=True;
					$mensaje=$mensaje."El campo de Número de cuenta está vacío.<br>";
				}elseif(!preg_match("/^[0-9]+$/",$ncuenta)){
					$error=True;
					$mensaje=$mensaje."El campo de Número de cuenta contiene más que números.<br>";
				}
				if($contrasenia==null||$contrasenia===""){
					$error=True;
					$mensaje=$mensaje."El campo de Contraseña está vacío.<br>";
				}
				if($contrasenia2==null||$contrasenia2===""){
					$error=True;
					$mensaje=$mensaje."El campo de Repetir Contraseña está vacío.<br>";
				}
				if($contrasenia2!=$contrasenia){
					$error=True;
					$mensaje=$mensaje."Las contraseñas son diferentes.<br>";
				}
				if(!$error){
					$alumno = new Model_Alumno();
					$alumno->nombres = $nombres;
					$alumno->apellidos = $apellidos;
					$alumno->correo = $correo;
					$alumno->contrasenia = sha1($contrasenia);
					$alumno->n_cuenta = (int)$ncuenta;
					$alumno->save();
					$mensaje = "El alumno ".$alumno->nombres." ha sido registrado con éxito.";
				}
				
				
			}
			else{
				if($alumno1!=null)
					$mensaje = "Ya existe un alumno con este número de trabajador.";
				else if($alumno2!=null)
					$mensaje = "Ya existe un alumno con este correo electrónico.";
				else
					$mensaje = "Ya existe un profesor con este correo electrónico. Si se requiere cuenta de alumno necesita registrar su cuenta con otro correo electrónico.";
				$error = True;
			}
			
			if($error){
				$data = array('mensaje' => $mensaje, 'nombres'=> $nombres, 'apellidos' => $apellidos, 'correo' => $correo, 'ncuenta' => $ncuenta);
				$this->template->content = View::forge('principal/registro_alumno', $data);
			}else{
				$data = array('mensaje' => $mensaje);
				$this->template->content = View::forge('principal/mensaje', $data);
			}
		}
	}

	/**
	 * Controlador del registro de profesores
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_registro_profesor()
	{
		$data = null;
		$ntrabajador = trim(Input::post('ntrabajador'));
		$nombres=trim(Input::post('nombres'));
		$apellidos=trim(Input::post('apellidos'));
		$correo=trim(Input::post('correo'));
		$contrasenia=trim(Input::post('pwd1'));
		$contrasenia2=trim(Input::post('pwd2'));


		if ($ntrabajador==null)
			$this->template->content = View::forge('principal/registro_profesor', $data);
		else{
			$mensaje="";
			$error = False;

			$profesor1 = Model_Profesor::find_by('n_trabajador', $ntrabajador);
			$profesor2 = Model_Profesor::find_by('correo', $correo);
			$alumno = Model_Alumno::find_by('correo',$correo);
			if ($profesor1==null && $profesor2==null && $alumno==null){
				
				if($nombres==null||$nombres==""){
					$error=True;
					$mensaje=$mensaje."El campo de Nombres está vacío.<br>";
				}
					
				if($apellidos==null||$apellidos==""){
					$error=True;
					$mensaje=$mensaje."El campo de Apellidos está vacío.<br>";
				}
				if($correo==null||$correo==""){
					$error=True;
					$mensaje=$mensaje."El campo de Correo está vacío.<br>";
				}elseif(!preg_match("/^[a-z0-9_\-.+]+@[a-z]+\.[a-z.]+$/i",$correo)){
					$error=True;
					$mensaje=$mensaje."El campo de Correo no contiene el formato de un correo válido (i.e. correo@servido.com).<br>";
				}

				if($ntrabajador==null||$ntrabajador==""){
					$error=True;
					$mensaje=$mensaje."El campo de Número de trabajador está vacío.<br>";
				}elseif(!preg_match("/^[0-9]+$/",$ntrabajador)){
					$error=True;
					$mensaje=$mensaje."El campo de Número de trabajador contiene más que números.<br>";
				}
				if($contrasenia==null||$contrasenia==""){
					$error=True;
					$mensaje=$mensaje."El campo de Contraseña está vacío.<br>";
				}
				if($contrasenia2==null||$contrasenia2==""){
					$error=True;
					$mensaje=$mensaje."El campo de Repetir Contraseña está vacío.<br>";
				}
				if($contrasenia2!=$contrasenia){
					$error=True;
					$mensaje=$mensaje."Las contraseñas son diferentes.<br>";
				}
				if(!$error){
					$profesor = new Model_Profesor();
					$profesor->nombres = $nombres;
					$profesor->apellidos = $apellidos;
					$profesor->correo = $correo;
					$profesor->contrasenia = sha1($contrasenia);
					$profesor->n_trabajador = (int)$ntrabajador;
					$profesor->save();
					$mensaje = "El profesor ".$profesor->nombres." ha sido registrado con éxito.";
				}
				
				
			}
			else{
				if($profesor1!=null)
					$mensaje = "Ya existe un profesor con este número de trabajador.";
				elseif($profesor2!=null)
					$mensaje = "Ya existe un profesor con este correo electrónico.";
				else
					$mensaje = "Ya existe un alumno con este correo electrónico. Si se requiere cuenta de profesor necesita registrar su cuenta con otro correo electrónico.";
				$error = True;
			}
			
			if($error){
				$data = array('mensaje' => $mensaje, 'nombres'=> $nombres, 'apellidos' => $apellidos, 'correo' => $correo, 'ntrabajador' => $ntrabajador);
				$this->template->content = View::forge('principal/registro_profesor', $data);
			}else{
				$data = array('mensaje' => $mensaje);
				$this->template->content = View::forge('principal/mensaje', $data);
			}
		}
		
	}

	/**
	 * A typical "Hello, Bob!" type example.  This uses a Presenter to
	 * show how to use them.
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_hello()
	{
		return Response::forge(Presenter::forge('principal/hello'));
	}

	/**
	 * The 404 action for the application.
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_404()
	{
		return Response::forge(Presenter::forge('principal/404'), 404);
	}
}
