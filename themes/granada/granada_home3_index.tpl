{*
*  @author Ovic-soft <nguyencaoson.zpt@gmail.com>
*  @copyright  2010-2015
*}
{if isset($HOOK_HOME_TOP_COLUMN) && $HOOK_HOME_TOP_COLUMN|trim}
      {$HOOK_HOME_TOP_COLUMN}
{/if}
{if isset($HOME_TOP_CONTENT) && $HOME_TOP_CONTENT|trim}
    {$HOME_TOP_CONTENT}
{/if}
<section id="blog-section" class="section">
	{if isset($HOOK_HOME) && $HOOK_HOME|trim}
		{$HOOK_HOME}
	{/if}
	<div class="section-btn-container"><a href="#lookbook-section" class="section-btn btn-prev" title="{l s='Previous Section'}">{l s='Previous Section'}</a> <a href="#trend-section" class="section-btn btn-next" title="{l s='Next Section'}">{l s='Next Section'}</a></div>
</section>
{if isset($HOME_BOTTOM_CONTENT) && $HOME_BOTTOM_CONTENT|trim}
	{$HOME_BOTTOM_CONTENT}
{/if}