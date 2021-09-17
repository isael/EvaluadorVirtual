<!-- Header -->
    <header class="container">
        <section>
            <div class="row padding">
                <div class="col-xs-12 col-md-6">
                    <div class="row">
                        <div class="col-xs-12">
                            <span class="skills"><?php echo Asset::img('logo/ev_app_logo_cuadro.png',array('class'=>'responsive', 'width'=>'80%', 'style'=>'margin-bottom: -15px;'));?></span>
                        </div>
                    
                        <div class="col-xs-6">
                            <?php echo Html::anchor('principal/inicio','Inicia Sesión',array('class'=>'btn btn-outline btn-block')) ;?>
                        </div>  
                        <div class="col-xs-6">
                            <?php echo Html::anchor('principal/registro','Registrate',array('class'=>'btn btn-outline btn-block')) ;?>
                        </div> 
                    </div>
                     
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="embed-container">
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/uZ-3Dw6w5pk" frameborder="0" allowfullscreen></iframe>
                    </div>  
                </div>
            </div>
        </section>
    </header>
    <!-- Mensaje -->
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
              <?php
                  if(!isset($mensaje)){
                    $mensaje = SESSION::get('mensaje');
                    SESSION::delete('mensaje');
                  }
                  if(isset($mensaje)){
                      echo "<div class='alert alert-success alert-dismissible fade in' style='z-index: 100;'>";
                      echo $mensaje;
                      echo "</div>";
                  }
              ?> 
            </div>
        </div>
    </div>
    <!-- /Mensaje -->