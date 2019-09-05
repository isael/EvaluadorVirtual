<?php

class Model_ReferenciaFuente extends \Orm\Model{
	protected static $_properties = array(
		'id_referencia',
		'id_fuente',
	);
	
	protected static $_table_name = 'ReferenciaFuente';
	protected static $_primary_key = array('id_referencia','id_fuente');

}

?>