<?php
Class Social_model extends CI_Model
{
 
  function social_group_list($limit){
	 	
	   $this->db->limit($this->config->item('number_of_rows'),$limit);
	   if($this->input->post('search')){
	         $this->db->like('sg_name',$this->input->post('search'));
	   }
		 $this->db->order_by('sg_id','desc');
		$query=$this->db->get('social_group');
		return $query->result_array();
		
	 
 }
  function feed($sg_id,$limit){
	 	
	   $this->db->limit($this->config->item('number_of_rows'),$limit);
	    $this->db->where('sg_id',$sg_id);
		 $this->db->order_by('feed_id','desc');
		$query=$this->db->get('news_feed');
		return $query->result_array();
		
	 
 }
 
 function group_member($sg_id){
 
 $this->db->where('sg_id',$sg_id);
 $this->db->join('savsoft_users','savsoft_users.uid=social_group_joined.uid');
 $query=$this->db->get('social_group_joined');
 return $query->result_array();
 }
 
 
 
 
 function add_group(){
 $logged_in=$this->session->userdata('logged_in');
 $uid=$logged_in['uid'];
 $userdata=array(
 'sg_name'=>$this->input->post('sg_name'),
'about'=>$this->input->post('about'),
 'created_by'=>$uid);
 $this->db->insert('social_group',$userdata);
 $sg_id=$this->db->insert_id();
 $userdata=array(
 'sg_id'=>$sg_id,
 'uid'=>$uid);
 $this->db->insert('social_group_joined',$userdata);
 $this->db->query(" update social_group set no_member=(no_member + 1) where sg_id='$sg_id' ");
 
 }
 
function edit_group($sg_id){
 $logged_in=$this->session->userdata('logged_in');
 $uid=$logged_in['uid'];
 $userdata=array(
 'sg_name'=>$this->input->post('sg_name'),
'about'=>$this->input->post('about')
);
$this->db->where('sg_id',$sg_id);
 $this->db->update('social_group',$userdata); 
 }
 
 
 function get_group($sg_id){
  $this->db->where('sg_id',$sg_id);
		$query=$this->db->get('social_group');
		return $query->row_array();
 }
 
 function joined($uid){
 $joinarr=array();
 $this->db->where('uid',$uid);
 $query=$this->db->get('social_group_joined');
 $joined=$query->result_array();
 foreach($joined as $k =>$val){
 $joinarr[]=$val['sg_id'];
 }
 return $joinarr;
 }
 function joined_groups($uid){
 $joinarr=array();
 $this->db->where('uid',$uid);
 $this->db->join('social_group','social_group.sg_id=social_group_joined.sg_id');
 $query=$this->db->get('social_group_joined');
 $joined=$query->result_array();
 foreach($joined as $k =>$val){
 $joinarr[$val['sg_id']]=$val['sg_name'];
 }
 return $joinarr;
 }
 
 function join($sg_id,$uid){
 $this->db->where('sg_id',$sg_id);
 $this->db->where('uid',$uid);
 $query=$this->db->get('social_group_joined');
if($query->num_rows()==0){
 $userdata=array(
 'sg_id'=>$sg_id,
 'uid'=>$uid);
 $this->db->insert('social_group_joined',$userdata);
 $this->db->query(" update social_group set no_member=(no_member + 1) where sg_id='$sg_id' ");
 
  $this->db->where('uid',$uid);
 $query=$this->db->get('savsoft_users');
$user=$query->row_array();
 $feed=$user['first_name'].' '.$user['last_name'].' '.$this->lang->line('sg_join_feed');
  $userdata=array(
  'sg_id'=>$sg_id,
  'feed'=>$feed  
  );
  $this->db->insert('news_feed',$userdata);
 }
 }
 
 

 
 function unjoin($sg_id,$uid){
 $this->db->where('sg_id',$sg_id);
 $this->db->where('uid',$uid);
 $this->db->delete('social_group_joined');
 $this->db->query(" update social_group set no_member=(no_member - 1) where sg_id='$sg_id' ");
   $this->db->where('uid',$uid);
 $query=$this->db->get('savsoft_users');
$user=$query->row_array();
 $feed=$user['first_name'].' '.$user['last_name'].' '.$this->lang->line('sg_unjoin_feed');
  $userdata=array(
  'sg_id'=>$sg_id,
  'feed'=>$feed  
  );
  $this->db->insert('news_feed',$userdata);
 }
 
	
	function remove_social_group($sg_id){
		$this->db->where('sg_id',$sg_id);
		$this->db->delete('social_group');
		return true;
		}				
 
 }
 
