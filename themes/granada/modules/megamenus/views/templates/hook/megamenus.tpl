{if isset($megamenus) && $megamenus|@count >0}
    {foreach from=$megamenus item=module name=modules}                       
        {$module.content}
    {/foreach}    
{/if}