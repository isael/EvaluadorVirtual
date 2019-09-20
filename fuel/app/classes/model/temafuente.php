<?php

class Model_TemaFuente extends \Orm\Model{
	protected static $_properties = array(
		'id_tema',
		'id_fuente',
		'cantidad_preguntas',
	);
	
	protected static $_table_name = 'TemaFuente';
	protected static $_primary_key = array('id_tema','id_fuente');

}

?>