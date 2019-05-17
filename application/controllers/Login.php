<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	 function __construct()
	 {
	   parent::__construct();
	   $this->load->database();
	   $this->load->model("user_model");
	    $this->load->model("quiz_model");
	   $this->lang->load('basic', $this->config->item('language'));
		if($this->db->database ==''){
		$this->load->helper('url');
		redirect('install');	
		}
		 
		 
		 
		
		
	 }

	public function index()
	{
		
		$this->load->helper('url');
		if($this->session->userdata('logged_in')){
			$logged_in=$this->session->userdata('logged_in');
			if($logged_in['su']=='1'){
				redirect('dashboard');
			}else{
				redirect('quiz');	
			}
			
		}
		
		
		
		$data['title']=$this->lang->line('login');
		$data['recent_quiz']=$this->quiz_model->recent_quiz('5');
		
		 $this->load->view('login',$data);
		 
	}
	
	public function resend()
	{
		
		
		 $this->load->helper('url');
		if($this->input->post('email')){
		$status=$this->user_model->resend($this->input->post('email'));
		$this->session->set_flashdata('message', $status);
		redirect('login/resend');
		}
		
		
		$data['title']=$this->lang->line('resend_link');
		 
		$this->load->view('header',$data);
		$this->load->view('resend',$data);
		$this->load->view('footer',$data);
	}
	
	
 
	
		function addtocart($gid,$gname,$price){
		$this->load->helper('url');
		if($this->session->userdata('cart')){
			$d=$this->session->userdata('cart');
		$d[]=array(
			$gid,$gname,$price
			);		
		}else{
			$d=array();
		$d[]=array(
			$gid,$gname,$price
			);	
		}
		$this->session->set_userdata('cart',$d);
		$this->session->set_flashdata('message', 'Group added into cart');
			redirect('login/registration/');
	}
	
	function clearcart(){
		$this->load->helper('url');
			$this->session->unset_userdata('cart');
			$this->session->set_flashdata('message', 'Cart cleared successfully');
			redirect('login/pre_registration');
	}
	function clearcartval($gid){
		$this->load->helper('url');
		$d=array();
		foreach($this->session->userdata('cart') as $k => $v){
		if($v[0]==$gid){

		}else{
			$d[]=$v;
		}		
		}
			$this->session->set_userdata('cart',$d);
			$this->session->set_flashdata('message', 'Group removed from cart');
			redirect('login/pre_registration');
	}
	
	
	
	
	
		public function pre_registration()
	{
	$this->load->helper('url');
		$data['title']=$this->lang->line('select_package');
		// fetching group list
		$data['group_list']=$this->user_model->group_list();
		$this->load->view('header',$data);
		$this->load->view('pre_register',$data);
		$this->load->view('footer',$data);
	}

	
		public function registration($gid='0')
	{
	$this->load->helper('url');
		$data['gid']=$gid;
		$data['title']=$this->lang->line('register_new_account');
		$data['custom_form']=$this->user_model->custom_form('Registration');
		// fetching group list
		$data['group_list']=$this->user_model->group_list();
		$this->load->view('header',$data);
		$this->load->view('register',$data);
		$this->load->view('footer',$data);
	}

	
	public function verifylogin($p1='',$p2=''){
		
		if($p1 == ''){
		$username=$this->input->post('email');
		$password=$this->input->post('password');
		}else{
		$username=urldecode($p1);
		$password=urldecode($p2);
		}
		 $status=$this->user_model->login($username,$password);
		if($status['status']=='1'){
			$this->load->helper('url');
			// row exist fetch userdata
			$user=$status['user'];
			$gids=$user['gid'];
			$uid=$user['uid'];
			 $sl="select * from savsoft_group where gid in ($gids) ";
			$rq=$this->db->query($sl);
			 
			$gr=$rq->result_array();
			 
			$price=0;
				
				
			foreach($gr as $pk => $pv){
				$gid=$pv['gid'];
				$sl2="select * from savsoft_payment where uid='$uid' and gid='$gid' and payment_status='Paid' ";
				 
				$sl3=$this->db->query($sl2);
				// echo $sl3->num_rows(); echo "<br>";
				
			if($sl3->num_rows() >= 1){
					
				}else{
			$price += $pv['price'];	
				}
			}
		 
			// validate if user assigned to paid group
			if($price > '0'){
				
				// user assigned to paid group now validate expiry date.
				if($user['subscription_expired'] <= time()){
					// eubscription expired, redirect to payment page
					
					redirect('payment_gateway_2/subscribe/'.$gids.'/'.$user['uid']);
					
				}
				
			}
			 
			$user['base_url']=base_url();
			// creating login cookie
			$this->session->set_userdata('logged_in', $user);
			// redirect to dashboard
			if($user['su']=='1'){
			 redirect('dashboard');
				 
			}else{
				$burl=$this->config->item('base_url').'index.php/quiz';
			 header("location:$burl");
			}
		}else if($status['status']=='0'){
			 
			// invalid login
			// try to auth wp
			if($this->config->item('wp-login')){
			 
		                if($this->authentication($username, $password)){
		               
		                 $this->verifylogin($username, $password);
		                }else{
		                 $this->load->helper('url');
		                 $this->session->set_flashdata('message', $status['message']);
			 $burl=$this->config->item('base_url');
			 header("location:$burl");
		                }
		        }else{
		        
		        $this->load->helper('url');
		        $this->session->set_flashdata('message', $status['message']);
			redirect('login');
		        }
		        
			
		}else if($status['status']=='2'){
                        $this->load->helper('url');

			 
			// email not verified
			$this->session->set_flashdata('message', $status['message']);
			redirect('login');
		}else if($status['status']=='3'){
                        $this->load->helper('url');

			 
			// email not verified
			$this->session->set_flashdata('message', $status['message']);
			redirect('login');
		}
		
		
		
	}
	
	
	
	
		
	function verify($vcode){
		$this->load->helper('url');	 
		 if($this->user_model->verify_code($vcode)){
			 $data['title']=$this->lang->line('email_verified');
		   $this->load->view('header',$data);
			$this->load->view('verify_code',$data);
		  $this->load->view('footer',$data);

			}else{
			 $data['title']=$this->lang->line('invalid_link');
		   $this->load->view('header',$data);
			$this->load->view('verify_code',$data);
		  $this->load->view('footer',$data);

			}
	}
	
	
	
	
	function forgot(){
	$this->load->helper('url');
			if($this->input->post('email')){
			$user_email=$this->input->post('email');
			 if($this->user_model->reset_password($user_email)){
				$this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('password_updated')." </div>");
						
			}else{
				$this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('email_doesnot_exist')." </div>");
						
			}
			redirect('login/forgot');
			}
			
  
			$data['title']=$this->lang->line('forgot_password');
		   $this->load->view('header',$data);
			$this->load->view('forgot_password',$data);
		  $this->load->view('footer',$data);

	
	}
	
	
		public function insert_user()
	{
		
		
		 $this->load->helper('url');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email', 'required|is_unique[savsoft_users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required');
          if ($this->form_validation->run() == FALSE)
                {
                     $this->session->set_flashdata('message', "<div class='alert alert-danger'>".validation_errors()." </div>");
					redirect('login/registration/');
                }
                else
                {
					if($this->user_model->insert_user_2()){
                        if($this->config->item('verify_email')){
						$this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('account_registered_email_sent')." </div>");
						}else{
							$this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('account_registered')." </div>");
						}
						}else{
						    $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('error_to_add_data')." </div>");
						
					}
					redirect('login/registration/');
                }       

	}
	
	
	
	
	function verify_result($rid){
		$this->load->helper('url');
		$this->load->model("result_model");
		
			$data['result']=$this->result_model->get_result($rid);
	if($data['result']['gen_certificate']=='0'){
		exit();
	}
	
	
	$certificate_text=$data['result']['certificate_text'];
	$certificate_text=str_replace('{email}',$data['result']['email'],$certificate_text);
	$certificate_text=str_replace('{first_name}',$data['result']['first_name'],$certificate_text);
	$certificate_text=str_replace('{last_name}',$data['result']['last_name'],$certificate_text);
	$certificate_text=str_replace('{percentage_obtained}',$data['result']['percentage_obtained'],$certificate_text);
	$certificate_text=str_replace('{score_obtained}',$data['result']['score_obtained'],$certificate_text);
	$certificate_text=str_replace('{quiz_name}',$data['result']['quiz_name'],$certificate_text);
	$certificate_text=str_replace('{status}',$data['result']['result_status'],$certificate_text);
	$certificate_text=str_replace('{result_id}',$data['result']['rid'],$certificate_text);
	$certificate_text=str_replace('{generated_date}',date('Y-m-d',$data['result']['end_time']),$certificate_text);
	
	$data['certificate_text']=$certificate_text;
	  $this->load->view('view_certificate_2',$data);
	 

	}
	
	
	
	function authentication ($user, $pass){
                  global $wp, $wp_rewrite, $wp_the_query, $wp_query;

                  if(empty($user) || empty($pass)){
                    return false;
                  }else{
                    require_once($this->config->item('wp-path'));
                    $status = false;
                    $auth = wp_authenticate($user, $pass );
                    if( is_wp_error($auth) ) {      
                      $status = false;
                    } else {
                    
                    // if username already exist in savsoft_users
                    $this->db->where('wp_user',$user);
                    $query=$this->db->get('savsoft_users');
                    if($query->num_rows()==0){
                    $userdata=array(
                    'password'=>md5($pass),
                    'wp_user'=>$user,
                    'su'=>0,
                    'gid'=>$this->config->item('default_group')                  
                    
                    );
                    $this->db->insert('savsoft_users',$userdata);
                    
                    }
                    
                    
                      $status = true;
                    }
                    return $status;
                  } 
        }
        
        
        public function commercial(){
        $this->load->helper('url');
		
       $data['title']=$this->lang->line('files_missing');
		   $this->load->view('header',$data);
			$this->load->view('files_missing',$data);
		  $this->load->view('footer',$data);
        }



		 // super admin code login controller 
	public function superadminlogin(){
	$this->load->helper('url');
			$logged_in=$this->session->userdata('logged_in_super_admin');
			if($logged_in['su']!='3'){
				exit('permission denied');
				
			}
			
		$user=$this->user_model->admin_login();
		$user['base_url']=base_url();
		 $user['super']=3;
		$this->session->set_userdata('logged_in', $user);
		redirect('dashboard');
	}
	
	
}
