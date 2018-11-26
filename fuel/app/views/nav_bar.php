<!-- Navigation -->
    <nav id="mainNav" class="navbar navbar-default navbar-fixed-top navbar-custom">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->

            
            <div class="navbar-header page-scroll">
                <a class="navbar-brand" href="<?php echo Uri::base();?>"><?php echo Asset::img('logo/ev_app_brand.png', array('width'=>'50%'));?> </a>
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <i class="fa fa-bars"></i>   Navegación
                </button>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                    <li class="page-scroll">
                        <?php echo Html::anchor('principal/inicio','Iniciar Sesión') ;?>
                    </li>
                    <li class="page-scroll">
                        <?php echo Html::anchor('principal/registro','Registrarse') ;?>
                    </li>
                    <li class="page-scroll">
                        <?php echo Html::anchor('principal/acerca','Acerca de EV') ;?>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>