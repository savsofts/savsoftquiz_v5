    <?php if($this->session->flashdata('message')){
       
       echo $this->session->flashdata('message'); 
      } ?>
<br><br>
<div class="col-lg-12"  >
<div class="col-lg-8"  >
<h3><?php echo $this->lang->line('edit');?> -  <?php echo $title;?></h3></h3>
<form method="post" action="<?php echo site_url('user/edit_custom/'.$custom['field_id']);?>" >
<br><br>
<div class="form-group">
 
        <label><?php echo $this->lang->line('field_name');?></label>
        <input type="text" name="field_title" class="form-control"  value="<?php echo $custom['field_title'];?>" required >
</div>

<div class="form-group">
        <label><?php echo $this->lang->line('field_type');?></label>
        <select name="field_type" class="form-control" >
        <option value="text" <?php if($custom['field_value']=='text'){ echo 'selected';} ?> >Text</option>
        <option value="password" <?php if($custom['field_value']=='password'){ echo 'selected';} ?> >Password</option>
        </select>
        
</div>

<div class="form-group">
        <label><?php echo $this->lang->line('field_validate');?></label>
        <input type="text" name="field_validate" class="form-control"  value='<?php echo $custom['field_validate'];?>'>
</div>

<div class="form-group">
        <label><?php echo $this->lang->line('field_value');?></label>
        <input type="text" name="field_value" class="form-control"  value="<?php echo $custom['field_value'];?>">
</div>



<div class="form-group">
        <label><?php echo $this->lang->line('display_at');?></label>
        <select name="display_at" class="form-control" >
        <option value="Registration" <?php if($custom['display_at']=='Registration'){ echo 'selected';} ?> >Registration</option>
        <option value="Result"  <?php if($custom['display_at']=='Result'){ echo 'selected';} ?> >Before Showing Result</option>
        </select>
        
</div>



<div class="form-group">
        
        <button type="submit"  class="btn btn-success"  ><?php echo $this->lang->line('submit');?></button>
</div>

</form>
</form>
</div>
<div style="clear:both;" ></div>
<hr>


 
 </div>

