<?php
	require 'Database.php';

	class RequestFriends{
		function __construct(){

		}

		/*public static function CreateTable($NameTable){
			try{
				$consult = "CREATE TABLE $NameTable (
							Id VARCHAR (50) PRIMARY KEY, 
							status VARCHAR(10) NOT NULL, 
							date_friends VARCHAR(50) NOT NULL)";
				$response = Database::getInstance()->getDB()->prepare($consult);
				$response->execute(array());
				return 200;
			}catch(PDOException $e){
				return -1;
			}
		}*/

		/*1 -> no friends
		2 -> send request friends
		3-> admit request friends
		4 -> friends*/

		public static function getDataUser($id){
			$consult = "SELECT name,last_name FROM PersonalInfo WHERE id = ?";

			$result = Database::getInstance()->getDb()->prepare($consult);

			$result->execute(array($id));

			$list = $result->fetch(PDO::FETCH_ASSOC);

			return $list;
		}

		public static function getLastMessage($id, $receptor){
			$nameTableSender = "Messages_" . $id;

			$consult = "SELECT * FROM $nameTableSender WHERE Id = (select max(Id) FROM $nameTableSender M2 WHERE M2.user = ?)";

			$result = Database::getInstance()->getDb()->prepare($consult);

			$result->execute(array($receptor));

			$list = $result->fetch(PDO::FETCH_ASSOC);

			return $list;
		}

		public static function SendRequest($TableName, $Id, $status, $date_friends){
			try{
				$consult = "INSERT INTO $TableName (Id,
				 status,date_friends) VALUES (?,?,?)";

				 $response = Database::getInstance()->getDb()->prepare($consult);
				 $response->execute(array($Id,$status,$date_friends));
				 return 200;
			}catch(PDOException $e){
				return -1;
			}
		}

		public static function UpdateData($TableName, $Id, $status, $date_friends,$status_var){
			try{
				$consult = "UPDATE $TableName SET status=?, date_friends=? WHERE Id=? AND status=?";
				$result = Database::getInstance()->getDB()->prepare($consult);
				$result->execute(array($status,$date_friends,$Id,$status_var));
				return 200;
			}catch(PDOException $e){
				return -1;
			}
		}

		public static function DeleteRequest($TableName, $Id){
			if(self::checkIfUserExist($TableName, $id)){
				$consult = "DELETE FROM $TableName WHERE Id=?";
				$result = Database::getInstance()->getDB()->prepare($consult);
				$result->execute(array($Id));
				return 200;
			}
			else{
				return -1;
			}

		}

		public static function checkIfUserExist($table, $id){
			$consult = "SELECT * FROM $table WHERE Id = ?";
	
			$result = Database::getInstance()->getDb()->prepare($consult);

			$result->execute(array($id));

			$list = $result->fetch(PDO::FETCH_ASSOC);

			return $list;
		}

		public static function getTokenUser($id){
			$consult = "SELECT id,token FROM Token WHERE id = ?";

			$result = Database::getInstance()->getDb()->prepare($consult);

			$result->execute(array($id));

			$list = $result->fetch(PDO::FETCH_ASSOC);

			return $list;
		}

		public static function SendNotification($token, $arrayData){
			ignore_user_abort();
			ob_start();

			$url = "https://fcm.googleapis.com/fcm/send";

			$fields = array('to' => $token,
			'data' => $arrayData);

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