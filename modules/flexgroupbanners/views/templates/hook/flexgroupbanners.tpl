{if isset($flexgroupbanners_modules) && $flexgroupbanners_modules|@count >0}
    {foreach from=$flexgroupbanners_modules item=flexgroupbanners_module name=modules}                       
        {$flexgroupbanners_module.moduleContents}
    {/foreach}    
{/if}