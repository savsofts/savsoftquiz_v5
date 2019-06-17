 <div class="container">
<?php
$lang=$this->config->item('question_lang');
?>
   
 <h3><?php echo $title;?></h3>
   
 

  <div class="row">
     <form method="post"  id="qf" action="<?php echo site_url('qbank/new_question_1/'.$nop.'/'.$para);?>">
	
<div class="col-md-12">
<br> 
 <div class="login-panel panel panel-default">
		<div class="panel-body"> 
	
	
	
			<?php 
		if($this->session->flashdata('message')){
			echo $this->session->flashdata('message');	
		}
		?>	
		
		
		
				<div class="form-group">	 
					
<?php echo $this->lang->line('multiple_choice_single_answer');?>
			</div>

			
			<div class="form-group">	 
					<label   ><?php echo $this->lang->line('select_category');?></label> 
					<select class="form-control" name="cid">
					<?php 
					foreach($category_list as $key => $val){
						?>
						
						<option value="<?php echo $val['cid'];?>"><?php echo $val['category_name'];?></option>
						<?php 
					}
					?>
					</select>
			</div>
			
			
			<div class="form-group">	 
					<label   ><?php echo $this->lang->line('select_level');?></label> 
					<select class="form-control" name="lid">
					<?php 
					foreach($level_list as $key => $val){
						?>
						
						<option value="<?php echo $val['lid'];?>"><?php echo $val['level_name'];?></option>
						<?php 
					}
					?>
					</select>
			</div>

			
<?php 
if($para==1){
foreach($lang as $lkey =>$val){	
$lno=$lkey;
if($lkey==0){
	$lno="";
}
?>
<div class="col-lg-6">
			<div class="form-group">	 
					<label for="inputEmail"  ><?php echo $this->lang->line('paragraph').' : '.$val;?></label> 
	<textarea  name="paragraph<?php echo $lno;?>"  class="form-control"   ><?php
	if(isset($qp)){ echo $qp['paragraph'.$lno]; } ?></textarea>
			</div>
			
			
				 
</div>			 

<?php
}
} 
?>			
			
<?php 
 
foreach($lang as $lkey =>$val){	
$lno=$lkey;
if($lkey==0){
	$lno="";
}
?>
<div class="col-lg-6">
			<div class="form-group">	 
					<label for="inputEmail"  ><?php echo $this->lang->line('question').' : '.$val;?></label> 
					<textarea  name="question<?php echo $lno;?>"  class="form-control"   ></textarea><br>
					
										<span style="color:red; font-size:12px;"><a href="javascript:toogleuperror();">Getting error while uploading image?</a> "The upload path does not appear to be valid"</span>
					<div style="display:none;" id="uperror">
					Go to 'My_Savsoft_Quiz_Folder*/editor/plugins/jbimages/' Open config.php. at line number 41 update <b>savsoftquiz_v5_enterprise</b> with <b>My_Savsoft_Quiz_Folder</b><br>
					Note: Here My_Savsoft_Quiz_Folder is the folder name where you installed/uploaded savsoft quiz files. if its done in root folder of domain then remove 'savsoftquiz_v5_enterprise/' from path.
					</div>
					<script> function toogleuperror(){
						$('#uperror').toggle();
					}
					</script>
					
			</div>
	</div>		
 <?php 
}
foreach($lang as $lkey =>$val){	
$lno=$lkey;
if($lkey==0){
	$lno="";
}
?>	<div class="col-lg-6">		
			<div class="form-group">	 
					<label for="inputEmail"  ><?php echo $this->lang->line('description').' : '.$val;?></label> 
					<textarea  name="description<?php echo $lno;?>"  class="form-control"></textarea>
			</div>
	</div>		
			<?php 
}
?>
		<?php 
		for($i=1; $i<=$nop; $i++){
			?>
			<div class="row">
			<?php 
 
foreach($lang as $lkey =>$val){	
$lno=$lkey;
if($lkey==0){
	$lno="";
}
?>
			<div class="col-lg-6">
			<div class="form-group">	 
					<label for="inputEmail"  ><?php echo $this->lang->line('options');?> <?php echo $i;?>) <?php echo ' : '.$val;?></label> <br>
				<?php 
if($lkey==0){
?>	<input type="radio" name="score" value="<?php echo $i-1;?>" <?php if($i==1){ echo 'checked'; } ?> > Select Correct Option 
<?php }else{ ?>  <?php } 
?>			<br><textarea  name="option<?php echo $lno;?>[]"  class="form-control"   ></textarea>
			</div>
			</div>
		<?php
}	
?></div>
<?php 	
		}
		?>

 <input type="hidden" name="parag" id="parag" value="0">
	<button class="btn btn-default" type="submit"><?php echo $this->lang->line('submit');?></button>
<?php 
if($para==1){
?>	<button class="btn btn-default" type="button" onClick="javascript:parags();"><?php echo $this->lang->line('submit&add');?></button>
<?php } ?>
 
		</div>
</div>
 
 
 
 
</div>
      </form>
</div>



 



</div>
<script>
function parags(){
$('#parag').val('1');
 $('#qf').submit(); 
}
</script>
