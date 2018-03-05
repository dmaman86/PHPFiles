<?php

	require 'RequestFriends.php';
	setlocale(LC_TIME, 'he_IL.UTF-8');
	date_default_timezone_set('Asia/Jerusalem');

	if($_SERVER['REQUEST_METHOD']=='POST'){

		$data = json_decode(file_get_contents("php://input"),true);

		$sender = $data["sender"];//who send membership requests -> 2
		$receptor = $data["receptor"];//who accept membership requests -> 3

		$NameTableSender = "Friends_" . $sender;
		$NameTableReceptor = "Friends_" . $receptor;

		$token_list = RequestFriends::getTokenUser($receptor);
		$dataSender = RequestFriends::getDataUser($sender);
		$dataReceptor = RequestFriends::getDataUser($receptor);
		$lastMessage = RequestFriends::getLastMessage($sender, $receptor);

		if($token_list){

			$token = $token_list["token"];
			$name_Sender = $dataSender["name"];
			$Lastname_Sender = $dataSender["last_name"];
			$nameReceptor = $dataReceptor["name"];
			$last_nameReceptor = $dataReceptor["last_name"];
			$LM = $lastMessage["message"];
			$LH = $lastMessage["hour_sms"];
			$KM = $lastMessage["kind_message"];

			$hour_AdmitFriend = strftime("%H:%M , %A, %d of %B of %Y ");

			$responseSendRequestSender = RequestFriends::UpdateData($NameTableSender,
			$receptor, 4,$hour_AdmitFriend,3);

			$responseSendRequestReceptor = RequestFriends::UpdateData($NameTableReceptor,
			$sender, 4,$hour_AdmitFriend,2);


			if($responseSendRequestSender == -1){
				echo json_encode(array('result' => 'Error Request Friends'));
			}
			if($responseSendRequestReceptor == -1){
				echo json_encode(array('result' => 'Error Request Friends'));
			}

			if($responseSendRequestSender == 200 && $responseSendRequestReceptor == 200){
				echo json_encode(array('result' => '200',
				 "fullName"=>$nameReceptor . " " . $last_nameReceptor, 
				 "LastMessage"=>$LM,
				  "hour"=>$LH,
				   "kind_message"=>$KM));
				$arrayData = array('type' => 'request',
					'sub_type'=>'accept_request',
					 'user_send' => $sender, 
					 'user_send_request_name' => $name_Sender . ' ' .$Lastname_Sender,
					 'hour_aceptRequest'=>$hour_AdmitFriend,
					 'hour_sms'=>$LH,
					 'lastMessage'=> $LM,
					 'kind_message'=>$KM,
					 'head' => 'New Friend', 
					 'body' =>  $name_Sender . " " . $Lastname_Sender . " accept request friends");
				RequestFriends::SendNotification($token, $arrayData);
			}
			else{
				echo json_encode(array('result' => '-1'));
			}
		}
		else{
			echo json_encode(array('result' => '-1'));
		}
	}
?>