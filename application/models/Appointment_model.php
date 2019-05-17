<?php
Class Appointment_model extends CI_Model
{
 
  function appointment_list($limit){
   if($this->input->post('search')){
  // print_r($_POST);die;
		 $search=$this->input->post('search');
		 $this->db->where('appointment_request.appointment_id',$search); 
		        

	 }
	  $logged_in=$this->session->userdata('logged_in');
		$nor=$this->config->item('number_of_rows');
		
		$tim=date('Y-m-d',time());
	 
		$query=$this->db->query("
		select A.*, B.first_name as requested_by_name, B.skype_id as requested_by_skype
		, C.first_name as appointed_to_name, C.skype_id as appointed_to_skype
		 from appointment_request as A
		JOIN savsoft_users as B on B.uid=A.request_by
		JOIN savsoft_users as C on C.uid=A.to_id
		 order by A.appointment_timing DESC
		limit $limit,$nor
		");
		return $query->result_array();
		
	 
 }
 
 
 function get_appointment($appointment_id){
 
 $this->db->where('appointment_id',$appointment_id);
 $query=$this->db->get('appointment_request');
 return $query->row_array();
 }
 
 function get_user($uid){
 
 $this->db->where('uid',$uid);
 $query=$this->db->get('savsoft_users');
 return $query->row_array();
 }
 
 
 function change_status($appointment_id,$status){
 
 $this->db->where('appointment_id',$appointment_id);
  $this->db->update('appointment_request',array('appointment_status'=>$status));

 }
 
 
  
	 	
	 	
	 	
	 	
	 	
	 	
	 	
	 	
	 	
	 	
	 	
 }
