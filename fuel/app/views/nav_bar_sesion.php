<?php 
    $usuario = SESSION::get('usuario');
    $id = SESSION::get('id_sesion');
    $foto = Uri::base(false)."assets/img/usuarios/".substr($id,0,1)."/".substr($id,1);
    $existe = File::exists(DOCROOT."assets/img/usuarios/".substr($id,0,1)."/".substr($id,1));
    //echo DOCROOT."assets/img/usuarios/".substr($id,0,1)."/".substr($id,1);
    //die();
    if (!$existe) {
        $foto = Uri::base(false)."assets/img/usuarios/default.png";
    }
    $foto = $foto."?t".time();
?>
<!-- Navigation -->
    <nav id="mainNav" class="navbar navbar-default navbar-fixed-top navbar-custom">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->

            
            <div class="navbar-header page-scroll">
                <a class="navbar-brand" href="<?php echo Uri::base()."sesion/index";?>"><?php echo Asset::img('logo/ev_app_brand.png', array('width'=>'50%'));?> </a>

                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menu_ajustes"> <i class="fa fa-bars"></i> &nbsp; Perfil
                </button>
                <button type="button" class="navbar-avatar usuario" style="background-image: url(<?php echo $foto;?>)" data-toggle="modal" data-target="#modalInfo">
                </button>              
                
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="menu_ajustes">
                <ul class="nav navbar-nav navbar-right">
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                    <li class="page-scroll" data-toggle="modal" data-target="#modalFoto">
                        <?php echo Html::anchor('sesion/#','Cambiar Foto') ;?>
                    </li>
                    <li class="page-scroll" data-toggle="modal" data-target="#modalNombre">
                        <?php echo Html::anchor('sesion/#','Cambiar Nombre') ;?>
                    </li>
                    <li class="page-scroll" data-toggle="modal" data-target="#modalContrasenia">
                        <?php echo Html::anchor('sesion/#','Cambiar Contraseña') ;?>
                    </li>
                    <li class="page-scroll" data-toggle="modal" data-target="#modalCorreo">
                        <?php echo Html::anchor('sesion/#','Cambiar Correo') ;?>
                    </li>
                    <li class="page-scroll" data-toggle="modal" data-target="#modalCerrar">
                        <?php echo Html::anchor('sesion/#','Cerrar Sesión') ;?>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">

                <!-- Modales -->

                <!-- Edicion de foto -->
                <div class="modal fade" id="modalFoto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">Cambiar Foto</h4>
                      </div>

                      <?php echo Form::open(array('action' => 'sesion/cambiar_foto', 'method' => 'post','enctype'=>'multipart/form-data'));?>
                      <div class="form-group">
                        <div class="modal-body">
                          <label>Foto actual</label>
                          <div class="foto" style="background-image: url(<?php echo $foto;?>)"></div>
                          <label for="nueva_foto">Nueva foto</label>
                          <div class="input-group">
                              <label class="input-group-btn">
                                  <span class="btn btn-primary">
                                      Selecciona Imagen <input id="nueva_foto" name="nueva_foto" type="file" style="display: none;" accept="image/*">
                                  </span>
                              </label>
                              <input id="texto_nueva_foto" type="text" class="form-control" readonly="" value="" style="height: 42px;">
                          </div>
                        </div>
                        <div class="modal-footer">
                            <div class="row text-center">
                              <div class="col-xs-6">
                                  <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Cancelar</button>
                              </div>
                              <div class="col-xs-6">
                                <input type="submit" class="btn btn-primary btn-block" value="Guardar Cambios">
                              </div>
                            </div>
                        </div>
                      </div>
                      <?php echo Form::close();?>
                    </div>
                  </div>
                </div>

                <!-- Edicion de nombre -->
                <div class="modal fade" id="modalNombre" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">Cambiar Nombre</h4>
                      </div>
                      <?php echo Form::open(array('action' => 'sesion/cambiar_nombre', 'accept-charset' => 'utf-8', 'method' => 'post', 'onsubmit' => 'javascript:{return es_valido_formulario_cambiar_nombre()}'));?>
                      <div class="form-group">
                        <div class="modal-body">
                          <label>Antiguo nombre</label>
                          <p><?php echo ($usuario->nombres)." ".($usuario->apellidos);?></p>
                          <div>
                            <label for="nuevo_nombres">Nuevo(s) nombre(s)</label>
                            <input type="text" class="form-control" id="nuevo_nombres" name="nuevo_nombres" placeholder="Introduce tu(s) nombre(s)">
                          </div>
                          <div>
                            <label for="nuevo_apellidos">Nuevo(s) apellido(s)</label>
                            <input type="text" class="form-control" id="nuevo_apellidos" name="nuevo_apellidos" placeholder="Introduce tu(s) apellido(s)">
                          </div>
                          <div>
                            <label for="pass_nuevo_nombre">Contraseña de confirmación</label>
                            <input type="password" class="form-control" id="pass_nuevo_nombre" name="pass_nuevo_nombre" placeholder="Introduce tu contraseña">
                          </div>
                        </div>
                        <div class="modal-footer">
                            <div class="row text-center">
                              <div class="col-xs-6">
                                  <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Cancelar</button>
                              </div>
                              <div class="col-xs-6">
                                <input type="submit" class="btn btn-primary btn-block" value="Guardar Cambios">
                              </div>
                            </div>
                        </div>
                      </div>
                      <?php echo Form::close();?>
                    </div>
                  </div>
                </div>
                <!-- Edicion de contrasenia -->
                <div class="modal fade" id="modalContrasenia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">Cambiar Contraseña</h4>
                      </div>
                      <?php echo Form::open(array('action' => 'sesion/cambiar_contrasenia', 'accept-charset' => 'utf-8', 'method' => 'post', 'onsubmit' => 'javascript:{return es_valido_formulario_cambiar_password()}'));?>
                      <div class="form-group">
                        <div class="modal-body">
                          <div>
                            <label for="anterior_pass">Escribe la contraseña actual</label>
                            <input type="password" class="form-control" id="anterior_pass" name="anterior_pass" placeholder="Introduce tu contraseña">
                          </div>
                          <div>
                            <label for="nuevo_pass">Escribe la nueva contraseña</label>
                            <input type="password" class="form-control" id="nuevo_pass" name="nuevo_pass" placeholder="Introduce contraseña">
                          </div>
                          <div>
                            <label for="nuevo_pass_rep">Repetir nueva contraseña</label>
                            <input type="password" class="form-control" id="nuevo_pass_rep" name="nuevo_pass_rep" placeholder="Repite contraseña">
                          </div>
                        </div>
                        <div class="modal-footer">
                            <div class="row text-center">
                              <div class="col-xs-6">
                                  <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Cancelar</button>
                              </div>
                              <div class="col-xs-6">
                                <input type="submit" class="btn btn-primary btn-block" value="Guardar Cambios">
                              </div>
                            </div>
                        </div>
                      </div>
                      <?php echo Form::close();?>
                    </div>
                  </div>
                </div>
                <!-- Edicion de correo -->
                <div class="modal fade" id="modalCorreo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">Cambiar Correo</h4>
                      </div>
                      <?php echo Form::open(array('action' => 'sesion/cambiar_correo', 'accept-charset' => 'utf-8', 'method' => 'post', 'onsubmit' => 'javascript:{return es_valido_formulario_cambiar_correo()}'));?>
                      <div class="form-group">
                        <div class="modal-body">
                          <div>
                            <label>Antiguo correo</label>
                            <p><?php echo $usuario->correo;?></p>
                          </div>
                          <div>
                            <label for="nuevo_correo">Nuevo correo</label>
                            <input type="email" class="form-control" id="nuevo_correo" name="nuevo_correo" placeholder="Introduce nuevo correo">
                          </div>
                          <div>
                            <label for="pass_nuevo_correo">Contraseña de confirmación</label>
                            <input type="password" class="form-control" id="pass_nuevo_correo" name="pass_nuevo_correo" placeholder="Introduce tu contraseña">
                          </div>
                        </div>
                        <div class="modal-footer">
                            <div class="row text-center">
                              <div class="col-xs-6">
                                  <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Cancelar</button>
                              </div>
                              <div class="col-xs-6">
                                <input type="submit" class="btn btn-primary btn-block" value="Guardar Cambios">
                              </div>
                            </div>
                        </div>
                      </div>
                      <?php echo Form::close();?>
                    </div>
                  </div>
                </div>
                <!-- Cerrar sesion -->
                <div class="modal fade" id="modalCerrar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">Cierre de sesión</h4>
                      </div>
                      <div class="modal-body">
                        Al cerrar la sesión se perderá toda la información que no ha sido guardada. ¿Está seguro de cerrar la sesión?
                      </div>
                      <div class="modal-footer">
                          <div class="row text-center">
                              <div class="col-xs-6">
                                <button type="button" class="btn btn-primary btn-block" data-dismiss="modal">Cancelar</button>
                              </div>
                              <div class="col-xs-6">
                                <?php echo Html::anchor('sesion/cerrar','Cerrar Sesión',array('type' => 'button', 'class' => 'btn btn-danger btn-block')) ;?>
                              </div>
                          </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Ver foto -->
                <div class="modal fade" id="modalInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">Información</h4>
                      </div>
                      <div class="modal-body">
                        <div class="foto" style="background-image: url(<?php echo $foto;?>)"></div>
                        <h3><?php echo ($usuario->nombres)." ".($usuario->apellidos);?></h3>
                        <p><?php echo "Correo: ".($usuario->correo);?></p>
                        <p><?php echo "Cuenta: ".substr($id, 1);?></p>
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- /Modales -->
            </div>
        </div>
    </div>

<!-- Mensaje -->
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
              <?php       
                $usuario = SESSION::get('usuario');
                $mensaje = SESSION::get('mensaje');
                  if(isset($mensaje)){
                      echo "<div class='alert alert-warning alert-dismissible fade in' style='z-index: 100;'>";
                      echo $mensaje;
                      echo "</div>";
                      SESSION::delete('mensaje');
                  }
              ?> 
            </div>
        </div>
    </div>
<!-- /Mensaje -->