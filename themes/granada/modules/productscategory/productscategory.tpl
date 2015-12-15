{if count($categoryProducts) > 0 && $categoryProducts !== false}
<section class="blockproductscategory">
    <h2 class="title_block">{l s='UPSELL PRODUCTS' mod='ovicproductscategory'}</h2>        
	<div id="productscategory_list" class="clearfix">
	   {include file="$tpl_dir./product-list-limit.tpl" products=$categoryProducts limit_item=4}
 	</div>
</section>
{/if}