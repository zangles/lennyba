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

{if $PS_SC_TWITTER || $PS_SC_FACEBOOK || $PS_SC_GOOGLE || $PS_SC_PINTEREST}
<div class="share-box"><span class="share-label">Share</span>
    <ul class="social-links clearfix">
        <li>
            <a href="javascript:voif(0)" class="social-icon icon-facebook social-sharing" data-type="facebook" title="Facebook"></a>
        </li>
        <li>
            <a href="javascript:voif(0)" class="social-icon icon-twitter social-sharing" data-type="twitter" title="Twitter"></a>
        </li>
        <li>
            <a href="javascript:voif(0)" class="social-icon icon-linkedin social-sharing" data-type="linkedin"  title="Linkedin"></a>
        </li>
        {if Module::isInstalled('sendtoafriend')}
        <li>
            <a id="send_friend_button" href="#send_friend_form" class="social-icon icon-email" title="Email"></a>
            <div style="display: none;">
				<div id="send_friend_form" style="top: 100px">
					<h2  class="page-subheading">
						{l s='Send to a friend'}
					</h2>
					<div class="row">
						<div class="product clearfix col-xs-12 col-sm-5">
							<img src="{$link->getImageLink($product->link_rewrite, $stf_product_cover, 'home_default')|escape:'html':'UTF-8'}" class="responsive" alt="{$product->name|escape:'html':'UTF-8'}" style="max-width: 100%" />
							<div class="product-name">								
								<strong>{$product->name}</strong>
							</div>
						</div><!-- .product -->
						<div class="send_friend_form_content col-xs-12 col-sm-7" id="send_friend_form_content">
							<div id="send_friend_form_error"></div>
							<div id="send_friend_form_success"></div>
							<div class="form_container">
								<div class="form-group form-error">
									<label class="form-label" for="friend_name">{l s='Name of your friend' }<span class="required">*</span></label>
									<input type="text" value="" name="friend_name" id="friend_name" class="form-control">
								</div>
								<div class="form-group form-error">
									<label class="form-label" for="email">{l s='E-mail address' }<span class="required">*</span></label>
									<input type="text" value="" name="friend_email" id="friend_email" class="form-control">
								</div>
								
							</div>
							<p class="submit">
								<input type="submit" value="{l s='Send' }" class="btn btn-custom min-width button_111_hover" name="sendEmail" id="sendEmail">
								
								{l s='or' }&nbsp;
								<a class="closefb" href="#">
									{l s='Cancel' }
								</a>
							</p>
						</div> <!-- .send_friend_form_content -->
						<!--
						<div class="xs-margin"></div>
						<div class="col-sm-12">
							{$product->description_short}
						</div>
						-->
					</div>
				</div>
			</div>
        </li>
        {/if}
        <li>
            <a href="javascript:voif(0)" class="social-icon icon-googleplus social-sharing" data-type="google-plus"  title="Google +"></a>
        </li>
    </ul>
</div>


{/if}