<section class="success">
    <div class="container">
        <div class="row">
            <div class="text-center">

<?php 

if (isset($error) && $error)
	echo "<h1>Error: ".$error."<h1>";

	//Session::destroy();
	echo '<br>';
	echo '<hr>';
	echo '<br>';
if (isset($mensaje))
	echo "<h3>".$mensaje."</h3>";

?>
			</div>
		</div>
	</div>
</section>
