<?php
	
	require('../db_connect.php');

	// Удаление книги

	$_POST = json_decode(file_get_contents('php://input'), true);

	$delBookQuery = mysqli_query($link, 'DELETE FROM `books` WHERE `id` = '.(int) $_POST.';');

	if ($delBookQuery == true){
		$response['status'] = true;
	}else{
		$response['status'] = false;
	}
	
	echo json_encode($response);

?>