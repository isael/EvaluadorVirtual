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
			$alumno = null;
			if ($alumno1==null && $alumno2==null && $profesor==null){
				
				if($nombres==null||$nombres==""){
					$error=True;
					$mensaje=$mensaje."El campo de Nombres está vacío.|";
				}
					
				if($apellidos==null||$apellidos===""){
					$error=True;
					$mensaje=$mensaje."El campo de Apellidos está vacío.|";
				}
				if($correo==null||$correo===""){
					$error=True;
					$mensaje=$mensaje."El campo de Correo está vacío.|";
				}else if(!preg_match("/^[a-z0-9_\-.+]+@[a-z]+\.[a-z.]+$/i",$correo)){
					$error=True;
					$mensaje=$mensaje."El campo de Correo no contiene el formato de un correo válido (i.e. correo@servido.com).|";
				}

				if($ncuenta==null||$ncuenta===""){
					$error=True;
					$mensaje=$mensaje."El campo de Número de cuenta está vacío.|";
				}elseif(!preg_match("/^[0-9]+$/",$ncuenta)){
					$error=True;
					$mensaje=$mensaje."El campo de Número de cuenta contiene más que números.|";
				}
				if($contrasenia==null||$contrasenia===""){
					$error=True;
					$mensaje=$mensaje."El campo de Contraseña está vacío.|";
				}
				if($contrasenia2==null||$contrasenia2===""){
					$error=True;
					$mensaje=$mensaje."El campo de Repetir Contraseña está vacío.|";
				}
				if($contrasenia2!=$contrasenia){
					$error=True;
					$mensaje=$mensaje."Las contraseñas son diferentes.|";
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
					$mensaje = "Ya existe un alumno con este número de cuenta.";
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
				$this->enviar_correo($correo,'a',$alumno->n_cuenta);
				$data = array('mensaje' => $mensaje);
				$this->template->content = View::forge('sesion/inicio', $data);
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


		if ($ntrabajador==null){
			$this->template->content = View::forge('principal/registro_profesor', $data);
		}else{
			$mensaje="";
			$error = False;

			$profesor1 = Model_Profesor::find_by('n_trabajador', $ntrabajador);
			$profesor2 = Model_Profesor::find_by('correo', $correo);
			$alumno = Model_Alumno::find_by('correo',$correo);
			$profesor=null;
			if ($profesor1==null && $profesor2==null && $alumno==null){
				
				if($nombres==null||$nombres==""){
					$error=True;
					$mensaje=$mensaje."El campo de Nombres está vacío.|";
				}
					
				if($apellidos==null||$apellidos==""){
					$error=True;
					$mensaje=$mensaje."El campo de Apellidos está vacío.|";
				}
				if($correo==null||$correo==""){
					$error=True;
					$mensaje=$mensaje."El campo de Correo está vacío.|";
				}elseif(!preg_match("/^[a-z0-9_\-.+]+@[a-z]+\.[a-z.]+$/i",$correo)){
					$error=True;
					$mensaje=$mensaje."El campo de Correo no contiene el formato de un correo válido (i.e. correo@servido.com).|";
				}

				if($ntrabajador==null||$ntrabajador==""){
					$error=True;
					$mensaje=$mensaje."El campo de Número de trabajador está vacío.|";
				}elseif(!preg_match("/^[0-9]+$/",$ntrabajador)){
					$error=True;
					$mensaje=$mensaje."El campo de Número de trabajador contiene más que números.|";
				}
				if($contrasenia==null||$contrasenia==""){
					$error=True;
					$mensaje=$mensaje."El campo de Contraseña está vacío.|";
				}
				if($contrasenia2==null||$contrasenia2==""){
					$error=True;
					$mensaje=$mensaje."El campo de Repetir Contraseña está vacío.|";
				}
				if($contrasenia2!=$contrasenia){
					$error=True;
					$mensaje=$mensaje."Las contraseñas son diferentes.|";
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
				$this->enviar_correo($correo,'p',$profesor->n_trabajador);
				$data = array('mensaje' => $mensaje);
				$this->template->content = View::forge('sesion/inicio', $data);
			}
		}
		
	}

	private function enviar_correo($correo,$tipo_usuario,$id){
		$str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
		$longitud_str = strlen($str);
		$longitud_clave = 150;
		$clave = "";
		$existe = True;
		//Reconstruimos la contraseña segun la longitud que se quiera
		do{
			for($i=0;$i<$longitud_clave;$i++) {
				//obtenemos un caracter aleatorio escogido de la cadena de caracteres
				$clave .= substr($str,rand(0,$longitud_str-1),1);
			}
			$pendiente = Model_Pendiente::find_by('clave',$clave);
			if(isset($pendiente)){
				$existe = True;
			}else{
				$existe = False;
			}

		}while($existe);
		//Mostramos la contraseña generada
		$pendiente = new Model_Pendiente();
		$pendiente->clave = $clave;
		$pendiente->tipo_usuario = $tipo_usuario;
		$pendiente->id = $id;
		$pendiente->save();
		//Pendiente de probar en servidor
		$from = "noreply@evaluadorvirtual.com.mx";
		$to = $correo;
		$subject = "Registro Exitoso en Evaluador Virtual";
		$headers = "From:" . $from . "\r\n";
		$headers .= "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		 
		$message = "
		<html>
		<head>
		<title>HTML</title>
		</head>
		<body>
		<h1>¡Bienvenid@!</h1>
		<h2>Te registraste con éxito</h2>
		<p>Ahora podrás ingresar a la aplicación con esta cuenta de correo y la contraseña que guardaste.</p>
		<p>Solo pulsa el siguiente enlace que te activará tu usuario.</p>
		<br>".
		Html::anchor('sesion/activar/'.$clave,'Da click en este enlace').
		"</body>
		</html>";
		 
		mail($to, $subject, $message, $headers);
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
		// return Response::forge(Presenter::forge('principal/404'), 404);
		$mensaje = "La página o recurso que buscas no existe. Verifica bien la dirección.";
		$error = "404 página no encontrada";
		$data = array('mensaje' => $mensaje,'error' => $error);
		$this->template->content = View::forge('principal/mensaje', $data);
	}
}
