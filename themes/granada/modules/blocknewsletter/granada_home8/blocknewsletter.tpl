<div class="banner-row-content newsletter-banner-content newsletter-content light text-center">
   <h3>{l s='TIMES A TICKING' mod='blocknewsletter'}</h3>
   <h2>{l s='DON\'T MISS OUT' mod='blocknewsletter'}</h2>
   <p>{l s='Subscribe for the latest styles and sales, plus get 25% off your first order.' mod='blocknewsletter'}</p>
   
	<form id="newsletter" action="{$link->getPageLink('index', null, null, null, false, null, true)|escape:'html':'UTF-8'}" method="post">
		<div class="form-group{if isset($msg) && $msg } {if $nw_error}form-error{else}form-ok{/if}{/if}" >	</div>
		<div class="input-group input-group-lg">
			<input type="email" name="email" required class="form-control" value="" placeholder="{l s='Enter Email Address' mod='blocknewsletter'}"> 
			<span class="input-group-btn">
				<button class="btn btn-custom-3" name="submitNewsletter" type="submit">{l s='SIGN UP!' mod='blocknewsletter'}</button>
			</span>
		</div>
		<input type="hidden" name="action" value="0" />
	</form>			
      	
   
</div>
