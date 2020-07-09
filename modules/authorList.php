<?php
	
	require('db_connect.php');

	// Получение списка авторов для таблице в админке

	$authorListQuery = mysqli_query($link, "SELECT `author`.`id`, count(`books`.`author`) as `count`, `author`.`surname`, `author`.`name`, `author`.`patronymic` FROM `author` LEFT JOIN `books` ON `books`.`author` = `author`.`id` GROUP BY `author`.`id` ORDER BY `author`.`surname`;");

	$autorSelectQuery = mysqli_query($link, "SELECT concat(`author`.`surname`, ' ', substring(`author`.`name`, 1, 1), '. ', substring(`author`.`patronymic`, 1, 1), '.') as `author`, `author`.`id` FROM `author` ORDER BY `author`.`name`;");

	while ($authorList = mysqli_fetch_assoc($authorListQuery)){

		$response['list'][] = $authorList;

	}

	while ($autorSelect = mysqli_fetch_assoc($autorSelectQuery)){

		$response['select'][] = $autorSelect;

	}

	echo json_encode($response);

?>