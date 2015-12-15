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

{if $products}
<div class="accordion" id="collapse">
    {if !$refresh}
    	<div class="xlg-margin"></div>
        <div class="wishlistLinkTop">        	
	        <a id="hideSendWishlist"  href="#" onclick="WishlistVisibility('wishlistLinkTop', 'SendWishlist'); return false;" rel="nofollow" title="{l s='Close this wishlist' mod='blockwishlist'}">
	            <span>{l s='Hide wishlist' mod='blockwishlist'}</span>
	        </a>
			<div class="xs-margin"></div>
			<div class="wishlisturl form-group">
	            <label>{l s='Permalink' mod='blockwishlist'}:</label>&nbsp;&nbsp;<a href="{$link->getModuleLink('blockwishlist', 'view', ['token' => $token_wish])|escape:'html':'UTF-8'}" title="view wishlist" >{$link->getModuleLink('blockwishlist', 'view', ['token' => $token_wish])|escape:'html':'UTF-8'}</a>
	        </div>        
        </div>
    {/if}    
    <div class="accordion-group panel">
	    
	        <h2 class="accordion-title"><span>{l s='Products' mod='blockwishlist'}</span> <a class="accordion-btn" data-toggle="collapse" href="#collapse-one"></a></h2>
	        <div class="accordion-body collapse" id="collapse-one">
	            <div class="accordion-body-wrapper">	                
	                <div class="wlp_bought">
				        {assign var='nbItemsPerLine' value=4}
				        {assign var='nbItemsPerLineTablet' value=3}
				        {assign var='nbLi' value=$products|@count}
				        {math equation="nbLi/nbItemsPerLine" nbLi=$nbLi nbItemsPerLine=$nbItemsPerLine assign=nbLines}
				        {math equation="nbLi/nbItemsPerLineTablet" nbLi=$nbLi nbItemsPerLineTablet=$nbItemsPerLineTablet assign=nbLinesTablet}				        
				        <div class="row wlp_bought_list wishlist-products">
				            {foreach from=$products item=product name=i}
				                {math equation="(total%perLine)" total=$smarty.foreach.i.total perLine=$nbItemsPerLine assign=totModulo}
				                {math equation="(total%perLineT)" total=$smarty.foreach.i.total perLineT=$nbItemsPerLineTablet assign=totModuloTablet}
				                {if $totModulo == 0}{assign var='totModulo' value=$nbItemsPerLine}{/if}
				                {if $totModuloTablet == 0}{assign var='totModuloTablet' value=$nbItemsPerLineTablet}{/if}
				                <div id="wlp_{$product.id_product}_{$product.id_product_attribute}"  class="col-xs-12 col-sm-4 col-md-3 {if $smarty.foreach.i.iteration%$nbItemsPerLine == 0} last-in-line{elseif $smarty.foreach.i.iteration%$nbItemsPerLine == 1} first-in-line{/if} {if $smarty.foreach.i.iteration > ($smarty.foreach.i.total - $totModulo)}last-line{/if} {if $smarty.foreach.i.iteration%$nbItemsPerLineTablet == 0}last-item-of-tablet-line{elseif $smarty.foreach.i.iteration%$nbItemsPerLineTablet == 1}first-item-of-tablet-line{/if} {if $smarty.foreach.i.iteration > ($smarty.foreach.i.total - $totModuloTablet)}last-tablet-line{/if}">
				                    <div class="row">
				                        <div class="col-xs-6 col-sm-12">
				                            <div class="product_image product-image-container">
				                                <a href="{$link->getProductlink($product.id_product, $product.link_rewrite, $product.category_rewrite)|escape:'html':'UTF-8'}" title="{l s='Product detail' mod='blockwishlist'}">
				                                    <img class="replace-2x img-responsive"  src="{$link->getImageLink($product.link_rewrite, $product.cover, 'home_default')|escape:'html':'UTF-8'}" alt="{$product.name|escape:'html':'UTF-8'}"/>
				                                </a>
												<a class="lnkdel close-button" href="javascript:;" onclick="WishlistProductManage('wlp_bought', 'delete', '{$id_wishlist}', '{$product.id_product}', '{$product.id_product_attribute}', $('#quantity_{$product.id_product}_{$product.id_product_attribute}').val(), $('#priority_{$product.id_product}_{$product.id_product_attribute}').val());" title="{l s='Delete' mod='blockwishlist'}"></a>
				                            </div>
				                        </div>
				                        <div class="col-xs-6 col-sm-12">
				                            <div class="product_infos">                                
												<div class="xs-margin"></div>
												<div class="xs-margin"></div>
				                                <div class="product-name text-left">
				                                	<a href="{$link->getProductlink($product.id_product, $product.link_rewrite, $product.category_rewrite)|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}">
				                                    	{$product.name|truncate:30:'...'|escape:'html':'UTF-8'}
				                                    </a>
				                                    {*}
				                                    {if isset($product.attributes_small)}
				                                        <small>
				                                            <a href="{$link->getProductlink($product.id_product, $product.link_rewrite, $product.category_rewrite)|escape:'html':'UTF-8'}" title="{l s='Product detail' mod='blockwishlist'}">
				                                                {$product.attributes_small|escape:'html':'UTF-8'}
				                                            </a>
				                                        </small>
				                                    {/if}
				                                    {*}
				                                </div>
				                                <div class="wishlist_product_detail">				                                	
		                                			<div class="form-group">
				                                        <select id="priority_{$product.id_product}_{$product.id_product_attribute}" class="form-control grey">
				                                            <option value="0"{if $product.priority eq 0} selected="selected"{/if}>
				                                                {l s='High' mod='blockwishlist'}
				                                            </option>
				                                            <option value="1"{if $product.priority eq 1} selected="selected"{/if}>
				                                                {l s='Medium' mod='blockwishlist'}
				                                            </option>
				                                            <option value="2"{if $product.priority eq 2} selected="selected"{/if}>
				                                                {l s='Low' mod='blockwishlist'}
				                                            </option>
				                                        </select>
				                                    </div>						                                   
				                                    <div class="product-action-content clearfix btn_action">
														<input class="grey product-amount-input pull-left" type="text" id="quantity_{$product.id_product}_{$product.id_product_attribute}" value="{$product.quantity|intval}" style="min-width: 120px" />                                        
				                                        <a class="btn btn-default button button-small pull-right"  href="javascript:;" onclick="WishlistProductManage('wlp_bought_{$product.id_product_attribute}', 'update', '{$id_wishlist}', '{$product.id_product}', '{$product.id_product_attribute}', $('#quantity_{$product.id_product}_{$product.id_product_attribute}').val(), $('#priority_{$product.id_product}_{$product.id_product_attribute}').val());" title="{l s='Save' mod='blockwishlist'}">
					                                        <span>{l s='Save' mod='blockwishlist'}</span>
					                                    </a>
													</div>
				                                </div>				                                
				                            </div>
				                        </div>
				                    </div>
				                    <div class="xlg-margin"></div>				                    
				                </div>
				            {/foreach}
				        </div>
				    </div>
	            </div>
	            <div class="lg-margin2x"></div>	            
	        </div>
	</div>
    
    
    
   
    
    {if !$refresh}
    <div class="accordion-group panel">
        
            <h2 class="accordion-title"><span>{l s='Send emails'}</span> <a class="accordion-btn" data-toggle="collapse" href="#collapse-two"></a></h2>
            <div class="accordion-body collapse " id="collapse-two">
                <div class="accordion-body-wrapper">
                    
                        <form method="post" class="wl_send box" onsubmit="return (false);">
				        	<div class="row">
				        		<div class="col-sm-6">
				        			<div class="required form-group">
					                    <label for="email1" class="form-label">{l s='Email' mod='blockwishlist'}1 <sup>*</sup></label>
					                    <input type="text" name="email1" id="email1" class="form-control input-lg"/>
					                </div>	
				        			<div class="form-group">
				                        <label for="email2" class="form-label">{l s='Email' mod='blockwishlist'}2</label>
					                    <input type="text" name="email2" id="email2" class="form-control input-lg"/>
				                    </div>
				                    <div class="form-group">
				                        <label for="email3" class="form-label">{l s='Email' mod='blockwishlist'}3</label>
					                    <input type="text" name="email3" id="email3" class="form-control input-lg"/>
				                    </div>
				                    <div class="form-group">
				                        <label for="email4" class="form-label">{l s='Email' mod='blockwishlist'}4</label>
					                    <input type="text" name="email4" id="email4" class="form-control input-lg"/>
				                    </div>
				                    <div class="form-group">
				                        <label for="email5" class="form-label">{l s='Email' mod='blockwishlist'}5</label>
					                    <input type="text" name="email5" id="email5" class="form-control input-lg"/>
				                    </div>
				                    
				        		</div>
				        		<div class="col-sm-6">
				        			<div class="form-group">
				                        <label for="email6" class="form-label">{l s='Email' mod='blockwishlist'}6</label>
					                    <input type="text" name="email6" id="email6" class="form-control input-lg"/>
				                    </div>
				                    <div class="form-group">
				                        <label for="email7" class="form-label">{l s='Email' mod='blockwishlist'}7</label>
					                    <input type="text" name="email7" id="email7" class="form-control input-lg"/>
				                    </div>
				                    <div class="form-group">
				                        <label for="email8" class="form-label">{l s='Email' mod='blockwishlist'}8</label>
					                    <input type="text" name="email8" id="email8" class="form-control input-lg"/>
				                    </div>
				                    <div class="form-group">
				                        <label for="email9" class="form-label">{l s='Email' mod='blockwishlist'}9</label>
					                    <input type="text" name="email9" id="email9" class="form-control input-lg"/>
				                    </div>
				                    <div class="form-group">
				                        <label for="email10" class="form-label">{l s='Email' mod='blockwishlist'}10</label>
					                    <input type="text" name="email10" id="email10" class="form-control input-lg"/>
				                    </div>
				        		</div>	
				        	</div>
							<div class="submit">
				                <button class="btn btn-default button button-small" type="submit" name="submitWishlist"
				                        onclick="WishlistSend('wl_send', '{$id_wishlist}', 'email');">
				                    <span>{l s='Send wishlist' mod='blockwishlist'}</span>
				                </button>
				            </div>
				        </form>
                    
                </div>
                <div class="lg-margin2x"></div>
            </div>
        
    </div>
    <div class="accordion-group panel">
		<h2 class="accordion-title"><span>{l s='Products boughts' mod='blockwishlist'}</span> <a class="accordion-btn" data-toggle="collapse" href="#collapse-three"></a></h2>
        <div class="accordion-body collapse" id="collapse-three">
            <div class="accordion-body-wrapper">                    
                {if count($productsBoughts)}                    
                    <table class="wlp_bought_infos  table table-bordered table-responsive">
		                <thead>
		                <tr>
		                    <th class="first_item">{l s='Product' mod='blockwishlist'}</th>
		                    <th class="item">{l s='Quantity' mod='blockwishlist'}</th>
		                    <th class="item">{l s='Offered by' mod='blockwishlist'}</th>
		                    <th class="last_item">{l s='Date' mod='blockwishlist'}</th>
		                </tr>
		                </thead>
		                <tbody>
		                {foreach from=$productsBoughts item=product name=i}
		                    {foreach from=$product.bought item=bought name=j}
		                        {if $bought.quantity > 0}
		                            <tr>
		                                <td class="first_item">
											<span style="float:left;">
												<img
		                                                src="{$link->getImageLink($product.link_rewrite, $product.cover, 'small')|escape:'html':'UTF-8'}"
		                                                alt="{$product.name|escape:'html':'UTF-8'}"/>
											</span>			
											<span style="float:left;">
												{$product.name|truncate:40:'...'|escape:'html':'UTF-8'}
		                                        {if isset($product.attributes_small)}
		                                            <br/>
		                                            <i>{$product.attributes_small|escape:'html':'UTF-8'}</i>
		                                        {/if}
											</span>
		                                </td>
		                                <td class="item align_center">
		                                    {$bought.quantity|intval}
		                                </td>
		                                <td class="item align_center">
		                                    {$bought.firstname} {$bought.lastname}
		                                </td>
		                                <td class="last_item align_center">
		                                    {$bought.date_add|date_format:"%Y-%m-%d"}
		                                </td>
		                            </tr>
		                        {/if}
		                    {/foreach}
		                {/foreach}
		                </tbody>
		            </table>
                {/if}
            </div>
            <div class="lg-margin2x"></div>
        </div>
    </div>    
    {/if}
</div>
{else}
    <p class="alert alert-warning">
        {l s='No products' mod='blockwishlist'}
    </p>
{/if}
