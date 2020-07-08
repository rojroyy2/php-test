<?php
	
	session_start();
	if ($_SESSION['root'] != 1){

		header("Location: http://php-test/index.php");
		session_destroy();
		exit();

	}

	// Подключение Базы данных

	require('modules/db_connect.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Админстрирование</title>
	<link rel="stylesheet" type="text/css" href="styles/slyle.css">
	<link rel="stylesheet" type="text/css" href="styles/admin.css">
</head>
<body>
	<div id="adminFunctionConteiner">

		<!-- Работа с информацией о книгах -->

		<div class="adminFunctionConteiner">
			<a id="adminExit" href="modules/userExit.php">Выйти</a>
			<h1>Список книг:</h1>
			<table>
				<tr>
					<th>Название</th>
					<th>Автор</th>
					<th>Год издания</th>
					<th>Объём</th>
				</tr>
				<?php

					$bookListQuery = mysqli_query($link, "SELECT `books`.`id`, `books`.`name`, `books`.`yeaк_wrie`, `books`.`count_pages`, concat(`author`.`surname`, ' ', substring(`author`.`name`, 1, 1), '. ', substring(`author`.`patronymic`, 1, 1), '.') as `author` FROM `books` LEFT JOIN `author` ON `books`.`author` = `author`.`id` ORDER BY `books`.`name`;");

					while ($bookList = mysqli_fetch_assoc($bookListQuery)){

				?>
				<tr data-id="<?php echo $bookList['id']; ?>">
					<td><?php echo $bookList['name']; ?></td>
					<td><?php echo $bookList['author']; ?></td>
					<td><?php echo $bookList['yeaк_wrie']; ?></td>
					<td><?php echo $bookList['count_pages']; ?> страниц</td>
				</tr>
				<?php

					}

				?>
			</table>
			<div class="buttonConteiner">
				<div class="button">Удалить</div>
				<div class="button">Добавить</div>
				<div class="button">Изменить</div>
			</div>
			<div class="status">Ошибка</div>
			<div class="infoConteiner">
				<input type="text" placeholder="Название">
				<input type="text" placeholder="Год издания">
				<input type="text" placeholder="Количество страниц">
				<textarea name="" id="" placeholder="Краткое описание:"></textarea>
				<div class="buttonConteiner">
					<div class="button">Отмена</div>
					<div class="button">Сохранить</div>
				</div>
			</div>
		</div>

		<!-- Работа с информацией авторах -->

		<div class="adminFunctionConteiner">
			<h1>Список авторов:</h1>
			<table>
				<tr>
					<th>Фамилия</th>
					<th>Имя</th>
					<th>Отчество</th>
					<th>Количество книг</th>
				</tr>
				<?php

					$authorListQuery = mysqli_query($link, "SELECT `author`.`surname`, `author`.`name`, `author`.`patronymic`, count(`books`.`id`) as `count` FROM `books` LEFT JOIN `author` ON `author`.`id` = `books`.`author` GROUP BY `books`.`author` ORDER BY `author`.`surname`;");

					while ($authorList = mysqli_fetch_assoc($authorListQuery)){

				?>
				<tr data-id="<?php echo $authorList['id']; ?>">
					<td><?php echo $authorList['surname']; ?></td>
					<td><?php echo $authorList['name']; ?></td>
					<td><?php echo $authorList['patronymic']; ?></td>
					<td><?php echo $authorList['count']; ?> книга</td>
				</tr>
				<?php

					}

				?>
			</table>
			<div class="buttonConteiner">
				<div class="button">Удалить</div>
				<div class="button">Добавить</div>
				<div class="button">Изменить</div>
			</div>
			<div class="status">Ошибка</div>
			<div class="infoConteiner">
				<input type="text" placeholder="Фамилия">
				<input type="text" placeholder="Имя">
				<input type="text" placeholder="Отчество">
				<div class="buttonConteiner">
					<div class="button">Отмена</div>
					<div class="button">Сохранить</div>
				</div>
			</div>
		</div>
		</div>
	</div>
</body>
<script type="text/javascript" src="scripts/admin.js"></script>
<script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')</script>
</html>