<?php
	require 'Token.php';

	if($_SERVER['REQUEST_METHOD']=='GET'){

		if(isset($_GET['id'])){
			$identify = $_GET['id'];

			$answer = Token::GetDataById($identify);

			if($answer){
				echo $answer["token"];
			}
			else{
				echo json_encode(array('Answer'=>'A user not exist'));
			}
		}
		else{
			echo json_encode(array('Answer'=>'Missing identifier'));
		}

	}



?>