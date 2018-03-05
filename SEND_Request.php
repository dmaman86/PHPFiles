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

		if($token_list){

			$token = $token_list["token"];
			$name_Sender = $dataSender["name"];
			$Lastname_Sender = $dataSender["last_name"];
			$nameReceptor = $dataReceptor["name"];
			$last_nameReceptor = $dataReceptor["last_name"];

			$hour_request = strftime("%H:%M , %A, %d of %B of %Y ");

			$responseSendRequestSender = RequestFriends::SendRequest($NameTableSender,
			$receptor, 2,$hour_request);

			$responseSendRequestReceptor = RequestFriends::SendRequest($NameTableReceptor,
			$sender, 3,$hour_request);


			if($responseSendRequestSender == -1){//if table of sender no exist
				RequestFriends::CreateTable($NameTableSender);
				$responseSendRequestSender = RequestFriends::SendRequest($NameTableSender,
				$receptor, 2,$hour_request);
			}
			if($responseSendRequestReceptor == -1){//if table of receptor no exist
				RequestFriends::CreateTable($NameTableReceptor);
				$responseSendRequestReceptor = RequestFriends::SendRequest($NameTableReceptor,
				$sender, 3,$hour_request);
			}

			if($responseSendRequestSender == 200 && $responseSendRequestReceptor == 200){
				echo json_encode(array('result'=>"200", 'status'=>"2", "fullName"=>$nameReceptor . " " . $last_nameReceptor, "hour"=>$hour_request));
				$arrayData = array('type' => 'request',
					'sub_type'=>'send_request',
					 'user_send' => $sender, 
					 'user_send_request_name' => $name_Sender . ' ' .$Lastname_Sender,
					 'hour'=>$hour_request,
					 'head' => 'Friends Request', 
					 'body' =>  $name_Sender . " " . $Lastname_Sender . " send request friends");
				RequestFriends::SendNotification($token, $arrayData);
			}
			else{
				echo json_encode(array('result'=>"-1"));
			}
		}else{
			echo json_encode(array('result'=>"-1"));
		}

	}
?>