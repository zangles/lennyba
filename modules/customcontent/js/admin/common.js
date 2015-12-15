function showModal(newModal){   
	$("#"+newModal).modal('show');
}
$(document).ready(function(){
    moduleFormNew = $("#frmModule").html();    
    itemFormNew = $("#frmItem").html();     
    moduleListSetup();
	groupBackgroundUploader();
	itemIconUploader();
	itemBackgroundUploader();
	tinySetup();
});
function itemIconUploader(){
	if($("#item-icon-uploader").length >0){
		new AjaxUpload($('#item-icon-uploader'), {
		action: baseModuleUrl+"/uploader.php",
			name: 'uploader',
	        data:{'maxFileSize':'1','uploadType':'image', 'secure_key':secure_key},
	        responseType: 'json',
			onChange: function(file, ext){},
			onSubmit: function(file, ext){					
				 if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){
				 	alert('You just upload files (jpg, png,jpeg,gif)');
					return false;
				}
			},
			onComplete: function(file, response){
				$('#item-icon').val(response.fileName);			
				if (response.status == '1'){
	               showSuccessMessage(response.msg);
		        }else{
		            showErrorMessage(response.msg);
		        }
			}
		});	
	}else{
		showErrorMessage(uploadfile_not_setup);
	}
}

function itemBackgroundUploader(){
	if($("#item-background-uploader").length >0){
		new AjaxUpload($('#item-background-uploader'), {
		action: baseModuleUrl+"/uploader.php",
			name: 'uploader',
	        data:{'maxFileSize':'1','uploadType':'image', 'secure_key':secure_key},
	        responseType: 'json',
			onChange: function(file, ext){},
			onSubmit: function(file, ext){					
				 if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){
				 	alert('You just upload files (jpg, png,jpeg,gif)');
					return false;
				}
			},
			onComplete: function(file, response){
				$('#item-background').val(response.fileName);			
				if (response.status == '1'){
	               showSuccessMessage(response.msg);
		        }else{
		            showErrorMessage(response.msg);
		        }
			}
		});	
	}else{
		showErrorMessage(uploadfile_not_setup);
	}
}

function groupBackgroundUploader(){
	if($("#module-background-uploader").length >0){
		new AjaxUpload($('#module-background-uploader'), {
		action: baseModuleUrl+"/uploader.php",
			name: 'uploader',
	        data:{'maxFileSize':'1','uploadType':'image', 'secure_key':secure_key},
	        responseType: 'json',
			onChange: function(file, ext){},
			onSubmit: function(file, ext){					
				 if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){
				 	alert('You just upload files (jpg, png,jpeg,gif)');
					return false;
				}
			},
			onComplete: function(file, response){
				$('#module-background').val(response.fileName);			
				if (response.status == '1'){
	               showSuccessMessage(response.msg);
		        }else{
		            showErrorMessage(response.msg);
		        }
			}
		});	
	}else{
		showErrorMessage(uploadfile_not_setup);
	}
}

