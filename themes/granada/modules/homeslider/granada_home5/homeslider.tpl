{if $page_name =='index'}
<!-- Module HomeSlider -->
    {if isset($homeslider_slides)}
    <div id="homepage-slider">
        <div class="homepage-slider">
            <div id="homepage-slider-6" class="homepage-slider-6 owl-theme gray-dark-font white-btn-container">
			{if isset($homeslider_slides.0) && isset($homeslider_slides.0.sizes.1)}{capture name='height'}{$homeslider_slides.0.sizes.1}{/capture}{/if}
			<ul id="homeslider"{if isset($smarty.capture.height) && $smarty.capture.height} style="max-height:{$smarty.capture.height}px;"{/if}>
				{foreach from=$homeslider_slides item=slide}
					{if $slide.active}
						<li class="item">
                            <div class="item-bg">
                                <img src="{$link->getMediaLink("`$smarty.const._MODULE_DIR_`homeslider/images/`$slide.image|escape:'htmlall':'UTF-8'`")}"{if isset($slide.size) && $slide.size} {$slide.size}{else} width="100%" height="100%"{/if} alt="{$slide.legend|escape:'htmlall':'UTF-8'}" />
                            </div>
							{if isset($slide.description) && trim($slide.description) != ''}
								{$slide.description}
							{/if}
						</li>
					{/if}
				{/foreach}
			</ul>
            </div>
		</div>
    </div>
    <div class="clearBoth" style="height:0;"></div>
	{/if}
<!-- /Module HomeSlider -->
{/if}