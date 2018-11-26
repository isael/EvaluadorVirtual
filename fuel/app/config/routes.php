<?php
return array(
	'_root_'  => 'principal/index',  // The default route
	'_404_'   => 'principal/404',    // The main 404 route
	
	'hello(/:name)?' => array('principal/hello', 'name' => 'hello'),
);
