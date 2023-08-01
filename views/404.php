<?php
defined('WEBSITEPATH') OR exit('No se permite acceso directo a este archivo');
$title = WEBSITENAME.' || Error 404. P&aacute;gina no encontrada';
?>
<!DOCTYPE html>
<html>
<head>
	<title><?=$title;?></title>
	<?php
	include_once('includes/head.php');
	?>
</head>
<body>
	<div>
		<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
	</div>
		<div class="container">
			<div class="text text-center">
				<h1>SISTEMA DE CONTROL DE VOTACIONES</h1>
				<div class="text text-center h3">P&aacute;gina no encontrada</div>
				<p>&nbsp;</p><p>&nbsp;</p>
        <img src="images/error404.jpg" width="70%">
        <p>
					<p>&nbsp;</p>
					<h4><a class="btn btn-primary btn-lg" href="<?=WEBSITEPATH;?>?pg=formulario"><u>Ir al inicio</u></a></h4>
        </p>
			</p>
			</div>
			<!----//End-footer--->
			<!---//End-wrap---->
		</div>
	</body>
</html>
