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
	<!-- Products list -->
    {if $hide_left_column xor $hide_right_column}
        {assign var='ulwidth' value="column3"}
    {else}
        {if $hide_left_column and $hide_right_column}
            {assign var='ulwidth' value="column4"}
        {else}
            {assign var='ulwidth' value="column2"}
        {/if}
    {/if}

    	{assign var='itemWidth' value=8}

    {if !isset($productPerRow)}
    	{assign var='productPerRow' value=3}	
    {/if}
    {assign var='group_count' value=3}    
    <div {if isset($id) && $id} id="{$id}"{/if} class="product_list category-grid" data-item-width="{$itemWidth}" data-product-per-row="{$productPerRow}" >
    	<div class="row">
    		{foreach from=$products item=product name=products}
    		{if (bool)Configuration::get('PS_DISABLE_OVERRIDES')}
    			{assign  var='over' value=0}
    		{else}
    			{assign  var='over' value=1}
    			{assign  var='rate' value=Product::getRatings($product.id_product)}
    		{/if}
    		
    		{$imginfo = Image::getImages(Language::getIdByIso($lang_iso),$product.id_product)}
            {assign var='new_idimg' value=''}
            {foreach from=$imginfo item=imgitem}
                {if !$imgitem['cover']}
                    {assign var='new_idimg' value="`$imgitem['id_product']`-`$imgitem['id_image']`"}
                    {break}
                {/if}
            {/foreach}
            {assign var='topLeft' value=false}
            {assign var='topRight' value=false}
    		<div class="col-sm-{$itemWidth} md-margin2x" itemscope itemtype="http://schema.org/Product">
    			<div class="product">               
                  <div class="product-top">						
						{if $PS_STOCK_MANAGEMENT && isset($product.available_for_order) && $product.available_for_order && !isset($restricted_country_mode)}
							{if $product.quantity <= 0}
								{if (isset($product.quantity_all_versions) && $product.quantity_all_versions > 0)}
									<link itemprop="availability" href="http://schema.org/LimitedAvailability" />
									<span class="outofstock-box top-left">{l s='Not available' mod='simplecategory'}</span>
								{else}
									<link itemprop="availability" href="http://schema.org/OutOfStock" />
									<span class="outofstock-box top-left">{l s='Out of' mod='simplecategory'}<span>{l s='Stock' mod='simplecategory'}</span></span>
								{/if}
							{else}
								{if isset($product.specific_prices.reduction) && $product.specific_prices.reduction}
			                        {if $product.specific_prices.reduction_type == 'percentage'}   
			                        	{assign var='topLeft' value=true}
			                        	<span class="discount-box top-left">-{$product.specific_prices.reduction * 100}%</span>
			                        {/if}
			                    {else}
			                        {if isset($product.on_sale) && $product.on_sale == 1}
			                        	{assign var='topLeft' value=true}
			                        	<span class="discount-box top-left">{l s='Sale'}</span>
			                        {/if}
			                    {/if}
			                    {if isset($product.new) && $product.new == 1}
			                        <span class="new-box {if $topLeft == true}top-right{else}top-left{/if}">{l s='New'}</span>
								{/if}
							{/if}
						{else}
							{if isset($product.specific_prices.reduction) && $product.specific_prices.reduction}
		                        {if $product.specific_prices.reduction_type == 'percentage'}   
		                        	{assign var='topLeft' value=true}
		                        	<span class="discount-box top-left">-{$product.specific_prices.reduction * 100}%</span>
		                        {/if}
		                    {else}
		                        {if isset($product.on_sale) && $product.on_sale == 1}
		                        	{assign var='topLeft' value=true}
		                        	<span class="discount-box top-left">{l s='Sale'}</span>
		                        {/if}
		                    {/if}
		                    {if isset($product.new) && $product.new == 1}
		                        <span class="new-box {if $topLeft == true}top-right{else}top-left{/if}">{l s='New'}</span>
							{/if}								
						{/if}
                     <figure class="product-image-container">
                     	<a href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}" itemprop="url">
			        		<img class="product-image" src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'home_default')|escape:'html':'UTF-8'}" alt="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" title="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" {if isset($homeSize)} width="{$homeSize.width}" height="{$homeSize.height}"{/if} itemprop="image" />
			        		{if !empty($new_idimg)}
			                    <img class="product-image-hover" src="{$link->getImageLink($product.link_rewrite, $new_idimg, 'home_default')|escape:'html':'UTF-8'}" alt="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" title="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" {if isset($homeSize)} width="{$homeSize.width}" height="{$homeSize.height}"{/if} itemprop="image" />
			                {else}
			                    <img class="product-image-hover" src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'home_default')|escape:'html':'UTF-8'}" alt="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" title="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" {if isset($homeSize)} width="{$homeSize.width}" height="{$homeSize.height}"{/if} itemprop="image" />
			                {/if}				            		
			        	</a>                     		
                     </figure>
                     <div class="product-action-container">
                        <div class="product-action-wrapper action-responsive">                        	
                        	{if ($product.id_product_attribute == 0 || (isset($add_prod_display) && ($add_prod_display == 1))) && $product.available_for_order && !isset($restricted_country_mode) && $product.customizable != 2 && !$PS_CATALOG_MODE}
								{if (!isset($product.customization_required) || !$product.customization_required) && ($product.allow_oosp || $product.quantity > 0)}
									{capture}add=1&amp;id_product={$product.id_product|intval}{if isset($static_token)}&amp;token={$static_token}{/if}{/capture}
									<a class="ajax_add_to_cart_button product-add-btn" href="{$link->getPageLink('cart', true, NULL, $smarty.capture.default, false)|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='Add to cart'}" data-id-product="{$product.id_product|intval}" data-minimal_quantity="{if isset($product.product_attribute_minimal_quantity) && $product.product_attribute_minimal_quantity > 1}{$product.product_attribute_minimal_quantity|intval}{else}{$product.minimal_quantity|intval}{/if}">
										<span class="add-btn-text">{l s='Add to Cart' mod='simplecategory'}</span> <span class="product-btn product-cart">{l s='Cart' mod='simplecategory'}</span>
									</a>
								{else}
									<span class="ajax_add_to_cart_button product-add-btn disabled">
										<span class="add-btn-text">{l s='Add to Cart' mod='simplecategory'}</span> <span class="product-btn product-cart">{l s='Cart' mod='simplecategory'}</span>
									</span>
								{/if}
							{/if}
							
	                        {if isset($quick_view) && $quick_view}
	                        	<a href="javascript:void(0)" title="{l s='Quick view'}" data-rel="{$product.link|escape:'html':'UTF-8'}" class="quick-view product-btn product-search"></a>
							{/if} 	                        
	                        {hook h='displayProductListFunctionalButtons' product=$product}	                        
							{if isset($comparator_max_item) && $comparator_max_item}
								<a href="{$product.link|escape:'html':'UTF-8'}" title="{l s='Add to compare'}" class="add_to_compare link-compare product-btn product-compare" data-id-product="{$product.id_product}"></a>
							  <!-- <a class="add_to_compare product-btn link-compare" title="{l s='Add to compare'}" href="{$product.link|escape:'html':'UTF-8'}" data-id-product="{$product.id_product}">{l s='Add to compare'}</a> -->
							{/if}
                        </div>
                     </div>
                  </div>
                  
                  <h3 class="product-name" itemprop="name">
                  	<a href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}" itemprop="url" >
						{$product.name|truncate:32:''|escape:'html':'UTF-8'}
					</a>
                  </h3>
                  <div class="ratings-container">
                  	{if $over == 1}
	                  	<div class="ratings" itemprop="aggregateRating" itemscope="" itemtype="http://schema.org/AggregateRating">
		                	<div class="ratings-result" data-result="{$rate.avg}"></div>
		                	<meta itemprop="worstRating" content="{$rate.min}">
		                	<meta itemprop="ratingValue" content="{$rate.avg}">
		                	<meta itemprop="bestRating" content="{$rate.max}">
		                	<meta itemprop="reviewCount" content="{$rate.review}">
		              	</div>
		              	<!-- <span class="ratings-amount">{$rate.review} review(s)</span> -->
                  	{else}
                  		{hook h='displayProductListReviews' product=$product}
                  	{/if}
					
					</div>
					<p class="product-desc" itemprop="description">
						{$product.description_short|strip_tags:'UTF-8'|truncate:360:'...'}
					</p>
                  <div class="product-price-container">
						{if isset($product.show_price) && $product.show_price && !isset($restricted_country_mode)}
							<meta itemprop="priceCurrency" content="{$currency->iso_code}" />
			                {if isset($product.specific_prices) && $product.specific_prices && isset($product.specific_prices.reduction) && $product.specific_prices.reduction > 0}
								{hook h="displayProductPriceBlock" product=$product type="old_price"}
			                    <span class="product-old-price">{displayWtPrice p=$product.price_without_reduction}</span>
			                    <span class="product-price" itemprop="price">{if !$priceDisplay}{convertPrice price=$product.price}{else}{convertPrice price=$product.price_tax_exc}{/if}</span>                                            
			                {else}
			                    <span class="product-price" itemprop="price">
			                        {if !$priceDisplay}{convertPrice price=$product.price}{else}{convertPrice price=$product.price_tax_exc}{/if}                                    
			                    </span>
			                {/if}
						{/if}
                  </div>
				</div>
            </div>
            {if ($smarty.foreach.products.index % $productPerRow == ($productPerRow -1)) && !$smarty.foreach.products.last} 
				</div>
				<div class="row"> 
			{/if}
    		{/foreach}
    	</div>
    </div>
{addJsDefL name=min_item}{l s='Please select at least one product' js=1}{/addJsDefL}
{addJsDefL name=max_item}{l s='You cannot add more than %d product(s) to the product comparison' sprintf=$comparator_max_item js=1}{/addJsDefL}
{addJsDef comparator_max_item=$comparator_max_item}
{addJsDef comparedProductsIds=$compared_products}
{/if}
