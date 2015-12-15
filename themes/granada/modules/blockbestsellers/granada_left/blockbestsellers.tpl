<div id="sale-products_block_left" class="block products_block">
    <div class="block-title">
        <strong><a href="{$link->getPageLink('best-sales')|escape:'html'}" title="{l s='View a top sellers products' mod='blockbestsellers'}">{l s='Bestsellers' mod='blockbestsellers'}</a></strong>
        <div class="arrows-container">
            <a class=" button-custom button-custom-active arrows-left bestseller-arrows-left button-white"></a>
            <a class=" button-custom button-custom-active arrows-right bestseller-arrows-right button-white"></a>
        </div>
    </div>
	<div class="block_content products_content products-slider-sidebar">
	{if $best_sellers && $best_sellers|@count > 0}
        <div id="bestsellers_product">
    		<ul class="product-item">
                {foreach from=$best_sellers item=product name=best_sellers}
                    <li itemscope itemtype="http://schema.org/Product" class="clearfix">
                        <div class="row">
                            <div class="col-xs-4 col-side-product">
                              <div class="product-image-wrapper">
                                 <div class="product-image">
                                    <a href="{$product.link|escape:'html'}" title="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}">
                                    <img src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'cart_default')|escape:'html'}" alt="{$product.name|escape:html:'UTF-8'}"/>
                                    </a>
                                 </div>
                              </div>
                           </div>
                           <div class="product-description col-xs-8">
                              <h4 class="product-name"><a href="{$product.link|escape:'html'}" title="{$product.name|escape:html:'UTF-8'}">{$product.name|strip_tags|escape:html:'UTF-8'}</a></h4>
                              {hook h='displayProductListReviews' product=$product}
                              {if !$PS_CATALOG_MODE}
                                  <div class="price-box">
                                     <span class="regular-price">
                                        <span class="price">{$product.price}</span>                                   
                                     </span>
                                  </div>
                              {/if}
                           </div>
                       </div>
                    </li>
                    {if $smarty.foreach.best_sellers.iteration % 3 == 0 && !$smarty.foreach.best_sellers.last}
                        </ul>
                        <ul class="product-item">
                    {/if}
                {/foreach}
            </ul>
        </div>
        <!--
        <div class="lnk">
        	<a href="{$link->getPageLink('best-sales')|escape:'html'}" title="{l s='All best sellers' mod='blockbestsellers'}"  class="btn btn-default button button-small"><span>{l s='All best sellers' mod='blockbestsellers'}<i class="icon-chevron-right right"></i></span></a>
        </div>
        -->
	{else}
		<p>{l s='No best sellers at this time' mod='blockbestsellers'}</p>
	{/if}
	</div>
</div>
<script type="text/javascript">
    //<![CDATA[
    $(document).ready(function() {
        var owl = $("#bestsellers_product");
        owl.owlCarousel({
            items:1,
            margin:30,
        });
        // Custom Navigation Events
          $(".bestseller-arrows-right").click(function(){
            owl.trigger('next.owl.carousel');
          })
          $(".bestseller-arrows-left").click(function(){
            owl.trigger('prev.owl.carousel');
          })
    });
     //]]>
</script>