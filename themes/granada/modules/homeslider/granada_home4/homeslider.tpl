{if $page_name =='index'}
<!-- Module HomeSlider -->
    {if isset($homeslider_slides)}
		<div id="homepage-slider" class="full-screen-slider clearfix">
            <div class="owl-theme owl-middle-narrow owl-banner-carousel">
			{if isset($homeslider_slides.0) && isset($homeslider_slides.0.sizes.1)}{capture name='height'}{$homeslider_slides.0.sizes.1}{/capture}{/if}
			<ul id="homeslider"{if isset($smarty.capture.height) && $smarty.capture.height} style="max-height:{$smarty.capture.height}px;"{/if}>
				{foreach from=$homeslider_slides item=slide}
					{if $slide.active}
						<li class="homeslider-container">
							<a href="{$slide.url|escape:'html':'UTF-8'}" title="{$slide.legend|escape:'html':'UTF-8'}">
								<img src="{$link->getMediaLink("`$smarty.const._MODULE_DIR_`homeslider/images/`$slide.image|escape:'htmlall':'UTF-8'`")}"{if isset($slide.size) && $slide.size} {$slide.size}{else} width="100%" height="100%"{/if} alt="{$slide.legend|escape:'htmlall':'UTF-8'}" />
							</a>
							{if isset($slide.description) && trim($slide.description) != ''}
								<div class="homeslider-description">{$slide.description}</div>
							{/if}
						</li>
					{/if}
				{/foreach}
			</ul>
            </div>
		</div>
	{/if}
<!-- /Module HomeSlider -->
{/if}