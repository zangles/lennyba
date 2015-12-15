<!-- Block user information module NAV  -->
{assign var='option_tpl' value=OvicLayoutControl::getTemplateFile('nav.tpl','blockuserinfo')}
{if  $option_tpl!== null}
    {include file=$option_tpl}
{else}
    <div id="header_user_info" class="top-bar-left">
        <ul class="links hidden-sm hidden-xs">
            <li class="myaccount-link"><a href="{$link->getPageLink('my-account', true)|escape:'html':'UTF-8'}" title="{l s='View my customer account' mod='blockuserinfo'}" class="account" rel="nofollow">{l s='My account' mod='blockuserinfo'}</a></li>
            <li class="checkout-link"><a href="{$link->getPageLink('order', true)|escape:'html':'UTF-8'}" title="{l s='Checkout' mod='blockuserinfo'}">{l s='Checkout' mod='blockuserinfo'}</a></li>
            <li class="mywishlist-link"><a href="{$link->getModuleLink('blockwishlist', 'mywishlist', array(), true)|escape:'html':'UTF-8'}"  rel="nofollow" title="{l s='My wishlists' mod='blockuserinfo'}">{l s='My wishlists' mod='blockuserinfo'}</a></li>
        </ul>
        <div class="dropdown top-bar-account top-bar-item hidden-md hidden-lg">
            <a href="{$link->getPageLink('my-account', true)|escape:'html':'UTF-8'}" title="{l s='View my customer account' mod='blockuserinfo'}" class="btn-top-account dropdown-toggle">
                My Account<span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <li class="myaccount-link"><a href="{$link->getPageLink('my-account', true)|escape:'html':'UTF-8'}" title="{l s='View my customer account' mod='blockuserinfo'}" class="account" rel="nofollow">{l s='My account' mod='blockuserinfo'}</a></li>
                <li class="checkout-link"><a href="{$link->getPageLink('order', true)|escape:'html':'UTF-8'}" title="{l s='Checkout' mod='blockuserinfo'}">{l s='Checkout' mod='blockuserinfo'}</a></li>
                <li class="mywishlist-link"><a href="{$link->getModuleLink('blockwishlist', 'mywishlist', array(), true)|escape:'html':'UTF-8'}"  rel="nofollow" title="{l s='My wishlists' mod='blockuserinfo'}">{l s='My wishlists' mod='blockuserinfo'}</a></li>
            </ul>
            <script type="text/javascript">
                (function($){
                    $('.top-bar-account > a').click(function(event){
                       event.preventDefault();
                    });
                    $('.top-bar-account').hover(function(){
                       $(this).addClass('open');
                    },
                    function(){
                       $(this).removeClass('open');
                    });
                })(jQuery);
            </script>
        </div>
    </div>
    {*}
    <div class="header_user_info">
            {if $is_logged}
            		<a href="{$link->getPageLink('my-account', true)|escape:'html':'UTF-8'}" title="{l s='View my customer account' mod='blockuserinfo'}" class="account" rel="nofollow">{l s='My account' mod='blockuserinfo'}</a>
                    <a href="{$link->getPageLink('index', true, NULL, "mylogout")|escape:'html'}" title="{l s='Sign out' mod='blockuserinfo'}">{l s='Sign out' mod='blockuserinfo'}</a>
            {else}
                    <a class="login" href="{$link->getPageLink('my-account', true)|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='Log in to your customer account' mod='blockuserinfo'}">
                        {l s='Login' mod='blockuserinfo'}
            	    </a>
            {/if}
    </div>
    {*}
{/if}
<!-- /Block usmodule NAV -->
