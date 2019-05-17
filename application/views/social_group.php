 <style>
 .panel-body{
 height:150px;
 }
 </style>
 
 <div class="container">
    <?php if($this->session->flashdata('message')){
       
       echo $this->session->flashdata('message'); 
      } ?>

<?php
$logged_in=$this->session->userdata('logged_in');
$acp=explode(',',$logged_in['social_group']);
if(in_array('Add',$acp)){
?>
<a href="<?php echo site_url('social_group/add_new');?>" class="btn btn-success"><?php echo $this->lang->line('add_new');?> <?php echo $this->lang->line('social_group');?></a><br><br>
<?php 
}
?>
<div class="row">
<div class="col-lg-12 col-md-12">

<form method="post" id="search" action="<?php echo site_url('social_group');?>" >
<div class="col-lg-8 col-md-8">
<input type="text" name="search" value="<?php echo $this->input->post('search');?>" class="form-control" placeholder="<?php echo $this->lang->line('search');?>">
</div>
<div class="col-lg-4 col-md-4">
<button type="submit" class="btn btn-default"><?php echo $this->lang->line('search');?></button>
</div>
</form>
</div>
</div>
<div class="row" style="margin-top:20px;">
<?php
if(count($result)==0){
echo $this->lang->line('no_record_found');
}
 
foreach($result as $k =>$val){
?>
<div class="col-lg-3 col-md-3">
<div class="panel panel-default">
<div class="panel-heading">
 <h3><a href="<?php echo site_url('social_group/view/'.$val['sg_id'].'/#member');?>"><?php echo $val['sg_name'];?></a></h3>
<span style="color:#666666;font-size:11px; "> <?php echo $this->lang->line('created');?>  <?php echo $val['created_date'];?></span>
</div>
<div class="panel-body">

<?php echo $val['about'];?>
</div>
<div class="panel-footer">
<?php 
$logged_in=$this->session->userdata('logged_in');
$acp=explode(',',$logged_in['social_group']);
if(!in_array($val['sg_id'],$joined)){ ?> 
<a href="<?php echo site_url('social_group/join/'.$val['sg_id']);?>" class="btn btn-primary"><i class="fa fa-plus"></i> <?php echo $this->lang->line('join');?></a>
<?php }else if($val['created_by'] != $logged_in['uid']){
?> 
<a href="<?php echo site_url('social_group/unjoin/'.$val['sg_id']);?>" class="btn btn-defult"> <?php echo $this->lang->line('unjoin');?></a>
<?php }else{ 
?> 
<a href="#" class="btn btn-defult"><?php echo $this->lang->line('urowner');?></a>
<?php
}

    $acp=explode(',',$logged_in['social_group']);
   
			if(in_array('Invite',$acp)){
?> 
<a href="<?php echo site_url('social_group/view/'.$val['sg_id'].'/invite');?>" class="btn btn-primary"> <?php echo $this->lang->line('invite');?></a>
<?php			
			}
			if(in_array('Add_other',$acp)){
?> 
<a href="<?php echo site_url('social_group/view/'.$val['sg_id'].'/adduser');?>" class="btn btn-primary"  > <?php echo $this->lang->line('add_user');?></a>

 
<?php			
			}
?> 

</div>
<div class="panel-footer">

<?php echo $val['no_member'];?> <?php echo $this->lang->line('members');?> 

<?php 
$logged_in=$this->session->userdata('logged_in');
$acp=explode(',',$logged_in['social_group']);
 
if(in_array('Edit',$acp)){
 
if($val['created_by'] == $logged_in['uid']){	?>
			
<a href="<?php echo site_url('social_group/edit_group/'.$val['sg_id']);?>"> <img src="<?php echo base_url('images/edit.png');?>"></a>
<?php
} 
}else if(in_array('Edit_all',$acp)){
 	?>
			
<a href="<?php echo site_url('social_group/edit_group/'.$val['sg_id']);?>"><img src="<?php echo base_url('images/edit.png');?>"></a>
<?php
 
}
                        $acp=explode(',',$logged_in['social_group']);
			if(in_array('Remove',$acp)){
	if($val['created_by'] == $logged_in['uid']){		

?>
<a href="javascript:remove_entry('social_group/remove_group/<?php echo $val['sg_id'];?>');"><img src="<?php echo base_url('images/cross.png');?>"></a>
<?php 
}
}else if(in_array('Remove_all',$acp)){
?>
<a href="javascript:remove_entry('social_group/remove_group/<?php echo $val['sg_id'];?>');"><img src="<?php echo base_url('images/cross.png');?>"></a>
<?php 
}
?>


</div>

</div>
</div>
<?php 
}
?>
 </div>     
   
  <div class="col-lg-12"  >
  
  
  <br><br>

<?php
if(($limit-($this->config->item('number_of_rows')))>=0){ $back=$limit-($this->config->item('number_of_rows')); }else{ $back='0'; }  
if($limit != 0){ ?>

<a href="<?php echo site_url('social_group/index/'.$back);?>"  class="btn btn-primary"><?php echo $this->lang->line('back');?></a>
&nbsp;&nbsp;
<?php
}
 $next=$limit+($this->config->item('number_of_rows'));  ?>

<a href="<?php echo site_url('social_group/index/'.$next);?>"  class="btn btn-primary"><?php echo $this->lang->line('next');?></a>


  </div>
  
    
  </div>
  
 
<script>
function hsdiv(id){
$(id).toggle();
}

</script>
