<?php
	
	session_start();
	if ($_SESSION['root'] == 1){

		header("Location: http://php-test/admin.php");
		exit();

	}

	// Подключение Базы данных

	require('modules/db_connect.php');

	// Функция вывода книги автора

	function bookWrite($book){
		echo '<li>';
			echo '<div class="bookName">"'. $book['bookName'] .'"</div>';
			echo '<div class="bookYear">Год издания: <u>'. $book['yaer'] .'</u></div>';
			echo '<div class="bookCountPages">Объём: <u>'. $book['countPages'] .' страниц</u></div>';
			echo '<div class="bookInfo">Краткое описание:'. $book['preview'] .'</div>';
		echo '</li>';
	}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Books</title>
	<link rel="stylesheet" type="text/css" href="styles/slyle.css">
	<link rel="stylesheet" type="text/css" href="styles/index.css">
</head>
<body>
	<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
	<div id="bookList">
		<div id="autorisation" class="adminInput">
			<h1>Администрирование:</h1>
			<input type="text" v-model="login" placeholder="Логин:">
			<input type="password" v-model="password" placeholder="Пароль:">
			<div class="button" @click="input">Вход</div>
		</div>
		<?php

			$authorId = 0;

			// Запрос к БД

			$bookQuery = mysqli_query($link, "SELECT `books`.`name` as `bookName`, `books`.`yeaк_write` as `yaer`, `books`.`count_pages` as `countPages`, substring(`books`.`preview`, 1, 150) as `preview`, concat(`author`.`surname`, ' ', `author`.`name`, ' ', `author`.`patronymic`) as `authorName`, `author`.`id` as `authorId` FROM `books` LEFT JOIN `author` ON `author`.`id` = `books`.`author` ORDER BY `author`.`id`;");
			
			// Получаем количество произведений каждого автора

			$countBooksQuery = mysqli_query($link, "SELECT count(`books`.`author`) as `countBook`, `author`.`id` as `author` FROM `books` LEFT JOIN `author` ON `books`.`author` = `author`.`id` GROUP BY `books`.`author`;");

			while ($countBooks = mysqli_fetch_assoc($countBooksQuery)){
				$countBooksArray[] = $countBooks;
			}
			
			while ($book = mysqli_fetch_assoc($bookQuery)){

				// Если автор уже был выведен то добавляем ему книги, если автор ещё не был выведен, добавляем контеинер для его книг

				if ($book['authorId'] != $authorId){

					foreach ($countBooksArray as $key) {

						if ($book['authorId'] == $key['author']){

							$booksCount = $key['countBook'];

						}

					}

				?>
					</ul>
					<div class="authorName"><?php echo $book['authorName'] ?></div>
					<div class="authorCountBook">Количество произведений: <?php echo $booksCount; ?></div>
					<ul>

						<?php 

							bookWrite($book);

							$authorId = $book['authorId'];

				}else{

					bookWrite($book);

				}

			}

		?>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
	<script type="text/javascript" src="scripts/index.js"></script>
</body>
</html>