 
function remove_entry(redir_cont){
	
	if(confirm("Do you really want to remove entry?")){
		window.location=base_url+"index.php/"+redir_cont;
	}
	
}



function updategroup(vall,gid){
	 
	var formData = {group_name:vall};
	$.ajax({
		 type: "POST",
		 data : formData,
			url: base_url + "index.php/user/update_group/"+gid,
		success: function(data){
		$("#message").html(data);
			
			},
		error: function(xhr,status,strErr){
			//alert(status);
			}	
		});
	
}

function updategroupprice(vall,gid){
	 
	var formData = {price:vall};
	$.ajax({
		 type: "POST",
		 data : formData,
			url: base_url + "index.php/user/update_group/"+gid,
		success: function(data){
		$("#message").html(data);
			
			},
		error: function(xhr,status,strErr){
			//alert(status);
			}	
		});
	
}


function updategroupvalid(vall,gid){
	 
	var formData = {valid_day:vall};
	$.ajax({
		 type: "POST",
		 data : formData,
			url: base_url + "index.php/user/update_group/"+gid,
		success: function(data){
		$("#message").html(data);
			
			},
		error: function(xhr,status,strErr){
			//alert(status);
			}	
		});
	
}



function updatecategory(vall,cid){
	 
	var formData = {category_name:vall};
	$.ajax({
		 type: "POST",
		 data : formData,
			url: base_url + "index.php/qbank/update_category/"+cid,
		success: function(data){
		$("#message").html(data);
			
			},
		error: function(xhr,status,strErr){
			//alert(status);
			}	
		});
	
}



function getexpiry(){
	 var gid=document.getElementById('gid').value;
	var formData = {gid:gid};
	$.ajax({
		 type: "POST",
		 data : formData,
			url: base_url + "index.php/user/get_expiry/"+gid,
		success: function(data){
		$("#subscription_expired").val(data);
			
			},
		error: function(xhr,status,strErr){
			//alert(status);
			}	
		});
	
}


function updatelevel(vall,lid){
	 
	var formData = {level_name:vall};
	$.ajax({
		 type: "POST",
		 data : formData,
			url: base_url + "index.php/qbank/update_level/"+lid,
		success: function(data){
		$("#message").html(data);
			
			},
		error: function(xhr,status,strErr){
			//alert(status);
			}	
		});
	
}



function hidenop(vall){
	if(vall == '1' || vall=='2' || vall=='3'){
		$("#nop").css('display','block');
	}else{
	$("#nop").css('display','none');
	}
}



function addquestion(quid,qid){
	 var did='#q'+qid;
	var formData = {quid:quid};
	$.ajax({
		 type: "POST",
		 data : formData,
			url: base_url + "index.php/quiz/add_qid/"+quid+'/'+qid,
		success: function(data){
		$(did).html(document.getElementById('added').value);
			
			},
		error: function(xhr,status,strErr){
			//alert(status);
			}	
		});
	
}





 
var position_type="Up";
var global_quid="0";
var global_qid="0";
var global_opos="0";

function cancelmove(position_t,quid,qid,opos){
save_answer(qn);
position_type=position_t;
global_quid=quid;
global_qid=qid;
global_opos=opos;

if((document.getElementById('warning_div').style.display)=="block"){
document.getElementById('warning_div').style.display="none";
}else{
document.getElementById('warning_div').style.display="block";
if(position_type=="Up"){
var upos=parseInt(global_opos)-parseInt(1);
}else{
var upos=parseInt(global_opos)+parseInt(1);
}
document.getElementById('qposition').value=upos;

}

}


function movequestion(){

var pos=document.getElementById('qposition').value;

if(position_type=="Up"){
var npos=parseInt(global_opos)-parseInt(pos);
window.location=base_url+"index.php/quiz/up_question/"+global_quid+"/"+global_qid+"/"+npos;
}else{
var npos=parseInt(pos)-parseInt(global_opos);
window.location=base_url+"index.php/quiz/down_question/"+global_quid+"/"+global_qid+"/"+npos;
}
}



