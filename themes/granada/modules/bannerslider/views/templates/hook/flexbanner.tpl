{if $banners && $banners|@count > 0}
    <div class="flex-banners clearfix row">
        {foreach from=$banners item=banner name=bannerLoop}
            <div class="banner-item col-sm-{$banner.width} {$banner.custom_class}">
                <a href="{$banner.link}" target="_blank" title="{$banner.alt}">
                	<img class="img-responsive" src="{$banner.image}" alt="{$banner.alt}" />
                </a>
                {if $banner.description}
                <div class="flex-banner-description">{$banner.description}</div>
                {/if}
            </div>               
        {/foreach}
    </div>
{/if}