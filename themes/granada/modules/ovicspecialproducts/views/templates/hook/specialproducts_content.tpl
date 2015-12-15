{assign var='option_tpl' value=OvicLayoutControl::getTemplateFile('specialproducts_content.tpl','ovicspecialproducts')}
{if  $option_tpl!== null}
    {include file=$option_tpl}
{else}


    {if isset($special_products) && $special_products}
    	{include file="$tpl_dir./product-list.tpl" products=$special_products class='specialproducts tab-pane' id='specialproducts'}
    {else}
    <ul id="specialproducts" class="specialproducts tab-pane">
    	<li class="alert alert-info">{l s='No special products at this time.' mod='ovicspecialproducts'}</li>
    </ul>
    {/if}

{/if}