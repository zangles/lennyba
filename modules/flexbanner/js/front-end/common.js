$(document).ready(function(){
	
    $(".home-banner").hover(
        function() {  
            $(this).find('.description-box-1').hide();
            //$(this).find('.txt-2').hide();
            //$(this).find('.txt-3').hide();                            
            $(this).find(".description-box-2").addClass('animated zoomIn');
            setTimeout(function(){
                $(".description-box-1").show().addClass('animated bounceInDown');
            }, 500);
        }, function() {
            $(this).find('.description-box-2').removeClass('animated zoomIn');
            $(this).find('.description-box-1').removeClass('animated bounceInDown');            
        }
    );    
});
