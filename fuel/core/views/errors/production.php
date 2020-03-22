<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>FuelPHP Framework</title>
	<style type="text/css">
		* { margin: 0; padding: 0; }
		body { background-color: #EEE; font-family: sans-serif; font-size: 16px; line-height: 20px; margin: 40px; }
		#wrapper { padding: 30px; background: #fff; color: #333; margin: 0 auto; width: 800px; }
		h1 { color: #000; font-size: 55px; padding: 0 0 25px; line-height: 1em; }
		.intro { font-size: 22px; line-height: 30px; font-family: georgia, serif; color: #555; padding: 29px 0 20px; border-top: 1px solid #CCC; }
		p { margin: 0 0 15px; line-height: 22px;}
	</style>
</head>
<body>
	<div id="wrapper">
		<h1>Lo sentimos</h1>
		<p class="intro">Ocurrió un error inesperado. Por favor intenta más tarde.</p>
	</div>
</body>
</html>
<?php
SESSION::set('mensaje',"Ocurrió un error inesperado. Por favor intenta más tarde.");
$root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
header("Location: ".$root."EvaluadorVirtual/");
exit;
?>