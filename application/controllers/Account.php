<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {

	 function __construct()
	 {
	   parent::__construct();
	   $this->load->database();
	   $this->load->helper('url');
	   $this->load->model("Account_model");
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
		
	 
			$logged_in=$this->session->userdata('logged_in');
                        $acp=explode(',',$logged_in['setting']);
			if(!in_array('All',$acp)){
			exit($this->lang->line('permission_denied'));
			}
		
		 	 
			
			
	        $data['limit']=$limit;
		$data['title']=$this->lang->line('account_list');
		
		$data['result']=$this->Account_model->account_list($limit);
		$this->load->view('header',$data);
		$this->load->view('account_list',$data);
		$this->load->view('footer',$data);
	}
	
	
 


function edit_account($account_id){
			$logged_in=$this->session->userdata('logged_in');
                        $acp=explode(',',$logged_in['setting']);
			if(!in_array('All',$acp)){
			exit($this->lang->line('permission_denied'));
			}
		$data['account_id']=$account_id;
		
		$data['result']=$this->Account_model->get_edit_account($account_id);
 	$data['title']=$this->lang->line('edit_account');

		  $this->load->view('header',$data);
		$this->load->view('edit_account',$data);

		
		$this->load->view('footer',$data);
	}
	
	
	function update_account($account_id){
	
			$logged_in=$this->session->userdata('logged_in');
                        $acp=explode(',',$logged_in['setting']);
			if(!in_array('All',$acp)){
			exit($this->lang->line('permission_denied'));
			}
	$this->Account_model->update_account($account_id);
$this->session->set_flashdata('message', "<div class='alert alert-success'>Account updated successfully </div>");
	redirect('account');
}


function remove_account($account_id){
			$logged_in=$this->session->userdata('logged_in');
                        $acp=explode(',',$logged_in['setting']);
			if(!in_array('All',$acp)){
			exit($this->lang->line('permission_denied'));
			}
			$maid=$this->input->post('maid');
$this->db->query(" update savsoft_users set su='$maid' where su='$account_id' ");
			if($this->Account_model->remove_account($account_id)){
                        $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('removed_successfully')." </div>");
					}else{
						    $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('error_to_remove')." </div>");
						
					}
			redirect('account');
		}
	
	
	
	public function pre_remove_account($account_id){
		
			$logged_in=$this->session->userdata('logged_in');
                        $acp=explode(',',$logged_in['setting']);
			if(!in_array('All',$acp)){
			exit($this->lang->line('permission_denied'));
			}
			
		$data['account_id']=$account_id;
		// fetching group list
		$data['result']=$this->Account_model->account_list(0);
		$data['title']=$this->lang->line('remove_account');
		$this->load->view('header',$data);
		$this->load->view('pre_remove_account',$data);
		$this->load->view('footer',$data);

		
		
		
	}
	
	
	
}
