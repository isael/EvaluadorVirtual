<?php

class Model_Genera extends \Orm\Model{
	protected static $_properties = array(
		'id_pregunta',
		'id_tema',
	);
	
	protected static $_table_name = 'Genera';
	protected static $_primary_key = array('id_pregunta','id_tema');

}

?>