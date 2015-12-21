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
{capture name=path}
	{if !isset($email_create)}{l s='Authentication'}{else}
		<a href="{$link->getPageLink('authentication', true)|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='Authentication'}">{l s='Authentication'}</a>
		<span class="navigation-pipe">{$navigationPipe}</span>{l s='Create your account'}
	{/if}
{/capture}
{*}{if isset($back) && preg_match("/^http/", $back)}{assign var='current_step' value='login'}{include file="$tpl_dir./order-steps.tpl"}{/if}{*}

{assign var='left_column_size' value=0}{assign var='right_column_size' value=0}
{if isset($HOOK_LEFT_COLUMN) && $HOOK_LEFT_COLUMN|trim && !$hide_left_column}{$left_column_size=3}{/if}
{if isset($HOOK_RIGHT_COLUMN) && $HOOK_RIGHT_COLUMN|trim && !$hide_right_column}{$right_column_size=3}{/if}
{assign var='current_step' value='summary'}


{assign var='stateExist' value=false}
{assign var="postCodeExist" value=false}
{assign var="dniExist" value=false}
<!-- ============================================================================================================= -->
{if !isset($email_create)}
<!-- ============================================================================================================= -->
	<!--{if isset($authentification_error)}
	<div class="alert alert-danger">
		{if {$authentification_error|@count} == 1}
			<p>{l s='There\'s at least one error'} :</p>
			{else}
			<p>{l s='There are %s errors' sprintf=[$account_error|@count]} :</p>
		{/if}
		<ol>
			{foreach from=$authentification_error item=v}
				<li>{$v}</li>
			{/foreach}
		</ol>
	</div>
	{/if}-->

