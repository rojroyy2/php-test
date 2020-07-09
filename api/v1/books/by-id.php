<!-- получение данных о книге по id (GET)-->
<?php

	require('../../../modules/db_connect.php');

	$bookInfoQuery = mysqli_query($link, "SELECT `books`.`id` as `id`, `books`.`name` as `book`, concat(`author`.`surname`, ' ', substring(`author`.`name`, 1, 1), '. ', substring(`author`.`patronymic`, 1, 1), '.') as `author`, `books`.`year_write`, `books`.`count_pages`, `books`.`preview` FROM `books` LEFT JOIN `author` ON `author`.`id` = `books`.`author` WHERE `books`.`id` = ". (int) $_GET['id'].";");

	$result = mysqli_fetch_assoc($bookInfoQuery);

	echo json_encode($result, JSON_UNESCAPED_UNICODE);
?>