  <h3><?php echo $title;?></h3>
    <?php if($this->session->flashdata('message')){
       
       echo $this->session->flashdata('message'); 
      } ?>
 

<div class="col-lg-12"  >
<div class="col-lg-8"  >
 
<form method="post" action="<?php echo site_url('social_group/add_new');?>" >
<br><br>
<div class="form-group">
        <label><?php echo $this->lang->line('group_name');?></label>
        <input type="text" name="sg_name" class="form-control"  value="" required >
</div>

<div class="form-group">
        <label><?php echo $this->lang->line('about');?></label>
        <input type="text" name="about" class="form-control"  value="" required >
</div>


<div class="form-group">
        
        <button type="submit"  class="btn btn-success"  ><?php echo $this->lang->line('submit');?></button>
</div>

</form>
</form>
</div>
 
</div>
