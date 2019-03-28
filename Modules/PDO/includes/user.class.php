<?php  

	class user{

		protected $db;

		public function __construct(){
			$this->db = DB::getInstance();
		}

		public function createUser($userArray){
			
			$passwordHash = hash('ripemd160', $userArray["Password"]);
			//check for existing user				
			//add to database
			$query="INSERT INTO `user`( `Name`, `Email`, `Password`) VALUES ('".$userArray["Name"]."','".$userArray["Email"]."','".$passwordHash."')";
				
			echo "<br>".$query;
			$this->db->exec($query);
			//return true;
			//return alert
		}

		public function login(){
			if(count(/* username and password query */) == 1){
				//set username variable and return positive
			} else {
				//return negative and give an alert
			}
		}

	}

?>