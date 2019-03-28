<?php 

	class quiz{
		protected $db;

		public function __construct(){
			$this->db = DB::getInstance();
		}

		public function createQuiz($quizInfo){

			$query="INSERT INTO quiz( Name, Code, Descr, user_id) VALUES ('".$quizInfo[0]."','".$quizInfo[1]."','".$quizInfo[2]."','".$quizInfo[3]."')";
					$this->db->exec($query);

		}

		public function getQuizByNameAndUser($user_id, $quiz_id){
			
			$query = "SELECT * FROM quiz WHERE user_id = ". $user_id. " AND id =" . $quiz_id;
			echo $query;
			echo "<br>";

			$quizArray[] = $this->db->run($query)->fetch();

			print_r($quizArray[0]);
		}

		public function getAllQuiz(){
			$query = "SELECT * FROM quiz WHERE 1";

			$quizArray[] = $this->db->run($query)->fetch();

			for($i = 0; $i < count($quizArray); $i++){
				print_r( $quizArray);
			}

		}
	}

?>