{if $banner}
    <div class="banner-col banner-col-3-1 hidden-sm {$banner.custom_class}">
        {if $banner.image}
            <a class="banner-row-link" title="{$banner.alt}" href="{$banner.link}">
                <img alt="{$banner.alt}" src="{$banner.image}" />
            </a>
        {/if}
        {if $banner.description}
            <div class="flex-banner-description">{$banner.description}</div>
        {/if}
    </div>
{/if}