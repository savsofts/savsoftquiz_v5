 <div class="container">

   
 <h3><?php echo $title;?></h3>
   
 

  <div class="row">
      
<?php echo form_open('assignment/add_new_assignment',array('enctype'=>'multipart/form-data')); ?>
 
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
					<input type="text" required  name="assignment_title"  class="form-control"   > 
			</div>
			 
		 
<div class="form-group">	 
					<label for="inputEmail"  ><?php echo $this->lang->line('description');?></label> 
					<textarea  name="assignment_description"  class="form-control"   ></textarea>
			</div><div class="form-group">	 
					<label for="inputEmail"  ><?php echo $this->lang->line('due_date');?> <?php echo $this->lang->line('date_format');?></label> 
					<input type="text" required  name="due_date"  class="form-control"   > 
			</div>
			 <div class="form-group">	 
					<label for="inputEmail"  ><?php echo $this->lang->line('file_upload');?></label> 
					<input type="file" required  name="userfile"    > 
			</div>
			<div class="form-group">	
			<label for="inputEmail"  ><?php echo $this->lang->line('category');?></label>  
				<select name="cid" class="form-control">
				<option value="0">--Select--</option>
				<?php foreach($categories as $cates){ ?>
				<option value="<?php echo $cates['cid']; ?>"><?php echo $cates['category_name']; ?></option>
				<?php } ?>
				</select>	
			</div>
			<div class="form-group">	
			<label for="inputEmail"  ><?php echo $this->lang->line('group_name');?></label>  <br>
				
				<?php foreach($groups as $group){ ?>
		<input type="checkbox"   name="gid[]"   value="<?php echo $group['gid']; ?>"  > 	<?php echo $group['group_name']; ?>	 &nbsp; &nbsp; &nbsp;
				<?php } ?>
					
			</div>
		 

 
	<button class="btn btn-default" type="submit"><?php echo $this->lang->line('submit');?></button>
 
		</div>
</div>
 
 
 
 
</div>
      </form>
</div>

 



</div>
