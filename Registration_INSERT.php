<?php
	require 'Registration.php';

	if($_SERVER['REQUEST_METHOD']=='POST'){
		$data = json_decode(file_get_contents("php://input"),true);
		$response = Registration::InsertNewData($data["id"],
			$data["name"],
			$data["last_name"],
			$data["date_birth"],
			$data["email"],
			$data["phone"]);

		$resp_2 = Registration::InsertNewDataInLogin($data["id"],
			$data["Password"]);


		if($response && $resp_2){
			Registration::CreateTableMessages($data["id"]);
			Registration::CreateTableFriends($data["id"]);
			echo json_encode(array('result' => 'Registration successful'));
		}
		else{
			echo json_encode(array('result' => 'A user exist, please try in another name'));
		}
	}

?>