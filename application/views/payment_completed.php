 <div class="container">

  <div class="row">
    
<div class="col-md-10">
<br> 
 <div class="login-panel panel panel-default">
		<div class="panel-body"> 
	  	<?php 
if(!$this->session->userdata('logged_in')){
?><img src="<?php echo base_url('images/logo.png');?>">
<?php 
}
?>
	
 <h3><?php echo $title;?></h3>
   <br><br>
   
   <?php echo $this->lang->line('payment_success_message');?>
   
 <br>
 <?php 
if(!$this->session->userdata('logged_in')){
?><a href="<?php echo site_url('login');?>"><?php echo $this->lang->line('login');?></a> 
 <?php 
 }
 ?>
 
 
 
 
 
 
</div> 

</div> 

</div> 

</div> 
 


</div> 
