<?php

	session_start();
	if ($_SESSION['root'] != 1){

		header("Location: http://php-test/index.php");
		session_destroy();
		exit();

	}
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>API Controller</title>
</head>
<body>
	<h1>API Контроллер:</h1>
	<hr>
	<a href="v1/books/list.php">Получение списка книг с именем автора</a>
	<hr>
	<form action="v1/books/by-id.php" method="GET">
		<input type="text" name="id" placeholder="Введите id книги для получения информаци о ней:">
	    <input type="submit" value="Информация о книге по id"/>
	</form>
	<hr>
	<h4>Изменение информации о книге:</h4>
	<form action="v1/books/update.php" method="POST">
		<input type="text" name="id" placeholder="id книги">
		<input type="text" name="book" placeholder="Название книги">
		<br>
		<input type="number" name="year" placeholder="Год написания">
		<input type="number" name="count" placeholder="Количество страниц">
		<br>
		<p>Автор:</p>
		<select name="author">
			<?php
				require('../modules/db_connect.php');

				$authorQuery = mysqli_query($link, "SELECT concat(`author`.`surname`, ' ', substring(`author`.`name`, 1, 1), '. ', substring(`author`.`patronymic`, 1, 1), '.') as `author`, `author`.`id` FROM `author` ORDER BY `author`.`name`;");
				while ($list = mysqli_fetch_assoc($authorQuery)){
			?>
				<option value="<?php echo $list['id']; ?>"><?php echo $list['author']; ?></option>
			<?php
				}
			?>
		</select>
		<br>
		<textarea name="preview" id="" placeholder="Краткое описание"></textarea>
		<br>
		<input type="submit" value="Обновить">
	</form>
	<hr>
	<h4>Удаление книги по id:</h4>
	<form action="v1/books/id.php" method="GET">
		<input type="text" name="id" placeholder="Введите id:">
	    <input type="submit" value="Удалить книгу"/>
	</form>
</body>
</html>