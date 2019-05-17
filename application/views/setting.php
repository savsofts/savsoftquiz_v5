  
		 
 <h3>Setting</h3>
 
		<form method="post" action="<?php echo site_url('setting/update');?>">
		
<ul class="nav nav-tabs">
  <?php 
foreach($tabs as $k => $val){ 
?>
  <li class="<?php if($k == 0){ echo 'active'; } ?>" style="background:#dddddd;margin-right:5px;"><a data-toggle="tab" href="#tab<?php echo $k;?>"><?php echo str_replace('_',' ',$val);?></a></li>
<?php } ?> 
</ul>

<div class="tab-content">
<?php 
foreach($tabs as $k => $val){ 
?>
  <div id="tab<?php echo $k;?>" class="tab-pane fade in <?php if($k == 0){ echo 'active show'; } ?> ">
 
	
	<div class="card card-default">
	  <div class="card-heading" style="padding:5px;"><?php echo str_replace('_',' ',$val);?>  </div>
	  <div class="card-body">
	  <?php 
	  $set=$settings[$val];
	  foreach($set as $sk => $sval){
		  ?>
		  
		  <div class="form-group">
			<label><?php echo str_replace('_',' ',ucfirst($sk));?> </label>
			<?php  
			if($sval[0] == 'true' || $sval[0] == 'false'){
				?>
			<select name="<?php echo $sk;?>" class="form-control" >
				<option value="true" <?php if($sval[0]=='true'){ echo 'selected'; } ?> >Enabled</option>
				<option value="false" <?php if($sval[0]=='false'){ echo 'selected'; } ?> >Disabled</option>
				
			</select>			
				<?php 
			}else{ 
			?>
			<input type="text" class="form-control" name="<?php echo $sk;?>" value="<?php echo $sval[0];?>"> 
			<?php 
			}
			?>
			<span style="color:#666666;font-size:12px"><?php echo $sval[1];?></span>
		  </div>
		  
		  <?php 
	  }
	  ?>
	  
	  </div>
	</div>

	
	
	
	
	
  </div>
<?php } ?>   
</div>		
		
		
		<br>
 		<button class="btn btn-default">Update</button>
		</form>
		
		
		
	 
		 