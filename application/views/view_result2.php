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


</div>



</div>




 


  <div class="row">
     
<div class="col-md-12">
<br> 
 <div class="login-panel panel panel-default onlyprint">
		<div class="panel-body"> 
	
	
	
		 
<table class="table table-bordered">
<?php 
if($result['camera_req']=='1'){
	?>
<tr><td colspan='2'> <?php if($result['photo']!=''){ ?> <img src ="<?php echo base_url('photo/'.$result['photo']);?>" id="photograph" ><?php } ?></td></tr>
	
	<?php 
}
?>
<tr><td><?php echo $this->lang->line('first_name');?></td><td><?php echo $result['first_name'];?></td></tr>
<tr><td><?php echo $this->lang->line('last_name');?></td><td><?php echo $result['last_name'];?></td></tr>
<tr><td><?php echo $this->lang->line('email');?></td><td><?php echo $result['email'];?></td></tr>
<tr><td><?php echo $this->lang->line('quiz_name');?></td><td><?php echo $result['quiz_name'];?></td></tr>
<tr><td><?php echo $this->lang->line('attempt_time');?></td><td><?php echo date('Y-m-d H:i:s',$result['start_time']);?></td></tr>
<tr><td><?php echo $this->lang->line('time_spent');?></td><td><?php echo secintomin($result['total_time']);?></td></tr>
<tr><td><?php echo $this->lang->line('percentage_obtained');?></td><td><?php echo $result['percentage_obtained'];?>%</td></tr>
<tr><td><?php echo $this->lang->line('percentile_obtained');?></td><td><?php echo substr(((($percentile[1]+1)/$percentile[0])*100),0,5);   ?>%</td></tr>
<tr><td><?php echo $this->lang->line('score_obtained');?></td><td><?php echo $result['score_obtained'];?></td></tr>
<tr><td><?php echo $this->lang->line('status');?></td><td><?php echo $result['result_status'];?></td></tr>

</table>
  
 
		</div>
</div>
<br>
 
	<div class="col-md-12">
		 <h3><?php echo $this->lang->line('categorywise');?></h3>
					<table class="table table-bordered">
					 <thead> <tr><th style="background:#337ab7;color:#ffffff;"><?php echo $this->lang->line('category_name');?></th>
					 <th  style="background:#337ab7;color:#ffffff;"><?php echo $this->lang->line('score_obtained');?></th>
					 <th  style="background:#337ab7;color:#ffffff;"><?php echo $this->lang->line('time_spent');?></th>
					  <th  style="background:#337ab7;color:#ffffff;"><?php echo $this->lang->line('correct');?></th>
					 <th  style="background:#337ab7;color:#ffffff;"><?php echo $this->lang->line('incorrect');?></th>
					 <th  style="background:#337ab7;color:#ffffff;"><?php echo $this->lang->line('notattempted');?></th> 
					</tr></thead>
					<tbody>
					  <?php 
					  $c=0;
					  $correct=0;
					 $incorrect=0;
					 $notattempted=0;
					  foreach(explode(',',$result['categories']) as $vk => $category){ 
					  
					 if(isset($cia_cat[0][$vk])){ $no_C=$cia_cat[0][$vk]; $correct+=$cia_cat[0][$vk]; }else{ $no_C=0; } 
					  if(isset($cia_cat[1][$vk])){ $no_iC=$cia_cat[1][$vk]; $incorrect+=$cia_cat[1][$vk]; }else{ $no_iC=0;  }
						?>
						<tr><td>
						<?php echo $category; ?>
						</td>
						
						<td><?php echo (($no_C*$result['correct_score'])+($no_iC*$result['incorrect_score']));?></td>
						<td><?php echo secintomin($cia_tim_cate[0][$vk]+$cia_tim_cate[1][$vk]+$cia_tim_cate[2][$vk]);?> Min.</td>
						<td><?php echo $no_C;?></td>
						<td><?php echo $no_iC;  ?></td>
						<td><?php   if(isset($cia_cat[2][$vk])){ echo $cia_cat[2][$vk]; $notattempted+=$cia_cat[2][$vk]; }else{ echo '0';  } ?></td>
						 
						</tr>
					 <?php 
					  }
					  ?>
					 </tbody>
						 <thead> 
						 <tr>
						 <th style="background:#337ab7;color:#ffffff;"><?php echo $this->lang->line('total');?></th>
						 <th  style="background:#337ab7;color:#ffffff;"><?php echo $result['score_obtained'];?>
						 </th>
						 <th style="background:#337ab7;color:#ffffff;"><?php echo secintomin($result['total_time']);?> Min. <?php echo $this->lang->line('approx');?></th>
						<th style="background:#337ab7;color:#ffffff;"><?php echo $correct;?></th>
						<th style="background:#337ab7;color:#ffffff;"><?php echo $incorrect;?></th>
						<th style="background:#337ab7;color:#ffffff;"><?php echo $notattempted;?></th> 
						 </tr>
						 </thead>
					
						</table>
						
		
	</div>
	
	<div class="col-lg-12 noprint">
	<h3><?php echo $this->lang->line('comparison_other');?></h3>
	</div>
	
