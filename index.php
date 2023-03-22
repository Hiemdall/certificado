<!DOCTYPE html>
<html>
<head>
	<title>Facturas</title>
    <link rel="stylesheet" type="text/css" href="estilo2.css">
</head>
<body>

	<h1>Certificado Integratic</h1>

	<form action="" method="post">
        <img class="logo" src="logo-ejemplo.png" alt="Logo de ejemplo">
		<input type="submit" name="aministracion" value="Administración">
		<input type="submit" name="certificado" value="Certificado">

	</form>

	<?php

	if (isset($_POST['aministracion'])) {
		header('Location: admin/formulario.php');
		exit();
	}

	if (isset($_POST['certificado'])) {
		header('Location: usuario/formulario.php');
		exit();
	}

	?>

</body>
</html>