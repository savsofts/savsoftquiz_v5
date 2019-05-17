 <div class="container">

   
 
   
 
			<?php 
		if($this->session->flashdata('message')){
			echo $this->session->flashdata('message');	
		}
		?>	

  <div class="row">
    
 
<br> 
 <div class="card panel-default">
 <div class="card-heading" style="padding:10px;">
 <h3><?php echo $title.' : '.$result['title']; ?></h3>
 </div>
		<div class="card-body" style="padding:10px;"> 
	
 
		
			<?php  echo $result['study_description']; ?>
			
			 
		 <br>
			 <?php 
			 if($result['attachment']!=''){
			 $filenameee=explode('.',$result['attachment']);
                       $ext=$filenameee[count($filenameee)-1];
			 ?>
			 <hr>
			<?php 
			if($ext=='mp4' || $ext=='ogg'){
			?>
			 <video width="320" height="240" controls>
  <source src="<?php echo base_url('upload/'.$result['attachment']);?>" type="video/mp4">
  <source src="<?php echo base_url('upload/'.$result['attachment']);?>" type="video/ogg">
Your browser does not support the video tag.
</video>
			 <?php }else{ ?>
			  <a href="<?php echo base_url('upload/'.$result['attachment']);?>" target="study_material">Download <?php echo $this->lang->line('attachment');?></a>
			
<?php } ?>
			 <?php 
			 }
			 ?>			
		</div>	 
			<div class="card-footer" style="padding:10px;">

			 <?php echo $this->lang->line('category');?>: <?php echo $result['category_name']; ?>		
			
			</div>
			<div class="card-footer" style="padding:10px;">	
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
 
	<a href="<?php echo site_url('study_material/'); ?>"><?php echo $this->lang->line('back');?></a>
 
		 
</div>
 
 
 
 
</div>
     
</div>

 


 










 
