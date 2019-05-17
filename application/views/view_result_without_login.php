 <style>
@media print {
   
   .navbar{
   display:none;
   }
   #footer{
   display:none;
   } 
   .printbtn{
	  display:none; 
   }
   #social_share{
	   display:none;
   }
   
   #page_break2{
	   
   page-break-after: always;
	}
	
.noprint{
	
	display:none; 
}
}
@media screen {
.onlyprint{
	display:none; 
	
}
}
 td{
		font-size:14px;
		padding:4px;
	}
	
	
	
	
	
	.circle_result{
	
	    width: 40px;
    height: 40px;
    border-radius: 20px;
    background: #0b8d6f;
    color: #ffffff;
    padding: 5px;
    font-size: 16px;
    text-align: center;
	margin-right:20px;
		float:left;
}


.circle_ur{
	
	    width: 40px;
    height: 40px;
    border-radius: 20px;
    background: #ffcc66;
    color: #ffffff;
    padding: 5px;
    font-size: 16px;
    text-align: center;
	margin-right:20px;
	float:left;
}


.circle_l{
	
	    width: 40px;
    height: 40px;
    border-radius: 20px;
    background: #ff3300;
    color: #ffffff;
    padding: 5px;
    font-size: 16px;
    text-align: center;
	margin-right:20px;
	float:right;
}

.td_line{
	background:url('<?php echo base_url('images/rankbar.png');?>');background-repeat: repeat-x;
}
</style>
 <div class="container">
<?php 
$logged_in=$this->session->userdata('logged_in');
?>
   
    
 
<?php 

function ordinal($number) {
    $ends = array('th','st','nd','rd','th','th','th','th','th','th');
    if ((($number % 100) >= 11) && (($number%100) <= 13))
        return $number. 'th';
    else
        return $number. $ends[$number % 10];
}

function questioninwhichcategory($key,$c_range){
	foreach($c_range as $k => $cv){
		
		if($key >= $cv[0] && $key <= $cv[1]){
			return $k;
		}
	}
	
}




function cia_cat($narray,$c_range){
	$unattempted=array();
	$correct=array();
	$incorrect=array();
	foreach($narray as $k => $val){
		
	if($val==0){
		if(isset($unattempted[questioninwhichcategory($k,$c_range)])){
		$unattempted[questioninwhichcategory($k,$c_range)]+=1;
		}else{
		$unattempted[questioninwhichcategory($k,$c_range)]=1;	
		}
	}else if($val==1){
// $correct+=1;
		if(isset($correct[questioninwhichcategory($k,$c_range)])){
		$correct[questioninwhichcategory($k,$c_range)]+=1;
		}else{
		$correct[questioninwhichcategory($k,$c_range)]=1;	
		}
	}else if($val==2){
// $incorrect+=1;
		if(isset($incorrect[questioninwhichcategory($k,$c_range)])){
		$incorrect[questioninwhichcategory($k,$c_range)]+=1;
		}else{
		$incorrect[questioninwhichcategory($k,$c_range)]=1;	
		}
	}	
	 
		 
	 
	}
	
	return array($correct,$incorrect,$unattempted);
}





function cia_tim_cate($narray,$tim,$c_range){
	$unattempted=array();
	$correct=array();
	$incorrect=array();
	foreach($narray as $k => $val){
	
	if($val==0){
		if(isset($unattempted[questioninwhichcategory($k,$c_range)])){
		$unattempted[questioninwhichcategory($k,$c_range)]+=$tim[$k];
		}else{
		$unattempted[questioninwhichcategory($k,$c_range)]=$tim[$k];	
		}
	}else if($val==1){
// $correct+=1;
		if(isset($correct[questioninwhichcategory($k,$c_range)])){
		$correct[questioninwhichcategory($k,$c_range)]+=$tim[$k];
		}else{
		$correct[questioninwhichcategory($k,$c_range)]=$tim[$k];	
		}
	}else if($val==2){
// $incorrect+=1;
		if(isset($incorrect[questioninwhichcategory($k,$c_range)])){
		$incorrect[questioninwhichcategory($k,$c_range)]+=$tim[$k];
		}else{
		$incorrect[questioninwhichcategory($k,$c_range)]=$tim[$k];	
		}
	}	
	
	}
		
	return array($correct,$incorrect,$unattempted);
}
function prezero($val){
	if($val <= 9){
	return '0'.$val;	
	}else{
		return $val;
	}
}
function secintomin($sec){
	if($sec >= 60){
	$splitin=explode('.',($sec/60));
	if(isset($splitin[1])){
		$secs=substr(intval((substr($splitin[1],0,2)*60)/100),0,2);
	}else{
		$secs=0;
	}
	return $splitin[0].':'.prezero($secs);
	}else{
	return '0:'.prezero($sec);	
	}
}


function per_nonzero($arr){
	
$totallen=count($arr);
$filt=array_filter($arr);
$per=(count($filt)/$totallen)*100;
return intval($per);	
}

