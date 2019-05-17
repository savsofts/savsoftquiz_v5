<div class="row">
<div class="container">
<h3><?php echo $this->lang->line('proctor');?></h3>


<br>
 <?php 
 if($rid != 0){
 
$quid= $quiz['quid'];
 $files = glob('proctor/'.$quid.'-'.$rid.'-*.png');  
$query=$this->db->query(" select * from savsoft_result  join savsoft_users on savsoft_result.uid=savsoft_users.uid where savsoft_result.rid='$rid' ");
$user=$query->row_array();
// Process through each file in the list
// and output its extension
 // print_r('proctor/'.$quid.'-'.$rid.'-*.png');
if (count($files) > 0){
  $recorded_files=count($files);
 }else{
 $recorded_files=0;
 }
 
 
 // echo $recorded_files;
 ?>
 <div class="panel panel-default">
 <div class="panel-heading">
<?php
 echo "<b>".$user['first_name']." ".$user['last_name']."</b>";
?>
</div>
<div class="panel-body">
<?php 
	foreach($files as $j => $file){
	$fname=explode('-',$file);
	
	?>
<div class="col-lg-3"><img src= '<?php echo base_url($file);?>'>
<b><?php echo $fname[2].'-'.$fname[3].'-'.$fname[4].'-'.$fname[5].'-'.$fname[6].'-'.$fname[7];?></b>
</div>
<?php 
}
?>

 </div>
 </div>
 
  
 <?php 
 }
 ?>
 
 
<div class="row">
<?php 
$quid=$quiz['quid'];
 $files = glob('proctor/'.$quid.'-*.png');  
 $inrid=array();
 if(count($files)==0){
 echo "Data not available! ";
 
 }
foreach($files as $k => $file){

$efile=explode('-',$file);
$rid=$efile[1];
 if(!in_array($rid,$inrid)){
 $inrid[]=$rid;
$query=$this->db->query(" select * from savsoft_result  join savsoft_users on savsoft_result.uid=savsoft_users.uid where savsoft_result.rid='$rid' ");
$user=$query->row_array();
?>
<div class="col-lg-2" style="text-align:center;">
<div class="panel panel-default">
<div class="panel-body">
<a href="<?php echo site_url('quiz/proctor/'.$quid.'/'.$rid);?>" ><i class="fa fa-video-camera fa-4x"></i></a>
</div>
<div class="panel-footer">
<?php
 echo "<b>".$user['first_name']." ".$user['last_name']."</b>";
?>
</div></div>
</div>
<?php
}
}
?>
</div>
</div>
</div>
