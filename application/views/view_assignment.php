 <div class="container">

   
 
   
 
			<?php 
		if($this->session->flashdata('message')){
			echo $this->session->flashdata('message');	
		}
		?>	

  <div class="row">
    
<div class="col-md-12">
<br> 
 <div class="panel panel-default">
 <div class="panel-heading">
 <h3><?php echo $title.' : '.$result['assignment_title']; ?></h3>
 </div>
		<div class="panel-body"> 
	
	
	
		
			<?php echo $result['assignment_description']; ?>
		 <br>
			 <?php 
			 if($result['attachments']!=''){
			 $filenameee=explode('.',$result['attachments']);
                       $ext=$filenameee[count($filenameee)-1];
			 ?>
			 <hr>
			<?php 
			if($ext=='mp4' || $ext=='ogg'){
			?>
			 <video width="320" height="240" controls>
  <source src="<?php echo base_url('upload/'.$result['attachments']);?>" type="video/mp4">
  <source src="<?php echo base_url('upload/'.$result['attachments']);?>" type="video/ogg">
Your browser does not support the video tag.
</video>
			 <?php }else{ ?>
			  <a href="<?php echo base_url('upload/'.$result['attachments']);?>" target="study_material"><?php echo $this->lang->line('attachment');?></a>
			
<?php } ?>
			 <?php 
			 }
			 ?>			
		</div>	<div class="panel-footer">
			<?php echo $this->lang->line('due_date');?>: <?php echo $result['due_date']; ?> 
			</div>
			<div class="panel-footer">

			 <?php echo $this->lang->line('category');?>: <?php echo $result['category_name']; ?>		
			
			</div>
			<div class="panel-footer">	
			 <?php echo $this->lang->line('group_name');?>: <br>
				
				<?php
				$gidz=explode(',',$result['gids']);
				
				 foreach($groups as $group){ ?>
		 	<?php
		 	if(in_array($group['gid'],$gidz)){ echo $group['group_name']; echo ", ";}
		 	  ?>
				<?php } ?>
					
			</div>
		 
</div>
 
 
	
	<a href="<?php echo site_url('assignment/'); ?>" ><?php echo $this->lang->line('back');?></a>

<a href="<?php echo site_url('assignment/csv/'.$result['assignment_id']); ?>" class="btn btn-primary"><?php echo $this->lang->line('csv_report');?></a>
<hr>
<?php 
$logged_in=$this->session->userdata('logged_in');
		        $acp=explode(',',$logged_in['assignment']);
			if(in_array('Add',$acp)){
		?>

<?php
}
?>
<h3><?php echo $this->lang->line('submitted_by_users');?></h3>

<?php 
if(count($uploaded_reports)==0){
echo $this->lang->line('no_record_found');
}
$sbt=0;
foreach($uploaded_reports as $k => $vals){
if($vals['uid']==$logged_in['uid']){
$sbt=1;
}
?>
<div class="panel panel-deault">
 
 
 <div class="panel-heading" >
 <div class="col-lg-6">
<a href="#"><?php echo $vals['first_name'].' '.$vals['last_name'];?></a>
<br>
<?php echo $this->lang->line('attachment'); ?> <a href="<?php echo base_url('upload/'.$vals['user_attachment']);?>" id="user_reports"><?php echo $this->lang->line('download'); ?></a>
<br>
<span style="font-size:11px;"><?php echo $this->lang->line('submitted_on').' '.$vals['reported_date']; ?></span>
<br>
<?php echo $this->lang->line('score');?>: <?php if($vals['evaluated']=='Pending'){ echo 'Pending';} else{ echo $vals['score'];}?>  
</div>
<div class="col-lg-6">
<?php 
$acp=explode(',',$logged_in['assignment']);
		         if(in_array('Add',$acp) || in_array('Edit',$acp)){
		        if($vals['evaluated']=='Pending'){ ?>
<form method="post" action="<?php echo site_url('assignment/insert_score/'.$result['assignment_id'].'/'.$vals['report_id']);?>" >
<input type="text" name="score"  placeholder="<?php echo $this->lang->line('score');?>" >
<input type="submit" value="<?php echo $this->lang->line('submit');?>">

</form>
<?php } } ?>
</div>
<div style="clear:both;"></div>
</div>
 </div>
 
<?php 
}
?>
<br><br>
<?php
		        $acp=explode(',',$logged_in['assignment']);
		         if(in_array('Submit',$acp)){
		         if($sbt==0){

?><div class="panel panel-default">
 <div class="panel-heading">
<h3><?php echo $this->lang->line('submit_report');?></h3>
</div>
<div class="panel-body">
 <?php echo form_open('assignment/upload_report/'.$result['assignment_id'],array('enctype'=>'multipart/form-data')); ?>
 <div class="form-group">	 
					<label for="inputEmail"  ><?php echo $this->lang->line('file_upload');?></label> 
					<input type="file" required  name="userfile"    > 
			</div>
			
			<button class="btn btn-default" type="submit"><?php echo $this->lang->line('submit');?></button>
 </form>
 </div>
 
<?php
}
}
?>

 
		</div>
</div>
 
 
 
 
</div>
     
</div>

 



</div>
