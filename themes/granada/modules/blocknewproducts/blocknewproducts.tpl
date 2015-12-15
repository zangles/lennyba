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
{assign var='option_tpl' value=OvicLayoutControl::getTemplateFile('blocknewproducts.tpl','blocknewproducts')}
{if  $option_tpl!== null}
    {include file=$option_tpl}
{else}
    <!-- MODULE Block new products -->
    <div class="blocknewproducts content-element">
       <h3 class="footer-title">{l s='New products' mod='blocknewproducts'}</h3>
       {if $new_products !== false}
       <ul class="footer-products-list">
          {foreach from=$new_products item=newproduct name=myLoop}
          <li itemscope itemtype="http://schema.org/Product">
             <a href="{$newproduct.link|escape:'html'}" title="{$newproduct.legend|escape:html:'UTF-8'}">
                <img class="replace-2x img-responsive" src="{$link->getImageLink($newproduct.link_rewrite, $newproduct.id_image, 'cart_default')|escape:'html'}" alt="{$newproduct.name|escape:html:'UTF-8'}"/>
                {$newproduct.name|strip_tags|escape:html:'UTF-8'}
             </a>
             {*}<div class="ratings">
                <div class="rating-box">
                   <div class="rating" style="width:73%"></div>
                </div>
                <span class="amount"><a href="#" onclick="var t = opener ? opener.window : window; t.location.href='http://newsmartwave.net/magento/granada/index.php/review/product/list/id/11/category/35/'; return false;">1 Review(s)</a></span>
             </div>{*}
             {hook h='displayProductListReviews' product=$newproduct}
             <div class="price-box">
                <p class="regular-price">
                    <span class="price">
                        {if !$priceDisplay}
                            {if !$priceDisplay}{convertPrice price=$newproduct.price}{else}{convertPrice price=$newproduct.price_tax_exc}{/if}
                        {/if}
                    </span>
                </p>
            </div>
            {if $smarty.foreach.myLoop.iteration == 2}
                {break}
            {/if}
          </li>
          {/foreach}
       </ul>
       {/if}
    </div>
    <!-- /MODULE Block new products -->
{/if}