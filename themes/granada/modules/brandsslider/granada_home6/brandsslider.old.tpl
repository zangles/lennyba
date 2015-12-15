<div class="centered-nav">
    <div id="brands_slider" class="container brands-slider-block">
        <h2 class="brands-title sub-title secondary-font">{l s='Our Brands' mod='brandsslider'}</h2>
        <div class="row">
            <div id="brand_list" class="brnads-slider " >
                {foreach from=$manufacturers item=manufacturer name=manufacturer_list}
                    <div class="item">
                        <a href="{$link->getmanufacturerLink($manufacturer.id_manufacturer, $manufacturer.link_rewrite)|escape:'html'}">
                            <img src="{$img_manu_dir}{$manufacturer.image}" alt="{$manufacturer.name}"/></a>
                    </div>
                {/foreach}
            </div>
        </div>
    </div>
</div>