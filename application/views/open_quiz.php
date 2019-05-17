<div class="row"  style="border-bottom:1px solid #dddddd;">
<div class="container"  >
<div class="col-md-1">
</div>
<div class="col-md-10">
<a href="<?php echo base_url();?>"><img src="<?php echo base_url('images/logo.png');?>"></a>
<?php echo $this->lang->line('login_tagline');?>
</div>
<div class="col-md-1">
</div>

</div>

</div>

<div class="row" style="margin-top:20px;">
<div class="container" >   
 
 
 
<?php 
		if($this->session->flashdata('message')){
			 echo $this->session->flashdata('message'); 
			 	
		}
		?>		


<div class="col-md-8">
<h3><?php echo $this->lang->line('all_quizzes');?></h3>
 
<?php 
foreach($open_quiz as $key => $val){
?>
<div style="margin-top:30px;">
<label><a href="<?php echo site_url('quiz/quiz_detail/'.$val['quid'].'/'.urlencode($val['quiz_name'])); ?>"><?php echo $val['quiz_name'];?></a></label> 
<span style="font-size:12px;color:#999;"><?php echo $this->lang->line('available');?> <?php echo date('d M y h:i A',$val['start_date']);?>
</span>
<p>
<span style="font-size:12px;color:#999;">
<?php echo substr(strip_tags($val['description']),0,100);?>
</span>
<br>
<?php echo $this->lang->line('questions');?>: <?php echo $val['noq'];?> | 
<?php echo $this->lang->line('duration2');?> <?php echo $val['duration'];?> Min. 
</p>
</div>
<?php 
}
if(count($open_quiz)==0){
	echo $this->lang->line('no_record_found');
}
?>
<br><br>
<?php
if(($limit-($this->config->item('number_of_rows')))>=0){ $back=$limit-($this->config->item('number_of_rows')); }else{ $back='0'; } ?>

<a href="<?php echo site_url('quiz/open_quiz/'.$back);?>"  class="btn btn-default"><?php echo $this->lang->line('back');?></a>
&nbsp;&nbsp;
<?php
 $next=$limit+($this->config->item('number_of_rows'));  ?>

<a href="<?php echo site_url('quiz/open_quiz/'.$next);?>"  class="btn btn-default"><?php echo $this->lang->line('next');?></a>
&nbsp;&nbsp;
<a href="<?php echo base_url();?>"   ><?php echo $this->lang->line('login');?></a>


</div>
<div class="col-md-4">

	 
</div>
 

</div>

</div>