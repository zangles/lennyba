{if $manufacturers}
<div class="md-margin3x hidden-xs"></div>
<div class="xlg-margin visible-xs"></div>
<div class="container">
  <div class="carousel-container">
     <h2 class="carousel-title">{l s='Our Brands' mod='brandsslider'}</h2>
     <div class="row">
        <div class="owl-carousel brands-carousel">
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