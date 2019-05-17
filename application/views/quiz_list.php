 <div class="container">
<?php 
$logged_in=$this->session->userdata('logged_in');
		$uid=$logged_in['uid'];	 
			
			?>
   
 <h3><?php echo $title;?></h3>
    <?php 
	$list_view="table";
	     $acp=explode(',',$logged_in['quiz']);
			if(in_array('List_all',$acp)){
		?>
		<div class="row">
 
  <div class="col-lg-6">
    <form method="post" action="<?php echo site_url('quiz/index/0/'.$list_view);?>">
	<div class="input-group">
    <input type="text" class="form-control" name="search" placeholder="<?php echo $this->lang->line('search');?>...">
      <span class="input-group-btn">
        <button class="btn btn-default" type="submit"><?php echo $this->lang->line('search');?></button>
      </span>
	 
	  
    </div><!-- /input-group -->
	 </form>
  </div><!-- /.col-lg-6 -->
  <div class="col-lg-6">
  <p style="float:right;">
 
  </p>
  
  </div>
</div><!-- /.row -->

<?php 
	}
?>
<div class="row">
 
 
 <div class="col-lg-4">
   
<div class="card mb-4">
 <div class="card-header"  style="<?php if($stat=='active'){ echo 'background:#eeeeee;';}?> ">
 <a href="<?php echo site_url('quiz/index/'.$limit.'/table/active');?>"> <?php echo $this->lang->line('active');?>      
 <?php echo $this->lang->line('quiz');?>     
</a>
</div>
<div class="card-body"  >
	
<?php echo $active;?>	
						
</div>
</div>
</div>



 <div class="col-lg-4">
   
<div class="card mb-4">
 <div class="card-header"  style="<?php if($stat=='upcoming'){ echo 'background:#eeeeee;';}?> ">
 <a href="<?php echo site_url('quiz/index/'.$limit.'/table/upcoming');?>">   <?php echo $this->lang->line('upcoming');?>     
 <?php echo $this->lang->line('quiz');?>     
</a>
</div>
<div class="card-body"  >
		
		<?php echo $upcoming;?>
						
</div>
</div>
</div>



 <div class="col-lg-4">
   
<div class="card mb-4">
 <div class="card-header" style="<?php if($stat=='archived'){ echo 'background:#eeeeee;';}?> ">
  <a href="<?php echo site_url('quiz/index/'.$limit.'/table/archived');?>" >  <?php echo $this->lang->line('archived');?>     
 <?php echo $this->lang->line('quiz');?>     
</a>
</div>
<div class="card-body"  >
		
		<?php echo $archived;?>
						
</div>
</div>
</div>

 
</div>


  <div class="row">
 
<div class="col-md-12">
<br> 
			<?php 
		if($this->session->flashdata('message')){
			echo $this->session->flashdata('message');	
		}
		?>	
		 
<table class="table table-bordered">
<tr>
 <th>#</th>
 <th><?php echo $this->lang->line('quiz_name');?></th>
<th><?php echo $this->lang->line('noq');?></th>
<th><?php echo $this->lang->line('action');?> </th>
</tr>
<?php 
if(count($result)==0){
	?>
<tr>
 <td colspan="3"><?php echo $this->lang->line('no_record_found');?></td>
</tr>	
	
	
	<?php
}
foreach($result as $key => $val){
?>
<tr>
 <td><?php echo $val['quid'];?></td>
 <td><?php echo substr(strip_tags($val['quiz_name']),0,50);?></td>
<td><?php echo $val['noq'];?></td>
 <td>
 <?php 
 if($val['quiz_price'] == 0 || in_array($val['quid'],$purchased_quiz)){
if($val['end_date'] >=time()){	 ?>
	 
<a href="<?php echo site_url('quiz/quiz_detail/'.$val['quid']);?>" class="btn btn-success"  ><?php echo $this->lang->line('attempt');?> </a>

<?php
}
if($val['end_date'] < time()){	 ?>
	 
<a href="#" class="btn btn-warning"  ><?php echo $this->lang->line('expired');?> </a>

<?php
}
if($val['start_date'] > time()){	 ?>
	 
<a href="#" class="btn btn-default"  ><?php echo $this->lang->line('upcoming');?> </a>

<?php
}
 
 }else{
 ?>
<a href="<?php echo site_url('payment_gateway_2/subscribe/0/'.$uid.'/'.$val['quid']);?>" class="btn btn-primary"  ><?php echo $this->config->item('base_currency_prefix').' '.$val['quiz_price'].' '.$this->config->item('base_currency_sufix')." ".$this->lang->line('paynow');?> </a>

 
 <?php 
 }
 ?>
<?php 
	     $acp=explode(',',$logged_in['quiz']);
		
			if(in_array('List_all',$acp)){
	?>
		 
<a href="<?php echo site_url('quiz/edit_quiz/'.$val['quid']);?>"><img src="<?php echo base_url('images/edit.png');?>"></a>
<a href="javascript:remove_entry('quiz/remove_quiz/<?php echo $val['quid'];?>');"><img src="<?php echo base_url('images/cross.png');?>"></a>
<?php 
}
?>
</td>
</tr>

<?php 
}
?>
</table>

   

</div>

</div>
<br><br>

<?php
if(($limit-($this->config->item('number_of_rows')))>=0){ $back=$limit-($this->config->item('number_of_rows')); }else{ $back='0'; } ?>

<a href="<?php echo site_url('quiz/index/'.$back.'/'.$list_view);?>"  class="btn btn-primary"><?php echo $this->lang->line('back');?></a>
&nbsp;&nbsp;
<?php
 $next=$limit+($this->config->item('number_of_rows'));  ?>

<a href="<?php echo site_url('quiz/index/'.$next.'/'.$list_view);?>"  class="btn btn-primary"><?php echo $this->lang->line('next');?></a>





</div>