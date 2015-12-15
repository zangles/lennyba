{if isset($customparallax_modules) && $customparallax_modules|@count >0}
    {foreach from=$customparallax_modules item=module name=modules}                       
        {$module}
    {/foreach}    
{/if}