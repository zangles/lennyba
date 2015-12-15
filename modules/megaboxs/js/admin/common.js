String.prototype.escapeSpecialChars = function() {
    return this.replace(/\\n/g, "\\n")
               .replace(/\\'/g, "\\'")
               .replace(/\\"/g, '\\"')
               .replace(/\\&/g, "\\&")
               .replace(/\\r/g, "\\r")
               .replace(/\\t/g, "\\t")
               .replace(/\\b/g, "\\b")
               .replace(/\\f/g, "\\f");
};

// 
function replacequote(text) {
    var newText = "";
    for (var i = 0; i < text.length; i++) {
        if (text[i] == "'") {
            newText += "\\'";
        }
        else
            newText += text[i];
    }
    return newText;
};
function handleEnterNumber(event){
	var keyCode = event.keyCode ? event.keyCode : event.charCode;	
	if((keyCode < 48 || keyCode > 58) && keyCode != 8 && keyCode != 13 && keyCode != 9 && keyCode != 35 && keyCode != 36 && keyCode != 99 && keyCode != 118 && keyCode != 46 && keyCode != 37 && keyCode != 39 && keyCode != 45){
		return false;
	}		
}
function handleEnterNumberInt(event){
	var keyCode = event.keyCode ? event.keyCode : event.charCode;
	if((keyCode < 48 || keyCode > 58) && keyCode != 8 && keyCode != 13 && keyCode != 9 && keyCode != 35 && keyCode != 36 && keyCode != 99 && keyCode != 118 && keyCode != 37 && keyCode != 39 && keyCode != 45){
		return false;
	}		
}
function showModal(newModal){   
	$("#"+newModal).modal('show');
}
function goToElement(eId, offset){
	$("html, body").animate({ scrollTop: $('#'+eId).offset().top-offset}, 1000);
}
$(document).ready(function(){
    formNewMegamenu = $("#frmMegamenu").html();
    formNewMenu = $("#frmMenu").html();
    formNewRow = $("#frmRow").html();
    formNewGroup = $("#frmGroup").html();
    formNewMenuItem = $("#frmMenuItem").html();
    formNewSubMenu =   $("#frmSubMenu").html();
    formNewSubMenuItem =    $("#frmSubMenuItem").html();
    $(".tab-groups a").click(function(e){
        $(".tab-groups").find('a').removeClass('active');
        $(this).addClass('active');
    	e.preventDefault();
    	$(this).tab('show');
    });    
    tinySetup();
    moduleListSetup();
    //menuBackgroundUploader();
    //menuIconUploader();
    //menuIconActiveUploader();
	menuitemImageUploader();
	menuitemIconActiveUploader();
	menuitemImageUploader();
	subMenuitemIconUploader();
	subMenuitemIconActiveUploader();
});
function menuBackgroundUploader(){
	if($("#menu-background-uploader").length >0){
		new AjaxUpload($('#menu-background-uploader'), {
			action: baseModuleUrl+"/uploader.php",
			name: 'uploader',
	        data:{'maxFileSize':'2','uploadType':'image', 'secure_key':secure_key},
	        responseType: 'json',
			onChange: function(file, ext){},
			onSubmit: function(file, ext){					
				 if (!(ext && /^(jpg|png|jpeg|gif)$/.test(ext))){
				 	alert('You just upload files (jpg, png,jpeg,gif)');
					return false;
				}
			},
			onComplete: function(file, response){
				$('#menu-background').val(response.fileName);			
				if (response.status == '0')
	               showErrorMessage(response.msg);		        
			}
		});	
	}else{
		showErrorMessage(uploadfile_not_setup);
	}		
}
function menuIconUploader(){
	if($("#menu-icon-uploader").length >0){
		new AjaxUpload($('#menu-icon-uploader'), {
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
				$('#menu-icon').val(response.fileName);			
				if (response.status == '0'){
	               showErrorMessage(response.msg);
		        }
			}
		});	
	}else{
		showErrorMessage(uploadfile_not_setup);
	}
		
}
function menuIconActiveUploader(){
	if($("#menu-icon-active-uploader").length >0){
		new AjaxUpload($('#menu-icon-active-uploader'), {
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
				$('#menu-icon-active').val(response.fileName);			
				if (response.status == '0'){
	               showErrorMessage(response.msg);
		        }
			}
		});		
	}else{
		showErrorMessage(uploadfile_not_setup);
	}	
}
function subMenuIconUploader(){
	if($("#submenu-icon-uploader").length >0){
		new AjaxUpload($('#submenu-icon-uploader'), {
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
				$('#submenumenu-icon').val(response.fileName);			
				if (response.status == '0'){
	               showErrorMessage(response.msg);
		        }
			}
		});	
	}else{
		showErrorMessage(uploadfile_not_setup);
	}
		
}
function subMenuIconActiveUploader(){
	if($("#submenu-icon-active-uploader").length >0){
		new AjaxUpload($('#submenu-icon-active-uploader'), {
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
				$('#submenu-icon-active').val(response.fileName);			
				if (response.status == '0'){
	               showErrorMessage(response.msg);
		        }
			}
		});		
	}else{
		showErrorMessage(uploadfile_not_setup);
	}	
}
function menuitemIconUploader(){
	if($("#menuitem-icon-uploader").length >0){
		new AjaxUpload($('#menuitem-icon-uploader'), {
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
				$('#menuitem-icon').val(response.fileName);			
				if (response.status == '0'){
	               showErrorMessage(response.msg);
		        }
			}
		});	
	}else{
		showErrorMessage(uploadfile_not_setup);
	}
		
}
function menuitemIconActiveUploader(){
	if($("#menuitem-icon-active-uploader").length >0){
		new AjaxUpload($('#menuitem-icon-active-uploader'), {
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
				$('#menuitem-icon-active').val(response.fileName);			
				if (response.status == '0'){
	               showErrorMessage(response.msg);
		        }
			}
		});		
	}else{
		showErrorMessage(uploadfile_not_setup);
	}	
}
function menuitemImageUploader(){
	if($("#menu-item-image-uploader").length >0){
		new AjaxUpload($('#menu-item-image-uploader'), {
		action: baseModuleUrl+"/uploader.php",
			name: 'uploader',
	        data:{'maxFileSize':'2','uploadType':'image', 'secure_key':secure_key},
	        responseType: 'json',
			onChange: function(file, ext){},
			onSubmit: function(file, ext){					
				 if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){
				 	alert('You just upload files (jpg, png,jpeg,gif)');
					return false;
				}
			},
			onComplete: function(file, response){	
			    var langActive = $("#menuItemLanguageActive").val();			
				$('#menuItemImage-'+langActive).val(response.fileName);			
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

function subMenuitemIconUploader(){
	if($("#sub-menuitem-icon-uploader").length >0){
		new AjaxUpload($('#sub-menuitem-icon-uploader'), {
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
				$('#sub-menuitem-icon').val(response.fileName);			
				if (response.status == '0'){
	               showErrorMessage(response.msg);
		        }
			}
		});		
	}else{
		showErrorMessage(uploadfile_not_setup);
	}	
}
function subMenuitemIconActiveUploader(){
	if($("#sub-menuitem-icon-active-uploader").length >0){
		new AjaxUpload($('#sub-menuitem-icon-active-uploader'), {
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
				$('#sub-menuitem-icon-active').val(response.fileName);			
				if (response.status == '0'){
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
        $("#frmMegamenu").html(formNewMegamenu);
        $("p.ajax-loader").remove();
    });
    $('#modalMenu').on('hidden.bs.modal', function (e) {
		$("#frmMenu").html(formNewMenu);
        $("p.ajax-loader").remove();
        menuBackgroundUploader();
        menuIconUploader();
        menuIconActiveUploader();
    });
    $('#modalSubMenu').on('hidden.bs.modal', function (e) {
		$("#frmSubMenu").html(formNewSubMenu);
        $("p.ajax-loader").remove();        
        subMenuIconUploader();
        subMenuIconActiveUploader();
    });
    $('#modalRow').on('hidden.bs.modal', function (e) {
        $("#frmRow").html(formNewRow);
        $("p.ajax-loader").remove();
    });
    $('#modalGroup').on('hidden.bs.modal', function (e) {
        $("p.ajax-loader").remove();
        tinyRemove();
        $("#frmGroup").html(formNewGroup);        
        $(".tab-groups a").click(function(e){
	        $(".tab-groups").find('a').removeClass('active');
	        $(this).addClass('active');
	    	e.preventDefault();
	    	$(this).tab('show');
	    });
    	tinySetup();
    });    
    $('#modalMenuItem').on('hidden.bs.modal', function (e) {
    	$("p.ajax-loader").remove();
		tinyRemove();
		$("#frmMenuItem").html(formNewMenuItem);
        menuitemImageUploader();
        menuitemIconActiveUploader();
		menuitemImageUploader();
        tinySetup();       
    });
    $('#modalSubMenuItem').on('hidden.bs.modal', function (e) {
    	$("p.ajax-loader").remove();		
		$("#frmSubMenuItem").html(formNewSubMenuItem);
		subMenuitemIconUploader();
		subMenuitemIconActiveUploader();		
    });
   
    $(document).on('click', '.link-add-megamenu', function(){
    	showModal('modalModule');
    });
    $(document).on('click', '.link-status-megamenu',function(){
		var value	 =	$(this).attr('data-value');
		var id		 = 	$(this).attr('data-id');
		var action	 = 	$(this).attr('data-action');
        if(value == '1'){
        	$(this).attr('data-value', '0').removeClass('link-active').addClass('link-deactive c-org');
        }else{
        	$(this).attr('data-value', '1').removeClass('link-deactive c-org').addClass('link-active');
        }
		var data={'action':'changeMegamenuStatus', 'itemId':id, 'value':value, 'secure_key':secure_key};
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
	$(document).on('click', '.link-edit-megamenu',function(){        
        var data={'action':'getMegamenuItem', 'itemId':$(this).data().id, 'secure_key':secure_key};
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
                    	$("#frmMegamenu").html(response.form);
                    	showModal('modalModule');                    	
                    }else{
                        showSuccessMessage(response.msg);
                    }
                }
    		}
    	});         

	});
    $(document).on('click', '.link-trash-megamenu',function(){
        if(confirm("Are you sure you want to delete item?") == true){                
    		var data={'action':'deleteMegamenuItem', 'id':$(this).data().id, 'secure_key':secure_key};
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
    $(document).on('click', '.link-megamenu',function(){        
        $(".list-megamenu").removeClass('selected');
        megamenuId = $(this).data('id');//.attr('data-id');        
        $("#megamenu_"+megamenuId).addClass('selected');
        $("#header-megamenu-name").html($(this).html());
        loadMegamenuContent();
        $("#panel-menus").show();        
	});
	$(document).on('click', '.link-copy-megamenu', function(){
		var megamenuId = $(this).data().id;
        var data={'action':'copyMegamenu', 'id':megamenuId, 'secure_key':secure_key};
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
                    	window.location.reload();                    	     
                    }else{
                        showErrorMessage(response.msg);
                    }
                }
    		}
    	});
	});
	//=========================================================================================================================================================
	//																		MENU
	//=========================================================================================================================================================
	$(document).on('click', '.link-add-menu', function(){
		menuId = 0;
		showModal('modalMenu');
	});	
	$(document).on('click', '.link-addsub-menu', function(){
		parentMenuId = $(this).data('id');
		showModal('modalSubMenu');
	});
	$(document).on('click', '.link-trash-menu',function(){
        if(confirm(confirm_delete_menu) == true){
            var itemId = $(this).attr('data-id');  
            megamenuId = $(this).data().megamenu;      
    		var data={'action':'deleteMenu', 'id':$(this).data().id, 'secure_key':secure_key};
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
                        if(response.status == '1') 
                        	loadMegamenuContent();
                    }                											
        		}
        	});    
        }		
	}); 
	$(document).on('click', '.link-edit-menu', function(){
    	var itemId = $(this).attr('data-id');
    	megamenuId = $(this).attr('data-megamenu');    	
        var data={'action':'getMenuItem', 'id':itemId, 'secure_key':secure_key};
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
						$("#frmMenu").html(response.form);
						menuBackgroundUploader();
						menuIconUploader();
						menuIconActiveUploader();					
                        showModal('modalMenu');
                    }else{
                        showErrorMessage(response.msg);
                    }
                }
    		}
    	}); 
    });
    $(document).on('click', '.link-edit-submenu', function(){
    	var itemId = $(this).data('id');
    	parentMenuId = $(this).data('parent');    	
        var data={'action':'getSubMenuItem', 'id':itemId, 'secure_key':secure_key};
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
						$("#frmSubMenu").html(response.form);
						subMenuIconUploader();
						subMenuIconActiveUploader();					
                        showModal('modalSubMenu');
                    }else{
                        showErrorMessage(response.msg);
                    }
                }
    		}
    	}); 
    });
	$(document).on('click', '.link-status-menu',function(){
		var value	 =	$(this).attr('data-value');
		var id		 = 	$(this).attr('data-id');
        if(value == '1'){
        	$(this).attr('data-value', '0').removeClass('link-active').addClass('link-deactive c-org');
        }else{
        	$(this).attr('data-value', '1').removeClass('link-deactive c-org').addClass('link-active');
        }
		var data={'action':'changMenuStatus', 'id':id, 'value':value, 'secure_key':secure_key};
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
	$(document).on('click', '.link-menu',function(){        
        megamenuId =  $(this).data().megamenu;
        menuId = $(this).data().id; 
        $(".list-menu").removeClass('selected');
        $("#mn_"+menuId).addClass('selected');
        $("#header-menu-name").html('['+$(this).html()+']');
        loadMenuContent();
        $("#row_of_menu").show();        
	});
    $(document).on('click', '.link-copy-menu', function(){
		rowId = $(this).data().id;
    	megamenuId = $(this).data().megamenu;
        var data={'action':'copyMenu', 'id':rowId, 'secure_key':secure_key};
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
                    	showSuccessMessage(response.msg);
                    	loadMegamenuContent();     	
                    }else{
                        showErrorMessage(response.msg);
                    }
                }
    		}
    	});
	});
	//=========================================================================================================================================================
	//																		END MENU
	//=========================================================================================================================================================
    //=========================================================================================================================================================
	//																		ROW
	//=========================================================================================================================================================
	$(document).on('click', '.link-add-row', function(){
    	showModal('modalRow');
    });
    $(document).on('click', '.link-status-row',function(){        
            var itemId = $(this).attr('data-id');
            var value = $(this).attr('data-value');        
            if(value == '1'){                
            	$(this).attr('data-value', '0').html('<i class="icon-square-o"></i> '+lab_disable);
                $("#panel-row-"+itemId).addClass('disable');
            }else{
            	$(this).attr('data-value', '1').html('<i class="icon-check-square-o"></i> '+lab_enable);
                $("#panel-row-"+itemId).removeClass('disable');
            }
    		var data={'action':'changRowStatus', 'itemId':itemId, 'value':value, 'secure_key':secure_key};
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
    $(document).on('click', '.link-edit-row',function(){
        var itemId = $(this).attr('data-id');  
        var data={'action':'getRowItem', 'itemId':itemId, 'secure_key':secure_key};
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
                    	$("#frmRow").html(response.form);
                    	showModal('modalRow');                    	
                    }else{
                        showSuccessMessage(response.msg);
                    }
                }
    		}
    	});         
	});
	$(document).on('click', '.link-delete-row',function(){
        if(confirm("Are you sure you want to delete row item?") == true){
            var itemId = $(this).attr('data-id');        
    		var data={'action':'deleteRow', 'itemId':itemId, 'secure_key':secure_key};
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
                        loadMenuContent();
                    }                											
        		}
        	});    
        }		
	});
	$(document).on('click', '.link-copy-row', function(){
		rowId = $(this).data().id;
    	megamenuId = $(this).data('module');    	  	
        var data={'action':'copyRow', 'id':rowId, 'secure_key':secure_key};
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
                    	showSuccessMessage(response.msg);
                        loadMegamenuContent();
                    }else{
                        showErrorMessage(response.msg);
                    }
                }
    		}
    	});
	});
	//=========================================================================================================================================================
	//																		END ROW
	//=========================================================================================================================================================
	//=========================================================================================================================================================
	//																		GROUP
	//=========================================================================================================================================================
	$(document).on('click', '.link-add-group', function(){
		rowId = $(this).attr('data-id');
		showModal('modalGroup');        
	});
	$(document).on('click', '.link-group-status', function(){
		var itemId = $(this).attr('data-id');
        var value = $(this).attr('data-value');        
        if(value == '1'){
            $("#panel-group-"+itemId).removeClass('enable').addClass('disable');
        	$(this).attr('data-value', '0').html('<i class="icon-square-o"></i> '+lab_disable);
        }else{
        	$(this).attr('data-value', '1').html('<i class="icon-check-square-o"></i> '+lab_enable);
            $("#panel-group-"+itemId).removeClass('disable').addClass('enable');
        }
		var data={'action':'changGroupStatus', 'itemId':itemId, 'value':value, 'secure_key':secure_key};
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
    $(document).on('click', '.link-group-edit', function(){
    	var itemId = $(this).attr('data-id');
    	moduleId = $(this).attr('data-module');
    	rowId = $(this).attr('data-row');
        var data={'action':'getGroupItem', 'itemId':itemId, 'moduleId':moduleId, 'rowId':rowId, 'secure_key':secure_key};
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
				        $("#frmGroup #group-config").html(response.config);
				        $("#frmGroup #group-description").html(response.description);
				        $(".tab-groups a").click(function(e){
					        $(".tab-groups").find('a').removeClass('active');
					        $(this).addClass('active');
					    	e.preventDefault();
					    	$(this).tab('show');
					    });
				    	tinySetup();    	
                    	showModal('modalGroup');
                    }else{
                        showErrorMessage(response.msg);
                    }
                }
    		}
    	}); 
    });
    $(document).on('click', '.link-group-delete', function (){
    	if(confirm(confirm_delete_group) == true){
            var itemId = $(this).attr('data-id');
            megamenuId = $(this).data().module;
            menuId = $(this).data().menu;
            rowId = $(this).data().row;
    		var data={'action':'deleteGroup', 'itemId':itemId, 'secure_key':secure_key};
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
                        loadRowContent();
                    }                											
        		}
        	});    
        }	
    });    
	$(document).on('click', '.link-group-copy', function(){
		groupId = $(this).data().id;
    	megamenuId = $(this).data().module;
    	menuId = $(this).data().menu;
    	rowId = $(this).data().row;  	
        var data={'action':'copyGroup', 'id':groupId, 'secure_key':secure_key};
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
                    	showSuccessMessage(response.msg);
                    	loadRowContent();                    	
                    }else{
                        showErrorMessage(response.msg);
                    }
                }
    		}
    	});
	});
	//=========================================================================================================================================================
	//																		END GROUP
	//=========================================================================================================================================================
	
	//=========================================================================================================================================================
	//																		MENUITEM
	//=========================================================================================================================================================
	$(document).on('click', '.link-group-additem', function(){
		groupId = $(this).attr('data-id');
		rowId = $(this).attr('data-row');
		moduleId = $(this).attr('data-module');
		showModal('modalMenuItem');
	});
	$(document).on('click', '.link-addsub-menuitem', function(){
    	megamenuId 			= 	$(this).data('module');
    	menuId 				= 	$(this).data('menu');
    	rowId				=	$(this).data('row');
    	groupId				=	$(this).data('group');
    	parentMenuItemId	=	$(this).data('id');
    	showModal('modalSubMenuItem');
    });	
	$(document).on('click', '.open-this', function(){
		var el = $(this).data('el');
		var status = $(this).attr('data-status');
		if(status == '1'){
			$(this).attr('data-status', 0).html('+');
		}else{
			$(this).attr('data-status', 1).html('-');
		}
		$("#"+el).toggle("slow");
	});
	$(document).on('click', '.link-open-this', function(){
		var el = $(this).data('el');
		var status = $(this).attr('data-status');
		if(status == '1'){
			$(this).attr('data-status', '0').html('<i class="fa fa-plus-square-o"></i>');
		}else{
			$(this).attr('data-status', '1').html('<i class="fa fa-minus-square-o"></i>');
		}
		$("#"+el).toggle("slow");
	});
	// change menuitem status
    $(document).on('click', '.link-menu-item-status', function(){
		var itemId = $(this).attr('data-id');
        var value = $(this).attr('data-value');        
        if(value == '1'){
        	$("#div-menu-item-"+itemId).removeClass('enable').addClass('disable');
        	$(this).attr('data-value', '0').html('<i class="icon-square-o"></i> '+lab_disable);
        }else{
        	$("#div-menu-item-"+itemId).removeClass('disable').addClass('enable');
        	$(this).attr('data-value', '1').html('<i class="icon-check-square-o"></i> '+lab_enable);
        }
		var data={'action':'changMenuItemStatus', 'itemId':itemId, 'value':value, 'secure_key':secure_key};
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
	// delete menuitem
	$(document).on('click', '.link-menu-item-delete', function (){
    	if(confirm("Are you sure you want to delete menu item?") == true){
            var itemId = $(this).attr('data-id');
            moduleId = $(this).attr('data-module');
            rowId = $(this).attr('data-row');
            groupId = $(this).attr('data-group');            
    		var data={'action':'deleteMenuItem', 'itemId':itemId, 'secure_key':secure_key};
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
                        loadGroupContent();
                    }                											
        		}
        	});    
        }	
    });
    // edit menuitem
    $(document).on('click', '.link-menu-item-edit', function(){
    	var itemId = $(this).data().id;
    	megamenuId = $(this).data().module;
    	menuId = $(this).data().menu;
    	rowId = $(this).data().row;
    	groupId = $(this).data().group;    	
        var data={'action':'getMenuItemItem', 'id':itemId, 'moduleId':megamenuId, 'menuId':menuId, 'rowId':rowId, 'groupId':groupId, 'secure_key':secure_key};
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
						$("#frmMenuItem").html(response.form);
						menuitemImageUploader();
						menuitemIconActiveUploader();
						menuitemImageUploader();						
                        showModal('modalMenuItem');
						tinySetup();
                    }else{
                        showErrorMessage(response.msg);
                    }
                }
    		}
    	}); 
    });
    // copy menuitem
    $(document).on('click', '.link-menu-item-copy', function(){
    	var itemId = $(this).data().id;
    	megamenuId = $(this).data().module;
    	menuId = $(this).data().menu;
    	rowId = $(this).data().row;
    	groupId = $(this).data().group;    	
        var data={'action':'copyMenuItem', 'id':itemId, 'moduleId':megamenuId, 'menuId':menuId, 'rowId':rowId, 'groupId':groupId, 'secure_key':secure_key};
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
                    	showSuccessMessage(response.msg);
                    	loadGroupContent();                    	
                    }else{
                        showErrorMessage(response.msg);
                    }
                }
    		}
    	}); 
    });
    //=========================================================================================================================================================
    $(document).on('click','.link-export',function(){
        var data={'action':'exportSameData', 'secure_key':secure_key};
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
                	showSuccessMessage(response);
                }
    		}
    	}); 	
	});
	$(document).on('click','.link-import',function(){
        var data={'action':'importData', 'secure_key':secure_key};
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
                	showSuccessMessage(response);
                	window.location.reload();
                }
    		}
    	}); 	
	});
	
	$(document).on('click', '.chk-all', function (){
		var dataClass = $(this).data().classname;
		if($(this).hasClass('link-deactive')){
			$(this).removeClass('link-deactive').addClass('link-active');
			$("."+dataClass).each(function(index) {
				$(this).prop( "checked", true);
			});
		}else{
			$(this).removeClass('link-active').addClass('link-deactive');
			$("."+dataClass).each(function(index) {
				$(this).prop( "checked", false);
			});
		}
	});
});
/*
function menuSortableSetup(){
	$("#menuList .list-body").sortable({
		placeholder: "ui-state-highlight",
        update: function (e, ui) {
			var ids = new Array;			
			if($(".parent-0").length >1){
				$(".parent-0").each(function(index) {
					ids[index] = $(this).data('id');					
				});
				var data={'action':'updateMenuOrdering', 'ids':ids};
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
*/