jQuery(function($){    
	$('#modalModule').on('hidden.bs.modal', function (e) {
        $("#frmModule").html(moduleFormNew);
        $("p.ajax-loader").remove();
    });   
    
    $('#modalItem').on('hidden.bs.modal', function (e) {
		tinyRemove();
        $("#frmItem").html(itemFormNew);
        $("p.ajax-loader").remove();
        itemIconUploader();
		itemBackgroundUploader();
        tinySetup();
    }); 
    $(document).on('click','.lik-module-status',function(){        
            var itemId = $(this).attr('item-id');
            var value = $(this).attr('value');        
            if(value == '1'){
            	$(this).attr('value', '0').removeClass('action-enabled').addClass('action-disabled');
            }else{
            	$(this).attr('value', '1').removeClass('action-disabled').addClass('action-enabled');
            }
    		var data={'action':'changModuleStatus', 'itemId':itemId, 'value':value, 'secure_key':secure_key};
            $.ajax({
        		type:'POST',
        		url: currentUrl,
        		data: data,
        		dataType:'json',
        		cache:false,
        		async: true,
        		beforeSend: function(){},
        		complete: function(){},
        		success: function(response){
                    if(response){             
                        showSuccessMessage(response.msg);
                    }                											
        		}		
        	});            
	});
	$(document).on('click','.lik-module-edit',function(){
        var itemId = $(this).attr('item-id');  
        var data={'action':'getModuleItem', 'itemId':itemId, 'secure_key':secure_key};
        $.ajax({
    		type:'POST',
    		url: currentUrl,
    		data: data,
    		dataType:'json',
    		cache:false,
    		async: true,
    		beforeSend: function(){},
    		complete: function(){},
    		success: function(response){                    
                if(response != null){
                    if(response.status == "1"){
                    	$("#frmModule").html(response.form);
                    	showModal('modalGroup');                    	
                    }else{
                        showSuccessMessage(response.msg);
                    }
                }
    		}
    	});         

	});
    $(document).on('click','.lik-module-delete',function(){
        if(confirm("Are you sure you want to delete module item?") == true){
            var itemId = $(this).attr('item-id');        
    		var data={'action':'deleteModule', 'itemId':itemId, 'secure_key':secure_key};
            $.ajax({
        		type:'POST',
        		url: currentUrl,
        		data: data,
        		dataType:'json',
        		cache:false,
        		async: true,
        		beforeSend: function(){},
        		complete: function(){},
        		success: function(response){
                    if(response){                        
                        showSuccessMessage(response.msg);
                        if(response.status == '1') window.location.reload();
                    }                											
        		}
        	});    
        }		
	}); 
    $(document).on('click','.lik-module',function(){        
        moduleId = $(this).attr('data-item-id');
        $("#moduleList").find('.selected').each(function (){
        	$(this).removeClass('selected');
        });
        $("#mo_"+moduleId).addClass("selected");
        $("#header-module-name").html('['+$(this).html()+']');
        loadModuleContent();
        $("#row_of_module").show();        
	});  
    
   
    $(document).on('click', '.lik-item-status', function(){
		var itemId = $(this).attr('data-id');
        var value = $(this).attr('data-value');        
        if(value == '1'){
        	$(this).attr('data-value', '0').html('<i class="icon-square-o"></i> Disable');
        	$("#menu-item-title-"+itemId).addClass('red');
        }else{
        	$(this).attr('data-value', '1').html('<i class="icon-check-square-o"></i> Enable');
        	$("#menu-item-title-"+itemId).removeClass('red');
        }
		var data={'action':'changeItemStatus', 'itemId':itemId, 'value':value, 'secure_key':secure_key};
        $.ajax({
    		type:'POST',
    		url: currentUrl,
    		data: data,
    		dataType:'json',
    		cache:false,
    		async: true,
    		beforeSend: function(){},
    		complete: function(){},
    		success: function(response){
                if(response){             
                    showSuccessMessage(response.msg);
                }                											
    		}		
    	}); 
	});
	$(document).on('click', '.lik-item-delete', function (){
    	if(confirm("Are you sure you want to delete item?") == true){
            var itemId = $(this).attr('item-id');
            //moduleId = $(this).attr('data-module');                       
    		var data={'action':'deleteItem', 'itemId':itemId, 'secure_key':secure_key};
            $.ajax({
        		type:'POST',
        		url: currentUrl,
        		data: data,
        		dataType:'json',
        		cache:false,
        		async: true,
        		beforeSend: function(){},
        		complete: function(){},
        		success: function(response){
                    if(response){                        
                        showSuccessMessage(response.msg);
                        loadModuleContent();
                    }                											
        		}
        	});    
        }	
    });
    $(document).on('click', '.lik-item-edit', function(){
    	var itemId = $(this).attr('item-id');    	
        var data={'action':'getItem', 'itemId':itemId, 'secure_key':secure_key};
        $.ajax({
    		type:'POST',
    		url: currentUrl,
    		data: data,
    		dataType:'json',
    		cache:false,
    		async: true,
    		beforeSend: function(){},
    		complete: function(){},
    		success: function(response){                    
                if(response != null){
                    if(response.status == "1"){    
                    	tinyRemove();                	
						$("#frmItem").html(response.form);
                        showModal('modalItem');                        
						itemIconUploader();
						itemBackgroundUploader();
						tinySetup();
                    }else{
                        showErrorMessage(response.msg);
                    }
                }
    		}
    	}); 
    });
});
function rowSortableSetup(){
	$(".row-sortable").sortable({
        update: function (e, ui) {
            var thisModule = $(this).attr('data-module');
			var ids = new Array;			
			if($(".module-"+thisModule).length >1){
				$(".module-"+thisModule).each(function(index) {
					ids[index] = $(this).attr('data-id');					
				});
				var data={'action':'updateMenuItemOrdering', 'ids':ids};
				$.ajax({
	        		type:'POST',
	        		url: currentUrl,
	        		data: data,
	        		dataType:'json',
	        		cache:false,
	        		async: true,
	        		beforeSend: function(){},
	        		complete: function(){},
	        		success: function(response){
	        			if(response.status = '1'){
	        				showSuccessMessage(response.msg);
	        			}else{
	        				showErrorMessage(response.msg);
	        				loadModuleContent();
	        			}
	                                    											
	        		}		
	        	});
			}
		}
     });
}

