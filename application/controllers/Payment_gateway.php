<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_gateway extends CI_Controller {

	 function __construct()
	 {
	   parent::__construct();
	   $this->load->database();
	   $this->load->helper('url');
	   $this->load->model("user_model");
	   $this->load->model("payment_model");
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
		$data['title']=$this->lang->line('payment_history');
		// fetching payment_history
		$data['payment_history']=$this->payment_model->payment_list($limit);
		$this->load->view('header',$data);
		$this->load->view('payment_list',$data);
		$this->load->view('footer',$data);
	}
	
function subscription_expired($uid){
				
		$data['uid']=$uid;
		$data['title']=$this->lang->line('subscription_expired');
		// fetching user info
		$data['user']=$this->user_model->get_user($uid);
		$this->load->view('header',$data);
		$this->load->view('subscription_expired',$data);
		$this->load->view('footer',$data);
	}
	
	
 
	
	
	
function generate_report(){
		// redirect if not loggedin
		if(!$this->session->userdata('logged_in')){
			redirect('login');
			
		}
					$logged_in=$this->session->userdata('logged_in');
                        $acp=explode(',',$logged_in['setting']);
			if(!in_array('All',$acp)){
			exit($this->lang->line('permission_denied'));
			}
			
		$this->load->helper('download');
		
		 $result=$this->payment_model->generate_report();
		$csvdata=$this->lang->line('transaction_id').",".$this->lang->line('email').",".$this->lang->line('first_name').",".$this->lang->line('last_name').",".$this->lang->line('payment_gateway').",".$this->lang->line('amount').",".$this->lang->line('paid_date').",".$this->lang->line('status')."\r\n";
		foreach($result as $rk => $val){
		$csvdata.=$val['transaction_id'].",".$val['email'].",".$val['first_name'].",".$val['last_name'].",".$val['payment_gateway'].",".$val['amount'].",".date('Y-m-d H:i:s',$val['paid_date']).",".$val['payment_status']."\r\n";
		}
		$filename=time().'.csv';
		force_download($filename, $csvdata);

	}
	
}
