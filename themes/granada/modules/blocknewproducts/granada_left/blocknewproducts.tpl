<!-- MODULE Block new products -->
<div class="col-sm-4 col-xs-12">
    <div class="content-element">
       <h3 class="footer-title">{l s='New products' mod='blocknewproducts'}</h3>
       {if $new_products !== false}
       <ul class="footer-products-list">
          {foreach from=$new_products item=newproduct name=myLoop}
          <li itemscope itemtype="http://schema.org/Product">
             <a href="{$newproduct.link|escape:'html'}" title="{$newproduct.legend|escape:html:'UTF-8'}">
                <img class="replace-2x img-responsive" src="{$link->getImageLink($newproduct.link_rewrite, $newproduct.id_image, 'cart_default')|escape:'html'}" alt="{$newproduct.name|escape:html:'UTF-8'}"/>
                {$newproduct.name|strip_tags|escape:html:'UTF-8'}
             </a>
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
            <div class="clearfix"></div>
          </li>
          {/foreach}
       </ul>
       {/if}
    </div>
</div>
<!-- /MODULE Block new products -->