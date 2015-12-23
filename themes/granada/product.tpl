{*
* 2007-2014 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2014 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Acanamedemic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
{assign var='left_column_size' value=0}{assign var='right_column_size' value=0}
{if isset($HOOK_LEFT_COLUMN) && $HOOK_LEFT_COLUMN|trim && !$hide_left_column}{$left_column_size=3}{/if}
{if isset($HOOK_RIGHT_COLUMN) && $HOOK_RIGHT_COLUMN|trim && !$hide_right_column}{$right_column_size=3}{/if}
{include file="$tpl_dir./errors.tpl"}
{if $errors|@count == 0}
	{if !isset($priceDisplayPrecision)}
		{assign var='priceDisplayPrecision' value=2}
	{/if}
	{if !$priceDisplay || $priceDisplay == 2}
		{assign var='productPrice' value=$product->getPrice(true, $smarty.const.NULL, $priceDisplayPrecision)}
		{assign var='productPriceWithoutReduction' value=$product->getPriceWithoutReduct(false, $smarty.const.NULL)}
	{elseif $priceDisplay == 1}
		{assign var='productPrice' value=$product->getPrice(false, $smarty.const.NULL, $priceDisplayPrecision)}
		{assign var='productPriceWithoutReduction' value=$product->getPriceWithoutReduct(true, $smarty.const.NULL)}
	{/if}
{if (bool)Configuration::get('PS_DISABLE_OVERRIDES')}
	{assign  var='over' value=0}
{else}
	{assign  var='over' value=1}
	{assign  var='rate' value=Product::getRatings($product->id)}
	
{/if}
<section id="content" role="main">
    <div id="product-single-container" class="light" itemscope itemtype="http://schema.org/Product" >
    	{include file="$tpl_dir./breadcrumb.tpl" class_name="absolute"}
    	<div class="sidebg left"></div>
		<div class="sidebg middle visible-sm"></div>
		<div class="sidebg right"></div>		
		<div class="carousel-container">
		    <div class="container">
		        <div class="row">
		            <div class="col-sm-6 col-sm-offset-4">
		                <div class="product-single-carousel">
		                	{foreach from=$images item=image name=thumbnails}
								{assign var=imageIds value="`$product->id`-`$image.id_image`"}
								{if !empty($image.legend)}
									{assign var=imageTitle value=$image.legend|escape:'html':'UTF-8'}
								{else}
									{assign var=imageTitle value=$product->name|escape:'html':'UTF-8'}
								{/if}
								<div class="slide">
			                        <img src="{$link->getImageLink($product->link_rewrite, $imageIds, 'large_default')|escape:'html':'UTF-8'}" alt="{$imageTitle}" class="img-responsive">
			                    </div>	                    
							{/foreach}					
		                </div>
		            </div>
		        </div>
		    </div>
		</div>
		<div class="md-margin2x visible-sm visible-xs"></div>
		<div class="product-single-meta-container ">
		    <div class="container">		    	
			        <div class="col-md-10 col-md-push-10 product-single-meta">
			            <h2 class="product-name">{$product->name|escape:'html':'UTF-8'}</h2>
			            <div class="clearfix">
			                <div class="product-price-container pull-left">
			                	<span id="our_price_display" class="product-price" itemprop="price">{convertPrice price=$productPrice}</span>
								{if $tax_enabled  && ((isset($display_tax_label) && $display_tax_label == 1) || !isset($display_tax_label))}
									{if $priceDisplay == 1} {l s='tax excl.'}{else} {l s='tax incl.'}{/if}
								{/if}
								<meta itemprop="priceCurrency" content="{$currency->iso_code}" />
								{hook h="displayProductPriceBlock" product=$product type="price"}
								 <div class="clearfix"></div>
								 <div id="old_price" class="old-price{if (!$product->specificPrice || !$product->specificPrice.reduction) && $group_reduction == 0} hidden{/if}">
								 	{strip}
		    						{if $priceDisplay >= 0 && $priceDisplay <= 2}
		    							{hook h="displayProductPriceBlock" product=$product type="old_price"}
		    							<span id="old_price_display" class="price">
		                                    {if $productPriceWithoutReduction > $productPrice}
		                                        {convertPrice price=$productPriceWithoutReduction}
		                                        {if $tax_enabled && $display_tax_label == 1}
		                                            {if $priceDisplay == 1}
		                                                {l s='tax excl.'}
		                                            {else}
		                                                {l s='tax incl.'}
		                                            {/if}
		                                        {/if}
		                                    {/if}
		                                </span>
		    						{/if}
		    					{/strip}
		    					</div>
								
			                </div>
			                <div class="ratings-container pull-right">
			                	{if $over == 1}
				                    <div class="ratings">
				                        <div class="ratings-result" data-result="{$rate.avg}"></div>
					                	<meta itemprop="worstRating" content="{$rate.min}">
					                	<meta itemprop="ratingValue" content="{$rate.avg}">
					                	<meta itemprop="bestRating" content="{$rate.max}">
					                	<meta itemprop="reviewCount" content="{$rate.review}">
				                    </div>
				                    <span class="separator">|</span>
				                    <span class="ratings-amount">{$rate.review} {l s='Review(s)'}</span>				                    
				                    {if ($too_early == false AND ($is_logged OR $allow_guests))}
				                    	<span class="separator">|</span>
				                    	<a class="open-comment-form add-rating" data-elId="product-tab-contents" href="javascript:void(0)">{l s='Write a review'}</a>				                    	
									{/if}  
									{*}
				                    <div class="hidden">{if isset($HOOK_EXTRA_RIGHT) && $HOOK_EXTRA_RIGHT}{$HOOK_EXTRA_RIGHT}{/if}</div>
				                    {*}
			                    {else}
			                    	{*}
			                    	{if isset($HOOK_EXTRA_RIGHT) && $HOOK_EXTRA_RIGHT}{$HOOK_EXTRA_RIGHT}{/if}
			                    	{*}
			                    {/if}
			                </div>
			            </div>
			            <div class="xs-margin"></div>			            
			            <ul>
			                <li><span>{l s='Availability'}:</span> {if $product->quantity >0}{l s='In Stock'} {else} {l s='Out stock'} {/if}</li>
			                <li><span>{l s='Product Code'}:</span> {$product->ean13}</li>
			                <li><span>{l s='Brand'}:</span> {$product->manufacturer_name}</li>
			            </ul>
			            <p class="hidden-md description_short">{strip_tags($product->description_short)|truncate:160:''|escape:'html':'UTF-8'}</p>
			            
			            <form id="buy_block"{if $PS_CATALOG_MODE && !isset($groups) && $product->quantity > 0} class="hidden"{/if} action="{$link->getPageLink('cart')|escape:'html':'UTF-8'}" method="post">
				            <p class="hidden">
								<input type="hidden" name="token" value="{$static_token}" />
								<input type="hidden" name="id_product" value="{$product->id|intval}" id="product_page_product_id" />
								<input type="hidden" name="add" value="1" />
								<input type="hidden" name="id_product_attribute" id="idCombination" value="" />
							</p>
				            <div class="product_attributes clearfix">
							
							<!-- minimal quantity wanted -->
							<p id="minimal_quantity_wanted_p"{if $product->minimal_quantity <= 1 || !$product->available_for_order || $PS_CATALOG_MODE} style="display: none;"{/if}>
								{l s='The minimum purchase order quantity for the product is'} <b id="minimal_quantity_label">{$product->minimal_quantity}</b>
							</p>
							{if isset($groups)}
								<!-- attributes -->
								<div id="attributes">
									<div class="clearfix"></div>
									{foreach from=$groups key=id_attribute_group item=group}
										{if $group.attributes|@count}
											<div class="filter-box">											
												
													<span class="filter-label">{$group.name|escape:'html':'UTF-8'}&nbsp;</span>
												
												{assign var="groupName" value="group_$id_attribute_group"}
												<div class="attribute_list">
													{if ($group.group_type == 'select')}
														<select name="{$groupName}" id="group_{$id_attribute_group|intval}" class="form-control attribute_select no-print">
															{foreach from=$group.attributes key=id_attribute item=group_attribute}
																<option value="{$id_attribute|intval}"{if (isset($smarty.get.$groupName) && $smarty.get.$groupName|intval == $id_attribute) || $group.default == $id_attribute} selected="selected"{/if} title="{$group_attribute|escape:'html':'UTF-8'}">{$group_attribute|escape:'html':'UTF-8'}</option>
															{/foreach}
														</select>
													{elseif ($group.group_type == 'color')}
														<ul id="color_to_pick_list" class="clearfix">
															{assign var="default_colorpicker" value=""}
															{foreach from=$group.attributes key=id_attribute item=group_attribute}
																{assign var='img_color_exists' value=file_exists($col_img_dir|cat:$id_attribute|cat:'.jpg')}
																<li{if $group.default == $id_attribute} class="selected"{/if}>
																	<a href="{$link->getProductLink($product)|escape:'html':'UTF-8'}" id="color_{$id_attribute|intval}" class="color_pick{if ($group.default == $id_attribute)} selected{/if}"{if !$img_color_exists && isset($colors.$id_attribute.value) && $colors.$id_attribute.value} style="background:{$colors.$id_attribute.value|escape:'html':'UTF-8'};"{/if} title="{$colors.$id_attribute.name|escape:'html':'UTF-8'}">
																		{if $img_color_exists}
																			<img src="{$img_col_dir}{$id_attribute|intval}.jpg" alt="{$colors.$id_attribute.name|escape:'html':'UTF-8'}" title="{$colors.$id_attribute.name|escape:'html':'UTF-8'}" width="20" height="20" />
																		{/if}
																	</a>
																</li>
																{if ($group.default == $id_attribute)}
																	{$default_colorpicker = $id_attribute}
																{/if}
															{/foreach}
														</ul>
														<input type="hidden" class="color_pick_hidden" name="{$groupName|escape:'html':'UTF-8'}" value="{$default_colorpicker|intval}" />
													{elseif ($group.group_type == 'radio')}
														<ul>
															{foreach from=$group.attributes key=id_attribute item=group_attribute}
																<li>
																	<input id="attr-{$id_attribute}" type="radio" class="attribute_radio" name="{$groupName|escape:'html':'UTF-8'}" value="{$id_attribute}" {if ($group.default == $id_attribute)} checked="checked"{/if} />
	                                                                <label class="label_radio {if ($group.default == $id_attribute)} checked{/if}" for="attr-{$id_attribute}">{$group_attribute|escape:'html':'UTF-8'}</label>
																</li>
															{/foreach}
														</ul>
													{/if}
												</div> <!-- end attribute_list -->
												<div class="clearfix"></div>
											</div>
										{/if}
									{/foreach}
								</div> <!-- end attributes -->
							{/if}
						</div> <!-- end product_attributes -->
				        
				        <div class="product-action-container clearfix">
				            <div class="product-action-content clearfix" id="add_to_cart">
				                <input type="text" class="product-amount-input" name="qty" id="quantity_wanted" value="1">
				                
				                <button type="submit" name="Submit" class="btn btn-custom-6 min-width-md exclusive">{l s='Add to Cart'}</button> 			                
				            </div>
				            <div class="product-action-inner">
				            	<a class="addToWishlist wishlistProd_{$product->id|intval} link-wishlist product-btn product-favorite" title="{l s='Add to my wishlist' mod='blockwishlist'}" href="#" data-wl="{$product->id|intval}" data-wl0="wishlist_block_list" data-wl1="add" data-wl2="{$product->id|intval}" data-wl3="1" data-wl4="1"></a>
				            	<a href="{$product->link_rewrite|escape:'html':'UTF-8'}" title="{l s='Add to compare'}" class="add_to_compare link-compare product-btn product-compare" data-id-product="{$product->id}"></a>			            	
				            </div>
				        </div>			        
				        {if isset($HOOK_EXTRA_RIGHT) && $HOOK_EXTRA_RIGHT}{$HOOK_EXTRA_RIGHT}{/if}			        
			       </form>

		    	</div>
			</div>
    	</div>

	</div>	
	
	
	{if !$content_only}
		<div class="container">
			<!-- Nav tabs -->
			<ul class="nav nav-pills" role="tablist">
				{if isset($product) && $product->description}
					<li class="active"><a href="#description" role="tab" data-toggle="tab">{l s='Description'}</a></li>
				{/if}
				{if isset($features) && $features}
					<li {if !isset($product) && !$product->description }class="active"{/if}><a href="#table-data-sheet" role="tab" data-toggle="tab">{l s='Details'}</a></li>
				{/if}
				{if (isset($quantity_discounts) && count($quantity_discounts) > 0)}
				<li {if !isset($product) && !$product->description && !isset($features) && !$features}class="active"{/if}><a href="#quantity-discount" role="tab" data-toggle="tab">{l s='Discounts'}</a></li>
				{/if}
				
				{if !$content_only && isset($accessories) && is_array($accessories) && $accessories|@count >0}
					<li {if !isset($product) && !$product->description && !isset($features) && !$features && !isset($quantity_discounts) && count($quantity_discounts) < 0}class="active"{/if}><a href="#accessories" role="tab" data-toggle="tab">{l s='Accessories'}</a></li>
				{/if}
				
				
				{if $HOOK_PRODUCT_TAB}
					{$HOOK_PRODUCT_TAB}
				{/if}	                
			</ul>	    
			<!-- Tab panes -->
			<div class="tab-content" id="product-tab-contents">
			  {if isset($product) && $product->description}
				<div id="description" class="tab-pane fade in active">
					{$product->description}
				</div>
			  {/if}
			  {if isset($features) && $features}
				<div id="table-data-sheet" class="tab-pane fade {if !isset($product) && !$product->description } in active{/if}">
					<table class="table-data-sheet">
						{foreach from=$features item=feature}
						<tr class="{cycle values="odd,even"}">
							{if isset($feature.value)}
							<td>{$feature.name|escape:'html':'UTF-8'}</td>
							<td>{$feature.value|escape:'html':'UTF-8'}</td>
							{/if}
						</tr>
						{/foreach}
					</table>
				</div>
			  {/if}
			  {if (isset($quantity_discounts) && count($quantity_discounts) > 0)}
					<!-- quantity discount -->
					<div class="tab-pane fade {if !isset($product) && !$product->description && !isset($features) && !$features} in active{/if}" id="quantity-discount">
						<table class="std table-product-discounts">
							<thead>
								<tr>
									<th>{l s='Quantity'}</th>
									<th>{if $display_discount_price}{l s='Price'}{else}{l s='Discount'}{/if}</th>
									<th>{l s='You Save'}</th>
								</tr>
							</thead>
							<tbody>
								{foreach from=$quantity_discounts item='quantity_discount' name='quantity_discounts'}
								<tr id="quantityDiscount_{$quantity_discount.id_product_attribute}" class="quantityDiscount_{$quantity_discount.id_product_attribute}" data-discount-type="{$quantity_discount.reduction_type}" data-discount="{$quantity_discount.real_value|floatval}" data-discount-quantity="{$quantity_discount.quantity|intval}">
									<td>
										{$quantity_discount.quantity|intval}
									</td>
									<td>
										{if $quantity_discount.price >= 0 || $quantity_discount.reduction_type == 'amount'}
											{if $display_discount_price}
												{convertPrice price=$productPrice-$quantity_discount.real_value|floatval}
											{else}
												{convertPrice price=$quantity_discount.real_value|floatval}
											{/if}
										{else}
											{if $display_discount_price}
												{convertPrice price = $productPrice-($productPrice*$quantity_discount.reduction)|floatval}
											{else}
												{$quantity_discount.real_value|floatval}%
											{/if}
										{/if}
									</td>
									<td>
										<span>{l s='Up to'}</span>
										{if $quantity_discount.price >= 0 || $quantity_discount.reduction_type == 'amount'}
											{$discountPrice=$productPrice-$quantity_discount.real_value|floatval}
										{else}
											{$discountPrice=$productPrice-($productPrice*$quantity_discount.reduction)|floatval}
										{/if}
										{$discountPrice=$discountPrice*$quantity_discount.quantity}
										{$qtyProductPrice = $productPrice*$quantity_discount.quantity}
										{convertPrice price=$qtyProductPrice-$discountPrice}
									</td>
								</tr>
								{/foreach}
							</tbody>
						</table>
					</div>
				{/if}
				{if isset($accessories) && is_array($accessories) && $accessories|@count >0}
					<div class="tab-pane fade {if !isset($product) && !$product->description && !isset($features) && !$features && !isset($quantity_discounts) && count($quantity_discounts) < 0} in active{/if}" id="accessories">
						{include file="$tpl_dir./group-product-style2.tpl" products=$accessories group_count=4 col_item=3}
					</div>					
				{/if}
			  	{if isset($HOOK_PRODUCT_TAB_CONTENT) && $HOOK_PRODUCT_TAB_CONTENT}
					{$HOOK_PRODUCT_TAB_CONTENT}
			  	{/if}
			</div>
		</div>	
	<div class="xlg-margin2x"></div>	
	{hook h="displayBottomProduct"}
	<div class="md-margin3x"></div>
	{/if}
</section>
        	
{strip}
{if isset($smarty.get.ad) && $smarty.get.ad}
	{addJsDefL name=ad}{$base_dir|cat:$smarty.get.ad|escape:'html':'UTF-8'}{/addJsDefL}
{/if}
{if isset($smarty.get.adtoken) && $smarty.get.adtoken}
	{addJsDefL name=adtoken}{$smarty.get.adtoken|escape:'html':'UTF-8'}{/addJsDefL}
{/if}
{addJsDef comparedProductsIds=$compared_products}
{addJsDef allowBuyWhenOutOfStock=$allow_oosp|boolval}
{addJsDef availableNowValue=$product->available_now|escape:'quotes':'UTF-8'}
{addJsDef availableLaterValue=$product->available_later|escape:'quotes':'UTF-8'}
{addJsDef attribute_anchor_separator=$attribute_anchor_separator|escape:'quotes':'UTF-8'}
{addJsDef attributesCombinations=$attributesCombinations}
{addJsDef currencySign=$currencySign|html_entity_decode:2:"UTF-8"}
{addJsDef currencyRate=$currencyRate|floatval}
{addJsDef currencyFormat=$currencyFormat|intval}
{addJsDef currencyBlank=$currencyBlank|intval}
{addJsDef currentDate=$smarty.now|date_format:'%Y-%m-%d %H:%M:%S'}
{if isset($combinations) && $combinations}
	{addJsDef combinations=$combinations}
	{addJsDef combinationsFromController=$combinations}
	{addJsDef displayDiscountPrice=$display_discount_price}
	{addJsDefL name='upToTxt'}{l s='Up to' js=1}{/addJsDefL}
{/if}
{if isset($combinationImages) && $combinationImages}
	{addJsDef combinationImages=$combinationImages}
{/if}
{addJsDef customizationFields=$customizationFields}
{addJsDef default_eco_tax=$product->ecotax|floatval}
{addJsDef displayPrice=$priceDisplay|intval}
{addJsDef ecotaxTax_rate=$ecotaxTax_rate|floatval}
{addJsDef group_reduction=$group_reduction}
{if isset($cover.id_image_only)}
	{addJsDef idDefaultImage=$cover.id_image_only|intval}
{else}
	{addJsDef idDefaultImage=0}
{/if}
{addJsDef img_ps_dir=$img_ps_dir}
{addJsDef img_prod_dir=$img_prod_dir}
{addJsDef id_product=$product->id|intval}
{addJsDef jqZoomEnabled=$jqZoomEnabled|boolval}
{addJsDef maxQuantityToAllowDisplayOfLastQuantityMessage=$last_qties|intval}
{addJsDef minimalQuantity=$product->minimal_quantity|intval}
{addJsDef noTaxForThisProduct=$no_tax|boolval}
{addJsDef customerGroupWithoutTax=$customer_group_without_tax|boolval}
{addJsDef oosHookJsCodeFunctions=Array()}
{addJsDef productHasAttributes=isset($groups)|boolval}
{addJsDef productPriceTaxExcluded=($product->getPriceWithoutReduct(true)|default:'null' - $product->ecotax)|floatval}
{addJsDef productBasePriceTaxExcluded=($product->base_price - $product->ecotax)|floatval}
{addJsDef productBasePriceTaxExcl=($product->base_price|floatval)}
{addJsDef productReference=$product->reference|escape:'html':'UTF-8'}
{addJsDef productAvailableForOrder=$product->available_for_order|boolval}
{addJsDef productPriceWithoutReduction=$productPriceWithoutReduction|floatval}
{addJsDef productPrice=$productPrice|floatval}
{addJsDef productUnitPriceRatio=$product->unit_price_ratio|floatval}
{addJsDef productShowPrice=(!$PS_CATALOG_MODE && $product->show_price)|boolval}
{addJsDef PS_CATALOG_MODE=$PS_CATALOG_MODE}
{if $product->specificPrice && $product->specificPrice|@count}
	{addJsDef product_specific_price=$product->specificPrice}
{else}
	{addJsDef product_specific_price=array()}
{/if}
{if $display_qties == 1 && $product->quantity}
	{addJsDef quantityAvailable=$product->quantity}
{else}
	{addJsDef quantityAvailable=0}
{/if}
{addJsDef quantitiesDisplayAllowed=$display_qties|boolval}
{if $product->specificPrice && $product->specificPrice.reduction && $product->specificPrice.reduction_type == 'percentage'}
	{addJsDef reduction_percent=$product->specificPrice.reduction*100|floatval}
{else}
	{addJsDef reduction_percent=0}
{/if}
{if $product->specificPrice && $product->specificPrice.reduction && $product->specificPrice.reduction_type == 'amount'}
	{addJsDef reduction_price=$product->specificPrice.reduction|floatval}
{else}
	{addJsDef reduction_price=0}
{/if}
{if $product->specificPrice && $product->specificPrice.price}
	{addJsDef specific_price=$product->specificPrice.price|floatval}
{else}
	{addJsDef specific_price=0}
{/if}
{addJsDef specific_currency=($product->specificPrice && $product->specificPrice.id_currency)|boolval} {* TODO: remove if always false *}
{addJsDef stock_management=$stock_management|intval}
{addJsDef taxRate=$tax_rate|floatval}
{addJsDefL name=doesntExist}{l s='This combination does not exist for this product. Please select another combination.' js=1}{/addJsDefL}
{addJsDefL name=doesntExistNoMore}{l s='This product is no longer in stock' js=1}{/addJsDefL}
{addJsDefL name=doesntExistNoMoreBut}{l s='with those attributes but is available with others.' js=1}{/addJsDefL}
{addJsDefL name=fieldRequired}{l s='Please fill in all the required fields before saving your customization.' js=1}{/addJsDefL}
{addJsDefL name=uploading_in_progress}{l s='Uploading in progress, please be patient.' js=1}{/addJsDefL}
{addJsDefL name='product_fileDefaultHtml'}{l s='No file selected' js=1}{/addJsDefL}
{addJsDefL name='product_fileButtonHtml'}{l s='Choose File' js=1}{/addJsDefL}
{/strip}
{/if}
