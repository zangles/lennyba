{if !isset($group_count)} 
	{assign  var='group_count' value=3}
{/if}
{if !isset($col_item)} 
	{assign  var='col_item' value=3}
{/if}

<div class="product-group"> 
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
							
	<div class="product clearfix" itemscope itemtype="http://schema.org/Product">
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
        <div class="product-content">
           <h3 class="product-name" itemprop="name">
           		<a href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}" itemprop="url">{$product.name|escape:'html':'UTF-8'}</a>
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
	              	{*}
	              	{if isset($view_rate_total) && $view_rate_total == 1}
	              	<div class="ratings-amount">{$rate.review} review(s)</div>
	              	{/if}
	              	{*}
              	{else}
              		{hook h='displayProductListReviews' product=$product}
              	{/if}              	
			</div>
			<div class="product-price-container" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
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
     {if ($smarty.foreach.products.index % $group_count == ($group_count -1)) && !$smarty.foreach.products.last} 
		</div>
		<div class="product-group"> 
	{/if}	
{/foreach}				
</div>