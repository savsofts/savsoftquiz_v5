<?php
Class Assignment_model extends CI_Model
{
 
  function assignment_list($limit){
   if($this->input->post('search')){
  // print_r($_POST);die;
		 $search=$this->input->post('search');
		 $this->db->where('savsoft_assignment.assignment_id',$search);
		 $this->db->or_where('savsoft_assignment.assignment_title',$search);
		        

	 }
	  $logged_in=$this->session->userdata('logged_in');
		
	  $this->db->limit($this->config->item('number_of_rows'),$limit);
		$this->db->order_by('savsoft_assignment.assignment_id','desc');
		$this->db->join('savsoft_category', 'savsoft_category.cid = savsoft_assignment.cid', 'left'); 
		$query=$this->db->get('savsoft_assignment');
		return $query->result_array();
		
	 
 }
 
 
 
 function getcategory_list(){
		// $this->db->where('add_id',$add_id);
		 $query=$this->db->get('savsoft_category');
		 return $query->result_array();
	 	} 
	 function getgroup_list(){
		
		 $query=$this->db->get('savsoft_group');
		 return $query->result_array();
	 	}  	
	
	 
	 
	 function upload_report($assignment_id){
	 
	 	$gids=implode(',',$this->input->post('gid'));
	$logged_in=$this->session->userdata('logged_in');
	
	$config['upload_path']          = './upload/';
                $config['allowed_types']        = 'gif|jpg|png|pdf|doc|docx|xls|xlsx|mp4|ogg';
                $config['max_size']             = 10000;

                $this->load->library('upload', $config);
$nfilename="";
                if (!$this->upload->do_upload('userfile'))
                {
                         
                }
                else
                {
                       $filedata=$this->upload->data();
                       $filename=$filedata['file_name'];
                       $filenameee=explode('.',$filedata['file_name']);
                       $ext=$filenameee[count($filenameee)-1];
                       $nfilename=time().'.'.$ext;
                       rename('./upload/'.$filename,'./upload/'.$nfilename);
                       
                }
                
                
	$userdata=array(
		'assignment_id'=>$assignment_id,
		'uid'=>$logged_in['uid'],
		 'user_attachment'=>$nfilename,
		 
		);
		 
	
	if($this->db->insert('user_assignment_reports',$userdata)){
	
	return true;
	}else{
	
	return false;
	}
	 }
	 
	 function update_score($report_id){
	 $this->db->where('report_id',$report_id);
	 $score=$this->input->post('score');
	 $this->db->update('user_assignment_reports',array('score'=>$score,'evaluated'=>'Evaluated'));
	 return true;
	 }
	 
	 
	 
	 function uploaded_reports($assignment_id){
	 
	 $logged_in=$this->session->userdata('logged_in');
                        $acp=explode(',',$logged_in['assignment']);
			if(in_array('Add',$acp) || in_array('Edit',$acp)){
			
			
			}else{
	 $this->db->where('user_assignment_reports.uid',$logged_in['uid']);		
			}
	 $this->db->where('user_assignment_reports.assignment_id',$assignment_id);
	 $this->db->join('savsoft_users','savsoft_users.uid=user_assignment_reports.uid');
	 $query=$this->db->get("user_assignment_reports");
	 return $query->result_array();
	 
	 }
	 
	 	
	 	
	function insert_assignment(){
	$gids=implode(',',$this->input->post('gid'));
	$logged_in=$this->session->userdata('logged_in');
	
	$config['upload_path']          = './upload/';
                $config['allowed_types']        = 'gif|jpg|png|pdf|doc|docx|xls|xlsx|mp4|ogg';
                $config['max_size']             = 10000;

                $this->load->library('upload', $config);
$nfilename="";
                if (!$this->upload->do_upload('userfile'))
                {
                         
                }
                else
                {
                       $filedata=$this->upload->data();
                       $filename=$filedata['file_name'];
                       $filenameee=explode('.',$filedata['file_name']);
                       $ext=$filenameee[count($filenameee)-1];
                       $nfilename=time().'.'.$ext;
                       rename('./upload/'.$filename,'./upload/'.$nfilename);
                       
                }
                
                
	$userdata=array(
		'assignment_title'=>$this->input->post('assignment_title'),
		'assignment_description'=>$this->input->post('assignment_description'),
		'cid'=>$this->input->post('cid'),
		'due_date'=>$this->input->post('due_date'),
		'gids'=>$gids,
		'attachments'=>$nfilename,
		'created_by'=>$logged_in['uid'],
		);
		 
	
	if($this->db->insert('savsoft_assignment',$userdata)){
	
	return true;
	}else{
	
	return false;
	}
	} 	
	 	
	 	
	 function getassignment_view($assignment_id){
	 $this->db->where('savsoft_assignment.assignment_id',$assignment_id);
	 $this->db->join('savsoft_category', 'savsoft_category.cid = savsoft_assignment.cid'); 
		$query=$this->db->get('savsoft_assignment');
		return $query->row_array();
	 
	 }	
	 
	 function remove_assignment($assignment_id){
	 $this->db->where('savsoft_assignment.assignment_id',$assignment_id);
	 if($this->db->delete('savsoft_assignment')){
	
	return true;
	}else{
	
	return false;
	}
	 
	 }	
	 	
	 	
	function getassignment_edit($assignment_id){
	
	
	 $this->db->where('assignment_id',$assignment_id);
		 $query=$this->db->get('savsoft_assignment');
		 return $query->row_array();
	
	} 	
	 	
	 function update_assignment($assignment_id){
	 
	 $gids=implode(',',$this->input->post('gid'));
	$logged_in=$this->session->userdata('logged_in');
		$config['upload_path']          = './upload/';
                $config['allowed_types']        = 'gif|jpg|png|pdf|doc|docx|xls|xlsx|mp4|ogg';
                $config['max_size']             = 10000;

                $this->load->library('upload', $config);
$nfilename="";
                if (!$this->upload->do_upload('userfile'))
                {
                         
                }
                else
                {
                       $filedata=$this->upload->data();
                       $filename=$filedata['file_name'];
                       $filenameee=explode('.',$filedata['file_name']);
                       $ext=$filenameee[count($filenameee)-1];
                       $nfilename=time().'.'.$ext;
                       rename('./upload/'.$filename,'./upload/'.$nfilename);
                       
                }
                
	$userdata=array(
		'assignment_title'=>$this->input->post('assignment_title'),
		'assignment_description'=>$this->input->post('assignment_description'),
		'cid'=>$this->input->post('cid'),
		'due_date'=>$this->input->post('due_date'),
		'gids'=>$gids,
		'attachments'=>$nfilename,
		);
		 
	 $this->db->where('assignment_id',$assignment_id);
	if($this->db->update('savsoft_assignment',$userdata)){
	
	return true;
	}else{
	
	return false;
	}
	 
	 
	 }	
	 	
	 	
	 	
	 	
	 	
	 	
	 	
	 	
	 	
	 	
	 	
	 	
	 	
	 	
	 	
	 	
	 	
	 	
	 	
 }
