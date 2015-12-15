{if isset($pagelink_modules) && $pagelink_modules|@count >0}
    {foreach from=$pagelink_modules item=pagelink_module name=modules}                       
        {$pagelink_module.moduleContents}
    {/foreach}    
{/if}