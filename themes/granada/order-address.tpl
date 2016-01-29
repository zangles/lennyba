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
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

{assign var='left_column_size' value=0}{assign var='right_column_size' value=0}
{if isset($HOOK_LEFT_COLUMN) && $HOOK_LEFT_COLUMN|trim && !$hide_left_column}{$left_column_size=3}{/if}
{if isset($HOOK_RIGHT_COLUMN) && $HOOK_RIGHT_COLUMN|trim && !$hide_right_column}{$right_column_size=3}{/if}







<section id="content" role="main">
	<div class="xlg-margin"></div>
	<div class="container" id="center_column">
		{if !$opc}
			{assign var='current_step' value='address'}
			{capture name=path}{l s='Addresses'}{/capture}
			{assign var="back_order_page" value="order.php"}
			{include file="$tpl_dir./order-steps.tpl"}
			{include file="$tpl_dir./errors.tpl"}
			<form action="{$link->getPageLink($back_order_page, true)|escape:'html':'UTF-8'}" method="post">
		{else}
			{assign var="back_order_page" value="order-opc.php"}
			<div id="opc_account" class="opc-main-block">
									<div id="opc_account-overlay" class="opc-overlay" style="display: none;"></div>			
		{/if}
				
			<div class="addresses clearfix">
				<div class="row">
					<div class="col-sm-6 padding-right-md">
						<div class="address_delivery select form-group selector1">
							<label for="id_address_delivery" class="form-label">{if $cart->isVirtualCart()}{l s='Elige una dirección de facturación:'}{else}{l s='Elige una dirección de envio:'}{/if}</label>
							<select name="id_address_delivery" id="id_address_delivery" class="address_select selectbox">
								{foreach from=$addresses key=k item=address}
									<option value="{$address.id_address|intval}"{if $address.id_address == $cart->id_address_delivery} selected="selected"{/if}>
										{$address.alias|escape:'html':'UTF-8'}
									</option>
								{/foreach}
							</select><span class="waitimage"></span>
						</div>
						<!--
						<p class="checkbox addressesAreEquals"{if $cart->isVirtualCart()} style="display:none;"{/if}>
							<input type="checkbox" name="same" id="addressesAreEquals" value="1"{if $cart->id_address_invoice == $cart->id_address_delivery || $addresses|@count == 1} checked="checked"{/if} />
							<label for="addressesAreEquals">{l s='Use the delivery address as the billing address.'}</label>
						</p>
						-->
					</div>
					<div class="xlg-margin visible-xs clearfix"></div>
					<div class="col-sm-6 padding-left-md">
						<div id="address_invoice_form" class="select form-group selector1">
							{if $addresses|@count > 1}
								<label for="id_address_invoice" class="form-label">{l s='Elige una dirección de facturación:'}</label>
								<select name="id_address_invoice" id="id_address_invoice" class="address_select selectbox">
								{section loop=$addresses step=-1 name=address}
									<option value="{$addresses[address].id_address|intval}"{if $addresses[address].id_address == $cart->id_address_invoice && $cart->id_address_delivery != $cart->id_address_invoice} selected="selected"{/if}>
										{$addresses[address].alias|escape:'html':'UTF-8'}
									</option>
								{/section}
								</select><span class="waitimage"></span>
							{else}
								<div class="address_delivery select form-group selector1">
									<label class="form-label" style="display: block">{l s='Agregar nueva dirección'}</label>
									<a href="{$link->getPageLink('address', true, NULL, "back={$back_order_page}?step=1&select_address=1{if $back}&mod={$back}{/if}")|escape:'html':'UTF-8'}" title="{l s='Agregar'}" class="button button-small btn btn-default">
										<span>{l s='Agregar nueva dirección'}</span>
									</a>
								</div>
							{/if}
						</div>
					</div>
				</div> <!-- end row -->
				<div class="xlg-margin"></div>
				<div class="row">
					<div class="col-sm-6 padding-right-md"{if $cart->isVirtualCart()} style="display:none;"{/if}>
						<ul class="address item box" id="address_delivery">
						</ul>
					</div>
					<div class="xlg-margin visible-xs clearfix"></div>
					<div class="col-sm-6 padding-left-md">
						<ul class="address alternate_item{if $cart->isVirtualCart()} full_width{/if} box" id="address_invoice">
						</ul>
					</div>
				</div> <!-- end row -->
				<div class="xlg-margin"></div>
				{if !$opc}				
					<div id="ordermsg" class="form-group">
						<label>{l s='Si desea agregar un comentario acerca de su pedido, por favor escríbalo en el campo de abajo.'}</label>
						<textarea class="form-control input-lg" cols="60" rows="6" name="message">{if isset($oldMessage)}{$oldMessage}{/if}</textarea>
					</div>					
				{/if}
			</div> <!-- end addresses -->
			
			
			{if !$opc}
						<p class="cart_navigation clearfix text-center">
							<input type="hidden" class="hidden" name="step" value="2" />
							<input type="hidden" name="back" value="{$back}" />
							<a href="{$link->getPageLink($back_order_page, true, NULL, "step=0{if $back}&back={$back}{/if}")|escape:'html':'UTF-8'}" title="{l s='Previous'}" class="button-exclusive btn btn-default">
								<i class="icon-chevron-left"></i>
								{l s='Continuar comprando'}
							</a>
							<button type="submit" name="processAddress" class="button btn btn-default button-medium">
								<span>{l s='Procesar perdido'}</span>
							</button>
						</p>
					</form>
			{else}
				</div> <!--  end opc_account -->
			{/if}
							
							
							
					
	</div>
	
	<div class="lg-margin2x"></div>