function no_q_available(lid){
	var cid=document.getElementById('cid').value;
	
		var formData = {cid:cid};
	$.ajax({
		 type: "POST",
		 data : formData,
			url: base_url + "index.php/quiz/no_q_available/"+cid+'/'+lid,
		success: function(data){
		$('#no_q_available').html(data);
			
			},
		error: function(xhr,status,strErr){
			//alert(status);
			}	
		});
}




// quiz attempt functions 

var noq=0;
var qn=0;
var lqn=0;

function fide_all_question(){
	
	for(var i=0; i < noq; i++){
		
		var did="#q"+i;
	$(did).css('display','none');
	}
}


function show_question(vqn){
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
setIndividual_time(lqn);
save_answer(lqn);
	
}

function show_next_question(){

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
	setIndividual_time(lqn);
	save_answer(lqn);
	
	// last qn
	lqn=qn;	
		
}

function check_answer(){
var classid=".green_option"+qn;
$(classid).css('display','block');
$(classid).css('background-color','#D6F7C3');
 
}


function show_back_question(){
	
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


function change_color(qn){
	var did='#qbtn'+qn;
	var q_type='#q_type'+lqn;
	
	// if not answered then make red
	// alert($(did).css('backgroundColor'));
	if($(did).css('backgroundColor') != 'rgb(68, 157, 68)' && $(did).css('backgroundColor') != 'rgb(236, 151, 31)'){
	$(did).css('backgroundColor','#c9302c');
	$(did).css('color','#ffffff');
	}
	
	// answered make green
	if(lqn >= '0' && $(did).css('backgroundColor') != 'rgb(236, 151, 31)'){
	var ldid='#qbtn'+lqn;
		
		if($(q_type).val()=='1' || $(q_type).val()=='2'){
		var green=0;
		for(var k=0; k<=10; k++){
			var answer_value="answer_value"+lqn+'-'+k;
			if(document.getElementById(answer_value)){
				if(document.getElementById(answer_value).checked == true){	
				green=1;
				}
			}
		}
		if(green==1){			
		$(ldid).css('backgroundColor','#449d44');
		$(ldid).css('color','#ffffff');	
		}		
		}		
 		
		if($(q_type).val()=='3' || $(q_type).val()=='4'){
		var answer_value="#answer_value"+lqn;
		if($(answer_value).val()!=''){			
		$(ldid).css('backgroundColor','#449d44');
		$(ldid).css('color','#ffffff');	
		}
		}		
 		
		if($(q_type).val()=='5'){
			var green=0;
			for(var k=0; k<=10; k++){
				var answer_value="answer_value"+lqn+'-'+k;
				if(document.getElementById(answer_value)){
					if(document.getElementById(answer_value).value != '0'){	
					green=1;
					}
				}
			}
			if(green==1){			
			$(ldid).css('backgroundColor','#449d44');
			$(ldid).css('color','#ffffff');	
			}		
		}		
		
	}
	
}


// clear radio btn response
function clear_response(){
var q_type='#q_type'+qn;
		
		if($(q_type).val()=='1' || $(q_type).val()=='2'){
		 
		for(var k=0; k<=10; k++){
			var answer_value="answer_value"+lqn+'-'+k;
			
			if(document.getElementById(answer_value)){
				
				if(document.getElementById(answer_value).checked == true){
					
				document.getElementById(answer_value).checked=false;
				}
			}
		}
	 		
		}	
		
		if($(q_type).val()=='3' || $(q_type).val()=='4'){
		var answer_value="answer_value"+qn;
		document.getElementById(answer_value).value='';
		}	
		
		
		
		if($(q_type).val()=='5'){
			 
			for(var k=0; k<=10; k++){
				var answer_value="answer_value"+qn+'-'+k;
				if(document.getElementById(answer_value)){
					if(document.getElementById(answer_value).value != '0'){	
					document.getElementById(answer_value).value='0';
					}
				}
			}
		 		
		}			
	var did='#qbtn'+qn;
	$(did).css('backgroundColor','#c9302c');
	$(did).css('color','#ffffff');
}

var review_later;
function review_later(){
	
 
	if(review_later[qn] && review_later[qn]){
	
		review_later[qn]=0;
		var did='#qbtn'+qn;
	$(did).css('backgroundColor','#c9302c');
			$(did).css('color','#ffffff');	
	}else{
		
		review_later[qn]=1;
	var did='#qbtn'+qn;
	$(did).css('backgroundColor','#ec971f');
	$(did).css('color','#ffffff');
	}
	
}




function save_answer(qn){
	
								// signal 1
							$('#save_answer_signal1').css('backgroundColor','#00ff00');
								setTimeout(function(){
							$('#save_answer_signal1').css('backgroundColor','#666666');		
								},5000);
								
								      var str = $( "#quiz_form" ).serialize()+'&'+$.param({ 'qn': qn });
 
 
						// var formData = {user_answer:str};
						$.ajax({
							 type: "POST",
							 data : str,
								url: base_url + "index.php/quiz/save_answer/",
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

 
function setIndividual_time(cqn){
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
			url: base_url + "index.php/quiz/set_ind_time",
		success: function(data){
	 	
			},
		error: function(xhr,status,strErr){
			//alert(status);
			}	
		});
		
}




function submit_quiz(){
	save_answer(qn);
	setIndividual_time(qn);
	$('#processing').html("Processing...<br>");
	setTimeout(function(){
	window.location=base_url+"index.php/quiz/submit_quiz/";
	},3000);
}



function switch_category(c_k){
	
	var did=document.getElementById(c_k).value;
	show_question(did);
	
}


function count_char(answer,span_id){
	var chcount=answer.split(' ').length;
	if(answer == ''){
		chcount=0;
	}
	document.getElementById(span_id).innerHTML=chcount; 
	
}



function sort_result(limit,val){
	window.location=base_url+"index.php/result/index/"+limit+"/"+val;
	
}


function assign_score(rid,qno,score){
	 var evaluate_warning=	document.getElementById('evaluate_warning').value;
	 if(confirm(evaluate_warning)){
	var formData = {rid:rid};
	$.ajax({
		 type: "POST",
		 data : formData,
			url: base_url + "index.php/quiz/assign_score/"+rid+'/'+qno+'/'+score,
		success: function(data){
	 	var did="#assign_score"+qno;
		$(did).css('display','none');
			},
		error: function(xhr,status,strErr){
			//alert(status);
			}	
		});	
	 }
}



function show_question_stat(id){
	var did="#stat-"+id;
	 
	if($(did).css('display')=='none'){
		$(did).css('display','block');
	}else{
		$(did).css('display','none');
	}
	 
}
 

// end - quiz attempt functions 









// start classroom




function postclass_content(id){
var cont=document.getElementById('page').innerHTML;
var formData = {content:cont};
document.getElementById('page_res').innerHTML="Sending data...";
	$.ajax({
		type: "POST",
	    data : formData,
		url: base_url + "index.php/liveclass/insert_content/"+id,
		success: function(data){
				var d = new Date();
		var dt=d.toString();
		var gt=dt.replace("GMT+0530 (India Standard Time)","");
		document.getElementById('page_res').innerHTML="Sent : "+gt;

		},
		error: function(xhr,status,strErr){
			document.getElementById('page_res').innerHTML="Sending failed!";
			}	
		});

}


function get_liveclass_content(id){

	$.ajax({
		url: base_url + "index.php/liveclass/get_class_content/"+id,
		success: function(data){
		var d = new Date();
var dt=d.toString();
var gt=dt.replace("GMT+0530 (India Standard Time)","");
document.getElementById('page').innerHTML=data;
		document.getElementById('page_res').innerHTML="Last updated on "+gt;
setTimeout(function(){
get_liveclass_content(id);
},5000);
		},
		error: function(xhr,status,strErr){
setTimeout(function(){
get_liveclass_content(id);
},5000);
			}	
		});
		
	document.getElementById("page").scrollTop = document.getElementById("page").scrollHeight;
	
}



function get_liveclass_content_2(id){

	$.ajax({
		url: base_url + "index.php/liveclass/get_class_content/"+id,
		success: function(data){
		var d = new Date();
var dt=d.toString();
var gt=dt.replace("GMT+0530 (India Standard Time)","");
document.getElementById('page').innerHTML=data;
		document.getElementById('page_res').innerHTML="Last updated on "+gt;

		},
		error: function(xhr,status,strErr){
setTimeout(function(){
get_liveclass_content(id);
},5000);
			}	
		});
		
	document.getElementById("page").scrollTop = document.getElementById("page").scrollHeight;
	
}



var class_id;
function get_ques_content(id){
class_id=id;
	$.ajax({
		url: base_url + "index.php/liveclass/get_ques_content/"+id,
		success: function(data){
		//alert(data);
		document.getElementById('comment_box').innerHTML=data;
		
setTimeout(function(){
get_ques_content(id);
},5000);
		},
		error: function(xhr,status,strErr){
setTimeout(function(){
get_ques_content(id);
},5000);
			}	
		});
		document.getElementById("comment_box").scrollTop = document.getElementById("comment_box").scrollHeight;

}

function get_ques_content_2(id){
class_id=id;
	$.ajax({
		url: base_url + "index.php/liveclass/get_ques_content/"+id,
		success: function(data){
		//alert(data);
		document.getElementById('comment_box').innerHTML=data;
		

		},
		error: function(xhr,status,strErr){
setTimeout(function(){
get_ques_content(id);
},5000);
			}	
		});
		document.getElementById("comment_box").scrollTop = document.getElementById("comment_box").scrollHeight;

}


function comment(id){
var comnt=document.getElementById('comment_send').value;

var formData = {content:comnt};
document.getElementById('comment_send').value="Sending data...";
	$.ajax({
		type: "POST",
	    data : formData,
		url: base_url + "index.php/liveclass/insert_comnt/"+id,
		success: function(data){
				document.getElementById('comment_send').value="";
		},
		error: function(xhr,status,strErr){
			document.getElementById('comment_send').innerHTML="Sending failed!";
			}	
		});

}


var publish="0";
 function show_options(id,p){
comnt_id=id;
publish=p;
if(publish=="0"){
document.getElementById('pub').innerHTML="Unpublish";
}else{
document.getElementById('pub').innerHTML="Publish";

}
$("#comnt_optn").fadeIn();

}
function hide_options(){
$("#comnt_optn").fadeOut();
}
 
  function publish_comment(){

	var formData = {id:comnt_id,pub:publish};
	$.ajax({
		type: "POST",
	    data : formData,
		url: base_url + "index.php/liveclass/publish_comnt/",
		success: function(data){
				$("#comnt_optn").fadeOut();
				 get_ques_content(class_id);
		},
		});
 
 
 }
 
 function delete_comment(){
 //alert(comnt_id);
	var formData = {id:comnt_id};
	$.ajax({
		type: "POST",
	    data : formData,
		url: base_url + "index.php/liveclass/del_comnt/",
		success: function(data){
				$("#comnt_optn").fadeOut();
				 get_ques_content(class_id);
		},
		});
 
 
 }

// end classroom







 // version check
function update_check(sq_version){
	 
	var formData = {sq_version:sq_version};
	$.ajax({
		 type: "POST",
		 data : formData,
			url: "http://update.savsoftquiz.com/",
		success: function(data){
			if(data.trim() <=sq_version){
			var msg="<div class='alert alert-success'>You are using updated version of <a href='http://savsoftquiz.com'>Savsoft Quiz "+sq_version+"</a></div>";	
			}else{
			var msg="<div class='alert alert-danger'>New version available: Savsoft Quiz v"+data.trim()+". You are using outdated version of Savsoft Quiz v"+sq_version+". Visit <a href='http://savsoftquiz.com'>www.savsoftquiz.com</a> to download</div>";	
				
			}
			if(!document.getElementById("update_notice")){
				$('body').prepend(msg);
			}else{
		$("#update_notice").html(msg);
			}
			
			},
		error: function(xhr,status,strErr){
			//alert(status);
			}	
		});
	
}















/* Set the width of the sidebar to 250px and the left margin of the page content to 250px */
function openNav() {
  document.getElementById("mySidebar").style.width = "250px";
  document.getElementById("main").style.marginLeft = "250px";
}

/* Set the width of the sidebar to 0 and the left margin of the page content to 0 */
function closeNav() {
  document.getElementById("mySidebar").style.width = "0";
  document.getElementById("main").style.marginLeft = "0";
}
 

