<?php

	session_start();
	$_SESSION['root'] = null;
	session_destroy();
	header("Location: http://php-test/index.php");

?>