function groupSortableSetup(){	
	$(".group-sortable" ).sortable({
        update: function (e, ui) {
            var thisRow = $(this).attr('data-row');
            var thisModule = $(this).attr('data-module');
			var ids = new Array;			
			if($(".row-"+thisRow).length >1){
				$(".row-"+thisRow).each(function(index) {
					ids[index] = $(this).attr('data-id');					
				});
				var data={'action':'updateMenuItemOrdering', 'ids':ids};
				$.ajax({
	        		type:'POST',
	        		url: currentUrl,
	        		data: data,
	        		dataType:'json',
	        		cache:false,
	        		async: true,
	        		beforeSend: function(){},
	        		complete: function(){},
	        		success: function(response){
	        			if(response.status = '1'){
	        				showSuccessMessage(response.msg);
	        			}else{
	        				showErrorMessage(response.msg);
	        				//loadRowContent(thisModule, thisRow);
	        			}
	                                    											
	        		}		
	        	});
			}
		}
     });		
}
function menuItemSortableSetup(parentEl){	
	$(".menuitem-sortable" ).sortable({
        update: function (e, ui) {
        	moduleId = $(this).attr('data-module');
        	rowId = $(this).attr('data-row');
        	groupId = $(this).attr('data-group');
        	
			var ids = new Array;			
			if($(".group-"+groupId).length >1){
				$(".group-"+groupId).each(function(index) {
					ids[index] = $(this).attr('data-id');					
				});
				var data={'action':'updateMenuItemOrdering', 'moduleId':moduleId, 'rowId':rowId, 'groupId':groupId, 'ids':ids};
				$.ajax({
	        		type:'POST',
	        		url: currentUrl,
	        		data: data,
	        		dataType:'json',
	        		cache:false,
	        		async: true,
	        		beforeSend: function(){},
	        		complete: function(){},
	        		success: function(response){
	        			if(response.status = '1'){
	        				showSuccessMessage(response.msg);
	        			}else{
	        				showErrorMessage(response.msg);
	        			}
	                                    											
	        		}		
	        	});
			}
		}
     });	
	
}
function loadHooks($moduleName, elHook){
	var data={'action':'loadHook', 'moduleName':$moduleName};
	$.ajax({
		type:'POST',
		url: currentUrl,
		data: data,
		dataType:'json',
		cache:false,
		async: true,
		beforeSend: function(){},
		complete: function(){},
		success: function(response){
			$("#"+elHook).html(response);			
		}		
	});
}
function moduleListSetup(){
    $("#moduleList").tableDnD({
		onDragStart: function(table, row) {
			originalOrder = $.tableDnD.serialize();
		},
		dragHandle: 'dragHandle',
		onDragClass: 'myDragClass',
		onDrop: function(table, row) {
            if (originalOrder != $.tableDnD.serialize()) {
                var rows = table.tBodies[0].rows;
                var ids = [];
                for (var i=0; i<rows.length; i++) {
                    var tr = rows[i].id;                    
                    ids[i] = tr.replace("mo_", ""); 
                }
    			var data={'action':'updateModuleOrdering', 'ids':ids, 'secure_key':secure_key};
                $.ajax({
            		type:'POST',
            		url: currentUrl,
            		data: data,
            		dataType:'json',
            		cache:false,
            		async: true,
            		beforeSend: function(){
            		},
            		complete: function(){ 					
            		},
            		success: function(response){
                        showSuccessMessage(response.msg);
                        if(response.status == '1') window.location.reload();										
            		}		
            	});
            }              		         
		}        
	});
}
function itemListSetup(){
    $("#itemList").tableDnD({
		onDragStart: function(table, row) {
			originalOrder = $.tableDnD.serialize();
		},
		dragHandle: 'dragHandle',
		onDragClass: 'myDragClass',
		onDrop: function(table, row) {
            if (originalOrder != $.tableDnD.serialize()) {
                var rows = table.tBodies[0].rows;
                var ids = [];
                for (var i=0; i<rows.length; i++) {
                    var tr = rows[i].id;                    
                    ids[i] = tr.replace("it_", ""); 
                }
    			var data={'action':'updateItemOrdering', 'ids':ids, 'secure_key':secure_key};
                $.ajax({
            		type:'POST',
            		url: currentUrl,
            		data: data,
            		dataType:'json',
            		cache:false,
            		async: true,
            		beforeSend: function(){
            		},
            		complete: function(){ 					
            		},
            		success: function(response){
                        showSuccessMessage(response.msg);
                        loadModuleContent();                        										
            		}		
            	});
            }              		         
		}        
	});
}
function saveModule(){
	$("#modalGroup .modal-footer").append('<p class="ajax-loader"><i class="fa fa-spinner fa-spin"></i></p>');
	var data = $('form#frmModule').serializeObject();
    $.ajax({
		type:'POST',
		url: currentUrl,
		data: data,
		dataType:'json',
		cache:false,
		async: true,
		beforeSend: function(){},
		complete: function(){},
		success: function(response){
			$("p.ajax-loader").remove();
            showSuccessMessage(response.msg);
            if(response.status == '1') window.location.reload();
		}
	});
}

