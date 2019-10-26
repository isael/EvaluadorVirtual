<?php

class Model_DeTipo extends \Orm\Model{
	protected static $_properties = array(
		'id_pregunta',
		'id_tipo',
	);
	
	protected static $_table_name = 'DeTipo';
	protected static $_primary_key = array('id_pregunta','id_tipo');

}

?>