jQuery(document).ready(function($){
	if($("#index #vslider_body").length >0){
		$("html").addClass("fsvs");
	    var slider = $.fn.fsvs({
	        speed               : 1000,
	        bodyID              : 'vslider_body',
	        selector            : '> .slide',
	        mouseSwipeDisance   : 40,
	        afterSlide          : function(){},
	        beforeSlide         : function(){},
	        endSlide            : function(){},
	        mouseWheelEvents    : true,
	        mouseWheelDelay     : false,
	        mouseDragEvents     : true,
	        touchEvents         : true,
	        arrowKeyEvents      : true,
	        pagination          : true,
	        nthClasses          : 2,
	        detectHash          : true
	    });	
	}    
});