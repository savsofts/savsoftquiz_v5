<div class="">

   
 <h3><?php echo $title;?></h3>
   
 

  <div class="row">
     <form method="post" action="<?php echo site_url('advertisment/update_advertisment/'.$add_id);?>" enctype="multipart/form-data">
	
	<div class="col-md-8">
	<br> 
	 <div class="login-panel panel panel-default">
		<div class="panel-body"> 
	
	
	
			<?php 
		if($this->session->flashdata('message')){
			echo $this->session->flashdata('message');	
			}
		?>	
		
		
		 	<div class="form-group">
<label>Position</label> 
<?php echo $result['position'];
if($result['position']=='During_Quiz'){ echo "<div class='alert alert-danger'>Google adsense code may not work on this position so you can use banner advertisement.</div>"; } ?>
</div>		 	<div class="form-group">
	<label for="input name">Advertisment code</label> 
	<textarea class="form-control" name="advertisment_code" rows="5" ><?php echo $result['advertisement_code'];?></textarea>
 
         
  </div><div class="form-group"> 
	<label for="input name">Banner</label> 
	<input type="file" name="userfile" >
       					  </div><div class="form-group"> 
       					  <label for="input name">Banner Link/URL</label> 
	<input type="text" name="banner_link" value="<?php echo $result['banner_link'];?>" class="form-control" >
 </div>
 <div class="form-group"> 
  
	<label for="input name">Ad Status</label> 

					<select name="add_status" class="form-control">
			<option value="Active" <?php if($result['add_status']=="Active"){ echo 'selected';} ?> >Active</option>
			<option value="Inactive" <?php if($result['add_status']=="Inactive"){ echo 'selected';} ?> >Inactive</option>
					
					</select>
					  </div>
    <button class="btn btn-success" type="submit">submit</button>
 			<br><br><br>
		</div>
	   </div>
