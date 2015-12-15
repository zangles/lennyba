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
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/
//global variables
var responsiveflag = false;
var FancyboxI18nClose = 'Close';
$(document).ready(function(){
	/*
	sw_section_width();
    sw_section_full();
    sw_section_full_footer();    	
	*/
	if($("#ps-breadcrumb").length >0){		
		$(".navigation_page").find('span').remove();
		var breadcrumb = '';
		$("#ps-breadcrumb").find('a').each(function(index) {
			breadcrumb += '<li><a href="'+($(this).attr('href'))+'" title="'+($(this).text())+'">'+($(this).text())+'</a></li>';
			$(this).remove();
		});
		$("#ps-breadcrumb").find('.navigation-pipe').remove();
		if($("#ps-breadcrumb").data('show-active') == '1'){
			breadcrumb += '<li class="active">'+($("#ps-breadcrumb").text())+'</li>';
		}		
		$("ul.breadcrumb").html(breadcrumb);
		
	}
	
    //$('#index #granada-home-page-tabs li:first, #index .tab-content ul:first').addClass('active');
    $(".mCustomScrollbar").mCustomScrollbar();
	/*
	
		var scroll_timer;
		var displayed = false;
		var $message = $('.back-to-top');
		$(window).scroll(function() {
			window.clearTimeout(scroll_timer);
			scroll_timer = window.setTimeout(function() {
				if (jQuery(window).scrollTop() <= 100) {
					displayed = false;
					$message.removeClass('btt-shown');
				} else if (displayed == false) {
					displayed = true;
					$message.stop(true, true).addClass('btt-shown').click(function() {
						$message.removeClass('btt-shown');
					});
				}
			}, 200);
			scrollOnTOp();
		});
		$('.back-to-top').click(function(e) {
			$('html, body').animate({
				scrollTop: 0
			}, 200);
			return false;
		});
		*/
	
	//highdpiInit();
	// responsiveResize();
	// $(window).resize(responsiveResize);
    // responsiveMobileHeader();
    // $(window).resize(responsiveMobileHeader);
    //crumbProcess();
    // cateSliderProcess();
	if (navigator.userAgent.match(/Android/i))
	{
		var viewport = document.querySelector('meta[name="viewport"]');
		viewport.setAttribute('content', 'initial-scale=1.0,maximum-scale=1.0,user-scalable=0,width=device-width,height=device-height');
		window.scrollTo(0, 1);
	}
	//blockHover();
	if (typeof quickView !== 'undefined' && quickView)
		quick_view();
	//dropDown();
	if (typeof page_name != 'undefined' && !in_array(page_name, ['index', 'product']))
	{
		bindGrid();
 		$(document).on('change', '.selectProductSort', function(e){
			if (typeof request != 'undefined' && request)
				var requestSortProducts = request;
 			var splitData = $(this).val().split(':');
			if (typeof requestSortProducts != 'undefined' && requestSortProducts)
				document.location.href = requestSortProducts + ((requestSortProducts.indexOf('?') < 0) ? '?' : '&') + 'orderby=' + splitData[0] + '&orderway=' + splitData[1];
    	});
		$(document).on('change', 'select[name="n"]', function(){
			$(this.form).submit();
		});
		$(document).on('change', 'select[name="manufacturer_list"], select[name="supplier_list"]', function() {
			if (this.value != '')
				location.href = this.value;
		});
		$(document).on('change', 'select[name="currency_payement"]', function(){
			setCurrency($(this).val());
		});
	}
	$(document).on('click', '.back', function(e){
		e.preventDefault();
		history.back();
	});
	$(document).on('click', '#call_search_block', function(e){
		$("#searchbox").toggle( "slide" );
	});
	$(document).on('click', '.back', function(e){
		e.preventDefault();
		history.back();
	});
    $(document).on('click', '.addToWishlist', function(e){
    	var wl3 = false;
    	if($(this).data('wl3') == "1") wl3 = true;    	 
		WishlistCart($(this).data('wl0'), $(this).data('wl1'), $(this).data('wl2'), wl3, $(this).data('wl4'));
	});
	//alert("bbbbbbbbbbbbbbbbbbb");
    //alert(FancyboxI18nClose);
    //closeBtn : '<a title="' + FancyboxI18nClose + '" class="fancybox-item fancybox-close" href="javascript:;"></a>',
	//next     : '<a title="' + FancyboxI18nNext + '" class="fancybox-nav fancybox-next" href="javascript:;"><span></span></a>',
	//prev     : '<a title="' + FancyboxI18nPrev + '" class="fancybox-nav fancybox-prev" href="javascript:;"><span></span></a>'
			
	jQuery.curCSS = jQuery.css;
	if (!!$.prototype.cluetip)
		$('a.cluetip').cluetip({
			local:true,
			cursor: 'pointer',
			dropShadow: false,
			dropShadowSteps: 0,
			showTitle: false,
			tracking: true,
			sticky: false,
			mouseOutClose: true,
			fx: {
		    	open:       'fadeIn',
		    	openSpeed:  'fast'
			}
		}).css('opacity', 0.8);
	if (!!$.prototype.fancybox)
		$.extend($.fancybox.defaults.tpl, {
			closeBtn : '<a title="Close" class="fancybox-item fancybox-close" href="javascript:;"></a>',
			next     : '<a title="Next" class="fancybox-nav fancybox-next" href="javascript:;"><span></span></a>',
			prev     : '<a title="Preview" class="fancybox-nav fancybox-prev" href="javascript:;"><span></span></a>'
		});
    /*************************************/
    /*         my account toggle         */
    /*************************************/
    /*
    myAccountClick = $(".header-toggle-call");
        myAccountClick.on('click',function(){
            var myAccountSlide = $(this).next('.header-toggle');
             if (myAccountSlide.is(':visible'))
                myAccountSlide.stop(true, true).slideUp(450);
             else{
                myAccountSlide.stop(true, true).slideDown(450)
             }
             $(myAccountClick).not(this).next('.header-toggle').slideUp();
             return false;
        });
        $(document).on('click',function(e){
            if (e.target.className.split(" ")[0] != 'header-toggle-call' && e.target.className != 'header-toggle'){
                $('.header-toggle').stop(true, true).slideUp(450);
            }
        });*/
    
/*
    
    $('.scroll_top').click(function(){
      $("html, body").animate({ scrollTop: 0 }, 600);
       return false;
     });
     $(window).scroll(function(){
          if ($(this).scrollTop() > 500) {
           $('.scroll_top').fadeIn();
          } else {
           $('.scroll_top').fadeOut();
          }
     });    */

     /*************** GranadaTheme JS *******************/
     /* Module: blockuserinfo */
    /*
    
        $('.top-bar-account > a').click(function(event){
            event.preventDefault();
        });
        $('.top-bar-account').hover(function(){
            $(this).addClass('open');
        },
        function(){
            $(this).removeClass('open');
        });
        */
    
});
function usingAnimate(el, animate){
}
function crumbProcess() {
    if ($('#responsive_slides').length) {
        $('.breadcrumb').appendTo('#responsive_slides');
    }
}
function cateSliderProcess() {
    if ($('#responsive_slides').length) {
        $('#top-category').removeClass('no_slider');
    }else {
        $('#top-category').addClass('no_slider');
    }
}
function highdpiInit()
{
	if($('.replace-2x').css('font-size') == "1px")
	{
		var els = $("img.replace-2x").get();
		for(var i = 0; i < els.length; i++)
		{
			src = els[i].src;
			extension = src.substr( (src.lastIndexOf('.') +1) );
			src = src.replace("." + extension, "2x." + extension);
			var img = new Image();
			img.src = src;
			img.height != 0 ? els[i].src = src : els[i].src = els[i].src;
		}
	}
}
// Used to compensante Chrome/Safari bug (they don't care about scroll bar for width)
function scrollCompensate()
{
    var inner = document.createElement('p');
    inner.style.width = "100%";
    inner.style.height = "200px";
    var outer = document.createElement('div');
    outer.style.position = "absolute";
    outer.style.top = "0px";
    outer.style.left = "0px";
    outer.style.visibility = "hidden";
    outer.style.width = "200px";
    outer.style.height = "150px";
    outer.style.overflow = "hidden";
    outer.appendChild(inner);
    document.body.appendChild(outer);
    var w1 = inner.offsetWidth;
    outer.style.overflow = 'scroll';
    var w2 = inner.offsetWidth;
    if (w1 == w2) w2 = outer.clientWidth;
    document.body.removeChild(outer);
    return (w1 - w2);
}
/*
function responsiveResize()
{
	compensante = scrollCompensate();
	if (($(window).width()+scrollCompensate()) <= 991 && responsiveflag == false)
	{
		//accordion('enable');
	   // accordionFooter('enable');
        //milanAccordion('enable');
		responsiveflag = true;
        //mobileHeader('enable');
        $('#left_column').insertAfter('#center_column');
        $('#search_block_top').prependTo('.f-right .top-icon-search');
        $('.shopping_cart').prependTo('.f-right .header-icon-cart .shopping_cart_container');
        $('#nav_topmenu').prependTo('#top_column');
	}
	else if (($(window).width()+scrollCompensate()) >= 992)
	{
		//accordion('disable');
	//accordionFooter('disable');
        //milanAccordion('disable');
       // mobileHeader('disable');
	    responsiveflag = false;
        $('#left_column').insertBefore('#center_column');
        $('#search_block_top').removeClass('open');
        $('#search_block_top').prependTo('#search_block_top_container');
        $('.shopping_cart').prependTo('#header .shopping_cart_container');
	}
	if (typeof page_name != 'undefined' && in_array(page_name, ['category']))
		resizeCatimg();
}
*/
function blockHover(status)
{
    /*
	$(document).off('mouseenter').on('mouseenter', '.product_list.grid li.ajax_block_product .product-container', function(e){
		if ($('body').find('.container').width() == 1170)
		{
			//var pcHeight = $(this).parent().outerHeight();
			//var pcPHeight = $(this).parent().find('.button-container').outerHeight() + $(this).parent().find('.comments_note').outerHeight() + $(this).parent().find('.functional-buttons').outerHeight();
			//$(this).parent().addClass('hovered').css({'height':pcHeight + pcPHeight, 'margin-bottom':pcPHeight * (-1)});
            $(this).parent().addClass('hovered');
		}
	});
	$(document).off('mouseleave').on('mouseleave', '.product_list.grid li.ajax_block_product .product-container', function(e){
		if ($('body').find('.container').width() == 1170)
			//$(this).parent().removeClass('hovered').css({'height':'auto', 'margin-bottom':'0'});
            $(this).parent().removeClass('hovered');
	});
    */
}
function quick_view()
{
	$(document).on('click', '.quick-view:visible, .quick-view-mobile:visible', function(e)
	{
		e.preventDefault();
		var url = $(this).data().rel;
		if (url.indexOf('?') != -1)
			url += '&';
		else
			url += '?';
		if (!!$.prototype.fancybox)
			$.fancybox({
			     helpers: {
                                    overlay: {
                                      locked: false
                                    }
                                  },
				'padding':  0,
				'width':    1087,
				'height':   610,
				'type':     'iframe',
				'href':     url + 'content_only=1'
			});
	});
}
function bindGrid()
{
	
	var view = $.totalStorage('display');
	if (!view && (typeof displayList != 'undefined') && displayList)
		view = 'grid';
		
	if (view && view != 'grid')
		display(view);
	else{
		$('.display').find('a.view_as_grid').addClass('active');		
	}
		
		
	$(document).on('click', '.view_as_grid', function(e){
		e.preventDefault();
		display('grid');
	});
	$(document).on('click', '.view_as_list', function(e){
		e.preventDefault();
		display('list');
	});
}
/*

$(window).resize(function(){
    sw_section_width();
    sw_section_full();
    sw_section_full_footer();
});
function sw_section_width() {
    var $ = jQuery;
    $('.sw_section').each(function(){
        $(this).css({
            'left': - ($(window).width() - $('#columns').width())/2,
            'width': $(window).width(),
            'visibility': 'visible'
        });
    });
}
function sw_section_full() {
    var $ = jQuery;
    $('.sw_section_full').each(function(){
        $(this).css({
            'width': $(window).width(),
            'height': $(window).height(),
            'visibility': 'visible'
        });
    });
}
function sw_section_full_footer(){
    var $ = jQuery;
    $('.sw_section_footer').each(function(){
        $(this).css({
            'margin-left': - ($(window).width() - $('.footer .container').width())/2,
            'width': $(window).width(),
            'visibility': 'visible'
        });
    });
}*/

