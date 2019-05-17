 <div class="container">

   
 <h3><?php echo $title;?></h3>
   
 

  <div class="row">
     <form method="post" action="<?php echo site_url('user/add_new_group');?>">
	
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
					<input type="text" required  name="group_name"  class="form-control"   > 
			</div>
			 
		 
<div class="form-group">	 
					<label for="inputEmail"  ><?php echo $this->lang->line('description');?></label> 
					<textarea  name="description"  class="form-control"   ></textarea>
			</div>
			 
			<div class="form-group">	 
					<label for="inputEmail"  ><?php echo $this->lang->line('price');?></label> 
					<input type="text" required  name="price"  class="form-control"  value="0" > <br>
					<p class="alert alert-warning">Free version doesn't support payment gateway. <br>Create free group (with zero price) or <a href="<?php echo site_url('payment_gateway');?>">Upgrade version</a>
			</div>
			<div class="form-group">	 
					<label for="inputEmail"  ><?php echo $this->lang->line('valid_for_days');?></label> 
					<input type="text" required  name="valid_for_days"  class="form-control"  value="0" > 
			</div>
		 

 
	<button class="btn btn-default" type="submit"><?php echo $this->lang->line('submit');?></button>
 
		</div>
</div>
 
 
 
 
</div>
      </form>
</div>

 



</div>
