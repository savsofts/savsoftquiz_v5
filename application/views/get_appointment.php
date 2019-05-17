 <div class="container">

   
 <h3><?php echo $title;?></h3>
   
 

  <div class="row">
      <?php echo form_open('appointment/get_appointment/'.$to_id,array('enctype'=>'multipart/form-data')); ?>

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
					<label for="inputEmail"  ><?php echo $this->lang->line('appointed_to');?></label> 
					<input type="text" required  name="to_name"  class="form-control" value="<?php echo $user['first_name'].' '.$user['last_name'];?>"  > 
					<input type="hidden" name="to_id" value="<?php echo $to_id; ?>" >
			</div>
			 
		 	<div class="form-group">	 
					<label for="inputEmail"  ><?php echo $this->lang->line('appointment_timing');?></label> 
					<input type="text" required  name="appointment_timing"  class="form-control" value="<?php echo date('Y-m-d H:i:s',time());?>"  > 
			</div>
			 
		 
  

 
	<button class="btn btn-default" type="submit"><?php echo $this->lang->line('submit');?></button>
 
		</div>
</div>
 
 
 
 
</div>
      </form>
</div>

 



</div>