function display(view)
{
	var itemWidth = parseInt($('#center_column .product_list').data('item-width'));
	var productPerRow = parseInt($('#center_column .product_list').data('product-per-row'));
    // process column
    //var case_width = 'normal-width';
    //case_width = $('.case-width').val();
    //var ul_class = $('#center_column ul.product_list').attr('class');
	if (view == 'list')
	{
		var products = '';
		if($(".product_list").hasClass('category-list')) return true;		
		$('#center_column .product_list').removeClass('category-grid').addClass('category-list');
		$('#center_column .product_list .product').each(function(index, element) {
		    /*
		    var li_class = $(this).attr('class');
            $(this).attr('data-class',li_class);
            if (index % 2 == 0)
                li_class = 'ajax_block_product item odd';
            else
                li_class = 'ajax_block_product item even';
            */
            //$(this).attr('class', 'product');
            // col 9
            //var html	='';
            products		+=	'<div class="row product">'
            products 		+= 		'<div class="p-col9 col-sm-9 clearfix">';
            products		+=			'<div class="product-top">'+$(this).find('.product-top').html()+'</div>';
            products 		+=			'<div class="product-list-content">';
            products		+=				'<h3 class="product-name" itemprop="name">'+$(this).find('.product-name').html()+'</h3>';
            products		+=				'<p class="product-desc" itemprop="description">'+$(this).find('.product-desc').html()+'</p>';
            products		+=			'</div>'            
            products		+=		'</div>';
            // end col 9
            // col 3
            var addtoCart = $(this).find('a.ajax_add_to_cart_button');
            var quickView = $(this).find('a.quick-view');
            var addToCompare = $(this).find('a.add_to_compare');            
            var addToWishlist = $(this).find('a.addToWishlist');            
            products		+=		'<div class="p-col3 col-sm-3 product-list-meta">';
            products		+=			'<div class="product-price-container">'+$(this).find('.product-price-container').html()+'</div>';
            products		+=			'<div class="ratings-container">'+$(this).find('.ratings-container').html()+'</div>';
            products		+=			'<div class="product-action-container">';
            products		+=				'<a href="'+$(addtoCart).attr('href')+'" title="'+$(addtoCart).attr('title')+'" class="ajax_add_to_cart_button btn btn-custom btn-block" rel="'+$(addtoCart).attr('rel')+'" title="'+$(addtoCart).attr('title')+'" data-id-product="'+$(addtoCart).attr('data-id-product')+'" data-minimal_quantity="'+$(addtoCart).attr('data-minimal_quantity')+'">'+$(addtoCart).html()+'</a>';
            products		+=				'<div class="sm-margin"></div>';
            products		+=				'<div class="product-list-action-wrapper">';
            products		+=					'<a href="'+$(quickView).attr('href')+'" title="'+$(quickView).attr('title')+'" data-rel="'+$(quickView).data('rel')+'" class="quick-view product-btn product-search">'+$(quickView).html()+'</a>';
            products		+=					'<a href="'+$(addToWishlist).attr('href')+'" title="'+$(addToWishlist).attr('title')+'" class="addToWishlist wishlistProd_2 link-wishlist product-btn product-favorite" data-wl="'+$(addToWishlist).data('wl')+'" data-wl0="'+$(addToWishlist).data('wl0')+'" data-wl1="'+$(addToWishlist).data('wl1')+'" data-wl2="'+$(addToWishlist).data('wl2')+'" data-wl3="'+$(addToWishlist).data('wl3')+'" data-wl4="'+$(addToWishlist).data('wl4')+'">'+$(addToWishlist).html()+'</a>';
            products		+=					'<a href="'+$(addToCompare).attr('href')+'" title="'+$(addToCompare).attr('title')+'" class="add_to_compare link-compare product-btn product-compare">'+$(addToCompare).html()+'</a>';            
            products		+=				'</div>';
            products		+=			'</div>';
            products		+=		'</div>';  
            products		+=	'</div>';    
            //products	+= html;      
			//$(element).html(html);
		});
		$('#center_column .product_list').html(products);
		$('.display').find('.view_as_list').addClass('active');
		$('.display').find('.view_as_grid').removeClass('active');
		$.totalStorage('display', 'list');
	}
	else
	{	   
		
		var products = '';
		if($(".product_list").hasClass('category-grid')) return true;
		$('#center_column .product_list').removeClass('category-list').addClass('category-grid');
		var total = $('#center_column .product_list  .product').length;
		var products = '<div class="row">';
		$('#center_column .product_list  .product').each(function(index, element) {		    
            //$(this).attr('class', 'col-sm-4 md-margin2x');

            products	+=	'<div class="col-sm-'+itemWidth+' md-margin2x">';
            products	+=		'<div class="product">';
            products	+=			'<div class="product-top">'+$(this).find('.product-top').html()+'</div>';
            products	+=			'<h3 class="product-name" itemprop="name">'+$(this).find('h3.product-name').html()+'</h3>';
            products 	+=			'<div class="ratings-container">'+$(this).find('div.ratings-container').html()+'</div>';
            products	+=			'<p class="product-desc" itemprop="description">'+$(this).find('p.product-desc').html()+'</p>';
            products	+=			'<div class="product-price-container">'+$(this).find('div.product-price-container').html()+'</div>';
            products	+=		'</div>';   
			products	+=	'</div>';    
			if((index % productPerRow == productPerRow-1) && index < total - 1){
				products += '</div><div class="row">'	
			}                 
			//$(element).html(html);
		});
		products += '</div>';
		
		
		
		/*
	    // process column
		var className = ''
    	if(($("#left_column").length >0 || $("#right_column").length >0) && !($("#left_column").length >0 && $("#right_column").length >0))
            className = 'products-grid grid-type-1 column3';
        else{
            if($("#left_column").length >0 && $("#right_column").length >0)
                className = 'products-grid grid-type-1 column2';
            else
                className = 'products-grid grid-type-1 column4';
        } 
        $('#center_column ul.product_list').removeClass('products-list').addClass(className);
		$('#center_column .product_list > li').each(function(index, element) {
		var data_class = $(this).attr('data-class');
        $(this).removeAttr('data-class');
        $(this).attr('class',data_class);
		html = '<div itemscope="" itemtype="http://schema.org/Product"><div class="product-image-wrapper">';
        html += $(element).find('.product-image-wrapper').html();
        html += '<div class="actions"><div class="actions-wrapper">';
        html += $(element).find('.btn-cart-wrapper').html();
        html += $(element).find('.hidden_btn').html();
        html += $(element).find('.wishlist_btn').html();
        html += $(element).find('.compare_btn').html();
        html += '</div></div></div><h2 itemprop="name" class="product-name">';
        html += $(element).find('.product-name').html();
        html += '</h2>';
        var comments_note = $(element).find('.comments_note').html();
            if (comments_note != null){
                html +='<div class="comments_note" itemprop="aggregateRating" itemscope="" itemtype="http://schema.org/AggregateRating">'+ comments_note +'</div>';
            }
        html +='<div class="price-box" itemprop="offers" itemscope="" itemtype="http://schema.org/Offer">';
        html += $(element).find('.price-box').html();
        html += '</div><p class="product-desc" itemprop="description">';
        html += $(element).find('.desc').html();
        html +='</p></div>';
		$(element).html(html);
		});
		*/
		$('#center_column .product_list').html(products);
		$('.display').find('.view_as_grid').addClass('active');
		$('.display').find('.view_as_list').removeClass('active');
		$.totalStorage('display', 'grid');
	}
}
function dropDown()
{
	elementClick = '#header .current';
	elementSlide =  'ul.toogle_content';
	activeClass = 'active';
	$(elementClick).on('click', function(e){
		e.stopPropagation();
		var subUl = $(this).next(elementSlide);
		if(subUl.is(':hidden'))
		{
			subUl.slideDown();
			$(this).addClass(activeClass);
		}
		else
		{
			subUl.slideUp();
			$(this).removeClass(activeClass);
		}
		$(elementClick).not(this).next(elementSlide).slideUp();
		$(elementClick).not(this).removeClass(activeClass);
		e.preventDefault();
	});
	$(elementSlide).on('click', function(e){
		e.stopPropagation();
	});
	$(document).on('click', function(e){
		e.stopPropagation();
		var elementHide = $(elementClick).next(elementSlide);
		$(elementHide).slideUp();
		$(elementClick).removeClass('active');
	});
}
/*

function accordionFooter(status)
{
	if(status == 'enable')
	{
		$('#footer .footer-block h4').on('click', function(){
			$(this).toggleClass('active').parent().find('.toggle-footer').stop().slideToggle('medium');
		})
		$('#footer').addClass('accordion').find('.toggle-footer').slideUp('fast');
	}
	else
	{
		$('.footer-block h4').removeClass('active').off().parent().find('.toggle-footer').removeAttr('style').slideDown('fast');
		$('#footer').removeClass('accordion');
	}
}
function milanAccordion(status)
{
	if(status == 'enable')
	{
		$('#blog-home-page .title_block, .block-toggle .row-title').on('click', function(){
			$(this).toggleClass('active').parent().find('.toggle-footer').stop().slideToggle('medium');
		})
		$('#blog-home-page, .block-toggle').addClass('accordion').find('.toggle-footer').slideUp('fast');
	}
	else
	{
		$('#blog-home-page .title_block, .block-toggle .row-title').removeClass('active').off().parent().find('.toggle-footer').removeAttr('style').slideDown('fast');
		$('#blog-home-page, .block-toggle').removeClass('accordion');
	}
}
function accordion(status)
{
	leftColumnBlocks = $('#left_column');
	if(status == 'enable')
	{
		$('#right_column .block .title_block, #left_column .block .title_block, #left_column #newsletter_block_left h4').on('click', function(){
			$(this).toggleClass('active').parent().find('.block_content').stop().slideToggle('medium');
		})
		$('#right_column, #left_column').addClass('accordion').find('.block .block_content').slideUp('fast');
	}
	else
	{
		$('#right_column .block .title_block, #left_column .block .title_block, #left_column #newsletter_block_left h4').removeClass('active').off().parent().find('.block_content').removeAttr('style').slideDown('fast');
		$('#left_column, #right_column').removeClass('accordion');
	}
}
function resizeCatimg()
{
	var div = $('.cat_desc').parent('div');
	var image = new Image;
	$(image).load(function(){
	    var width  = image.width;
	    var height = image.height;
		var ratio = parseFloat(height / width);
		var calc = Math.round(ratio * parseInt(div.outerWidth(false)));
		div.css('min-height', calc);
	});
	if (div.length)
		image.src = div.css('background-image').replace(/url\("?|"?\)$/ig, '');
}*/

/* Ovic - Process mobile header */
function mobileHeader(flag_mobile) {
    if (flag_mobile == 'enable') {
        // Enable mobile header
        //$('#currencies-block-top, #languages-block-top, .shopping_cart_container').appendTo('#enable_mobile_header');
        //$('#enable_mobile_header').show();
    }else if (flag_mobile == 'disable') {
        // Disable mobile header
        //$('#currencies-block-top, #languages-block-top').insertAfter('header .nav .header_user_info');
        //$('.shopping_cart_container').insertAfter('#search_block_top');
        //$('#enable_mobile_header').hide();
    }
}
function responsiveMobileHeader()
{
	compensante = scrollCompensate();
	if (($(window).width()+scrollCompensate()) <= 480)
	{
        mobileHeader('enable');
	}
	else if (($(window).width()+scrollCompensate()) > 480)
	{
        mobileHeader('disable');
	}
}