$c_range=array();
$j=0;
$i=0;
foreach(explode(",",$result['category_range']) as $ck => $cv){
	$c_range[]=array($i,($i+($cv-1)));
	$i+=$cv;
}
$correct_incorrect_unattempted=explode(",",$result['score_individual']);
 
$cia_cat=cia_cat($correct_incorrect_unattempted,$c_range);
 
$cia_tim_cate=cia_tim_cate($correct_incorrect_unattempted,explode(",",$result['individual_time']),$c_range);



?>

<div class="row"  style="border-bottom:1px solid #dddddd;">
<div class="container"  >
<div class="col-md-1">
</div>
<div class="col-md-10">
<a href="<?php echo base_url();?>"><img src="<?php echo base_url('images/logo.png');?>"></a>
<?php echo $this->lang->line('login_tagline');?>
</div>
<div class="col-md-1">
</div>

</div>

</div>

<div class="row noprint" >
<div class="col-lg-12" style="background-image:url('<?php echo base_url('images/result_bg.jpg');?>');background-size:cover;font-size:18px;padding:20px;color:#ffffff;min-height:400px;">
<div class="col-lg-12" >
<center><h3><span style="color:#e39500;"> 
<?php echo $this->lang->line('hello');?> <?php echo $result['first_name'];?> 
<?php echo $result['last_name'];?>!</span>  <?php echo str_replace('{attempt_no}',ordinal($attempt),$this->lang->line('title_result'));?> </h3></center>
</div>
<div class="col-lg-12" >
<center>
<h2><span style="color:#e39500;"><?php echo $result['quiz_name'];?>   </span></h2>
</center>
</div>
<div class="col-lg-12" style="margin-top:20px;">
	<div class="col-lg-2" style="text-align:center;">
		<p><?php echo $this->lang->line('score_obtained');?></p>
		<p style="color:#e39500;" ><?php echo $result['score_obtained'];?></p>
	</div>
	<div class="col-lg-2"  style="text-align:center;">
		<p><?php echo $this->lang->line('time_spent');?></p>
		<p style="color:#e39500;" ><?php echo secintomin($result['total_time']);?> Min.</p>

	</div>
	<div class="col-lg-2"  style="text-align:center;">
		<p><?php echo $this->lang->line('attempt_time');?></p>
		<p style="color:#e39500;font-size:14px;" ><?php echo date('Y-m-d H:i:s',$result['start_time']);?></p>

	</div>
	<div class="col-lg-2"  style="text-align:center;">
		<p><?php echo $this->lang->line('percentage_obtained');?></p>
		<p style="color:#e39500;" ><?php echo $result['percentage_obtained'];?>%</p>

	</div>
 <div class="col-lg-2"  style="text-align:center;">
		<p><?php echo $this->lang->line('percentile_obtained');?></p>
		<p style="color:#e39500;" ><?php echo substr(((($percentile[1]+1)/$percentile[0])*100),0,5);   ?>%</p>

	</div>
 
<div class="col-lg-2"  style="text-align:center;">
		<p><?php echo $this->lang->line('status');?></p>
		<p style="color:#e39500;" ><?php echo $result['result_status'];?></p>

	</div>
 

	 
</div>
	<?php 
	if($this->session->userdata('logged_in')){
		?>
<div class="col-lg-12" style="margin-top:20px;">
<center>
<?php 
if($result['view_answer']=='1' || $logged_in['su']=='1'){
	
?>
<a href="#answers_i" class="btn btn-info" style="margin-top:10px;"><?php echo $this->lang->line('answer_sheet');?></a>
<?php 
}
?>

<a href="javascript:print();" class="btn btn-success printbtn" style="margin-top:10px;"><?php echo $this->lang->line('print');?></a>

<?php
if($result['gen_certificate']=='1'){
?>
<a href="<?php echo site_url('result/generate_certificate/'.$result['rid']);?>" class="btn btn-warning printbtn" style="margin-top:10px;"><?php echo $this->lang->line('download_certificate');?></a>
	
<?php
}
?>



</center>
</div>

<div class="col-lg-12" style="margin-top:50px;color:#dddddd;font-size:14px;">
 
	
		 
		 <center>
		 <?php echo $this->lang->line('result_id');?> <?php echo $result['rid'];?> &nbsp;&nbsp;&nbsp;
		<?php echo $this->lang->line('user_id');?> <?php echo $result['uid'];?>&nbsp;&nbsp;&nbsp;
		<?php echo $this->lang->line('email');?>: <?php echo $result['email'];?>
		 </center>
		
		 

	 
  
 

	 
</div>

<?php 
	}else{
	?>
	<div class="col-lg-12" style="margin-top:20px;">
<center>
<?php echo str_replace('{base_url}',base_url(),$this->lang->line('login_required3'));?>
</center>
	</div>
	<?php 
	}
	?>
</div>



</div>




 


  
      
</div>

 



</div>

<input type="hidden" id="evaluate_warning" value="<?php echo $this->lang->line('evaluate_warning');?>">
 
 <script>
 $('.s_title').tooltip('show');
 </script>