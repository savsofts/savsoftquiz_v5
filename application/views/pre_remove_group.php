 <div class="container">

   
 <h3><?php echo $title;?></h3>


  <div class="row">
 
<div class="col-md-12">
<br> 
			<?php 
		if($this->session->flashdata('message')){
			echo $this->session->flashdata('message');	
		}
		?>	
		<div id="message"></div>
		
		 <form method="post" action="<?php echo site_url('user/remove_group/'.$gid);?>">

<div class="form-group">
 <?php echo $this->lang->line('remove_group_message');?> 
</div>
<div class="form-group">
 
 <select name="mgid">
 <?php 
 foreach($group_list as $gk => $val){
 if($gid != $val['gid']){ 
 ?>
 <option value="<?php echo $val['gid'];?>"><?php echo $val['group_name'];?></option>
 <?php 
 }
 }
 ?>
 </select>
 
 
</div>
  

 
<button class="btn btn-danger" type="submit"><?php echo $this->lang->line('submit');?></button>
<a href="<?php echo site_url('user/group_list');?>" class="btn btn-default"  ><?php echo $this->lang->line('cancel');?></a>
 
</td>
</tr>
</table>
</form>
</div>

</div>



</div>
