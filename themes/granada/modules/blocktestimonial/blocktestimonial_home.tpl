{assign var='option_tpl' value=OvicLayoutControl::getTemplateFile('blocktestimonial_home.tpl','blocktestimonial')}
{if  $option_tpl!== null}
    {include file=$option_tpl}
{else}
    {if $testimonials|@count > 0}
	<h2 class="aaa">{$TESTIMONIAL_TITLE}</h2>
	<div class="vcenter-container">
		<div class="vcenter bottom-nav">
			<div class="owl-carousel testimonials-slider">
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
{/if}