function menuSortableSetup(parentEl, el){
	if(el != ''){
		$(el).sortable({
			placeholder: "ui-state-highlight",
	        update: function (e, ui) {        	
	        	parentMenuId = $(this).data('parent');
				var ids = new Array;			
				if($(".parent-"+parentMenuId).length >1){
					$(".parent-"+parentMenuId).each(function(index) {
						ids[index] = $(this).data('id');					
					});
					var data={'action':'updateMenuOrdering', 'ids':ids};
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
	}else{
		if(parentEl == ''){
			$(".menu-sortable").sortable({
				placeholder: "ui-state-highlight",
		        update: function (e, ui) {        			        	
		        	parentMenuId = $(this).data('parent');		        	
					var ids = new Array;			
					if($(".parent-"+parentMenuId).length >1){
						$(".parent-"+parentMenuId).each(function(index) {
							ids[index] = $(this).data('id');					
						});
						var data={'action':'updateMenuOrdering', 'ids':ids};
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
		}else{
			$(parentEl+" .menu-sortable").sortable({
				placeholder: "ui-state-highlight",
		        update: function (e, ui) {        	
		        	parentMenuId = $(this).data('parent');		        
					var ids = new Array;			
					if($(".parent-"+parentMenuId).length >1){
						$(".parent-"+parentMenuId).each(function(index) {
							ids[index] = $(this).data('id');					
						});
						var data={'action':'updateMenuOrdering', 'ids':ids};
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
	}
}
function menuSortableDestroy(parentEl, el){	
	if(el != ''){
		$(el).sortable('destroy');		
	}else{
		if(parentEl == ''){
			$(".menu-sortable").sortable('destroy');			
		}else{
			$(parentEl+" .menu-sortable").sortable('destroy');
		}
	}
	return true;
}

function subMenuSortableSetup(parentEl, el){
	if(el != ''){
		$(el).sortable({
			placeholder: "ui-state-highlight",
	        update: function (e, ui) {
	        	parentMenuItemId = $(this).data('parent');
				var ids = new Array;			
				if($(".menuitem-parent-"+parentMenuItemId).length >1){
					$(".menuitem-parent-"+parentMenuItemId).each(function(index) {
						ids[index] = $(this).data('id');					
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
		        			}
		                                    											
		        		}		
		        	});
				}
			}
	     });
	}else{
		if(parentEl == ''){
			$(".menuitem-sortable").sortable({
				placeholder: "ui-state-highlight",
		        update: function (e, ui) {        			        	
		        	parentMenuItemId = $(this).data('parent');		        	
					var ids = new Array;			
					if($(".menuitem-parent-"+parentMenuItemId).length >1){
						$(".menuitem-parent-"+parentMenuItemId).each(function(index) {
							ids[index] = $(this).data('id');					
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
			        			}
			                                    											
			        		}		
			        	});
					}
				}
		     });
		}else{
			$(parentEl+" .menuitem-sortable").sortable({
				placeholder: "ui-state-highlight",
		        update: function (e, ui) {        	
		        	parentMenuItemId = $(this).data('parent');		        
					var ids = new Array;			
					if($(".menuitem-parent-"+parentMenuItemId).length >1){
						$(".menuitem-parent-"+parentMenuItemId).each(function(index) {
							ids[index] = $(this).data('id');					
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
			        			}
			                                    											
			        		}		
			        	});
					}
				}
		     });
		}
	}
}
function subMenuSortableDestroy(parentEl, el){	
	if(el != ''){
		$(el).sortable('destroy');		
	}else{
		if(parentEl == ''){
			$(".menuitem-sortable").sortable('destroy');			
		}else{
			$(parentEl+" .menuitem-sortable").sortable('destroy');
		}
	}
	return true;
}
function rowSortableSetup(){
	$(".row-sortable").sortable({
        update: function (e, ui) {
            moduleId = $(this).attr('data-module');
            menuId = $(this).attr('data-menu');
			var ids = new Array;			
			if($(".menu-"+menuId).length >1){
				$(".menu-"+menuId).each(function(index) {
					ids[index] = $(this).attr('data-id');					
				});
				var data={'action':'updateRowOrdering', 'moduleId':moduleId, 'menuId':menuId, 'ids':ids};
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
	        				//loadMenuContent();
	        			}
	                                    											
	        		}		
	        	});
			}
		}
     });
}
function groupSortableSetup(parentEl){
	if(parentEl == ""){
		$(".group-sortable" ).sortable({
	        update: function (e, ui) {
	        	moduleId = $(this).attr('data-row');
	        	menuId = $(this).attr('data-menu');
	            rowId = $(this).attr('data-row');
				var ids = new Array;			
				if($(".row-"+rowId).length >1){
					$(".row-"+rowId).each(function(index) {
						ids[index] = $(this).attr('data-id');					
					});
					var data={'action':'updateGroupOrdering', 'moduleId':moduleId, 'menuId':menuId, 'rowId':rowId, 'ids':ids};
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
	}else{
		$("#"+parentEl+" .group-sortable" ).sortable({
	        update: function (e, ui) {
	            moduleId = $(this).attr('data-row');
	        	menuId = $(this).attr('data-menu');
	            rowId = $(this).attr('data-row');
				var ids = new Array;			
				if($(".row-"+rowId).length >1){
					$(".row-"+rowId).each(function(index) {
						ids[index] = $(this).attr('data-id');					
					});
					var data={'action':'updateGroupOrdering', 'moduleId':moduleId, 'menuId':menuId, 'rowId':rowId, 'ids':ids};
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
}
function menuItemSortableSetup(parentEl){
	if(parentEl == ""){
		$(".menuitem-sortable" ).sortable({
	        update: function (e, ui) {
	        	moduleId = $(this).attr('data-module');
	        	menuId = $(this).attr('data-menu');
	        	rowId = $(this).attr('data-row');
	        	groupId = $(this).attr('data-group');
	        	
				var ids = new Array;			
				if($(".group-"+groupId).length >1){
					$(".group-"+groupId).each(function(index) {
						ids[index] = $(this).attr('data-id');					
					});
					var data={'action':'updateMenuItemOrdering', 'moduleId':moduleId, 'menuId':menuId, 'rowId':rowId, 'groupId':groupId, 'ids':ids};
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
	}else{
		$("#"+parentEl+" .menuitem-sortable" ).sortable({
	        update: function (e, ui) {
	        	moduleId = $(this).attr('data-module');
	        	menuId = $(this).attr('data-menu');
	        	rowId = $(this).attr('data-row');
	        	groupId = $(this).attr('data-group');
				var ids = new Array;			
				if($(".group-"+groupId).length >1){
					$(".group-"+groupId).each(function(index) {
						ids[index] = $(this).attr('data-id');					
					});
					var data={'action':'updateMenuItemOrdering', 'moduleId':moduleId, 'menuId':menuId, 'rowId':rowId, 'groupId':groupId, 'ids':ids};
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
}
function loadModuleHooks(moduleName, elHook){
	var data={'action':'loadModuleHooks', 'moduleName':moduleName};
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
                    ids[i] = tr.replace("megamenu_", ""); 
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
function menuListSetup(){
    $("#menuList").tableDnD({
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
                    ids[i] = tr.replace("mn_", ""); 
                }
    			var data={'action':'updateMenuOrdering', 'ids':ids, 'secure_key':secure_key};
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
            		}		
            	});
            }              		         
		}        
	});
}
function saveModule(){
	$("#modalModule .modal-footer").append('<p class="ajax-loader"><i class="fa fa-spinner fa-spin"></i></p>');
	var data = $('form#frmMegamenu').serializeObject();
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
function saveMenu(){
	$("#modalMenu .modal-footer").append('<p class="ajax-loader"><i class="fa fa-spinner fa-spin"></i></p>');
	var data = $('form#frmMenu').serializeObject();
	data.megamenuId = megamenuId;
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
            if(response.status == '1'){
            	$('#modalMenu').modal('hide');
            	showSuccessMessage(response.msg);
            	loadMegamenuContent();
            }else{
            	showErrorMessage(response.msg);
            }
		}
	});
}
// save submenu
function saveSubMenu(){
	$("#modalSubMenu .modal-footer").append('<p class="ajax-loader"><i class="fa fa-spinner fa-spin"></i></p>');
	var data = $('form#frmSubMenu').serializeObject();
	data.megamenuId = megamenuId;
	data.parent_id = parentMenuId;
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
            if(response.status == '1'){
            	$('#modalSubMenu').modal('hide');
            	showSuccessMessage(response.msg);
            	loadSubmenu();
            }else{
            	showErrorMessage(response.msg);
            }
		}
	});
}

function saveRow(){
	$("#modalRow .modal-footer").append('<p class="ajax-loader"><i class="fa fa-spinner fa-spin"></i></p>');
	var data = $('form#frmRow').serializeObject();
	data.megamenuId = megamenuId;
	//data.menuId = menuId;
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
			$('#modalRow').modal('hide');
            showSuccessMessage(response.msg);
            loadMegamenuContent();
            //loadMenuContent();
		}
	});
}
function saveGroup(){
	$("#modalGroup .modal-footer").append('<p class="ajax-loader"><i class="fa fa-spinner fa-spin"></i></p>');
	tinymce.triggerSave();
	var data = $('form#frmGroup').serializeObject();
	data.megamenuId = megamenuId;
	data.rowId = rowId;	
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
                $('#modalGroup').modal('hide');
                loadRowContent();	
            }										
		}
	}); 
}
function saveMenuItem(){
	$("#modalMenuItem .modal-footer").append('<p class="ajax-loader"><i class="fa fa-spinner fa-spin"></i></p>');
	tinymce.triggerSave();
	var data = $('form#frmMenuItem').serializeObject();
	data.moduleId = megamenuId;
	data.menuId = menuId;
	data.rowId	= rowId;
	data.groupId = groupId;	
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
                $('#modalMenuItem').modal('hide');
                loadGroupContent();	
            }
		}
	});
}
function saveSubMenuItem(){
	$("#modalSubMenuItem .modal-footer").append('<p class="ajax-loader"><i class="fa fa-spinner fa-spin"></i></p>');
	var	data 			=	$('form#frmSubMenuItem').serializeObject();
		data.moduleId 	=	megamenuId;
		data.menuId		=	menuId;
		data.rowId		=	rowId;
		data.groupId	=	groupId;
		data.parentId	=	parentMenuItemId;	
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
                $('#modalSubMenuItem').modal('hide');
                loadGroupContent();	
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
function changeLinkType_MenuItem(value){
	if(value == 'CUSTOMLINK|0'){
        $(".menu-item-link-type-product").hide();
        $(".menu-item-link-type-custom").show();
    }else if(value == 'PRODUCT|0'){
        $(".menu-item-link-type-custom").hide();
        $(".menu-item-link-type-product").show();
    }else{
        $(".menu-item-link-type-custom").hide();
        $(".menu-item-link-type-product").hide();
    }
}
function changeLinkType_SubMenuItem(value){
	if(value == 'CUSTOMLINK|0'){
        $(".submenu-item-link-type-product").hide();
        $(".submenu-item-link-type-custom").show();
    }else if(value == 'PRODUCT|0'){
        $(".submenu-item-link-type-custom").hide();
        $(".submenu-item-link-type-product").show();
    }else{
        $(".submenu-item-link-type-custom").hide();
        $(".submenu-item-link-type-product").hide();
    }
}
function changeLinkType_Menu(value){
	if(value == 'CUSTOMLINK|0'){
        $(".menu-link-type-product").hide();
        $(".menu-link-type-custom").show();
    }else if(value == 'PRODUCT|0'){
        $(".menu-link-type-custom").hide();
        $(".menu-link-type-product").show();
    }else{
        $(".menu-link-type-custom").hide();
        $(".menu-link-type-product").hide();
    }
}
function changeLinkType_SubMenu(value){
	if(value == 'CUSTOMLINK|0'){
        $(".submenu-link-type-product").hide();
        $(".submenu-link-type-custom").show();
    }else if(value == 'PRODUCT|0'){
        $(".submenu-link-type-custom").hide();
        $(".submenu-link-type-product").show();
    }else{
        $(".submenu-link-type-custom").hide();
        $(".submenu-link-type-product").hide();
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
	var oldLang = $("#moduleLanguageActive").val(); 
	$("#moduleLanguageActive").val(langId);	
	$(".module-lang").each(function() {
		$(this).val(langId);        
    });
    $(".module-lang-"+oldLang).hide();
    $(".module-lang-"+langId).show();
}
function menuChangeLanguage(langId){
	var oldLang = $("#menuLanguageActive").val(); 
	$("#menuLanguageActive").val(langId);	
	$(".menu-lang").each(function() {
		$(this).val(langId);        
    });
    $(".menu-lang-"+oldLang).hide();
    $(".menu-lang-"+langId).show();
}
function rowChangeLanguage(langId){
	var oldLang = $("#rowLanguageActive").val(); 
	$("#rowLanguageActive").val(langId);	
	$(".row-lang").each(function() {
		$(this).val(langId);        
    });
    $(".row-lang-"+oldLang).hide();
    $(".row-lang-"+langId).show();
}
function groupChangeLanguage(langId){
	var oldLang = $("#groupLanguageActive").val();	
	$("#groupLanguageActive").val(langId);	
	$(".group-lang").each(function() {
		$(this).val(langId);        
    });
    $(".group-lang-"+oldLang).hide();
    $(".group-lang-"+langId).show();
}
function menuItemChangeLanguage(langId){
	var oldLang = $("#menuItemLanguageActive").val(); 
	$("#menuItemLanguageActive").val(langId);	
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
/*
function loadMegamenuContent(){
	if(parseInt(megamenuId) >0){
		var data = {'action':'loadMegamenuContent', 'id':megamenuId, 'secure_key':secure_key}; 
        $.ajax({
    		type:'POST',
    		url: currentUrl,
    		data: data,
    		dataType:'json',
    		cache:false,
    		async: true,
    		beforeSend: function(){
    			$("#row_of_menu").hide();
    		},
    		complete: function(){},
    		success: function(response){
				$("#menuList .list-body").html(response.content);
				if(response.status == "1"){
					menuSortableSetup('', '');					
				} 
				else showErrorMessage(response.msg);				
    		}
    	});
	}
}
*/
//============================================

function loadSubmenu(){
	if(parseInt(parentMenuId) >0){
		var data = {'action':'loadSubmenu', 'megamenu_id':megamenuId, 'parent_id':parentMenuId, 'secure_key':secure_key}; 
        $.ajax({
    		type:'POST',
    		url: currentUrl,
    		data: data,
    		dataType:'json',
    		cache:false,
    		async: true,
    		beforeSend: function(){
    			menuSortableDestroy('',"#submenu-"+parentMenuId);
    			menuSortableDestroy("#submenu-"+parentMenuId,'');
    			//$("#submenu-"+parentMenuId).sortable('destroy');
    		},
    		complete: function(){},
    		success: function(response){
				if(response.status == "1"){
					$("#submenu-"+parentMenuId).html(response.content);
					menuSortableSetup('', "#submenu-"+parentMenuId);
					menuSortableSetup("#submenu-"+parentMenuId, '');
				}else 
					showErrorMessage(response.msg);				
    		}
    	});
	}
}

function loadMegamenuContent(){
	if(parseInt(megamenuId) >0){
		var data = {'action':'loadMegamenuContent', 'megamenuId':megamenuId, 'secure_key':secure_key}; 
        $.ajax({
    		type:'POST',
    		url: currentUrl,
    		data: data,
    		dataType:'json',
    		cache:false,
    		async: true,
    		beforeSend: function(){
    			if($(".row-sortable").length >0) $(".row-sortable").sortable('destroy');
    		},
    		complete: function(){},
    		success: function(response){
				$("#menu-content").html(response);
				rowSortableSetup();				
				groupSortableSetup('');
				menuItemSortableSetup('');
    		}
    	});
	}
}
function loadRowContent(){
	//megamenuId, menuId, rowId
	if(parseInt(megamenuId) >0 && parseInt(rowId) >0){
		var data = {'action':'loadRowContent', 'moduleId':megamenuId, 'rowId':rowId, 'secure_key':secure_key}; 
        $.ajax({
    		type:'POST',
    		url: currentUrl,
    		data: data,
    		dataType:'json',
    		cache:false,
    		async: true,
    		beforeSend: function(){
    			if($("#row-"+rowId+"-body .group-sortable").length >0) $("#row-"+rowId+"-body .group-sortable").sortable('destroy');
    		},
    		complete: function(){},
    		success: function(response){
				$("#row-"+rowId+"-content").html(response);
				groupSortableSetup('row-'+rowId+'-body');
                menuItemSortableSetup('');
    		}
    	});
	}
		
}
function loadGroupContent(){	
	if(parseInt(megamenuId) >0 && parseInt(rowId) >0 && parseInt(groupId) >0){
		var data = {'action':'loadGroupContent', 'moduleId':megamenuId, 'menuId':menuId, 'rowId':rowId, 'groupId':groupId, 'secure_key':secure_key}; 
        $.ajax({
    		type:'POST',
    		url: currentUrl,
    		data: data,
    		dataType:'json',
    		cache:false,
    		async: true,
    		beforeSend: function(){
    			if($("#group-"+groupId+"-body .menuitem-sortable").length >0) $("#group-"+groupId+"-body .menuitem-sortable").sortable('destroy');
    		},
    		complete: function(){},
    		success: function(response){
				$("#group-"+groupId+"-content").html(response);
				menuItemSortableSetup('group-'+groupId+'-body');
    		}
    	});
	}
}
function showGroupType(value){
	$(".group-type").hide();
	if($("#group-type-"+value).length >0)
		$("#group-type-"+value).show();
			 
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