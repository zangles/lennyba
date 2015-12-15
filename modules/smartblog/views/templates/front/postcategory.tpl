
{capture name=path}
	<li><a href="{$base_dir}">{l s='Home' mod='smartblog'}</a></li>
	<li><a href="{smartblog::GetSmartBlogLink('smartblog')}">{l s='All Blog News' mod='smartblog'}</a></li>	
    {if $title_category != ''}
    	<li class="active">{$title_category}</li>
    {/if}
{/capture}
    
    
{assign var='left_column' value=false}
{assign var='right_column' value=false}

{if isset($HOOK_LEFT_COLUMN) && $HOOK_LEFT_COLUMN|trim && !$hide_left_column}
	{$left_column=true}
{/if}
{if isset($HOOK_RIGHT_COLUMN) && $HOOK_RIGHT_COLUMN|trim && !$hide_right_column}
	{$right_column=true}
{/if}

<section id="content" role="main">
	{include file="$tpl_dir./breadcrumb.tpl"}
	<div class="xs-margin"></div>
	<div class="container">
		<div class="row">
			{if $left_column == true}
				{if $right_column == true}
					<aside class="col-md-3 sidebar margin-top-up" role="complementary">
						{include file="./postcategory-left.tpl"}	
					</aside>
					<div class="col-md-6 padding-both-larger" id="center_column">
						{include file="./postcategory-center.tpl"}
					</div>					
					<aside class="col-md-3 sidebar margin-top-up">
						{include file="./postcategory-right.tpl"}
					</aside>
				{else}
					<div class="col-md-9 col-md-push-3 col-sm-8 col-sm-push-4 padding-left-larger">
						{include file="./postcategory-center.tpl"}
					</div>
					<aside class="col-md-3 col-md-pull-9 col-sm-4 col-sm-pull-8 sidebar margin-top-up" role="complementary">
						{include file="./postcategory-left.tpl"}
					</aside>
				{/if}
			{else}
				{if $right_column == true}
					<div class="col-md-9 col-sm-8 padding-right-lg" id="center_column">
						{include file="./postcategory-center.tpl"}
					</div>
					<aside class="col-md-3 col-sm-4 sidebar margin-top-up" role="complementary">
						{include file="./postcategory-right.tpl"}
					</aside>
				{else}
					<div class="col-xs-12 articles-container" id="center_column">
						{include file="./postcategory-center.tpl"}
					</div>					
				{/if}
			{/if}					
		</div>
	</div>	
	<div class="lg-margin2x"></div>
</section>
 
    