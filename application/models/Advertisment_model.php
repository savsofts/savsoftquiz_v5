<?php
Class Advertisment_model extends CI_Model
{
 
  function advertisment_list($limit){
	  $logged_in=$this->session->userdata('logged_in');
		
	  $this->db->limit($this->config->item('number_of_rows'),$limit);
		$this->db->order_by('add_id','desc');
		$query=$this->db->get('savsoft_add');
		return $query->result_array();
		
	 
 }
 
 function get_edit_advertisment($add_id){
		 $this->db->where('add_id',$add_id);
		 $query=$this->db->get('savsoft_add');
		 return $query->row_array();
	 	} 
	 	
	function update_advertisment($add_id,$new_file_name){
	 
		$userdata=array(
					'advertisement_code'=>$this->input->post('advertisment_code'),
					
					'add_status'=>$this->input->post('add_status'),
					
					'banner_link'=>$this->input->post('banner_link'),
					
					
				);
				if($_FILES['userfile']['name']!=''){
				$userdata['banner']=$new_file_name;
				}
					$this->db->where('add_id',$add_id);
				
					$this->db->update('savsoft_add',$userdata);
					 
			

					} 	
	 	
	 	
	 	
 }
