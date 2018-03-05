<?php

	require 'RequestFriends.php';
	setlocale(LC_TIME, 'he_IL.UTF-8');
	date_default_timezone_set('Asia/Jerusalem');

	if($_SERVER['REQUEST_METHOD']=='POST'){

		$data = json_decode(file_get_contents("php://input"),true);

		$sender = $data["sender"];//who send membership requests -> 2
		$receptor = $data["receptor"];//who accept membership requests -> 3

		$token_list = RequestFriends::getTokenUser($receptor);

		if($token_list){
			$token = $token_list["token"];
			$NameTableSender = "Friends_" . $sender;
			$NameTableReceptor = "Friends_" . $receptor;

			$responseSendRequestSender = RequestFriends::DeleteRequest($NameTableSender,
				$receptor);

			$responseSendRequestReceptor = RequestFriends::DeleteRequest($NameTableReceptor,
				$sender);

			if($responseSendRequestSender == -1){
				echo json_encode(array('response' =>'-1', 'result' => 'Error Request Friends'));
				return;
			}
			if($responseSendRequestReceptor == -1){
				echo json_encode(array('response' =>'-1','result' => 'Error Request Friends'));
				return;
			}

			if($responseSendRequestSender == 200 && $responseSendRequestReceptor == 200){
				echo json_encode(array('response' =>'200','result' => 'Your are delete this user'));
				$arrayData = array('type' => 'request',
							'sub_type'=>'delete_request',
							 'user_send' => $sender);
				RequestFriends::SendNotification($token, $arrayData);
			}
		}

	}
?>