{if $banners && $banners|@count > 0}
    {foreach from=$banners item=banner name=banners}
        <div class="banner-item {if $banner.width >0} col-sm-{$banner.width} {/if} {$banner.custom_class}">
            {if $banner.image}
            <a href="{$banner.link}" target="_blank" title="{$banner.alt}">
            	<img class="img-responsive" src="{$banner.image}" alt="{$banner.alt}" />
            </a>
            {/if}
            {if $banner.description}
            <div class="flex-banner-description">{$banner.description}</div>
            {/if}
        </div>               
    {/foreach}
{/if}