 <div class="container">

   
 <h3><?php echo $title;?></h3>
   
 

  <div class="row">
     <form method="post" action="<?php echo site_url('notification/send_notification');?>">
	
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
			<label for="inputEmail"  ><?php echo $this->lang->line('title');?></label> 
			<input type="text" required  name="title"  class="form-control"   > 
			</div>
			 
			<div class="form-group">	 
			<label for="inputEmail"  ><?php echo $this->lang->line('message');?></label> 
			<input type="text" required  name="message"  class="form-control"   > 
			</div>
			 
			<div class="form-group">	 
			<label for="inputEmail"  ><?php echo $this->lang->line('click_action');?></label> 
			<input type="text" required  name="click_action"  value="<?php echo base_url();?>" class="form-control"   > 
			</div>
			 
			<?php 
			if($tuid=='0'){
			?>
 
			<input type="hidden" required  name="notification_to[]"  value="<?php echo '/topics/'.$this->config->item('firebase_topic');?>"   > 
			 <?php echo $this->lang->line('send_to');?>: <?php echo $this->lang->line('all_users');?>
			 <input type="hidden" required  name="uid" value="0"   > 
			
			<br><br>
			<?php 
			}else{
			$nq=$this->db->query("select * from savsoft_users where uid='$tuid'");
			$nuser=$nq->row_array();
			
			?>
			 <?php echo $this->lang->line('send_to');?>: 
			 <?php echo $nuser['first_name'];?>  <?php echo $nuser['last_name'];?> (# <?php echo $nuser['uid'];?>)<br><br>
			<input type="hidden" required  name="notification_to[]" value="<?php echo $nuser['web_token'];?>"   > 
			<input type="hidden" required  name="notification_to[]" value="<?php echo $nuser['android_token'];?>"   > 
			<input type="hidden" required  name="uid" value="<?php echo $tuid;?>"   > 
			<?php 
			}
			?> 
	 
 
	<button class="btn btn-default" type="submit"><?php echo $this->lang->line('submit');?></button>
 
		</div>
</div>
 
 
 
 
</div>
      </form>
</div>

 



</div>
