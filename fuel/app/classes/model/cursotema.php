<?php

class Model_CursoTema extends \Orm\Model{
	protected static $_properties = array(
		'id_curso',
		'id_tema',
		'cantidad_preguntas',
	);
	
	protected static $_table_name = 'CursoTema';
	protected static $_primary_key = array('id_curso','id_tema');

}

?>