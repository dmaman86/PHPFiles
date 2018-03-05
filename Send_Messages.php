<?php

	require 'Messages.php';
	setlocale(LC_TIME, 'he_IL.UTF-8');
	date_default_timezone_set('Asia/Jerusalem');

	if($_SERVER['REQUEST_METHOD']=='POST'){

		$data = json_decode(file_get_contents("php://input"),true);
		$sender = $data["sender"];
		$receptor = $data["receptor"];
		$message = $data["message"];
		$NameTableSender = "Messages_" . $sender;
		$NameTableReceptor = "Messages_" . $receptor;

		$token_list = Messages::getTokenUser($receptor);

		if($token_list){

			$token = $token_list["token"];

			//$response_CreateTable_Sender = Messages::CreateTable($NameTableSender);

			//$response_CreateTable_Receptor = Messages::CreateTable($NameTableReceptor);

			/*this is for date and hours*/
			$actual_date = getdate();
			$seconds = $actual_date['seconds'];
			$minutes = $actual_date['minutes'];
			$hour = $actual_date['hours'];
			$day = $actual_date['mday'];
			$month = $actual_date['mon'];
			$year = $actual_date['year'];

			$miliseconds = DateTime::createFromFormat('U.u',microtime(true));

			$id_user_sender = $sender . "_" . $hour . $minutes . $seconds . $miliseconds->format("u");
			$id_user_receptor = $receptor . "_" . $hour . $minutes . $seconds . $miliseconds->format("u");

			$hour_from_sms = strftime("%H:%M , %A, %d of %B of %Y ");

			$MEE = false;//this flag boolean for sender
			$MER = false;//this is flag boolean for receptor

			$responseSendMessageSender = Messages::SendMessage($NameTableSender,$receptor,
			$id_user_receptor, $message,1,$hour_from_sms);

			if($responseSendMessageSender == 200){
				$MEE = true;
			}
			else{
				echo "We can't send a message from sender";
			}

			$responseSendMessageReceptor = Messages::SendMessage($NameTableReceptor,$sender,
				$id_user_sender, $message,2,$hour_from_sms);

			if($responseSendMessageReceptor == 200){
				$MER = true;
			}
			else{
				echo "We can't send a message from receptor";
			}

			if($MEE && $MER){
				echo json_encode(array('result' => "a message was sended correctly"));
				Messages::SendNotification($message,$hour_from_sms,$token,$sender,$receptor);
			}
		}
		else{
			echo json_encode(array('result' => "a user receptor not exist"));
		}
		
		
	}
?>