{if isset($customhtml_modules) && $customhtml_modules|@count >0}
    {foreach from=$customhtml_modules item=module name=modules}                       
        {$module}
    {/foreach}    
{/if}