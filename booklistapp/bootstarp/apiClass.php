<?php
class API
	{
		private static $sql;
		
		public static function setSQL($id)
		{
			if ($id)
			{
				self::$sql = "SELECT * FROM users WHERE id =".$id;
			}
			else
			{
				self::$sql = "SELECT * FROM users";				
			}
		}
		
		public static function printJson()
		{	
			include 'database.php';
			
			$pdo = Database::connect();
				
			foreach($pdo->query(self::$sql) as $row)
			{
				$arr = Array('username' => $row['username'], 'email' => $row['email'], 'mobile' => $row['mobile']);
				echo json_encode($arr);
			}
			
			Database::disconnect();
		}
	}
?>