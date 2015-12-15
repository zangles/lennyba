{assign var='option_tpl' value=OvicLayoutControl::getTemplateFile('home5.tpl','ovicparallaxblock')}
{if  $option_tpl!== null}
    {include file=$option_tpl}
{else}
    <div class="parallax-section" style="background-image: url({$full_path})" data-parallax-speed="{$ratio}" data-parallax-firsttop="{$firsttop}">
        {$content}
    </div>
{/if}