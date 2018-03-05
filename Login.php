<?php
	require 'Database.php';

	class Register{
		function _construct(){
		}

		public static function GetAllUsers(){//this function accepts and manages all users
			$consult = "SELECT * FROM Login";

			$result = Database::getInstance()->getDb()->prepare($consult);

			$result->execute();

			$list = $result->fetchAll(PDO::FETCH_ASSOC);

			return $list;

		}

		public static function GetDataById($Id){//this function check if a user exist
			$consult = "SELECT Id,Password FROM Login WHERE Id = ?";//check from a database

			try{
				$result = Database::getInstance()->getDb()->prepare($consult);

				$result->execute(array($Id));

				$list = $result->fetch(PDO::FETCH_ASSOC);

				return $list;
			}catch(PDOException $e){
				return false;
			}
		}

		public static function InsertNewData($id,$password){//this function is for new user
			$consult = "INSERT INTO Login(Id,Password) VALUES(?,?)";
			try{
				$result = Database::getInstance()->getDb()->prepare($consult);
				return $result->execute(array($id,$password));
			}catch(PDOException $e){
				return false;
			}
		}

		public static function UpdateData($id,$password){//this function is for change password
			if(self::GetDataById($id)){
				$consult = "UPDATE Login SET Password=? WHERE Id=?";
				$result = Database::getInstance()->getDB()->prepare($consult);
				return $result->execute(array($password,$id));
			}
			else{
				return false;
			}
		}
	}

?>