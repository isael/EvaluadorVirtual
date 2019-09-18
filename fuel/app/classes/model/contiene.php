<?php

class Model_Contiene extends \Orm\Model{
	protected static $_properties = array(
		'id_pregunta',
		'id_respuesta',
	);
	
	protected static $_table_name = 'Contiene';
	protected static $_primary_key = array('id_pregunta','id_respuesta');

}

?>