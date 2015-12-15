{*
*  @author Ovic-soft <nguyencaoson.zpt@gmail.com>
*  @copyright  2010-2015
*}
{assign var='option_tpl' value=OvicLayoutControl::getTemplateFile('index.tpl')}
{if  $option_tpl!== null}
    {include file=$option_tpl}
{else}
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
		<div id="columns" class="container">
	        {if isset($HOOK_HOME_TOP_COLUMN) && $HOOK_HOME_TOP_COLUMN|trim}
			      <div id="home_top_column" class="home_top_column">{$HOOK_HOME_TOP_COLUMN}</div>
	        {/if}			
			<div class="row">
				<div class="col-md-9 col-md-push-3 col-sm-12">
				    {if isset($HOME_TOP_CONTENT) && $HOME_TOP_CONTENT|trim}
				        {$HOME_TOP_CONTENT}
				    {/if}			   
				    {if isset($HOOK_HOME) && $HOOK_HOME|trim}
				    	<div class="lg-margin hidden-xs"></div>
				    	<div class="xs-margin visible-xs"></div>
				    	{$HOOK_HOME}
				    {/if}				    
			    </div><!-- #center_column -->
			    <aside class="col-md-3 col-md-pull-9 col-sm-12 sidebar home-sidebar dark" role="complementary">{$HOOK_LEFT_COLUMN}</aside>			    
			</div>				
		</div><!-- #columns -->
		
	</section><!-- .columns-container -->

{/if}
