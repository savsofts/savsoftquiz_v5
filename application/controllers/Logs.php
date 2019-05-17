<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logs extends CI_Controller {

	 function __construct()
	 {
	   parent::__construct();
	   $this->load->database();
	   
	 }
	 
	 
	public function index($filename=''){
        if($filename==''){
        $filename="log-".date('Y-m-d',time()).".php";
        }
        echo "<pre>";
        $file_content=file_get_contents('application/logs/'.$filename);
       print_r($file_content);
        }	 
		 
		 
		
		
}
