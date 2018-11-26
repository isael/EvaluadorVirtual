<?php

class Model_Examen extends \Model_Crud{
	protected static $_properties = array(
		'id_examen',
		'nombre',
		'fecha_inicio',
		'fecha_fin',
		'tiempo',
		'oportunidades',
		'vidas'

);

	protected static $_primary_key = 'id_examen';
	
	protected static $_table_name = 'Examen';

}

?>