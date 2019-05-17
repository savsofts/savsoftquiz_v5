 <div class="container">

   
 <h3><?php echo $title;?></h3>
   
 

  <div class="row">
   	
<div class="col-md-8">
<br> 
  
 
 <div class="alert alert-danger"><?php echo $this->lang->line('pending_quiz_message');?></div>
 <br><br>
 <?php echo str_replace('[link]',site_url($openquizurl),$this->lang->line('manual_redirect'));?>
 
 
</div>
       
</div>

 
 



</div>

<script>
setTimeout(function(){
window.location="<?php echo site_url($openquizurl);?>";
},7000);

</script>
