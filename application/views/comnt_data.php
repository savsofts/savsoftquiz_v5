

<?php
$logged_in =$this->session->userdata('logged_in');
   

 foreach($result as $val){

 if( $val['published']==0){
   $pub_id="1";
   }else{
   $pub_id="0";
   }
 
 ?> <div <?php  if($logged_in['su']=="1"){   ?> OnClick="show_options(<?php echo $val['content_id'];?>,<?php echo $pub_id;?>);"  <?php } ?> style="<?php if($val['su']=='1'){ ?> background:#E1FFDA;<?php }else{ ?> background:#D4DDE7; <?php } ?>;<?php if($logged_in['su']=="1"){ echo "cursor:pointer;"; }?>width: 250px;
padding: 5px;

-webkit-border-radius: 10px;
-moz-border-radius: 10px;
border-radius: 10px;" >


 
 <?php
if($val['su']=="1"){

echo "<span id='username_comment'>Admin:</span> ".$val["content"];
}else{

echo "<span id='username_comment'>User: ".$val['id']."</span> ".$val["content"];
}
 if($val["published"]=='1'){
?> 
<img title="Published" style="float:right; width:12px;height:12px;" src="<?php echo base_url();?>images/tick-icon.png">

<?php } else{?>

<img title="Unpublished"  style="float:right; width:12px;height:12px;" src="<?php echo base_url();?>images/grey-tick.png">


<?php
}?>
</div><br>
<?php
	 }
	 ?>
	