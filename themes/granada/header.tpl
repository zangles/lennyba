{*
*  @author Ovic-soft <nguyencaoson.zpt@gmail.com>
*  @copyright  2010-2015
*}
{assign var='option_tpl' value=OvicLayoutControl::getTemplateFile('header.tpl')}
{if  $option_tpl!== null}
    {include file=$option_tpl}
{else}
<!DOCTYPE HTML>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7 " lang="{$lang_iso}"><![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8 ie7" lang="{$lang_iso}"><![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9 ie8" lang="{$lang_iso}"><![endif]-->
<!--[if gt IE 8]> <html class="no-js ie9" lang="{$lang_iso}"><![endif]-->
<html lang="{$lang_iso}">
	<head>
		<meta charset="utf-8" />
		<title>{$meta_title|escape:'html':'UTF-8'}</title>
		{if isset($meta_description) AND $meta_description}
		<meta name="description" content="{$meta_description|escape:'html':'UTF-8'}" />
		{/if}
		{if isset($meta_keywords) AND $meta_keywords}
		<meta name="keywords" content="{$meta_keywords|escape:'html':'UTF-8'}" />
		{/if}
		<meta name="generator" content="PrestaShop" />
		<meta name="robots" content="{if isset($nobots)}no{/if}index,{if isset($nofollow) && $nofollow}no{/if}follow" />
		<meta name="viewport" content="width=device-width, minimum-scale=0.25, maximum-scale=1.6, initial-scale=1.0" />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<link rel="icon" type="image/vnd.microsoft.icon" href="{$favicon_url}?{$img_update_time}" />
		<link rel="shortcut icon" type="image/x-icon" href="{$favicon_url}?{$img_update_time}" />
		<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Judson:200,300,400,400italic,500,600,700" type="text/css">
		<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Source+Code+Pro:200,300,400,400italic,500,600,700" type="text/css">
		<link id="Open_Sans_secondary-css" href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css' />
		{assign var="globalcss" value="`$tpl_uri`css/global.css"}
		<link rel="stylesheet" href="{$globalcss}" type="text/css" media="all" />

		{if isset($css_files)}
			{foreach from=$css_files key=css_uri item=media}
				{if $css_uri != $globalcss }
				<link rel="stylesheet" href="{$css_uri|escape:'html':'UTF-8'}" type="text/css" media="{$media|escape:'html':'UTF-8'}" />
				{/if}
			{/foreach}
		{/if}
		{if isset($js_defer) && !$js_defer && isset($js_files) && isset($js_def)}
			{$js_def}
			{foreach from=$js_files item=js_uri}
			<script type="text/javascript" src="{$js_uri|escape:'html':'UTF-8'}"></script>
			{/foreach}
		{/if}
		<!-- <script type="text/javascript" src="{$js_dir}{$current_dir}.js"></script> -->       
		{$HOOK_HEADER}
		<link rel="stylesheet" type="text/css" href="{$css_dir}animate.min.css" />
		<link rel="stylesheet" href="http{if Tools::usingSecureMode()}s{/if}://fonts.googleapis.com/css?family=Open+Sans:300,600&amp;subset=latin,latin-ext" type="text/css" media="all" />
		<!--[if IE 8]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
		<![endif]-->
		<script type="text/javascript">
		//<![CDATA[
		//if (typeof EM == 'undefined') EM = {};
		//]]
		</script>

	</head>
	<body{if isset($page_name)} id="{$page_name|escape:'html':'UTF-8'}"{/if} class="{if isset($body_classes) && $body_classes|@count} {implode value=$body_classes separator=' '}{/if}{if $hide_left_column} hide-left-column{/if}{if $hide_right_column} hide-right-column{/if}{if isset($content_only) && $content_only} content_only{/if} lang_{$lang_iso} {$current_dir} content-type wide granada-theme {if $page_name =='index'}index-page{else}orther-page{/if}">
	{addJsDef tplUri=$tpl_uri}
    <div id="wrapper" style="overflow: hidden">
    {if !isset($content_only) || !$content_only}
		{if isset($restricted_country_mode) && $restricted_country_mode}
			<div id="restricted-country">
				<p>{l s='You cannot place a new order from your country.'} <span class="bold">{$geolocation_country|escape:'html':'UTF-8'}</span></p>
			</div>
		{/if}
        {if $page_name == 'index' || $page_name == 'product'}{addJsDefL name=min_item}{l s='Please select at least one product' js=1}{/addJsDefL}{/if}
        {if ($page_name == 'index' || $page_name == 'product') and isset($comparator_max_item)}
        {addJsDefL name=max_item}{l s='You cannot add more than %d product(s) to the product comparison' sprintf=$comparator_max_item js=1}{/addJsDefL}
        {addJsDef comparator_max_item=$comparator_max_item}
        {/if}
        {if ($page_name != 'category' && $page_name !='best-sales' && $page_name != 'search' && $page_name != 'manufacturer' && $page_name != 'supplier' && $page_name != 'prices-drop' && $page_name != 'new-products') and isset($compared_products)}{addJsDef comparedProductsIds=$compared_products}{/if}
			<div id="sticky-header" class="header4 dark boxed-menu" data-fixed="fixed"></div>
    		<header id="header" class="header4 boxed-menu dark">
               <div id="header-top">
                  <div class="container clearfix">
                  	{hook h="displayNav"}
                  </div>
               </div>
               <div class="container header-inside">

				   <div class="row" style="height: 100px">

					  <div class="col-sm-2 col-sm-offset-3 menu_item">
						  <a class="dropdown-toggle colectionMenu" href="{$link->getCategoryLink(15)|escape:'html':'UTF-8'}" style="color: #000;">COLECCIONES</a>
						  <ul class="dropdown-menu" style="top: 75px">
							  <li><a href="{$link->getCMSLink('7-gitano-ss16')|escape:'html':'UTF-8'}" title="{l s='SS16' mod='blockuserinfo'}" class="account" rel="nofollow">{l s='SS16' mod='blockuserinfo'}</a></li>
						  </ul>
						  <script type="text/javascript">
							  (function($){
								  $('.colectionMenu, .lookbookMenu, .videoMenu').click(function(event){
									  event.preventDefault();
								  });
								  $('.colectionMenu, .lookbookMenu, .videoMenu').hover(function(){
											  $(this).addClass('open');
										  },
										  function(){
											  $(this).removeClass('open');
										  });
							  })(jQuery);
						  </script>
					  </div>

					   <div class="col-sm-3 menu_item text-center" >
						   <a href="{$link->getCMSLink('8-01' )|escape:'html':'UTF-8'}" style="margin-left: 20px;" class=" dropdown-toggle lookbookMenu" style="color: #000;">
								LOOKBOOK
						   </a>
						   <ul class="dropdown-menu" style="top: 75px">
							   <li><a href="{$link->getCMSLink('8-01')|escape:'html':'UTF-8'}" title="{l s='SS16' mod='blockuserinfo'}" class="account" rel="nofollow">{l s='SS16' mod='blockuserinfo'}</a></li>
						   </ul>
					   </div>

					  <div class="col-sm-2 menu_item text-center dropdown-toggle videoMenu">
						  <a href="#" class=" dropdown-toggle videoMenu" style="color: #000;">
							  VIDEO
						  </a>
						  <ul class="dropdown-menu" style="top: 75px">
							  <li><a href="{$link->getCMSLink('10-video-ss16')|escape:'html':'UTF-8'}" title="{l s='SS16' mod='blockuserinfo'}" class="account" rel="nofollow">{l s='SS16' mod='blockuserinfo'}</a></li>
						  </ul>
					  </div>
					   <a href="/">
						  <div class="col-sm-4 menu_item text-center" style="padding-top: 29px">
							  <img class="img-responsive" src="{$base_dir}/LOGO-LENNY-NEGRO.png" style="max-width: 228px; ">
						  </div>

					   </a>
					   <a href="{$link->getCategoryLink(12)|escape:'html':'UTF-8'}">
						   <div class="col-sm-2 menu_item text-center">E-SHOP</div>
					   </a>
					   <a href="{$link->getCMSLink('9-about' )|escape:'html':'UTF-8'}">
					  		<div class="col-sm-2 menu_item text-center">ABOUT</div>
					   </a>
					   <a href="{$link->getPageLink('contact-form.php', true)}">
						   <div class="col-sm-2 menu_item">
						   	{l s='CONTACTO' mod='blockcms'}
						   </div>
					   </a>
                  </div>
				   <div class="row"  style="background-color: black;color:white">
					   <div class="col-sm-3 col-sm-offset-3 dropdown" style="margin-top: 5px;">
						   <a href="{$link->getPageLink('my-account', true)|escape:'html':'UTF-8'}" title="{l s='View my customer account' mod='blockuserinfo'}" class="btn-top-account dropdown-toggle"  style="color: #fff;">
							   <img src="{$base_dir}/img/azs/menu_icon_mi_cuenta.jpg" alt="">
							   Mi Cuenta
						   </a>
						   <ul class="dropdown-menu">
							   <li class="myaccount-link"><a href="{$link->getPageLink('my-account', true)|escape:'html':'UTF-8'}" title="{l s='Ver mi cuenta' mod='blockuserinfo'}" class="account" rel="nofollow">{l s='Mi cuenta' mod='blockuserinfo'}</a></li>
							   <li class="checkout-link"><a href="{$link->getPageLink('order', true)|escape:'html':'UTF-8'}" title="{l s='Checkout' mod='blockuserinfo'}">{l s='Checkout' mod='blockuserinfo'}</a></li>
							   <li class="mywishlist-link"><a href="{$link->getModuleLink('blockwishlist', 'mywishlist', array(), true)|escape:'html':'UTF-8'}"  rel="nofollow" title="{l s='Favoritos' mod='blockuserinfo'}">{l s='Favoritos' mod='blockuserinfo'}</a></li>
						   </ul>
						   <script type="text/javascript">
							   (function($){
								   $('.top-bar-account > a').click(function(event){
									   event.preventDefault();
								   });
								   $('.top-bar-account').hover(function(){
											   $(this).addClass('open');
										   },
										   function(){
											   $(this).removeClass('open');
										   });
							   })(jQuery);
						   </script>
					   </div>
					   <div class="col-sm-3" style="margin-top: 5px;">
						   <a href="{$link->getPageLink('order', true)|escape:'html':'UTF-8'}" title="{l s='Checkout' mod='blockuserinfo'}"  style="color: #fff;">
							   <img src="{$base_dir}/img/azs/menu_icon_checkout.jpg" alt="">{l s='Checkout' mod='blockuserinfo'}
						   </a>
					   </div>
					   <div class="col-sm-3" style="margin-top: 5px;">
						   <a href="{$link->getModuleLink('blockwishlist', 'mywishlist', array(), true)|escape:'html':'UTF-8'}"  rel="nofollow" title="{l s='My wishlists' mod='blockuserinfo'}"  style="color: #fff;">
							   <img src="{$base_dir}/img/azs/menu_icon_favs.jpg" alt="">
							   {l s='Favoritos' mod='blockuserinfo'}
						   </a>
					   </div>

					   <div class="col-sm-2">
						   {if $logged}
							   <a href="{$base_dir}index.php?mylogout" style="color: #fff;">
								<img src="{$base_dir}/img/azs/menu_icon_login.jpg" alt="">
								   {l s='Log out'}
							   </a>
						   {else}
							&nbsp;
						   {/if}
					   </div>

					   <div class="col-sm-9">
						   {if isset($HOOK_TOP)}{$HOOK_TOP}{/if}
					   </div>

					   {*<div class="col-sm-2">$ Pesos Arg</div>*}
					   {*<div class="col-sm-2">*}
						   {*<img src="{$base_dir}/img/azs/menu_icon_items.jpg" alt="">*}
						   {*<span class="ajax_cart_quantity">0</span> Item(s)*}
					   {*</div>*}
					   {*<div class="col-sm-2">*}
						   {*<img src="{$base_dir}/img/azs/menu_icon_search.jpg" alt="">*}
						   {*Search*}
					   {*</div>*}
				   </div>
               </div>
               <div id="nav-wrapper">

               </div>
            </header>
	{/if}	
{/if}
