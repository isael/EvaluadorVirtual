<?php

class Model_Evalua extends \Model_Crud{
	protected static $_properties = array(
		'id_examen',
		'id_curso',
	);

	protected static $_primary_key = 'id_examen';
	
	protected static $_table_name = 'Evalua';

}

?>