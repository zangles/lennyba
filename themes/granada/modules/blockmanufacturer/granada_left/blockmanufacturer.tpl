<div class="widget side-menu-container">
	<h3>{l s='Brands' mod='blockmanufacturer'}</h3>
	<div class="side-menu">
		<ul>
			{foreach from=$manufacturers item=manufacturer name=manufacturer_list}
				{if $smarty.foreach.manufacturer_list.iteration <= $text_list_nb}
					<li><a href="{$link->getmanufacturerLink($manufacturer.id_manufacturer, $manufacturer.link_rewrite)|escape:'html':'UTF-8'}" title="{$manufacturer.name|escape:'html':'UTF-8'}">{$manufacturer.name|escape:'html':'UTF-8'}</a></li>
                {/if}
            {/foreach}           
      </ul>
   </div>
</div>