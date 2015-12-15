$(document).ready(function(){
	tinySetup();
    listOrderSetup('moduleList', 'mod_', 'updateModuleOrdering');    
    newModuleForm = $("#frmModule").html();
    newSlideFrom = $("#frmSlide").html();
    slideUploader();
});

function listOrderSetup(el, prefix, action){
    $("#"+el).tableDnD({
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
                    ids[i] = tr.replace(prefix, "");
                    $("."+prefix+"position_"+ids[i]).html((1+i)); 
                }
    			var data={'action':action, 'ids':ids, 'secure_key':secure_key};
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
            			showSuccessMessage(response.msg);										
            		}		
            	});
            }              		         
		}        
	});
}

function slideUploader(){
	new AjaxUpload($('#slide-uploader'), {
		action: baseModuleUrl+"/uploader.php",
		name: 'uploader',
        data:{'maxFileSize':'3','uploadType':'image', 'secure_key':secure_key},
        responseType: 'json',
		onChange: function(file, ext){},
		onSubmit: function(file, ext){					
			 if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){
			 	alert('You just upload files (jpg, png, jpeg, gif)');
				return false;
			}
		},
		onComplete: function(file, response){	
		    var langActive = $("#slideLangActive").val();			
			$('#slide-'+langActive).val(response.fileName);
			if (response.status == '1'){
               showSuccessMessage(response.msg);
	        }else{
	            showErrorMessage(response.msg);
	        }
	        
		}
	});		
}
jQuery(function($){
	$(document).on('click','.lik-module-status',function(){        
        var itemId = $(this).attr('item-id');
        var value = $(this).attr('value');        
        if(value == '1'){
        	$(this).attr('value', '0').removeClass('action-enabled').addClass('action-disabled');
        }else{
        	$(this).attr('value', '1').removeClass('action-disabled').addClass('action-enabled');
        }
		var data={'action':'changeModuleStatus', 'itemId':itemId, 'value':value, 'secure_key':secure_key};
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
    		beforeSend: function(){
    			
    		},
    		complete: function(){},
    		success: function(response){
    			           
                if(response != null){
                    if(response.status == "1"){
                    	tinyRemove();                    	
						$("#frmModule").html(response.form);					
                        showModal('modalModule');
                        tinySetup();
                    }else{
                        showSuccessMessage(response.msg);
                    }
                }
    		}
    	}); 	
	});
	
	$(document).on('click','.lik-module-delete',function(){
        if(confirm("Are you sure you want to delete item?") == true){
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
                    showSuccessMessage(response.msg);
                    window.location.reload();           								
        		}		
        	}); 
        }
	});
	
	$(document).on('click','.lik-module',function(){
        if(moduleId != '0') $("#mod_"+moduleId).removeClass('tr-selected');
        moduleId = $(this).attr('data-id');
        $("#mod_"+moduleId).addClass('tr-selected');
        $("#span-module-name").html('['+($(this).html())+']');
        $("#slide-panel").show();
        loadModuleContent();
        
	});
	
	
    $(document).on('click','.lik-slide-status',function(){        
            var itemId = $(this).attr('data-id');
            var value = $(this).attr('data-value');        
            if(value == '1'){
            	$(this).attr('data-value', '0').removeClass('action-enabled').addClass('action-disabled');
            }else{
            	$(this).attr('data-value', '1').removeClass('action-disabled').addClass('action-enabled');
            }
    		var data={'action':'changeSlideStatus', 'itemId':itemId, 'value':value, 'secure_key':secure_key};
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
    $(document).on('click','.lik-slide-edit',function(){
    	var itemId = $(this).attr('data-id');  
        var data={'action':'getSlideItem', 'itemId':itemId, 'secure_key':secure_key};
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
						$("#frmSlide").html(response.form);
						slideUploader();				
                        showModal('modalSlide');
						tinySetup();
                    }else{
                        showSuccessMessage(response.msg);
                    }
                }
    		}
    	}); 	
	});	
    // delete item
    $(document).on('click','.lik-slide-delete',function(){
        if(confirm("Are you sure you want to delete item?") == true){
           var itemId = $(this).attr('data-id');        
    		var data={'action':'deleteSlide', 'itemId':itemId, 'secure_key':secure_key};
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
        			if(response.status == '1'){
        				showSuccessMessage(response.msg);
        				loadModuleContent();	
        			}else{
        				showErrorMessage(response.msg);
        			}             								
        		}		
        	}); 
        }
	});
    $('#modalModule').on('hidden.bs.modal', function (e) { 
        $("p.ajax-loader").remove();
        tinyRemove();
        $("#frmModule").html(newModuleForm); 
        tinySetup();
    });
    
    $('#modalSlide').on('hidden.bs.modal', function (e) { 
        $("p.ajax-loader").remove();
        tinyRemove();
        $("#frmSlide").html(newSlideFrom);
        slideUploader();
        tinySetup();  
    });  	
});

function showModal(el){
	$("#"+el).modal('show');
}
function saveModule(){     
	tinymce.triggerSave();   
	$("#modalModule .modal-footer").append('<p class="ajax-loader"><i class="fa fa-spinner fa-spin"></i></p>');
    var data = $('form#frmModule').serializeObject();  
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
		  $("p.ajax-loader").remove();            
            if(response.status == '1'){
            	window.location.reload();
            }else{
            	showErrorMessage(response.msg);	
            }
		}		
	});
}
function loadModuleContent(){
	if(parseInt(moduleId) >0){
		var data={'action':'loadModuleContent', 'moduleId':moduleId, 'secure_key':secure_key};
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
                $("#slideList > tbody").html(response);
                listOrderSetup('slideList', 'sl_', 'updateSlideOrdering');          								
    		}		
    	}); 
	}
}
// Save group
function saveSlide(){    
	if(parseInt(moduleId) >0){
		tinymce.triggerSave();
	    //$("#modalSlide .modal-footer").append('<p class="ajax-loader"><i class="fa fa-spinner fa-spin"></i></p>');    
	    var data = $('form#frmSlide').serializeObject();
	    data.moduleId = moduleId;
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
				$("p.ajax-loader").remove();	            
	            if(response.status == '1'){
	            	showSuccessMessage(response.msg);
	            	$('#modalSlide').modal('hide');
	            	loadModuleContent();
	            }else{
	            	showErrorMessage(response.msg);
	            }
			}		
		});
	}
	
}

function changeModuleLanguage(langId){
	var oldLang = $("#langModuleActive").val(); 
	$("#langModuleActive").val(langId);	
	$(".module-lang").each(function() {
		$(this).val(langId);        
    });
    $(".module-lang-"+oldLang).hide();
    $(".module-lang-"+langId).show();
    
}
function changeSlideLanguage(langId){	
	var oldLang = $("#slideLangActive").val(); 
	$("#slideLangActive").val(langId);	
	$(".slide-lang").each(function() {
		$(this).val(langId);        
    });
    $(".slide-lang-"+oldLang).hide();
    $(".slide-lang-"+langId).show();
    
}
