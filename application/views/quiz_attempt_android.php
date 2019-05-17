 <html lang="en">
  <head>
  <title><?php echo $title;?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  
	<title> </title>
	<!-- bootstrap css -->
	<link href="<?php echo base_url('bootstrap/css/bootstrap.min.css');?>" rel="stylesheet">
	<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	
	<!-- custom css -->
	<link href="<?php echo base_url('css/style.css');?>" rel="stylesheet">
	
	<script>
	
	var base_url="<?php echo base_url();?>";

	
	function switchup(){
	$('#category_bar').fadeToggle();
	}
	
	
	
	</script>
	
	<!-- jquery -->
	<script src="<?php echo base_url('js/jquery.js');?>"></script>
	
	<!-- custom javascript -->
	  	<script src="<?php echo base_url('js/basic.js');?>"></script>
		
	<!-- bootstrap js -->
    <script src="<?php echo base_url('bootstrap/js/bootstrap.min.js');?>"></script>
	
	
	 <link rel="stylesheet" href="<?php echo base_url('css/jquery.mobile-1.4.5.min.css');?>">
 <script src="<?php echo base_url('js/jquery.mobile-1.4.5.min.js');?>"></script>

	
 </head>
 <body>
  
 
 
 
 <style>
 td{
		font-size:14px;
		padding:4px;
	}
	
.question_div{
 
width: 100%;
height: 100%;
position: fixed;
z-index: 1000;
background: #ffffff;
top: 0px;
left: 0px;
}


.footer_buttons{
z-index: 1200;
}

.checkbox_layer{
z-index:100;
position:absolute;
width:100%;
height:100%;
}	
</style>


<script>

var Timer;
var TotalSeconds;


function CreateTimer(TimerID, Time) {
Timer = document.getElementById(TimerID);
TotalSeconds = Time;

UpdateTimer()
window.setTimeout("Tick()", 1000);
}

function Tick() {
if (TotalSeconds <= 0) {
alert("Time's up!")
return;
}

TotalSeconds -= 1;
UpdateTimer()
window.setTimeout("Tick()", 1000);
}

function UpdateTimer() {
var Seconds = TotalSeconds;

var Days = Math.floor(Seconds / 86400);
Seconds -= Days * 86400;

var Hours = Math.floor(Seconds / 3600);
Seconds -= Hours * (3600);

var Minutes = Math.floor(Seconds / 60);
Seconds -= Minutes * (60);


var TimeStr = ((Days > 0) ? Days + " days " : "") + LeadingZero(Hours) + ":" + LeadingZero(Minutes) + ":" + LeadingZero(Seconds)


Timer.innerHTML = TimeStr;
}


function LeadingZero(Time) {

return (Time < 10) ? "0" + Time : + Time;

}

//var myCountdown1 = new Countdown({time:<?php echo $seconds;?>, rangeHi:"hour", rangeLo:"second"});
setTimeout(submitform,'<?php echo $seconds * 1000;?>');
function submitform(){
alert('Time Over');
window.location="<?php echo site_url('quiz/submit_quiz/');?>";
}

 

 

</script>

<div class="save_answer_signal" id="save_answer_signal2"></div>
<div class="save_answer_signal" id="save_answer_signal1"></div>


<div class="container" >





 
	
<div style="clear:both;"></div>

<!-- Category button -->

 <div class="row" style="display:none;" >
<?php 
$categories=explode(',',$quiz['categories']);
$category_range=explode(',',$quiz['category_range']);
 
function getfirstqn($cat_keys='0',$category_range){
	if($cat_keys==0){
		return 0;
	}else{
		$r=0;
		for($g=0; $g < $cat_keys; $g++){
		$r+=$category_range[$g];	
		}
		return $r;
	}
	
	
}



?>
</div> 

   
 
 <div class="row"  style="margin-top:5px;">
 <div class="col-md-8">
