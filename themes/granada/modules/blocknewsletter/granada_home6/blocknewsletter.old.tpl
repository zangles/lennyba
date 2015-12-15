<div class="a-center sw_section parallax-section newsletter-block_dark newsletter-block_dark_demo7">
    <div id="newsletter_block_left" class="container s-newsletter">
    	<div class="block_content">
            <h3 class="newsletter-sub-title sub-title white-font">{l s='Times A Ticking' mod='blocknewsletter'}</h3>
            <h2 class="newletter-title white-font">{l s='Don\'t Miss Out' mod='blocknewsletter'}</h2>
            <div class="newsletter-desc secondary-font white-font">{l s='Sybscribe for the latest styles and sales, plus get 25% off your first order.' mod='blocknewsletter'}</div>
            <form action="{$link->getPageLink('index')|escape:'html':'UTF-8'}" method="post" class="newsletter-form">
              <div class="newsletter-wrapper white-newsletter form-group{if isset($msg) && $msg } {if $nw_error}form-error{else}form-ok{/if}{/if}">
                 <div class="input-box">
                    <input class="inputNew form-control newsletter-input input-text input-email" id="newsletter-input" type="text" name="email" size="18" placeholder="{l s='Enter your e-mail' mod='blocknewsletter'}" value="{if isset($msg) && $msg}{$msg}{elseif isset($value) && $value}{$value}{/if}" />
                 </div>
                 <div class="actions">
                    <button type="submit" name="submitNewsletter" class="button button-custom button-custom-active">
                        <span>{l s='Subscribe' mod='blocknewsletter'}</span>
                    </button>
                    <input type="hidden" name="action" value="0" />
                 </div>
              </div>
           </form>
    	</div>
    </div>
</div>