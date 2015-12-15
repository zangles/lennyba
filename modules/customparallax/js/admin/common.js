function showModal(newModal){   
	$("#"+newModal).modal('show');
}
function handleEnterNumber(event){
	var keyCode = event.keyCode ? event.keyCode : event.charCode;	
	if((keyCode < 48 || keyCode > 58) && keyCode != 8 && keyCode != 13 && keyCode != 9 && keyCode != 35 && keyCode != 36 && keyCode != 99 && keyCode != 118 && keyCode != 46 && keyCode != 37 && keyCode != 39 && keyCode != 45){
		return false;
	}		
}
$(document).ready(function(){
    moduleConfig = $("#module-config").html(); 
    parallaxConfig = $("#parallax-config").html();         
    moduleListSetup();
    tinySetup();
    backgroundUploader();
});
jQuery(function($){    
	
	$(".tab-groups a").click(function(e){
        $(".tab-groups").find('a').removeClass('active');
        $(this).addClass('active');
    	e.preventDefault();
    	$(this).tab('show');
    });    
	$('#modalModule').on('hidden.bs.modal', function (e) {
		tinyRemove();
		moduleConfig = $("#module-config").html(moduleConfig); 
    	parallaxConfig = $("#parallax-config").html(parallaxConfig); 
        $("p.ajax-loader").remove();
        tinySetup();
        backgroundUploader();
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
    		beforeSend: function(){
    			tinyRemove();
    		},
    		complete: function(){},
    		success: function(response){                    
                if(response != null){
                    if(response.status == "1"){
                    	$("#module-config").html(response.config);
                    	$("#parallax-config").html(response.parallax);                    	
                    	showModal('modalModule', '');
                    	tinySetup();                    	
                    	backgroundUploader();
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
});
function backgroundUploader(){
	if($("#image-uploader").length >0){
		new AjaxUpload($('#image-uploader'), {
			action: baseModuleUrl+"/uploader.php",
			name: 'uploader',
	        data:{'maxFileSize':'5','uploadType':'image', 'secure_key':secure_key},
	        responseType: 'json',
			onChange: function(file, ext){},
			onSubmit: function(file, ext){					
				 if (!(ext && /^(jpg|png|jpeg|gif)$/.test(ext))){
				 	alert('You just upload files (jpg, png,jpeg,gif)');
					return false;
				}
			},
			onComplete: function(file, response){
				
				$('#parallax_image').val(response.fileName);			
				if (response.status == '0')
	               showErrorMessage(response.msg);		        
			}
		});	
	}else{
		showErrorMessage(uploadfile_not_setup);
	}		
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
		beforeSend: function(){},
		complete: function(){},
		success: function(response){
			$("p.ajax-loader").remove();
            showSuccessMessage(response.msg);
            if(response.status == '1') window.location.reload();
		}
	});
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
function showDataType(value){
	$(".data-type").hide();
	$("#type-"+value).show();
}
function loadModuleHooks(moduleName){
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
			$("#module_hook").html(response);			
		}		
	});
}