<form method="post" action="<?php echo site_url('quiz/submit_quiz/'.$quiz['rid']);?>" id="quiz_form" >
<input type="hidden" name="rid" value="<?php echo $quiz['rid'];?>">
<input type="hidden" name="noq" value="<?php echo $quiz['noq'];?>">
<input type="hidden" name="individual_time"  id="individual_time" value="<?php echo $quiz['individual_time'];?>">
 
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
 
 <div id="q<?php echo $qk;?>" class="question_div">
		
		<div class="question_container"  
		style="height:auto;background:#eeeeee;padding:4px;margin:5px;border:1px solid #dddddd;">
		 <?php echo $this->lang->line('question');?> <?php echo $qk+1;?>)<br>
		 <?php echo $question['question'];?>
		 
		 </div>
		<div class="option_container" >
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
			foreach($options as $ok => $option){
				if($option['qid']==$question['qid']){
			?>
			 
		<div class="op op_style" onClick="checkrad('answer_value<?php echo $qk.'-'.$i;?>');" > <table><tr><td><input type="radio" name="answer[<?php echo $qk;?>][]"  id="answer_value<?php echo $qk.'-'.$i;?>" value="<?php echo $option['oid'];?>"   <?php if(in_array($option['oid'],$save_ans)){ echo 'checked'; } ?> style="position:relative;" > </td><td> <?php echo $option['q_option'];?></td></tr></table> </div>
			 
			 
			 <?php 
			 $i+=1;
				}else{
				$i=0;	
					
				}
			}
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
			foreach($options as $ok => $option){
				if($option['qid']==$question['qid']){
			?>
			 
		<div class="op op_style"  >
		<div class="checkbox_layer" onClick="checkrad2('answer_value<?php echo $qk.'-'.$i;?>');"></div>
		<table><tr><td> <input type="checkbox" name="answer[<?php echo $qk;?>][]" id="answer_value<?php echo $qk.'-'.$i;?>"   value="<?php echo $option['oid'];?>"  <?php if(in_array($option['oid'],$save_ans)){ echo 'checked'; } ?> style="position:relative;" > </td><td> <?php echo $option['q_option'];?> </td></tr></table> </div>
			 
			 
			 <?php 
			 $i+=1;
				}else{
				$i=0;	
					
				}
			}
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
			 <input type="hidden"  name="question_type[]"  id="q_type<?php echo $qk;?>" value="3" >
			 <?php
			 ?>
			 
		<div class="op"> 
		<?php echo $this->lang->line('answer');?> 
		<input type="text" name="answer[<?php echo $qk;?>][]" value="<?php echo $save_ans;?>" id="answer_value<?php echo $qk;?>"   >  
		</div>
			 
			 
			 <?php 
			 
			 
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
		<?php echo $this->lang->line('word_counts');?> <span id="char_count<?php echo $qk;?>">0</span>
		<textarea name="answer[<?php echo $qk;?>][]" id="answer_value<?php echo $qk;?>" style="width:100%;height:100%;" onKeyup="count_char(this.value,'char_count<?php echo $qk;?>');"><?php echo $save_ans;?></textarea>
		</div>
			 
			 
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
						
						<?php 
			shuffle($match_1);
			shuffle($match_2);
			foreach($match_1 as $mk1 =>$mval){
						?>
						<tr><td>
						<?php echo $abc[$mk1];?>)  <?php echo $mval;?> 
						</td><td>
						
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
 
 
 
 <?php
}
?>
</form>
 </div>
  <div class="col-md-4" style="padding-bottom:80px;">
<div class="rightpanel" style="display:none;z-index:1600; margin:0px;position:absolute;background:#ffffff;right:0px;padding:5px;border:1px solid #eeeeee;" >
<a id="slideri2" href="#" style="color:#212121;">&times;</a>
<center>
 <h4><?php echo $title;?></h4>
 
	Time left: <span id='timer' >
	<script type="text/javascript">window.onload = CreateTimer("timer", <?php echo $seconds;?>);</script>
</span><br><br></center>
<?php if(count($categories) > 1 ){

	$jct=0;
	foreach($categories as $cat_key => $category){
?>
<a href="javascript:switch_category('cat_<?php echo $cat_key;?>');"   class="btn btn-default btn-sm"  style="cursor:pointer;color:#666666;"><?php echo $category;?></a>
<input type="hidden" id="cat_<?php echo $cat_key;?>" value="<?php echo getfirstqn($cat_key,$category_range);?>">
<?php 
}
echo "<br><br>";
}?>
<b> <?php echo $this->lang->line('questions');?></b>
	<div>
		<?php 
		for($j=0; $j < $quiz['noq']; $j++ ){
			?>
			
			<div class="qbtn" onClick="javascript:show_question('<?php echo $j;?>');" id="qbtn<?php echo $j;?>" ><?php echo ($j+1);?></div>
			
			<?php 
		}
		?>
<div style="clear:both;"></div>

	</div>
	
	
	<br>
	<hr>
	<br>
	<div>
	

	