function saveItem(){
	tinymce.triggerSave();
	//$("#modalItem .modal-footer").append('<p class="ajax-loader"><i class="fa fa-spinner fa-spin"></i></p>');
	var data = $('form#frmItem').serializeObject();	
	data.moduleId = moduleId;
    $.ajax({
		type:'POST',
		url: currentUrl,
		data: data,
		dataType:'json',
		cache:false,
		async: true,
		beforeSend: function(){},
		complete: function(){},
		success: function(response){
			$("p.ajax-loader").remove();
            showSuccessMessage(response.msg);
            if(response.status == '1'){
                $('#modalItem').modal('hide');
                loadModuleContent();	
            }
		}
	});
}
function showItemContentByType(value){
    if(value == 'link'){
        $(".item-type-image").hide();
        $(".item-type-html").hide();
        $(".item-type-module").hide();
    }else if(value == 'image'){
        $(".item-type-html").hide();
        $(".item-type-module").hide();
        $(".item-type-image").show();
    }else if(value == 'html'){
        $(".item-type-image").hide();
        $(".item-type-module").hide();
        $(".item-type-html").show();
    }else if(value == 'module'){
        $(".item-type-image").hide();
        $(".item-type-html").hide();
        $(".item-type-module").show();
    }
}
function showContentByType(value){
    if(value == 'link'){
        $(".type-image").hide();
        $(".type-html").hide();
    }else if(value == 'image'){
        $(".type-html").hide();
        $(".type-image").show();
    }else if(value == 'html'){
        $(".type-image").hide();
        $(".type-html").show();
    }
}
function changeLinkType(value){
	if(value == 'CUSTOMLINK-0'){
        $(".item-link-type-product").hide();
        $(".item-link-type-custom").show();
    }else if(value == 'PRODUCT-0'){
        $(".item-link-type-custom").hide();
        $(".item-link-type-product").show();
    }else{
        $(".item-link-type-custom").hide();
        $(".item-link-type-product").hide();
    }
}
function generationUrl(value, inputUrl){
    if(value == 'CUSTOMLINK-0'){
        $("#"+inputUrl).val('');
    }else if(value == 'PRODUCT-0'){
        showModal('modalProductId');
    }else{
        var data = {'action':'generationUrl', 'value':value, 'secure_key':secure_key};
        $.ajax({
    		type:'POST',
    		url: currentUrl,
    		data: data,
    		dataType:'json',
    		cache:false,
    		async: true,
    		beforeSend: function(){},
    		complete: function(){},
    		success: function(response){
                $("#"+inputUrl).val(response);
    		}
    	});
    }
}
function addProductId(){    
    if($('#modalMenuItem').hasClass('in') == true){
        var elUrl = 'menu-item-link';
    }else{
        $('#modalProductId').modal('hide');
        return false;
    }   
    productId = $("#product-id").val();
    if(parseInt(productId) >0){
        var value = 'PRD-'+productId;
        var data = {'action':'generationUrl', 'value':value, 'secure_key':secure_key};
        $.ajax({
    		type:'POST',
    		url: currentUrl,
    		data: data,
    		dataType:'json',
    		cache:false,
    		async: true,
    		beforeSend: function(){
    			$("#menu-item-product-id").val(productId);
    		},
    		complete: function(){},
    		success: function(response){
                $("#"+elUrl).val(response);
                $("#product-id").val('');
                $('#modalProductId').modal('hide');										
    		}
    	});        
    }
}
function moduleChangeLanguage(langId){
	var oldLang = $("#moduleLangActive").val(); 
	$("#moduleLangActive").val(langId);	
	$(".module-lang").each(function() {
		$(this).val(langId);        
    });
    $(".module-lang-"+oldLang).hide();
    $(".module-lang-"+langId).show();
}
function menuChangeLanguage(langId){
	var oldLang = $("#menuLangActive").val(); 
	$("#menuLangActive").val(langId);	
	$(".menu-lang").each(function() {
		$(this).val(langId);        
    });
    $(".menu-lang-"+oldLang).hide();
    $(".menu-lang-"+langId).show();
}
function rowChangeLanguage(langId){
	var oldLang = $("#rowLangActive").val(); 
	$("#rowLangActive").val(langId);	
	$(".row-lang").each(function() {
		$(this).val(langId);        
    });
    $(".row-lang-"+oldLang).hide();
    $(".row-lang-"+langId).show();
}
function groupChangeLanguage(langId){
	var oldLang = $("#groupLangActive").val(); 
	$("#groupLangActive").val(langId);	
	$(".group-lang").each(function() {
		$(this).val(langId);        
    });
    $(".group-lang-"+oldLang).hide();
    $(".group-lang-"+langId).show();
}
function menuItemChangeLanguage(langId){
	var oldLang = $("#menuItemLangActive").val(); 
	$("#menuItemLangActive").val(langId);	
	$(".menu-item-lang").each(function() {
		$(this).val(langId);        
    });
    $(".menu-item-lang-"+oldLang).hide();
    $(".menu-item-lang-"+langId).show();
}
function tinyRemove(elParent){	
	var i, t = tinyMCE.editors;
	for (i in t){
	    if (t.hasOwnProperty(i)){
	        t[i].remove();
	    }
	}	 
}
function loadModuleContent(){
	if(parseInt(moduleId) >0){
		var data = {'action':'loadModuleContent', 'moduleId':moduleId, 'secure_key':secure_key}; 
        $.ajax({
    		type:'POST',
    		url: currentUrl,
    		data: data,
    		dataType:'json',
    		cache:false,
    		async: true,
    		beforeSend: function(){    			
    		},
    		complete: function(){},
    		success: function(response){    
    			$("#itemList >tbody").html(response);
				itemListSetup();
    		}
    	});
	}
}

function showGroupType(value){
    if(value == 'product'){
        $("#group-type-module").hide();
        $("#group-type-product").show();
    }else if(value == 'module'){
        $("#group-type-product").hide();
        $("#group-type-module").show();
    }else{
        $("#group-type-product").hide();
        $("#group-type-module").hide();  
    } 
}
function showProductOption(value){
    if(value == 'manual'){
        $("#group-product-type-auto").hide();
        $("#group-product-type-manual").show();  
    }else{
        $("#group-product-type-manual").hide();
        $("#group-product-type-auto").show();        
    } 

}