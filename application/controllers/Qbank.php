<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Qbank extends CI_Controller {

	 function __construct()
	 {
	   parent::__construct();
	   $this->load->database();
	   $this->load->helper('url');
	   $this->load->model("qbank_model");
	   $this->lang->load('basic', $this->config->item('language'));
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

	public function index($limit='0',$cid='0',$lid='0')
	{
		$this->load->helper('form');
			
			$logged_in=$this->session->userdata('logged_in');
                        $acp=explode(',',$logged_in['questions']);
			if(in_array('List_all',$acp) || in_array('List',$acp)){
			
			}else{
			exit($this->lang->line('permission_denied'));
			} 
			
			 $data['category_list']=$this->qbank_model->category_list();
		 $data['level_list']=$this->qbank_model->level_list();
		
		$data['limit']=$limit;
		$data['cid']=$cid;
		$data['lid']=$lid;
		 
		
		$data['title']=$this->lang->line('qbank');
		// fetching user list
		$data['result']=$this->qbank_model->question_list($limit,$cid,$lid);
		$this->load->view('header',$data);
		$this->load->view('question_list',$data);
		$this->load->view('footer',$data);
	}
	
	public function remove_question($qid){

			$logged_in=$this->session->userdata('logged_in');
                        $acp=explode(',',$logged_in['questions']);
			if(!in_array('Remove',$acp)){
			exit($this->lang->line('permission_denied'));
			} 
			
			if($this->qbank_model->remove_question($qid)){
                        $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('removed_successfully')." </div>");
					}else{
						    $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('error_to_remove')." </div>");
						
					}
					redirect('qbank');
                     
			
		}
	
	
	
	function pre_question_list($limit='0',$cid='0',$lid='0'){
		$cid=$this->input->post('cid');
		$lid=$this->input->post('lid');
		redirect('qbank/index/'.$limit.'/'.$cid.'/'.$lid);
	}
	
	
	public function pre_new_question()
	{
	 	
	$para=0;
		if($this->input->post('with_paragraph')){
		$para=1;
		
		}
		
		
			$logged_in=$this->session->userdata('logged_in');
                        $acp=explode(',',$logged_in['questions']);
			if(!in_array('Add',$acp)){
			exit($this->lang->line('permission_denied'));
			}
			
		if($this->input->post('question_type')){
		if($this->input->post('question_type')=='1'){
			$nop=$this->input->post('nop');
			if(!is_numeric($this->input->post('nop'))){
				$nop=4;
			}
		redirect('qbank/new_question_1/'.$nop.'/'.$para);
		}
		if($this->input->post('question_type')=='2'){
			$nop=$this->input->post('nop');
			if(!is_numeric($this->input->post('nop'))){
				$nop=4;
			}
		redirect('qbank/new_question_2/'.$nop.'/'.$para);
		}
		if($this->input->post('question_type')=='3'){
			$nop=$this->input->post('nop');
			if(!is_numeric($this->input->post('nop'))){
				$nop=4;
			}
		redirect('qbank/new_question_3/'.$nop.'/'.$para);
		}
		if($this->input->post('question_type')=='4'){
			$nop=$this->input->post('nop');
			if(!is_numeric($this->input->post('nop'))){
				$nop=4;
			}
		redirect('qbank/new_question_4/'.$nop.'/'.$para);
		}
				if($this->input->post('question_type')=='5'){
			$nop=$this->input->post('nop');
			if(!is_numeric($this->input->post('nop'))){
				$nop=4;
			}
		redirect('qbank/new_question_5/'.$nop.'/'.$para);
		}

		}
		
		 $data['title']=$this->lang->line('add_new').' '.$this->lang->line('question');
		 $this->load->view('header',$data);
		$this->load->view('pre_new_question',$data);
		$this->load->view('footer',$data);
	}
	
	public function new_question_1($nop='4',$para='0')
	{
		
			$logged_in=$this->session->userdata('logged_in');
                        $acp=explode(',',$logged_in['questions']);
			if(!in_array('Add',$acp)){
			exit($this->lang->line('permission_denied'));
			}
			if($this->input->post('question')){
				 
				if($this->qbank_model->insert_question_1()){
                $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('data_added_successfully')." </div>");
				}else{
				 $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('error_to_add_data')." </div>");
				}
				if($this->input->post('parag')==1){
				redirect('qbank/new_question_1/'.$nop.'/'.$para);
				}else{
				redirect('qbank/pre_new_question/');
				}
			}
			if($this->session->flashdata('qid')){
			$data['qp']=$this->qbank_model->get_question($this->session->flashdata('qid'));
		
			}			
		 $data['para']=$para;	
		 $data['nop']=$nop;
		 $data['title']=$this->lang->line('add_new');
		// fetching category list
		$data['category_list']=$this->qbank_model->category_list();
		// fetching level list
		$data['level_list']=$this->qbank_model->level_list();
		 $this->load->view('header',$data);
		$this->load->view('new_question_1',$data);
		$this->load->view('footer',$data);
	}
	
	
	public function new_question_2($nop='4',$para='0')
	{
		
			$logged_in=$this->session->userdata('logged_in');
                        $acp=explode(',',$logged_in['questions']);
			if(!in_array('Add',$acp)){
			exit($this->lang->line('permission_denied'));
			}
			if($this->input->post('question')){
				if($this->qbank_model->insert_question_2()){
                $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('data_added_successfully')." </div>");
				}else{
				 $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('error_to_add_data')." </div>");
				}
				if($this->input->post('parag')==1){
				redirect('qbank/new_question_2/'.$nop.'/'.$para);
				}else{
				redirect('qbank/pre_new_question/');
				}
			}
			if($this->session->flashdata('qid')){
			$data['qp']=$this->qbank_model->get_question($this->session->flashdata('qid'));
		
			}			
		 $data['para']=$para;	
		 $data['nop']=$nop;
		 $data['title']=$this->lang->line('add_new');
		// fetching category list
		$data['category_list']=$this->qbank_model->category_list();
		// fetching level list
		$data['level_list']=$this->qbank_model->level_list();
		 $this->load->view('header',$data);
		$this->load->view('new_question_2',$data);
		$this->load->view('footer',$data);
	}
	
	
	public function new_question_3($nop='4',$para='0')
	{
		
			$logged_in=$this->session->userdata('logged_in');
                        $acp=explode(',',$logged_in['questions']);
			if(!in_array('Add',$acp)){
			exit($this->lang->line('permission_denied'));
			}
			if($this->input->post('question')){
				if($this->qbank_model->insert_question_3()){
                $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('data_added_successfully')." </div>");
				}else{
				 $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('error_to_add_data')." </div>");
				}
								if($this->input->post('parag')==1){
				redirect('qbank/new_question_3/'.$nop.'/'.$para);
				}else{
				redirect('qbank/pre_new_question/');
				}
			}
			if($this->session->flashdata('qid')){
			$data['qp']=$this->qbank_model->get_question($this->session->flashdata('qid'));
		
			}			
		 $data['para']=$para;	
		 $data['nop']=$nop;
		 $data['title']=$this->lang->line('add_new');
		// fetching category list
		$data['category_list']=$this->qbank_model->category_list();
		// fetching level list
		$data['level_list']=$this->qbank_model->level_list();
		 $this->load->view('header',$data);
		$this->load->view('new_question_3',$data);
		$this->load->view('footer',$data);
	}
	
	
		public function new_question_4($nop='4',$para='0')
	{
		
			$logged_in=$this->session->userdata('logged_in');
                        $acp=explode(',',$logged_in['questions']);
			if(!in_array('Add',$acp)){
			exit($this->lang->line('permission_denied'));
			}
			if($this->input->post('question')){
				if($this->qbank_model->insert_question_4()){
                $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('data_added_successfully')." </div>");
				}else{
				 $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('error_to_add_data')." </div>");
				}
								if($this->input->post('parag')==1){
				redirect('qbank/new_question_4/'.$nop.'/'.$para);
				}else{
				redirect('qbank/pre_new_question/');
				}
			}
			if($this->session->flashdata('qid')){
			$data['qp']=$this->qbank_model->get_question($this->session->flashdata('qid'));
		
			}			
		 $data['para']=$para;	
		 $data['nop']=$nop;
		 $data['title']=$this->lang->line('add_new');
		// fetching category list
		$data['category_list']=$this->qbank_model->category_list();
		// fetching level list
		$data['level_list']=$this->qbank_model->level_list();
		 $this->load->view('header',$data);
		$this->load->view('new_question_4',$data);
		$this->load->view('footer',$data);
	}
	
	
			public function new_question_5($nop='4',$para='0')
	{
		
			$logged_in=$this->session->userdata('logged_in');
                        $acp=explode(',',$logged_in['questions']);
			if(!in_array('Add',$acp)){
			exit($this->lang->line('permission_denied'));
			}
			if($this->input->post('question')){
				if($this->qbank_model->insert_question_5()){
                $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('data_added_successfully')." </div>");
				}else{
				 $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('error_to_add_data')." </div>");
				}
								if($this->input->post('parag')==1){
				redirect('qbank/new_question_5/'.$nop.'/'.$para);
				}else{
				redirect('qbank/pre_new_question/');
				}
			}
			if($this->session->flashdata('qid')){
			$data['qp']=$this->qbank_model->get_question($this->session->flashdata('qid'));
		
			}			
		 $data['para']=$para;
		 $data['nop']=$nop;
		 $data['title']=$this->lang->line('add_new');
		// fetching category list
		$data['category_list']=$this->qbank_model->category_list();
		// fetching level list
		$data['level_list']=$this->qbank_model->level_list();
		 $this->load->view('header',$data);
		$this->load->view('new_question_5',$data);
		$this->load->view('footer',$data);
	}
	

	
	
	
	
	
		public function edit_question_1($qid)
	{
		
			$logged_in=$this->session->userdata('logged_in');
                        $acp=explode(',',$logged_in['questions']);
			if(!in_array('Edit',$acp)){
			exit($this->lang->line('permission_denied'));
			}
			if($this->input->post('question')){
				if($this->qbank_model->update_question_1($qid)){
                $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('data_updated_successfully')." </div>");
				}else{
				 $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('error_to_update_data')." </div>");
				}
				redirect('qbank/edit_question_1/'.$qid);
			}			
			
		 
		 $data['title']=$this->lang->line('edit');
		// fetching question
		$data['question']=$this->qbank_model->get_question($qid);
		$data['options']=$this->qbank_model->get_option($qid);
		// fetching category list
		$data['category_list']=$this->qbank_model->category_list();
		// fetching level list
		$data['level_list']=$this->qbank_model->level_list();
		 $this->load->view('header',$data);
		$this->load->view('edit_question_1',$data);
		$this->load->view('footer',$data);
	}
	
	
	public function edit_question_2($qid)
	{
		
			$logged_in=$this->session->userdata('logged_in');
                        $acp=explode(',',$logged_in['questions']);
			if(!in_array('Edit',$acp)){
			exit($this->lang->line('permission_denied'));
			}
			if($this->input->post('question')){
				if($this->qbank_model->update_question_2($qid)){
                $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('data_updated_successfully')." </div>");
				}else{
				 $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('error_to_update_data')." </div>");
				}
				redirect('qbank/edit_question_2/'.$qid);
			}			
			
		 
		 $data['title']=$this->lang->line('edit');
		// fetching question
		$data['question']=$this->qbank_model->get_question($qid);
		$data['options']=$this->qbank_model->get_option($qid);
		// fetching category list
		$data['category_list']=$this->qbank_model->category_list();
		// fetching level list
		$data['level_list']=$this->qbank_model->level_list();
		 $this->load->view('header',$data);
		$this->load->view('edit_question_2',$data);
		$this->load->view('footer',$data);
	}
	
	
	public function edit_question_3($qid)
	{
		
			$logged_in=$this->session->userdata('logged_in');
                        $acp=explode(',',$logged_in['questions']);
			if(!in_array('Edit',$acp)){
			exit($this->lang->line('permission_denied'));
			}
			if($this->input->post('question')){
				if($this->qbank_model->update_question_3($qid)){
                $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('data_updated_successfully')." </div>");
				}else{
				 $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('error_to_update_data')." </div>");
				}
				redirect('qbank/edit_question_3/'.$qid);
			}			
			
		  
		 $data['title']=$this->lang->line('edit');
		// fetching question
		$data['question']=$this->qbank_model->get_question($qid);
		$data['options']=$this->qbank_model->get_option($qid);
		// fetching category list
		$data['category_list']=$this->qbank_model->category_list();
		// fetching level list
		$data['level_list']=$this->qbank_model->level_list();
		 $this->load->view('header',$data);
		$this->load->view('edit_question_3',$data);
		$this->load->view('footer',$data);
	}
	
	
		public function edit_question_4($qid)
	{
		
			$logged_in=$this->session->userdata('logged_in');
                        $acp=explode(',',$logged_in['questions']);
			if(!in_array('Edit',$acp)){
			exit($this->lang->line('permission_denied'));
			}
			if($this->input->post('question')){
				if($this->qbank_model->update_question_4($qid)){
                $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('data_updated_successfully')." </div>");
				}else{
				 $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('error_to_update_data')." </div>");
				}
				redirect('qbank/edit_question_4/'.$qid);
			}			
			
		 
		 $data['title']=$this->lang->line('edit');
		// fetching question
		$data['question']=$this->qbank_model->get_question($qid);
		$data['options']=$this->qbank_model->get_option($qid);
		// fetching category list
		$data['category_list']=$this->qbank_model->category_list();
		// fetching level list
		$data['level_list']=$this->qbank_model->level_list();
		 $this->load->view('header',$data);
		$this->load->view('edit_question_4',$data);
		$this->load->view('footer',$data);
	}
	
	
			public function edit_question_5($qid)
	{
		
			$logged_in=$this->session->userdata('logged_in');
                        $acp=explode(',',$logged_in['questions']);
			if(!in_array('Edit',$acp)){
			exit($this->lang->line('permission_denied'));
			}
			if($this->input->post('question')){
				if($this->qbank_model->update_question_5($qid)){
                $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('data_updated_successfully')." </div>");
				}else{
				 $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('error_to_update_data')." </div>");
				}
				redirect('qbank/edit_question_5/'.$qid);
			}			
			
		 
		 $data['title']=$this->lang->line('edit');
		// fetching question
		$data['question']=$this->qbank_model->get_question($qid);
		$data['options']=$this->qbank_model->get_option($qid);
		// fetching category list
		$data['category_list']=$this->qbank_model->category_list();
		// fetching level list
		$data['level_list']=$this->qbank_model->level_list();
		 $this->load->view('header',$data);
		$this->load->view('edit_question_5',$data);
		$this->load->view('footer',$data);
	}
	

	// category functions start
	public function category_list(){
					$logged_in=$this->session->userdata('logged_in');
                        $acp=explode(',',$logged_in['setting']);
			if(!in_array('All',$acp)){
			exit($this->lang->line('permission_denied'));
			}
		// fetching group list
		$data['category_list']=$this->qbank_model->category_list();
		$data['title']=$this->lang->line('category_list');
		$this->load->view('header',$data);
		$this->load->view('category_list',$data);
		$this->load->view('footer',$data);

		
		
		
	}
	
	
		public function insert_category()
	{
		
		
					$logged_in=$this->session->userdata('logged_in');
                        $acp=explode(',',$logged_in['setting']);
			if(!in_array('All',$acp)){
			exit($this->lang->line('permission_denied'));
			}
	
				if($this->qbank_model->insert_category()){
                $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('data_added_successfully')." </div>");
				}else{
				 $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('error_to_add_data')." </div>");
						
				}
				redirect('qbank/category_list/');
	
	}
	
			public function update_category($cid)
	{
		
		
					$logged_in=$this->session->userdata('logged_in');
                        $acp=explode(',',$logged_in['setting']);
			if(!in_array('All',$acp)){
			exit($this->lang->line('permission_denied'));
			}
	
				if($this->qbank_model->update_category($cid)){
                echo "<div class='alert alert-success'>".$this->lang->line('data_updated_successfully')." </div>";
				}else{
				 echo "<div class='alert alert-danger'>".$this->lang->line('error_to_update_data')." </div>";
						
				}
				 
	
	}
	
	
	
	
			public function remove_category($cid){

					$logged_in=$this->session->userdata('logged_in');
                        $acp=explode(',',$logged_in['setting']);
			if(!in_array('All',$acp)){
			exit($this->lang->line('permission_denied'));
			}
			
			$mcid=$this->input->post('mcid');
$this->db->query(" update savsoft_qbank set cid='$mcid' where cid='$cid' ");


			if($this->qbank_model->remove_category($cid)){
                        $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('removed_successfully')." </div>");
					}else{
						    $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('error_to_remove')." </div>");
						
					}
					redirect('qbank/category_list');
                     
			
		}
	// category functions end
	
	
	
	
		public function pre_remove_category($cid){
		
			$logged_in=$this->session->userdata('logged_in');
                        $acp=explode(',',$logged_in['setting']);
			if(!in_array('All',$acp)){
			exit($this->lang->line('permission_denied'));
			}
			
		$data['cid']=$cid;
		// fetching group list
		$data['category_list']=$this->qbank_model->category_list();
		$data['title']=$this->lang->line('remove_category');
		$this->load->view('header',$data);
		$this->load->view('pre_remove_category',$data);
		$this->load->view('footer',$data);

		
		
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
		
	
	// level functions start
	public function level_list(){
						$logged_in=$this->session->userdata('logged_in');
                        $acp=explode(',',$logged_in['setting']);
			if(!in_array('All',$acp)){
			exit($this->lang->line('permission_denied'));
			}
		
		// fetching group list
		$data['level_list']=$this->qbank_model->level_list();
		$data['title']=$this->lang->line('level_list');
		$this->load->view('header',$data);
		$this->load->view('level_list',$data);
		$this->load->view('footer',$data);

		
		
		
	}
	
	
		public function insert_level()
	{
		
		
					$logged_in=$this->session->userdata('logged_in');
                        $acp=explode(',',$logged_in['setting']);
			if(!in_array('All',$acp)){
			exit($this->lang->line('permission_denied'));
			}
	
				if($this->qbank_model->insert_level()){
                $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('data_added_successfully')." </div>");
				}else{
				 $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('error_to_add_data')." </div>");
						
				}
				redirect('qbank/level_list/');
	
	}
	
			public function update_level($lid)
	{
		
		
					$logged_in=$this->session->userdata('logged_in');
                        $acp=explode(',',$logged_in['setting']);
			if(!in_array('All',$acp)){
			exit($this->lang->line('permission_denied'));
			}
	
				if($this->qbank_model->update_level($lid)){
                echo "<div class='alert alert-success'>".$this->lang->line('data_updated_successfully')." </div>";
				}else{
				 echo "<div class='alert alert-danger'>".$this->lang->line('error_to_update_data')." </div>";
						
				}
				 
	
	}
	
	
	
	
			public function remove_level($lid){
                       
					$logged_in=$this->session->userdata('logged_in');
                        $acp=explode(',',$logged_in['setting']);
			if(!in_array('All',$acp)){
			exit($this->lang->line('permission_denied'));
			}
$mlid=$this->input->post('mlid');
$this->db->query(" update savsoft_qbank set lid='$mlid' where lid='$lid' ");
 			
			if($this->qbank_model->remove_level($lid)){
                        $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('removed_successfully')." </div>");
					}else{
						    $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('error_to_remove')." </div>");
						
					}
					redirect('qbank/level_list');
                     
			
		}
	// level functions end
	
	
	
		public function pre_remove_level($lid){
		$data['lid']=$lid;
		// fetching group list
		$data['level_list']=$this->qbank_model->level_list();
		$data['title']=$this->lang->line('remove_level');
		$this->load->view('header',$data);
		$this->load->view('pre_remove_level',$data);
		$this->load->view('footer',$data);

		
		
		
	}
	
	
	
	
	
	
	
	
	
	
	function import()
		{	
					$logged_in=$this->session->userdata('logged_in');
                        $acp=explode(',',$logged_in['quiz']);
			if(!in_array('Add',$acp)){
			exit($this->lang->line('permission_denied'));
			}	

   $this->load->helper('xlsimport/php-excel-reader/excel_reader2');
   $this->load->helper('xlsimport/spreadsheetreader.php');


   
if(isset($_FILES['xlsfile'])){

                $config['upload_path']          = './xls/';
                $config['allowed_types']        = 'xls';
                $config['max_size']             = 10000;
                $this->load->library('upload', $config);
                if ( ! $this->upload->do_upload('xlsfile'))
                {
                        $error = array('error' => $this->upload->display_errors());
 $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$error['error']." </div>");
		redirect('qbank');				
                      exit;
                }
                else
                {
$data = array('upload_data' => $this->upload->data());
$targets = 'xls/';
$targets = $targets . basename($data['upload_data']['file_name']);
$Filepath = $targets;
			 
$allxlsdata = array();
	date_default_timezone_set('UTC');

	$StartMem = memory_get_usage();
	//echo '---------------------------------'.PHP_EOL;
	//echo 'Starting memory: '.$StartMem.PHP_EOL;
	//echo '---------------------------------'.PHP_EOL;

	try
	{
		$Spreadsheet = new SpreadsheetReader($Filepath);
		$BaseMem = memory_get_usage();

		$Sheets = $Spreadsheet -> Sheets();

		//echo '---------------------------------'.PHP_EOL;
		//echo 'Spreadsheets:'.PHP_EOL;
		//print_r($Sheets);
		//echo '---------------------------------'.PHP_EOL;
		//echo '---------------------------------'.PHP_EOL;

		foreach ($Sheets as $Index => $Name)
		{
			//echo '---------------------------------'.PHP_EOL;
			//echo '*** Sheet '.$Name.' ***'.PHP_EOL;
			//echo '---------------------------------'.PHP_EOL;

			$Time = microtime(true);

			$Spreadsheet -> ChangeSheet($Index);

			foreach ($Spreadsheet as $Key => $Row)
			{
				//echo $Key.': ';
				if ($Row)
				{
					//print_r($Row);
					$allxlsdata[] = $Row;
				}
				else
				{
					var_dump($Row);
				}
				$CurrentMem = memory_get_usage();
		
				//echo 'Memory: '.($CurrentMem - $BaseMem).' current, '.$CurrentMem.' base'.PHP_EOL;
				//echo '---------------------------------'.PHP_EOL;
		
				if ($Key && ($Key % 500 == 0))
				{
					//echo '---------------------------------'.PHP_EOL;
					//echo 'Time: '.(microtime(true) - $Time);
					//echo '---------------------------------'.PHP_EOL;
				}
			}
		
		//	echo PHP_EOL.'---------------------------------'.PHP_EOL;
			//echo 'Time: '.(microtime(true) - $Time);
			//echo PHP_EOL;

			//echo '---------------------------------'.PHP_EOL;
			//echo '*** End of sheet '.$Name.' ***'.PHP_EOL;
			//echo '---------------------------------'.PHP_EOL;
		}
		
	}
	catch (Exception $E)
	{
		echo $E -> getMessage();
	}


$this->qbank_model->import_question($allxlsdata);   
		
				}
			
				}
				
			else{
			echo "Error: " . $_FILES["file"]["error"];
			}	
  $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('data_imported_successfully')." </div>");
  redirect('qbank');
	}

	
	
	
	
	
	
	
	
	
	
	
}