<table>
<tr><td style="font-size:10px;"><div class="qbtn" style="background:#449d44;width:20px;height:20px;">&nbsp;</div> <?php echo $this->lang->line('Answered');?>  </td></tr>
<tr><td style="font-size:10px;"><div class="qbtn" style="background:#c9302c;width:20px;height:20px;">&nbsp;</div> <?php echo $this->lang->line('UnAnswered');?>  </td></tr>
<tr><td style="font-size:10px;"><div class="qbtn" style="background:#ec971f;width:20px;height:20px;">&nbsp;</div> <?php echo $this->lang->line('Review-Later');?>  </td></tr>
<tr><td style="font-size:10px;"><div class="qbtn" style="background:#212121;width:20px;height:20px;">&nbsp;</div> <?php echo $this->lang->line('Not-visited');?>  </td></tr>
</table>



	<div style="clear:both;"></div>

	</div>
</div>
 </div>
 
 
 </div>
  
 



</div>



<div class="footer_buttons">
	<button class="btn btn-warning"   onClick="javascript:review_later();" style="margin-top:2px;" ><?php echo $this->lang->line('rl');?></button>
	
	<button class="btn btn-info"  onClick="javascript:clear_response();"  style="margin-top:2px;"  ><?php echo $this->lang->line('clear');?></button>

	<button class="btn btn-success"  id="backbtn" style="visibility:hidden;" onClick="javascript:show_back_question2();"  style="margin-top:2px;" ><?php echo $this->lang->line('back');?></button>
	
	<button class="btn btn-success" id="nextbtn" onClick="javascript:show_next_question2();" style="margin-top:2px;" ><?php echo $this->lang->line('save_next');?></button>
	
	<button class="btn btn-danger"  onClick="javascript:cancelmove();" style="margin-top:2px;" ><?php echo $this->lang->line('submit_quiz');?></button>
</div>

<div style="position:fixed;top:40%;width:80px;cursor:pointer; color:#8A6D3B;height:30px;right:0px;z-index:1200;background:#FCF8E3;padding:5px;border:1px solid #FAEBCC;vertical-align:center" id="slideri"><span class="glyphicons glyphicons-expand"></span> <?php echo $this->lang->line('pallet');?></div>

<script>
var ctime=0;
var ind_time=new Array();
<?php 
$ind_time=explode(',',$quiz['individual_time']);
for($ct=0; $ct < $quiz['noq']; $ct++){
	?>
ind_time[<?php echo $ct;?>]=<?php if(!isset($ind_time[$ct])){ echo 0;}else{ echo $ind_time[$ct]; }?>;
	<?php 
}
?>
noq="<?php echo $quiz['noq'];?>";
show_question('0');


function increasectime(){
	
	ctime+=1;
 
}
 setInterval(increasectime,1000);
 setInterval(setIndividual_time,30000);
 
 
 function checkrad(did){
 
 document.getElementById(did).checked=true;
 }
 function checkrad2(did){
  
 if(document.getElementById(did).checked==true){
 document.getElementById(did).checked=false;
 }else{
 document.getElementById(did).checked=true; 
 }
 
 }
 
 $(".question_div").on("swiperight",function(){
 
  show_back_question2();
});

 $(".question_div").on("swipeleft",function(){
 
  show_next_question2();
});

$('#slideri').click(function () {
  $(".rightpanel").css("display","block");
  });
$('#slideri2').click(function () {
 
  
    $(".rightpanel").css("display","none");
 });
 
 
 
 function showspiner(){
	  
	 $('#loading_spin0').css('display','block');
	 
 }
function hidespiner(){
	 $('#loading_spin0').css('display','none');
	 
 }
 
 
 
 function submit_quiz2(){
	save_answer2(qn,'<?php echo $rid;?>');
	setIndividual_time2(qn,'<?php echo $rid;?>');
	$('#processing').html("Processing...<br>");
	setTimeout(function(){
	window.location=base_url+"index.php/api/submit_quiz/<?php echo $connection_key;?>/<?php echo $uid;?>/<?php echo $rid;?>";
	},3000);
}




