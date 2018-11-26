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

    <!-- Theme CSS -->
    <?php echo Asset::css('freelancer.css'); ?>

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
<!-- Navigation -->
	<?php echo $nav_bar;?>

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

<!-- Theme JavaScript -->
    <?php echo Asset::js('freelancer.js'); ?>

</body>

</html>