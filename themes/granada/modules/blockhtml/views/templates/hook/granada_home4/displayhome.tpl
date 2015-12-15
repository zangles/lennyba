{if isset($item) && !empty($item)}
<div class="a-center sw_section parallax-section funs-block">
    <div id="blockhtml_{$hook_position}" class="container">
        {if isset($item.title) && $item.title|count_characters >0}
            <div class="block-title"><strong>{$item.title}</strong></div>
        {/if}
        {if isset($item.content)}
            {$item.content}
        {/if}
    </div>
</div>
{/if}
