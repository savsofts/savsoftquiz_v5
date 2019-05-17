 <hr>
<div class="container">
 <?php if($this->session->flashdata('message')){
       
       echo $this->session->flashdata('message'); 
      } ?>
      
	 
    <div class="row">
  	<div class="col-sm-3"><!--left col-->
             <h1><?php echo $title;?></h1> 
         <ul class="list-group">
            
             
         
               
<?php 
$logged_in=$this->session->userdata('logged_in');
$acp=explode(',',$logged_in['social_group']);
if(!in_array($sg_id,$joined)){ ?> 
<li class="list-group-item text-muted"><a href="<?php echo site_url('social_group/join/'.$sg_id);?>"   class="btn btn-primary btn-block" ><i class="fa fa-plus"></i> <?php echo $this->lang->line('join');?></a></li>
<?php }else if($group['created_by'] != $logged_in['uid']){
?> 
<li class="list-group-item text-muted">
<a href="<?php echo site_url('social_group/unjoin/'.$sg_id);?>"   class="btn btn-primary btn-block" > <?php echo $this->lang->line('unjoin');?></a></li>
<?php }else{ 
?> 
<li class="list-group-item text-muted"><a href="#"   class="btn btn-primary btn-block"  ><?php echo $this->lang->line('urowner2');?></a></li>
<?php
}

    $acp=explode(',',$logged_in['social_group']);
   
			if(in_array('Invite',$acp)){
?> 
<li class="list-group-item text-muted"><a href="<?php echo site_url('social_group/view/'.$sg_id.'/#invite');?>"   class="btn btn-primary btn-block" data-toggle="modal" data-target="#myModal1" > <?php echo $this->lang->line('invite');?></a></li>
<?php			
			}
			if(in_array('Add_other',$acp)){
?> <li class="list-group-item text-muted">
<a href="<?php echo site_url('social_group/view/'.$sg_id.'/#member');?>"   class="btn btn-primary btn-block"  data-toggle="modal" data-target="#myModal2"> <?php echo $this->lang->line('add_user');?></a></li>

 
<?php			
			}
?> 
           
          
         
          </ul>
          
          <h3><?php echo $this->lang->line('members');?> (<?php echo $group['no_member'];?>)</h3>
        <div style="height:300px;width:100%;overflow-y:auto;background:#fcfcfc;border:1px solid #ddd;padding:5px;">
        <?php 
        foreach($members as $k => $val){
        ?>
       <div style="border-bottom:1px solid #dddddd;padding:2px;"> <a href="#"><?php echo $val['first_name'].' '.$val['last_name'];?></a>
 <?php 
                      $acp=explode(',',$logged_in['social_group']);
			if(in_array('Remove',$acp)){
	if($group['created_by'] == $logged_in['uid']){		
	?>   <a href="<?php echo site_url('social_group/remove_user/'.$sg_id.'/'.$val['uid']);?>" style="float:right;"  > <i class="fa fa-times"></i></a>
	<?php
	}
	}else if(in_array('Remove_all',$acp)){
	?>
	  <a href="<?php echo site_url('social_group/remove_user/'.$sg_id.'/'.$val['uid']);?>" style="float:right;"   > <i class="fa fa-times"></i></a>
	  
	<?php 
	}
	?>
        <p><?php echo $val['email'];?><br>
        <span style="color:#666666;font-size:11px;"><?php echo $this->lang->line('joined');?> <?php echo $val['joined_date'];?></span>
        </p>
        </div>
        <?php 
        }
        ?>
        
        </div>  
          
          
        </div><!--/col-3-->
    	<div class="col-sm-9">
           
         <h3><?php echo $this->lang->line('news_feed');?></h3>
         
         <?php
         if(count($feed)==0){
         
         echo $this->lang->line('no_record_found');
         }
         
         	foreach($feed as $k => $fd){
	?>
	
     <div class="media" style="border-bottom:1px solid #dddddd;padding-bottom:4px;">
       
        <div class="media-body">
           
          <p class="notification-desc"><?php echo $fd['feed'];?> </p>

          <div class="notification-meta">
            <small class="timestamp"><?php echo $fd['feed_date'];?></small>
            
             
          </div>
        </div>
      </div>
   
<?php 
	
	}
         
         ?>
           
           
       <br><br>

<?php
if(($limit-($this->config->item('number_of_rows')))>=0){ $back=$limit-($this->config->item('number_of_rows')); }else{ $back='0'; }  
if($limit != 0){ ?>

<a href="<?php echo site_url('social_group/view/'.$sg_id.'/0/'.$back);?>"  class="btn btn-primary"><?php echo $this->lang->line('back');?></a>
&nbsp;&nbsp;
<?php
}
 $next=$limit+($this->config->item('number_of_rows'));  ?>

<a href="<?php echo site_url('social_group/view/'.$sg_id.'/0/'.$next);?>"  class="btn btn-primary"><?php echo $this->lang->line('next');?></a>
     
           
           
        </div> 
             
        </div> 

        </div><!--/col-9-->
    </div><!--/row-->
    
    
    
    
    
    
    
    
    
    
    
    <!-- modal1 -->
    
    
    <!-- Modal -->
<div id="myModal1" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"> <?php echo $this->lang->line('invite');?></h4>
      </div>
      <div class="modal-body">
        <p> <form method="post" action="<?php echo site_url('social_group/invite/'.$sg_id);?>">
        <div class="form-group">
        <input type="text" name="email" value="" placeholder="<?php echo $this->lang->line('email_comma');?>" class="form-control" >
        </div>
        <div class="form-group">
        <input type="text" name="custom_message" value="" placeholder="<?php echo $this->lang->line('custom_message');?>" class="form-control" >
        </div>
         <div class="form-group">
        <input type="submit"   class="btn btn-primary" >
        </div>
        </form> </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


    
    <!-- modal2 -->
    
    
    <!-- Modal -->
<div id="myModal2" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"> <?php echo $this->lang->line('add_user');?></h4>
      </div>
      <div class="modal-body">
        <p>
        <form method="post" action="<?php echo site_url('social_group/add_user/'.$sg_id);?>">
        <div class="form-group">
        <input type="text" name="email" value="" placeholder="<?php echo $this->lang->line('email_comma');?>" class="form-control" >
        </div>
         <div class="form-group">
        <input type="submit"   class="btn btn-primary" >
        </div>
        </form> </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
    
    
   <script>
   <?php 
   if($ac == 'invite'){
   ?>
   
   $('#myModal1').modal('toggle');
   
   <?php 
   }
   ?>
   <?php 
   if($ac == 'adduser'){
   ?>
   
   $('#myModal2').modal('toggle');
   
   <?php 
   }
   ?>
   
   </script>
