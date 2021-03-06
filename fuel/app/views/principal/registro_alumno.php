<section class="success">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h3>
                    <?php if(isset($mensaje))
                        echo $mensaje;
                    ?>
                </h3>
                <h3>Registro como alumno</h3>
            </div>
        </div>

        <?php echo Form::open(array('action' => 'principal/registro_alumno', 'accept-charset' => 'utf-8', 'method' => 'post', 'onsubmit' => 'javascript:{return es_valido_formulario_registro_alumno()}'));?>
        	<div class="row">
                <div class="form-group col-md-6 col-md-offset-3">
                    <label for="apellidos">Apellido(s):</label>
                    <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?php if (isset($apellidos)){echo $apellidos;}?>">
                </div>
                <div class="form-group col-md-6 col-md-offset-3">
                    <label for="nombres">Nombre(s):</label>
                    <input type="text" class="form-control" id="nombres" name="nombres" value="<?php if (isset($nombres)){echo $nombres;}?>">
                </div>
                <div class="form-group col-md-6 col-md-offset-3">
                    <label for="correo">Correo electrónico:</label>
                    <input type="email" class="form-control" id="correo" name="correo" value="<?php if (isset($correo)){echo $correo;}?>">
                </div>
                <div class="form-group col-md-6 col-md-offset-3">
                    <label for="ncuenta">Número de cuenta:</label>
                    <input type="text" class="form-control" id="ncuenta" name="ncuenta" value="<?php if (isset($ncuenta)){echo $ncuenta;}?>">
                </div>
                <div class="form-group col-md-6 col-md-offset-3">
                    <label for="pwd1">Contraseña:</label>
                    <input type="password" class="form-control" id="pwd1" name="pwd1">
                </div>
                <div class="form-group col-md-6 col-md-offset-3">
                    <label for="pwd2">Repetir Contraseña:</label>
                    <input type="password" class="form-control" id="pwd2" name="pwd2">
                </div>
                <div class="form-group col-md-6 col-md-offset-3">
                    <br />
                </div>
                <div class="form-group col-md-6 col-md-offset-3">
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