{assign var='option_tpl' value=OvicLayoutControl::getTemplateFile('flexbanner.granadahome5.tpl','flexbanner')}
{if  $option_tpl!== null}
    {include file=$option_tpl}
{else}
    {if $banner}
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
    {/if}
{/if}