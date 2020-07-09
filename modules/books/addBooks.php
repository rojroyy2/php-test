<?php
	
	require('../db_connect.php');

	// Добавление новой книги

	$_POST = json_decode(file_get_contents('php://input'), true);

	if ((strlen($_POST['name']) > 255)||(strlen($_POST['name']) == 0)||(is_int($_POST['author']) == false)||(is_int($_POST['year_write']) == false)||($_POST['year_write'] > date ( 'Y' ))||($_POST['count_pages'] > 9999)){
		echo json_encode($response);
		exit();
	}

	$addBookQuery = mysqli_query($link, 'INSERT INTO `books` (`id`, `author`, `name`, `year_write`, `count_pages`, `preview`) VALUES (NULL, '.$_POST['author'].', "'.$_POST['name'].'", '. (int) $_POST['year_write'].', '. (int) $_POST['count_pages'].', "'.$_POST['preview'].'");');

	if ($addBookQuery == true){
		$response['status'] = 'good';
		$response['id'] = mysqli_insert_id($link);
	}else{
		$response['status'] = 'error0';
	}
	
	echo json_encode($response);

?>