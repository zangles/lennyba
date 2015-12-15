{if isset($customparallax) }
<section id="{$customparallax.custom_class}" class="section full-height home-full-height parallax" style="background-image: url({$customparallax.parallax_image})" data-stellar-background-ratio="{$customparallax.parallax_ratio}">
	{$customparallax.content}	
</section>
{/if}
