<h3><?php echo $this->lang->line('duplicate_question_found');?></h3><?php 
 
foreach($result as $key => $val){
?>
<?php
$qn=1;
if($val['question_type']==$this->lang->line('multiple_choice_single_answer')){
	$qn=1;
}
if($val['question_type']==$this->lang->line('multiple_choice_multiple_answer')){
	$qn=2;
}
if($val['question_type']==$this->lang->line('match_the_column')){
	$qn=3;
}
if($val['question_type']==$this->lang->line('short_answer')){
	$qn=4;
}
if($val['question_type']==$this->lang->line('long_answer')){
	$qn=5;
}


?>

<p>
<label> <a href="<?php echo site_url('qbank/edit_question_'.$qn.'/'.$val['qid']);?>" target="edit_question" >
 <?php echo substr(strip_tags($val['question']),0,40);?></a></label>
<br>
 <?php echo $val['question_type'];?> <br>
 <span style="font-size:12px;"><?php echo $val['category_name'];?> / <?php echo $val['level_name'];?></span> 
 
</p> 

 
<?php 
}
?>  
