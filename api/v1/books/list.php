<!-- получение списка книг с именем автора -->
<?php

	require('../../../modules/db_connect.php');

	$query = mysqli_query($link, "SELECT `books`.`id`, `books`.`name`, `books`.`year_write`, `books`.`count_pages`, concat(`author`.`surname`, ' ', substring(`author`.`name`, 1, 1), '. ', substring(`author`.`patronymic`, 1, 1), '.') as `author` FROM `books` LEFT JOIN `author` ON `books`.`author` = `author`.`id` ORDER BY `books`.`name`;");

	$jsonArray = [];

	while($elem = mysqli_fetch_assoc($query)){
		$jsonArray[] = $elem;
	}

	echo json_encode($jsonArray, JSON_UNESCAPED_UNICODE);

?>