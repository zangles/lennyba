
    {if $testimonials|@count > 0}
    <!-- MODULE Block otutestimonial -->
    <div id="testimonial_block" class="col-sm-4 home-block clearfix">
        <h1 class="block-title">{$TESTIMONIAL_TITLE}</h1>
        <div class="block-content">
            <div id="block_testimonial_block_slide" class="effect-zoomOut">	
        		{foreach from=$testimonials item=info}
        			<div class="slide_item"> 
                        <div class="wrapper" >
                            <div class="content">
                                <p class="block_testimonial_content">"{$info.text|escape:html:'UTF-8'}"</p>
                                <hr />
                                <p class="block_testimonial_name">{$info.name|escape:html:'UTF-8'}&nbsp;&ndash;&nbsp;<span class="block_testimonial_company">{$info.company|escape:html:'UTF-8'}</span></p>
                            </div>
                        </div>
                    </div>
         		{/foreach} 
          	</div>
        </div>
    </div>
    <!-- /MODULE Block otutestimonial -->
    {/if}
