<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Install extends CI_Controller {

	 function __construct()
	 {
	   parent::__construct();
 $this->load->helper('url');
	 }

	public function index()
	{
			$this->lang->load('basic', $this->config->item('language'));
		
		$data['title']=$this->lang->line('installation_process');
 

		
	 
	 
		$this->load->view('header',$data);
		$this->load->view('installation',$data);
		$this->load->view('footer',$data);
	}
	
	 function config_sq(){
		$this->lang->load('basic', $this->config->item('language'));

		if($this->input->post('force_write')){
		if(chmod("./application/config/sq_config.php",0777)){ } 	
		}
	 
		$file="./application/config/sq_config.php";
		
		$content="<?php 
		$"."sq_base_url='".$this->input->post('sq_base_url')."';
		$"."sq_hostname='".$this->input->post('sq_hostname')."';
		$"."sq_dbname='".$this->input->post('sq_dbname')."';
		$"."sq_dbusername='".$this->input->post('sq_dbusername')."';
		$"."sq_dbpassword='".$this->input->post('sq_dbpassword')."';
		?>";
		 
		 file_put_contents($file,$content);
		 
		 
		 
		 
		 // run sql file
		 
		 
			$hostname=$this->input->post('sq_hostname');
			$database=$this->input->post('sq_dbname');
			$username=$this->input->post('sq_dbusername');
			$password=$this->input->post('sq_dbpassword');
			$adminemail=$this->input->post('adminemail');
			$adminpassword=$this->input->post('adminpassword');
			 $link = mysqli_connect($hostname, $username, $password, $database);

			/* check connection */
			if (mysqli_connect_errno()) {
				printf("Connect failed: %s\n", mysqli_connect_error());
				exit();
			}
			$query=file_get_contents("savsoftquiz_v5_0.sql");
			if (mysqli_multi_query($link, $query)) {
				$burl="<a href='".$this->input->post('sq_base_url')."'>".$this->input->post('sq_base_url')."</a>";
			$data['result']=str_replace("ADMINEMAIL",$adminemail,str_replace("ADMINPASS",$adminpassword,str_replace("{base_url}",$burl,$this->lang->line('installation_completed'))));
			$mpass=md5($adminpassword);
			  
			 
			}else{
			$data['result']=$this->lang->line('installation_failed');			
			}
			$this->load->database();
			$pq=" update savsoft_users set email='$adminemail', password='$mpass' where uid='1' ";
			
			$this->db->query($pq);
			$data['title']="";
		// $this->load->view('header',$data);
		$this->load->view('installation2',$data);
		// $this->load->view('footer',$data);
		
		if($this->input->post('force_write')){
		if(chmod("./application/config/sq_config.php",0644)){ } 	
		}
		
		if(chmod("./upload/",0777)){ } 
		if(chmod("./xls/",0777)){ } 
		if(chmod("./photo/",0777)){ }  
		rename("./application/controllers/Install.php","./application/controllers/".time()."Install.php");
		
		 /*
		$sq_base_url='http://localhost/savsoftquiz_v3.0/';
		$sq_hostname='localhost';
		$sq_dbname='';
		$sq_dbusername='root';
		$sq_dbpassword='';
		*/
		
	 }
	 
	 
	 
	
}
