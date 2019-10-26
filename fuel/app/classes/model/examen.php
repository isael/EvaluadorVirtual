<?php

class Model_Examen extends \Model_Crud{
	protected static $_properties = array(
		'id_examen',
		'nombre',
		'fecha_inicio',
		'fecha_fin',
		'oportunidades',
		'vidas',
		'preguntas_por_mostrar',
		'preguntas_por_mezclar',

);

	protected static $_primary_key = 'id_examen';
	
	protected static $_table_name = 'Examen';

}

?>