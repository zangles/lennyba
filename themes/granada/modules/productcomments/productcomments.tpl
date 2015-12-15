{*
* 2007-2015 PrestaShop
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
* Do not edit or add to this file if you wish to upgrade PrestaShop to newersend_friend_form_content
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2015 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
{if isset($product) && $product}
	{if !$product|is_array}	
		{*}
		{assign var='product' value=$product|get_object_vars}
		{*}	
		<div id="idTab5" class="tab-pane fade in">
			<div id="product_comments_block_tab" class="row">
				<div class="col-sm-7 padding-right-md review-comments">
					<h3>{$comments|@count} {l s='Review for' mod='productcomments'} "{$product->name}"</h3>
					<ul class="review-comments">				
					{foreach from=$comments item=comment}				
						{if $comment.content}
						{assign var='ratingValue' value=$comment.grade * 20}
						<li>
							<div class="review-comment" itemprop="review" itemscope itemtype="http://schema.org/Review">
		                        <div class="ratings-container" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
		                            <div class="ratings">
		                                <div class="ratings-result" data-result="{$ratingValue}"></div>
		                            </div>
		                            <meta itemprop="worstRating" content = "0" />
									<meta itemprop="ratingValue" content = "{$ratingValue|escape:'html':'UTF-8'}" />
		            				<meta itemprop="bestRating" content = "100" />
		                        </div>
		                        <figure>
		                            <img src="{$tpl_uri}images/user.jpg" alt="{$comment.customer_name}">
		                        </figure>
		                        <div class="review-comment-content">
		                            <h4 itemprop="name">{$comment.title}</h4>
		                            <meta itemprop="datePublished" content="{$comment.date_add|escape:'html':'UTF-8'|substr:0:10}" />
		                            <div class="review-comment-meta">{l s='by'} <a itemprop="author" href="#">{$comment.customer_name}</a> {l s='on'} {dateFormat date=$comment.date_add|escape:'html':'UTF-8' full=0}</div>
		                            <p itemprop="reviewBody">{$comment.content}</p>
		                        </div>
		                    </div>					
						</li>
						{/if}
					{/foreach}
					</ul>
				</div>
				<div class="lg-margin clearfix visible-xs"></div>
				<div class="col-sm-5 padding-left-md review-comment-form">
						
						{if (!$too_early AND ($is_logged OR $allow_guests))}
						
						<h3>{l s='Write your Review' mod='productcomments'}</h3>				
		                
		                <form id="id_new_comment_form" action="#">
		                	<input id="id_product_comment_send" name="id_product" type="hidden" value='{$id_product_comment_form}' />
		                	<div id="new_comment_form_error" class="error" style="display: none; padding: 15px 25px">
								<ul></ul>
							</div>
		                	{if $criterions|@count > 0}
								<ul id="criterions_list">
								{foreach from=$criterions item='criterion'}
									<li>
										<label>{$criterion.name|escape:'html':'UTF-8'}:</label>
										<div class="star_content">
											<input class="star" type="radio" name="criterion[{$criterion.id_product_comment_criterion|round}]" value="1" />
											<input class="star" type="radio" name="criterion[{$criterion.id_product_comment_criterion|round}]" value="2" />
											<input class="star" type="radio" name="criterion[{$criterion.id_product_comment_criterion|round}]" value="3" />
											<input class="star" type="radio" name="criterion[{$criterion.id_product_comment_criterion|round}]" value="4" checked="checked" />
											<input class="star" type="radio" name="criterion[{$criterion.id_product_comment_criterion|round}]" value="5" />
										</div>
										<div class="clearfix"></div>
									</li>
								{/foreach}
								</ul>
							{/if}
		                	{if $allow_guests == true && !$is_logged}
								<div class="form-group">
			                    	<input id="commentCustomerName" class="form-control input-lg" name="customer_name" type="text" value="" placeholder="{l s='Enter your nickname *' mod='productcomments'}"/>	                        
			                    </div>                    
							{/if}
		                    <div class="form-group">
		                    	<input id="comment_title" class="form-control input-lg" name="title" type="text" value="" placeholder="{l s='Enter comment title *' mod='productcomments'}"/>                        
		                    </div>                    
		                    <div class="form-group">
		                        <textarea name="content" id="content" class="form-control input-lg min-height" cols="30" rows="6" placeholder="{l s='Write your review *' mod='productcomments'}"></textarea>
		                    </div>
		                    <div class="xs-margin"></div>
		                    <input type="submit" id="submitNewMessage" class="btn btn-custom-5 btn-lg min-width" value="{l s='Submit Review' mod='productcomments'}">
		                </form>
		                {else}
		                	<h3>{l s='No customer reviews for the moment.' mod='productcomments'}</h3>	
		                {/if}			
					</div>					
			</div> <!-- #product_comments_block_tab -->
		</div>
	{else}	
		<div id="idTab5" class="tab-pane fade in">
			<div id="product_comments_block_tab" class="row">
				<div class="col-sm-7 padding-right-md review-comments">
					<h3>{$comments|@count} {l s='Review for' mod='productcomments'} "{$product.name}"</h3>
					<ul class="review-comments">				
					{foreach from=$comments item=comment}				
						{if $comment.content}
						{assign var='ratingValue' value=$comment.grade * 20}
						<li>
							<div class="review-comment" itemprop="review" itemscope itemtype="http://schema.org/Review">
		                        <div class="ratings-container" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
		                            <div class="ratings">
		                                <div class="ratings-result" data-result="{$ratingValue}"></div>
		                            </div>
		                            <meta itemprop="worstRating" content = "0" />
									<meta itemprop="ratingValue" content = "{$ratingValue|escape:'html':'UTF-8'}" />
		            				<meta itemprop="bestRating" content = "100" />
		                        </div>
		                        <figure>
		                            <img src="{$tpl_uri}images/user.jpg" alt="{$comment.customer_name}">
		                        </figure>
		                        <div class="review-comment-content">
		                            <h4 itemprop="name">{$comment.title}</h4>
		                            <meta itemprop="datePublished" content="{$comment.date_add|escape:'html':'UTF-8'|substr:0:10}" />
		                            <div class="review-comment-meta">{l s='by'} <a itemprop="author" href="#">{$comment.customer_name}</a> {l s='on'} {dateFormat date=$comment.date_add|escape:'html':'UTF-8' full=0}</div>
		                            <p itemprop="reviewBody">{$comment.content}</p>
		                        </div>
		                    </div>					
						</li>
						{/if}
					{/foreach}
					</ul>
				</div>
				<div class="lg-margin clearfix visible-xs"></div>
				<div class="col-sm-5 padding-left-md review-comment-form">
						
						{if (!$too_early AND ($is_logged OR $allow_guests))}
						
						<h3>{l s='Write your Review' mod='productcomments'}</h3>				
		                
		                <form id="id_new_comment_form" action="#">
		                	<input id="id_product_comment_send" name="id_product" type="hidden" value='{$id_product_comment_form}' />
		                	<div id="new_comment_form_error" class="error" style="display: none; padding: 15px 25px">
								<ul></ul>
							</div>
		                	{if $criterions|@count > 0}
								<ul id="criterions_list">
								{foreach from=$criterions item='criterion'}
									<li>
										<label>{$criterion.name|escape:'html':'UTF-8'}:</label>
										<div class="star_content">
											<input class="star" type="radio" name="criterion[{$criterion.id_product_comment_criterion|round}]" value="1" />
											<input class="star" type="radio" name="criterion[{$criterion.id_product_comment_criterion|round}]" value="2" />
											<input class="star" type="radio" name="criterion[{$criterion.id_product_comment_criterion|round}]" value="3" />
											<input class="star" type="radio" name="criterion[{$criterion.id_product_comment_criterion|round}]" value="4" checked="checked" />
											<input class="star" type="radio" name="criterion[{$criterion.id_product_comment_criterion|round}]" value="5" />
										</div>
										<div class="clearfix"></div>
									</li>
								{/foreach}
								</ul>
							{/if}
		                	{if $allow_guests == true && !$is_logged}
								<div class="form-group">
			                    	<input id="commentCustomerName" class="form-control input-lg" name="customer_name" type="text" value="" placeholder="{l s='Enter your nickname *' mod='productcomments'}"/>	                        
			                    </div>                    
							{/if}
		                    <div class="form-group">
		                    	<input id="comment_title" class="form-control input-lg" name="title" type="text" value="" placeholder="{l s='Enter comment title *' mod='productcomments'} "/>                        
		                    </div>                    
		                    <div class="form-group">
		                        <textarea name="content" id="content" class="form-control input-lg min-height" cols="30" rows="6" placeholder="{l s='Write your review *' mod='productcomments'}"></textarea>
		                    </div>
		                    <div class="xs-margin"></div>
		                    <input type="submit" id="submitNewMessage" class="btn btn-custom-5 btn-lg min-width" value="{l s='Submit Review' mod='productcomments'}">
		                </form>
		                {else}
		                	<h3>{l s='No customer reviews for the moment.' mod='productcomments'}</h3>	
		                {/if}			
					</div>					
			</div> <!-- #product_comments_block_tab -->
		</div>
	{/if}
	
	{strip}
	{addJsDef productcomments_controller_url=$productcomments_controller_url|@addcslashes:'\''}
	{addJsDef moderation_active=$moderation_active|boolval}
	{addJsDef productcomments_url_rewrite=$productcomments_url_rewriting_activated|boolval}
	{addJsDef secure_key=$secure_key}
	
	{addJsDefL name=confirm_report_message}{l s='Are you sure that you want to report this comment?' mod='productcomments' js=1}{/addJsDefL}
	{addJsDefL name=productcomment_added}{l s='Your comment has been added!' mod='productcomments' js=1}{/addJsDefL}
	{addJsDefL name=productcomment_added_moderation}{l s='Your comment has been added and will be available once approved by a moderator.' mod='productcomments' js=1}{/addJsDefL}
	{addJsDefL name=productcomment_title}{l s='New comment' mod='productcomments' js=1}{/addJsDefL}
	{addJsDefL name=productcomment_ok}{l s='OK' mod='productcomments' js=1}{/addJsDefL}
	{/strip}
{/if}

{*}
<!-- Fancybox -->
<div style="display: none;">
	<div id="new_comment_form">
		<form id="id_new_comment_form" action="#">
			<h2 class="page-subheading">{l s='Write a review' mod='productcomments'}</h2>
			<div class="row">
				{if isset($product) && $product}
					{if $product|is_array}
						<div class="product clearfix  col-xs-12 col-sm-6">
							<img src="{$productcomment_cover_image}" height="{$mediumSize.height}" width="{$mediumSize.width}" alt="{$product.name|escape:'html':'UTF-8'}" />
							<div class="product_desc">
								<p class="product_name">
									<strong>{$product.name}</strong>
								</p>
								{$product.description_short}
							</div>
						</div>					
					{else}
						<div class="product clearfix  col-xs-12 col-sm-6">
							<img src="{$productcomment_cover_image}" height="{$mediumSize.height}" width="{$mediumSize.width}" alt="{$product->name|escape:'html':'UTF-8'}" />
							<div class="product_desc">
								<p class="product_name">
									<strong>{$product->name}</strong>
								</p>
								{$product->description_short}
							</div>
						</div>
					{/if}
					
				{/if}
				<div class="new_comment_form_content col-xs-12 col-sm-6">
					<div id="new_comment_form_error" class="error" style="display: none; padding: 15px 25px">
						<ul></ul>
					</div>
					{if $criterions|@count > 0}
						<ul id="criterions_list">
						{foreach from=$criterions item='criterion'}
							<li>
								<label>Rate quality:</label>
								<div class="star_content">
									<input class="star" type="radio" name="criterion[{$criterion.id_product_comment_criterion|round}]" value="1" />
									<input class="star" type="radio" name="criterion[{$criterion.id_product_comment_criterion|round}]" value="2" />
									<input class="star" type="radio" name="criterion[{$criterion.id_product_comment_criterion|round}]" value="3" checked="checked" />
									<input class="star" type="radio" name="criterion[{$criterion.id_product_comment_criterion|round}]" value="4" />
									<input class="star" type="radio" name="criterion[{$criterion.id_product_comment_criterion|round}]" value="5" />
								</div>
								<div class="clearfix"></div>
							</li>
						{/foreach}
						</ul>
					{/if}
					<label for="comment_title">
						{l s='Title:' mod='productcomments'} <sup class="required">*</sup>
					</label>
					<input id="comment_title" name="title" type="text" value=""/>
					<label for="content">
						{l s='Comment:' mod='productcomments'} <sup class="required">*</sup>
					</label>
					<textarea id="content" name="content"></textarea>
					{if $allow_guests == true && !$is_logged}
						<label>
							{l s='Your name:' mod='productcomments'} <sup class="required">*</sup>
						</label>
						<input id="commentCustomerName" name="customer_name" type="text" value=""/>
					{/if}
					<div id="new_comment_form_footer">
						<input id="id_product_comment_send" name="id_product" type="hidden" value='{$id_product_comment_form}' />
						<p class="fl required"><sup>*</sup> {l s='Required fields' mod='productcomments'}</p>
						<p class="fr">
							<button id="submitNewMessage" name="submitMessage" type="submit" class="btn button button-small">
								<span>{l s='Submit' mod='productcomments'}</span>
							</button>&nbsp;
							{l s='or' mod='productcomments'}&nbsp;
							<a class="closefb" href="#">
								{l s='Cancel' mod='productcomments'}
							</a>
						</p>
						<div class="clearfix"></div>
					</div> <!-- #new_comment_form_footer -->
				</div>
			</div>
		</form><!-- /end new_comment_form_content -->
	</div>
</div>
{*}
<!-- End fancybox -->

