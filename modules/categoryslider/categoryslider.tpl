{if isset($categoryslider)}
<script type="text/javascript">
     var categoryslider_loop={$categoryslider.loop|intval};
     var categoryslider_width={$categoryslider.width|intval};
     var categoryslider_speed={$categoryslider.speed|intval};
     var categoryslider_pause={$categoryslider.pause|intval};
</script>
{/if}
{if isset($categoryslider_slides)}
<div id="responsive_slides">
    <div class="callbacks_container clearBoth">
      <ul id="categoryslider">
        {foreach from=$categoryslider_slides item=slide}
	       {if $slide.active}
                <li><img class="img-responsive" src="{$smarty.const._MODULE_DIR_}/categoryslider/images/{$slide.image|escape:'htmlall':'UTF-8'}" alt="{$slide.legend|escape:'htmlall':'UTF-8'}"  /></li>
           {/if}
        {/foreach}
      </ul>
    </div>
</div>
{/if}

