<?php

class Model_CursoFuente extends \Orm\Model{
	protected static $_properties = array(
		'id_curso',
		'id_fuente',
	);
	
	protected static $_table_name = 'CursoFuente';
	protected static $_primary_key = array('id_curso','id_fuente');

}

?>