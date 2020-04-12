<?php

class Model_Curso extends \Model_Crud{
	protected static $_properties = array(
		'id_curso',
		'clave',
		'nombre',
		'activo',
		'fecha_inicio',
		'fecha_fin',
	);
	
	protected static $_table_name = 'Curso';
	protected static $_primary_key = 'id_curso';

}

?>