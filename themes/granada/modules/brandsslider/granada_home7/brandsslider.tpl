{if $manufacturers}
<div class="container">
  <div class="carousel-container">
  	<h2 class="carousel-title clearfix">
		<span class="cat-list-name sub-title cat-list-e003" style="border-top: 2px solid #c114e6; color: #c114e6;">{l s='Brands' mod='brandsslider'}</span>							
	</h2>
     <div class="row">
        <div class="owl-carousel color2 brands-carousel">
        	{foreach from=$manufacturers item=manufacturer name=manufacturer_list}
        		<div class="brand">
        			<a href="{$link->getmanufacturerLink($manufacturer.id_manufacturer, $manufacturer.link_rewrite)|escape:'html'}" title="{$manufacturer.name}">
        				<img src="{$img_manu_dir}{$manufacturer.image}" alt="{$manufacturer.name}" />
        			</a>
        		</div>        		
            {/foreach}            
        </div>
     </div>
  </div>
</div>
{/if}