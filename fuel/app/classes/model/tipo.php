<?php

class Model_Tipo extends \Model_Crud{
	protected static $_properties = array(
		'id_tipo',
		'nombre',
		'tiene_subpreguntas',
		'min_respuestas',
		'max_respuestas',
	);
	
	protected static $_table_name = 'Tipo';
	protected static $_primary_key = 'id_tipo';

}

?>