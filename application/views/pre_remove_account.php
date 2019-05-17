<div class="container">

   
 <h3>Remove Account</h3>


  <div class="row">
 
<div class="col-md-12">
<br> 
			<?php 
		if($this->session->flashdata('message')){
			echo $this->session->flashdata('message');	
		}
		?>	
		<div id="message"></div>
		
<form method="post" action="<?php echo site_url('account/remove_account/'.$account_id);?>">

<div class="form-group">
 <?php echo $this->lang->line('remove_account_message');?> 
</div>
<div class="form-group">
 
 <select name="maid">
 <?php 
 foreach($result as $gk => $val){
 if($account_id != $val['account_id']){ 
 ?>
 <option value="<?php echo $val['account_id'];?>"><?php echo $val['account_name'];?></option>
 <?php 
 }
 }
 ?>
 </select>
 
 
</div>
  

 
<button class="btn btn-danger" type="submit"><?php echo $this->lang->line('submit');?></button>
<a href="<?php echo site_url('account');?>" class="btn btn-default"  ><?php echo $this->lang->line('cancel');?></a>
 
</td>
</tr>
</table>
</form>
</div>

</div>



</div>
