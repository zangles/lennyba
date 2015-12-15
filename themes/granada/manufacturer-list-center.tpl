{if !($itemWidth)}
	{assign var='itemWidth' value=4}	
{/if}
{if !($itemPerRow)}
	{assign var='itemPerRow' value=3}	
{/if}
<div id="center_column" class="center_column manufacturers_list">
	<h2 class="color2">
		{l s='Brands'}
	    {strip}
			<span class="heading-counter">
				{if $nbManufacturers == 0}{l s='There are no manufacturers.'}
				{else}
					{if $nbManufacturers == 1}
						{l s='There is 1 brand'}
					{else}
						{l s='There are %d brands' sprintf=$nbManufacturers}
					{/if}
				{/if}
			</span>
	    {/strip}
	</h2>
	{if isset($errors) AND $errors}
		
	{else}
		{if $nbManufacturers > 0}
			{include file="$tpl_dir./pagination.tpl"}
			{assign var='nbItemsPerLine' value=3}
	        {assign var='nbItemsPerLineTablet' value=2}
	        {assign var='nbLi' value=$manufacturers|@count}
	        {math equation="nbLi/nbItemsPerLine" nbLi=$nbLi nbItemsPerLine=$nbItemsPerLine assign=nbLines}
	        {math equation="nbLi/nbItemsPerLineTablet" nbLi=$nbLi nbItemsPerLineTablet=$nbItemsPerLineTablet assign=nbLinesTablet}
			<div id="manufacturers_list" class="category-grid row">
				{foreach from=$manufacturers item=manufacturer name=manufacturers}					
		        	{math equation="(total%perLine)" total=$smarty.foreach.manufacturers.total perLine=$nbItemsPerLine assign=totModulo}
		            {math equation="(total%perLineT)" total=$smarty.foreach.manufacturers.total perLineT=$nbItemsPerLineTablet assign=totModuloTablet}
		            {if $totModulo == 0}{assign var='totModulo' value=$nbItemsPerLine}{/if}
		            {if $totModuloTablet == 0}{assign var='totModuloTablet' value=$nbItemsPerLineTablet}{/if}		
		            
		            
		            <div class="col-sm-{$itemWidth} md-margin">
					   <div class="product product4 dark">
					      <figure class="product-image-container">
					      	<a href="{$link->getmanufacturerLink($manufacturer.id_manufacturer, $manufacturer.link_rewrite)|escape:'html':'UTF-8'}" title="{$manufacturer.name|escape:'html':'UTF-8'}">
					      		<img src="{$img_manu_dir}{$manufacturer.image|escape:'html':'UTF-8'}-medium_default.jpg" alt="{$manufacturer.name|escape:'html':'UTF-8'}" class="product-image">
					      	</a>
					      </figure>
					      <div class="product-meta">
					         <div class="product-meta-inner">
					            <h3 class="product-name text-left">
					            	<a href="{$link->getmanufacturerLink($manufacturer.id_manufacturer, $manufacturer.link_rewrite)|escape:'html':'UTF-8'}" title="{$manufacturer.name|escape:'html':'UTF-8'}">{$manufacturer.name|escape:'html':'UTF-8'}</a>
					            </h3>
					            <div class="product-price-container text-left">
					            	{if $manufacturer.nb_products > 1}
					            		<span class="product-price">{l s='%d products' sprintf=$manufacturer.nb_products|intval}</span>
		                        	{elseif $manufacturer.nb_products  == 1}
		                        	<span class="product-price">{l s='%d product' sprintf=$manufacturer.nb_products|intval}</span>
		                        	{else}
		                        		<span class="product-price">{l s='No products'}</span>
			                        {/if}			                        
					            </div>
					            <div class="product-action-container clearfix">
					            	{if $manufacturer.nb_products > 0}
				                        <a class="btn btn-default button exclusive-medium" href="{$link->getmanufacturerLink($manufacturer.id_manufacturer, $manufacturer.link_rewrite)|escape:'html':'UTF-8'}">
				                        	<span>
				                        		{l s='view products'} <i class="icon-chevron-right right"></i>
				                        	</span>
				                        </a>
				                    {/if}						               
					            </div>
					         </div>
					      </div>
					   </div>
					</div>
		            
		            
		            			
				{/foreach}
			</div>
		{/if}
	{/if}
</div>