<?php
Class Account_model extends CI_Model
{
 
  function account_list($limit){
	  $logged_in=$this->session->userdata('logged_in');
		
	 // $this->db->limit($this->config->item('number_of_rows'),$limit);
		//$this->db->order_by('account_id','desc');
		$query=$this->db->get('account_type');
		return $query->result_array();
		
	 
 }
 
 function insert_account(){
 
 //print_r($_POST); die;
 $userdata=array(
                        'account_name'=>$this->input->post('name'),
                        
                       'setting'=>$this->input->post('setting'));
       if($this->input->post('users')){
       $userdata['users']=implode(',',$this->input->post('users'));
       }                 
       if($this->input->post('quiz')){
       $userdata['quiz']=implode(',',$this->input->post('quiz'));
       }                 
       if($this->input->post('study_material')){
       $userdata['study_material']=implode(',',$this->input->post('study_material'));
       }                 
       if($this->input->post('result')){
       $userdata['results']=implode(',',$this->input->post('result'));
       }                 
       if($this->input->post('questions')){
       $userdata['questions']=implode(',',$this->input->post('questions'));
       }                 
                        
				$this->db->insert('account_type',$userdata);
 //print_r($this->db->last_query()); exit;
 
 
 }
 
 
 function get_edit_account($account_id){
		 $this->db->where('account_id',$account_id);
		 $query=$this->db->get('account_type');
		 return $query->row_array();
	 	} 
	 	
	 	
	 	
	 	function update_account($account_id){
	 
		$userdata=array(
					'account_name'=>$this->input->post('name'),
					  'setting'=>$this->input->post('setting'));
					if($this->input->post('users')){
       $userdata['users']=implode(',',$this->input->post('users'));
       }else{
       $userdata['users']="";
       }                 
       if($this->input->post('quiz')){
       $userdata['quiz']=implode(',',$this->input->post('quiz'));
       }else{
       $userdata['quiz']="";
       }                 
       if($this->input->post('result')){
       $userdata['results']=implode(',',$this->input->post('result'));
       }else{
       $userdata['results']="";
       }                 
       if($this->input->post('questions')){
       $userdata['questions']=implode(',',$this->input->post('questions'));
       } else{
       $userdata['questions']="";
       } 
        
    if($this->input->post('study_material')){
       $userdata['study_material']=implode(',',$this->input->post('study_material'));
       }else{
       $userdata['study_material']="";
       }  
      
   if($this->input->post('appointment')){
       $userdata['appointment']=implode(',',$this->input->post('appointment'));
       }else{
       $userdata['appointment']="";
       }  
	$this->db->where('account_id',$account_id);
	$this->db->update('account_type',$userdata);				
	}
	
	
	function remove_account($account_id){
		$this->db->where('account_id',$account_id);
		$this->db->delete('account_type');
		return true;
		}				
 
 }
 
