<?php

class Model_Referencia extends \Model_Crud{
	protected static $_properties = array(
		'id_referencia',
		'capitulo',
		'pagina',
	);
	
	protected static $_table_name = 'Referencia';
	protected static $_primary_key = 'id_referencia';

}

?>