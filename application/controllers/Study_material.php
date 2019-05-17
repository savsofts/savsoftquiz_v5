<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Study_material extends CI_Controller {

	 function __construct()
	 {
	   parent::__construct();
	   $this->load->database();
	   $this->load->helper('url');
	   $this->load->model("Studymaterial_model");
	     $this->lang->load('basic', $this->config->item('language'));
$this->load->helper('form');
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
		
	 					$logged_in=$this->session->userdata('logged_in');
                        $acp=explode(',',$logged_in['study_material']);
			if(!in_array('List',$acp)){
			exit($this->lang->line('permission_denied'));
			}
			
		
		 	 
			
			
	        $data['limit']=$limit;
		$data['title']=$this->lang->line('study_material');
		
		$data['result']=$this->Studymaterial_model->studymaterial_list($limit);
		$this->load->view('header',$data);
		$this->load->view('studymaterial_list',$data);
		$this->load->view('footer',$data);
	}
	
	function add_new(){
	if(!$this->session->userdata('logged_in')){
			redirect('login');
			
		}
		$logged_in=$this->session->userdata('logged_in');
		if($logged_in['base_url'] != base_url()){
		$this->session->unset_userdata('logged_in');		
		redirect('login');
		}
		
	 					$logged_in=$this->session->userdata('logged_in');
                        $acp=explode(',',$logged_in['study_material']);
			if(!in_array('Add',$acp)){
			exit($this->lang->line('permission_denied'));
			}
			
	$data['title']=$this->lang->line('study_material');
		
		$data['categories']=$this->Studymaterial_model->getcategory_list();
		$data['groups']=$this->Studymaterial_model->getgroup_list();
		$this->load->view('header',$data);
		$this->load->view('add_studymaterial',$data);
		$this->load->view('footer',$data);
	
	
	}
	
	function add_new_studymaterial(){
	
	//echo "<pre>";print_r($_POST);
	$logged_in=$this->session->userdata('logged_in');
			$user_p=explode(',',$logged_in['study_material']);
			if(!in_array('Add',$user_p)){
			exit($this->lang->line('permission_denied'));
			}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', 'Title', 'required|is_unique[study_material.title]');
        $this->form_validation->set_rules('cid', 'Category', 'required');
          if ($this->form_validation->run() == FALSE)
                {
                     $this->session->set_flashdata('message', "<div class='alert alert-danger'>".validation_errors()." </div>");
					redirect('study_material/add_new/');
                }
                else
                {
				$result=$this->Studymaterial_model->insert_studymaterial();
					if($result=='true'){
					
                        $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('data_added_successfully')." </div>");
					}else{ 
						    $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('error_to_add_data')." </div>");
						
					}
					redirect('study_material/add_new/');
                }       

	
	}
	
		function view_studymaterial($stid){
	if(!$this->session->userdata('logged_in')){
			redirect('login');
			
		}
		$logged_in=$this->session->userdata('logged_in');
		if($logged_in['base_url'] != base_url()){
		$this->session->unset_userdata('logged_in');		
		redirect('login');
		}
		
	 					$logged_in=$this->session->userdata('logged_in');
                        $acp=explode(',',$logged_in['study_material']);
			if(!in_array('View',$acp)){
			exit($this->lang->line('permission_denied'));
			}
			
	$data['title']=$this->lang->line('study_material');
		
		$data['result']=$this->Studymaterial_model->getstudymaterial_view($stid);
		$data['groups']=$this->Studymaterial_model->getgroup_list();
		$this->load->view('header',$data);
		$this->load->view('view_studymaterial',$data);
		$this->load->view('footer',$data);
	
	
	}
	
	public function remove_studymaterial($stid){

			$logged_in=$this->session->userdata('logged_in');
			$user_p=explode(',',$logged_in['study_material']);
			if(!in_array('Remove',$user_p)){
			exit($this->lang->line('permission_denied'));
			}
			if($uid=='1'){
					exit($this->lang->line('permission_denied'));
			}
			$result=$this->Studymaterial_model->remove_studymaterial($stid);
			if($result=='true'){
                        $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('removed_successfully')." </div>");
					}else{
			$this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('error_to_remove')." </div>");
					}
					redirect('study_material/');
                     
			
		}
	
	function edit_studymaterial($stid){
	
	if(!$this->session->userdata('logged_in')){
			redirect('login');
			
		}
		$logged_in=$this->session->userdata('logged_in');
		if($logged_in['base_url'] != base_url()){
		$this->session->unset_userdata('logged_in');		
		redirect('login');
		}
		
	 					$logged_in=$this->session->userdata('logged_in');
                        $acp=explode(',',$logged_in['study_material']);
			if(!in_array('Edit',$acp)){
			exit($this->lang->line('permission_denied'));
			}
			
	        $data['title']=$this->lang->line('study_material');
		$data['result']=$this->Studymaterial_model->getstudymaterial_edit($stid);
		$data['categories']=$this->Studymaterial_model->getcategory_list();
		$data['groups']=$this->Studymaterial_model->getgroup_list();
		$this->load->view('header',$data);
		$this->load->view('edit_studymaterial',$data);
		$this->load->view('footer',$data);
	
	}
	
	
	
	function update_studymaterial($stid){
	$logged_in=$this->session->userdata('logged_in');
			$user_p=explode(',',$logged_in['study_material']);
			if(!in_array('Edit',$user_p)){
			exit($this->lang->line('permission_denied'));
			}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('cid', 'Category', 'required');
          if ($this->form_validation->run() == FALSE)
                {
                     $this->session->set_flashdata('message', "<div class='alert alert-danger'>".validation_errors()." </div>");
					redirect('study_material/edit_studymaterial/'.$stid);
                }
                else
                {
				$result=$this->Studymaterial_model->update_studymaterial($stid);
					if($result=='true'){
					
                        $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('data_updated_successfully')." </div>");
					}else{ 
						    $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('error_to_add_data')." </div>");
						
					}
					redirect('study_material/edit_studymaterial/'.$stid);
                }       

	
	
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
/// end	
}
