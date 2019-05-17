<?php
Class Studymaterial_model extends CI_Model
{
 
  function studymaterial_list($limit){
   if($this->input->post('search')){
  // print_r($_POST);die;
		 $search=$this->input->post('search');
		 $this->db->where('study_material.stid',$search);
		 $this->db->or_where('study_material.title',$search);
		        

	 }
	  $logged_in=$this->session->userdata('logged_in');
		
	  $this->db->limit($this->config->item('number_of_rows'),$limit);
		$this->db->order_by('study_material.stid','desc');
		$this->db->join('savsoft_category', 'savsoft_category.cid = study_material.cid', 'left'); 
		$query=$this->db->get('study_material');
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
	
	 	
	 	
	function insert_studymaterial(){
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
		'title'=>$this->input->post('title'),
		'study_description'=>$this->input->post('study_description'),
		'cid'=>$this->input->post('cid'),
		'gids'=>$gids,
		'created_by'=>$logged_in['uid'],
		'attachment'=>$nfilename
		);
		 
	
	if($this->db->insert('study_material',$userdata)){
	
	return true;
	}else{
	
	return false;
	}
	} 	
	 	
	 	
	 function getstudymaterial_view($stid){
	 $this->db->where('study_material.stid',$stid);
	 $this->db->join('savsoft_category', 'savsoft_category.cid = study_material.cid'); 
		$query=$this->db->get('study_material');
		return $query->row_array();
	 
	 }	
	 
	 function remove_studymaterial($stid){
	 $this->db->where('study_material.stid',$stid);
	 if($this->db->delete('study_material')){
	
	return true;
	}else{
	
	return false;
	}
	 
	 }	
	 	
	 	
	function getstudymaterial_edit($stid){
	
	
	 $this->db->where('stid',$stid);
		 $query=$this->db->get('study_material');
		 return $query->row_array();
	
	} 	
	 	
	 function update_studymaterial($stid){
	 
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
		'title'=>$this->input->post('title'),
		'study_description'=>$this->input->post('study_description'),
		'cid'=>$this->input->post('cid'),
		'gids'=>$gids,
		'created_by'=>$logged_in['uid'],
		'attachment'=>$nfilename
		);
		 
	 $this->db->where('stid',$stid);
	if($this->db->update('study_material',$userdata)){
	
	return true;
	}else{
	
	return false;
	}
	 
	 
	 }	
	 	
	 	
	 	
	 	
	 	
	 	
	 	
	 	
	 	
	 	
	 	
	 	
	 	
	 	
	 	
	 	
	 	
	 	
	 	
 }
