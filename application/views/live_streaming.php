  <link href="<?php echo base_url('css/streaming.css');?>" rel="stylesheet" type="text/css">
  <script src="https://static.opentok.com/v2/js/opentok.min.js"></script>
  <i id="spinner" class="fa fa-circle-o-notch fa-spin fa-4x"  style="color:#ffffff;margin-left:45%;"></i>
  
   <div id="videos">
        <div id="subscriber"></div>
        <div id="publisher"></div>
    </div>
    
    
   
      <script type="text/javascript" src="<?php echo base_url('js/streaming.js');?>"></script>
      
       <script>

getSQLcdet("<?php echo $this->config->item('SQLc_user_id');?>","<?php echo $this->config->item('SQLc_key');?>","<?php echo $this->config->item('SQLc_path');?>","<?php echo $SQLc_session_id;?>");

</script>
