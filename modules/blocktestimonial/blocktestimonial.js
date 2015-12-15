$(document).ready(function() {
    $("#block_testimonial_block_slide").owlCarousel({
      navigation : true, // Show next and prev buttons
      slideSpeed: 500,
      singleItem:true,
      addClassActive:true
    });
    $('#testimonials-slider').owlCarousel({
        items:1,    
        animateOut: 'zoomOutLeft',
        animateIn:  'zoomInRight',
        autoplay:true,
        nav:true,
        margin:10,
        loop:true,
        autoHeight:true
    });
});