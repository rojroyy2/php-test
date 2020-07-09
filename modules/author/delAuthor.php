<?php

	require('../db_connect.php');

	$id = json_decode(file_get_contents('php://input'), true);

	$count = mysqli_fetch_assoc(mysqli_query($link, 'SELECT count(`books`.`author`) as `count` FROM `author` LEFT JOIN `books` ON `books`.`author` = `author`.`id` WHERE `author`.`id` = '.$id.';'));

	if ($count['count'] != 0){

		// Сначала удалите книги написанные данным автором!
		$response['status'] = 'error1';

	}else{

		$delQuery = mysqli_query($link, 'DELETE FROM `author` WHERE `id` = '.$id.';');

		if ($delQuery == true){

			// Удаление прошло успешно

			$response['status'] = 'good';

		}else{

			// Удаление не удалось

			$response['status'] = 'error1';

		}

	}

	echo json_encode($response);

?>