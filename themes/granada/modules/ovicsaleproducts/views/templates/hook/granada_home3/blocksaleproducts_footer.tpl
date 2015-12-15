    <div class="col-sm-4">
       <h3 class="footer-title">{l s='Sale products' mod='ovicsaleproducts'}</h3>
       {if $sale_products !== false}
       <ul class="footer-products-list">
          {foreach from=$sale_products item=saleproduct name=myLoop}
          <li itemscope itemtype="http://schema.org/Product">
             <a href="{$saleproduct.link|escape:'html'}" title="{if !empty($saleproduct.legend)}{$saleproduct.legend|escape:'html':'UTF-8'}{else}{$saleproduct.name|escape:'html':'UTF-8'}{/if}">
             <img src="{$link->getImageLink($saleproduct.link_rewrite, $saleproduct.id_image, 'cart_default')|escape:'html'}" alt="{$saleproduct.name|escape:html:'UTF-8'}"/>
             {$saleproduct.name|strip_tags|escape:html:'UTF-8'}
             </a>
             {hook h='displayProductListReviews' product=$saleproduct}
             <div class="price-box">
                {if isset($saleproduct.specific_prices) && $saleproduct.specific_prices && isset($saleproduct.specific_prices.reduction) && $saleproduct.specific_prices.reduction > 0}
                    <p class="old-price">
                        <span class="price">
                            {displayWtPrice p=$saleproduct.price_without_reduction}
                        </span>
                    </p>							
                    <p class="special-price" itemprop="price">
                        <span class="price">
                            {if !$priceDisplay}{convertPrice price=$saleproduct.price}{else}{convertPrice price=$saleproduct.price_tax_exc}{/if}
                        </span>
                    </p>
                {else}
                    <span class="regular-price" itemprop="price">
                        <span class="price">{if !$priceDisplay}{convertPrice price=$saleproduct.price}{else}{convertPrice price=$saleproduct.price_tax_exc}{/if}</span>                                    
                    </span>
                {/if}
            </div>
            <div class="clearfix"></div>
          </li>
          {if $smarty.foreach.myLoop.iteration == 3}
            {break}
          {/if}
          {/foreach}
       </ul>
       {else}
    		<p>&raquo; {l s='Do not allow sale products at this time.' mod='ovicsaleproducts'}</p>
    	{/if}
    </div>