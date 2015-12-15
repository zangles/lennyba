{assign var='option_tpl' value=OvicLayoutControl::getTemplateFile('customparallax.default.tpl','customparallax')}
{if  $option_tpl!== null}
    {include file=$option_tpl}
{else}	
	{if isset($customparallax) }
	<div class="lg-margin3x xs-margin2x"></div>
	<div class="{$customparallax.custom_class} parallax" style="background-image: url({$customparallax.parallax_image})" data-stellar-background-ratio="{$customparallax.parallax_ratio}">
		{$customparallax.content}	
	</div>
	{/if}
{/if}
