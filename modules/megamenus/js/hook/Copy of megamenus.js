var flexmegamenus_windowWidth = $(window).width();
$(document).ready(function(){ 
    flexMegamenusSetup();
           
});
$(window).resize(function() {
	
	if($(window).width() != flexmegamenus_windowWidth){
		$(".flexmegamenus-menu-contents").removeAttr('style');
		flexmegamenus_windowWidth = $(window).width();
		flexMegamenusSetup();
	}    
});
$(window).bind('load', function(){
	//verticalMegamenusSetup();
});
jQuery(function($){
	$(document).on('click','.vertical-parent',function(){
		if($(this).parent().hasClass('active') == true){			
			$(this).parent().removeClass('active');			
		}else{
			$(".megamenus-ul >li.parent").removeClass('active');
			$(this).parent().addClass('active');	
		}		
		        
	});
});
function removeLink(){
	$(".megamenus-ul >li.parent").removeClass('active');
	if(verticleWindowWidth <1199){
		$("a.vertical-parent").attr('href', 'javascript:void(0)');	
	}else{
		$("a.vertical-parent").each(function(index) {
			$(this).attr('href', $(this).attr('data-link'));
		});
	}	
}
function flexMegamenusSetup(){
	// vertical setup
    if($(".box-flexmegamenus-vertical-left").length >0){
        $(".box-flexmegamenus-vertical-left").each(function(){		
            var mainWidth = $(this).parent().parent().actual('width');			
			if(flexmegamenus_windowWidth >= 768){
				$(this).find('div.parent').each(function(){			
	                $(this).removeAttr('data-toggle');                
	            });
	            $(this).find('li.open').removeClass('open');
				var parentWidth = $(this).parent().actual('width');
				var verticalLeft_Width = parseInt(mainWidth - parentWidth - 30);
			}else{
				var verticalLeft_Width = parentWidth;
				$(this).find('div.parent').each(function(){			
	                $(this).attr({'data-toggle':'dropdown'});                
	            });
			}			
            //if(verticalLeft_Width < 100) verticalLeft_Width = parentWidth;			
            $(this).find('.flexmegamenus-menu-contents').each(function(){				
                $(this).css({'width': verticalLeft_Width});                
            });
        });
    }
    // horizontal setup 
    if($(".box-flexmegamenus-horizontal-top").length >0){
    	$(".box-flexmegamenus-horizontal-top").each(function(index) {
    		var mainWidth = $(this).width();
    		if(flexmegamenus_windowWidth >= 768){
				$(this).find('a.parent').each(function(){			
	                $(this).removeAttr('data-toggle');                
	            });
	            $(this).find('li.open').removeClass('open');				
			}else{
				$(this).find('a.parent').each(function(){			
	                $(this).attr({'data-toggle':'dropdown'});                
	            });
			}    		
    		$(this).find('.dropdown-menu').each(function(index) {
    			var parent = $(this).parent();
    			var parentWidth = parseInt(parent.width());    			
    			var parentLeft = parseInt($(this).parent().position().left);
				var theWidth = parseInt($(this).width());
								
				if(theWidth <= (parentLeft + parentWidth)){
					var left = parentLeft + (parentWidth/2) - (theWidth/2);	
									
					if((left + theWidth) >= mainWidth){
						$(this).css({"right": 0, 'left':'auto', 'width':mainWidth});
					}else{
						$(this).css({"left": left, 'width':mainWidth});	
					}
					
				}
	            
				//alert(theParentLeft);
			});
			//var mainWidth = $(this).actual('width');
			//$(this).find('.flexmegamenus-menu-contents').css({'width':mainWidth});
			
		});
    }
      
}
