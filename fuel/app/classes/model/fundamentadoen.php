<?php

class Model_FundamentadoEn extends \Orm\Model{
	protected static $_properties = array(
		'id_pregunta',
		'id_referencia',
	);
	
	protected static $_table_name = 'FundamentadoEn';
	protected static $_primary_key = array('id_pregunta','id_referencia');

}

?>