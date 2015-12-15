<div id="center_column" class="center_column">
	{include file="$tpl_dir./errors.tpl"}

	{if isset($confirmation) && $confirmation == 1}
	<p class="alert alert-success">{l s='Your password has been successfully reset and a confirmation has been sent to your email address:'} {if isset($customer_email)}{$customer_email|escape:'html':'UTF-8'|stripslashes}{/if}</p>
	{elseif isset($confirmation) && $confirmation == 2}
	<p class="alert alert-success">{l s='A confirmation email has been sent to your address:'} {if isset($customer_email)}{$customer_email|escape:'html':'UTF-8'|stripslashes}{/if}</p>
	{else}
	<p>{l s='Please enter the email address you used to register. We will then send you a new password. '}</p>
	<form action="{$request_uri|escape:'html':'UTF-8'}" method="post" class="std" id="form_forgotpassword">
		<fieldset>
			<div class="form-group">
				<label class="form-label" for="email">{l s='Email address'}</label>
				<input class="form-control input-lg" type="text" id="email" name="email" value="{if isset($smarty.post.email)}{$smarty.post.email|escape:'html':'UTF-8'|stripslashes}{/if}" />
			</div>
			<p class="submit">
				<button type="submit" class="btn btn-lg btn-custom-5"><span>{l s='Retrieve Password'}<i class="icon-chevron-right right"></i></span></button>
				
				<a class="btn btn-lg btn-custom-5" href="{$link->getPageLink('authentication')|escape:'html':'UTF-8'}" title="{l s='Back to Login'}" rel="nofollow"><span><i class="icon-chevron-left"></i>{l s='Back to Login'}</span></a>
				
			</p>
		</fieldset>
	</form>
	{/if}
	{*}
	<ul class="clearfix footer_links">
		<li><a class="btn btn-default button button-small" href="{$link->getPageLink('authentication')|escape:'html':'UTF-8'}" title="{l s='Back to Login'}" rel="nofollow"><span><i class="icon-chevron-left"></i>{l s='Back to Login'}</span></a></li>
	</ul>
	{*}
</div>