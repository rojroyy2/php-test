<?php

	session_start();
	
	$_POST = json_decode(file_get_contents('php://input'), true);

	if (($_POST['login'] == '') || ($_POST['password']) == ''){

		session_destroy();
		response('error0');

	}else{

		if ((md5(md5($_POST['login'] . 'solllll6456r')) == md5(md5('admin' . 'solllll6456r'))) && (md5(md5($_POST['password'] . 'solllll6456r'))) == md5(md5('admin' . 'solllll6456r'))){

			$_SESSION['root'] = 1;
			response('good');

		}else{

			session_destroy();
			response('error0');

		}

	}

// Функция выдачи ответа клиенту

	function response($status){
		$response['status'] = $status;
		echo json_encode($response);
		exit();
	}

?>