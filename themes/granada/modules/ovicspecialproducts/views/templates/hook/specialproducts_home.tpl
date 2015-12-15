{assign var='option_tpl' value=OvicLayoutControl::getTemplateFile('specialproducts_home.tpl','ovicspecialproducts')}
{if  $option_tpl!== null}
    {include file=$option_tpl}
{else}

    <div id="sale_product_home">
        <h3>{l s='special products' mod='ovicspecialproducts'}</h3>
        <div class="product-content">
            {if isset($special_products) && $special_products}
            	{include file="$tpl_dir./product-list.tpl" products=$special_products class='specialproducts tab-pane' id='specialproducts'}
            {else}
            <ul id="specialproducts" class="specialproducts tab-pane">
            	<li class="alert alert-info">{l s='No special products at this time.' mod='ovicspecialproducts'}</li>
            </ul>
        </div>
    </div>
    {/if}

{/if}