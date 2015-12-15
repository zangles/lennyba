{*
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
*}
{capture name=path}
	<li><a href="{$base_dir}" title="{l s='Home'}">{l s='Home'}</a></li>
	<li><a href="{$link->getPageLink('manufacturer')|escape:'html':'UTF-8'}" title="{l s='Manufacturers'}">{l s='Manufacturers'}</a></li>	
	<li class="active">{$manufacturer->name|escape:'html':'UTF-8'}</li>
{/capture}

{assign var='left_column_size' value=0}{assign var='right_column_size' value=0}
{if isset($HOOK_LEFT_COLUMN) && $HOOK_LEFT_COLUMN|trim && !$hide_left_column}{$left_column_size=3}{/if}
{if isset($HOOK_RIGHT_COLUMN) && $HOOK_RIGHT_COLUMN|trim && !$hide_right_column}{$right_column_size=3}{/if}
{assign var='left_column' value=false}
{assign var='right_column' value=false}
{if isset($HOOK_LEFT_COLUMN) && $HOOK_LEFT_COLUMN|trim && !$hide_left_column}
	{$left_column=true}
{/if}
{if isset($HOOK_RIGHT_COLUMN) && $HOOK_RIGHT_COLUMN|trim && !$hide_right_column}
	{$right_column=true}
{/if}
<section id="content" role="main">
	{include file="$tpl_dir./breadcrumb.tpl"}
	<div class="container">
		<div class="row">			
			<div class="col-sm-12">
				{include file="$tpl_dir./errors.tpl"}
				<div id="category-banner" class="content_scene_cat_bg">
		    		<h2 class="color2">{l s='List of products by manufacturer'}&nbsp;{$manufacturer->name|escape:'html':'UTF-8'}</h2>
					<div class="description_box rte">
						{if !empty($manufacturer->short_description)}
							<div class="short_desc">
								{$manufacturer->short_description}
							</div>
							<div class="hide_desc">
								{$manufacturer->description}
							</div>
							<a href="#" class="lnk_more" onclick="$(this).prev().slideDown('slow'); $(this).hide();$(this).prev().prev().hide(); return false;">
								{l s='More'}
							</a>
						{else}
							<div>
								{$manufacturer->description}
							</div>
						{/if}
					</div>					
		         </div>                   
		         <div class="lg-margin"></div>	
			</div>
		</div>
	</div>
	<div class="xs-margin"></div>
	<div class="container">
		<div class="row">
			{if $left_column == true}
				{if $right_column == true}
					<aside class="col-md-3 sidebar margin-top-up" role="complementary">
						{$HOOK_LEFT_COLUMN}
					</aside>
					<div class="col-md-6 padding-both-larger" id="center_column">
						{include file="./manufacturer-center.tpl" productPerRow='2' itemWidth='6'}
					</div>					
					<aside class="col-md-3 sidebar margin-top-up">
						{$HOOK_RIGHT_COLUMN}
					</aside>
				{else}
					<div class="col-md-9 col-md-push-3 col-sm-8 col-sm-push-4 padding-left-larger">
						{include file="./manufacturer-center.tpl" productPerRow='3' itemWidth='4'}
					</div>
					<aside class="col-md-3 col-md-pull-9 col-sm-4 col-sm-pull-8 sidebar margin-top-up" role="complementary">
						{$HOOK_LEFT_COLUMN}
					</aside>
				{/if}
			{else}
				{if $right_column == true}
					<div class="col-md-9 col-sm-8 padding-right-md" id="center_column">
						{include file="./manufacturer-center.tpl" productPerRow='3' itemWidth='4'}
					</div>
					<aside class="col-md-3 col-sm-4 sidebar margin-top-up" role="complementary">
						{$HOOK_RIGHT_COLUMN}
					</aside>
				{else}
					<div class="col-xs-12 articles-container" id="center_column">
						{include file="./manufacturer-center.tpl" productPerRow='4' itemWidth='3'}
					</div>					
				{/if}
			{/if}					
		</div>
	</div>	
	<div class="md-margin"></div>
</section>