</section>
























{strip}
{if !$opc}
	{addJsDef orderProcess='order'}
	{addJsDef currencySign=$currencySign|html_entity_decode:2:"UTF-8"}
	{addJsDef currencyRate=$currencyRate|floatval}
	{addJsDef currencyFormat=$currencyFormat|intval}
	{addJsDef currencyBlank=$currencyBlank|intval}
	{addJsDefL name=txtProduct}{l s='product' js=1}{/addJsDefL}
	{addJsDefL name=txtProducts}{l s='products' js=1}{/addJsDefL}
	{addJsDefL name=CloseTxt}{l s='Submit' js=1}{/addJsDefL}
{/if}
{capture}{if $back}&mod={$back|urlencode}{/if}{/capture}
{capture name=addressUrl}{$link->getPageLink('address', true, NULL, 'back='|cat:$back_order_page|cat:'?step=1'|cat:$smarty.capture.default)|escape:'quotes':'UTF-8'}{/capture}
{addJsDef addressUrl=$smarty.capture.addressUrl}
{capture}{'&multi-shipping=1'|urlencode}{/capture}
{addJsDef addressMultishippingUrl=$smarty.capture.addressUrl|cat:$smarty.capture.default}
{capture name=addressUrlAdd}{$smarty.capture.addressUrl|cat:'&id_address='}{/capture}
{addJsDef addressUrlAdd=$smarty.capture.addressUrlAdd}
{addJsDef formatedAddressFieldsValuesList=$formatedAddressFieldsValuesList}
{addJsDef opc=$opc|boolval}
{capture}<h2 class="color2">{l s='Tu dirección de facturación' js=1}</h2>{/capture}
{addJsDefL name=titleInvoice}{$smarty.capture.default|@addcslashes:'\''}{/addJsDefL}
{capture}<h2 class="color2">{l s='Tu dirección de envio' js=1}</h2>{/capture}
{addJsDefL name=titleDelivery}{$smarty.capture.default|@addcslashes:'\''}{/addJsDefL}
{capture}<a class="button button-small btn btn-default button_111_hover" href="{$smarty.capture.addressUrlAdd}" title="{l s='Update address' js=1}"><span>{l s='Update address' js=1}</span></a>{/capture}
{addJsDefL name=liUpdate}{$smarty.capture.default|@addcslashes:'\''}{/addJsDefL}
{/strip}