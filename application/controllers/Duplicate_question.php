<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Duplicate_question extends CI_Controller {

	 function __construct()
	 {
	   parent::__construct();
	   $this->load->database();
	   $this->load->helper('url');
	   $this->load->model("duplicate_question_model");
	   $this->lang->load('duplicate', $this->config->item('language'));
		// redirect if not loggedin
		if(!$this->session->userdata('logged_in')){
			redirect('login');
			
		}
		$logged_in=$this->session->userdata('logged_in');
		if($logged_in['base_url'] != base_url()){
		$this->session->unset_userdata('logged_in');		
		redirect('login');
		}
	 }

	public function index($limit='0')
	{
		$this->load->helper('form');
		$logged_in=$this->session->userdata('logged_in');
			if($logged_in['su']!='1'){
			exit($this->lang->line('permission_denied'));
			}
			
		$data['result']=$this->duplicate_question_model->check_duplicate($limit);
		if(count($data['result'])==0){
		exit('');
		}
		  $data['limit']=$limit;
		// print_r($this->db->last_query());
		  
		// fetching  list
		 $this->load->view('duplicate_question_list',$data);
		 
	}
	
	 
	
	
	
	
}
