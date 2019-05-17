<div class="container">

<div id="content" class="testd">
<h3><?php if($title){ echo $title; } ?></h3><br>

<div class="class_text_board">
	<div class="class_heading">
		Notes  <div id="page_res" ></div>
	</div>
	<div id="page" >
		<?php echo $result['content'];?>
	</div>
	
</div>
<div class="class_comment_board">
Comments<br>
<div id="comment_box"></div>
<input type="text" id="comment_send" name="class_cont" placeholder="Enter your comment" onKeyup="javascript: if (event.keyCode=='13') comment('<?php echo $class_id;?>');" >
</div>

<div style="clear:both;"></div>

</div>
</div>
<script>
get_liveclass_content('<?php echo $class_id;?>');
get_ques_content('<?php echo $class_id;?>');
</script>



<script type="text/javascript">
 
</script>
