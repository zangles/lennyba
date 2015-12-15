	{if isset($customparallax) }
	<div class="md-margin2x half hidden-xs"></div>
	<div class="xs-margin visible-xs"></div>
	<div class="{$customparallax.custom_class} parallax" style="background-image: url({$customparallax.parallax_image})" data-stellar-background-ratio="{$customparallax.parallax_ratio}">
		{$customparallax.content}	
	</div>
	{/if}
