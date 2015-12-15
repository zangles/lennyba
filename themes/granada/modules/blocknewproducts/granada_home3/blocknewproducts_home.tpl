{if isset($new_products) && $new_products}
    <div id="blocknewproducts" class="tab-pane" data-el="blocknewproducts_home">
        <div class="blocknewproducts_home slider-type-2">
    	{include file="$tpl_dir./product-list-carousel-type2.tpl" products=$new_products class='blocknewproducts' id='blocknewproducts_home'}
        </div>
    </div>
    
{else}
<ul id="blocknewproducts" class="blocknewproducts tab-pane">
	<li class="alert alert-info">{l s='No new products at this time.' mod='blocknewproducts'}</li>
</ul>
{/if}