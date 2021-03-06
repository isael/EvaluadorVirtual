<section class="success">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h4>
                    <?php if(isset($mensaje)){
                        $mensajeArray = explode("|", $mensaje);
                        foreach ($mensajeArray as $mensaje) {
                            echo $mensaje;
                            ?>
                                <br>
                            <?
                        }
                    }
                    ?>
                </h4>
                <h3>Registro como profesor</h3>
                
            </div>
        </div>

        <?php echo Form::open(array('action' => 'principal/registro_profesor', 'accept-charset' => 'utf-8', 'method' => 'post', 'onsubmit' => 'javascript:{return es_valido_formulario_registro_profesor()}'));?>
        	<div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <label for="apellidos">Apellido(s):</label>
                    <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?php if (isset($apellidos)){echo $apellidos;}?>">
                </div>
                <div class="col-md-6 col-md-offset-3">
                    <label for="nombres">Nombre(s):</label>
                    <input type="text" class="form-control" id="nombres" name="nombres" value="<?php if (isset($nombres)){echo $nombres;}?>">
                </div>
                <div class="col-md-6 col-md-offset-3">
                    <label for="email">Correo electrónico:</label>
                    <input type="email" class="form-control" id="correo" name="correo" value="<?php if (isset($correo)){echo $correo;}?>">
                </div>
                <div class="col-md-6 col-md-offset-3">
                    <label for="ntrabajador">Número de trabajador:</label>
                    <input type="text" class="form-control" id="ntrabajador" name="ntrabajador" value="<?php if (isset($ntrabajador)){echo $ntrabajador;}?>">
                </div>
                <div class="col-md-6 col-md-offset-3">
                    <label for="pwd1">Contraseña:</label>
                    <input type="password" class="form-control" id="pwd1" name="pwd1">
                </div>
                <div class="col-md-6 col-md-offset-3">
                    <label for="pwd2">Repetir Contraseña:</label>
                    <input type="password" class="form-control" id="pwd2" name="pwd2">
                </div>
                <div class="col-md-6 col-md-offset-3">
                    <br />
                </div>
                <div class="col-md-6 col-md-offset-3">
                    <button type="submit" class="btn btn-primary btn-block">Registrarme</button>
                </div>
            </div>

        <?php echo Form::close();?>
        <br>
        <div style="text-align: center">
            <h4><u>
                <?php echo Html::anchor('principal/registro','<i class="fa fa-arrow-left"></i>'.' Volver');?>
            </u></h4>
        </div>
        <br>
    </div>
</section>