{*
*  @author Ovic-soft <nguyencaoson.zpt@gmail.com>
*  @copyright  2010-2015
*}
<section id="content" role="main">    					
    {if isset($HOOK_HOME_TOP_COLUMN) && $HOOK_HOME_TOP_COLUMN|trim}
	      <div class="row">{$HOOK_HOME_TOP_COLUMN}</div>
    {/if}
</section>
<section>
		
    {if isset($HOME_TOP_CONTENT) && $HOME_TOP_CONTENT|trim}
        {$HOME_TOP_CONTENT}
    {/if}			   
		
	{if isset($HOOK_HOME) && $HOOK_HOME|trim}
    	{$HOOK_HOME}
    {/if}
    {if isset($HOME_BOTTOM_CONTENT) && $HOME_BOTTOM_CONTENT|trim}
		{$HOME_BOTTOM_CONTENT}
	{/if}
    <div class="md-margin2x half hidden-xs"></div>
    <div class="lg-margin visible-xs"></div>    
</section><!-- .columns-container -->
