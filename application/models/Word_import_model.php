<?php
Class word_import_model extends CI_Model
{



function import_ques($questionm){
  
$questioncid=$this->input->post('cid');
$questiondid=$this->input->post('lid');
foreach($questionm as $key => $singlequestion){
 
	//$ques_type= 
	
//echo $ques_type; 

if($key >= 0){
//echo "<pre>";print_r($singlequestion);exit;
$question= str_replace('"','&#34;',$singlequestion['question']);
 
$question= str_replace("`",'&#39;',$question);
$question= str_replace("‘",'&#39;',$question);
$question= str_replace("’",'&#39;',$question);
$question= str_replace("â€œ",'&#34;',$question);
$question= str_replace("â€˜",'&#39;',$question);



$question= str_replace("â€™",'&#39;',$question);
$question= str_replace("â€",'&#34;',$question);
$question= str_replace("'","&#39;",$question);
$question= str_replace("\n","<br>",$question);

$paragraph= str_replace('"','&#34;',$singlequestion['paragraph']);
 
//$description= str_replace('"','&#34;',$singlequestion['2']);
//$description= str_replace("'","&#39;",$description);
//$description= str_replace("\n","<br>",$description);
$description= str_replace('"','&#34;',$singlequestion['description']);
$description= str_replace("`",'&#39;',$description);
$description= str_replace("‘",'&#39;',$description);
$description= str_replace("’",'&#39;',$description);
$description= str_replace("â€œ",'&#34;',$description);
$description= str_replace("â€˜",'&#39;',$description);



$description= str_replace("â€™",'&#39;',$description);
$description= str_replace("â€",'&#34;',$description);
$description= str_replace("'","&#39;",$description);
$description= str_replace("\n","<br>",$description);

if(isset($singlequestion['question1'])){
$question1= str_replace('"','&#34;',$singlequestion['question1']);
$description1= str_replace('"','&#34;',$singlequestion['description1']);
$paragraph1= str_replace('"','&#34;',$singlequestion['paragraph1']);
}

$option_count=count($singlequestion['option']);
$ques_type="0";
if($option_count!="0"){
	if($singlequestion['correct']!=""){
		if (strpos($singlequestion['correct'],',') !== false) {
		  $ques_type="1";
		  
		}else{

		$ques_type="0";
		}
	}else{
		// $ques_type="5";
	}
}else{
/*
if($singlequestion['correct']!=""){
	if (strpos($question,'_____') !== false) {
		  $ques_type="2";
		  
		}else{
			$ques_type="3";
		}

}else{
$ques_type="4";
}
*/
}
 if($ques_type==0){
	$ques_type2="Multiple Choice Single Answer"; 
 }
 if($ques_type==1){
	$ques_type2="Multiple Choice Multiple Answer"; 
 }
 
//$ques_type= $singlequestion['0'];
$corect_position=array(
		'A' => '0',
		'B' => '1',
		'C' => '2',
		'D' => '3',
		'E' => '4'
		);
	$insert_data = array(
	'cid' => $questioncid,
	'lid' => $questiondid,
	'question' =>$question,
	'paragraph' =>$paragraph,
	'description' =>$description,
	'question_type' => $ques_type2 
	);
	
	if(isset($singlequestion['question1'])){
	$insert_data['question1']=$singlequestion['question1'];
	$insert_data['paragraph1']=$singlequestion['paragraph1'];
	$insert_data['description1']=$singlequestion['description1'];
	}
	
	if($this->db->insert('savsoft_qbank',$insert_data)){
		$qid=$this->db->insert_id();
		$optionkeycounter = 4;
		if($ques_type=="0" || $ques_type=="1"){
$correct_op=array_filter(explode(',',$singlequestion['correct']));
$correct_option_position=array();

foreach($correct_op as $v){
 
$correct_option_position[]=$corect_position[trim($v)];
 
 
}
 
		foreach($singlequestion['option'] as $corect_key => $correct_val){
				
	if(in_array($corect_key, $correct_option_position)){
$divideratio=count($correct_option_position);
$correctoption =1/$divideratio;
}else{
$correctoption = 0;
}										
				$insert_options = array(
				"qid" =>$qid,
				"q_option" => $correct_val,
				"score" => $correctoption
				);
					if(isset($singlequestion['option1'])){
$insert_options['q_option1']=$singlequestion['option1'][$corect_key];
}
				$this->db->insert("savsoft_options",$insert_options);
				
				
			
			}
	}
	/*multiple type
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
				"option_value" => $singlequestion[$optionkeycounter],
				"institute_id" => $institute_id,
				"score" => $correctoptionm[$i-1]
				);
				$this->db->insert("q_options",$insert_options);
				$optionkeycounter++;
				
				
				}
			
			}
	}
	
	//multiple type end*/	
	
	//fillups
		if($ques_type=="2" || $ques_type=="3"){
		
			
				$insert_options = array(
				"qid" =>$qid,
				"option_value" => $singlequestion['correct'],
				"institute_id" => $institute_id,
				"score" => "1"
				);
				$this->db->insert("q_options",$insert_options);
				
				
				
			
			
			}
	
		
	//endfillups
	
	/*short Answer
		if($ques_type=="3"){
		for($i=1;$i<=1;$i++){
			
			if($singlequestion[$optionkeycounter] != ""){
				if($singlequestion['3'] == $i){ $correctoption ='1'; }
				$insert_options = array(
				"qid" =>$qid,
				"option_value" => $singlequestion[$optionkeycounter],
				"institute_id" => $institute_id,
				"score" => $correctoption
				);
				$this->db->insert("q_options",$insert_options);
				$optionkeycounter++;
				}
				
				}
			
			}
	
	//end Short answer*/
	
	//match Answer
		if($ques_type=="5"){
			




		foreach($singlequestion['option'] as $corect_key => $correct_val){
				
	
$divideratio=count(array_filter($singlequestion['option']));
$correctoption =1/$divideratio;
										
				$insert_options = array(
				"qid" =>$qid,
				"option_value" => $correct_val,
				"institute_id" => $institute_id,
				"score" => $correctoption
				);
				$this->db->insert("q_options",$insert_options);
				
				
			
			}
			///h
		
			
			}
	
	//end match answer
	
		}//
		}
	}

/*
$institute_id = $this->session->userdata('institute_id');
if($question['question'] != ""){
			$insert_data = array(
			'cid' => $question['cid'],
			'did' => $question['did'],
			'question' => $question['question'],
			'institute_id' => $institute_id
			);
			
 	
			if($this->db->insert('qbank',$insert_data)){
			$qid=$this->db->insert_id();
			foreach($question['option'] as $key => $value){
			$sc=$question['score']-1;
			if($key==$sc){
			$score="1";
			}else{
			$score="0";
			}
			if($value != ""){
			$insert_data = array(
			'qid' => $qid,
			'option_value' => $value,
			'score'=> $score,
			'institute_id' => $institute_id
			);
			}
			$this->db->insert('q_options',$insert_data);
			}
			}
			}
			*/
}



}
?>