<section id="content" role="main">
	{include file="$tpl_dir./breadcrumb.tpl"}
	<div class="xs-margin half"></div>	
	<div class="container" id="center_column">
		<div class="row">
			<div class="col-sm-12">{include file="$tpl_dir./errors.tpl"}</div>
			<div class="col-sm-6 padding-right-md">
                <form action="{$link->getPageLink('authentication', true)|escape:'html':'UTF-8'}" method="post" id="create-account_form" class="box">
					<h2 class="color2">{l s='Create an account'}</h2>
					<div class="form_content clearfix">
						<div class="alert alert-danger" id="create_account_error" style="display:none"></div>
						<div class="form-group">
							<label for="email_create" class="form-label">{l s='Email address'}<span class="required">*</span></label>
							<input type="text" class="is_required validate account_input form-control input-lg" data-validate="isEmail" id="email_create" name="email_create" value="{if isset($smarty.post.email_create)}{$smarty.post.email_create|stripslashes}{/if}" />
						</div>
						
						
						<div class="submit">
							{if isset($back)}<input type="hidden" class="hidden" name="back" value="{$back|escape:'html':'UTF-8'}" />{/if}
							<input type="submit" class="btn btn-custom btn-lg min-width button_111_hover" id="SubmitCreate" name="SubmitCreate" value="{l s='Create an account'}">							
							<input type="hidden" class="hidden" name="SubmitCreate" value="{l s='Create an account'}" />
						</div>
					</div>
				</form>
            </div>
			<div class="xlg-margin visible-xs clearfix"></div>
			<div class="col-sm-6 padding-left-md">
				<form action="{$link->getPageLink('authentication', true)|escape:'html':'UTF-8'}" method="post" id="login_form" class="box">
					<h2 class="color2">{l s='Already registered?'}</h2>
					<div class="form_content clearfix">
						<div class="form-group">
							<label for="email" class="form-label">{l s='Email address'}<span class="required">*</span></label>
							<input class="is_required validate account_input form-control input-lg" data-validate="isEmail" type="text" id="email" name="email" value="{if isset($smarty.post.email)}{$smarty.post.email|stripslashes}{/if}" />
						</div>
						<div class="form-group">
							<label for="passwd" class="form-label">{l s='Password'}<span class="required">*</span></label>
							<span><input class="is_required validate account_input form-control input-lg" type="password" data-validate="isPasswd" id="passwd" name="passwd" value="{if isset($smarty.post.passwd)}{$smarty.post.passwd|stripslashes}{/if}" /></span>
						</div>
						<a class="help-block" href="{$link->getPageLink('password')|escape:'html':'UTF-8'}" title="{l s='Recover your forgotten password'}" rel="nofollow">{l s='Forgot your password?'}</a>
						<div class="xs-margin"></div>
						<input type="submit" id="SubmitLogin" name="SubmitLogin" class="btn btn-custom btn-lg min-width button_111_hover" value="{l s='Sign in'}">						
					</div>
				</form>
			</div>
		</div>
		{if isset($inOrderProcess) && $inOrderProcess && $PS_GUEST_CHECKOUT_ENABLED}						
			<form action="{$link->getPageLink('authentication', true, NULL, "back=$back")|escape:'html':'UTF-8'}" method="post" id="new_account_form" class="std clearfix">
				<div class="row">
                    <div class="col-sm-6 padding-right-md">
                        <h2 class="color2">{l s='Your Personal Details'}</h2>
                        <div class="required form-group">
							<label for="guest_email" class="form-label">{l s='Email address'} <sup>*</sup></label>
							<input required type="email" class="is_required validate form-control input-lg" data-validate="isEmail" id="guest_email" name="guest_email" value="{if isset($smarty.post.guest_email)}{$smarty.post.guest_email}{/if}" />
						</div>
						<div class="form-group">
                            <label for="id_gender" class="form-label">{l s='Title'}</label>
                            <div class="large-selectbox clearfix">
                                <select id="id_gender" name="id_gender" class="selectbox">
                                	{foreach from=$genders key=k item=gender}
                                		<option value="{$gender->id}">{$gender->name}</option>
                                	{/foreach}		                                    
                                </select>
                            </div>
                        </div>
						
						<div class="required form-group">
							<label for="firstname" class="form-label">{l s='First name'} <sup>*</sup></label>
							<input type="text" required class="is_required validate form-control input-lg" data-validate="isName" id="firstname" name="firstname" value="{if isset($smarty.post.firstname)}{$smarty.post.firstname}{/if}" />
						</div>
						<div class="required form-group">
							<label for="lastname" class="form-label">{l s='Last name'} <sup>*</sup></label>
							<input type="text" required class="is_required validate form-control input-lg" data-validate="isName" id="lastname" name="lastname" value="{if isset($smarty.post.lastname)}{$smarty.post.lastname}{/if}" />
						</div>
						<div class="form-group date-select">
							<label class="form-label">{l s='Date of Birth'}</label>
							<div class="row">
								<div class="col-xs-4">
									<div class="large-selectbox clearfix">
		                                <select id="days" name="days" class="selectbox">
		                                	<option value="">-</option>
											{foreach from=$days item=day}
												<option value="{$day}" {if ($sl_day == $day)} selected="selected"{/if}>{$day}&nbsp;&nbsp;</option>
											{/foreach}	                                    
		                                </select>
		                            </div>
								</div>
								<div class="col-xs-4">
									<div class="large-selectbox clearfix">
		                                <select id="months" name="months" class="selectbox">
		                                	<option value="">-</option>
		                                	{foreach from=$months key=k item=month}
												<option value="{$k}" {if ($sl_month == $k)} selected="selected"{/if}>{l s=$month}&nbsp;</option>
											{/foreach}	                                    
		                                </select>
		                            </div>
		                            
								</div>
								<div class="col-xs-4">
									<div class="large-selectbox clearfix">
		                                <select id="years" name="years" class="selectbox">
		                                	<option value="">-</option>
											{foreach from=$years item=year}
												<option value="{$year}" {if ($sl_year == $year)} selected="selected"{/if}>{$year}&nbsp;&nbsp;</option>
											{/foreach}                                    
		                                </select>
		                            </div>											
								</div>
							</div>
						</div>						
						<div id="opc_invoice_address"  class="unvisible">
							{assign var=stateExist value=false}
							{assign var=postCodeExist value=false}
							<div class="lg-margin2x"></div>
							<h2 class="color2">{l s='Invoice address'}</h2>							
							{foreach from=$inv_all_fields item=field_name}
							{if $field_name eq "company" && $b2b_enable}
							<div class="form-group">
								<label for="company_invoice" class="form-label">{l s='Company'}</label>
								<input type="text" class="text form-control input-lg" id="company_invoice" name="company_invoice" value="" />
							</div>
							{elseif $field_name eq "vat_number"}
							<div id="vat_number_block_invoice" class="is_customer_param" style="display:none;">
								<div class="form-group">
									<label for="vat_number_invoice" class="form-label">{l s='VAT number'}</label>
									<input type="text" class="form-control input-lg" id="vat_number_invoice" name="vat_number_invoice" value="" />
								</div>
							</div>
							{elseif $field_name eq "dni"}
							{assign var=dniExist value=true}
							<div class="required form-group dni_invoice">
								<label for="dni" class="form-label">{l s='Identification number'} <sup>*</sup></label>
								<input type="text" class="text form-control input-lg" name="dni_invoice" id="dni_invoice" value="{if isset($guestInformations) && $guestInformations.dni_invoice}{$guestInformations.dni_invoice}{/if}" />
								<span class="form_info">{l s='DNI / NIF / NIE'}</span>
							</div>
							{elseif $field_name eq "firstname"}
							<div class="required form-group">
								<label for="firstname_invoice" class="form-label">{l s='First name'} <sup>*</sup></label>
								<input type="text" class="form-control input-lg" id="firstname_invoice" name="firstname_invoice" value="{if isset($guestInformations) && $guestInformations.firstname_invoice}{$guestInformations.firstname_invoice}{/if}" />
							</div>
							{elseif $field_name eq "lastname"}
							<div class="required form-group">
								<label for="lastname_invoice" class="form-label">{l s='Last name'} <sup>*</sup></label>
								<input type="text" class="form-control input-lg" id="lastname_invoice" name="lastname_invoice" value="{if isset($guestInformations) && $guestInformations.lastname_invoice}{$guestInformations.lastname_invoice}{/if}" />
							</div>
							{elseif $field_name eq "address1"}
							<div class="required form-group">
								<label for="address1_invoice" class="form-label">{l s='Address'} <sup>*</sup></label>
								<input type="text" class="form-control input-lg" name="address1_invoice" id="address1_invoice" value="{if isset($guestInformations) && $guestInformations.address1_invoice}{$guestInformations.address1_invoice}{/if}" />
							</div>
							{elseif $field_name eq "address2"}
							<div class="form-group is_customer_param">
								<label for="address2_invoice" class="form-label">{l s='Address (Line 2)'}</label>
								<input type="text" class="form-control input-lg" name="address2_invoice" id="address2_invoice" value="{if isset($guestInformations) && $guestInformations.address2_invoice}{$guestInformations.address2_invoice}{/if}" />
							</div>
							{elseif $field_name eq "postcode"}
							{$postCodeExist = true}
							<div class="required postcode_invoice form-group">
								<label for="postcode_invoice" class="form-label">{l s='Zip/Postal Code'} <sup>*</sup></label>
								<input type="text" class="form-control input-lg" name="postcode_invoice" id="postcode_invoice" value="{if isset($guestInformations) && $guestInformations.postcode_invoice}{$guestInformations.postcode_invoice}{/if}" onkeyup="$('#postcode_invoice').val($('#postcode_invoice').val().toUpperCase());" />
							</div>
							{elseif $field_name eq "city"}
							<div class="required form-group">
								<label for="city_invoice" class="form-label">{l s='City'} <sup>*</sup></label>
								<input type="text" class="form-control input-lg" name="city_invoice" id="city_invoice" value="{if isset($guestInformations) && $guestInformations.city_invoice}{$guestInformations.city_invoice}{/if}" />
							</div>
							{elseif $field_name eq "country" || $field_name eq "Country:name"}
							<div class="form-group">
	                            <label for="id_country_invoice" class="form-label">{l s='Country'}</label>
	                            <div class="large-selectbox clearfix">
	                                <select name="id_country_invoice" id="id_country_invoice" class="selectbox">
	                                	<option value="">-</option>
										{foreach from=$countries item=v}
										<option value="{$v.id_country}"{if (isset($guestInformations) AND $guestInformations.id_country_invoice == $v.id_country) OR (!isset($guestInformations) && $sl_country == $v.id_country)} selected="selected"{/if}>{$v.name|escape:'html':'UTF-8'}</option>
										{/foreach}		                                    
									</select>
	                            </div>
	                        </div>			                      
							{elseif $field_name eq "state" || $field_name eq 'State:name'}
							{$stateExist = true}
							<div class="form-group">
	                            <label for="id_state_invoice" class="form-label">{l s='State'}</label>
	                            <div class="large-selectbox clearfix">
	                                <select name="id_state_invoice" id="id_state_invoice" class="selectbox">
	                                	<option value="">-</option>														                                   
									</select>
	                            </div>
	                        </div>			                        
							{/if}
							{/foreach}
							{if !$postCodeExist}
							<div class="required postcode_invoice form-group unvisible">
								<label for="postcode_invoice" class="form-label">{l s='Zip/Postal Code'} <sup>*</sup></label>
								<input type="text" class="form-control input-lg" name="postcode_invoice" id="postcode_invoice" value="" onkeyup="$('#postcode').val($('#postcode').val().toUpperCase());" />
							</div>
							{/if}					
							{if !$stateExist}
							<div class="form-group">
	                            <label for="id_state_invoice" class="form-label">{l s='State'}</label>
	                            <div class="large-selectbox clearfix">
	                                <select name="id_state_invoice" id="id_state_invoice" class="selectbox">
	                                	<option value="">-</option>														                                   
									</select>
	                            </div>
	                        </div>
							
							{/if}
							<div class="form-group is_customer_param">
								<label for="other_invoice" class="form-label">{l s='Additional information'}</label>
								<textarea class="form-control input-lg" name="other_invoice" id="other_invoice" cols="26" rows="3"></textarea>
							</div>
							{if isset($one_phone_at_least) && $one_phone_at_least}
								<p class="inline-infos required is_customer_param">{l s='You must register at least one phone number.'}</p>
							{/if}					
							<div class="form-group is_customer_param">
								<label for="phone_invoice" class="form-label">{l s='Home phone'}</label>
								<input type="text" class="form-control input-lg" name="phone_invoice" id="phone_invoice" value="{if isset($guestInformations) && $guestInformations.phone_invoice}{$guestInformations.phone_invoice}{/if}" />
							</div>
							<div class="{if isset($one_phone_at_least) && $one_phone_at_least}required {/if}form-group">
								<label for="phone_mobile_invoice" class="form-label">{l s='Mobile phone'}{if isset($one_phone_at_least) && $one_phone_at_least} <sup>*</sup>{/if}</label>
								<input type="text" class="form-control input-lg" name="phone_mobile_invoice" id="phone_mobile_invoice" value="{if isset($guestInformations) && $guestInformations.phone_mobile_invoice}{$guestInformations.phone_mobile_invoice}{/if}" />
							</div>
							<input type="hidden" name="alias_invoice" id="alias_invoice" value="{l s='My Invoice address'}" />
						</div>
                    </div>
                    <div class="md-margin visible-xs clearfix"></div>
                    <div class="col-sm-6 padding-left-md">
                        <h2 class="color2">{l s='Delivery address'}</h2>
						{foreach from=$dlv_all_fields item=field_name}
							{if $field_name eq "company" && $b2b_enable}
								<div class="form-group">
									<label for="company" class="form-label">{l s='Company'}</label>
									<input type="text" class="form-control input-lg" id="company" name="company" value="{if isset($smarty.post.company)}{$smarty.post.company}{/if}" />
								</div>
							{elseif $field_name eq "vat_number"}
								<div id="vat_number" style="display:none;">
									<div class="form-group">
										<label for="vat-number" class="form-label">{l s='VAT number'}</label>
										<input id="vat-number" type="text" class="form-control input-lg" name="vat_number" value="{if isset($smarty.post.vat_number)}{$smarty.post.vat_number}{/if}" />
									</div>
								</div>
								{elseif $field_name eq "dni"}
								{assign var='dniExist' value=true}
								<div class="required dni form-group">
									<label for="dni" class="form-label">{l s='Identification number'} <sup>*</sup></label>
									<input type="text" class="form-control input-lg" name="dni" id="dni" value="{if isset($smarty.post.dni)}{$smarty.post.dni}{/if}" />
									<span class="form_info">{l s='DNI / NIF / NIE'}</span>
								</div>
							{elseif $field_name eq "address1"}
								<div class="required form-group">
									<label for="address1" class="form-label">{l s='Address'} <sup>*</sup></label>
									<input type="text" class="form-control input-lg" name="address1" id="address1" value="{if isset($smarty.post.address1)}{$smarty.post.address1}{/if}" />
								</div>
							{elseif $field_name eq "address2"}
								<div class="form-group is_customer_param">
									<label for="address2" class="form-label">{l s='Address (Line 2)'} <sup>*</sup></label>
									<input type="text" class="form-control input-lg" name="address2" id="address2" value="{if isset($smarty.post.address2)}{$smarty.post.address2}{/if}" />
								</div>
							{elseif $field_name eq "postcode"}
								{assign var='postCodeExist' value=true}
								<div class="required postcode form-group">
									<label for="postcode" class="form-label">{l s='Zip/Postal Code'} <sup>*</sup></label>
									<input type="text" class="form-control input-lg" name="postcode" id="postcode" value="{if isset($smarty.post.postcode)}{$smarty.post.postcode}{/if}" onkeyup="$('#postcode').val($('#postcode').val().toUpperCase());" />
								</div>
							{elseif $field_name eq "city"}
								<div class="required form-group">
									<label for="city" class="form-label">{l s='City'} <sup>*</sup></label>
									<input type="text" class="form-control input-lg" name="city" id="city" value="{if isset($smarty.post.city)}{$smarty.post.city}{/if}" />
								</div>
								<!-- if customer hasn't update his layout address, country has to be verified but it's deprecated -->
							{elseif $field_name eq "Country:name" || $field_name eq "country"}
								<div class="form-group">
		                            <label for="id_country" class="form-label">{l s='State'}</label>
		                            <div class="large-selectbox clearfix">
		                                <select name="id_country" id="id_country"  class="selectbox ">
		                                	{foreach from=$countries item=v}
												<option value="{$v.id_country}"{if (isset($smarty.post.id_country) AND  $smarty.post.id_country == $v.id_country) OR (!isset($smarty.post.id_country) && $sl_country == $v.id_country)} selected="selected"{/if}>{$v.name}</option>
											{/foreach}												                                   
										</select>
		                            </div>
		                        </div>
								
							{elseif $field_name eq "State:name"}
								{assign var='stateExist' value=true}
								<div class="form-group">
		                            <label for="id_state" class="form-label">{l s='State'}</label>
		                            <div class="large-selectbox clearfix">
		                                <select name="id_state" id="id_state" class="selectbox">
											<option value="">-</option>
										</select>
		                            </div>
		                        </div>
		                        
							{/if}
						{/foreach}
						{if $stateExist eq false}
							<div class="form-group">
	                            <label for="id_state" class="form-label">{l s='State'}</label>
	                            <div class="large-selectbox clearfix">
	                                <select name="id_state" id="id_state"  class="selectbox">
										<option value="">-</option>
									</select>
	                            </div>
	                        </div>
							
						{/if}
						{if $postCodeExist eq false}
							<div class="required postcode unvisible form-group">
								<label for="postcode" class="form-label">{l s='Zip/Postal Code'} <sup>*</sup></label>
								<input type="text" class="form-control input-lg" name="postcode" id="postcode" value="{if isset($smarty.post.postcode)}{$smarty.post.postcode}{/if}" onkeyup="$('#postcode').val($('#postcode').val().toUpperCase());" />
							</div>
						{/if}
						{if $dniExist eq false}
							<div class="required form-group dni_invoice">
								<label for="dni" class="form-label">{l s='Identification number'} <sup>*</sup></label>
								<input type="text" class="text form-control input-lg" name="dni_invoice" id="dni_invoice" value="{if isset($guestInformations) && $guestInformations.dni_invoice}{$guestInformations.dni_invoice}{/if}" />
								<span class="form_info">{l s='DNI / NIF / NIE'}</span>
							</div>
						{/if}
						<div class="{if isset($one_phone_at_least) && $one_phone_at_least}required {/if}form-group">
							<label for="phone_mobile" class="form-label">{l s='Mobile phone'}{if isset($one_phone_at_least) && $one_phone_at_least} <sup>*</sup>{/if}</label>
							<input type="text" class="form-control input-lg" name="phone_mobile" id="phone_mobile" value="{if isset($smarty.post.phone_mobile)}{$smarty.post.phone_mobile}{/if}" />
						</div>
						<input type="hidden" name="alias" id="alias" value="{l s='My address'}" />
						<input type="hidden" name="is_new_customer" id="is_new_customer" value="0" />
						<div class="checkbox">
							<input type="checkbox" name="invoice_address" id="invoice_address"{if (isset($smarty.post.invoice_address) && $smarty.post.invoice_address) || (isset($guestInformations) && $guestInformations.invoice_address)} checked="checked"{/if} autocomplete="off"/>
		                	<label for="invoice_address" class="form-label">
								
								{l s='Please use another address for invoice'}
							</label>
						</div>
						
                    </div>
                </div>
                <div class="lg-margin2x"></div>
                <div class="row">
                    <div class="col-sm-6 padding-right-md">
                        
                    </div>
                    <div class="md-margin visible-xs clearfix"></div>
                    <div class="col-sm-6 padding-left-md">
                    	{if isset($newsletter) && $newsletter}
                    		<h2 class="color2">{l s='Newsletter'}</h2>
							<div class="checkbox">
								<input type="checkbox" name="newsletter" id="newsletter" value="1" {if isset($smarty.post.newsletter) && $smarty.post.newsletter == '1'}checked="checked"{/if} />
								<label for="newsletter" class="form-label">{l s='Sign up for our newsletter!'}</label>
							</div>
							<div class="checkbox">
								<input type="checkbox" name="optin" id="optin" value="1" {if isset($smarty.post.optin) && $smarty.post.optin == '1'}checked="checked"{/if} />
								<label for="optin" class="form-label">										{l s='Receive special offers from our partners!'}</label>
							</div>
						{/if}
						
                        <div class="xs-margin"></div>
                        <input type="submit" name="submitGuestAccount" id="submitGuestAccount" class="btn btn-custom btn-lg" value="{l s='Create Account'}">
                        <div class="lg-margin2x"></div>
                        {$HOOK_CREATE_ACCOUNT_FORM}
                    </div>
                </div>
			</form>					
		{/if}
	</div>
	<div class="lg-margin2x"></div>	
