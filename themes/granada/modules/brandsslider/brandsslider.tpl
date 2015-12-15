{if $manufacturers}
<!-- Brands slider module -->
    {assign var='option_tpl' value=OvicLayoutControl::getTemplateFile('brandsslider.tpl','brandsslider')}
    {if  $option_tpl!== null}
        {include file=$option_tpl}
    {else}
        <div id="brands_slider" class="container brands-slider-block">
            <h2 class="brands-title sub-title secondary-font">{l s='Our Brands' mod='brandsslider'}</h2>
            <div id="brand_list" class="brnads-slider " >
                {foreach from=$manufacturers item=manufacturer name=manufacturer_list}
                    <div class="item">
                        <a href="{$link->getmanufacturerLink($manufacturer.id_manufacturer, $manufacturer.link_rewrite)|escape:'html'}">
                            <img src="{$img_manu_dir}{$manufacturer.image}" alt="{$manufacturer.name}"/></a>
                    </div>
                {/foreach}
            </div>
        </div>
    {/if}
<!-- /Brands slider module -->
{/if}