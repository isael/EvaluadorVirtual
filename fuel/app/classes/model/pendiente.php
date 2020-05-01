<?php

class Model_Pendiente extends \Model_Crud{
	protected static $_properties = array(
		'clave',
		'tipo_usuario',
		'id',
	);	
	protected static $_table_name = 'Pendiente';

}

?>