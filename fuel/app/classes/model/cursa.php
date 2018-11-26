<?php

class Model_Cursa extends \Orm\Model{
	protected static $_properties = array(
		'n_cuenta',
		'id_curso',
		'estado',
	);
	
	protected static $_table_name = 'Cursa';
	protected static $_primary_key = array('n_cuenta','id_curso');

}

?>