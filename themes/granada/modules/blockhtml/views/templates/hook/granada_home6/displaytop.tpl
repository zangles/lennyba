{if isset($item) && !empty($item)}
{*}<div id="blockhtml_{$hook_position}" class="col-sm-4">{*}
    {if isset($item.title) && $item.title|count_characters >0}
        <div class="block-title"><strong>{$item.title}</strong></div>
    {/if}
    {if isset($item.content)}
        {*}<div class="block-content">{*}
        {$item.content}
        {*}</div>{*}
    {/if}
{*}</div>{*}
{/if}