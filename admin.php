<?php
	
	session_start();
	if ($_SESSION['root'] != 1){

		header("Location: http://php-test/index.php");
		session_destroy();
		exit();

	}

	// Подключение Базы данных

	require('modules/db_connect.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Админстрирование</title>
	<link rel="stylesheet" type="text/css" href="styles/slyle.css">
	<link rel="stylesheet" type="text/css" href="styles/admin.css">
</head>
<body>
	<div id="adminFunctionConteiner">
		<div class="adminFunctionConteiner">
			
		</div>
		<div class="adminFunctionConteiner">
			
		</div>
	</div>
</body>
<script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')</script>
</html>