{if isset($simplecategory_item) && $simplecategory_item|@count >0}
	{if isset($simplecategory_item.products) && $simplecategory_item.products|@count >0}
		<div class="carousel-container col-sm-12">
			<div class="position_relative simple-category">
				{if $simplecategory_item.display_name == '1'}
					<h2 class="carousel-title clearfix">
						<span class="cat-list-name sub-title {$simplecategory_item.custom_class}" style="border-top:2px solid {$simplecategory_item.params.color};color:{$simplecategory_item.params.color};">{$simplecategory_item.name}</span>							
					</h2>
				{/if}
				<div class="row">
					<div class="col-sm-3">
						{$simplecategory_item.description}
					</div>
					<div class="col-sm-9 position_static">
						<div class="row products-grid grid-type-1 grid-type-4">
							<div class="owl-carousel color2  bestsellers-carousel">
								{include file="$tpl_dir./group-product-carousel-style7.tpl" products=$simplecategory_item.products}	
							</div>	
						</div>								
					</div>					
				</div>	
			</div>				
		</div>
	{/if}	
{/if}

