{*
*  @author Ovic-soft <nguyencaoson.zpt@gmail.com>
*  @copyright  2010-2015
*}

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
		    			
			<div id="sticky-header" class="boxed-menu header4 " data-fixed="fixed"></div>
    		<header id="header" class="header4 boxed-menu dark">
               <div id="header-top">
					<div class="container clearfix">						
	                       {hook h="displayNav"}                        	                     	
					</div>						
               </div>
               <div class="container header-inside">
                  <div class="row">
                     <div class="col-sm-12 clearfix">                     	
                        <div class="logo-container">
                           <h1 class="logo clearfix"><a href="{$base_dir}" title="{$shop_name} - {$meta_description|escape:'html':'UTF-8'}">{$shop_name}</a></h1>
                        </div>
                        <div class="right-side clearfix">
                        	{if isset($HOOK_TOP)}{$HOOK_TOP}{/if}	                        	
                        </div>
                     </div>
                  </div>
               </div>
               <div class="container nav-wrapper" data-clone="sticky">
                  <div class="row">
                     <div class="col-sm-12">
                        <a href="#" class="header-search-btn visible-xs" title="Search"></a>
                        {hook h="displayTopColumn"}
                     </div>
                  </div>
               </div>
            </header>
	{/if}	

