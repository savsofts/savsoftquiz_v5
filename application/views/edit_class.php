<div class="container" >
<script type="text/javascript" src="<?php echo base_url();?>/js/basic.js"></script>
<br>
<?php 
if($resultstatus){ echo "<div class='alert alert-success'>".$resultstatus."</div>"; }
 ?> 
<form method="post" action="<?php echo site_url('liveclass/edit_class/'.$class_id);?>">
<a href="<?php echo site_url('liveclass');?>"    class="btn btn-danger">Back</a>
<div class="row" style="margin-top:10px;">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php if($title){ echo $title; } ?>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                   
                                        <div class="form-group">
                                            <label>Class Name</label>
		                                         <input type='text'  class="form-control"  name='class_name'   value="<?php echo $result['class_name'];?>"  >

                                         </div>
	                                      <div class="form-group">
                                            <label>Start Time ( YYYY/MM/DD HH:MM:SS  )</label>
		                                         <input type='text'  class="form-control"  name='start_time'  value="<?php echo date("Y/m/d H:i:s",$result['initiated_time']);?>">

                                         </div>
	                                      <div class="form-group">
                                            <label>Assign to Groups:</label><br>
		                                       	<?php
												$group_counter = 1; 
												foreach($groups as $key => $group){ ?>
													<?php echo $group['group_name']; ?>  &nbsp;<input type="checkbox" name="assigned_groups[]" value="<?php echo $group['gid']; ?>"  <?php if(in_array($group['gid'],$assigned_gids)){ echo "checked";} ?> > &nbsp; &nbsp;&nbsp;
												<?php if($group_counter%5 == 0){ echo "</br>"; } $group_counter++; }  ?>
											
													 </div>
													 
									     <div class="form-group">
                                            
 <input type="submit" value="Submit"  name="submit_class"   class="btn btn-default"> 
                                         </div>
						
										 
										 
										 
								
								</div>
							</div>
						</div>
					</div>
				</div>
</div>

</form>





</div>
 
<script type="text/javascript">
	tinyMCE.init({
	
    mode : "textareas",
		theme : "advanced",
		relative_urls:"false",
	 plugins: "jbimages",
	
  // ===========================================
  // PUT PLUGIN'S BUTTON on the toolbar
  // ===========================================
	
 
	
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "jbimages,insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft,visualblocks",
		
		
	});
</script>
