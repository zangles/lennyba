<div id="best-sellers_block_right" class="content-element col-sm-4">
   <h3 class="footer-title"><a href="{$link->getPageLink('best-sales')|escape:'html'}" title="{l s='View a top sellers products' mod='blockbestsellers'}">{l s='Top sellers' mod='blockbestsellers'}</a></h3>
   {if $best_sellers && $best_sellers|@count > 0}
       <ul class="footer-products-list">
          {foreach from=$best_sellers item=product name=myLoop}
          <li itemscope itemtype="http://schema.org/Product">
            <a href="{$product.link|escape:'html'}" title="{$product.legend|escape:'html':'UTF-8'}" class="avatar">
            	<img class="replace-2x img-responsive" src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'cart_default')|escape:'html'}" alt="{$product.legend|escape:'html':'UTF-8'}" />                
            </a>
			<div class="product-content">
				<h5><a>{$product.name|strip_tags:'UTF-8'|escape:'html':'UTF-8'}</a></h5>
				{hook h='displayProductListReviews' product=$product}
				<div class="price-box">
					{if !$PS_CATALOG_MODE}
						<span class="regular-price" itemprop="price">
							<span class="price">{$product.price}</span>                                    
						</span>
					{/if}
				</div>
			</div>            
			<div class="clearfix"></div>
          </li>
          {if $smarty.foreach.myLoop.iteration == 3}
            {break}
          {/if}
          {/foreach}
       </ul>
       <div class="lnk">
        	<a href="{$link->getPageLink('best-sales')|escape:'html'}" title="{l s='All best sellers' mod='blockbestsellers'}"  class="btn btn-default button button-small"><span>{l s='All best sellers' mod='blockbestsellers'}<i class="icon-chevron-right right"></i></span></a>
        </div>
   {else}
		<p>{l s='No best sellers at this time' mod='blockbestsellers'}</p>
	{/if}
</div>