function tinyRemove(elParent){	
	var i, t = tinyMCE.editors;
	for (i in t){
	    if (t.hasOwnProperty(i)){
	        t[i].remove();
	    }
	}	 
}
function tinySetup(config)

{

	if(!config)

		config = {};

	//var editor_selector = 'rte';

	//if (typeof config['editor_selector'] !== 'undefined')

		//var editor_selector = config['editor_selector'];

	if (typeof config['editor_selector'] != 'undefined')

		config['selector'] = '.'+config['editor_selector'];



//    safari,pagebreak,style,table,advimage,advlink,inlinepopups,media,contextmenu,paste,fullscreen,xhtmlxtras,preview

	default_config = {

		selector: ".editor" ,

		height: 160,

		plugins : "colorpicker link image paste pagebreak table contextmenu filemanager table code media textcolor shortcode_module, shortcode_product",

		toolbar1 : "code,|,bold,italic,underline,strikethrough,|,alignleft,aligncenter,alignright,alignfull,formatselect,|,blockquote,colorpicker,pasteword,|,bullist,numlist,|,outdent,indent,|,link,unlink,|,cleanup,|,media,image",

		toolbar2: "",

		external_filemanager_path: ad+"/filemanager/",

		filemanager_title: "File manager" ,

		external_plugins: { "filemanager" : ad+"/filemanager/plugin.min.js"},

		language: iso,
        
        
        
		skin: "prestashop",

		statusbar: false,

		relative_urls : false,

		convert_urls: false,
		verify_html : false,
		extended_valid_elements : "em[class|name|id],div[*],ul[*],deal",
        custom_elements : 'em, module, product',
        entity_encoding : "raw",
        //forced_root_block : false,    
        //force_br_newlines : true,    
        force_p_newlines : false,
        forced_root_block : 'div',
		menu: {

			edit: {title: 'Edit', items: 'undo redo | cut copy paste | selectall'},

			insert: {title: 'Insert', items: 'media image link | pagebreak'},

			view: {title: 'View', items: 'visualaid'},

			format: {title: 'Format', items: 'bold italic underline strikethrough superscript subscript | formats | removeformat'},

			table: {title: 'Table', items: 'inserttable tableprops deletetable | cell row column'},

			tools: {title: 'Tools', items: 'code shortcode_module shortcode_product'}

		}

	};

	
	tinyMCE.PluginManager.add('shortcode_module', function(editor, url) {
		editor.addButton('shortcode_module', {
			text: 'Module',
			icon: true,
			onclick: function() {
				editor.windowManager.open({
					title: 'Module Shortcode',
					width: 400,
					height: 120,
					body: [
						{
							type: 'textbox', 
							name: 'module_name', 
							label: 'Enter module name',								
    					},
    					{
							type: 'textbox', 
							name: 'hook_name', 
							label: 'Enter hook name',								
    					}
					],
					onsubmit: function(e) {
						editor.insertContent('{module}{"mod":"'+e.data.module_name+'", "hook":"'+e.data.hook_name+'"}{/module}');
					}
				});
			}
		});	
		// Adds a menu item to the tools menu
		editor.addMenuItem('shortcode_module', {
			text: 'Module',
			context: 'tools',
			onclick: function() {
				editor.windowManager.open({
					title: 'Module Shortcode',
					width: 400,
					height: 120,
					body: [
						{
							type: 'textbox', 
							name: 'module_name', 
							label: 'Enter module name',								
    					},
    					{
							type: 'textbox', 
							name: 'hook_name', 
							label: 'Enter hook name',								
    					}
					],
					onsubmit: function(e) {
						editor.insertContent('{module}{"mod":"'+e.data.module_name+'", "hook":"'+e.data.hook_name+'"}{/module}');
					}
				});				
			}
		});
	});
	tinyMCE.PluginManager.add('shortcode_product', function(editor, url) {
		editor.addButton('shortcode_product', {
			text: 'Product',
			icon: true,
			onclick: function() {
				editor.insertContent('{product}{"id":"1"}{/product}');				
			}
		});	
		// Adds a menu item to the tools menu
		editor.addMenuItem('shortcode_product', {
			text: 'Product',
			context: 'tools',
			onclick: function() {
				editor.insertContent('{product}{"id":"1"}{/product}');			
			}
		});
	});
	$.each(default_config, function(index, el)
	{
		if (config[index] === undefined )
			config[index] = el;

	});
	tinyMCE.init(config);



};