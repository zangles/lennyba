
{if $testimonials|@count > 0}
<h2>{$TESTIMONIAL_TITLE}</h2>
<div class="vcenter-container">
	<div class="vcenter bottom-nav">
		<div class="owl-carousel color2 testimonials-slider">
			{foreach from=$testimonials item=info}
			<div class="testimonial">
				<span class="quote-icon"></span>
				<p>{$info.text|escape:html:'UTF-8'}</p>
				<span class="testimonial-owner">{$info.name|escape:html:'UTF-8'}</span>
			</div>
		    {/foreach}         	
		</div>
	</div>
</div>
   {/if}
