<section class="success">
    <div class="container">
        <div class="row">
            <div class="text-center">

<?php 

if (isset($error) && $error)
	echo "<h1>Error<h1>";

	//Session::destroy();	

if (isset($mensaje))
	echo "<h3>".$mensaje."</h3>";

?>
			</div>
		</div>
	</div>
</section>	
	
