 <div class="container">
 <?php 
 $logged_in=$this->session->userdata('logged_in');
		
		?>  
 
   
 <h3><?php echo $title;?></h3>
  
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
 <th><?php echo $this->lang->line('requested_by');?></th>
 <th><?php echo $this->lang->line('appointed_to');?> </th>

<th><?php echo $this->lang->line('appointment_time');?></th>
<th><?php echo $this->lang->line('status');?></th>
<?php //if($logged_in['su']=='1'){ ?>
 
<?php // } ?>

</tr>
<?php 
if(count($result)==0){
	?>
<tr>
 <td colspan="6"><?php echo $this->lang->line('no_record_found');?></td>
</tr>	
	
	
	<?php
}
foreach($result as $key => $val){
?>
<tr>
 <td><?php echo $val['appointment_id'];?></td>
 <td><?php echo $val['requested_by_name'];?> <br><?php echo $this->lang->line('skype_id');?>: <?php echo $val['requested_by_skype'];?></td>
  <td><?php echo $val['appointed_to_name'];?> <br><?php echo $this->lang->line('skype_id');?>: <?php echo $val['appointed_to_skype'];?></td>
  <td><?php echo $val['appointment_timing'];?></td> 
  <td><?php echo $val['appointment_status'];
  if($val['appointment_status']=="Pending" && $logged_in['uid']==$val['to_id']){
  ?>  &nbsp;&nbsp;
  <a href="<?php echo site_url('appointment/change_status/'.$val['appointment_id'].'/Accepted');?>" class="btn btn-success btn-sm"><?php echo $this->lang->line('accept');?></a>
 
  <a href="<?php echo site_url('appointment/change_status/'.$val['appointment_id'].'/Rejected');?>" class="btn btn-danger btn-sm"><?php echo $this->lang->line('reject');?></a>
  <?php
  } 
  
  ?></td> 
 
 
</tr>

<?php 
}
?>
</table>
 </div>

</div>


<?php
if(($limit-($this->config->item('number_of_rows')))>=0){ $back=$limit-($this->config->item('number_of_rows')); }else{ $back='0'; } ?>

<a href="<?php echo site_url('appointment/myappointment/'.$back);?>"  class="btn btn-primary"><?php echo $this->lang->line('back');?></a>
&nbsp;&nbsp;
<?php
 $next=$limit+($this->config->item('number_of_rows'));  ?>

<a href="<?php echo site_url('appointment/myappointment/'.$next);?>"  class="btn btn-primary"><?php echo $this->lang->line('next');?></a>





</div>
