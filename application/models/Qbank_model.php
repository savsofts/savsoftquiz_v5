<?php
Class Qbank_model extends CI_Model
{
 
  function question_list($limit,$cid='0',$lid='0'){
	$logged_in=$this->session->userdata('logged_in');
	 if($this->input->post('search')){
		 $search=$this->input->post('search');
		 $this->db->or_where('savsoft_qbank.qid',$search);
		 $this->db->or_like('savsoft_qbank.question',$search);
		 $this->db->or_like('savsoft_qbank.description',$search);

	 }
	 if($cid!='0'){
		  $this->db->where('savsoft_qbank.cid',$cid);
	 }
	 if($lid!='0'){
		  $this->db->where('savsoft_qbank.lid',$lid);
	 }
	 if($logged_in['uid'] != '1'){
	 $uid=$logged_in['uid'];
	 $this->db->where('savsoft_qbank.inserted_by',$uid);
	 }
		 $this->db->join('savsoft_category','savsoft_category.cid=savsoft_qbank.cid');
	 $this->db->join('savsoft_level','savsoft_level.lid=savsoft_qbank.lid');
	 $this->db->limit($this->config->item('number_of_rows'),$limit);
		$this->db->order_by('savsoft_qbank.qid','desc');
		$query=$this->db->get('savsoft_qbank');
		return $query->result_array();
		
	 
 }
 
 
 function num_qbank(){
 $logged_in=$this->session->userdata('logged_in');
	
		 if($logged_in['uid'] != '1'){
	 $uid=$logged_in['uid'];
	 $this->db->where('savsoft_qbank.inserted_by',$uid);
	 } 
	 $query=$this->db->get('savsoft_qbank');
		return $query->num_rows();
 }
 
 
 
 function get_question($qid){
	 $this->db->where('qid',$qid);
	 $query=$this->db->get('savsoft_qbank');
	 return $query->row_array();
	 
	 
 }
 function get_option($qid){
	 $this->db->where('qid',$qid);
	 $query=$this->db->get('savsoft_options');
	 return $query->result_array();
	 
	 
 }
 
 function remove_question($qid){
	 
	 $this->db->where('qid',$qid);
	 if($this->db->delete('savsoft_qbank')){
		  $this->db->where('qid',$qid);
			$this->db->delete('savsoft_options');
			
						
	$qr=$this->db->query("select * from savsoft_quiz where FIND_IN_SET($qid, qids) ");
	 
			foreach($qr->result_array() as $k =>$val){
			
			$quid=$val['quid'];
			$qids=explode(',',$val['qids']);
			$nqids=array();
			foreach($qids as $qk => $qv){
			if($qv != $qid){
			$nqids[]=$qv;
			}
			}
			$noq=count($nqids);
			$nqids=implode(',',$nqids);
			$this->db->query(" update savsoft_quiz set qids='$nqids', noq='$noq' where quid='$quid' ");
			}
			
			
		 return true;
	 }else{
		 
		 return false;
	 }
	 
	 
 }
 
 function insert_question_1(){
	 

	  
	 $userdata=array(
	 'paragraph'=>$this->input->post('paragraph'),
	 'question'=>$this->input->post('question'),
	 'description'=>$this->input->post('description'),
	 'question_type'=>$this->lang->line('multiple_choice_single_answer'),
	 'cid'=>$this->input->post('cid'),
	 'lid'=>$this->input->post('lid')	 
	 );
	  $logged_in=$this->session->userdata('logged_in');
	  $uid=$logged_in['uid'];
	  $fname=$logged_in['first_name'].' '.$logged_in['last_name'];
	  $userdata['inserted_by']=$uid;
	  $userdata['inserted_by_name']=$fname;
	  
	  $lang=$this->config->item('question_lang');
	  foreach($lang as $lk => $lv){
		  if($lk > 0){
		  if($this->input->post('question'.$lk)){
				$userdata['paragraph'.$lk]=$this->input->post('paragraph'.$lk); 
				$userdata['question'.$lk]=$this->input->post('question'.$lk); 
					$userdata['description'.$lk]=$this->input->post('description'.$lk); 
			}	 
		  }		  
	  }
	  
	 $this->db->insert('savsoft_qbank',$userdata);
	 $qid=$this->db->insert_id();
	 $this->session->set_flashdata('qid',$qid);
	 foreach($this->input->post('option') as $key => $val){
		 if($this->input->post('score')==$key){
			 $score=1;
		 }else{
			 $score=0;
		 }
	$userdata=array(
	 'q_option'=>$val,
	 'qid'=>$qid,
	 'score'=>$score,
	 );
	  $lang=$this->config->item('question_lang');
	  foreach($lang as $lk => $lv){
		   
		  if($lk > 0){
			   
		  if(isset($_POST['option'.$lk])){
			  print_r($this->input->post('option1'));
			  $eopo=$this->input->post('option'.$lk);
				$userdata['q_option'.$lk]=$eopo[$key];  
			}	 
		  }		  
	  }
	  
	  
	 $this->db->insert('savsoft_options',$userdata);	 
		 
	 }
	 
	 return true;
	 
 }

 function insert_question_2(){
	 
	 
	 $userdata=array(
	 'paragraph'=>$this->input->post('paragraph'),
	 	 'question'=>$this->input->post('question'),
	 'description'=>$this->input->post('description'),
	 'question_type'=>$this->lang->line('multiple_choice_multiple_answer'),
	 'cid'=>$this->input->post('cid'),
	 'lid'=>$this->input->post('lid')	 
	 );
	  $logged_in=$this->session->userdata('logged_in');
	  $uid=$logged_in['uid'];
	  $fname=$logged_in['first_name'].' '.$logged_in['last_name'];
	  $userdata['inserted_by']=$uid;
	  $userdata['inserted_by_name']=$fname;
	  
	 $this->db->insert('savsoft_qbank',$userdata);
	 $qid=$this->db->insert_id();
	 $this->session->set_flashdata('qid',$qid);
	 foreach($this->input->post('option') as $key => $val){
		 if(in_array($key,$this->input->post('score'))){
			 $score=(1/count($this->input->post('score')));
		 }else{
			 $score=0;
		 }
	$userdata=array(
	 'q_option'=>$val,
	 'qid'=>$qid,
	 'score'=>$score,
	 );
	 $this->db->insert('savsoft_options',$userdata);	 
		 
	 }
	 
	 return true;
	 
 }
 
 
 function insert_question_3(){
	 
	 
	 $userdata=array(
	  'paragraph'=>$this->input->post('paragraph'),
	 'question'=>$this->input->post('question'),
	 'description'=>$this->input->post('description'),
	 'question_type'=>$this->lang->line('match_the_column'),
	 'cid'=>$this->input->post('cid'),
	 'lid'=>$this->input->post('lid')	 
	 );
	 	  $logged_in=$this->session->userdata('logged_in');
	  $uid=$logged_in['uid'];
	  $fname=$logged_in['first_name'].' '.$logged_in['last_name'];
	  $userdata['inserted_by']=$uid;
	  $userdata['inserted_by_name']=$fname;
	 $this->db->insert('savsoft_qbank',$userdata);
	 $qid=$this->db->insert_id();
	 $this->session->set_flashdata('qid',$qid);
	 foreach($this->input->post('option') as $key => $val){
	  $score=(1/count($this->input->post('option')));
	$userdata=array(
	 'q_option'=>$val,
	 'q_option_match'=>$_POST['option2'][$key],
	 'qid'=>$qid,
	 'score'=>$score,
	 );
	 $this->db->insert('savsoft_options',$userdata);	 
		 
	 }
	 
	 return true;
	 
 }
 
 
 
 
 function insert_question_4(){
	 
	 
	 $userdata=array(
	  'paragraph'=>$this->input->post('paragraph'),
	 'question'=>$this->input->post('question'),
	 'description'=>$this->input->post('description'),
	 'question_type'=>$this->lang->line('short_answer'),
	 'cid'=>$this->input->post('cid'),
	 'lid'=>$this->input->post('lid')	 
	 );
	 	  $logged_in=$this->session->userdata('logged_in');
	  $uid=$logged_in['uid'];
	  $fname=$logged_in['first_name'].' '.$logged_in['last_name'];
	  $userdata['inserted_by']=$uid;
	  $userdata['inserted_by_name']=$fname;
	 $this->db->insert('savsoft_qbank',$userdata);
	 $qid=$this->db->insert_id();
	 $this->session->set_flashdata('qid',$qid);
	 foreach($this->input->post('option') as $key => $val){
	  $score=1;
	$userdata=array(
	 'q_option'=>$val,
	 'qid'=>$qid,
	 'score'=>$score,
	 );
	 $this->db->insert('savsoft_options',$userdata);	 
		 
	 }
	 
	 return true;
	 
 }
 
 
 function insert_question_5(){
	 
	 
	 $userdata=array(
	  'paragraph'=>$this->input->post('paragraph'),
	 'question'=>$this->input->post('question'),
	 'description'=>$this->input->post('description'),
	 'question_type'=>$this->lang->line('long_answer'),
	 'cid'=>$this->input->post('cid'),
	 'lid'=>$this->input->post('lid')	 
	 );
	 	  $logged_in=$this->session->userdata('logged_in');
	  $uid=$logged_in['uid'];
	  $fname=$logged_in['first_name'].' '.$logged_in['last_name'];
	  $userdata['inserted_by']=$uid;
	  $userdata['inserted_by_name']=$fname;
	 $this->db->insert('savsoft_qbank',$userdata);
	 $qid=$this->db->insert_id();
	 $this->session->set_flashdata('qid',$qid);
	 
	 return true;
	 
 }
 
 
 
  function update_question_1($qid){
	 
	 
	 $userdata=array(
	  'paragraph'=>$this->input->post('paragraph'),
	 'question'=>$this->input->post('question'),
	 'description'=>$this->input->post('description'),
	 'question_type'=>$this->lang->line('multiple_choice_single_answer'),
	 'cid'=>$this->input->post('cid'),
	 'lid'=>$this->input->post('lid')	 
	 );
	 	  $lang=$this->config->item('question_lang');
	  foreach($lang as $lk => $lv){
		  if($lk > 0){
		  if($this->input->post('question'.$lk)){
				$userdata['paragraph'.$lk]=$this->input->post('paragraph'.$lk); 
				$userdata['question'.$lk]=$this->input->post('question'.$lk); 
					$userdata['description'.$lk]=$this->input->post('description'.$lk); 
			}	 
		  }		  
	  }
	 $this->db->where('qid',$qid);
	 $this->db->update('savsoft_qbank',$userdata);
	 $this->db->where('qid',$qid);
	$this->db->delete('savsoft_options');
	 foreach($this->input->post('option') as $key => $val){
		 
		 
		 if($this->input->post('score')==$key){
			 $score=1;
		 }else{
			 $score=0;
		 }
	$userdata=array(
	 'q_option'=>$val,
	 'qid'=>$qid,
	 'score'=>$score,
	 );
	   $lang=$this->config->item('question_lang');
	  foreach($lang as $lk => $lv){
		   
		  if($lk > 0){
			   
		  if(isset($_POST['option'.$lk])){
			  print_r($this->input->post('option1'));
			  $eopo=$this->input->post('option'.$lk);
				$userdata['q_option'.$lk]=$eopo[$key];  
			}	 
		  }		  
	  }
	 $this->db->insert('savsoft_options',$userdata);	 
		 
	 }
	 
	 return true;
	 
 }

 
 
 
 
  function update_question_2($qid){
	 
	 
	 $userdata=array(
	  'paragraph'=>$this->input->post('paragraph'),
	 'question'=>$this->input->post('question'),
	 'description'=>$this->input->post('description'),
	 'question_type'=>$this->lang->line('multiple_choice_multiple_answer'),
	 'cid'=>$this->input->post('cid'),
	 'lid'=>$this->input->post('lid')	 
	 );
	 $this->db->where('qid',$qid);
	 $this->db->update('savsoft_qbank',$userdata);
	 $this->db->where('qid',$qid);
	$this->db->delete('savsoft_options');
	 foreach($this->input->post('option') as $key => $val){
		 if(in_array($key,$this->input->post('score'))){
			 $score=(1/count($this->input->post('score')));
		 }else{
			 $score=0;
		 }
	$userdata=array(
	 'q_option'=>$val,
	 'qid'=>$qid,
	 'score'=>$score,
	 );
	 $this->db->insert('savsoft_options',$userdata);	 
		 
	 }
	 
	 return true;
	 
 }
 
 
 function update_question_3($qid){
	 
	 
	 $userdata=array(
	  'paragraph'=>$this->input->post('paragraph'),
	 'question'=>$this->input->post('question'),
	 'description'=>$this->input->post('description'),
	 'question_type'=>$this->lang->line('match_the_column'),
	 'cid'=>$this->input->post('cid'),
	 'lid'=>$this->input->post('lid')	 
	 );
	 	 $this->db->where('qid',$qid);
	 $this->db->update('savsoft_qbank',$userdata);
	 $this->db->where('qid',$qid);
	$this->db->delete('savsoft_options');
	foreach($this->input->post('option') as $key => $val){
	  $score=(1/count($this->input->post('option')));
	$userdata=array(
	 'q_option'=>$val,
	 'q_option_match'=>$_POST['option2'][$key],
	 'qid'=>$qid,
	 'score'=>$score,
	 );
	 $this->db->insert('savsoft_options',$userdata);	 
		 
	 }
	 
	 return true;
	 
 }
 
 
 
 
 function update_question_4($qid){
	 
	 
	 $userdata=array(
	 'paragraph'=>$this->input->post('paragraph'),
	  'question'=>$this->input->post('question'),
	 'description'=>$this->input->post('description'),
	 'question_type'=>$this->lang->line('short_answer'),
	 'cid'=>$this->input->post('cid'),
	 'lid'=>$this->input->post('lid')	 
	 );
		 $this->db->where('qid',$qid);
	 $this->db->update('savsoft_qbank',$userdata);
	 $this->db->where('qid',$qid);
	$this->db->delete('savsoft_options');
 foreach($this->input->post('option') as $key => $val){
	  $score=1;
	$userdata=array(
	 'q_option'=>$val,
	 'qid'=>$qid,
	 'score'=>$score,
	 );
	 $this->db->insert('savsoft_options',$userdata);	 
		 
	 }
	 
	 return true;
	 
 }
 
 
 function update_question_5($qid){
	 
	 
	 $userdata=array(
	  'paragraph'=>$this->input->post('paragraph'),
	 'question'=>$this->input->post('question'),
	 'description'=>$this->input->post('description'),
	 'question_type'=>$this->lang->line('long_answer'),
	 'cid'=>$this->input->post('cid'),
	 'lid'=>$this->input->post('lid')	 
	 );
		 $this->db->where('qid',$qid);
	 $this->db->update('savsoft_qbank',$userdata);
	 $this->db->where('qid',$qid);
	$this->db->delete('savsoft_options');

	 
	 return true;
	 
 }
 
 
 
 
 // category function start
 function category_list(){
	 $this->db->order_by('cid','desc');
	 $query=$this->db->get('savsoft_category');
	 return $query->result_array();
	 
 }
 
 
 
 
 function update_category($cid){
	 
		$userdata=array(
		'category_name'=>$this->input->post('category_name'),
		 	
		);
	 
		 $this->db->where('cid',$cid);
		if($this->db->update('savsoft_category',$userdata)){
			
			return true;
		}else{
			
			return false;
		}
	 
 }
  
 
 
 function remove_category($cid){
	 
	 $this->db->where('cid',$cid);
	 if($this->db->delete('savsoft_category')){
		 return true;
	 }else{
		 
		 return false;
	 }
	 
	 
 }
 
  
 
 function insert_category(){
	 
	 	$userdata=array(
		'category_name'=>$this->input->post('category_name'),
			);
		
		if($this->db->insert('savsoft_category',$userdata)){
			
			return true;
		}else{
			
			return false;
		}
	 
 }
 
 // category function end
 
 
 

 
 
// level function start
 function level_list(){
	  $query=$this->db->get('savsoft_level');
	 return $query->result_array();
	 
 }
 
 
 
 
 function update_level($lid){
	 
		$userdata=array(
		'level_name'=>$this->input->post('level_name'),
		 	
		);
	 
		 $this->db->where('lid',$lid);
		if($this->db->update('savsoft_level',$userdata)){
			
			return true;
		}else{
			
			return false;
		}
	 
 }
  
 
 
 function remove_level($lid){
	 
	 $this->db->where('lid',$lid);
	 if($this->db->delete('savsoft_level')){
		 return true;
	 }else{
		 
		 return false;
	 }
	 
	 
 }
 
  
 
 function insert_level(){
	 
	 	$userdata=array(
		'level_name'=>$this->input->post('level_name'),
			);
		
		if($this->db->insert('savsoft_level',$userdata)){
			
			return true;
		}else{
			
			return false;
		}
	 
 }
 
 // level function end
 

 
 
 
 
 function import_question($question){
//echo "<pre>"; print_r($question);exit;
 $questioncid=$this->input->post('cid');
$questiondid=$this->input->post('did');
$prevqid="";
$prevtype="";
foreach($question as $key => $singlequestion){
	//$ques_type= 
	
//echo $ques_type; 

if($key != 0){
// echo "<pre>";print_r($singlequestion); exit;
$question= str_replace('"','&#34;',$singlequestion['1']);
$question= str_replace("`",'&#39;',$question);
$question= str_replace("‘",'&#39;',$question);
$question= str_replace("’",'&#39;',$question);
$question= str_replace("â€œ",'&#34;',$question);
$question= str_replace("â€˜",'&#39;',$question);



$question= str_replace("â€™",'&#39;',$question);
$question= str_replace("â€",'&#34;',$question);
$question= str_replace("'","&#39;",$question);
$question= str_replace("\n","<br>",$question);
$description= str_replace('"','&#34;',$singlequestion['2']);
$description= str_replace("'","&#39;",$description);
$description= str_replace("\n","<br>",$description);
$ques_type= $singlequestion['0'];
if(trim($ques_type) !=""){
if($ques_type=="0"){
$question_type=$this->lang->line('multiple_choice_single_answer');	
}
if($ques_type=="1"){
$question_type=$this->lang->line('multiple_choice_multiple_answer');	
}
if($ques_type=="2"){
$question_type=$this->lang->line('match_the_column');	
}
if($ques_type=="3"){
$question_type=$this->lang->line('short_answer');	
}
if($ques_type=="4"){
$question_type=$this->lang->line('long_answer');	
}


	$insert_data = array(
	'cid' => $questioncid,
	'lid' => $questiondid,
	'question' =>$question,
	'description' => $description,
	'question_type' => $question_type
	);
	
	if($this->db->insert('savsoft_qbank',$insert_data)){
	
		$qid=$this->db->insert_id();
		$prevoid=array();
	$prevqid=$qid;
	$prevtype=$ques_type;
		
		$optionkeycounter = 4;
		if($ques_type=="0" || $ques_type==""){
		for($i=1;$i<=10;$i++){
			if($singlequestion[$optionkeycounter] != ""){
				if($singlequestion['3'] == $i){ $correctoption ='1'; }
				else{ $correctoption = 0; }
				$insert_options = array(
				"qid" =>$qid,
				"q_option" => $singlequestion[$optionkeycounter],
				"score" => $correctoption
				);
				$this->db->insert("savsoft_options",$insert_options);
				$prevoid[]=$this->db->insert_id();
				$optionkeycounter++;
				}
			
			}
	}
	//multiple type
	if($ques_type=="1"){
			$correct_options=explode(",",$singlequestion['3']);
			$no_correct=count($correct_options);
			$correctoptionm=array();
			for($i=1;$i<=10;$i++){
			if($singlequestion[$optionkeycounter] != ""){
			foreach($correct_options as $valueop){
				if($valueop == $i){ $correctoptionm[$i-1] =(1/$no_correct);
					break;
					}
				else{ $correctoptionm[$i-1] = 0; }
			}
			}
			}
			
			//print_r($correctoptionm);
			
		for($i=1;$i<=10;$i++){
		
			if($singlequestion[$optionkeycounter] != ""){
			
				$insert_options = array(
				"qid" =>$qid,
				"q_option" => $singlequestion[$optionkeycounter],
				"score" => $correctoptionm[$i-1]
				);
				$this->db->insert("savsoft_options",$insert_options);
				$prevoid[]=$this->db->insert_id();
				$optionkeycounter++;
				
				
				}
			
			}
	}
	
	//multiple type end	
	
 //match Answer
		if($ques_type=="2"){
			$qotion_match=0;
			for($j=1;$j<=10;$j++){
			
			if($singlequestion[$optionkeycounter] != ""){
				
				$qotion_match+=1;
				$optionkeycounter++;
				}
				
				}
			///h
			$optionkeycounter=4;
		for($i=1;$i<=10;$i++){
			
			if($singlequestion[$optionkeycounter] != ""){
				$explode_match=explode('=',$singlequestion[$optionkeycounter]);
				 $correctoption =1/$qotion_match; 
				$insert_options = array(
				"qid" =>$qid,
				"q_option" =>$explode_match[0] ,
				"q_option_match" =>$explode_match[1] ,
				 "score" => $correctoption
				);
				$this->db->insert("savsoft_options",$insert_options);
				$prevoid[]=$this->db->insert_id();
				$optionkeycounter++;
				}
				
				}
			
			}
	
	//end match answer
	
	//short Answer
		if($ques_type=="3"){
		for($i=1;$i<=1;$i++){
			
			if($singlequestion[$optionkeycounter] != ""){
				if($singlequestion['3'] == $i){ $correctoption ='1'; }
				$insert_options = array(
				"qid" =>$qid,
				"q_option" => $singlequestion[$optionkeycounter],
				"score" => $correctoption
				);
				$this->db->insert("savsoft_options",$insert_options);
				$prevoid[]=$this->db->insert_id();
				$optionkeycounter++;
				}
				
				}
			
			}
	
	//end Short answer
	
	
	
		}//
		
		}else{
		 
		$update_data = array(
	 'question1' =>$question,
	'description1' => $description 
	);
	$this->db->where('qid',$prevqid);
	 $this->db->update('savsoft_qbank',$update_data);
		 
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		$optionkeycounter = 4;
		if($prevtype=="0" ){
		for($i=1;$i<=10;$i++){
			if($singlequestion[$optionkeycounter] != ""){
				if($singlequestion['3'] == $i){ $correctoption ='1'; }
				else{ $correctoption = 0; }
				$insert_options = array(
				 "q_option1" => $singlequestion[$optionkeycounter],
				 );
				 $this->db->where('oid',$prevoid[$i-1]);
				$this->db->update("savsoft_options",$insert_options);
				$optionkeycounter++;
				}
			
			}
	}
	//multiple type
	if($ques_type=="1"){
			$correct_options=explode(",",$singlequestion['3']);
			$no_correct=count($correct_options);
			$correctoptionm=array();
			for($i=1;$i<=10;$i++){
			if($singlequestion[$optionkeycounter] != ""){
			foreach($correct_options as $valueop){
				if($valueop == $i){ $correctoptionm[$i-1] =(1/$no_correct);
					break;
					}
				else{ $correctoptionm[$i-1] = 0; }
			}
			}
			}
			
			//print_r($correctoptionm);
			
		for($i=1;$i<=10;$i++){
		
			if($singlequestion[$optionkeycounter] != ""){
			
				$insert_options = array(
				 "q_option1" => $singlequestion[$optionkeycounter],
				 );
				 $this->db->where('oid',$prevoid[$i-1]);
				$this->db->update("savsoft_options",$insert_options);
				$optionkeycounter++;
				
				
				}
			
			}
	}
	
	//multiple type end	
	
 //match Answer
		if($ques_type=="2"){
			$qotion_match=0;
			for($j=1;$j<=10;$j++){
			
			if($singlequestion[$optionkeycounter] != ""){
				
				$qotion_match+=1;
				$optionkeycounter++;
				}
				
				}
			///h
			$optionkeycounter=4;
		for($i=1;$i<=10;$i++){
			
			if($singlequestion[$optionkeycounter] != ""){
				$explode_match=explode('=',$singlequestion[$optionkeycounter]);
				 $correctoption =1/$qotion_match; 
				$insert_options = array(
				 "q_option1" =>$explode_match[0] ,
				"q_option_match1" =>$explode_match[1] ,
				 );
				$this->db->where('oid',$prevoid[$i-1]);
				$this->db->update("savsoft_options",$insert_options);
				$optionkeycounter++;
				}
				
				}
			
			}
	
	//end match answer
	
	//short Answer
		if($ques_type=="3"){
		for($i=1;$i<=1;$i++){
			
			if($singlequestion[$optionkeycounter] != ""){
				if($singlequestion['3'] == $i){ $correctoption ='1'; }
				$insert_options = array(
				 "q_option1" => $singlequestion[$optionkeycounter],
				 );
				$this->db->where('oid',$prevoid[$i-1]);
				$this->db->update("savsoft_options",$insert_options);
				$optionkeycounter++;
				}
				
				}
			
			}
	
	//end Short answer
	
	
		
		
		
		
		
		
		
		
		
		
		
		
		}
		
		}
	}

 
}






 
}







 



?>
