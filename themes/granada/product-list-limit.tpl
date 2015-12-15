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
	<ul{if isset($id) && $id} id="{$id}"{/if} class="product_list products-grid grid-type-1 {$ulwidth} row{if isset($class) && $class} {$class}{/if}">
	{foreach from=$products item=product name=products}
        {if (isset($limit_item) && ($smarty.foreach.products.index == $limit_item))}
            {break}
        {/if}
        <li class="ajax_block_product item{if $smarty.foreach.products.index%2 == 0} nth-child-2np1{else} nth-child-2n{/if}{if $smarty.foreach.products.iteration%3 == 0} nth-child-3n{elseif $smarty.foreach.products.index%3 == 0} nth-child-3np1{/if}{if $smarty.foreach.products.iteration%4 == 0} nth-child-4n{elseif $smarty.foreach.products.index%4 == 0} nth-child-4np1{/if}{if $smarty.foreach.products.iteration%5 == 0} nth-child-5n{elseif $smarty.foreach.products.index%5 == 0} nth-child-5np1{/if}{if $smarty.foreach.products.iteration%6 == 0} nth-child-6n{elseif $smarty.foreach.products.index%6 == 0} nth-child-6np1{/if}">
            {* Product hover effect *}
            <div itemscope itemtype="http://schema.org/Product">
                {$imginfo = Image::getImages(Language::getIdByIso($lang_iso),$product.id_product)}
                {assign var='new_idimg' value=''}
                {foreach from=$imginfo item=imgitem}
                    {if !$imgitem['cover']}
                        {assign var='new_idimg' value="`$imgitem['id_product']`-`$imgitem['id_image']`"}
                        {break}
                    {/if}
                {/foreach}
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
                  <div class="actions">
                     <div class="actions-wrapper">
                        {if ($product.id_product_attribute == 0 || (isset($add_prod_display) && ($add_prod_display == 1))) && $product.available_for_order && !isset($restricted_country_mode) && $product.minimal_quantity <= 1 && $product.customizable != 2 && !$PS_CATALOG_MODE}
    						{if (!isset($product.customization_required) || !$product.customization_required) && ($product.allow_oosp || $product.quantity > 0)}
    							{if isset($static_token)}
    								<a class="button ajax_add_to_cart_button btn-cart product-add-btn" href="{$link->getPageLink('cart',false, NULL, "add=1&amp;id_product={$product.id_product|intval}&amp;token={$static_token}", false)|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='Add to cart'}" data-id-product="{$product.id_product|intval}">
    									<span><span>{l s='Add to cart'}</span></span>
    								</a>
    							{else}
    								<a class="button ajax_add_to_cart_button btn-cart product-add-btn" href="{$link->getPageLink('cart',false, NULL, 'add=1&amp;id_product={$product.id_product|intval}', false)|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='Add to cart'}" data-id-product="{$product.id_product|intval}">
    									<span><span>{l s='Add to cart'}</span></span>
    								</a>
    							{/if}
    						{else}
    							<span class="button ajax_add_to_cart_button btn-cart product-add-btn disabled">
    								<span><span>{l s='Add to cart'}</span></span>
    							</span>
    						{/if}
    					{/if}
                        {if isset($quick_view) && $quick_view}
						  <a class="quick-view sw-product-quickview product-btn" href="{$product.link|escape:'html':'UTF-8'}" rel="{$product.link|escape:'html':'UTF-8'}">{l s='Quick view'}</a>
						{/if}
                        {hook h='displayProductListFunctionalButtons' product=$product}                    
						{if isset($comparator_max_item) && $comparator_max_item}
						  <a class="add_to_compare product-btn link-compare" title="{l s="Add to compare"}" href="{$product.link|escape:'html':'UTF-8'}" data-id-product="{$product.id_product}">{l s='Add to compare'}</a>
						{/if}
                     </div> 
                  </div>
               </div>
               <h2 itemprop="name" class="product-name">
                {if isset($product.pack_quantity) && $product.pack_quantity}{$product.pack_quantity|intval|cat:' x '}{/if}
				<a href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}" itemprop="url" >
					{$product.name|truncate:32:''|escape:'html':'UTF-8'}
				</a>
               </h2>
               {hook h='displayProductListReviews' product=$product}
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
                <p class="product-desc" itemprop="description">
					{$product.description_short|strip_tags:'UTF-8'|truncate:360:'...'}
				</p>
           </div>
		</li>
	{/foreach}
	</ul>
{addJsDefL name=min_item}{l s='Please select at least one product' js=1}{/addJsDefL}
{addJsDefL name=max_item}{l s='You cannot add more than %d product(s) to the product comparison' sprintf=$comparator_max_item js=1}{/addJsDefL}
{addJsDef comparator_max_item=$comparator_max_item}
{addJsDef comparedProductsIds=$compared_products}
{/if}
