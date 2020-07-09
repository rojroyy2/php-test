<?php
	
	require('db_connect.php');

	// Получение списка книг для таблице в админке

	$bookListQuery = mysqli_query($link, "SELECT `books`.`id`, `books`.`name`, `books`.`year_write`, `books`.`count_pages`, concat(`author`.`surname`, ' ', substring(`author`.`name`, 1, 1), '. ', substring(`author`.`patronymic`, 1, 1), '.') as `author` FROM `books` LEFT JOIN `author` ON `books`.`author` = `author`.`id` ORDER BY `books`.`name`;");

	while ($bookList = mysqli_fetch_assoc($bookListQuery)){

		$response['list'][] = $bookList;

	}

	echo json_encode($response);

?>