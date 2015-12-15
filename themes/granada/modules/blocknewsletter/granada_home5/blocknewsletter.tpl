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
<!-- Block Newsletter module-->
<div id="newsletter_block_left">
        <div class="sub-title bb-sub-title">{l s='Times A Ticking' mod='blocknewsletter'}</div>
        <h2 class="bb-title">{l s='Don\'t Miss Out' mod='blocknewsletter'}</h2>
        <div class="secondary-font bb-comment">{l s='Sybscribe for the latest styles and sales, plus get 25% off your first order.' mod='blocknewsletter'}</div>
		<form action="{$link->getPageLink('index')|escape:'html':'UTF-8'}" method="post" class="newsletter-form">
			<div class="form-group{if isset($msg) && $msg } {if $nw_error}form-error{else}form-ok{/if}{/if} newsletter-wrapper white-newsletter" >
				<div class="input-box">
                    <input class="input-text input-email" id="newsletter-input" type="text" name="email" size="18" placeholder="{l s='Enter your e-mail' mod='blocknewsletter'}" value="{if isset($msg) && $msg}{$msg}{elseif isset($value) && $value}{$value}{/if}" />
                </div>
                <div class="actions">
                    <button type="submit" name="submitNewsletter" class="button button-custom button-custom-active">
                        <span><span>{l s='Subscribe' mod='blocknewsletter'}</span></span>
                    </button>
                </div>
				<input type="hidden" name="action" value="0" />
			</div>
		</form>
</div>
<!-- /Block Newsletter module-->
{strip}
{if isset($msg) && $msg}
{addJsDef msg_newsl=$msg|@addcslashes:'\''}
{/if}
{if isset($nw_error)}
{addJsDef nw_error=$nw_error}
{/if}
{addJsDefL name=placeholder_blocknewsletter}{l s='Enter your e-mail' mod='blocknewsletter' js=1}{/addJsDefL}
{if isset($msg) && $msg}
	{addJsDefL name=alert_blocknewsletter}{l s='Newsletter : %1$s' sprintf=$msg js=1 mod="blocknewsletter"}{/addJsDefL}
{/if}
{/strip}