
<div class="row"  style="border-bottom:1px solid #dddddd;">
<div class="container"  >
<div class="col-md-1">
</div>
<div class="col-md-10">
<a href="<?php echo base_url();?>"><img src="<?php echo base_url('images/logo.png');?>"></a>
<?php echo $this->lang->line('login_tagline');?>
</div>
<div class="col-md-1">
</div>

</div>

</div>

<div class="row" style="margin-top:20px;">
<div class="container" >   
 
 
 



<div class="col-md-2">

</div>
<div class="col-md-6">

	<div class="login-panel panel panel-default">
		<div class="panel-body"> 
		
		

			<form class="form-signin" method="post" action="<?php echo site_url('login/resend');?>">
					<h3 class="form-signin-heading"><?php echo $title;?></h3>
		<?php 
		if($this->session->flashdata('message')){
			?>
			<div class="alert alert-danger">
			<?php echo $this->session->flashdata('message');?>
			</div>
		<?php	
		}
		?>				  
			<div class="form-group">	 
					<label for="inputEmail" class="sr-only"><?php echo $this->lang->line('email_address');?></label> 
					<input type="email" id="inputEmail" name="email" class="form-control" placeholder="<?php echo $this->lang->line('email_address');?>" value="" required autofocus>
			</div>
			
			<div class="form-group">	  
					 
					<button class="btn btn-lg btn-primary btn-block" type="submit"><?php echo $this->lang->line('send');?></button>
			</div>
 	<a href="<?php echo site_url('login');?>"><?php echo $this->lang->line('login');?></a>

			</form>
		</div>
	</div>

</div>
 

</div>

</div>
