{if $page_name == 'product'}
    {if $prevProduct != NULL OR $nextProduct != NULL}
        <div class="prev-next-products">                   
            {if $prevProduct != NULL}
                <div class="product-nav product-prev">
                    <a href="{$prevProduct.link}" id="prev_product" class="product-prev" title="{l s='Prev product' mod='productlinksdr'}"></a>
                    <div class="product-pop theme-border-color">
                        <img class="product-image" src="{$link->getImageLink($prevProduct.link_rewrite, $prevProduct.id_image, 'home_default')|escape:'html':'UTF-8'}" alt="Previous"/>
                        <h3 class="product-name">{$prevProduct.name|truncate:32:''|escape:'html':'UTF-8'}</h3>
                    </div>
                </div>
            {/if}
            {if $nextProduct != NULL}
                <div class="product-nav product-next">
                    <a class="product-next" href="{$nextProduct.link}" id="next_product" title="{l s='Next product' mod='productlinksdr'}"></a>
                    <div class="product-pop theme-border-color">
                        <img class="product-image" src="{$link->getImageLink($nextProduct.link_rewrite, $nextProduct.id_image, 'home_default')|escape:'html':'UTF-8'}" alt="Previous"/>
                        <h3 class="product-name">{$nextProduct.name|truncate:32:''|escape:'html':'UTF-8'}</h3>
                    </div>
                </div>
            {/if}
        </div>
    {/if}
{/if}