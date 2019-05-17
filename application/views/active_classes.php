 <div class="container">

 <?php 
$logged_in=$this->session->userdata('logged_in');

if($resultstatus){ echo "<div class='alert alert-success'>".$resultstatus."</div>"; }
 ?> 	
<div class="row" style="margin-top:10px;">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                         <?php if($title){ echo $title; } ?>
                        </div>
                        <!-- .panel-heading -->
                        <div class="panel-body">
                            <div class="panel-group" id="accordion">
   <?php
$logged_in=$this->session->userdata('logged_in');
   
if(in_array('All',explode(',',$logged_in['setting']))){
 
?>
Live Classroom is a place where you can post live content  (text, image or any other attachments) to users of selected groups.<br>
Users can ask any question by posting comments and you (Admin) have power to publish, delete and answer that comments.
Closing any class will disable new content or comments.

<?php
}
?>
 
<br>
<br>
<?php 
		if($this->session->flashdata('message')){
			echo $this->session->flashdata('message');	
		}
		?>	
<?php
if(in_array('All',explode(',',$logged_in['setting']))){
 
?>
<a href="<?php echo site_url('liveclass/add_new');?>"  class="btn btn-success">Initiate new class</a>
<?php
}
?>
<a href="<?php echo site_url('liveclass/closed_classes/');?>"  class="btn btn-warning">Closed classes</a>
<br><br>
   <table class="table table-hover">
                                    <thead>
                                   
                       <tr><th>Id</th>
<th>Class name</th>
<th>Start time</th>
<th>Action</th></tr></thead></tbody>
<?php
if($result==false){
?>
<tr>
<td colspan="5">
No active or upcoming class!
</td>
</tr>
<?php

}else{
foreach($result as $row){
?>
<tr>
<td  data-th="Id"><?php echo $row['class_id'];?></td>
<td data-th="Class Name"><?php echo $row['class_name'];?></td>
<td data-th="Start Time"><?php echo date('Y/m/d H:i:s',$row['initiated_time']);?></td>
<td>

<?php
if($this->config->item('SQLc') == true && ($row['SQLc_session_id'] > 0 || $row['initiated_by']==$logged_in['uid'])){
?>
<a href="<?php echo site_url('liveclass/live_streaming/'.$row['class_id'].'/'.$row['SQLc_session_id']);?>"  class="glyphicon glyphicon-facetime-video btn btn-primary "> Live</a>
 
<?php } ?>
<?php
if(in_array('All',explode(',',$logged_in['setting']))){
 
?>
<a href="<?php echo site_url('liveclass/attempt/'.$row['class_id']);?>"  class="btn btn-success">Post Content</a>
 
<a href="<?php echo site_url('liveclass/close_class/'.$row['class_id']);?>"  class="btn btn-danger">Close Class</a>
 
<?php 
}else{
?>
<a href="<?php echo site_url('liveclass/attempt/'.$row['class_id']);?>"  class="btn btn-warning">Attend</a>
 
<?php
}
?>
<?php
if(in_array('All',explode(',',$logged_in['setting']))){
 
?>
<a href="javascript: if(confirm('Do you really want to remove this class?')){ window.location='<?php echo site_url('liveclass/remove_class/'.$row['class_id'] );?>'; }" class="btn btn-danger">Remove</a> 
 <a href="<?php echo site_url('liveclass/edit_class/'.$row['class_id'] );?>"  class="btn btn-info">Edit</a>
<?php
}
?>
</td>
</tr>
<?php
}
}
?>
        
			</tbody></table>				   
							   
							   




   
                              </div>
                        </div>
                        <!-- .panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
			
	
 
<?php
if(in_array('All',explode(',',$logged_in['setting']))){
 
?>

<?php
}
?>
<?php
if(($limit-($this->config->item('number_of_rows')))>=0){ $back=$limit-($this->config->item('number_of_rows')); }else{ $back='0'; } ?>

<a href="<?php echo site_url('liveclass/index/'.$back);?>" class="btn btn-primary">Back</a>
&nbsp;&nbsp;
<?php
 $next=$limit+($this->config->item('number_of_rows'));  ?>

<a href="<?php echo site_url('liveclass/index/'.$next);?>" class="btn btn-primary">Next</a>





  
   
   
   </div>
   
   
