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
class Controller_Sesion extends Controller_Template
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
			$tipo_usuario = substr($id,0,1);
			if($tipo_usuario == "p"){
				$sesion = "profesor";
			}else{
				$sesion = "alumno";
			}
			Response::redirect("sesion/".$sesion);
		}else{
			Response::redirect('sesion/inicio');	
		}
		
	}

	/**
	 * Controlador de la vista principal de la aplicacion
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_cerrar()
	{
		Response::redirect('principal/cerrar');
	}

	/**
	 * Controlador del inicio de sesion a la aplicacion
	 *
	 * @access  public
	 * @return  Response
	 */public function action_inicio()
	{
		$data = null;
		$correo=trim(Input::post('correo'));
		$contrasenia=trim(Input::post('pwd'));
		$this->template->nav_bar = View::forge('nav_bar');		
        $this->template->footer = View::forge('footer');
		$id=SESSION::get('id_sesion');
		if(isset($id)){
			Response::redirect('sesion/index');
			die();
		}
		if ($correo==null && $contrasenia==null){//Carga naturalmente
			$this->template->content = View::forge('sesion/inicio', $data);	
		}else{									//Ha recibido peticion por POST
			if($correo == null||$correo == ""){	//El correo es vacio
				$mensaje = "El correo no debe ser vacío";
				$data = array('mensaje' => $mensaje );	
				$this->template->content = View::forge('sesion/inicio', $data);	
			}elseif($contrasenia == null || $contrasenia == ""){//La contrasenia es vacio
				$mensaje = "La contraseña no debe ser vacía";
				$data = array('mensaje' => $mensaje );	
				$this->template->content = View::forge('sesion/inicio', $data);	
			}else{												//Ambos campos estan llenos
				$profesor= Model_Profesor::find_one_by('correo',$correo);
				$alumno= Model_Alumno::find_one_by('correo',$correo);
				if ($profesor==null){
					if($alumno==null){
						$mensaje = "El correo y/o la contraseña son incorrectos.";
						$data = array('mensaje' => $mensaje );			
						$this->template->content = View::forge('sesion/inicio', $data);
					}else{
						//Es alumno
						if($this->esta_pendiente($alumno->n_cuenta)){
							$mensaje = "Activa tu cuenta con el correo que se te ha enviado para poder iniciar sesión";
							$data = array('mensaje' => $mensaje );
							$this->template->content = View::forge('sesion/inicio', $data);
						}elseif($alumno->contrasenia==sha1($contrasenia)){
							$id = $alumno->n_cuenta;
							SESSION::set('id_sesion','a'.$id);
							SESSION::set('usuario',$alumno);
							Response::redirect("sesion/alumno");
							//$this->template->content = View::forge('sesion/sesion_alumno', $data);//cambiar***********
						}else{
							$mensaje = "El correo y/o la contraseña son incorrectos.";
							$data = array('mensaje' => $mensaje );
							$this->template->content = View::forge('sesion/inicio', $data);
						}
					}
				}else{
					//Es profesor. Si existiera una cuenta como profesor y otra como alumno para el mismo 
					//alumno, que en principio no debera pasar, seleccionaria por defecto la de profesor.
					if($this->esta_pendiente($profesor->n_trabajador)){
							$mensaje = "Activa tu cuenta con el correo que se te ha enviado para poder iniciar sesión";
							$data = array('mensaje' => $mensaje );
							$this->template->content = View::forge('sesion/inicio', $data);
					}elseif(($profesor->contrasenia)==sha1($contrasenia)){
						$id = $profesor->n_trabajador;
						SESSION::set('id_sesion','p'.$id);
						SESSION::set('usuario',$profesor);
						Response::redirect("sesion/profesor");
						//$this->template->content = View::forge('sesion/sesion_profesor', $data);//cambiar***********
					}else{
						$mensaje = "El correo y/o la contraseña son incorrectos.";
						$data = array('mensaje' => $mensaje );
						$this->template->content = View::forge('sesion/inicio', $data);
					}
				}


			}
		}

		
	}

	private function esta_pendiente($id){
		$respuesta = False;
		$pendiente = Model_Pendiente::find_one_by('id',$id);
		if(isset($pendiente)){
			$respuesta = True;
		}
		return $respuesta;
	}

	/**
	 * Controlador para activar las cuentas de usuarios
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_activar($clave = "")
	{
		$this->template->nav_bar = View::forge('nav_bar');
		$pendiente = Model_Pendiente::find_one_by('clave',$clave);
		if(isset($pendiente)){
			$pendiente->delete();
			$mensaje = "Cuenta activada con éxito. Ingresa tu correo y contraseña para acceder al sitio.";
			$data = array('mensaje' => $mensaje, 'className' => ' secondary' );
			$this->template->content = View::forge('sesion/inicio', $data);
		}else{
			$mensaje = "Hay un error en la liga a la que intentas acceder.";
			$data = array('mensaje' => $mensaje );
			$this->template->content = View::forge('sesion/inicio', $data);
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
		if(isset($id) && substr($id,0,1)=='a'){
			SESSION::delete('id_curso');
			$id = substr($id,1);
			// $cursos = Model_Curso::find(function ($query) use ($id){
			//     return $query->join('Cursa')
			//                  ->on('Cursa.id_curso', '=', 'Curso.id_curso')
			//                  ->where('Cursa.n_cuenta', $id)
			//                  ->order_by('Cursa.estado');
			// });
			$sql = "SELECT
					`Curso`.`id_curso` as curso_id,`Curso`.`clave`,`Curso`.`nombre`,`Curso`.`activo`,`Curso`.`fecha_inicio`,`Curso`.`fecha_fin`, `Cursa`.`estado`,  
					(SELECT COUNT(*) FROM `Curso` JOIN `Evalua` ON `Evalua`.`id_curso` = `Curso`.`id_curso` JOIN `Examen` ON `Examen`.`id_examen` = `Evalua`.`id_examen` JOIN `Presenta` ON `Presenta`.`id_examen` = `Examen`.`id_examen` WHERE `Presenta`.`terminado` = 1 AND `Examen`.`fecha_inicio` <= NOW() AND NOW() <= `Examen`.`fecha_fin` AND `Curso`.`id_curso` = curso_id AND `Presenta`.`n_cuenta` = ".$id.") as examenes_terminados,
					(SELECT COUNT(*) FROM `Examen` JOIN `Evalua` ON `Examen`.`id_examen` = `Evalua`.`id_examen` JOIN `Cursa` ON `Cursa`.`id_curso` = `Evalua`.`id_curso` WHERE `Cursa`.`id_curso` = curso_id AND `Cursa`.`n_cuenta` = ".$id." AND (`Examen`.`fecha_inicio` > NOW() OR NOW() > `Examen`.`fecha_fin`)) as examenes_pasados, 
					(SELECT COUNT(*) FROM `Examen` JOIN `Evalua` ON `Examen`.`id_examen` = `Evalua`.`id_examen` JOIN `Cursa` ON `Cursa`.`id_curso` = `Evalua`.`id_curso` WHERE `Cursa`.`id_curso` = curso_id AND `Cursa`.`n_cuenta` = ".$id.") as examenes_totales
					FROM `Cursa` JOIN `Curso` ON `Cursa`.`id_curso` = `Curso`.`id_curso`
					WHERE `Cursa`.`n_cuenta` = ".$id." GROUP BY curso_id, `Curso`.`clave`,`Curso`.`nombre`,`Curso`.`activo`,`Curso`.`fecha_inicio`,`Curso`.`fecha_fin`, `Cursa`.`estado`";
			$cursos = DB::query($sql)->execute();
			$data = array('cursos' => $cursos);
			$this->template->content = View::forge('sesion/sesion_alumno', $data);
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
			SESSION::delete('id_curso');
			$id = substr($id,1);
			//SELECT `Curso`.`id_curso`,`Curso`.`clave`,`Curso`.`nombre`,`Curso`.`activo`,`Curso`.`fecha_inicio`,`Curso`.`fecha_fin`, COUNT(IF(`Cursa`.`estado` = 'a', `Cursa`.`estado`,null)) AS aceptados, COUNT(IF(`Cursa`.`estado` = 'e', `Cursa`.`estado`,null)) AS esperando FROM `Curso` JOIN `Imparte` ON (`Imparte`.`id_curso` = `Curso`.`id_curso`) LEFT JOIN `Cursa` ON (`Cursa`.`id_curso` = `Curso`.`id_curso`) WHERE `Imparte`.`n_trabajador` = '1' GROUP BY `Curso`.`id_curso`,`Curso`.`clave`,`Curso`.`nombre`,`Curso`.`activo`,`Curso`.`fecha_inicio`,`Curso`.`fecha_fin`
			$sql = "SELECT `Curso`.`id_curso`,`Curso`.`clave`,`Curso`.`nombre`,`Curso`.`activo`,`Curso`.`fecha_inicio`,`Curso`.`fecha_fin`, COUNT(IF(`Cursa`.`estado` = 'a', `Cursa`.`estado`,null)) AS aceptados, COUNT(IF(`Cursa`.`estado` = 'e', `Cursa`.`estado`,null)) AS esperando FROM `Curso` JOIN `Imparte` ON (`Imparte`.`id_curso` = `Curso`.`id_curso`) LEFT JOIN `Cursa` ON (`Cursa`.`id_curso` = `Curso`.`id_curso`) WHERE `Imparte`.`n_trabajador` = ".$id." GROUP BY `Curso`.`id_curso`,`Curso`.`clave`,`Curso`.`nombre`,`Curso`.`activo`,`Curso`.`fecha_inicio`,`Curso`.`fecha_fin`";
			$cursos = DB::query($sql)->execute();
			$data = array('cursos' => $cursos);
			$this->template->content = View::forge('sesion/sesion_profesor', $data);
		}else{
			Response::redirect('sesion/index');
		}
	}

	/**
	 * Controlador que sirve para actualizar el correo del usuario
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_cambiar_correo()
	{
		$id=SESSION::get('id_sesion');
		if(isset($id)){
			$correo=Input::post('nuevo_correo');
			$password=Input::post('pass_nuevo_correo');
			$tipo_usuario = substr($id,0,1);
			$id = substr($id,1);
			$usuario=null;
			if($tipo_usuario == "p"){
				$usuario = Model_Profesor::find_one_by('n_trabajador',$id);
			}else{
				$usuario = Model_Alumno::find_one_by('n_cuenta',$id);
			}
			if($usuario!=null && $usuario->contrasenia == sha1($password) && $correo!=null && preg_match("/^[a-z0-9_\-.+]+@[a-z]+\.[a-z.]+$/i",$correo)){
				$usuario->correo = $correo;
				$usuario->save();
				$mensaje="Correo cambiado con éxito";
			}else{
				$mensaje="Hubo un error con los datos. Inténtalo de nuevo";
			}
			SESSION::set('usuario',$usuario);
			SESSION::set('mensaje',$mensaje);
		}
		Response::redirect("sesion/index");
	}

	/**
	 * Controlador que sirve para actualizar el correo del usuario
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_cambiar_contrasenia()
	{
		$id=SESSION::get('id_sesion');
		if(isset($id)){
			$pass=Input::post('nuevo_pass');
			$pass_rep=Input::post('nuevo_pass_rep');
			$password=Input::post('anterior_pass');
			$tipo_usuario = substr($id,0,1);
			$id = substr($id,1);
			$usuario=null;
			if($tipo_usuario == "p"){
				$usuario = Model_Profesor::find_one_by('n_trabajador',$id);
			}else{
				$usuario = Model_Alumno::find_one_by('n_cuenta',$id);
			}
			if($pass==$pass_rep){
				if($usuario!=null && $usuario->contrasenia == sha1($password) && $pass!=null){
					$usuario->contrasenia = sha1($pass);
					$usuario->save();
					$mensaje="Contraseña cambiada con éxito";
				}else{
					$mensaje="Hubo un error con los datos. Inténtalo de nuevo";
				}
			}else{
				$mensaje="Las nueva contraseña y su repetición son diferentes. Intentalo de nuevo.";
			}
			SESSION::set('usuario',$usuario);
			SESSION::set('mensaje',$mensaje);
		}
		Response::redirect("sesion/index");
	}

	/**
	 * Controlador que sirve para actualizar el correo del usuario
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_cambiar_nombre()
	{
		$id=SESSION::get('id_sesion');
		if(isset($id)){
			$nombres=Input::post('nuevo_nombres');
			$apellidos=Input::post('nuevo_apellidos');
			$password=Input::post('pass_nuevo_nombre');
			$tipo_usuario = substr($id,0,1);
			$id = substr($id,1);
			$usuario=null;
			if($tipo_usuario == "p"){
				$usuario = Model_Profesor::find_one_by('n_trabajador',$id);
			}else{
				$usuario = Model_Alumno::find_one_by('n_cuenta',$id);
			}
			if($usuario!=null && $usuario->contrasenia == sha1($password) && $nombres != null && $apellidos!=null){
				$usuario->nombres = $nombres;
				$usuario->apellidos = $apellidos;
				$usuario->save();
				$mensaje="Nombre cambiado con éxito";
			}else{
				$mensaje="Hubo un error con los datos. Inténtalo de nuevo";
			}
			SESSION::set('usuario',$usuario);
			SESSION::set('mensaje',$mensaje);
		}
		Response::redirect("sesion/index");
		
	}

	/**
	 * Controlador que sirve para actualizar el correo del usuario
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_cambiar_foto()
	{
		$archivo = (isset($_FILES['nueva_foto'])) ? $_FILES['nueva_foto'] : null;		
		$id=SESSION::get('id_sesion');
		if(isset($id)){
			$tipo_usuario = substr($id,0,1);
			$id = substr($id,1);
			if ($archivo!=null && $archivo['name']!=""){
				$ruta_destino_archivo = "assets/img/usuarios/{$tipo_usuario}/{$id}";
		  		$archivo_ok = move_uploaded_file($archivo['tmp_name'], $ruta_destino_archivo);			
				$mensaje="Foto actualizada con éxito.";
			}else{
				$mensaje="No hay archivo válido que guardar. Intenta de nuevo.";
			}
			SESSION::set('mensaje',$mensaje);
		}
		Response::redirect("sesion/index");
		
	}
	/**
	 * Controlador que sirve para crear en la base un nuevo curso
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_agregar_curso()
	{
		$nombre=trim(Input::post('nombre_curso'));
		$clave=trim(Input::post('clave_curso'));
		$id=SESSION::get('id_sesion');
		if(isset($id)){
			if($nombre == null||$nombre == "" || $clave == null||$clave == ""){	//El nombre es vacio
				$mensaje = "Ningún campo debe ser vacío";
			}else{
				$tipo_usuario = substr($id,0,1);
				$id = substr($id,1);
				if ($tipo_usuario=="p"){
					$curso = new Model_Curso();
					$curso->nombre = $nombre;
					$curso->clave = $clave;
					$exito = false;
					try{
						$curso->save();
						$exito = true;
					}catch(Database_Exception $e){
						$pos = strpos($e->getMessage(), "Duplicate entry");	//Es el error que marca cuando hay duplicados
						if ($pos !== false) {
							$mensaje="Ya existe un curso con esa clave '$clave'";
						} else {
							$mensaje="Hubo un error al crear el curso";
						}
					}

					if($exito){
						try{
							$imparte = new Model_Imparte();
							$imparte->n_trabajador = $id;
							$imparte->id_curso = $curso->id_curso;
							$imparte->save();

							$mensaje="Curso agregado con éxito.";

						}catch(Database_Exception $e){
							$mensaje="Hubo un error al crear el curso";
						}						
					}

				}else{
					$mensaje="Acción no permitida";
				}
			}
			SESSION::set('mensaje',$mensaje);
		}
		Response::redirect("sesion/index");
		
	}

	/**
	 * Controlador que sirve para crear en la base un nuevo curso
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_solicitar_curso()
	{
		$clave=trim(Input::post('clave_curso'));
		$id=SESSION::get('id_sesion');
		if(isset($id)){
			if($clave == null||$clave == ""){	//El nombre es vacio
				$mensaje = "El campo de curso no debe ser vacío.";
			}else{
				$tipo_usuario = substr($id,0,1);
				$id = substr($id,1);
				if ($tipo_usuario=="a"){
					try{
						$curso = Model_Curso::find_one_by('clave',$clave);
						if(!isset($curso) || !$curso->activo){
							throw new Database_Exception("Error al obtener el curso");
						}

						$cursa = new Model_Cursa();
						$cursa->n_cuenta = $id;
						$cursa->id_curso = $curso->id_curso;
						$cursa->estado = 'e'; //Esperando
						$cursa->save();
						$mensaje="Curso solicitado con éxito. Espera confirmación del profesor.";
					}catch(Database_Exception $e){
						$pos = strpos($e->getMessage(), "Duplicate entry");	//Es el error que marca cuando hay duplicados
						if ($pos !== false) {
							$mensaje="Ya existe una solicitud previa al curso '$clave'";
						} else if(!isset($curso)){
							$mensaje="No se encontró el curso '".$clave."'. Verifica la clave.";
						} else if(!$curso->activo){
							$mensaje="El curso que solicitaste no está disponible";
						} else {
							$mensaje="Hubo un error al solicitar el curso";
						}
					}
				}else{
					$mensaje="Acción no permitida";
				}
			}
			SESSION::set('mensaje',$mensaje);
		}
		Response::redirect("sesion/index");
		
	}
}