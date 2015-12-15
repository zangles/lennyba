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

    moduleFormNew = $("#frmModule").html();

    rowFormNew = $("#frmRow").html();

    groupFormNew = $("#frmGroup").html();

    bannerFormNew = $("#frmBanner").html();     

    tinySetup();

    moduleListSetup();

	bannerUploader();

	

});

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

		    var langActive = $("#bannerLangActive").val();			

			$('#bannerImage-'+langActive).val(response.fileName);

			if (response.status == '1'){

               showSuccessMessage(response.msg);

	        }else{

	            showErrorMessage(response.msg);

	        }

	        

		}

	});		

}



jQuery(function($){    

	$('#modalModule').on('hidden.bs.modal', function (e) {

        $("#frmModule").html(moduleFormNew);

        $("p.ajax-loader").remove();

    });

    $('#modalRow').on('hidden.bs.modal', function (e) {

        $("#frmRow").html(rowFormNew);

        $("p.ajax-loader").remove();

    });

    $('#modalGroup').on('hidden.bs.modal', function (e) {

        $("#frmGroup").html(groupFormNew);

        $("p.ajax-loader").remove();             

    });

        

    $('#modalMenuItem').on('hidden.bs.modal', function (e) {

    	$("p.ajax-loader").remove();

		tinyRemove();

		$("#frmBanner").html(bannerFormNew);

        bannerUploader();

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

                    	showModal('modalModule', '');                    	

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

        $("#header-module-name").html('['+$(this).html()+']');

        loadModuleContent();

        $("#row_of_module").show();        

	});  

    $(document).on('click','.lik-row-status',function(){        

            var itemId = $(this).attr('data-id');

            var value = $(this).attr('data-value');        

            if(value == '1'){

            	$(this).attr('data-value', '0').removeClass('status-1').addClass('status-0').html('<i class="icon-square-o"></i> Disable');

            }else{

            	$(this).attr('data-value', '1').removeClass('status-0').addClass('status-1').html('<i class="icon-check-square-o"></i> Enable');

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

    $(document).on('click','.lik-row-edit',function(){

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

                    	showModal('modalRow', '');                    	

                    }else{

                        showSuccessMessage(response.msg);

                    }

                }

    		}

    	});         

	});

	$(document).on('click','.lik-row-delete',function(){

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

                        loadModuleContent();

                    }                											

        		}

        	});    

        }		

	}); 

	$(document).on('click', '.lik-row-addgroup', function(){

		rowId = $(this).attr('data-id');

		showModal('modalGroup');

	});

	$(document).on('click', '.lik-group-status', function(){

		var itemId = $(this).attr('data-id');

        var value = $(this).attr('data-value');        

        if(value == '1'){

        	$(this).attr('data-value', '0').removeClass('status-1').addClass('status-0').html('<i class="icon-square-o"></i> Disable');

        }else{

        	$(this).attr('data-value', '1').removeClass('status-0').addClass('status-1').html('<i class="icon-check-square-o"></i> Enable');

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

    $(document).on('click', '.lik-group-edit', function(){

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

                    	$("#frmGroup").html(response.form);

                    	showModal('modalGroup', '');

                    }else{

                        showErrorMessage(response.msg);

                    }

                }

    		}

    	}); 

    });

    $(document).on('click', '.lik-group-delete', function (){

    	if(confirm("Are you sure you want to delete group item?") == true){

            var itemId = $(this).attr('data-id');

            moduleId = $(this).attr('data-module');

            rowId = $(this).attr('data-row');

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

    $(document).on('click', '.lik-group-additem', function(){

		groupId = $(this).attr('data-id');

		rowId = $(this).attr('data-row');

		moduleId = $(this).attr('data-module');

		showModal('modalMenuItem');

	});

    $(document).on('click', '.lik-menu-item-status', function(){

		var itemId = $(this).attr('data-id');

        var value = $(this).attr('data-value');        

        if(value == '1'){

        	$(this).attr('data-value', '0').removeClass('status-1').addClass('status-0').html('<i class="icon-square-o"></i> Disable');

        }else{

        	$(this).attr('data-value', '1').removeClass('status-0').addClass('status-1').html('<i class="icon-check-square-o"></i> Enable');

        }

		var data={'action':'changBannerStatus', 'itemId':itemId, 'value':value, 'secure_key':secure_key};

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

	$(document).on('click', '.lik-menu-item-delete', function (){

    	if(confirm("Are you sure you want to delete menu item?") == true){

            var itemId = $(this).attr('data-id');

            moduleId = $(this).attr('data-module');

            rowId = $(this).attr('data-row');

            groupId = $(this).attr('data-group');            

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

                    if(response){                        

                        showSuccessMessage(response.msg);

                        loadGroupContent();

                    }                											

        		}

        	});    

        }	

    });

    $(document).on('click', '.lik-menu-item-edit', function(){

    	var itemId = $(this).attr('data-id');

    	moduleId = $(this).attr('data-module');

    	rowId = $(this).attr('data-row');

    	groupId = $(this).attr('data-group');

        var data={'action':'getBannerItem', 'itemId':itemId, 'moduleId':moduleId, 'rowId':rowId, 'groupId':groupId, 'secure_key':secure_key};

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

                        showModal('modalMenuItem', '');

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

				var data={'action':'updateRowOrdering', 'ids':ids};

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

function groupSortableSetup(parentEl){

	if(parentEl == ""){

		$(".group-sortable" ).sortable({

	        update: function (e, ui) {

	            var thisRow = $(this).attr('data-row');

	            var thisModule = $(this).attr('data-module');

				var ids = new Array;			

				if($(".row-"+thisRow).length >1){

					$(".row-"+thisRow).each(function(index) {

						ids[index] = $(this).attr('data-id');					

					});

					var data={'action':'updateGroupOrdering', 'moduleId':thisModule, 'rowId':thisRow, 'ids':ids};

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

	}else{

		$("#"+parentEl+" .group-sortable" ).sortable({

	        update: function (e, ui) {

	            var thisRow = $(this).attr('data-row');

	            var thisModule = $(this).attr('data-module');

				var ids = new Array;			

				if($(".row-"+thisRow).length >1){

					$(".row-"+thisRow).each(function(index) {

						ids[index] = $(this).attr('data-id');					

					});

					var data={'action':'updateGroupOrdering', 'moduleId':thisModule, 'rowId':thisRow, 'ids':ids};

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

}

function menuItemSortableSetup(parentEl){

	if(parentEl == ""){

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

					var data={'action':'updateBannerOrdering', 'moduleId':moduleId, 'rowId':rowId, 'groupId':groupId, 'ids':ids};

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

	        	rowId = $(this).attr('data-row');

	        	groupId = $(this).attr('data-group');

				var ids = new Array;			

				if($(".group-"+groupId).length >1){

					$(".group-"+groupId).each(function(index) {

						ids[index] = $(this).attr('data-id');					

					});

					var data={'action':'updateBannerOrdering', 'moduleId':moduleId, 'rowId':rowId, 'groupId':groupId, 'ids':ids};

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

function saveModule(){

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

function saveRow(){

	$("#modalRow .modal-footer").append('<p class="ajax-loader"><i class="fa fa-spinner fa-spin"></i></p>');

	var data = $('form#frmRow').serializeObject();

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

			$('#modalRow').modal('hide');

            showSuccessMessage(response.msg);

            loadModuleContent();

		}

	});

}

function saveGroup(){

	$("#modalGroup .modal-footer").append('<p class="ajax-loader"><i class="fa fa-spinner fa-spin"></i></p>');

	var data = $('form#frmGroup').serializeObject();

	data.moduleId = moduleId;

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

                loadRowContent(moduleId, rowId);	

            }										

		}

	}); 

}

function saveBanner(){

	$("#modalMenuItem .modal-footer").append('<p class="ajax-loader"><i class="fa fa-spinner fa-spin"></i></p>');

	tinymce.triggerSave();

	var data = $('form#frmBanner').serializeObject();

	data.moduleId = moduleId;

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

	if(value == 'CUSTOMLINK-0'){

        $(".menu-item-link-type-product").hide();

        $(".menu-item-link-type-custom").show();

    }else if(value == 'PRODUCT-0'){

        $(".menu-item-link-type-custom").hide();

        $(".menu-item-link-type-product").show();

    }else{

        $(".menu-item-link-type-custom").hide();

        $(".menu-item-link-type-product").hide();

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

function bannerChangeLanguage(langId){

	var oldLang = $("#bannerLangActive").val(); 

	$("#bannerLangActive").val(langId);	

	$(".banner-lang").each(function() {

		$(this).val(langId);        

    });

    $(".banner-lang-"+oldLang).hide();

    $(".banner-lang-"+langId).show();

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

    			if($(".row-sortable").length >0) $(".row-sortable").sortable('destroy');

    		},

    		complete: function(){},

    		success: function(response){

				$("#module-content").html(response);

				rowSortableSetup();				

				groupSortableSetup('');

				menuItemSortableSetup('');

    		}

    	});

	}

}

function loadRowContent(thisModule, thisRow){

	if(parseInt(thisModule) >0 && parseInt(thisRow) >0){

		var data = {'action':'loadRowContent', 'moduleId':thisModule, 'rowId':thisRow, 'secure_key':secure_key}; 

        $.ajax({

    		type:'POST',

    		url: currentUrl,

    		data: data,

    		dataType:'json',

    		cache:false,

    		async: true,

    		beforeSend: function(){

    			if($("#row-"+thisRow+"-body .group-sortable").length >0) $("#row-"+thisRow+"-body .group-sortable").sortable('destroy');

    		},

    		complete: function(){},

    		success: function(response){

				$("#row-"+thisRow+"-content").html(response);

				groupSortableSetup('row-'+thisRow+'-body');

    		}

    	});

	}else{

		if(parseInt(moduleId) >0 && parseInt(rowId) >0){

			var data = {'action':'loadRowContent', 'moduleId':moduleId, 'rowId':rowId, 'secure_key':secure_key}; 

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

	    		}

	    	});

		}

	}	

}

function loadGroupContent(){

		

	if(parseInt(moduleId) >0 && parseInt(rowId) >0 && parseInt(groupId) >0){

		var data = {'action':'loadGroupContent', 'moduleId':moduleId, 'rowId':rowId, 'groupId':groupId, 'secure_key':secure_key}; 

        $.ajax({

    		type:'POST',

    		url: currentUrl,

    		data: data,

    		dataType:'json',

    		cache:false,

    		async: true,

    		beforeSend: function(){

    			//if($("#group-"+groupId+"-body .menuitem-sortable").length >0) 

    			//	$("#group-"+groupId+"-body .menuitem-sortable").sortable('destroy');

    			//if($("#group-"+groupId+"-body .menuitem-sortable").length >0) 

    			//$("#group-"+groupId+"-body .menuitem-sortable").sortable('destroy');

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