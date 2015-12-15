<div class="flexgroupmenus block-toggle {$custom_class}">
	{if $display_name == '1'}<h3 class="module-name">{$module_name}</h3>{/if}	
	{if isset($rowContents) && $rowContents|@count >0}
		<div class="flexgroupmenus-rows">	
		{foreach from=$rowContents item=row name=rows}
			<div class="flexgroupmenus-row {$row.custom_class} {if $row.width >0}col-sm-{$row.width}{/if} clearfix">
				<div class="row">
					{if $row.display_title == "1"}<h3 class="row-title title-block-toggle"><span>{$row.name}</span><i class="fa fa-plus-square-o visible-xs"></i><i class="fa fa-minus-square-o"></i></h3>{/if}
					{if isset($row.groups) && $row.groups|@count >0}
					{assign var='totalwidth' value=0}
					<div class="flexgroupmenus-groups clearfix row toggle-footer">					
						{foreach from=$row.groups item=group name=groups}
							{assign var='totalwidth' value=$totalwidth+$group.width}            
				            {if $totalwidth>12 && !$smarty.foreach.groups.last}
				                <div class="clearfix"></div>                
				                {assign var='totalwidth' value=0}            
				            {/if}
	
				            <!-- group item -->                                                        
	                        <div class="flexgroupmenus-group {$group.custom_class} col-sm-{$group.width}">
	                            {if $group.display_name == '1'}<h3 class="group-title">{$group.name}</h3> {/if}
	                            {if $group.type == 'module'}
	                                <div class="flexgroupmenus-group-module">{$group.items}</div>
	                            {elseif $group.type == 'product'}
	                            <!-- group products -->
	                                {if isset($group.items) && $group.items|@count >0}
	                                    <div class="flexgroupmenus-group-products clearfix">
	                                        {assign var='products_totalwidth' value=0}
	                                        {foreach from=$group.items item=product name=products}
	                                            {assign var='products_totalwidth' value=$products_totalwidth+$group.productWidth}            
	                                            {if $products_totalwidth > 12 && !$smarty.foreach.products.last}             
	                                                <div class="clearfix"></div>                
	                                                {assign var='products_totalwidth' value=0}            
	                                            {/if}                                                                         
	                                            <!-- product-container -->
	                                            <div class="product-container col-sm-{$group.productWidth}" itemscope itemtype="http://schema.org/Product">
	                                                <div class="left-block">
	                                                    <div class="product-image-container">
	                                                        <a class="product_img_link" href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}" itemprop="url">
	                                                            <img class="replace-2x img-responsive" src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'home_default')|escape:'html':'UTF-8'}" alt="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" title="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" {if isset($homeSize)} width="{$homeSize.width}" height="{$homeSize.height}"{/if} itemprop="image" />
	                                                        </a>                                                                                       
	                                                        {if isset($product.new) && $product.new == 1}
	                                                            <a class="new-box" href="{$product.link|escape:'html':'UTF-8'}">
	                                                                <span class="new-label">{l s='New'}</span>
	                                                            </a>
	                                                        {/if}
	                                                        {if isset($product.on_sale) && $product.on_sale && isset($product.show_price) && $product.show_price && !$PS_CATALOG_MODE}
	                                                            <a class="sale-box" href="{$product.link|escape:'html':'UTF-8'}">
	                                                                <span class="sale-label">{l s='Sale!'}</span>
	                                                            </a>
	                                                        {/if}
	                                                    </div>                                                                                    
	                                                </div>
	                                                <div class="right-block">
	                                                    <h5 itemprop="name">
	                                                        {if isset($product.pack_quantity) && $product.pack_quantity}{$product.pack_quantity|intval|cat:' x '}{/if}
	                                                        <a class="product-name" href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}" itemprop="url" >
	                                                            {$product.name|truncate:45:'...'|escape:'html':'UTF-8'}
	                                                        </a>
	                                                    </h5>
	                                                    
	                                                    {if (!$PS_CATALOG_MODE AND ((isset($product.show_price) && $product.show_price) || (isset($product.available_for_order) && $product.available_for_order)))}
	                                                    <div itemprop="offers" itemscope itemtype="http://schema.org/Offer" class="content_price">
	                                                        {if isset($product.show_price) && $product.show_price && !isset($restricted_country_mode)}
	                                                            <span itemprop="price" class="price product-price">
	                                                                {if !$priceDisplay}{convertPrice price=$product.price}{else}{convertPrice price=$product.price_tax_exc}{/if}
	                                                            </span>
	                                                            <meta itemprop="priceCurrency" content="{$currency->iso_code}" />
	                                                            {if isset($product.specific_prices) && $product.specific_prices && isset($product.specific_prices.reduction) && $product.specific_prices.reduction > 0}
	                                                                {hook h="displayProductPriceBlock" product=$product type="old_price"}
	                                                                <span class="old-price product-price">
	                                                                    {displayWtPrice p=$product.price_without_reduction}
	                                                                </span>
	                                                                {hook h="displayProductPriceBlock" id_product=$product.id_product type="old_price"}
	                                                                {if $product.specific_prices.reduction_type == 'percentage'}
	                                                                    <span class="price-percent-reduction">-{$product.specific_prices.reduction * 100}%</span>
	                                                                {/if}
	                                                            {/if}
	                                                            {hook h="displayProductPriceBlock" product=$product type="price"}
	                                                            {hook h="displayProductPriceBlock" product=$product type="unit_price"}
	                                                        {/if}
	                                                    </div>
	                                                    {/if}                                                                                    
	                                                </div>                                                                                
	                                            </div>
	                                            <!-- end product-container -->                                                                            
	                                        {/foreach}
	                                    </div>      
	                                {/if}
	                            <!-- end group products -->                                                            
	                            {else}
	                                {if isset($group.items) && $group.items|@count >0}
	                                    <!-- menu items -->
	                                    <ul class="flexgroupmenus-menu-items">
	                                        {foreach from=$group.items item=menuitem name=menuitems}
	                                            <li class="flexgroupmenus-menu-item">                                                                                
	                                                {if $menuitem.menuType == 'module'}
	                                                    {if $menuitem.display_name == '1'}
	                                                        <h5 class="flexgroupmenus-menu-item-title"><a href="{$menuitem.link}" title="{$menuitem.name}">{$menuitem.name}</a></h5>
	                                                    {/if}
	                                                    <div class="flexgroupmenus-menu-item-module">
	                                                        {$menuitem.content}
	                                                    </div>
	                                                {elseif $menuitem.menuType == 'html'}
	                                                    {if $menuitem.display_name == '1'}
	                                                        <h5 class="flexgroupmenus-menu-item-title"><a href="{$menuitem.link}" title="{$menuitem.name}">{$menuitem.name}</a></h5>
	                                                    {/if}
	                                                    <div class="flexgroupmenus-menu-item-html">
	                                                        {$menuitem.content}
	                                                    </div>
	                                                {elseif $menuitem.menuType == 'image'}
	                                                    {if $menuitem.display_name == '1'}
	                                                        <h5 class="flexgroupmenus-menu-item-title"><a href="{$menuitem.link}" title="{$menuitem.name}">{$menuitem.name}</a></h5>
	                                                    {/if}
	                                                    <div class="flexgroupmenus-menu-item-image">
	                                                        <a href="{$menuitem.link}" title="{$menuitem.name}"><img class="img-responsive" src="{$menuitem.content}" alt="{$menuitem.imageAlt}" /></a>
	                                                    </div>
	                                                {else}
	                                                    {if $menuitem.display_name == '1'}
	                                                        <a href="{$menuitem.link}" title="{$menuitem.name}">{$menuitem.name}</a>
	                                                    {/if}
	                                                {/if}
	                                            </li>        
	                                        {/foreach}
	                                    </ul>
	                                    <!-- end menu item -->
	                                {/if}                                                            
	                            {/if}
	                        </div>
	                        <!-- end group item -->
				            
				            
				            
				            
				            
				            
				            
				            
				            
				            
				            
				            
				            
				            
				            
				            
				            
				            
				            
				            
				            
				            
	      
						{/foreach}								
					</div>
					{/if}
				</div>
			</div>	
		{/foreach}
		</div>	
	{/if}
	
</div>




