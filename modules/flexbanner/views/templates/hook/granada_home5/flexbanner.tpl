{if isset($flexbanner_contents) && $flexbanner_contents|@count >0}
    {foreach from=$flexbanner_contents item=banner name=banners}                       
        {$banner.html}
    {/foreach}
{/if}