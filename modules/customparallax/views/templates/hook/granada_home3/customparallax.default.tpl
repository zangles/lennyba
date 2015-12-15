{if isset($customparallax) }
<div class="xlg-margin3x hidden-sm hidden-xs"></div>
<div class="xlg-margin2x visible-sm"></div>
<div class="xlg-margin visible-xs"></div>
<div class="{$customparallax.custom_class} parallax" style="background-image: url({$customparallax.parallax_image})" data-stellar-background-ratio="{$customparallax.parallax_ratio}">
	{$customparallax.content}	
</div>
{/if}
