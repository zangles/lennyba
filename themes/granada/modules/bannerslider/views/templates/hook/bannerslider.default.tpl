{assign var='option_tpl' value=OvicLayoutControl::getTemplateFile('bannerslider.default.tpl','bannerslider')}
{if  $option_tpl!== null}
    {include file=$option_tpl}
{else}
<div class="{$custom_class}">
	<div class="sw_section sw_section_full gray-button-container">
        {$moduleDescription}  
        
        {if $bannerslider_items && $bannerslider_items|@count >0}
        <div class="full-bg-slider-1 full-screen-slider">
            {foreach from=$bannerslider_items item=slide name=bannerslider_items}
            <div class="item">
				<div style="width: 100%; height: 100%; background: url('{$slide.full_image}') center center no-repeat; background-size: cover;">&nbsp;</div>
			</div>
            {/foreach}
        </div>
        <script type="text/javascript">
		// &lt;![CDATA[
		  jQuery(document).ready(function(){
				var fullbgslider1 = jQuery('.full-bg-slider-1').owlCarousel({
                        loop:true,
                        autoplay:true,
                        margin:0,
                        nav:false,
                        mouseDrag:true,
                        animateOut:"fadeOut",
                        responsiveClass:true,
                        responsive:{
                            0:{
                                items:1
                            }
                        }
								
				   });
                	jQuery('.arrival-block .button-prev').click(function(){
                	   fullbgslider1.trigger('prev.owl.carousel')
                	});
                	jQuery('.arrival-block .button-next').click(function(){
                	   fullbgslider1.trigger('next.owl.carousel')                    		
                	});            
				});
		// ]]&gt;
		</script>
        {/if}
        		
	</div>
</div>
{/if}