$(document).ready(function(){
	tinySetup();
    bannerListSetup();
    newForm = $("#frmBanner").html();
    bannerUploader();
});
function bannerListSetup(){
    $("#bannerList").tableDnD({
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
                    ids[i] = tr.replace("bn_", ""); 
                }
    			var data={'action':'updateBannerOrdering', 'ids':ids, 'secure_key':secure_key};
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
function bannerUploader(){
	new AjaxUpload($('#banner'), {
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
		    var langActive = $("#langActive").val();			
			$('#image-'+langActive).val(response.fileName);

			if (response.status == '1'){
               showSuccessMessage(response.msg);
	        }else{
	            showErrorMessage(response.msg);
	        }
	        
		}
	});		
}
jQuery(function($){
    $(document).on('click','.lik-banner-status',function(){        
            var itemId = $(this).attr('item-id');
            var value = $(this).attr('value');        
            if(value == '1'){
            	$(this).attr('value', '0').removeClass('action-enabled').addClass('action-disabled');
            }else{
            	$(this).attr('value', '1').removeClass('action-disabled').addClass('action-enabled');
            }
    		var data={'action':'changeBannerStatus', 'itemId':itemId, 'value':value, 'secure_key':secure_key};
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
    $(document).on('click','.lik-banner-edit',function(){
    	var itemId = $(this).attr('item-id');  
        var data={'action':'getBannerItem', 'itemId':itemId, 'secure_key':secure_key};
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
						$("#frmBanner").html(response.form);
						bannerUploader();						
                        showModal('modalBanner', '');
						tinySetup();
						                	
                    }else{
                        showSuccessMessage(response.msg);
                    }
                }
    		}
    	}); 	
	});
	
    // delete item
    $(document).on('click','.lik-banner-delete',function(){
        if(confirm("Are you sure you want to delete item?") == true){
           var itemId = $(this).attr('item-id');        
    		var data={'action':'deleteBanner', 'itemId':itemId, 'secure_key':secure_key};
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
    
    $('#modalBanner').on('hidden.bs.modal', function (e) { 
        $("p.ajax-loader").remove();
        tinyRemove();
        $("#frmBanner").html(newForm);
        bannerUploader();
        tinySetup();  
    });  	
});
function tinyRemove(elParent){	
	var i, t = tinyMCE.editors;
	for (i in t){
	    if (t.hasOwnProperty(i)){
	        t[i].remove();
	    }
	}	 
}
function showModal(el){
	$("#"+el).modal('show');
}
// Save group
function saveBanner(){    
	tinymce.triggerSave();
    $("#modalBanner .modal-footer").append('<p class="ajax-loader"><i class="fa fa-spinner fa-spin"></i></p>');    
    var data = $('form#frmBanner').serializeObject();    
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
            showSuccessMessage(response.msg);
            if(response.status == '1'){
            	window.location.reload();
            }
		}		
	});
}


function changeLanguage(langId){
	var oldLang = $("#langActive").val(); 
	$("#langActive").val(langId);	
	$(".lang").each(function() {
		$(this).val(langId);        
    });
    $(".lang-"+oldLang).hide();
    $(".lang-"+langId).show();
    
}
