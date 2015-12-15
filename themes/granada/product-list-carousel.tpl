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
{if isset($products) && $products}
	{*define numbers of product per line in other page for desktop*}
	{if $page_name !='index' && $page_name !='product'}
        {if $hide_left_column xor $hide_right_column}
            {assign var='nbol' value=3}
        {else}
            {assign var='nbol' value=4}
        {/if}
		{assign var='nbItemsPerLine' value=$nbol}
		{assign var='nbItemsPerLineTablet' value=($nbol-1)}
		{assign var='nbItemsPerLineMobile' value=($nbol-2)}
	{else}
        {if $page_name =='index' && ($hide_left_column xor $hide_right_column)}
            {assign var='nbol' value=3}
        {else}
            {assign var='nbol' value=4}
        {/if}
		{assign var='nbItemsPerLine' value=$nbol}
		{assign var='nbItemsPerLineTablet' value=($nbol-1)}
		{assign var='nbItemsPerLineMobile' value=($nbol-2)}
	{/if}
	{*define numbers of product per line in other page for tablet*}
	{assign var='nbLi' value=$products|@count}
	{math equation="nbLi/nbItemsPerLine" nbLi=$nbLi nbItemsPerLine=$nbItemsPerLine assign=nbLines}
	{math equation="nbLi/nbItemsPerLineTablet" nbLi=$nbLi nbItemsPerLineTablet=$nbItemsPerLineTablet assign=nbLinesTablet}

	<!-- Products list -->
	{foreach from=$products item=product name=products}
        <ul{if isset($id) && $id} id="{$id}"{/if} class="product_list grid row{if isset($class) && $class} {$class}{/if}">
        <li class="ajax_block_product col-sm-12">
            {* Product hover effect *}
            {$imginfo = Image::getImages(Language::getIdByIso($lang_iso),$product.id_product)}
            {assign var='new_idimg' value=''}
            {foreach from=$imginfo item=imgitem}
                {if !$imgitem['cover']}
                    {assign var='new_idimg' value="`$imgitem['id_product']`-`$imgitem['id_image']`"}
                    {break}
                {/if}
            {/foreach}
			<div class="product-container" itemscope itemtype="http://schema.org/Product">
				<div class="left-block">
					<div class="product-image-container">
						<a class="product_img_link"	href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}" itemprop="url">
							<img class="replace-2x img-responsive" src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'home_default')|escape:'html':'UTF-8'}" alt="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" title="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" {if isset($homeSize)} width="{$homeSize.width}" height="{$homeSize.height}"{/if} itemprop="image" />
						</a>
						{if isset($quick_view) && $quick_view}
						<a class="quick-view" href="{$product.link|escape:'html':'UTF-8'}" data-rel="{$product.link|escape:'html':'UTF-8'}">
							<span><i class="fa fa-search"></i>{l s='Quick view'}</span>
						</a>
						{/if}
                        {if isset($product.specific_prices.reduction) && $product.specific_prices.reduction}
                            {if $product.specific_prices.reduction_type == 'percentage'}                                                    
                                <span class="label-icon sale-label">-{$product.specific_prices.reduction * 100}%</span>
                            {else}
                                <span class="label-icon sale-label">
                                    -{convertPrice price=$product.specific_prices.reduction|intval}
                                </span>                                                
                            {/if}
                        {else}
                            {if isset($product.on_sale) && $product.on_sale == 1}
                                <span class="label-icon sale-label">{l s='Sale'}</span>
                            {/if}
                        {/if}
                        {if isset($product.new) && $product.new == 1}
                            <span class="label-icon new-label{if (isset($product.specific_prices.reduction) && $product.specific_prices.reduction) || (isset($product.on_sale) && $product.on_sale == 1)} second-label{/if}">{l s='New'}</span>
    					{/if}
                        {*}                                                
						{if isset($product.new) && $product.new == 1}
							<a class="new-box" href="{$product.link|escape:'html':'UTF-8'}">
								<span class="new-label">{l s='New'}</span>
							</a>
						{/if}
						{if isset($product.on_sale) && $product.on_sale && isset($product.show_price) && $product.show_price && !$PS_CATALOG_MODE}
							<a class="sale-box{if isset($product.new) && !$product.new} no-new{/if}" href="{$product.link|escape:'html':'UTF-8'}">
								<span class="sale-label">{l s='Sale!'}</span>
							</a>
						{/if}
                        {*}                        
					</div>
					{hook h="displayProductDeliveryTime" product=$product}
					{hook h="displayProductPriceBlock" product=$product type="weight"}
				</div>
				<div class="right-block">
					{hook h='displayProductListReviews' product=$product}
                    <h5 itemprop="name">
						{if isset($product.pack_quantity) && $product.pack_quantity}{$product.pack_quantity|intval|cat:' x '}{/if}
						<a class="product-name" href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}" itemprop="url" >
							{$product.name|truncate:32:''|escape:'html':'UTF-8'}
						</a>
					</h5>
					<p class="product-desc" itemprop="description">
						{$product.description_short|strip_tags:'UTF-8'|truncate:36:''}
					</p>
                    <p class="product-desc-list" itemprop="description">
						{$product.description_short|strip_tags:'UTF-8'}
					</p>
                    <div class="clearfix product-price-info">
    					{if (!$PS_CATALOG_MODE AND ((isset($product.show_price) && $product.show_price) || (isset($product.available_for_order) && $product.available_for_order)))}
    					<div itemprop="offers" itemscope itemtype="http://schema.org/Offer" class="content_price pull-left">
    						{if isset($product.show_price) && $product.show_price && !isset($restricted_country_mode)}
    							<meta itemprop="priceCurrency" content="{$currency->iso_code}" />
    		                      <span itemprop="price" class="price product-price">
        								{if !$priceDisplay}{convertPrice price=$product.price}{else}{convertPrice price=$product.price_tax_exc}{/if}
    							  </span>
                                {if isset($product.specific_prices) && $product.specific_prices && isset($product.specific_prices.reduction) && $product.specific_prices.reduction > 0}
    								{hook h="displayProductPriceBlock" product=$product type="old_price"}
    								<span class="old-price product-price">
    									{displayWtPrice p=$product.price_without_reduction}
    								</span>
    								{hook h="displayProductPriceBlock" id_product=$product.id_product type="old_price"}
    								{if $product.specific_prices.reduction_type == 'percentage'}
    									<span class="price-percent-reduction">-{$product.specific_prices.reduction * 100}%</span>
    								{/if}
    							{/if}
    
    							{hook h="displayProductPriceBlock" product=$product type="price"}
    							{hook h="displayProductPriceBlock" product=$product type="unit_price"}
    						{/if}
    					</div>
                        
    					{/if}
                        <div class="pull-right addtocart_button">
                        {if ($product.id_product_attribute == 0 || (isset($add_prod_display) && ($add_prod_display == 1))) && $product.available_for_order && !isset($restricted_country_mode) && $product.minimal_quantity <= 1 && $product.customizable != 2 && !$PS_CATALOG_MODE}
    						{if (!isset($product.customization_required) || !$product.customization_required) && ($product.allow_oosp || $product.quantity > 0)}
    							{if isset($static_token)}
    								<a class="button ajax_add_to_cart_button btn btn-default" href="{$link->getPageLink('cart',false, NULL, "add=1&amp;id_product={$product.id_product|intval}&amp;token={$static_token}", false)|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='Add to cart'}" data-id-product="{$product.id_product|intval}">
    									<i class="fa fa-shopping-cart"></i>&nbsp;&nbsp;<span>{l s='Add to cart'}</span>
    								</a>
    							{else}
    								<a class="button ajax_add_to_cart_button btn btn-default" href="{$link->getPageLink('cart',false, NULL, 'add=1&amp;id_product={$product.id_product|intval}', false)|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='Add to cart'}" data-id-product="{$product.id_product|intval}">
    									<i class="fa fa-shopping-cart"></i>&nbsp;&nbsp;<span>{l s='Add to cart'}</span>
    								</a>
    							{/if}
    						{else}
    							<span class="button ajax_add_to_cart_button btn btn-default disabled">
    								<i class="fa fa-shopping-cart"></i>&nbsp;&nbsp;<span>{l s='Add to cart'}</span>
    							</span>
    						{/if}
    					{/if}
                        </div>
                    </div>
                    
					{if isset($product.color_list)}
						<div class="color-list-container">{$product.color_list}</div>
					{/if}
					
                    <div class="product-flags hidden">
						{if (!$PS_CATALOG_MODE AND ((isset($product.show_price) && $product.show_price) || (isset($product.available_for_order) && $product.available_for_order)))}
							{if isset($product.online_only) && $product.online_only}
								<span class="online_only">{l s='Online only'}</span>
							{/if}
						{/if}
						{if isset($product.on_sale) && $product.on_sale && isset($product.show_price) && $product.show_price && !$PS_CATALOG_MODE}
							{elseif isset($product.reduction) && $product.reduction && isset($product.show_price) && $product.show_price && !$PS_CATALOG_MODE}
								<span class="discount">{l s='Reduced price!'}</span>
							{/if}
					</div>
					{if (!$PS_CATALOG_MODE && $PS_STOCK_MANAGEMENT && ((isset($product.show_price) && $product.show_price) || (isset($product.available_for_order) && $product.available_for_order)))}
						{if isset($product.available_for_order) && $product.available_for_order && !isset($restricted_country_mode)}
							<span itemprop="offers" itemscope itemtype="http://schema.org/Offer" class="availability">
                                <span class="availability-text">{l s='Availability:'}</span>
								{if ($product.allow_oosp || $product.quantity > 0)}
									<span class="{if $product.quantity <= 0 && !$product.allow_oosp}out-of-stock{else}available-now{/if}">
										<link itemprop="availability" href="http://schema.org/InStock" />{if $product.quantity <= 0}{if $product.allow_oosp}{if isset($product.available_later) && $product.available_later}{$product.available_later}{else}{l s='In Stock'}{/if}{else}{l s='Out of stock'}{/if}{else}{if isset($product.available_now) && $product.available_now}{$product.available_now}{else}{l s='In Stock'}{/if}{/if}
									</span>
								{elseif (isset($product.quantity_all_versions) && $product.quantity_all_versions > 0)}
									<span class="available-dif">
										<link itemprop="availability" href="http://schema.org/LimitedAvailability" />{l s='Product available with different options'}
									</span>
								{else}
									<span class="out-of-stock">
										<link itemprop="availability" href="http://schema.org/OutOfStock" />{l s='Out stock'}
									</span>
								{/if}
							</span>
						{/if}
					{/if}
	 				<div class="functional-buttons clearfix">
                        {hook h='displayProductListFunctionalButtons' product=$product}                    
						{if isset($comparator_max_item) && $comparator_max_item}
							<div class="compare">
								<a class="add_to_compare" title="{l s="Add to compare"}" href="{$product.link|escape:'html':'UTF-8'}" data-id-product="{$product.id_product}"><i class="fa-compress"></i><span class="visible-list">{l s='Add to compare'}</span></a>
							</div>
						{/if}
					</div>
				</div>
			</div><!-- .product-container> -->
		</li>
        </ul>
	{/foreach}
{addJsDefL name=min_item}{l s='Please select at least one product' js=1}{/addJsDefL}
{addJsDefL name=max_item}{l s='You cannot add more than %d product(s) to the product comparison' sprintf=$comparator_max_item js=1}{/addJsDefL}
{addJsDef comparator_max_item=$comparator_max_item}
{addJsDef comparedProductsIds=$compared_products}
{/if}
