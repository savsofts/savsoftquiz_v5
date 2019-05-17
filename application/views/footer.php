<?php 
if($this->uri->segment(3) != 'ph'){
if($this->config->item('mathjax')){
?><script type="text/javascript"
     src="https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
  </script>
  <?php 
  }
  ?>
  
  </div>
  
  
<center><?php 
if($this->uri->segment(2) != 'attempt'  && $this->uri->segment(1) != 'install'){
	$this->db->where("add_status","Active");
	$this->db->where("position","Bottom");
	$query=$this->db->get('savsoft_add');
	if($query->num_rows()==1){
	$ad=$query->row_array();
	if($ad['advertisement_code'] != ""){
	echo $ad['advertisement_code'];
	}else if($ad['banner']!=''){ ?><a href="<?php echo $ad['banner_link'];?>" target="new_add"><img src="<?php echo base_url('upload/'.$ad['banner']);?>" class="img-responsive"  ></a> <?php    
	
	}
	}
	}
	
	
?></center>


<?php
$during_quiz="";
if($this->uri->segment(2) == 'attempt'){
	$this->db->where("add_status","Active");
	$this->db->where("position","During_Quiz");
	$query=$this->db->get('savsoft_add');
	if($query->num_rows()==1){
	$ad=$query->row_array();
	if($ad['advertisement_code'] != ""){
	$during_quiz=$ad['advertisement_code'];
	}else if($ad['banner']!=''){ 
	$during_quiz="<a href='".$ad['banner_link']."' target='new_add'><img src='".base_url('upload/'.$ad['banner'])."' class='img-responsive'  ></a>";
	}
	}
	}
	
 
if($during_quiz != ""){
?>
<script>
setTimeout(function(){
showadvertisement();
},<?php echo ($this->config->item('showadvertisement_after')*1000);?>);


function showadvertisement(){
$('#advertisement_bg').css('display','block');
$('#advertisement').css('display','block');

setTimeout(function(){
$('#advertisement').css('display','none');
$('#advertisement_bg').css('display','none');
},<?php echo $this->config->item('showadvertisement_sec')*1000;?>);

}

</script>
<div style="display:none;width:100%;height:90%;background:#212121;position:fixed;z-index:1700;top:0px;right:0px;padding-top:10%;opacity:0.7" id="advertisement_bg" >

</div>
<div style="display:none;width:100%;height:90%;background:transparent;position:fixed;z-index:1800;top:0px;right:0px;padding-top:10%;color:#ffffff;" id="advertisement" >

<center>
<label>Advertisement will close in <?php echo $this->config->item('showadvertisement_sec');?> Seconds...</label>
<?php echo $during_quiz;?></center></div>

<?php
}	
	?>
	 
<div class="container" style="text-align:right;">
Powered by <a href="https://savsoftquiz.com">Savsoft Quiz</a>
</div>
</div>	   
		

<?php 
if($this->config->item('tinymce')){
					if($this->uri->segment(2)!='attempt'){
					if($this->uri->segment(2)!='view_result'){

					if($this->uri->segment(2)!='config'){
					if($this->uri->segment(2)!='css'){
					if($this->uri->segment(2)!='edit_advertisment'){

	
	?>
	<script type="text/javascript" src="<?php echo base_url();?>editor/tinymce.min.js"></script>
	 
 <?php 
 if($this->uri->segment(2)=='edit_quiz' || ($this->uri->segment(2)=='add_new' && $this->uri->segment(1)=='quiz')){
?>
<script type="text/javascript">
  tinymce.init({
  selector: '.tinymce_textarea',
  height: 100,
  theme: 'modern',
  plugins: [
    'advlist autolink lists link image jbimages <?php if($this->config->item('eqneditor')){ ?>eqneditor<?php } ?> charmap print preview hr anchor pagebreak',
    'searchreplace wordcount visualblocks visualchars code fullscreen',
    'insertdatetime media nonbreaking save table contextmenu directionality',
    'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc help'
  ],
  toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image |  jbimages | <?php if($this->config->item('eqneditor')){ ?>eqneditor<?php } ?>',
  toolbar2: 'print preview media | forecolor backcolor emoticons | codesample help',
  image_advtab: true,
  templates: [
    { title: 'Test template 1', content: 'Test 1' },
    { title: 'Test template 2', content: 'Test 2' }
  ],
  content_css: [
    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
    '//www.tinymce.com/css/codepen.min.css'
  ]
 });
 
 </script>

 

<?php 
 }else{
?>

	<script type="text/javascript">
  tinymce.init({
  selector: 'textarea',
  images_dataimg_filter: function(img) {
    return img.hasAttribute('internal-blob');
  },
  height: 100,
  theme: 'modern',
  plugins: [
    'advlist autolink lists link image jbimages <?php if($this->config->item('eqneditor')){ ?>eqneditor<?php } ?> <?php if($this->config->item('wiris')){ ?>tiny_mce_wiris<?php } ?>  charmap print preview hr anchor pagebreak',
    'searchreplace wordcount visualblocks visualchars code fullscreen',
    'insertdatetime media nonbreaking save table contextmenu directionality',
    'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc help'
  ],
  toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image |  jbimages | <?php if($this->config->item('eqneditor')){ ?>eqneditor<?php } ?> <?php if($this->config->item('wiris')){ ?> | tiny_mce_wiris_formulaEditor | tiny_mce_wiris_formulaEditorChemistry | tiny_mce_wiris_CAS <?php } ?>',
  toolbar2: 'print preview media | forecolor backcolor emoticons | codesample help',
  image_advtab: true,
  templates: [
    { title: 'Test template 1', content: 'Test 1' },
    { title: 'Test template 2', content: 'Test 2' }
  ],
  content_css: [
    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
    '//www.tinymce.com/css/codepen.min.css'
  ]
 });
 
 </script>

<?php 
 }
 ?>
 
 

	
	<?php 
	}
						}
					}
			}
		}
	}
?>






 

<div id="messages"></div>

 



<!-- duplicate question check -->
<div id="duplicate_question" style="display:none;position:fixed;z-index:1000;width:100%;bottom:0px;height:220px;overflow-y:auto;background:#212121;color:#ffffff;padding:8px;">

<a href="javascript:canceldupli();" style="float:right;"><i class="fa fa-times"></i></a>
<div id="duplicate_question2">

</div>
</div>
<script>
var showdupli=1;
function canceldupli(){
$('#duplicate_question').css('display','none');	
showdupli=0;
}
		
function myCustomOnChangeHandler(inst) {
         
      tinyMCE.triggerSave();
       var question=$('#question').val();
if(question != '' && showdupli == 1){
$('#duplicate_question').css('display','block');

	var formData = {question:question};
	$.ajax({
		 type: "POST",
		 data : formData,
		url: base_url + "index.php/duplicate_question/index",
		success: function(data){
		 
		if(data.trim() != ''){
	 	$('#duplicate_question2').html(data);
	 	}else{
	 	 
	 	$('#duplicate_question').css('display','none');
	 	}
			},
		error: function(xhr,status,strErr){
			//alert(status);
			}	
		});
		}else{
$('#duplicate_question').css('display','none');		
		}
}

 		
</script>
<!-- dupllicate question check ends -->
 <?php } ?>
</body>
</html>
