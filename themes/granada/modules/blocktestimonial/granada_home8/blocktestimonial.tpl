{if $testimonials|@count > 0}
<div class="banner-row-content testimonial-banner-content left light text-center bottom-nav light-nav">
	<h2 class="h1 text-uppercase">{$TESTIMONIAL_TITLE}</h2>
	<div class="owl-carousel testimonials-slider">
		{foreach from=$testimonials item=info}
		<div class="testimonial">
			<span class="quote-icon light"></span>
			<p>{$info.text|escape:html:'UTF-8'}</p>
			<span class="testimonial-owner">{$info.name|escape:html:'UTF-8'}</span>
		</div>
	    {/foreach}         	
	</div>		
</div>
{/if}
