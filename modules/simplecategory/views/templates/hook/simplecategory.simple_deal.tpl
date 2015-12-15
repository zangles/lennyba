<div class="home-mixed-products simple-deal {$custom_class}">
    <h2 class="secondary-font" style="color:{$module_color};">{$module_name}</h2>
    <div class="row">
        <div class="col-sm-7">
            <div class="home-product-slider">
                <div class="products-slider items-slider saleproduct column3">
                    <div class="row">
                        {if $module_products &&  $module_products|@count >0}
                        <div class="products-grid column3 products-doubled" style="opacity: 1; display: block;">
                            {assign var='nextItem' value=0}
                            {foreach from=$module_products item=product name=products}
                            {$imginfo = Image::getImages(Language::getIdByIso($lang_iso),$product.id_product)}
                            {assign var='new_idimg' value=''}
                            {foreach from=$imginfo item=imgitem}
                                {if !$imgitem['cover']}
                                    {assign var='new_idimg' value="`$imgitem['id_product']`-`$imgitem['id_image']`"}
                                    {break}
                                {/if}
                            {/foreach}
                            {if $nextItem == 0}
                                <div>
                                    <ul class="products-item">  
                            {/if}
                            <li class="item">
                                <div itemscope itemtype="http://schema.org/Product">                    
                                    <div class="product-image-wrapper">
                                        {if isset($product.on_sale) && $product.on_sale == 1}
                                            <span class="label-icon sale-label">{l s='Sale'}</span>
                                        {/if}
                                        {if isset($product.new) && $product.new == 1}
                                            <span class="label-icon new-label{if isset($product.on_sale) && $product.on_sale == 1} second-label{/if}">{l s='New'}</span>
                    					{/if}
                                        <a href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}" class="product-image alt-image-effect">
                                            <img class="cat-main-img" src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'home_default')|escape:'html':'UTF-8'}" alt="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" title="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" {if isset($homeSize)} width="{$homeSize.width}" height="{$homeSize.height}"{/if} itemprop="image" />
                                            {if !empty($new_idimg)}
                                                <img class="alt-image" src="{$link->getImageLink($product.link_rewrite, $new_idimg, 'home_default')|escape:'html':'UTF-8'}" alt="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" title="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" {if isset($homeSize)} width="{$homeSize.width}" height="{$homeSize.height}"{/if} itemprop="image" />
                                            {else}
                                                <img class="alt-image" src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'home_default')|escape:'html':'UTF-8'}" alt="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" title="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" {if isset($homeSize)} width="{$homeSize.width}" height="{$homeSize.height}"{/if} itemprop="image" />
                                            {/if}
                                        </a>                                        
                                    </div>
                                    
                                    <h2 itemprop="name" class="product-name">
                                        {if isset($product.pack_quantity) && $product.pack_quantity}{$product.pack_quantity|intval|cat:' x '}{/if}
                        				<a href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}" itemprop="url" >
                        					{$product.name|truncate:32:''|escape:'html':'UTF-8'}
                        				</a>
                                   </h2>
                                   <div class="price-box" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                                        {if isset($product.show_price) && $product.show_price && !isset($restricted_country_mode)}
                    						<meta itemprop="priceCurrency" content="{$currency->iso_code}" />
                                            {if isset($product.specific_prices) && $product.specific_prices && isset($product.specific_prices.reduction) && $product.specific_prices.reduction > 0}
                    							{hook h="displayProductPriceBlock" product=$product type="old_price"}
                                                <p class="old-price">
                                                    <span class="price">
                                                        {displayWtPrice p=$product.price_without_reduction}
                                                    </span>
                                                </p>							
                                                <p class="special-price" itemprop="price">
                                                    <span class="price">
                                                        {if !$priceDisplay}{convertPrice price=$product.price}{else}{convertPrice price=$product.price_tax_exc}{/if}
                                                    </span>
                                                </p>
                                            {else}
                                                <span class="regular-price" itemprop="price">
                                                    <span class="price">{if !$priceDisplay}{convertPrice price=$product.price}{else}{convertPrice price=$product.price_tax_exc}{/if}</span>                                    
                                                </span>
                                            {/if}
                    					{/if}
                                    </div>                                                       
                               </div>                            
                            </li> 
                            {assign var='nextItem' value=$nextItem + 1}
                            {if $smarty.foreach.products.last}
                                {assign var='nextItem' value=0}
                                    </ul>
                                </div>
                            {else}
                                {if $nextItem == 2}
                                    {assign var='nextItem' value=0}
                                        </ul>
                                    </div>
                                {/if}
                            {/if}                            
                            {/foreach}
                            
                        </div>
                        
                        
                        
                        
                        {/if}
                        
                    </div>
                </div>
            </div>
            
        </div>
        <div class="col-sm-5 simplecategory-description-product">{$module_description}</div>
    </div>
</div>
{addJsDefL name=txt_years}{l s='years' mod='simplecategory' js=1}{/addJsDefL}
{addJsDefL name=txt_month}{l s='month' mod='simplecategory' js=1}{/addJsDefL}
{addJsDefL name=txt_weeks}{l s='weeks' mod='simplecategory' js=1}{/addJsDefL}
{addJsDefL name=txt_days}{l s='days' mod='simplecategory' js=1}{/addJsDefL}
{addJsDefL name=txt_hours}{l s='hours' mod='simplecategory' js=1}{/addJsDefL}
{addJsDefL name=txt_min}{l s='min' mod='simplecategory' js=1}{/addJsDefL}
{addJsDefL name=txt_sec}{l s='sec' mod='simplecategory' js=1}{/addJsDefL}