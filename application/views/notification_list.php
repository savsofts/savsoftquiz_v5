 <div class="container">
 <?php 
 $logged_in=$this->session->userdata('logged_in');
		
		?>  
 
   
 <h3><?php echo $title;?></h3>
    <div class="row">
 
  <div class="col-lg-6">
    <form method="post" action="<?php echo site_url('notification/index/');?>">
	<div class="input-group">
    <input type="text" class="form-control" name="search" placeholder="<?php echo $this->lang->line('search');?>...">
      <span class="input-group-btn">
        <button class="btn btn-default" type="submit"><?php echo $this->lang->line('search');?></button>
      </span>
	 
	  
    </div><!-- /input-group -->
	 </form>
  </div><!-- /.col-lg-6 -->
</div><!-- /.row -->


  <div class="row">
 
<div class="col-md-12">
<br> 
			<?php 
		if($this->session->flashdata('message')){
			echo $this->session->flashdata('message');	
		}
		                        $acp=explode(',',$logged_in['setting']);
			if(in_array('All',$acp)){
			 
		?>	
		
 <a href="<?php echo site_url('notification/add_new');?>" class="btn btn-success"><?php echo $this->lang->line('add_new');?></a><br><br>
 <?php 
 }
 ?>
<table class="table table-bordered">
<tr>
 <th>#</th>
 <th><?php echo $this->lang->line('title');?></th>
<th><?php echo $this->lang->line('message');?> </th>
<?php
if($logged_in['su']=='1'){
?>
<th><?php echo $this->lang->line('click_action');?></th>
<th><?php echo $this->lang->line('notification_to');?> </th> 
<?php 
}
?>
<th><?php echo $this->lang->line('date');?> </th> 
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
 <td><?php echo $val['nid'];?></td>
 <td><a href="<?php echo $val['click_action'];?>" target="fcmclick"><?php echo $val['title'];?></a></td>
  <td><?php echo $val['message'];?></td>
  <?php
if($logged_in['su']=='1'){
?>
 <td><?php echo $val['click_action'];?></td>
 <td><?php 
 if($val['uid']==0){
 ?>
 <?php echo $this->lang->line('all_users');?>
 <?php
  }else{ 
 ?><a href="<?php echo site_url('user/edit_user/'.$val['uid']);?>"><?php echo $val['first_name'].' '.$val['last_name'];?></a>
 <?php 
 }
 ?>
 
 </td>
 <?php 
 }
 ?>
<td><?php echo $val['notification_date'];?></td>
 
</tr>

<?php 
}
?>
</table>
 </div>

</div>


<?php
if(($limit-($this->config->item('number_of_rows')))>=0){ $back=$limit-($this->config->item('number_of_rows')); }else{ $back='0'; } ?>

<a href="<?php echo site_url('notification/index/'.$back);?>"  class="btn btn-primary"><?php echo $this->lang->line('back');?></a>
&nbsp;&nbsp;
<?php
 $next=$limit+($this->config->item('number_of_rows'));  ?>

<a href="<?php echo site_url('notification/index/'.$next);?>"  class="btn btn-primary"><?php echo $this->lang->line('next');?></a>





</div>
