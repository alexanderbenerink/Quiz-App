<?php 

	class result{
		protected $db;

		protected function __construct(){
			$this->db = DB::getInstance();
		}

		public function createResult(){
			if(isset(/* question_id */)&&isset(/* tempUser_id */)){
				//insert into database
			}
		}

		public function getResultByQuestion($id){
			if(isset(/* question_id */)){
				//get score, given answer and tempUsername by $id
				$resultArray
				if(count($resultArray) == 1){
					//return assoc array
				}else{
					//return false
				}
			}
		}
	}

?>