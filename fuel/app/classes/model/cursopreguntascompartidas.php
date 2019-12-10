<?php

class Model_CursoPreguntasCompartidas extends \Orm\Model{
	protected static $_properties = array(
		'id_curso',
		'id_pregunta',
		'fecha_de_modificacion',
		'por_cambiar',
	);
	
	protected static $_table_name = 'CursoPreguntasCompartidas';
	protected static $_primary_key = array('id_curso','id_pregunta');

}

?>