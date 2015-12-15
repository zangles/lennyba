{if isset($customcontent_modules) && $customcontent_modules|@count >0}
    {foreach from=$customcontent_modules item=module name=modules}                       
        {$module.content}
    {/foreach}    
{/if}