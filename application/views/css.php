 <div class="container">

   
 
  



<div class="row">


<form class="form-signin" method="post" action="<?php echo site_url('dashboard/css');?>" >
<h4><?php echo $this->lang->line('custom_css');?></h4>
<br>

			 
			
<br>
<div class="form-group">	
<textarea name="config_val" style="width:800px;height:500px;"><?php echo $result;?></textarea>
 

 			</div>
 			<div class="form-group">	  
					<button class="btn btn-primary" type="submit"><?php echo $this->lang->line('submit');?></button>
			</div>
 <input type="checkbox" name="force_write"  > <span style="font-size:11px;"> Tick if server required 777 permission to write file </span>

			</form>
</div>
 
<br><br>


</div>