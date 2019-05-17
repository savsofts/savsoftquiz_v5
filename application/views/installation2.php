 <div class="container">

   
 <?php 
 $sq_url="http://".$_SERVER['HTTP_HOST'] . str_replace('index.php/install','',$_SERVER['REQUEST_URI']);
 $last_sl=substr($sq_url,(strlen($sq_url)-1),strlen($sq_url));
 if($last_sl=='/'){
	$sq_url=$sq_url; 
 }else{
	$sq_url=$sq_url."/";  
 }
 ?>
 
 



<div class="col-md-4">
</div>
<div class="col-md-4">

	<div class="login-panel panel panel-default">
		<div class="panel-body"> 
		<img src="<?php echo base_url('images/logo.png');?>">
		

			 	<br><hr><br>
		
			 <?php 
			 echo $result;
			 ?>
		</div>
	</div>

</div>
<div class="col-md-4">


</div>



</div>