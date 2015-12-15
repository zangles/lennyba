{assign var='option_tpl' value=OvicLayoutControl::getTemplateFile('flexbanner.tpl','flexbanner')}
{if  $option_tpl!== null}
    {include file=$option_tpl}
{else}
    {if isset($flexbanner_contents) && $flexbanner_contents|@count >0}
        <div class="flex-banners clearfix row">
        {foreach from=$flexbanner_contents item=banner name=banners}                       
            {$banner.html}
        {/foreach}
        </div>
    {/if}
{/if}