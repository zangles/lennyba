
<div class="widget tagclog-widget">
   <h3>{l s='TagCloud' mod='smartblogtag'}</h3>   
   <div class="tagcloud">
   	{if $tags}
		{foreach from=$tags item=tag name=myLoop}
			{assign var="options" value=null}
			{$options.tag = $tag.name}
			<a href="{smartblog::GetSmartBlogLink('smartblog_tag',$options)}">{$tag.name}</a>
		{/foreach}
	{else}
		{l s='No tags specified yet' mod='smartblogtag'}
	{/if}
	</div>
</div>
