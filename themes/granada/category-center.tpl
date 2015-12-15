<div id="center_column" class="center_column">
    {if isset($category)}
		{if $category->id AND $category->active}				        
			{if $products}							
				<div id="category-filter-bar" class="clearfix">
				   <div class="pull-left clearfix">
				      <div class="pull-left sort-filter">
				      	{include file="./product-sort.tpl"}
				      </div>
				      <div class="pull-left show-filter">
				      	{include file="./nbr-product-page.tpl"}
				      </div>
				   </div>
				   <div class="sm-margin visible-xs clearfix"></div>
				   <div class="pull-right clearfix">
						{include file="./product-compare.tpl"}
						{include file="./product-view.tpl"}					
				   </div>
				</div>				
				{include file="./product-list.tpl" products=$products layout="product-list-style1.tpl" itemWidth=$itemWidth productPerRow=$productPerRow}
				{include file="./pagination.tpl" paginationId='bottom'}							
			{else}
	            <div class="warning">{l s='Sorry! There are no products in this category.'}</div>
	        {/if}
		{elseif $category->id}
			<p class="alert alert-warning">{l s='This category is currently unavailable.'}</p>
		{/if}
	{/if}
</div><!-- #center_column -->