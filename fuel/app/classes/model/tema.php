<?php

class Model_Tema extends \Model_Crud{
	protected static $_properties = array(
		'id_tema',
		'nombre',
);

	protected static $_primary_key = 'id_tema';
	
	protected static $_table_name = 'Tema';

}

?>