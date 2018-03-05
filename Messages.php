<?php
	require 'Database.php';

	class Messages{
		function __construct(){

		}

		/*public static function CreateTable($NameTable){
			try{
				$consult = "CREATE TABLE $NameTable (
							Id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
							user VARCHAR(50) NOT NULL,
							code_message VARCHAR(80) NOT NULL, 
							message VARCHAR(500) NOT NULL, 
							kind_message VARCHAR(10) NOT NULL,
							hour_sms VARCHAR(50) NOT NULL )";
				$response = Database::getInstance()->getDB()->prepare($consult);
				$response->execute(array());
				return 200;
			}catch(PDOException $e){
				return -1;
			}
		}*/

		public static function SendMessage($TableName,$user,$code_message, $message, $kind_message, $hour_from_sms){
			try{
				$consult = "INSERT INTO $TableName (user,code_message,
				 message,kind_message,hour_sms) VALUES (?,?,?,?,?)";

				 $response = Database::getInstance()->getDb()->prepare($consult);
				 $response->execute(array($user, $code_message, $message, $kind_message, $hour_from_sms));
				 return 200;
			}catch(PDOException $e){
				return -1;
			}
		}

		public static function RequestMessageUser($name_table, $receptor){
			try{
				$consult = "SELECT * FROM $name_table WHERE user = ?";

				 $result = Database::getInstance()->getDb()->prepare($consult);
				 $result->execute(array($receptor));
				 $table = $result->fetchAll(PDO::FETCH_ASSOC);
				 return $table;
			}catch(PDOException $e){
				return false;
			}
		}

		public static function getTokenUser($id){
			$consult = "SELECT id,token FROM Token WHERE id = ?";

			$result = Database::getInstance()->getDb()->prepare($consult);

			$result->execute(array($id));

			$list = $result->fetch(PDO::FETCH_ASSOC);

			return $list;
		}

		public static function SendNotification($Message,$hour,$token,$sender_message,$receptor_message){
			ignore_user_abort();
			ob_start();

			$url = "https://fcm.googleapis.com/fcm/send";

			$fields = array('to' => $token,
			'data' => array('type' => 'message','message' => $Message, 'hour' => $hour, 'head' => $sender_message.' was send new message', 'body' => $Message, 'receptor' => $receptor_message, 
				'sender' => $sender_message));

			define('GOOGLE_API_KEY', 'AIzaSyAV4ySB9qKP1WdI7BwdOb846TQ3C_1Y6MU');

			$headers = array('Authorization:key='.GOOGLE_API_KEY,
					'Content-Type:application/json');

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($fields));

			$result = curl_exec($ch);

			if($result == false)
				die('Curl failed ' . curl_error());
			curl_close($ch);

			return $result;
		}
	}


?>