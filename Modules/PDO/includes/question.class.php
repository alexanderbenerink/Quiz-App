<?php 

	class question{
		protected $db;

		public function __construct(){
			$this->db = DB::getInstance();
		}

		public function createQuestion($quiz_Questions){
			if(isset($quiz_Questions)){
				//^^^will be put in assoc array^^^
				//loop through array
				//echo Count($quiz_Questions);
				for($i = 0; $i < Count($quiz_Questions); $i++){
					$query="INSERT INTO question( questionString, quiz_id, questionAnswer, questionWrongAnswer1, questionWrongAnswer2, questionWrongAnswer3, questionType) VALUES ('".$quiz_Questions[$i][0]."','".$quiz_Questions[$i][1]."','".$quiz_Questions[$i][2]."','".$quiz_Questions[$i][3]."','".$quiz_Questions[$i][4]."','".$quiz_Questions[$i][5]."','".$quiz_Questions[$i][6]."')";
					//echo "<br>".$query;
					$this->db->exec($query);
				}
			}
		}

		public function getQuestionsByQuiz($id){
			//get question query by $id
			//$questionArray
			if(count($questionArray) >= 1){
				//return question array
			}else{
				//return false
			}
		}
	}

?>