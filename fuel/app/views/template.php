<?php 
header("Cache-Control: no-store, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Titulo</title>

    <!-- Bootstrap Core CSS -->
    <?php echo Asset::css('bootstrap.css'); ?>
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">

    <!-- Theme CSS -->
    <?php echo Asset::css('freelancer.css'); ?>

    <!-- Chart -->
    <?php echo Asset::js('Chart.js'); ?>
    <?php echo Asset::css('Chart.css'); ?>

    <!-- Extra-Styles -->
    <?php echo Asset::css('specialSelect.css'); ?>
    <?php echo Asset::css('offline-theme-default.css'); ?>
    <?php echo Asset::css('offline-language-spanish.css'); ?>

    <!-- Custom Fonts -->
    <?php echo Asset::css('font-awesome.min.css'); ?>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body id="page-top" class="index<?php 
        if(isset($color)){
            echo $color;
        }
    ?>">
    <noscript>
        <h1>Se detectó un problema con Javascript</h1>
        <div class="deshabilitado">
            Parece que Javascript no está habilitado.Para un correcto funcionamiento,
            <b><i>habilite javascript</i></b>.<br/>
            <br/>
            Accede en la siguiente liga y sigue las instrucciones para activarlo.<br/>
            <a href="http://www.enable-javascript.com/es/" 
            target="_blank">Instrucciones para habilitar javascript</a>.
        </div>
    </noscript>
<!-- Navigation -->
	<?php 
        if(isset($nav_bar)){
            echo $nav_bar;
        }
    ?>

<!-- Content -->
    <?php echo $content;?>

<!-- Scroll to Top Button (Only visible on small and extra-small screen sizes) -->
    <div class="scroll-top page-scroll hidden-sm hidden-xs hidden-lg hidden-md">
        <a class="btn btn-primary" href="#page-top">
            <i class="fa fa-chevron-up"></i>
        </a>
    </div><!-- Footer -->
	<?php 
        if(isset($footer)){
            echo $footer;
        }
    ?>
<!-- Portfolio Modals -->
	<?php //echo $portfolio_modals;?>

<!-- jQuery -->
    <?php echo Asset::js('jquery.min.js'); ?>

<!-- Bootstrap Core JavaScript -->
    <?php echo Asset::js('bootstrap.min.js'); ?>
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

<!-- Theme JavaScript -->
    <?php echo Asset::js('freelancer.js'); ?>

<!-- PrintThis -->
    <?php echo Asset::js('printThis.js'); ?>

<!-- Extra-functionality -->
    <?php echo Asset::js('validaciones.js'); ?>

<!-- Extra-functionality -->
    <?php echo Asset::js('specialSelect.js'); ?>

<!-- Connected -->
    <?php echo Asset::js('offline.min.js'); ?>
    <script type="text/javascript">
        Offline.options = {checks: {image: {url: 'https://media1.tenor.com/images/45e529c116a1758fd09bdb27e2172eca/tenor.gif?_='+(Math.random()*Date.now())}, active: 'image'}};
        let handleOn = () =>{
            console.log("prendido");
            Offline.options = {checks: {image: {url: 'https://media1.tenor.com/images/45e529c116a1758fd09bdb27e2172eca/tenor.gif?_='+(Math.random()*Date.now())}, active: 'image'}};
        }
        let handleOff = () =>{
            console.log("apagado");
        }
        Offline.off("up", handleOn);
        Offline.off("down", handleOff);
        Offline.on("up", handleOn);
        Offline.on("down", handleOff);
    </script>

</body>

</html>