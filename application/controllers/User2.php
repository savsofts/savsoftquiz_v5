<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User2 extends CI_Controller {

	 function __construct()
	 {
	   parent::__construct();
	   $this->load->database();
	   $this->load->helper('url');
	   $this->load->model("user_model");
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

	public function index($limit='0')
	{
	 
	}
	
	 

	public function view_user($uid)
	{
		
			$logged_in=$this->session->userdata('logged_in');
			if($logged_in['su']!='1'){
			 $uid=$logged_in['uid'];
			}
			
			$data['uid']=$uid;
	        $data['title']=$this->lang->line('profile');
	        
	        $query1=$this->db->query(" select * from savsoft_result where uid='$uid' order by rid desc ");
	        $res1=$query1->result_array();
	        $query2=$this->db->query(" select * from savsoft_result where uid='$uid' and result_status='Pass' ");
	        $query3=$this->db->query(" select * from savsoft_result where uid='$uid' and result_status='Fail' ");
	        if($query1->num_rows()==0){
	        $data['lastattempt']="Not attempted any quiz";
	        }else{
	        $data['lastattempt']=date('Y-m-d h:i:s', $res1[0]['start_time']);
	        }
	        $data['attempted']=$query1->num_rows();
	        $data['pass']=$query2->num_rows();
	        $data['fail']=$query3->num_rows();
	        
	        $category=array();
	        $category_recent=array();
	        $incorrect_answers=array();
	        // getting categories
	        
	        if(count($res1) != 0){
	        foreach($res1 as $k => $val){
	        $i=1;
	        
	                         $scores=explode(',',$val['score_individual']);
	                         $range=explode(',',$val['category_range']);
	                         $rqids=explode(',',$val['r_qids']);
	                        
	                foreach(explode(',',$val['categories']) as $ck =>$cv){
	                $score_arr=0;
	                $counts=0;
	                 
	        
	                        for($j=$i; $j < ($i+$range[$ck]); $j++){
	                        if($scores[$j-1] != 2){
	                                $score_arr+=$scores[$j-1];
	                                $counts+=1;
	                                }
	                                if($scores[$j-1] == 0){
	                                // incorrect answer. add question id
	                                if(!isset($incorrect_answers[$rqids[$j-1]])){
	                                $incorrect_answers[$rqids[$j-1]]=$rqids[$j-1];
	                                } 
	                                }
	                                 
	                        }
	                        $i+=$range[$ck];
	                        if(isset($category[$cv])){
	                        if($score_arr != 0){
	                        $category[$cv]=($category[$cv]+(($score_arr/$counts)*100))/2;
	                        } 
	                   
	                        }else{
	                        if($score_arr != 0){
	                        $category[$cv]=($score_arr/$counts)*100;
	                        }else{
	                        $category[$cv]=0;
	                        }
	                        if($score_arr != 0){
	                        $category_recent[$cv]=($score_arr/$counts)*100;
	                        }else{
	                        $category_recent[$cv]=0;
	                        }
	                        }
	                       
	                }
	                
	                
	                
	        
	        }
	        
	        $incorrect_answers_new=array(0);
	         foreach($incorrect_answers as $kk => $vv){
	         if($kk < 100){
	          $incorrect_answers_new[]=$vv;
	          }
	         }
	         $incorrect_answers_new=array_filter($incorrect_answers_new);
	         $incorrect_answers_new=implode(',',$incorrect_answers_new);
	         if($incorrect_answers_new==''){
	         $incorrect_answers_new=0;
	         }
	       // getting questions
	       $query4=$this->db->query(" select * from savsoft_qbank where qid in ($incorrect_answers_new) ");
	       $questions=$query4->result_array();
	       $query5=$this->db->query(" select * from savsoft_options where qid in ($incorrect_answers_new) ");
	       $options=$query5->result_array();
	          }
	        $data['questions']=$questions;
		 $data['options']=$options;
		$data['categories']=$category;
		$data['category_recent']=$category_recent;
		// fetching user
		$data['result']=$this->user_model->get_user($uid);
		$this->load->model("payment_model");
		$data['payment_history']=$this->payment_model->get_payment_history($uid);
		// fetching group list
		$data['group_list']=$this->user_model->group_list();
		 $this->load->view('header',$data);
		$this->load->view('profile',$data);
		$this->load->view('footer',$data);
	}

	 
}
