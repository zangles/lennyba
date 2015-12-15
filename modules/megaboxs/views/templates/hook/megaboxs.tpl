{if isset($megaboxs) && $megaboxs|@count >0}
    {foreach from=$megaboxs item=module name=modules}                       
        {$module.content}
    {/foreach}    
{/if}