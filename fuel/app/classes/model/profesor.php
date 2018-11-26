<?php

class Model_Profesor extends \Model_Crud{
	protected static $_properties = array(
		'n_trabajador',
		'nombres',
		'apellidos',
		'correo',
		'contrasenia',
	);
	
	protected static $_table_name = 'Profesor';
	protected static $_primary_key = 'n_trabajador';

}

?>