{if isset($item) && !empty($item)}
<div class="col-sm-4 col-xs-12">
    <div id="blockhtml_{$hook_position}">
        {if isset($item.title) && $item.title|count_characters >0}
            <div class="block-title"><strong>{$item.title}</strong></div>
        {/if}
        {if isset($item.content)}
            {$item.content}
        {/if}
    </div>
</div>
{/if}