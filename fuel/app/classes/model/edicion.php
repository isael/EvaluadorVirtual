<?php

class Model_Edicion extends \Orm\Model{
	protected static $_properties = array(
		'id_fuente',
		'numero',
		'anio',
		'liga',
);

	protected static $_primary_key = array('id_fuente','numero');
	
	protected static $_table_name = 'Edicion';

}

?>