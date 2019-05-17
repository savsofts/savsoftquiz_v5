/**
 * Creates a TINYMCE instance on "example" div.
 * @param  {string} lang              TINYMCE language. WIRIS plugin read this variable to set the editor lang.
 * @param  {string} wiriseditorparameters JSON containing WIRIS editor parameters.
 */
 function createEditorInstance(lang, wiriseditorparameters) {

 	var dir = 'ltr';
 	if (lang == 'ar' || lang == 'he'){
 		dir = 'rtl';
 	}

 	if (typeof wiriseditorparameters == 'undefined') {
 		wiriseditorparameters = {};
 	}

 	tinymce.init({
 		selector: '#example',
 		height : 300,
 		auto_focus:true,
 		language: lang,
 		directionality : dir,
 		// To avoid TinyMCE path conversion from base64 to blob objects.
 		// https://www.tinymce.com/docs/configure/file-image-upload/#images_dataimg_filter
 		images_dataimg_filter : function(img) {
			return img.hasAttribute('internal-blob');
 		},
 		menubar : false,
 		plugins: 'tiny_mce_wiris',
 		toolbar: 'code,|,bold,italic,underline,|,cut,copy,paste,|,search,|,undo,redo,|,forecolor,backcolor,|,justifyleft,justifycenter,justifyright,fontselect,fontsizeselect,|,tiny_mce_wiris_formulaEditor,tiny_mce_wiris_formulaEditorChemistry,|,fullscreen',
 		init_instance_callback : "updateFunctionTimeOut",
 		setup : function(ed)
 		{
 			ed.on('init', function() 
 			{
 				this.getDoc().body.style.fontSize = '16px';
 				this.getDoc().body.style.fontFamily = 'Arial, "Helvetica Neue", Helvetica, sans-serif';
 			});
 		},
 		
 	});
 }

 function updateFunctionTimeOut() {
 	setTimeout(function(){ updateFunction();}, 500);
 }

 var exampleContainer = document.getElementById('example');
 if (exampleContainer.innerHTML.trim().length == 0 || exampleContainer.innerHTML == '<br>') {
 	exampleContainer.innerHTML = document.getElementById('example_content').innerHTML;
 }

// Creating TINYMCE demo instance.
createEditorInstance('en', {});

/**
 * Getting data from editor using getContent TINYMCE method.
 * Using WIRIS formulas are parsed to WIRIS save mode format (mathml, image or base64)
 * For more information see: http://www.wiris.com/es/plugins/docs/full-mathml-mode.
 * @return {string} TINYMCE parsed data.
 */
 function getEditorData() {
 	return tinymce.get('example').getContent();
 }

/**
 * Changes dynamically wiriseditorparameters TINYMCE config variable.
 * @param {json} json_params WIRIS editor parameters.
 */
 function setParametersSpecificPlugin(wiriseditorparameters) {
 	//var lang = tinyMCE.activeEditor.settings.langCode;
 	//resetEditor(lang, wiriseditorparameters);
 	tinyMCE.activeEditor.settings.wiriseditorparameters = wiriseditorparameters;
 }

 function resetEditor(lang){
 	var editor_parameters = tinyMCE.activeEditor.settings.wiriseditorparameters;
 	tinymce.EditorManager.execCommand('mceRemoveEditor',true, "example");
 	createEditorInstance(lang, editor_parameters);
    _wrs_modalWindow = undefined;
 }

/**
 * Gets wiriseditorparameters from TINYMCE.
 * @return {object} WIRIS editor parameters as JSON. An empty JSON if is not defined.
 */
 function getWirisEditorParameters() {
 	if (typeof tinyMCE.activeEditor.settings != 'undefined' && typeof tinyMCE.activeEditor.settings.wiriseditorparameters != 'undefined') {
 		return tinyMCE.activeEditor.settings.wiriseditorparameters;
 	} 
 	return {};
 }