<div class="col-lg-12 noprint" style="margin-top:50px;"> 
<button class="btn btn-default" style="margin-right:20px;width:141px;	float:left;"> <?php echo $this->lang->line('rank').': '.$rank;?> </button> 
<div class="td_line" style="float:left;width:700px;height:70px;">
<div <?php if($rank=='1'){?>class="circle_ur s_title" data-toggle="tooltip"  title="Your Rank"<?php }else{ ?>class="circle_result"<?php } ?>>1</div>
<div <?php if($rank=='2'){?>class="circle_ur s_title" data-toggle="tooltip"  title="Your Rank"<?php }else{ ?>class="circle_result"<?php } ?>>2</div>
<div <?php if($rank=='3'){?>class="circle_ur s_title" data-toggle="tooltip"  title="Your Rank"<?php }else{ ?>class="circle_result"<?php } ?>>3</div>
  <?php 
  if($rank > 3 ){
  ?>
<div class="circle_ur s_title"  data-toggle="tooltip"  title="Your Rank" style="margin-left:<?php echo intval(($rank/$last_rank)*100);?>%"><?php echo $rank;?></div>	  
  <?php 
  }
  ?>

    <?php 
  if($rank != $last_rank ){
  ?>
<div class="circle_l s_title"  data-toggle="tooltip"  title="Last Rank"><?php echo $last_rank;?></div>	  
  <?php 
  }else{
  ?>
<div class="circle_l s_title"  data-toggle="tooltip"  title="Your Rank is Last"><?php echo $last_rank;?></div>	  

  <?php
  }
  ?>
</div>
 </div>
 
 
 
 
 
<div class="col-lg-12 noprint" style="margin-top:50px;">
<button class="btn btn-default" style="margin-right:20px;width:141px;	float:left;"> <?php echo $this->lang->line('score_obtained').': '.$result['score_obtained'];?> </button> 
<div class="td_line" style="float:left;width:700px;height:70px;">
<div <?php if($rank=='1'){?>class="circle_ur s_title" data-toggle="tooltip"  title="Your Score"<?php }else{ ?>class="circle_result"<?php } ?>><?php echo $toppers[0]['score_obtained'];?></div>
<div <?php if($rank=='2'){?>class="circle_ur s_title" data-toggle="tooltip"  title="Your Score"<?php }else{ ?>class="circle_result"<?php } ?>><?php echo $toppers[1]['score_obtained'];?></div>
<div <?php if($rank=='3'){?>class="circle_ur s_title" data-toggle="tooltip"  title="Your Score"<?php }else{ ?>class="circle_result"<?php } ?>><?php echo $toppers[2]['score_obtained'];?></div>
  <?php 
  if($rank > 3 ){
  ?>
<div class="circle_ur s_title"  data-toggle="tooltip"  title="Your Score" style="margin-left:<?php echo intval(($rank/$last_rank)*100);?>%"><?php echo $result['score_obtained'];?></div>	  
  <?php 
  }
  ?>

    <?php 
  if($rank != $last_rank ){
  ?>
<div class="circle_l s_title"  data-toggle="tooltip"  title="Lowest Score"><?php echo $looser['score_obtained'];?></div>	  
  <?php 
  }else{
  ?>
<div class="circle_l s_title"  data-toggle="tooltip"  title="Lowest Score is Your"><?php echo $looser['score_obtained'];?></div>	  

  <?php
  }
  ?>
