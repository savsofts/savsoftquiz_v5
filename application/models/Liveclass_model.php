<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Liveclass_model extends CI_Model {

  function __construct()
  {
    // Call the Model constructor
    parent::__construct();
    $this->load->database();
  } 
  
  
  
  
   public function active_classroom($limit)
			 {
					$this->db->where("closed_time","0");
					$this->db->order_by("initiated_time","ASC");
					$this -> db -> limit($this->config->item('number_of_rows'),$limit);
					$query=$this->db->get("live_class");
					return $query->result_array();
			 }	
  
  
  
  public function validategid($gid,$class_id){
          $this->db->where("gid",$gid);
          $this->db->where("class_id",$class_id);
          $query=$this->db->get("class_gid");
         if($query->num_rows()==0){
          return false;
          }else{
          return true;
          }
  }
  
    public function closed_classroom($limit)
			 {
					$this->db->where("closed_time !=","0");
					$this->db->order_by("closed_time","ASC");
					$this -> db -> limit($this->config->item('number_of_rows'),$limit);
					$query=$this->db->get("live_class");
					return $query->result_array();
			 }	
			 
	public function insert_classroom(){
			$logged_in =$this->session->userdata('logged_in');
			$uid= $logged_in['uid'];
			$userdata=array(
			'class_name'=>$this->input->post('class_name'),
			'initiated_by'=>$uid,
			'initiated_time'=>strtotime($this->input->post('start_time'))
			);
			$this->db->insert('live_class',$userdata);
			$class_id=$this->db->insert_id();
			foreach($this->input->post('assigned_groups') as $key => $gid){
			$userdata=array(
			'class_id'=>$class_id,
			'gid'=>$gid
			);
			$this->db->insert('class_gid',$userdata);
			}
	return $class_id;
	}
  
  	public function update_classroom($class_id){
			$logged_in =$this->session->userdata('logged_in');
			$uid= $logged_in['uid'];
			$userdata=array(
			'class_name'=>$this->input->post('class_name'),
			'initiated_time'=>strtotime($this->input->post('start_time'))
			);
			$this->db->where("class_id",$class_id);
			$this->db->update('live_class',$userdata);
		
			$this->db->where("class_id",$class_id);
			$this->db->delete('class_gid');
			
			
			foreach($this->input->post('assigned_groups') as $key => $gid){
			$userdata=array(
			'class_id'=>$class_id,
			'gid'=>$gid
			);
			$this->db->insert('class_gid',$userdata);
			}
	return $class_id;
	}
  
  function insert_content($class_id){
  $cont=$this->input->post('content');
  			$userdata=array(
			'content'=>$cont
			);
			$this->db->where("class_id",$class_id);
			$this->db->update('live_class',$userdata);
  
  }
  
  function insert_comnt($class_id){
   $comnt=$this->input->post('content');
   $generated_time=time();
   $logged_in =$this->session->userdata('logged_in');
   $uid= $logged_in['uid'];
   $userdata=array(
			'generated_time'=>$generated_time,
			'content'=>$comnt,
			'content_by'=>$uid,
			'class_id'=>$class_id
			);
			if($logged_in['su']=="1"){
			$userdata['published']="1";
			}
			$this->db->insert('class_coment',$userdata);
  }
  
  
  public function assigned_groups($class_id){
					$this->db->where("class_id",$class_id);
					$query=$this->db->get("class_gid");
   if($query -> num_rows() >= 1)
   {
     $resultdata=$query->result();
     $gids=array();
     foreach($resultdata as $value){
     $gids[]=$value->gid;
     }
     return $gids;
   }
   else
   {
     return array('0');
   }
  
  }
  
   public function get_class($class_id)
			 {
					$this->db->where("class_id",$class_id);
					$query=$this->db->get("live_class");
					return $query->row_array();
			 }	
			 
  
 public function get_coment($class_id)
			 {
			 $logged_in =$this->session->userdata('logged_in');
			 $uid=$logged_in['uid'];
			if($logged_in['su']!="1"){
				$this->db->where("class_coment.published",1);
				$this->db->or_where('class_coment.content_by', $uid); 
			
			}
			
					$this->db->where("class_coment.class_id",$class_id);
					$this->db->join("savsoft_users","savsoft_users.uid=class_coment.content_by");
					$query=$this->db->get("class_coment");
					//print_r($this->db->last_query());
					return $query->result_array();
			 }	
			 
			 
  public function remove_classroom($class_id){
  
  		$this->db->where("class_id",$class_id);
			$this->db->delete('live_class');
		
			$this->db->where("class_id",$class_id);
			$this->db->delete('class_gid');
			
  }
  
    public function close_classroom($class_id){
  
  		$this->db->where("class_id",$class_id);
			$this->db->update('live_class',array('closed_time'=>time()));
			
  }
  
  
   function del_coment(){
    $comnt_id=$this->input->post('id');
	$this->db->where("content_id",$comnt_id);
			$this->db->delete('class_coment');
   }
   
   function publish_comnt(){
   $pub_id=$this->input->post('pub');
  // echo $pub_id; 

   
    $comnt_id=$this->input->post('id');
	$data = array(
               'published' =>$pub_id
            );

$this->db->where('content_id', $comnt_id);
$this->db->update('class_coment', $data); 
	//return;
   }
  
  
  }?>
