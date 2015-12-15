<ul class="social-links clearfix">
	{if $facebook_url != ''}
		<li class="facebook">
			<a class="ps-social-icon icon-facebook second_button_111_hover" target="_blank" href="{$facebook_url|escape:html:'UTF-8'}">
				<span>{l s='Facebook' mod='blocksocial'}</span>
			</a>
		</li>
	{/if}
	{if $twitter_url != ''}
		<li class="twitter">
			<a class="ps-social-icon icon-twitter second_button_111_hover" target="_blank" href="{$twitter_url|escape:html:'UTF-8'}">
				<span>{l s='Twitter' mod='blocksocial'}</span>
			</a>
		</li>
	{/if}
	{if $rss_url != ''}
		<li class="rss">
			<a class="ps-social-icon icon-rss second_button_111_hover" target="_blank" href="{$rss_url|escape:html:'UTF-8'}">
				<span>{l s='RSS' mod='blocksocial'}</span>
			</a>
		</li>
	{/if}
    {if $youtube_url != ''}
    	<li  class="youtube">
    		<a class="ps-social-icon icon-youtube second_button_111_hover" target="_blank"  href="{$youtube_url|escape:html:'UTF-8'}">
    			<span>{l s='Youtube' mod='blocksocial'}</span>
    		</a>
    	</li>
    {/if}
    {if $google_plus_url != ''}
    	<li class="google-plus">
    		<a class="ps-social-icon icon-google-plus second_button_111_hover" target="_blank" href="{$google_plus_url|escape:html:'UTF-8'}">
    			<span>{l s='Google Plus' mod='blocksocial'}</span>
    		</a>
    	</li>
    {/if}
    {if $pinterest_url != ''}
    	<li class="pinterest">
    		<a class="ps-social-icon icon-pinterest second_button_111_hover" target="_blank"  href="{$pinterest_url|escape:html:'UTF-8'}">
    			<span>{l s='Pinterest' mod='blocksocial'}</span>
    		</a>
    	</li>
    {/if}
    {if $vimeo_url != ''}
    	<li class="vimeo">
    		<a class="ps-social-icon icon-vimeo second_button_111_hover" target="_blank" href="{$vimeo_url|escape:html:'UTF-8'}">
    			<span>{l s='Vimeo' mod='blocksocial'}</span>
    		</a>
    	</li>
    {/if}
    {if $instagram_url != ''}
    	<li class="instagram">
    		<a class="ps-social-icon icon-instagram second_button_111_hover" target="_blank"  href="{$instagram_url|escape:html:'UTF-8'}">
    			<span>{l s='Instagram' mod='blocksocial'}</span>
    		</a>
    	</li>
    {/if}
</ul>

