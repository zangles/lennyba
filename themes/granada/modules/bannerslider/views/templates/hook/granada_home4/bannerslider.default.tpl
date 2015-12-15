<div class="xlg-margin2x hidden-xs"></div>
<div class="lg-margin visible-xs"></div>
<div id="arrivals-section" class="section dark full-height">
	{$moduleDescription} 
	{if $bannerslider_items && $bannerslider_items|@count >0}
        <ul class="arrivals-bxslider">
            {foreach from=$bannerslider_items item=slide name=bannerslider_items}
            <li>
            	<div class="slide-content">
            		<img src="{$slide.image}" alt="{$slide.alt}" />	
            	</div>            	
            </li>
            {/foreach}
        </ul>
        
        <script type="text/javascript">
		// &lt;![CDATA[
		$(window).bind('load', function(){			
			var slider = $('.arrivals-bxslider').bxSlider({
				nextSelector: '#arrivals-next',
				prevSelector: '#arrivals-prev',
				nextText: 'Next Slide',
				prevText: 'Previous Slide',
				mode:'fade',
				pager: false
			});
			$('#arrivals-next').click(function(){
		      slider.goToNextSlide();
		      return true;
		    });
		
		    $('#arrivals-prev').click(function(){
		      slider.goToPrevSlide();
		      return true;
		    });
		});
		
		// ]]&gt;
		</script>
	{/if}
	
</div>

