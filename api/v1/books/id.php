<!-- удаление книги по id (GET)-->
<?php
	
	require('../../../modules/db_connect.php');

	// Получение информации о книге

	$delBookQuery = mysqli_query($link, 'DELETE FROM `books` WHERE `id` = '.(int) $_GET['id'].';');
	
	if ($delBookQuery == true){
		$response['status'] = 'good';
	}else{
		$response['status'] = 'error';
	}

	echo json_encode($response);

?>