{if !($itemWidth)}
	{assign var='itemWidth' value=4}	
{/if}
{if !($itemPerRow)}
	{assign var='itemPerRow' value=3}	
{/if}
<div id="center_column" class="center_column manufacturers_list">
	<h2 class="color2">
		{if $nbSuppliers == 0}
			{l s='There are no suppliers.'}
		{else}
			{if $nbSuppliers == 1}
				{l s='There is %d supplier.' sprintf=$nbSuppliers}
			{else}
				{l s='There are %d suppliers.' sprintf=$nbSuppliers}
			{/if}
		{/if}
	</h2>
	{if isset($errors) AND $errors}
		
	{else}
		{if $nbSuppliers > 0}
			{include file="$tpl_dir./pagination.tpl"}
			{assign var='nbItemsPerLine' value=3}
		    {assign var='nbItemsPerLineTablet' value=2}
		    {assign var='nbLi' value=$suppliers_list|@count}
		    {math equation="nbLi/nbItemsPerLine" nbLi=$nbLi nbItemsPerLine=$nbItemsPerLine assign=nbLines}
		    {math equation="nbLi/nbItemsPerLineTablet" nbLi=$nbLi nbItemsPerLineTablet=$nbItemsPerLineTablet assign=nbLinesTablet}		    
			
			<div id="suppliers_list" class="category-grid row">
				{foreach from=$suppliers_list item=supplier name=supplier}
			    	{math equation="(total%perLine)" total=$smarty.foreach.supplier.total perLine=$nbItemsPerLine assign=totModulo}
			        {math equation="(total%perLineT)" total=$smarty.foreach.supplier.total perLineT=$nbItemsPerLineTablet assign=totModuloTablet}
			        {if $totModulo == 0}{assign var='totModulo' value=$nbItemsPerLine}{/if}
			        {if $totModuloTablet == 0}{assign var='totModuloTablet' value=$nbItemsPerLineTablet}{/if}
					<div class="col-sm-{$itemWidth} md-margin">
					   <div class="product product4 dark">
					      <figure class="product-image-container">
					      	<a href="{$link->getsupplierLink($supplier.id_supplier, $supplier.link_rewrite)|escape:'html':'UTF-8'}" title="{$supplier.name|escape:'html':'UTF-8'}">
					      		<img src="{$img_sup_dir}{$supplier.image|escape:'html':'UTF-8'}-medium_default.jpg" alt="{$supplier.name|escape:'html':'UTF-8'}" class="product-image">
					      	</a>
					      </figure>
					      <div class="product-meta">
					         <div class="product-meta-inner">
					            <h3 class="product-name text-left">
					            	<a href="{$link->getsupplierLink($supplier.id_supplier, $supplier.link_rewrite)|escape:'html':'UTF-8'}" title="{$supplier.name|escape:'html':'UTF-8'}">{$supplier.name|escape:'html':'UTF-8'}</a>
					            </h3>
					            <div class="product-price-container text-left">
					            	{if $supplier.nb_products > 0}
					            		<span class="product-price">{l s='%d products' sprintf=$supplier.nb_products|intval}</span>
		                        	{elseif $supplier.nb_products  == 1}
		                        		<span class="product-price">{l s='%d product' sprintf=$supplier.nb_products|intval}</span>
		                        	{else}
		                        		<span class="product-price">{l s='No products'}</span>
			                        {/if}			                        
					            </div>
					            <div class="product-action-container clearfix">					            	
			                        <a class="btn btn-default button exclusive-medium" href="{$link->getsupplierLink($supplier.id_supplier, $supplier.link_rewrite)|escape:'html':'UTF-8'}">
			                        	<span>
			                        		{l s='view products'} <i class="icon-chevron-right right"></i>
			                        	</span>
			                        </a>
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
