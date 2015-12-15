{if $wishlists}
    <p>
        <strong class="dark">
            {l s='Other wishlists of %1s %2s:' sprintf=[$current_wishlist.firstname, $current_wishlist.lastname] mod='blockwishlist'}
        </strong>
        {foreach from=$wishlists item=wishlist name=i}
            {if $wishlist.id_wishlist != $current_wishlist.id_wishlist}
                <a href="{$link->getModuleLink('blockwishlist', 'view', ['token' => $wishlist.token])|escape:'html':'UTF-8'}" rel="nofollow" title="{$wishlist.name}">
                    {$wishlist.name}
                </a>
                {if !$smarty.foreach.i.last}
                    /
                {/if}
            {/if}
        {/foreach}
    </p>
{/if}

<div class="wlp_bought">
    {assign var='nbItemsPerLine' value=4}
    {assign var='nbItemsPerLineTablet' value=3}
    {assign var='nbLi' value=$products|@count}
    {math equation="nbLi/nbItemsPerLine" nbLi=$nbLi nbItemsPerLine=$nbItemsPerLine assign=nbLines}
    {math equation="nbLi/nbItemsPerLineTablet" nbLi=$nbLi nbItemsPerLineTablet=$nbItemsPerLineTablet assign=nbLinesTablet}
    <ul class="row wlp_bought_list ">
        {foreach from=$products item=product name=i}
            {math equation="(total%perLine)" total=$smarty.foreach.i.total perLine=$nbItemsPerLine assign=totModulo}
            {math equation="(total%perLineT)" total=$smarty.foreach.i.total perLineT=$nbItemsPerLineTablet assign=totModuloTablet}
            {if $totModulo == 0}{assign var='totModulo' value=$nbItemsPerLine}{/if}
            {if $totModuloTablet == 0}{assign var='totModuloTablet' value=$nbItemsPerLineTablet}{/if}
            <li id="wlp_{$product.id_product}_{$product.id_product_attribute}" class="ajax_block_product col-xs-12 col-sm-4 col-md-3 {if $smarty.foreach.i.iteration%$nbItemsPerLine == 0} last-in-line{elseif $smarty.foreach.i.iteration%$nbItemsPerLine == 1} first-in-line{/if} {if $smarty.foreach.i.iteration > ($smarty.foreach.i.total - $totModulo)}last-line{/if} {if $smarty.foreach.i.iteration%$nbItemsPerLineTablet == 0}last-item-of-tablet-line{elseif $smarty.foreach.i.iteration%$nbItemsPerLineTablet == 1}first-item-of-tablet-line{/if} {if $smarty.foreach.i.iteration > ($smarty.foreach.i.total - $totModuloTablet)}last-tablet-line{/if}">
				<div class="row">
					<div class="col-xs-6 col-sm-12">
						<div class="product_image product-image-container">
                            <a href="{$link->getProductlink($product.id_product, $product.link_rewrite, $product.category_rewrite)|escape:'html':'UTF-8'}" title="{l s='Product detail' mod='blockwishlist'}">
								<img class="replace-2x img-responsive" src="{$link->getImageLink($product.link_rewrite, $product.cover, 'home_default')|escape:'html':'UTF-8'}" alt="{$product.name|escape:'html':'UTF-8'}"/>
                            </a>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-12">
						<div class="product_infos">
							<div class="xs-margin"></div>
							<div class="xs-margin"></div>
							<div class="product-name text-left" >
                                {$product.name|truncate:30:'...'|escape:'html':'UTF-8'}
                                {if isset($product.attributes_small)}
                                    <a href="{$link->getProductlink($product.id_product, $product.link_rewrite, $product.category_rewrite)|escape:'html':'UTF-8'}" title="{l s='Product detail' mod='blockwishlist'}">
                                        <small>{$product.attributes_small|escape:'html':'UTF-8'}</small>
                                    </a>
                                {/if}
                            </div>
                            <div><span>{l s='Priority' mod='blockwishlist'}: {$product.priority_name}</span></div>
                            <div class="xs-margin"></div>
                            <div class="wishlist_product_detail">                                                                
                                <div class="product-action-content clearfix btn_action">
                                	{if isset($product.attribute_quantity) AND $product.attribute_quantity >= 1 OR !isset($product.attribute_quantity) AND $product.product_quantity >= 1}
                                        {if !$ajax}
                                            <form id="addtocart_{$product.id_product|intval}_{$product.id_product_attribute|intval}" action="{$link->getPageLink('cart')|escape:'html':'UTF-8'}" method="post">
                                                <p class="hidden">
                                                    <input type="hidden" name="id_product" value="{$product.id_product|intval}" id="product_page_product_id"/>
                                                    <input type="hidden" name="add" value="1"/>
                                                    <input type="hidden" name="token" value="{$token}"/>
                                                    <input type="hidden" name="id_product_attribute" id="idCombination" value="{$product.id_product_attribute|intval}"/>
                                                </p>
                                            </form>
                                        {/if}
                                        <input class="grey product-amount-input" type="text" id="quantity_{$product.id_product}_{$product.id_product_attribute}" value="{$product.quantity|intval}"/>
                                        
                                        <a  href="javascript:void(0);"  class=" ajax_add_to_cart_button product-add-btn button_111_hover"  onclick="WishlistBuyProduct('{$token|escape:'html':'UTF-8'}', '{$product.id_product}', '{$product.id_product_attribute}', '{$product.id_product}_{$product.id_product_attribute}', this, {$ajax});"  title="{l s='Add to cart' mod='blockwishlist'}"  rel="nofollow">
                                            <span class="product-btn product-cart"></span>
                                        </a>
                                    {else}
                                        <span class="button ajax_add_to_cart_button btn btn-default disabled"> <span>{l s='Add to cart' mod='blockwishlist'}</span> </span>
                                    {/if}
                                    <a  class="lnk_view product-view-btn "  href="{$link->getProductLink($product.id_product,  $product.link_rewrite, $product.category_rewrite)|escape:'html':'UTF-8'}"  title="{l s='View' mod='blockwishlist'}" rel="nofollow"> <span class="product-btn product-search button_111_hover"></span></a>
                                    
                                	
                                	 			                
					            </div>			            
                                <!-- .btn_action -->
                            </div>
                            <!-- .wishlist_product_detail -->
                        </div>
                        <!-- .product_infos -->
                    </div>
                </div>
                <div class="xlg-margin"></div>
            </li>
        {/foreach}
    </ul>
</div>
