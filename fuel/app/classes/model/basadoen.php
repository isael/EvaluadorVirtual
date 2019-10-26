<?php

class Model_BasadoEn extends \Orm\Model{
	protected static $_properties = array(
		'id_examen',
		'id_tema',
		'desde_dificultad',
		'hasta_dificultad',
	);
	
	protected static $_table_name = 'BasadoEn';
	protected static $_primary_key = array('id_examen','id_tema');

}

?>