</div>
 </div>
 
 
 
 
 <div class="col-lg-12 noprint" style="margin-top:50px;margin-bottom:50px;">
<button class="btn btn-default" style="margin-right:20px;width:141px;	float:left;"> <?php echo $this->lang->line('time').': '.secintomin($result['total_time']).' Min.';?>   </button> 
<div class="td_line" style="float:left;width:700px;height:70px;">
<div <?php if($rank=='1'){?>class="circle_ur s_title" data-toggle="tooltip"  title="Your Time"<?php }else{ ?>class="circle_result"<?php } ?> style="font-size:12px;padding-top:10px;"><?php echo secintomin($toppers[0]['total_time']);?></div>
<div <?php if($rank=='2'){?>class="circle_ur s_title" data-toggle="tooltip"   title="Your Time"<?php }else{ ?>class="circle_result"<?php } ?> style="font-size:12px;padding-top:10px;"><?php echo secintomin($toppers[1]['total_time']);?></div>
<div <?php if($rank=='3'){?>class="circle_ur s_title" data-toggle="tooltip"   title="Your Time"<?php }else{ ?>class="circle_result"<?php } ?> style="font-size:12px;padding-top:10px;"><?php echo secintomin($toppers[2]['total_time']);?></div>
  <?php 
  if($rank > 3 ){
  ?>
<div class="circle_ur s_title"  data-toggle="tooltip"  title="Your Time" style="margin-left:<?php echo intval(($rank/$last_rank)*100);?>%" style="font-size:12px;padding-top:10px;"><?php echo secintomin($result['total_time']);?></div>	  
  <?php 
  }
  ?>

    <?php 
  if($rank != $last_rank ){
  ?>
<div class="circle_l s_title"  data-toggle="tooltip"  title="Last Ranker's Time" style="font-size:12px;padding-top:10px;"><?php echo secintomin($looser['total_time']);?></div>	  
  <?php 
  }else{
  ?>
<div class="circle_l s_title"  data-toggle="tooltip"  title="Last Ranker's Time" style="font-size:12px;padding-top:10px;"><?php echo secintomin($looser['total_time']);?></div>	  

  <?php
  }
  ?>
</div>
 </div>
 
 
	 <div id="page_break"></div>
 <div class="col-md-12">
<?php
 
 
  
