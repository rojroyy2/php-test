<?php
	
	require('../db_connect.php');

	// Добавление новой книги

	$_POST = json_decode(file_get_contents('php://input'), true);

	if ((strlen($_POST['name']) > 255)||(strlen($_POST['name']) == 0)||(is_int($_POST['author']) == false)||(is_int($_POST['year_write']) == false)||($_POST['year_write'] > date ( 'Y' ))||($_POST['count_pages'] > 9999)||(is_int($_POST['id']) == false)){
		echo json_encode($response);
		exit();
	}

	$updateBookQuery = mysqli_query($link, 'UPDATE `books` SET `name` = "'.$_POST['name'].'", `author`= '.$_POST['author'].', `year_write` = '.$_POST['year_write'].', `count_pages` = '.$_POST['count_pages'].', `preview` = "'.$_POST['preview'].'" WHERE `books`.`id` = '.$_POST['id'].';');

	if ($updateBookQuery == true){
		$response['status'] = 'good';
	}else{
		$response['status'] = 'error0';
	}
	
	echo json_encode($response);

?>