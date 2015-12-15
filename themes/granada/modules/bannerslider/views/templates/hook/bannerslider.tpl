{if isset($bannerslider_contents) && $bannerslider_contents|@count >0}
    {foreach from=$bannerslider_contents item=module name=modules}                       
        {$module.module_contents}
    {/foreach}    
{/if}
