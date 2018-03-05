<?php
	require 'Token.php';

	if($_SERVER['REQUEST_METHOD']=='POST'){
		$data = json_decode(file_get_contents("php://input"),true);
		$response = Token::InsertNewData($data["id"],$data["token"]);

		if($response){
			echo json_encode(array('result' => 'Token goup to database'));
		}
		else{
			Token::UpdateData($data["id"],$data["token"]);
			echo json_encode(array('result' => 'Token goup to database'));
		}
	}

?>