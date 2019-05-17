<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quiz extends CI_Controller {

	 function __construct()
	 {
	   parent::__construct();
	   $this->load->database();
	   $this->load->helper('url');
	   $this->load->model("quiz_model");
	   $this->load->model("user_model");
	   $this->lang->load('basic', $this->config->item('language'));

	 }

	public function index($limit='0',$list_view='grid',$stat='')
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
		
		
		
		 	
			$logged_in=$this->session->userdata('logged_in');
                        $setting_p=explode(',',$logged_in['quiz']);
			if(in_array('List',$setting_p) || in_array('List_all',$setting_p)){
			
			}else{
			exit($this->lang->line('permission_denied'));
			}
			 
			
			
		$data['list_view']=$list_view;
		$data['limit']=$limit;
		$data['title']=$this->lang->line('quiz');
		// fetching quiz list
		$data['purchased_quiz']=$this->quiz_model->get_purchased_quiz();
		$data['result']=$this->quiz_model->quiz_list($limit,$stat);
	 	$data['archived']=$this->quiz_model->quizstat('archived');
		$data['active']=$this->quiz_model->quizstat('active');
		$data['upcoming']=$this->quiz_model->quizstat('upcoming');
		 $data['stat']=$stat;
		$this->load->view('header',$data);
		$this->load->view('quiz_list',$data);
		$this->load->view('footer',$data);
	}
	
	
	
