/*
* 2007-2014 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2014 PrestaShop SA
*  @version  Release: $Revision$
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

$(document).ready(function(){

	if (typeof(homeslider_speed) == 'undefined')
		homeslider_speed = 500;
	if (typeof(homeslider_pause) == 'undefined')
		homeslider_pause = 3000;
	if (typeof(homeslider_loop) == 'undefined')
		homeslider_loop = true;
	if (typeof(homeslider_width) == 'undefined')
		homeslider_width = 779;


	$('.homeslider-description').click(function () {
		window.location.href = $(this).prev('a').prop('href');
	});

	//if ($('#htmlcontent_top').length > 0)
		//$('#homepage-slider').addClass('col-xs-8');
	//else
		//$('#homepage-slider').addClass('col-xs-12');
		
    var animated = new Array('animated fadeInDown', 'animated slideInLeft', 'animated zoomIn', 'animated fadeInUp', 'animated fadeInDown');
	if (!!$.prototype.bxSlider)
		$('#homeslider').bxSlider({
			useCSS: false,
			maxSlides: 1,
            mode: 'fade',
            responsive:true,
			//slideWidth: homeslider_width,
			infiniteLoop: homeslider_loop,
			hideControlOnEnd: true,
			pager: false,
			autoHover: true,
			auto: homeslider_loop,
			speed: parseInt(homeslider_speed),
			pause: homeslider_pause,
			controls: true,
            onSliderLoad:function(){
                //$('.custom-animated').hide("slow");
                $(".custom-animated").each(function(index){
                    var el = this;
                    setTimeout(function(){
                        $(el).show().addClass(animated[index]);
                    }, (index * 500));
                    
                });
                  
            },
            onSlideBefore:function(slideElement, oldIndex, newIndex){
                $('.custom-animated').removeClass('animated bounceInDown');
                slideElement.find('.custom-animated').hide("slow");                
            },
            onSlideAfter: function(slideElement, oldIndex, newIndex){                
                slideElement.find('.custom-animated').hide("slow");
                slideElement.find(".custom-animated").each(function(index){
                    var el = this;
                   setTimeout(function(){
                        $(el).show().addClass(animated[index]);
                    }, (index * 500));
                });                               
            }
		});
});