</section>

<!-- ============================================================================================================= -->				
{else}
<!-- ============================================================================================================= -->
<section id="content" role="main">
	{include file="$tpl_dir./breadcrumb.tpl"}
	<div class="xs-margin half"></div>	
	<div class="container">
		<div class="row">
			<div class="col-sm-18 col-sm-offset-4">

				<form action="{$link->getPageLink('authentication', true)|escape:'html':'UTF-8'}" method="post" id="account-creation_form" class="std box">
					<div class="row">
						<div class="col-sm-24 padding-right-md">
                        	{$HOOK_CREATE_ACCOUNT_TOP}
							<div class="account_creation">
								<h2 class="color2">{l s='Your personal information'}</h2>
								
								
								<div class="form-group">
		                            <label for="id_gender" class="form-label">{l s='Title'}</label>
		                            <div class="large-selectbox clearfix">
		                                <select id="id_gender" name="id_gender" class="selectbox">
		                                	{foreach from=$genders key=k item=gender}
		                                		<option value="{$gender->id}">{$gender->name}</option>
		                                	{/foreach}		                                    
		                                </select>
		                            </div>
		                        </div>
								
								<div class="required form-group">
									<label for="customer_firstname" class="form-label">{l s='First name'} <sup>*</sup></label>
									<input onkeyup="$('#firstname').val(this.value);" type="text" class="is_required validate form-control input-lg" data-validate="isName" id="customer_firstname" name="customer_firstname" value="{if isset($smarty.post.customer_firstname)}{$smarty.post.customer_firstname}{/if}" />							
								</div>
								<div class="required form-group">
									<label for="customer_lastname" class="form-label">{l s='Last name'} <sup>*</sup></label>
									<input onkeyup="$('#lastname').val(this.value);" type="text" class="is_required validate form-control input-lg" data-validate="isName" id="customer_lastname" name="customer_lastname" value="{if isset($smarty.post.customer_lastname)}{$smarty.post.customer_lastname}{/if}" />							
								</div>
								
								<div class="required form-group">
									<label for="email" class="form-label">{l s='Email'} <sup>*</sup></label>
									<input type="text" class="is_required validate form-control input-lg" data-validate="isEmail" id="email" name="email" value="{if isset($smarty.post.email)}{$smarty.post.email}{/if}" />
								</div>
								<div class="required password form-group">
									<label for="passwd" class="form-label">{l s='Password'} <sup>*</sup></label>
									<input type="password" class="is_required validate form-control input-lg" data-validate="isPasswd" name="passwd" id="passwd" />
									<span class="form_info">{l s='(Five characters minimum)'}</span>
								</div> 
								
								<div class="form-group date-select">
									<label class="form-label">{l s='Date of Birth'}</label>
									<div class="row">
										<div class="col-xs-4">
											<div class="large-selectbox clearfix">
												<select id="days" name="days" class="selectbox">
													<option value="">-</option>
													{foreach from=$days item=day}
														<option value="{$day}" {if ($sl_day == $day)} selected="selected"{/if}>{$day}&nbsp;&nbsp;</option>
													{/foreach}
												</select>										
				                            </div>
										</div>
										<div class="col-xs-4">
											<div class="large-selectbox clearfix">
				                                <select id="months" name="months" class="selectbox">
													<option value="">-</option>
													{foreach from=$months key=k item=month}
														<option value="{$k}" {if ($sl_month == $k)} selected="selected"{/if}>{l s=$month}&nbsp;</option>
													{/foreach}
												</select>
				                            </div>
				                            
										</div>
										<div class="col-xs-4">
											<div class="large-selectbox clearfix">
				                                <select id="years" name="years" class="selectbox">
													<option value="">-</option>
													{foreach from=$years item=year}
														<option value="{$year}" {if ($sl_year == $year)} selected="selected"{/if}>{$year}&nbsp;&nbsp;</option>
													{/foreach}
												</select>
				                            </div>											
										</div>
									</div>
								</div>	
								
								
								{if $newsletter}
									<div class="checkbox">
										<input type="checkbox" name="newsletter" id="newsletter" value="1" {if isset($smarty.post.newsletter) AND $smarty.post.newsletter == 1} checked="checked"{/if} />
										<label for="newsletter" class="form-label">{l s='Sign up for our newsletter!'}</label>
									</div>
									<div class="checkbox">
										<input type="checkbox" name="optin" id="optin" value="1" {if isset($smarty.post.optin) AND $smarty.post.optin == 1} checked="checked"{/if} />
										<label for="optin" class="form-label">{l s='Receive special offers from our partners!'}</label>
									</div>
								{/if}
							</div>
							
							<div class="lg-margin2x"></div>
							{$HOOK_CREATE_ACCOUNT_FORM}
							<div class="submit clearfix">
								<input type="hidden" name="email_create" value="1" />
								<input type="hidden" name="is_new_customer" value="1" />
								{if isset($back)}<input type="hidden" class="hidden" name="back" value="{$back|escape:'html':'UTF-8'}" />{/if}
								<input type="submit" name="submitAccount" id="submitAccount" class="btn btn-custom btn-lg" value="{l s='Register'}">
								
								
							</div>
							
							
                    	</div>
						<div class="md-margin visible-xs clearfix"></div>
						<div class="col-sm-6 padding-left-md">
	                        {if $b2b_enable}
							<div class="account_creation">
								<h2 class="color">{l s='Your company information'}</h2>
								<div class="form-group">
									<label for="company" class="form-label">{l s='Company'}</label>
									<input type="text" class="form-control input-lg" id="company" name="company" value="{if isset($smarty.post.company)}{$smarty.post.company}{/if}" />								
								</div>
								<div class="form-group">
									<label for="siret" class="form-label">{l s='SIRET'}</label>
									<input type="text" class="form-control input-lg" id="siret" name="siret" value="{if isset($smarty.post.siret)}{$smarty.post.siret}{/if}" />																
								</div>
								<div class="form-group">
									<label for="ape" class="form-label">{l s='APE'}</label>
									<input type="text" class="form-control input-lg" id="ape" name="ape" value="{if isset($smarty.post.ape)}{$smarty.post.ape}{/if}" />																
								</div>
								<div class="form-group">
									<label for="website" class="form-label">{l s='Website'}</label>
									<input type="text" class="form-control input-lg" id="website" name="website" value="{if isset($smarty.post.website)}{$smarty.post.website}{/if}" />																
								</div>							
							</div>
						{/if}
						{if isset($PS_REGISTRATION_PROCESS_TYPE) && $PS_REGISTRATION_PROCESS_TYPE}
							<div class="account_creation">
								<div class="lg-margin2x"></div>
								<h2 class="color">{l s='Your address'}</h2>
								{foreach from=$dlv_all_fields item=field_name}
									{if $field_name eq "company"}
										{if !$b2b_enable}
											<div class="form-group">
												<label for="company" class="form-label">{l s='Company'}</label>
												<input type="text" class="form-control input-lg" id="company" name="company" value="{if isset($smarty.post.company)}{$smarty.post.company}{/if}" />
											</div>										
										{/if}
									{elseif $field_name eq "vat_number"}									
										<div id="vat_number" style="display:none;">
											<div class="form-group" >
												<label for="vat_number" class="form-label">{l s='VAT number'}</label>
												<input type="text" class="form-control input-lg" name="vat_number" value="{if isset($smarty.post.vat_number)}{$smarty.post.vat_number}{/if}" />
											</div>										
										</div>
									{elseif $field_name eq "firstname"}
										<div class="required form-group" >
											<label for="firstname" class="form-label">{l s='First name'} <sup>*</sup></label>
											<input type="text" class="form-control input-lg" id="firstname" name="firstname" value="{if isset($smarty.post.firstname)}{$smarty.post.firstname}{/if}" />
										</div>										
									{elseif $field_name eq "lastname"}
										<div class="required form-group" >
											<label for="lastname" class="form-label">{l s='Last name'} <sup>*</sup></label>
											<input type="text" class="form-control input-lg" id="lastname" name="lastname" value="{if isset($smarty.post.lastname)}{$smarty.post.lastname}{/if}" />
										</div>									
									{elseif $field_name eq "address1"}
										<div class="required form-group" >
											<label for="address1" class="form-label">{l s='Address'} <sup>*</sup></label>
											<input type="text" class="form-control input-lg" name="address1" id="address1" value="{if isset($smarty.post.address1)}{$smarty.post.address1}{/if}" />
											<span class="inline-infos">{l s='Street address, P.O. Box, Company name, etc.'}</span>
										</div>
										
									{elseif $field_name eq "address2"}
										<div class="is_customer_param form-group" >
											<label for="address2" class="form-label">{l s='Address (Line 2)'}</label>
											<input type="text" class="form-control input-lg" name="address2" id="address2" value="{if isset($smarty.post.address2)}{$smarty.post.address2}{/if}" />
											<span class="inline-infos">{l s='Apartment, suite, unit, building, floor, etc...'}</span>
										</div>
									{elseif $field_name eq "postcode"}
										{assign var='postCodeExist' value=true}
										<div class="required form-group postcode" >
											<label for="postcode" class="form-label">{l s='Zip/Postal Code'} <sup>*</sup></label>
											<input type="text" class="form-control input-lg" name="postcode" id="postcode" value="{if isset($smarty.post.postcode)}{$smarty.post.postcode}{/if}" onkeyup="$('#postcode').val($('#postcode').val().toUpperCase());" />
										</div>
									{elseif $field_name eq "city"}
										<div class="required form-group" >
											<label for="city" class="form-label">{l s='City'} <sup>*</sup></label>
											<input type="text" class="form-control input-lg" name="city" id="city" value="{if isset($smarty.post.city)}{$smarty.post.city}{/if}" />
										</div>									
										<!-- if customer hasn't update his layout address, country has to be verified but it's deprecated -->
									{elseif $field_name eq "Country:name" || $field_name eq "country"}
										
										<div class="required select form-group">
				                            <label for="id_country" class="form-label">{l s='Country'}</label>
				                            <div class="large-selectbox clearfix">
				                                <select  name="id_country" id="id_country" class="selectbox">
				                                	<option value="">-</option>
													{foreach from=$countries item=v}
													<option value="{$v.id_country}"{if (isset($smarty.post.id_country) AND $smarty.post.id_country == $v.id_country) OR (!isset($smarty.post.id_country) && $sl_country == $v.id_country)} selected="selected"{/if}>{$v.name}</option>
													{/foreach}		                                    
				                                </select>
				                            </div>
				                        </div>
	
									{elseif $field_name eq "State:name" || $field_name eq 'state'}
										{assign var='stateExist' value=true}
										<div class="required select form-group">
				                            <label for="id_state" class="form-label">{l s='State'}</label>
				                            <div class="large-selectbox clearfix">
				                                <select  name="id_state" id="id_state" class="selectbox">
				                                	<option value="">-</option>
				                                </select>
				                            </div>
				                        </div>			                        
									{/if}
								{/foreach}
								{if $postCodeExist eq false}
									<div class="required postcode form-group unvisible" >
										<label for="postcode" class="form-label">{l s='Zip/Postal Code'} <sup>*</sup></label>
										<input type="text" class="form-control input-lg" name="postcode" id="postcode" value="{if isset($smarty.post.postcode)}{$smarty.post.postcode}{/if}" onkeyup="$('#postcode').val($('#postcode').val().toUpperCase());" />
									</div>									
								{/if}		
								{if $stateExist eq false}
									<div class="required id_state select unvisible form-group">
			                            <label for="id_state" class="form-label">{l s='State'}</label>
			                            <div class="large-selectbox clearfix">
			                                <select name="id_state" id="id_state" class="form-control">
												<option value="">-</option>
											</select>
			                            </div>
			                        </div>
								{/if}
								<div class="  form-group " >
									<label for="other" class="form-label">{l s='Additional information'}</label>
									<textarea class="form-control input-lg" name="other" id="other" cols="26" rows="3">{if isset($smarty.post.other)}{$smarty.post.other}{/if}</textarea>
								</div>
								
								{if isset($one_phone_at_least) && $one_phone_at_least}
									<p class="inline-infos">{l s='You must register at least one phone number.'}</p>
								{/if}
								<div class="  form-group " >
									<label for="phone" class="form-label">{l s='Home phone'}</label>
									<input type="text" class="form-control input-lg" name="phone" id="phone" value="{if isset($smarty.post.phone)}{$smarty.post.phone}{/if}" />
								</div>
								<div class="{if isset($one_phone_at_least) && $one_phone_at_least}required {/if}form-group" >
									<label for="phone_mobile" class="form-label">{l s='Mobile phone'}{if isset($one_phone_at_least) && $one_phone_at_least} <sup>*</sup>{/if}</label>
									<input type="text" class="form-control input-lg" name="phone_mobile" id="phone_mobile" value="{if isset($smarty.post.phone_mobile)}{$smarty.post.phone_mobile}{/if}" />
								</div>
								<div class="required form-group" id="address_alias" >
									<label for="alias" class="form-label">{l s='Assign an address alias for future reference.'} <sup>*</sup></label>
									<input type="text" class="form-control input-lg" name="alias" id="alias" value="{if isset($smarty.post.alias)}{$smarty.post.alias}{else}{l s='My address'}{/if}" />
								</div>
	
							</div>
							<div class="account_creation dni">
								<h2 class="color">{l s='Tax identification'}</h2>
								<div class="required form-group" >
									<label for="dni" class="form-label">{l s='Identification number'} <sup>*</sup></label>
									<input type="text" class="form-control input-lg" name="dni" id="dni" value="{if isset($smarty.post.dni)}{$smarty.post.dni}{/if}" />
									<span class="form_info">{l s='DNI / NIF / NIE'}</span>
								</div>
								
							</div>
						{/if}
                    	</div>
					</div>					
					
					
					
				</form>
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
			</div>
		</div>
	</div>
	<div class="lg-margin2x"></div>	