if($this->config->item('google_chart') == true ){ 
?>


<!-- google chart starts -->
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable(<?php echo $value;?>);

        var options = {
          title: '<?php echo $this->lang->line('top_10_result');?> <?php echo $result['quiz_name'];?>',
          hAxis: {title: '<?php echo $this->lang->line('quiz');?>(<?php echo $this->lang->line('user');?>)', titleTextStyle: {color: 'red'}}
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
		 <div id="chart_div" style="width: 800px; height: 500px;"></div>
<!-- google chart ends -->


<!-- google chart starts -->

    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable(<?php echo $qtime;?>);

        var options = {
          title: '<?php echo $this->lang->line('time_spent_on_ind');?>'
        };

        var chart = new google.visualization.PieChart(document.getElementById('chart_div2'));
        chart.draw(data, options);
      }
    </script>
		 <div id="chart_div2" style="width:800px; height: 500px;"></div>
<!-- google chart ends -->




 

<?php 
}
?>
</div>
<?php
$ind_score=explode(',',$result['score_individual']); 
// view answer
if($result['view_answer']=='1' || $logged_in['su']=='1'){
	
?>

<div class="login-panel panel panel-default">
		<div class="panel-body"> 
		<a name="answers_i"></a>
<h3><?php echo $this->lang->line('answer_sheet');?></h3>

<?php 
$abc=array(
'0'=>'A',
'1'=>'B',
'2'=>'C',
'3'=>'D',
'4'=>'E',
'6'=>'F',
'7'=>'G',
'8'=>'H',
'9'=>'I',
'10'=>'J',
'11'=>'K'
);
foreach($questions as $qk => $question){
?>
 <hr>
 <div id="q<?php echo $qk;?>" class="" style="<?php if($ind_score[$qk]=='1'){ ?>background-color:#e3f8da;<?php }else if($ind_score[$qk]=='2'){ ?>background-color:#ffe1cb;<?php }else if($ind_score[$qk]=='3'){ ?>background-color:#fdfbcf;<?php }else{ ?>background-color:#ffffff;<?php } ?>">
		
		<div style="padding:10px;" >
		 <?php echo '<b>'.$this->lang->line('question');?> <?php echo $qk+1;?>)</b><br>
		 <?php echo $question['question'];?>
<hr>
		 <?php if($question['description']!='') {
			echo '<b>'.$this->lang->line('description').'</b><br>';
			echo $question['description'];
		 }
		 ?> 
		 </div>
		<div style="padding:10px;" >
		 <?php 
		 // multiple single choice
		 if($question['question_type']==$this->lang->line('multiple_choice_single_answer')){
			 
			 			 			 $save_ans=array();
			 foreach($saved_answers as $svk => $saved_answer){
				 if($question['qid']==$saved_answer['qid']){
					$save_ans[]=$saved_answer['q_option'];
				 }
			 }
			 
			 
			 ?>
			 <input type="hidden"  name="question_type[]"  id="q_type<?php echo $qk;?>" value="1">
			 <?php
			$i=0;
			$correct_options=array();
			foreach($options as $ok => $option){
				if($option['qid']==$question['qid']){
					if($option['score'] >= 0.1){
						$correct_options[]=$option['q_option'];
					}
			?>
			 
		<div class="op"><?php echo $abc[$i];?>) <input type="radio" name="answer[<?php echo $qk;?>][]"  id="answer_value<?php echo $qk.'-'.$i;?>" value="<?php echo $option['oid'];?>"   <?php if(in_array($option['oid'],$save_ans)){ echo 'checked'; } ?>  > <?php echo $option['q_option'];?> </div>
			 
			 
			 <?php 
			 $i+=1;
				}else{
				$i=0;	
					
				}
			}
			echo "<br>".$this->lang->line('correct_options').': '.implode(', ',$correct_options);
		 }
			
