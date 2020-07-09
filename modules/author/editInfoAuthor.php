<?php
	
	require('../db_connect.php');

	// Добавление новой книги

	$_POST = json_decode(file_get_contents('php://input'), true);

	if ((strlen($_POST['name']) > 20)||(strlen($_POST['surname']) > 20)||(strlen($_POST['patronymic']) > 20)){
		$response['status'] = false;
		echo json_encode($response);
		exit();
	}

	$updateAuthorQuery = mysqli_query($link, 'UPDATE `author` SET `surname` = "'.$_POST['surname'].'", `name` = "'.$_POST['name'].'", `patronymic` = "'.$_POST['patronymic'].'" WHERE `id` = '.$_POST['id'].';');

	if ($updateAuthorQuery == true){
		$response['status'] = true;
	}else{
		$response['status'] = false;
	}
	
	echo json_encode($response);

?>