</section>
	<!--{if isset($account_error)}
	<div class="error">
		{if {$account_error|@count} == 1}
			<p>{l s='There\'s at least one error'} :</p>
			{else}
			<p>{l s='There are %s errors' sprintf=[$account_error|@count]} :</p>
		{/if}
		<ol>
			{foreach from=$account_error item=v}
				<li>{$v}</li>
			{/foreach}
		</ol>
	</div>
	{/if}-->
	
<!-- ============================================================================================================= -->	
{/if}
<!-- ============================================================================================================= -->
{strip}
{if isset($smarty.post.id_state) && $smarty.post.id_state}
	{addJsDef idSelectedState=$smarty.post.id_state|intval}
{else if isset($address->id_state) && $address->id_state}
	{addJsDef idSelectedState=$address->id_state|intval}
{else}
	{addJsDef idSelectedState=false}
{/if}
{if isset($smarty.post.id_country) && $smarty.post.id_country}
	{addJsDef idSelectedCountry=$smarty.post.id_country|intval}
{else if isset($address->id_country) && $address->id_country}
	{addJsDef idSelectedCountry=$address->id_country|intval}
{else}
	{addJsDef idSelectedCountry=false}
{/if}
{if isset($countries)}
	{addJsDef countries=$countries}
{/if}
{if isset($vatnumber_ajax_call) && $vatnumber_ajax_call}
	{addJsDef vatnumber_ajax_call=$vatnumber_ajax_call}
{/if}
{if isset($email_create) && $email_create}
	{addJsDef email_create=$email_create|boolval}
{else}
	{addJsDef email_create=false}
{/if}
{/strip}