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
	<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
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
				<tr v-for="elem in books.list" v-bind:data-id="elem.id" @click="booksTableClick">
					<td>{{ elem.name }}</td>
					<td>{{ elem.author }}</td>
					<td>{{ elem.yeaк_write }}</td>
					<td>{{ elem.count_pages }} страниц</td>
				</tr>
			</table>
			<div class="buttonConteiner">
				<div class="button" @click="bookDel">Удалить</div>
				<div class="button" @click="addBookWindowShow">Добавить</div>
				<div class="button" @click="editInfoBookWindowShow">Изменить</div>
			</div>
			<div class="status" v-if="books.statusShow.length != 0">{{ books.statusShow }}</div>
			<div class="infoConteiner col4" v-if="books.info.show == true">
				<input type="text" placeholder="Название" v-model="books.info.name">
				<input type="number" placeholder="Год издания" v-model="books.info.year">
				<input type="number" placeholder="Количество страниц" v-model="books.info.count">
				<select placeholder="Автор" name="" id="" v-model="books.info.author">
					<option v-for="elem in books.selectList" v-bind:value="elem.id">{{ elem.author }}</option>
				</select>
				<textarea name="" id="" placeholder="Краткое описание:" v-model="books.info.preview"></textarea>
				<div class="buttonConteiner">
					<div class="button" @click="bookInfoClear">Отмена</div>
					<div class="button" @click="bookInfoSave">Сохранить</div>
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
				<tr v-for="elem in author.list" v-bind:data-id="elem.id" @click="authorTableClick">
					<td>{{ elem.surname }}</td>
					<td>{{ elem.name }}</td>
					<td>{{ elem.patronymic }}</td>
					<td>{{ elem.count }}</td>
				</tr>
			</table>
			<div class="buttonConteiner">
				<div class="button" @click="authorDel">Удалить</div>
				<div class="button" @click="addNewAuthor">Добавить</div>
				<div class="button" @click="editInfoAuthor">Изменить</div>
			</div>
			<div class="status" v-if="author.statusShow.length > 0">{{ author.statusShow }}</div>
			<div class="infoConteiner" v-if="author.info.show">
				<input type="text" placeholder="Фамилия" v-model="author.info.surname">
				<input type="text" placeholder="Имя" v-model="author.info.name">
				<input type="text" placeholder="Отчество" v-model="author.info.patronymic">
				<div class="buttonConteiner">
					<div class="button" @click="authorInfoClear">Отмена</div>
					<div class="button" @click="saveInfoAuthor">Сохранить</div>
				</div>
			</div>
		</div>
		</div>
	</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script type="text/javascript" src="scripts/admin.js"></script>
<?php
	$authorListQuery = mysqli_query($link, "SELECT `author`.`id`, `author`.`surname`, `author`.`name`, `author`.`patronymic`, count(`books`.`id`) as `count` FROM `books` LEFT JOIN `author` ON `author`.`id` = `books`.`author` GROUP BY `books`.`author` ORDER BY `author`.`surname`;");
?>
<script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')</script>
</html>