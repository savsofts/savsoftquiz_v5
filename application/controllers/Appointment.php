<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Appointment extends CI_Controller {

	 function __construct()
	 {
	   parent::__construct();
	   $this->load->database();
	   $this->load->helper('url');
	   $this->load->model("Appointment_model");
	     $this->lang->load('basic', $this->config->item('language'));
$this->load->helper('form');
	 }
	 
	 function index(){
	 
	 }

	public function myappointment($limit='0')
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
	 		 $acp=explode(',',$logged_in['appointment']);
			if(!in_array('List',$acp)){
			exit($this->lang->line('permission_denied'));
			}
			
		
		 	 
			
			
	        $data['limit']=$limit;
		$data['title']=$this->lang->line('myappointment');
		
		$data['result']=$this->Appointment_model->Appointment_list($limit);
		 
		$this->load->view('header',$data);
		$this->load->view('myappointment',$data);
		$this->load->view('footer',$data);
	}
	
 
	
	
	function change_status($appointment_id,$status){
	$data['result']=$this->Appointment_model->get_appointment($appointment_id);
		$logged_in=$this->session->userdata('logged_in');
	 	if($data['result']['to_id']==$logged_in['uid']){
	 	
	 	$this->Appointment_model->change_status($appointment_id,$status);
	 	  $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('accepted_successfully')." </div>");
					}else{
			exit($this->lang->line('permission_denied'));
					}
			redirect('appointment/myappointment/');					
	
	}
	
	
	
	
	
	function get_appointment($to_id){
	
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
	 		 $acp=explode(',',$logged_in['appointment']);
			if(!in_array('List',$acp)){
			exit($this->lang->line('permission_denied'));
			}
			
		
		 	 
			if($this->input->post('to_id')){
$userdata=array(
'to_id'=>$to_id,
'request_by'=>$logged_in['uid'],
'appointment_timing'=>$this->input->post('appointment_timing')

);
$this->db->insert('appointment_request',$userdata);
 $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('appointment_added')." </div>");
	redirect('appointment/myappointment/');			
			
			}
			
	        $data['to_id']=$to_id;
		 $data['title']=$this->lang->line('appointment_with_expert');
		
		$data['user']=$this->Appointment_model->get_user($to_id);
		 
		$this->load->view('header',$data);
		$this->load->view('get_appointment',$data);
		$this->load->view('footer',$data);
	
	}
	
	
	
	
	
	
	
	
/// end	
}
