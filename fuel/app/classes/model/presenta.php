<?php

class Model_Presenta extends \Orm\Model{
	protected static $_properties = array(
		'n_cuenta',
		'id_examen',
		'calificacion',
		'vidas',
		'oportunidades',
		'terminado',
	);
	
	protected static $_table_name = 'Presenta';
	protected static $_primary_key = array('n_cuenta','id_examen');

}

?>