// multiple_choice_multiple_answer	

		 if($question['question_type']==$this->lang->line('multiple_choice_multiple_answer')){
			 			 $save_ans=array();
			 foreach($saved_answers as $svk => $saved_answer){
				 if($question['qid']==$saved_answer['qid']){
					$save_ans[]=$saved_answer['q_option'];
				 }
			 }
			 
			 ?>
			 <input type="hidden"  name="question_type[]"  id="q_type<?php echo $qk;?>" value="2">
			 <?php
			$i=0;
			$correct_options=array();
			foreach($options as $ok => $option){
				if($option['qid']==$question['qid']){
						if($option['score'] >= 0.1){
						$correct_options[]=$option['q_option'];
					}
			?>
			 
		<div class="op"><?php echo $abc[$i];?>) <input type="checkbox" name="answer[<?php echo $qk;?>][]" id="answer_value<?php echo $qk.'-'.$i;?>"   value="<?php echo $option['oid'];?>"  <?php if(in_array($option['oid'],$save_ans)){ echo 'checked'; } ?> > <?php echo $option['q_option'];?> </div>
			 
			 
			 <?php 
			 $i+=1;
				}else{
				$i=0;	
					
				}
			}
			echo "<br>".$this->lang->line('correct_options').': '.implode(', ',$correct_options);
		 }
			 
	// short answer	

		 if($question['question_type']==$this->lang->line('short_answer')){
			 			 $save_ans="";
			 foreach($saved_answers as $svk => $saved_answer){
				 if($question['qid']==$saved_answer['qid']){
					$save_ans=$saved_answer['q_option'];
				 }
			 }
			 ?>
			 <input type="hidden"  name="question_type[]"  id="q_type<?php echo $qk;?>" value="3"   >
			 
			 <?php

			 
			
			 ?>
			 
		<div class="op"> 
		<?php echo $this->lang->line('your_answer');?> 
		<input type="text" name="answer[<?php echo $qk;?>][]" value="<?php echo $save_ans;?>" id="answer_value<?php echo $qk;?>"   >  
		</div>
			 
			 
			 <?php 
			 			 foreach($options as $ok => $option){
				if($option['qid']==$question['qid']){
					 echo "<br>".$this->lang->line('correct_answer').': '.$option['q_option'];
			 }
			 }
			 
		 }
		 
		 
		 	// long answer	

		 if($question['question_type']==$this->lang->line('long_answer')){
			 $save_ans="";
			 foreach($saved_answers as $svk => $saved_answer){
				 if($question['qid']==$saved_answer['qid']){
					$save_ans=$saved_answer['q_option'];
				 }
			 }
			 ?>
			 <input type="hidden"  name="question_type[]" id="q_type<?php echo $qk;?>" value="4">
			 <?php
			 ?>
			 
		<div class="op"> 
		<?php echo $this->lang->line('answer');?> <br>
		<?php echo $this->lang->line('word_counts');?>  <?php echo str_word_count($save_ans);?>
		<textarea name="answer[<?php echo $qk;?>][]" id="answer_value<?php echo $qk;?>" style="width:100%;height:100%;" onKeyup="count_char(this.value,'char_count<?php echo $qk;?>');"><?php echo $save_ans;?></textarea>
		</div>
		<?php 
		if($logged_in['su']=='1'){
			if($ind_score[$qk]=='3'){
			
		?>
		<div id="assign_score<?php echo $qk;?>">
		<?php echo $this->lang->line('evaluate');?>	
		<a href="javascript:assign_score('<?php echo $result['rid'];?>','<?php echo $qk;?>','1');"  class="btn btn-success" ><?php echo $this->lang->line('correct');?></a>	
		<a href="javascript:assign_score('<?php echo $result['rid'];?>','<?php echo $qk;?>','2');"  class="btn btn-danger" ><?php echo $this->lang->line('incorrect');?></a>	
		</div>
		<?php 
			}
		}
		?>		
			 
			 <?php 
			 
			 
		 }
			 
		
		
		
		
		
		
		// matching	

		 if($question['question_type']==$this->lang->line('match_the_column')){
			 			 			 $save_ans=array();
			 foreach($saved_answers as $svk => $saved_answer){
				 if($question['qid']==$saved_answer['qid']){
					// $exp_match=explode('__',$saved_answer['q_option_match']);
					$save_ans[]=$saved_answer['q_option'];
				 }
			 }
			 
			 
			 ?>
			 <input type="hidden" name="question_type[]" id="q_type<?php echo $qk;?>" value="5">
			 <?php
			$i=0;
			$match_1=array();
			$match_2=array();
			foreach($options as $ok => $option){
				if($option['qid']==$question['qid']){
					$match_1[]=$option['q_option'];
					$match_2[]=$option['q_option_match'];
			?>
			 
			 
			 
			 <?php 
			 $i+=1;
				}else{
				$i=0;	
					
				}
			}
			?>
			<div class="op">
						<table>
						<tr><td></td><td><?php echo $this->lang->line('your_answer');?></td><td><?php echo $this->lang->line('correct_answer');?></td></tr>
						<?php 
			 
			foreach($match_1 as $mk1 =>$mval){
						?>
						<tr><td>
						<?php echo $abc[$mk1];?>)  <?php echo $mval;?> 
						</td>
						<td>
						
							<select name="answer[<?php echo $qk;?>][]" id="answer_value<?php echo $qk.'-'.$mk1;?>"  >
							<option value="0"><?php echo $this->lang->line('select');?></option>
							<?php 
							foreach($match_2 as $mk2 =>$mval2){
								?>
								<option value="<?php echo $mval.'___'.$mval2;?>"  <?php $m1=$mval.'___'.$mval2; if(in_array($m1,$save_ans)){ echo 'selected'; } ?> ><?php echo $mval2;?></option>
								<?php 
							}
							?>
							</select>

						</td>
						
						<td>
						<?php 
							echo $match_2[$mk1];
							?>
						</td>
						
						</tr>
				
						
						<?php 
			}
			
			
			?>
			</table>
			 </div>
			<?php
			
		 }
			
		 ?>

		</div> 
 </div>
 <div id="page_break"></div>
 
 
 <?php
}
?>
</div>
</div>
<?php 
}
// view answer ends
?>





 
 
 
 
</div>
      
</div>

 



</div>

<input type="hidden" id="evaluate_warning" value="<?php echo $this->lang->line('evaluate_warning');?>">
 
 <script>
 $('.s_title').tooltip('show');
 </script>