<?php

class Model_CometeErroresEn extends \Orm\Model{
	protected static $_properties = array(
		'id_respuesta',
		'n_cuenta',
		'id_pregunta',
		'id_tema',
		'id_examen',
	);
	
	protected static $_table_name = 'CometeErroresEn';
	protected static $_primary_key = array('id_respuesta','n_cuenta');

}

?>