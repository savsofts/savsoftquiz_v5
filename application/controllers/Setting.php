<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller {

/*
| Savsoft Quiz - https://savsoftquiz.com 
|  Setting page
*/


	 function __construct()
	 {
	   parent::__construct();
		 $this->load->database();
	   $this->load->helper('url');
		$this->lang->load('basic', $this->config->item('language'));
		 $this->load->model('Setting_model');

	 // redirect if not loggedin
		if(!$this->session->userdata('logged_in')){
			redirect('login');
			
		}
		$logged_in=$this->session->userdata('logged_in');
		if(!in_array('All',explode(',',$logged_in['setting']))){
			redirect('login');
		}
	 }
	 
	 
	public function index()
	{
	$data['title']="Setting";
	$data['tabs']=$this->Setting_model->settingTabs();
	$data['settings']=$this->Setting_model->basicSetting();
	 
	$this->load->view('header',$data);
	 $this->load->view('setting',$data);
	$this->load->view('footer',$data);
		 
	}
	
	public function update(){
		
		if($this->Setting_model->updateSetting()){
			 	$this->session->set_flashdata('message', "<div class='alert alert-success sqFadeout'>Setting updated successfully!</div>");
		}else{
			 	$this->session->set_flashdata('message', "<div class='alert alert-danger sqFadeout'>Unable to update setting!</div>");
		}
		 
			  redirect('setting/index');
		
		
		
	}
	 
		 
}
