{if isset($customparallax) }
<div class="lg-margin2x">&nbsp;</div>
<div id="newsletter-section" class="{$customparallax.custom_class} parallax" style="background-image: url({$customparallax.parallax_image})" data-stellar-background-ratio="{$customparallax.parallax_ratio}">
	{$customparallax.content}	
</div>
{/if}

