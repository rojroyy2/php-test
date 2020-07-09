<!-- обновление данных книги (POST) -->
<?php
	
	require('../../../modules/db_connect.php');

	// Обновление информаци о книге

	if ((strlen($_POST['book']) > 255)||(strlen($_POST['book']) == 0)||($_POST['year'] > date ( 'Y' ))||($_POST['count'] > 9999)){
		exit();
	}

	$updateBookQuery = mysqli_query($link, 'UPDATE `books` SET `name` = "'.$_POST['book'].'", `author`= '.$_POST['author'].', `year_write` = '.(int) $_POST['year'].', `count_pages` = '.(int) $_POST['count'].', `preview` = "'.$_POST['preview'].'" WHERE `books`.`id` = '.(int) $_POST['id'].';');

	if ($updateBookQuery == true){
		$response['status'] = 'good';
	}else{
		$response['status'] = 'error';
	}
	
	echo json_encode($response);

?>