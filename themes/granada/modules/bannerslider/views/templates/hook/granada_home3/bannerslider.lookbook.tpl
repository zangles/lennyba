<section id="lookbook-section" class="section" >
	{$moduleDescription} 
	{if $bannerslider_items && $bannerslider_items|@count >0}
        <ul class="lookbook-bxslider">
            {foreach from=$bannerslider_items item=slide name=bannerslider_items}
            <li><img src="{$slide.image}" alt="{$slide.alt}" /></li>           
            {/foreach}
        </ul>
        <script type="text/javascript">
		// &lt;![CDATA[
		$(window).bind('load', function(){
			
			var slider = $('.lookbook-bxslider').bxSlider({
				nextSelector: '#lookbook-next',
				prevSelector: '#lookbook-prev',
				nextText: 'Next Slide',
				prevText: 'Previous Slide',
				mode:'fade',
				pager: false
			});
			$('#lookbook-next').click(function(){
		      slider.goToNextSlide();
		      return true;
		    });
		
		    $('#lookbook-prev').click(function(){
		      slider.goToPrevSlide();
		      return true;
		    });
		});
		
		// ]]&gt;
		</script>
	{/if}
	<div class="section-btn-container"><a href="#products-section" class="section-btn btn-prev light" title="Previous Section">Previous Section</a> <a href="#blog-section" class="section-btn btn-next light" title="Next Section">Next Section</a></div>
</section>

