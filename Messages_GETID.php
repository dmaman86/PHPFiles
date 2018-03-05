<?php

	require 'Messages.php';
	setlocale(LC_TIME, 'he_IL.UTF-8');
	date_default_timezone_set('Asia/Jerusalem');

	if($_SERVER['REQUEST_METHOD']=='POST'){

		$data = json_decode(file_get_contents("php://input"),true);
		$sender = $data["sender"];
		$receptor = $data["receptor"];
		$NameTableSender = "Messages_" . $sender;

		$response = Messages::RequestMessageUser($NameTableSender, $receptor);

		if($response){
			echo json_encode(array("result" => $response));
		}
		else{
			echo json_encode(array("result" => "can't upload a messages"));
		}
		
	}
?>