function open_quiz($limit='0'){
	if(!$this->config->item('open_quiz')){
		exit();
	}
		$data['limit']=$limit;
		$data['title']=$this->lang->line('quiz');
		$data['open_quiz']=$this->quiz_model->open_quiz($limit);
		
		$this->load->view('header',$data);
		$this->load->view('open_quiz',$data);
		$this->load->view('footer',$data);
	
}



	public function add_new()
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
		
			$logged_in=$this->session->userdata('logged_in');
                        $acp=explode(',',$logged_in['quiz']);
			if(!in_array('Add',$acp)){
			exit($this->lang->line('permission_denied'));
			}	
	 
		$data['title']=$this->lang->line('add_new').' '.$this->lang->line('quiz');
		// fetching group list
		$data['group_list']=$this->user_model->group_list();
		$data['user_list']=$this->user_model->user_list_all();
		$this->load->view('header',$data);
		$this->load->view('new_quiz',$data);
		$this->load->view('footer',$data);
	}
	
		
		
	
	
	
	
	
	
	
		public function edit_quiz($quid)
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
		
			$logged_in=$this->session->userdata('logged_in');
                        $acp=explode(',',$logged_in['quiz']);
			if(!in_array('Edit',$acp)){
			exit($this->lang->line('permission_denied'));
			}
			
			
	 
		$data['title']=$this->lang->line('edit').' '.$this->lang->line('quiz');
		// fetching group list
		$data['group_list']=$this->user_model->group_list();
		$data['user_list']=$this->user_model->user_list_all();
		$data['quiz']=$this->quiz_model->get_quiz($quid);
		if($data['quiz']['question_selection']=='0'){
		$data['questions']=$this->quiz_model->get_questions($data['quiz']['qids']);
			 
		}else{
			$this->load->model("qbank_model");
	   $data['qcl']=$this->quiz_model->get_qcl($data['quiz']['quid']);
		
			 $data['category_list']=$this->qbank_model->category_list();
		 $data['level_list']=$this->qbank_model->level_list();
		
		}
		$this->load->view('header',$data);
		$this->load->view('edit_quiz',$data);
		$this->load->view('footer',$data);
	}
	
	
	
	
	function no_q_available($cid,$lid){
		$val="<select name='noq[]'>";
		$query=$this->db->query(" select * from savsoft_qbank where cid='$cid' and lid='$lid' ");
		$nor=$query->num_rows();
		for($i=0; $i<= $nor; $i++){
			$val.="<option value='".$i."' >".$i."</option>";
			
			
		}
		$val.="</select>";
		echo $val;
		
	}
	
	
	
	
	function remove_qid($quid,$qid){
				// redirect if not loggedin
		if(!$this->session->userdata('logged_in')){
			redirect('login');
			
		}
		$logged_in=$this->session->userdata('logged_in');
		if($logged_in['base_url'] != base_url()){
		$this->session->unset_userdata('logged_in');		
		redirect('login');
		}
		
		if($this->quiz_model->remove_qid($quid,$qid)){
                        $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('removed_successfully')." </div>");
		}
		redirect('quiz/edit_quiz/'.$quid);
	}
	
	function add_qid($quid,$qid){
				// redirect if not loggedin
		if(!$this->session->userdata('logged_in')){
			redirect('login');
			
		}
		$logged_in=$this->session->userdata('logged_in');
		if($logged_in['base_url'] != base_url()){
		$this->session->unset_userdata('logged_in');		
		redirect('login');
		}
		
		 $this->quiz_model->add_qid($quid,$qid);
          echo 'added';              
	}
	
	
	
	function pre_add_question($quid,$limit='0',$cid='0',$lid='0'){
				// redirect if not loggedin
		if(!$this->session->userdata('logged_in')){
			redirect('login');
			
		}
		$logged_in=$this->session->userdata('logged_in');
		if($logged_in['base_url'] != base_url()){
		$this->session->unset_userdata('logged_in');		
		redirect('login');
		}
		$cid=$this->input->post('cid');
		$lid=$this->input->post('lid');
		redirect('quiz/add_question/'.$quid.'/'.$limit.'/'.$cid.'/'.$lid);
	}
	
	
	
		public function add_question($quid,$limit='0',$cid='0',$lid='0')
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

		$this->load->model("qbank_model");
	   
		
		$logged_in=$this->session->userdata('logged_in');
			if($logged_in['su']!='1'){
			exit($this->lang->line('permission_denied'));
			}
			
			
	 
		 $data['quiz']=$this->quiz_model->get_quiz($quid);
		$data['title']=$this->lang->line('add_question_into_quiz').': '.$data['quiz']['quiz_name'];
		if($data['quiz']['question_selection']=='0'){
		
		$data['result']=$this->qbank_model->question_list($limit,$cid,$lid);
		 $data['category_list']=$this->qbank_model->category_list();
		 $data['level_list']=$this->qbank_model->level_list();
			 
		}else{
			
			exit($this->lang->line('permission_denied'));
		}
		$data['limit']=$limit;
		$data['cid']=$cid;
		$data['lid']=$lid;
		$data['quid']=$quid;
		
		$this->load->view('header',$data);
		$this->load->view('add_question_into_quiz',$data);
		$this->load->view('footer',$data);
	}
	
	
	
	
	function up_question($quid,$qid,$not='1'){
				// redirect if not loggedin
		if(!$this->session->userdata('logged_in')){
			redirect('login');
			
		}
		$logged_in=$this->session->userdata('logged_in');
		if($logged_in['base_url'] != base_url()){
		$this->session->unset_userdata('logged_in');		
		redirect('login');
		}


		$logged_in=$this->session->userdata('logged_in');
	if($logged_in['su']!="1"){
	exit($this->lang->line('permission_denied'));
	return;
	}		
	for($i=1; $i <= $not; $i++){
	$this->quiz_model->up_question($quid,$qid);
	}
	redirect('quiz/edit_quiz/'.$quid, 'refresh');
	}
	
	
	
	
	
	
	function down_question($quid,$qid,$not='1'){
				// redirect if not loggedin
		if(!$this->session->userdata('logged_in')){
			redirect('login');
			
		}
		$logged_in=$this->session->userdata('logged_in');
		if($logged_in['base_url'] != base_url()){
		$this->session->unset_userdata('logged_in');		
		redirect('login');
		}


		$logged_in=$this->session->userdata('logged_in');
	if($logged_in['su']!="1"){
	exit($this->lang->line('permission_denied'));
	return;
	}	
			for($i=1; $i <= $not; $i++){
	$this->quiz_model->down_question($quid,$qid);
	}
	redirect('quiz/edit_quiz/'.$quid, 'refresh');
	}
	
	
	
	
		public function insert_quiz()
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
		
	 
	
	
		
			$logged_in=$this->session->userdata('logged_in');
                        $acp=explode(',',$logged_in['quiz']);
			if(!in_array('Add',$acp)){
			exit($this->lang->line('permission_denied'));
			}
			
			
			
		$this->load->library('form_validation');
		$this->form_validation->set_rules('quiz_name', 'quiz_name', 'required');
           if ($this->form_validation->run() == FALSE)
                {
                     $this->session->set_flashdata('message', "<div class='alert alert-danger'>".validation_errors()." </div>");
					redirect('quiz/add_new/');
                }
                else
                {
					$quid=$this->quiz_model->insert_quiz();
                   $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('quiz_created')." </div>");
		  $this->session->set_flashdata('addquestion', "<div class='alert alert-success'>".$this->lang->line('quiz_created')." </div>");
					redirect('quiz/edit_quiz/'.$quid);
                }       

	}
	
		public function update_quiz($quid)
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
		
		
			$logged_in=$this->session->userdata('logged_in');
                        $acp=explode(',',$logged_in['quiz']);
			if(!in_array('Edit',$acp)){
			exit($this->lang->line('permission_denied'));
			}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('quiz_name', 'quiz_name', 'required');
           if ($this->form_validation->run() == FALSE)
                {
                     $this->session->set_flashdata('message', "<div class='alert alert-danger'>".validation_errors()." </div>");
					redirect('quiz/edit_quiz/'.$quid);
                }
                else
                {
					$quid=$this->quiz_model->update_quiz($quid);
                   
					redirect('quiz/edit_quiz/'.$quid);
                }       

	}
	
	
	
	

	
	
	
	
	
	
	public function remove_quiz($quid){
				// redirect if not loggedin
		if(!$this->session->userdata('logged_in')){
			redirect('login');
			
		}
		$logged_in=$this->session->userdata('logged_in');
		if($logged_in['base_url'] != base_url()){
		$this->session->unset_userdata('logged_in');		
		redirect('login');
		}

			$logged_in=$this->session->userdata('logged_in');
                        $acp=explode(',',$logged_in['quiz']);
			if(!in_array('Remove',$acp)){
			exit($this->lang->line('permission_denied'));
			}
			if($this->quiz_model->remove_quiz($quid)){
                        $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('removed_successfully')." </div>");
					}else{
						    $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('error_to_remove')." </div>");
						
					}
					redirect('quiz');
                     
			
		}
	



	public function quiz_detail($quid){
				// redirect if not loggedin
 
		
		//$logged_in=$this->session->userdata('logged_in');
			$logged_in=$this->session->userdata('logged_in');
                        $acp=explode(',',$logged_in['quiz']);
			if(!in_array('View',$acp)){
				$data['quiz']=$this->quiz_model->get_quiz($quid);
	
			    if($data['quiz']['with_login'] == 1){
			exit($this->lang->line('permission_denied'));
			}
			}
		$gid=$logged_in['gid'];
		$data['title']=$this->lang->line('attempt').' '.$this->lang->line('quiz');
		
		$data['quiz']=$this->quiz_model->get_quiz($quid);
		$this->load->view('header',$data);
		$this->load->view('quiz_detail',$data);
		$this->load->view('footer',$data);
		
	}
	
	public function proctor($quid,$rid=0){
				// redirect if not loggedin
 
		
		//$logged_in=$this->session->userdata('logged_in');
			$logged_in=$this->session->userdata('logged_in');
                        $acp=explode(',',$logged_in['quiz']);
			if(!in_array('View',$acp)){
				$data['quiz']=$this->quiz_model->get_quiz($quid);
	
			    if($data['quiz']['with_login'] == 1){
			exit($this->lang->line('permission_denied'));
			}
			}
		$gid=$logged_in['gid'];
		$data['title']=$this->lang->line('proctor').' '.$this->lang->line('quiz');
		$data['rid']=$rid;
		$data['quiz']=$this->quiz_model->get_quiz($quid);
		$this->load->view('header',$data);
		$this->load->view('vproctor',$data);
		$this->load->view('footer',$data);
		
	}
	
	public function validate_quiz($quid){
	$selected_lang=0;
	if($this->input->post('selected_lang')){
	$selected_lang=$this->input->post('selected_lang');
	}
			$logged_in=$this->session->userdata('logged_in');
                        $acp=explode(',',$logged_in['quiz']);
			if(!in_array('Attempt',$acp)){
				$data['quiz']=$this->quiz_model->get_quiz($quid);
	
			    if($data['quiz']['with_login'] == 1){
			exit($this->lang->line('permission_denied'));
			}
			}
		$data['quiz']=$this->quiz_model->get_quiz($quid);
		// if it is without login quiz.
		if($data['quiz']['with_login']==0 && !$this->session->userdata('logged_in')){
		if($this->session->userdata('logged_in_raw')){
		$logged_in=$this->session->userdata('logged_in_raw');
		}else{
			
		$userdata=array(
		'email'=>time(),
		'password'=>md5(rand(11111,99999)),
		'first_name'=>'Guest User',
		'last_name'=>time(),
		'contact_no'=>'',
		'gid'=>$this->config->item('default_gid'),
		'su'=>'0'		
		);
		$this->db->insert('savsoft_users',$userdata);
		$uid=$this->db->insert_id();
		$query=$this->db->query("select * from savsoft_users where uid='$uid' ");
		$user=$query->row_array();
		// creating login cookie
		$user['base_url']=base_url();
		$this->session->set_userdata('logged_in_raw', $user);
		$logged_in=$user;
		}		
		
		
		$gid=$logged_in['gid'];
		$uid=$logged_in['uid'];
		 
		 // if this quiz already opened by user then resume it
		 $open_result=$this->quiz_model->open_result($quid,$uid);
		 if($open_result != '0'){
		// $this->session->set_userdata('rid', $open_result);
		redirect('quiz/resume_pending/'.$open_result);
		 	
		}
		$data['quiz']=$this->quiz_model->get_quiz($quid);

		// validate start end date/time
		if($data['quiz']['start_date'] > time()){
		$this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_not_available')." </div>");
		redirect('quiz/quiz_detail/'.$quid);
		 }
		// validate start end date/time
		if($data['quiz']['end_date'] < time()){
		$this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_ended')." </div>");
		redirect('quiz/quiz_detail/'.$quid);
		 }


		
		// insert result row and get rid (result id)
		$rid=$this->quiz_model->insert_result($quid,$uid);
		
		$this->session->set_userdata('rid', $rid);
		redirect('quiz/attempt/'.$rid.'/'.$selected_lang);	














		
		// without login ends

		
		}else{
		// with login starts
				// redirect if not loggedin
		if(!$this->session->userdata('logged_in')){
			$this->session->set_flashdata('message', $this->lang->line('login_required2'));
			
			redirect('login');
			
		}
		$logged_in=$this->session->userdata('logged_in');
		if($logged_in['base_url'] != base_url()){
		$this->session->unset_userdata('logged_in');		
		redirect('login');
		}
		 
		
		
		$logged_in=$this->session->userdata('logged_in');
		
		
		$gid=$logged_in['gid'];
		$uid=$logged_in['uid'];
		 
		 // if this quiz already opened by user then resume it
		 $open_result=$this->quiz_model->open_result($quid,$uid);
		 if($open_result != '0'){
		// $this->session->set_userdata('rid', $open_result);
		redirect('quiz/resume_pending/'.$open_result);
		 	
		}
		$data['quiz']=$this->quiz_model->get_quiz($quid);
		// validate assigned group
		if(!in_array($gid,explode(',',$data['quiz']['gids']))){
			if(!in_array($uid,explode(',',$data['quiz']['uids']))){
		
		$this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_not_assigned_to_your_group')." </div>");
		redirect('quiz/quiz_detail/'.$quid);
			}
		 }
		// validate start end date/time
		if($data['quiz']['start_date'] > time()){
		$this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_not_available')." </div>");
		redirect('quiz/quiz_detail/'.$quid);
		 }
		// validate start end date/time
		if($data['quiz']['end_date'] < time()){
		$this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_ended')." </div>");
		redirect('quiz/quiz_detail/'.$quid);
		 }

		// validate ip address
		if($data['quiz']['ip_address'] !=''){
		$ip_address=explode(",",$data['quiz']['ip_address']);
		$myip=$_SERVER['REMOTE_ADDR'];
		if(!in_array($myip,$ip_address)){
		$this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('ip_declined')." </div>");
		redirect('quiz/quiz_detail/'.$quid);
		 }
		}
		 // validate maximum attempts
		$maximum_attempt=$this->quiz_model->count_result($quid,$uid);
		if($data['quiz']['maximum_attempts'] <= $maximum_attempt){
		$this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('reached_maximum_attempt')." </div>");
		redirect('quiz/quiz_detail/'.$quid);
		 }
		 
		 
		// validate start end date/time

		if($data['quiz']['quiz_price'] >= 1){
			
			$quiz_txn=intval($this->quiz_model->get_quiz_transactions($quid));
			 
		if($quiz_txn == 0){
		$this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_paid')." </div>");
		redirect('quiz/quiz_detail/'.$quid);
		   }  
		 }

		 
		
		// insert result row and get rid (result id)
		$rid=$this->quiz_model->insert_result($quid,$uid);
		
		$this->session->set_userdata('rid', $rid);
		redirect('quiz/attempt/'.$rid.'/'.$selected_lang);	
		}
		
	}
	
	function resume_pending($open_result){
	$data['title']=$this->lang->line('pending_quiz');
	$this->session->set_userdata('rid', $open_result);
		$data['openquizurl']='quiz/attempt/'.$open_result;
			 		
		$this->load->view('header',$data);
		 $this->load->view('pending_quiz_message',$data);
		$this->load->view('footer',$data);
	
	}
	
	function attempt($rid,$selected_lang=0){
		// redirect if not loggedin
		if(!$this->session->userdata('logged_in')){
			if(!$this->session->userdata('logged_in_raw')){
				redirect('login');
			}
		}
		
		if(!$this->session->userdata('logged_in')){
		$logged_in=$this->session->userdata('logged_in_raw');
		}else{
		$logged_in=$this->session->userdata('logged_in');
		}
		if($logged_in['base_url'] != base_url()){
		$this->session->unset_userdata('logged_in');		
		redirect('login');
		}



		$srid=$this->session->userdata('rid');
						// if linked and session rid is not matched then something wrong.
			if($rid != $srid){
		 
		$this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_ended')." </div>");
		redirect('quiz/');

			}
		/*
		if(!$this->session->userdata('logged_in')){
			exit($this->lang->line('permission_denied'));
		}
		*/
		
		// get result and quiz info and validate time period
		$data['quiz']=$this->quiz_model->quiz_result($rid);
		$data['saved_answers']=$this->quiz_model->saved_answers($rid);
		$data['selected_lang']=$selected_lang;

			
			
		// end date/time
		if($data['quiz']['end_date'] < time()){
		$this->quiz_model->submit_result($rid);
		$this->session->unset_userdata('rid');
		$this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_ended')." </div>");
		redirect('quiz/quiz_detail/'.$data['quiz']['quid']);
		 }

		
		// end date/time
		if(($data['quiz']['start_time']+($data['quiz']['duration']*60)) < time()){
		$this->quiz_model->submit_result($rid);
		$this->session->unset_userdata('rid');
		$this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('time_over')." </div>");
		redirect('quiz/quiz_detail/'.$data['quiz']['quid']);
		 }
		// remaining time in seconds 
		$data['seconds']=($data['quiz']['duration']*60) - (time()- $data['quiz']['start_time']);
		// get questions
		$data['questions']=$this->quiz_model->get_questions($data['quiz']['r_qids']);
		// get options
		$data['options']=$this->quiz_model->get_options($data['quiz']['r_qids']);
		$data['title']=$data['quiz']['quiz_name'];
		$this->load->view('header',$data);
		
		$this->load->view('quiz_attempt_'.$data['quiz']['quiz_template'],$data);
		$this->load->view('footer',$data);
			
		}
		
		
	
	
	function save_answer(){
				// redirect if not loggedin
		if(!$this->session->userdata('logged_in')){
			if(!$this->session->userdata('logged_in_raw')){
		
		redirect('login');
			}	
		}
		if(!$this->session->userdata('logged_in')){
		$logged_in=$this->session->userdata('logged_in_raw');
		}else{
		$logged_in=$this->session->userdata('logged_in');
		}
		if($logged_in['base_url'] != base_url()){
		$this->session->unset_userdata('logged_in');		
		redirect('login');
		}


		 echo $this->quiz_model->insert_answer();
		
		
	}
 function set_ind_time(){
		  // update questions time spent
		$this->quiz_model->set_ind_time();
		
		
	}
 
 
 
 function upload_photo(){
				// redirect if not loggedin
		if(!$this->session->userdata('logged_in')){
			redirect('login');
			
		}
		$logged_in=$this->session->userdata('logged_in');
		if($logged_in['base_url'] != base_url()){
		$this->session->unset_userdata('logged_in');		
		redirect('login');
		}

		
		
if(isset($_FILES['webcam'])){
			$targets = 'photo/';
			$filename=time().'.jpg';
			$targets = $targets.''.$filename;
			if(move_uploaded_file($_FILES['webcam']['tmp_name'], $targets)){
			
				$this->session->set_flashdata('photoname', $filename);
				}
				}
}



 function submit_quiz(){
	 				// redirect if not loggedin
		if(!$this->session->userdata('logged_in')){
			if(!$this->session->userdata('logged_in_raw')){
		 redirect('login');
			}
		}
		if(!$this->session->userdata('logged_in')){
		$logged_in=$this->session->userdata('logged_in_raw');
		}else{
		$logged_in=$this->session->userdata('logged_in');
		}
		if($logged_in['base_url'] != base_url()){
		$this->session->unset_userdata('logged_in');		
		redirect('login');
		}

	 $rid=$this->session->userdata('rid');
		
				if($this->quiz_model->submit_result()){
					 
					 $this->session->set_flashdata('message', "<div class='alert alert-success'>".str_replace("{result_url}",site_url('result/view_result/'.$rid),$this->lang->line('quiz_submit_successfully'))." </div>");
					 
					
					}else{
						    $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('error_to_submit')." </div>");
						
					}
			$this->session->unset_userdata('rid');		
	if($this->session->userdata('logged_in')){
	redirect('result/view_result/'.$rid);				
 redirect('quiz');
	}else{
	 redirect('quiz/open_quiz/0');	
	}
 }
 
 
 
 function assign_score($rid,$qno,$score){
	 
	 				// redirect if not loggedin
		if(!$this->session->userdata('logged_in')){
			redirect('login');
			
		}
		$logged_in=$this->session->userdata('logged_in');
		if($logged_in['base_url'] != base_url()){
		$this->session->unset_userdata('logged_in');		
		redirect('login');
		}

		
		
	 $logged_in=$this->session->userdata('logged_in');
			if($logged_in['su']!='1'){
				exit($this->lang->line('permission_denied'));
			} 
			$this->quiz_model->assign_score($rid,$qno,$score);
			
			echo '1';
	 
 }
 
 
 function insert_warning(){
 $rid=$_POST['rid'];
 $uid=$_POST['uid'];
 $m=$_POST['m'];
 $tim=time();
 $insertdata=array(
 'uid'=>$uid,
 'rid'=>$rid,
 'warning_message'=>$m,
 'warning_time'=>$tim
 );
 $this->db->insert('warning_message',$insertdata);
 print_r($this->db->last_query());
 }
 
 	
}
