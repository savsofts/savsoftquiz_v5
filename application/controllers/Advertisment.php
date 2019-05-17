<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Advertisment extends CI_Controller {

	 function __construct()
	 {
	   parent::__construct();
	   $this->load->database();
	   $this->load->helper('url');
	   $this->load->model("Advertisment_model");
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
		$data['title']=$this->lang->line('advertisment');
		
		$data['result']=$this->Advertisment_model->advertisment_list($limit);
		$this->load->view('header',$data);
		$this->load->view('advertisment_list',$data);
		$this->load->view('footer',$data);
	}
	
	
	function edit_advertisment($add_id){
					$logged_in=$this->session->userdata('logged_in');
                        $acp=explode(',',$logged_in['setting']);
			if(!in_array('All',$acp)){
			exit($this->lang->line('permission_denied'));
			}
		$data['add_id']=$add_id;
		
		$data['result']=$this->Advertisment_model->get_edit_advertisment($add_id);
 
		  $this->load->view('header',$data);
		$this->load->view('edit_advertisment',$data);

		
		$this->load->view('footer',$data);
	}
	
	
	function update_advertisment($add_id){
						$logged_in=$this->session->userdata('logged_in');
                        $acp=explode(',',$logged_in['setting']);
			if(!in_array('All',$acp)){
			exit($this->lang->line('permission_denied'));
			}
			
	$new_file_name="";
                $config=array(
					'upload_path' => "./upload/",

					'allowed_types'=> "gif|jpg|png",

					'max_size' => "1000",

					'max_width' => "1024",

					'max_height' => "768",
				);
				$this->load->library('upload', $config);
					 if($this->upload->do_upload()){
					 
				$file=$this->upload->data();
				$new_file_name=time().'.jpg';

				$filename=$file['file_name'];
 
				rename('./upload/'.$filename,'./upload/'.$new_file_name);
				}
				
	$this->Advertisment_model->update_advertisment($add_id,$new_file_name);
$this->session->set_flashdata('message', "<div class='alert alert-success'>Ad updated successfully </div>");
	redirect('advertisment');
}
}
