{if isset($simplecategory_item) && $simplecategory_item|@count >0}
	{if isset($simplecategory_item.products) && $simplecategory_item.products|@count >0}
	<section id="products-section" class="section">
		<div class="container">	
			<div class="carousel-container">
				{if $simplecategory_item.display_name == '1'}<h2 class="carousel-title big text-center secondary-font">{$simplecategory_item.name}</h2>{/if}
				<div class="row ">
					<div class="owl-carousel products-section-carousel center-buttons color2 grid-type-4 products-grid">
						{include file="$tpl_dir./group-product-carousel-style6.tpl" products=$simplecategory_item.products}	
					</div>
				</div>					
			</div>
		</div>
	</section>
	{/if}	
{/if}