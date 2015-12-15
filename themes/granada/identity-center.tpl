{include file="$tpl_dir./errors.tpl"}
{if isset($confirmation) && $confirmation}
    <p class="alert alert-success">
        {l s='Your personal information has been successfully updated.'}
        {if isset($pwd_changed)}<br />{l s='Your password has been sent to your email:'} {$email}{/if}
    </p>
{else}    
    <form action="{$link->getPageLink('identity', true)|escape:'html':'UTF-8'}" method="post" class="std">
    	<div class="row">
    		<div class="col-sm-6 padding-right-md">
    			<h2 class="color2">YOUR PERSONAL DETAILS</h2>
    			<div class="form-group required">
                    <label for="id_country" class="form-label">{l s='Country'}</label>
                    <div class="large-selectbox clearfix">                       
                        <select id="id_country" name="id_country" class="selectbox">
                        	{foreach from=$genders key=k item=gender}
                        		<option value="{$gender->id|intval}">{$gender->name}</option>			                    
			                {/foreach}                                   
                        </select>
                    </div>
                </div>
	            <div class="required form-group">
	                <label for="firstname" class="form-label">
	                    {l s='First name'} 
	                    <sup>*</sup>
	                </label>
	                <input class="is_required validate form-control input-lg" data-validate="isName" type="text" id="firstname" name="firstname" value="{$smarty.post.firstname}" />
	            </div>
	            <div class="required form-group">
	                <label for="lastname" class="form-label">
	                    {l s='Last name'} 
	                    <sup>*</sup>
	                </label>
	                <input class="is_required validate form-control input-lg" data-validate="isName" type="text" name="lastname" id="lastname" value="{$smarty.post.lastname}" />
	            </div>
	            <div class="required form-group">
	                <label for="email" class="form-label">
	                    {l s='E-mail address'}
	                    <sup>*</sup> 
	                </label>
	                <input class="is_required validate form-control input-lg" data-validate="isEmail" type="email" name="email" id="email" value="{$smarty.post.email}" />
	            </div>
	            <div class="form-group">
	                <label class="form-label">
	                    {l s='Date of Birth'}
	                </label>
	                <div class="row">
	                    <div class="col-xs-4 large-selectbox">	                    	
	                        <select name="days" id="days" class="selectbox">
	                            <option value="">-</option>
	                            {foreach from=$days item=v}
	                                <option value="{$v}" {if ($sl_day == $v)}selected="selected"{/if}>{$v}&nbsp;&nbsp;</option>
	                            {/foreach}
	                        </select>

	                    </div>
	                    <div class="col-xs-4 large-selectbox">
	                        <select id="months" name="months" class="selectbox">
	                            <option value="">-</option>
	                            {foreach from=$months key=k item=v}
	                                <option value="{$k}" {if ($sl_month == $k)}selected="selected"{/if}>{l s=$v}&nbsp;</option>
	                            {/foreach}
	                        </select>
	                    </div>
	                    <div class="col-xs-4 large-selectbox">
	                        <select id="years" name="years" class="selectbox">
	                            <option value="">-</option>
	                            {foreach from=$years item=v}
	                                <option value="{$v}" {if ($sl_year == $v)}selected="selected"{/if}>{$v}&nbsp;&nbsp;</option>
	                            {/foreach}
	                        </select>
	                    </div>
	                </div>
	            </div>
	            {if $b2b_enable}
	            	<div class="xlg-margin"></div>
					<h2 class="color2">
						{l s='Your company information'}
					</h2>
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
				{/if}
    		</div>
            <div class="md-margin visible-xs clearfix"></div>
            <div class="col-sm-6 padding-left-md">
            	<h2 class="color2">YOUR PASWORD</h2>
            	<div class="required form-group">
	                <label for="old_passwd" class="form-label">
	                    {l s='Current Password'}
	                    <sup>*</sup> 
	                </label>
	                <input class="is_required validate form-control input-lg" type="password" data-validate="isPasswd" name="old_passwd" id="old_passwd" />
	            </div>
	            <div class="password form-group">
	                <label for="passwd" class="form-label">
	                    {l s='New Password'}
	                </label>
	                <input class="is_required validate form-control input-lg" type="password" data-validate="isPasswd" name="passwd" id="passwd" />
	            </div>
	            <div class="password form-group">
	                <label for="confirmation" class="form-label">
	                    {l s='Confirmation'}
	                </label>
	                <input class="is_required validate form-control" type="password" data-validate="isPasswd" name="confirmation" id="confirmation" />
	            </div>
	            {if $newsletter}	            	
	                <div>
	                    <label for="newsletter" class="form-label">
	                        <input type="checkbox" id="newsletter" name="newsletter" value="1" {if isset($smarty.post.newsletter) && $smarty.post.newsletter == 1} checked="checked"{/if}/>
	                        {l s='Sign up for our newsletter!'}
	                    </label>
	                </div>
	                <div>
	                    <label for="optin" class="form-label">
	                        <input type="checkbox" name="optin" id="optin" value="1" {if isset($smarty.post.optin) && $smarty.post.optin == 1} checked="checked"{/if}/>
	                        {l s='Receive special offers from our partners!'}
	                    </label>
	                </div>
	                
	                <p id="security_informations" class="text-right">
		                <i>{l s='[Insert customer data privacy clause here, if applicable]'}</i>
		            </p>
	            {/if}
            </div>
    	</div>    
    	<div class="md-margin clearfix"></div>
    	<div class="row">
        	<div class="form-group text-center">
                <button type="submit" name="submitIdentity" class="btn btn-custom btn-lg min-width-md button_111_hover">
                    <span>{l s='Update personal information'}<i class="icon-chevron-right right"></i></span>
                </button>
            </div>

    	</div>    
    </form> <!-- .std -->
{/if}
{*}
<div class="xs-margin"></div>
<div class="footer_links clearfix text-center">
	
        <a class="btn btn-default button button-small" href="{$link->getPageLink('my-account', true)}">
            <span>
                <i class="icon-chevron-left"></i>{l s='Back to your account'}
            </span>
        </a>
    
        <a class="btn btn-default button button-small" href="{$base_dir}">
            <span>
                <i class="icon-chevron-left"></i>{l s='Home'}
            </span>
        </a>
    
</div>
{*}
