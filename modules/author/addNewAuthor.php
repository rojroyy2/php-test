<?php
	
	require('../db_connect.php');

	// Добавление новой книги

	$_POST = json_decode(file_get_contents('php://input'), true);

	if ((strlen($_POST['name']) > 20)||(strlen($_POST['surname']) > 20)||(strlen($_POST['patronymic']) > 20)){
		$response['status'] = false;
		echo json_encode($response);
		exit();
	}

	$addAuthorQuery = mysqli_query($link, 'INSERT INTO `author` (`id`, `surname`, `name`, `patronymic`) VALUES (NULL, "'.$_POST['surname'].'", "'.$_POST['name'].'", "'. $_POST['patronymic'].'");');

	if ($addAuthorQuery == true){
		$response['status'] = true;
		$response['status'] = 'INSERT INTO `author` (`id`, `surname`, `name`, `patronymic`) VALUES (NULL, "'.$_POST['surname'].'", "'.$_POST['name'].'", "'. $_POST['patronymic'].'");';
		$response['id'] = mysqli_insert_id($link);
	}else{
		$response['status'] = false;
	}
	
	echo json_encode($response);

?>