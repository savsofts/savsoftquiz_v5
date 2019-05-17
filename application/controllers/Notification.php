<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends CI_Controller {

	 function __construct()
	 {
	   parent::__construct();
	   $this->load->database();
	   $this->load->helper('url');
	   $this->load->model("notification_model");
	     $this->lang->load('basic', $this->config->item('language'));

	 }

	public function index($limit='0')
	{
		
		// redirect if not loggedin
		if(!$this->session->userdata('logged_in')){
			redirect('login');
			
		}
		$logged_in=$this->session->userdata('logged_in');
		if($logged_in['base_url'] != base_url()){
		$this->session->unset_userdata('logged_in');		
		redirect('login');
		}
		
	 
			
		
		 	 
		$uid=$logged_in['uid'];
$this->db->query("update savsoft_notification set viewed='1' where uid='$uid' ");		
			
	        $data['limit']=$limit;
		$data['title']=$this->lang->line('notification');
		// fetching quiz list
		$data['result']=$this->notification_model->notification_list($limit);
		$this->load->view('header',$data);
		$this->load->view('notification_list',$data);
		$this->load->view('footer',$data);
	}
	
	
	
	public function register_token($device,$uid){
	 if($device=='web'){
	 $userdata=array(
	 'web_token'=>$_POST['currentToken']	 
	 );
	 }else{
	  $userdata=array(
	 'android_token'=>$_POST['currentToken']	 
	 );
	 }
	$this->db->where('uid',$uid);
	$this->db->update('savsoft_users',$userdata);
	
	}
	
	
	
	public function add_new($tuid='0'){
	
	// redirect if not loggedin
		if(!$this->session->userdata('logged_in')){
			redirect('login');
			
		}
		$logged_in=$this->session->userdata('logged_in');
		if($logged_in['base_url'] != base_url()){
		$this->session->unset_userdata('logged_in');		
		redirect('login');
		}
		
                        $acp=explode(',',$logged_in['setting']);
			if(!in_array('All',$acp)){
			exit($this->lang->line('permission_denied'));
			} 
		
	$data['title']=$this->lang->line('send_notification');
	$data['tuid']=$tuid;	
	        $this->load->view('header',$data);
		$this->load->view('new_notification',$data);
		$this->load->view('footer',$data);
	}
	
	
	public function send_notification(){
	
	
	// redirect if not loggedin
		if(!$this->session->userdata('logged_in')){
			redirect('login');
			
		}
		$logged_in=$this->session->userdata('logged_in');
		if($logged_in['base_url'] != base_url()){
		$this->session->unset_userdata('logged_in');		
		redirect('login');
		}
		
                        $acp=explode(',',$logged_in['setting']);
			if(!in_array('All',$acp)){
			exit($this->lang->line('permission_denied'));
			} 
		
	foreach($_POST['notification_to'] as $nk => $nval){
	if($nval != ''){	
	 $fields = array(
            'to' => $nval,
            'icon' => 'logo',
	    'sound'=>'default',
            'data' =>array('message'=> $_POST['message']),
            'notification' =>array('title'=> $_POST['title'],'body'=> $_POST['message'],'click_action'=>$_POST['click_action']),
        );
   // Set POST variables
        $url = 'https://fcm.googleapis.com/fcm/send';
 $firebase_serverkey=$this->config->item('firebase_serverkey');
        $headers = array(
            'Authorization: key='.$firebase_serverkey,
            'Content-Type: application/json'
        );
        // Open connection
        $ch = curl_init();
 
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
 
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
 
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
 
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
 
        // Close connection
        curl_close($ch);
        
        
	
	$this->notification_model->insert_notification($result,$nval);
	}
	}
	  $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('notification_sent')." </div>");
		 
		redirect('notification/index');
	
	}
	
	
	
	
 
	
}
