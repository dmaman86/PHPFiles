<?php
	require 'Database.php';

	class Registration{
		function _construct(){
		}

		public static function InsertNewData($id,$name,$last_name,$date,$email,$phone){//this function is for new user
			$consult = "INSERT INTO PersonalInfo(id,name,last_name,date_of_birth,email,phone) VALUES(?,?,?,?,?,?)";
			try{
				$result = Database::getInstance()->getDb()->prepare($consult);
				return $result->execute(array($id,$name,$last_name,$date,$email,$phone));
			}catch(PDOException $e){
				return false;
			}
		}

		public static function InsertNewDataInLogin($id,$password){//this function is for new user
			$consult = "INSERT INTO Login(Id,Password) VALUES(?,?)";
			try{
				$result = Database::getInstance()->getDb()->prepare($consult);
				return $result->execute(array($id,$password));
			}catch(PDOException $e){
				return false;
			}
		}

		public static function CreateTableMessages($id){
			$NameTable = "Messages_" . $id;
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
		}

		public static function CreateTableFriends($id){
			$NameTable = "Friends_". $id;
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
		}

	}

?>