<?php

class Model_Fuente extends \Model_Crud{
	protected static $_properties = array(
		'id_fuente',
		'nombre',
		'autores',
);

	protected static $_primary_key = 'id_fuente';
	
	protected static $_table_name = 'Fuente';

}

?>