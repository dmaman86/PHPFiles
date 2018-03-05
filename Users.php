<?php

	require 'Database.php';

	class Users{
		function _construct(){
		}

		public static function GetAllUsers(){//this function accepts and manages all users
			$consult = "SELECT id,name FROM PersonalInfo WHERE id IN (SELECT id FROM Token)";

			$result = Database::getInstance()->getDb()->prepare($consult);

			$result->execute();

			$list = $result->fetchAll(PDO::FETCH_ASSOC);

			return $list;

		}

	}



?>