 <div class="container">

   
 <h3><?php echo $title;?></h3>
   
 

  <div class="row">
     <form method="post" action="<?php echo site_url('user/edit_group/'.$gid);?>">
	
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
					<label for="inputEmail"  ><?php echo $this->lang->line('group_name');?></label> 
					<input type="text" required  name="group_name"  class="form-control"  value="<?php echo $group['group_name'];?>" > 
			</div>
			 
		 
<div class="form-group">	 
					<label for="inputEmail"  ><?php echo $this->lang->line('description');?></label> 
					<textarea  name="description"  class="form-control"   >   <?php echo $group['description'];?></textarea>
			</div>
			 
			<div class="form-group">	 
					<label for="inputEmail"  ><?php echo $this->lang->line('price');?></label> 
					<input type="text" required  name="price"  class="form-control"    value="<?php echo $group['price'];?>"   > 
			</div>
			<div class="form-group">	 
					<label for="inputEmail"  ><?php echo $this->lang->line('valid_for_days');?></label> 
					<input type="text" required  name="valid_for_days"  class="form-control"  value="<?php echo $group['valid_for_days'];?>"  > 
			</div>
		 

 
	<button class="btn btn-default" type="submit"><?php echo $this->lang->line('submit');?></button>
 
		</div>
</div>
 
 
 
 
</div>
      </form>
</div>

 



</div>
