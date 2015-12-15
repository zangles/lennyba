
    	<div class="cart-dropdown dropdown pull-right ">    		
    		<a href="{$link->getPageLink($order_process, true)|escape:'html':'UTF-8'}" class="dropdown-toggle" data-toggle="dropdown" title="{l s='View my shopping cart' mod='blockcart'}" rel="nofollow">
    			<span class="dropdown-icon"></span>
    			<span class="ajax_cart_quantity badge cart_quantity_{$cart_qties}">{$cart_qties}</span>
    			<span class="dropdown-text">{l s='Shopping Cart' mod='blockcart'}</span>
    			<span class=" hidden-xs hidden">
    				<span class="ajax_cart_quantity badge hidden">{$cart_qties}</span>
    				
    				<span class="ajax_cart_product_txt_empty{if $cart_qties != 0} unvisible{/if} hidden">{l s='item(s)' mod='blockcart'}</span>
	                <span class="ajax_cart_product_txt{if $cart_qties != 1} unvisible{/if} hidden" >{l s='item' mod='blockcart'}</span>
	    			<span class="ajax_cart_product_txt_s{if $cart_qties < 2} unvisible{/if} hidden">{l s='items' mod='blockcart'}</span>
    				<span class="ajax_cart_total hidden" style="display: none">
	    				{if $cart_qties > 0}
	    					{if $priceDisplay == 1}
	    						{assign var='blockcart_cart_flag' value='Cart::BOTH_WITHOUT_SHIPPING'|constant}
	    						{convertPrice price=$cart->getOrderTotal(false, $blockcart_cart_flag)}
	    					{else}
	    						{assign var='blockcart_cart_flag' value='Cart::BOTH_WITHOUT_SHIPPING'|constant}
	    						{convertPrice price=$cart->getOrderTotal(true, $blockcart_cart_flag)}
	    					{/if}
	                    {else}
	                        {assign var='blockcart_cart_flag' value='Cart::BOTH_WITHOUT_SHIPPING'|constant}
	    					{convertPrice price=$cart->getOrderTotal(false, $blockcart_cart_flag)}
	    				{/if}
	    			</span>
    			</span>    			
    		</a>    		
    		
    		{if !$PS_CATALOG_MODE}
                
    			<div class="cart_block block exclusive dropdown-menu">
					<div class="block_content">
						<!-- block list of products -->
						<div class="cart_block_list{if isset($blockcart_top) && !$blockcart_top}{if isset($colapseExpandStatus) && $colapseExpandStatus eq 'expanded' || !$ajax_allowed || !isset($colapseExpandStatus)} expanded{else} collapsed unvisible{/if}{/if}">							
							<p class="cart-desc"><span class="ajax_cart_quantity">{$cart_qties}</span> {l s='item(s) in your cart' mod='blockcart'} - 
								<span class="ajax_cart_total">
				    				{if $cart_qties > 0}
				    					{if $priceDisplay == 1}
				    						{assign var='blockcart_cart_flag' value='Cart::BOTH_WITHOUT_SHIPPING'|constant}
				    						{convertPrice price=$cart->getOrderTotal(false, $blockcart_cart_flag)}
				    					{else}
				    						{assign var='blockcart_cart_flag' value='Cart::BOTH_WITHOUT_SHIPPING'|constant}
				    						{convertPrice price=$cart->getOrderTotal(true, $blockcart_cart_flag)}
				    					{/if}
				                    {else}
				                        {assign var='blockcart_cart_flag' value='Cart::BOTH_WITHOUT_SHIPPING'|constant}
				    					{convertPrice price=$cart->getOrderTotal(false, $blockcart_cart_flag)}
				    				{/if}
				    			</span>
				    		</p>
							{if $products}
							
							
								<div class="products">
								{foreach from=$products item='product' name='myLoop'}
									{assign var='productId' value=$product.id_product}
									{assign var='productAttributeId' value=$product.id_product_attribute}
									<div data-id="cart_block_product_{$product.id_product|intval}_{if $product.id_product_attribute}{$product.id_product_attribute|intval}{else}0{/if}_{if $product.id_address_delivery}{$product.id_address_delivery|intval}{else}0{/if}" class="product clearfix">
										<a href="{$link->getPageLink('cart', true, NULL, "delete=1&id_product={$product.id_product|intval}&ipa={$product.id_product_attribute|intval}&id_address_delivery={$product.id_address_delivery|intval}&token={$static_token}")|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='remove this product from my cart' mod='blockcart'}" class="delete-btn ajax_cart_block_remove_link" ></a>
										<figure class="product-image-container">
											<a href="{$link->getProductLink($product.id_product, $product.link_rewrite, $product.category)|escape:'html':'UTF-8'}" class="cart-images" title="{$product.name|escape:'html':'UTF-8'}">
												<img src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'cart_default')}" alt="{$product.name|escape:'html':'UTF-8'}" class="product-image" />												
											</a>
										</figure>
										<div class="product-content">
										   <h3 class="product-name">
												<a href="{$link->getProductLink($product, $product.link_rewrite, $product.category, null, null, $product.id_shop, $product.id_product_attribute)|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}">{$product.name|escape:'html':'UTF-8'}</a>
											</h3>
										   <div class="product-price-container">
												{if isset($product.attributes_small)}
													<div class="product-atributes">
														<a href="{$link->getProductLink($product, $product.link_rewrite, $product.category, null, null, $product.id_shop, $product.id_product_attribute)|escape:'html':'UTF-8'}" title="{l s='Product detail' mod='blockcart'}">{$product.attributes_small}</a>
													</div>
												{/if}
												<span class="product-price">
													{if !isset($product.is_gift) || !$product.is_gift}
														<span class="quantity-formated"><span class="quantity">{$product.cart_quantity}</span>&nbsp;x&nbsp;</span> {if $priceDisplay == $smarty.const.PS_TAX_EXC}{displayWtPrice p="`$product.total`"}{else}{displayWtPrice p="`$product.total_wt`"}{/if}
													{else}
														{l s='Free!' mod='blockcart'}
													{/if}
												</span>
											</div>	
										</div>
										
										{if isset($product.attributes_small)}
											<dd data-id="cart_block_combination_of_{$product.id_product|intval}{if $product.id_product_attribute}_{$product.id_product_attribute|intval}{/if}_{$product.id_address_delivery|intval}" class="{if $smarty.foreach.myLoop.first}first_item{elseif $smarty.foreach.myLoop.last}last_item{else}item{/if}">
										{/if}
										<!-- Customizable datas -->
										{if isset($customizedDatas.$productId.$productAttributeId[$product.id_address_delivery])}
											{if !isset($product.attributes_small)}
												<dd data-id="cart_block_combination_of_{$product.id_product|intval}_{if $product.id_product_attribute}{$product.id_product_attribute|intval}{else}0{/if}_{if $product.id_address_delivery}{$product.id_address_delivery|intval}{else}0{/if}" class="{if $smarty.foreach.myLoop.first}first_item{elseif $smarty.foreach.myLoop.last}last_item{else}item{/if}">
											{/if}
											<ul class="cart_block_customizations" data-id="customization_{$productId}_{$productAttributeId}">
												{foreach from=$customizedDatas.$productId.$productAttributeId[$product.id_address_delivery] key='id_customization' item='customization' name='customizations'}
													<li name="customization">
														<div data-id="deleteCustomizableProduct_{$id_customization|intval}_{$product.id_product|intval}_{$product.id_product_attribute|intval}_{$product.id_address_delivery|intval}" class="deleteCustomizableProduct">
															<a class="ajax_cart_block_remove_link" href="{$link->getPageLink('cart', true, NULL, "delete=1&id_product={$product.id_product|intval}&ipa={$product.id_product_attribute|intval}&id_customization={$id_customization|intval}&token={$static_token}")|escape:'html':'UTF-8'}" rel="nofollow">&nbsp;</a>
														</div>
														{if isset($customization.datas.$CUSTOMIZE_TEXTFIELD.0)}
															{$customization.datas.$CUSTOMIZE_TEXTFIELD.0.value|replace:"<br />":" "|truncate:28:'...'|escape:'html':'UTF-8'}
														{else}
															{l s='Customization #%d:' sprintf=$id_customization|intval mod='blockcart'}
														{/if}
													</li>
												{/foreach}
											</ul>
											{if !isset($product.attributes_small)}</dd>{/if}
										{/if}
										{if isset($product.attributes_small)}</dd>{/if}
										
										
									 </div>
									
									
									
									
								{/foreach}
								</div>
							
							
							{/if}
							<p class="cart_block_no_products{if $products} unvisible{/if}">
								{l s='No products' mod='blockcart'}
							</p>
							{if $discounts|@count > 0}
								<table class="vouchers{if $discounts|@count == 0} unvisible{/if}">
									{foreach from=$discounts item=discount}
										{if $discount.value_real > 0}
											<tr class="bloc_cart_voucher" data-id="bloc_cart_voucher_{$discount.id_discount|intval}">
												<td class="quantity">1x</td>
												<td class="name" title="{$discount.description}">
													{$discount.name|truncate:18:'...'|escape:'html':'UTF-8'}
												</td>
												<td class="price">
													-{if $priceDisplay == 1}{convertPrice price=$discount.value_tax_exc}{else}{convertPrice price=$discount.value_real}{/if}
												</td>
												<td class="delete">
													{if strlen($discount.code)}
														<a class="delete_voucher" href="{$link->getPageLink("$order_process", true)}?deleteDiscount={$discount.id_discount|intval}" title="{l s='Delete' mod='blockcart'}" rel="nofollow">
															<i class="icon-remove-sign"></i>
														</a>
													{/if}
												</td>
											</tr>
										{/if}
									{/foreach}
								</table>
							{/if}
							<div class="clearfix">
								<ul class="pull-left action-info-container">
								   <li class="{if !($page_name == 'order-opc') && $shipping_cost_float == 0 && (!isset($cart->id_address_delivery) || !$cart->id_address_delivery)} unvisible{/if}">
								   		{l s='Shipping' mod='blockcart'}: 
									   	<span class="first-color price cart_block_shipping_cost ajax_cart_shipping_cost">
									   	{if $shipping_cost_float == 0}
												 {if !($page_name == 'order-opc') && (!isset($cart->id_address_delivery) || !$cart->id_address_delivery)}{l s='To be determined' mod='blockcart'}{else}{l s='Free shipping!' mod='blockcart'}{/if}
											{else}
												{$shipping_cost}
											{/if}
									   </span>
								   </li>
								   {if $show_tax && isset($tax_cost)}
									<li>{l s='Tax' mod='blockcart'}: <span class="first-color price cart_block_tax_cost ajax_cart_tax_cost">{$tax_cost}</span></li>
								   {/if}
								   <li>Total: <span class="first-color price cart_block_total ajax_block_cart_total">{$total}</span></li>
								   
								   {if $use_taxes && $display_tax_label == 1 && $show_tax}
									<li>
										<p>
										{if $priceDisplay == 0}
											{l s='Prices are tax included' mod='blockcart'}
										{elseif $priceDisplay == 1}
											{l s='Prices are tax excluded' mod='blockcart'}
										{/if}
										</p>
									</li>
								{/if}
								</ul>
								<ul class="pull-right action-btn-container">
									<li><a class="btn btn-custom-5" href="{$link->getPageLink("$order_process", true)|escape:"html":"UTF-8"}" title="{l s='Check out' mod='blockcart'}" rel="nofollow">{l s='Cart' mod='blockcart'}</a></li>
									<li><a class="btn btn-custom" href="{$link->getPageLink("$order_process", true)|escape:"html":"UTF-8"}" title="{l s='Check out' mod='blockcart'}" rel="nofollow">{l s='Checkout' mod='blockcart'}</a></li>
								</ul>
							 </div>
							
						</div>
					</div>
				</div><!-- .cart_block -->
                
                

                
    		{/if}
    	</div>
    
    
    
    
    {counter name=active_overlay assign=active_overlay}
    {if !$PS_CATALOG_MODE && $active_overlay == 1}
    	<div id="layer_cart" class="layer_cart layer_cart_content">
    		<div class="clearfix">
    			<div class="layer_cart_product col-xs-12 col-md-6">
    				<span class="cross" title="{l s='Close window' mod='blockcart'}"></span>
    				<h2>
    					<i class="icon-ok"></i>{l s='Product successfully added to your shopping cart' mod='blockcart'}
    				</h2>
    				<div class="product-image-container layer_cart_img">
    				</div>
    				<div class="layer_cart_product_info">
    					<span id="layer_cart_product_title" class="layer_cart_product_title product-name"></span>
    					<span id="layer_cart_product_attributes" class="layer_cart_product_attributes"></span>
    					<div>
    						<span class="dark">{l s='Quantity' mod='blockcart'}</span>
    						<span id="layer_cart_product_quantity" class="layer_cart_product_quantity"></span>
    					</div>
    					<div>
    						<span class="dark">{l s='Total' mod='blockcart'}</span>
    						<span id="layer_cart_product_price" class="layer_cart_product_price"></span>
    					</div>
    				</div>
    			</div>
    			<div class="layer_cart_cart col-xs-12 col-md-6">
    				<h2>
    					<!-- Plural Case [both cases are needed because page may be updated in Javascript] -->
    					<span class="ajax_cart_product_txt_s {if $cart_qties < 2} unvisible{/if}">
    						{l s='There are [1]%d[/1] items in your cart.' mod='blockcart' sprintf=[$cart_qties] tags=['<span class="ajax_cart_quantity">']}
    					</span>
    					<!-- Singular Case [both cases are needed because page may be updated in Javascript] -->
    					<span class="ajax_cart_product_txt {if $cart_qties > 1} unvisible{/if}">
    						{l s='There is 1 item in your cart.' mod='blockcart'}
    					</span>
    				</h2>
    				<div class="layer_cart_row">
    					<span class="dark">
    						{l s='Total products' mod='blockcart'}
    						{if $priceDisplay == 1}
    							{l s='(tax excl.)' mod='blockcart'}
    						{else}
    							{l s='(tax incl.)' mod='blockcart'}
    						{/if}
    					</span>
    					<span class="ajax_block_products_total">
    						{if $cart_qties > 0}
    							{convertPrice price=$cart->getOrderTotal(false, Cart::ONLY_PRODUCTS)}
    						{/if}
    					</span>
    				</div>
    				{if $show_wrapping}
    					<div class="layer_cart_row">
    						<span class="dark">
    							{l s='Wrapping' mod='blockcart'}
    							{if $priceDisplay == 1}
    								{l s='(tax excl.)' mod='blockcart'}
    							{else}
    								{l s='(tax incl.)' mod='blockcart'}
    							{/if}
    						</span>
    						<span class="price cart_block_wrapping_cost">
    							{if $priceDisplay == 1}
    								{convertPrice price=$cart->getOrderTotal(false, Cart::ONLY_WRAPPING)}
    							{else}
    								{convertPrice price=$cart->getOrderTotal(true, Cart::ONLY_WRAPPING)}
    							{/if}
    						</span>
    					</div>
    				{/if}
    				<div class="layer_cart_row">
    					<span class="dark">
                            {if $shipping_cost_float > 0}
    						  {l s='Total shipping' mod='blockcart'}&nbsp;{l s='(tax excl.)' mod='blockcart'}
                            {/if}
    					</span>
    					<span class="ajax_cart_shipping_cost">
    						{if $shipping_cost_float > 0}
    							{$shipping_cost}
    						{/if}
    					</span>
    				</div>
    				{if $show_tax && isset($tax_cost)}
    					<div class="layer_cart_row">
    						<span class="dark">{l s='Tax' mod='blockcart'}</span>
    						<span class="price cart_block_tax_cost ajax_cart_tax_cost">{$tax_cost}</span>
    					</div>
    				{/if}
    				<div class="layer_cart_row">
    					<span class="dark">
    						{l s='Total' mod='blockcart'}
    						{if $priceDisplay == 1}
    							{l s='(tax excl.)' mod='blockcart'}
    						{else}
    							{l s='(tax incl.)' mod='blockcart'}
    						{/if}
    					</span>
    					<span class="ajax_block_cart_total">
    						{if $cart_qties > 0}
    							{if $priceDisplay == 1}
    								{convertPrice price=$cart->getOrderTotal(false)}
    							{else}
    								{convertPrice price=$cart->getOrderTotal(true)}
    							{/if}
    						{/if}
    					</span>
    				</div>
    				<div class="button-container">
    					<span class="continue btn btn-default button exclusive-medium mainBorderLightHoverOnly" title="{l s='Continue shopping' mod='blockcart'}">
    						<span class="mainBgHoverOnly">
    							<i class="icon-angle-left left"></i>{l s='Continue shopping' mod='blockcart'}
    						</span>
    					</span>
    					<a class="btn btn-default button button-medium mainBorder"	href="{$link->getPageLink("$order_process", true)|escape:"html":"UTF-8"}" title="{l s='Proceed to checkout' mod='blockcart'}" rel="nofollow">
    						<span>
    							{l s='Proceed to checkout' mod='blockcart'}<i class="icon-angle-right right"></i>
    						</span>
    					</a>
    				</div>
    			</div>
    		</div>
    		<div class="crossseling"></div>
    	</div> <!-- #layer_cart -->
    	<div class="layer_cart_overlay"></div>
    {/if}