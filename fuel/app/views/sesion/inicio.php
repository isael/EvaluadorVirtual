<section class="success">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h3>
                    <?php if(isset($mensaje)){
                            echo $mensaje;?>
                            <hr>
                            <?php
                        }
                    ?>
                </h3>
                <h3>Iniciar Sesión</h3>
            </div>
        </div>
        <br/>
        <?php echo Form::open('sesion/inicio');?>
        	<div class="row">
        		<div class="form-group col-md-6 col-md-offset-3">
				    <label for="correo">Correo electrónico:</label>
				    <input type="email" class="form-control" id="correo" name="correo">
				</div>
				<div class="form-group col-md-6 col-md-offset-3">
				    <label for="pwd">Contraseña:</label>
				    <input type="password" class="form-control" id="pwd" name="pwd">
				</div>
				<div class="form-group col-md-6 col-md-offset-3">
			        <br/>
				</div>
				<div class="form-group col-md-6 col-md-offset-3">
					<button type="submit" class="btn btn-primary btn-block">Iniciar</button>
				</div>
        	</div>
        <?php echo Form::close();?>        	
    </div>
</section>

