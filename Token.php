<?php
	require 'Database.php';

	class Token{
		function _construct(){
		}

		public static function GetAllUsers(){
			$consult = "SELECT * FROM Token";

			$result = Database::getInstance()->getDb()->prepare($consult);

			$result->execute();

			$list = $result->fetchAll(PDO::FETCH_ASSOC);

			return $list;

		}

		public static function GetDataById($id){
			$consult = "SELECT id,token FROM Token WHERE id = ?";

			try{
				$result = Database::getInstance()->getDb()->prepare($consult);

				$result->execute(array($id));

				$list = $result->fetch(PDO::FETCH_ASSOC);

				return $list;
			}catch(PDOException $e){
				return false;
			}
		}

		public static function InsertNewData($id,$password){
			$consult = "INSERT INTO Token(id,token) VALUES(?,?)";
			try{
				$result = Database::getInstance()->getDb()->prepare($consult);
				return $result->execute(array($id,$password));
			}catch(PDOException $e){
				return false;
			}
		}

		public static function UpdateData($id,$password){
			if(self::GetDataById($id)){
				$consult = "UPDATE Token SET token=? WHERE id=?";
				$result = Database::getInstance()->getDB()->prepare($consult);
				return $result->execute(array($password,$id));
			}
			else{
				return false;
			}
		}
	}

?>