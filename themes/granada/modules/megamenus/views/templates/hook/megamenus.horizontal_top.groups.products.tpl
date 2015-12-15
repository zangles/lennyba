<div class="col-md-{$width} {$custom_class}">
	{if $display_title == '1'}
		<h5 class="group-title megamenu-title">{$name}</h5>
	{/if}
	{if isset($megamenus_products) && $megamenus_products|@count >0}
		<div class="megamenus-group-products clearfix">
	        {assign var='products_totalwidth' value=0}
	        {foreach from=$megamenus_products item=product name=products}
	            {assign var='products_totalwidth' value=$products_totalwidth+$item_width}            
	            {if $products_totalwidth > 12 && !$smarty.foreach.products.last}             
	                <div class="clearfix"></div>                
	                {assign var='products_totalwidth' value=0}            
	            {/if}                                                                         
	            <!-- product-container -->
	            <div class="product-container col-sm-{$item_width}" itemscope itemtype="http://schema.org/Product">
	                <div class="left-block">
	                    <div class="product-image-container">
	                        <a class="product_img_link" href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}" itemprop="url">
	                            <img class="replace-2x img-responsive" src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'home_default')|escape:'html':'UTF-8'}" alt="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" title="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" {if isset($homeSize)} width="{$homeSize.width}" height="{$homeSize.height}"{/if} itemprop="image" />
	                        </a>                                                                                       
	                        {if isset($product.new) && $product.new == 1}
	                            <a class="new-box" href="{$product.link|escape:'html':'UTF-8'}">
	                                <span class="new-label">{l s='New'}</span>
	                            </a>
	                        {/if}
	                        {if isset($product.on_sale) && $product.on_sale && isset($product.show_price) && $product.show_price && !$PS_CATALOG_MODE}
	                            <a class="sale-box" href="{$product.link|escape:'html':'UTF-8'}">
	                                <span class="sale-label">{l s='Sale!'}</span>
	                            </a>
	                        {/if}
	                    </div>                                                                                    
	                </div>
	                <div class="right-block">
	                    <h5 itemprop="name">
	                        {if isset($product.pack_quantity) && $product.pack_quantity}{$product.pack_quantity|intval|cat:' x '}{/if}
	                        <a class="product-name" href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}" itemprop="url" >
	                            {$product.name|truncate:45:'...'|escape:'html':'UTF-8'}
	                        </a>
	                    </h5>
	                    
	                    {if (!$PS_CATALOG_MODE AND ((isset($product.show_price) && $product.show_price) || (isset($product.available_for_order) && $product.available_for_order)))}
	                    <div itemprop="offers" itemscope itemtype="http://schema.org/Offer" class="content_price">
	                        {if isset($product.show_price) && $product.show_price && !isset($restricted_country_mode)}
	                            <span itemprop="price" class="price product-price">
	                                {if !$priceDisplay}{convertPrice price=$product.price}{else}{convertPrice price=$product.price_tax_exc}{/if}
	                            </span>
	                            <meta itemprop="priceCurrency" content="{$currency->iso_code}" />
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
	                </div>                                                                                
	            </div>
	            <!-- end product-container -->                                                                            
	        {/foreach}
	    </div> 
	{/if}
</div>