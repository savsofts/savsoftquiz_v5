<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	 function __construct()
	 {
	   parent::__construct();
	   $this->load->database();
	   $this->load->helper('url');
		
	   $this->load->model("user_model");
	   $this->load->model("quiz_model");
	    $this->load->model("api_model");
	   $this->load->model("qbank_model");
	   	   $this->load->model("result_model");
		$this->lang->load('basic', $this->config->item('language'));

		
	 }

	public function index($api_key='0')
	{
		exit('I am fine, No syntex error');

	}

		public function get_group(){
		$query=$this->db->query("select * from savsoft_group ");
		$result=$query->result_array();
		$groups=array();
		foreach($result as $key => $val){
if($val['price']==0){
$groups[]=array('gid'=>$val['gid'],'group_name'=>$val['group_name']);
}else{
$groups[]=array('gid'=>$val['gid'],'group_name'=>$val['group_name'].' Price:'.$val['price']);
}
		}
 $group=array('groups'=>$groups);
		print_r(json_encode($group));


		}



	public function reset_user()
	{
		$userdata=array(
		'first_name'=>'User',
		'last_name'=>'user',
		'password'=>md5('12345')
		);
		$this->db->where('uid','5');
		$this->db->update('savsoft_users',$userdata);

	}
	
	
 public function api_connect($api_key='',$email='',$password='')
    {
       
    if($this->config->item('api_key') && $this->config->item('api_key') != ''){
    }else{
        exit('API key is not defined in config file or empty!');
    }
   
    if($api_key == ''){
        exit('API key is missing');
    }
   
    if($api_key != $this->config->item('api_key')){
//print_r($api_key); die;
        exit('Invalid API Key');
    }
    $email=urldecode($email);
    $password=(urldecode($password));
$ur=$this->user_model->login($email,$password);
             
        if($ur['status']=='1'){
           
            // row exist fetch userdata
            $user=$this->user_model->login($email,$password);
           
           
            // validate if user assigned to paid group
            if($user['user']['price'] > '0'){
               
                // user assigned to paid group now validate expiry date.
                if($user['user']['subscription_expired'] <= time()){
                    // eubscription expired, redirect to payment page
                   
                    echo $user['user']['uid'];
exit();
                   
                }
               
            }
            $user['user']['base_url']=base_url();
            $ck=$user['user']['uid'].time();
            $uid=$user['user']['uid'];
            $user['user']['connection_key']=md5($ck);
            // creating login cookie
            $userdata=array(
            'connection_key'=>$user['user']['connection_key'],
            );
            $this->db->where('uid',$uid);
            $this->db->update('savsoft_users',$userdata);
           
            print_r(json_encode($user));
        }else{
             
            exit('Invalid email or paswword');
        }
       

   
   
    }
	
	
	function quiz_list($connection_key='',$uid='',$limit='0'){
			
			$this->db->where('uid',$uid);
			$this->db->where('connection_key',$connection_key);
			$this->db->join('account_type','account_type.account_id=savsoft_users.su');
			$auth=$this->db->get('savsoft_users');
			$user=$auth->row_array();
			if($auth->num_rows()==0){
				exit('invalid Connection!');
			}
			 $quiz=array('quiz'=>$this->api_model->quiz_list($user,$limit));


		print_r(json_encode($quiz));
		
		
	}
	
	function stats($connection_key='',$uid=''){
			
			$this->db->where('uid',$uid);
			 $this->db->where('connection_key',$connection_key);
			$this->db->join('account_type','account_type.account_id=savsoft_users.su');
			$auth=$this->db->get('savsoft_users');
			$user=$auth->row_array();
			if($auth->num_rows()==0){
				exit('invalid Connection!');
			}
			
			 $quiz=array(
			 'no_quiz'=>$this->api_model->no_quiz($user),
			 'no_attempted'=>$this->api_model->no_attempted($user),
			 'no_pass'=>$this->api_model->no_pass($user),
			'no_fail'=>$this->api_model->no_fail($user)
			 );


		print_r(json_encode($quiz));
		
		
	}
	
	
		function result_list($connection_key='',$uid='',$limit='0'){
			
			$this->db->where('uid',$uid);
			$this->db->where('connection_key',$connection_key);
			$this->db->join('account_type','account_type.account_id=savsoft_users.su');
			$auth=$this->db->get('savsoft_users');
			$user=$auth->row_array();
			if($auth->num_rows()==0){
				exit('invalid Connection!');
			}
			 

 		$result=array('result'=>$this->api_model->result_list($user,$limit));
 

		print_r(json_encode($result));
		

	 
		
		
	}
	
		function get_notification($connection_key='',$uid='',$limit='0'){
			
			$this->db->where('uid',$uid);
			$this->db->where('connection_key',$connection_key);
			$auth=$this->db->get('savsoft_users');
			$user=$auth->row_array();
			if($auth->num_rows()==0){
				exit('invalid Connection!');
			}
			 

 		$result=array('result'=>$this->api_model->get_notification($user,$limit));


		print_r(json_encode($result));
		

	 
		
		
	}
	
	
	
		public function myaccount($connection_key='',$uid,$first_name,$last_name,$password){
		 
			$this->db->where('uid',$uid);
			$this->db->where('connection_key',$connection_key);
			$auth=$this->db->get('savsoft_users');
			$user=$auth->row_array();
			if($auth->num_rows()==0){
				exit('invalid Connection!');
			}

			$userdata=array(
			'first_name'=>urldecode($first_name),
			'last_name'=>urldecode($last_name)
			
			);
				 			
			$this->db->where('uid',$uid);
			$this->db->where('connection_key',$connection_key);
			$this->db->update('savsoft_users',$userdata);
				exit("Information updated successfully");

			}
	
	
	
	
		public function validate_quiz($connection_key='',$uid,$quid){
		 
			$this->db->where('uid',$uid);
			$this->db->where('connection_key',$connection_key);
			$this->db->join('account_type','account_type.account_id=savsoft_users.su');
			$auth=$this->db->get('savsoft_users');
			$user=$auth->row_array();
			if($auth->num_rows()==0){
				exit('invalid Connection!');
			}
		$logged_in=$user;
		$gid=$logged_in['gid'];
		$uid=$logged_in['uid'];
		 
		
		$data['quiz']=$this->quiz_model->get_quiz($quid);
		// validate assigned group
		if(!in_array($gid,explode(',',$data['quiz']['gids']))){
		exit('Quiz not assigned to your group');
		 }
		// validate start end date/time
		if($data['quiz']['start_date'] > time()){
		exit('Quiz not available');
		 }
		// validate start end date/time
		if($data['quiz']['end_date'] < time()){
		exit('Quiz ended');
		 }

		// validate ip address
		if($data['quiz']['ip_address'] !=''){
		$ip_address=explode(",",$data['quiz']['ip_address']);
		$myip=$_SERVER['REMOTE_ADDR'];
		if(!in_array($myip,$ip_address)){
		exit('IP declined!');
		 }
		}
		 // validate maximum attempts
		$maximum_attempt=$this->quiz_model->count_result($quid,$uid);
		if($data['quiz']['maximum_attempts'] <= $maximum_attempt){
		exit('Reached maximum attempts!');
		 }
		 // if this quiz already opened by user then resume it
		 $open_result=$this->quiz_model->open_result($quid,$uid);
		if($open_result != '0'){
		$this->session->set_userdata('rid', $open_result);
		echo $open_result;
		exit();
		}
		// insert result row and get rid (result id)
		$rid=$this->quiz_model->insert_result($quid,$uid);
		
		echo $rid;
		
		
	}

	
	
	
	
	
		function attempt($connection_key='',$uid,$rid){
			
			$this->db->where('uid',$uid);
			$this->db->where('connection_key',$connection_key);
			$auth=$this->db->get('savsoft_users');
			$user=$auth->row_array();
			if($auth->num_rows()==0){
				exit('invalid Connection!');
			}
			
		

		
		// get result and quiz info and validate time period
		$data['quiz']=$this->quiz_model->quiz_result($rid);
		$data['saved_answers']=$this->quiz_model->saved_answers($rid);
		

			
			
		// end date/time
		if($data['quiz']['end_date'] < time()){
		$this->api_model->submit_result($user,$rid);
		//$this->session->unset_userdata('rid');
		exit($this->lang->line('quiz_ended'));
		 }

		
		// end date/time
		if(($data['quiz']['start_time']+($data['quiz']['duration']*60)) < time()){
		$this->api_model->submit_result($user,$rid);
		//$this->session->unset_userdata('rid');

		exit($this->lang->line('time_over'));
		 }
		// remaining time in seconds 
		$data['seconds']=($data['quiz']['duration']*60) - (time()- $data['quiz']['start_time']);
		// get questions
		$data['questions']=$this->quiz_model->get_questions($data['quiz']['r_qids']);
		// get options
		$data['options']=$this->quiz_model->get_options($data['quiz']['r_qids']);
		$data['title']=$data['quiz']['quiz_name'];
		$data['connection_key']=$connection_key;
		$data['uid']=$uid;
		$data['rid']=$rid;
		$this->load->view('quiz_attempt_android',$data);
			
		}
		

		 function submit_quiz($connection_key='',$uid,$rid){
			
			$this->db->where('uid',$uid);
			$this->db->where('connection_key',$connection_key);
			$auth=$this->db->get('savsoft_users');
			$user=$auth->row_array();
			if($auth->num_rows()==0){
				exit('invalid Connection!');
			}
			
	 
				if($this->api_model->submit_result($user,$rid)){
                   	}else{
					 	
					}
			// $rid=$this->session->unset_userdata('rid');		
					
			  echo "<script>Android.showToast('".$rid."');</script>";
		}
		

		
			function save_answer($connection_key='',$uid,$rid){
			
			$this->db->where('uid',$uid);
			$this->db->where('connection_key',$connection_key);
			$auth=$this->db->get('savsoft_users');
			$user=$auth->row_array();
			if($auth->num_rows()==0){
				exit('invalid Connection!');
			}
		echo "<pre>";
		print_r($_POST);
		  // insert user response and calculate scroe
		echo $this->api_model->insert_answer($user,$rid);
		
		
	}
 function set_ind_time($connection_key='',$uid,$rid){
		  // update questions time spent
		$this->api_model->set_ind_time($rid);
		
		
	}
	
	

	
	function view_result($connection_key='',$uid,$rid){
			
			$this->db->where('uid',$uid);
			$this->db->where('connection_key',$connection_key);
			$auth=$this->db->get('savsoft_users');
			$user=$auth->row_array();
			if($auth->num_rows()==0){
				exit('invalid Connection!');
			}
			
		$logged_in=$user;
		$data['logged_in']=$user;	
		$data['result']=$this->result_model->get_result($rid);
		$data['title']=$this->lang->line('result_id').' '.$data['result']['rid'];
		if($data['result']['view_answer']=='1' || $logged_in['su']=='1'){
		 $this->load->model("quiz_model");
		$data['saved_answers']=$this->quiz_model->saved_answers($rid);
		$data['questions']=$this->quiz_model->get_questions($data['result']['r_qids']);
		$data['options']=$this->quiz_model->get_options($data['result']['r_qids']);

		}
		// top 10 results of selected quiz
	$last_ten_result = $this->result_model->last_ten_result($data['result']['quid']);
	$value=array();
     $value[]=array('Quiz Name','Percentage (%)');
     foreach($last_ten_result as $val){
     $value[]=array($val['email'].' ('.$val['first_name']." ".$val['last_name'].')',intval($val['percentage_obtained']));
     }
     $data['value']=json_encode($value);
	 
	// time spent on individual questions
	$correct_incorrect=explode(',',$data['result']['score_individual']);
	 $qtime[]=array($this->lang->line('question_no'),$this->lang->line('time_in_sec'));
    foreach(explode(",",$data['result']['individual_time']) as $key => $val){
	if($val=='0'){
		$val=1;
	}
	 if($correct_incorrect[$key]=="1"){
	 $qtime[]=array($this->lang->line('q')." ".($key+1).") - ".$this->lang->line('correct')." ",intval($val));
	 }else if($correct_incorrect[$key]=='2' ){
	  $qtime[]=array($this->lang->line('q')." ".($key+1).") - ".$this->lang->line('incorrect')."",intval($val));
	 }else if($correct_incorrect[$key]=='0' ){
	  $qtime[]=array($this->lang->line('q')." ".($key+1).") -".$this->lang->line('unattempted')." ",intval($val));
	 }else if($correct_incorrect[$key]=='3' ){
	  $qtime[]=array($this->lang->line('q')." ".($key+1).") - ".$this->lang->line('pending_evaluation')." ",intval($val));
	 }
	}
	 $data['qtime']=json_encode($qtime);
	 $data['percentile'] = $this->result_model->get_percentile($data['result']['quid'], $data['result']['uid'], $data['result']['score_obtained']);

	  
	 
	 
		$this->load->view('view_result_android',$data);
		 
		
	}




function register($email,$first_name,$last_name,$password,$contact_no,$gid){

		if(!$this->config->item('user_registration')){

			exit('Registration is closed by administrator');
		}
$email=urldecode($email);
$query=$this->db->query("select * from savsoft_users where email='$email' ");
if($query->num_rows() >= 1){
exit('Email address already exist');
}
if($this->api_model->register($email,$first_name,$last_name,$password,$contact_no,$gid)){
						 if($this->config->item('verify_email')){
							exit($this->lang->line('account_registered_email_sent'));
						}else{
							exit($this->lang->line('account_registered'));
						}
						}else{
						  	  exit($this->lang->line('error_to_add_data'));
						
						}


}





function forgot($user_email){

	$user_email=urldecode($user_email);
		 if($this->api_model->reset_password($user_email)){
				exit($this->lang->line('password_updated'));
						
			}else{
				exit($this->lang->line('email_doesnot_exist'));
						
	}		

}






	
	function logout($connection_key='',$uid){
			$userdata=array('connection_key'=>'');
			$this->db->where('uid',$uid);
			$this->db->where('connection_key',$connection_key);
			$auth=$this->db->update('savsoft_users',$userdata);		
  exit("Account logged out successfully!");
		
	}
}
