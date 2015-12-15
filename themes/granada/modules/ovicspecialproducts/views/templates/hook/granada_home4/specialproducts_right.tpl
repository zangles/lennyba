<div id="sale-products_block_right" class="block products_block">
	<h4 class="title_block">{l s='Special products' mod='ovicspecialproducts'}</h4>
	<div class="block_content">
	{if $special_products !== false}
		<div class="right-product-list">
            {foreach from=$special_products item=saleproduct name=myLoop}

            {$imginfo = Image::getImages(Language::getIdByIso($lang_iso),$saleproduct.id_product)}
            {assign var='new_idimg' value=''}
            {foreach from=$imginfo item=imgitem}
                {if !$imgitem['cover']}
                    {assign var='new_idimg' value="`$imgitem['id_product']`-`$imgitem['id_image']`"}
                    {break}
                {/if}
            {/foreach}
            <div class="product-item">
                <a class="products-block-image" href="{$saleproduct.link|escape:'html':'UTF-8'}">
                    <img 
                    class="replace-2x img-responsive first-img" 
                    src="{$link->getImageLink($saleproduct.link_rewrite, $saleproduct.id_image, 'home_default')|escape:'html':'UTF-8'}" 
                    alt="{if !empty($saleproduct.legend)}{$saleproduct.legend|escape:'html':'UTF-8'}{else}{$saleproduct.name|escape:'html':'UTF-8'}{/if}" 
                    title="{$saleproduct.name|escape:'html':'UTF-8'}" />
                    {if !empty($new_idimg)}
                        <img class="replace-2x img-responsive second-img" src="{$link->getImageLink($saleproduct.link_rewrite, $new_idimg, 'home_default')|escape:'html':'UTF-8'}" alt="{if !empty($saleproduct.legend)}{$saleproduct.legend|escape:'html':'UTF-8'}{else}{$saleproduct.name|escape:'html':'UTF-8'}{/if}" title="{if !empty($saleproduct.legend)}{$saleproduct.legend|escape:'html':'UTF-8'}{else}{$saleproduct.name|escape:'html':'UTF-8'}{/if}" {if isset($homeSize)} width="{$homeSize.width}" height="{$homeSize.height}"{/if} itemprop="image" />
                    {else}
                        <img class="replace-2x img-responsive second-img" src="{$link->getImageLink($saleproduct.link_rewrite, $saleproduct.id_image, 'home_default')|escape:'html':'UTF-8'}" alt="{if !empty($saleproduct.legend)}{$saleproduct.legend|escape:'html':'UTF-8'}{else}{$saleproduct.name|escape:'html':'UTF-8'}{/if}" title="{if !empty($saleproduct.legend)}{$saleproduct.legend|escape:'html':'UTF-8'}{else}{$saleproduct.name|escape:'html':'UTF-8'}{/if}" {if isset($homeSize)} width="{$homeSize.width}" height="{$homeSize.height}"{/if} itemprop="image" />
                    {/if}
                </a>
                <div class="product-content">
                	<h5>
                        <a class="product-name" href="{$saleproduct.link|escape:'html':'UTF-8'}" title="{$saleproduct.name|escape:'html':'UTF-8'}">
                            {$saleproduct.name|escape:'html':'UTF-8'}
                        </a>
                    </h5>
                    <div class="price-box">
                    	{if !$PS_CATALOG_MODE}
                            <span class="old-price">
                                {if !$priceDisplay}
                                    {displayWtPrice p=$saleproduct.price_without_reduction}
                                {/if}
                            </span>
                        	<span class="price special-price">
                                {if !$priceDisplay}
                                    {displayWtPrice p=$saleproduct.price}{else}{displayWtPrice p=$saleproduct.price_tax_exc}
                                {/if}
                            </span>
                             {if $saleproduct.specific_prices}
                                {assign var='specific_prices' value=$saleproduct.specific_prices}
                                {if $specific_prices.reduction_type == 'percentage' && ($specific_prices.from == $specific_prices.to OR ($smarty.now|date_format:'%Y-%m-%d %H:%M:%S' <= $specific_prices.to && $smarty.now|date_format:'%Y-%m-%d %H:%M:%S' >= $specific_prices.from))}
                                    <span class="price-percent-reduction">-{$specific_prices.reduction*100|floatval}%</span>
                                {/if}
                            {/if}
                             
                        {/if}
                    </div>
                </div>
            </div>
            {/foreach}
        </div>
	{else}
		<p>&raquo; {l s='Do not allow special products at this time.' mod='ovicspecialproducts'}</p>
	{/if}
	</div>
</div>