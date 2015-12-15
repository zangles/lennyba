{*
*  @author Ovic-soft <nguyencaoson.zpt@gmail.com>
*  @copyright  2010-2015
*}
{assign var='left_column_size' value=0}{assign var='right_column_size' value=0}
{if isset($HOOK_LEFT_COLUMN) && $HOOK_LEFT_COLUMN|trim && !$hide_left_column}{$left_column_size=3}{/if}
{if isset($HOOK_RIGHT_COLUMN) && $HOOK_RIGHT_COLUMN|trim && !$hide_right_column}{$right_column_size=3}{/if}

{assign var='left_column' value=false}
{assign var='right_column' value=false}
{if isset($HOOK_LEFT_COLUMN) && $HOOK_LEFT_COLUMN|trim && !$hide_left_column}
	{$left_column=true}
{/if}
{if isset($HOOK_RIGHT_COLUMN) && $HOOK_RIGHT_COLUMN|trim && !$hide_right_column}
	{$right_column=true}
{/if}
<section id="content" role="main">    					
    {if isset($HOOK_HOME_TOP_COLUMN) && $HOOK_HOME_TOP_COLUMN|trim}
	      <div id="revslider-container">{$HOOK_HOME_TOP_COLUMN}</div>
    {/if}
	<div class="container">	
	    {if isset($HOME_TOP_CONTENT) && $HOME_TOP_CONTENT|trim}
	        {$HOME_TOP_CONTENT}
	    {/if}			   
	</div>
	<div class="xlg-margin"></div>	
	{if isset($HOOK_HOME) && $HOOK_HOME|trim}
    	{$HOOK_HOME}
    {/if}
    <div class="md-margin2x half hidden-xs"></div>
    <div class="lg-margin visible-xs"></div>    
</section><!-- .columns-container -->
