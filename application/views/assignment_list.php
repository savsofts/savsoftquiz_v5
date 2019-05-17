 <div class="container">
 <?php 
 $logged_in=$this->session->userdata('logged_in');
		
		?>  
 
   
 <h3><?php echo $title;?></h3>
    <div class="row">
 
  <div class="col-lg-6">
    <form method="post" action="<?php echo site_url('assignment/index/');?>">
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
		$logged_in=$this->session->userdata('logged_in');
		        $acp=explode(',',$logged_in['study_material']);
			if(in_array('Add',$acp)){
			 
		?>	
		
 <a href="<?php echo site_url('assignment/add_new');?>" class="btn btn-success"><?php echo $this->lang->line('add_new');?></a><br><br>
 <?php 
 }
 ?>
<table class="table table-bordered">
<tr>
 <th>#</th>
 <th><?php echo $this->lang->line('title');?></th>
<th><?php echo $this->lang->line('description');?> </th>

<th><?php echo $this->lang->line('due_date');?></th>
<?php //if($logged_in['su']=='1'){ ?>
<th><?php echo $this->lang->line('action');?> </th> 
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
 <td><?php echo $val['assignment_id'];?></td>
 <td><?php echo $val['assignment_title'];?></td>
  <td><?php echo substr($val['assignment_description'],0,50);?>...</td>
  <td><?php echo $val['due_date'];?></td>
 
<td>
<?php 
$acp=explode(',',$logged_in['study_material']);
if(in_array('Edit',$acp)){
?>
<a href="<?php echo site_url('assignment/edit_assignment/'.$val['assignment_id']);?>"><?php echo $this->lang->line('edit');?></a>
<?php } ?>
<?php 
$acp=explode(',',$logged_in['study_material']);
if(in_array('View',$acp)){
?>
<a href="<?php echo site_url('assignment/view_assignment/'.$val['assignment_id']);?>"><?php echo $this->lang->line('view');?></a>
<?php } ?>
<?php 
$acp=explode(',',$logged_in['study_material']);
if(in_array('Remove',$acp)){
?>
<a href="<?php echo site_url('assignment/remove_assignment/'.$val['assignment_id']);?>"><?php echo $this->lang->line('remove');?></a>
<?php } ?>
</td>
 
</tr>

<?php 
}
?>
</table>
 </div>

</div>


<?php
if(($limit-($this->config->item('number_of_rows')))>=0){ $back=$limit-($this->config->item('number_of_rows')); }else{ $back='0'; } ?>

<a href="<?php echo site_url('assignment/index/'.$back);?>"  class="btn btn-primary"><?php echo $this->lang->line('back');?></a>
&nbsp;&nbsp;
<?php
 $next=$limit+($this->config->item('number_of_rows'));  ?>

<a href="<?php echo site_url('assignment/index/'.$next);?>"  class="btn btn-primary"><?php echo $this->lang->line('next');?></a>





</div>
