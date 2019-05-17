<?php
Class Duplicate_question_model extends CI_Model
{
 
  
 function check_duplicate($limit){
	 
	$question=strip_tags($this->input->post('question'));
			 $this->db->like('savsoft_qbank.question',$question);

	 
		 $this->db->join('savsoft_category','savsoft_category.cid=savsoft_qbank.cid');
	 $this->db->join('savsoft_level','savsoft_level.lid=savsoft_qbank.lid');
	 $this->db->limit(5,$limit);
		$this->db->order_by('savsoft_qbank.qid','desc');
		$query=$this->db->get('savsoft_qbank');
		return $query->result_array();
 }
 
  

 
}







 



?>
