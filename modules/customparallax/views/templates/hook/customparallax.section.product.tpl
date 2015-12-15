{if isset($product) }
<div class="product" itemscope itemtype="http://schema.org/Product">
     <div class="product-top">
        <figure class="product-image-container">
        	<a href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name}" itemprop="url">
        		<img src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'home_default')|escape:'html':'UTF-8'}" alt="{$product.name}" itemprop="image" />
        	</a>
        </figure>
     </div>
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
     <h3 class="product-name" itemprop="name"><a href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name}" itemprop="url">{$product.name}</a></h3>
     <div class="product-action">
     	{if ($product.id_product_attribute == 0 || (isset($add_prod_display) && ($add_prod_display == 1))) && $product.available_for_order && !isset($restricted_country_mode) && $product.customizable != 2 && !$PS_CATALOG_MODE}
			{if (!isset($product.customization_required) || !$product.customization_required) && ($product.allow_oosp || $product.quantity > 0)}
				{capture}add=1&amp;id_product={$product.id_product|intval}{if isset($static_token)}&amp;token={$static_token}{/if}{/capture}
				<a class="ajax_add_to_cart_button product-add-btn btn-block" href="{$link->getPageLink('cart', true, NULL, $smarty.capture.default, false)|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='Add to cart'}" data-id-product="{$product.id_product|intval}" data-minimal_quantity="{if isset($product.product_attribute_minimal_quantity) && $product.product_attribute_minimal_quantity > 1}{$product.product_attribute_minimal_quantity|intval}{else}{$product.minimal_quantity|intval}{/if}">
					{l s='Add to Cart' mod='customparallax'}
				</a>
			{else}
				<span class="ajax_add_to_cart_button product-add-btn btn-block disabled">
					{l s='ADD to Cart' mod='customparallax'}
				</span>
			{/if}
		{/if}
     </div>
  </div>
{/if}
