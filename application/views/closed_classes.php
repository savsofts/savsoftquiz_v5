<div class="container" >
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
							  <table class="table table-hover">
                                    <thead>
         <tr><th>Id</th>
<th>Class name</th>
<th>Start time</th>
<th>Closed time</th>
<th>Action</th></tr></thead></tbody>
<?php
if($result==false){
?>
<tr>
<td colspan="5">
No clossed class!
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
<td data-th="Closed Time"><?php echo date('Y/m/d H:i:s',$row['closed_time']);?></td>
<td>

<a href="<?php echo site_url('liveclass/view/'.$row['class_id']);?>"  class="btn btn-info btn-xs">View</a>
&nbsp;&nbsp;

<?php
if($logged_in['su']=="1"){
?>

<a href="javascript: if(confirm('Do you really want to remove this class?')){ window.location='<?php echo site_url('liveclass/remove_class/'.$row['class_id'] );?>'; }" class="btn btn-danger btn-xs">Remove</a>
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
if($logged_in['su']=="1"){
?>

<?php
}
?>
<?php
if(($limit-($this->config->item('number_of_rows')))>=0){ $back=$limit-($this->config->item('number_of_rows')); }else{ $back='0'; } ?>

<a href="<?php echo site_url('liveclass/closed_classes/'.$back);?>" class="btn btn-primary">Back</a>
&nbsp;&nbsp;
<?php
 $next=$limit+($this->config->item('number_of_rows'));  ?>

<a href="<?php echo site_url('liveclass/closed_classes/'.$next);?>" class="btn btn-primary">Next</a>






</div>

 						
							
							
							