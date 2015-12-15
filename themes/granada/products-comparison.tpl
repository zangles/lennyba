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
	<li class="active">{l s='Product Comparison'}</li>
{/capture}
<section id="content" role="main">
	{include file="$tpl_dir./breadcrumb.tpl"}
	<div class="xs-margin"></div>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				{assign var='taxes_behavior' value=false}
				{if $use_taxes && (!$priceDisplay  || $priceDisplay == 2)}
					{assign var='taxes_behavior' value=true}
				{/if}
				{if isset($products) && $products|@count >0}
				<table class="table compare-table">
					<tbody>
						<tr class="product-row">
							<td class="table-title">{l s='PRODUCT NAME'}{*}{$HOOK_COMPARE_EXTRA_INFORMATION}{*}</td>
							{foreach from=$products item=product name=products}	
							{assign var='replace_id' value=$product->id|cat:'|'}							
							<td class="ajax_block_product comparison_infos product-block product-{$product->id}">
								<figure>
									<a href="{$product->getLink()|escape:'html':'UTF-8'}"><img src="{$link->getImageLink($product->link_rewrite, $product->id_image, 'home_default')|escape:'html':'UTF-8'}" alt="{$product->name|escape:'html':'UTF-8'}"></a>
								</figure>
								<h2 class="product-name"><a href="{$product->getLink()|escape:'html':'UTF-8'}">{$product->name|escape:'html':'UTF-8'}</a></h2>
							</td>							
							{/foreach}							 
						</tr>
						<tr class="price-row">
							<td class="table-title">{l s='unit PRICE'}</td>
							{foreach from=$products item=product name=products}	
							{assign var='replace_id' value=$product->id|cat:'|'}							
							<td class="ajax_block_product comparison_infos product-block product-{$product->id}">								
								<span class="product-price-special">
									{convertPrice price=$product->getPrice($taxes_behavior)}
									{hook h="displayProductPriceBlock" id_product=$product->id type="price"}
								</span>								
							</td>							
							{/foreach}							 
						</tr>
						<tr class="brand-row">
							<td class="table-title">{l s='BRAND'}</td>
							{foreach from=$products item=product name=products}	
							{assign var='replace_id' value=$product->id|cat:'|'}							
							<td class="ajax_block_product comparison_infos product-block product-{$product->id}">
								{if $product->manufacturer_name}
									{$product->manufacturer_name|escape:'html':'UTF-8'}
								{else}
									No manufacturer
								{/if}
							</td>							
							{/foreach}							 
						</tr>
						
						<tr class="availability-row">
							<td class="table-title">{l s='AVAILABILITY'}</td>
							{foreach from=$products item=product name=products}	
							{assign var='replace_id' value=$product->id|cat:'|'}							
							<td class="ajax_block_product comparison_infos product-block product-{$product->id}">
								{if !(($product->quantity <= 0 && !$product->available_later) OR ($product->quantity != 0 && !$product->available_now) OR !$product->available_for_order OR $PS_CATALOG_MODE)}
									
									
										{if $product->quantity <= 0}
											{if $product->allow_oosp}
												{$product->available_later|escape:'html':'UTF-8'}
											{else}
												{l s='This product is no longer in stock.'}
											{/if}
										{else}
											{$product->available_now|escape:'html':'UTF-8'}
										{/if}
									
								{else}
									No comparison
								{/if}
							</td>							
							{/foreach}							 
						</tr>
						
						<tr class="summary-row">
							<td class="table-title">{l s='Summary'}</td>
							{foreach from=$products item=product name=products}	
							{assign var='replace_id' value=$product->id|cat:'|'}							
							<td class="ajax_block_product comparison_infos product-block product-{$product->id}">
								{$product->description_short}
							</td>							
							{/foreach}							 
						</tr>
						{if $ordered_features}
							{foreach from=$ordered_features item=feature}
								<tr>
									{cycle values='comparison_feature_odd,comparison_feature_even' assign='classname'}
									<td class="table-title {$classname} feature-name" >
										<strong>{$feature.name|escape:'html':'UTF-8'}</strong>
									</td>
									{foreach from=$products item=product name=for_products}
										{assign var='product_id' value=$product->id}
										{assign var='feature_id' value=$feature.id_feature}
										{if isset($product_features[$product_id])}
											{assign var='tab' value=$product_features[$product_id]}
											<td class="{$classname} comparison_infos product-{$product->id}">{if (isset($tab[$feature_id]))}{$tab[$feature_id]|escape:'html':'UTF-8'}{/if}</td>
										{else}
											<td class="{$classname} comparison_infos product-{$product->id}"></td>
										{/if}
									{/foreach}
								</tr>
							{/foreach}
						{/if}
						{$HOOK_EXTRA_PRODUCT_COMPARISON}
						<tr class="action-row">
							<td class="table-title"></td>
							{foreach from=$products item=product name=products}	
							{assign var='replace_id' value=$product->id|cat:'|'}							
								<td class="ajax_block_product comparison_infos product-block product-{$product->id}">
						            {if (!$product->hasAttributes() OR (isset($add_prod_display) AND ($add_prod_display == 1))) AND $product->minimal_quantity == 1 AND $product->customizable != 2 AND !$PS_CATALOG_MODE}
										{if ($product->quantity > 0 OR $product->allow_oosp)}
											<a class="ajax_add_to_cart_button btn btn-custom-6 min-width-md" data-id-product="{$product->id}" href="{$link->getPageLink('cart', true, NULL, "qty=1&amp;id_product={$product->id}&amp;token={$static_token}&amp;add")|escape:'html':'UTF-8'}" title="{l s='Add to cart'}">
												<span>{l s='Add to cart'}</span>
											</a>
										{else}
											<span class="ajax_add_to_cart_button btn btn-custom-6 min-width-md disabled">
												<span>{l s='Add to cart'}</span>
											</span>
										{/if}
									{/if}
						            <div class="sm-margin"></div>
						            <a class="cmp_remove close-button" href="{$link->getPageLink('products-comparison', true)|escape:'html':'UTF-8'}" title="{l s='Remove'}" data-id-product="{$product->id}"></a>
						         </td>							
							{/foreach}
				      </tr>
					
					</tbody>
				</table>
				
				{/if}
				
				
				
				
				
			</div>
			
			
			
		</div>
	</div>	
	<div class="md-margin"></div>
</section>
