<?php

class Model_Alumno extends \Model_Crud{
	protected static $_properties = array(
		'n_cuenta',
		'nombres',
		'apellidos',
		'correo',
		'contrasenia',
	);

	protected static $_primary_key = 'n_cuenta';
	
	protected static $_table_name = 'Alumno';

}

?>