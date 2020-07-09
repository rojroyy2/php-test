<?php
	
	require('../db_connect.php');

	// Получение информации о книге

	$_POST = json_decode(file_get_contents('php://input'), true);

	$bookInfoQuery = mysqli_query($link, "SELECT * FROM `books` WHERE `id` = ". (int) $_POST.";");
	$response = mysqli_fetch_assoc($bookInfoQuery);
	
	echo json_encode($response);

?>