<?php

class Model_Pregunta extends \Model_Crud{
	protected static $_properties = array(
		'id_pregunta',
		'texto',
		'dificultad',
		'tiene_subpregunta',
		'justificacion',
	);
	
	protected static $_table_name = 'Pregunta';
	protected static $_primary_key = 'id_pregunta';

}

?>