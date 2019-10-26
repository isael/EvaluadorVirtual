<?php

class Model_Respuesta extends \Model_Crud{
	protected static $_properties = array(
		'id_respuesta',
		'contenido',
		'porcentaje',
	);
	
	protected static $_table_name = 'Respuesta';
	protected static $_primary_key = 'id_respuesta';

}

?>