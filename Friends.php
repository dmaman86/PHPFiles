<?php
	require 'Database.php';

	class Friends{
		function __construct(){
		}

		public static function GetAllUsers($name_table){//this function accepts and manages all users
			$consult = "SELECT $name_table.Id, $name_table.status, $name_table.date_friends, PersonalInfo.name, 
			PersonalInfo.last_name FROM $name_table, PersonalInfo WHERE $name_table.Id = PersonalInfo.id";

			$result = Database::getInstance()->getDb()->prepare($consult);

			$result->execute();

			$list = $result->fetchAll(PDO::FETCH_ASSOC);

			return $list;

		}
	}

?>