function save_answer2(qn){
	
								// signal 1
							$('#save_answer_signal1').css('backgroundColor','#00ff00');
								setTimeout(function(){
							$('#save_answer_signal1').css('backgroundColor','#666666');		
								},5000);
								
								    var str = $( "form" ).serialize();
 
 
						// var formData = {user_answer:str};
						$.ajax({
							 type: "POST",
							 data : str,
								url: base_url + "index.php/api/save_answer/<?php echo $connection_key;?>/<?php echo $uid;?>/<?php echo $rid;?>",
							success: function(data){
							// signal 1
							$('#save_answer_signal2').css('backgroundColor','#00ff00');
								setTimeout(function(){
							$('#save_answer_signal2').css('backgroundColor','#666666');		
								},5000);
								
								},
							error: function(xhr,status,strErr){
								//alert(status);
								
							// signal 1
							$('#save_answer_signal2').css('backgroundColor','#ff0000');
								setTimeout(function(){
							$('#save_answer_signal2').css('backgroundColor','#666666');		
								},5500);

								}	
							});
	 		
		 
	
}


function setIndividual_time2(cqn){
	if(cqn==undefined || cqn == null ){
		var cqn='0';
	}
		  if(cqn=='0'){
		ind_time[qn]=parseInt(ind_time[qn])+parseInt(ctime);	
		 
		  }else{
			  
			ind_time[cqn]=parseInt(ind_time[cqn])+parseInt(ctime);	
		  
		  }
	
	ctime=0;
	  
	 document.getElementById('individual_time').value=ind_time.toString();
	 
	 var iid=document.getElementById('individual_time').value;
	 
	 	 
	var formData = {individual_time:iid};
	$.ajax({
		 type: "POST",
		 data : formData,
			url: base_url + "index.php/api/set_ind_time/<?php echo $connection_key;?>/<?php echo $uid;?>/<?php echo $rid;?>",
		success: function(data){
	 	
			},
		error: function(xhr,status,strErr){
			//alert(status);
			}	
		});
		
}









function show_question2(vqn){
	change_color(vqn);
	fide_all_question();
	var did="#q"+vqn;
	$(did).css('display','block');
	// hide show next back btn
	if(vqn >= 1){
	$('#backbtn').css('visibility','visible');
	}
	
	if(vqn < noq){
	$('#nextbtn').css('visibility','visible');
	}
	if((parseInt(vqn)+1) == noq){
	  
	$('#nextbtn').css('visibility','hidden');
	}
	if(vqn == 0){
	$('#backbtn').css('visibility','hidden');
	}
	
	// last qn
	qn=vqn;
lqn=vqn;
setIndividual_time2(lqn);
save_answer2(lqn);
	
}

function show_next_question2(){

	if((parseInt(qn)+1) < noq){
	fide_all_question();
	qn=(parseInt(qn)+1);
	var did="#q"+qn;
	$(did).css('display','block');
	}
	// hide show next back btn
	if(qn >= 1){
	$('#backbtn').css('visibility','visible');
	}
	if((parseInt(qn)+1) == noq){
	$('#nextbtn').css('visibility','hidden');
	}
	change_color(lqn);
	setIndividual_time2(lqn);
	save_answer2(lqn);
	
	// last qn
	lqn=qn;	
		
}
function show_back_question2(){
	
	if((parseInt(qn)-1) >= 0 ){
	fide_all_question();
	qn=(parseInt(qn)-1);
	var did="#q"+qn;
	$(did).css('display','block');
	}
	// hide show next back btn
	if(qn < noq){
	$('#nextbtn').css('visibility','visible');
	}
	if(qn == 0){
	$('#backbtn').css('visibility','hidden');
	}
	change_color(lqn);
	setIndividual_time(lqn);
	save_answer(lqn);
	
	// last qn
	lqn=qn;	
		
}



</script>
 
 
 
 
 
<div  id="warning_div" style="padding:10px; position:fixed;z-index:1200;display:none;width:98%;border-radius:5px;height:120px; border:1px solid #dddddd;left:4px;top:70px;background:#ffffff;">
<center><b> <?php echo $this->lang->line('really_Want_to_submit');?></b> <br><br>
<span id="processing"></span>

<a href="javascript:hidespiner();cancelmove();"   class="btn btn-danger"  style="cursor:pointer;"><?php echo $this->lang->line('cancel');?></a> &nbsp; &nbsp; &nbsp; &nbsp;
<a href="javascript:submit_quiz2();"   class="btn btn-info"  style="cursor:pointer;"><?php echo $this->lang->line('submit_quiz');?></a>

</center>
</div>



<div class="" id="loading_spin0" style="display:none;position:fixed;width:100%;height:100%;z-index:1000;background:#212121;color:#ffffff;opacity:0.8;text-align:center;top:0px;right:0px;">
 </div>
</body>
</html>

